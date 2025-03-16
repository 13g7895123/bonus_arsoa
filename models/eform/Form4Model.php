<?php
/*
 *  活動
 */
class Form4Model extends CI_Model
{
    private $db;
    protected $mainTableName = "eform4_main";
    protected $detailTableName = "eform4_detail";
    protected $key = "e0b1c1d4f2a8c9b7d23f5d9a12e7d35b";
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data)
    {
        $mainData = $data['mainData'];
        //身分證加密
        $mainData['member_iv'] = ''; //initial
        $mainData['spouse_iv'] = ''; //initial
        if (!empty($mainData['member_id_card_number'])) {
            $memberEncrypt = $this->encryptID($mainData['member_id_card_number']);
            $mainData['member_id_card_number'] = $memberEncrypt['encrypted'];
            $mainData['member_iv'] = $memberEncrypt['iv'];
        }
        if (!empty($mainData['spouse_id_card_number'])) {
            $memberEncrypt = $this->encryptID($mainData['spouse_id_card_number']);
            $mainData['spouse_id_card_number'] = $memberEncrypt['encrypted'];
            $mainData['spouse_iv'] = $memberEncrypt['iv'];
        }
        

        $mainData['create_time'] = date('Y-m-d H:i:s');
        $mainData['update_time'] = date('Y-m-d H:i:s');

        $detailData = $data['detailData'];
        $detailBatchData = array();
        $detilColumn = array(
            'p_no_',
            'p_name_',
            'purchaser_num_',
            'r_price_',
        );

        $this->db->trans_start(); // 開始交易
        $this->db->insert($this->mainTableName, $mainData);
        $form_id = $this->db->insert_id();
        for ($i = 1; $i <= count($detailData)/count($detilColumn); $i++) {
            $no_key = $detilColumn[0] . $i;
            $name_key = $detilColumn[1] . $i;
            $num_key = $detilColumn[2] . $i;
            $price_key = $detilColumn[3] . $i;
            // 確保欄位存在且不為空
            if (!empty($detailData[$no_key]) && !empty($detailData[$name_key]) && !empty($detailData[$num_key]) && !empty($detailData[$price_key])) {
                $detailBatchData[] = [
                    'form_id' => $form_id,
                    'p_no' => $detailData[$no_key],
                    'p_name' => $detailData[$name_key],
                    'purchaser_num' => $detailData[$num_key],
                    'r_price' => $detailData[$price_key],
                ];
            }
        }
        if (!empty($detailBatchData)) {
            $this->db->insert_batch($this->detailTableName, $detailBatchData);
        } else {
            return false;
        }
        $this->db->trans_complete(); // 自動檢查錯誤，成功則 commit，失敗則 rollback
        return $this->db->trans_status();
    }

    private function encryptID($plaintext) {
        $cipher = "AES-256-CBC";
        $iv = openssl_random_pseudo_bytes(16); // 產生 16-byte IV
        $ciphertext = openssl_encrypt($plaintext, $cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        
        return [
            'encrypted' => base64_encode($ciphertext), // 轉為 base64 存入資料庫
            'iv' => base64_encode($iv)
        ];
    }

    private function decryptID($ciphertext, $iv) {
        $cipher = "AES-256-CBC";
        return openssl_decrypt(base64_decode($ciphertext), $cipher, $this->key, OPENSSL_RAW_DATA, base64_decode($iv));
    }
    
}