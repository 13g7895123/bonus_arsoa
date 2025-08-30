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
                $this->load->model('eeform/Eeform3Model', 'eform3_model');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform3 model: ' . $e->getMessage(), 500, [
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                exit();
            }
            
            // Service layer removed - all functionality moved to model
            
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
            
            // Test model validation functionality
            $validation_test = null;
            $validation_error = null;
            try {
                if (isset($this->eform3_model)) {
                    $test_data = ['member_name' => 'test', 'member_id' => 'test', 'age' => 25, 'height' => 170, 'goal' => 'test'];
                    $validation = $this->eform3_model->validate_submission_data($test_data);
                    $validation_test = 'Model validation working - result: ' . ($validation['valid'] ? 'valid' : 'invalid');
                } else {
                    $validation_error = 'Model validation not available';
                }
            } catch (Exception $e) {
                $validation_error = 'Model validation error: ' . $e->getMessage();
            }
            
            $health_data = [
                'status' => 'OK',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'ci_version' => CI_VERSION,
                'memory_usage' => memory_get_usage(true),
                'loaded_services' => [
                    'eform3_model' => isset($this->eform3_model),
                    'all_properties' => array_keys(get_object_vars($this))
                ],
                'model_tests' => [
                    'activity_items_test' => $model_test,
                    'activity_items_error' => $model_error,
                    'validation_test' => $validation_test,
                    'validation_error' => $validation_error
                ],
                'database_connection' => $this->db ? 'connected' : 'not connected',
                'file_structure' => [
                    'controller_file' => __FILE__,
                    'model_file' => file_exists(APPPATH . 'models/eeform/Eeform3Model.php') ? 'exists' : 'missing'
                ],
                'class_info' => [
                    'model_class_exists' => class_exists('Eeform3Model') ? 'yes' : 'no'
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

            $items = $this->eform3_model->get_activity_items();
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

            // 檢查model是否正確載入
            if (!isset($this->eform3_model)) {
                $this->_send_error('eform3_model not loaded', 500, [
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
                $validation_result = $this->eform3_model->validate_submission_data($input_data);
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
                $submission_id = $this->eform3_model->create_submission($input_data);
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

            // Add debugging for the member_id received
            $debug_info = [
                'member_id_received' => $member_id,
                'member_id_length' => strlen($member_id),
                'member_id_type' => gettype($member_id)
            ];

            // Check if database tables exist
            try {
                $tables_exist = $this->_check_database_tables();
                $debug_info['tables_check'] = $tables_exist;
            } catch (Exception $e) {
                $this->_send_error('Database tables check failed: ' . $e->getMessage(), 500, [
                    'debug_info' => $debug_info,
                    'trace' => $e->getTraceAsString()
                ]);
                return;
            }

            // 取得查詢參數
            $page = (int)$this->input->get('page') ?: 1;
            $limit = (int)$this->input->get('limit') ?: 10;
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');

            $submissions = $this->eform3_model->get_member_submissions_enhanced(
                $member_id, 
                $page, 
                $limit, 
                $start_date, 
                $end_date
            );

            $this->_send_success('取得提交記錄成功', $submissions);

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
     * GET /api/eeform3/submission/{id}
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

                $submission = $this->eform3_model->get_submission_detail_enhanced($id);
                
                if ($submission) {
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
     * POST /api/eeform3/update/{id}
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
            $validation_result = $this->eform3_model->validate_submission_data($input_data);
            if (!$validation_result['valid']) {
                $this->_send_error('資料驗證失敗', 400, $validation_result['errors']);
                return;
            }

            // 更新表單資料
            $result = $this->eform3_model->update_submission($id, $input_data);
            
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

            $result = $this->eform3_model->update_submission_status_enhanced($id, $status);
            
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

            $stats = $this->eform3_model->get_member_stats_enhanced($member_id);
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

    /**
     * Check if required database tables exist
     * @return array
     */
    private function _check_database_tables() {
        $required_tables = [
            'eeform3_submissions',
            'eeform3_body_data', 
            'eeform3_activity_items',
            'eeform3_activity_records',
            'eeform3_plans'
        ];
        
        $table_status = [];
        $missing_tables = [];
        
        foreach ($required_tables as $table) {
            try {
                $this->db->select('1');
                $this->db->from($table);
                $this->db->limit(1);
                $query = $this->db->get();
                $table_status[$table] = 'exists';
            } catch (Exception $e) {
                $table_status[$table] = 'missing';
                $missing_tables[] = $table;
            }
        }
        
        // If tables are missing, try to create them
        if (!empty($missing_tables)) {
            $create_result = $this->_create_database_tables($missing_tables);
            foreach ($create_result as $table => $result) {
                $table_status[$table] = $result;
            }
        }
        
        return $table_status;
    }

    /**
     * Create missing database tables
     * @param array $missing_tables
     * @return array
     */
    private function _create_database_tables($missing_tables) {
        $results = [];
        
        // Table creation SQL statements
        $table_sqls = [
            'eeform3_submissions' => "
                CREATE TABLE eeform3_submissions (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
                    member_id VARCHAR(50) NOT NULL COMMENT '會員編號',
                    age TINYINT UNSIGNED NOT NULL COMMENT '年齡',
                    height SMALLINT UNSIGNED NOT NULL COMMENT '身高(cm)',
                    goal TEXT NOT NULL COMMENT '目標',
                    action_plan_1 TEXT NULL COMMENT '自身行動計畫1',
                    action_plan_2 TEXT NULL COMMENT '自身行動計畫2',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
                    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
                    submission_date DATE NOT NULL COMMENT '填寫日期',
                    
                    INDEX idx_member_id (member_id),
                    INDEX idx_submission_date (submission_date),
                    INDEX idx_status (status),
                    INDEX idx_created_at (created_at)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='微微卡日記表單主表'
            ",
            'eeform3_body_data' => "
                CREATE TABLE eeform3_body_data (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    submission_id INT NOT NULL COMMENT '表單提交ID',
                    weight DECIMAL(5,2) NULL COMMENT '體重(公斤)',
                    blood_pressure_high SMALLINT UNSIGNED NULL COMMENT '收縮壓',
                    blood_pressure_low SMALLINT UNSIGNED NULL COMMENT '舒張壓',
                    waist DECIMAL(5,2) NULL COMMENT '腰圍(公分)',
                    measurement_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '測量時間',
                    
                    FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE,
                    INDEX idx_submission_id (submission_id),
                    INDEX idx_measurement_time (measurement_time)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='身體數據記錄表'
            ",
            'eeform3_activity_items' => "
                CREATE TABLE eeform3_activity_items (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    item_key VARCHAR(50) NOT NULL UNIQUE COMMENT '活動項目鍵值',
                    item_name VARCHAR(100) NOT NULL COMMENT '活動項目名稱',
                    description TEXT NULL COMMENT '項目描述',
                    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
                    sort_order INT DEFAULT 0 COMMENT '排序順序',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    
                    INDEX idx_item_key (item_key),
                    INDEX idx_is_active (is_active),
                    INDEX idx_sort_order (sort_order)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活動項目主表'
            ",
            'eeform3_activity_records' => "
                CREATE TABLE eeform3_activity_records (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    submission_id INT NOT NULL COMMENT '表單提交ID',
                    activity_item_id INT NOT NULL COMMENT '活動項目ID',
                    is_completed BOOLEAN DEFAULT FALSE COMMENT '是否完成',
                    completion_time TIMESTAMP NULL COMMENT '完成時間',
                    notes TEXT NULL COMMENT '備註',
                    
                    FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE,
                    FOREIGN KEY (activity_item_id) REFERENCES eeform3_activity_items(id) ON DELETE CASCADE,
                    UNIQUE KEY uk_submission_activity (submission_id, activity_item_id),
                    INDEX idx_submission_id (submission_id),
                    INDEX idx_activity_item_id (activity_item_id),
                    INDEX idx_is_completed (is_completed)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活動完成記錄表'
            ",
            'eeform3_plans' => "
                CREATE TABLE eeform3_plans (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    submission_id INT NOT NULL COMMENT '表單提交ID',
                    plan_type ENUM('plan_a', 'plan_b', 'other') NOT NULL COMMENT '計畫類型',
                    plan_content TEXT NOT NULL COMMENT '計畫內容',
                    priority TINYINT DEFAULT 1 COMMENT '優先順序',
                    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending' COMMENT '執行狀態',
                    target_date DATE NULL COMMENT '目標完成日期',
                    actual_completion_date DATE NULL COMMENT '實際完成日期',
                    
                    FOREIGN KEY (submission_id) REFERENCES eeform3_submissions(id) ON DELETE CASCADE,
                    INDEX idx_submission_id (submission_id),
                    INDEX idx_plan_type (plan_type),
                    INDEX idx_status (status),
                    INDEX idx_target_date (target_date)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='個人計畫記錄表'
            "
        ];
        
        foreach ($missing_tables as $table) {
            if (isset($table_sqls[$table])) {
                try {
                    $this->db->query($table_sqls[$table]);
                    $results[$table] = 'created';
                    
                    // Insert initial data for activity_items table
                    if ($table === 'eeform3_activity_items') {
                        $this->_insert_initial_activity_items();
                    }
                } catch (Exception $e) {
                    $results[$table] = 'create_failed: ' . $e->getMessage();
                }
            } else {
                $results[$table] = 'no_sql_found';
            }
        }
        
        return $results;
    }

    /**
     * Insert initial activity items data
     */
    private function _insert_initial_activity_items() {
        $items = [
            ['item_key' => 'hand_measure', 'item_name' => '用手測量', 'sort_order' => 1],
            ['item_key' => 'exercise', 'item_name' => '運動(30分)', 'sort_order' => 2],
            ['item_key' => 'health_supplement', 'item_name' => '保健食品', 'sort_order' => 3],
            ['item_key' => 'weika', 'item_name' => '微微卡', 'sort_order' => 4],
            ['item_key' => 'water_intake', 'item_name' => '飲水量', 'sort_order' => 5]
        ];
        
        foreach ($items as $item) {
            try {
                $this->db->insert('eeform3_activity_items', $item);
            } catch (Exception $e) {
                // Ignore duplicate key errors
            }
        }
    }
}