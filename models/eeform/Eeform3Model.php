<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform3Model extends MY_Model {

    protected $table_submissions = 'eeform3_submissions';
    protected $table_body_data = 'eeform3_body_data';
    protected $table_activity_items = 'eeform3_activity_items';
    protected $table_activity_records = 'eeform3_activity_records';
    protected $table_plans = 'eeform3_plans';

    public function __construct() {
        parent::__construct();
        
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->load->database();
    }

    /**
     * 驗證表單提交資料
     * @param array $data 表單資料
     * @return array 驗證結果
     */
    public function validate_submission_data($data) {
        $errors = [];
        
        // 必填欄位驗證
        $required_fields = [
            'member_name' => '會員姓名',
            'member_id' => '會員編號',
            'age' => '年齡',
            'height' => '身高',
            'goal' => '目標'
        ];
        
        foreach ($required_fields as $field => $label) {
            if (empty($data[$field])) {
                $errors[] = $label . '為必填欄位';
            }
        }
        
        // 數據格式驗證
        if (!empty($data['age'])) {
            if (!is_numeric($data['age']) || $data['age'] < 0 || $data['age'] > 150) {
                $errors[] = '年齡必須為0-150之間的數字';
            }
        }
        
        if (!empty($data['height'])) {
            if (!is_numeric($data['height']) || $data['height'] < 50 || $data['height'] > 300) {
                $errors[] = '身高必須為50-300之間的數字';
            }
        }
        
        if (!empty($data['weight'])) {
            if (!is_numeric($data['weight']) || $data['weight'] < 0 || $data['weight'] > 500) {
                $errors[] = '體重必須為0-500之間的數字';
            }
        }
        
        if (!empty($data['blood_pressure_high'])) {
            if (!is_numeric($data['blood_pressure_high']) || $data['blood_pressure_high'] < 50 || $data['blood_pressure_high'] > 300) {
                $errors[] = '收縮壓必須為50-300之間的數字';
            }
        }
        
        if (!empty($data['blood_pressure_low'])) {
            if (!is_numeric($data['blood_pressure_low']) || $data['blood_pressure_low'] < 30 || $data['blood_pressure_low'] > 200) {
                $errors[] = '舒張壓必須為30-200之間的數字';
            }
        }
        
        if (!empty($data['waist'])) {
            if (!is_numeric($data['waist']) || $data['waist'] < 30 || $data['waist'] > 200) {
                $errors[] = '腰圍必須為30-200之間的數字';
            }
        }
        
        // 血壓邏輯驗證
        if (!empty($data['blood_pressure_high']) && !empty($data['blood_pressure_low'])) {
            if ($data['blood_pressure_high'] <= $data['blood_pressure_low']) {
                $errors[] = '收縮壓必須大於舒張壓';
            }
        }
        
        // 會員編號格式驗證
        if (!empty($data['member_id'])) {
            if (!preg_match('/^[A-Za-z0-9]+$/', $data['member_id'])) {
                $errors[] = '會員編號只能包含英文字母和數字';
            }
        }
        
        // 字串長度驗證
        $string_fields = [
            'member_name' => ['max' => 100, 'label' => '會員姓名'],
            'member_id' => ['max' => 50, 'label' => '會員編號'],
            'goal' => ['max' => 1000, 'label' => '目標'],
            'action_plan_1' => ['max' => 1000, 'label' => '自身行動計畫1'],
            'action_plan_2' => ['max' => 1000, 'label' => '自身行動計畫2'],
            'plan_a' => ['max' => 1000, 'label' => '計畫a'],
            'plan_b' => ['max' => 1000, 'label' => '計畫b'],
            'other' => ['max' => 1000, 'label' => '其他']
        ];
        
        foreach ($string_fields as $field => $config) {
            if (!empty($data[$field]) && mb_strlen($data[$field]) > $config['max']) {
                $errors[] = $config['label'] . '不能超過' . $config['max'] . '個字符';
            }
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * 建立表單提交記錄
     * @param array $data 表單資料
     * @return int|false 提交ID或false
     */
    public function create_submission($data) {
        $this->db->trans_start();
        
        try {
            // 資料清理和預處理
            $cleaned_data = $this->clean_submission_data($data);
            
            // 插入主表單資料
            $submission_data = [
                'member_name' => $cleaned_data['member_name'],
                'member_id' => $cleaned_data['member_id'],
                'age' => (int)$cleaned_data['age'],
                'height' => (int)$cleaned_data['height'],
                'goal' => $cleaned_data['goal'],
                'action_plan_1' => isset($cleaned_data['action_plan_1']) ? $cleaned_data['action_plan_1'] : null,
                'action_plan_2' => isset($cleaned_data['action_plan_2']) ? $cleaned_data['action_plan_2'] : null,
                'submission_date' => date('Y-m-d'),
                'status' => 'submitted'
            ];
            
            $this->db->insert($this->table_submissions, $submission_data);
            $submission_id = $this->db->insert_id();
            
            if (!$submission_id) {
                throw new Exception('無法建立表單提交記錄');
            }
            
            // 插入身體數據
            if (isset($cleaned_data['weight']) || isset($cleaned_data['blood_pressure_high']) || 
                isset($cleaned_data['blood_pressure_low']) || isset($cleaned_data['waist'])) {
                
                $body_data = [
                    'submission_id' => $submission_id,
                    'weight' => !empty($cleaned_data['weight']) ? (float)$cleaned_data['weight'] : null,
                    'blood_pressure_high' => !empty($cleaned_data['blood_pressure_high']) ? (int)$cleaned_data['blood_pressure_high'] : null,
                    'blood_pressure_low' => !empty($cleaned_data['blood_pressure_low']) ? (int)$cleaned_data['blood_pressure_low'] : null,
                    'waist' => !empty($cleaned_data['waist']) ? (float)$cleaned_data['waist'] : null
                ];
                
                $this->db->insert($this->table_body_data, $body_data);
            }
            
            // 插入活動記錄
            $activity_fields = ['hand_measure', 'exercise', 'health_supplement', 'weika', 'water_intake'];
            foreach ($activity_fields as $field) {
                if (isset($cleaned_data[$field]) && $cleaned_data[$field]) {
                    // 先取得活動項目ID
                    $activity_item = $this->db->get_where($this->table_activity_items, ['item_key' => $field])->row();
                    
                    if ($activity_item) {
                        $activity_record = [
                            'submission_id' => $submission_id,
                            'activity_item_id' => $activity_item->id,
                            'is_completed' => 1,
                            'completion_time' => date('Y-m-d H:i:s')
                        ];
                        
                        $this->db->insert($this->table_activity_records, $activity_record);
                    }
                }
            }
            
            // 插入計畫記錄
            $plan_fields = [
                'plan_a' => 'plan_a',
                'plan_b' => 'plan_b',
                'other' => 'other'
            ];
            
            foreach ($plan_fields as $field => $plan_type) {
                if (!empty($cleaned_data[$field])) {
                    $plan_data = [
                        'submission_id' => $submission_id,
                        'plan_type' => $plan_type,
                        'plan_content' => $cleaned_data[$field],
                        'status' => 'pending'
                    ];
                    
                    $this->db->insert($this->table_plans, $plan_data);
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('交易失敗');
            }
            
            // 記錄操作日誌
            if ($submission_id) {
                $this->log_operation('create_submission', $submission_id, $cleaned_data);
                $this->notify_submission_created($submission_id, $cleaned_data);
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->log_error('create_submission_error', $e->getMessage(), $data);
            return false;
        }
    }

    /**
     * 取得會員提交記錄
     * @param string $member_id 會員編號
     * @param int $page 頁數
     * @param int $limit 每頁筆數
     * @param string $start_date 開始日期
     * @param string $end_date 結束日期
     * @return array
     */
    public function get_member_submissions($member_id, $page = 1, $limit = 10, $start_date = null, $end_date = null) {
        $offset = ($page - 1) * $limit;
        
        $this->db->select('s.*, bd.weight, bd.blood_pressure_high, bd.blood_pressure_low, bd.waist');
        $this->db->from($this->table_submissions . ' s');
        $this->db->join($this->table_body_data . ' bd', 's.id = bd.submission_id', 'left');
        $this->db->where('s.member_id', $member_id);
        
        if ($start_date) {
            $this->db->where('s.submission_date >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('s.submission_date <=', $end_date);
        }
        
        $this->db->order_by('s.submission_date', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        $results = $query->result_array();
        
        // 取得總筆數
        $this->db->from($this->table_submissions);
        $this->db->where('member_id', $member_id);
        
        if ($start_date) {
            $this->db->where('submission_date >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('submission_date <=', $end_date);
        }
        
        $total = $this->db->count_all_results();
        
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
     * 取得表單詳細資料
     * @param int $id 表單ID
     * @return array|null
     */
    public function get_submission_detail($id) {
        // 基本表單資料
        $this->db->select('s.*, bd.weight, bd.blood_pressure_high, bd.blood_pressure_low, bd.waist, bd.measurement_time');
        $this->db->from($this->table_submissions . ' s');
        $this->db->join($this->table_body_data . ' bd', 's.id = bd.submission_id', 'left');
        $this->db->where('s.id', $id);
        
        $submission = $this->db->get()->row_array();
        
        if (!$submission) {
            return null;
        }
        
        // 活動記錄
        $this->db->select('ar.*, ai.item_key, ai.item_name');
        $this->db->from($this->table_activity_records . ' ar');
        $this->db->join($this->table_activity_items . ' ai', 'ar.activity_item_id = ai.id');
        $this->db->where('ar.submission_id', $id);
        $this->db->where('ar.is_completed', 1);
        
        $activities = $this->db->get()->result_array();
        $submission['activities'] = $activities;
        
        // 計畫記錄
        $this->db->select('*');
        $this->db->from($this->table_plans);
        $this->db->where('submission_id', $id);
        $this->db->order_by('plan_type');
        
        $plans = $this->db->get()->result_array();
        $submission['plans'] = $plans;
        
        return $submission;
    }

    /**
     * 取得活動項目列表
     * @return array
     */
    public function get_activity_items() {
        $this->db->select('*');
        $this->db->from($this->table_activity_items);
        $this->db->where('is_active', 1);
        $this->db->order_by('sort_order', 'ASC');
        
        return $this->db->get()->result_array();
    }

    /**
     * 更新表單狀態
     * @param int $id 表單ID
     * @param string $status 狀態
     * @return bool
     */
    public function update_submission_status($id, $status) {
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->where('id', $id);
        return $this->db->update($this->table_submissions, $data);
    }

    /**
     * 刪除表單提交記錄
     * @param int $id 表單ID
     * @return bool
     */
    public function delete_submission($id) {
        $this->db->trans_start();
        
        try {
            // 刪除相關記錄 (由於有外鍵約束，會自動刪除相關資料)
            $this->db->where('id', $id);
            $this->db->delete($this->table_submissions);
            
            $this->db->trans_complete();
            
            return $this->db->trans_status();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }

    /**
     * 取得會員統計資料
     * @param string $member_id 會員編號
     * @return array
     */
    public function get_member_stats($member_id) {
        $stats = [];
        
        // 總提交次數
        $this->db->from($this->table_submissions);
        $this->db->where('member_id', $member_id);
        $stats['total_submissions'] = $this->db->count_all_results();
        
        // 最新提交日期
        $this->db->select('submission_date');
        $this->db->from($this->table_submissions);
        $this->db->where('member_id', $member_id);
        $this->db->order_by('submission_date', 'DESC');
        $this->db->limit(1);
        
        $latest = $this->db->get()->row();
        $stats['last_submission_date'] = $latest ? $latest->submission_date : null;
        
        // 平均完成活動數
        $this->db->select('AVG(activity_count) as avg_activities');
        $this->db->from('(
            SELECT s.id, COUNT(ar.id) as activity_count 
            FROM ' . $this->table_submissions . ' s 
            LEFT JOIN ' . $this->table_activity_records . ' ar ON s.id = ar.submission_id AND ar.is_completed = 1 
            WHERE s.member_id = "' . $member_id . '"
            GROUP BY s.id
        ) as subquery');
        
        $avg_result = $this->db->get()->row();
        $stats['avg_completed_activities'] = $avg_result ? round($avg_result->avg_activities, 2) : 0;
        
        // 身體數據統計 (最近的記錄)
        $this->db->select('bd.*');
        $this->db->from($this->table_submissions . ' s');
        $this->db->join($this->table_body_data . ' bd', 's.id = bd.submission_id');
        $this->db->where('s.member_id', $member_id);
        $this->db->order_by('s.submission_date', 'DESC');
        $this->db->limit(5);
        
        $body_data = $this->db->get()->result_array();
        
        if ($body_data) {
            $weights = array_filter(array_column($body_data, 'weight'));
            $bp_highs = array_filter(array_column($body_data, 'blood_pressure_high'));
            $bp_lows = array_filter(array_column($body_data, 'blood_pressure_low'));
            $waists = array_filter(array_column($body_data, 'waist'));
            
            $stats['body_stats'] = [
                'latest_weight' => $weights ? $weights[0] : null,
                'avg_weight' => $weights ? round(array_sum($weights) / count($weights), 2) : null,
                'latest_bp_high' => $bp_highs ? $bp_highs[0] : null,
                'avg_bp_high' => $bp_highs ? round(array_sum($bp_highs) / count($bp_highs), 1) : null,
                'latest_bp_low' => $bp_lows ? $bp_lows[0] : null,
                'avg_bp_low' => $bp_lows ? round(array_sum($bp_lows) / count($bp_lows), 1) : null,
                'latest_waist' => $waists ? $waists[0] : null,
                'avg_waist' => $waists ? round(array_sum($waists) / count($waists), 2) : null
            ];
        } else {
            $stats['body_stats'] = null;
        }
        
        return $stats;
    }

    /**
     * 匯出提交資料
     * @param array $params 匯出參數
     * @return array
     */
    public function export_submissions($params) {
        $this->db->select('s.*, bd.weight, bd.blood_pressure_high, bd.blood_pressure_low, bd.waist');
        $this->db->from($this->table_submissions . ' s');
        $this->db->join($this->table_body_data . ' bd', 's.id = bd.submission_id', 'left');
        
        if (!empty($params['start_date'])) {
            $this->db->where('s.submission_date >=', $params['start_date']);
        }
        
        if (!empty($params['end_date'])) {
            $this->db->where('s.submission_date <=', $params['end_date']);
        }
        
        if (!empty($params['member_ids']) && is_array($params['member_ids'])) {
            $this->db->where_in('s.member_id', $params['member_ids']);
        }
        
        $this->db->order_by('s.submission_date', 'DESC');
        
        return $this->db->get()->result_array();
    }

    /**
     * 初始化活動項目資料
     * @return bool
     */
    public function initialize_activity_items() {
        $items = [
            ['item_key' => 'hand_measure', 'item_name' => '用手測量', 'sort_order' => 1],
            ['item_key' => 'exercise', 'item_name' => '運動(30分)', 'sort_order' => 2],
            ['item_key' => 'health_supplement', 'item_name' => '保健食品', 'sort_order' => 3],
            ['item_key' => 'weika', 'item_name' => '微微卡', 'sort_order' => 4],
            ['item_key' => 'water_intake', 'item_name' => '飲水量', 'sort_order' => 5]
        ];
        
        foreach ($items as $item) {
            // 檢查是否已存在
            $existing = $this->db->get_where($this->table_activity_items, ['item_key' => $item['item_key']])->row();
            
            if (!$existing) {
                $this->db->insert($this->table_activity_items, $item);
            }
        }
        
        return true;
    }

    /**
     * 取得會員提交記錄 (增強版包含計算欄位)
     * @param string $member_id 會員編號
     * @param int $page 頁數
     * @param int $limit 每頁筆數
     * @param string $start_date 開始日期
     * @param string $end_date 結束日期
     * @return array
     */
    public function get_member_submissions_enhanced($member_id, $page = 1, $limit = 10, $start_date = null, $end_date = null) {
        // 參數驗證
        $page = max(1, (int)$page);
        $limit = max(1, min(100, (int)$limit)); // 限制最大100筆
        
        // 日期格式驗證
        if ($start_date && !$this->validate_date($start_date)) {
            throw new Exception('開始日期格式不正確');
        }
        
        if ($end_date && !$this->validate_date($end_date)) {
            throw new Exception('結束日期格式不正確');
        }
        
        $result = $this->get_member_submissions($member_id, $page, $limit, $start_date, $end_date);
        
        // 處理返回資料，添加計算欄位
        foreach ($result['data'] as &$submission) {
            $submission['bmi'] = $this->calculate_bmi($submission['weight'] ?? null, $submission['height'] ?? null);
            $submission['submission_days_ago'] = $this->calculate_days_ago($submission['submission_date']);
        }
        
        return $result;
    }

    /**
     * 取得表單詳細資料 (增強版包含計算欄位)
     * @param int $id 表單ID
     * @return array|null
     */
    public function get_submission_detail_enhanced($id) {
        $submission = $this->get_submission_detail($id);
        
        if ($submission) {
            // 添加計算欄位
            $submission['bmi'] = $this->calculate_bmi($submission['weight'] ?? null, $submission['height'] ?? null);
            $submission['submission_days_ago'] = $this->calculate_days_ago($submission['submission_date']);
            
            // 整理活動資料為更友好的格式
            $submission['activity_summary'] = $this->format_activity_summary($submission['activities'] ?? []);
        }
        
        return $submission;
    }

    /**
     * 更新表單狀態 (增強版包含日誌)
     * @param int $id 表單ID
     * @param string $status 狀態
     * @return bool
     */
    public function update_submission_status_enhanced($id, $status) {
        $valid_statuses = ['draft', 'submitted', 'reviewed'];
        
        if (!in_array($status, $valid_statuses)) {
            throw new Exception('無效的狀態值');
        }
        
        $result = $this->update_submission_status($id, $status);
        
        if ($result) {
            $this->log_operation('update_status', $id, ['status' => $status]);
        }
        
        return $result;
    }

    /**
     * 刪除表單提交記錄 (增強版包含日誌)
     * @param int $id 表單ID
     * @return bool
     */
    public function delete_submission_enhanced($id) {
        // 先取得記錄資訊用於日誌
        $submission = $this->get_submission_detail($id);
        
        $result = $this->delete_submission($id);
        
        if ($result && $submission) {
            $this->log_operation('delete_submission', $id, $submission);
        }
        
        return $result;
    }

    /**
     * 取得會員統計資料 (增強版包含趨勢分析)
     * @param string $member_id 會員編號
     * @return array
     */
    public function get_member_stats_enhanced($member_id) {
        $stats = $this->get_member_stats($member_id);
        
        // 添加額外的統計資料
        $stats['health_trends'] = $this->analyze_health_trends($member_id);
        $stats['goal_achievement'] = $this->analyze_goal_achievement($member_id);
        
        return $stats;
    }

    /**
     * 匯出提交資料 (增強版支援CSV)
     * @param array $params 匯出參數
     * @return array|string
     */
    public function export_submissions_enhanced($params) {
        $data = $this->export_submissions($params);
        
        if ($params['format'] === 'csv') {
            return $this->convert_to_csv($data);
        }
        
        return $data;
    }

    /**
     * 清理表單提交資料
     * @param array $data 原始資料
     * @return array 清理後的資料
     */
    private function clean_submission_data($data) {
        $cleaned = [];
        
        // 清理字串欄位
        $string_fields = ['member_name', 'member_id', 'goal', 'action_plan_1', 'action_plan_2', 'plan_a', 'plan_b', 'other'];
        foreach ($string_fields as $field) {
            if (isset($data[$field])) {
                $cleaned[$field] = trim($data[$field]);
            }
        }
        
        // 清理數字欄位
        $numeric_fields = ['age', 'height', 'weight', 'blood_pressure_high', 'blood_pressure_low', 'waist'];
        foreach ($numeric_fields as $field) {
            if (isset($data[$field]) && $data[$field] !== '') {
                $cleaned[$field] = is_numeric($data[$field]) ? $data[$field] : null;
            }
        }
        
        // 清理布林欄位
        $boolean_fields = ['hand_measure', 'exercise', 'health_supplement', 'weika', 'water_intake'];
        foreach ($boolean_fields as $field) {
            if (isset($data[$field])) {
                $cleaned[$field] = !empty($data[$field]) ? 1 : 0;
            }
        }
        
        return $cleaned;
    }

    /**
     * 計算BMI
     * @param float $weight 體重(公斤)
     * @param int $height 身高(公分)
     * @return float|null
     */
    private function calculate_bmi($weight, $height) {
        if (!$weight || !$height) {
            return null;
        }
        
        $height_m = $height / 100;
        $bmi = $weight / ($height_m * $height_m);
        
        return round($bmi, 2);
    }

    /**
     * 計算距今天數
     * @param string $date 日期
     * @return int
     */
    private function calculate_days_ago($date) {
        $submission_date = new DateTime($date);
        $today = new DateTime();
        $diff = $today->diff($submission_date);
        
        return $diff->days;
    }

    /**
     * 格式化活動摘要
     * @param array $activities 活動列表
     * @return array
     */
    private function format_activity_summary($activities) {
        $summary = [];
        
        foreach ($activities as $activity) {
            $summary[] = [
                'name' => $activity['item_name'],
                'completed' => true,
                'completion_time' => $activity['completion_time']
            ];
        }
        
        return $summary;
    }

    /**
     * 分析健康趨勢
     * @param string $member_id 會員編號
     * @return array
     */
    private function analyze_health_trends($member_id) {
        // 這裡可以實現更複雜的健康趨勢分析
        // 目前返回基本資訊
        return [
            'weight_trend' => 'stable', // stable, increasing, decreasing
            'bp_trend' => 'stable',
            'activity_trend' => 'stable'
        ];
    }

    /**
     * 分析目標達成情況
     * @param string $member_id 會員編號
     * @return array
     */
    private function analyze_goal_achievement($member_id) {
        // 這裡可以實現目標達成度分析
        return [
            'completion_rate' => 0.75, // 完成度百分比
            'consistency' => 'good', // excellent, good, fair, poor
            'recommendations' => ['持續記錄', '增加運動頻率']
        ];
    }

    /**
     * 驗證日期格式
     * @param string $date 日期字串
     * @return bool
     */
    private function validate_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    /**
     * 轉換為CSV格式
     * @param array $data 資料陣列
     * @return string
     */
    private function convert_to_csv($data) {
        if (empty($data)) {
            return '';
        }
        
        $output = fopen('php://temp', 'r+');
        
        // 寫入標題行
        $headers = array_keys($data[0]);
        fputcsv($output, $headers);
        
        // 寫入資料行
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }

    /**
     * 記錄操作日誌
     * @param string $action 操作類型
     * @param int $record_id 記錄ID
     * @param array $data 相關資料
     */
    private function log_operation($action, $record_id, $data) {
        // 這裡可以實現日誌記錄功能
        // 可以寫入檔案或資料庫
        $log_data = [
            'action' => $action,
            'record_id' => $record_id,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        
        // 實際的日誌寫入邏輯可在此處實現
    }

    /**
     * 記錄錯誤日誌
     * @param string $type 錯誤類型
     * @param string $message 錯誤訊息
     * @param array $context 上下文資料
     */
    private function log_error($type, $message, $context) {
        $error_data = [
            'type' => $type,
            'message' => $message,
            'context' => $context,
            'timestamp' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        
        // 實際的錯誤日誌寫入邏輯可在此處實現
    }

    /**
     * 通知表單已建立
     * @param int $submission_id 提交ID
     * @param array $data 表單資料
     */
    private function notify_submission_created($submission_id, $data) {
        // 這裡可以實現通知功能
        // 例如發送郵件、推送通知等
        
        // 範例：發送確認郵件
        // $this->send_confirmation_email($data['member_name'], $data['member_id']);
        
        // 範例：推送管理員通知
        // $this->notify_admin_new_submission($submission_id);
    }
}