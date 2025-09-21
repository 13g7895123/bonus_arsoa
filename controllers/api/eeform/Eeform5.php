<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        
        // 允許跨域請求
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // 設定編碼和JSON回應
        header('Content-Type: application/json; charset=utf-8');
        $this->output->set_content_type('application/json; charset=utf-8');

        try {
            $this->load->model('eeform/Eeform5Model', 'eform5_model');
        } catch (Exception $e) {
            $this->_send_error('Failed to load eform5 model: ' . $e->getMessage(), 500);
            exit();
        }
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
            if (!$this->eform5_model->check_table_exists()) {
                log_message('info', 'Creating eeform5 tables...');
                $this->eform5_model->create_tables();
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

            // 檢查是否為更新操作（從編輯功能來的請求會有此標識）
            $is_update = isset($input_data['is_update']) && $input_data['is_update'] === true;
            
            if ($is_update) {
                log_message('info', 'This is an update operation from edit function, redirecting...');
                // 如果是更新操作，應該通過 submission/{id} endpoint 而不是 submit
                throw new Exception('更新操作請使用 submission/{id} endpoint');
            }

            // 驗證必要欄位
            $required_fields = ['phone'];
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
            $result = $this->eform5_model->submit_form($form_data);

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

            if (!$this->eform5_model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            $submission = $this->eform5_model->get_submission_by_id($id);
            
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
     * 取得表單提交記錄
     * GET /api/eeform/eeform5/submissions/{member_id}
     */
    public function submissions($member_id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$member_id) {
                $this->_send_error('缺少會員編號', 400);
                return;
            }

            $submissions = $this->eform5_model->get_submissions_by_member($member_id);
            
            $this->_send_success('取得提交記錄成功', [
                'member_id' => $member_id,
                'data' => $submissions,
                'total' => count($submissions)
            ]);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得表單列表
     */
    public function list()
    {
        try {
            if (!$this->eform5_model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            $page = intval($this->input->get('page') ?? 1);
            $limit = intval($this->input->get('limit') ?? 20);
            $search = $this->input->get('search');
            $status = $this->input->get('status');
            $date_from = $this->input->get('date_from');
            $date_to = $this->input->get('date_to');

            $result = $this->eform5_model->get_all_submissions_paginated($page, $limit, $search, $status, $date_from, $date_to);
            
            // 驗證 model 回傳的資料結構
            if (!$result || !is_array($result)) {
                throw new Exception('Model 回傳無效的資料結構');
            }
            
            if (!isset($result['data']) || !isset($result['total']) || !isset($result['page']) || !isset($result['total_pages']) || !isset($result['limit'])) {
                throw new Exception('Model 回傳的資料結構不完整: ' . json_encode(array_keys($result)));
            }

            $response = array(
                'success' => true,
                'data' => array(
                    'data' => $result['data'],
                    'pagination' => array(
                        'current_page' => $result['page'],
                        'total_pages' => $result['total_pages'],
                        'total' => $result['total'],
                        'per_page' => $result['limit']
                    )
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

            if (!$this->eform5_model->check_table_exists()) {
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

            $result = $this->eform5_model->update_status($id, $input_data['status']);

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
            'table_exists' => $this->eform5_model->check_table_exists()
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

            if ($this->eform5_model->check_table_exists()) {
                throw new Exception('資料表已存在');
            }

            $result = $this->eform5_model->create_tables();

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
            if (!$this->eform5_model->check_table_exists()) {
                log_message('info', 'Creating eeform5 tables for testing...');
                $this->eform5_model->create_tables();
            }

            // 準備完整測試資料
            $test_data = array(
                'member_name' => '測試公司',
                'member_id' => 'TEST001',
                'phone' => '0912345678',
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
                'occupation' => array('上班族', '自由業'),
                'health_concerns' => array('睡眠不佳', '免疫力', '體重困擾'),
                'recommended_products' => array('活力精萃', '白鶴靈芝EX', '美力C錠'),
                'product_dosages' => array(
                    'energy_essence_dosage' => '每日1包',
                    'reishi_ex_dosage' => '每日2粒',
                    'vitamin_c_dosage' => '每日1錠'
                )
            );

            log_message('info', 'Eeform5 comprehensive test data: ' . print_r($test_data, true));

            // 提交測試資料
            $result = $this->eform5_model->submit_form($test_data);

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

    /**
     * 取得單一表單詳細資料 (別名方法，用於前端相容性)
     * GET /api/eeform/eeform5/submission/{id}
     */
    public function submission($id = null) {
        // 根據HTTP方法決定執行動作
        if ($this->input->method() === 'get') {
            // GET請求：獲取資料
            return $this->get($id);
        } elseif ($this->input->method() === 'post') {
            // POST請求：更新資料
            return $this->update_submission($id);
        } else {
            $this->_send_error('不支援的HTTP方法', 405);
        }
    }

    /**
     * 更新表單資料（用於編輯功能）
     * POST /api/eeform/eeform5/submission/{id}
     */
    private function update_submission($id = null) {
        try {
            if (!$id || !is_numeric($id)) {
                throw new Exception('缺少有效的表單ID');
            }

            if (!$this->eform5_model->check_table_exists()) {
                throw new Exception('資料表不存在');
            }

            // 取得POST資料
            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                // 如果JSON解析失敗，嘗試從POST取得
                $input_data = $this->input->post();
            }

            if (empty($input_data)) {
                throw new Exception('缺少更新資料');
            }

            // 添加更新標識，與提交功能區分
            $input_data['is_update'] = true;
            $input_data['updated_at'] = date('Y-m-d H:i:s');

            // 先檢查記錄是否存在
            $existing = $this->eform5_model->get_submission_by_id($id);
            if (!$existing) {
                throw new Exception('找不到指定的表單記錄');
            }

            // 更新記錄
            $result = $this->eform5_model->update_submission($id, $input_data);

            if ($result['success']) {
                $this->_send_success('表單更新成功', array('submission_id' => $id));
            } else {
                throw new Exception($result['message']);
            }

        } catch (Exception $e) {
            log_message('error', 'Eeform5 update submission error: ' . $e->getMessage());
            $this->_send_error('更新失敗：' . $e->getMessage(), 500);
        }
    }

    /**
     * 匯出單一表單到Excel
     * GET /api/eeform/eeform5/export_single/{id}
     */
    public function export_single($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id || !is_numeric($id)) {
                $this->_send_error('缺少有效的表單ID', 400);
                return;
            }

            $submission = $this->eform5_model->get_submission_by_id($id);            
            
            if (!$submission) {
                $this->_send_error('找不到指定的表單記錄', 404);
                return;
            }

            // 使用 PHPExcel 創建真正的 Excel 檔案 (欄位值格式)
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();
            
            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('個人體測表+健康諮詢表管理');
            
            $status_map = [
                'submitted' => '已提交',
                'processing' => '處理中', 
                'completed' => '已完成',
                'cancelled' => '已取消'
            ];
            
            // 設定欄位寬度 (A欄:欄位名稱, B欄:值)
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
            
            $row = 1;
            
            // 表單標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '個人體測表+健康諮詢表');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('006f42c1');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true)->setColor(new PHPExcel_Style_Color('FFFFFFFF'));
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            // 空行
            $row++;
            
            // 基本資料標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '基本資料');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00D9EDF7');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            // 基本資料欄位
            $basic_fields = [
                'ID' => $submission['id'],
                '會員姓名' => $submission['member_name'] ?? '',
                '會員編號' => $submission['member_id'] ?? '',
                '手機號碼' => $submission['phone'] ?? '',
                '性別' => $submission['gender'] ?? '',
                '年齡' => isset($submission['age']) ? $submission['age'] . ' 歲' : '',
                '身高' => isset($submission['height']) ? $submission['height'] . ' cm' : '',
                '運動習慣' => $submission['exercise_habit'] ?? ''
            ];
            
            foreach ($basic_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
            }
            
            // 空行
            $row++;
            
            // 體測標準建議值標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '體測標準建議值');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00D9EDF7');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            // 體測數據欄位
            $body_test_fields = [
                '體重' => isset($submission['weight']) ? $submission['weight'] . ' Kg' : '',
                'BMI' => $submission['bmi'] ?? '',
                '脂肪率' => isset($submission['fat_percentage']) ? $submission['fat_percentage'] . ' %' : '',
                '脂肪量' => isset($submission['fat_mass']) ? $submission['fat_mass'] . ' Kg' : '',
                '肌肉百分比' => isset($submission['muscle_percentage']) ? $submission['muscle_percentage'] . ' %' : '',
                '肌肉量' => isset($submission['muscle_mass']) ? $submission['muscle_mass'] . ' Kg' : '',
                '水份比例' => isset($submission['water_percentage']) ? $submission['water_percentage'] . ' %' : '',
                '水含量' => isset($submission['water_content']) ? $submission['water_content'] . ' Kg' : '',
                '內臟脂肪率' => isset($submission['visceral_fat_percentage']) ? $submission['visceral_fat_percentage'] . ' %' : '',
                '骨量' => isset($submission['bone_mass']) ? $submission['bone_mass'] . ' Kg' : '',
                '基礎代謝率' => isset($submission['bmr']) ? $submission['bmr'] . ' 卡' : '',
                '蛋白質' => isset($submission['protein_percentage']) ? $submission['protein_percentage'] . ' %' : '',
                '肥胖度' => isset($submission['obesity_percentage']) ? $submission['obesity_percentage'] . ' %' : '',
                '身體年齡' => isset($submission['body_age']) ? $submission['body_age'] . ' 歲' : '',
                '去脂體重' => isset($submission['lean_body_mass']) ? $submission['lean_body_mass'] . ' KG' : ''
            ];
            
            foreach ($body_test_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
            }
            
            // 空行
            $row++;
            
            // 職業資訊標題
            if (isset($submission['occupations']) && !empty($submission['occupations'])) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '職業資訊');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D9EDF7');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                $occupations = [];
                foreach ($submission['occupations'] as $occupation) {
                    $occupations[] = $occupation['occupation_type'];
                }
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '職業');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, implode(', ', $occupations));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
                
                // 空行
                $row++;
            }
            
            // 健康困擾標題
            if (isset($submission['health_concerns']) && !empty($submission['health_concerns'])) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '健康困擾');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D9EDF7');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                $concerns = [];
                foreach ($submission['health_concerns'] as $concern) {
                    $concerns[] = $concern['concern_type'];
                }
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '健康困擾');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, implode(', ', $concerns));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
                
                // 其他健康困擾
                if (!empty($submission['health_concerns_other'])) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '其他健康困擾');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $submission['health_concerns_other']);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }
                
                // 空行
                $row++;
            }
            
            // 建議產品標題
            if (isset($submission['products']) && !empty($submission['products'])) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '建議產品');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D9EDF7');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                foreach ($submission['products'] as $product) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $product['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $product['recommended_dosage'] ?? '');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }
                
                // 空行
                $row++;
            }

            // 其他資訊標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '其他資訊');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00D9EDF7');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            $other_fields = [
                '長期用藥習慣' => ($submission['has_medication_habit'] == 1) ? '有' : '無',
                '使用藥物名稱' => $submission['medication_name'] ?? '',
                '家族慢性病史' => ($submission['has_family_disease_history'] == 1) ? '有' : '無',
                '疾病名稱' => $submission['disease_name'] ?? '',
                '微循環檢測結果' => $submission['microcirculation_test'] ?? '',
                '日常飲食建議' => $submission['dietary_advice'] ?? '',
                '填寫日期' => $submission['submission_date'] ?? ''
            ];
            
            foreach ($other_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                if (in_array($field, ['微循環檢測結果', '日常飲食建議'])) {
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
                }
                $row++;
            }
            
            // 設定對齊方式
            $objPHPExcel->getActiveSheet()->getStyle('A1:B'.($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            
            $filename = 'eeform5_' . $submission['member_name'] . '_' . date('YmdHis');
            
            // 創建Excel2007格式的Writer
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            
            // 設定Headers
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            
            // 輸出到瀏覽器
            $objWriter->save("php://output");
            
            // 清理記憶體
            $objPHPExcel->disconnectWorksheets();
            unset($objWriter, $objPHPExcel);
            exit();

        } catch (Exception $e) {
            $this->_send_error('匯出表單失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 依據會員資料匯出分組表單 (Excel格式)
     * GET /api/eeform5/export_grouped?member_name=xxx&member_id=xxx
     */
    public function export_grouped() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $member_name = $this->input->get('member_name');
            $member_id = $this->input->get('member_id');

            if (!$member_name && !$member_id) {
                $this->_send_error('必須提供會員姓名或會員編號', 400);
                return;
            }

            $submissions = $this->eform5_model->get_submissions_by_member_info($member_name, $member_id);

            if (empty($submissions)) {
                $this->_send_error('找不到符合條件的表單記錄', 404);
                return;
            }

            // 使用 PHPExcel 創建真正的 Excel 檔案 (分組表單格式)
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();

            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('會員表單匯出');

            // 設定欄位寬度 (A欄:欄位名稱, B欄:值)
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);

            $row = 1;

            // 總標題
            $title = '會員表單匯出';
            if ($member_name && $member_id) {
                $title .= " - {$member_name} ({$member_id})";
            } else if ($member_name) {
                $title .= " - {$member_name}";
            } else if ($member_id) {
                $title .= " - {$member_id}";
            }

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $title);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('004472C4');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true)->setColor(new PHPExcel_Style_Color('FFFFFFFF'));
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;

            // 空行
            $row++;

            // 匯出統計
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '匯出資訊');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, '共找到 ' . count($submissions) . ' 筆表單記錄');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
            $row++;

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '匯出時間');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, date('Y-m-d H:i:s'));
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
            $row++;

            // 空行
            $row++;

            foreach ($submissions as $index => $item) {
                // 每一筆資料分區顯示
                if ($index > 0) {
                    // 在每筆資料之間加上分隔線
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '==========================================');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00E0E0E0');
                    $row++;
                }

                // 表單標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '會員服務追蹤管理表(體測) - 第'.($index+1).'筆');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('004472C4');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true)->setColor(new PHPExcel_Style_Color('FFFFFFFF'));
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;

                // 空行
                $row++;

                // 基本資料標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '基本資料');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D9EDF7');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;

                // 基本資料欄位
                $basic_fields = [
                    'ID' => $item['id'] ?? '',
                    '會員姓名' => $item['member_name'] ?? '',
                    '會員編號' => $item['member_id'] ?? '',
                    '電話' => $item['phone'] ?? '',
                    '性別' => $item['gender'] ?? '',
                    '年齡' => isset($item['age']) ? $item['age'] . ' 歲' : '',
                    '身高' => isset($item['height']) ? $item['height'] . ' cm' : '',
                    '運動習慣' => $item['exercise_habit'] ?? ''
                ];

                foreach ($basic_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }

                // 空行
                $row++;

                // 體測數據標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '體測數據');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D4EDDA');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;

                $body_fields = [
                    '體重' => isset($item['weight']) ? $item['weight'] . ' kg' : '',
                    'BMI' => $item['bmi'] ?? '',
                    '體脂肪率' => isset($item['fat_percentage']) ? $item['fat_percentage'] . ' %' : '',
                    '體脂肪量' => isset($item['fat_mass']) ? $item['fat_mass'] . ' kg' : '',
                    '肌肉率' => isset($item['muscle_percentage']) ? $item['muscle_percentage'] . ' %' : '',
                    '肌肉量' => isset($item['muscle_mass']) ? $item['muscle_mass'] . ' kg' : '',
                    '水分率' => isset($item['water_percentage']) ? $item['water_percentage'] . ' %' : '',
                    '水分含量' => isset($item['water_content']) ? $item['water_content'] . ' kg' : '',
                    '內臟脂肪率' => isset($item['visceral_fat_percentage']) ? $item['visceral_fat_percentage'] . ' %' : '',
                    '骨量' => isset($item['bone_mass']) ? $item['bone_mass'] . ' kg' : '',
                    '基礎代謝率' => isset($item['bmr']) ? $item['bmr'] . ' kcal' : '',
                    '蛋白質率' => isset($item['protein_percentage']) ? $item['protein_percentage'] . ' %' : '',
                    '肥胖度' => isset($item['obesity_percentage']) ? $item['obesity_percentage'] . ' %' : '',
                    '體年齡' => isset($item['body_age']) ? $item['body_age'] . ' 歲' : '',
                    '去脂體重' => isset($item['lean_body_mass']) ? $item['lean_body_mass'] . ' kg' : ''
                ];

                foreach ($body_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }

                // 空行
                $row++;

                // 用藥習慣標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '用藥習慣');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00FFF3CD');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;

                $medication_fields = [
                    '是否有用藥習慣' => ($item['has_medication_habit'] ?? '') == '1' ? '是' : '否',
                    '藥物名稱' => $item['medication_name'] ?? ''
                ];

                foreach ($medication_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }

                // 空行
                $row++;

                // 表單資訊標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '表單資訊');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00F8D7DA');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;

                $form_fields = [
                    '提交時間' => $item['created_at'] ?? '',
                    '更新時間' => $item['updated_at'] ?? ''
                ];

                foreach ($form_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }

                // 空行
                $row++;
            }

            // 設定對齊方式
            $objPHPExcel->getActiveSheet()->getStyle('A1:B'.($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

            // 構建檔案名稱
            $filename = 'eform05_分組匯出_';
            if ($member_name && $member_id) {
                $filename .= $member_name . '_' . $member_id;
            } else if ($member_name) {
                $filename .= $member_name;
            } else if ($member_id) {
                $filename .= $member_id;
            }
            $filename .= '_' . date('Y-m-d_H-i-s');

            // 創建Excel2007格式的Writer
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // 設定Headers
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');

            // 輸出到瀏覽器
            $objWriter->save("php://output");

            // 清理記憶體
            $objPHPExcel->disconnectWorksheets();
            unset($objWriter, $objPHPExcel);
            exit();

        } catch (Exception $e) {
            $this->_send_error('匯出分組表單失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 發送成功回應
     * @param string $message 
     * @param mixed $data 
     * @param int $code 
     */
    private function _send_success($message = 'Success', $data = null, $code = 200) {
        $response = [
            'success' => true,
            'code' => $code,
            'message' => $message
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        $response['timestamp'] = date('Y-m-d H:i:s');
        
        $this->output
            ->set_status_header($code)
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 發送錯誤回應
     * @param string $message 
     * @param int $code 
     * @param mixed $errors 
     */
    private function _send_error($message = 'Error', $code = 500, $errors = null) {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $message
        ];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        $response['timestamp'] = date('Y-m-d H:i:s');
        
        $this->output
            ->set_status_header($code)
            ->set_output(json_encode($response, JSON_UNESCAPED_UNICODE));
    }
}