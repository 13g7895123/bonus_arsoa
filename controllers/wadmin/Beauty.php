<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beauty extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->model( 'front_admin_model' );
        $this->load->model( 'front_base_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->load->library('ui');
        
        $this->load->library( 'user_agent' );
        
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
        
        if ($data['Search'] > ''){
            $like = array(
                     'nickname' => $data['Search'],
                     'uname'   => $data['Search'],
                     'email'  => $data['Search'],
                     'content'  => $data['Search'],
                     'subject'  => $data['Search']
                    );
        }        
        $where['uname <>'] = '';
        
        $data['list'] = $this->block_service->page_list( 'ab_share',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'ab_share_id' => 'desc' )    // order by
        );      
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );
                
        $data['web_page'] = 'ab_share';
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/beauty_list', $data);
        
    }
        
    public function modify($kind)
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
        
        $where  = array ('ab_share_id' => $data['edit']);        
         
        $data['data'] = $this->front_admin_model->get_data('ab_share',$where);
                      
        $data['web_page'] = 'beauty_modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
        
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/beauty_modify', $data);
       
    }
    
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
          
             $data = array (
                        'content'   => $data_post['content'],
                        'ifShow'    => $data_post['ifShow'],                        
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             $where['ab_share_id ='] = $data_post['edit'];                 
             $this->front_base_model->update_table('ab_share',$data,$where);
             $okmsg = '編輯成功！';
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
             PF_submit(base_url('wadmin/beauty/list/'.$kind) ,$ahidden);
        }
    }
      
}