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

        // 忽略欄位
        $ignoreField = array(
            'card_type',
            'bank',
            'card_number',
            'card_expiry_month',
            'card_expiry_year',
        );

        for ($i = 1; $i <= 7; $i++) {
            $ignoreField[] = 'name_'.$i;
            $ignoreField[] = 'member_code_'.$i;
            $ignoreField[] = 'delivery_date_'.$i;
            $ignoreField[] = 'delivery_item_'.$i;
            $ignoreField[] = 'purchase_item_'.$i;
            $ignoreField[] = 'redemption_item_'.$i;
        }

        foreach ($ignoreField as $_val) {
            if (isset($data[$_val])) {
                unset($data[$_val]);
            }
        }

        $this->db->insert('eform7_main', $data);
        return $this->db->insert_id();
    }

    public function createDetailData($data)
    {
        $this->db->insert('eform7_detail', $data);
    }
    
    public function findValueInDatabase()
    {
        $this->db->insert('test_input', ['data' => '12345']);
        print_r($this->db->insert_id()); die();

        $searchValue = '250246';  // 要查找的值
        $foundTables = [];  // 存放找到的資料表

        // print_r(123); die();

        // 取得所有資料表
        $tables = $this->db->query("SHOW TABLES")->getResultArray();

        print_r($tables); die();

        foreach ($tables as $table) {
            $tableName = reset($table);  // 取得表格名稱

            // 取得表格的所有欄位
            $columns = $this->db->query("SHOW COLUMNS FROM `$tableName`")->getResultArray();

            foreach ($columns as $column) {
                $columnName = $column['Field'];

                // 嘗試查詢該表該欄位是否有 `250246`
                $query = $this->db->query("SELECT COUNT(*) as count FROM `$tableName` WHERE `$columnName` = ?", [$searchValue]);
                $result = $query->getRow();

                if ($result->count > 0) {
                    $foundTables[] = $tableName;
                    break; // 該表已找到，不需繼續檢查
                }
            }
        }

        if (!empty($foundTables)) {
            return "找到 `250246` 的表格：" . implode(', ', $foundTables);
        } else {
            return "沒有找到 `250246` 的表格。";
        }
    }
}