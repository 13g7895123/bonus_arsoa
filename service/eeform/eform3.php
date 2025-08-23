<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eform3 extends MY_Service {

    protected $eform3_model;
    protected $ci;

    public function __construct() {
        parent::__construct();
        
        try {
            $this->ci = &get_instance();
            
            if (!isset($this->ci)) {
                throw new Exception('Cannot get CodeIgniter instance');
            }
            
            $this->ci->load->model('eeform/eform3', 'eform3_model');
            
            if (!isset($this->ci->eform3_model)) {
                throw new Exception('Failed to load eform3_model');
            }
            
            $this->eform3_model = $this->ci->eform3_model;
            
            // 初始化活動項目資料
            $this->eform3_model->initialize_activity_items();
            
        } catch (Exception $e) {
            log_message('error', 'Eform3 Service constructor error: ' . $e->getMessage());
            throw $e;
        }
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
        try {
            // 資料清理和預處理
            $cleaned_data = $this->clean_submission_data($data);
            
            // 建立提交記錄
            $submission_id = $this->eform3_model->create_submission($cleaned_data);
            
            if ($submission_id) {
                // 記錄操作日誌
                $this->log_operation('create_submission', $submission_id, $cleaned_data);
                
                // 可以在這裡添加其他業務邏輯，如發送通知等
                $this->notify_submission_created($submission_id, $cleaned_data);
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            // 記錄錯誤
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
        
        $result = $this->eform3_model->get_member_submissions($member_id, $page, $limit, $start_date, $end_date);
        
        // 處理返回資料，添加計算欄位
        foreach ($result['data'] as &$submission) {
            $submission['bmi'] = $this->calculate_bmi($submission['weight'] ?? null, $submission['height'] ?? null);
            $submission['submission_days_ago'] = $this->calculate_days_ago($submission['submission_date']);
        }
        
        return $result;
    }

    /**
     * 取得表單詳細資料
     * @param int $id 表單ID
     * @return array|null
     */
    public function get_submission_detail($id) {
        $submission = $this->eform3_model->get_submission_detail($id);
        
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
     * 取得活動項目列表
     * @return array
     */
    public function get_activity_items() {
        return $this->eform3_model->get_activity_items();
    }

    /**
     * 更新表單狀態
     * @param int $id 表單ID
     * @param string $status 狀態
     * @return bool
     */
    public function update_submission_status($id, $status) {
        $valid_statuses = ['draft', 'submitted', 'reviewed'];
        
        if (!in_array($status, $valid_statuses)) {
            throw new Exception('無效的狀態值');
        }
        
        $result = $this->eform3_model->update_submission_status($id, $status);
        
        if ($result) {
            $this->log_operation('update_status', $id, ['status' => $status]);
        }
        
        return $result;
    }

    /**
     * 刪除表單提交記錄
     * @param int $id 表單ID
     * @return bool
     */
    public function delete_submission($id) {
        // 先取得記錄資訊用於日誌
        $submission = $this->eform3_model->get_submission_detail($id);
        
        $result = $this->eform3_model->delete_submission($id);
        
        if ($result && $submission) {
            $this->log_operation('delete_submission', $id, $submission);
        }
        
        return $result;
    }

    /**
     * 取得會員統計資料
     * @param string $member_id 會員編號
     * @return array
     */
    public function get_member_stats($member_id) {
        $stats = $this->eform3_model->get_member_stats($member_id);
        
        // 添加額外的統計資料
        $stats['health_trends'] = $this->analyze_health_trends($member_id);
        $stats['goal_achievement'] = $this->analyze_goal_achievement($member_id);
        
        return $stats;
    }

    /**
     * 匯出提交資料
     * @param array $params 匯出參數
     * @return array|string
     */
    public function export_submissions($params) {
        $data = $this->eform3_model->export_submissions($params);
        
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
        
        // 實際的日誌寫入邏輯
        // log_message('info', 'EForm03 Operation: ' . json_encode($log_data));
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
        
        // 實際的錯誤日誌寫入邏輯
        // log_message('error', 'EForm03 Error: ' . json_encode($error_data));
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