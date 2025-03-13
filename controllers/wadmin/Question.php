<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service',
            'line_service',
            'api_line_service'
        ));        
        
        $this->load->library( 'ui' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_admin_model' );
        $this->load->model( 'question_model' );           
        
        
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function list($kind)
    {
       
        $data['Search'] = '';
        $data['Sclass'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }
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
        if ($data['Sclass'] > ''){
        	  $where['classid'] = $data['Sclass'];        	
        }else{
        	  $where['a.q_id > '] = 0;
        }
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.q_title'      => $data['Search'],
                     'a.q_desc'      => $data['Search']
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_question',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.q_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'question';
        
        $data['class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'QA'),array('classsort'=>'asc'));  
        
        foreach ($data['class'] as $item){
            $data['classtitle'][$item['classid']] = $item['classtitle'];
        }
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	  $data['list']['rows'][$key]['reply_count'] = $this->question_model->reply_find_count($item['q_id']);                    	
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/question_list', $data);
        
    }
    
    public function modify($kind,$type = 'N')
    {
        $data_post = $this->input->post();
        
        $data['edit'] = 0;
        $data['Search'] = '';
        $data['Sclass'] = '';
        $data['Page'] = 1;
        $data['data'] = array();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (!empty($this->input->get( 'edit' ))){
                 $data['edit'] = (int)$this->input->get( 'edit' );
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }          
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }          
        }
        
        $data['reply_count'] = 0;
        if($data['edit'] == '') {
            $data['modify_name'] = '新增';
            $data['data'] = array(
                'edit'     => 0,
                'q_title'  => '',
                'q_desc'   => '',
                'classid'  => '',
                'q_date'   => '',
                'q_start'  => '',
                'q_end'    => '',
                'q_num'    => '0',
                'q_data'   => '',
                'q_config' => array('member' => 'Y'),
                'status'   => 'Y'
            );
        }
        else {
            $where  = array ('q_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_question',$where);
            
            if (!$data['data']){
                redirect( 'question/list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['q_data']   = json_decode($data['data']['q_ans'], true);                                 
                $data['qq_class'] = array();
                foreach ($data['data']['q_data'] as $key => $item){ 
                	       if (!isset($data['qq_class'][$item['classid']])){
                	           $data['qq_class'][$item['classid']]  = $this->front_base_model->get_data('ap_question_qa',array('classid' => $item['classid'],'status' => 'Y'),array('qa_id'=>'asc'));  
                	       }
                }
                $data['data']['q_config']   = json_decode($data['data']['q_config'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['q_id'] = 0;                
                $data['data']['status'] = 'Y';
            }else{            	  
        	      $data['reply_count'] = $this->question_model->reply_find_count($data['data']['q_id']);                    	
            }      
            
        }
        
        $data['class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'QA'),array('classsort'=>'asc'));       
        
        $data['qa_class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'Q'),array('classsort'=>'asc'));  
                
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/question_modify', $data);      
          
    }
    
    // 問卷存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                                      
             if (!isset($data_post['q_config_member'])){ 
                 $data_post['q_config_member'] = "N"; 
             }
             
             $q_config = array(
                              'member' => $data_post['q_config_member'],
                              'color_font' => $data_post['color_font'],
                              'color_background1' => $data_post['color_background1'],
                              'color_background2' => $data_post['color_background2'],
                              'color_border' => $data_post['color_border'],
                              );
             
             $reply_count = 0;
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                   
                 $reply_count = $this->question_model->reply_find_count($data_post['edit']);                    	
             }
             
             $data = array (
                        'q_title'   => $data_post['q_title'],                        
                        'q_desc'    => $data_post['q_desc'],                        
                        'q_date'    => $data_post['q_date'],
                        'q_config'  => json_encode($q_config),
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             
             if ($reply_count == 0){
             	   $data['classid'] = $data_post['classid'];
             	   
             	   $ans_num = 0;
                 $srr = array();             
                 if ($data_post['data_num'] > 0) {
                     $sort = 1;
                     // 題目數
                     for ($i = 1; $i <= $data_post['data_num']; $i++) {
                         $qaid = isset($data_post['qaid_' . $i]) ? $data_post['qaid_' . $i] : '';
                         $qa_required = isset($data_post['qa_required_' . $i]) ? $data_post['qa_required_' . $i] : 'N';                     
                         if ($qaid > ''){  // 有選提庫才存檔
                             $ans_num++;                                
                             $srr[$data_post['data_sort_'.$i]]['qaid'] = $qaid;               
                             $srr[$data_post['data_sort_'.$i]]['required'] = $qa_required;                                
                         }
                     }
                 
                     ksort($srr); 
                     $arr = array();
                     $sort = 0;
                     foreach ($srr as $key => $item)
                     {
                          $sort++;
                          
                          $qa_data = $this->front_admin_model->get_data('ap_question_qa',array ('qa_id' => $item['qaid']));
                          
                          $dsr = array(
                                                   'qaid'       => $item['qaid'],
                                                   'required'   => $item['required'],
                                                   'classid'    => $qa_data['classid'],
                                                   'title'      => $qa_data['title'],
                                                   'img'        => $qa_data['img'],
                                                   'no_title'   => $qa_data['no_title'],
                                                   'ans_data'   => json_decode($qa_data['ans_data'], true),
                                                   'ans_config' => json_decode($qa_data['ans_config'], true)
                                                 );
                 
                          $dsrr[] = $dsr;
                     }                        
                 }                         
                 $data['q_num'] = $ans_num;       
                 $data['q_ans']   = json_encode($dsrr);       
             }
             
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['q_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_question',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $id = $this->front_base_model->insert_table('ap_question',$data);
                 
                 $checkcode = 'Q'.$id.''.substr(md5(microtime(true)), 0, 5);
                 
                 $this->front_base_model->update_table('ap_question',array('checkcode'=>$checkcode),array('q_id'=>$id));  
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Sclass'] > ''){
                 $ahidden['Sclass'] = $data_post['Sclass'];
             }
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }

             PF_submit(base_url('wadmin/question/list/'.$kind) ,$ahidden);
             
        }    
    
    }
    
    
    public function qa_list($kind)
    {
       
        $data['Search'] = '';
        $data['Sclass'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }
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
        if ($data['Sclass'] > ''){
        	  $where['classid'] = $data['Sclass'];        	
        }else{
        	  $where['qa_id > '] = 0;
        }
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.title'      => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_question_qa',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.qa_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'question';
        
        $data['class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'Q'),array('classsort'=>'asc'));  
        
        foreach ($data['class'] as $item){
            $data['classtitle'][$item['classid']] = $item['classtitle'];            
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/question_qa_list', $data);
        
    }
    
    public function qa_select($classid) 
    {
    	 
    	 $this->output->set_content_type('application/json');
    	 
    	 $qa  = $this->front_base_model->get_data('ap_question_qa',array('classid' => $classid,'status' => 'Y'),array('qa_id'=>'asc'));  
    	 
       echo json_encode($qa);
       exit;               
    }
    
    
    public function qa_modify($kind,$type = 'N')
    {
        $data_post = $this->input->post();
        
        $data['edit'] = 0;
        $data['Search'] = '';
        $data['Sclass'] = '';
        $data['Page'] = 1;
        $data['data'] = array();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (!empty($this->input->get( 'edit' ))){
                 $data['edit'] = (int)$this->input->get( 'edit' );
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }          
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }          
        }
        
        if($data['edit'] == '') {
            $data['modify_name'] = '新增';
            $data['data'] = array(
                'edit'    => 0,
                'title' => '',
                'img'  => '',
                'classid' => '',
                'no_title' => 'N',
                'ans_data'=> '',
                'ans_config' => array('type' => 'R','set' => 'X','set_num' => ''),
                'status' => 'Y'
            );
        }
        else {
            $where  = array ('qa_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_question_qa',$where);
            
            if (!$data['data']){
                redirect( 'question/qa_list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['ans_data']   = json_decode($data['data']['ans_data'], true);                 
                $data['data']['ans_config']   = json_decode($data['data']['ans_config'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['qa_id'] = 0;
                $data['data']['img'] = '';
                $data['data']['status'] = 'Y';
                $data['data']['no_title'] = 'N';
            }           
        }
        
        $data['class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'Q'),array('classsort'=>'asc'));       
                
        $data['web_page'] = 'qa_modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/question_qa_modify', $data);      
          
    }
    
    public function qa_save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                                      
             $file_data = $this->block_service->PF_Upload("question",true,FC_FileLimit);	
             
             if (!isset($data_post['no_title'])){ 
                 $data_post['no_title'] = "N"; 
             }
             
             $data = array (
                        'classid'   => $data_post['classid'],
                        'title'     => $data_post['title'],                        
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             
             $img = '';             
             if ($file_data){
                 // 檔案判斷
                 $img = $file_data['img']['name'];    
             }
             
             if ($img > '' || (isset($data_post['img_del']) && $data_post['img_del'] == 'Y')){
                 $data['img'] = $img;
             }else{
             	   if (isset($data_post['img_old']) && $data_post['img_old'] > ''){
             	       $data['img'] = $data_post['img_old']; 
             	   }else{
             	   	   $data['img'] = '';
             	   }
             }
             if ($data['img'] == ''){
             	   $data_post['no_title'] = 'N';
             }
         
             $data['no_title'] = $data_post['no_title'];
             
             $ans_config['type'] = $data_post['ans_config_type'];
                
             if ($ans_config['type'] == 'A' || $ans_config['type'] == 'T'){
             	   $ans['count'] = 1;    
             }else{
                  $ans_num = 0;
                  $srr = array();             
                  if ($data_post['data_num'] > 0) {
                      $sort = 1;
                      // 題目數
                      for ($i = 1; $i <= $data_post['data_num']; $i++) {
                          $data_title = isset($data_post['data_title_' . $i]) ? $data_post['data_title_' . $i] : '';
                          if ($data_title > ''){  // 題目有才存檔
                              $ans_num++;                                
                              $srr[$data_post['data_sort_'.$i]]['title'] = $data_title;                                               
                          }
                      }
                  
                      ksort($srr); 
                      $arr = array();
                      $sort = 0;
                      foreach ($srr as $key => $item)
                      {
                           $sort++;
                           $arr[]           = $item['title'];                             
                      }                        
                  }                         
                  $ans['count'] = $ans_num;       
                  $ans['ans']   = $arr;       
             }
             
             $data['ans_data'] = json_encode($ans);
             
             if ($ans_config['type']  == 'C'){
             	   $ans_config['set'] = $data_post['ans_config_set'];
             	   if ($ans_config['set'] != 'X'){
             	       $ans_config['num'] = $data_post['ans_config_num'];	
             	   }
             }
             
             $data['ans_config'] = json_encode($ans_config);
             //    echo "<pre>".print_r($data,true)."</pre>";
             //    exit;       
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['qa_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_question_qa',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');
                 $id = $this->front_base_model->insert_table('ap_question_qa',$data);
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Sclass'] > ''){
                 $ahidden['Sclass'] = $data_post['Sclass'];
             }
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
       
             PF_submit(base_url('wadmin/question/qa_list/'.$kind) ,$ahidden);
             
        }    
    
    }
    
    public function prd_set($kind,$p_no)
    {
           
        $prd_set_data = $this->front_base_model->get_data('ap_question_prd_set',array('p_no' => $p_no),array('p_no'=>'asc'));       
        
        if ($prd_set_data){
            $data['data'] = $prd_set_data[0];   
            $data['data']['set_data']   = json_decode($data['data']['set_data'], true);                    
        }else{
            alert('無此問卷設定！',base_url('wadmin/question/list/Q003'));
        }
       
        $data['kind'] = $kind;             
        
        $data['p_no'] = $p_no;     
        
        $data['web_page'] = 'question_prd_set';
        
        $data['question']  = $this->front_base_model->get_data('ap_question',array('classid' => 'QA2','status' => 'Y'),array('q_id'=>'asc'));  
                
        $this->layout->view('admin/question_prd_set', $data);      
    }
    
     // 問卷存檔
    public function reply_list($q_id)
    {
    	  $data['question_data'] = $this->question_model->find_one('q_id',$q_id,true);    	 
    	  
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
      
        if (isset($data_post['break_bid']) && $data_post['break_bid'] > 0){   // 有值代表要刪掉
            $this->front_base_model->delete_table('ap_question_reply',array('rid'=>$data_post['break_bid']));   
            /*
            $udate = array(
                            'status'   => 'D',
                            'updt' => date('Y-m-d H:i:s')
                          );
            $this->question_model->reply_update_data($data_post['break_bid'],$udate);
            */
            $data['ok_message'] = '已刪除！';           
        }
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        $where['a.status'] = 'Y';
        $where['a.q_id'] = $q_id;
                
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_name'        => $data['Search'],
                     'a.user_id'       => $data['Search'],
                     'a.display_name'  => $data['Search']
                    );
        }            	  
    	  
    	  $data['list'] = $this->question_model->page_list( 'ap_question_reply',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.rid' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'question';
    	  
    	  $data['kind'] = 'Q003';   
    	  
    	  $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        

    	      	  
        $this->layout->view('admin/question_reply_user_list', $data);      
    }
    
    public function send_again()
    {
           
        $result = array('msg' => '已成功寄送！');
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             $rid = 0;
             if (isset($data_post['id'])){
                 $rid = $data_post['id'];
                 $reply_data = $this->question_model->reply_find_one('rid',$rid,'N');   
                 if ($reply_data){
                 	   if ($reply_data['status'] == 'Y'){
                 	   	   $result['msg'] = '此筆問卷已填答完成無法重新寄送！';
                 	   }else{
                 	   	   $result['msg'] = $this->block_service->question_send_line($rid,'question_again');       			     
                 	   	   
                 	   	   if ($result['msg'] == ''){
                 	   	       $udata = array(
                                            'crdt' => date('Y-m-d H:i:s'),
                                            'opdt' => null,
                                            'ckdt' => null
                                           );                                                            
                             $this->question_model->reply_update_data($rid,$udata);
                             $result['msg'] = '已成功寄送！';
                         }
                 	   }
                 }else{
                 	   $result['msg'] = '無此筆問卷請再確認！';
                 }
             }
        }
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;   
    }
    
    public function question_reply_show($rid)
    {
    	  $result = array('html' => '');    
        
        $reply_data = $this->question_model->reply_find_one('rid',$rid,'N');
        
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
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;  
    }
    
    public function excel_export($q_id)
    {
                mb_internal_encoding('utf-8');

                header("Pragma: public"); // required
                header("Expires: 0");
                header('Content-Encoding: UTF-8');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false); // required for certain browsers
                header("Content-Type: application/csv; charset=UTF-8");
                header('Content-Disposition:filename="問卷_'.$q_id.'-' . date_format(new Datetime('now'), 'Y-m-d') . '.csv"');
                header("Content-Transfer-Encoding: binary");
                echo "\xEF\xBB\xBF";
                $file = fopen('php://output', 'w');
                $header = array('填寫序號',
                                'Line 資訊',
                                'Line 暱稱',
                                '會員編號',
                                '會員姓名',
                                '填寫時間',
                );
                $where['q_id']    = $q_id; 
                $where['status']  = 'Y'; 
                
                $listdata  = $this->front_admin_model->list_data('ap_question_reply',$where,array( 'okdt' => 'asc' ));  
                $reply        = json_decode($listdata[0]['reply'], true);		            
                
                foreach ($reply as $key => $aitem){        
                	  $header[] = $aitem['title'];                    
                }
     
                fputcsv($file, $header);
                $data = $this->question_model->excel_data($q_id);                     
                foreach ($data as $val) {
                	       $reply        = json_decode($val['reply'], true);	
                	       foreach ($reply as $key2 => $aitem){    
                	       	   $val[] = str_replace(',,',',',str_replace(array("\r", "\n", "\r\n", "\n\r"),',',$aitem['ans']));
                	       }
                	       unset($val['reply']);     
                         fputcsv($file, $val);
                }
                fclose($file);
                exit;
                
                
                $where['q_id']    = $q_id; 
                $where['status']  = 'Y'; 
                
                $listdata  = $this->front_admin_model->list_data('ap_question_reply',$where,array( 'okdt' => 'asc' ));  
                   
                if ($listdata)
                {                
                	  $filename  = "問卷_".$listdata[0]['q_id']."-".date('Y-m-d');
                	  
                	  $reply        = json_decode($listdata[0]['reply'], true);		            
                	       
                	  $excel_row = 0;
        
        	          $this->load->library("PHPExcel");
        	          
        	          $objPHPExcel = new PHPExcel();
                    
                    $objPHPExcel->setActiveSheetIndex(0);
		                //Set Title
                    $objPHPExcel->getActiveSheet()->setTitle($listdata[0]['q_title']);
                    
                    $ex = 0;
                                        
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '填寫編號');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('8');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, 'Line 資訊');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('40');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, 'Line 暱稱');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('30');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '會員編號');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('12');     
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '會員姓名');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('15');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '填寫時間');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('20');         
                                            
                    foreach ($reply as $key => $aitem){        
                    	  $ex++;                    	                      	  
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, $aitem['title']);
                        $objPHPExcel->getActiveSheet()->getStyle($this->block_service->ecell($ex,1))->getAlignment()->setWrapText(true); //可跳行
                        
                        // 寬度設定
                        $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('30');                             
                    }
                                  
                    // 標題底色
                    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->block_service->ecell($ex,1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB ( '00CCD1D1' );                   
                    
                    if ($listdata){
                        $nrow = 1;            
                        foreach($listdata as $key1 => $item){                    
                            $nrow++;
                            $reply        = json_decode($item['reply'], true);		                            
                            $ey = 0;
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['rid']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['user_id']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['display_name']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['c_no']);
                            $objPHPExcel->getActiveSheet()->getStyle($this->block_service->ecell($ey,$nrow))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['c_name']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['okdt']);
                            
                            //依據每個專題的不同，做不同的調整
                            foreach ($reply as $key2 => $aitem){               
                                $ey++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $aitem['ans']);                                     
                                $objPHPExcel->getActiveSheet()->getStyle($this->block_service->ecell($ey,$nrow))->getAlignment()->setWrapText(true); //可跳行                  
                            }                            
                        }                            
                    }
                                        
                    // 上下置中
                    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->block_service->ecell($ex,$nrow))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                                
                    
                    //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    
                    //Header
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("Cache-Control: no-store, no-cache, must-revalidate");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    
                    //Nama File
                    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                    
                    //Download
                    $objWriter->save("php://output");
                    
                    $objPHPExcel->disconnectWorksheets();
                    unset($objWriter, $objPHPExcel);
                    
            
                }else{
                   echo '無資料可供下載!'; 
                   exit;
                }      
                exit;         
    }    
    
    public function analyze($q_id)
    {
            
         $where['q_id']    = $q_id; 
         $where['status']  = 'Y'; 
         
         $listdata  = $this->front_admin_model->list_data('ap_question_reply',$where);  
            
         if ($listdata)
         {      
             $data['listdata'] = $listdata;
             $data['web_page'] = 'analyze';
             
             $this->layout->view('admin/question_analyze', $data);                              
         }else{             
             alert('無此問卷資料(或尚無人填寫)！',base_url('wadmin/question/list/Q003'));
             exit;
         }         
    }
}