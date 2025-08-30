<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form5 extends MY_Controller
{
    public function __construct()
    {
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        // Set JSON response headers early
        header('Content-Type: application/json');
        
        // Enable CORS for API requests
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // Handle preflight OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        // Simplified constructor for debugging
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_mssql_model' );
        
        // Load Form5 specific models
        $this->load->model( 'eform/Form1Model' );
        $this->load->model( 'eform/Form2Model' );
        $this->load->model( 'eform/Form3Model' );
        $this->load->model( 'eform/Form4Model' );
        $this->load->model( 'eform/Form5Model' );
        $this->load->model( 'eform/Form6Model' );
        $this->load->model( 'eform/Form7Model' );
        $this->load->model( 'eform/CommonModel' );
        
        $this->load->library( 'user_agent' );
        $this->load->helper('url');
    }

    public function submit()
    {
        // print_r($this->session->userdata('member_session')['c_no']); die();

        // 取得表單資料
        $postData = $this->input->post();
        $cCode = $postData['c_code'];   // 會員編號

        // 引用模型
        $commonModel = new CommonModel();
        $form5Model = new Form5Model();

        // 上傳檔案
        $files = array('signature', 'creditCardFront', 'creditCardBack', 'image');
        $fileIds = array('signature' => null, 'creditCardFront' => null, 'creditCardBack' => null, 'image' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                if ($_val == 'image') {     // 頁面截圖
                    // 自訂檔案名稱
                    $serialNumber = $form5Model->fetchLatestForm5SerialNumber($cCode);
                    $customFileName = $cCode . '-' . $serialNumber . '.jpg';
                    $uploadResult = $commonModel->uploadFile($_FILES, $_val, $customFileName);
                }else{
                    $uploadResult = $commonModel->uploadFile($_FILES, $_val);
                }
                //     // 自訂檔案名稱
                //     // $customFileName = $this->session->userdata('member_session')['c_no'] . '_' . date('YmdHis') . substr(microtime(), 2, 3) . '.jpg';
                //     // $uploadResult = $commonModel->uploadFile($_FILES, $_val, $customFileName);
                //     $uploadResult = $commonModel->uploadFile($_FILES, $_val);
                // } else {
                //     $uploadResult = $commonModel->uploadFile($_FILES, $_val);
                // }

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        // 寫入信用卡資料
        $creditCardId = 0;
        if (isset($postData['credit'])) {
            $creditCardData = json_decode($postData['credit'], true);
            $creditCardData = $form5Model->fetchCreditCardDataFormat($creditCardData);
            $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform5');
        }

        // 宅配更新
        if (isset($postData['web_no']) && !empty($postData['web_no'])) {    // 一般入會
            $msconn = $this->front_mssql_model->ms_connect(); 
            $this->front_mssql_model->update_data($msconn, 'isf_h', array('isvcard' => 1), array('web_no' => $postData['web_no']));
        }

        if (isset($postData['join_no']) && !empty($postData['join_no'])) {    // 新入會
            $msconn = $this->front_mssql_model->ms_connect(); 
            $this->front_mssql_model->update_data($msconn, 'jsf_h', array('isvcard' => 1), array('join_no' => $postData['join_no']));
        }

        // 寫入資料        
        $insertData = array(
            'c_name' => $postData['c_code'],
            'order_type' => $postData['order_type'],
            'credit_id' => $creditCardId,
            'year' => $postData['year'],
            'month' => $postData['month'],
            'day' => $postData['day'],
            'image_id' => isset($fileIds['image']) ? $fileIds['image'] : null,
            'signature_id' => isset($fileIds['signature']) ? $fileIds['signature'] : null,
            'credit_front_id' => isset($fileIds['creditCardFront']) ? $fileIds['creditCardFront'] : null,
            'credit_back_id' => isset($fileIds['creditCardBack']) ? $fileIds['creditCardBack'] : null,
        );

        if ($form5Model->createData($insertData)) {
            $result = array(
                "status" => 200,
                "message" => "資料新增成功"
            );
            
            $this->output
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($result));
            return;
        }

        $result = array(
            "status" => 400,
            "error" => "Validation Error",
            "message" => "資料新增失敗，請檢查欄位是否填寫齊全"
        );

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }
}