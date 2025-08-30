<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform2 extends MY_Controller
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
            
            // Load eform02 specific models and services with error handling
            try {
                $this->load->model('eeform/Eeform2Model', 'eform2_model');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform2 model: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                exit();
            }
            
            $this->load->library( 'user_agent' );
            $this->load->helper('url');
            
        } catch (Exception $e) {
            $this->_send_error('Constructor error: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit();
        }
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
     * 刪除表單記錄
     * DELETE /api/eeform2/delete/{id}
     */
    public function delete($id = null) {
        try {
            if (!in_array($this->input->method(TRUE), ['DELETE', 'POST'])) {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id || !is_numeric($id)) {
                $this->_send_error('缺少有效的表單ID', 400);
                return;
            }

            $result = $this->eform2_model->delete_submission($id);
            
            if ($result) {
                $this->_send_success('刪除記錄成功', [
                    'id' => $id
                ]);
            } else {
                $this->_send_error('刪除記錄失敗', 500);
            }

        } catch (Exception $e) {
            $this->_send_error('刪除記錄失敗: ' . $e->getMessage(), 500, [
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
     * GET/PUT /api/eeform2/products
     */
    public function products() {
        try {
            $method = $this->input->method(TRUE);
            
            if ($method === 'GET') {
                // 取得目前的產品設定 - 從 Model 中的 product_mapping 取得
                $product_mapping = $this->_get_product_mapping();
                
                $products = [];
                foreach ($product_mapping as $key => $product) {
                    $product_key = str_replace('product_', '', $key);
                    $products[$product_key] = $product['name'];
                }
                
                $this->_send_success('取得產品設定成功', $products);
                
            } else if ($method === 'PUT' || $method === 'POST') {
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
                
                // 更新 Model 中的產品設定 - 這裡可以將設定寫入設定檔或資料庫
                // 為了示例，我們返回成功
                $result = $this->_update_product_mapping($input_data['products']);
                
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

            // 準備 CSV 資料 (相容性更好)
            $csv_data = $this->_prepare_excel_data($data);
            $filename = 'eform02_會員服務追蹤管理表_' . date('Y-m-d_H-i-s') . '.csv';
            
            // 設定 HTTP headers for file download
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // 輸出 BOM 以支援中文
            echo "\xEF\xBB\xBF";
            
            // 建立檔案指針
            $output = fopen('php://output', 'w');
            
            // 寫入 CSV 資料
            foreach ($csv_data as $row) {
                fputcsv($output, $row);
            }
            
            fclose($output);
            exit();

        } catch (Exception $e) {
            $this->_send_error('匯出 Excel 失敗: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    // Helper methods
    
    /**
     * 取得產品對應表
     */
    private function _get_product_mapping() {
        return [
            'product_soap001' => ['code' => 'SOAP001', 'name' => '淨白活膚蜜皂'],
            'product_soap002' => ['code' => 'SOAP002', 'name' => 'AP柔敏潔顏皂'],
            'product_mask001' => ['code' => 'MASK001', 'name' => '活顏泥膜'],
            'product_toner001' => ['code' => 'TONER001', 'name' => '安露莎化粧水I'],
            'product_toner002' => ['code' => 'TONER002', 'name' => '安露莎化粧水II'],
            'product_toner003' => ['code' => 'TONER003', 'name' => '安露莎活膚化粧水'],
            'product_toner004' => ['code' => 'TONER004', 'name' => '柔敏化粧水'],
            'product_serum001' => ['code' => 'SERUM001', 'name' => '安露莎精華液I'],
            'product_serum002' => ['code' => 'SERUM002', 'name' => '安露莎精華液II'],
            'product_serum003' => ['code' => 'SERUM003', 'name' => '安露莎活膚精華液'],
            'product_serum004' => ['code' => 'SERUM004', 'name' => '美白精華液'],
            'product_lotion001' => ['code' => 'LOTION001', 'name' => '保濕潤膚液'],
            'product_oil001' => ['code' => 'OIL001', 'name' => '美容防皺油'],
            'product_gel001' => ['code' => 'GEL001', 'name' => '保濕凝膠'],
            'product_essence001' => ['code' => 'ESSENCE001', 'name' => '亮采晶萃'],
            'product_sunscreen001' => ['code' => 'SUNSCREEN001', 'name' => '防曬隔離液'],
            'product_foundation001' => ['code' => 'FOUNDATION001', 'name' => '保濕粉底液'],
            'product_powder001' => ['code' => 'POWDER001', 'name' => '絲柔粉餅']
        ];
    }
    
    /**
     * 更新產品對應表 (可以寫入設定檔或資料庫)
     */
    private function _update_product_mapping($products) {
        // 在實際應用中，這裡可以將產品設定寫入設定檔、資料庫或更新Model中的設定
        // 為了示例，我們直接返回 true
        // 
        // 可能的實作方式：
        // 1. 寫入設定檔: file_put_contents(APPPATH . 'config/eform2_products.json', json_encode($products));
        // 2. 更新資料庫設定表
        // 3. 更新 Model 中的設定
        
        try {
            // 將產品設定寫入設定檔
            $config_path = APPPATH . 'config/eform2_products.json';
            $result = file_put_contents($config_path, json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            
            return $result !== false;
        } catch (Exception $e) {
            return false;
        }
    }
    
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