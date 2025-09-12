<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform5Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }

    /**
     * 提交表單資料
     */
    public function submit_form($data)
    {
        $this->db->trans_start();

        try {
            // 準備主要表單資料
            $submission_data = array(
                'member_name' => $data['member_name'],
                'member_id' => $data['member_id'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'age' => $data['age'],
                'height' => $data['height'],
                'exercise_habit' => $data['exercise_habit'],
                
                // 體測標準建議值
                'weight' => $data['weight'],
                'bmi' => $data['bmi'],
                'fat_percentage' => $data['fat_percentage'],
                'fat_mass' => $data['fat_mass'],
                'muscle_percentage' => $data['muscle_percentage'],
                'muscle_mass' => $data['muscle_mass'],
                'water_percentage' => $data['water_percentage'],
                'water_content' => $data['water_content'],
                'visceral_fat_percentage' => $data['visceral_fat_percentage'],
                'bone_mass' => $data['bone_mass'],
                'bmr' => $data['bmr'],
                'protein_percentage' => $data['protein_percentage'],
                'obesity_percentage' => $data['obesity_percentage'],
                'body_age' => $data['body_age'],
                'lean_body_mass' => $data['lean_body_mass'],
                
                // 其他資料
                'has_medication_habit' => $data['has_medication_habit'],
                'medication_name' => $data['medication_name'],
                'has_family_disease_history' => $data['has_family_disease_history'],
                'disease_name' => $data['disease_name'],
                'microcirculation_test' => $data['microcirculation_test'],
                'dietary_advice' => $data['dietary_advice'],
                'health_concerns_other' => $data['health_concerns_other'],
                
                'submission_date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'submitted'
            );

            // 插入主表單
            $this->db->insert('eeform5_submissions', $submission_data);
            $submission_id = $this->db->insert_id();

            if (!$submission_id) {
                throw new Exception('無法插入主表單資料');
            }

            // 插入職業資料
            if (isset($data['occupation']) && is_array($data['occupation'])) {
                foreach ($data['occupation'] as $occupation) {
                    $occupation_data = array(
                        'submission_id' => $submission_id,
                        'occupation_type' => $occupation
                    );
                    $this->db->insert('eeform5_occupations', $occupation_data);
                }
            }

            // 插入健康困擾資料
            if (isset($data['health_concerns']) && is_array($data['health_concerns'])) {
                foreach ($data['health_concerns'] as $concern) {
                    $health_data = array(
                        'submission_id' => $submission_id,
                        'concern_type' => $concern
                    );
                    $this->db->insert('eeform5_health_concerns', $health_data);
                }
            }

            // 插入建議產品資料
            if (isset($data['recommended_products']) && is_array($data['recommended_products'])) {
                // 建立產品名稱與dosage欄位的對應表
                $product_dosage_map = array(
                    '活力精萃' => 'energy_essence_dosage',
                    '白鶴靈芝EX' => 'reishi_ex_dosage', 
                    '美力C錠' => 'vitamin_c_dosage',
                    '鶴力晶' => 'energy_crystal_dosage',
                    '白鶴靈芝茶' => 'reishi_tea_dosage'
                );
                
                foreach ($data['recommended_products'] as $product) {
                    $dosage_field = isset($product_dosage_map[$product]) ? $product_dosage_map[$product] : '';
                    $recommended_dosage = '';
                    
                    if ($dosage_field && isset($data['product_dosages'][$dosage_field])) {
                        $recommended_dosage = $data['product_dosages'][$dosage_field];
                    }
                    
                    $product_data = array(
                        'submission_id' => $submission_id,
                        'product_name' => $product,
                        'recommended_dosage' => $recommended_dosage
                    );
                    $this->db->insert('eeform5_product_recommendations', $product_data);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('資料庫交易失敗');
            }

            return array(
                'success' => true,
                'message' => '表單提交成功',
                'submission_id' => $submission_id
            );

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Eeform5Model submit_form error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => '提交失敗：' . $e->getMessage()
            );
        }
    }

    /**
     * 取得表單資料
     */
    public function get_submission_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('eeform5_submissions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $submission = $query->row_array();
            
            // 取得職業資料
            $this->db->select('occupation_type');
            $this->db->from('eeform5_occupations');
            $this->db->where('submission_id', $id);
            $occupation_query = $this->db->get();
            $submission['occupations'] = $occupation_query->result_array();
            
            // 取得健康困擾資料
            $this->db->select('concern_type');
            $this->db->from('eeform5_health_concerns');
            $this->db->where('submission_id', $id);
            $health_query = $this->db->get();
            $submission['health_concerns'] = $health_query->result_array();
            
            // 取得產品資料
            $this->db->select('product_name, recommended_dosage');
            $this->db->from('eeform5_product_recommendations');
            $this->db->where('submission_id', $id);
            $product_query = $this->db->get();
            $submission['products'] = $product_query->result_array();
            
            return $submission;
        }
        
        return false;
    }

    /**
     * 取得所有提交記錄 (分頁)
     */
    public function get_all_submissions_paginated($page = 1, $limit = 20, $search = null, $status = null, $date_from = null, $date_to = null)
    {
        $offset = ($page - 1) * $limit;
        
        $this->db->select('id, member_name, member_id, phone, gender, age, height, has_medication_habit, has_family_disease_history, submission_date, status, created_at');
        $this->db->from('eeform5_submissions');
        
        // 搜尋條件
        if ($search) {
            $this->db->group_start();
            $this->db->like('member_name', $search);
            $this->db->or_like('phone', $search);
            $this->db->group_end();
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($date_from) {
            $this->db->where('submission_date >=', $date_from);
        }
        
        if ($date_to) {
            $this->db->where('submission_date <=', $date_to);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        $results = $query->result_array();
        
        // 計算總數
        $this->db->select('COUNT(*) as total');
        $this->db->from('eeform5_submissions');
        
        // 重複搜尋條件
        if ($search) {
            $this->db->group_start();
            $this->db->like('member_name', $search);
            $this->db->or_like('phone', $search);
            $this->db->group_end();
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($date_from) {
            $this->db->where('submission_date >=', $date_from);
        }
        
        if ($date_to) {
            $this->db->where('submission_date <=', $date_to);
        }
        
        $count_query = $this->db->get();
        $total = $count_query->row()->total;
        
        return array(
            'data' => $results,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total / $limit)
        );
    }

    /**
     * 取得會員的所有提交記錄
     * @param string $member_id 會員編號
     * @return array
     */
    public function get_submissions_by_member($member_id) {
        try {
            $this->db->select('*');
            $this->db->from('eeform5_submissions');
            $this->db->where('member_id', $member_id);
            $this->db->order_by('created_at', 'DESC');
            
            $query = $this->db->get();
            $submissions = $query->result_array();
            
            return $submissions;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 更新表單狀態
     */
    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('eeform5_submissions', array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        return $this->db->affected_rows() > 0;
    }

    /**
     * 檢查資料表是否存在
     */
    public function check_table_exists()
    {
        return $this->db->table_exists('eeform5_submissions');
    }

    /**
     * 創建新的eform5資料表
     */
    public function create_tables()
    {
        // 主表單
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'member_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'member_id' => array('type' => 'VARCHAR', 'constraint' => '50', 'null' => FALSE),
            'phone' => array('type' => 'VARCHAR', 'constraint' => '20', 'null' => FALSE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'gender' => array('type' => 'ENUM', 'constraint' => array('男', '女'), 'null' => FALSE),
            'age' => array('type' => 'INT', 'constraint' => 3, 'null' => FALSE),
            'height' => array('type' => 'DECIMAL', 'constraint' => '5,1', 'null' => TRUE),
            'exercise_habit' => array('type' => 'ENUM', 'constraint' => array('是', '否'), 'null' => TRUE),
            
            // 體測數據
            'weight' => array('type' => 'DECIMAL', 'constraint' => '5,1', 'null' => TRUE),
            'bmi' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'fat_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'fat_mass' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'muscle_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'muscle_mass' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'water_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'water_content' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'visceral_fat_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'bone_mass' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'bmr' => array('type' => 'INT', 'constraint' => 5, 'null' => TRUE),
            'protein_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'obesity_percentage' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            'body_age' => array('type' => 'INT', 'constraint' => 3, 'null' => TRUE),
            'lean_body_mass' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE),
            
            // 其他資料
            'has_medication_habit' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            'medication_name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
            'has_family_disease_history' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
            'disease_name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
            'microcirculation_test' => array('type' => 'TEXT', 'null' => TRUE),
            'dietary_advice' => array('type' => 'TEXT', 'null' => TRUE),
            'health_concerns_other' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
            
            'submission_date' => array('type' => 'DATE', 'null' => FALSE),
            'status' => array('type' => 'ENUM', 'constraint' => array('draft','submitted','reviewed','completed'), 'default' => 'submitted'),
            'created_at' => array('type' => 'TIMESTAMP', 'null' => FALSE),
            'updated_at' => array('type' => 'TIMESTAMP', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('eeform5_submissions');

        // 職業表
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'submission_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'occupation_type' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'created_at' => array('type' => 'TIMESTAMP', 'null' => FALSE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('eeform5_occupations');

        // 健康困擾表
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'submission_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'concern_type' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'created_at' => array('type' => 'TIMESTAMP', 'null' => FALSE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('eeform5_health_concerns');

        // 產品表
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'submission_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'product_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'recommended_dosage' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
            'created_at' => array('type' => 'TIMESTAMP', 'null' => FALSE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('eeform5_product_recommendations');

        return true;
    }

    /**
     * 更新表單記錄（用於編輯功能）
     */
    public function update_submission($id, $data)
    {
        $this->db->trans_start();

        try {
            // 先檢查記錄是否存在
            $this->db->where('id', $id);
            $query = $this->db->get('eeform5_submissions');
            
            if ($query->num_rows() == 0) {
                throw new Exception('找不到指定的表單記錄');
            }

            // 準備主要表單更新資料
            $update_data = array(
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'age' => $data['age'],
                'height' => $data['height'],
                'exercise_habit' => $data['exercise_habit'],
                
                // 體測標準建議值 - 添加null值檢查
                'weight' => $data['weight'] ?? null,
                'bmi' => $data['bmi'] ?? null,
                'fat_percentage' => $data['fat_percentage'] ?? null,
                'fat_mass' => $data['fat_mass'] ?? null,
                'muscle_percentage' => $data['muscle_percentage'] ?? null,
                'muscle_mass' => $data['muscle_mass'] ?? null,
                'water_percentage' => $data['water_percentage'] ?? null,
                'water_content' => $data['water_content'] ?? null,
                'visceral_fat_percentage' => $data['visceral_fat_percentage'] ?? null,
                'bone_mass' => $data['bone_mass'] ?? null,
                'bmr' => $data['bmr'] ?? null,
                'protein_percentage' => $data['protein_percentage'] ?? null,
                'obesity_percentage' => $data['obesity_percentage'] ?? null,
                'body_age' => $data['body_age'] ?? null,
                'lean_body_mass' => $data['lean_body_mass'] ?? null,
                
                // 其他資料 - 添加null值檢查
                'has_medication_habit' => $data['has_medication_habit'] ?? null,
                'medication_name' => $data['medication_name'] ?? null,
                'has_family_disease_history' => $data['has_family_disease_history'] ?? null,
                'disease_name' => $data['disease_name'] ?? null,
                'microcirculation_test' => $data['microcirculation_test'] ?? null,
                'dietary_advice' => $data['dietary_advice'] ?? null,
                'health_concerns_other' => $data['health_concerns_other'] ?? null,
                
                'updated_at' => date('Y-m-d H:i:s')
            );

            // 更新主表單
            $this->db->where('id', $id);
            $this->db->update('eeform5_submissions', $update_data);

            if ($this->db->affected_rows() == 0) {
                log_message('info', 'No rows affected in main table update, but continuing...');
            }

            // 注意：職業、健康困擾、產品建議等關聯資料在編輯模式中通常以顯示文字形式呈現
            // 如果需要更新這些關聯資料，可以在這裡添加相關邏輯
            // 目前先專注於主要欄位的更新

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                throw new Exception('資料庫更新失敗');
            }

            return array(
                'success' => true,
                'message' => '表單更新成功',
                'submission_id' => $id
            );

        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Eeform5Model update_submission error: ' . $e->getMessage());
            return array(
                'success' => false,
                'message' => '更新失敗：' . $e->getMessage()
            );
        }
    }
}