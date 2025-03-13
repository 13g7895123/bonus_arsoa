<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );                        
        $this->load->model( 'Member_line_model' );
        $this->load->model( 'question_model' );            
        $this->load->model( 'front_admin_model' );
        $this->load->model( 'front_order_model' );
        
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/layout_liff'));
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
                
    }
        // https://liff.line.me/1656832375-Vw6mmZ1q/Q434790b
    public function test($checkcode = 'Q434790b')
    {
    	 
    	  $this->session->set_userdata('line_user_id', 'U1f8c9566bd3519855409230932767d38' ); //Ueae68938d7b555eeaebb60d66dc0638f
    	  //$this->session->set_userdata('line_user_id', 'Ueae68938d7b555eeaebb60d66dc0638f' ); 
        $this->session->set_userdata('line_display_name', 'linroy' );            	 
        
        $this->form($checkcode);
        
    }
    
    public function preview($query)
    {
    	          
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->form($query,true);        
    }
        
    public function form($query, $preview = FALSE)
    {     
       if (!$preview){
           // 偵側不到 user_id
    	     if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	         if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	         	   $err_url = base_url('question/test');
    	         }else{
    	             $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$query;
    	         }
    	         alert( '抱歉，您的操作時間過久，請重新確認才能填寫問卷！',$err_url );    	     
    	         exit;
    	     }
    	     $question_data = $this->question_model->find_one('checkcode',$query,$preview);    	 
       }else{
           $question_data = $this->question_model->find_one('checkcode',$query,$preview);
       }
             
       if ($question_data)
       {
           $data['question_data']              = $question_data;
           $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);
           $data['question_data']['q_config']  = json_decode($question_data['q_config'], true);
           
           if (!$preview){
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
               	   	   alert('親愛的 '.$this->session->userdata('line_display_name').' 您好：\n\n此問卷需安露莎會員身份才可以填寫！',base_url('line/bind?rdurl='.base_url('question/form/'.$query)));
               	   	   exit;
               	   }
               }                     
           }                     
       }else{
       	   alert( '問卷操作有誤，請重新操作(QF01_'.$query.')！' ,base_url());
    	     exit;
       }
       
       // --  事先建立的體驗或試用的問卷
       $check = false;
       $check_data = $this->question_model->check_reply_form($question_data['q_id'],$this->session->userdata('line_user_id'));
       if ($check_data){
       	   if ($check_data['status'] == 'Y'){  // 已填寫過
       	       $check = true;
       	   }else{  //  未填寫看有沒有過期
       	       if ($check_data['c_type'] == 'S'){  // 試用品
       	       	   $this->load->model( 'sample_model' );            
       	       	   $sample_data = $this->sample_model->find_one('s_id',$check_data['p_no'],true);        	       	
                   if ($sample_data)
                   {
                   	   if ($sample_data['lock_days'] > 0){ // 天內才可以填寫
                   	   	    $diff_day = floor((strtotime(date("Y-n-j")) - strtotime(date("Y-n-j",strtotime($check_data['crdt'])))) / 86400);  // 購買和今天相差天數                           	   	    
                   	   	    if ($diff_day > $sample_data['lock_days']){
                   	   	        $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好\n\n此問卷已超過可填寫的時間，若有任何問題，請洽客服！';
                   	   	        alert( $msg ,base_url());
    	                          exit;
                   	   	    }
                   	   }
                   }
       	       }
       	   }
       	   if ($check_data['status'] == 'P'){ // 從 LINE 過來填寫售後服務,記錄點擊時間       	   	   
       	       $udt_data = array('ckdt' => date('Y-m-d H:i:s'));
               $this->question_model->reply_update_date_data($check_data['rid'],'ckdt',$udt_data);
       	   }   
       }else{
       	   if (!$preview){
       	        if ($data['question_data']['classid'] == 'QA5'){ // 試用
                	   $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好\n\n尚未到填寫此問卷的時間，若有任何問題，請洽客服！';
                    alert( $msg ,base_url());
    	              exit;
                }elseif($data['question_data']['classid'] == 'QA2'){ // 會員產品體驗回覆
                	   $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好\n\n尚未到填寫此問卷的時間，若有任何問題，請洽客服！';
                    alert( $msg ,base_url());
    	              exit;
                }
           }
       }
       
       // 判斷是否填寫過
       if (!$preview && $check){
           $msg = '親愛的 '.$this->session->userdata('line_display_name').' 您好<br> <br>您已填寫過此份問卷，請勿重覆填寫，若有任何問題，請洽客服！';
           self::question_msg($query,$msg);               
       }else{
       
           $data['query']         = $query;
           $data['preview']       = $preview;
           $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
           $data['action']         = base_url('question/form_save/'.$query);
           $this->layout->view('question_form', $data);       
       }
    }   
    
    
    public function form_save($query)
    {     
    	 
    	 // 偵側不到 user_id
    	 if (empty($this->session->userdata('line_user_id'))){    	 	    	 	
    	     if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
    	     	   $err_url = base_url('question/test');
    	     }else{
    	         $err_url = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$query;
    	     }
    	     alert( '抱歉，您的操作時間過久，請重新確認才能填寫問卷！',$err_url );    	     
    	     exit;
    	 }
    	 
    	 $data_post = $this->input->post( NULL, FALSE );
        
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
       					    	 				
    	 				$question_data = $this->question_model->find_one('checkcode',$query);
       				              	
       				if ($question_data)
       				{
       				     $q_ans     = json_decode($question_data['q_ans'], true);       				    
       				}else{
       					   alert( "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n您已填寫過此份問卷，請勿重覆填寫，若有任何問題，請洽客服！",base_url());
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
       	               alert( '問卷操作有誤，請重新操作(QF02_'.$query.')！' ,base_url());
    	 				         exit;     
       	           }
              }else{
              	  if ( !$this->front_admin_model->check_admin_login( TRUE ) ) { 
              	        if ($question_data['classid'] == 'QA5'){ // 試用
                        	   $msg = "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n尚未到填寫此問卷的時間，若有任何問題，請洽客服！";
                             alert( $msg ,base_url());
    	                       exit;
                        }elseif($question_data['classid'] == 'QA2'){ // 會員產品體驗回覆
                        	   $msg = "親愛的 ".$this->session->userdata('line_display_name')." 您好\\n\\n尚未到填寫此問卷的時間，若有任何問題，請洽客服！";
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
       				    $reply_data['query']					= $query;
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
       				
       				redirect( 'question/complete/'.$query.'/'.$checkcode);
             
              exit;       				
    	  }    	 
    } 
       
    public function complete($query,$checkcode)
    {  
        $reply_data = $this->question_model->reply_find_one('checkcode',$checkcode);
        
        if ($reply_data)
       	{
       	    $data['name'] = $reply_data['display_name'];
       	    if ($reply_data['c_name'] > ''){
       	    	  $data['name'] = $reply_data['c_name'];
       	    }
       	    
       	    $data['question_data'] = $this->question_model->find_one('q_id',$reply_data['q_id']);       	    
       	}else{
       		   alert( '問卷操作有誤，請重新操作(QF02_'.$query.')！' ,base_url());
    	 	     exit;       				
       	}       
       	
        $msg = '親愛的 '.$data['name'].' 您好<br> <br>感謝您的回覆填寫！';
                
        self::question_msg($query,$msg);
       
    }	 
    
    private function question_msg($query,$msg)
    {
    	  
    	  $data['msg'] = $msg;
    	  
    	  $data['query'] = $query;
    	  
    	  $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
   
        $this->layout->view('question_msg', $data);
        
    }
    
     
    // Line 記錄售後服務的OPEN 
    public function r()
    {
        if (!empty($this->input->get( 'c' ))){
            $c = $this->input->get( 'c' );            
        }                
        if ($c > ''){
            $areg = json_decode(base64_decode($c), true);                 
            if ($areg['l'] > ''){
            	  $data = array('opdt' => date('Y-m-d H:i:s'));
                $this->question_model->reply_update_date_data($areg['l'],'opdt',$data);
            }
        }
        $fileModTime = time();
        header('Content-Type: image/gif');
        header('Last-Modified: ' . gmdate('D, d M Y H:00:00', $fileModTime) . ' GMT'); 
        header('Expires: ' . gmdate('D, d M Y H:00:00', time() + 7200) . ' GMT');
        echo base64_decode('R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');        
        exit;
    }
    
    public function partners($p_id)
    {
    	  if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        if (!is_numeric($p_id)){
        	  $data['line_push'] = $p_id;
        	  $data['class']  = $this->front_base_model->get_data('ap_question_prd_set',array('web_sort >' => 0,'line_push' => $data['line_push']),array('web_sort'=>'asc'));        
        	  $p_id = $data['class'][0]['p_id'];
        	  $where  = array ('p_id' => $p_id);                 
            $data['set_class'] = $this->front_admin_model->get_data('ap_question_prd_set',$where);            
        }else{
        	  $where  = array ('p_id' => $p_id);                 
            $data['set_class'] = $this->front_admin_model->get_data('ap_question_prd_set',$where);            
            $data['line_push'] = $data['set_class']['line_push'];
        }
        
        $data['s_list']  = $this->front_base_model->get_data('ap_question_prd_set',array('web_sort >' => 0,'line_push' => $data['line_push']),array('web_sort'=>'asc'));                
                
        $data['Search'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['p_id'])){
                 $p_id = $data_post['p_id'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $data['p_id'] = $p_id;        
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_no'      => $data['Search'],
                     'a.c_name'    => $data['Search']
                    );
        }        
        
        $where['a.d_spno'] = $this->session->userdata('member_session')['c_no'];        
        $where['h.p_id'] = $p_id;
        $where['r.show_web'] = 'Y';
        
        $data['list'] = $this->question_model->partners_list( 'member ',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , array('a.c_no','a.c_name','h.buy_date','h.last_rid','h.send_date')
            , array( 'max(r.okdt)' => 'desc','h.buy_date' => 'asc' )    // order by
        );       
     
        foreach ($data['list']['rows'] as $key => $item){        	
        	       $data['list']['rows'][$key]['reply'] = $this->question_model->find_reply_list('P',$item['c_no'],$p_id,'Y');        	              	       
        }
                     
        $data['Page']        = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount']   = $data['list']['PageCount']; //總頁數 
        
        $data['qtype'] = 'P';  
        
        if ($data['set_class']['line_push'] != 'Y'){  // 推薦本人
            $data['member'] = $this->question_model->find_reply_list('P',$this->session->userdata('member_session')['c_no'],$p_id,'Y');        	             
        }
                                  
        $this->layout->view('question_partners', $data);
    	    	
    }
    
    public function question_reply_show($checkcode)
    {
    	  $result = array('html' => '無此資料！');    
        
        $reply_data = $this->question_model->reply_find_one('checkcode',$checkcode);
        
        if ($reply_data){
            $reply        = json_decode($reply_data['reply'], true);		            
            
            $q_desc = '';            
            if ($reply_data['q_desc'] > '' ){
            	  $q_desc = $reply_data['q_desc'];
            	  $q_desc .= '<br>';
            }
                        
            $result['html'] = $q_desc.'<p class="fs14 text-right mb-3">填答時間：'.$reply_data['okdt'].'</p>';
            foreach ( $reply as $key => $item){
				    		         $num = $key + 1;
				    		         $result['html'] .= '   <div class="card mb-3">
                              <div class="card-body">
                                <div class="row">
				    				             <div class="col-md-auto border-right">Q'.sprintf('%02d',$num).'</div>
				    				             <div class="col-md-auto">'.$item['title'].'<br>
				    					           <span class="text-danger">'.$item['ans'].'</span>
				    				            </div>
				    			             </div>
                              </div>
                            </div>';
            }
        }
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;  
    }
    
    // 上線會員 - 看會員的問卷內容
    public function v()
    {
        if (!empty($this->input->get( 'r' ))){
            $r = $this->input->get( 'r' );            
        }                
        if ($r > ''){
            $areg = json_decode(base64_decode($r), true);
            
            $question_data = $this->question_model->reply_find_one('checkcode',$areg['checkcode'],'N');
            
            if ($question_data)
            {
                $data['question_data']              = $question_data;
                $data['query']                      = $question_data['query'];
                $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);
            }else{
            	  alert( '問卷操作有誤，請重新操作(QV01_'.$areg['rid'].')！' ,base_url());
         	      exit;
            }
            
            $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';           
            $data['preview']  = false;
            $data['view']     = true;
            $this->layout->view('question_form', $data);            
        }else{
            alert( '抱歉，您的操作有誤(QV99)！',base_url());    	     
    	      exit;
        }
    }
    
    public function product($checkcode)
    {
    	  
    	  $prd_data  = $this->front_base_model->get_data('ap_question_prd_set',array('checkcode' => $checkcode,'status' => 'Y','line_push !=' => 'Y'));     
        if ($prd_data){
        	  $data['data'] = $prd_data[0];
        	  $data['data']['set_data']   = json_decode($data['data']['set_data'], true);    
        	  
            $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';                       
            
            if ($data['data']['line_push'] == 'Q'){
                foreach ($data['data']['set_data'] as $key => $item){
                	       $data['data']['set_data'][$key]['q_title'] = $this->question_model->find_one('q_id',$item['q_id'])['q_title'];
                }
            }
           
            $this->layout->view('question_product', $data);            
        }else{
            alert( '抱歉，您的操作有誤(QP99)！',base_url());    	     
    	      exit;
        }
    }
    
    public function product_check($checkcode)
    {
    	  $result = array('gourl' => '','errmsg' => '','errtype' => 'clear');
    	  $prd_data  = $this->front_base_model->get_data('ap_question_prd_set',array('checkcode' => $checkcode,'status' => 'Y','line_push !=' => 'Y'));     	   
        if ($prd_data){
            $data_post = $this->input->post();
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
                 if (isset($data_post['Search']) && $data_post['Search'] > ''){
                 	   $prd_data = $prd_data[0];                 	   
                 	   $this->load->model( 'Question_prd_set_model' );
                 	   if ($this->Question_prd_set_model->order_his_find_count($prd_data['p_id'],$data_post['Search']) > 0){
                 	   	   $q_num = 1;
                 	   	   if (isset($data_post['q_num']) && $data_post['q_num'] > ''){
                 	   	   	   $q_num = $data_post['q_num'];
                 	   	   }
                 	   	   
                 	   	   $qdata = array(
       	                               'c_no'        => trim($data_post['Search']),
       	                               'checkcode'   => $checkcode,
       	                               'q_num'       => $q_num
       	                 );
       	                 $query = str_replace('=', '', str_replace('/', '_', base64_encode( json_encode($qdata) ) ) );
       	                     
                 	   	   if ($this->Question_prd_set_model->product_reply_send_find_count($prd_data['p_id'],$data_post['Search']) == 0 || $prd_data['line_push'] == 'Q'){
                 	   	   	   $can_next = true;
                 	   	   	   if ($prd_data['line_push'] == 'Q'){
                 	   	   	   	   $prd_data['set_data']   = json_decode($prd_data['set_data'], true);   
                 	   	   	   	   if ($q_num > 1){                 	   	   	   	   	   
                 	   	   	   	   	   foreach ($prd_data['set_data'] as $key => $item){
                 	   	   	   	   	   	        if ($key < ($q_num-1)){                 	   	   	   	   	   	        	  
                 	   	   	   	   	   	        	  if ($this->Question_prd_set_model->product_reply_send_find_qid_count($prd_data['p_id'],$data_post['Search'],$item['q_id']) == 0){
                 	   	   	   	   	   	        	      $can_next = false;
                 	   	   	   	   	   	        	  }
                 	   	   	   	   	   	        }
                 	   	   	   	   	   }
                 	   	   	   	   }
                 	   	   	   }
                 	   	   	   if ($can_next){
                 	   	   	       $result['gourl'] = base_url('question/product_form/'.$query);                 	   	   	       
                 	   	   	   }else{
                 	   	   	       $result['errmsg'] = ' ( '.$data_post['Search'].' ) 會員編號，第 '.($q_num-1).' 份問卷尚未填寫，無法填寫下份問卷！';	
                 	   	   	       $result['errtype'] = '';
                 	   	   	   }
                 	   	   }else{                 	   	
                     	       $result['errmsg'] = ' ( '.$data_post['Search'].' ) 會員編號已填寫過體驗問卷！';
                     	   }
                     }else{
                     	   $result['errmsg'] = ' ( '.$data_post['Search'].' ) 會員編號並無購買該產品！'; 
                     }
                 }
            }   	
        }else{
        	   $result['errmsg'] = '無此產品體驗！';
        }   
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit; 
    }
    
    public function product_form($query)
    {   
    	 $qdata = json_decode( base64_decode( str_replace('_', '/', $query) ), true );   
    	
    	 $prd_data  = $this->front_base_model->get_data('ap_question_prd_set',array('checkcode' => $qdata['checkcode'],'status' => 'Y','line_push != ' => 'Y'));     	   
    	
       if ($prd_data){       	   
       	   $data['data'] = $prd_data[0];
       	   $data['show_web'] = 'Y';
       	   if ($data['data']['line_push'] == 'Q'){ // 諮詢修改                   
        	     $data['data']['set_data']   = json_decode($data['data']['set_data'], true)[($qdata['q_num']-1)];   
        	 }else{
        	 	   $data['data']['set_data']   = json_decode($data['data']['set_data'], true)[0];   
        	 }        	 
        	 $question_data = $this->question_model->find_one('q_id',$data['data']['set_data']['q_id']);     
        	 if ($question_data)
           {
               $data['question_data']              = $question_data;
               $data['question_data']['q_ans']     = json_decode($question_data['q_ans'], true);

               $data['question_data']['q_config']  = json_decode($question_data['q_config'], true);
               $data['query']         = $query;
               $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';
               
               if ($data['data']['line_push'] == 'Q'){ // 諮詢修改                   
                   $this->load->model( 'Question_prd_set_model' );                   
                   $ans_data = $this->Question_prd_set_model->product_reply_send_find_one($data['data']['p_id'],$qdata['c_no'],$question_data['q_id']);
                   if ($ans_data){
                   	   $data['ans_data'] = json_decode($ans_data['reply'], true);      
                   	   $data['show_web'] = $ans_data['show_web'];            	   
                   }
               }
               
               $data['action']    = base_url('question/product_form_save/'.$query);
               $data['preview']   = false;
               $data['line_push'] = $data['data']['line_push'];
               
               $this->layout->view('question_form', $data);       
           }
       }
    }
    
    public function product_form_save($query)
    {     
    	     	 
    	 $qdata = json_decode( base64_decode( str_replace('_', '/', $query) ), true );   
    	    	 
    	 $prd_data  = $this->front_base_model->get_data('ap_question_prd_set',array('checkcode' => $qdata['checkcode'],'status' => 'Y','line_push !=' => 'Y'));
    	    	 
    	 $data_post = $this->input->post( NULL, FALSE );
        
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0 && $prd_data){    
              
              $prd_data = $prd_data[0];
                            
              if ($prd_data['line_push'] == 'Q'){ // 諮詢修改                   
        	        $prd_data['set_data']   = json_decode($prd_data['set_data'], true)[($qdata['q_num']-1)];   
        	    }else{
        	    	  $prd_data['set_data']   = json_decode($prd_data['set_data'], true)[0];   
        	    }  
        	    
    	 				$question_data = $this->question_model->find_one('q_id',$prd_data['set_data']['q_id']);
       				              	
       				if ($question_data)
       				{
       				     $q_ans     = json_decode($question_data['q_ans'], true);       				    
       				}else{
       					   alert( "親愛的您好\\n\\n此問卷不存在，若有任何問題，請洽客服！",base_url('question/product/'.$qdata['checkcode']));
    	 				     exit;
       				}
       				$this->load->model( 'Question_prd_set_model' );
       				
       				$ans_rid = 0;
       				if ($prd_data['line_push'] == 'Q'){ // 諮詢修改                                      
                   $ans_data = $this->Question_prd_set_model->product_reply_send_find_one($prd_data['p_id'],$qdata['c_no'],$prd_data['set_data']['q_id']);
                   if ($ans_data){
                   	   $ans_rid = $ans_data['rid'];
                   }
              }else{       				
       				     if ($this->Question_prd_set_model->product_reply_send_find_count($prd_data['p_id'],$qdata['c_no']) > 0){              	   
                       alert( "親愛的您好\\n\\n( ".$qdata['c_no']." ) 會員編號已填寫過體驗問卷！",base_url('question/product/'.$qdata['checkcode']));
    	 				         exit;             	   	
                   }
              }
              
              $c_name = '';
              $member_data = $this->front_member_model->find_one('c_no',$qdata['c_no']);
       				if ($member_data){       					  
       				    $c_name = trim($member_data['c_name']);
       				}
       				
       				$checkcode = md5(uniqid());       				
                 				
       				$reply_data = array(
         					                  'c_type'	=> 'P',         					                  
         					                  'ip'      => $this->block_service->client_ip(),                
         					                  'q_title'	=> str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_title']), 
         					                  'q_desc'  => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_desc']),
         					                  'q_ans'		=> $question_data['q_ans'], 
         					                  'status'	=> 'Y',
         					                  'c_no'  	=> $qdata['c_no'],
         					                  'p_no'  	=> $prd_data['p_id'],
         					                  'p_num'  	=> 1,
         					                  'c_name'  => $c_name,
         					                  'query'  => $question_data['checkcode'],
         					                  'q_id'    => $question_data['q_id'],
         					                  'checkcode' => $checkcode,
         					                  'okdt'		=> date('Y-m-d H:i:s'),
         					                  'ckdt'		=> date('Y-m-d H:i:s'),
         					                  'opdt'		=> date('Y-m-d H:i:s'),
         					                  'show_web' => 'Y'
       					                  );
       				if (isset($data_post['show_web']) && $data_post['show_web'] == 'N'){
       					  $reply_data['show_web'] = 'N';
       				}               
       				
       				$q_data = array();
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
                       $q_data[] = $tdata;
       				}
       				$reply_data['reply'] =  json_encode($q_data);
       				
       				if ($ans_rid == 0){
       				    $this->question_model->reply_insert_data($reply_data);       				    
       				    alert( "親愛的您好\\n\\n( ".$qdata['c_no']." ) 會員編號填寫成功！",base_url('question/product/'.$qdata['checkcode']));       				    
       				}else{
                  $this->question_model->reply_update_data($ans_rid,$reply_data);                  
                  alert( "親愛的您好\\n\\n( ".$qdata['c_no']." ) 會員編號資料修改成功！",base_url('question/product/'.$qdata['checkcode']));
              }      				
       				
    	 				//redirect( base_url('question/product/'.$qdata['checkcode']));             
              exit;       				
    	  }    	 
    } 
    
}       