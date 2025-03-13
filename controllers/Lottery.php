<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lottery extends MY_Controller
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
        $this->load->model( 'lottery_model' );
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
                
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
                
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        
    /*
        http://localhost/arsoa/lottery/test
        輪盤 xvqI1VwDJ 
        J7Nn3PPmn 拉霸
        iut82NxsE 刮
    */
    public function test($checkcode = 'xvqI1VwDJ')
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
       
       $lottery_data = $this->lottery_model->find_one('checkcode',$query);       
       if ($lottery_data){
       	   $data['query']         = $query;       	   
           $data['view']          = $view;
           $data['data']          = $lottery_data;
           $data['dev']           = ''; 
           
           $data['liff_url'] = $this->config->item('line_liff_lottery_url');
           
           $this->layout->view('line/liff_lottery', $data);
       }else{
       	   alert('操作有誤(Lot99)，無活動進行！',base_url());
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
             	  $data['line_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$query;
             	  
             	  $result['msg']  = '親愛的來賓您好：<br><br>';
             	  $result['msg'] .= '請先加入好友，或解除封鎖 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank>安露莎官方Line</a>，才可進行相關作業！<br><a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target=_blank><img src="'.base_url('public/images/qr.png').'"></a><br>';
             	  $result['msg'] .= '<button type="button" class="btn btn-info" onClick="location.href=\''.$data['line_url'].'\'">重新抽獎</button>';
             }else{
                 if ($line_user_data)
                 {
                     $lottery_data = $this->lottery_model->find_one('checkcode',$query);
                     
                     if ($lottery_data){
                         $this->session->set_userdata('line_user_id', $data_post['userId'] );
                         $this->session->set_userdata('line_display_name', $line_user_data['display_name'] );
                         
                         $errmsg_data = self::lottery_check($query,$lottery_data,$data_post['userId'],$line_user_data['display_name']);                         
                        
                         if (!$errmsg_data['status']){
                         	   if ($errmsg_data['errmsg'] == 'redirect'){
                                 
                             }else{
                                 $result['msg'] = str_replace("\\n",'<br>',$errmsg_data['errmsg']);
                             }
                         	   if ($errmsg_data['gourl'] > ''){
                         	   	   $result['goline'] = $errmsg_data['gourl'];                                    
                         	   }
                         	   
                         }else{                             
                             $result['goline'] = base_url('lottery/form/'.$query);                                    
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
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認！',$err_url );    	     
    	         exit;
    	     }    	
    	 }     
    	 $lottery_data = $this->lottery_model->find_one('checkcode',$query,$preview); 
    	
       if ($lottery_data)
       {
       	   if (!$preview){
           			$errmsg_data = self::lottery_check($query,$lottery_data,$this->session->userdata('line_user_id'),$this->session->userdata('line_display_name'));           
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
       	   alert('活動已結束！',base_url());
    	     exit;
       }
       
       $data['lottery_data']                 = $lottery_data;           
       $data['lottery_data']['lot_data']     = json_decode($lottery_data['lot_data'], true);                             
       $data['lottery_data']['lot_config']   = json_decode($lottery_data['lot_config'], true);                             
       
              
       $data['query']         = $query;
       $data['preview']       = $preview;
       $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
       
       $data['disabled']      = '';
       
       if (!$preview){
           /*
           $data['params'] = $this->lottery_model->charge_last_data($this->session->userdata('line_user_id')); // 是否有申請過              
       
           if ($data['params']){
       	       $data['disabled'] = ' disabled';
       	       $citydata = $this->front_base_model->get_data('city',array('citytitle' => $data['params']['city'] ),array('cityno'=>'asc'));
       	       if ($citydata){
       	           $data['params']['cityno'] = $citydata[0]['cityno'];
       	           $data['town']  = $this->front_base_model->get_data('town',array('cityno' => $data['params']['cityno'] ),array('postal'=>'asc'));                       	   
       	       }
       	   }
       	   */
       }
       
       // $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
      // echo "<pre>".print_r($data,true)."</pre>";
      //exit;
       echo $this->load->view('lottery/type_'.$lottery_data['lot_type'], $data, TRUE); 
       exit;
       
    }  
    
    public function award($query)
    {
    	    $result = array('msg' => '');
    	    
    	    if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
    	        $lottery_data = $this->lottery_model->find_one('checkcode',$query);     
    	    }else{
    	    	  $lottery_data = $this->lottery_model->find_one('checkcode',$query,true);     
    	    }
    	    
          if ($lottery_data)
          {
          	  $award_num = 0;              
          	  $lottery_data['lot_data']     = json_decode($lottery_data['lot_data'], true);
          	  $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);    
          	  
          	  // -- 獎項有沒有再來一次
          	  $_i_have_again = false;
          	  foreach ($lottery_data['lot_data'] as $key => $item)
              {
              	  if ($item['type'] == 'A'){  
              	  	  $_i_have_again = true;
              	  }
              } 
          	  
          	  $user_have_again = false;
          	  if ($_i_have_again){
          	      // 判斷是否已有抽過再抽一次,有抽過要去掉 -- start
          	      $charge_check = $this->lottery_model->charge_check($lottery_data['lot_id'],$this->session->userdata('line_user_id'));
                  $charge_check['lot_item']     = json_decode($charge_check['lot_item'], true);                            
                  if ($charge_check['lot_item']['type'] == 'A'){  // 再抽一次
                  	  $user_have_again = true;
                  }   	 
              }
          	            	  
          	  $lot_num = count($lottery_data['lot_data']);          	  
          	  foreach ($lottery_data['lot_data'] as $key => $item)
              {
              	     if (!$user_have_again || $item['type'] != 'A'){  // 當
              	     	   $lottery_data['lot_data'][$key]['use_num'] = $this->lottery_model->charge_find_use_count($lottery_data['lot_id'],$key);    // 可抽獎獎品數量               
              	         $num = $item['num'] - $lottery_data['lot_data'][$key]['use_num'];
              	     }else{
              	     	   $num = 0;
              	     }
              	     
              	     if ($num < 0){
                         $num = 0;
                     }              	     
              	     $lottery_data['lot_data'][$key]['num'] = $num;              	     
              	     $award_num += $num;              	     
                     if ($item['set_item'] == 'Y'){
                         $set_item_key = $key;
                     }
              }   
                // echo "<pre>".print_r($lottery_data,true)."</pre>";
//exit;        
              $prizes = array();                            
              foreach ($lottery_data['lot_data'] as $key => $item)
              {
                       $num = $item['num'];
                       if ($award_num > 0){
                           $probability = round(($item['num'] / $award_num),2);     // 獎品數量 / 總數量 = 中獎比率
                       }else{
                       	   $probability = 0;
                       	   if ($set_item_key == $key){
                       	   	   $probability = 1;
                       	   	   $num = 10;
                       	   }
                       }
                       
                       $prizes[] = array(
                                     'key'					=> $key, 
                                     'name'					=> $item['title'], 
                                     'item'					=> $item, 
                                     'quantity'			=> $num, 
                                     'type'					=> $item['type'],
                                     'probability'	=> $probability,
                                   );                       
              }
              // echo "<pre>".print_r($prizes,true)."</pre>";
              // exit;
              $winner = $this->doDraw($prizes);
       
          	  switch ($lottery_data['lot_type']){
		       			   case "2":
		       			        $result = array('image' => base_url('public/func/'.$winner['item']['image']).'?'.date('YmdHis'));
		       			        if ($this->session->userdata('line_user_id') > ''){
		       			            //$charge_last_data = $this->lottery_model->charge_last_data($lottery_data['lot_id'],$this->session->userdata('line_user_id')); // 是否有資料
		       			            $charge_last_data = $this->lottery_model->charge_last_lot_key_data($lottery_data['lot_id'],$this->session->userdata('line_user_id'),$winner['key']); // 是否有資料              	      
              	      
              	            $c_no = '';
              	            $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));
                            if ($line_id_data){    
                                $c_no     = $line_id_data['c_no'];       					         				 
                            }
                            
                            $charge_checkcode = uniqid();
              	            
              	            $data = array(
     					 		                        "lot_id"    => $lottery_data['lot_id'],
     					 		                        "user_id"	=> $this->session->userdata('line_user_id'),
     					 		                        "display_name" => mb_substr($this->session->userdata('line_display_name'),0,20),       				    
     					 		                        "lot_dt" => date('Y-m-d H:i:s'),
     					 		                        "lot_key" => $winner['key'],
     					 		                        "c_no" => $c_no,
     					 		                        "lot_title" => $winner['item']['title'],
     					 		                        "lot_item" => json_encode($winner['item']),
     					 		                        "status" => $winner['type'],
     					 		                        "checkcode" => $charge_checkcode,
     					 		                        "ip" => $this->data['tracking']['ip'],     					 		              
     					 		          );     					 		     					 	
     					 		          
     					 		          if ($charge_last_data){
     					 		              $this->lottery_model->charge_update_data($charge_last_data['id'],$data);
     					 		          }else{     			
     					 		          	  $data['crdt']	= date('Y-m-d H:i:s');
     					 		          	  $this->db->insert('ap_lottery_charge', $data);     					 		     					 		            
     					 		          }     		
		       			        }
		       			        if ($winner['type'] == 'Y'){
		       			        	   if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊
		       			        	       $result['showhtml'] = '<img class="show_bg" src="'.base_url('public/lottery/2/images/ok_1.png').'" style="border-radius: 10px;">';
		       			        	   }else{
		       			        	   	   $result['showhtml'] = '<img class="show_bg" src="'.base_url('public/lottery/2/images/ok_2.png').'" style="border-radius: 10px;">';
		       			        	   }
		       			        	   
			                       $result['showhtml'] .= '<img class="show_food" id="show_food" src="'.base_url('public/func/'.$winner['item']['image']).'?'.date('YmdHis').'" />';
			                       if ($this->session->userdata('line_user_id') > ''){
			                           if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊
              	  	                 $result['showhtml'] .= '<a class="btn" href="'.base_url('lottery/information/'.$charge_checkcode).'"></a>';	
              	  	             }else{
              	  	             	   $result['showhtml'] .= '<a class="btn" href="javascript:void(0);" onclick="alert(\'現場領取\');"></a>';
              	  	             }
			                       }else{
			                       	   if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊
			                       	       $result['showhtml'] .= '<a class="btn" href="javascript:void(0);" onclick="alert(\'後台預覽 無法填寫\');"></a>';
			                       	   }else{
			                       	   	   $result['showhtml'] .= '<a class="btn" href="'.base_url().'"></a>'; 
			                       	   }
			                       }			                       
		       			        }else{
		       			        	  if ($winner['type'] == 'A'){  // 再抽一次
		       			        	  	  $result['showhtml'] = '<img class="show_bg" src="'.base_url('public/lottery/2/images/again.png').'" style="border-radius: 10px;">
		       			        	                             <img class="show_bg1" src="'.base_url('public/lottery/2/images/ok1.png').'">
			                                                 <img class="show_food" id="show_food" src="'.base_url('public/func/'.$winner['item']['image']).'?'.date('YmdHis').'" />';
			                          $result['showhtml'] .= '<a class="btn" href="'.base_url('lottery/form/'.$query).'"></a>'; 
		       			        	  }else{
		       			        	      $result['showhtml'] = '<img class="show_bg" src="'.base_url('public/lottery/2/images/no.png').'" style="border-radius: 10px;">
		       			        	                             <img class="show_bg1" src="'.base_url('public/lottery/2/images/ok1.png').'">
			                                                 <img class="show_food" id="show_food" src="'.base_url('public/func/'.$winner['item']['image']).'?'.date('YmdHis').'" />';
			                          $result['showhtml'] .= '<a class="btn" href="'.base_url().'"></a>'; 
			                      }
		       			        }     
		       				      break;
		       				 case "3":
		       				      if ($this->session->userdata('line_user_id') > ''){
		       			            $charge_last_data = $this->lottery_model->charge_last_lot_key_data($lottery_data['lot_id'],$this->session->userdata('line_user_id'),$winner['key']); // 是否有資料
              	      
              	            $c_no = '';
              	            $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));
                            if ($line_id_data){    
                                $c_no     = $line_id_data['c_no'];       					         				 
                            }
                            
                            $charge_checkcode = uniqid();
              	            
              	            $data = array(
     					 		                        "lot_id"    => $lottery_data['lot_id'],
     					 		                        "user_id"	=> $this->session->userdata('line_user_id'),
     					 		                        "display_name" => mb_substr($this->session->userdata('line_display_name'),0,20),       				    
     					 		                        "lot_dt" => date('Y-m-d H:i:s'),
     					 		                        "lot_key" => $winner['key'],
     					 		                        "c_no" => $c_no,
     					 		                        "lot_title" => $winner['item']['title'],
     					 		                        "lot_item" => json_encode($winner['item']),
     					 		                        "status" => $winner['type'],
     					 		                        "checkcode" => $charge_checkcode,
     					 		                        "ip" => $this->data['tracking']['ip'],     					 		              
     					 		          );     					 		     					 	
     					 		          
     					 		          if ($charge_last_data){
     					 		              $this->lottery_model->charge_update_data($charge_last_data['id'],$data);
     					 		          }else{     			
     					 		          	  $data['crdt']	= date('Y-m-d H:i:s');
     					 		          	  $this->db->insert('ap_lottery_charge', $data);     					 		     					 		            
     					 		          }     		
		       			        }
		       			        $result['award'] = $winner['key']+1;
		       			        $result['status'] = $winner['type'];
		       			        $result['award_title'] = $winner['item']['title'];
		       			        if ($winner['type'] == 'Y'){
		       			        	   $result['showhtml'] = '您抽中 '.$result['award_title'];
		       			        	   $result['showhtml'] .= '<br>';
			                       if ($this->session->userdata('line_user_id') > ''){
			                           if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊                       			                           
              	  	                 $result['showhtml'] .= "<a href=\"".base_url('lottery/information/'.$charge_checkcode)."\" style=\"color:#e5004a;\">填寫收件地址</a>";	
              	  	             }else{
              	  	             	   $result['showhtml'] .= '現場領取';
              	  	             }
			                       }else{
			                       	   $result['showhtml'] .= '後台預覽 無法填寫';
			                       }			                       
		       			        }else{
		       			        	  $result['showhtml'] = $winner['item']['title'];
		       			        }     
		       				      break;
		       			   default:
		       			        break;
		       	  }
          	  
          }  
          
          $this->output->set_content_type('application/json');            
          echo json_encode($result);         
          exit;  
    	    
    }
    
    public function whichaward($query)
    {
    	    $result = array('msg' => '');
    	    
    	    $data_post = $this->input->post( NULL, TRUE );         
    	            
          $lottery_data = $this->lottery_model->find_one('checkcode',$query);     	
          if ($lottery_data)
          {
              $lottery_data['lot_data']     = json_decode($lottery_data['lot_data'], true);
              $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
           
              $lot_num = count($lottery_data['lot_data']);
              
              $award_num = 0;              
              $set_item_key = '';
              foreach ($lottery_data['lot_data'] as $key => $item)
              {
              	     $lottery_data['lot_data'][$key]['use_num'] = $this->lottery_model->charge_find_use_count($lottery_data['lot_id'],$key);    // 可抽獎獎品數量               
              	     $num = $item['num'] - $lottery_data['lot_data'][$key]['use_num'];
              	     if ($num < 0){
                         $num = 0;
                     }
              	     
              	     $lottery_data['lot_data'][$key]['num'] = $num;
              	     
              	     $award_num += $num;              	     
                     if ($item['set_item'] == 'Y'){
                         $set_item_key = $key;
                     }
              }
             
              $m_angle = round(360 / $lot_num);
              $prizes = array();                            
              foreach ($lottery_data['lot_data'] as $key => $item)
              {
                       $num = $item['num'];
                       if ($award_num > 0){
                           $probability = round(($item['num'] / $award_num),2);     // 獎品數量 / 總數量 = 中獎比率
                       }else{
                       	   $probability = 0;
                       	   if ($set_item_key == $key){
                       	   	   $probability = 1;
                       	   	   $num = 10;
                       	   }
                       }
                       $min_block = $key * $m_angle;
                       if ($min_block <= 4){
                       	   $min_block = 5;
                       }
                       $max_block = ($key+1) * $m_angle;
                       if ($max_block >= 355){
                       	   $max_block = 355;
                       }
                       
                       $prizes[] = array(
                                     'key'					=> $key, 
                                     'name'					=> $item['title'], 
                                     'item'					=> $item, 
                                     'quantity'			=> $num, 
                                     'type'					=> $item['type'],
                                     'probability'	=> $probability,
                                     'min_block'		=> $min_block,
                                     'max_block'		=> $max_block,
                                   );                       
              }
             // echo "<pre>".print_r($prizes,true)."</pre>";
      
              if ($data_post['dtype'] == 'A'){
                  
                  $data_post['deg'] = 360 - (int)$data_post['deg'];
     
              	  $wkey = '';
              	  $winner = '';
              	  foreach ($prizes as $key => $item)
              	  {
              	  	       if ($data_post['deg'] >= $item['min_block'] && $data_post['deg'] < $item['max_block']){
              	  	       	   $wkey = $item['key'];
              	  	       	   $winner = $item;
              	  	       }              	  	
              	  }     
              	  $status = 'N';
              	  $result['msg'] = '<div class="msgbox"><h4 style="text-align: center;">抽獎訊息</h4><hr><div style="margin-top: 14px;">';
              	  $charge_checkcode = uniqid();
	
              	  if ($winner['type'] == 'Y'){
              	  	  $result['msg'] .= "恭禧您獲得：".$winner['name']."</div></div>";
              	  	  if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊
              	  	      if ($this->session->userdata('line_user_id') > ''){
              	  	          $result['msg'] .= "<a href=\"".base_url('lottery/information/'.$charge_checkcode)."\" class=\"btn-inline-wrap\">填寫收件地址</a>";
              	  	      }else{
              	  	      	  $result['msg'] .= "<a href=\"javascript:void(0);\" class=\"btn-inline-wrap\">後台預覽 無法填寫</a>";
              	  	      }
              	  	  }
              	  	  $status = 'Y';
              	  }else{
              	  	  if ($winner['type'] == 'A'){
              	  	  	  $result['msg'] .= $winner['name'];
              	  	  	  $result['msg'] .= '<br><br><div align="center"><button type="button" class="btn btn-info" onClick="location.href=\''.base_url('lottery/form/'.$query).'\'" style="background-color: #e5004a;padding: 0.3rem;color:white;border-color: #e5004a;font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 0.4rem;line-height: 1.2;">再抽一次</button></div>';
              	  	      $result['msg'] .= '</div></div>';
              	  	  	  $status = 'A';
              	  	  }else{
              	  	      $result['msg'] .= $winner['name'];
              	  	      $result['msg'] .= '</div></div>';
              	  	      $status = 'C';
              	  	  }
              	  }
              	  
              	  if ($this->session->userdata('line_user_id') > ''){
              	      $charge_last_data = $this->lottery_model->charge_last_lot_key_data($lottery_data['lot_id'],$this->session->userdata('line_user_id'),$wkey); // 是否有資料
              	      
              	      $c_no = '';
              	      $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));
                      if ($line_id_data){    
                          $c_no     = $line_id_data['c_no'];       					         				 
                      }
              	      
              	      $data = array(
     					 		                  "lot_id"    => $lottery_data['lot_id'],
     					 		                  "user_id"	=> $this->session->userdata('line_user_id'),
     					 		                  "display_name" => mb_substr($this->session->userdata('line_display_name'),0,20),       				    
     					 		                  "lot_dt" => date('Y-m-d H:i:s'),
     					 		                  "lot_key" => $wkey,
     					 		                  "c_no" => $c_no,
     					 		                  "lot_title" => $winner['item']['title'],
     					 		                  "lot_item" => json_encode($winner['item']),
     					 		                  "status" => $status,
     					 		                  "checkcode" => $charge_checkcode,
     					 		                  "ip" => $this->data['tracking']['ip'],     					 		              
     					 		    );     					 		     					 	
     					 		    
     					 		    if ($charge_last_data){
     					 		        $this->lottery_model->charge_update_data($charge_last_data['id'],$data);
     					 		    }else{     			
     					 		    	  $data['crdt']	= date('Y-m-d H:i:s');
     					 		    	//  if ($status == 'Y'){
     					 		           $this->db->insert('ap_lottery_charge', $data);     					 		
     					 		      //  }
     					 		    }     					 		
     					 		}
              }else{
              	  // 進行抽獎
                  $winner = $this->doDraw($prizes);
              	  //echo "<pre>".print_r($winner,true)."</pre>";

              	  $deg = rand($winner["min_block"],$winner["max_block"]);
              	  //echo "<pre>".print_r($deg,true)."</pre>";

              	  $result['deg'] = $deg;
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
                $this->lottery_model->charge_update_date_data($areg['l'],'opdt',$data);
            }
        }
        $fileModTime = time();
        header('Content-Type: image/gif');
        header('Last-Modified: ' . gmdate('D, d M Y H:00:00', $fileModTime) . ' GMT'); 
        header('Expires: ' . gmdate('D, d M Y H:00:00', time() + 7200) . ' GMT');
        echo base64_decode('R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');        
        exit;
    }
    
    
    public function question($query)
    { 
    	 $lottery_data = $this->lottery_model->find_one('checkcode',$query);      
       
       $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
         	         
       $this->load->model( 'question_model' );
       
       $question_data = $this->question_model->find_one('q_id',$lottery_data['lot_config']['q_id']);
                     	   
       if ($question_data)
       {
           $data['question_data']              = $question_data;
           $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);
           $data['question_data']['q_config']  = json_decode($question_data['q_config'], true);
           
           /*
               if ($data['question_data']['q_config']['member'] == 'Y'){  // 需要會員才可以填問卷
               	   $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));
               	   $chk_member = false;
                   if ($line_id_data)
                   {
                   	   if (trim($line_id_data['c_no']) > ''){
                   	   	   $chk_member = true;
                   	   }
               	   }
               	   if (!$chk_member){
               	   	   alert('親愛的 '.$this->session->userdata('line_display_name').' 您好：\n\n此問卷需安露莎會員身份才可以填寫！',base_url('line/bind?rdurl='.base_url('lottery/question/'.$query)));
               	   	   exit;
               	   }
               }                     
           */
       }else{
       	   alert( '問卷操作有誤，請重新操作(QL01_'.$query.')！' ,base_url());
    	     exit;
       }
       
       // --  事先建立的體驗或試用的問卷
       $check = false;
       $check_data = $this->question_model->check_reply_form($question_data['q_id'],$this->session->userdata('line_user_id'));
       if ($check_data){
       	   if ($check_data['status'] == 'Y'){  // 已填寫過
       	       $check = true;
       	   }   
       }
       
       // 判斷是否填寫過
       if ($check){
           $msg = "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您已填寫過此份問卷，請勿重覆填寫，若有任何問題，請洽客服！";
           
           alert($msg,base_url('lottery/form/'.$query));                       	           
           exit;
       }else{       
           $data['query']			= $query;
           $data['preview']		= false;
           $data['platform']	= ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
           $data['action']		= base_url('lottery/question_save/'.$query);
           $this->layout->view('question_form', $data);       
       }       
    }
    
    public function question_save($query)
    {     
    	 
    	 // 偵側不到 user_id
    	 if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('lottery/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫問卷！',$err_url );    	     
    	     exit;
    	 }
    	 
    	 $data_post = $this->input->post( NULL, FALSE );
        
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
       					    	 				
       				$lottery_data = $this->lottery_model->find_one('checkcode',$query);      
       
              $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     	    	 				
       				
       				$this->load->model( 'question_model' );
       					    	 			
       			  $question_data = $this->question_model->find_one('q_id',$lottery_data['lot_config']['q_id']);	
    	 				              	
       				if ($question_data)
       				{
       				     $q_ans     = json_decode($question_data['q_ans'], true);       				    
       				}else{
       					   alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您已填寫過此份問卷，請勿重覆填寫，若有任何問題，請洽客服(LQS1)！",base_url());
    	 				     exit;       				
       				}
       	
       			 	$rid = 0;
       				$check_data = $this->question_model->check_reply_form($question_data['q_id'],$this->session->userdata('line_user_id'));       				
              if ($check_data){
              	   if ($check_data['status'] == 'P'){ // 從 LINE 過來填寫售後服務,記錄點擊時間
              	       $rid				= $check_data['rid'];
              	       $checkcode = $check_data['checkcode'];
              	   }
              	   if ($check_data['status'] == 'Y'){
       	               alert( '問卷操作有誤，請重新操作(QL02_'.$query.')！' ,base_url());
    	 				         exit;     
       	           }
              }else{
              	  if ( !$this->front_admin_model->check_admin_login( TRUE ) ) { 
              	        if ($question_data['classid'] == 'QA5'){ // 試用
                        	   $msg = "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n尚未到填寫此問卷的時間，若有任何問題，請洽客服(LQS2)！";
                             alert( $msg ,base_url());
    	                       exit;
                        }elseif($question_data['classid'] == 'QA2'){ // 會員產品體驗回覆
                        	   $msg = "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n尚未到填寫此問卷的時間，若有任何問題，請洽客服(LQS3)！";
                             alert( $msg ,base_url());
    	                       exit;
                        }
                  }
              }
       				
       				$reply_data = array(
         					                  'ip'      => $this->block_service->client_ip(),                
         					                  'q_title'	=> str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_title']), 
         					                  'q_desc'  => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_desc']),
         					                  'q_ans'		=> $question_data['q_ans'], 
         					                  'status'	=> 'Y',
         					                  'okdt'		=> date('Y-m-d H:i:s')    
       					                  );
       					                  
       				if ($rid == 0){
       				    // 是否為會員
       				    $c_no = '';
       				    $c_name = '';
       				    $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));                     	   
       				    if ($line_id_data){
       				    	  $c_no     = $line_id_data['c_no'];       					  
       				    	  //$c_name   = $line_id_data['c_name'];       		
       				    	  $member_data = $this->front_member_model->find_one('c_no',$c_no);
       				    	  if ($member_data){       					  
       				    	      $c_name = $member_data['c_name'];
       				    	  }
       				    } 
       				    // 是否為會員
       				    
       				    $checkcode = md5(uniqid());       				
       				    
       				    $reply_data['c_no']						= $c_no;
       				    $reply_data['c_name']				 = $c_name;
       				    $reply_data['user_id']				= $this->session->userdata('line_user_id');
       				    $reply_data['display_name']		= mb_substr($this->session->userdata('line_display_name'),0,20);
       				    $reply_data['q_id']						= $question_data['q_id'];
       				    $reply_data['checkcode']			= $checkcode;
       				    $reply_data['query']					= $question_data['checkcode'];
       				}
       				
       				$qdata = array();
       				foreach ($q_ans as $key => $item)
       				{
       					       $inum = $key + 1;                       
                       $iname = 'q_'.$inum.'';
                       $tdata = array('title' => $item['title']);
                       if (is_array($data_post[$iname])){
                       	   $tdata['ans'] = implode(",",$data_post[$iname]);
                       }else{
                       	   $tdata['ans'] = $data_post[$iname];
                       }
                       $qdata[] = $tdata;
       				}
       				$reply_data['reply'] =  json_encode($qdata);
       				
       				if ($rid == 0){
       				    $this->question_model->reply_insert_data($reply_data);
       				}else{
                  $this->question_model->reply_update_data($rid,$reply_data);
              }
       				
       				redirect( 'lottery/form/'.$query);             
              exit;       				
    	  }    	 
    } 
    
    //收件資料填寫
    public function information($charge_checkcode)
    {
        // 偵側不到 user_id
    	  if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('lottery/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫(LI0)！',$err_url );    	     
    	     exit;
    	  }
        
        $charge_check = $this->lottery_model->charge_find_one('checkcode',$charge_checkcode);
        
        if ($charge_check)
        {
            $charge_check['lot_item']     = json_decode($charge_check['lot_item'], true);  
            $lottery_data = $this->lottery_model->find_one('lot_id',$charge_check['lot_id']);     	        
            $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
            if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊    
                if ($charge_check['lot_item']['type'] == 'N'){
                    alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您未中獎，請勿填寫收件資料，若有任何問題，請洽客服！",base_url());
    	 			    	  exit;            
                }else{
                    if ($charge_check['address'] > ''){
                        alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n【".$lottery_data['lot_title']."】您已抽中《".$charge_check['lot_item']['title']."》並已填寫完收件資料，若有任何問題，請洽客服！",base_url());
    	 			    	      exit;            
                    }
                }
            }else{
            	  alert( '抱歉，您的操作有誤，若有任何問題，請洽客服(LI1)！',base_url());   
    	          exit;
            }
        }else{
            alert( '抱歉，您的操作有誤，若有任何問題，請洽客服(LI2)！',base_url());                
            exit;       				
        }
        
        $c_no = '';
        $c_name = '';
        $c_tel = '';
        $c_mobile = '';
        $c_postal = '';
        $c_email = '';
        $c_addr = '';
        $line_id_data = $this->Member_line_model->find_one('user_id',$this->session->userdata('line_user_id'));
        if ($line_id_data){    
            $c_no     = $line_id_data['c_no'];       					         				 
       		  $member_data = $this->front_member_model->find_one('c_no',$c_no);
       		 
       			if ($member_data){       					  
       			    $c_name    = trim($member_data['c_name']);       			    
       			    $c_postal  = trim($member_data['zip_dl']);
       			    $c_addr    = trim($member_data['addr_dl']);
       			    $c_mobile  = trim($member_data['cell1']);
       			    $c_email   = trim($member_data['e_mail']);
       			}    
        }
        if ($c_email == ''){
            $line_user_data = $this->front_base_model->get_data('line_user',array('user_id' => $this->session->userdata('line_user_id') ),array('user_id'=>'asc'));
            if ($line_user_data){
                $c_email   = trim($line_user_data[0]['line_email']);
            }
        }
        
        $data = array(
                       'charge_checkcode' => $charge_checkcode,
                       'lottery_data' => $lottery_data,
                       'charge_check' => $charge_check,
                       'c_no' => $c_no,
                       'c_name' => $c_name,
                       'c_tel' => $c_tel,
                       'c_email' => $c_email,
                       'c_mobile' => $c_mobile,
                       'c_postal' => $c_postal,
                       'c_addr' => $c_addr,                       
                     );
                     
        if ($c_postal > ''){
            $town_data = $this->front_base_model->get_data('town',array('postal' => $c_postal),array('postal'=>'asc'));
            if ($town_data){
                $town = $town_data[0];
                $data['cityno']  = $town['cityno'];
                $data['town'] = $this->front_base_model->get_data('town',array('cityno' => $data['cityno']),array('postal'=>'asc'));
            }
        }
        
        $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));
        
        $this->layout->view('lottery/information', $data);       
        
    }       
    
    //收件資料填寫 - 存檔
    public function information_save($charge_checkcode)
    {      
        
        // 偵側不到 user_id
    	  if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('lottery/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫(LS0)！',$err_url );    	     
    	     exit;
    	  } 
    	  
    	  $charge_check = $this->lottery_model->charge_find_one('checkcode',$charge_checkcode);
        if ($charge_check)
        {
            $charge_check['lot_item']     = json_decode($charge_check['lot_item'], true);  
            $lottery_data = $this->lottery_model->find_one('lot_id',$charge_check['lot_id']);     	
            $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
            if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊   
            		if ($charge_check['lot_item']['type'] == 'N'){
            		    alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您未中獎，請勿填寫收件資料，若有任何問題，請洽客服(LS1)！",base_url());
    	 						  exit;            
            		}else{
            		    if ($charge_check['address'] > ''){
            		        alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n【".$lottery_data['lot_title']."】您已抽中《".$charge_check['lot_item']['title']."》並已填寫完收件資料，若有任何問題，請洽客服！",base_url());
    	 						      exit;            
            		    }
            		}
            }else{
            	  alert( '抱歉，您的操作有誤，若有任何問題，請洽客服(LS2)！',base_url());   
    	          exit;
            }
        }else{
            alert( '抱歉，您的操作有誤，若有任何問題，請洽客服(LS3)！',base_url());   
    	      exit;
        }
        $data_post = $this->input->post( NULL, FALSE );
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){  
                  $data = array(
     					 		              "name" => $data_post['name'],
     					 		              "mobile" => $data_post['mobile'],
     					 		            //  "email" => $data_post['email'],
     					 		              "cityno" => $data_post['cityno'],
     					 		              "postal" => $data_post['postal'],
     					 		              "address" => $data_post['c_addr'],
     					 		              "updt" => date('Y-m-d H:i:s'),     					 		              
     					 		);     					 		     					 	
     					 		
     					 		$this->lottery_model->charge_update_data($charge_check['id'],$data);
     		}
     		
        $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好<br> <br>感謝您的填寫！';                
        
        self::lottery_msg($charge_checkcode,$msg);
    }    
    
    private function lottery_check($query,$lottery_data,$user_id,$display_name)
    {
    	  
    	  $result = array('status' => false,'gourl' => '', 'errmsg' => ''); 

        if (strtotime($lottery_data['lot_start']) > strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此活動尚未開始(LE1)！";
        }elseif(strtotime($lottery_data['lot_end']) < strtotime(date('Y-m-d H:i:s')))
        {
            $result['errmsg'] = "此活動已經結束(LE2)！";
        }else
        {
         	  $lottery_data['lot_data']     = json_decode($lottery_data['lot_data'], true);       
         	  $lottery_data['lot_config']   = json_decode($lottery_data['lot_config'], true);     
         	  
         	  if ($lottery_data['lot_config']['member'] == 'Y'){  // 會員才可以抽獎
         	      $line_id_data = $this->Member_line_model->find_one('user_id',$user_id);                     	   
                if (!$line_id_data)
                {
                	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n非安露莎會員無法參加活動；如有問題，請洽客服(LE3)！";
                }   
            }
            
            if ($lottery_data['lot_config']['question'] == 'Y'){  // 填完問卷才可以抽獎
                $this->load->model( 'question_model' );
                $check_data = $this->question_model->check_reply_form($lottery_data['lot_config']['q_id'],$this->session->userdata('line_user_id'));
                
                if ($check_data){
       	            if ($check_data['status'] == 'Y' || $check_data['status'] == 'D'){  // 已填寫過 , 可以抽獎
       	            	  
       	            }else{
       	            	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n請填寫問卷後才可參加活動；如有問題，請洽客服(LE4)！";
       	                $result['gourl'] = base_url('lottery/question/'.$query);
       	            }
       	        }else{
       	        	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n請填寫問卷後才可參加活動；如有問題，請洽客服(LE5)！";
       	        	  $result['gourl'] = base_url('lottery/question/'.$query);
       	        }
            }
            
            if ($result['errmsg'] == ''){
                $charge_check = $this->lottery_model->charge_check($lottery_data['lot_id'],$user_id);
                
                if ($lottery_data['lot_config']['charge'] == 'Y'){  // 有在抽獎名單才可以抽
            	      if (!$charge_check){
            	      	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n非限定名單無法參加活動；如有問題，請洽客服(LE6)！";
            	      }else{
            	      	  if ($charge_check['checkcode'] == ''){
           				  	      $checkcode = generatorPassword(6).$charge_check['id'].generatorPassword(6);
           				  	      $up_data['checkcode'] = $checkcode;
           				  	      $this->lottery_model->charge_update_data($charge_check['id'],$up_data);
           				      }
            	      }
            	  }
            	 
            	  if ($result['errmsg'] == '' && $charge_check){
            	  	  if ($charge_check['status'] == 'N'){
            	  	  	
            	  	  }else{
            	          $charge_check['lot_item']     = json_decode($charge_check['lot_item'], true);             	      
            	          if ($charge_check['lot_item']['type'] == 'Y' && $charge_check['address'] == ''){  // 地址未填
            	              if ($lottery_data['lot_config']['addr'] == 'Y'){  // 中獎需要填寫收件資訊
            	                  $result['gourl'] = base_url('lottery/information/'.$charge_check['checkcode']);            	      
            	                  $result['errmsg'] = 'redirect';
            	              }else{            	          	  
            	              	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n【".$lottery_data['lot_title']."】您已抽中《".$charge_check['lot_item']['title']."》！";
            	              }
            	          }else{
            	          	  if ($charge_check['lot_item']['type'] == 'C'){
            	          	  	  $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n您已抽過【".$lottery_data['lot_title']."】活動，已抽中《".$charge_check['lot_item']['title']."》；如有問題，請洽客服(LE9)！";
            	          	  }else{
            	          	  	  if ($charge_check['lot_item']['type'] == 'A'){  // 再抽一次
            	          	  	  	
            	          	  	  }else{
                                    $result['errmsg'] = "親愛的 ".$display_name." 您好：\\n\\n活動只能抽獎一次；如有問題，請洽客服(LE7)！";
                                }
                            }
                        }
                    }
                }
            }
            
            if ($result['errmsg'] == ''){
            	  $result['status'] = true; 
            }
        }      
       
        return $result;
    }
    
    private function lottery_msg($query,$msg)
    {
    	  
    	  $data['msg'] = $msg;
    	  
    	  $data['query'] = $query;
    	  
    	  $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
   
        $this->layout->view('lottery_msg', $data);
        
    } 
    
    private function doDraw($prizes) {
        // 計算總機率
        $totalProbability = 0;
        foreach ($prizes as $prize) {
            $totalProbability += $prize['probability'];
        }
        
        // 生成一個隨機數
        $random = mt_rand(1, 100) / 100;
        
        // 遍歷獎項，根據機率進行抽獎
        $currentProbability = 0;
        foreach ($prizes as $prize) {
            $currentProbability += $prize['probability'] / $totalProbability;
            
            if ($random <= $currentProbability) {
                // 檢查獎項數量是否足夠
                if ($prize['quantity'] > 0) {
                    // 減少獎項數量
                    $prize['quantity']--;
                    
                    // TODO: 更新獎項數量到數據庫或其他來源
                    
                    // 返回獎項名稱
                    return $prize;
                } else {
                    // 獎項數量不足，繼續抽獎
                    continue;
                }
            }
        }
        
        // 如果沒有中獎獎項，返回空值或其他提示
        return "Sorry, you didn't win any prize.";
    }
    
}       