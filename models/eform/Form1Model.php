<?php
/*
 *  活動
 */
class Form1Model extends CI_Model
{
    private $db;
    protected $mainTableName = "eform1_main";
    protected $detailTableName = "eform1_detail";
    protected $commonModel;
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->load->model( 'eform/CommonModel' );
    }

    public function createData($data, $signatureFileIds=array(), $creditCardId=0)
    {
        $commonModel = new CommonModel();
        $mainData = json_decode($data['mainData'], true);
        $detailData = json_decode($data['detailData'], true);
        $creditData = json_decode($data['creditData'], true);

        if ($mainData['payment_method'] === 'credit_card') {
            $mainData['payment_method'] = $creditData['member_name'];
            if (!empty($creditData['member_id_card_number'])) {
                $memberEncrypt = $commonModel->encryptID($creditData['member_id_card_number']);
                $mainData['member_id_card_number'] = $memberEncrypt['encrypted'];
                $mainData['member_iv'] = $memberEncrypt['iv'];
            }
            $mainData['cardholder_name'] = $creditData['cardholder_name'];
            $mainData['c_no'] = $creditData['c_no'];
            $mainData['contact_phone_number'] = $creditData['contact_phone_number'];
            $mainData['signature_id'] = $signatureFileIds['signature'];
            $mainData['credit_id'] = $creditCardId;
        }
        $mainData['create_time'] = date('Y-m-d H:i:s');
        $mainData['update_time'] = date('Y-m-d H:i:s');

        
        $detailBatchData = array();
        $detilColumn = array(
            'purchaser_c_no_',
            'purchaser_c_name_',
            'purchaser_num_',
            'purchaser_amount_',
        );

        $this->db->trans_start(); // 開始交易
        $this->db->insert($this->mainTableName, $mainData);
        $form_id = $this->db->insert_id();
        for ($i = 1; $i <= count($detailData)/count($detilColumn); $i++) {
            $no_key = $detilColumn[0] . $i;
            $name_key = $detilColumn[1] . $i;
            $num_key = $detilColumn[2] . $i;
            $amount_key = $detilColumn[3] . $i;
            // 確保欄位存在且不為空
            if (!empty($detailData[$no_key]) && !empty($detailData[$name_key]) && !empty($detailData[$num_key]) && !empty($detailData[$amount_key])) {
                $detailBatchData[] = [
                    'form_id' => $form_id,
                    'purchaser_c_no' => $detailData[$no_key],
                    'purchaser_c_name' => $detailData[$name_key],
                    'purchaser_num' => $detailData[$num_key],
                    'purchaser_amount' => $detailData[$amount_key]
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
    
}