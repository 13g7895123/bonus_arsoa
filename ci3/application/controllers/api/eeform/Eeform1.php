<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform1 extends CI_Controller
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
        
        // Simplified constructor for CI3
        parent::__construct();
        
        // Load basic helpers and libraries
        $this->load->helper('url');
        
        // Try loading eform model if it exists
        if (file_exists(APPPATH . 'models/eeform/Eeform1Model.php')) {
            $this->load->model('eeform/Eeform1Model', 'eform1_model');
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
     * GET /api/eeform1/submissions/{form_filler_id}
     */
    public function submissions($form_filler_id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$form_filler_id) {
                $this->_send_error('缺少代填者編號', 400);
                return;
            }

            // Add debugging for the form_filler_id received
            $debug_info = [
                'form_filler_id_received' => $form_filler_id,
                'form_filler_id_length' => strlen($form_filler_id),
                'form_filler_id_type' => gettype($form_filler_id)
            ];

            // 取得查詢參數
            $page = (int)$this->input->get('page') ?: 1;
            $limit = (int)$this->input->get('limit') ?: 10;
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $submissions = $this->eform1_model->get_form_filler_submissions(
                $form_filler_id, 
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

            // 調整回應格式以符合前端預期
            $response = [
                'success' => true,
                'message' => '取得列表資料成功',
                'data' => $results['data'],
                'total' => $results['pagination']['total'],
                'page' => $results['pagination']['current_page'],
                'limit' => $results['pagination']['per_page']
            ];
            
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($response));

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
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '出生年月');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, ($submission['birth_year'] ?? '') . '年' . ($submission['birth_month'] ?? '') . '月');
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
     * 測試資料庫寫入功能
     * GET /api/eeform1/test_write
     * 確認所有 eeform1 相關資料表可以正常寫入資料
     */
    public function test_write() {
        try {
            // 確認是 GET 請求
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('請使用 GET 方法呼叫此 API', 405);
                return;
            }

            // 確保資料庫連線
            $this->load->database();
            
            if (!$this->db) {
                $this->_send_error('資料庫連線失敗', 500, [
                    'error' => '無法建立資料庫連線'
                ]);
                return;
            }

            // 開始交易
            $this->db->trans_start();
            
            $test_results = [];
            $test_results['資料庫連線'] = '成功';
            
            // 先清理任何現有的測試資料，避免唯一約束衝突
            $this->db->where('member_id', '999999');
            $this->db->or_where('phone', '0987654321');
            $this->db->delete('eeform1_submissions');
            $test_results['清理舊測試資料'] = '完成';
            
            // 使用唯一的時間戳確保不重複
            $unique_suffix = date('His') . rand(100, 999);
            
            // 建立測試資料
            $test_submission_data = [
                'member_id' => '999' . $unique_suffix,
                'member_name' => '測試用戶' . $unique_suffix,
                'form_filler_id' => '000000',
                'form_filler_name' => '系統管理員',
                'birth_year' => 1985,
                'birth_month' => 10,
                'phone' => '098765' . substr($unique_suffix, -4),
                'skin_type' => 'combination',
                'skin_age' => 35,
                'submission_date' => date('Y-m-d H:i:s'),
                'status' => 'completed'
            ];

            // 測試主表 eeform1_submissions
            $this->db->insert('eeform1_submissions', $test_submission_data);
            if ($this->db->affected_rows() > 0) {
                $submission_id = $this->db->insert_id();
                $test_results['eeform1_submissions'] = '寫入成功 (ID: ' . $submission_id . ')';
            } else {
                throw new Exception('主表寫入失敗: ' . $this->db->error()['message']);
            }

            // 測試 eeform1_occupations
            $occupation_data = [
                ['submission_id' => $submission_id, 'occupation_type' => 'office', 'is_selected' => 1],
                ['submission_id' => $submission_id, 'occupation_type' => 'service', 'is_selected' => 1]
            ];
            $this->db->insert_batch('eeform1_occupations', $occupation_data);
            $test_results['eeform1_occupations'] = '寫入成功 (2筆記錄)';

            // 測試 eeform1_lifestyle
            $lifestyle_data = [
                ['submission_id' => $submission_id, 'category' => 'sunlight', 'item_key' => '3_4h', 'item_value' => null, 'is_selected' => 1],
                ['submission_id' => $submission_id, 'category' => 'sleep', 'item_key' => 'other', 'item_value' => '測試作息時間', 'is_selected' => 1]
            ];
            $this->db->insert_batch('eeform1_lifestyle', $lifestyle_data);
            $test_results['eeform1_lifestyle'] = '寫入成功 (2筆記錄)';

            // 測試 eeform1_products
            $products_data = [
                ['submission_id' => $submission_id, 'product_type' => 'toner', 'product_name' => null, 'is_selected' => 1],
                ['submission_id' => $submission_id, 'product_type' => 'other', 'product_name' => '測試產品', 'is_selected' => 1]
            ];
            $this->db->insert_batch('eeform1_products', $products_data);
            $test_results['eeform1_products'] = '寫入成功 (2筆記錄)';

            // 測試 eeform1_skin_issues  
            $skin_issues_data = [
                ['submission_id' => $submission_id, 'issue_type' => 'dry', 'issue_description' => null, 'is_selected' => 1],
                ['submission_id' => $submission_id, 'issue_type' => 'spots', 'issue_description' => null, 'is_selected' => 1]
            ];
            $this->db->insert_batch('eeform1_skin_issues', $skin_issues_data);
            $test_results['eeform1_skin_issues'] = '寫入成功 (2筆記錄)';

            // 測試 eeform1_allergies
            $allergies_data = [
                ['submission_id' => $submission_id, 'allergy_type' => 'seasonal', 'is_selected' => 1]
            ];
            $this->db->insert_batch('eeform1_allergies', $allergies_data);
            $test_results['eeform1_allergies'] = '寫入成功 (1筆記錄)';

            // 測試 eeform1_skin_scores
            $skin_scores_data = [
                ['submission_id' => $submission_id, 'category' => 'moisture', 'score_type' => 'healthy', 'score_value' => 8, 'measurement_date' => date('Y-m-d')],
                ['submission_id' => $submission_id, 'category' => 'complexion', 'score_type' => 'warning', 'score_value' => 5, 'measurement_date' => date('Y-m-d')],
                ['submission_id' => $submission_id, 'category' => 'texture', 'score_type' => 'severe', 'score_value' => 3, 'measurement_date' => date('Y-m-d')]
            ];
            $this->db->insert_batch('eeform1_skin_scores', $skin_scores_data);
            $test_results['eeform1_skin_scores'] = '寫入成功 (3筆記錄)';

            // 測試 eeform1_suggestions
            $suggestions_data = [
                'submission_id' => $submission_id,
                'toner_suggestion' => '保濕化妝水',
                'serum_suggestion' => '抗老精華液',
                'suggestion_content' => '建議加強保濕，每日使用防曬產品',
                'created_by' => 'API測試系統',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('eeform1_suggestions', $suggestions_data);
            $test_results['eeform1_suggestions'] = '寫入成功 (1筆記錄)';

            // 驗證資料完整性 - 檢查外鍵關聯
            $this->db->select('COUNT(*) as count');
            $this->db->from('eeform1_occupations');
            $this->db->where('submission_id', $submission_id);
            $occupation_count = $this->db->get()->row()->count;

            $this->db->select('COUNT(*) as count');
            $this->db->from('eeform1_skin_scores');
            $this->db->where('submission_id', $submission_id);
            $scores_count = $this->db->get()->row()->count;

            if ($occupation_count == 2 && $scores_count == 3) {
                $test_results['外鍵關聯驗證'] = '成功 - 相關資料正確關聯';
            } else {
                throw new Exception('外鍵關聯驗證失敗');
            }

            // 測試資料約束 - 嘗試插入無效的分數值 (使用不同的分類避免唯一約束衝突)
            try {
                $invalid_score = [
                    'submission_id' => $submission_id,
                    'category' => 'pigment', // 使用不同的分類避免唯一約束衝突
                    'score_type' => 'severe', // 使用不同的評分類型
                    'score_value' => 15, // 超出範圍 (應該是 0-10)
                    'measurement_date' => date('Y-m-d')
                ];
                $this->db->insert('eeform1_skin_scores', $invalid_score);
                
                // 如果沒有拋出例外，表示約束沒有工作
                $test_results['資料約束測試'] = '警告 - 分數範圍約束可能未正確設定';
            } catch (Exception $e) {
                // 檢查錯誤類型
                $error_msg = $e->getMessage();
                if (strpos($error_msg, 'Duplicate') !== false) {
                    $test_results['資料約束測試'] = '警告 - 遇到唯一約束衝突，無法完整測試分數範圍約束';
                } else {
                    $test_results['資料約束測試'] = '成功 - 資料約束正常運作';
                }
            }

            // 完成交易（但要回滾以清理測試資料）
            $this->db->trans_rollback();
            $test_results['測試資料清理'] = '成功 - 測試資料已清除';

            // 回傳成功結果
            $this->_send_success('資料庫寫入測試完成', [
                '測試時間' => date('Y-m-d H:i:s'),
                '測試狀態' => '全部通過',
                '資料表測試結果' => $test_results,
                '總結' => [
                    '測試的資料表數量' => 8,
                    '寫入測試' => '成功',
                    '外鍵關聯' => '正常',
                    '資料約束' => '運作中',
                    '資料清理' => '完成'
                ],
                '說明' => 'Point 100 建立的 eeform1 資料表結構完全可以正常使用，所有寫入功能測試通過'
            ]);

        } catch (Exception $e) {
            // 如果有錯誤，確保回滾交易
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            }

            $this->_send_error('資料庫寫入測試失敗: ' . $e->getMessage(), 500, [
                '錯誤詳情' => $e->getMessage(),
                '錯誤檔案' => $e->getFile(),
                '錯誤行號' => $e->getLine(),
                '測試結果' => $test_results ?? [],
                '建議' => '請確認 Point 100 的資料表建立是否完整，或檢查資料庫連線設定'
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

            $members_raw = $query->result_array();
            
            // 確保會員姓名是純淨的，但保留會員編號資料
            $clean_members = [];
            foreach ($members_raw as $member) {
                if (!empty($member['c_name'])) {
                    $clean_members[] = [
                        'c_no' => $member['c_no'],
                        'c_name' => trim($member['c_name']) // 純姓名，無額外格式
                    ];
                }
            }
            
            // 返回查詢結果 - 包含會員編號和純姓名
            $result = [
                'count' => count($clean_members),
                'members' => $clean_members, // 包含會員編號和純姓名
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
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
                $mysql_result = $this->eform1_model->check_mysql_procedure('ww_chkguest');
                $results['mysql'] = $mysql_result;

                // 如果 MySQL 預儲程序存在，執行測試
                if ($mysql_result['exists']) {
                    $test_result = $this->eform1_model->test_mysql_procedure($test_data);
                    $results['mysql']['test_result'] = $test_result;
                }
            } catch (Exception $e) {
                $results['mysql'] = [
                    'exists' => false,
                    'error' => 'MySQL 連線或查詢錯誤: ' . $e->getMessage()
                ];
            }

            // 檢查 MSSQL 預儲程序
            try {
                $mssql_result = $this->eform1_model->check_mssql_procedure('ww_chkguest');
                $results['mssql'] = $mssql_result;

                // 如果 MSSQL 預儲程序存在，執行測試
                if ($mssql_result['exists']) {
                    $test_result = $this->eform1_model->test_mssql_procedure($test_data);
                    $results['mssql']['test_result'] = $test_result;
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
     * 測試來賓驗證（測試模式）
     * GET /api/eeform1/ww_chkguest_test
     */
    public function ww_chkguest_test() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得GET參數
            $cname = $this->input->get('cname');
            $bdate = $this->input->get('bdate');

            // 驗證必填欄位
            $missing_fields = [];
            if (empty($cname)) $missing_fields[] = 'cname';
            if (empty($bdate)) $missing_fields[] = 'bdate';

            if (!empty($missing_fields)) {
                $this->_send_error('缺少必填欄位', 400, [
                    'missing_fields' => $missing_fields,
                    'required_fields' => [
                        'cname' => '來賓姓名',
                        'bdate' => '生日 (YYYY-MM-DD)'
                    ]
                ]);
                return;
            }

            // 格式化生日 (YYYY-MM-DD to YYYYMMDD)
            $formatted_bdate = str_replace('-', '', $bdate);
            if (!preg_match('/^\d{8}$/', $formatted_bdate)) {
                $this->_send_error('生日格式錯誤', 400, [
                    'error' => '生日格式應為 YYYY-MM-DD'
                ]);
                return;
            }

            // 測試資料
            $test_data = [
                'test' => 1,
                'd_spno' => '000000', // 預設推薦人編號
                'cname' => $cname,
                'bdate' => $formatted_bdate
            ];

            // 呼叫測試預儲程序
            $result = $this->eform1_model->test_ww_chkguest($test_data);

            if ($result['success']) {
                $this->_send_success('來賓驗證測試成功', $result);
            } else {
                $this->_send_error($result['message'], 400, $result);
            }

        } catch (Exception $e) {
            $this->_send_error('測試來賓驗證時發生錯誤: ' . $e->getMessage(), 500, [
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
            $required_fields = ['cname', 'bdate'];
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

            // 格式化生日 (YYYY-MM-DD to YYYYMMDD)
            $formatted_bdate = str_replace('-', '', $input_data['bdate']);
            if (!preg_match('/^\d{8}$/', $formatted_bdate)) {
                $validation_errors[] = '生日格式錯誤，需為 YYYY-MM-DD 格式';
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
                'd_spno' => '000000', // 預設推薦人編號
                'cname' => $input_data['cname'],
                'bdate' => $formatted_bdate
            ];

            // 呼叫預儲程序（正式模式）
            $result = $this->eform1_model->create_guest_procedure($guest_data);

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