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
        
        $commonModel = new CommonModel();
        // 上傳檔案
        $files = array('signature');
        $fileIds = array('signature' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        $mainData = json_decode($postData['mainData'], true);
        // 寫入信用卡資料
        $creditCardId = 0;
        if ($mainData['payment_method'] === 'credit_card') {
            $creditData = json_decode($postData['creditData'], true);
            $creditCardData = array(
                'card_type' => '',
                'number' => $creditData['card_number_1'].$creditData['card_number_2'].$creditData['card_number_3'].$creditData['card_number_4'],
                'month' => $creditData['card_expiry_month'],
                'year' => $creditData['card_expiry_year'],
                'bank' => $creditData['bank_name'],
            );
            $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform2');
        }
        
        $form1Model = new Form1Model();
        if ($form1Model->createData($postData, $fileIds, $creditCardId)) {
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
        //身分證加密
        if (!empty($postData['member_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($postData['member_id_card_number']);
            $postData['member_id_card_number'] = $memberEncrypt['encrypted'];
            $postData['member_iv'] = $memberEncrypt['iv'];
        }
        if (!empty($postData['cardholder_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($postData['cardholder_id_card_number']);
            $postData['cardholder_id_card_number'] = $memberEncrypt['encrypted'];
            $postData['cardholder_iv'] = $memberEncrypt['iv'];
        }

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
        $postData['signature_id'] = $fileIds['signature'];
        $postData['signature_post_id'] = $fileIds['signaturePost'];
        $postData['signature_agreement_id'] = $fileIds['signatureAgreement'];
        $postData['signature_check_id'] = $fileIds['signatureCheck'];
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
        //身分證加密
        if (!empty($postData['member_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($postData['member_id_card_number']);
            $postData['member_id_card_number'] = $memberEncrypt['encrypted'];
            $postData['member_iv'] = $memberEncrypt['iv'];
        }
        if (!empty($postData['cardholder_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($postData['cardholder_id_card_number']);
            $postData['cardholder_id_card_number'] = $memberEncrypt['encrypted'];
            $postData['cardholder_iv'] = $memberEncrypt['iv'];
        }

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
        $postData['signature_id'] = $fileIds['signature'];
        $postData['post_signature_id'] = $fileIds['signaturePost'];
        $postData['agreement_signature_id'] = $fileIds['signatureAgreement'];
        $postData['check_signature_id'] = $fileIds['signatureCheck'];
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
        $commonModel = new CommonModel();
        // 上傳檔案
        $files = array('signatureCredit', 'signatureCreditAgreement', 'signatureMemberAgreement');
        $fileIds = array('signatureCredit' => null, 'signatureCreditAgreement' => null, 'signatureMemberAgreement' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        $mainData = json_decode($postData['mainData'], true);
        // 寫入信用卡資料
        $creditCardId = 0;
        if ($mainData['payment_method'] === 'credit_card') {
            $creditData = json_decode($postData['creditData'], true);
            $creditCardData = array(
                'card_type' => '',
                'number' => $creditData['card_number_1'].$creditData['card_number_2'].$creditData['card_number_3'].$creditData['card_number_4'],
                'month' => $creditData['card_expiry_month'],
                'year' => $creditData['card_expiry_year'],
                'bank' => '',
                'three_code' => $creditData['creditCardCvv'],
            );
            $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform4');
        }

        
        $form4Model = new Form4Model();
        if ($form4Model->createData($postData, $fileIds, $creditCardId)) {
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

    public function image()
    {
        $postData = $this->input->post();
        print_r($postData); die();

        $commonModel = new CommonModel();
        $uploadResult = $commonModel->uploadFile($_FILES, 'image', $customFileName);

        print_r($_FILES); die();
        $postData = json_decode(file_get_contents('php://input'), true);
        print_r($postData); die();

        // 處理 base64 圖片數據
        $image_data = $data->imageData;
            
        // 移除 base64 的前綴
        $image_data = str_replace('data:image/jpeg;base64,', '', $image_data);
        $image_data = str_replace(' ', '+', $image_data);
        
        // 解碼 base64
        $decoded_image = base64_decode($image_data);

        // 設定上傳資料夾 - IIS路徑
        $filePath = "public/func/eform/";
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $filePath;

        // 生成檔案名稱
        $filename = 'form_' . date('YmdHis') . '.jpg';
        $file_path = $uploadPath . $filename;
    }

    public function form6()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }

        $postData = $this->input->post();
        $commonModel = new CommonModel();
        // 上傳檔案
        $files = array('signatureCredit', 'signatureCreditAgreement');
        $fileIds = array('signatureCredit' => null, 'signatureCreditAgreement' => null);

        foreach ($files as $_val) {
            if (isset($_FILES[$_val])) {
                $uploadResult = $commonModel->uploadFile($_FILES, $_val);

                // 確認上傳成功並取ID
                if ($uploadResult[0] === true) {
                    $fileIds[$_val] = $uploadResult[1];
                }
            }
        }

        $mainData = json_decode($postData['mainData'], true);
        // 寫入信用卡資料
        $creditCardId = 0;
        if ($mainData['payment_method'] === 'credit_card') {
            $creditData = json_decode($postData['creditData'], true);
            $creditCardData = array(
                'card_type' => '',
                'number' => $creditData['card_number_1'].$creditData['card_number_2'].$creditData['card_number_3'].$creditData['card_number_4'],
                'month' => $creditData['card_expiry_month'],
                'year' => $creditData['card_expiry_year'],
                'bank' => $creditData['bank_name'],
                'three_code' => $creditData['creditCardCvv'],
            );
            $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform6');
        }
        
        $form6Model = new Form6Model();
        if ($form6Model->createData($postData, $fileIds, $creditCardId)) {
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

        $commonModel = new CommonModel();
        
        // 上傳檔案
        $files = array('signature');
        $fileIds = array('signature' => null);

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
        $result = array('success' => false, 'message' => '');

        // 寫入信用卡資料
        $creditCardData = array(
            'card_type' => $postData['card_type'],
            'card_number' => $postData['card_number'],
            'card_expiry_month' => $postData['card_expiry_month'],
            'card_expiry_year' => $postData['card_expiry_year'],
            'bank' => $postData['bank_name'],
        );
        $creditCardId = $commonModel->insertCreditCardData($creditCardData, 'eform7');
        
        $form7Model = new Form7Model();
        $postData['credit_id'] = $creditCardId;
        $postData['signature_id'] = $fileIds['signature'];

        $formId = $form7Model->createData($postData);

        // 細項
        for ($i = 1; $i <= 7; $i++) {
            if (!empty($postData['name_'.$i]) || !empty($postData['member_code_'.$i]) 
            || !empty($postData['delivery_date_'.$i]) || !empty($postData['delivery_item_'.$i]) 
            || !empty($postData['purchase_item_'.$i]) || !empty($postData['redemption_item_'.$i])){
                $item = array(
                    'form_id' => $formId,
                    'name' => $postData['name_'.$i],
                    'member_code' => $postData['member_code_'.$i],
                    'delivery_date' => $postData['delivery_date_'.$i],
                    'delivery_item' => $postData['delivery_item_'.$i],
                    'purchase_item' => $postData['purchase_item_'.$i],
                    'redemption_item' => $postData['redemption_item_'.$i],
                );
                $form7Model->createDetailData($item);
            }
        }        

        $result['status'] = 200;
        $result['success'] = true;
        $result['message'] = '資料新增成功';
        
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
        return;
    }

    public function upload()
    {
        $result = array('success' => false);
        $fileId = null;
        $commonModel = new CommonModel();

        if (isset($_FILES['signature'])){
            $uploadResult = $commonModel->uploadFile($_FILES, 'signature');

            // 確認上傳成功並取ID
            if ($uploadResult[0] === true) {
                $fileId = $uploadResult[1];
            }
        }

        if ($fileId !== null){
            $result['success'] = true;
            $result['fileId'] = $fileId;
        }

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }

    public function sendSms($mobile='0903706726', $message='test')
    {
        if (empty($mobile) || empty($message)) {
            echo json_encode(["status" => "error", "message" => "手機號碼和訊息內容不得為空"]);
            return;
        }

        // 發送參數
        $params = [
            'username' => $this->smsConfig('username'),
            'password' => $this->smsConfig('password'),
            'dstaddr'  => $mobile,
            'encoding' => 'BIG5', // 可改為 UCS2（簡體）或 ASCII
            'smbody'   => urlencode(mb_convert_encoding($message, "BIG5", "UTF-8")),
            'rtype'    => 'JSON'
        ];

        // 發送 API 請求
        $response = $this->sendRequest($this->smsConfig('api_url'), $params);

        echo json_encode($response);
    }

    private function smsConfig($type)
    {
        $config = array(
            'api_url' => 'https://www.smsgo.com.tw/sms_gw/sendsms.aspx',
            'query_url' => 'https://www.smsgo.com.tw/sms_gw/query.aspx',
            'balance_url' => 'https://www.smsgo.com.tw/sms_gw/query_point.aspx',
            'username' => 'arsoa203@arsoa.tw',
            'password' => '0227063111',
        );

        return $config[$type];
    }

    /**
     * 發送 HTTP GET 請求
     */
    private function sendRequest($url, $data) {
        $query_string = http_build_query($data);
        $full_url = $url . '?' . $query_string;

        $ch = curl_init($full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 如果是 HTTPS，避免 SSL 問題

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function findValueInDatabase()
    {
        $form7Model = new Form7Model();
        $result = $form7Model->findValueInDatabase();

        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }
}