<?php
class CommonModel extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    /**
     * 上傳檔案
     * @param array $fileData 上傳的檔案資料
     * @param string $name 檔案名稱
     * @return array 上傳結果，包含是否成功和插入的ID
     */
    public function uploadFile($fileData, $name)
    {
        if (!isset($fileData[$name])) {
            throw new Exception("沒有上傳的檔案");
        }

        // 設定上傳資料夾 - IIS路徑
        $filePath = "public/func/eform/";
        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $filePath;
        
        // 取得上傳檔案資訊
        $file = $fileData[$name];
        $fileTmpPath = $file['tmp_name'];
        $fileName = str_replace('.', '', uniqid(rand(), true)) . ".png";
        $destination = $uploadPath . $fileName;
        $originalFileName = $file['name'];      // 取得原始檔名
        $fileType = $file['type'];             // 取得檔案類型 MIME type
        $fileSize = $file['size'];             // 取得檔案大小(bytes)

        // 檢查是否為有效圖片
        $imageInfo = @getimagesize($fileTmpPath);
        if ($imageInfo === false) {
            throw new Exception("無效的圖片格式");
        }

        // 檢查圖片類型
        $allowedTypes = [IMAGETYPE_PNG, IMAGETYPE_JPEG];
        if (!in_array($imageInfo[2], $allowedTypes)) {
            throw new Exception("只允許PNG或JPEG格式");
        }

        // 移動檔案到上傳目錄
        if (!move_uploaded_file($fileTmpPath, $destination)) {
            throw new Exception("檔案儲存失敗: " . error_get_last()['message']);
        }

        // 寫入資料表
        $insertData = array(
            'name' => $originalFileName,
            'path' => $filePath . $fileName,
            'type' => $fileType,
            'size' => $fileSize,
            'uploaded_at' => date('Y-m-d H:i:s')
        );
        $insertId = $this->insertFileData($insertData);

        return [True, $insertId];
    }

    public function insertFileData($data)
    {
        $this->db->insert('eform_file', $data);
        return $this->db->insert_id();
    }

    /**
     * 寫入信用卡資料
     * @param array $data 信用卡資料
     * @param string $formCode 表單代碼
     * @return void
     */ 
    public function insertCreditCardData($data, $formCode)
    {
        $data['form_code'] = $formCode;

        // 確認資料
        $checkData = array('three_code', 'english_name');
        foreach ($checkData as $_val) {
            if (isset($data[$_val]) === false) {
                $data[$_val] = '';
            }
        }

        $this->db->insert('eform_credit', $data);
        return $this->db->insert_id();
    }
}