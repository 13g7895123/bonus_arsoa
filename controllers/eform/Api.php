<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_mssql_model' );
                      
        $this->load->library( 'user_agent' );
    }

    public function form1()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form2()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form3()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form4()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form5()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form6()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }

    public function form7()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $msconn = $this->front_mssql_model->ms_connect(); 
        
        $postData = $this->input->post();
        print_r($postData); die();
    }
    
    
}