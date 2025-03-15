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
        $this->load->model( 'eform/Form7Model' );
        $this->load->model( 'eform/Form1Model' );
                      
        $this->load->library( 'user_agent' );
    }

    public function form1()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $postData = $this->input->post();
        
        $form1Model = new Form1Model();
        if ($form1Model->createData($postData)) {
            $result = array(
                "status" => 200,
                "message" => "資料新增成功"
            );
        } else {
            http_response_code(400);
            $result = array(
                "status" => 400,
                "error" => "Validation Error",
                "message" => "資料新增失敗，請檢查欄位是否填寫齊全"
            );
        }
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
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

        $postData = $this->input->post();
        $result = array('success' => false, 'message' => '');
        
        $form7Model = new Form7Model();
        if ($form7Model->createData($postData)){
            $result['success'] = true;
            $result['message'] = '資料新增成功';
            
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($result));
            return;
        }

        $result['message'] = '資料新增失敗';

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }
    
    
}