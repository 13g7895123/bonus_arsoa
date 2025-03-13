<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_join extends MY_Controller
{
    private $join_name   = array('','會費750元','購買3500元產品','圓夢事業組合','健康宅配專案','肌能調理宅配專案','可佳媽媽淨活水器專案');
    private $arsoa_join_key  = '';  // 暫存車KEY
    private $arsoa_join_jid  = '';
    private $arsoa_join_pckpro  = array();
        
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->library('ui');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_join_model' );
        $this->load->model( 'front_base_model' );        
        $this->load->model( 'front_mssql_model' );
        $this->load->model( 'front_product_model' );  
                
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
        
    }
    
    private function join_data_check()
    {
    	  //session_destroy();
        $this->arsoa_join_data = array();
         
        if (!empty($this->session->userdata( 'arsoa_join_key' )) && $this->session->userdata( 'arsoa_join_key' ) > ''){
        	  $this->arsoa_join_key = $this->session->userdata( 'arsoa_join_key' );
        }
        if ($this->arsoa_join_key == ''){
            if (isset($_COOKIE["arsoa_join_key"])){      // 判斷有 cookie id	
            	  $this->arsoa_join_key = $_COOKIE["arsoa_join_key"];
            }
        }        
        
        $cookie_key = '';
        if ($this->arsoa_join_key > ''){      // 判斷有 cookie id
            $this->arsoa_join_data = $this->front_base_model->get_data('ap_member_join_new',array('cookie_key'=>$this->arsoa_join_key,'pay_statue'=>'N'),'',1);            
            if ($this->arsoa_join_data){
            	  $cookie_key = $this->arsoa_join_key;  
            	  $this->arsoa_join_jid = $this->arsoa_join_data['jid'];            	  
            	  for ($i = 1;$i<= 4;$i++){
            	  	   $this->arsoa_join_pckpro[$i] = json_decode($this->arsoa_join_data['pckpro'.$i], true);  
            	  }
            }
        }
        
        if ($cookie_key == ''){
            $cookie_key = 'jtemp_'.date('Y-m-d').'_'.md5(uniqid());
        }
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){               
             $this->input->set_cookie("arsoa_join_key",$cookie_key, time()+3600);                             
        }else{
             $this->input->set_cookie("arsoa_join_key",$cookie_key,525600, "/", "arsoa.tw");  // 一年
        }
        $this->session->set_userdata( 'arsoa_join_key',$cookie_key );
        
        $this->arsoa_join_key = $cookie_key;
    }
    
    public function index()
    {
      
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }else{
            redirect( 'member_join/form' );            
        } 
    }
    
    public function test(){
    	  $this->session->set_userdata( 'arsoa_join_key', 'jtemp_2023-04-21_3e5290fb16cccbb2e294b94802d58d0b' );
    	  redirect( 'member_join/form' );   
    	  exit;
    }
    
    public function form()
    {         
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );           
        } 
        
        //--結帳鎖定通知--
        $this->block_service->dataset('join','form',base_url());            
        //--結帳鎖定通知--  
        
        self::join_data_check();
        
        $meta['title2'] = '新會員登錄 | 填寫基本資料';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );      
        
        $params = array();
        if ($this->arsoa_join_data){
            $params = $this->arsoa_join_data;
            $params['cityno'] = $this->front_base_model->get_data('town',array('postal'=>$params['postal']),'',1)['cityno'];
            $data['town']  = $this->front_base_model->get_data('town',array('cityno' => $params['cityno'] ),array('postal'=>'asc'));            
        }
        
        
        if (empty($params)){                
            $params = array(
                      'uname'         => '',
                      'sex'           => '',
                      'idno'          => '',
                      'bday'          => '',
                      'tel'           => '',
                      'email'         => '',
                     // 'spouse_name'   => '',
                     // 'spouse_idno'   => '',
                     // 'spouse_bday'   => '',                      
                      'cityno'        => '',
                      'postal'        => '',
                      'address'       => '',
                      'referrer_name' => '',
                      'referrer_c_no' => ''
           );            
        }
        
        $data['params'] = $params;     
        
        $data['arsoa_join_key'] = $this->arsoa_join_key;     
                
        $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
                                    
        _timer('*** before layout ***');
     
        $this->layout->view('member_join/step_form', $data);      
    }
    
    
    // 車檢視修改數量和刪除
    public function step_cart_change($jtype)
    {
        self::join_data_check();
        
        $result = array('status' => 1);                
        $data_post = $this->input->post( NULL, FALSE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){  
                 $data = array();
                 if ($this->arsoa_join_pckpro[$jtype]){                                          
                     // 數量變更
                     foreach ($this->arsoa_join_pckpro[$jtype] as $key => $item){
                              for ($k = 1;$k<= $data_post['p_num'];$k++){
                              			if ($item['p_no'] == trim($data_post['p_no_'.$k])){
                              			    $data[] = array(
                              			                    'p_no' => $item['p_no'],
                              			                    'pid'  => $item['pid'],
                              			                    'qty'  => $data_post['num_'.$k]
                              			                   );
                              			}
                              }
                     }                 
                     // 產品刪除
                     if (isset($data_post['del_prd']) && $data_post['del_prd']){
                         foreach ($data_post['del_prd'] as $dprd){                              
                              foreach ($data as $key => $item){
                                       if ($item['p_no'] == $dprd){
                                            unset($data[$key]);
                                       } 
                              }
                         }  
                         $data=array_values($data);
                     }   
                 }                                  
                 $this->front_join_model->update_pckpro($this->arsoa_join_jid,$jtype,$data);                 
        }
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;    
    }
    
    // 每一頁的資料判斷
    public function step_check($step)
    {      
        if ( $this->front_member_model->check_member_login( TRUE ) ) {            
            redirect( 'member/main' );            
        }   
        
        self::join_data_check();
        
        $result = array('status' => 0,'focuskey' => '', 'errmsg' => '操作有誤!');                
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
        	  
        	  switch ($step) {
                    case 'form':  // 資料填寫頁                         
     								   	  $data_post['email'] = strtolower($data_post['email']);
     								   	  if ($data_post['uname'] == '') {      
     								   	  	  $result['errmsg'] = '姓名未填入！';     
     								   	  	  $result['focuskey'] = 'uname';                
     								   	  	  $check = false;
     								   	  }
     								   	  if ($data_post['sex'] == '') {      
     								   	  	  $result['errmsg'] = '性別未選擇！';     
     								   	  	  $result['focuskey'] = 'sex';                
     								   	  	  $check = false;
     								   	  }
     								   	  
     								   	  if ($check && $data_post['jointype'] == '3' && $data_post['idno'] == ''){
     								   	  	   $result['errmsg'] = '圓夢事業組合必須填寫身份證字號！';
     								           $result['focuskey'] = 'idno';                
      								   	  	 $check = false; 
     								   	  }     								   	  	  	  
     								   	  
     								   	  if ($check && $data_post['idno'] > '')
     								   	  {
     								   	      if (!is_numeric(substr($data_post['idno'],1,1))){  // 第二碼是英文字 居留碼
     								   	      	  if (!check_idno($data_post['idno'],'R')){
     								                  $result['errmsg'] = '居留證號有誤(I1)！';
     								                  $result['focuskey'] = 'idno';                
     								   	  	          $check = false;
     								   	          }	
     								   	      }else{
     								   	          if (!check_idno($data_post['idno'])){
     								                  $result['errmsg'] = '身份證字號有誤(I2)！';
     								                  $result['focuskey'] = 'idno';                
     								   	  	          $check = false;
     								   	          }	
     								   	          if ($check && !(($data_post['sex'] == 'F' && substr($data_post['idno'],1,1) == '2') || ($data_post['sex'] == 'M' && substr($data_post['idno'],1,1) == '1'))){
     								   	  	  	  	  $result['errmsg'] = '身份證字號有誤(I3)！';
     								                  $result['focuskey'] = 'idno';                
     								   	  	          $check = false;     								   	  	  
     								   	  	      }
     								   	      }
     								   	  }
     								   	  
     								   	  if ($check && !check_date($data_post['bday'])){
     								           $result['errmsg'] = '生日日期有誤！';
     								           $result['focuskey'] = 'bday';                
     								   	  	  $check = false;
     								   	  }else{
     								   	  	  if (!validateAge($data_post['bday'])){
     								   	  	  	  $result['errmsg'] = '滿20歲才可申請會員！';
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
     								   	  
     								   	  if ($check && $data_post['email'] > '' && !filter_var($data_post['email'],  FILTER_VALIDATE_EMAIL)) {      
     								   	  	  $result['errmsg'] = 'E-mail 格式有誤！';     
     								   	  	  $result['focuskey'] = 'email';                
     								   	  	  $check = false;
     								   	  }        	  
     								   	  if ($data_post['postal'] == '' || $data_post['cityno'] == '' || $data_post['address'] == ''){
     								   	      $result['errmsg'] = '通訊地址有誤！';     
     								   	  	  $result['focuskey'] = 'cityno';                
     								   	  	  $check = false;     								   	  
     								   	  }
     								   	  /*
     								   	  if ($check && $data_post['spouse_idno'] > '' && !check_idno($data_post['spouse_idno'])){
     								   	      $result['errmsg'] = '配偶身份證字號有誤！';     
     								   	      $result['focuskey'] = 'spouse_idno';                
     								   	  	  $check = false;
     								   	  }
     								   	  if ($check && $data_post['idno'] > '' && $data_post['idno'] == $data_post['spouse_idno']){
     								           $result['errmsg'] = '二組身份證字號不可重覆！';
     								           $result['focuskey'] = 'idno';                
     								   	  	  $check = false;
     								   	  }
     								   	  if ($check && $data_post['spouse_bday'] > '' && !check_date($data_post['spouse_bday'])){
     								           $result['errmsg'] = '配偶生日日期有誤！';
     								           $result['focuskey'] = 'spouse_bday';                
     								   	  	  $check = false;
     								   	  } 
     								   	  */     
     								   	  if ($check){  
     								   	  	  $msconn = $this->front_mssql_model->ms_connect();  
     								   	  }
     								   	  if ($check){             								   	  	
     								   	      $chkdata = $this->front_join_model->ms_chkname($msconn,$data_post['uname'],$data_post['bday']);  // 判斷此會員是否已加入過             	           								   	      
     								   	      if ($chkdata['errcode']){
     								   	          $result['errmsg'] = '您已申請過會員，如有問題請洽公司客服 0809-080-608！';
     								              $result['focuskey'] = 'uname';                
     								   	  	      $check = false;
     								   	      }        	      
     								   	  }
     								   	  
     								   	  if ($check && $data_post['idno'] > ''){          	      
     								   	      $chkdata = $this->front_join_model->ms_chkidno($msconn,$data_post['idno']);  // 判斷入會者身分證號是否重複(有輸入身份證號才做)     
     								   	      if ($chkdata['errcode']){
     								   	          $result['errmsg'] = '此身份證字號已申請過會員，如有問題請洽公司客服 0809-080-608！';
     								               $result['focuskey'] = 'idno';                
     								   	  	      $check = false;
     								   	      }        	      
     								   	  }
     								   	  
     								   	  if ($check){          	      
     								   	      $chkdata = $this->front_join_model->ms_chkdname($msconn,$data_post['referrer_name'],$data_post['referrer_c_no']);  // 檢查推薦人資料是否存在
     								   	      if ($chkdata['errcode']){
     								   	          $result['errmsg'] = '推薦人資料有誤，如有問題請洽公司客服 0809-080-608！';
     								               $result['focuskey'] = 'referrer_name';                
     								   	  	      $check = false;
     								   	      }        	      
     								   	  }
     								   	  
     								   	  /*        	  
     								   	  if ($check){  
     								   	      $this->db->select( "m.c_no" )
     								                         ->from( 'member m' )
     								                         ->join( 'position p', 'm.d_posn = p.d_posn' )
     								                         ->where( 'ifnull(m.d_posn,999) <=', '100' )
     								                         ->where( 'm.c_no', $data_post['referrer_c_no'] )
     								                         ->where( 'm.c_name', $data_post['referrer_name'] );
     								           $result = $this->db->get()->row_array();              
     								           if (!$result){     
     								               $result['errmsg'] = '推薦人資料有誤！';
     								               $result['focuskey'] = 'referrer_name';                
     								   	      	   $check = false;
     								           }
     								       }
     								       */
     								   	  	  
     								   	  if ($check){        	  
     								       		$session_id = session_id();
     								       		$cookie_key = md5($session_id.date('Y-m-d H:i:s'));
     								       		$data = array(
     								       		              "jointype" => $data_post['jointype'],
     								       		              "step"  => $step,
     								       		              "uname" => $data_post['uname'],
     								       		              "sex" => $data_post['sex'],
     								       		              "idno" => $data_post['idno'],
     								       		              "bday" => $data_post['bday'],
     								       		              "email" => $data_post['email'],
     								       		              "tel"   => $data_post['tel'],
     								       		             // "spouse_name"   => $data_post['spouse_name'],
     								       		             // "spouse_idno"   => $data_post['spouse_idno'],
     								       		             // "spouse_bday"   => $data_post['spouse_bday'],
     								       		              'city' => $this->front_base_model->city_title($data_post['cityno']),
     								       		              'town' => $this->front_base_model->town_title($data_post['postal']),
     								       		              "postal" => $data_post['postal'],
     								       		              "address" => $data_post['address'],
     								       		              "referrer_name" => $data_post['referrer_name'],
     								       		              "referrer_c_no" => $data_post['referrer_c_no'],
     								       		              "ip" => $this->data['tracking']['ip']
     								       		);
     								       		
     								       		if ($this->arsoa_join_data){  // 資料已存在,修改
     								       			   if ($this->arsoa_join_data['jointype'] <> $data_post['jointype']){  // 選擇的方案不同清空車     								       			       
     								       			       for ($i = 1;$i<=4;$i++){
     								       			            $data['pckpro'.$i] = '';     								       			       
     								       			            $this->arsoa_join_data['pckpro'.$i] = '';
     								       			       }
     								       			       $this->front_join_model->ms_jsf_temp($msconn,$this->arsoa_join_jid,'A',1,4);  // mssql 暫存車刪掉      
     								       			   }else{                                     // 清掉贈品和紅利點數
     								       			   	   for ($i = 3;$i<=4;$i++){
     								       			            $data['pckpro'.$i] = '';     								       			       
     								       			            $this->arsoa_join_data['pckpro'.$i] = '';
     								       			       }
     								       			       $this->front_join_model->ms_jsf_temp($msconn,$this->arsoa_join_jid,'S',3,4);  // mssql 暫存車刪掉      
     								       			   }
     								       			   $data['updt'] = date('Y-m-d H:i:s');
     								               $where = array ('jid'=>$this->arsoa_join_data['jid'],'cookie_key'=>$this->arsoa_join_key);                              
     								               $this->front_base_model->update_table('ap_member_join_new',$data ,$where);     
     								               
     								               $jid = $this->arsoa_join_data['jid'];         			
     								       		}else{            		            		                  
     								       		    $data['cookie_key'] = $this->arsoa_join_key;
     								       		    $data['session_id'] = session_id();
     								       		    $data['pckpro1'] = '';
     								       			  $data['pckpro2'] = '';
     								       			  $data['pckpro3'] = '';
     								       			  $data['pckpro4'] = '';
     								       			       
     								       		    $data['crdt'] = date('Y-m-d H:i:s');
     								       		    $this->db->insert('ap_member_join_new', $data);
     								       		    
     								       		    if ($this->db->affected_rows() > 0 ){               
     								       		        $jid = $this->db->insert_id();                            		        
     								       		    }
     								       		}               
     								       		$result['status']     = 1;
     								       	  $result['jid']        = $jid;
     								       		$result['next_url']   = base_url('member_join/product');
     								       }                        
                        
                        break;                
                    case 'product':    // 資料填寫頁
                     
                        $msconn = $this->front_mssql_model->ms_connect();  
                                
        								// 必選
        								$maxamt = 0;          // 需達到金額
        								$selcnt = 0;          // 需必選產品
        								$total_price = 0;     // 總金額
        								$pckpro1_selcnt = 0;  // 已選
        								$result['errmsg'] = '';
        							
        								$pckpro1_selprd = array();    
        								      								
                        $data['pckpro1'] = $this->front_join_model->ms_pckpro(1,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));    
                        
                        $this->arsoa_join_pckpro[1] = '';
                        if ($data['pckpro1']){                                                        
                            if (isset($data['pckpro1'][0]['maxamt']) && $data['pckpro1'][0]['maxamt'] > 0){
                                $maxamt = $data['pckpro1'][0]['maxamt'];
                            }                   
                             
                            foreach ($data['pckpro1'] as $key => $item){                 						      
                                           $item['p_no'] = trim($item['p_no']);
                                           $prdtotal = $item['price']*$item['qty'];
                                           if ($selcnt == 0 && (int)$item['selcnt'] > 0){
                                               $selcnt = (int)$item['selcnt'];
                                           }                                           
            									   		       if ($item['issel'] || (isset($data_post['sel_prd']) && in_array($item['p_no'],$data_post['sel_prd']))){
            									          	      $total_price += $prdtotal;
            									          	      $pckpro1_selcnt++;
            									          	      $pckpro1_selprd[] = array( 'p_no' => $item['p_no'],
            									          	                                 'pid'  => $item['pid'],
            									          	                                 'qty'  => $item['qty']
            									          	                                );      
            									          	                             
            									          	      $this->front_join_model->in_join_cart($this->arsoa_join_jid,$this->arsoa_join_pckpro,'1',$item['p_no'],$item['pid'],$item['qty']);
            									          	 }
                            }                                                        
                        }    
                       
                        $this->arsoa_join_data['pckpro1'] = json_encode($pckpro1_selprd);                  
                                               
                        $data['pckpro2'] = $this->front_join_model->ms_pckpro(2,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
                        if ($data['pckpro2']){
                            if (empty($data['pckpro1'])){  
                                if (isset($data['pckpro2'][0]['maxamt']) && $data['pckpro2'][0]['maxamt'] > 0){
                                    $maxamt = $data['pckpro2'][0]['maxamt'];
                                }
                            }
                        }
                      
                        if ($selcnt > $pckpro1_selcnt){
                 				     $result['errmsg']   = '尚未選擇 '.$selcnt.' 個專案';     								            
  								   	       $check = false;
                 				}
                 				
                        if ($maxamt > 0){                                                        
        	       						foreach ($data['pckpro2'] as $key => $item){                 						      
                 						           if ($this->front_join_model->check_cart($this->arsoa_join_pckpro,'2',trim($item["p_no"]))){
                 						               $p_num = $this->front_join_model->check_cart_prd_num($this->arsoa_join_pckpro,'2',trim($item["p_no"]));
                 						               $prdtotal = $item['price']*$p_num;
                 						               $total_price += $prdtotal;
                 						           }
                 						      
                 						}
                 						if ($maxamt > $total_price){                 						    
                 						    if ($result['errmsg'] > ''){ $result['errmsg'] .= ","; }
                 						    $result['errmsg']   .= '整張單需滿 '.number_format($maxamt).' 元，已選產品金額 '.number_format($total_price).' 元，不足 '.number_format($maxamt - $total_price).' 元';     								            
     								   	      	$check = false;
                 						}
                 				}
                 				if ($result['errmsg'] > ''){ $result['errmsg'] .= "！"; }
                 				
                 			
                 				if ($check){   // 沒問題,到紅利頁                   					
                 				      for ($i = 3;$i<=4;$i++){
     								       		     $udata['pckpro'.$i] = '';     								       			       
     								       		     $this->arsoa_join_data['pckpro'.$i] = '';
     								       		}
     								       		$this->front_join_model->ms_jsf_temp($msconn,$this->arsoa_join_jid,'S',1,4);  // mssql 
     								       		
     								       		$where = array ('jid'=>$this->arsoa_join_data['jid'],'cookie_key'=>$this->arsoa_join_key);                              
     								          $this->front_base_model->update_table('ap_member_join_new',$udata ,$where);     
     								       		
                 				      $result['status']     = 1;
     								       	  $result['next_url']   = base_url('member_join/reward');
     								    }
     								    
     								    break;
     								 case 'reward':  // 紅利確認頁
     								    $total_mp = 0;
     								    
     								    $msconn = $this->front_mssql_model->ms_connect();  
     								    
     								    // 計算 mp 
     								    $data['pckpro_mp'] = $this->front_join_model->ms_pckpro('mp',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
     								    
     								    $data['pckpro3'] = $this->front_join_model->ms_pckpro(3,$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
     								    
     								    $data['pckpro_total_mp'] = self::pckpro_total_mp($data['pckpro_mp'],$data['pckpro3']);
     								    						    
        								$data['pckpro4'] = $this->front_join_model->ms_pckpro(4,$msconn,array('jointype'=>$this->arsoa_join_data['jointype'],'mp'=>$data['pckpro_total_mp'],'arsoa_join_key' => $this->arsoa_join_key));
         							
        								if ($data['pckpro4']){
        	       						foreach ($data['pckpro4'] as $key => $item){                 						      
                 						           if ($this->front_join_model->check_cart($this->arsoa_join_pckpro,'4',trim($item["p_no"]))){
                 						               $p_num = $this->front_join_model->check_cart_prd_num($this->arsoa_join_pckpro,'4',trim($item["p_no"]));
                 						               $prdtotal = $item['m_mp']*$p_num;
                 						               $total_mp += $prdtotal;
                 						           }
                 						      
                 						}
                 						if ($total_mp > $data['pckpro_total_mp']){
		        								    $m_mp = $total_mp - $data['pckpro_total_mp'];
		                 				    $result['errmsg']   = '可兌換紅利點數 '.number_format($data['pckpro_total_mp']).'，您選擇的點數 '.number_format($total_mp).'，已超過 '.number_format($m_mp).' 點！';
		     								   	   	$check = false;
		                 			  }		        								        			
                 				}                 				
        								
     								    if ($check){   // 沒問題,到確認頁  
                 				      $pckpro3_selprd = array();  
                 				      if ($data['pckpro3']){                 				      	
        											    foreach ($data['pckpro3'] as $key => $item){            											    
        											             $pckpro3_selprd[] = array( 'p_no' => $item['p_no'],
            									          	                            'pid'  => $item['pid'],
            									          	                            'qty'  => $item['qty']
            									          	                           );    
        											    }                											    
        											}
        											$this->front_join_model->update_pckpro($this->arsoa_join_jid,3,$pckpro3_selprd);
        											     
        											$this->front_join_model->ms_jsf_temp($msconn,$this->arsoa_join_jid,'S',1,4);  // 資料存到　mssql
                 				      
                 				      $result['status']     = 1;
     								       	  $result['next_url']   = base_url('member_join/confirm');
     								    }     								         								 
     								    break; 
     								 case 'confirm':  // 確認頁         								 
     								    
     								    if ($check && isset($data_post['out_day'])){
     								    	  if ($data_post['out_day'] == '0'){     								    	
     								            $result['errmsg'] = '每期出貨日尚未選擇！';
     								            $result['focuskey'] = 'out_day';                
     								  	        $check = false;     						
     								  	    }else{
     								  	    	  $data['out_day']	= $data_post['out_day'];     								        
     								  	    }
     								  	}else{		        
     								        $data['out_day']	= '';
     								    }
     								    
     								    $msconn = $this->front_mssql_model->ms_connect();  
     								    $arsoa_join_chkpromo = $this->front_join_model->ms_chkpromo($msconn,$this->arsoa_join_key);
     								   
     								    $data['promo_p_no'] = '';                
     								    $data['promo_p_name'] = '';                
     								    if ($arsoa_join_chkpromo){
     								    	  if ($check && isset($data_post['promo_sel'])){
     								    	      if ($data_post['promo_sel'] == ''){     								    	
     								                $result['errmsg'] = $arsoa_join_chkpromo[0]['promomsg'];
     								                $result['focuskey'] = 'promo_sel';                
     								  	            $check = false;     						
     								  	        }else{
     								  	        	  $data['promo_p_no'] = trim($data_post['promo_sel']);
     								  	        	  foreach ($arsoa_join_chkpromo as $item){
     								  	        	  	       if ($data['promo_p_no'] == trim($item['p_no'])){
     								  	        	               $data['promo_p_name'] = trim($item['p_name']);
     								  	        	           }
     								  	        	  }
     								  	        }
     								  	    }
     								    }     								    
     								    
     								    /*
     								    if ($check && $this->arsoa_join_data['jointype'] == 3 && isset($data_post['is_sample']) && $data_post['is_sample'] == ''){
     								    	  $result['errmsg'] = '是否要綁定LINE並以此2000紅利兌換3組試用組尚未選擇！';
     								        $result['focuskey'] = 'is_sample';                
     								  	    $check = false;     						
     								    }else{
     								    	  if (isset($data_post['is_sample']) && $data_post['is_sample'] > ''){
     								    	  	  $data['is_sample']	= $data_post['is_sample'];
     								    	  }else{
     								    	      $data['is_sample']	= '';
     								    	  }
     								    }
     								    */
     								    $data['is_sample']	= '';
     								    
     								    if ($check && !isset($data_post['iagree'])){
     								        $result['errmsg'] = '會員條款並未閱讀同意！';
     								          $result['focuskey'] = 'iagree';                
     								   	  	  $check = false;
     								    }
     								    
     								    if ($check && ( isset($data_post['iagree']) && $data_post['iagree'] != 'Y')){
     								   	  	  $result['errmsg'] = '會員條款並未閱讀同意！';
     								          $result['focuskey'] = 'iagree';                
     								   	  	  $check = false;
     								   	}
     								    
     								    if ($check){   // 沒問題,到付款金流頁       								                           				      
                 				      $data['remark']		= $data_post['remark'];     								        
     								          $where = array ('jid'=>$this->arsoa_join_data['jid'],'cookie_key'=>$this->arsoa_join_key);                              
     								          $this->front_base_model->update_table('ap_member_join_new',$data ,$where);     
                 				      
                 				      $result['status']     = 1;
     								       	  $result['next_url']   = base_url('member_join/pay');
     								    }     								         								 
     								    break;
            }
        }  
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;    
    }    
    
    // 產品選擇
    public function product()
    {
    	  self::join_data_check();
    	  
    	  if (empty($this->arsoa_join_data)){    	      
    	      alert( '操作有誤，請重新登錄會員(J01)！' ,base_url('member_join'));
    	      exit;
    	  }
    	  
    	  //--結帳鎖定通知--
        $this->block_service->dataset('join','pay',base_url());            
        //--結帳鎖定通知-- 
    	  
    	  $data['css'] = array('bs-stepper.min');
    	      	      	  
        $data['join_name'] = $this->join_name;
        
        $data['arsoa_join_data'] = $this->arsoa_join_data;
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        // 必選
        $data['pckpro1'] = $this->front_join_model->ms_pckpro(1,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
        
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
        $data['pckpro2'] = $this->front_join_model->ms_pckpro(2,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
        
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
        //echo "<pre>".print_r($data ,true)."</pre>";exit;
         
        $data['arsoa_join_pckpro']  = $this->arsoa_join_pckpro;
        
        $data['maxamt'] = $maxamt;
        $data['useamt'] = 0;
                
    	  _timer('*** before layout ***');
     
        $this->layout->view('member_join/step_product', $data);      
        
    }
    
    // 選紅利產品
    public function reward()
    {
        self::join_data_check();
        
        if (empty($this->arsoa_join_data)){    	      
    	      alert( '操作有誤，請重新登錄會員(J02)！' ,base_url('member_join'));
    	      exit;
    	  }
    	  
    	  $data['css'] = array('bs-stepper.min');
    	     	      	  
        $data['join_name'] = $this->join_name;
        
        $data['arsoa_join_data'] = $this->arsoa_join_data;
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        $data['pckpro_mp'] = $this->front_join_model->ms_pckpro('mp',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        
        $data['pckpro3'] = $this->front_join_model->ms_pckpro(3,$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        
        $data['pckpro_total_mp'] = self::pckpro_total_mp($data['pckpro_mp'],$data['pckpro3']);
                
        $data['pckpro4'] = $this->front_join_model->ms_pckpro(4,$msconn,array('jointype'=>$this->arsoa_join_data['jointype'],'mp'=>$data['pckpro_total_mp'],'arsoa_join_key' => $this->arsoa_join_key));
         
        if ($data['pckpro4']){        	  
        	  $data['pckpro4_count']  = count($data['pckpro4']);  // 筆數
        	  
        	  $data['pckpro4_protype'] = array();
        	  $protype = '';
        	  foreach ($data['pckpro4'] as $key => $item){
        	  	       if ($protype <> trim($item['protype'])){
        	  	           $data['pckpro4_protype'][] = trim($item['protype']);
        	  	           $data['pckpro4_protype_num'][trim($item['protype'])] = 1;
        	  	       }else{
        	  	       	   $data['pckpro4_protype_num'][trim($item['protype'])] ++;
        	  	       }
        	  	       $protype = trim($item['protype']);
        	  }
        }
        
        if (!$data['pckpro4'] && !$data['pckpro3']){  // 入會750 什麼都沒到確認頁
            redirect( 'member_join/confirm' );
        } 
        
        _timer('*** before layout ***');
     
        $this->layout->view('member_join/step_reward', $data);      
        
    }
    
    // 確認頁
    public function confirm()
    {
        self::join_data_check();
        
        if (empty($this->arsoa_join_data)){    	      
    	      alert( '操作有誤，請重新登錄會員(J03)！' ,base_url('member_join'));
    	      exit;
    	  }
    	  
    	  //--結帳鎖定通知--
        $this->block_service->dataset('join','pay',base_url());            
        //--結帳鎖定通知-- 
    	  
    	  $data['css'] = array('bs-stepper.min');
    	      	  
        $data['join_name'] = $this->join_name;
        
        $msconn = $this->front_mssql_model->ms_connect();
        
        $chkordererrmsg = $this->front_join_model->ms_chkjoin($msconn,$this->arsoa_join_key);
        if ($chkordererrmsg > ''){
            alert($chkordererrmsg,base_url('member_join/form'));
            exit;
        }
        
        $data['arsoa_join_chkpromo'] = $this->front_join_model->ms_chkpromo($msconn,$this->arsoa_join_key);
        
        $data['arsoa_join_data'] = $this->arsoa_join_data;
        
        $data = self::join_check_data($msconn,$data);
        
        if ($data['check_errmsg'] > ''){
            alert( $data['check_errmsg'] ,$data['errurl']);
    	      exit;
        }
              
        $data['sumdetail'] = $this->front_join_model->ms_pckpro('sumdetail',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
                
        $where  = array ('epostid' => 'U010');            
        $data['policy'] = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
        
        _timer('*** before layout ***');
     
        $this->layout->view('member_join/step_confirm', $data);      
    }
    
    // 付款
    public function pay()
    {
        self::join_data_check();
        
        if (empty($this->arsoa_join_data)){    	      
    	      alert( '操作有誤，請重新登錄會員(J06)！' ,base_url('member_join'));
    	      exit;
    	  }
    	  if (!$this->arsoa_join_pckpro[1] && !$this->arsoa_join_pckpro[2]){
    	      alert( '操作有誤，請重新選擇產品(J07)！' ,base_url('member_join/product'));
    	      exit;
    	  }
    	  
    	  //--結帳鎖定通知--
        $this->block_service->dataset('join','pay',base_url());            
        //--結帳鎖定通知--  
    	      	  
    	  $msconn = $this->front_mssql_model->ms_connect();
    	  
    	  $chkordererrmsg = $this->front_join_model->ms_chkjoin($msconn,$this->arsoa_join_key);
        if ($chkordererrmsg > ''){
            alert($chkordererrmsg,base_url('member_join/form'));
            exit;
        }
        
        $data['arsoa_join_data'] = $this->arsoa_join_data;
        
        $data = self::join_check_data($msconn,$data);
        
        if ($data['check_errmsg'] > ''){
            alert( $data['check_errmsg'] ,$data['errurl']);
    	      exit;
        }
        
        $data['sumdetail'] = $this->front_join_model->ms_pckpro('sumdetail',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        
        $purchAmt = $data['sumdetail']['amt'];
        
        $this->load->model( 'front_order_model' );
        
    	  $join_no = $this->front_order_model->web_no('J'); // 訂單單號
    	  
    	  $checkcode = uniqid();
    	  
    	  //　訂單主檔　
        $paramsh = array(
                      'join_no'    => $join_no,
                      'or_date'    => date('Y-m-d H:i:s'),
                      'bv_date'    => $data['sumdetail']['bv_date'],
                      'session_id' => $this->arsoa_join_data['session_id'],
                      'cookie_key' => $this->arsoa_join_data['cookie_key'],
                      'jointype'   => $this->arsoa_join_data['jointype'],
                      'uname'      => $this->arsoa_join_data['uname'],
                      'sex'        => $this->arsoa_join_data['sex'],
                      'idno'       => $this->arsoa_join_data['idno'],
                      'bday'       => $this->arsoa_join_data['bday'],
                      'tel'        => $this->arsoa_join_data['tel'],
                      'email'      => $this->arsoa_join_data['email'],
                      'spouse_name'=> $this->arsoa_join_data['spouse_name'],
                      'spouse_idno'=> $this->arsoa_join_data['spouse_idno'],
                      'spouse_bday'=> $this->arsoa_join_data['spouse_bday'],
                      'city'       => $this->arsoa_join_data['city'],
                      'town'       => $this->arsoa_join_data['town'],
                      'postal'     => $this->arsoa_join_data['postal'],
                      'address'    => $this->arsoa_join_data['address'],
                      'remark'    => $this->arsoa_join_data['remark'],
                      'out_day'    => $this->arsoa_join_data['out_day'],
                      'is_sample'  => $this->arsoa_join_data['is_sample'],
                      'referrer_name'  => $this->arsoa_join_data['referrer_name'],
                      'referrer_c_no'  => $this->arsoa_join_data['referrer_c_no'],
                      'ip'         => $this->arsoa_join_data['ip'],
                      'p_no'         => $this->arsoa_join_data['promo_p_no'],
                      'amt'        => $data['sumdetail']['amt'],
                      'freight'    => $data['sumdetail']['freight'],
                      'ordtotal'   => $data['sumdetail']['ordtotal'],
                      'a_pv'       => $data['sumdetail']['a_pv'],
                      'b_pv'       => $data['sumdetail']['b_pv'],
                      'pv'         => $data['sumdetail']['pv'],
                      'a_amt'      => $data['sumdetail']['a_amt'],
                      'b_amt'      => $data['sumdetail']['b_amt'],
                      'u_amt'      => $data['sumdetail']['u_amt'],
                      'mp_amt'     => $data['sumdetail']['mp_amt'],
                      'r_mp'       => $data['sumdetail']['r_mp'],
                      'p_mp'       => $data['sumdetail']['p_mp'],
                      'm_mp'       => $data['sumdetail']['m_mp'],
                      'mp'         => $data['sumdetail']['mp'],           
                      'pay_statue' => 'N',
                      'checkcode'  => $checkcode
                  );
        
        if ($this->arsoa_join_data['jointype'] != 3){
        	  $paramsh['is_sample'] = 0;
        }
             		
     		$this->front_mssql_model->insert_data($msconn,"jsf_h",$paramsh);
     		
     		$pckpro = $this->front_join_model->ms_pckpro('jsf_b',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
     		
     	//	echo "<pre>".print_r($paramsh,true)."</pre>";
     		
     		foreach ($pckpro as $key => $item){             
                 $paramsb = array(
                                  'join_no'    => $join_no,
                                  'gid'        => trim($item['gid']), 
                                  'pid'        => trim($item['pid']), 
                                  'p_no'       => trim($item['p_no']), 
                                  'p_name'     => trim($item['p_name']), 
                                  'r_price'    => (int)$item['r_price'],
                                  'qty'        => trim($item['qty']),                                          
                                  'mp_amt'     => trim($item['mp_amt']), 
                                  'p_mp'       => trim($item['p_mp']), 
                                  'm_mp'       => trim($item['m_mp']), 
                                  'c_price'    => (int)$item['c_price'],
                                  'a_pv'       => trim($item['a_pv']), 
                                  'b_pv'       => trim($item['b_pv']), 
                                  'pv'         => (int)$item['pv'],
                                  'opv'        => (int)$item['opv'],
                                  'opv_h'      => trim($item['opv_h']), 
                                  'a_amt'      => trim($item['a_amt']), 
                                  'b_amt'      => trim($item['b_amt'])
                            );                               
               //  echo "<pre>".print_r($paramsb,true)."</pre>";           
                 $this->front_mssql_model->insert_data($msconn,"jsf_b",$paramsb);
        }            
        
        $MerchantName = mb_convert_encoding($this->config->item('pay')['MerchantName'], 'BIG-5', "UTF-8");   // 設定特店網站或公司名稱
          
        if ( ENVIRONMENT == 'production' ){
             $OrderDetail = '會員登錄訂單';
        }else{
             $OrderDetail = '測試會員登錄訂單'; 
        }
        $OrderDetail = mb_convert_encoding($OrderDetail, 'BIG-5', "UTF-8").":".$join_no;  
                                
        $action = '';
            
        include APPPATH.'libraries/auth_mpi_mac.php';
        
        $MerchantID = $this->config->item('pay')['card_MerchantID'];        
        $TerminalID = $this->config->item('pay')['card_TerminalID'];     
        /*
        txType
        交易方式，長度為一碼數字： 0 ：一般交易， 1 ：分期交易， 2 ：紅利折抵一般交易。 4 ：紅利折抵分期交易
        */
        $txType="0"; 
        /*
        Option
        產品代碼、分期期數或產品代碼加分期期數，純數字。 (1) 一般特店請填「1」。 
        (2) 分期特店請填長度為一到兩碼的分期期數。 (3) 紅利特店請填長度為固定兩碼的產品代碼。 (4) 紅利分期特店長度為三到四碼，前兩碼固定為產品代碼，後 一碼或兩碼為分期期數。
        */
        $Option="1"; 
        $Key = $this->config->item('pay')['card_key'];   // 壓碼字串               
        $AuthResURL = $this->config->item('pay')['join_card_AuthResURL'];  // 回傳網址              
        /*
        AutoCap
        是否自動請款。 0–不自動請款 1–自動請款
        */
        $AutoCap="0"; 
        /*
        Customize
        設定刷卡頁顯示特定語系或客制化頁面。 1–繁體中文 2–簡體中文 3–英文 5–客制化頁面 
        */
        $Customize="1"; 
        
        $debug="0"; /* debug 預設(進行交易時)請填 0，偵錯時請填 1。*/
                      
        $MACString=auth_in_mac($MerchantID,$TerminalID,$join_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$debug); 
            
        //   echo"InMac=$MACString\n<br><br>"; 
        
        $URLEnc=get_auth_urlenc($MerchantID,$TerminalID,$join_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$MACString,$debug); 
        
        //  echo"UrlEnc=$URLEnc\n"; 
        
        $action = $this->config->item('pay')['card_action'];
        
        $merID = $this->config->item('pay')['card_merID'];
        
        ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
         <title>arsoa pay</title></head><body bgcolor="#FFFFFF">   
          <form id="keyinorder" name="keyinorder" method="post" action="<?=$action?>">
             <table width="540" bgcolor="#999999" style="display:none">     
                <tr>      
                   <td width="100%">       
                     網路特店編號(MerID)：<input type="hidden" name="merID" value="<?=$merID?>" >      
                   </td>     
                </tr>     
                <tr>      
                   <td width="100%">加密值： <input type="hidden" name="URLEnc" value="<?=$URLEnc?>">      </td>  
               </tr>    
               <tr bgColor=#aedcff>               
                   <td align="middle">      
                      <input name="imageField" type="submit" value="Pay by credit card" border=0 height="32" width="161">    
                   </td>     
               </tr>      
             </table>   
          </form>  
          </body>
          <script>document.keyinorder.submit();</script>
        </html>         
        <?php    
    	  exit;
    }
    
    // 付款回來
    public function auth($payment = 'C',$test = '')
    {
        $paycheck = 'N';        
        $debug = "0";         
        $checkcode = '';
        if ($payment == 'C'){
            $data_post = $this->input->post();
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                              
                 include APPPATH.'libraries/auth_mpi_mac.php'; 
                 
                 $merID = $data_post['merID'];  
                 $EncRes = $data_post['URLResEnc'];  // 回傳的密文，請參考3.8特店網站設定AuthResURL(加密專用)取得URLResEnc  
                
                 $Key = $this->config->item('pay')['card_key'];                  
                 $EncArray=gendecrypt($EncRes,$Key,$debug);                  
                 
                 if ($test == 'Y'){
                     foreach($EncArray AS $name => $val){  
                         echo $name ."=>". urlencode(trim($val,"\x00..\x08")) ."<br>\n"; 
                     }       
                 }  
                 
                 $status = isset($EncArray['status']) ? $EncArray['status'] : ""; // 交易狀態碼
                 $errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : "";   // 交易錯誤碼
                 $errdesc = isset($EncArray['errdesc']) ? $EncArray['errdesc'] : "";   // 交易錯誤訊息
                 $merid = isset($EncArray['merid']) ? $EncArray['merid'] : "";   // 特店代碼
                 $authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";  // 交易授權碼
                 $authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";   // 交易金額
                 $join_no = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";  //訂單編號      
                 $xid = isset($EncArray['xid']) ? $EncArray['xid'] : "";  //授權之交易序號
                 $last4digitpan = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";   //卡號末四碼
                 $authresurl = isset($EncArray['authresurl']) ? $EncArray['authresurl'] : "";            // 回傳網址
                 
                 $OffsetAmt = isset($EncArray['OffsetAmt']) ? $EncArray['OffsetAmt'] : "";       
                 $OriginalAmt = isset($EncArray['OriginalAmt']) ? $EncArray['OriginalAmt'] : "";       
                 $UtilizedPoint = isset($EncArray['UtilizedPoint']) ? $EncArray['UtilizedPoint'] : "";       
                 $Option = isset($EncArray['numberofpay']) ? $EncArray['numberofpay'] : ""; // 分期期數
                 
                 /*
                    //紅利交易時請帶入prodcode 
                   $Option = isset($EncArray['prodcode']) ? $EncArray['prodcode'] : ""; 
                 
                   $CardNumber = isset($EncArray['cardnumber']) ? $EncArray['cardnumber'] : "";  // 隱碼卡號
                   $CardNo  = isset($EncArray['cardno']) ? $EncArray['cardno'] : "";//(僅供優化環境使用)       
                   $EInvoice  = isset($EncArray['einvoice']) ? $EncArray['einvoice'] : "";//(僅供優化環境使用) 
                 
                 */   
                                                
                 $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$join_no,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option,$last4digitpan,$Key,$debug);    
                
                 if  ($MACString == $EncArray['outmac']){                      
                      $msconn = $this->front_mssql_model->ms_connect();  
            
                      $params = array ($join_no); 
                      $data = $this->front_mssql_model->get_data($msconn,"select join_no,cookie_key,isnull(pay_date,'') as pay_date,checkcode from jsf_h where join_no = ?",$params);
                      
                      if (count($data) > 0){
                       
                          if ($test == 'Y'){
                              echo "<pre>".print_r($data[0],true)."</pre>";
                          }
                      
                          $data = $data[0];
                          
                          if (trim($data['pay_date']) <> '1900-01-01 00:00:00.000'){
                              alert( $join_no.' 此付款已經交易過！',base_url('member_join') );
                              exit;                              
                          }
                          
                          $checkcode = trim($data['checkcode']);
                          
                          $uparams = array (
                                             'buysafeord'   => trim($xid),  
                                             'status'       => trim($status)
                                           );
                                    
                          if ($status == '0'){ // 付款成功
                              $uparams['Last4digitPAN'] = trim($last4digitpan);
                              $uparams['pay_statue'] = 'Y';
                              $uparams['pay_amt'] = $authAmt;                                                 
                              $paycheck = 'Y';
                          }else{               // 付款失敗
                              $uparams['pay_statue'] = 'F';
                              $uparams['pay_amt'] = 0;
                          }
                          if ($test == 'Y'){
                              echo "<pre>".print_r($uparams,true)."</pre>";
                          }
                          $uparams['ApproveCode'] = trim($authCode);
                          $uparams['errcode']     = trim($errCode);
                          $uparams['pay_date']    = date('Y-m-d H:i:s');
                          
                          $this->front_mssql_model->update_data($msconn,"jsf_h",$uparams,array('join_no'=>$join_no));   
                        
                          if ($paycheck == 'Y'){ // 付款成功
                              // 刷卡成功清空購物車                                          
                              $this->session->unset_userdata( 'arsoa_join_key' );  
                              
                              // -- Line 綁定 key -- Start
                              $this->load->model( 'Member_line_model' );
                              
                              $params = array ($join_no); 
                              $jsf_h_data = $this->front_mssql_model->get_data($msconn,"select c_no,jointype,uname,referrer_name,referrer_c_no,checkcode from jsf_h where join_no = ?",$params)[0];
                      
                              $idata = array(
                                             'c_no'      => $jsf_h_data['c_no'],
                                             'c_name'    => $jsf_h_data['uname'],
                                             'join_no'   => $join_no,    
                                             'bind_type' => 'J',
                                             'bind_code' => $jsf_h_data['checkcode'],
                                            );                                            
                              $this->Member_line_model->insert_data($idata);
                              // -- Line 綁定 key -- End
                              
                              $join_mail_body = "入會編號：".$jsf_h_data['c_no']."\n<br>姓名：".$jsf_h_data['uname']."\n<br>推薦人：".$jsf_h_data['referrer_name']."(".$jsf_h_data['referrer_c_no'].")\n<br>入會方式：".$this->join_name[$jsf_h_data['jointype']]."\n<br>付款金額：".$authAmt." 元";
                              
                              $this->block_service->send_email(FC_Email,'會員登錄付款成功('.$jsf_h_data['c_no'].')',$join_mail_body);	                              
                              
                              $this->load->helper('cookie');           
                              delete_cookie("arsoa_join_key");
                          }
                      }else{                       
                          alert( '操作有誤煩請重新訂購(PAY01)！',base_url('member_join/confirm') );
                          exit;
                      }
                 }else{
                      alert( '操作有誤煩請重新訂購(PAY02)！',base_url('member_join/confirm') );
                      exit;
                 }                 
            }else{
                 alert( '操作有誤煩請重新訂購(PAY03)！',base_url('member_join/confirm') );
                 exit;
            }                 
        }
     
        if ($paycheck == 'Y'){ // 付款成功            
            ?>
            <html>
            <head>
            <title><?=FC_Web?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </head>
            <body>
            <form method="post" name="goorder" action="<?=base_url('member_join/complete')?>" >
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							 
            <input type="hidden" name="jd" value="<?=$join_no?>">
            <input type="hidden" name="cc" value="<?=$checkcode?>">            
            </form>
            </body>
            </html>
            <script>
            document.goorder.submit();
            </script>
            <?php                        
        }else{
            alert( '付款失敗，煩請重新訂購('.$errCode.')！',base_url('member_join/confirm') );            
        }
        exit;
    }
    
    public function complete()
    {
    	  $data_post = $this->input->post( NULL, true );        
    	  /*
    	  $data_post['jd'] = 'J211200019';
    	  $data_post['cc'] = '61cda0a199439';
    	  */
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             $data['jd']   = trim($data_post['jd']);
             $data['cc']   = trim($data_post['cc']);
             
             $msconn = $this->front_mssql_model->ms_connect();  
             
             $data['order_detail'] = $this->front_join_model->order_detail($msconn,$data['jd'],$data['cc']);
            
             if ($data['order_detail']){                             
                 $data['join_name'] = $this->join_name;
                 
                 $meta['title2'] = '新登錄會員-付款成功資料檢視';
                 $meta['title1'] = FC_Web.' - '.$meta['title2'];
                 $data['meta']['canonical'] = site_url();
                 $data['meta'] = $meta;           
                 
                 $data['arsoa_join_data'] = $data['order_detail']['main'];
                 $data['sumdetail'] = $data['order_detail']['main'];
               
                 foreach ($data['order_detail']['prd'] as $item){
                 	        $item['price'] = $item['c_price'];
                 	        $data['pckpro'.$item['gid']][] = $item;                 	
                 }
                 
                 $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_url').'/m_'.$data['cc'];
                 
                 $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
                  
                 $this->layout->view('member_join/step_complete', $data);               
            }else{
                 alert( '無此登錄會員資訊！',base_url('member_join'));
                 exit;
            }
        }else{  
            alert( '操作有誤(er99)！',base_url('member_join'));
            exit;    
        }
    }
    
    // 抓出放入車的產品數
    public function pckpro_num($itype)
    {
         self::join_data_check();
         
         $result = array('status' => 1);  
    		 $result['prd_num'] = $this->front_join_model->check_cart_num($this->arsoa_join_pckpro,$itype);  
         echo json_encode($result);
         exit;
    }
    
    // 分類更換
    public function pckpro_protype($itype)
    {
        self::join_data_check();
        
        $result = array('html' => '');
        $data_post = $this->input->post( NULL, FALSE );        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){ 
             $itype_title1 = '建議售價';
             $itype_title2 = '$';
             $itype_title3 = '購買';
             $itype_title4 = '已購';
             $itype_field = 'price';
             $itype_unit = '元';
             if ($itype == '4'){
                 $itype_title1 = '紅利點數';
                 $itype_title2 = '';
                 $itype_title3 = '兌換';
                 $itype_title4 = '已兌';
                 $itype_field = 'm_mp';
                 $itype_unit = '點數';
             }
             $msconn = $this->front_mssql_model->ms_connect();  
             if ($itype == '4'){                 
                 $data['pckpro_mp'] = $this->front_join_model->ms_pckpro('mp',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
                 
        				 $data['pckpro3'] = $this->front_join_model->ms_pckpro(3,$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        				 
        				 $data['pckpro_total_mp'] = self::pckpro_total_mp($data['pckpro_mp'],$data['pckpro3']);
        				 
        				 $pckpro = $this->front_join_model->ms_pckpro(4,$msconn,array('jointype'=>$this->arsoa_join_data['jointype'],'mp'=>$data['pckpro_total_mp'],'arsoa_join_key' => $this->arsoa_join_key));
             }else{
                 $pckpro = $this->front_join_model->ms_pckpro($itype,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
             }
             if ($pckpro){                
       	         $result['html'] = '<thead class="thead-dark"><tr><th class="text-left">產品名稱</th>';
        	       if ($data_post['protype'] == 'cart'){
        	           $result['html'] .= '<th>'.$itype_title1.'</th>
            					                   <th width="15%">數量</th>
            					                   <th>小計</th>
            					                   <th>刪除</th>';
        	       }else{
        	           $result['html'] .= '<th width="15%">數量</th>
            					                   <th>'.$itype_title1.'</th>
            					                   <th>訂購</th>';
        	       }
        	       $result['html'] .= '</tr>
																	  </thead>';				
								 $prdnum = 0;
								 $total_price = 0;
        	       foreach ($pckpro as $key => $item){
                       if ($data_post['protype'] == 'cart'){
                            if ($this->front_join_model->check_cart($this->arsoa_join_pckpro,$itype,trim($item["p_no"]))){
                                $prdnum++;
                                $p_num = $this->front_join_model->check_cart_prd_num($this->arsoa_join_pckpro,$itype,trim($item["p_no"]));
                                $total_price += ($item[$itype_field]*$p_num);
                                $result['html'] .= '
                       			          <tr>
															            <td class="text-left">'.$this->block_service->load_join_product(trim($item['p_no']),trim($item['p_name']),$item[$itype_field],$itype_unit).'</td>
            					 			              <td>'.$itype_title2.''.number_format($item[$itype_field]).'</td>
            					 			              <td class="form-group" style="width:160px;display: inline-block;white-space: nowrap;"><a href="javascript:void(0)" onclick="ChangeProductNum(\'Minus\', \''.$prdnum.'\', \'1\');change_cart(\'C\');" title="減少" class="button-icon-light" ><i class="ion-minus"></i></a>
                       			                 <input name="num_'.$prdnum.'" id="num_'.$prdnum.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" readonly unselectable="on" type="text" class="input-num" title="數量" value="'.$p_num.'" maxlength="2">
                       			                 <a href="javascript:void(0)" onclick="ChangeProductNum(\'Add\', \''.$prdnum.'\', \'99\');change_cart(\'C\');" title="增加" class="button-icon-light" ><i class="ion-plus"></i></a>                                                   
                       			                 <input type="hidden" name="p_no_'.$prdnum.'" id="p_no_'.$prdnum.'" value="'.trim($item['p_no']).'">
                       			                 <input type="hidden" name="pid_'.$prdnum.'" id="pid_'.$prdnum.'" value="'.trim($item['pid']).'"></td>
            					 			             <td>'.$itype_title2.''.number_format($item[$itype_field]*$p_num).'</td>
            					 			             <td><input type="checkbox" name="del_prd[]" id="del_prd[]" value="'.trim($item['p_no']).'" onclick="change_cart(\'C\');"></td>
            					 			          </tr>';
                            }
                       }else{
                       			if (trim($item['protype']) == trim($data_post['protype'])){                            
                       			    $p_num = $this->front_join_model->check_cart_prd_num($this->arsoa_join_pckpro,$itype,trim($item["p_no"]));
                       			    
                       			    $prdnum++;
                       			    if ($this->front_join_model->check_cart($this->arsoa_join_pckpro,$itype,trim($item["p_no"]))){
                       			        $showcard = '<a href="javascript:void(0);" onclick="join_incar(\''.$itype.'\',\''.trim($item["p_no"]).'\',\''.trim($item["pid"]).'\','.$prdnum.');" title="更換產品數量" class="btn btn-outline-info btn-sm"><i class="icon ion-ios-cart"></i> '.$itype_title4.' ('.$p_num.')</a>';
                       			    }else{                               
                       			     	  $showcard = '<a href="javascript:void(0);" onclick="join_incar(\''.$itype.'\',\''.trim($item["p_no"]).'\',\''.trim($item["pid"]).'\','.$prdnum.');" title="放入購物車" class="btn btn-outline-info btn-sm"><i class="icon ion-ios-cart-outline"></i> '.$itype_title3.' </a>';
                       			    }
                       			    if ($p_num == ''){  $p_num = 1; }
                       			    
                       			    $result['html'] .= '<tr>'.
															           '<td class="text-left">'.$this->block_service->load_join_product(trim($item['p_no']),trim($item['p_name']),$item[$itype_field],$itype_unit).'</td>'.
            					 			             '<td class="form-group" style="width:160px;display: inline-block;white-space: nowrap;"><a href="javascript:void(0)" onclick="ChangeProductNum(\'Minus\', \''.$prdnum.'\', \'1\');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>'.
                       			                 '<input name="num_'.$prdnum.'" id="num_'.$prdnum.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" readonly unselectable="on" type="text" class="input-num" title="數量" value="'.$p_num.'" maxlength="2">'.
                       			                 '<a href="javascript:void(0)" onclick="ChangeProductNum(\'Add\', \''.$prdnum.'\', \'99\');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a></td>'.
            					 			             '<td>'.$itype_title2.''.number_format($item[$itype_field]).'</td>'.
            					 			             '<td id="join_prd_'.$prdnum.'">'.$showcard.'</td>'.
            					 			          '</tr>';
            					 			}
            					 }
                 }
                 if ($data_post['protype'] == 'cart'){
                     if ($prdnum > 0){
                         $result['html'] .= '<tr>
															        			    <td class="text-right" colspan="2"></td>
															        			    <td>合計</td>
															        			    <td>'.$itype_title2.''.number_format($total_price).'</td>
															        			    <td><button type="button" onclick="join_cart_change('.$itype.','.$this->arsoa_join_data['jointype'].');" class="btn btn-outline-secondary">更改</button></td>
            					 			          			</tr><input type="hidden" name="p_num" id="p_num" value="'.$prdnum.'">';
            				 }else{
            				      $result['html'] .= '
                       			          <tr>
															            <td class="text-left" colspan="5">尚未選擇產品</td>
            					 			          </tr>';
            				 }
                 }
            }
        }
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;    
    }
    
    // 產品放入購物車
    public function join_incart($itype)
    {
        self::join_data_check();
        
        $result = array('status' => 0, 'errcode' => '', 'errmsg' => '');  
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if ($this->front_join_model->in_join_cart($this->arsoa_join_jid,$this->arsoa_join_pckpro,$itype,$data_post['p_no'],$data_post['pid'],$data_post['num']) == 1){
                 $result['errmsg'] = "已加入購物車！";
                 $result['status'] = 1;
                 
                 // 產品放入購物車 -- 重新抓資料出來比對
                 $this->arsoa_join_data = $this->front_base_model->get_data('ap_member_join_new',array('cookie_key'=>$this->arsoa_join_key,'pay_statue'=>'N'),'',1);            
                 if ($this->arsoa_join_data){                 	   
                 	   for ($i = 1;$i<= 4;$i++){
                 	  	    $this->arsoa_join_pckpro[$i] = json_decode($this->arsoa_join_data['pckpro'.$i], true);  
                 	   }
                 }
             }else{
                 $result['errmsg'] = "已更改此產品於購物車數量！";                 
             }                  
         }
         
         // 抓產品數量
         $result['prd_num'] = $this->front_join_model->check_cart_num($this->arsoa_join_pckpro,$itype);  
         $this->output->set_content_type('application/json');         
         echo json_encode($result);
         exit;
    }   
    
    // 產品資料顯示
    public function product_show()
    {
        self::join_data_check();
        
        $result = array('status' => 0, 'imgsrc' => '', 'desc' => '');  
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             $p_no   = trim($data_post['p_no']);
             
             $prddata = $this->front_product_model->get_data_join($p_no);
      
        		 if ($prddata){
        		     $result['status'] = 1;
        		     $result['imgsrc'] = base_url('public/prdimages/'.$p_no).".png";
        		     if ($prddata['pro_title1'] > ''){
        		         $result['desc'] = '<p>'.$prddata['pro_title1'].'<br>'.$prddata['pro_title2'].'</p>';
        		     }else{
        		         $result['desc'] = '<p>'.$prddata['pro_desc'].'</p>';
        		     }        		     
        		 }             
        }
        $this->output->set_content_type('application/json');         
        echo json_encode($result);
        exit;
    }
    
    // mp + 贈品 可能會送 mp
    private function pckpro_total_mp($mp,$pckpro3)
    {
        $pckpro_total_mp = $mp;
        
        if ($pckpro3){
            foreach ($pckpro3 as $key => $item){
                     if ($item['mp3'] > 0){
                         $pckpro_total_mp += $item['mp3'];
                     }
            }            					                	
        }
        
        return $pckpro_total_mp;
    }
    
    // 確認資料裡面有沒有問題
    private function join_check_data($msconn,$data)
    {
        if (!$this->arsoa_join_data){
             self::join_data_check();
        }
        
        $data['check_errmsg'] = '';
        
        $data['pckpro_data1'] = $this->front_join_model->ms_pckpro(1,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
        $data['pckpro_data2'] = $this->front_join_model->ms_pckpro(2,$msconn,array('jointype'=>$this->arsoa_join_data['jointype']));
        $data['pckpro_mp'] = $this->front_join_model->ms_pckpro('mp',$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        $data['pckpro_data3'] = $this->front_join_model->ms_pckpro(3,$msconn,array('arsoa_join_key'=>$this->arsoa_join_key));
        
        $data['pckpro_total_mp'] = self::pckpro_total_mp($data['pckpro_mp'],$data['pckpro_data3']);
        
        $data['pckpro_data4'] = $this->front_join_model->ms_pckpro(4,$msconn,array('jointype'=>$this->arsoa_join_data['jointype'],'mp'=>$data['pckpro_total_mp'],'arsoa_join_key' => $this->arsoa_join_key));
        
        $data['sel_pckpro1'] = json_decode($this->arsoa_join_data['pckpro1'], true);
        $data['sel_pckpro2'] = json_decode($this->arsoa_join_data['pckpro2'], true);
        $data['sel_pckpro3'] = json_decode($this->arsoa_join_data['pckpro3'], true);
        $data['sel_pckpro4'] = json_decode($this->arsoa_join_data['pckpro4'], true);
        
        if (!$data['sel_pckpro1'] && !$data['sel_pckpro2']){  // 都沒有選的產品
            $data['check_errmsg'] = '操作有誤，請重新登錄會員(J04)！';
            $data['errurl'] = base_url('member_join');
            return $data;
        }
        $total_mp = 0;
        // 用 SP 抓出的產品,再和放入車子的做比對,再到確認頁
        for ($i = 1;$i<=4;$i++){        
             $data['pckpro'.$i] = array();
             if ($data['pckpro_data'.$i] && $data['sel_pckpro'.$i]){  
                 foreach ($data['sel_pckpro'.$i] as $skey => $sitem){
                          $pro_chk = true;
                          foreach ($data['pckpro_data'.$i] as $key => $item){                          
                                   if (trim($item['p_no']) == trim($sitem['p_no'])){
                                       $item['qty'] = $sitem['qty'];
                                       $data['pckpro'.$i][] = $item;
                                       if ($i == 4){
                                           $mp_total = $item['m_mp']*$sitem['qty'];
        		                               $total_mp += $mp_total;
                                       }
                                       $pro_chk = false;
                                   }
                          }
                          if ($pro_chk){
                              $data['check_errmsg'] = '操作有誤，請重新選擇產品(J05)！';
                              $data['errurl'] = base_url('member_join/product');
                              return $data;
                          }
                 }                 
             }
        }
        
        if ($total_mp > $data['pckpro_total_mp']){
		    		$m_mp = $total_mp - $data['pckpro_total_mp'];
		    	  $data['check_errmsg'] = '可兌換紅利點數 '.number_format($data['pckpro_total_mp']).'，您選擇的點數 '.number_format($total_mp).'，已超過 '.number_format($m_mp).' 點！';		       	
            $data['errurl'] = base_url('member_join/reward');
            return $data;
                              
        }                 			
        
        return $data;
    }
    
} 