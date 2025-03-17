<?php
/*
 *  活動
 */
class Form4Model extends CI_Model
{
    private $db;
    protected $mainTableName = "eform4_main";
    protected $detailTableName = "eform4_detail";
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
        $creditStatementData = json_decode($data['creditStatementData'], true);
        //會員同意簽名
        $mainData['member_agree_signature_id'] = $signatureFileIds['signatureMemberAgreement'];
        
        //身分證加密
        $mainData['member_iv'] = ''; //initial
        $mainData['spouse_iv'] = ''; //initial
        if (!empty($mainData['member_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($mainData['member_id_card_number']);
            $mainData['member_id_card_number'] = $memberEncrypt['encrypted'];
            $mainData['member_iv'] = $memberEncrypt['iv'];
        }
        if (!empty($mainData['spouse_id_card_number'])) {
            $memberEncrypt = $commonModel->encryptID($mainData['spouse_id_card_number']);
            $mainData['spouse_id_card_number'] = $memberEncrypt['encrypted'];
            $mainData['spouse_iv'] = $memberEncrypt['iv'];
        }
        if ($mainData['payment_method'] === 'credit_card') {
            //信用卡資料
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

}