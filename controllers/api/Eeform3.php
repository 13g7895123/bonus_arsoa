<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform3 extends MY_Controller
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
            
            // Load eform03 specific models and services with error handling
            try {
                $this->load->model('eeform/eeform3', 'eform3_model');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform3 model: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                exit();
            }
            
            try {
                $this->load->service('eeform/eeform3', 'eform3_service');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform3 service: ' . $e->getMessage(), 500, [
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
                'line' => $e->getLine(),
                'request_data' => [
                    'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                    'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
                    'headers' => getallheaders()
                ]
            ]);
            exit();
        } catch (Throwable $e) {
            $this->_send_error('Fatal constructor error: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit();
        }

        // $this->db = $this->load->database('default', true);
    }

    /**
     * API健康檢查
     * GET /api/eeform3/health
     */
    public function health() {
        try {
            // Test model loading
            $model_test = null;
            $model_error = null;
            try {
                if (isset($this->eform3_model)) {
                    $activity_items = $this->eform3_model->get_activity_items();
                    $model_test = 'Model working - found ' . count($activity_items) . ' activity items';
                } else {
                    $model_error = 'Model not loaded';
                }
            } catch (Exception $e) {
                $model_error = 'Model error: ' . $e->getMessage();
            }
            
            // Test service loading
            $service_test = null;
            $service_error = null;
            try {
                if (isset($this->eform3_service)) {
                    $test_data = ['member_name' => 'test', 'member_id' => 'test', 'age' => 25, 'height' => 170, 'goal' => 'test'];
                    $validation = $this->eform3_service->validate_submission_data($test_data);
                    $service_test = 'Service working - validation result: ' . ($validation['valid'] ? 'valid' : 'invalid');
                } else {
                    $service_error = 'Service not loaded';
                }
            } catch (Exception $e) {
                $service_error = 'Service error: ' . $e->getMessage();
            }
            
            $health_data = [
                'status' => 'OK',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'ci_version' => CI_VERSION,
                'memory_usage' => memory_get_usage(true),
                'loaded_services' => [
                    'eform3_model' => isset($this->eform3_model),
                    'eform3_service' => isset($this->eform3_service)
                ],
                'service_tests' => [
                    'model_test' => $model_test,
                    'model_error' => $model_error,
                    'service_test' => $service_test,
                    'service_error' => $service_error
                ],
                'database_connection' => $this->db ? 'connected' : 'not connected',
                'file_structure' => [
                    'controller_file' => __FILE__,
                    'model_file' => file_exists(APPPATH . 'models/eeform/eeform3.php') ? 'exists' : 'missing',
                    'service_file' => file_exists(APPPATH . 'service/eeform/eeform3.php') ? 'exists' : 'missing'
                ],
                'request_info' => [
                    'method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
                    'uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
                ]
            ];
            
            $this->_send_success('API Health Check', $health_data);
        } catch (Exception $e) {
            $this->_send_error('Health check failed: ' . $e->getMessage(), 500, [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * 取得活動項目列表
     * GET /api/eeform/activity_items
     */
    public function activity_items() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $items = $this->eform3_service->get_activity_items();
            $this->_send_success('取得活動項目成功', $items);
        } catch (Exception $e) {
            $this->_send_error('取得活動項目失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 提交微微卡日記表單
     * POST /api/eeform3/submit
     */
    public function submit() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 檢查服務是否正確載入
            if (!isset($this->eform3_service)) {
                $this->_send_error('eform3_service not loaded', 500, [
                    'debug' => 'Service not available in controller',
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
                $validation_result = $this->eform3_service->validate_submission_data($input_data);
            } catch (Exception $e) {
                $this->_send_error('驗證服務錯誤: ' . $e->getMessage(), 500, [
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
                $submission_id = $this->eform3_service->create_submission($input_data);
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
                $this->_send_success('表單提交成功', [
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
     * GET /api/eeform/submissions/{member_id}
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

            // 取得查詢參數
            $page = (int)$this->input->get('page') ?: 1;
            $limit = (int)$this->input->get('limit') ?: 10;
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $submissions = $this->eform3_service->get_member_submissions(
                $member_id, 
                $page, 
                $limit, 
                $start_date, 
                $end_date
            );

            $this->_send_success('取得提交記錄成功', $submissions);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得單一表單詳細資料
     * GET /api/eeform/submission/{id}
     */
    public function submission($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少表單ID', 400);
                return;
            }

            $submission = $this->eform3_service->get_submission_detail($id);
            
            if ($submission) {
                $this->_send_success('取得表單詳細資料成功', $submission);
            } else {
                $this->_send_error('找不到指定的表單', 404);
            }

        } catch (Exception $e) {
            $this->_send_error('取得表單詳細資料失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 更新表單狀態
     * PUT /api/eeform/submission/{id}/status
     */
    public function update_status($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'PUT') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少表單ID', 400);
                return;
            }

            $input_data = json_decode($this->input->raw_input_stream, true);
            $status = isset($input_data['status']) ? $input_data['status'] : null;

            if (!in_array($status, ['draft', 'submitted', 'reviewed'])) {
                $this->_send_error('無效的狀態值', 400);
                return;
            }

            $result = $this->eform3_service->update_submission_status($id, $status);
            
            if ($result) {
                $this->_send_success('狀態更新成功');
            } else {
                $this->_send_error('狀態更新失敗', 500);
            }

        } catch (Exception $e) {
            $this->_send_error('狀態更新失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得會員統計資料
     * GET /api/eeform/stats/{member_id}
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

            $stats = $this->eform3_service->get_member_stats($member_id);
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