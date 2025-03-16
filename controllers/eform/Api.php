<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller
{
    // private $db;

    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_mssql_model' );

        $this->load->model( 'eform/Form1Model' );
        $this->load->model( 'eform/Form2Model' );
        $this->load->model( 'eform/Form3Model' );
        $this->load->model( 'eform/Form4Model' );
        $this->load->model( 'eform/Form5Model' );
        $this->load->model( 'eform/Form6Model' );
        $this->load->model( 'eform/Form7Model' );
        $this->load->model( 'eform/CommonModel' );
        $this->load->library( 'user_agent' );

        // $this->db = $this->load->database('default', true);
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

        $commonModel = new CommonModel();
        
        // 上傳檔案
        $files = array('signature', 'signaturePost', 'signatureAgreement', 'signatureCheck');
        $fileIds = array('signature' => null, 'signaturePost' => null, 'signatureAgreement' => null, 'signatureCheck' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        $postData = $this->input->post();

        // 寫入信用卡資料
        $creditCardData = array(
            'card_type' => $postData['card_type'],
            'number' => $postData['card_number'],
            'month' => $postData['card_expiry_month'],
            'year' => $postData['card_expiry_year'],
            'bank' => $postData['bank_name'],
        );
        $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform2');

        $form2Model = new Form2Model();
        $postData['credit_id'] = $creditCardId;
        $formId = $form2Model->createData($postData);

        // 細項
        if (isset($postData['products'])) {
            $products = explode(',', $postData['products']);
            if (count($products) > 0) {
                $insertBatchData = array();
                foreach ($products as $_val) {
                    $insertBatchData[] = array(
                        'form_id' => $formId,
                        'product_code' => $_val,
                    );
                }

                // 批次建立資料
                $form2Model->createDetailData($insertBatchData);
            }
        }

        $result = array(
            "status" => 200,
            "message" => "資料新增成功"
        );

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }

    public function form3()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $commonModel = new CommonModel();
        
        // 上傳檔案
        $files = array('signature', 'signaturePost', 'signatureAgreement', 'signatureCheck');
        $fileIds = array('signature' => null, 'signaturePost' => null, 'signatureAgreement' => null, 'signatureCheck' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        $postData = $this->input->post();

        // 寫入信用卡資料
        $creditCardData = array(
            'card_type' => $postData['card_type'],
            'number' => $postData['card_number'],
            'month' => $postData['card_expiry_month'],
            'year' => $postData['card_expiry_year'],
            'bank' => $postData['bank_name'],
        );
        $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform3');

        $form3Model = new Form3Model();
        $postData['credit_id'] = $creditCardId;
        $formId = $form3Model->createData($postData);

        // 細項
        if (isset($postData['products'])) {
            $products = explode(',', $postData['products']);
            if (count($products) > 0) {
                $insertBatchData = array();
                foreach ($products as $_val) {
                    $insertBatchData[] = array(
                        'form_id' => $formId,
                        'product_code' => $_val,
                    );
                }

                // 批次建立資料
                $form3Model->createDetailData($insertBatchData);
            }
        }

        $result = array(
            "status" => 200,
            "message" => "資料新增成功"
        );

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }

    public function form4()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $postData = $this->input->post();
        
        $form4Model = new Form4Model();
        if ($form4Model->createData($postData)) {
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

    public function form5()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        // 取得表單資料
        $postData = $this->input->post();

        // 引用模型
        $commonModel = new CommonModel();
        $form5Model = new Form5Model();

        // 上傳檔案
        $files = array('signature', 'creditCardFront', 'creditCardBack');
        $fileIds = array('signature' => null, 'creditCardFront' => null, 'creditCardBack' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        // 寫入信用卡資料
        if (isset($postData['credit'])) {
            $creditCardData = json_decode($postData['credit'], true);
            $creditCardData = $form5Model->fetchCreditCardDataFormat($creditCardData);
            $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform5');
        }

        // 寫入資料        
        $insertData = array(
            'c_name' => $postData['c_name'],
            'credit_id' => $creditCardId,
            'year' => $postData['year'],
            'month' => $postData['month'],
            'day' => $postData['day'],
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

    public function form6()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $postData = $this->input->post();
        
        $form6Model = new Form6Model();
        if ($form6Model->createData($postData)) {
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