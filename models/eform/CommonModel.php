<?php
class CommonModel extends CI_Model
{
    private $db;
    protected $key = "e0b1c1d4f2a8c9b7d23f5d9a12e7d35b";
    protected $gcmKey = '12345678901234567890123456789012';

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

        if ($data['card_type'] == '') {
            $data['card_type'] = 'VISA';
        }

        // 確認資料
        if (isset($data['three_code'])) {
            $data['three_code'] = $this->encryptGCM($data['three_code']);
        } else {
            $data['three_code'] = '';
        }

        if (isset($data['english_name'])) {
            $data['english_name'] = '';
        }

        // 加密
        $encryptedNumber = $this->encryptGCM($data['number']);
        $data['number'] = $encryptedNumber;

        // $sql = $this->db->set($data)->get_compiled_insert('eform_credit');
        // print_r($sql); die();

        $this->db->insert('eform_credit', $data);
        return $this->db->insert_id();
    }

    // GCM加密
    public function encryptGCM($plaintext) {
        $cipher = "aes-256-gcm";
        $iv = openssl_random_pseudo_bytes(12); // 產生 12-byte IV
        $tag = 'arsoagcm';

        // 加密
        $ciphertext = openssl_encrypt($plaintext, $cipher, $this->gcmKey, OPENSSL_RAW_DATA, $iv, $tag);
        
        // 轉為 base64
        $ciphertext = base64_encode($ciphertext);

        // 回傳
        return base64_encode($iv) . ':' . base64_encode($ciphertext) . ':' . base64_encode($tag);
    }

    // GCM解密
    public function decryptGCM($encryptedText) {
        $cipher = 'aes-256-gcm';
        list($iv, $ciphertext, $tag) = explode(':', $encryptedText);
    
        // Base64 解碼
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);
        $tag = base64_decode($tag);
    
        // 執行解密
        $plaintext = openssl_decrypt($ciphertext, $cipher, $this->gcmKey, OPENSSL_RAW_DATA, $iv, $tag);
        
        return $plaintext ?: false; // 若解密失敗則回傳 false
    }

    public function encryptID($plaintext) {
        $cipher = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(16); // 產生 16-byte IV
        $ciphertext = openssl_encrypt($plaintext, $cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        
        return [
            'encrypted' => base64_encode($ciphertext), // 轉為 base64 存入資料庫
            'iv' => base64_encode($iv)
        ];
    }

    public function decryptID($ciphertext, $iv) {
        $cipher = "AES-256-CBC";
        return openssl_decrypt(base64_decode($ciphertext), $cipher, $this->key, OPENSSL_RAW_DATA, base64_decode($iv));
    }
}