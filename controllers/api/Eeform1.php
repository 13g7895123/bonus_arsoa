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
     * 取得單一表單詳細資料
     * GET /api/eeform1/submission/{id}
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