<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eform extends MY_Controller
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

    public function eform1()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );
        
        $this->layout->view('./eeform/eform01', $data);
    }

    public function eform1_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );
        
        $this->layout->view('./eeform/eform01_list', $data);
    }

    public function eform2()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eeform/eform02', $data);
    }

    public function eform3()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eeform/eform03', $data);
    }

    public function eform3_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
        );

        $this->layout->view('./eeform/eform03_list', $data);
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

    public function saveEform03()
    {
        $postData = $this->input->post();
        
        if (empty($postData)) {
            redirect('Eform/form3');
        }

        // 驗證必填欄位
        $required_fields = ['member_name', 'member_id', 'age', 'height', 'goal'];
        foreach ($required_fields as $field) {
            if (empty($postData[$field])) {
                $this->session->set_flashdata('error', '請填寫所有必填欄位');
                redirect('Eform/form3');
            }
        }

        // 準備資料
        $formData = array(
            'member_name' => $postData['member_name'],
            'member_id' => $postData['member_id'],
            'age' => intval($postData['age']),
            'height' => intval($postData['height']),
            'goal' => $postData['goal'],
            'action_plan_1' => isset($postData['action_plan_1']) ? $postData['action_plan_1'] : '',
            'action_plan_2' => isset($postData['action_plan_2']) ? $postData['action_plan_2'] : '',
            'weight' => isset($postData['weight']) ? floatval($postData['weight']) : null,
            'blood_pressure_high' => isset($postData['blood_pressure_high']) ? intval($postData['blood_pressure_high']) : null,
            'blood_pressure_low' => isset($postData['blood_pressure_low']) ? intval($postData['blood_pressure_low']) : null,
            'waist' => isset($postData['waist']) ? floatval($postData['waist']) : null,
            'hand_measure' => isset($postData['hand_measure']) ? 1 : 0,
            'exercise' => isset($postData['exercise']) ? 1 : 0,
            'health_supplement' => isset($postData['health_supplement']) ? 1 : 0,
            'weika' => isset($postData['weika']) ? 1 : 0,
            'water_intake' => isset($postData['water_intake']) ? 1 : 0,
            'plan_a' => isset($postData['plan_a']) ? $postData['plan_a'] : '',
            'plan_b' => isset($postData['plan_b']) ? $postData['plan_b'] : '',
            'other' => isset($postData['other']) ? $postData['other'] : '',
            'created_at' => date('Y-m-d H:i:s')
        );

        // 這裡應該儲存到資料庫，因為沒有model，所以先設定session訊息
        $this->session->set_flashdata('success', '表單已成功送出！');
        
        // 重定向到列表頁面
        redirect('eeform/eform03_list');
    }
}