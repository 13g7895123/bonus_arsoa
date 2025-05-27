<?php
/**
 * Class Front_member_model 
*/
class Front_member_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_member_login($bool = FALSE,$chkpwd = true)
    {

        $member_session = $this->session->userdata('member_session');               
        if (isset($member_session['c_no']) && $member_session['c_no'] > '') {                 
            
            if ($this->session->userdata('is_read') == "0" && substr_count($_SERVER['PATH_INFO'],"copyright") == 0){              
                alert( '抱歉您尚未同意 安露莎 ARSOA  版權聲明！' ,base_url('member/copyright'));
                exit;    
            }
           
            if ($chkpwd){
                if ($this->session->userdata('pwdlen') < 6){                                  
                    alert( '抱歉您密碼尚未修改為6碼以上！' ,base_url('member/changepwd'));
                    exit;    
                }
            }
            
            /*
            if (notd_posn = $this->session->userdata('d_posn')){
                alert( '抱歉您沒有權限使用該功能！' ,base_url('member/main'));
                exit;    
            }
            */
            return $bool ? TRUE : array(
                'status' => TRUE,
                'data'   => $member_session
            );
        }

        return $bool ? FALSE : array('status' => FALSE);
    }
    
    public function logout()
    {
        
        $this->session->unset_userdata( 'logid' );
        $this->session->unset_userdata( 'webis_org' );
        $this->session->unset_userdata( 'use_cart' );
        $this->session->unset_userdata( 'closepaystdt' );
        $this->session->unset_userdata( 'closepayeddt' );
        $this->session->unset_userdata( 'is_read' );   
        $this->session->unset_userdata( 'is_read_reward' );     
        $this->session->unset_userdata( 'member_session' );
        $this->session->unset_userdata( 'ProductList' );
        $this->front_order_model->clearDatabaseCart();
        $this->session->unset_userdata( 'prd_session' );
        $this->session->unset_userdata( 'pwdlen' );
        $this->session->unset_userdata( 'login_type' );        
        $this->session->unset_userdata( 'sfreight' );
        $this->session->unset_userdata( 'bp_date' );
        $this->session->unset_userdata( 'temp_no' );        
        $this->session->unset_userdata( 'FC_freight' );                
        $this->session->unset_userdata( 'FC_freight_mp' );
        $this->session->unset_userdata( 'only_reward' ); // 只能買紅利商品
        
    }
    
    public function get_address($c_no)
    {
        $sql = "select * from ap_member_address where c_no = ? order by sort,updt  ";
        $query = $this->db->query($sql, array($c_no));    
        $address = $query->result_array();        
        $query->free_result();                
        return $address;
    }
    
    public function member_session_set($result,$set_type)
    {
            $member_session = array(
                     'c_no'						=> trim($result['c_no']),                  
                     'd_pos'					=> trim($result['d_pos']),           //階級名稱              
                     'c_name'					=> trim($result['c_name']),          //姓名
                     's_rate'					=> trim($result['s_rate']),          //折扣
                     'zip_dl'					=> trim($result['zip_dl']),         
                     'addr_dl'				=> trim($result['addr_dl']),       
                     'cell1'					=> trim($result['cell1']),       
                     'e_mail'					=> trim($result['e_mail']),
                     'mb_status' 			=> trim($result['mb_status']),                         
                     'is_org' 		    => trim($result['is_org']),          //判斷該會員是否有阻擋不可進去組織專區
                     'b_date'					=> date('Y-m-d',strtotime($result['b_date']))
            );
            
            $this->session->set_userdata( 'pwdlen' ,strlen(trim($result['passwrd'])));    // 密碼長度
            
            if (trim($result["d_posn"]) == ""){
            	   $member_session["d_posn"]   = 100;
            }else{
                 $member_session["d_posn"]   = (int)(trim($result["d_posn"]));
            }
            
            if ($set_type == 'order'){
                if (trim($result["mb_status"]) == "退出"){   	  	  // 退出 --  要判斷MP 還有沒有值..有值可以去買紅利商品
                    $this->session->set_userdata( 'use_cart', 'N' );  
                    $this->session->set_userdata( 'only_reward', 'Y' );   	   
                }else{
                    $this->session->set_userdata( 'use_cart', 'Y' );  
                    $this->session->set_userdata( 'only_reward', 'N' );   	   
                }
            }
            
            $this->session->set_userdata( 'is_read', 1 );
            $this->session->set_userdata( 'is_read_reward',trim($result['is_read_reward']));  // 有沒有看過紅利兌利說明 第一次買紅利要看
            $this->session->set_userdata( 'member_session', $member_session );
            
    }
    
    public function member_cookie_set($ctype = 'I',$cookie_key = 'cookie_key')
    {
        if ($ctype == 'I'){
            $cookie_value = '';
            if (isset($_COOKIE[$cookie_key])){      // 判斷有 cookie id
                $cookie_value = trim($_COOKIE[$cookie_key]);
            }            
            if ($cookie_value > ''){        
                $sql = "INSERT INTO ap_member_cookie (c_no,cookie_key,cookie_value,crdt) VALUES (?,?,?,now()) ON DUPLICATE KEY UPDATE cookie_value=?,updt = now()";                             
                $this->db->query($sql,array($this->session->userdata('member_session')['c_no'],$cookie_key,$cookie_value,$cookie_value));
            }
        }else{
            $this->db->delete('ap_member_cookie' ,array('c_no' => $this->session->userdata('member_session')['c_no'],'cookie_key' => $cookie_key));
        }
    }
    
    public function member_save_data($c_no,$mkey,$email)
    {
        
        $sql = "INSERT INTO ap_member_data (c_no,mkey,value,crdt) VALUES (?,?,?,now()) ON DUPLICATE KEY UPDATE value=?,updt = now()";                             
        $this->db->query($sql,array($c_no,$mkey,$email,$email));
        
    }
    
    
    public function member_get_data($c_no,$mkey)
    {
        
        $this->db->select( "value" )
                   ->from( "ap_member_data" );
        $this->db->where( 'c_no', $c_no );
        $this->db->where( 'mkey', $mkey );
        $query = $this->db->get();      
        $rows = $query->row_array();
        $query->free_result();  
        if ($rows){
            return $rows['value'];
        }else{
        	  return '';
        }
    }
    
    public function member_cookie_login($c_no)
    {
        //echo "<pre>".print_r($this->session->userdata,true)."</pre>";
        if (!isset($this->session->userdata('member_session')['c_no']) || $this->session->userdata('member_session')['c_no'] == ''){
        	 // echo 'session 不見了';
        	 // exit;
           // $cookie_key = 'cookie_key';
           // $cookie_value = '';
           // if (isset($_COOKIE[$cookie_key])){      // 判斷有 cookie id
           //     $cookie_value = trim($_COOKIE[$cookie_key]);
           // }            
         //   echo "[".$cookie_value."]";          
            if ($c_no > ''){
                /*
                $sql = "select m.*,p.s_rate 
                         from member m 
                         join ap_member_cookie c on m.c_no = c.c_no 
                         join position p on m.d_posn = p.d_posn
                         where c.cookie_key = 'cookie_key'
                           and c.cookie_value = ? 
                         limit 1 ";
                $query = $this->db->query($sql, array($cookie_value));                    
                */
                $sql = "select m.*,p.s_rate 
                         from member m 
                         join position p on m.d_posn = p.d_posn
                         where m.c_no = ? ";
                $query = $this->db->query($sql, array($c_no));                                    
                $result = $query->row_array();                 
              //  echo "<pre>".print_r($this->db->last_query(), true)."</pre>";
              //  echo "<pre>".print_r($result,true)."</pre>";
                $this->member_session_set($result,'order');
                return true;
            }
        }
        return false; 
    }
    
    // 申請加入會員寄信給使用者...MAIL
    public function joinmail($jid)
    {
         $where  = array ('jid' => $jid);
         $rdata = $this->front_base_model->get_data('ap_member_join',$where,array(),1);        
         if ($rdata){         
             $EBody = $this->block_service->PF_ReadFile("public/email/mumber-mail.html");    
            
             $EBody = str_replace("[+uname+]", $rdata['uname'] ,$EBody);        
           
             $this->block_service->send_email($rdata['email'],'安露莎入會資訊信函',$EBody);
             return true;
         }
         return false; 
    }
    
    public function check_login($ltype,$result,$rdurl = '')
    {
   	   if ($rdurl == ''){
   	       $rdurl = 'member/main';
   	   }
   	   if (trim($result["mb_status"]) == "暫停"){
   	       redirect( base_url('webmsg/M9001') );
   	       exit;
   	   }
   	   
   	   $this->session->set_userdata( 'only_reward', 'N' );
   	   $this->session->set_userdata( 'login_type', $ltype );
   	   
   	   if (trim($result["mb_status"]) == "退出"){   	  	  // 退出 --  要判斷MP 還有沒有值..有值可以去買紅利商品
   	       $msconn = $this->front_mssql_model->ms_connect();          
           $mp = $this->front_order_model->ms_get_mp($msconn,$result['c_no']);              
           if ($mp <= 0){
   	   	       redirect( base_url('webmsg/M9002') );
   	           exit;
   	       }else{
   	           $this->session->set_userdata( 'only_reward', 'Y' );
   	       }
   	   }
   	   
   	   if (trim($result["is_web"]) == 0){
   	       redirect( base_url('webmsg/M9003') );
   	       exit;
   	   }else{     	          	        
   	        if ($ltype == 'user'){
   	             //---登入記錄--- 
                 $data = array(
                               "c_no" => $result['c_no'],
                               "ip"   => $this->data['tracking']['ip'],
                               "crdt" => date('Y-m-d H:i:s')
                 );
                 $rdata = ($this->db->insert('ap_member_login_log', $data)) ? true : false;
                 if ($rdata){
                     $logid = $this->db->insert_id();
                 }                 
                            
                 // 有登入 Line ---                 
                 if (!empty($this->session->userdata('line_user_id'))){                     
                     $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));            
                     if ($line_id_data)
                     {
                     	  if ($line_id_data['c_no'] != $result['c_no']){
                     	  	  alert("親愛的 ".$result['c_name']." 您好：\\n\\n您的 Line 帳號已綁定（會員編號：".$line_id_data['c_no']."），由於一個 Line 帳號，只能綁定一個會員編號；如有問題，請洽客服！",base_url('member/login'));
                     	  	  exit;
                     	  }
                     }else{
                     	   $this->member_line_bind($result['c_no'],$result['c_name'],$this->session->userdata('line_user_id'));                     	   
                     }
                  }
                  
                  $this->Member_login_record->clear_record();
            }else{
                 $logid = 0;          
            }
            
            if ($this->session->userdata('only_reward') == 'N'){
                $this->session->set_userdata( 'use_cart', 'Y' );
            }else{
                $this->session->set_userdata( 'use_cart', 'N' );
            }
                 
            $this->session->set_userdata( 'logid', $logid );
            
            $this->member_session_set($result,'login');
            
            // line 資料抓取
            $this->member_session_line_set($result['c_no'],$result['c_name'],'login');
            
            if ($ltype == 'user'){
                $this->front_base_model->update_table('member',array("web_date" => date('Y-m-d H:i:s')),array('c_no='=>$result['c_no']));                  
                $this->member_cookie_set('I');
            }else{
            	  $this->session->set_userdata( 'pwdlen' , 8 );  
            }
            
            //--結帳鎖定通知--
            $this->block_service->dataset('member','login');            
            //--結帳鎖定通知--              
            
            $this->session->set_userdata( 'is_read', 1 );  
            
            if ($ltype == 'user'){
                if ($result["is_read"] == 0 && $result["d_posn"] <= 100){ // 第一次登入需要按同意才可以看   
                    $this->session->set_userdata( 'is_read', 0 );  
                    redirect( 'member/copyright' );
                    exit;
                }
                
                // pass_date 空值 尚未改過密碼                                
                if ($result["pass_date"] == '' || $result["pass_date"] == '1900-01-01 00:00:00'){ // 變更密碼    
                    redirect( 'member/changepwd/Y' );
                }else{
                    // 登入時將上次未買的產品放到 session
                    $this->front_order_model->login_session_cart(trim($result['c_no']),$result["d_posn"]);
                
                    redirect( $rdurl );
                }   
            }else{
                redirect( $rdurl );
            }
         }          
    }
    
    public function member_session_line_set($c_no,$c_name,$c_type)
    {
    	
    	   $line_user_id			= '';
         $line_follow				= '';
         $line_display_name = '';
         $line_picture_url	= '';
         $bind_code					= '';
         
         if ($c_no > ''){
             // 判斷這會員有沒有在 資料庫有資料 
             $line_data = $this->Member_line_model->find_one('c_no',$c_no);                              
             if ($line_data)
             {
                 if ($line_data['user_id'] > ''){  // 會員有綁 line 了 
                 	  $line_user_id = trim($line_data['user_id']);
                 	  $line_user_data = $this->line_service->get_line_user($line_user_id ,'',true);                      	  
                 	  if ($line_user_data){
                 	      $line_follow = $line_user_data['follow'];
                 	      $line_display_name = $line_user_data['display_name'];
                 	      $line_picture_url = $line_user_data['picture_url'];
                 	  }
                 }else{  // 有資料,但沒綁
                     $bind_code = $line_data['bind_code'];	
                 }
             }else{    	// 沒資料建立一筆資料                  	                      
                 $bind_code = md5('member_'.uniqid());
             	   $idata = array(
                               'c_no'      => $c_no,
                               'c_name'    => $c_name,                                    
                               'bind_type' => 'L',
                               'bind_code' => $bind_code
                              );                                            
                 $this->Member_line_model->insert_data($idata);                      
             }         	
         }
         
         $member_session = $this->session->userdata('member_session');               
         
         $member_session['line_user_id'] 			= trim( $line_user_id );
         $member_session['line_display_name'] = trim( $line_display_name );
         $member_session['line_follow'] 			= trim( $line_follow );
         $member_session['bind_code'] 				= trim( $bind_code );
         $member_session['line_picture_url']	= trim( $line_picture_url );
                     
         $this->session->set_userdata( 'member_session', $member_session );         
         
         // 有登入 Line ---
    }
    
    // 取資料 - 單筆
    public function find_one($key,$val)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from('member');
        $this->db->where($key, $val);
        $result = $this->db->get()->result_array();
        return (count($result) > 0) ? $result[0] : array();
    }
    
    public function member_line_bind($c_no,$c_name,$user_id)
    {
    	  $line_c_no_data = $this->Member_line_model->find_one('c_no',$c_no);
           
        if ($line_c_no_data){
            if (trim($line_c_no_data['user_id']) > '' && $line_c_no_data['user_id'] != $user_id){
                alert("親愛的 ".$this->session->userdata('line_display_name')." 您好：\\n\\n您登入的會員帳號已綁定另一組 Line 帳號，由於一個會員編號，只能綁定一個 Line 帳號；如有問題，請洽客服！");
                exit;
            }else{
        	       $m_data = array(
                       'user_id'   => $user_id,                                             
                       'bind_date' => date('Y-m-d H:i:s')
                      );     
                 if (trim($line_c_no_data['bind_type']) == 'L'){
                	    $m_data['bind_type'] = 'M';
                 }      
                 $this->Member_line_model->update_data($line_c_no_data['bid'],$m_data);
            }
        }else{                             
            $idata = array(
                           'c_no'      => $c_no,
                           'c_name'    => $c_name,
                           'user_id'   => $user_id,                                             
                           'bind_type' => 'B',
                           'bind_code' => md5('line_'.uniqid()),
                           'bind_date' => date('Y-m-d H:i:s')
                          );                                            
            $this->Member_line_model->insert_data($idata);
        }
                                     
        $line_user_data = $this->line_service->get_line_user($user_id ,'',true);                      	  
        
        $push_msg = $this->line_service->bind_push($line_user_data,$c_no,$c_name,'');
        
        //$this->session->unset_userdata( 'line_user_id' );        
        //$this->session->unset_userdata( 'line_display_name' );                                
    }
}