<?php
/*
 *  活動
 */
class Form1Model extends CommonModel
{
    protected $mainTableName = "eform1_main";
    protected $detailTableName = "eform1_detail";
    function __construct()
    {
        parent::__construct();
    }

    public function createData($data, $fileIds=array())
    {
        $mainData = json_decode($data['mainData'], true);
        if ($mainData['payment_method'] === 'credit_card') {
            
        }
        $mainData['create_time'] = date('Y-m-d H:i:s');
        $mainData['update_time'] = date('Y-m-d H:i:s');

        $detailData = json_decode($data['detailData'], true);
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