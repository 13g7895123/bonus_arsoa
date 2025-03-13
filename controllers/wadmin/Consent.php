<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consent extends MY_Controller
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
        $this->load->model( 'consent_model' );           
        
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
        $where['a.c_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_title'      => $data['Search'],
                     'a.c_desc'      => $data['Search'],
                     'a.c_body'      => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_consent',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.c_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'consent';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	 
        	  $data['list']['rows'][$key]['y_num'] = $this->consent_model->charge_find_count($item['c_id'],'Y');        	  
        	  $data['list']['rows'][$key]['n_num'] = $this->consent_model->charge_find_count($item['c_id'],'N');
        	  
        	  $data['list']['rows'][$key]['c_config'] = json_decode($item['c_config'], true);
        }
         	
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/consent_list', $data);
        
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
            $data['data'] = array(
                'edit'     => 0,
                'c_title'  => '',
                'c_desc'   => '',                                
                'c_body'   => '',                                                
                'c_start'  => '',
                'c_end'    => '',
                'status'   => 'N',
                'c_config' => array('member'=>'N','charge'=>'Y'),                
            );
        }
        else {
            $where  = array ('c_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_consent',$where);
            
            if (!$data['data']){
                redirect( 'consent/list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';                                     
                $data['data']['c_config']   = json_decode($data['data']['c_config'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['c_img'] = '';          
                $data['data']['c_id'] = 0;
                $data['data']['status'] = 'N';
            }
        }
                
        $data['web_page'] = 'consent';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/consent_modify', $data);      
          
    }
    
    // 存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $data = array (
                        'c_title'=> $data_post['c_title'], 
                        'c_desc'=> $data_post['c_desc'],   
                        'c_body'=> $data_post['c_body'],                               
                        'c_start'=> $data_post['c_start'],   
                        'c_end'=> $data_post['c_end'],   
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
            
             $c_config = array(
                                'member'=>'N',
                                'charge'=>'Y',
                                'agree_desc' => $data_post['agree_desc']                                
                                );              
             
             $data['c_config']   = json_encode($c_config);
             
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['c_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_consent',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $id = $this->front_base_model->insert_table('ap_consent',$data);
                 
                 $checkcode = generatorPassword(4).$id.generatorPassword(4);
                 
                 $this->front_base_model->update_table('ap_consent',array('checkcode' => $checkcode),array('c_id'=>$id));  
                 $okmsg =  "新增成功！";
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( 'wadmin/consent/list/'.$kind);
             
        }    
    
    }
    
     // 列表
    public function charge_list($kind,$c_id = '')
    {
    	  
                
        $data['Search'] = '';  
        $data['Follow'] = ''; 
        $data['Status'] = ''; 
        
        $data['c_id'] = '';        	
        if ($c_id > ''){
            $data['c_id'] = $c_id;        	
        }        
         
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['break_bid']) && $data_post['break_bid'] > 0){   // 有值代表要刪掉
        		     $this->front_base_model->delete_table('ap_consent_charge',array('id'=>$data_post['break_bid']));   
        		    // $data['ok_message'] = '已刪除！';           
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
             if (isset($data_post['c_id']) && $data_post['c_id'] > ''){
                 $data['c_id'] = $data_post['c_id'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }   
             if (isset($data_post['s_num']) && $data_post['s_num'] > 0){
             	   for ($i = 1;$i<=$data_post['s_num'];$i++)
             	   { 
             	   	    if (isset($data_post['c_id_'.$i])){
             	   	        $upchk = false;
             	   	        $c_id = $data_post['c_id_'.$i];             	   	        
             	   	        if (isset($data_post['del_'.$c_id]) && $data_post['del_'.$c_id] == 'Y'){ // 刪除
             	   	            $udata['status'] = 'D';
             	   	            $upchk = true;
             	   	        }else{
             	   	        	  if (isset($data_post['outdt_'.$c_id]) && $data_post['outdt_'.$c_id] > ''){ // 寄送日期
             	   	        	  	  $udata['status'] = 'Y';
             	   	        	  	  $udata['outdt'] = $data_post['outdt_'.$c_id];
             	   	        	  	  $upchk = true;
             	   	        	  }
             	   	        }
             	   	        if ($upchk){
             	   	            $udata['updt'] = date('Y-m-d H:i:s');
             	   	            $udata['account'] = $_SESSION['admin_session']['admin_name'];
             	   	            
             	   	            $this->consent_model->charge_update_data($c_id,$udata);
                          }
             	   	    }
             	   }
             }                  
        }
              
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        
        if ($data['c_id'] > ''){
            $where['a.c_id'] = $data['c_id'];
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
                     'a.user_id'       => $data['Search'],
                     'a.display_name'  => $data['Search'],
                    );
        }            	  
    	  
    	  $data['list'] = $this->consent_model->charge_page_list( 'ap_consent_charge',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.id' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'consent';
    	  
    	  $data['kind'] = 'T002'; 
    	  
    	  $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $data['class']  = $this->front_base_model->get_data('ap_consent',array('c_id >' => '0'),array('c_id'=>'desc'));  
    	      	  
        $this->layout->view('admin/consent_charge_list', $data);      
    }
    
    
    public function excel_export($atype,$id)
    {
    	          mb_internal_encoding('utf-8');

                header("Pragma: public"); // required
                header("Expires: 0");
                header('Content-Encoding: UTF-8');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false); // required for certain browsers
                header("Content-Type: application/csv; charset=UTF-8");
                header('Content-Disposition:filename="同意書名單_'.$id.'-' . date_format(new Datetime('now'), 'Y-m-d') . '.csv"');                
                header("Content-Transfer-Encoding: binary");
                echo "\xEF\xBB\xBF";
                $file = fopen('php://output', 'w');
                       
                $header = array('序號',
                                'Line 資訊',
                                'Line 暱稱',                                
                                '會員編號',
                                '會員姓名',
                                '同意書狀態',
                                '開啟時間',                          
                                '同意時間',
                );
                fputcsv($file, $header);  
                $data = $this->consent_model->excel_data($atype,$id);
             
                foreach ($data as $val) {
                    fputcsv($file, $val);
                }
                fclose($file);
                exit;
    }    
    
}