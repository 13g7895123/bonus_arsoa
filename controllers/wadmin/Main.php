<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->model( 'front_admin_model' );
        
        $this->load->library( 'user_agent' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // ¥»¾÷´ú¸Õ   
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function index()
    {
     
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
           
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        $data['web_page'] = 'main';
                      
        $this->layout->view('admin/main', $data);
        
    }
    
}