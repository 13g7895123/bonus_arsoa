<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform4 extends MY_Controller
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
        
        try {
            parent::__construct();
            _timer('*** controllers start ***');

            $this->load->model( 'front_member_model' );
            $this->load->model( 'front_base_model' );
            $this->load->model( 'front_mssql_model' );

            $this->load->model( 'eform/Form1Model' );
            $this->load->model( 'eform/Form2Model' );
            $this->load->model( 'eform/Form3Model' );
            $this->load->model( 'eform/Form4Model' );
            $this->load->model( 'eform/Form5Model' );
            $this->load->model( 'eform/Form6Model' );
            $this->load->model( 'eform/Form7Model' );
            $this->load->model( 'eform/CommonModel' );
            
            try {
                $this->load->model('eeform/Eeform4Model', 'eform4_model');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform4 model: ' . $e->getMessage(), 500);
                exit();
            }
            
            $this->load->library( 'user_agent' );
            $this->load->helper('url');
            
        } catch (Exception $e) {
            $this->_send_error('Constructor error: ' . $e->getMessage(), 500);
            exit();
        }
    }

    /**
     * API健康檢查
     * GET /api/eeform4/health
     */
    public function health() {
        try {
            $health_info = [
                'status' => 'healthy',
                'service' => 'EForm4 API',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'codeigniter_version' => CI_VERSION
            ];

            $this->_send_success('EForm4 API is healthy', $health_info);

        } catch (Exception $e) {
            $this->_send_error('Health check failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 提交表單資料
     * POST /api/eeform4/submit
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
                $this->_send_error('沒有接收到資料', 400);
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
            $submission_id = $this->eform4_model->create_submission($submission_data);
            
            if ($submission_id) {
                // 收集產品資料
                $products = [];
                $product_fields = [
                    'product_energy_essence001',
                    'product_reishi_ex001', 
                    'product_vitamin_c001',
                    'product_energy_crystal001',
                    'product_reishi_tea001',
                    'product_soap001',
                    'product_mask001',
                    'product_toner001'
                ];
                
                foreach ($product_fields as $field) {
                    if (isset($input_data[$field]) && !empty($input_data[$field]) && (int)$input_data[$field] > 0) {
                        $products[$field] = [
                            'quantity' => (int)$input_data[$field]
                        ];
                    }
                }
                
                // 保存產品資料
                log_message('debug', 'Controller: 收集到的產品資料: ' . json_encode($products));
                log_message('debug', 'Controller: 產品數量: ' . count($products));
                
                if (!empty($products)) {
                    try {
                        $result = $this->eform4_model->save_products($submission_id, $products);
                        log_message('debug', 'Controller: 產品保存結果: ' . ($result ? 'success' : 'failed'));
                    } catch (Exception $e) {
                        // 如果產品保存失敗，記錄錯誤但不回傳失敗
                        log_message('error', 'eform4產品保存失敗: ' . $e->getMessage());
                        log_message('error', 'eform4產品保存失敗 trace: ' . $e->getTraceAsString());
                    }
                } else {
                    log_message('debug', 'Controller: 沒有產品資料需要保存');
                }
                
                $this->_send_success('表單提交成功', [
                    'submission_id' => $submission_id,
                    'submission_date' => date('Y-m-d H:i:s'),
                    'products_saved' => count($products)
                ]);
            } else {
                $this->_send_error('表單提交失敗', 500);
            }

        } catch (Exception $e) {
            $this->_send_error('表單提交失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得表單提交記錄
     * GET /api/eeform4/submissions/{member_id}
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

            $submissions = $this->eform4_model->get_submissions_by_member($member_id);
            
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
     * 取得單一表單記錄
     * GET /api/eeform4/submission/{id}
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

            $submission = $this->eform4_model->get_submission_by_id($id);
            
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
     * GET /api/eeform4/list
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

            $result = $this->eform4_model->get_all_submissions_paginated($page, $limit, $filters);
            
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
     * PUT /api/eeform4/update_status/{id}
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

            $result = $this->eform4_model->update_submission_status($id, $update_data);
            
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
     * GET /api/eeform4/stats
     */
    public function stats() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $stats = $this->eform4_model->get_submission_stats();
            
            $this->_send_success('取得統計資料成功', $stats);

        } catch (Exception $e) {
            $this->_send_error('取得統計資料失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 取得/更新產品設定
     * GET/POST /api/eeform4/products
     */
    public function products() {
        try {
            $method = $this->input->method(TRUE);
            
            if ($method === 'GET') {
                // 從資料庫取得產品設定
                $products = $this->eform4_model->get_all_products();
                
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
                $result = $this->eform4_model->batch_update_products($input_data['products']);
                
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
     * 匯出單一表單 (Excel格式)
     * GET /api/eeform4/export_single/{id}
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

            $submission = $this->eform4_model->get_submission_by_id($id);
            
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
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '會員服務追蹤管理表(保健)');
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
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, '肌膚/健康狀況');
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
            
            $filename = 'eform04_表單_' . $id . '_' . date('Y-m-d_H-i-s');
            
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
     * 查詢會員資料
     * GET /api/eeform4/member_lookup/{member_id}
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

    // Helper methods
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