<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_eeform extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->model( 'front_admin_model' );
        
        $this->load->library( 'user_agent' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // ��������   
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }

    public function eeform_manage_eeform02()
    {
        $test = 'eeform_manage_eeform2';
        $data = array('text' => $test);
        $this->layout->view('admin/eeform/form2', $data);
    }
}