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
        $this->load->model( 'eform/Form4Model' );
        $this->load->model( 'eform/Form6Model' );
        $this->load->model( 'eform/Form7Model' );
        
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

        print_r(123); die();
        // $this->fileUpload();
        // print_r($_FILES); die();
        // $commonModel = new CommonModel();
        // $commonModel->uploadFile($_FILES);
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
    
    // public function fileUpload()
    // {        
    //     if (!isset($_FILES['signature'])) {
    //         throw new Exception("沒有上傳的檔案");
    //     }

    //     // 設定上傳資料夾 - IIS路徑
    //     // $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/images/";
    //     // $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/";
    //     $filePath = "public/func/eform/";
    //     $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $filePath;
        
    //     // 取得上傳檔案資訊
    //     $file = $_FILES['signature'];
    //     print_r($file); die();
    //     $fileTmpPath = $file['tmp_name'];
    //     $fileName = "sign_" . time() . ".png";
    //     $destination = $uploadPath . $fileName;
    //     $originalFileName = $file['name'];      // 取得原始檔名
    //     $fileType = $file['type'];             // 取得檔案類型 MIME type
    //     $fileSize = $file['size'];             // 取得檔案大小(bytes)

    //     // 取得原始檔名
    //     $originalFileName = $file['name'];

    //     // 檢查是否為有效圖片
    //     $imageInfo = @getimagesize($fileTmpPath);
    //     if ($imageInfo === false) {
    //         throw new Exception("無效的圖片格式");
    //     }

    //     // 檢查圖片類型
    //     $allowedTypes = [IMAGETYPE_PNG, IMAGETYPE_JPEG];
    //     if (!in_array($imageInfo[2], $allowedTypes)) {
    //         throw new Exception("只允許PNG或JPEG格式");
    //     }

    //     // 移動檔案到上傳目錄
    //     // print_r($fileTmpPath); die();
    //     if (!move_uploaded_file($fileTmpPath, $destination)) {
    //         throw new Exception("檔案儲存失敗: " . error_get_last()['message']);
    //     }

    //     // 寫入資料表
    //     $insertData = array(
    //         'name' => $originalFileName,
    //         'path' => $filePath . $fileName,
    //         'type' => $fileType,
    //         'size' => $fileSize,
    //         'upload_at' => date('Y-m-d H:i:s')
    //     );
    //     $this->db->insert('eform_file', $insertData);

    //     return True;
    // }
}