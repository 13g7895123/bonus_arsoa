<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform2Model extends MY_Model {

    protected $table_submissions = 'eeform2_submissions';
    protected $table_products = 'eeform2_products';
    protected $table_product_master = 'eeform2_product_master';
    protected $table_contact_history = 'eeform2_contact_history';

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
     * 保存產品資料
     * @param int $submission_id 提交記錄ID
     * @param array $products 產品資料
     * @return bool
     */
    public function save_products($submission_id, $products) {
        try {
            $this->db->trans_start();
            
            // 刪除現有的產品記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_products);
            
            // 產品代碼映射
            $product_mapping = [
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
            
            // 插入產品記錄
            foreach ($products as $key => $product) {
                if (isset($product_mapping[$key])) {
                    $quantity = isset($product['quantity']) ? (int)$product['quantity'] : 0;
                    
                    if ($quantity > 0) {
                        $product_data = [
                            'submission_id' => $submission_id,
                            'product_code' => $product_mapping[$key]['code'],
                            'product_name' => $product_mapping[$key]['name'],
                            'quantity' => $quantity
                        ];
                        
                        $this->db->insert($this->table_products, $product_data);
                    }
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('保存產品資料失敗');
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('保存產品資料失敗: ' . $e->getMessage());
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
            
            // 為每個提交記錄加載產品數據
            foreach ($submissions as &$submission) {
                $submission['products'] = $this->get_products_by_submission($submission['id']);
            }
            
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
            
            if ($submission) {
                $submission['products'] = $this->get_products_by_submission($id);
            }
            
            return $submission;
            
        } catch (Exception $e) {
            throw new Exception('取得提交記錄失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得提交記錄的產品數據
     * @param int $submission_id 提交記錄ID
     * @return array
     */
    public function get_products_by_submission($submission_id) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('submission_id', $submission_id);
            $this->db->order_by('product_code', 'ASC');
            
            $query = $this->db->get();
            return $query->result_array();
            
        } catch (Exception $e) {
            throw new Exception('取得產品資料失敗: ' . $e->getMessage());
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
            
            // 刪除相關產品記錄
            $this->db->where('submission_id', $id);
            $this->db->delete($this->table_products);
            
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
     * 取得統計資料
     * @param string $member_name 會員姓名
     * @return array
     */
    public function get_stats_by_member($member_name) {
        try {
            // 基本統計
            $this->db->select('COUNT(*) as total_submissions');
            $this->db->from($this->table_submissions);
            $this->db->where('member_name', $member_name);
            $query = $this->db->get();
            $stats = $query->row_array();
            
            // 最近提交日期
            $this->db->select('MAX(submission_date) as last_submission_date');
            $this->db->from($this->table_submissions);
            $this->db->where('member_name', $member_name);
            $query = $this->db->get();
            $last_submission = $query->row_array();
            
            $stats['last_submission_date'] = $last_submission['last_submission_date'];
            
            // 產品訂購統計
            $this->db->select('SUM(p.quantity) as total_products_ordered');
            $this->db->from($this->table_products . ' p');
            $this->db->join($this->table_submissions . ' s', 's.id = p.submission_id');
            $this->db->where('s.member_name', $member_name);
            $query = $this->db->get();
            $product_stats = $query->row_array();
            
            $stats['total_products_ordered'] = (int)$product_stats['total_products_ordered'];
            
            return $stats;
            
        } catch (Exception $e) {
            throw new Exception('取得統計資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 管理員取得所有提交記錄 (分頁)
     * @param int $page 頁碼
     * @param int $limit 每頁筆數
     * @param array $filters 篩選條件
     * @return array
     */
    public function get_all_submissions_paginated($page = 1, $limit = 20, $filters = []) {
        try {
            $offset = ($page - 1) * $limit;
            
            // 構建查詢
            $this->db->select('*');
            $this->db->from($this->table_submissions);
            
            // 套用篩選條件
            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $this->db->group_start();
                $this->db->like('member_name', $search);
                $this->db->or_like('line_contact', $search);
                $this->db->or_like('tel_contact', $search);
                $this->db->group_end();
            }
            
            if (!empty($filters['status'])) {
                $this->db->where('status', $filters['status']);
            }
            
            if (!empty($filters['start_date'])) {
                $this->db->where('submission_date >=', $filters['start_date']);
            }
            
            if (!empty($filters['end_date'])) {
                $this->db->where('submission_date <=', $filters['end_date']);
            }
            
            // 取得總數量
            $total_query = clone $this->db;
            $total = $total_query->count_all_results();
            
            // 套用分頁和排序
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit($limit, $offset);
            
            $query = $this->db->get();
            $data = $query->result_array();
            
            // 為每個提交記錄加載產品數據
            foreach ($data as &$submission) {
                $submission['products'] = $this->get_products_by_submission($submission['id']);
            }
            
            return [
                'data' => $data,
                'total' => $total
            ];
            
        } catch (Exception $e) {
            throw new Exception('取得分頁資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 更新提交記錄狀態
     * @param int $id 提交記錄ID
     * @param array $data 更新資料
     * @return bool
     */
    public function update_submission_status($id, $data) {
        try {
            $this->db->where('id', $id);
            $result = $this->db->update($this->table_submissions, $data);
            
            return $result;
            
        } catch (Exception $e) {
            throw new Exception('更新狀態失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得提交記錄統計資料 (管理員用)
     * @return array
     */
    public function get_submission_stats() {
        try {
            $stats = [];
            
            // 總提交數
            $this->db->select('COUNT(*) as total');
            $this->db->from($this->table_submissions);
            $query = $this->db->get();
            $result = $query->row_array();
            $stats['total'] = (int)$result['total'];
            
            // 已完成數量
            $this->db->select('COUNT(*) as completed');
            $this->db->from($this->table_submissions);
            $this->db->where('status', 'completed');
            $query = $this->db->get();
            $result = $query->row_array();
            $stats['completed'] = (int)$result['completed'];
            
            // 處理中數量
            $this->db->select('COUNT(*) as processing');
            $this->db->from($this->table_submissions);
            $this->db->where('status', 'processing');
            $query = $this->db->get();
            $result = $query->row_array();
            $stats['processing'] = (int)$result['processing'];
            
            // 今日提交數量
            $this->db->select('COUNT(*) as today');
            $this->db->from($this->table_submissions);
            $this->db->where('DATE(created_at)', date('Y-m-d'));
            $query = $this->db->get();
            $result = $query->row_array();
            $stats['today'] = (int)$result['today'];
            
            // 已提交數量
            $this->db->select('COUNT(*) as submitted');
            $this->db->from($this->table_submissions);
            $this->db->where('status', 'submitted');
            $query = $this->db->get();
            $result = $query->row_array();
            $stats['submitted'] = (int)$result['submitted'];
            
            return $stats;
            
        } catch (Exception $e) {
            throw new Exception('取得統計資料失敗: ' . $e->getMessage());
        }
    }
}