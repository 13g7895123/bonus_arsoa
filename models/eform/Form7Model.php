<?php
/*
 *  活動
 */
class Form7Model extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data)
    {
        // 布林欄位
        $booleanField = array(
            'muscle_energy_home_delivery_ten_days',
            'five_days',
            'twenty_days',
            'vitality_fermentation_extract',
            'white_crane_ganoderma_extract',
            'beauty_C_tablets',
        );

        // 布林欄位轉換
        foreach ($booleanField as $_val) {
            if (isset($data[$_val])) {
                $data[$_val] = $data[$_val] == 'false' ? 0 : 1;
            }
        }

        $data['create_time'] = date('Y-m-d H:i:s');     // 新增時間
        $data['update_time'] = date('Y-m-d H:i:s');     // 更新時間

        return $this->db->insert('eform7_pri', $data);
    }
    
}