<?php
/*
 *  活動
 */
class Form6Model extends CI_Model
{
    private $db;
    protected $mainTableName = "eform6_main";
    protected $detailTableName = "eform6_detail";
    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data, $signatureFileIds=array(), $creditCardId=0)
    {
        $commonModel = new CommonModel();
        $mainData = json_decode($data['mainData'], true);
        $detailData = json_decode($data['detailData'], true);
        $creditData = json_decode($data['creditData'], true);
        $creditStatementData = json_decode($data['creditStatementData'], true);

        if ($mainData['payment_method'] === 'credit_card') {
            //信用卡資料
            $mainData['credit_card_consumption_amount'] = $creditData['credit_card_consumption_amount'];
            $mainData['credit_card_consumption_date'] = $creditData['credit_card_consumption_date'];
            $mainData['credit_id'] = $creditCardId;
            $mainData['signature_id'] = $signatureFileIds['signatureCredit'];
            //信用卡聲明同意
            $mainData['cardholder_name'] = $creditStatementData['cardholder_name'];
            if (!empty($creditStatementData['cardholder_id_card_number'])) {
                $memberEncrypt = $commonModel->encryptID($creditStatementData['cardholder_id_card_number']);
                $mainData['cardholder_id_card_number'] = $memberEncrypt['encrypted'];
                $mainData['cardholder_iv'] = $memberEncrypt['iv'];
            }
            $mainData['credit_card_statement_agree_text'] = $creditStatementData['credit_card_statement_agree_text'];
            $mainData['credit_card_statement_agree_total_amount'] = $creditStatementData['credit_card_statement_agree_total_amount'];
            $mainData['credit_card_statement_agree_date'] = $creditStatementData['credit_card_statement_agree_date'];
            $mainData['credit_card_statement_agree_signature_id'] = $signatureFileIds['signatureCreditAgreement'];
        }

        $mainData['create_time'] = date('Y-m-d H:i:s');
        $mainData['update_time'] = date('Y-m-d H:i:s');

        $detailBatchData = array();
        $detilColumn = array(
            'p_no_',
            'purchaser_num_',
            'r_price_',
            'BP_',
        );

        $this->db->trans_start(); // 開始交易
        $this->db->insert($this->mainTableName, $mainData);
        $form_id = $this->db->insert_id();
        for ($i = 1; $i <= count($detailData)/count($detilColumn); $i++) {
            $no_key = $detilColumn[0] . $i;
            $num_key = $detilColumn[1] . $i;
            $price_key = $detilColumn[2] . $i;
            $bp_key = $detilColumn[3] . $i;
            // 確保欄位存在且不為空
            if (!empty($detailData[$no_key]) && !empty($detailData[$num_key]) && !empty($detailData[$price_key]) && !empty($detailData[$bp_key])) {
                $detailBatchData[] = [
                    'form_id' => $form_id,
                    'p_no' => $detailData[$no_key],
                    'purchaser_num' => $detailData[$num_key],
                    'r_price' => $detailData[$price_key],
                    'BP' => $detailData[$bp_key]
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