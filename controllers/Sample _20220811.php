<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends MY_Controller
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
        $this->load->model( 'sample_model' );
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
                
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        
    /*
        http://localhost/arsoa/sample/test
    */
    public function test($checkcode = 'FS9D2Ibc2')
    {
    	 
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' );
        $this->session->set_userdata('line_display_name', 'linroy' );       
        
        /*
        $val = array();

     					 		// 送 Line 訊息
     					 		$val['line_title'] = '肌能調理試用組';
                  $val['name'] = '親愛的 linroy 您好';                           
                  $val['line_msg'] = '恭喜您已完成肌能調理試用組申請！『請先回傳姓名 回傳後』，靜待官方 LINE 後續通知！';     
                  
                  $record_code = base64_encode(json_encode(array('l' => 6,'t'=> 'so')));
                  $record_code = str_replace('=', '', str_replace('/', '_',$record_code));
                    
                  $val['record_url']  = "https://www.arsoa.tw/sample/r?c=".$record_code;
                  
                  $bubble_card[] = $this->api_line_service->get_bubble_cont($val, 'member_card');
                  
                  $messages[]  = array(
                        'type'     => 'flex',
                        'altText'  => '肌能調理試用組',
                        'contents' => array(
                            'type'     => 'carousel',
                            'contents' => $bubble_card
                        )
                  ); 
                   
                  $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'sample_msg');            
               
                  $messages[]  = array(
                        'type'     => 'flex',
                        'altText'  => '肌能調理試用組',
                        'contents' => array(
                            'type'     => 'carousel',
                            'contents' => $bubble_data
                        )
                  );
                         echo "<pre>".print_r($messages,true)."</pre>";
       
                  $send_result = $this->api_line_service->push('U1f8c9566bd3519855409230932767d38',$messages);
                  echo "<pre>".print_r($send_result,true)."</pre>";
                  exit; 
        */    	 
        
        $this->form($checkcode);
        	  
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
       
       $sample_data = $this->sample_model->find_one('checkcode',substr($query,1));
       
       if ($sample_data){
       	   $query = strtoupper(substr($query,0,1)).substr($query,1);
       	   
       	   $data['query']         = $query;       	   
           $data['view']          = $view;
           $data['data']          = $sample_data;
           $data['dev']           = ''; 
           $data['line_liff_url'] = $this->config->item('line_liff_sample_url');
           
           $this->layout->view('line/liff_sample', $data);
       }else{
       	   alert('組數已兌換完畢，活動已截止（S01-'.$query.'）！',base_url());
           exit;  
       }
    }
    
    
    public function receive()
    {    	
    	  $result = array('success' => 0,'goline' => 'N', 'msg' => '');
                
        $data_post = $this->input->post( NULL, TRUE );         
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {         
             $platform = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
             
             $query = $data_post['query'];         
             $query = strtoupper(substr($query,0,1)).substr($query,1);
             
             $line_user_data = $this->line_service->get_line_user($data_post['userId'],'',true);
             
             $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_sample_url').'/'.$query;
             
             if ($line_user_data['follow'] == 'disable')
             {
             	  $result['msg']  = '親愛的來賓您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行相關作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新索取</button>';
             }else{
                 if ($line_user_data)
                 {
                     $sample_data = $this->sample_model->find_one('checkcode',substr($query,1));
                     
                     if (strtotime($sample_data['s_start']) > strtotime(date('Y-m-d H:i:s'))){
                         $result["msg"] = "此活動尚未開始！";
                     }elseif(strtotime($sample_data['s_end']) < strtotime(date('Y-m-d H:i:s'))){               
                         $result["msg"] = "此活動已經結束！";
                     }else{
                     	   $line_id_data = $this->Member_line_model->find_one('user_id',$data_post['userId']);                     	   
                     	   if ($line_id_data)
                     	   {
                     	       $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>會員無法索取試用組；如有問題，請洽客服！';
                     	   }else{
                     	   	   $charge_check = $this->sample_model->charge_check($sample_data['s_id'],$data_post['userId']);
                     	   	   if ($charge_check){
                     	   	       $result['msg'] = '親愛的 '.$line_user_data['display_name'].' 您好：<br><br>試用組只能申請一次；如有問題，請洽客服！'; 	
                     	   	   }else{
                     	   	   	   $this->session->set_userdata('line_user_id', $data_post['userId'] );
                                 $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );                          
                                 $result['goline'] = base_url('sample/form/'.$query);                                    
                                 $result['success'] = 1;
                     	   	   }
                     	   }
                     }
                     
                     if ($data_post['email'] > '' && $line_user_data['line_email'] <> $data_post['email'])  // 更新LINE USER EMAIL
                     {
                         $this->load->model( 'Line_user' );  
                         
                         $change_data        = array(
                                'line_email'    => $data_post['email']
                         );
                         
                         $this->Line_user->update_data($data_post['userId'],$change_data,'');
                     }     
                 }  
             }
        }        
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);         
        exit;
    }
    
    
    public function form($query, $preview = FALSE)
    {     
       $this->load->library('ui');
       
       $query = strtoupper(substr($query,0,1)).substr($query,1);
              
       if (!$preview){
           // 偵側不到 user_id
    	     if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	         if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	         	   $err_url = base_url('form/test');
    	         }else{
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_sample_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認才能申請！',$err_url );    	     
    	         exit;
    	     }    	
    	 }     
    	 $sample_data = $this->sample_model->find_one('checkcode',substr($query,1),$preview); 
       if ($sample_data)
       {
           if (strtotime($sample_data['s_start']) > strtotime(date('Y-m-d H:i:s'))){
               alert('此活動尚未開始（S03-'.$query.'）！',base_url());  
           }elseif(strtotime($sample_data['s_end']) < strtotime(date('Y-m-d H:i:s'))){                              
               alert('此活動已經結束（S04-'.$query.'）！',base_url());  
           }
       }else{
       	   alert('組數已兌換完畢，活動已截止（S05-'.$query.'）！',base_url());
    	     exit;
       }
       
       $data['sample_data']                 = $sample_data;           
       $data['sample_data']['sample_data']  = json_decode($sample_data['sample_data'], true);                             
       
       $check = false;
       $check_data = $this->sample_model->charge_check($sample_data['s_id'],$this->session->userdata('line_user_id'));
       if ($check_data){
       	   if ($check_data['status'] == 'Y'){
       	       $check = true;
       	   }
       }
       
       // 判斷是否填寫過
       if (!$preview && $check){
           $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好<br> <br>試用組只能申請一次；如有問題，請洽客服！';
           self::msg($query,$msg);               
       }else{
       
           $data['query']         = $query;
           $data['preview']       = $preview;
           $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
           
           $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
          
           $this->layout->view('sample_form', $data);                  
       }
    }  
    
      // 每一頁的資料判斷
    public function from_save($query)
    {      
        $result = array('status' => 0,'focuskey' => '', 'errmsg' => '操作有誤!'); 
        
        if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	          if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	          	   $err_url = base_url('form/test');
    	          }else{
    	              $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_sample_url').'/'.$query;
    	          }
    	          alert( '抱歉，您的操作時間過久，請重新確認才能申請！',$err_url );    	     
    	          exit;    	      	
    	  }     
    	  $sample_data = $this->sample_model->find_one('checkcode',substr($query,1)); 
        if ($sample_data)
        {
            if (strtotime($sample_data['s_start']) > strtotime(date('Y-m-d H:i:s'))){
                alert('此活動尚未開始（S06-'.$query.'）！',base_url());  
            }elseif(strtotime($sample_data['s_end']) < strtotime(date('Y-m-d H:i:s'))){                              
                alert('此活動已經結束（S07-'.$query.'）！',base_url());  
            }
        }else{
        	   alert('組數已兌換完畢，活動已截止（S08-'.$query.'）！',base_url());
    	       exit;
        }
                   
        $sample_data['sample_data']  = json_decode($sample_data['sample_data'], true);       
                              
        $data_post = $this->input->post( NULL, FALSE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){  
        	   foreach ($data_post as $key => $val){
        	   	       if (is_array($val)){
        	   	       	   $data_post[$key] = $val;
        	   	       }else{
        	   	           $data_post[$key] = trim($val);
        	   	       }
        	   }
        	   $check = true;
        	  
     					if ($data_post['uname'] == '') {      
     						  $result['errmsg'] = '姓名未填入！';     
     						  $result['focuskey'] = 'uname';                
     						  $check = false;
     					}
     					if ($check && $data_post['sex'] == '') {      
     						  $result['errmsg'] = '性別未選擇！';     
     						  $result['focuskey'] = 'sex';                
     						  $check = false;
     					}
     					
     					if ($check && !check_date($data_post['bday'])){
     					    $result['errmsg'] = '生日日期有誤！';
     					    $result['focuskey'] = 'bday';                
     						  $check = false;
     					}else{
     						  if (!validateAge($data_post['bday'])){
     						  	  $result['errmsg'] = '滿18歲才可申請！';
     					        $result['focuskey'] = 'bday';                
     						      $check = false;
     						  }
     					}
     					
     					if ($check && substr($data_post['tel'],0,2) == '09'){
     						  if (!ismobile($data_post['tel'])){
     						  	  $result['errmsg'] = '手機號碼不符格式！';
     					        $result['focuskey'] = 'tel';                
     						      $check = false;
     						  }        	  	
     					}
     					
     					if ($check && substr($data_post['tel'],0,2) == '09'){
     						  if (!ismobile($data_post['tel'])){
     						  	  $result['errmsg'] = '手機號碼不符格式！';
     					        $result['focuskey'] = 'tel';                
     						      $check = false;
     						  }        	  	
     					}
     					
     					if ($data_post['postal'] == '' || $data_post['cityno'] == '' || $data_post['address'] == ''){
     					    $result['errmsg'] = '地址有誤！';     
     						  $result['focuskey'] = 'cityno';                
     						  $check = false;     								   	  
     					}
     					
     					if ($check){
     					    if (count($sample_data['sample_data']) == 1){
     					    	  $sel_sample = trim($sample_data['sample_data'][0]['title']);
     					    }else{
     					    	  foreach ($sample_data['sample_data'] as $key => $item){
     					    	  	       if (trim($data_post['sel_sample']) == trim($item['title'])){
     					    	  	       	   $sel_sample = trim($data_post['sel_sample']);
     					    	  	       }
     					    	  }     					    	  
     					    }
     					    if ($sel_sample == '') {      
     						      $result['errmsg'] = '試用組未選擇！';     
     						      $result['focuskey'] = 'sel_sample';                
     						      $check = false;
     					    }
     					}
     					
     					if ( $_SERVER['HTTP_HOST'] != 'localhost' && $check){  
     					    $msconn = $this->front_mssql_model->ms_connect();  
     					    
     					    $chkdata = $this->sample_model->ms_chknamebdate($msconn,$data_post['uname'],$data_post['bday'],$data_post['tel']);  // 檢查申請人是否為會員
     					    if ($chkdata['errcode']){
     					        $result['errmsg'] = '親愛的 '.$this->session->userdata('line_display_name').' 您好，會員無法索取試用組；如有問題，請洽客服';
     					        $result['focuskey'] = 'uname';                
     						      $check = false;
     					    } 
     					    
     					    if ($check && strtoupper(substr($query,0,1)) == 'S'){
     					        $this->load->model( 'front_join_model' );  // 判斷推薦人   					    
     					        $chkdata = $this->front_join_model->ms_chkdname($msconn,$data_post['referrer_name'],$data_post['referrer_c_no']);  // 檢查推薦人資料是否存在     					    
     					        if ($chkdata['errcode']){
     					            $result['errmsg'] = '推薦人資料有誤，如有問題請洽公司客服 0809-080-608！';
     					            $result['focuskey'] = 'referrer_name';                
     						          $check = false;
     					        }     
     					        $line_id_data = $this->Member_line_model->find_one('c_no',$data_post['referrer_c_no']);                     	                  
     					        if ($check && $line_id_data){
     					        	  if ($line_id_data['user_id'] == ''){
     					        	  	  $result['errmsg'] = '此推薦人尚未綁定官方Line，無法索取試用組！';
     					                $result['focuskey'] = 'referrer_name';                
     						              $check = false;
     					        	  }else{
     					        	  	  $referrer_line_user_data = $this->line_service->get_line_user($line_id_data['user_id'] ,'',true);     
    	  	                    if ($referrer_line_user_data['follow'] == 'disable'){
    	  	                    	  $result['errmsg'] = '此推薦人封鎖官方Line，無法索取試用組！';
     					                    $result['focuskey'] = 'referrer_name';                
     						                  $check = false;    	  	                    	
    	  	                    }
     					        	  }
     					        }else{
     					        	  $result['errmsg'] = '此推薦人尚未綁定官方Line，無法索取試用組！';
     					            $result['focuskey'] = 'referrer_name';                
     						          $check = false;
     					        }     					        
     					    }
     					}
     					
     					if ($check){        	  
     					    $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));      
                  if ($line_id_data)
                  {
                  	  $result['errmsg'] = '親愛的 '.$this->session->userdata('line_display_name').' 您好，會員無法索取試用組；如有問題，請洽客服！';
     					        $result['focuskey'] = 'uname';                
     						      $check = false;
     						  }else{
                  	   $charge_check = $this->sample_model->charge_check($sample_data['s_id'],$this->session->userdata('line_user_id'));
                  	   if ($charge_check){
                  	       $result['errmsg'] = '親愛的 '.$this->session->userdata('line_display_name').' 您好，試用組只能申請一次；如有問題，請洽客服！';
     					             $result['focuskey'] = 'uname';                
     						           $check = false;
                  	   }
                  	   $charge_check = $this->sample_model->charge_check_name_bday($sample_data['s_id'],$data_post['uname'],$data_post['bday']);
                  	   if ($charge_check){
                  	       $result['errmsg'] = '親愛的 '.$this->session->userdata('line_display_name').' 您好，試用組只能申請一次；如有問題，請洽客服！';
     					             $result['focuskey'] = 'uname';                
     						           $check = false;
                  	   }
                  }
              }   	   
     					
     					if ($check){        	  
     					 		$session_id = session_id();
     					 		$cookie_key = md5($session_id.date('Y-m-d H:i:s'));
     					 		$data = array(
     					 		              "s_id"    => $sample_data['s_id'],
     					 		              "s_type"  => substr($query,0,1),
     					 		              "query" => $query,
     					 		              "uname" => $data_post['uname'],
     					 		              "sex" => $data_post['sex'],     								       		              
     					 		              "bday" => $data_post['bday'],     								       		              
     					 		              "tel"   => $data_post['tel'],
     					 		              "user_id"	=> $this->session->userdata('line_user_id'),
       				                  "display_name" => mb_substr($this->session->userdata('line_display_name'),0,20),       				    
     					 		              'city' => $this->front_base_model->city_title($data_post['cityno']),
     					 		              'town' => $this->front_base_model->town_title($data_post['postal']),
     					 		              "postal" => $data_post['postal'],
     					 		              "sel_sample" => $sel_sample,     					 		              
     					 		              "address" => $data_post['address'],     								       		              
     					 		              "ip" => $this->data['tracking']['ip'],
     					 		              "crdt" => date('Y-m-d H:i:s'),
     					 		              "checkcode" => uniqid()
     					 		);
     					 		if (strtoupper(substr($query,0,1)) == 'S'){
     					 			  $data['referrer_name'] = trim($data_post['referrer_name']);
     					 			  $data['referrer_c_no'] = trim($data_post['referrer_c_no']);
     					 		}
     					 		
     					 		$this->db->insert('ap_sample_charge', $data);
     					 		    
     					 		if ($this->db->affected_rows() > 0 ){               
     					 		    $jid = $this->db->insert_id();                            		             								       		
     					 		}               
     					 		$result['status']     = 1;
     					 	  $result['jid']        = $jid;
     					 	  $result['errmsg']     = '感謝您的填寫，您已申請成功！';
     					 		$result['next_url']   = base_url();
     					 		
     					 		$val = array();

     					 		// 送 Line 訊息
     					 		$val['line_title'] = trim($sample_data['line_title']);
                  $val['name'] = '親愛的 '.trim($this->session->userdata('line_display_name')).' 您好';                           
                  $val['line_msg'] = $sample_data['line_msg'];     
                  
                  $record_code = base64_encode(json_encode(array('l' => $jid,'t'=> 'so')));
                  $record_code = str_replace('=', '', str_replace('/', '_',$record_code));
                    
                  $val['record_url']  = "https://www.arsoa.tw/sample/r?c=".$record_code;
                                    
                  // -- 會員卡 -- 
                  $bubble_card[] = $this->api_line_service->get_bubble_cont($val, 'member_card');
                  
                  $messages[]  = array(
                        'type'     => 'flex',
                        'altText'  => '肌能調理試用組',
                        'contents' => array(
                            'type'     => 'carousel',
                            'contents' => $bubble_card
                        )
                  );                   
                  // -- 會員卡 -- 
                   
                  $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'sample_msg');            
               
                  $messages[]  = array(
                        'type'     => 'flex',
                        'altText'  => $sample_data['line_title'],
                        'contents' => array(
                            'type'     => 'carousel',
                            'contents' => $bubble_data
                        )
                  );
                                       
                  $send_result = $this->api_line_service->push($this->session->userdata('line_user_id'),$messages);
                  //echo "<pre>".print_r($send_result,true)."</pre>";
                  //exit; 
                  $this->load->model( 'Line_push_log' );                                            
                  // 推送記錄
                  $this->Line_push_log->insert_log($this->session->userdata('line_user_id'),'sample',$sample_data['s_id'],$messages,$send_result['http_code'],$send_result['result']);
                  
                  $msg = 'Line 訊息推送失敗 ';
                  if ($send_result['http_code'] == 429) {  // 訊息數不足
                      $msg = 'Line 訊息數不足';                       
                  }elseif($send_result['http_code'] == 200){  // 寄送成功
                      $msg = 'Line 訊息推送成功 ';
                  }   
                  
                  $this->sample_model->charge_update_data($jid,array('msg' => $msg ));
                
     					 }                        
        }
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;    
    }    
    
    
    // Line 記錄 OPEN 
    public function r()
    {
        if (!empty($this->input->get( 'c' ))){
            $c = $this->input->get( 'c' );            
        }                
        if ($c > ''){
            $areg = json_decode(base64_decode($c), true);                 
            if ($areg['l'] > '' && $areg['t'] == 'so'){
            	  $data = array('opdt' => date('Y-m-d H:i:s'));
                $this->sample_model->charge_update_date_data($areg['l'],'opdt',$data);
            }
        }
        $fileModTime = time();
        header('Content-Type: image/gif');
        header('Last-Modified: ' . gmdate('D, d M Y H:00:00', $fileModTime) . ' GMT'); 
        header('Expires: ' . gmdate('D, d M Y H:00:00', time() + 7200) . ' GMT');
        echo base64_decode('R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');        
        exit;
    }
    
    
    public function partners()
    {
    	  if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $this->load->model( 'question_model' );        
        $this->load->model( 'front_order_model' );
        
        $data['Search'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.tel'      => $data['Search'],
                     'a.uname'    => $data['Search']
                    );
        }        
        
        $where['a.referrer_c_no'] = $this->session->userdata('member_session')['c_no'];    
        $where['a.status'] = 'Y';
        
        $data['list'] = $this->sample_model->partners_list( 'ap_sample_charge ',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , array('a.s_id','a.user_id','a.send_date','a.uname','a.tel','a.outdt','a.last_rid')
            , array( 'max(r.okdt)' => 'desc','a.outdt' => 'asc' )    // order by
        );     
     
        foreach ($data['list']['rows'] as $key => $item){        	
        	       $data['list']['rows'][$key]['reply'] = $this->question_model->find_reply_list('S',$item['user_id'],$item['s_id']);        	              	       
        }
                     
        $data['Page']        = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount']   = $data['list']['PageCount']; //總頁數 
        
        $data['qtype'] = 'S';      
                                 
        $this->layout->view('sample_partners', $data);
    	    	
    }
    
    
    
    private function msg($query,$msg)
    {
    	  
    	  $data['msg'] = $msg;
    	  
    	  $data['query'] = $query;
    	  
    	  $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
   
        $this->layout->view('question_msg', $data);
        
    } 
}       