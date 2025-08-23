<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform3 extends MY_Model {

    protected $table_submissions = 'eform03_submissions';
    protected $table_body_data = 'eform03_body_data';
    protected $table_activity_items = 'eform03_activity_items';
    protected $table_activity_records = 'eform03_activity_records';
    protected $table_plans = 'eform03_plans';

    public function __construct() {
        parent::__construct();
        
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->load->database();
    }

    /**
     * 建立表單提交記錄
     * @param array $data 表單資料
     * @return int|false 提交ID或false
     */
    public function create_submission($data) {
        $this->db->trans_start();
        
        try {
            // 插入主表單資料
            $submission_data = [
                'member_name' => $data['member_name'],
                'member_id' => $data['member_id'],
                'age' => (int)$data['age'],
                'height' => (int)$data['height'],
                'goal' => $data['goal'],
                'action_plan_1' => isset($data['action_plan_1']) ? $data['action_plan_1'] : null,
                'action_plan_2' => isset($data['action_plan_2']) ? $data['action_plan_2'] : null,
                'submission_date' => date('Y-m-d'),
                'status' => 'submitted'
            ];
            
            $this->db->insert($this->table_submissions, $submission_data);
            $submission_id = $this->db->insert_id();
            
            if (!$submission_id) {
                throw new Exception('無法建立表單提交記錄');
            }
            
            // 插入身體數據
            if (isset($data['weight']) || isset($data['blood_pressure_high']) || 
                isset($data['blood_pressure_low']) || isset($data['waist'])) {
                
                $body_data = [
                    'submission_id' => $submission_id,
                    'weight' => !empty($data['weight']) ? (float)$data['weight'] : null,
                    'blood_pressure_high' => !empty($data['blood_pressure_high']) ? (int)$data['blood_pressure_high'] : null,
                    'blood_pressure_low' => !empty($data['blood_pressure_low']) ? (int)$data['blood_pressure_low'] : null,
                    'waist' => !empty($data['waist']) ? (float)$data['waist'] : null
                ];
                
                $this->db->insert($this->table_body_data, $body_data);
            }
            
            // 插入活動記錄
            $activity_fields = ['hand_measure', 'exercise', 'health_supplement', 'weika', 'water_intake'];
            foreach ($activity_fields as $field) {
                if (isset($data[$field]) && $data[$field]) {
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
                if (!empty($data[$field])) {
                    $plan_data = [
                        'submission_id' => $submission_id,
                        'plan_type' => $plan_type,
                        'plan_content' => $data[$field],
                        'status' => 'pending'
                    ];
                    
                    $this->db->insert($this->table_plans, $plan_data);
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('交易失敗');
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
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
}