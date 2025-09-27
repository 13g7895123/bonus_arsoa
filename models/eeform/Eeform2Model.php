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

            // 確保必要欄位存在
            $allowed_fields = [
                'member_id', 'member_name', 'join_date', 'gender', 'age', 'birth_year_month',
                'skin_health_condition', 'line_contact', 'tel_contact',
                'meeting_date', 'submission_date', 'created_at', 'status',
                'form_filler_id', 'form_filler_name', 'identity'
            ];

            // 驗證出生年月日格式
            if (isset($data['birth_year_month']) && !empty($data['birth_year_month'])) {
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['birth_year_month']) || !strtotime($data['birth_year_month'])) {
                    throw new Exception('出生年月日格式不正確，請使用 YYYY-MM-DD 格式');
                }
            }

            $submission_data = [];
            foreach ($allowed_fields as $field) {
                if (isset($data[$field])) {
                    $submission_data[$field] = $data[$field];
                }
            }

            // 插入主表數據
            $this->db->insert($this->table_submissions, $submission_data);
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
     * @param string $operation_type 操作類型 ('create' | 'update')
     * @return bool
     */
    public function save_products($submission_id, $products, $operation_type = 'create') {
        try {            
            $this->db->trans_start();
                        
            // 刪除現有的產品記錄
            $this->db->where('submission_id', $submission_id);
            $this->db->delete($this->table_products);
            
            // 取得產品主檔資料來建立映射
            $product_master = $this->get_all_products();
            
            $product_mapping = [];
            
            foreach ($product_master as $product) {
                // 建立前端欄位名稱對應 (product_code 轉為小寫並加上 product_ 前綴)
                $name_tail = ($operation_type === 'create') ? strtolower($product['product_code']) : $product['product_code'];
                $field_name = 'product_' . $name_tail;
                $product_mapping[$field_name] = [
                    'code' => $product['product_code'],
                    'name' => $product['product_name']
                ];
            }
                        
            // 收集需要插入的產品資料
            $batch_insert_data = [];
            
            foreach ($product_mapping as $field_name => $product_info) {
                // 檢查前端是否有提供這個產品的數量資料
                $quantity = 0;
                
                // 支援兩種資料格式：
                // 1. $products[$field_name]['quantity'] (物件格式)
                // 2. $products[$field_name] (直接數值格式) 
                if (isset($products[$field_name])) {
                    if (is_array($products[$field_name]) && isset($products[$field_name]['quantity'])) {
                        $quantity = (int)$products[$field_name]['quantity'];
                    } elseif (!is_array($products[$field_name])) {
                        $quantity = (int)$products[$field_name];
                    }
                }
                
                // 只有數量大於0的產品才加入批次插入清單
                if ($quantity > 0) {
                    $batch_insert_data[] = [
                        'submission_id' => $submission_id,
                        'product_code' => $product_info['code'],
                        'product_name' => $product_info['name'],
                        'quantity' => $quantity
                    ];
                }

                // print_r($batch_insert_data); die();
            }
                        
            // 使用 insert_batch 批次插入產品記錄
            if (!empty($batch_insert_data)) {
                $result = $this->db->insert_batch($this->table_products, $batch_insert_data);
                if (!$result) {
                    $db_error = $this->db->error();
                    log_message('error', 'Product batch insert failed: ' . json_encode($db_error));
                    throw new Exception('批次插入產品資料失敗: ' . $db_error['message']);
                }
                log_message('debug', 'Successfully inserted ' . count($batch_insert_data) . ' product records');
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('保存產品資料失敗');
            }
                        
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Save products error: ' . $e->getMessage());
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
            $this->db->where('form_filler_id', $member_name);
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
     * 根據會員姓名和編號取得提交記錄 (用於分組匯出)
     * @param string $member_name 會員姓名 (可選)
     * @param string $member_id 會員編號 (可選)
     * @return array
     */
    public function get_submissions_by_member_info($member_name = null, $member_id = null) {
        try {
            if (!$member_name && !$member_id) {
                throw new Exception('必須提供會員姓名或會員編號');
            }

            $this->db->select('*');
            $this->db->from($this->table_submissions);

            // 建立 WHERE 條件
            if ($member_name && $member_id) {
                $this->db->group_start();
                $this->db->where('member_name', $member_name);
                $this->db->where('member_id', $member_id);
                $this->db->group_end();
            } else if ($member_name) {
                $this->db->where('member_name', $member_name);
            } else if ($member_id) {
                $this->db->where('member_id', $member_id);
            }

            $this->db->order_by('created_at', 'DESC');

            $query = $this->db->get();
            $submissions = $query->result_array();

            // 為每個提交記錄加載產品數據
            foreach ($submissions as &$submission) {
                $submission['products'] = $this->get_products_by_submission($submission['id']);
            }

            return $submissions;

        } catch (Exception $e) {
            throw new Exception('取得會員提交記錄失敗: ' . $e->getMessage());
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
                // 取得已訂購的產品
                $ordered_products = $this->get_products_by_submission($id);
                
                // 取得所有產品主檔
                $all_products = $this->get_all_products();
                
                // 建立產品映射表（用於快速查找）
                $ordered_map = [];
                foreach ($ordered_products as $product) {
                    $ordered_map[$product['product_code']] = $product;
                }
                
                // 合併所有產品，包含未訂購的（數量為0）
                $complete_products = [];
                foreach ($all_products as $master_product) {
                    if (isset($ordered_map[$master_product['product_code']])) {
                        // 使用已訂購的產品資料
                        $complete_products[] = $ordered_map[$master_product['product_code']];
                    } else {
                        // 加入未訂購的產品（數量為0）
                        $complete_products[] = [
                            'product_code' => $master_product['product_code'],
                            'product_name' => $master_product['product_name'],
                            'quantity' => 0,
                            'sort_order' => $master_product['sort_order']
                        ];
                    }
                }
                
                // 按照sort_order排序
                usort($complete_products, function($a, $b) {
                    return ($a['sort_order'] ?? 0) - ($b['sort_order'] ?? 0);
                });
                
                $submission['products'] = $complete_products;
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
            $this->db->select('p.*, pm.sort_order');
            $this->db->from($this->table_products . ' p');
            $this->db->join($this->table_product_master . ' pm', 'p.product_code = pm.product_code', 'left');
            $this->db->where('p.submission_id', $submission_id);
            $this->db->order_by('pm.sort_order', 'ASC');
            $this->db->order_by('p.product_code', 'ASC');
            
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
            
            // 記錄更新操作的詳細資訊
            log_message('debug', 'Updating submission ID: ' . $id . ', Data: ' . json_encode($data));
            
            $this->db->where('id', $id);
            $result = $this->db->update($this->table_submissions, $data);
            
            // 記錄SQL執行結果
            $affected_rows = $this->db->affected_rows();
            $last_query = $this->db->last_query();
            log_message('debug', 'Update query: ' . $last_query);
            log_message('debug', 'Affected rows: ' . $affected_rows);
            
            if (!$result) {
                $db_error = $this->db->error();
                log_message('error', 'Database update failed: ' . json_encode($db_error));
                throw new Exception('資料庫更新失敗: ' . $db_error['message']);
            }
            
            if ($affected_rows === 0) {
                log_message('warning', 'Update succeeded but no rows were affected. Record may not exist or data may be identical.');
            }
            
            return $result;
            
        } catch (Exception $e) {
            log_message('error', 'Update submission error: ' . $e->getMessage());
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

    /**
     * 取得所有產品主檔資料
     * @return array
     */
    public function get_all_products() {
        try {
            $this->db->select('*');
            $this->db->from($this->table_product_master);
            $this->db->where('is_active', true);
            $this->db->order_by('sort_order', 'ASC');
            $this->db->order_by('product_code', 'ASC');
            
            $query = $this->db->get();
            return $query->result_array();
            
        } catch (Exception $e) {
            throw new Exception('取得產品資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 根據產品代碼取得產品資訊
     * @param string $product_code 產品代碼
     * @return array|null
     */
    public function get_product_by_code($product_code) {
        try {
            $this->db->select('*');
            $this->db->from($this->table_product_master);
            $this->db->where('product_code', $product_code);
            $this->db->where('is_active', true);
            
            $query = $this->db->get();
            return $query->row_array();
            
        } catch (Exception $e) {
            throw new Exception('取得產品資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 新增產品
     * @param array $data 產品資料
     * @return int|bool 產品ID或false
     */
    public function add_product($data) {
        try {
            // 如果沒有設定 sort_order，自動設定為最大值+1（加在最後面）
            if (!isset($data['sort_order'])) {
                $this->db->select('MAX(sort_order) as max_order');
                $this->db->from($this->table_product_master);
                $query = $this->db->get();
                $result = $query->row_array();
                $max_order = $result['max_order'] ?? 0;
                $data['sort_order'] = $max_order + 1;
            }
            
            $this->db->insert($this->table_product_master, $data);
            return $this->db->insert_id();
            
        } catch (Exception $e) {
            throw new Exception('新增產品失敗: ' . $e->getMessage());
        }
    }

    /**
     * 更新產品
     * @param int $id 產品ID
     * @param array $data 產品資料
     * @return bool
     */
    public function update_product($id, $data) {
        try {
            $this->db->where('id', $id);
            return $this->db->update($this->table_product_master, $data);
            
        } catch (Exception $e) {
            throw new Exception('更新產品失敗: ' . $e->getMessage());
        }
    }

    /**
     * 刪除產品 (軟刪除)
     * @param int $id 產品ID
     * @return bool
     */
    public function delete_product($id) {
        try {
            $data = [
                'is_active' => false,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->where('id', $id);
            return $this->db->update($this->table_product_master, $data);
            
        } catch (Exception $e) {
            throw new Exception('刪除產品失敗: ' . $e->getMessage());
        }
    }

    /**
     * 批量更新產品資料
     * @param array $products 產品清單
     * @return bool
     */
    public function batch_update_products($products) {
        try {
            $this->db->trans_start();
            
            // 先取得目前所有啟用的產品清單
            $current_products = $this->get_all_products();
            $current_product_ids = array_column($current_products, 'id');
            
            // 取得目前最大的 sort_order 值，用於新增產品
            $max_sort_order = 0;
            if (!empty($current_products)) {
                $sort_orders = array_column($current_products, 'sort_order');
                $max_sort_order = max($sort_orders);
            }
            
            // 記錄提交的產品ID清單
            $submitted_product_ids = [];
            
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id']) {
                    $submitted_product_ids[] = $product['id'];
                    
                    // 更新現有產品
                    $update_data = [
                        'product_code' => $product['code'],
                        'product_name' => $product['name'],
                        'product_category' => isset($product['category']) ? $product['category'] : 'other',
                        'description' => isset($product['description']) ? $product['description'] : null,
                        'sort_order' => isset($product['sort_order']) ? $product['sort_order'] : 0,
                        'is_active' => isset($product['is_active']) ? $product['is_active'] : true
                    ];
                    
                    $this->db->where('id', $product['id']);
                    $this->db->update($this->table_product_master, $update_data);
                } else {
                    // 新增產品 - 新產品加在最後面
                    $max_sort_order++;
                    $insert_data = [
                        'product_code' => $product['code'],
                        'product_name' => $product['name'],
                        'product_category' => isset($product['category']) ? $product['category'] : 'other',
                        'description' => isset($product['description']) ? $product['description'] : null,
                        'sort_order' => $max_sort_order,
                        'is_active' => isset($product['is_active']) ? $product['is_active'] : true
                    ];
                    
                    $this->db->insert($this->table_product_master, $insert_data);
                }
            }
            
            // 找出需要停用的產品（目前啟用但不在提交清單中的產品）
            $products_to_deactivate = array_diff($current_product_ids, $submitted_product_ids);
            
            // 停用被刪除的產品
            if (!empty($products_to_deactivate)) {
                $this->db->where_in('id', $products_to_deactivate);
                $this->db->update($this->table_product_master, [
                    'is_active' => false
                ]);
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('批量更新產品失敗');
            }
            
            return true;
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw new Exception('批量更新產品失敗: ' . $e->getMessage());
        }
    }

    /**
     * 測試 MSSQL 預儲程序 ww_chkguest (測試模式)
     * @param array $test_data
     * @return array
     */
    public function test_mssql_ww_chkguest($test_data) {
        try {
            // 載入front_mssql_model
            $CI = &get_instance();
            $CI->load->model('front_mssql_model');

            // 檢查MSSQL連線
            if (!$CI->front_mssql_model->ms_test()) {
                throw new Exception('MSSQL 連線測試失敗');
            }

            $msconn = $CI->front_mssql_model->ms_connect();
            if (!$msconn) {
                throw new Exception('無法建立MSSQL連線');
            }

            // 準備參數 - 測試模式 (test=1)
            $params = [
                ['1', SQLSRV_PARAM_IN],  // test mode = 1 (測試)
                [$test_data['d_spno'], SQLSRV_PARAM_IN],
                [$test_data['cname'], SQLSRV_PARAM_IN],
                [$test_data['bdate'], SQLSRV_PARAM_IN]
            ];

            // 調用MSSQL預儲程序 (移除cell參數)
            $result = $CI->front_mssql_model->get_data($msconn, "{CALL ww_chkguest(?,?,?,?)}", $params);

            $CI->front_mssql_model->ms_close($msconn);

            // 錯誤代碼對應訊息
            $error_messages = [
                0 => '來賓身分通過驗證',
                1 => '已存在此來賓',
                2 => '已存在此來賓，但推薦人不同',
                3 => '此來賓已經是會員了'
            ];

            $errcode = isset($result[0]['errcode']) ? (int)$result[0]['errcode'] : -1;

            return [
                'success' => true,
                'database_type' => 'MSSQL',
                'mode' => 'test',
                'input_data' => $test_data,
                'result' => $result,
                'errcode' => $errcode,
                'message' => $error_messages[$errcode] ?? '未知錯誤 (errcode: ' . $errcode . ')',
                'execution_time' => date('Y-m-d H:i:s')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'database_type' => 'MSSQL',
                'mode' => 'test',
                'error' => $e->getMessage(),
                'input_data' => $test_data,
                'message' => 'MSSQL 預儲程序測試失敗: ' . $e->getMessage()
            ];
        }
    }

    /**
     * 創建來賓（正式模式）- MSSQL 版本
     * @param array $guest_data
     * @return array
     */
    public function create_mssql_ww_chkguest($guest_data) {
        try {
            // 載入front_mssql_model
            $CI = &get_instance();
            $CI->load->model('front_mssql_model');

            // 檢查MSSQL連線
            if (!$CI->front_mssql_model->ms_test()) {
                throw new Exception('MSSQL 連線測試失敗');
            }

            $msconn = $CI->front_mssql_model->ms_connect();
            if (!$msconn) {
                throw new Exception('無法建立MSSQL連線');
            }

            // 準備參數 - 正式模式 (test=0)
            $params = [
                ['0', SQLSRV_PARAM_IN],  // test mode = 0 (正式)
                [$guest_data['d_spno'], SQLSRV_PARAM_IN],
                [$guest_data['cname'], SQLSRV_PARAM_IN],
                [$guest_data['bdate'], SQLSRV_PARAM_IN]
            ];

            // 調用MSSQL預儲程序 (移除cell參數)
            $result = $CI->front_mssql_model->get_data($msconn, "{CALL ww_chkguest(?,?,?,?)}", $params);

            $CI->front_mssql_model->ms_close($msconn);

            // 錯誤代碼對應訊息
            $error_messages = [
                0 => '來賓身分通過驗證，成功創建來賓編號',
                1 => '已存在此來賓，返回現有編號',
                2 => '已存在此來賓，但推薦人不同',
                3 => '此來賓已經是會員了'
            ];

            $errcode = isset($result[0]['errcode']) ? (int)$result[0]['errcode'] : -1;
            $guest_id = $result[0]['c_no'] ?? null;

            return [
                'success' => $errcode <= 1, // errcode 0 或 1 視為成功
                'database_type' => 'MSSQL',
                'mode' => 'production',
                'input_data' => $guest_data,
                'result' => $result,
                'errcode' => $errcode,
                'guest_id' => $guest_id,
                'c_no' => $guest_id, // 別名，方便前端使用
                'message' => $error_messages[$errcode] ?? '未知錯誤 (errcode: ' . $errcode . ')',
                'execution_time' => date('Y-m-d H:i:s')
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'database_type' => 'MSSQL',
                'mode' => 'production',
                'error' => $e->getMessage(),
                'input_data' => $guest_data,
                'message' => 'MSSQL 來賓創建失敗: ' . $e->getMessage()
            ];
        }
    }
}