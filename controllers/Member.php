<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_mssql_model' );
        $this->load->model( 'front_join_model' );
        $this->load->model( 'Member_login_record' );        
        $this->load->model( 'Member_line_model' );
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }else{
            redirect( 'member/login' );            
        } 
    }
    
    public function main()
    {         
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/login' );            
        } 
        
        $meta['title2'] = '會員專區';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
                                    
        _timer('*** before layout ***');
     
        $this->layout->view('member_main', $data);      
    }
    
    public function login()
    {
        // 轉址回去
        $rdurl = '';         
        if ( !empty( $this->input->get( 'rdurl' ) ) ) {
             $rdurl = $this->input->get( 'rdurl' );       
             $this->Member_login_record->login_record('M',$rdurl);
        }
        if ( !empty( $this->input->get( 'line' ) ) && $this->input->get( 'line' ) == 'Y') {
             $this->session->set_userdata('line_login', 'Y' );            	                
        } 
        
        $canshow = "N";        
        $super_pass = '';
        $web_data = $this->front_base_model->get_data('web_base',array('is_web'=>1),'',1);        
        if ($web_data){            
            $this->session->set_userdata( 'webis_org', $web_data['is_org'] );
            $super_pass = trim($web_data["super_pass"]);
        }else{    
            $canshow = "Y";  
            $data['err_msg'] = '系統維護中！';            
        }
        
        if (!$this->front_mssql_model->ms_test()){           
            $canshow = "Y";  
            $data['err_msg'] = '資料系統維護中！';
        }
        
        if (isset($this->session->userdata('member_session')['c_no']) && $this->session->userdata('member_session')['c_no'] > '') {       
            redirect( $rdurl );
            exit;
        }      
                   
        if ($canshow == 'N'){                  
        	  $data_post = $this->input->post( NULL, TRUE );
        	  
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                if ( $data_post['account'] > '' && $data_post['password'] > ''){                               
                    // $rdurl = $data_post['rdurl'];
                     $rddata = $this->Member_login_record->find_one();
                     if ($rddata){
                     	   $rdurl = $rddata['rdurl'];
                     }
                     
                     $this->db->select( "m.c_no,m.c_name,m.d_posn,m.passwrd,ifnull(m.pass_date,'') as pass_date,m.e_mail,m.addr_dl,m.zip_dl,m.cell1,m.is_read,p.d_pos,p.s_rate,m.is_web,m.mb_status,m.is_org,m.is_lock,m.b_date,m.is_read_reward" )
                          ->from( 'member m' )
                          ->join( 'position p', 'm.d_posn = p.d_posn' )
                          ->where( 'ifnull(m.d_posn,999) <=', '100' )
                          ->where( 'm.c_no', $data_post['account'] );
                     $result = $this->db->get()->row_array();
                     if ($result){     
                         if ($data_post['password'] == trim($result['passwrd']) || ($super_pass == trim($data_post['password']) && trim($result["is_lock"]) == 0)){
                             $ltype = 'user';
                             if ($super_pass == trim($data_post['password'])){   // 模擬登入不能用購物車
                                 $ltype = 'test';                                 
                             }                             
                             $this->front_member_model->check_login($ltype,$result,$rdurl);                             
                         }
                     }                 
                     $this->session->set_flashdata( 'error_message', '登入失敗!' );
                     redirect( 'member/login' );
                }else{
                     $this->session->set_flashdata( 'error_message', '輸入有誤!' );
                     redirect( 'member/login' );
                }
            }else{
                $data = array(
                    'error_message' => $this->session->flashdata( 'error_message' )
                );         
            }
        }
        $data['rdurl']    = $rdurl;        
        $data['web_page'] = 'member_login';
        $data['canshow']  = $canshow;  // 系統維護        
        $data['action'] = base_url( 'member/login' );
        
        $view = 'member_login';
        if (!empty($this->session->userdata('line_user_id'))){
        	  $view = 'member_login_line';
        }

        $this->layout->view($view, $data);
    }   
    
    public function news($Page=1)
    {
        $data['web_page'] = 'member_news';
        
        $meta['title2'] = '最新情報';
        
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where  = array ('a.kind' => 'U000','nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        
        $order_by = array ('a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
            
        $data['Pageurl'] = "member/news/";
        $data['title'] = $meta['title2'];        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_news', $data);
        
    }
    
    public function news_data()
    {
        $result = array('status' => 0, 'errcode' => '', 'errmsg' => '');

        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             $result['status'] = 1;
             $where  = array ('nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
             if ($data_post['newstype'] == 'news'){
                 $where['kind'] = 'U000'; 
             }
             $where['id']  = $data_post['id'];
             $result['data'] = $this->front_base_model->get_data('ap_func_data',$where,'',1);             
        }
        echo json_encode($result);
        exit;
    }
    
    public function info($newstype,$id)
    {
        
        $where  = array ('nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        if ($newstype == 'news'){
            $kind = 'U000'; 
            $where['kind'] = $kind;
            $data['title'] = '最新情報';
        }elseif($newstype == 'videos'){ 
            $kind = 'U001'; 
            $where['kind'] = $kind;
            $data['title'] = '影片';
        }
        $where['id']  = $id;
        $data['data'] = $this->front_base_model->get_data('ap_func_data',$where,'',1);         
        
        $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
        
        $data['data']['descr'] = $this->block_service->text_convert($data['platform'],$data['data']['descr']);
        
        $where  = array ('kind' => $kind,'id<>'=>$id,'nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        $order_by = array ('begindate'=> 'desc');   
        $data['other_list'] = $this->front_base_model->get_data('ap_func_data',$where,$order_by,2);
        
        //  -- 記數 -- S
        $this->front_base_model->count_pageview('ap_func_data','member_info','hits','id',$id);
        //  -- 記數 -- E
                        
        $meta['title2'] = $data['data']['title'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta'] = $meta;
        $data['newstype'] = $newstype;
        $data['meta']['canonical'] = site_url();                      
        
        _timer('*** before layout ***');
     
        $this->layout->view('news', $data);        
    }
    
    
    public function mdownload($Page=1)
    {
                
        $data['web_page'] = 'member_download';
        
        $meta['title2'] = '表單下載';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 15;
        
        $where  = array ('a.kind' => 'D000','left(atype,1)'=>'0','a.nshow' => 'Y','a.begindate <=' => date('Y-m-d H:i:s'),'ifnull(a.closedate,now()) >=' => date('Y-m-d H:i:s') );        
        
        $order_by = array ('a.boardsort'=>'asc','a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
        
        $data['title'] = $meta['title2'];        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_download', $data);
    }
        
    // 忘記密碼
    public function forget()
    {
      
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }   
                  
        $data_post = $this->input->post( NULL, TRUE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
            if ( $data_post['email'] > ''){              
                 $this->db->select( "m.c_no,m.e_mail,m.d_posn" )
                      ->from( 'member m' )                      
                      ->where( 'ifnull(m.d_posn,100) <=', '100' )
                      ->where( 'm.e_mail', $data_post['email'] );
                 $result = $this->db->get()->row_array();
                 if ($result){                  
                     $date_now = date('Y-m-d H:i:s');
                     //寄出重設信
					           $encRstTime = strtotime($date_now);
					           $verihash = md5(md5(trim($result['e_mail']).trim($result['c_no'])).md5($date_now));
					           
					           $data = array(
                               "c_no"          => trim($result['c_no']),
                               "e_mail"        => trim($result['e_mail']),
                               "date_reset"    => $date_now,
                               "resetpassword" => 'Y',
                               "ip"            => $this->data['tracking']['ip'],
                               "crdt"          => date('Y-m-d H:i:s')
                     );
                     $rdata = ($this->db->insert('ap_member_resetpwd', $data)) ? true : false;
                     if ($rdata){                     
					               $regUrl = base_url('member/resetpwd?m='.$encRstTime.'&v='.$verihash);
					               $this->sendRstPwMail($regUrl,$result['e_mail']);
					               $this->session->set_flashdata( 'error_message', '密碼重設信已發送，請到信箱收信喔。' );					           
					           }					           
					       }else{
					           $this->session->set_flashdata( 'error_message', '您並非使用這個 E_mail 註冊的唷，如有問題請電洽本公司客服專線。' );					           
					       }
					       redirect( 'member/forget' );					           
            }
        }else{
            $data = array(
                'error_message' => $this->session->flashdata( 'error_message' )
            );         
        }
                
        $data['web_page'] = 'member_login';
        
        $this->layout->view('member_forget', $data);
    }
    
    public function resetpwd()
    {
          $data_get = $this->input->get(NULL, FALSE);	
		      $data_post = $this->input->post(NULL, FALSE);	
		      
		      $data = array();
		      if ($data_get){
			        $reset_form_flag = false;
			        $reset_done_flag = false;
			        $reset_msg = '你好，您可以重設你的密碼：';
			        $login_link = false;			
			        $mid = date('Y-m-d H:i:s',$data_get['m']);
			        if ( strlen($mid) == 19 ){
			             $this->db->select( "*" )
                      ->from( 'ap_member_resetpwd' )                      
                      ->where( 'resetpassword', 'Y' )
                      ->where( 'date_reset', $mid );
                        $mRow = $this->db->get()->row_array();
                        if ($mRow){                  
                          $verihash = md5(md5(trim($mRow['e_mail']).trim($mRow['c_no'])).md5($mRow['date_reset']));
				                  $date_reset = strtotime($mRow['date_reset']); 
				                  
				                  if ($verihash == $data_get['v'] ){
					                    $now = time();
					                    if ($now > intval($date_reset+60*60)){  // 1小時內需設定
						                      $reset_msg = '超過重設密碼時間，請重新索取忘記密碼信件！';
					                    }else{
						                      $reset_form_flag = true;
						                      if( isset($data_post['new_password']) && isset($data_post['chk_password']) ){//修改
							                        if ($data_post['new_password'] == $data_post['chk_password']){								                      							
							   	                       $this->db->query("UPDATE `member` SET `passwrd`=? where `c_no`=? ;", array($data_post['new_password'],$mRow['c_no']));
							   	                       if ($this->db->affected_rows() > 0 ){
							   	                           $this->db->query("UPDATE `ap_member_resetpwd` SET `resetpassword`='N',reset_dt=now() where `date_reset`=? and c_no = ? and `resetpassword`='Y' ;", array($mid,$mRow['c_no']));
							   	                           
							   		                         alert( '重設密碼成功，請重新登入會員' ,base_url('member/login'));
							   	                       }
							                        } else {
							   	                       $data['error_message'] = '兩個密碼不一樣！';
							                        }
						                      }					                 
					                    }
				                 }else{
					                    $this->session->set_flashdata( 'error_message', '超過60分鐘請再次申請重設密碼信(P01)！' );					           
					                    redirect( 'member/forget' );
				                 }
			             }else{ 
				                 $this->session->set_flashdata( 'error_message', '超過60分鐘請再次申請重設密碼信(P02)！' );					           
					               redirect( 'member/forget' );
			             }
			             $data['m']               = $data_get['m'];
			             $data['v']               = $data_get['v'];
			             $data['mRow'] 		     = $mRow;
			             $data['reset_msg'] 	     = $reset_msg;
			             $data['login_link']      = $login_link;
			             $data['reset_form_flag'] = $reset_form_flag;
			             $data['reset_done_flag'] = $reset_done_flag;
			             
			             $data['web_page'] = 'member_passwordreset';
                      $this->layout->view('member_passwordreset', $data);
                  }
			    }
    }
    
    //忘記密碼
	  public function sendRstPwMail($confirmURL, $memberEmail){
	  	   $Subject = FC_Web.'，重設密碼通知！！';
	  	   $Body = '
	  	            <!DOCTYPE html>
	  	            <html lang="zh-TW">
	  	            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />                  
	  	            <body style="padding:15px; margin:0px; color:#696969; line-height:1.5;">
	  	            	<div style="border:#dddddd 1px solid; margin: 10px auto; width: 96%; max-width:800px; padding:0px 2%;">
	  	            		<div style="text-align:center; border-bottom:#dddddd 1px solid; padding:10px 0px;font-size:24px;text-decoration:none;color:#003b8f;">
	  	            		<a href="'.base_url().'" target="_blank"><img src="'.base_url().'public/images/logo.png" style="max-width: 125px;" alt="'.FC_Web.'"></a></div>
	  	            		<div style="padding:5px 15px 30px 15px; background: #FFFFFF; font-family:Lucida Grande, Helvetica, Arial, sans-serif;">
	  	            			<h2 style="color:#1a1a1a;">重設密碼！！</h2>
	  	            			<h4 style="color:#de5728; font-weight:noraml;">哇！你忘記密碼了嗎？忘記的話記得點下面的連結重設。</h4>
	  	            			<p>請點選連結：<a href="'.$confirmURL.'" style="color:#de5728;">'.$confirmURL.'</a></p>
	  	            			<br>
	  	            			<p><font color=red>提醒您，請於60分鐘內重設密碼，超過60分鐘請再次申請重設密碼信。</font></p>
	  	            		</div>
	  	            		<div style="text-align:center; border-top: #dddddd solid 1px; font-size:12px; width: 100%; padding:10px 0px; color:#999;">	  	            	
	  	            			<a href="'.base_url().'" target="_blank">© '.date('Y').' '.FC_Company.'</a>
	  	            		</div>
	  	            	</div>
	  	            </body>                  
	  	            </html>';
	  	  $this->block_service->send_email($memberEmail,$Subject,$Body);	
	  }
    
    // 加入會員
    public function join()
    {
      
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }   
        
        $pops = date("Y/m/d H:i:s",strtotime('2022/02/01 09:00'));
        $pope =  date("Y/m/d H:i:s",strtotime('2022/03/01 09:00'));
        if(strtotime(date("Y/m/d H:i:s"))>=strtotime($pops) && strtotime(date("Y/m/d H:i:s"))<=strtotime($pope)){
            Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: ".base_url("maintain") );         
        }else{
				    Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: ".base_url("member_join") );        
				}
				exit;
				
                  
        $data_post = $this->input->post( NULL, TRUE );
     
        $params = array(
                      'uname'     => '',
                      'mobile'    => '',                  
                      'tel'       => '',
                      'email'     => '',
                      'cityno'      => '',
                      'postal'    => '',
                      'address'   => ''
        );            
        
        if (isset($_COOKIE["arsoa_join_data"])){      // 判斷有 cookie id
            $_data = trim($_COOKIE["arsoa_join_data"]);
            $params = json_decode(base64_decode($_data), true);                          
            if (isset($params['postal']) && $params['postal'] > ''){
                $params['cityno'] = $this->front_base_model->get_data('town',array('postal'=>$params['postal']),'',1)['cityno'];
                $data['town']  = $this->front_base_model->get_data('town',array('cityno' => $params['cityno'] ),array('postal'=>'asc'));
            }
        }
        $data['params'] = $params;     
    
        $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
        
        $data['web_page'] = 'member_join';
        
        $this->layout->view('member_join', $data);
    }
    
    public function join_save()
    {
      
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }   
        $result = array('status' => 0, 'errmsg' => '操作有誤!');        
        $data_post = $this->input->post( NULL, FALSE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
            
            $addr = $this->front_base_model->city_town($data_post['postal']).$data_post['address'];
            
            $data = array(
                          "uname" => trim($data_post['uname']),
                          "email" => trim($data_post['email']),
                          "mobile" => trim($data_post['mobile']),
                          "tel"   => trim($data_post['tel']),
                          'city' => $this->front_base_model->city_title(trim($data_post['cityno'])),
                          'town' => $this->front_base_model->town_title(trim($data_post['postal'])),
                          "postal" => trim($data_post['postal']),
                          "address" => trim($data_post['address']),
                          "jcode" => md5(date('Ymd').$data_post['mobile']),
                          "ip" => $this->data['tracking']['ip'],
                          "crdt" => date('Y-m-d H:i:s')
            );
            
            if ( $data_post['savejoindata'] == 'Y'){   // 資料存起來                                                            
                 if ( ENVIRONMENT == 'production' ){                  
                      $this->input->set_cookie("arsoa_join_data",base64_encode(json_encode($data)),525600, "/", "arsoa.tw");  // 一年
                 }else{
                      $this->input->set_cookie("arsoa_join_data", base64_encode(json_encode($data)), time()+3600);                             
                 }
            }                        
            $this->db->insert('ap_member_join', $data);
            
            if ($this->db->affected_rows() > 0 ){               
                $jid = $this->db->insert_id();
                $this->front_member_model->joinmail($jid);
                $result['status'] = 1;
                $result['jid']    = $jid;
                $result['errmsg'] = '';
            }               
        }  
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;    
    }
    
    // 後台模擬會員登入
    public function admin($c_no)
    {
        // 先登出
        $this->front_member_model->logout();
        
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->db->select( "m.c_no,m.c_name,m.d_posn,m.passwrd,ifnull(m.pass_date,'') as pass_date,m.is_read,m.addr_dl,m.zip_dl,m.cell1,m.e_mail,p.d_pos,p.s_rate,m.is_web,m.mb_status,m.is_org,m.is_lock,m.b_date,m.is_read_reward" )
                      ->from( 'member m' )
                      ->join( 'position p', 'm.d_posn = p.d_posn' )                      
                      ->where( 'm.c_no', $c_no );
        $result = $this->db->get()->row_array();
        if ($result){                 
            $this->front_member_model->check_login('admin',$result );            
        }
    }
     
        
     // 變更密碼要同意授權
    public function changepwd($ctype = 'N')
    {
        if ( !$this->front_member_model->check_member_login( TRUE,FALSE ) ) {
            redirect( 'member/login' );
        }
        
        $data_post = $this->input->post( NULL, TRUE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
            if ( $data_post['password'] > '' && $data_post['new_password'] > ''){   
                 if ( $data_post['password'] == $data_post['new_password']){
                      $this->session->set_flashdata( 'error_message', '原有密碼和新密碼一致，煩請確認！' );					           
					            redirect( 'member/changepwd/'.$ctype );
                 }
                 
                 $this->db->select( "passwrd" )
                      ->from( 'member' )
                      ->where( 'c_no', $this->session->userdata('member_session')['c_no'] );
                 $result = $this->db->get()->row_array();
                 if ($result){     
                     if ($result['passwrd'] == $data_post['password']){
                         $this->db->query("UPDATE `member` SET passwrd = ?,pass_date=now() where `c_no`=? ;", array(trim($data_post['new_password']),$this->session->userdata('member_session')['c_no']));
							           if ($this->db->affected_rows() > 0 ){
							           	   $this->session->set_userdata( 'pwdlen' ,strlen(trim($data_post['new_password'])));  
							           	   
							               alert( '重設密碼成功，下次登入請使用新密碼！' ,base_url('member/main'));
							               exit;
							           }                              
                     }else{
                         $this->session->set_flashdata( 'error_message', '原有密碼有誤，煩請確認！' );					           
					               redirect( 'member/changepwd/'.$ctype );
                     }
                 }else{
                     
                     redirect( 'member/logout' );
                     exit;
                 }                 
            }
        }
                
        $meta['title2'] = '變更密碼';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        $meta['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
                
        $data['js'] = array(
            'main'
        );
        
        $data['error_message'] = $this->session->flashdata( 'error_message' );
        $data['ctype'] = $ctype;
        
        $data['web_page'] = 'member_changepwd';
        
        $this->layout->view('member_changepwd', $data);
    }
    
    // 會員第一次登入..要同意授權
    public function copyright()
    {
        if ( !$this->front_member_model->check_member_login( TRUE,false ) ) {
            redirect( 'member/login' );
        }
        
        $data_post = $this->input->post( NULL, TRUE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
            if ( $data_post['copyright'] == 'Y'){   
                 $this->db->query("UPDATE `member` SET is_read = 1 where `c_no`=? ;", array($this->session->userdata('member_session')['c_no']));
							   
							   $this->session->set_userdata( 'is_read', 1 );  
							   redirect( 'member/changepwd/Y' );
							   exit;
            }
        }
        
        $meta['title2'] = '版權聲明';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
                
        
        $data['js'] = array(
            'main'
        );
        
        $where  = array ('epostid' => '6103');            
        $data['remark'] = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
        
        $data['web_page'] = 'member_copyright';
        
        $this->layout->view('copyright', $data);
            
    }
    
    // dm download
    public function dm_download($Page=1)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
                
        $data['web_page'] = 'member_dm_download';
        
        $meta['title2'] = '型錄下載';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 15;
        
        $where  = array ('a.kind' => 'U009','a.nshow' => 'Y','a.begindate <=' => date('Y-m-d H:i:s'),'ifnull(a.closedate,now()) >=' => date('Y-m-d H:i:s') );        
        
        $order_by = array ('a.boardsort'=>'asc','a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
        $data['title'] = $meta['title2']; 
        $data['Pageurl'] = "member/dm_download/";
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_dm_download', $data);
        
        
    }
    
    // ARSOA AI
    public function love($Page=1)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
                
        $data['web_page'] = 'member_arsoa_AI';
        
        $meta['title2'] = 'ARSOA AI';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 15;
        
        $where  = array ('a.kind' => 'U008','a.nshow' => 'Y','a.begindate <=' => date('Y-m-d H:i:s'),'ifnull(a.closedate,now()) >=' => date('Y-m-d H:i:s') );        
        
        $order_by = array ('a.boardsort'=>'asc','a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
            
        $data['title'] = $meta['title2'];    
        $data['Pageurl'] = "member/love/";
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_arsoa_ai', $data);
        
        
    }
    
    public function rights()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
                
        $data['web_page'] = 'member_rights';
        
        $meta['title2'] = '權益規範';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        _timer('*** before layout ***');
     
        $this->layout->view('member_rights', $data);
    }   

    public function logout()
    {
        if (!empty($this->session->userdata('logid'))){
            $this->front_base_model->update_table('ap_member_login_log',array("logoutdt" => date('Y-m-d H:i:s')),array('logid='=> $this->session->userdata('logid')));                  
        }
        
        $this->front_member_model->member_cookie_set('D');
        
        $this->front_member_model->logout();
                       
        alert( '您已成功登出！', base_url('') );   
        exit;        
    }

    public function product($type = '')
    {
        $useful_type = array(4,5);
        if (!in_array($type, $useful_type)){
            redirect( 'member/main' );
        }

        // 確認是否登入確認是否登入
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/login' );            
        }

        $msconn = $this->front_mssql_model->ms_connect();

        // 必選
        $data['pckpro1'] = $this->front_join_model->ms_pckpro(1, $msconn, array('jointype' => $type));
        
        $maxamt = 0;          // 需達到金額
        
        $data['pckpro1_checkbox'] = false;
        $data['pckpro1_selcnt'] = 0;
        if ($data['pckpro1']){
            $data['pckpro1_count']  = count($data['pckpro1']);  // 筆數
            if (isset($data['pckpro1'][0]['maxamt']) && $data['pckpro1'][0]['maxamt'] > 0){
                $maxamt = $data['pckpro1'][0]['maxamt'];
            }  
            $sel1cnt = 0;
            foreach ($data['pckpro1'] as $key => $item){                 						      
                if ($item['issel']){
                    $sel1cnt++;            	          	      
                }
            }                  
                            
            $data['pckpro1_selcnt'] = $data['pckpro1'][0]['selcnt']; // 必選筆數
            //if ($data['pckpro1_count'] > $data['pckpro1_selcnt']){  // 筆數大於必選,所以要出現勾選
            if ($sel1cnt != $data['pckpro1_selcnt']){  // 筆數大於必選,所以要出現勾選
                $data['pckpro1_checkbox'] = true;
            }
        }

        // 自選
        $data['pckpro2'] = $this->front_join_model->ms_pckpro(2, $msconn, array('jointype'=>$this->arsoa_join_data['jointype']));
        
        if ($data['pckpro2']){        	  
            if (empty($data['pckpro1'])){  
                if (isset($data['pckpro2'][0]['maxamt']) && $data['pckpro2'][0]['maxamt'] > 0){
                    $maxamt = $data['pckpro2'][0]['maxamt'];
                }
            }
            
            $data['pckpro2_count']  = count($data['pckpro2']);  // 筆數
            $data['pckpro2_protype'] = array();
            $protype = '';
            foreach ($data['pckpro2'] as $key => $item){
                if ($protype <> trim($item['protype'])){
                    $data['pckpro2_protype'][] = trim($item['protype']);
                    $data['pckpro2_protype_num'][trim($item['protype'])] = 1;
                }else{
                    $data['pckpro2_protype_num'][trim($item['protype'])] ++;
                }
                $protype = trim($item['protype']);
            }        	  
        }

        $data['maxamt'] = $maxamt;
        $data['useamt'] = 0;

        $this->layout->view('member/step_product', $data);
    }
} 