<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_form extends MY_Controller
{
    protected $userdata;
    protected $apiBaseUrl;

    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_product_model' );
        $this->load->model( 'front_mssql_model' );
                      
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));

        // Get current function name
        $nowFunction = $this->router->fetch_method();

        if ($nowFunction != 'form5') {
            if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                redirect( 'member/login' );
            }
            $this->userdata = $this->session->userdata['member_session'];
        }

        // api url
        $this->apiBaseUrl = base_url() . 'eform/api/';
    }

    public function testVariable()
    {
        echo '<pre>';
        print_r();
        echo '</pre>';
    }

    public function form1()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );
        
        $blockNum = 10;
        for($index=1;$index<=$blockNum;$index++) {
            $subView['index'] = $index;
            $data['subView'] .= $this->load->view('eform/sub_eform01', $subView, true);
        }
        $this->layout->view('./eform/eform01', $data);
    }

    public function form2()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eform/eform02', $data);
    }

    public function form3()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eform/eform03', $data);
    }

    public function form4()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );
        $blockNum = 4;
        for($index=1;$index<=$blockNum;$index++) {
            $subView['index'] = $index;
            $data['subView'] .= $this->load->view('eform/sub_eform04', $subView, true);
        }
        $this->layout->view('./eform/eform04', $data);
    }

    public function form5()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        // 如果有宅配的話，會帶入會員編號和姓名
        $getData = $this->input->get();
        if (isset($getData['code']) && isset($getData['name'])) {
            $data['userdata']['c_no'] = trim($getData['code']);
            $data['userdata']['c_name'] = trim($getData['name']);
        }

        $data['userdata']['web_no'] = (isset($getData['web_no'])) ? trim($getData['web_no']) : '';
        $data['userdata']['join_no'] = (isset($getData['join_no'])) ? trim($getData['join_no']) : '';

        $this->layout->view('./eform/eform05', $data);
    }

    public function form6()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );
        $blockNum = 12;
        for($index=1;$index<=$blockNum;$index++) {
            $subView['index'] = $index;
            $data['subView'] .= $this->load->view('eform/sub_eform06', $subView, true);
        }
        $this->layout->view('./eform/eform06', $data);
    }

    public function form7()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eform/eform07', $data);
    }

    public function form8()
    {
        $data = array(
            'apiUrl' => $this->apiBaseUrl . 'submit'
        );
        
        $this->layout->view('./eform/eform08', $data);
    }
}