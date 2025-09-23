<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform1Model extends MY_Model
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

        // 檢查必填欄位 - 根據 identity 參數調整驗證規則
        $identity = isset($data['identity']) ? $data['identity'] : null;

        // 會員姓名永遠是必填的
        if (empty($data['member_name'])) {
            $errors[] = "必填欄位 member_name 不能為空";
        }

        // 來賓模式：phone 必填；會員模式：phone 非必填
        if ($identity === 'guest' && empty($data['phone'])) {
            $errors[] = "必填欄位 phone 不能為空";
        }
        
        // 驗證出生年月日 - 支援新的 birth_date (YYYY-MM-DD) 或舊的 birth_year/birth_month/birth_day
        if (!empty($data['birth_date'])) {
            // 使用新的年月日欄位 (YYYY-MM-DD 格式)
            $birth_date = $data['birth_date'];
            // 驗證 YYYY-MM-DD 格式
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $birth_date) || !strtotime($birth_date)) {
                $errors[] = '出生年月日格式不正確，請使用 YYYY-MM-DD 格式';
            } else {
                $parts = explode('-', $birth_date);
                $year = intval($parts[0]);
                $month = intval($parts[1]);
                $day = intval($parts[2]);
                if ($year < 1950 || $year > date('Y')) {
                    $errors[] = '出生年份不在有效範圍內';
                }
                if ($month < 1 || $month > 12) {
                    $errors[] = '出生月份不在有效範圍內';
                }
                if ($day < 1 || $day > 31) {
                    $errors[] = '出生日期不在有效範圍內';
                }
                // 為往後相容性，將年月日資料同步到別字欄位
                $data['birth_year'] = $year;
                $data['birth_month'] = $month;
                $data['birth_day'] = $day;
            }
        } else {
            // 使用舊的年月日欄位
            if (empty($data['birth_year']) || empty($data['birth_month']) || empty($data['birth_day'])) {
                $errors[] = '出生年月日是必填欄位';
            } else {
                $year = intval($data['birth_year']);
                $month = intval($data['birth_month']);
                $day = intval($data['birth_day']);
                if ($year < 1950 || $year > date('Y')) {
                    $errors[] = '出生年份不在有效範圍內';
                }
                if ($month < 1 || $month > 12) {
                    $errors[] = '出生月份不在有效範圍內';
                }
                if ($day < 1 || $day > 31) {
                    $errors[] = '出生日期不在有效範圍內';
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
            // 準備主表資料
            $submission_data = [
                'member_id' => isset($data['member_id']) ? $data['member_id'] : null,
                'member_name' => $data['member_name'], // 被填表人姓名
                'identity' => isset($data['identity']) ? $data['identity'] : null, // 填表身份：member/guest
                'form_filler_id' => isset($data['form_filler_id']) ? $data['form_filler_id'] : null, // 代填問卷者ID
                'form_filler_name' => isset($data['form_filler_name']) ? $data['form_filler_name'] : null, // 代填問卷者姓名
                'birth_year' => intval($data['birth_year']),
                'birth_month' => intval($data['birth_month']),
                'birth_day' => intval($data['birth_day']),
                'phone' => isset($data['phone']) ? $data['phone'] : null,
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
    public function get_member_submissions($form_filler_id, $page = 1, $limit = 10, $start_date = null, $end_date = null)
    {
        $this->db->select('s.*, COUNT(*) OVER() as total_count');
        $this->db->from('eeform1_submissions s');
        $this->db->where('form_filler_id', $form_filler_id);
        
        if ($start_date) {
            $this->db->where('s.submission_date >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('s.submission_date <=', $end_date);
        }
        
        $this->db->order_by('s.created_at', 'DESC');
        $this->db->limit($limit, ($page - 1) * $limit);
        
        $query = $this->db->get();
        $results = $query->result_array();
        
        $total = 0;
        if (!empty($results)) {
            $total = $results[0]['total_count'];
            // 移除 total_count 欄位
            foreach ($results as &$result) {
                unset($result['total_count']);
            }
        }
        
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
                'birth_day' => intval($data['birth_day']),
                'phone' => isset($data['phone']) ? $data['phone'] : null,
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
                s.form_filler_name,
                s.member_id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.birth_day,
                s.phone,
                s.skin_type,
                s.skin_age,
                s.submission_date,
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
                s.form_filler_name,
                s.member_id,
                s.member_name,
                s.birth_year,
                s.birth_month,
                s.birth_day,
                s.phone,
                s.skin_type,
                s.skin_age,
                s.submission_date,
                s.created_at,
                s.updated_at
            ');
            $this->db->from('eeform1_submissions s');
            $this->_apply_search_conditions($search, $start_date, $end_date);
            $this->db->order_by('s.submission_date', 'DESC');
            $this->db->limit($limit, $offset);
            
            $query = $this->db->get();
            
            if (!$query) {
                $db_error = $this->db->error();
                log_message('error', 'Data query failed: ' . json_encode($db_error));
                throw new Exception('Database query failed: ' . $db_error['message']);
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

    /**
     * 根據會員姓名和電話取得所有匹配的表單記錄 (用於分組匯出)
     * @param string|null $member_name 會員姓名
     * @param string|null $phone 電話號碼
     * @return array 匹配的表單記錄陣列
     */
    public function get_submissions_by_member_info($member_name = null, $phone = null) {
        try {
            // 驗證資料庫連接
            if (!$this->db) {
                throw new Exception('Database connection not available');
            }

            // 檢查表是否存在
            if (!$this->db->table_exists('eeform1_submissions')) {
                log_message('error', 'Table eeform1_submissions does not exist');
                return [];
            }

            // 確保至少有一個查詢條件
            if (empty($member_name) && empty($phone)) {
                log_message('error', 'No search criteria provided for grouped export');
                return [];
            }

            // 建立查詢條件
            $this->db->select('s.id');
            $this->db->from('eeform1_submissions s');

            // 根據提供的參數添加 WHERE 條件
            if (!empty($member_name) && !empty($phone)) {
                // 如果兩個參數都有，則必須同時匹配
                $this->db->where('s.member_name', $member_name);
                $this->db->where('s.phone', $phone);
            } elseif (!empty($member_name)) {
                // 只有姓名
                $this->db->where('s.member_name', $member_name);
            } elseif (!empty($phone)) {
                // 只有電話
                $this->db->where('s.phone', $phone);
            }

            // 按提交日期排序
            $this->db->order_by('s.submission_date', 'DESC');

            $query = $this->db->get();
            if (!$query) {
                $db_error = $this->db->error();
                throw new Exception('Query failed: ' . $db_error['message']);
            }

            $submission_ids = $query->result_array();
            if (empty($submission_ids)) {
                log_message('info', 'No submissions found for member: ' . $member_name . ', phone: ' . $phone);
                return [];
            }

            // 取得每個表單的詳細資料
            $detailed_submissions = [];
            foreach ($submission_ids as $id_row) {
                $submission_detail = $this->get_submission_detail($id_row['id']);
                if ($submission_detail) {
                    $detailed_submissions[] = $submission_detail;
                }
            }

            log_message('info', 'Found ' . count($detailed_submissions) . ' submissions for member: ' . $member_name . ', phone: ' . $phone);
            return $detailed_submissions;

        } catch (Exception $e) {
            log_message('error', 'Error in get_submissions_by_member_info: ' . $e->getMessage());
            log_message('error', 'Trace: ' . $e->getTraceAsString());
            return [];
        }
    }

    /**
     * 刪除所有測試資料
     * @return bool
     */
    public function delete_all_test_data() {
        try {
            $this->db->trans_start();
            
            // 取得所有 submission_id 來確保完整刪除關聯資料
            $this->db->select('id');
            $query = $this->db->get('eeform1_submissions');
            $submissions = $query->result_array();
            
            if (!empty($submissions)) {
                $submission_ids = array_column($submissions, 'id');
                
                // 刪除所有關聯表的資料
                $related_tables = [
                    'eeform1_occupations',
                    'eeform1_lifestyle',
                    'eeform1_products',
                    'eeform1_skin_issues',
                    'eeform1_allergies',
                    'eeform1_skin_scores',
                    'eeform1_suggestions'
                ];
                
                foreach ($related_tables as $table) {
                    if (!empty($submission_ids)) {
                        $this->db->where_in('submission_id', $submission_ids);
                        $this->db->delete($table);
                    }
                }
            }
            
            // 最後刪除主要的 submissions 表
            $this->db->empty_table('eeform1_submissions');
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                log_message('error', 'Failed to delete all test data - transaction failed');
                return false;
            }
            
            log_message('info', 'Successfully deleted all test data');
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Error deleting all test data: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 檢查 MySQL 預儲程序是否存在
     * @param string $procedure_name
     * @return array
     */
    public function check_mysql_procedure($procedure_name) {
        try {
            // 使用 INFORMATION_SCHEMA 查詢預儲程序
            $sql = "SELECT
                        ROUTINE_NAME,
                        ROUTINE_TYPE,
                        ROUTINE_SCHEMA,
                        CREATED,
                        LAST_ALTERED,
                        ROUTINE_COMMENT
                    FROM INFORMATION_SCHEMA.ROUTINES
                    WHERE ROUTINE_SCHEMA = DATABASE()
                      AND ROUTINE_NAME = ?
                      AND ROUTINE_TYPE = 'PROCEDURE'";

            $query = $this->db->query($sql, [$procedure_name]);

            if (!$query) {
                throw new Exception('MySQL query failed: ' . $this->db->error()['message']);
            }

            $result = $query->row_array();

            if ($result) {
                // 預儲程序存在，取得參數資訊
                $param_sql = "SELECT
                                PARAMETER_NAME,
                                PARAMETER_MODE,
                                DATA_TYPE,
                                CHARACTER_MAXIMUM_LENGTH
                            FROM INFORMATION_SCHEMA.PARAMETERS
                            WHERE SPECIFIC_SCHEMA = DATABASE()
                              AND SPECIFIC_NAME = ?
                            ORDER BY ORDINAL_POSITION";

                $param_query = $this->db->query($param_sql, [$procedure_name]);
                $parameters = $param_query ? $param_query->result_array() : [];

                return [
                    'exists' => true,
                    'database_type' => 'MySQL',
                    'procedure_info' => $result,
                    'parameters' => $parameters,
                    'message' => '預儲程序存在於 MySQL 資料庫中'
                ];
            } else {
                return [
                    'exists' => false,
                    'database_type' => 'MySQL',
                    'message' => '預儲程序不存在於 MySQL 資料庫中'
                ];
            }

        } catch (Exception $e) {
            return [
                'exists' => false,
                'database_type' => 'MySQL',
                'error' => $e->getMessage(),
                'message' => 'MySQL 檢查失敗: ' . $e->getMessage()
            ];
        }
    }

    /**
     * 檢查 MSSQL 預儲程序是否存在
     * @param string $procedure_name
     * @return array
     */
    public function check_mssql_procedure($procedure_name) {
        // 暫時停用 MSSQL 檢查功能
        return [
            'exists' => false,
            'database_type' => 'MSSQL',
            'message' => '暫時停用 MSSQL 檢查功能',
            'status' => 'disabled'
        ];

        /* 原始程碼暫時註解
        try {
            // 使用設定檔中的 MSSQL 連線配置
            $mssql_db = $this->load->database('mssql', TRUE);

            if (!$mssql_db) {
                return [
                    'exists' => false,
                    'database_type' => 'MSSQL',
                    'error' => 'MSSQL 連線失敗',
                    'message' => '無法連線到 MSSQL 資料庫'
                ];
            }

            // 查詢 MSSQL 預儲程序
            $sql = "SELECT
                        name,
                        type_desc,
                        create_date,
                        modify_date
                    FROM sys.objects
                    WHERE type = 'P'
                      AND name = ?";

            $query = $mssql_db->query($sql, [$procedure_name]);

            if (!$query) {
                $mssql_db->close();
                throw new Exception('MSSQL query failed');
            }

            $result = $query->row_array();
            $mssql_db->close();

            if ($result) {
                return [
                    'exists' => true,
                    'database_type' => 'MSSQL',
                    'procedure_info' => $result,
                    'message' => '預儲程序存在於 MSSQL 資料庫中'
                ];
            } else {
                return [
                    'exists' => false,
                    'database_type' => 'MSSQL',
                    'message' => '預儲程序不存在於 MSSQL 資料庫中'
                ];
            }

        } catch (Exception $e) {
            return [
                'exists' => false,
                'database_type' => 'MSSQL',
                'error' => $e->getMessage(),
                'message' => 'MSSQL 檢查失敗: ' . $e->getMessage()
            ];
        }
        */
    }

    /**
     * 測試 MySQL 預儲程序
     * @param array $test_data
     * @return array
     */
    public function test_mysql_procedure($test_data) {
        try {
            // 調用 MySQL 預儲程序 - 使用輸出參數版本
            $sql = "CALL ww_chkguest(?, ?, ?, ?, ?, @errcode, @guest_id)";

            $result = $this->db->query($sql, [
                $test_data['test'],
                $test_data['d_spno'],
                $test_data['cname'],
                $test_data['bdate'],
                $test_data['cell']
            ]);

            if (!$result) {
                throw new Exception('MySQL 預儲程序調用失敗: ' . $this->db->error()['message']);
            }

            // 取得輸出參數
            $output_query = $this->db->query("SELECT @errcode as errcode, @guest_id as guest_id");
            $output = $output_query ? $output_query->row_array() : null;

            if (!$output) {
                throw new Exception('無法取得預儲程序輸出參數');
            }

            // 錯誤代碼對應訊息
            $error_messages = [
                0 => '來賓身分通過驗證',
                1 => '已存在此來賓',
                2 => '已存在此來賓，但推薦人不同',
                3 => '此來賓已經是會員了'
            ];

            // 處理輸出參數
            $errcode = isset($output['errcode']) ? (int)$output['errcode'] : -1;
            $guest_id = $output['guest_id'] ?? null;

            return [
                'success' => true,
                'database_type' => 'MySQL',
                'input_data' => $test_data,
                'raw_output' => $output,  // 原始輸出供調試用
                'errcode' => $errcode,
                'guest_id' => $guest_id,
                'message' => $error_messages[$errcode] ?? '未知錯誤 (errcode: ' . $errcode . ')',
                'execution_time' => date('Y-m-d H:i:s'),
                'note' => '如果預儲程序不存在或參數不正確，此測試會失敗'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'database_type' => 'MySQL',
                'error' => $e->getMessage(),
                'input_data' => $test_data,
                'message' => 'MySQL 預儲程序執行失敗: ' . $e->getMessage()
            ];
        }
    }

    /**
     * 測試 MSSQL 預儲程序
     * @param array $test_data
     * @return array
     */
    public function test_mssql_procedure($test_data) {
        // 暫時停用 MSSQL 測試功能
        return [
            'success' => false,
            'database_type' => 'MSSQL',
            'message' => '暫時停用 MSSQL 測試功能',
            'status' => 'disabled',
            'input_data' => $test_data
        ];

        /* 原始程碼暫時註解
        try {
            // 使用設定檔中的 MSSQL 連線配置
            $mssql_db = $this->load->database('mssql', TRUE);

            if (!$mssql_db) {
                throw new Exception('MSSQL 連線失敗');
            }

            // 調用 MSSQL 預儲程序
            $sql = "EXEC ww_chkguest ?, ?, ?, ?, ?";

            $result = $mssql_db->query($sql, [
                $test_data['test'],
                $test_data['d_spno'],
                $test_data['cname'],
                $test_data['bdate'],
                $test_data['cell']
            ]);

            if (!$result) {
                $mssql_db->close();
                throw new Exception('MSSQL 預儲程序調用失敗');
            }

            $output = $result->row_array();
            $mssql_db->close();

            // 錯誤代碼對應訊息
            $error_messages = [
                0 => '來賓身分通過驗證',
                1 => '已存在此來賓',
                2 => '已存在此來賓，但推薦人不同',
                3 => '此來賓已經是會員了'
            ];

            $errcode = isset($output['errcode']) ? (int)$output['errcode'] : -1;

            return [
                'success' => true,
                'database_type' => 'MSSQL',
                'input_data' => $test_data,
                'output' => $output,
                'errcode' => $errcode,
                'guest_id' => $output['c_no'] ?? null,
                'message' => $error_messages[$errcode] ?? '未知錯誤',
                'execution_time' => date('Y-m-d H:i:s')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'database_type' => 'MSSQL',
                'error' => $e->getMessage(),
                'input_data' => $test_data,
                'message' => 'MSSQL 預儲程序執行失敗: ' . $e->getMessage()
            ];
        }
        */
    }

    /**
     * 創建 MySQL 預儲程序 ww_chkguest
     * @return array
     */
    public function create_mysql_procedure() {
        try {
            // 先檢查 member 表是否存在
            $table_check = $this->db->query("SHOW TABLES LIKE 'member'");
            $member_table_exists = $table_check && $table_check->num_rows() > 0;

            // 定義需要檢查的欄位
            $columns_to_check = [
                'member_type' => "ALTER TABLE `member` ADD COLUMN `member_type` ENUM('member', 'guest') DEFAULT 'guest' COMMENT '會員類型'",
                'birth_date' => "ALTER TABLE `member` ADD COLUMN `birth_date` VARCHAR(8) NULL COMMENT '生日 YYYYMMDD'",
                'phone' => "ALTER TABLE `member` ADD COLUMN `phone` VARCHAR(20) NULL COMMENT '電話'"
            ];

            if (!$member_table_exists) {
                // 創建基本的 member 表用於測試
                $create_member_table = "
                    CREATE TABLE IF NOT EXISTS `member` (
                        `c_no` VARCHAR(10) PRIMARY KEY COMMENT '會員編號',
                        `d_spno` CHAR(7) NULL COMMENT '推薦人編號',
                        `c_name` VARCHAR(20) NOT NULL COMMENT '會員姓名',
                        `birth_date` VARCHAR(8) NULL COMMENT '生日 YYYYMMDD',
                        `phone` VARCHAR(20) NULL COMMENT '電話',
                        `member_type` ENUM('member', 'guest') DEFAULT 'guest' COMMENT '會員類型',
                        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員資料表'
                ";

                $this->db->query($create_member_table);

                if ($this->db->error()['code'] != 0) {
                    throw new Exception('創建 member 表失敗: ' . $this->db->error()['message']);
                }
            } else {
                // 檢查現有 member 表是否有必要的欄位，如果沒有則添加
                foreach ($columns_to_check as $column => $alter_sql) {
                    $column_check = $this->db->query("SHOW COLUMNS FROM `member` LIKE '{$column}'");
                    if (!$column_check || $column_check->num_rows() == 0) {
                        // 欄位不存在，添加它
                        $this->db->query($alter_sql);
                        if ($this->db->error()['code'] != 0) {
                            // 不是致命錯誤，記錄但繼續
                            error_log("Warning: Could not add column {$column}: " . $this->db->error()['message']);
                        }
                    }
                }
            }

            // 刪除已存在的預儲程序
            $drop_sql = "DROP PROCEDURE IF EXISTS ww_chkguest";
            $this->db->query($drop_sql);

            // 創建預儲程序
            $procedure_sql = "
            CREATE PROCEDURE `ww_chkguest`(
                IN `test_mode` TINYINT,
                IN `d_spno` CHAR(7),
                IN `cname` VARCHAR(20),
                IN `bdate` VARCHAR(8),
                IN `cell` VARCHAR(20),
                OUT `errcode` SMALLINT,
                OUT `guest_id` VARCHAR(10)
            )
            BEGIN
                DECLARE v_count INT DEFAULT 0;
                DECLARE v_existing_id VARCHAR(10) DEFAULT '';
                DECLARE v_existing_d_spno CHAR(7) DEFAULT '';
                DECLARE v_new_guest_id VARCHAR(10);
                DECLARE v_member_type_exists INT DEFAULT 0;

                -- 初始化輸出參數
                SET errcode = 0;
                SET guest_id = '';

                -- 檢查 member_type 欄位是否存在
                SELECT COUNT(*)
                INTO v_member_type_exists
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'member'
                  AND COLUMN_NAME = 'member_type';

                -- 檢查是否已存在相同的來賓（根據姓名、生日、電話）
                -- 首先檢查數量
                SELECT COUNT(*)
                INTO v_count
                FROM member
                WHERE c_name = cname
                  AND (birth_date = bdate OR birth_date IS NULL)
                  AND (phone = cell OR phone IS NULL);

                -- 如果存在，取得詳細資料
                IF v_count > 0 THEN
                    SELECT c_no, COALESCE(d_spno, '') as d_spno
                    INTO v_existing_id, v_existing_d_spno
                    FROM member
                    WHERE c_name = cname
                      AND (birth_date = bdate OR birth_date IS NULL)
                      AND (phone = cell OR phone IS NULL)
                    LIMIT 1;
                END IF;

                IF v_count > 0 THEN
                    -- 已存在此來賓
                    SET guest_id = v_existing_id;

                    -- 簡化邏輯：如果推薦人不同則返回錯誤2，否則返回錯誤1
                    IF v_existing_d_spno != d_spno THEN
                        -- 推薦人不同
                        SET errcode = 2;
                    ELSE
                        -- 已存在此來賓，推薦人相同
                        SET errcode = 1;
                    END IF;
                ELSE
                    -- 新來賓，通過驗證
                    SET errcode = 0;

                    -- 如果是正式模式，產生來賓編號並新增資料
                    IF test_mode = 0 THEN
                        -- 產生新的來賓編號 (G + 6位數字)
                        SELECT CONCAT('G', LPAD(COALESCE(MAX(CAST(SUBSTRING(c_no, 2) AS UNSIGNED)), 0) + 1, 6, '0'))
                        INTO v_new_guest_id
                        FROM member
                        WHERE c_no LIKE 'G%';

                        -- 插入新來賓資料（根據欄位是否存在決定插入語句）
                        IF v_member_type_exists > 0 THEN
                            INSERT INTO member (c_no, d_spno, c_name, birth_date, phone, member_type)
                            VALUES (v_new_guest_id, d_spno, cname, bdate, cell, 'guest');
                        ELSE
                            INSERT INTO member (c_no, d_spno, c_name)
                            VALUES (v_new_guest_id, d_spno, cname);
                        END IF;

                        SET guest_id = v_new_guest_id;
                    ELSE
                        -- 測試模式，不實際新增資料
                        SET guest_id = 'TEST_GUEST';
                    END IF;
                END IF;

            END
            ";

            // 執行創建預儲程序
            $result = $this->db->query($procedure_sql);

            if (!$result) {
                $db_error = $this->db->error();
                throw new Exception('創建預儲程序失敗: ' . $db_error['message']);
            }

            // 檢查哪些欄位被添加了
            $added_columns = [];
            if ($member_table_exists) {
                foreach ($columns_to_check as $column => $alter_sql) {
                    $column_check = $this->db->query("SHOW COLUMNS FROM `member` LIKE '{$column}'");
                    if ($column_check && $column_check->num_rows() > 0) {
                        $added_columns[] = $column;
                    }
                }
            }

            return [
                'success' => true,
                'message' => 'ww_chkguest 預儲程序創建成功',
                'procedure_name' => 'ww_chkguest',
                'created_at' => date('Y-m-d H:i:s'),
                'member_table_existed' => $member_table_exists,
                'columns_added' => $member_table_exists ? $added_columns : ['所有欄位 (新建表)'],
                'parameters' => [
                    'test_mode' => 'TINYINT (1=測試用, 0=正式模式)',
                    'd_spno' => 'CHAR(7) (推薦人編號)',
                    'cname' => 'VARCHAR(20) (來賓姓名)',
                    'bdate' => 'VARCHAR(8) (生日 YYYYMMDD)',
                    'cell' => 'VARCHAR(20) (電話)'
                ],
                'output_parameters' => [
                    'errcode' => 'SMALLINT (0=通過, 1=已存在, 2=推薦人不同, 3=已是會員)',
                    'guest_id' => 'VARCHAR(10) (來賓編號)'
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => '創建預儲程序失敗: ' . $e->getMessage()
            ];
        }
    }
}