<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends MY_Controller
{
    private $reg_type  = array('1' => '會員本人', '2' => '會員配偶', '3' => '會員子女', '4' => '來賓');
    
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
        $this->load->model( 'activity_model' );           
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
        $where['a.act_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.act_title'      => $data['Search'],
                     'a.act_desc'       => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_activity',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.act_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'activity';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	 
        	  foreach ($this->reg_type as $kaekey => $kitem){
        	      $data['list']['rows'][$key]['num_'.$kaekey] = $this->activity_model->charge_find_reg_type_count($item['act_id'],$kaekey);
        	  }
        	  
        	  $data['list']['rows'][$key]['set_question'] = $this->front_base_model->get_data('ap_activity_question',array('act_id' => $item['act_id']),array('set_sort'=>'asc'));
        	  
        	  if ($data['list']['rows'][$key]['set_question']){
        	      foreach ($data['list']['rows'][$key]['set_question'] as $qkey => $qitem){
        	               $data['list']['rows'][$key]['set_question'][$qkey]['q_title'] = $this->question_model->find_one('q_id',$qitem['q_id'])['q_title'];        	               
        	               $data['list']['rows'][$key]['set_question'][$qkey]['all_reply_count'] = $this->question_model->activity_reply_find_count($item['act_id'],$qitem['q_id'],$qitem['set_sort'],'ALL');                    	
        	               $data['list']['rows'][$key]['set_question'][$qkey]['reply_count'] = $this->question_model->activity_reply_find_count($item['act_id'],$qitem['q_id'],$qitem['set_sort'],'Y');                    	
        	      }
        	  }
        	  
        	//  $data['list']['rows'][$key]['c_num'] = $this->activity_model->charge_find_count($item['act_id'],'C');
        	//  $data['list']['rows'][$key]['n_num'] = $this->activity_model->charge_find_count($item['act_id'],'N');
        	  
        	//  $data['list']['rows'][$key]['act_data'] = json_decode($item['act_data'], true);
        	//  if ($data['list']['rows'][$key]['act_data']){
        	//  	  foreach ($data['list']['rows'][$key]['act_data'] as $akey => $aitem){
        	//  	  	       $data['list']['rows'][$key]['act_data'][$akey]['use_num'] = $this->activity_model->charge_find_use_count($item['act_id'],$akey);
        	//  	  }
        	//  }          	    	
        }
         	
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數   
        $data['reg_type'] = $this->reg_type;                  
                                      
        $this->layout->view('admin/activity_list', $data);
        
    }
    
    public function modify($kind,$type = 'N')
    {
        $data_post = $this->input->post();
        
        $data['edit'] = 0;
        $data['Search'] = '';        
        $data['Page'] = 1;
        $data['data'] = array();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (!empty($this->input->get( 'edit' ))){
                 $data['edit'] = (int)$this->input->get( 'edit' );
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }                       
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }          
        }
        
        if($data['edit'] == '') {
            $data['modify_name'] = '新增';
            
            $act_type = 'C';
            
            $data['data'] = array(
                'edit'     => 0,
                'act_type' => $act_type,
                'act_title'  => '',
                'act_desc'   => '',                                
                'act_start'  => '',
                'act_end'    => '',            
                'status'   => 'N'
                //'act_bg_img' => '',
                //'act_config' => array('member'=>'N','charge'=>'N','question'=>'N'),                
            );
        }
        else {
            $where  = array ('act_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_activity',$where);
            
            if (!$data['data']){
                redirect( 'activity/list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';             
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['act_id'] = 0;
                $data['data']['status'] = 'N';
            }else{
            	 $data['set_question']  = $this->front_base_model->get_data('ap_activity_question',array('act_id' => $data['edit']),array('set_sort'=>'asc'));                  
            }
        }
                
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['reg_type'] = $this->reg_type;             
        
        $data['kind'] = $kind;
        
        $data['question']  = $this->front_base_model->get_data('ap_question',array('classid' => 'QA8','status' => 'Y'),array('q_id'=>'desc'));  
        
        $this->layout->view('admin/activity_modify', $data);      
          
    }
    
    // 存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $data = array (
                        'act_title'=> $data_post['act_title'], 
                        'act_desc'=> $data_post['act_desc'],                             
                        'act_start'=> $data_post['act_start'],   
                        'act_end'=> $data_post['act_end'],   
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
                          
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['act_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_activity',$data,$where);                
                 $okmsg = '編輯成功！';
                 $id = $data_post['edit'];
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $data['act_type'] = 'C';
                 $id = $this->front_base_model->insert_table('ap_activity',$data);
                 
                 $checkcode = generatorPassword(4).'C'.$id.generatorPassword(4);
                 
                 $this->front_base_model->update_table('ap_activity',array('checkcode' => $checkcode),array('act_id'=>$id));  
                 $okmsg =  "新增成功！";
             }
             
             for ($i = 1;$i < $data_post['data_num'];$i++)
             {
             	    $set_id = 0;
             	    if (isset($data_post['set_id_'.$i])){
             	        $set_id = $data_post['set_id_'.$i];	
             	    }
             	    $q_id = $data_post['q_id_'.$i];
             	    $push_time = '';
             	    if ($data_post['push_time_'.$i.'_date'] > ''){
             	        $push_time = $data_post['push_time_'.$i.'_date'].' '.$data_post['push_time_'.$i.'_hour'].':'.$data_post['push_time_'.$i.'_min'].':00';
             	    }
             	    $sdata = array();
             	    if ($q_id > ''){             	    
             	        $sdata = array (
                                      'act_id'=> $id, 
                                      'q_id'=> $q_id,
                                      'set_sort'=> $i,
                                      'set_date'=> $push_time,   
                                      'status' => 'Y',
                                      'updt'      => date('Y-m-d H:i:s')
                                     );
                      if ($set_id > 0){
                      	  $this->front_base_model->update_table('ap_activity_question',$sdata,array('id'=>$set_id));  
                      }else{
                      	  $sdata['crdt'] = date('Y-m-d H:i:s');
                          $this->front_base_model->insert_table('ap_activity_question',$sdata);
                      }
                  }else{
                  	  if ($set_id > 0){
                  	  	   $sdata = array (
                                      'status' => 'D',
                                      'updt'      => date('Y-m-d H:i:s')
                                     );
                      	  $this->front_base_model->update_table('ap_activity_question',$sdata,array('id'=>$set_id));  
                      }
                  }
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( 'wadmin/activity/list/'.$kind);
             
        }    
    
    }
    
     // 列表
    public function charge_list($kind,$act_id = '')
    {
    	    
        $data['Search'] = '';  
        $data['Follow'] = ''; 
        $data['Status'] = ''; 
        
        $data['act_id'] = '';        	
        if ($act_id > ''){
            $data['act_id'] = $act_id;        	
        }        
         
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['break_bid']) && $data_post['break_bid'] > 0){   // 有值代表要刪掉
        		     $this->front_base_model->delete_table('ap_activity_charge',array('id'=>$data_post['break_bid']));   
        		     $data['ok_message'] = '已刪除！';           
        		 }
             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Follow'])){
                 $data['Follow'] = $data_post['Follow'];
             }
             if (isset($data_post['Status'])){
                 $data['Status'] = $data_post['Status'];
             }
             if (isset($data_post['act_id']) && $data_post['act_id'] > ''){
                 $data['act_id'] = $data_post['act_id'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }               
        }
              
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        
        if ($data['act_id'] > ''){
            $where['a.act_id'] = $data['act_id'];
        }
        if ($data['Follow'] > ''){
        	  $where['u.follow'] = $data['Follow'];
        }
        if ($data['Status'] > ''){
        	  $where['a.status'] = $data['Status'];
        }
                
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_no'        => $data['Search'],
                     'a.relation_c_no'        => $data['Search'],
                     'a.display_name'  => $data['Search'],
                    );
        }            	  
    	  
    	  $data['list'] = $this->activity_model->charge_page_list( 'ap_activity_charge',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.id' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'sample';
    	  
    	  $data['kind'] = 'C002'; 
    	  
    	  $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $data['class']  = $this->front_base_model->get_data('ap_activity',array('act_id >' => '0'),array('act_id'=>'desc'));  
        
        $data['reg_type'] = $this->reg_type;             
    	      	  
        $this->layout->view('admin/activity_charge_list', $data);      
    }
    
    
    public function excel_export($id)
    {
    	            
                $activity_data = $this->activity_model->find_one('act_id',$id);       
              
                mb_internal_encoding('utf-8');

                header("Pragma: public"); // required
                header("Expires: 0");
                header('Content-Encoding: UTF-8');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false); // required for certain browsers
                header("Content-Type: application/csv; charset=UTF-8");
                header('Content-Disposition:filename="活動_參加人名單_'.$id.'-'.$activity_data['act_title'].'-' . date_format(new Datetime('now'), 'Y-m-d') . '.csv"');
                header("Content-Transfer-Encoding: binary");
                echo "\xEF\xBB\xBF";                
                $file = fopen('php://output', 'w');
              
                $header = array('序號',
                                'Line 資訊',
                                'Line 暱稱',
                                '會員關係',
                                '會員編號',
                                '會員姓名',
                                '陪伴會員編號',
                                '陪伴會員姓名',
                                '報到時間',
                );
                fputcsv($file, $header);
                $data = $this->activity_model->excel_data($id);
                foreach ($data as $val) {
                	$val['reg_type'] = $this->reg_type[$val['reg_type']];              
                    fputcsv($file, $val);
                }
                fclose($file);
                exit;
    }    
    
}