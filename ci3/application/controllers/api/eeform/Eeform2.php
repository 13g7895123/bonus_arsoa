<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform2 extends CI_Controller
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
        if (file_exists(APPPATH . 'models/eeform/Eeform2Model.php')) {
            $this->load->model('eeform/Eeform2Model', 'eform2_model');
        }
        $this->load->library('user_agent');
        $this->load->helper('url');
    }

    /**
     * API健康檢查
     * GET /api/eeform2/health
     */
    public function health() {
        try {
            $health_info = [
                'status' => 'healthy',
                'service' => 'EForm2 API',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'codeigniter_version' => CI_VERSION
            ];

            $this->_send_success('EForm2 API is healthy', $health_info);

        } catch (Exception $e) {
            $this->_send_error('Health check failed: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 提交表單資料
     * POST /api/eeform2/submit
     */
    public function submit() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 獲取輸入資料
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
            $required_fields = ['member_name', 'join_date', 'gender', 'age'];
            $validation_errors = [];
            
            foreach ($required_fields as $field) {
                if (!isset($input_data[$field]) || trim($input_data[$field]) === '') {
                    $validation_errors[] = "欄位 '{$field}' 為必填";
                }
            }
            
            if (!empty($validation_errors)) {
                $this->_send_error('資料驗證失敗', 400, $validation_errors);
                return;
            }

            // 準備資料庫資料
            $submission_data = [
                'member_name' => trim($input_data['member_name']),
                'join_date' => $input_data['join_date'],
                'gender' => $input_data['gender'],
                'age' => (int)$input_data['age'],
                'skin_health_condition' => isset($input_data['skin_health_condition']) ? trim($input_data['skin_health_condition']) : null,
                'line_contact' => isset($input_data['line_contact']) ? trim($input_data['line_contact']) : null,
                'tel_contact' => isset($input_data['tel_contact']) ? trim($input_data['tel_contact']) : null,
                'meeting_date' => !empty($input_data['meeting_date']) ? $input_data['meeting_date'] : null,
                'submission_date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'submitted'
            ];

            // 提交表單資料
            try {
                $submission_id = $this->eform2_model->create_submission($submission_data);
            } catch (Exception $e) {
                $this->_send_error('建立提交記錄失敗: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'input_data' => $submission_data
                ]);
                return;
            }
            
            if ($submission_id) {
                // 處理產品資料
                if (isset($input_data['products']) && is_array($input_data['products'])) {
                    try {
                        $this->eform2_model->save_products($submission_id, $input_data['products']);
                    } catch (Exception $e) {
                        $this->_send_error('保存產品資料失敗: ' . $e->getMessage(), 500, [
                            'submission_id' => $submission_id,
                            'products' => $input_data['products']
                        ]);
                        return;
                    }
                }

                $this->_send_success('表單提交成功', [
                    'submission_id' => $submission_id,
                    'submission_date' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->_send_error('表單提交失敗', 500, [
                    'debug' => 'create_submission returned false',
                    'input_data' => $submission_data
                ]);
            }

        } catch (Exception $e) {
            $this->_send_error('表單提交失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 取得表單提交記錄
     * GET /api/eeform2/submissions/{member_id}
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

            $submissions = $this->eform2_model->get_submissions_by_member($member_id);
            
            $this->_send_success('取得提交記錄成功', [
                'member_id' => $member_id,
                'data' => $submissions,
                'total' => count($submissions)
            ]);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄失敗: ' . $e->getMessage(), 500, [
                'member_id' => $member_id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 取得單一表單記錄
     * GET /api/eeform2/submission/{id}
     */
    public function submission($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id || !is_numeric($id)) {
                $this->_send_error('缺少有效的表單ID', 400);
                return;
            }

            $submission = $this->eform2_model->get_submission_by_id($id);
            
            if ($submission) {
                $this->_send_success('取得表單記錄成功', $submission);
            } else {
                $this->_send_error('找不到指定的表單記錄', 404);
            }

        } catch (Exception $e) {
            $this->_send_error('取得表單記錄失敗: ' . $e->getMessage(), 500, [
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 管理員取得所有表單記錄 (分頁)
     * GET /api/eeform2/list
     */
    public function list() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得查詢參數
            $page = (int)($this->input->get('page') ?? 1);
            $limit = (int)($this->input->get('limit') ?? 20);
            $search = $this->input->get('search') ?? '';
            $status = $this->input->get('status') ?? '';
            $start_date = $this->input->get('start_date') ?? '';
            $end_date = $this->input->get('end_date') ?? '';

            // 驗證參數
            if ($page < 1) $page = 1;
            if ($limit < 1 || $limit > 100) $limit = 20;

            $filters = [
                'search' => $search,
                'status' => $status,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];

            $result = $this->eform2_model->get_all_submissions_paginated($page, $limit, $filters);
            
            $this->_send_success('取得表單列表成功', [
                'data' => $result['data'],
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $limit,
                    'total' => $result['total'],
                    'total_pages' => ceil($result['total'] / $limit)
                ],
                'filters' => $filters
            ]);

        } catch (Exception $e) {
            $this->_send_error('取得表單列表失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 更新表單狀態
     * PUT /api/eeform2/update_status/{id}
     */
    public function update_status($id = null) {
        try {
            if (!in_array($this->input->method(TRUE), ['PUT', 'POST'])) {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id || !is_numeric($id)) {
                $this->_send_error('缺少有效的表單ID', 400);
                return;
            }

            $raw_input = $this->input->raw_input_stream;
            $input_data = json_decode($raw_input, true);
            
            if (!$input_data) {
                $input_data = $this->input->post();
            }

            if (empty($input_data['status'])) {
                $this->_send_error('缺少狀態參數', 400);
                return;
            }

            $allowed_statuses = ['submitted', 'processing', 'completed', 'cancelled'];
            if (!in_array($input_data['status'], $allowed_statuses)) {
                $this->_send_error('無效的狀態值', 400, [
                    'allowed_statuses' => $allowed_statuses
                ]);
                return;
            }

            $update_data = [
                'status' => $input_data['status'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($input_data['admin_note'])) {
                $update_data['admin_note'] = trim($input_data['admin_note']);
            }

            $result = $this->eform2_model->update_submission_status($id, $update_data);
            
            if ($result) {
                $this->_send_success('更新狀態成功', [
                    'id' => $id,
                    'new_status' => $input_data['status']
                ]);
            } else {
                $this->_send_error('更新狀態失敗', 500);
            }

        } catch (Exception $e) {
            $this->_send_error('更新狀態失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }


    /**
     * 取得統計資料
     * GET /api/eeform2/stats
     */
    public function stats() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $stats = $this->eform2_model->get_submission_stats();
            
            $this->_send_success('取得統計資料成功', $stats);

        } catch (Exception $e) {
            $this->_send_error('取得統計資料失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 取得/更新產品設定
     * GET/POST /api/eeform2/products
     */
    public function products() {
        try {
            $method = $this->input->method(TRUE);
            
            if ($method === 'GET') {
                // 從資料庫取得產品設定
                $products = $this->eform2_model->get_all_products();
                
                $this->_send_success('取得產品設定成功', $products);
                
            } else if ($method === 'POST') {
                // 更新產品設定
                $raw_input = $this->input->raw_input_stream;
                $input_data = json_decode($raw_input, true);
                
                if (!$input_data) {
                    $input_data = $this->input->post();
                }
                
                if (empty($input_data['products'])) {
                    $this->_send_error('缺少產品資料', 400);
                    return;
                }
                
                // 使用資料庫儲存產品設定
                $result = $this->eform2_model->batch_update_products($input_data['products']);
                
                if ($result) {
                    $this->_send_success('產品設定更新成功', $input_data['products']);
                } else {
                    $this->_send_error('產品設定更新失敗', 500);
                }
                
            } else {
                $this->_send_error('Method not allowed', 405);
            }

        } catch (Exception $e) {
            $this->_send_error('產品設定操作失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 匯出 Excel
     * GET /api/eeform2/export
     */
    public function export() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得篩選參數
            $search = $this->input->get('search') ?? '';
            $status = $this->input->get('status') ?? '';
            $start_date = $this->input->get('start_date') ?? '';
            $end_date = $this->input->get('end_date') ?? '';

            $filters = [
                'search' => $search,
                'status' => $status,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];

            // 取得所有符合條件的資料 (不分頁)
            $result = $this->eform2_model->get_all_submissions_paginated(1, 10000, $filters);
            $data = $result['data'];

            // 使用 PHPExcel 創建真正的 Excel 檔案 (批量資料 - 欄位值格式)
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();
            
            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('會員服務追蹤管理表');
            
            // 設定欄位寬度 (A欄:欄位名稱, B欄:值)
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            
            $row = 1;
            $status_map = [
                'submitted' => '已提交',
                'processing' => '處理中',
                'completed' => '已完成',
                'cancelled' => '已取消'
            ];
            
            foreach ($data as $index => $item) {
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
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '會員服務追蹤管理表(肌膚) - 第'.($index+1).'筆');
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
                    'ID' => $item['id'],
                    '會員姓名' => $item['member_name'] ?? '',
                    '性別' => $item['gender'] ?? '',
                    '年齡' => isset($item['age']) ? $item['age'] . ' 歲' : '',
                    '入會日' => $item['join_date'] ?? '',
                    '見面日' => $item['meeting_date'] ?? ''
                ];
                
                foreach ($basic_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }
                
                // 空行
                $row++;
                
                // 健康狀況標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '健康狀況');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D9EDF7');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '肌膚健康狀況');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $item['skin_health_condition'] ?? '');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
                $row++;
                
                // 空行
                $row++;
                
                // 產品資料標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '產品訂購');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00D4EDDA');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                // 產品資料
                if (isset($item['products']) && is_array($item['products']) && !empty($item['products'])) {
                    foreach ($item['products'] as $product) {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $product['product_name']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $product['quantity'] . ' 個');
                        $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                        $row++;
                    }
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '訂購產品');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, '未訂購任何產品');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }
                
                // 空行
                $row++;
                
                // 聯絡資訊標題
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '聯絡資訊');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00FFF3CD');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
                $row++;
                
                $contact_fields = [
                    'LINE聯絡' => $item['line_contact'] ?? '',
                    '電話聯絡' => $item['tel_contact'] ?? ''
                ];
                
                foreach ($contact_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
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
                    '提交日期' => $item['submission_date'] ?? '',
                    '建立時間' => $item['created_at'] ?? '',
                    '狀態' => $status_map[$item['status']] ?? $item['status']
                ];
                
                if (!empty($item['admin_note'])) {
                    $form_fields['管理員備註'] = $item['admin_note'];
                }
                
                foreach ($form_fields as $field => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
                    $row++;
                }
                
                // 空行
                $row++;
            }
            
            // 設定對齊方式
            $objPHPExcel->getActiveSheet()->getStyle('A1:B'.($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            
            $filename = 'eform02_會員服務追蹤管理表_' . date('Y-m-d_H-i-s');
            
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
            $this->_send_error('匯出 Excel 失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 匯出單一表單 (Excel格式)
     * GET /api/eeform2/export_single/{id}
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

            $submission = $this->eform2_model->get_submission_by_id($id);
            
            if (!$submission) {
                $this->_send_error('找不到指定的表單記錄', 404);
                return;
            }

            // 使用 PHPExcel 創建真正的 Excel 檔案 (欄位值格式)
            $this->load->library("PHPExcel");
            $objPHPExcel = new PHPExcel();
            
            // 設定工作表屬性
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle('會員服務追蹤管理表');
            
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '會員服務追蹤管理表(肌膚)');
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
                'ID' => $submission['id'],
                '會員姓名' => $submission['member_name'] ?? '',
                '性別' => $submission['gender'] ?? '',
                '年齡' => isset($submission['age']) ? $submission['age'] . ' 歲' : '',
                '入會日' => $submission['join_date'] ?? '',
                '見面日' => $submission['meeting_date'] ?? ''
            ];
            
            foreach ($basic_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
            }
            
            // 空行
            $row++;
            
            // 健康狀況標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '健康狀況');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00D9EDF7');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '肌膚健康狀況');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $submission['skin_health_condition'] ?? '');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
            $row++;
            
            // 空行
            $row++;
            
            // 產品資料標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '產品訂購');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00D4EDDA');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            // 產品資料
            if (isset($submission['products']) && is_array($submission['products']) && !empty($submission['products'])) {
                foreach ($submission['products'] as $product) {
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $product['product_name']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $product['quantity'] . ' 個');
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                    $row++;
                }
            } else {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '訂購產品');
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, '未訂購任何產品');
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $row++;
            }
            
            // 空行
            $row++;
            
            // 聯絡資訊標題
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '聯絡資訊');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('00FFF3CD');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
            $row++;
            
            $contact_fields = [
                'LINE聯絡' => $submission['line_contact'] ?? '',
                '電話聯絡' => $submission['tel_contact'] ?? ''
            ];
            
            foreach ($contact_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
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
                '提交日期' => $submission['submission_date'] ?? '',
                '建立時間' => $submission['created_at'] ?? '',
                '狀態' => $status_map[$submission['status']] ?? $submission['status']
            ];
            
            if (!empty($submission['admin_note'])) {
                $form_fields['管理員備註'] = $submission['admin_note'];
            }
            
            foreach ($form_fields as $field => $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $field);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true);
                $row++;
            }
            
            // 設定對齊方式
            $objPHPExcel->getActiveSheet()->getStyle('A1:B'.($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            
            $filename = 'eform02_表單_' . $id . '_' . date('Y-m-d_H-i-s');
            
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

    // Helper methods
    
    
    /**
     * 準備 Excel 匯出資料
     */
    private function _prepare_excel_data($data) {
        $excel_data = [];
        
        // 設定標題列
        $excel_data[] = [
            'ID', '會員姓名', '會員編號', '性別', '年齡', '入會日',
            '見面日', '健康狀況', 'LINE聯絡', '電話聯絡', '提交日期', 
            '建立時間', '狀態', '管理員備註', '訂購產品'
        ];
        
        // 加入資料列
        foreach ($data as $item) {
            // 取得該筆記錄的產品資料
            $products = [];
            if (isset($item['products']) && is_array($item['products'])) {
                foreach ($item['products'] as $product) {
                    $products[] = $product['product_name'] . ': ' . $product['quantity'] . '個';
                }
            }
            $product_summary = implode('; ', $products);
            
            $status_map = [
                'submitted' => '已提交',
                'processing' => '處理中',
                'completed' => '已完成',
                'cancelled' => '已取消'
            ];
            
            $excel_data[] = [
                $item['id'],
                $item['member_name'] ?? '',
                $item['member_id'] ?? '',
                $item['gender'] ?? '',
                $item['age'] ?? '',
                $item['join_date'] ?? '',
                $item['meeting_date'] ?? '',
                $item['skin_health_condition'] ?? '',
                $item['line_contact'] ?? '',
                $item['tel_contact'] ?? '',
                $item['submission_date'] ?? '',
                $item['created_at'] ?? '',
                $status_map[$item['status']] ?? $item['status'],
                $item['admin_note'] ?? '',
                $product_summary
            ];
        }
        
        return $excel_data;
    }
    
    /**
     * 準備單一表單的 Excel 匯出資料
     */
    private function _prepare_single_form_excel_data($submission) {
        $excel_data = [];
        
        // 標題
        $excel_data[] = ['會員服務追蹤管理表(肌膚)', ''];
        $excel_data[] = ['', '']; // 空行
        
        // 基本資料
        $excel_data[] = ['基本資料', ''];
        $excel_data[] = ['會員姓名', $submission['member_name'] ?? ''];
        $excel_data[] = ['會員編號', $submission['member_id'] ?? ''];
        $excel_data[] = ['性別', $submission['gender'] ?? ''];
        $excel_data[] = ['年齡', isset($submission['age']) ? $submission['age'] . ' 歲' : ''];
        $excel_data[] = ['入會日', $submission['join_date'] ?? ''];
        $excel_data[] = ['見面日', $submission['meeting_date'] ?? ''];
        $excel_data[] = ['', '']; // 空行
        
        // 健康狀況
        $excel_data[] = ['健康狀況', ''];
        $excel_data[] = ['肌膚健康狀況', $submission['skin_health_condition'] ?? ''];
        $excel_data[] = ['', '']; // 空行
        
        // 產品訂購
        $excel_data[] = ['產品訂購', ''];
        if (isset($submission['products']) && is_array($submission['products']) && !empty($submission['products'])) {
            foreach ($submission['products'] as $product) {
                $excel_data[] = [$product['product_name'], $product['quantity'] . ' 個'];
            }
        } else {
            $excel_data[] = ['未訂購任何產品', ''];
        }
        $excel_data[] = ['', '']; // 空行
        
        // 聯絡資訊
        $excel_data[] = ['聯絡資訊', ''];
        $excel_data[] = ['LINE聯絡', $submission['line_contact'] ?? ''];
        $excel_data[] = ['電話聯絡', $submission['tel_contact'] ?? ''];
        $excel_data[] = ['', '']; // 空行
        
        // 表單資訊
        $excel_data[] = ['表單資訊', ''];
        $excel_data[] = ['提交日期', $submission['submission_date'] ?? ''];
        $excel_data[] = ['建立時間', $submission['created_at'] ?? ''];
        
        $status_map = [
            'submitted' => '已提交',
            'processing' => '處理中',
            'completed' => '已完成',
            'cancelled' => '已取消'
        ];
        $excel_data[] = ['狀態', $status_map[$submission['status']] ?? $submission['status']];
        
        if (!empty($submission['admin_note'])) {
            $excel_data[] = ['管理員備註', $submission['admin_note']];
        }
        
        return $excel_data;
    }
    
    /**
     * 生成前台表單格式的 HTML
     */
    private function _generate_form_html($submission) {
        // 獲取產品資料
        $products_html = '';
        if (isset($submission['products']) && is_array($submission['products'])) {
            foreach ($submission['products'] as $product) {
                $products_html .= '<p><strong>' . htmlspecialchars($product['product_name']) . ':</strong> ' . intval($product['quantity']) . ' 個</p>';
            }
        }
        if (empty($products_html)) {
            $products_html = '<p>未訂購任何產品</p>';
        }
        
        $html = '<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員服務追蹤管理表(肌膚) - ' . htmlspecialchars($submission['member_name'] ?? '') . '</title>
    <style>
        body {
            font-family: "Microsoft JhengHei", "PingFang TC", "Apple LiGothic Medium", sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .form-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-title {
            text-align: center;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .form-section {
            margin-bottom: 25px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #3498db;
        }
        .form-section h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.2em;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: -5px;
        }
        .form-group {
            flex: 1;
            min-width: 200px;
            margin: 5px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-value {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            min-height: 20px;
            word-wrap: break-word;
        }
        .form-value.empty {
            color: #999;
            font-style: italic;
        }
        .products-section {
            background-color: #e8f5e8;
            border-left-color: #27ae60;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .form-container {
                box-shadow: none;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">會員服務追蹤管理表(肌膚)</h1>
        
        <div class="form-section">
            <h3>基本資料</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>會員姓名</label>
                    <div class="form-value">' . htmlspecialchars($submission['member_name'] ?? '') . '</div>
                </div>
                <div class="form-group">
                    <label>會員編號</label>
                    <div class="form-value">' . htmlspecialchars($submission['member_id'] ?? '') . '</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>性別</label>
                    <div class="form-value">' . htmlspecialchars($submission['gender'] ?? '') . '</div>
                </div>
                <div class="form-group">
                    <label>年齡</label>
                    <div class="form-value">' . (isset($submission['age']) ? intval($submission['age']) . ' 歲' : '') . '</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>入會日</label>
                    <div class="form-value">' . htmlspecialchars($submission['join_date'] ?? '') . '</div>
                </div>
                <div class="form-group">
                    <label>見面日</label>
                    <div class="form-value' . (empty($submission['meeting_date']) ? ' empty' : '') . '">' . 
                    (empty($submission['meeting_date']) ? '(未填寫)' : htmlspecialchars($submission['meeting_date'])) . '</div>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>健康狀況</h3>
            <div class="form-group">
                <label>肌膚健康狀況描述</label>
                <div class="form-value' . (empty($submission['skin_health_condition']) ? ' empty' : '') . '">' .
                (empty($submission['skin_health_condition']) ? '(未填寫)' : nl2br(htmlspecialchars($submission['skin_health_condition']))) . '</div>
            </div>
        </div>
        
        <div class="form-section products-section">
            <h3>產品訂購</h3>
            <div class="form-group">
                <label>訂購產品清單</label>
                <div class="form-value">' . $products_html . '</div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>聯絡資訊</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>LINE 聯絡方式</label>
                    <div class="form-value' . (empty($submission['line_contact']) ? ' empty' : '') . '">' .
                    (empty($submission['line_contact']) ? '(未填寫)' : nl2br(htmlspecialchars($submission['line_contact']))) . '</div>
                </div>
                <div class="form-group">
                    <label>電話聯絡方式</label>
                    <div class="form-value' . (empty($submission['tel_contact']) ? ' empty' : '') . '">' .
                    (empty($submission['tel_contact']) ? '(未填寫)' : nl2br(htmlspecialchars($submission['tel_contact']))) . '</div>
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h3>表單資訊</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>填寫日期</label>
                    <div class="form-value">' . htmlspecialchars($submission['submission_date'] ?? '') . '</div>
                </div>
                <div class="form-group">
                    <label>建立時間</label>
                    <div class="form-value">' . htmlspecialchars($submission['created_at'] ?? '') . '</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';
        
        return $html;
    }

    /**
     * 查詢會員資料
     * GET /api/eeform2/member_lookup/{member_id}
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
            
            // 返回查詢結果
            $result = [
                'count' => count($members),
                'members' => $members,
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
    
    private function _send_success($message, $data = null, $code = 200) {
        $response = [
            'success' => true,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        if ($data !== null) {
            $response['data'] = $data;
        }
        
        http_response_code($code);
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }

    private function _send_error($message, $code = 400, $debug = null) {
        $response = [
            'success' => false,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        if ($debug !== null) {
            $response['debug'] = $debug;
        }
        
        http_response_code($code);
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
}