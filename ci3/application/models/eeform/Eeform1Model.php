<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform1Model extends CI_Model
{
    protected $table_submissions = 'eeform1_submissions';
    protected $table_skin_concerns = 'eeform1_skin_concerns';
    protected $table_lifestyle_habits = 'eeform1_lifestyle_habits';
    protected $table_occupations = 'eeform1_occupations';
    protected $table_skincare_products = 'eeform1_skincare_products';
    protected $table_problem_areas = 'eeform1_problem_areas';
    protected $table_skincare_goals = 'eeform1_skincare_goals';
    protected $table_consultation_dates = 'eeform1_consultation_dates';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 檢查並創建缺失的資料表
     * @return array 返回檢查結果
     */
    public function check_and_create_tables() 
    {
        $required_tables = [
            'eeform1_submissions' => false,
            'eeform1_occupations' => false,
            'eeform1_lifestyle' => false,
            'eeform1_products' => false,
            'eeform1_skin_issues' => false,
            'eeform1_allergies' => false,
            'eeform1_skin_scores' => true, // 這是經常缺失的表
            'eeform1_suggestions' => false,
        ];

        $results = [];
        
        foreach ($required_tables as $table => $is_critical) {
            $check_query = "SHOW TABLES LIKE '{$table}'";
            $query_result = $this->db->query($check_query);
            $exists = $query_result && $query_result->num_rows() > 0;
            
            $results[$table] = [
                'exists' => $exists,
                'critical' => $is_critical,
                'message' => $exists ? 'OK' : 'MISSING'
            ];
            
            if (!$exists && $is_critical) {
                error_log("CRITICAL: Missing table {$table} - skin_scores will be empty");
            }
        }
        
        return $results;
    }

    /**
     * 創建 eeform1_skin_scores 表（如果不存在）
     */
    public function create_skin_scores_table() 
    {
        $sql = "CREATE TABLE IF NOT EXISTS eeform1_skin_scores (
            id INT PRIMARY KEY AUTO_INCREMENT,
            submission_id INT NOT NULL COMMENT '提交記錄ID',
            category ENUM('moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore') NOT NULL COMMENT '評分類別',
            score_type ENUM('severe', 'warning', 'healthy') NOT NULL COMMENT '評分類型',
            score_value TINYINT NOT NULL DEFAULT 0 COMMENT '評分值 (0-10)',
            measurement_date DATE NULL COMMENT '測量日期',
            measurement_number INT NULL COMMENT '測量數值',
            notes TEXT NULL COMMENT '備註',
            
            FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
            UNIQUE KEY uk_submission_category_score (submission_id, category, score_type),
            INDEX idx_submission_id (submission_id),
            INDEX idx_category (category),
            INDEX idx_score_type (score_type),
            INDEX idx_measurement_date (measurement_date)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚評分記錄表'";
        
        return $this->db->query($sql);
    }

    /**
     * 驗證提交資料
     * @param array $data
     * @return array
     */
    public function validate_submission_data($data)
    {
        $errors = [];
        // 檢查必填欄位 - 支援新的 birth_date 或舊的 birth_year/birth_month
        $required_fields = ['member_name', 'phone'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "必填欄位 {$field} 不能為空";
            }
        }
        
        // 驗證出生年月 - 支援新的 birth_date (YYYY-MM) 或舊的 birth_year/birth_month
        if (!empty($data['birth_date'])) {
            // 使用新的年月欄位 (YYYY-MM 格式)
            $birth_date = $data['birth_date'];
            // 驗證 YYYY-MM 格式
            if (!preg_match('/^\d{4}-\d{2}$/', $birth_date) || !strtotime($birth_date . '-01')) {
                $errors[] = '出生年月格式不正確，請使用 YYYY-MM 格式';
            } else {
                $parts = explode('-', $birth_date);
                $year = intval($parts[0]);
                $month = intval($parts[1]);
                if ($year < 1950 || $year > date('Y')) {
                    $errors[] = '出生年份不在有效範圍內';
                }
                if ($month < 1 || $month > 12) {
                    $errors[] = '出生月份不在有效範圍內';
                }
                // 為往後相容性，將年月資料同步到別字欄位
                $data['birth_year'] = $year;
                $data['birth_month'] = $month;
            }
        } else {
            // 使用舊的年月欄位
            if (empty($data['birth_year']) || empty($data['birth_month'])) {
                $errors[] = '出生年月是必填欄位';
            } else {
                $year = intval($data['birth_year']);
                $month = intval($data['birth_month']);
                if ($year < 1950 || $year > date('Y')) {
                    $errors[] = '出生年份不在有效範圍內';
                }
                if ($month < 1 || $month > 12) {
                    $errors[] = '出生月份不在有效範圍內';
                }
            }
        }
        
        // 驗證電話格式
        if (!empty($data['phone'])) {
            if (!preg_match('/^09\d{8}$/', $data['phone'])) {
                $errors[] = '電話格式不正確，請輸入09開頭的10位數字';
            }
        }
        
        // 驗證肌膚年齡
        if (!empty($data['skin_age'])) {
            $skin_age = intval($data['skin_age']);
            if ($skin_age < 18 || $skin_age > 80) {
                $errors[] = '肌膚年齡不在有效範圍內';
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * 建立新的提交記錄
     * @param array $data
     * @return int|false
     */
    public function create_submission($data)
    {
        $this->db->trans_start();
        
        try {
            // 準備主表資料 - Point 80: 支援代填問卷者追蹤
            $submission_data = [
                'member_id' => isset($data['member_id']) ? $data['member_id'] : null,
                'member_name' => $data['member_name'], // 被填表人姓名
                'form_filler_id' => isset($data['form_filler_id']) ? $data['form_filler_id'] : null, // 代填問卷者ID
                'form_filler_name' => isset($data['form_filler_name']) ? $data['form_filler_name'] : null, // 代填問卷者姓名
                'birth_year' => intval($data['birth_year']),
                'birth_month' => intval($data['birth_month']),
                'phone' => $data['phone'],
                'skin_type' => isset($data['skin_type']) ? $data['skin_type'] : null,
                'skin_age' => isset($data['skin_age']) ? intval($data['skin_age']) : null,
                'submission_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'submitted'
            ];
            
            // 插入主表
            $this->db->insert('eeform1_submissions', $submission_data);
            $submission_id = $this->db->insert_id();
            
            if (!$submission_id) {
                throw new Exception('Failed to create submission record');
            }
            
            // 處理職業資料
            $occupations = ['service', 'office', 'restaurant', 'housewife'];
            foreach ($occupations as $occupation) {
                if (!empty($data["occupation_{$occupation}"])) {
                    $this->db->insert('eeform1_occupations', [
                        'submission_id' => $submission_id,
                        'occupation_type' => $occupation,
                        'is_selected' => 1
                    ]);
                }
            }
            
            // 處理生活方式資料
            $lifestyle_categories = [
                'sunlight' => ['1_2h', '3_4h', '5_6h', '8h_plus'],
                'aircondition' => ['1h', '2_4h', '5_8h', '8h_plus'],
                'sleep' => ['9_10', '11_12', 'after_1', 'other']
            ];
            
            foreach ($lifestyle_categories as $category => $items) {
                foreach ($items as $item) {
                    $field_name = "{$category}_{$item}";
                    if (!empty($data[$field_name])) {
                        $lifestyle_data = [
                            'submission_id' => $submission_id,
                            'category' => $category,
                            'item_key' => $item,
                            'is_selected' => 1
                        ];
                        
                        // 處理其他選項的文字內容
                        if ($item === 'other' && !empty($data["{$category}_other_text"])) {
                            $lifestyle_data['item_value'] = $data["{$category}_other_text"];
                        }
                        
                        $this->db->insert('eeform1_lifestyle', $lifestyle_data);
                    }
                }
            }
            
            // 處理產品使用資料
            $products = ['honey_soap', 'mud_mask', 'toner', 'serum', 'premium', 'sunscreen', 'other'];
            foreach ($products as $product) {
                if (!empty($data["product_{$product}"])) {
                    $product_data = [
                        'submission_id' => $submission_id,
                        'product_type' => $product,
                        'is_selected' => 1
                    ];
                    
                    // 處理其他產品的文字內容
                    if ($product === 'other' && !empty($data['product_other_text'])) {
                        $product_data['product_name'] = $data['product_other_text'];
                    }
                    
                    $this->db->insert('eeform1_products', $product_data);
                }
            }
            
            // 處理肌膚困擾資料
            $skin_issues = ['elasticity', 'luster', 'dull', 'spots', 'pores', 'acne', 'wrinkles', 'rough', 'irritation', 'dry', 'makeup', 'other'];
            foreach ($skin_issues as $issue) {
                if (!empty($data["skin_issue_{$issue}"])) {
                    $issue_data = [
                        'submission_id' => $submission_id,
                        'issue_type' => $issue,
                        'is_selected' => 1
                    ];
                    
                    // 處理其他困擾的文字內容
                    if ($issue === 'other' && !empty($data['skin_issue_other_text'])) {
                        $issue_data['issue_description'] = $data['skin_issue_other_text'];
                    }
                    
                    $this->db->insert('eeform1_skin_issues', $issue_data);
                }
            }
            
            // 處理過敏狀況資料
            $allergies = ['frequent', 'seasonal', 'never'];
            foreach ($allergies as $allergy) {
                if (!empty($data["allergy_{$allergy}"])) {
                    $this->db->insert('eeform1_allergies', [
                        'submission_id' => $submission_id,
                        'allergy_type' => $allergy,
                        'is_selected' => 1
                    ]);
                }
            }
            
            // 處理肌膚評分資料（支援8個類別）
            $skin_categories = ['moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore'];
            $score_types = ['severe', 'warning', 'healthy'];
            
            error_log('Processing skin categories for submission_id: ' . $submission_id);
            error_log('Available form data fields: ' . implode(', ', array_keys($data)));
            
            foreach ($skin_categories as $category) {
                foreach ($score_types as $type) {
                    $field_name = "{$category}_{$type}";
                    // Check if field exists and has a value (including "0")
                    error_log("Checking field: $field_name, value: " . (isset($data[$field_name]) ? "'" . $data[$field_name] . "'" : 'NOT SET'));
                    if (isset($data[$field_name]) && $data[$field_name] !== '') {
                        $score_data = [
                            'submission_id' => $submission_id,
                            'category' => $category,
                            'score_type' => $type,
                            'score_value' => intval($data[$field_name]),
                            'measurement_date' => date('Y-m-d')
                        ];
                        
                        $insert_result = $this->db->insert('eeform1_skin_scores', $score_data);
                        
                        // Debug: 檢查插入結果
                        if ($insert_result) {
                            $inserted_id = $this->db->insert_id();
                            error_log('Successfully inserted skin_score: ' . json_encode($score_data) . ' with ID: ' . $inserted_id);
                        } else {
                            $db_error = $this->db->error();
                            error_log('Failed to insert skin_score: ' . json_encode($score_data) . ' Error: ' . json_encode($db_error));
                        }
                    } else {
                        error_log('No data found for field: ' . $field_name);
                    }
                }
                
            }
            
            // 處理建議內容
            if (!empty($data['toner_suggestion']) || !empty($data['serum_suggestion']) || !empty($data['suggestion_content'])) {
                $this->db->insert('eeform1_suggestions', [
                    'submission_id' => $submission_id,
                    'toner_suggestion' => isset($data['toner_suggestion']) ? $data['toner_suggestion'] : '',
                    'serum_suggestion' => isset($data['serum_suggestion']) ? $data['serum_suggestion'] : '',
                    'suggestion_content' => isset($data['suggestion_content']) ? $data['suggestion_content'] : '',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Failed to create submission: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 取得會員的提交記錄
     * @param string $member_id
     * @param int $page
     * @param int $limit
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function get_member_submissions($member_id, $page = 1, $limit = 10, $start_date = null, $end_date = null)
    {
        // 建構 WHERE 條件的helper函數
        $apply_conditions = function() use ($member_id, $start_date, $end_date) {
            $this->db->where('member_id', $member_id);
            if ($start_date) {
                $this->db->where('submission_date >=', $start_date);
            }
            if ($end_date) {
                $this->db->where('submission_date <=', $end_date);
            }
        };
        
        // 取得總數 - 使用完全獨立的查詢
        $this->db->from('eeform1_submissions');
        $apply_conditions();
        $total = $this->db->count_all_results();
        
        // 取得實際資料 - 重新開始新的查詢
        $this->db->select('*');
        $this->db->from('eeform1_submissions');
        $apply_conditions();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, ($page - 1) * $limit);
        
        $query = $this->db->get();
        $results = $query->result_array();
        
        return [
            'data' => $results,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit)
            ]
        ];
    }

    /**
     * 取得單一提交記錄詳細資料
     * @param int $id
     * @return array|null
     */
    public function get_submission_detail($id)
    {
        // 取得主要資料
        $this->db->from('eeform1_submissions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $submission = $query->row_array();
        
        if (!$submission) {
            return null;
        }
        
        // 取得職業資料
        $this->db->from('eeform1_occupations');
        $this->db->where('submission_id', $id);
        $this->db->where('is_selected', 1);
        $occupations = $this->db->get()->result_array();
        
        // 取得生活方式資料
        $this->db->from('eeform1_lifestyle');
        $this->db->where('submission_id', $id);
        $this->db->where('is_selected', 1);
        $lifestyle = $this->db->get()->result_array();
        
        // 取得產品使用資料
        $this->db->from('eeform1_products');
        $this->db->where('submission_id', $id);
        $this->db->where('is_selected', 1);
        $products = $this->db->get()->result_array();
        
        // 取得肌膚困擾資料
        $this->db->from('eeform1_skin_issues');
        $this->db->where('submission_id', $id);
        $this->db->where('is_selected', 1);
        $skin_issues = $this->db->get()->result_array();
        
        // 取得過敏狀況資料
        $this->db->from('eeform1_allergies');
        $this->db->where('submission_id', $id);
        $this->db->where('is_selected', 1);
        $allergies = $this->db->get()->result_array();
        
        // Debug: 檢查資料表是否存在
        $table_exists_query = "SHOW TABLES LIKE 'eeform1_skin_scores'";
        $table_check = $this->db->query($table_exists_query);
        $table_exists = $table_check && $table_check->num_rows() > 0;
        error_log('Table eeform1_skin_scores exists: ' . ($table_exists ? 'YES' : 'NO'));
        
        // 如果表不存在，嘗試檢查所有必要的表
        if (!$table_exists) {
            error_log('Running complete table check...');
            $table_status = $this->check_and_create_tables();
            error_log('Table status check result: ' . json_encode($table_status));
        }
        
        if (!$table_exists) {
            error_log('WARNING: eeform1_skin_scores table does not exist! Creating fallback solution...');
            // 檢查是否還在使用舊的表名
            $old_table_check = $this->db->query("SHOW TABLES LIKE 'eeform1_moisture_scores'");
            $old_table_exists = $old_table_check && $old_table_check->num_rows() > 0;
            error_log('Old table eeform1_moisture_scores exists: ' . ($old_table_exists ? 'YES' : 'NO'));
            
            if ($old_table_exists) {
                error_log('Falling back to old table structure');
                // 使用舊表結構作為臨時解決方案
                $this->db->from('eeform1_moisture_scores');
                $this->db->where('submission_id', $id);
                $skin_scores = $this->db->get()->result_array();
                
                // 轉換舊資料結構為新格式
                foreach ($skin_scores as &$score) {
                    if (!isset($score['category'])) {
                        $score['category'] = 'moisture'; // 舊資料預設為moisture
                    }
                }
                
                error_log('Retrieved ' . count($skin_scores) . ' records from old table');
                
                // 取得建議內容 (needed for fallback path)
                $this->db->from('eeform1_suggestions');
                $this->db->where('submission_id', $id);
                $suggestions = $this->db->get()->row_array();
                
                // 組合結果並返回
                $submission['occupations'] = $occupations;
                $submission['lifestyle'] = $lifestyle;
                $submission['products'] = $products;
                $submission['skin_issues'] = $skin_issues;
                $submission['allergies'] = $allergies;
                $submission['skin_scores'] = $skin_scores;
                $submission['moisture_scores'] = $skin_scores;
                $submission['suggestions'] = $suggestions;
                
                return $submission;
            } else {
                error_log('ERROR: Neither eeform1_skin_scores nor eeform1_moisture_scores table exists!');
                // 返回空的skin_scores陣列
                $skin_scores = [];
            }
        }
        
        // 初始化 skin_scores 變數
        $skin_scores = [];
        
        if ($table_exists) {
            // 取得肌膚評分資料（新版統一資料表）
            $this->db->from('eeform1_skin_scores');
            $this->db->where('submission_id', $id);
            
            // Debug: 檢查SQL查詢
            $sql_query = $this->db->get_compiled_select();
            log_message('debug', 'SQL Query: ' . $sql_query);
            error_log('SQL Query for skin_scores: ' . $sql_query);
            
            // 重新設定查詢 (get_compiled_select 會清除查詢)
            $this->db->from('eeform1_skin_scores');
            $this->db->where('submission_id', $id);
            $skin_scores = $this->db->get()->result_array();
            
            // Check for database errors
            $db_error = $this->db->error();
            if ($db_error['code'] != 0) {
                error_log('Database error when querying skin_scores: ' . json_encode($db_error));
            }
            
            // Debug: 檢查查詢結果
            log_message('debug', 'Querying eeform1_skin_scores for submission_id: ' . $id);
            log_message('debug', 'Found skin_scores records: ' . count($skin_scores));
            error_log('Found skin_scores records count: ' . count($skin_scores) . ' for submission_id: ' . $id);
            
            if (!empty($skin_scores)) {
                $sample_data = json_encode(array_slice($skin_scores, 0, 3));
                log_message('debug', 'Sample skin_scores: ' . $sample_data);
                error_log('Sample skin_scores: ' . $sample_data);
            } else {
                error_log('No skin_scores found for submission_id: ' . $id . ' - table exists but no data');
                
                // 檢查該submission_id是否在主表中存在
                $this->db->from('eeform1_submissions');
                $this->db->where('id', $id);
                $submission_exists = $this->db->count_all_results() > 0;
                error_log('Submission exists in main table: ' . ($submission_exists ? 'YES' : 'NO'));
                
                // 檢查是否有任何skin_scores資料
                $this->db->from('eeform1_skin_scores');
                $total_scores = $this->db->count_all_results();
                error_log('Total skin_scores records in table: ' . $total_scores);
            }
        }
        
        // 取得建議內容
        $this->db->from('eeform1_suggestions');
        $this->db->where('submission_id', $id);
        $suggestions = $this->db->get()->row_array();
        
        // 組合結果
        $submission['occupations'] = $occupations;
        $submission['lifestyle'] = $lifestyle;
        $submission['products'] = $products;
        $submission['skin_issues'] = $skin_issues;
        $submission['allergies'] = $allergies;
        $submission['skin_scores'] = $skin_scores;
        $submission['moisture_scores'] = $skin_scores;  // 為了向後相容性保留此欄位
        $submission['suggestions'] = $suggestions;
        
        // Final debug: 檢查最終返回的資料結構
        error_log('=== Final submission data structure ===');
        error_log('Total submission keys: ' . implode(', ', array_keys($submission)));
        error_log('skin_scores final count: ' . count($skin_scores));
        error_log('moisture_scores final count: ' . count($submission['moisture_scores']));
        if (!empty($skin_scores)) {
            error_log('Final skin_scores sample: ' . json_encode(array_slice($skin_scores, 0, 2)));
        } else {
            error_log('WARNING: Final skin_scores is empty for submission_id: ' . $id);
        }
        error_log('======================================');
        
        return $submission;
    }

    /**
     * 更新提交記錄
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update_submission($id, $data)
    {
        $this->db->trans_start();
        
        try {
            // 更新主表
            $submission_data = [
                'member_id' => isset($data['member_id']) ? $data['member_id'] : null,
                'member_name' => $data['member_name'],
                'birth_year' => intval($data['birth_year']),
                'birth_month' => intval($data['birth_month']),
                'phone' => $data['phone'],
                'skin_type' => isset($data['skin_type']) ? $data['skin_type'] : null,
                'skin_age' => isset($data['skin_age']) ? intval($data['skin_age']) : null,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->where('id', $id);
            $this->db->update('eeform1_submissions', $submission_data);
            
            // 刪除舊的關聯資料
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_occupations');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_lifestyle');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_products');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_skin_issues');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_allergies');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_skin_scores');
            
            $this->db->where('submission_id', $id);
            $this->db->delete('eeform1_suggestions');
            
            // 重新插入職業資料
            $occupations = ['service', 'office', 'restaurant', 'housewife'];
            foreach ($occupations as $occupation) {
                if (!empty($data["occupation_{$occupation}"])) {
                    $this->db->insert('eeform1_occupations', [
                        'submission_id' => $id,
                        'occupation_type' => $occupation,
                        'is_selected' => 1
                    ]);
                }
            }
            
            // 重新插入生活方式資料
            $lifestyle_categories = [
                'sunlight' => ['1_2h', '3_4h', '5_6h', '8h_plus'],
                'aircondition' => ['1h', '2_4h', '5_8h', '8h_plus'],
                'sleep' => ['9_10', '11_12', 'after_1', 'other']
            ];
            
            foreach ($lifestyle_categories as $category => $items) {
                foreach ($items as $item) {
                    $field_name = "{$category}_{$item}";
                    if (!empty($data[$field_name])) {
                        $lifestyle_data = [
                            'submission_id' => $id,
                            'category' => $category,
                            'item_key' => $item,
                            'is_selected' => 1
                        ];
                        
                        if ($item === 'other' && !empty($data["{$category}_other_text"])) {
                            $lifestyle_data['item_value'] = $data["{$category}_other_text"];
                        }
                        
                        $this->db->insert('eeform1_lifestyle', $lifestyle_data);
                    }
                }
            }
            
            // 重新插入產品使用資料
            $products = ['honey_soap', 'mud_mask', 'toner', 'serum', 'premium', 'sunscreen', 'other'];
            foreach ($products as $product) {
                if (!empty($data["product_{$product}"])) {
                    $product_data = [
                        'submission_id' => $id,
                        'product_type' => $product,
                        'is_selected' => 1
                    ];
                    
                    if ($product === 'other' && !empty($data['product_other_text'])) {
                        $product_data['product_name'] = $data['product_other_text'];
                    }
                    
                    $this->db->insert('eeform1_products', $product_data);
                }
            }
            
            // 重新插入肌膚困擾資料
            $skin_issues = ['elasticity', 'luster', 'dull', 'spots', 'pores', 'acne', 'wrinkles', 'rough', 'irritation', 'dry', 'makeup', 'other'];
            foreach ($skin_issues as $issue) {
                if (!empty($data["skin_issue_{$issue}"])) {
                    $issue_data = [
                        'submission_id' => $id,
                        'issue_type' => $issue,
                        'is_selected' => 1
                    ];
                    
                    if ($issue === 'other' && !empty($data['skin_issue_other_text'])) {
                        $issue_data['issue_description'] = $data['skin_issue_other_text'];
                    }
                    
                    $this->db->insert('eeform1_skin_issues', $issue_data);
                }
            }
            
            // 重新插入過敏狀況資料
            $allergies = ['frequent', 'seasonal', 'never'];
            foreach ($allergies as $allergy) {
                if (!empty($data["allergy_{$allergy}"])) {
                    $this->db->insert('eeform1_allergies', [
                        'submission_id' => $id,
                        'allergy_type' => $allergy,
                        'is_selected' => 1
                    ]);
                }
            }
            
            // 重新插入肌膚評分資料（支援8個類別）
            $skin_categories = ['moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore'];
            $score_types = ['severe', 'warning', 'healthy'];
            
            foreach ($skin_categories as $category) {
                foreach ($score_types as $type) {
                    $field_name = "{$category}_{$type}";
                    // Check if field exists and has a value (including "0")
                    error_log("UPDATE - Checking field: $field_name, value: " . (isset($data[$field_name]) ? "'" . $data[$field_name] . "'" : 'NOT SET'));
                    if (isset($data[$field_name]) && $data[$field_name] !== '') {
                        $score_data = [
                            'submission_id' => $id,
                            'category' => $category,
                            'score_type' => $type,
                            'score_value' => intval($data[$field_name]),
                            'measurement_date' => date('Y-m-d')
                        ];
                        
                        $this->db->insert('eeform1_skin_scores', $score_data);
                    }
                }
                
            }
            
            // 重新插入建議內容
            if (!empty($data['toner_suggestion']) || !empty($data['serum_suggestion']) || !empty($data['suggestion_content'])) {
                $this->db->insert('eeform1_suggestions', [
                    'submission_id' => $id,
                    'toner_suggestion' => isset($data['toner_suggestion']) ? $data['toner_suggestion'] : '',
                    'serum_suggestion' => isset($data['serum_suggestion']) ? $data['serum_suggestion'] : '',
                    'suggestion_content' => isset($data['suggestion_content']) ? $data['suggestion_content'] : '',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Failed to update submission: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 取得會員統計資料
     * @param string $member_id
     * @return array
     */
    public function get_member_stats($member_id)
    {
        // 取得總提交次數
        $this->db->where('member_id', $member_id);
        $total_submissions = $this->db->count_all_results('eeform1_submissions');
        
        // 取得最新提交日期
        $this->db->select('submission_date');
        $this->db->where('member_id', $member_id);
        $this->db->order_by('submission_date', 'DESC');
        $this->db->limit(1);
        $latest = $this->db->get('eeform1_submissions')->row_array();
        
        return [
            'total_submissions' => $total_submissions,
            'latest_submission_date' => $latest ? $latest['submission_date'] : null,
            'member_id' => $member_id
        ];
    }

    /**
     * 取得所有提交記錄（分頁）
     * @param int $page
     * @param int $limit
     * @param string $search
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function get_all_submissions_paginated($page = 1, $limit = 20, $search = null, $start_date = null, $end_date = null) {
        try {
            // 驗證資料庫連接
            if (!$this->db) {
                throw new Exception('Database connection not available');
            }
            
            $offset = ($page - 1) * $limit;
            
            // 檢查表是否存在
            if (!$this->db->table_exists('eeform1_submissions')) {
                log_message('error', 'Table eeform1_submissions does not exist');
                return [
                    'data' => [],
                    'pagination' => [
                        'current_page' => $page,
                        'per_page' => $limit,
                        'total' => 0,
                        'total_pages' => 0,
                        'has_next' => false,
                        'has_prev' => false
                    ]
                ];
            }
            
            // 先取得總數
            $this->db->from('eeform1_submissions s');
            $this->_apply_search_conditions($search, $start_date, $end_date);
            
            $count_query = $this->db->get_compiled_select();
            log_message('debug', 'Count query: ' . $count_query);
            
            $this->db->flush_cache();
            $this->db->from('eeform1_submissions s');
            $this->_apply_search_conditions($search, $start_date, $end_date);
            $total = $this->db->count_all_results('', FALSE);
            
            if ($total === FALSE) {
                $db_error = $this->db->error();
                log_message('error', 'Count query failed: ' . json_encode($db_error));
                throw new Exception('Failed to count submissions: ' . $db_error['message']);
            }
            
            // 重新建立查詢取得實際資料
            $this->db->flush_cache();
            $this->db->select('
                s.id,
                s.member_id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.phone,
                s.skin_type,
                s.skin_age,
                s.submission_date,
                s.form_filler_name,
                s.created_at,
                s.updated_at
            ');
            $this->db->from('eeform1_submissions s');
            $this->_apply_search_conditions($search, $start_date, $end_date);
            $this->db->order_by('s.submission_date', 'DESC');
            $this->db->limit($limit, $offset);
            
            $data_query = $this->db->get_compiled_select();
            log_message('debug', 'Data query: ' . $data_query);
            
            $this->db->flush_cache();
            $this->db->select('
                s.id,
                s.member_id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.phone,
                s.skin_type,
                s.skin_age,
                s.submission_date,
                s.form_filler_name,
                s.created_at,
                s.updated_at
            ');
            $this->db->from('eeform1_submissions s');
            $this->_apply_search_conditions($search, $start_date, $end_date);
            $this->db->order_by('s.submission_date', 'DESC');
            $this->db->limit($limit, $offset);
            
            $query = $this->db->get();
            
            if (!$query || $query === FALSE) {
                $db_error = $this->db->error();
                log_message('error', 'Data query failed: ' . json_encode($db_error));
                return [
                    'data' => [],
                    'pagination' => [
                        'current_page' => $page,
                        'per_page' => $limit,
                        'total' => 0,
                        'total_pages' => 0,
                        'has_next' => false,
                        'has_prev' => false
                    ]
                ];
            }
            
            $submissions = $query->result_array();
            
            if ($submissions === FALSE) {
                $db_error = $this->db->error();
                log_message('error', 'Result_array failed: ' . json_encode($db_error));
                throw new Exception('Failed to fetch submissions: ' . $db_error['message']);
            }
            
            // 計算分頁資訊
            $total_pages = ceil($total / $limit);
            
            return [
                'data' => $submissions,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $total,
                    'total_pages' => $total_pages,
                    'has_next' => $page < $total_pages,
                    'has_prev' => $page > 1
                ]
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Eeform1Model::get_all_submissions_paginated error: ' . $e->getMessage());
            log_message('error', 'Eeform1Model::get_all_submissions_paginated trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * 套用搜尋和日期條件的輔助方法
     */
    private function _apply_search_conditions($search, $start_date, $end_date) {
        // 套用搜尋條件
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('s.member_name', $search);
            $this->db->or_like('s.phone', $search);
            $this->db->group_end();
        }
        
        // 套用日期條件
        if (!empty($start_date)) {
            $this->db->where('DATE(s.submission_date) >=', $start_date);
        }
        
        if (!empty($end_date)) {
            $this->db->where('DATE(s.submission_date) <=', $end_date);
        }
    }
}