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
                // 獲取詳細的資料庫錯誤資訊
                $db_error = $this->db->error();
                $last_query = $this->db->last_query();

                $detailed_error = [
                    'debug' => 'create_submission returned false',
                    'db_error_code' => $db_error['code'],
                    'db_error_message' => $db_error['message'],
                    'last_query' => $last_query,
                    'input_data_structure' => [
                        'keys' => array_keys($input_data),
                        'identity' => isset($input_data['identity']) ? $input_data['identity'] : 'not_set',
                        'member_id' => isset($input_data['member_id']) ? $input_data['member_id'] : 'not_set',
                        'member_name' => isset($input_data['member_name']) ? $input_data['member_name'] : 'not_set'
                    ],
                    'table_check' => $this->_check_table_structure()
                ];

                error_log('API Submit Error Details: ' . json_encode($detailed_error));

                $this->_send_error('表單提交失敗 - 詳細錯誤請查看伺服器日誌', 500, $detailed_error);
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

            // 使用 PHPExcel 創建 Excel 檔案
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();

            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('肌膚諮詢記錄表');

            // 設定欄位寬度
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

            // 設定表頭
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '肌膚諮詢記錄表');
            $objPHPExcel->getActiveSheet()->mergeCells('A1:B1');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            
            $row = 3;
            
            // 基本資料
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '會員姓名');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['member_name'] ?? '');
            $row++;

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '出生年月日');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, ($submission['birth_year'] ?? '') . '年' . ($submission['birth_month'] ?? '') . '月' . ($submission['birth_day'] ?? '') . '日');
            $row++;

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '電話');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['phone'] ?? '');
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
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '職業');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, implode('、', $occupations));
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
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '生活習慣');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, implode('、', $lifestyle));
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
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '使用產品');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, implode('、', $products));
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
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '肌膚困擾');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, implode('、', $issues));
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
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '過敏狀況');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, implode('、', $allergies));
                $row++;
            }
            
            // 建議內容
            if (isset($submission['suggestions'])) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '化妝水建議');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['suggestions']['toner_suggestion'] ?? '');
                $row++;
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '精華液建議');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['suggestions']['serum_suggestion'] ?? '');
                $row++;
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '建議內容');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['suggestions']['suggestion_content'] ?? '');
                $row++;
            }
            
            // 肌膚檢測
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '肌膚類型');
            $skinTypeMap = [
                'normal' => '中性',
                'combination' => '混合性',
                'oily' => '油性',
                'dry' => '乾性',
                'sensitive' => '敏感性'
            ];
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $skinTypeMap[$submission['skin_type']] ?? $submission['skin_type'] ?? '');
            $row++;
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '肌膚年齡');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, ($submission['skin_age'] ?? '') . '歲');
            $row++;
            
            // 提交資訊
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '提交日期');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $submission['submission_date'] ?? '');
            $row++;

            // 調整欄位寬度
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

            // 設定檔案名稱
            $filename = '肌膚諮詢記錄表_' . ($submission['member_name'] ?? 'ID' . $id) . '_' . date('Y-m-d') . '.xlsx';
            
            // 創建Excel2007格式的Writer
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // 設定Headers
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');

            // 輸出檔案
            $objWriter->save('php://output');

            // 清理記憶體
            $objPHPExcel->disconnectWorksheets();
            unset($objWriter, $objPHPExcel);
            exit();

        } catch (Exception $e) {
            $this->_send_error('匯出失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 匯出分組表單 (依據會員姓名和電話)
     * GET /api/eeform1/export_grouped?member_name={member_name}&phone={phone}
     */
    public function export_grouped() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得查詢參數
            $member_name = $this->input->get('member_name');
            $phone = $this->input->get('phone');

            // 確保至少有一個參數
            if (empty($member_name) && empty($phone)) {
                $this->_send_error('缺少查詢參數：需要會員姓名或電話', 400);
                return;
            }

            // 從模型取得符合條件的所有表單
            $submissions = $this->eform1_model->get_submissions_by_member_info($member_name, $phone);

            if (empty($submissions)) {
                $this->_send_error('找不到符合條件的表單記錄', 404);
                return;
            }

            // 使用 PHPExcel 創建 Excel 檔案
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();

            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('肌膚諮詢記錄表');

            // 設定欄位寬度
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

            $current_row = 1;

            // 為每個表單創建一個區塊
            foreach ($submissions as $index => $submission) {
                // 表單標題
                $form_title = '肌膚諮詢記錄表 #' . ($index + 1);
                if (!empty($submission['member_name'])) {
                    $form_title .= ' - ' . $submission['member_name'];
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, $form_title);
                $objPHPExcel->getActiveSheet()->mergeCells('A' . $current_row . ':B' . $current_row);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $current_row)->getFont()->setBold(true)->setSize(16);
                $current_row += 2;

                // 基本資料
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '會員姓名');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['member_name'] ?? '');
                $current_row++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '出生年月日');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, ($submission['birth_year'] ?? '') . '年' . ($submission['birth_month'] ?? '') . '月' . ($submission['birth_day'] ?? '') . '日');
                $current_row++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '電話');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['phone'] ?? '');
                $current_row++;

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
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '職業');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, implode('、', $occupations));
                    $current_row++;
                }

                // 生活習慣
                if (isset($submission['lifestyle']) && is_array($submission['lifestyle'])) {
                    $lifestyle = [];
                    foreach ($submission['lifestyle'] as $item) {
                        if ($item['is_selected'] == 1) {
                            $lifestyle[] = $item['category'] . ': ' . $item['item_key'];
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '生活習慣');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, implode('、', $lifestyle));
                    $current_row++;
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
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '使用產品');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, implode('、', $products));
                    $current_row++;
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
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '肌膚困擾');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, implode('、', $issues));
                    $current_row++;
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
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '過敏狀況');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, implode('、', $allergies));
                    $current_row++;
                }

                // 建議內容
                if (isset($submission['suggestions'])) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '化妝水建議');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['suggestions']['toner_suggestion'] ?? '');
                    $current_row++;

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '精華液建議');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['suggestions']['serum_suggestion'] ?? '');
                    $current_row++;

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '建議內容');
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['suggestions']['suggestion_content'] ?? '');
                    $current_row++;
                }

                // 肌膚檢測
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '肌膚類型');
                $skinTypeMap = [
                    'normal' => '中性',
                    'combination' => '混合性',
                    'oily' => '油性',
                    'dry' => '乾性',
                    'sensitive' => '敏感性'
                ];
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $skinTypeMap[$submission['skin_type']] ?? $submission['skin_type'] ?? '');
                $current_row++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '肌膚年齡');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, ($submission['skin_age'] ?? '') . '歲');
                $current_row++;

                // 提交資訊
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '提交日期');
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $current_row, $submission['submission_date'] ?? '');
                $current_row++;

                // 在表單之間加空行分隔
                if ($index < count($submissions) - 1) {
                    $current_row += 2;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $current_row, '---分隔線---');
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $current_row . ':B' . $current_row);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $current_row)->getFont()->setItalic(true);
                    $current_row += 2;
                }
            }

            // 調整欄位寬度
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

            // 設定檔案名稱
            $member_info = !empty($member_name) ? $member_name : '會員';
            $phone_info = !empty($phone) ? '_' . $phone : '';
            $filename = '肌膚諮詢記錄表_' . $member_info . $phone_info . '_共' . count($submissions) . '筆_' . date('Y-m-d') . '.xlsx';

            // 創建Excel2007格式的Writer
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // 設定Headers
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');

            // 輸出檔案
            $objWriter->save('php://output');

            // 清理記憶體
            $objPHPExcel->disconnectWorksheets();
            unset($objWriter, $objPHPExcel);
            exit();

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
     * 刪除所有測試資料
     */
    public function delete_all_test_data() {
        try {
            // 只允許 POST 方法
            if ($this->input->method() !== 'post') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 執行刪除操作
            $result = $this->eform1_model->delete_all_test_data();
            
            if ($result) {
                $this->_send_success('所有測試資料已成功刪除');
            } else {
                $this->_send_error('刪除測試資料失敗', 500);
            }

        } catch (Exception $e) {
            log_message('error', 'Delete all test data API error: ' . $e->getMessage());
            $this->_send_error('刪除測試資料時發生錯誤: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 創建 MySQL 預儲程序
     * GET /api/eeform1/create_procedure
     */
    public function create_procedure() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 檢查MSSQL預儲程序是否存在
            $check_result = $this->eform1_model->check_mssql_procedure('ww_chkguest');

            if (!$check_result['exists']) {
                $this->_send_error('MSSQL預儲程序 ww_chkguest 不存在，請在MSSQL伺服器上建立該預儲程序', 404, [
                    'procedure_info' => $check_result,
                    'note' => '請參考第5點的預儲程序說明在MSSQL伺服器上建立 ww_chkguest',
                    'required_parameters' => [
                        '@test' => 'smallint (1=測試用, 0=正式模式)',
                        '@d_spno' => 'char(7) (推薦人編號)',
                        '@cname' => 'nvarchar(20) (來賓姓名)',
                        '@bdate' => 'varchar(8) (生日 YYYYMMDD)',
                        '@cell' => 'varchar(20) (電話)'
                    ]
                ]);
                return;
            }

            // 預儲程序存在，執行測試
            $test_data = [
                'test' => 1,
                'd_spno' => '000000',
                'cname' => '章喆',
                'bdate' => '19780615',
                'cell' => '0966-123-456'
            ];

            $test_result = $this->eform1_model->test_mssql_ww_chkguest($test_data);

            $response_data = [
                'procedure_check' => $check_result,
                'test_result' => $test_result,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            if ($test_result['success']) {
                $this->_send_success('MSSQL預儲程序檢查和測試完成', $response_data);
            } else {
                $this->_send_error('MSSQL預儲程序測試失敗', 500, $response_data);
            }

        } catch (Exception $e) {
            log_message('error', 'Create procedure API error: ' . $e->getMessage());
            $this->_send_error('創建預儲程序時發生錯誤: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 測試預儲程序
     * GET /api/eeform1/test_procedure
     */
    public function test_procedure() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 測試資料
            $test_data = [
                'test' => 1,
                'd_spno' => '000000',
                'cname' => '章喆',
                'bdate' => '19780615',
                'cell' => '0966-123-456'
            ];

            $results = [
                'mysql' => null,
                'mssql' => null,
                'test_data' => $test_data,
                'timestamp' => date('Y-m-d H:i:s')
            ];

            // 檢查 MySQL 預儲程序
            try {
                $mssql_result = $this->eform1_model->check_mssql_procedure('ww_chkguest');
                $results['mssql'] = $mssql_result;

                // 如果 MSSQL 預儲程序存在，執行測試
                if ($mssql_result['exists']) {
                    $test_result = $this->eform1_model->test_mssql_ww_chkguest($test_data);
                    $results['mssql']['test_result'] = $test_result;
                } else {
                    $results['mssql']['test_result'] = [
                        'success' => false,
                        'message' => 'MSSQL預儲程序不存在，跳過測試'
                    ];
                }
            } catch (Exception $e) {
                $results['mssql'] = [
                    'exists' => false,
                    'error' => 'MSSQL 連線或查詢錯誤: ' . $e->getMessage()
                ];
            }

            $this->_send_success('預儲程序檢查完成', $results);

        } catch (Exception $e) {
            log_message('error', 'Test procedure API error: ' . $e->getMessage());
            $this->_send_error('測試預儲程序時發生錯誤: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 創建來賓（正式模式）
     * POST /api/eeform1/create_guest
     */
    public function create_guest() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
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

            // 驗證必填欄位
            $required_fields = ['d_spno', 'cname', 'bdate', 'cell'];
            $missing_fields = [];

            foreach ($required_fields as $field) {
                if (empty($input_data[$field])) {
                    $missing_fields[] = $field;
                }
            }

            if (!empty($missing_fields)) {
                $this->_send_error('缺少必填欄位', 400, [
                    'missing_fields' => $missing_fields,
                    'required_fields' => [
                        'd_spno' => '推薦人編號',
                        'cname' => '來賓姓名',
                        'bdate' => '生日 (YYYYMMDD)',
                        'cell' => '電話'
                    ]
                ]);
                return;
            }

            // 驗證資料格式
            $validation_errors = [];

            // 驗證生日格式 (YYYYMMDD)
            if (!preg_match('/^\d{8}$/', $input_data['bdate'])) {
                $validation_errors[] = '生日格式錯誤，需為8位數字 (YYYYMMDD)';
            }

            // 驗證推薦人編號格式
            if (strlen($input_data['d_spno']) > 7) {
                $validation_errors[] = '推薦人編號不能超過7個字符';
            }

            // 驗證姓名長度
            if (strlen($input_data['cname']) > 20) {
                $validation_errors[] = '來賓姓名不能超過20個字符';
            }

            if (!empty($validation_errors)) {
                $this->_send_error('資料格式驗證失敗', 400, [
                    'validation_errors' => $validation_errors
                ]);
                return;
            }

            // 準備預儲程序資料
            $guest_data = [
                'd_spno' => $input_data['d_spno'],
                'cname' => $input_data['cname'],
                'bdate' => $input_data['bdate'],
                'cell' => '' // 電話參數已移除，傳空字串
            ];

            // 呼叫 MSSQL 預儲程序（正式模式）
            $result = $this->eform1_model->create_mssql_ww_chkguest($guest_data);

            if ($result['success']) {
                $this->_send_success('來賓創建成功', $result);
            } else {
                // 根據錯誤代碼回傳不同的錯誤訊息
                $error_code = $result['errcode'] ?? -1;
                $status_code = 400;

                if ($error_code === 2) {
                    $status_code = 409; // Conflict - 推薦人不同
                } elseif ($error_code === 3) {
                    $status_code = 409; // Conflict - 已是會員
                } elseif ($error_code === -1) {
                    $status_code = 500; // Internal Server Error
                }

                $this->_send_error($result['message'], $status_code, [
                    'errcode' => $error_code,
                    'guest_id' => $result['guest_id'],
                    'details' => $result
                ]);
            }

        } catch (Exception $e) {
            log_message('error', 'Create guest API error: ' . $e->getMessage());
            $this->_send_error('創建來賓時發生錯誤: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 檢查資料表結構
     * @return array
     */
    private function _check_table_structure() {
        try {
            // 檢查 eeform1_submissions 表是否存在
            $table_exists = $this->db->table_exists('eeform1_submissions');

            if (!$table_exists) {
                return ['table_exists' => false, 'error' => 'eeform1_submissions table not found'];
            }

            // 檢查表的欄位結構
            $fields_query = $this->db->query("DESCRIBE eeform1_submissions");
            $fields = $fields_query ? $fields_query->result_array() : [];

            $field_names = array_column($fields, 'Field');

            return [
                'table_exists' => true,
                'field_count' => count($field_names),
                'critical_fields' => [
                    'member_id' => in_array('member_id', $field_names),
                    'member_name' => in_array('member_name', $field_names),
                    'identity' => in_array('identity', $field_names),
                    'created_at' => in_array('created_at', $field_names)
                ]
            ];
        } catch (Exception $e) {
            return [
                'error' => 'Failed to check table structure: ' . $e->getMessage()
            ];
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

    /**
     * 專用 ww_chkguest 預儲程序測試 API
     * GET /api/eeform1/ww_chkguest_test?d_spno=000000&cname=章喆&bdate=19780615
     */
    public function ww_chkguest_test() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得GET參數
            $d_spno = $this->input->get('d_spno') ?: '000000';
            $cname = $this->input->get('cname') ?: '章喆';
            $bdate = $this->input->get('bdate') ?: '19780615';
            $cell = ''; // 電話參數已移除

            // 驗證參數
            if (empty($cname)) {
                $this->_send_error('來賓姓名不能為空', 400);
                return;
            }

            $test_data = [
                'd_spno' => $d_spno,
                'cname' => $cname,
                'bdate' => $bdate,
                'cell' => $cell
            ];

            // 呼叫MSSQL預儲程序測試
            $result = $this->eform1_model->test_mssql_ww_chkguest($test_data);

            $this->_send_success('ww_chkguest 預儲程序測試完成', $result);

        } catch (Exception $e) {
            $this->_send_error('ww_chkguest 測試失敗', 500, [
                'error' => $e->getMessage(),
                'test_data' => $test_data ?? null
            ]);
        }
    }

    /**
     * 除錯API - 檢查資料表結構和系統狀態
     * GET /api/eeform1/debug_info
     */
    public function debug_info() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $debug_info = [
                'database_connection' => $this->db ? 'Connected' : 'Not Connected',
                'table_structure' => $this->_check_table_structure(),
                'model_loaded' => isset($this->eform1_model) ? 'Yes' : 'No',
                'last_db_error' => $this->db->error(),
                'php_version' => PHP_VERSION,
                'ci_version' => CI_VERSION,
                'server_time' => date('Y-m-d H:i:s'),
                'test_data_sample' => [
                    'identity' => 'guest',
                    'member_id' => 'TEST123',
                    'member_name' => '測試使用者',
                    'birth_year' => 1990,
                    'birth_month' => 1,
                    'birth_day' => 1
                ]
            ];

            // 嘗試檢查資料表欄位
            try {
                $fields_query = $this->db->query("SHOW COLUMNS FROM eeform1_submissions");
                $fields = $fields_query ? $fields_query->result_array() : [];
                $debug_info['table_columns'] = $fields;
            } catch (Exception $e) {
                $debug_info['table_columns_error'] = $e->getMessage();
            }

            $this->_send_success('除錯資訊', $debug_info);

        } catch (Exception $e) {
            $this->_send_error('取得除錯資訊失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 專用 ww_chkguest 預儲程序創建來賓 API (正式模式)
     * POST /api/eeform1/ww_chkguest_create
     * Body: {"d_spno":"000000","cname":"章喆","bdate":"19780615"}
     */
    public function ww_chkguest_create() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得POST資料
            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);

            if (!$input_data) {
                $input_data = $this->input->post();
            }

            if (empty($input_data)) {
                $this->_send_error('沒有接收到資料', 400);
                return;
            }

            // 驗證必填欄位（移除cell）
            $required_fields = ['d_spno', 'cname', 'bdate'];
            $missing_fields = [];

            foreach ($required_fields as $field) {
                if (!isset($input_data[$field]) || $input_data[$field] === '') {
                    $missing_fields[] = $field;
                }
            }

            if (!empty($missing_fields)) {
                $this->_send_error('缺少必填欄位', 400, [
                    'missing_fields' => $missing_fields,
                    'required_fields' => [
                        'd_spno' => '推薦人編號',
                        'cname' => '來賓姓名',
                        'bdate' => '生日 (YYYYMMDD)'
                    ]
                ]);
                return;
            }

            $guest_data = [
                'd_spno' => $input_data['d_spno'],
                'cname' => $input_data['cname'],
                'bdate' => $input_data['bdate'],
                'cell' => '' // 電話參數已移除，傳空字串
            ];

            // 呼叫MSSQL預儲程序（正式模式）
            $result = $this->eform1_model->create_mssql_ww_chkguest($guest_data);

            if ($result['success']) {
                $this->_send_success('來賓創建成功', $result);
            } else {
                $error_messages = [
                    0 => '來賓身分通過驗證',
                    1 => '已存在此來賓，返回現有編號',
                    2 => '已存在此來賓，但推薦人不同',
                    3 => '此來賓已經是會員了'
                ];

                $error_code = $result['errcode'] ?? -1;
                $message = $error_messages[$error_code] ?? '未知錯誤';

                $this->_send_error($message, 400, $result);
            }

        } catch (Exception $e) {
            $this->_send_error('ww_chkguest 創建失敗', 500, [
                'error' => $e->getMessage(),
                'input_data' => $input_data ?? null
            ]);
        }
    }
}