<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Line_link extends MY_Controller
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
        $where['a.id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.link_title'      => $data['Search'],
                     'a.link_desc'       => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_line_link',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'lottery';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	  /*
        	  $data['list']['rows'][$key]['y_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'Y');
        	  $data['list']['rows'][$key]['c_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'C');
        	  $data['list']['rows'][$key]['n_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'N');
        	  
        	  $data['list']['rows'][$key]['lot_data'] = json_decode($item['lot_data'], true);
        	  if ($data['list']['rows'][$key]['lot_data']){
        	  	  foreach ($data['list']['rows'][$key]['lot_data'] as $akey => $aitem){
        	  	  	       $data['list']['rows'][$key]['lot_data'][$akey]['use_num'] = $this->lottery_model->charge_find_use_count($item['lot_id'],$akey);
        	  	  }
        	  } 
        	  */         	    	
        }
         	
        
        $data['kind'] = $kind;        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數   
                                      
        $this->layout->view('admin/line_link', $data);
        
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
                'link_title'  => '',
                'link_desc'   => '',                                
                'link_member'   => 'Y',
                'link_start'  => '',
                'link_end'    => '',                
                'status'   => 'N',                
                'link_data' => array(),
            );
        }
        else {
            $where  = array ('id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_line_link',$where);
            
            if (!$data['data']){
                redirect( 'line_link/list/U910' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';                
                $data['data']['link_data']   = json_decode($data['data']['link_data'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['id'] = 0;
                $data['data']['status'] = 'N';
            }
        }
                
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;
        
        $this->layout->view('admin/line_link_modify', $data);      
          
    }
    
    // 存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $link_member = 'N';
             if (isset($data_post['link_member']) && $data_post['link_member'] == 'Y'){
             	   $link_member = 'Y';
             }
             
             $data = array (             
                        'link_title'=> $data_post['link_title'],                         
                        'link_desc'=> $data_post['link_desc'],   
                        'link_member'=> $link_member,                          
                        'link_start'=> $data_post['link_start'],   
                        'link_end'=> $data_post['link_end'],   
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             $link_num = 0;
             $srr = array();        
             $dsrr = array();        
             if ($data_post['line_link_num'] > 0) {
                 $sort = 1;
                 // 題目數
                 for ($i = 1; $i <= $data_post['line_link_num']; $i++) {
                     $title = isset($data_post['data_title_' . $i]) ? $data_post['data_title_' . $i] : '';
                     $link = isset($data_post['data_link_' . $i]) ? $data_post['data_link_' . $i] : '';
                     
                     $image = '';
                     if (isset($file_data['data_img_' . $i]['name'])){
                     	   $image = $file_data['data_img_' . $i]['name'];
                     }else{                     	   
                         $image = $data_post['data_img_old_' . $i];
                     }
                                          
                     if ($title > '' && $link > ''){  // 有才存檔
                         $link_num++;
                         $srr[$data_post['data_sort_'.$i]]['title'] = $title;
                         $srr[$data_post['data_sort_'.$i]]['link'] = $link;                         
                         $srr[$data_post['data_sort_'.$i]]['image'] = $image;
                     }
                 }
            
                 ksort($srr); 
                 $arr = array();
                 $sort = 0;
                 foreach ($srr as $key => $item)
                 {
                      $sort++;
                      $dsr = array(
                                     'title'			=> $item['title'],
                                     'link'				=> $item['link'],                                     
                                     'image'			=> $item['image'],
                                  );            
                      $dsrr[] = $dsr;
                 }                        
             }                         
           
             $data['link_num'] = $link_num;
             $data['link_data']   = json_encode($dsrr);
                   
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_line_link',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                                  
                 $id = $this->front_base_model->insert_table('ap_line_link',$data);
                 
                 $checkcode = generatorPassword(4).$id.generatorPassword(4);
                 
                 $this->front_base_model->update_table('ap_line_link',array('checkcode' => $checkcode),array('id'=>$id));  
                 $okmsg =  "新增成功！";
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( 'wadmin/line_link/list/'.$kind);
             
        }    
    
    }

}