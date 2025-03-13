<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Line extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );        
        $this->load->model( 'front_mssql_model' );
        $this->load->model( 'front_order_model' );        
        $this->load->model( 'Member_line_model' );
        $this->load->model( 'Member_login_record' );                
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
        
        $this->line_redirect_uri = base_url('line/auth');
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        
    public function test_login()
    {
    	 /*
    	  $c_no = '000000';
    	  $this->db->select( "m.c_no,m.c_name,m.d_posn,m.passwrd,ifnull(m.pass_date,'') as pass_date,m.is_read,m.addr_dl,m.zip_dl,m.cell1,m.e_mail,p.d_pos,p.s_rate,m.is_web,m.mb_status,m.is_org,m.is_lock,m.b_date,m.is_read_reward" )
                          ->from( 'member m' )
                          ->join( 'position p', 'm.d_posn = p.d_posn' )                      
                          ->where( 'm.c_no', $c_no );
                    $result = $this->db->get()->row_array();
                    if ($result){                                     	
                        $this->front_member_model->check_login('user',$result );            
                        exit;
                    }
                    
    	  exit;
    	  */
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' );
        $this->session->set_userdata('line_display_name', 'linroy' );            	 
        
        $login_url = base_url('member/login');
        $rddata = $this->Member_login_record->find_one();
        if ($rddata){
        	  if ($rddata['rdurl'] > ''){
        	      $login_url .= '?rdurl='.$rddata['rdurl'];
        	  }
        }
            
        redirect($login_url);            	  
        exit;
    }
        
    public function index()
    {
    	  exit;
    	  
        $user_id = 'U1f8c9566bd3519855409230932767d38';
        $data['query']         = 'm_61fa8188b12d4';
        $data['view']          = 'F';
        $data['dev']           = ''; 
        
        $data['line_liff_url'] = $this->config->item('line_liff_url');
     
        $this->layout->view('line/liff', $data);
        
        /*exit;
       
        // Line USER 資料 - 更新、取得
        $line_user_data = $this->line_service->get_line_user($user_id);
        echo "<pre>".print_r($line_user_data,true)."</pre>";
        exit;
        if ($line_user_data['follow'] == 'enable'){       
            $messages[] = array(
                            'type' => 'text',
                            'text' => "親愛的 abyzcase 您好：\n您已成功綁定台灣安露莎 LINE 官方帳號！"
                    );  
            $val['c_no'] = '000001';
            
            $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'member_card');
            
            $messages[]  = array(
                  'type'     => 'flex',
                  'altText'  => '會員綁定完成',
                  'contents' => array(
                      'type'     => 'carousel',
                      'contents' => $bubble_data
                  )
            );
            //  echo "<pre>".print_r($messages,true)."</pre>";
        
            $send_result = $this->api_line_service->push($user_id,$messages);
         //   echo "<pre>".print_r($send_result, true)."</pre>";
            
            $this->load->model( 'Line_push_log' );
            
            // 推送記錄
            $this->Line_push_log->insert_log($user_id,'member_join',$val['c_no'],$messages,$send_result['http_code'],$send_result['result']);
            
            if ($send_result['http_code'] == 429) {  // 訊息數不足
                echo '訊息數不足';
            }
            
        }else{
        	  echo $user_id.' 已封鎖';
        }
        exit;
        */
    }
    
    public function liff($query = '',$view = 'F')
    { 
    	 if ($query == '') {       
            $get = $this->input->get();
            if (isset($get['liff_state'])) {
                $query = str_replace('/', '', $get['liff_state']);
            }
            if (isset($get['query'])) {
               $query = $get['query'];
            }
       }
       
       if (substr($query,0,2) == 'm_')  // Join 會員綁定
       {
       	   $code = str_replace('m_', '', $query);       	   
       }
       
       $data['query']         = $query;
       $data['view']          = $view;
       $data['dev']           = ''; 
       $data['line_liff_url'] = $this->config->item('line_liff_url');
     
       $this->layout->view('line/liff', $data);
       
    }
    
    // http://localhost/arsoa/line/question/Q15412ba
    // https://liff.line.me/1656832375-Vw6mmZ1q/Q301725
    public function question($query = '',$view = 'F')
    { 
    	 if ($query == '') {       
            $get = $this->input->get();
            if (isset($get['liff_state'])) {
                $query = str_replace('/', '', $get['liff_state']);
            }
            if (isset($get['query'])) {
               $query = $get['query'];
            }
       }
       
       $this->load->model( 'question_model' );
       
       $question_data = $this->question_model->find_one('checkcode',$query);
                     	   
       if ($question_data)
       {
           $data['question_data']              = $question_data;
           $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);
           $data['question_data']['q_config']  = json_decode($question_data['q_config'], true);
       }   
       
       $data['query']         = $query;
       $data['view']          = $view;
       $data['dev']           = ''; 
       $data['line_liff_url'] = $this->config->item('line_liff_question_url');
     
       $this->layout->view('line/liff_question', $data);
       
    }
    
    public function liffdev($query = '',$view = 'F')
    { 
    	 if ($query == '') {       
            $get = $this->input->get();
            if (isset($get['liff_state'])) {
                $query = str_replace('/', '', $get['liff_state']);
            }
            if (isset($get['query'])) {
               $query = $get['query'];
            }
       }
       
       if (substr($query,0,2) == 'm_')  // 會員綁定
       {
       	   $code = str_replace('m_', '', $query);       	   
       }
       
       $data['query']         = $query;
       $data['view']          = $view;
       $data['dev']           = 'dev';
       $data['line_liff_url'] = $this->config->item('dev_line_liff_url');
     
       $this->layout->view('line/liff', $data);
    }
    
    public function question_receive($dev = '')
    {    	
    	  $result = array('success' => 0,'goline' => 'N', 'msg' => '');
                
        $data_post = $this->input->post( NULL, TRUE );         
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {         
             $platform = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
             
             $query = $data_post['query'];         
             
             $line_user_data = $this->line_service->get_line_user($data_post['userId'],$dev,true);
             
             $this->load->model( 'question_model' );
       
             $question_data = $this->question_model->find_one('checkcode',$query);
             
             if ($question_data)
             {
                 $data['question_data']              = $question_data;
                 $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);
                 $data['question_data']['q_config']  = json_decode($question_data['q_config'], true);
             }   
             
             $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$query;
             
             if ($line_user_data['follow'] == 'disable')
             {
             	  $result['msg']  = '親愛的會員您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可填寫問卷！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新綁定</button>';
             }else{
                              
                     $this->session->set_userdata('line_user_id', $data_post['userId'] );
                     $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );     
                     
                     $question_go = true;
                     if ($data['question_data']['q_config']['member'] == 'Y'){  // 需要會員才可以填問卷
                     	   $line_id_data = $this->Member_line_model->find_one('user_id',$data_post['userId'],$dev);                     	                  
           	             $chk_member = false;
                         if ($line_id_data)
                         {
                         	   if (trim($line_id_data['c_no']) > ''){
                         	   	   $chk_member = true;
                         	   }
           	             }
           	             if (!$chk_member){
           	             	   $result['msg']  = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>此問卷需安露莎會員身份才可以填寫！';
                         	   $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.base_url('line/bind?rdurl='.base_url('question/form/'.$query)).'\'">綁定會員</button>';                         	   	   
                         	   $question_go = false;
           	             }
                     }
                     
                     if ($question_go){                     
                         $result['goline'] = base_url('question/form/'.$query);   
                         $result['success'] = 1;
                     }
                     
                     if ($data_post['email'] > '' && $line_user_data['line_email'] <> $data_post['email'])  // 更新LINE USER EMAIL
                     {
                         $this->load->model( 'Line_user' );  
                         
                         $change_data        = array(
                                'line_email'    => $data_post['email']
                         );
                         
                         $this->Line_user->update_data($data_post['userId'],$change_data,$dev);
                     }     
                
             }
        }        
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);         
        exit;
    }
    
    public function receive($dev = '')
    {    	
    	  $result = array('success' => 0,'goline' => 'N', 'msg' => '綁定失敗!');
                
        $data_post = $this->input->post( NULL, TRUE );         
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {         
             $platform = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
             
             $query = $data_post['query'];         
             
             $line_user_data = $this->line_service->get_line_user($data_post['userId'],$dev,true);
             
             $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_url').'/'.$query;
             
             if ($line_user_data['follow'] == 'disable')
             {
             	  $result['msg']  = '親愛的會員您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行綁定作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新綁定</button>';
             }else{
                 if ($line_user_data)
                 {
                     if (substr($query,0,2) == 'm_')  // 會員綁定
                     {
                     	   $bind_code = str_replace('m_', '', $query);   
                     
                     	   $member_line_data = $this->Member_line_model->find_one('bind_code',$bind_code,$dev);
                     	   
                     	   if ($member_line_data)
                     	   {
                     	       if ($member_line_data['user_id'] == '')
                     	       {
                     	       	   $line_id_data = $this->Member_line_model->find_one('user_id',$data_post['userId'],$dev);                     	   
                     	           if ($line_id_data)
                     	           {
                     	   	           $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>您的Line帳號已綁定（'.$line_id_data['c_no'].'），一個 Line帳號，只能綁定一個會員編號；如有問題，請洽客服！';
                     	           }else{                     	   
                     	       	       $m_data   = array(
                                            'user_id'   => trim($data_post['userId']),
                                            'bind_date' => date('Y-m-d H:i:s')
                                     );
                                     if (trim($member_line_data['bind_type']) == 'L'){
                                     	   $m_data['bind_type'] = 'M';
                                     }
                                     
                     	       	       $this->Member_line_model->update_data($member_line_data['bid'],$m_data,$dev);
                     	       	       
                     	       	       $push_msg = $this->line_service->bind_push($line_user_data,$member_line_data['c_no'],$member_line_data['c_name'],$dev);
                     	       	       
                     	       	       // line 資料抓取 set session
                                     $this->front_member_model->member_session_line_set($member_line_data['c_no'],$line_user_data['display_name'],'line');
                                     
                     	               $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>您已成功綁定！';
                                     $result['success'] = 1;   
                                     if (($member_line_data['bind_type'] == 'M' || $member_line_data['bind_type'] == 'L') && $platform == 'DESKTOP'){  // 桌機導回會員專區
                                     	   $result['goline'] = base_url('member/main');   
                                     }else{
                                         $result['goline'] = 'Y';   
                                     }   
                                 }                                 
                             }else{
                             	   if ($member_line_data['user_id'] == $data_post['userId']){
                             	       $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>您已成功綁定過，不用重覆綁定！';
                             	   }else{
                             	   	   $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>此會員已被其他 Line 帳號綁定；如有問題，請洽客服！';
                             	   }
                             }
                         }else{
                         	   $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>綁定有誤；如有問題，請洽客服！';
                         }
                     }
                     if ($query == 'bind')  // LINE 來做會員綁定
                     {
                     	   $line_id_data = $this->Member_line_model->find_one('user_id',$data_post['userId'],$dev);                     	   
                     	   if ($line_id_data)
                     	   {
                     	       if ($line_id_data['user_id'] == $data_post['userId']){
                                 $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>您已成功綁定過，不用重覆綁定！';
                                 $result['success'] = 1; 
                             }else{
                             	   $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>此會員已被其他 Line 帳號綁定；如有問題，請洽客服！';
                             }
                             $result['goline'] = 'Y';                                
                     	   }else{                     	   
                     	   	   $this->session->set_userdata('line_user_id', $data_post['userId'] );
                             $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );     
                     	       
                     	       $result['goline'] = base_url('line/bind');   	
                     	       $result['msg']  = '親愛的會員您好：<br><br>請輸入您的會員編號以及密碼登入綁定 Line';
                     	       $result['success'] = 1;   
                         }
                     }
                     
                     if ($data_post['email'] > '' && $line_user_data['line_email'] <> $data_post['email'])  // 更新LINE USER EMAIL
                     {
                         $this->load->model( 'Line_user' );  
                         
                         $change_data        = array(
                                'line_email'    => $data_post['email']
                         );
                         
                         $this->Line_user->update_data($data_post['userId'],$change_data,$dev);
                     }     
                 }  
              }
        }        
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);         
        exit;
    }
        
    // line login
    // https://developers.line.biz/en/docs/line-login/verify-id-token/#get-profile-info-from-id-token
    public function login()
    {
        $rddata = $this->Member_login_record->find_one();
        if ($rddata){
        	  $login_code = $rddata['login_code'];
        }else{
        	  $rdurl = '';         
            if ( !empty( $this->input->get( 'rdurl' ) ) ) {
                 $rdurl = $this->input->get( 'rdurl' );                     
            }
            
            $login_code = $this->Member_login_record->login_record('L',$rdurl);
        }
        
        if (isset($_COOKIE[$this->config->item('cookies_name')]) && !empty($_COOKIE[$this->config->item('cookies_name')])) {
            $line_config = $this->config->item('line_config');
            
            $time_temp = date('Y-m-dH:i:s', strtotime('now'));
            // 每次重登這兩個值都要換新的
            $this->session->set_userdata('line_api_state', md5($_COOKIE[$this->config->item('cookies_name')] . 'state' . $time_temp) );
            $this->session->set_userdata('line_api_nonce', $login_code);
            
            $query = array(
                'response_type'       => 'code',
                'client_id'           => $line_config['line_client_id'],
                'state'               => $this->session->userdata('line_api_state'),  // 隨機字串 驗證response用
                'nonce'               => $this->session->userdata('line_api_nonce'),  // replay attack隨機字串 驗證response用
                'redirect_uri'        => $this->line_redirect_uri,                          // 設定在Line Login裡
                'scope'               => 'profile openid email',                            // 抓個人資料            
            );        
            
            $line_login_url = 'https://access.line.me/oauth2/v2.1/authorize?' . http_build_query($query);
            redirect($line_login_url);
        }else{
            redirect(base_url('member/login'));
        }        
    }
    
    // Line 官方api回傳的地方
    public function auth()
    {
        // 已登入轉回去
        if (isset($this->session->userdata('member_session')['c_no']) && $this->session->userdata('member_session')['c_no'] > '') {       
            redirect( base_url('member/main') );
            exit;
        }  
        
        $get = $this->input->get();
        
        if (!empty($get['state']) && $get['state'] == $this->session->userdata('line_api_state')) {
            $line_config = $this->config->item('line_config');
            $this->session->unset_userdata('line_api_state');
        
            $post = array(
                'grant_type'    => 'authorization_code',
                'code'          => $get['code'],
                'redirect_uri'  => ($this->line_redirect_uri),
                'client_id'     => $line_config['line_client_id'],
                'client_secret' => $line_config['line_client_secret']
            );
            
            $auth = curl_post_header_form('https://api.line.me/oauth2/v2.1/token', http_build_query($post));
        
            if (!empty($auth['error'])) {                
                    // 抓token有問題
                    $insert_data = array(
                        'error_message' => json_encode($auth),
                        'crdt'   				=> date('Y-m-d H:i:s'),
                        'cookies' 			=> $_COOKIE[$this->config->item('cookies_name')],
                        'type'          => 'line_token'
                    );
                    $this->db->insert('line_login_error', $insert_data);                                
            } else {
                $c_no = $this->line_service->get_profile_by_id_token($auth,$line_config['line_client_id'],$cookies);
                
                if ($c_no > ''){
                    $this->db->select( "m.c_no,m.c_name,m.d_posn,m.passwrd,ifnull(m.pass_date,'') as pass_date,m.is_read,m.addr_dl,m.zip_dl,m.cell1,m.e_mail,p.d_pos,p.s_rate,m.is_web,m.mb_status,m.is_org,m.is_lock,m.b_date,m.is_read_reward" )
                          ->from( 'member m' )
                          ->join( 'position p', 'm.d_posn = p.d_posn' )                      
                          ->where( 'm.c_no', $c_no );
                    $result = $this->db->get()->row_array();
                    if ($result){                             
                    	  $rdurl = '';
                    	  $rddata = $this->Member_login_record->find_one();
                        if ($rddata){
                        	  if ($rddata['rdurl'] > ''){
                        	      $rdurl = $rddata['rdurl'];
                        	  }
                        }        	
                        $this->front_member_model->check_login('user',$result,$rdurl );
                        exit;
                    }
                }
                redirect(base_url('member/login'));
                exit;                
            }
        }else{
            redirect(base_url('member/login'));
        }
        
        if (!empty($get['error'])) {
            // 登入有問題
            $insert = array(
                'cookies'       => $_COOKIE[$this->config->item('cookies_name')],                
                'error_message' => json_encode($get),
                'insert_time'   => date('Y-m-d H:i:s'),
                'type'          => 'line_login'
            );
            $this->db->insert('line_login_error', $insert_data); 
        }
        redirect(base_url('member/login'));
    }  
    
    /* 
       line 來綁定
       https://liff.line.me/1656832375-578ddKjz/bind
       
    */       
    public function bind()
    {
    	   // 偵側不到 user_id
    	   if (empty($this->session->userdata('line_user_id'))){
    	       $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_url').'/bind';
    	       redirect($err_url);
    	       exit;
    	   }
    	   
    	   $rdurl = '';         
         if ( !empty( $this->input->get( 'rdurl' ) ) ) {
             $rdurl = $this->input->get( 'rdurl' );                
         }
    	   
    	   $data_post = $this->input->post( NULL, TRUE );            
         if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
                if ( $data_post['account'] > '' && $data_post['password'] > ''){                                                        
                     $this->db->select( "m.c_no,m.c_name,m.d_posn,m.passwrd,ifnull(m.pass_date,'') as pass_date,m.e_mail,m.addr_dl,m.zip_dl,m.cell1,m.is_read,p.d_pos,p.s_rate,m.is_web,m.mb_status,m.is_org,m.is_lock,m.b_date,m.is_read_reward" )
                          ->from( 'member m' )
                          ->join( 'position p', 'm.d_posn = p.d_posn' )
                          ->where( 'ifnull(m.d_posn,999) <=', '100' )
                          ->where( 'm.c_no', $data_post['account'] );
                     $result = $this->db->get()->row_array();
                     if ($result){     
                         if ($data_post['password'] == trim($result['passwrd']) || ($super_pass == trim($data_post['password']) && trim($result["is_lock"]) == 0)){
                             if (trim($result["mb_status"]) == "退出"){   	  	  // 退出
                             	   $this->session->set_flashdata( 'error_message', '您的會員資格巳取消，若有任何疑問請洽本公司客服人員！' );
                                 redirect( 'line/bind' );                     
                             }else{
                                 $this->front_member_model->member_line_bind($result['c_no'],$result['c_name'],$this->session->userdata('line_user_id'));        
                                 if ($data_post['rdurl'] > ''){            
                                     redirect($data_post['rdurl']);            	  
                                 }else{
                                 	   redirect(base_url('line/bind_close'));            	  
                                 }
                                 exit;
                             }
                         }
                     }else{
                         $this->session->set_flashdata( 'error_message', '登入失敗!' );
                         redirect( 'line/bind' );
                     }
                }else{
                     $this->session->set_flashdata( 'error_message', '輸入有誤!' );
                     redirect( 'line/bind' );
                }
        }else{
                $data = array(
                    'error_message' => $this->session->flashdata( 'error_message' )
                );                
        }
        $data['web_page'] = 'member_login';
        $data['canshow'] = 'N';
        $data['rdurl'] = $rdurl;
        $data['action'] = base_url( 'line/bind' );
        
        $this->layout->view('member_login_line', $data);
    }
    
    public function bind_close()
    {        
    	   $data['web_page'] = 'liff_close';
    	   $data['line_liff_url'] = $this->config->item('line_liff_url');
    	   $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
    	   
         $this->layout->view('line/liff_close', $data);
    }
    
    public function logout()
    {        
        $this->session->unset_userdata( 'line_user_id' );        
        $this->session->unset_userdata( 'line_display_name' );
        
        $login_url = base_url('member/login');
        $rddata = $this->Member_login_record->find_one();
        if ($rddata){
        	  if (trim($rddata['rdurl']) > ''){
        	      $login_url .= '?rdurl='.$rddata['rdurl'];
        	      $login_url .= "&line=Y";
        	  }else{
        	  	  $login_url .= "?line=Y";
        	  }
        }else{
            $login_url .= "?line=Y";
        }
        redirect($login_url);            	  
        exit;
    	 
    } 
    
}       
        
        
        
        
        
        
        
        