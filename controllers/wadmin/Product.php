<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->library('ui');
                
        $this->load->model( 'front_admin_model' );            
        $this->load->model( 'front_product_model' );
        $this->load->model( 'front_base_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
                   
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試   
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function list($kind)
    {
        $data['Search'] = '';
        $Swp1 = '';
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page = $data_post['Page'];
             }
             if (isset($data_post['Swp1'])){
                 $Swp1 =  $data_post['Swp1'];
             }             
        }
        
        $data['web_page'] = 'product_list';
                
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
                
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );

        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'p.p_name'      => $data['Search'],
                     'p.p_no'        => $data['Search'],
                     'p.pro_title1'  => $data['Search']
                    );
        }
        
        if ($kind == '2001'){                    
            $where['p.is_web ='] = '1';
            $where['p.is_nogoods ='] = '0';
            $where['p.m_mp >'] = '0';
        }else{
            $where['p.is_list ='] = '1';
            $where['ifnull(p.c_price,0) >'] = '0';
        }
        if ($Swp1 == 'A' || $Swp1 == ''){
            $where['p.wp1_no > '] = '0';
        }else{
            $where['p.wp1_no'] = $Swp1;
        }
        
        $data['list'] = $this->front_product_model->page_list( $where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'p.p_no' => 'asc')    // order by
            );        
         
        $where  = array ('wp1_no >' => '0');                 
        $data['wp1'] = $this->front_base_model->get_data('wp1_type',$where);
       
        $data['kind'] = $kind;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount']   = $data['list']['PageCount']; //總頁數        
        $data['Swp1'] = $Swp1;
        
        $this->layout->view('admin/product_list', $data);
    }
    
    public function modify($kind)
    {
        $data_post = $this->input->post();
        $data['web_page'] = 'product_modify';
        $data['edit'] = 0;
        $data['Search'] = '';
        $data['Page'] = 1;
        $data['data'] = array();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (!empty($this->input->get( 'edit' ))){
                 $data['edit'] = $this->input->get( 'edit' );
             }
           //  $data['pid'] = 0;
            // if (!empty($this->input->get( 'pid' ))){
            //     $data['pid'] = (int)$this->input->get( 'pid' );
           //  }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }          
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }  
             if (isset($data_post['Swp1'])){
                 $data['Swp1']   = $data_post['Swp1'];
             }          
             $data['GoBackUrl'] = $data_post['GoBackUrl'];   
        }
        
        if ($data['edit'] > ''){              
            $data['data'] = $this->front_product_model->get_data($data['edit']);  
            
            $data['kind'] = $kind;
            
            $this->layout->view('admin/product_modify', $data);
        }
              
    }
    
    public function save($kind)
    {
        $data_post = $this->input->post();
        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {
             if (isset($data_post['menu_sort'])){
                 if ($data_post['menu_sort'] == '1' || $data_post['menu_sort'] == '2'){
                     $data['menu_sort']     = $data_post['menu_sort'];                     
                     $data['menu_name']     = $data_post['menu_name'];
                     $swhere['menu_sort ='] = $data_post['menu_sort'];        
                     $this->front_base_model->update_table('ap_product',array('menu_sort'=>''),$swhere);
                 }else{
                     $data['menu_sort'] = '';
                     $data['menu_name'] = '';
                 }
             }else{
                $data['menu_sort'] = '';  
                $data['menu_name'] = '';
             }
             
             $data['body'] = $data_post['body'];
             $data['p_title1'] = $data_post['p_title1'];
             $data['p_title2'] = $data_post['p_title2'];
             $data['tags'] = $data_post['tags'];
             $data['updt'] = date('Y-m-d H:i:s');
             $data['account'] = $_SESSION['admin_session']['admin_name'];       
             
             $prd_data =  $this->front_admin_model->get_data('ap_product',array('p_no'=>$data_post['edit']),'',1); 
             if ($prd_data){              
                 $where['pid ='] = $prd_data['pid'];                 
                 $where['p_no ='] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_product',$data,$where);
                 $okmsg = '編輯成功！';
             }else{
                 $data['p_no'] = $data_post['edit'];
                 $data['crdt'] = date('Y-m-d H:i:s');
                 $data['hits'] = 0;
                 $id = $this->front_base_model->insert_table('ap_product',$data);
                 $okmsg =  "設定成功！";
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                                                      
                           'Page'   =>  $data_post['Page'],
                        );
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
             if ($data_post['Swp1'] > ''){
                 $ahidden['Swp1'] = $data_post['Swp1'];
             }
             PF_submit(base_url('wadmin/product/list/'.$kind) ,$ahidden);
             
        }
        
    }
}