<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service'
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
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function list($kind)
    {
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
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
                     'c_name' => $data['Search'],
                     'idno'   => $data['Search'],
                     'cell1'  => $data['Search'],
                     'cell2'  => $data['Search'],
                     'e_mail'  => $data['Search']
                    );
        }        
        $where['c_name <>'] = '(預留)';
        
        $data['list'] = $this->block_service->page_list( 'member',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.c_no' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'member';
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/member_list', $data);
        
    }
    
    public function join($kind)
    {
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $data['web_page'] = 'member_join';
         
        $data['Search'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){     
             if (isset($data_post['del'])){
                 foreach ($data_post['del'] as $key => $editid){
                          $this->front_base_model->delete_table('ap_member_join',array('jid'=>$editid));
                 }                 
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
        
        $where = array();
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'uname'    => $data['Search'],
                     'email'    => $data['Search'],
                     'mobile'   => $data['Search'],
                     'tel'      => $data['Search'],
                     'address'  => $data['Search']
                    );
        }        
        
           
        $data['list'] = $this->block_service->page_list( 'ap_member_join',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'jid' => 'desc' )    // order by
            );        
      
        $data['kind'] = $kind;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $this->layout->view('admin/member_join', $data);
        
    }
    
    public function join_out_download()
    {
         $data_post = $this->input->post();
         $where["jid > "]  = '0';
         if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                $other = true;
                if ($data_post['stdt'] > ''){
                    $where["DATE_FORMAT(crdt,'%Y-%m-%d') >= "]  = $data_post['stdt']; 
                    $other = false;
                }
                if ($data_post['eddt'] > ''){
                    $where["DATE_FORMAT(crdt,'%Y-%m-%d') <= "]  = $data_post['eddt']; 
                    $other = false;
                }
                if ($other){
                	  if ($data_post['mid'] > ''){
                        $where["jid >= "]  = $data_post['mid'];        
                    }
                    if ($data_post['xid'] > ''){
                        $where["jid <= "]  = $data_post['xid'];        
                    }
                }
         }
         $listdata = $this->front_admin_model->list_data('ap_member_join',$where);     
         $filename = "入會申請-".date('Y-m-d');                
         
         if ($listdata){                
            $this->block_service->excel_download('xlsx','入會申請',$filename,$listdata,array('jid','uname','mobile','tel','email','postal','address','crdt','ip'),array('申請編號','姓名','手機','電話','電子信箱','郵遞區號','地址','申請時間','申請IP'));
         }else{
            echo '無資料可供下載!'; 
         }                
         exit;	
    }
    
    public function joinsend($jid)
    {
         $result = array('status' => 0, 'errmsg' => '操作有誤!');     
         
         if ($this->front_member_model->joinmail($jid)){
             $result = array('status' => 1, 'errmsg' => '');     
         }
         
         $this->output->set_content_type('application/json');            
         echo json_encode($result);
         exit;    
    } 
    
}