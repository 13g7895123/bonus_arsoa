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