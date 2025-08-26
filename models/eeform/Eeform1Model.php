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
            
            // 處理水潤評分資料
            $moisture_types = ['severe', 'warning', 'healthy'];
            foreach ($moisture_types as $type) {
                if (!empty($data["moisture_{$type}"])) {
                    $this->db->insert('eeform1_moisture_scores', [
                        'submission_id' => $submission_id,
                        'score_type' => $type,
                        'score_value' => intval($data["moisture_{$type}"]),
                        'measurement_date' => date('Y-m-d')
                    ]);
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
        $this->db->where('s.phone', $member_id); // 使用電話作為會員識別
        
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
        
        // 取得水潤評分資料
        $this->db->from('eeform1_moisture_scores');
        $this->db->where('submission_id', $id);
        $moisture_scores = $this->db->get()->result_array();
        
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
        $submission['moisture_scores'] = $moisture_scores;
        $submission['suggestions'] = $suggestions;
        
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
            
            // 重新插入新的關聯資料（使用與 create_submission 相同的邏輯）
            // ... (省略重複代碼，與 create_submission 中的處理邏輯相同)
            
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
        $this->db->where('phone', $member_id);
        $total_submissions = $this->db->count_all_results('eeform1_submissions');
        
        // 取得最新提交日期
        $this->db->select('submission_date');
        $this->db->where('phone', $member_id);
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