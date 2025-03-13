<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends MY_Controller
{
    private $reg_type  = array('1' => '會員本人', '2' => '會員配偶', '3' => '會員子女', '4' => '來賓');
    
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );        
        $this->load->model( 'front_mssql_model' );
        $this->load->model( 'front_order_model' );        
        $this->load->model( 'front_admin_model' );        
        $this->load->model( 'Member_line_model' );
        $this->load->model( 'Member_login_record' );                
        $this->load->model( 'activity_model' );
        $this->load->model( 'question_model' );        
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
                
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        
    /*
        http://localhost/arsoa/activity/test
    */
    public function test($checkcode = 'aIYAC1sU2E')
    {
    	 
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' );
        $this->session->set_userdata('line_display_name', 'linroy' );       
        
        $set = array(
            	                 'c_no' => '',
            	                 'c_name' => '',
            	                 'set_sort' => 1,
            	                 'line_user_id' => $this->session->userdata('line_user_id'),
            	                 'line_display_name' => $this->session->userdata('line_display_name'),
            	               );
        $params = $this->block_service->activity_push_line(1,$set);
        
       	echo "<pre>".print_r($params,true)."</pre>";
        exit;  
        
        $this->form($checkcode);
        	  
    }
    
    public function deltest()
    {
    	 
    	  $this->front_base_model->delete_table('ap_activity_charge',array('act_id'=>2));
    	  $this->front_base_model->delete_table('ap_question_reply',array('c_type' => 'A','p_no'=>2));
    	  
    	  echo 'delete OK';
    	  exit;
        	  
    }
    
    public function preview($query)
    {
    	          
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->session->set_userdata('line_user_id', '' );
        $this->session->set_userdata('line_display_name', 'TEST' );
        
        $this->form($query,true);        
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
       
       $activity_data = $this->activity_model->find_one('checkcode',$query);       
       if ($activity_data){
       	   $data['query']         = $query;       	   
           $data['view']          = $view;
           $data['data']          = $activity_data;
           $data['dev']           = ''; 
           
           $data['liff_url'] = $this->config->item('line_liff_activity_url');
           
           $this->layout->view('line/liff_activity', $data);
       }else{
       	   alert('操作有誤(Act99)，無活動進行！',base_url());
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
             
             $line_user_data = $this->line_service->get_line_user($data_post['userId'],'',true);
             
             if ($line_user_data['follow'] == 'disable')
             {
             	  $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_activity_url').'/'.$query;
             	  
             	  $result['msg']  = '親愛的來賓您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行相關作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新報到</button>';
             }else{
                 if ($line_user_data)
                 {
                     $activity_data = $this->activity_model->find_one('checkcode',$query);
                     
                     if ($activity_data){
                         $this->session->set_userdata('line_user_id', $data_post['userId'] );
                         $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );
                         
                         $errmsg_data = self::activity_check($query,$activity_data,$data_post['userId'],$line_user_data['display_name']);                         
                        
                         if ($errmsg_data['gourl'] > ''){
                         	   $result['goline'] = $errmsg_data['gourl'];                                    
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
    
    
    public function form($query)
    {     
       $this->load->library('ui');
              
       // 偵側不到 user_id
    	 if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('form/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_activity_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認！',$err_url );    	     
    	     exit;
    	 }    	
    	 
    	 $activity_data = $this->activity_model->find_one('checkcode',$query); 
    
       if ($activity_data)
       {
       	   self::activity_check($query,$activity_data,$this->session->userdata('line_user_id'),$this->session->userdata['line_display_name']);     
       	   
       	   $charge_check = $this->activity_model->charge_check($activity_data['act_id'],$this->session->userdata('line_user_id'));
           
           if ($charge_check['status'] == 'Y'){     
               redirect( 'activity/success/'.$charge_check['checkcode'] ); 
               exit;
           }           
       }else{
       	   alert('活動已結束(ActF01)！',base_url());
    	     exit;
       }
       
       $data['activity_data']                 = $activity_data;
       $data['charge_check']                  = $charge_check;
       //$data['activity_data']['act_config']   = json_decode($activity_data['act_config'], true);                                     
              
       $data['query']         = $query;
       $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
       
       $data['disabled']      = '';
       /*
       if (!$preview){
           /*
           $data['params'] = $this->activity_model->charge_last_data($this->session->userdata('line_user_id')); // 是否有申請過              
       
           if ($data['params']){
       	       $data['disabled'] = ' disabled';
       	       $citydata = $this->front_base_model->get_data('city',array('citytitle' => $data['params']['city'] ),array('cityno'=>'asc'));
       	       if ($citydata){
       	           $data['params']['cityno'] = $citydata[0]['cityno'];
       	           $data['town']  = $this->front_base_model->get_data('town',array('cityno' => $data['params']['cityno'] ),array('postal'=>'asc'));                       	   
       	       }
       	   }       	 
       }
       */
       // $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
      // echo "<pre>".print_r($data,true)."</pre>";
      //exit;
       $this->layout->view('activity_form', $data); 
              
    }  
    
    public function success($charge_checkcode)
    {     
       // 偵側不到 user_id
    	 if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	         if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	         	   $err_url = base_url('form/test');
    	         }else{
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_activity_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認！',$err_url );    	     
    	         exit;    	 
    	 }     
    	 
    	 $charge_check = $this->activity_model->charge_find_one('checkcode',$charge_checkcode);
    	 
    	 $activity_data = $this->activity_model->find_one('act_id',$charge_check['act_id']);
    	 
       if ($activity_data)
       {
       	   $name = $this->session->userdata('line_display_name');
       	   if ($charge_check['c_no'] > ''){
       	       $member_data = $this->front_member_model->find_one('c_no',$charge_check['c_no']);
       	       if ($member_data){
       	       	   $name = $member_data['c_name'];
       	       }
       	   }
       	   
       	   $msg = '親愛的 '.trim($name).' 您好<br> <br>感謝您的參加！';                
        
           self::activity_msg($activity_data,$msg);
       	   
       }else{
       	   alert('活動已結束！',base_url());
    	     exit;
       }
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
                $this->activity_model->charge_update_date_data($areg['l'],'opdt',$data);
            }
        }
        $fileModTime = time();
        header('Content-Type: image/gif');
        header('Last-Modified: ' . gmdate('D, d M Y H:00:00', $fileModTime) . ' GMT'); 
        header('Expires: ' . gmdate('D, d M Y H:00:00', time() + 7200) . ' GMT');
        echo base64_decode('R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');        
        exit;
    }
    
    //
    public function member_check($charge_checkcode)
    {  
    	  $result = array('success' => 0,'html' => '');
                
        $data_post = $this->input->post( NULL, TRUE );         
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {         
             $relation_c_no = $data_post['relation_c_no'];         
             
             $member_data = $this->front_member_model->find_one('c_no',$relation_c_no);
       	     if ($member_data){
       	         $result['success'] = 1;
       	         $name = trim($member_data['c_name']);
       	         $result['html']  = '會員對應 ['.$name.'] 請選擇與會員關係！<br><div class="form-group mx-sm-3 mb-2"><input type="hidden" name="save_relation_c_no" id="save_relation_c_no" value="'.$relation_c_no.'">';             	   
       	         $result['html']  .= '<br><select name="reg_type" id="reg_type" class="form-control" style="width:300px;">';             	   
       	         $result['html']  .= '<option value="">請選擇</option>';
       	         foreach ($this->reg_type as $key => $item){
       	              $result['html']  .= '<option value="'.$key.'">'.$item.'</option>';
       	         }
       	         $result['html']  .= '</select></div>';
       	         $result['html']  .= '<input type="button" class="btn btn-primary mb-2" onclick="save();" style="height: 44px;" value="確認送出">';
       	     }else{
       	         $result['html']  = '無此會員編號對應！';             	   
       	     }
        }        
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);         
        exit;
    }
        
    //資料填寫 - 存檔
    public function reg_save($charge_checkcode)
    {      
        
        // 偵側不到 user_id
    	  if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('activity/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_activity_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫(LS0)！',$err_url );    	     
    	     exit;
    	  } 
    	  
    	  $result = array('success' => 0,'html' => '');
                
        $data_post = $this->input->post( NULL, TRUE );         
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {   
    	      $charge_check = $this->activity_model->charge_find_one('checkcode',$charge_checkcode);
            if ($charge_check)
            {
            		if ($charge_check['status'] == 'N'){
            		    $data = array(
     					 		              "relation_c_no" => $data_post['relation_c_no'],
     					 		              "reg_type" => $data_post['reg_type'],
     					 		              "updt" => date('Y-m-d H:i:s'),  
     					 		              "status" => 'Y',
     					 		              "ip" => $this->data['tracking']['ip'],   		
     					 		              "reg_dt" => date('Y-m-d H:i:s'),
     					 		  );     					 		     					 	     					 		
     					 		  $this->activity_model->charge_update_data($charge_check['id'],$data);    
     					 		  
     					 		  $c_name = '';
     					 		  if ($charge_check['c_no'] > ''){
       	   					    $member_data = $this->front_member_model->find_one('c_no',$charge_check['c_no']);
       	   					    if ($member_data){
       	   					    	   $c_name = $member_data['c_name'];
       	   					    }
       	   					}
     					 		  
     					 		  
     					 		      $set = array(
            	                     'c_no' => $charge_check['c_no'],
            	                     'c_name' => $c_name,
            	                     'set_sort' => 1,
            	                     'line_user_id' => $charge_check['user_id'],
            	                     'line_display_name' => $charge_check['display_name'],
            	                   );
                        
            	          $msg = $this->block_service->activity_push_line($charge_check['act_id'],$set);            	                					 		  
            	      
            		}
            		$result['success'] = 1;
            		$result['gourl'] = base_url('activity/success/'.$charge_check['checkcode']);            	              
            }            
        }
        $this->output->set_content_type('application/json');            
        echo json_encode($result);         
        exit;
    }    
    
    private function activity_check($query,$activity_data,$user_id,$display_name)
    {
    	  
    	  $result = array('status' => false, 'errmsg' => ''); 

        if (strtotime($activity_data['act_start']) > strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此活動尚未開始(ACT1)！";
        }elseif(strtotime($activity_data['act_end']) < strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此活動已經結束(ACT2)！";
        }else
        {
         	  $line_id_data = $this->Member_line_model->find_one('user_id',$user_id);  // 是否為會員
         	  
         	  $charge_check = $this->activity_model->charge_check($activity_data['act_id'],$user_id);
                
            $send_line_push = false;
            
            $c_no = '';
            $c_name = '';
            if ($line_id_data){
            	  $c_no = $line_id_data['c_no'];
            	  $c_name = $line_id_data['c_name'];
            }
            
            if ($charge_check){
                if ($charge_check['status'] == 'Y'){ // 已報到成功
                	  $result['gourl'] = base_url('activity/success/'.$charge_check['checkcode']);
            	      $result['errmsg'] = 'redirect';
                }else{
            	      if ($line_id_data){
            	      	  $data = array(
     					 		              "c_no" => $c_no,
     					 		              "display_name" => $display_name,
     					 		              'reg_type' => '1',
     					 		              "status" => 'Y',
     					 		              "ip" => $this->data['tracking']['ip'],
     					 		              "updt" => date('Y-m-d H:i:s'),     				
     					 		              "reg_dt" => date('Y-m-d H:i:s'),	 		              
     					 		      );     					 		     					 	     					 		
     					 		      $this->activity_model->charge_update_data($charge_check['id'],$data);            	      	
     					 		      $result['gourl'] = base_url('activity/success/'.$charge_check['checkcode']);            	           					 		      
            	          $result['errmsg'] = 'redirect';
            	          $send_line_push = true;
            	      }else{
            	      	  $result['gourl'] = base_url('activity/form/'.$query);
            	          $result['errmsg'] = 'redirect';
            	      }
            	  }
            }else{            	
                $charge_checkcode = uniqid();
                
                $data = array(
     					 	              "act_id"    => $activity_data['act_id'],
     					 	              "user_id"	=> $this->session->userdata('line_user_id'),
     					 	              "display_name" => mb_substr($this->session->userdata('line_display_name'),0,20),       				    
     					 	              "reg_dt" => date('Y-m-d H:i:s'),     					 		           
     					 	              "checkcode" => $charge_checkcode,
     					 	              "updt" => date('Y-m-d H:i:s'),  
     					 	              "ip" => $this->data['tracking']['ip'],     					 		              
     					 	);     					 		     					 	
     					 	
     					 	if ($line_id_data){
     					 		  $data['c_no'] = $c_no;
     					 		  $data['status'] = 'Y';
     					 		  $data['reg_type'] = '1';
     					 		  $result['gourl'] = base_url('activity/success/'.$charge_checkcode);            	      
            	      $result['errmsg'] = 'redirect';
            	      $send_line_push = true;
     					 	}else{
     					 		  $data['status'] = 'N';
     					 		  $result['gourl'] = base_url('activity/form/'.$query);
            	      $result['errmsg'] = 'redirect';
     					 	}
     					 	$data['crdt']	= date('Y-m-d H:i:s');
     					 	$this->db->insert('ap_activity_charge', $data);
            }
            
            if ($send_line_push){  // Line 問卷推播
            	  
            	  	  $set = array(
            	  	                 'c_no' => $c_no,
            	  	                 'c_name' => $c_name,
            	  	                 'set_sort' => 1,
            	  	                 'line_user_id' => $this->session->userdata('line_user_id'),
            	  	                 'line_display_name' => $this->session->userdata('line_display_name'),
            	  	               );
            	  	  $this->block_service->activity_push_line($activity_data['act_id'],$set);            	               
            	  
            }
        }
        return $result;
    }
    
    private function activity_msg($activity_data,$msg)
    {
    	  
    	  $data['msg'] = $msg;
    	  
    	  $data['activity_data'] = $activity_data;
    	  
    	  $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
   
        $this->layout->view('activity_msg', $data);
        
    } 
            
}       