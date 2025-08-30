<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5Model extends MY_Model {

    protected $table_submissions = 'eeform5_submissions';
    protected $table_occupations = 'eeform5_occupations';
    protected $table_health_issues = 'eeform5_health_issues';
    protected $table_product_recommendations = 'eeform5_product_recommendations';
    protected $table_consultation_records = 'eeform5_consultation_records';

    public function __construct() {
        parent::__construct();
        
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->load->database();
    }

    /**
     * 建立表單提交記錄
     * @param array $data 表單資料
     * @return int|bool 提交記錄ID或false
     */
    public function create_submission($data) {
        try {
            $this->db->trans_start();
            
            // 插入主表數據
            $this->db->insert($this->table_submissions, $data);
            $submission_id = $this->db->insert_id();
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE || !$submission_id) {
                throw new Exception('插入提交記錄失敗');
            }
            
            return $submission_id;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('建立提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得會員的所有提交記錄
     * @param string $member_name 會員姓名
     * @return array
     */
    public function get_submissions_by_member($member_name) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_submissions);
            $this->db->where('member_name', $member_name);
            $this->db->order_by('created_at', 'DESC');
            
            $query = $this->db->get();
            $submissions = $query->result_array();
            
            return $submissions;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 根據ID取得單一提交記錄
     * @param int $id 提交記錄ID
     * @return array|null
     */
    public function get_submission_by_id($id) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_submissions);
            $this->db->where('id', $id);
            
            $query = $this->db->get();
            $submission = $query->row_array();
            
            return $submission;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 更新提交記錄
     * @param int $id 提交記錄ID
     * @param array $data 更新資料
     * @return bool
     */
    public function update_submission($id, $data) {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->db->where('id', $id);
            $result = $this->db->update($this->table_submissions, $data);
            
            return $result;
            
        } catch (Exception $e) {
            throw new Exception('更新提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 刪除提交記錄
     * @param int $id 提交記錄ID
     * @return bool
     */
    public function delete_submission($id) {
        try {
            $this->db->trans_start();
            
            // 刪除主記錄
            $this->db->where('id', $id);
            $this->db->delete($this->table_submissions);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('刪除提交記錄失敗');
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('刪除提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 保存職業資料
     * @param int $submission_id 提交記錄ID
     * @param array $occupations 職業資料
     * @return bool
     */
    public function save_occupations($submission_id, $occupations) {
        try {
            $this->db->trans_start();
            
            // 刪除現有記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_occupations);
            
            // 插入新記錄
            foreach ($occupations as $occupation) {
                $data = [
                    'submission_id' => $submission_id,
                    'occupation_type' => $occupation['type'],
                    'occupation_name' => $occupation['name']
                ];
                $this->db->insert($this->table_occupations, $data);
            }
            
            $this->db->trans_complete();
            
            return $this->db->trans_status() !== FALSE;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存職業資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 保存健康困擾資料
     * @param int $submission_id 提交記錄ID
     * @param array $health_issues 健康困擾資料
     * @return bool
     */
    public function save_health_issues($submission_id, $health_issues) {
        try {
            $this->db->trans_start();
            
            // 刪除現有記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_health_issues);
            
            // 插入新記錄
            foreach ($health_issues as $issue) {
                $data = [
                    'submission_id' => $submission_id,
                    'issue_code' => $issue['code'],
                    'issue_name' => $issue['name'],
                    'other_description' => isset($issue['other_description']) ? $issue['other_description'] : null,
                    'severity' => isset($issue['severity']) ? $issue['severity'] : null
                ];
                $this->db->insert($this->table_health_issues, $data);
            }
            
            $this->db->trans_complete();
            
            return $this->db->trans_status() !== FALSE;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存健康困擾資料失敗: ' . $e->getMessage());
        }
    }
}