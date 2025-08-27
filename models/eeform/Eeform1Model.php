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
     * 驗證提交資料
     * @param array $data
     * @return array
     */
    public function validate_submission_data($data)
    {
        $errors = [];
        $required_fields = ['member_name', 'birth_year', 'birth_month', 'phone'];
        
        // 檢查必填欄位
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "必填欄位 {$field} 不能為空";
            }
        }
        
        // 驗證出生年份
        if (!empty($data['birth_year'])) {
            $year = intval($data['birth_year']);
            if ($year < 1950 || $year > date('Y')) {
                $errors[] = '出生年份不在有效範圍內';
            }
        }
        
        // 驗證出生月份
        if (!empty($data['birth_month'])) {
            $month = intval($data['birth_month']);
            if ($month < 1 || $month > 12) {
                $errors[] = '出生月份不在有效範圍內';
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
                'member_name' => $data['member_name'],
                'birth_year' => intval($data['birth_year']),
                'birth_month' => intval($data['birth_month']),
                'phone' => $data['phone'],
                'skin_type' => isset($data['skin_type']) ? $data['skin_type'] : null,
                'skin_age' => isset($data['skin_age']) ? intval($data['skin_age']) : null,
                'submission_date' => date('Y-m-d'),
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
                    if (!empty($data[$field_name])) {
                        $score_data = [
                            'submission_id' => $submission_id,
                            'category' => $category,
                            'score_type' => $type,
                            'score_value' => intval($data[$field_name]),
                            'measurement_date' => date('Y-m-d')
                        ];
                        
                        // 檢查是否有對應的日期和數字資料
                        $date_field = "{$category}_date";
                        $number_field = "{$category}_number";
                        
                        if (!empty($data[$date_field])) {
                            $score_data['measurement_date'] = $data[$date_field];
                        }
                        
                        if (!empty($data[$number_field])) {
                            $score_data['measurement_number'] = intval($data[$number_field]);
                        }
                        
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
        $this->db->select('s.*, COUNT(*) OVER() as total_count');
        $this->db->from('eeform1_submissions s');
        $this->db->where('s.member_id', $member_id); // 使用member_id作為會員識別
        
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
        error_log('Table eeform1_skin_scores exists: ' . ($table_check->num_rows() > 0 ? 'YES' : 'NO'));
        
        if ($table_check->num_rows() === 0) {
            error_log('ERROR: eeform1_skin_scores table does not exist!');
            // 檢查是否還在使用舊的表名
            $old_table_check = $this->db->query("SHOW TABLES LIKE 'eeform1_moisture_scores'");
            error_log('Old table eeform1_moisture_scores exists: ' . ($old_table_check->num_rows() > 0 ? 'YES' : 'NO'));
            
            if ($old_table_check->num_rows() > 0) {
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
            }
        }
        
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
            error_log('No skin_scores found - checking if table exists or data was inserted');
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
                    if (!empty($data[$field_name])) {
                        $score_data = [
                            'submission_id' => $id,
                            'category' => $category,
                            'score_type' => $type,
                            'score_value' => intval($data[$field_name]),
                            'measurement_date' => date('Y-m-d')
                        ];
                        
                        // 檢查是否有對應的日期和數字資料
                        $date_field = "{$category}_date";
                        $number_field = "{$category}_number";
                        
                        if (!empty($data[$date_field])) {
                            $score_data['measurement_date'] = $data[$date_field];
                        }
                        
                        if (!empty($data[$number_field])) {
                            $score_data['measurement_number'] = intval($data[$number_field]);
                        }
                        
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
}