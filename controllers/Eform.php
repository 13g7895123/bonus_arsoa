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

    public function saveEform01()
    {
        $postData = $this->input->post();
        
        if (empty($postData)) {
            redirect('Eform/eform1');
        }

        // 驗證必填欄位
        $required_fields = ['member_name', 'birth_year', 'birth_month', 'phone'];
        foreach ($required_fields as $field) {
            if (empty($postData[$field])) {
                $this->session->set_flashdata('error', '請填寫所有必填欄位');
                redirect('Eform/eform1');
            }
        }

        // 準備資料
        $formData = array(
            'member_name' => $postData['member_name'],
            'birth_year' => intval($postData['birth_year']),
            'birth_month' => intval($postData['birth_month']),
            'phone' => $postData['phone'],
            
            // 職業選擇
            'occupation_service' => isset($postData['occupation_service']) ? 1 : 0,
            'occupation_office' => isset($postData['occupation_office']) ? 1 : 0,
            'occupation_restaurant' => isset($postData['occupation_restaurant']) ? 1 : 0,
            'occupation_housewife' => isset($postData['occupation_housewife']) ? 1 : 0,
            
            // 戶外日曬時間
            'sunlight_1_2h' => isset($postData['sunlight_1_2h']) ? 1 : 0,
            'sunlight_3_4h' => isset($postData['sunlight_3_4h']) ? 1 : 0,
            'sunlight_5_6h' => isset($postData['sunlight_5_6h']) ? 1 : 0,
            'sunlight_8h_plus' => isset($postData['sunlight_8h_plus']) ? 1 : 0,
            
            // 空調環境時間
            'aircondition_1h' => isset($postData['aircondition_1h']) ? 1 : 0,
            'aircondition_2_4h' => isset($postData['aircondition_2_4h']) ? 1 : 0,
            'aircondition_5_8h' => isset($postData['aircondition_5_8h']) ? 1 : 0,
            'aircondition_8h_plus' => isset($postData['aircondition_8h_plus']) ? 1 : 0,
            
            // 睡眠狀況
            'sleep_9_10' => isset($postData['sleep_9_10']) ? 1 : 0,
            'sleep_11_12' => isset($postData['sleep_11_12']) ? 1 : 0,
            'sleep_after_1' => isset($postData['sleep_after_1']) ? 1 : 0,
            'sleep_other' => isset($postData['sleep_other']) ? 1 : 0,
            'sleep_other_text' => isset($postData['sleep_other_text']) ? $postData['sleep_other_text'] : '',
            
            // 現在使用產品
            'product_honey_soap' => isset($postData['product_honey_soap']) ? 1 : 0,
            'product_mud_mask' => isset($postData['product_mud_mask']) ? 1 : 0,
            'product_toner' => isset($postData['product_toner']) ? 1 : 0,
            'product_serum' => isset($postData['product_serum']) ? 1 : 0,
            'product_premium' => isset($postData['product_premium']) ? 1 : 0,
            'product_sunscreen' => isset($postData['product_sunscreen']) ? 1 : 0,
            'product_other' => isset($postData['product_other']) ? 1 : 0,
            'product_other_text' => isset($postData['product_other_text']) ? $postData['product_other_text'] : '',
            
            // 肌膚困擾
            'skin_issue_elasticity' => isset($postData['skin_issue_elasticity']) ? 1 : 0,
            'skin_issue_luster' => isset($postData['skin_issue_luster']) ? 1 : 0,
            'skin_issue_dull' => isset($postData['skin_issue_dull']) ? 1 : 0,
            'skin_issue_spots' => isset($postData['skin_issue_spots']) ? 1 : 0,
            'skin_issue_pores' => isset($postData['skin_issue_pores']) ? 1 : 0,
            'skin_issue_acne' => isset($postData['skin_issue_acne']) ? 1 : 0,
            'skin_issue_wrinkles' => isset($postData['skin_issue_wrinkles']) ? 1 : 0,
            'skin_issue_rough' => isset($postData['skin_issue_rough']) ? 1 : 0,
            'skin_issue_irritation' => isset($postData['skin_issue_irritation']) ? 1 : 0,
            'skin_issue_dry' => isset($postData['skin_issue_dry']) ? 1 : 0,
            'skin_issue_makeup' => isset($postData['skin_issue_makeup']) ? 1 : 0,
            'skin_issue_other' => isset($postData['skin_issue_other']) ? 1 : 0,
            'skin_issue_other_text' => isset($postData['skin_issue_other_text']) ? $postData['skin_issue_other_text'] : '',
            
            // 過敏狀況
            'allergy_frequent' => isset($postData['allergy_frequent']) ? 1 : 0,
            'allergy_seasonal' => isset($postData['allergy_seasonal']) ? 1 : 0,
            'allergy_never' => isset($postData['allergy_never']) ? 1 : 0,
            
            // 建議內容
            'toner_suggestion' => isset($postData['toner_suggestion']) ? $postData['toner_suggestion'] : '',
            'serum_suggestion' => isset($postData['serum_suggestion']) ? $postData['serum_suggestion'] : '',
            'suggestion_content' => isset($postData['suggestion_content']) ? $postData['suggestion_content'] : '',
            
            // 肌膚類型
            'skin_type' => isset($postData['skin_type']) ? $postData['skin_type'] : '',
            'skin_age' => isset($postData['skin_age']) ? intval($postData['skin_age']) : null,
            
            'created_at' => date('Y-m-d H:i:s')
        );

        // 這裡應該儲存到資料庫，因為沒有model，所以先設定session訊息
        $this->session->set_flashdata('success', '肌膚諮詢記錄表已成功送出！');
        
        // 重定向到列表頁面
        redirect('eform/eform1_list');
    }
}