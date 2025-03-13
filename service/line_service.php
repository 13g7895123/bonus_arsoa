<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Line_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(
            array(
                'Line_message_log',
                'Line_user'
            )
        );

        $this->load->service(
            array(
                'api_line_service'
            )
        );
    }
    
     // line 抓使用者資料
    public function get_profile_by_id_token($auth,$line_client_id,$cookies)
    {
        // 此方法可拿到 email
        $api_url = 'https://api.line.me/oauth2/v2.1/verify';
        $update = array();
        
        $post = array(
            'id_token' => $auth['id_token'],
            'client_id' => $line_client_id
        );
        $result = curl_post_header_form($api_url, http_build_query($post));
        
        if (!empty($result['error'])) {
            // 抓個資有問題
            $insert_data = array(
                'error_message' => json_encode($result),
                'crdt'      => date('Y-m-d H:i:s'),
                'cookies'   => $cookies,
                'type'      => 'line_profile'
            );
            $this->db->insert('line_login_error', $insert_data);
            
            redirect(base_url('member/login'));
        } else {
            $user_id      = $result['sub'];
            
            $login_url = base_url('member/login');
            $rddata = $this->Member_login_record->find_one($result['nonce']);
            if ($rddata){
            	  if ($rddata['rdurl'] > ''){
            	      $login_url .= '?rdurl='.$rddata['rdurl'];
            	  }
            }
            
            $line_user_data = $this->get_line_user($user_id,'',true);   // 資料存入 line_user            
            $line_id_data = $this->Member_line_model->find_one('user_id',$user_id);
            
            if ($line_id_data)
            {
            	  return $line_id_data['c_no'];            	   
            }else{
            	  $this->session->set_userdata('line_user_id', $user_id );
            	  $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );            	  
            	  redirect($login_url);            	  
            	  exit;
            }            
        }        
    }
    
    public function quota()
    {
         $this->load->service( 'api_line_service' );   
         return $this->api_line_service->quota();
    }
    
    public function consumption()
    {
         $this->load->service( 'api_line_service' );   
         return $this->api_line_service->consumption();
    }

    // Line USER 資料 - 更新、取得
    public function get_line_user($line_user_id,$db = 'default', $always_from_line = false)
    {
        $line_user_data = $this->Line_user->find_one($line_user_id,$db);
       
        # ## 查無資料 / 資料過期 => 呼叫line api取得user data
        if(empty($line_user_data) || (isset($line_user_data['profile_exdate']) && strtotime($line_user_data['profile_exdate']) < time()) || $always_from_line)
        {
            // 透過 Line API 取得 Line USER 資料
            $get_line_user_data = $this->api_line_service->get_profile($line_user_id);      
            
            $change_data        = array(
                'user_id'           => $line_user_id,
                'display_name'      => isset($get_line_user_data['displayName'])   ? mb_substr($get_line_user_data['displayName'],0,20)   : '',
                'picture_url'       => isset($get_line_user_data['pictureUrl'])    ? $get_line_user_data['pictureUrl']    : '',
                'language'          => isset($get_line_user_data['language'])    ? $get_line_user_data['language']    : '',
                'status_message'    => isset($get_line_user_data['statusMessage']) ? mb_substr($get_line_user_data['statusMessage'],0,500) : '',
                'active_no'         => $this->Line_message_log->get_user_active($line_user_id, 30 ,$db),
                'last_insteractive' => date('Y-m-d H:i:s'),
                'profile_exdate'    => date('Y-m-d H:i:s', time() + (86400 * 30)),
                'follow'            => 'enable'
            );
            
            if(!$get_line_user_data) {
                // 無法取得資料，活躍度設為 -1
                $change_data['active_no']      = -1;
                $change_data['profile_exdate'] = date('Y-m-d H:i:s');
                $change_data['follow']         = 'disable';
                
                unset($change_data['display_name']);
                unset($change_data['picture_url']);
                unset($change_data['status_message']);
                unset($change_data['language']);
            }

            // 檢查是否資料已存在於資料庫
            $line_user_data = $this->Line_user->find_one($line_user_id,$db);
            if(count($line_user_data) == 0) {
                $this->Line_user->insert_data($change_data,$db);
            }
            else {
                $this->Line_user->update_data($line_user_id, $change_data,$db);
            }
            $line_user_data = $change_data;

        }
        # ## 追蹤中、最後一次互動超過30分鐘、更新活躍度
        elseif(isset($line_user_data['follow']) && $line_user_data['follow'] == 'enable' &&
               isset($line_user_data['last_insteractive']) && strtotime($line_user_data['last_insteractive']) < (time() - 1800))
        {
            $change_data = array(
                'active_no'         => $this->Line_message_log->get_user_active($line_user_id, 30 ,$db),
                'last_insteractive' => date('Y-m-d H:i:s')
            );
            $this->Line_user->update_data($line_user_id, $change_data);
        }

        return $line_user_data;
    }

    // 取得轉址網址 - article
    public function get_redirect_article_url($article_id, $user_id, $url)
    {
        return $this->config->item('web_url') . '/redirect/article/' . $article_id . '/' . $user_id . '/' . time() . '?url=' . urlencode($url);
    }
    
    
     // 取得轉址網址 - article
    public function get_goto_url($anchor, $user_id, $url)
    {
        return $this->config->item('web_url') . '/redirect/goto/' . $anchor . '/' . $user_id . '/' . time() . '?url=' . urlencode($url);
    }
    
    public function bind_push($line_user_data,$c_no,$c_name,$dev = 'default')
    {
    	  if ($line_user_data['follow'] == 'enable'){       
            $messages[] = array(
                            'type' => 'text',
                            'text' => "親愛的 ".$line_user_data['display_name']." 您好：\n您已成功綁定台灣安露莎 LINE 官方帳號！\n會員編號：".$c_no."，會員姓名：".$c_name.""
                    );  
                    
            $val['c_no'] = $c_no;
            
            $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'member_card');
            
            $messages[]  = array(
                  'type'     => 'flex',
                  'altText'  => '會員綁定完成',
                  'contents' => array(
                      'type'     => 'carousel',
                      'contents' => $bubble_data
                  )
            );
        
            $send_result = $this->api_line_service->push($line_user_data['user_id'],$messages);
            
            $this->load->model( 'Line_push_log' );
            
            // 推送記錄
            $this->Line_push_log->insert_log($line_user_data['user_id'],'member_join',$val['c_no'],$messages,$send_result['http_code'],$send_result['result'],$dev);
            
            if ($send_result['http_code'] == 429) {  // 訊息數不足
                return 'NoMsg';
            }else{
            	  return '';
            }            
        }else{
        	  return '帳號已封鎖';
        }
    }  
}