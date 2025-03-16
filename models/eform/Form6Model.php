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

    public function createData($data)
    {
        $mainData = $data['mainData'];
        $mainData['create_time'] = date('Y-m-d H:i:s');
        $mainData['update_time'] = date('Y-m-d H:i:s');

        $detailData = $data['detailData'];
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