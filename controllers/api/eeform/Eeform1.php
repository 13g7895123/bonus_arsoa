<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform1 extends MY_Controller
{
    public function __construct()
    {
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        // Set JSON response headers early
        header('Content-Type: application/json');
        
        // Enable CORS for API requests
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // Handle preflight OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
        
        // Simplified constructor for debugging
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_mssql_model' );
        
        // Try loading with error handling
        try {
            $this->load->model('eeform/Eeform1Model', 'eform1_model');
        } catch (Exception $e) {
            echo json_encode([
                'error' => 'Model loading exception',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit;
        }
        
        // Verify model is loaded
        if (!isset($this->eform1_model)) {
            echo json_encode([
                'error' => 'Model loading failed',
                'debug' => 'Eeform1Model could not be loaded after load attempt'
            ]);
            exit;
        }
        $this->load->library( 'user_agent' );
        $this->load->helper('url');
    }

    /**
     * Test endpoint to verify controller accessibility
     * GET /api/eeform1/test
     */
    public function test() {
        // Test if model is loaded and working
        if (method_exists($this->eform1_model, 'validate_submission_data')) {
            $model_status = 'Model loaded with validate_submission_data method';
        } else {
            $model_status = 'Model loaded but missing expected methods';
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Eeform1 controller is accessible',
            'controller' => 'Eeform1',
            'method' => 'test',
            'model_status' => $model_status,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }

    /**
     * API健康檢查
     * GET /api/eeform1/health
     */
    public function health() {
        try {
            $health_data = [
                'status' => 'OK',
                'service' => 'Eeform1 API',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'ci_version' => CI_VERSION,
                'memory_usage' => memory_get_usage(true),
                'request_info' => [
                    'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                    'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
                ]
            ];
            
            $this->_send_success('Eeform1 API Health Check', $health_data);
        } catch (Exception $e) {
            $this->_send_error('Health check failed: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 提交肌膚諮詢記錄表單
     * POST /api/eeform1/submit
     */
    public function submit() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 檢查model是否正確載入
            if (!isset($this->eform1_model)) {
                $this->_send_error('eform1_model not loaded', 500, [
                    'debug' => 'Model not available in controller',
                    'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                    'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
                    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'unknown'
                ]);
                return;
            }

            // 取得POST資料
            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);
            
            if (!$input_data) {
                $input_data = $this->input->post();
            }
            
            if (empty($input_data)) {
                $this->_send_error('沒有接收到資料', 400, [
                    'raw_input' => $raw_input,
                    'post_data' => $this->input->post(),
                    'get_data' => $this->input->get(),
                    'json_last_error' => json_last_error_msg()
                ]);
                return;
            }

            // 驗證必填欄位
            try {
                $validation_result = $this->eform1_model->validate_submission_data($input_data);
            } catch (Exception $e) {
                $this->_send_error('驗證錯誤: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                return;
            }
            
            if (!$validation_result['valid']) {
                $this->_send_error('資料驗證失敗', 400, $validation_result['errors']);
                return;
            }

            // 提交表單資料
            try {
                $submission_id = $this->eform1_model->create_submission($input_data);
            } catch (Exception $e) {
                $this->_send_error('建立提交記錄失敗: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'input_data' => $input_data
                ]);
                return;
            }
            
            if ($submission_id) {
                $this->_send_success('肌膚諮詢記錄表提交成功', [
                    'submission_id' => $submission_id,
                    'submission_date' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->_send_error('表單提交失敗', 500, [
                    'debug' => 'create_submission returned false',
                    'input_data' => $input_data
                ]);
            }

        } catch (Exception $e) {
            $this->_send_error('表單提交失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        } catch (Throwable $e) {
            $this->_send_error('致命錯誤: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 取得表單提交記錄
     * GET /api/eeform1/submissions/{member_id}
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

            // Add debugging for the member_id received
            $debug_info = [
                'member_id_received' => $member_id,
                'member_id_length' => strlen($member_id),
                'member_id_type' => gettype($member_id)
            ];

            // 取得查詢參數
            $page = (int)$this->input->get('page') ?: 1;
            $limit = (int)$this->input->get('limit') ?: 10;
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $submissions = $this->eform1_model->get_member_submissions(
                $member_id, 
                $page, 
                $limit, 
                $start_date, 
                $end_date
            );

            $this->_send_success('取得肌膚諮詢記錄成功', $submissions);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'debug_info' => $debug_info ?? null
            ]);
        }
    }

    /**
     * 取得單一表單詳細資料 (GET) 或更新表單資料 (POST)
     * GET /api/eeform1/submission/{id}
     * POST /api/eeform1/submission/{id}
     */
    public function submission($id = null) {
        try {
            $method = $this->input->method(TRUE);
            
            if ($method === 'GET') {
                // 取得表單詳細資料
                if (!$id) {
                    $this->_send_error('缺少表單ID', 400);
                    return;
                }

                $submission = $this->eform1_model->get_submission_detail($id);
                
                if ($submission) {
                    // Debug: 檢查skin_scores資料結構
                    error_log('API submission response debug for ID ' . $id . ':');
                    error_log('skin_scores count: ' . (isset($submission['skin_scores']) ? count($submission['skin_scores']) : 0));
                    error_log('moisture_scores count: ' . (isset($submission['moisture_scores']) ? count($submission['moisture_scores']) : 0));
                    if (isset($submission['skin_scores']) && !empty($submission['skin_scores'])) {
                        error_log('skin_scores sample: ' . json_encode(array_slice($submission['skin_scores'], 0, 3)));
                    }
                    
                    $this->_send_success('取得表單詳細資料成功', $submission);
                } else {
                    $this->_send_error('找不到指定的表單', 404);
                }
                
            } elseif ($method === 'POST') {
                // 更新表單資料
                if (!$id) {
                    $this->_send_error('缺少表單ID', 400);
                    return;
                }

                // 取得POST資料
                $raw_input = $this->input->raw_input_stream;
                $input_data = json_decode($raw_input, true);
                
                if (!$input_data) {
                    $input_data = $this->input->post();
                }
                
                if (empty($input_data)) {
                    $this->_send_error('沒有接收到資料', 400, [
                        'raw_input' => $raw_input,
                        'post_data' => $this->input->post(),
                        'json_last_error' => json_last_error_msg()
                    ]);
                    return;
                }

                // 驗證資料
                $validation_result = $this->eform1_model->validate_submission_data($input_data);
                if (!$validation_result['valid']) {
                    $this->_send_error('資料驗證失敗', 400, $validation_result['errors']);
                    return;
                }

                // 更新表單資料
                $result = $this->eform1_model->update_submission($id, $input_data);
                
                if ($result) {
                    $this->_send_success('表單更新成功', ['submission_id' => $id]);
                } else {
                    $this->_send_error('表單更新失敗', 500);
                }
                
            } else {
                $this->_send_error('Method not allowed', 405);
                return;
            }

        } catch (Exception $e) {
            $this->_send_error('操作失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 更新表單資料
     * POST /api/eeform1/update/{id}
     */
    public function update($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少表單ID', 400);
                return;
            }

            // 取得POST資料
            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);
            
            if (!$input_data) {
                $input_data = $this->input->post();
            }
            
            if (empty($input_data)) {
                $this->_send_error('沒有接收到資料', 400, [
                    'raw_input' => $raw_input,
                    'post_data' => $this->input->post(),
                    'json_last_error' => json_last_error_msg()
                ]);
                return;
            }

            // 驗證資料
            $validation_result = $this->eform1_model->validate_submission_data($input_data);
            if (!$validation_result['valid']) {
                $this->_send_error('資料驗證失敗', 400, $validation_result['errors']);
                return;
            }

            // 更新表單資料
            $result = $this->eform1_model->update_submission($id, $input_data);
            
            if ($result) {
                $this->_send_success('表單更新成功', ['submission_id' => $id]);
            } else {
                $this->_send_error('表單更新失敗', 500);
            }

        } catch (Exception $e) {
            $this->_send_error('更新操作失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 取得會員統計資料
     * GET /api/eeform1/stats/{member_id}
     */
    public function stats($member_id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$member_id) {
                $this->_send_error('缺少會員編號', 400);
                return;
            }

            $stats = $this->eform1_model->get_member_stats($member_id);
            $this->_send_success('取得統計資料成功', $stats);

        } catch (Exception $e) {
            $this->_send_error('取得統計資料失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得管理員列表資料 (分頁)
     * GET /api/eeform1/list
     */
    public function list() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 驗證模型是否正確載入
            if (!isset($this->eform1_model)) {
                $this->_send_error('Model not loaded', 500, [
                    'debug' => 'eform1_model is not available'
                ]);
                return;
            }

            // 驗證模型方法是否存在
            if (!method_exists($this->eform1_model, 'get_all_submissions_paginated')) {
                $this->_send_error('Model method not found', 500, [
                    'debug' => 'get_all_submissions_paginated method does not exist'
                ]);
                return;
            }

            // 取得查詢參數
            $page = (int)$this->input->get('page') ?: 1;
            $limit = (int)$this->input->get('limit') ?: 20;
            $search = $this->input->get('search');
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            
            // 參數驗證
            if ($page < 1) $page = 1;
            if ($limit < 1 || $limit > 100) $limit = 20;

            log_message('debug', 'Eeform1::list called with params: ' . json_encode([
                'page' => $page,
                'limit' => $limit,
                'search' => $search,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]));

            $results = $this->eform1_model->get_all_submissions_paginated(
                $page, 
                $limit, 
                $search,
                $start_date, 
                $end_date
            );

            if (!$results) {
                $this->_send_error('No results returned from model', 500);
                return;
            }

            $this->_send_success('取得列表資料成功', $results);

        } catch (Exception $e) {
            log_message('error', 'Eeform1::list exception: ' . $e->getMessage());
            log_message('error', 'Eeform1::list trace: ' . $e->getTraceAsString());
            
            $this->_send_error('取得列表資料失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'model_loaded' => isset($this->eform1_model),
                'method_exists' => method_exists($this->eform1_model ?? null, 'get_all_submissions_paginated')
            ]);
        }
    }

    /**
     * 匯出單一表單
     * GET /api/eeform1/export_single/{id}
     */
    public function export_single($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少表單ID', 400);
                return;
            }

            // 取得表單詳細資料
            $submission = $this->eform1_model->get_submission_detail($id);
            
            if (!$submission) {
                $this->_send_error('找不到指定的表單', 404);
                return;
            }

            // 載入 PHPSpreadsheet
            $this->load->library('excel');
            
            // 建立新的試算表
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('肌膚諮詢記錄表');

            // 設定表頭
            $sheet->setCellValue('A1', '肌膚諮詢記錄表');
            $sheet->mergeCells('A1:B1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            
            $row = 3;
            
            // 基本資料
            $sheet->setCellValue('A' . $row, '會員姓名');
            $sheet->setCellValue('B' . $row, $submission['member_name'] ?? '');
            $row++;
            
            $sheet->setCellValue('A' . $row, '出生年月');
            $sheet->setCellValue('B' . $row, ($submission['birth_year'] ?? '') . '年' . ($submission['birth_month'] ?? '') . '月');
            $row++;
            
            $sheet->setCellValue('A' . $row, '電話');
            $sheet->setCellValue('B' . $row, $submission['phone'] ?? '');
            $row++;
            
            // 職業
            if (isset($submission['occupations']) && is_array($submission['occupations'])) {
                $occupations = [];
                $occupationMap = [
                    'service' => '服務業',
                    'office' => '上班族', 
                    'restaurant' => '餐飲業',
                    'housewife' => '家管'
                ];
                foreach ($submission['occupations'] as $occ) {
                    if ($occ['is_selected'] == 1) {
                        $occupations[] = $occupationMap[$occ['occupation_type']] ?? $occ['occupation_type'];
                    }
                }
                $sheet->setCellValue('A' . $row, '職業');
                $sheet->setCellValue('B' . $row, implode('、', $occupations));
                $row++;
            }
            
            // 生活習慣
            if (isset($submission['lifestyle']) && is_array($submission['lifestyle'])) {
                $lifestyle = [];
                foreach ($submission['lifestyle'] as $item) {
                    if ($item['is_selected'] == 1) {
                        $lifestyle[] = $item['category'] . ': ' . $item['item_key'];
                    }
                }
                $sheet->setCellValue('A' . $row, '生活習慣');
                $sheet->setCellValue('B' . $row, implode('、', $lifestyle));
                $row++;
            }
            
            // 使用產品
            if (isset($submission['products']) && is_array($submission['products'])) {
                $products = [];
                $productMap = [
                    'honey_soap' => '蜜皂',
                    'mud_mask' => '泥膜',
                    'toner' => '化妝水',
                    'serum' => '精華液',
                    'premium' => '極緻系列',
                    'sunscreen' => '防曬',
                    'other' => '其他'
                ];
                foreach ($submission['products'] as $prod) {
                    if ($prod['is_selected'] == 1) {
                        $productName = $productMap[$prod['product_type']] ?? $prod['product_type'];
                        if ($prod['product_type'] === 'other' && $prod['product_name']) {
                            $productName .= ': ' . $prod['product_name'];
                        }
                        $products[] = $productName;
                    }
                }
                $sheet->setCellValue('A' . $row, '使用產品');
                $sheet->setCellValue('B' . $row, implode('、', $products));
                $row++;
            }
            
            // 肌膚困擾
            if (isset($submission['skin_issues']) && is_array($submission['skin_issues'])) {
                $issues = [];
                $issueMap = [
                    'elasticity' => '沒有彈性',
                    'luster' => '沒有光澤',
                    'dull' => '暗沉',
                    'spots' => '斑點',
                    'pores' => '毛孔粗大',
                    'acne' => '痘痘粉刺',
                    'wrinkles' => '皺紋細紋',
                    'rough' => '粗糙',
                    'irritation' => '癢、紅腫',
                    'dry' => '乾燥',
                    'makeup' => '上妝不服貼',
                    'other' => '其他'
                ];
                foreach ($submission['skin_issues'] as $issue) {
                    if ($issue['is_selected'] == 1) {
                        $issueName = $issueMap[$issue['issue_type']] ?? $issue['issue_type'];
                        if ($issue['issue_type'] === 'other' && $issue['issue_description']) {
                            $issueName .= ': ' . $issue['issue_description'];
                        }
                        $issues[] = $issueName;
                    }
                }
                $sheet->setCellValue('A' . $row, '肌膚困擾');
                $sheet->setCellValue('B' . $row, implode('、', $issues));
                $row++;
            }
            
            // 過敏狀況
            if (isset($submission['allergies']) && is_array($submission['allergies'])) {
                $allergies = [];
                $allergyMap = [
                    'frequent' => '經常',
                    'seasonal' => '偶爾(換季時)',
                    'never' => '不會'
                ];
                foreach ($submission['allergies'] as $allergy) {
                    if ($allergy['is_selected'] == 1) {
                        $allergies[] = $allergyMap[$allergy['allergy_type']] ?? $allergy['allergy_type'];
                    }
                }
                $sheet->setCellValue('A' . $row, '過敏狀況');
                $sheet->setCellValue('B' . $row, implode('、', $allergies));
                $row++;
            }
            
            // 建議內容
            if (isset($submission['suggestions'])) {
                $sheet->setCellValue('A' . $row, '化妝水建議');
                $sheet->setCellValue('B' . $row, $submission['suggestions']['toner_suggestion'] ?? '');
                $row++;
                
                $sheet->setCellValue('A' . $row, '精華液建議');
                $sheet->setCellValue('B' . $row, $submission['suggestions']['serum_suggestion'] ?? '');
                $row++;
                
                $sheet->setCellValue('A' . $row, '建議內容');
                $sheet->setCellValue('B' . $row, $submission['suggestions']['suggestion_content'] ?? '');
                $row++;
            }
            
            // 肌膚檢測
            $sheet->setCellValue('A' . $row, '肌膚類型');
            $skinTypeMap = [
                'normal' => '中性',
                'combination' => '混合性',
                'oily' => '油性',
                'dry' => '乾性',
                'sensitive' => '敏感性'
            ];
            $sheet->setCellValue('B' . $row, $skinTypeMap[$submission['skin_type']] ?? $submission['skin_type'] ?? '');
            $row++;
            
            $sheet->setCellValue('A' . $row, '肌膚年齡');
            $sheet->setCellValue('B' . $row, ($submission['skin_age'] ?? '') . '歲');
            $row++;
            
            // 提交資訊
            $sheet->setCellValue('A' . $row, '提交日期');
            $sheet->setCellValue('B' . $row, $submission['submission_date'] ?? '');
            $row++;

            // 調整欄位寬度
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(50);

            // 設定檔案名稱
            $filename = '肌膚諮詢記錄表_' . ($submission['member_name'] ?? 'ID' . $id) . '_' . date('Y-m-d') . '.xlsx';
            
            // 輸出檔案
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            $this->_send_error('匯出失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 查詢會員資料
     * GET /api/eeform1/member_lookup/{member_id}
     */
    public function member_lookup($member_id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$member_id) {
                $this->_send_error('缺少會員編號', 400);
                return;
            }

            // 查詢會員資料：Select c_no, c_name from member where c_no=@x or d_spno=@x
            $this->db->select('c_no, c_name');
            $this->db->from('member');
            $this->db->group_start();
            $this->db->where('c_no', $member_id);
            $this->db->or_where('d_spno', $member_id);
            $this->db->group_end();
            
            $query = $this->db->get();
            
            if (!$query) {
                throw new Exception('Database query failed: ' . $this->db->error()['message']);
            }

            $members = $query->result_array();

            // 確保會員姓名是純淨的，但保留會員編號資料
            $clean_members = [];
            foreach ($members as $member) {
                if (!empty($member['c_name'])) {
                    $clean_members[] = [
                        'c_no' => $member['c_no'],
                        'c_name' => trim($member['c_name']) // 純姓名，無額外格式
                    ];
                }
            }
            
            // 返回查詢結果
            $result = [
                'count' => count($members),
                'members' => $clean_members,
                'search_id' => $member_id
            ];

            $this->_send_success('查詢會員資料成功', $result);

        } catch (Exception $e) {
            $this->_send_error('查詢會員資料失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
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