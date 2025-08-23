<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform extends MY_Controller
{
    public function __construct()
    {
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
        
        // Load eform03 specific models and services
        $this->load->model('eeform/eform3', 'eform3_model');
        $this->load->service('eeform/eform3', 'eform3_service');
        
        $this->load->library( 'user_agent' );
        $this->load->helper('url');
        
        // Set JSON response headers for API endpoints
        $this->output->set_content_type('application/json');
        
        // Enable CORS for API requests
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        // Handle preflight OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        // $this->db = $this->load->database('default', true);
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
     * POST /api/eeform/submit
     */
    public function submit() {
        try {
            if ($this->input->method(TRUE) !== 'POST') {
                $this->_send_error('Method not allowed', 405);
                return;
            }

            // 取得POST資料
            $input_data = json_decode($this->input->raw_input_stream, true);
            
            if (!$input_data) {
                $input_data = $this->input->post();
            }

            // 驗證必填欄位
            $validation_result = $this->eform3_service->validate_submission_data($input_data);
            if (!$validation_result['valid']) {
                $this->_send_error('資料驗證失敗', 400, $validation_result['errors']);
                return;
            }

            // 提交表單資料
            $submission_id = $this->eform3_service->create_submission($input_data);
            
            if ($submission_id) {
                $this->_send_success('表單提交成功', [
                    'submission_id' => $submission_id,
                    'submission_date' => date('Y-m-d H:i:s')
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