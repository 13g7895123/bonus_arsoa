<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends MY_Controller
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
        $this->load->model( 'line_link_model' );
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
                
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        
    /*
        http://localhost/arsoa/lottery/test
    */
    public function test($checkcode = 'iut82NxsE')
    {
    	 
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' );
        $this->session->set_userdata('line_display_name', 'linroy' );       
        
        $this->form($checkcode);
        	  
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
       
       $data = $this->line_link_model->find_one('checkcode',$query);       
       if ($data){
       	   $data['query']         = $query;       	   
           $data['view']          = $view;
           $data['data']          = $data;
           $data['dev']           = ''; 
           
           $data['liff_url'] = $this->config->item('line_liff_link_url');
           
           $this->layout->view('line/liff_link', $data);
       }else{
       	   alert('操作有誤(Link99)，無活動進行！',base_url());
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
             	  $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_link_url').'/'.$query;
             	  
             	  $result['msg']  = '親愛的來賓您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行相關作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新連結</button>';
             }else{
                 if ($line_user_data)
                 {
                     $lottery_data = $this->line_link_model->find_one('checkcode',$query);
                     
                     if ($lottery_data){
                         $this->session->set_userdata('line_user_id', $data_post['userId'] );
                         $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );
                         
                         $errmsg_data = self::link_check($query,$lottery_data,$data_post['userId'],$line_user_data['display_name']);                         
                        
                         if (!$errmsg_data['status']){
                         	   if ($errmsg_data['errmsg'] == 'redirect'){
                                 
                             }else{
                                 $result['msg'] = str_replace("\\n",'<br>',$errmsg_data['errmsg']);
                             }
                         	   if ($errmsg_data['gourl'] > ''){
                         	   	   $result['goline'] = $errmsg_data['gourl'];                                    
                         	   }
                         	   
                         }else{                             
                             $result['goline'] = base_url('link/form/'.$query);                                    
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
    	         	   $err_url = base_url('link/test');
    	         }else{
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_link_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認！',$err_url );    	     
    	         exit;
    	     }    	
    	 }     
    	 $data = $this->line_link_model->find_one('checkcode',$query,$preview); 
    	
       if ($data)
       {
       	   if (!$preview){
           			$errmsg_data = self::link_check($query,$data,$this->session->userdata('line_user_id'),$this->session->userdata('line_display_name'));           
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
           			}
           }
       }else{
       	   alert('連結已失效！',base_url());
    	     exit;
       }
       
       $data['data']                 = $data;           
       $data['data']['link_data']     = json_decode($data['link_data'], true);       
              
       $data['query']         = $query;
       $data['preview']       = $preview;
       $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
       
       $data['disabled']      = '';
       
       echo $this->load->view('line/link', $data, TRUE); 
       exit;
       
    }  
    
    private function link_check($query,$lottery_data,$user_id,$display_name)
    {
    	  
    	  $result = array('status' => false,'gourl' => '', 'errmsg' => ''); 

        if (strtotime($lottery_data['link_start']) > strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此連結尚未開始(LI1)！";
        }elseif($lottery_data['link_end'] != '0000-00-00 00:00:00' && strtotime($lottery_data['link_end']) < strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此連結已經結束(LI2)！";
        }else
        {
         	  $lottery_data['lot_data']     = json_decode($lottery_data['lot_data'], true);       
         	  $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
         	  
         	  if ($lottery_data['link_member'] == 'Y'){  // 會員才可以
         	      $line_id_data = $this->Member_line_model->find_one('user_id',$user_id);                     	   
                if (!$line_id_data)
                {
                	  $result['errmsg'] = "親愛的 ".$display_name." 您好：非安露莎綁定會員無法使用；請先登入綁定！";
                	  $result['gourl'] = base_url('member/login').'?rdurl=https://liff.line.me/'.$this->config->item('line_liff_link_url').'/'.$query;                	  
                }   
            }
          
            if ($result['errmsg'] == ''){
            	  $result['status'] = true; 
            }
        }      
       
        return $result;
    }
    

}       