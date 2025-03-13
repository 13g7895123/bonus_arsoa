<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consent extends MY_Controller
{
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
        $this->load->model( 'Consent_model' );   
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
                
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
    
    /*
        http://localhost/arsoa/consent/test
    */
    public function test($checkcode = '71pp1uJq9')
    {
    	 
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' );
        $this->session->set_userdata('line_display_name', 'linroy' );       
        
        $this->form($checkcode);
        	  
    }
    
    public function pdf($id,$charge_checkcode)
    {
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $charge_check = $this->Consent_model->charge_find_one('checkcode',$charge_checkcode);
        if ($charge_check){
            if ($charge_check['id'] = $id){
                $consent_data = $this->Consent_model->find_one('c_id',$charge_check['c_id'],true);
                
                $c_name = '';
                $member_data = $this->front_member_model->find_one('c_no',$charge_check['c_no']);
       				  if ($member_data){       					  
       				      $c_name = $member_data['c_name'];
       				  }
       				    	  
                require_once APPPATH.'third_party/tcpdf/tcpdf.php';
                
                $this->load->library('tcpdf');
                
                $pdf = new TCPDF(); // 创建一个TCPDF实例
                
                // 设置PDF文档属性
                $pdf->SetCreator(FC_Web);
                $pdf->SetAuthor(FC_Web);
                $pdf->SetTitle($consent_data['c_id'].'_'.$consent_data['c_title']);
                $pdf->SetSubject($consent_data['c_title']);
                
                // 添加一页PDF内容
                $pdf->AddPage();
                
                $imageFile = APPPATH.'public/images/logo.png';
                
                $pdf->Image($imageFile, 78, 20, 50, 0, 'PNG');
                
                $pdf->SetFont('msungstdlight', '', 12);
                $html = '<br><br><br><br><br><br><h1>'.$consent_data['c_title'].'</h1><br><br><div style="border:1px #ccc solid;padding: 20px;text-align: center;"> <br> <br><div style="width:95%;text-align: left;">  '.str_replace(array("\n"),'<br>  ',$consent_data['c_body']).'</div></div>';
                
                $c_config  = json_decode($consent_data['c_config'], true);                             
                $html .= '<br>';
                $html .= ''.$c_config['agree_desc']; //☑  [ V ] 
                $html .= '<br>';
                $html .= '<br>';
                $html .= '會員編號：'.$charge_check['c_no'];
                $html .= '<br>';
                $html .= '會員姓名：'.$c_name;
                $html .= '<br>';
                $html .= '同意時間：'.$charge_check['agree_dt'];
                $html .= '<br>';
                
                
                
                $pdf->writeHTML($html, true, false, true, false, '');
                
                // 输出PDF
                $pdf->Output($charge_check['c_no'].'_'.$c_name.'.pdf', 'I');
            }else{
            	  echo '操作有誤'; 
            }
        }else{
        	  echo '操作有誤';    
        }
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
       
       $consent_data = $this->Consent_model->find_one('checkcode',$query);     
       
       if ($consent_data){
       	   $data['query']         = $query;       	   
           $data['view']          = $view;
           $data['data']          = $consent_data;
           $data['dev']           = ''; 
           
           $data['liff_url'] = $this->config->item('line_liff_consent_url');
          
           $this->layout->view('line/liff_consent', $data);
       }else{
       	   alert('操作有誤(Con99)，無活動進行！',base_url());
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
             	  $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_consent_url').'/'.$query;
             	  
             	  $result['msg']  = '親愛的來賓您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行相關作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新進入</button>';
             }else{
                 if ($line_user_data)
                 {
                     $consent_data = $this->Consent_model->find_one('checkcode',$query);
                     
                     if ($consent_data){
                         $this->session->set_userdata('line_user_id', $data_post['userId'] );
                         $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );
                         
                         $errmsg_data = self::consent_check($query,$consent_data,$data_post['userId'],$line_user_data['display_name']);                         
                        
                         if (!$errmsg_data['status']){
                         	   if ($errmsg_data['errmsg'] == 'redirect'){
                                 
                             }else{
                                 $result['msg'] = str_replace("\\n",'<br>',$errmsg_data['errmsg']);
                             }
                         	   if ($errmsg_data['gourl'] > ''){
                         	   	   $result['goline'] = $errmsg_data['gourl'];                                    
                         	   }
                         	   
                         }else{                             
                             $result['goline'] = base_url('consent/form/'.$query);                                    
                             $result['success'] = 1;
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
              
       if (!$preview){
           // 偵側不到 user_id
    	     if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	         if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	         	   $err_url = base_url('form/test');
    	         }else{
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_consent_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認！',$err_url );    	     
    	         exit;
    	     }    	
    	 }     
    	 $consent_data = $this->Consent_model->find_one('checkcode',$query,$preview); 
    	
       if ($consent_data)
       {
       	   if (!$preview){
           			$errmsg_data = self::consent_check($query,$consent_data,$this->session->userdata('line_user_id'),$this->session->userdata('line_display_name'));           
           			if (!$errmsg_data['status']){     
           			    if ($errmsg_data['gourl'] > ''){
           			        if ($errmsg_data['errmsg'] == 'redirect'){
           			            redirect( $errmsg_data['gourl'] );
           			        }else{
           			            alert($errmsg_data['errmsg'],$errmsg_data['gourl']);
           			        }
           			    }else{
           			        alert($errmsg_data['errmsg'],base_url());                       	
           			    }
           			    exit;
           			}else{
           				  $data['charge_data'] = $errmsg_data['charge_data'];
           				  $up_data = array(
           				                    'opdt' => date('Y-m-d H:i:s'),
           				                  );
           				  if ($data['charge_data']['checkcode'] == ''){
           				  	  $checkcode = generatorPassword(6).$data['charge_data']['id'].generatorPassword(6);
           				  	  $up_data['checkcode'] = $checkcode;
           				  	  $data['charge_data']['checkcode'] = $checkcode;
           				  }
           				  if ($data['charge_data']['status'] == 'N'){
           				  	  $up_data['status'] = 'O';
           				  }
                    $this->Consent_model->charge_update_data($data['charge_data']['id'],$up_data);
           			}
           }else{
           	   $data['charge_data']['checkcode'] = 'preview';
           }
       }else{
       	   alert('活動已結束！',base_url());
    	     exit;
       }
       
       $data['consent_data']                 = $consent_data;                  
       $data['consent_data']['c_config']   = json_decode($consent_data['c_config'], true);                             
       
              
       $data['query']         = $query;
       $data['preview']       = $preview;
       $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
       
       $data['disabled']      = '';
     
       $this->layout->view('consent', $data);     
    
    }  
            
    // 存檔
    public function save($charge_checkcode)
    {      
        
        // 偵側不到 user_id
    	  if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('consent/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_consent_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫(CS0)！',$err_url );    	     
    	     exit;
    	  } 
    	              
    	  $charge_check = $this->Consent_model->charge_find_one('checkcode',$charge_checkcode);
        if ($charge_check)
        {
            if ($charge_check['status'] == 'Y')
            {
            	  alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您已確認，無法重新確認；如有問題，請洽客服(CS1)！",base_url());
    	 					exit;            
            }
        }else{
            alert( '抱歉，您的操作有誤，若有任何問題，請洽客服(CS2)！',base_url());   
    	      exit;
        }
        $data_post = $this->input->post( NULL, FALSE );        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {  
             if ($data_post['agree'] == 'Y'){                  
                  $consent_data = $this->Consent_model->find_one('c_id',$charge_check['c_id'],true); 
                  
                  $agree_data = array(
                                      'c_title' => $consent_data['c_title'],
                                      'c_desc' => $consent_data['c_desc'],
                                      'c_body' => $consent_data['c_body'],
                                      );
                  
                  $up_data = array(
                                    'agree_dt'	=> date('Y-m-d H:i:s'),
                                    'ip'				=> $this->data['tracking']['ip'],
                                    'status'		=> 'Y',        
                                    'agree_data' => json_encode($agree_data)
                                  );                  
                  $this->Consent_model->charge_update_data($charge_check['id'],$up_data);
                  
             }
     		}
     		
        $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好<br> <br>感謝您的確認！';                
        
        self::consent_msg($charge_checkcode,$msg);
    }    
    
    private function consent_check($query,$consent_data,$user_id,$display_name)
    {
    	  
    	  $result = array('status' => false,'gourl' => '', 'errmsg' => ''); 

        if (strtotime($consent_data['c_start']) > strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "尚未開始(CE1)！";
        }elseif(strtotime($consent_data['c_end']) < strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "已經結束(CE2)！";
        }else
        {
         	  $consent_data['c_config']   = json_decode($consent_data['c_config'], true);     
         	  
            if ($result['errmsg'] == ''){
                $charge_check = $this->Consent_model->charge_check($consent_data['c_id'],$user_id);
                
                if ($consent_data['c_config']['charge'] == 'Y'){  // 有在名單才可以
            	      if (!$charge_check){
            	      	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n非限定名單無法參加；如有問題，請洽客服(CE6)！";
            	      }
            	  }
            	   	  
            	  if ($result['errmsg'] == '' && $charge_check){
            	  	  if ($charge_check['status'] == 'N' || $charge_check['status'] == 'O'){
            	  	  	  $result['charge_data'] = $charge_check;
            	  	  }else{
            	          $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n已於 ".$charge_check['agree_dt']." 確認！\\n\\n無法重新確認；如有問題，請洽客服(CE7)！";
            	      }
                }
            }
            
            if ($result['errmsg'] == ''){
            	  $result['status'] = true; 
            }
        }      
       
        return $result;
    }
    
    private function consent_msg($query,$msg)
    {
    	  
    	  $data['msg'] = $msg;
    	  
    	  $data['query'] = $query;
    	  
    	  $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
   
        $this->layout->view('lottery_msg', $data);
        
    } 
    
}       