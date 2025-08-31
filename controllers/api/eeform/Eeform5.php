<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5 extends MY_Controller
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
                $this->load->model('eeform/Eeform5Model', 'eform5_model');
            } catch (Exception $e) {
                $this->_send_error('Failed to load eform5 model: ' . $e->getMessage(), 500);
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
     * GET /api/eeform5/health
     */
    public function health() {
        try {
            $health_info = [
                'status' => 'healthy',
                'service' => 'EForm5 API',
                'timestamp' => date('Y-m-d H:i:s'),
                'php_version' => PHP_VERSION,
                'codeigniter_version' => CI_VERSION
            ];

            $this->_send_success('EForm5 API is healthy', $health_info);

        } catch (Exception $e) {
            $this->_send_error('Health check failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 提交表單資料
     * POST /api/eeform5/submit
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
            $required_fields = ['member_name', 'birth_date', 'height'];
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

            // 解析出生年月
            $birth_date = $input_data['birth_date']; // Format: YYYY-MM
            $birth_parts = explode('-', $birth_date);
            $birth_year = (int)$birth_parts[0];
            $birth_month = (int)$birth_parts[1];

            // 準備資料庫資料
            $submission_data = [
                'member_name' => trim($input_data['member_name']),
                'birth_year' => $birth_year,
                'birth_month' => $birth_month,
                'height' => (int)$input_data['height'],
                'has_medication_habit' => isset($input_data['has_medication_habit']) ? (bool)$input_data['has_medication_habit'] : false,
                'medication_name' => isset($input_data['medication_name']) ? trim($input_data['medication_name']) : null,
                'has_family_disease_history' => isset($input_data['has_family_disease_history']) ? (bool)$input_data['has_family_disease_history'] : false,
                'disease_name' => isset($input_data['disease_name']) ? trim($input_data['disease_name']) : null,
                'microcirculation_test' => isset($input_data['microcirculation_test']) ? trim($input_data['microcirculation_test']) : null,
                'dietary_advice' => isset($input_data['dietary_advice']) ? trim($input_data['dietary_advice']) : null,
                'submission_date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'submitted'
            ];

            // 提交表單資料
            $submission_id = $this->eform5_model->create_submission($submission_data);
            
            if (!$submission_id) {
                $this->_send_error('表單提交失敗', 500);
                return;
            }
            
            // 保存職業資料
            if (isset($input_data['occupation']) && is_array($input_data['occupation'])) {
                $occupations = [];
                foreach ($input_data['occupation'] as $occupation) {
                    $occupations[] = [
                        'type' => 'checkbox',
                        'name' => $occupation
                    ];
                }
                $this->eform5_model->save_occupations($submission_id, $occupations);
            }
            
            // 保存健康困擾資料  
            if (isset($input_data['health_concerns']) && is_array($input_data['health_concerns'])) {
                $health_issues = [];
                foreach ($input_data['health_concerns'] as $concern) {
                    $issue = [
                        'code' => str_replace(' ', '_', strtolower($concern)),
                        'name' => $concern
                    ];
                    if ($concern === '其他' && isset($input_data['health_concerns_other'])) {
                        $issue['other_description'] = trim($input_data['health_concerns_other']);
                    }
                    $health_issues[] = $issue;
                }
                $this->eform5_model->save_health_issues($submission_id, $health_issues);
            }
            
            // 保存產品推薦資料
            if (isset($input_data['recommended_products']) && is_array($input_data['recommended_products'])) {
                $product_recommendations = [];
                $dosage_fields = [
                    '活力精萃' => 'energy_essence_dosage',
                    '白鶴靈芝EX' => 'reishi_ex_dosage', 
                    '美力C錠' => 'vitamin_c_dosage',
                    '鶴力晶' => 'energy_crystal_dosage',
                    '白鶴靈芝茶' => 'reishi_tea_dosage'
                ];
                
                foreach ($input_data['recommended_products'] as $product) {
                    $recommendation = [
                        'product_code' => str_replace(' ', '_', strtolower($product)),
                        'product_name' => $product,
                        'dosage' => ''
                    ];
                    
                    if (isset($dosage_fields[$product]) && isset($input_data[$dosage_fields[$product]])) {
                        $recommendation['dosage'] = trim($input_data[$dosage_fields[$product]]);
                    }
                    
                    $product_recommendations[] = $recommendation;
                }
                $this->eform5_model->save_product_recommendations($submission_id, $product_recommendations);
            }
            
            $this->_send_success('表單提交成功', [
                'submission_id' => $submission_id,
                'submission_date' => date('Y-m-d H:i:s')
            ]);

        } catch (Exception $e) {
            $this->_send_error('表單提交失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得表單提交記錄
     * GET /api/eeform5/submissions/{member_id}
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

            $submissions = $this->eform5_model->get_submissions_by_member($member_id);
            
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
     * 取得分頁提交記錄列表 (管理後台用)
     * GET /api/eeform5/list
     */
    public function list() {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            $page = (int)$this->input->get('page', TRUE) ?: 1;
            $limit = (int)$this->input->get('limit', TRUE) ?: 20;
            $search = $this->input->get('search', TRUE);
            $start_date = $this->input->get('start_date', TRUE);
            $end_date = $this->input->get('end_date', TRUE);

            $result = $this->eform5_model->get_all_submissions_paginated($page, $limit, $search, $start_date, $end_date);
            
            $this->_send_success('取得提交記錄列表成功', $result);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄列表失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 取得單一提交記錄詳細資料 (管理後台用)
     * GET /api/eeform5/submission/{id}
     */
    public function submission($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少提交記錄ID', 400);
                return;
            }

            $submission = $this->eform5_model->get_submission_with_details($id);
            
            if (!$submission) {
                $this->_send_error('找不到該提交記錄', 404);
                return;
            }

            $this->_send_success('取得提交記錄詳細資料成功', $submission);

        } catch (Exception $e) {
            $this->_send_error('取得提交記錄詳細資料失敗: ' . $e->getMessage(), 500);
        }
    }

    /**
     * 匯出單一表單 (管理後台用)
     * GET /api/eeform5/export_single/{id}
     */
    public function export_single($id = null) {
        try {
            if ($this->input->method(TRUE) !== 'GET') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            if (!$id) {
                $this->_send_error('缺少提交記錄ID', 400);
                return;
            }

            $submission = $this->eform5_model->get_submission_with_details($id);
            
            if (!$submission) {
                $this->_send_error('找不到該提交記錄', 404);
                return;
            }

            // 匯出Excel
            $this->eform5_model->export_single_submission($submission);

        } catch (Exception $e) {
            $this->_send_error('匯出失敗: ' . $e->getMessage(), 500);
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