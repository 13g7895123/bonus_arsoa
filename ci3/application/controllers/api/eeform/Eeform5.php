<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('eeform/Eeform5Model');
        $this->load->helper('url');
        
        // 允許跨域請求
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // 設定編碼和JSON回應
        header('Content-Type: application/json; charset=utf-8');
        $this->output->set_content_type('application/json; charset=utf-8');
    }

    /**
     * 提交表單
     */
    public function submit()
    {
        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('只接受POST請求');
            }

            // 檢查並創建資料表
            if (!$this->Eeform5Model->check_table_exists()) {
                log_message('info', 'Creating eeform5 tables...');
                $this->Eeform5Model->create_tables();
            }

            // 取得POST資料
            $raw_input = $this->input->raw_input_stream;
            log_message('info', 'Eeform5 raw input: ' . $raw_input);
            
            if (empty($raw_input)) {
                // 如果沒有raw input，嘗試從POST取得
                $input_data = $this->input->post();
                if (empty($input_data)) {
                    throw new Exception('沒有接收到資料');
                }
            } else {
                $input_data = json_decode($raw_input, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    log_message('error', 'JSON decode error: ' . json_last_error_msg());
                    throw new Exception('JSON資料格式錯誤: ' . json_last_error_msg());
                }
            }

            log_message('info', 'Eeform5 submit received data: ' . print_r($input_data, true));

            // 驗證必要欄位
            $required_fields = ['name', 'phone', 'gender', 'age'];
            foreach ($required_fields as $field) {
                if (empty($input_data[$field])) {
                    throw new Exception("必填欄位 {$field} 不能為空");
                }
            }

            // 處理資料
            $form_data = array(
                'member_name' => $input_data['member_name'] ?? '公司',
                'member_id' => $input_data['member_id'] ?? '000000',
                'phone' => $input_data['phone'],
                'name' => $input_data['name'],
                'gender' => $input_data['gender'],
                'age' => intval($input_data['age']),
                'height' => $input_data['height'] ?? null,
                'exercise_habit' => $input_data['exercise_habit'] ?? null,
                
                // 體測標準建議值
                'weight' => $input_data['weight'] ?? null,
                'bmi' => $input_data['bmi'] ?? null,
                'fat_percentage' => $input_data['fat_percentage'] ?? null,
                'fat_mass' => $input_data['fat_mass'] ?? null,
                'muscle_percentage' => $input_data['muscle_percentage'] ?? null,
                'muscle_mass' => $input_data['muscle_mass'] ?? null,
                'water_percentage' => $input_data['water_percentage'] ?? null,
                'water_content' => $input_data['water_content'] ?? null,
                'visceral_fat_percentage' => $input_data['visceral_fat_percentage'] ?? null,
                'bone_mass' => $input_data['bone_mass'] ?? null,
                'bmr' => $input_data['bmr'] ?? null,
                'protein_percentage' => $input_data['protein_percentage'] ?? null,
                'obesity_percentage' => $input_data['obesity_percentage'] ?? null,
                'body_age' => $input_data['body_age'] ?? null,
                'lean_body_mass' => $input_data['lean_body_mass'] ?? null,
                
                // 其他資料
                'has_medication_habit' => intval($input_data['has_medication_habit'] ?? 0),
                'medication_name' => $input_data['medication_name'] ?? null,
                'has_family_disease_history' => intval($input_data['has_family_disease_history'] ?? 0),
                'disease_name' => $input_data['disease_name'] ?? null,
                'microcirculation_test' => $input_data['microcirculation_test'] ?? null,
                'dietary_advice' => $input_data['dietary_advice'] ?? null,
                'health_concerns_other' => $input_data['health_concerns_other'] ?? null,
                
                // 陣列資料
                'occupation' => $input_data['occupation'] ?? array(),
                'health_concerns' => $input_data['health_concerns'] ?? array(),
                'recommended_products' => $input_data['recommended_products'] ?? array(),
                'product_dosages' => $input_data['product_dosages'] ?? array()
            );

            log_message('info', 'Eeform5 processed data: ' . print_r($form_data, true));

            // 提交到資料庫
            $result = $this->Eeform5Model->submit_form($form_data);

            if ($result['success']) {
                $response = array(
                    'success' => true,
                    'message' => '表單提交成功',
                    'data' => array(
                        'submission_id' => $result['submission_id']
                    )
                );
                log_message('info', 'Eeform5 submit success: ' . $result['submission_id']);
            } else {
                throw new Exception($result['message']);
            }

        } catch (Exception $e) {
            $error_message = $e->getMessage();
            log_message('error', 'Eeform5 submit error: ' . $error_message);
            
            $response = array(
                'success' => false,
                'message' => $error_message,
                'error_code' => 'SUBMIT_ERROR'
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 取得表單資料
     */
    public function get($id = null)
    {
        try {
            if (!$id) {
                throw new Exception('缺少表單ID');
            }

            if (!$this->Eeform5Model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            $submission = $this->Eeform5Model->get_submission_by_id($id);
            
            if (!$submission) {
                throw new Exception('找不到指定的表單');
            }

            $response = array(
                'success' => true,
                'data' => $submission
            );

        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 取得表單列表
     */
    public function list()
    {
        try {
            if (!$this->Eeform5Model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            $page = intval($this->input->get('page') ?? 1);
            $limit = intval($this->input->get('limit') ?? 20);
            $search = $this->input->get('search');
            $status = $this->input->get('status');
            $date_from = $this->input->get('date_from');
            $date_to = $this->input->get('date_to');

            $result = $this->Eeform5Model->get_all_submissions_paginated($page, $limit, $search, $status, $date_from, $date_to);

            $response = array(
                'success' => true,
                'data' => $result['data'],
                'pagination' => array(
                    'current_page' => $result['page'],
                    'total_pages' => $result['total_pages'],
                    'total_records' => $result['total'],
                    'limit' => $result['limit']
                )
            );

        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 更新表單狀態
     */
    public function update_status($id = null)
    {
        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('只接受POST請求');
            }

            if (!$id) {
                throw new Exception('缺少表單ID');
            }

            if (!$this->Eeform5Model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON資料格式錯誤');
            }

            if (empty($input_data['status'])) {
                throw new Exception('缺少狀態參數');
            }

            $valid_statuses = array('draft', 'submitted', 'reviewed', 'completed');
            if (!in_array($input_data['status'], $valid_statuses)) {
                throw new Exception('無效的狀態值');
            }

            $result = $this->Eeform5Model->update_status($id, $input_data['status']);

            if ($result) {
                $response = array(
                    'success' => true,
                    'message' => '狀態更新成功'
                );
            } else {
                throw new Exception('狀態更新失敗');
            }

        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 測試API連接
     */
    public function test()
    {
        $response = array(
            'success' => true,
            'message' => 'Eeform5 API連接正常',
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $this->input->method(),
            'table_exists' => $this->Eeform5Model->check_table_exists()
        );

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 創建資料表
     */
    public function create_tables()
    {
        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('只接受POST請求');
            }

            if ($this->Eeform5Model->check_table_exists()) {
                throw new Exception('資料表已存在');
            }

            $result = $this->Eeform5Model->create_tables();

            if ($result) {
                $response = array(
                    'success' => true,
                    'message' => '資料表創建成功'
                );
            } else {
                throw new Exception('資料表創建失敗');
            }

        } catch (Exception $e) {
            $response = array(
                'success' => false,
                'message' => $e->getMessage()
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 綜合測試API - 測試所有表格資料寫入
     */
    public function comprehensive_test()
    {
        try {
            // 檢查並創建資料表
            if (!$this->Eeform5Model->check_table_exists()) {
                log_message('info', 'Creating eeform5 tables for testing...');
                $this->Eeform5Model->create_tables();
            }

            // 準備完整測試資料
            $test_data = array(
                'member_name' => '測試公司',
                'member_id' => 'TEST001',
                'phone' => '0912345678',
                'name' => '測試使用者',
                'gender' => '男',
                'age' => 30,
                'height' => 170.5,
                'exercise_habit' => '是',
                
                // 體測數據
                'weight' => 70.2,
                'bmi' => 24.3,
                'fat_percentage' => 15.8,
                'fat_mass' => 11.1,
                'muscle_percentage' => 42.5,
                'muscle_mass' => 29.9,
                'water_percentage' => 58.2,
                'water_content' => 40.8,
                'visceral_fat_percentage' => 8.5,
                'bone_mass' => 3.2,
                'bmr' => 1650,
                'protein_percentage' => 18.5,
                'obesity_percentage' => 12.3,
                'body_age' => 28,
                'lean_body_mass' => 59.1,
                
                // 其他資料
                'has_medication_habit' => 1,
                'medication_name' => '高血壓藥物',
                'has_family_disease_history' => 1,
                'disease_name' => '糖尿病',
                'microcirculation_test' => '血液循環良好，微血管通透性正常',
                'dietary_advice' => '建議多攝取蛋白質，減少糖分攝入',
                'health_concerns_other' => '偶爾失眠',
                
                // 陣列資料
                'occupation' => array('上班族', '學生'),
                'health_concerns' => array('失眠', '消化不良', '疲勞'),
                'recommended_products' => array('維他命B群', '魚油', '益生菌'),
                'product_dosages' => array(
                    'vitamin_b_complex_dosage' => '每日1粒',
                    'fish_oil_dosage' => '每日2粒',
                    'probiotics_dosage' => '每日1包'
                )
            );

            log_message('info', 'Eeform5 comprehensive test data: ' . print_r($test_data, true));

            // 提交測試資料
            $result = $this->Eeform5Model->submit_form($test_data);

            if (!$result['success']) {
                throw new Exception('資料提交失敗：' . $result['message']);
            }

            $submission_id = $result['submission_id'];

            // 驗證資料寫入正確性
            $verification = $this->verify_data_integrity($submission_id, $test_data);

            $response = array(
                'success' => true,
                'message' => '綜合測試完成',
                'data' => array(
                    'submission_id' => $submission_id,
                    'test_data' => $test_data,
                    'verification' => $verification
                ),
                'summary' => array(
                    'main_table' => $verification['main_table']['success'] ? '✓ 通過' : '✗ 失敗',
                    'occupations' => $verification['occupations']['success'] ? '✓ 通過' : '✗ 失敗',
                    'health_concerns' => $verification['health_concerns']['success'] ? '✓ 通過' : '✗ 失敗',
                    'products' => $verification['products']['success'] ? '✓ 通過' : '✗ 失敗',
                    'overall' => $verification['overall_success'] ? '✓ 全部測試通過' : '✗ 部分測試失敗'
                )
            );

        } catch (Exception $e) {
            $error_message = $e->getMessage();
            log_message('error', 'Eeform5 comprehensive test error: ' . $error_message);
            
            $response = array(
                'success' => false,
                'message' => $error_message,
                'error_code' => 'TEST_ERROR'
            );
        }

        $this->output->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 驗證資料完整性
     */
    private function verify_data_integrity($submission_id, $original_data)
    {
        $verification = array(
            'overall_success' => true,
            'main_table' => array('success' => false, 'details' => array()),
            'occupations' => array('success' => false, 'details' => array()),
            'health_concerns' => array('success' => false, 'details' => array()),
            'products' => array('success' => false, 'details' => array())
        );

        try {
            // 驗證主表資料
            $this->db->select('*');
            $this->db->from('eeform5_submissions');
            $this->db->where('id', $submission_id);
            $main_query = $this->db->get();
            
            if ($main_query->num_rows() > 0) {
                $main_data = $main_query->row_array();
                $verification['main_table']['success'] = true;
                $verification['main_table']['details'] = array(
                    'record_found' => true,
                    'member_name' => $main_data['member_name'] === $original_data['member_name'],
                    'phone' => $main_data['phone'] === $original_data['phone'],
                    'gender' => $main_data['gender'] === $original_data['gender'],
                    'age' => intval($main_data['age']) === intval($original_data['age']),
                    'weight' => floatval($main_data['weight']) === floatval($original_data['weight']),
                    'bmi' => floatval($main_data['bmi']) === floatval($original_data['bmi'])
                );
            } else {
                $verification['main_table']['details']['record_found'] = false;
                $verification['overall_success'] = false;
            }

            // 驗證職業資料
            $this->db->select('occupation_type');
            $this->db->from('eeform5_occupations');
            $this->db->where('submission_id', $submission_id);
            $occupation_query = $this->db->get();
            
            $stored_occupations = array_column($occupation_query->result_array(), 'occupation_type');
            $verification['occupations']['success'] = (count($stored_occupations) === count($original_data['occupation']));
            foreach ($original_data['occupation'] as $occupation) {
                if (!in_array($occupation, $stored_occupations)) {
                    $verification['occupations']['success'] = false;
                    break;
                }
            }
            $verification['occupations']['details'] = array(
                'expected_count' => count($original_data['occupation']),
                'actual_count' => count($stored_occupations),
                'stored_data' => $stored_occupations
            );

            // 驗證健康困擾資料
            $this->db->select('concern_type');
            $this->db->from('eeform5_health_concerns');
            $this->db->where('submission_id', $submission_id);
            $health_query = $this->db->get();
            
            $stored_concerns = array_column($health_query->result_array(), 'concern_type');
            $verification['health_concerns']['success'] = (count($stored_concerns) === count($original_data['health_concerns']));
            foreach ($original_data['health_concerns'] as $concern) {
                if (!in_array($concern, $stored_concerns)) {
                    $verification['health_concerns']['success'] = false;
                    break;
                }
            }
            $verification['health_concerns']['details'] = array(
                'expected_count' => count($original_data['health_concerns']),
                'actual_count' => count($stored_concerns),
                'stored_data' => $stored_concerns
            );

            // 驗證產品資料
            $this->db->select('product_name, recommended_dosage');
            $this->db->from('eeform5_product_recommendations');
            $this->db->where('submission_id', $submission_id);
            $product_query = $this->db->get();
            
            $stored_products = $product_query->result_array();
            $verification['products']['success'] = (count($stored_products) === count($original_data['recommended_products']));
            $verification['products']['details'] = array(
                'expected_count' => count($original_data['recommended_products']),
                'actual_count' => count($stored_products),
                'stored_data' => $stored_products
            );

            // 檢查整體成功狀態
            if (!$verification['main_table']['success'] || 
                !$verification['occupations']['success'] || 
                !$verification['health_concerns']['success'] || 
                !$verification['products']['success']) {
                $verification['overall_success'] = false;
            }

        } catch (Exception $e) {
            log_message('error', 'Data verification error: ' . $e->getMessage());
            $verification['overall_success'] = false;
            $verification['error'] = $e->getMessage();
        }

        return $verification;
    }
}