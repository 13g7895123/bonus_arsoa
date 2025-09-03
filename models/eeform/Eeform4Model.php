<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform4Model extends MY_Model {

    protected $table_submissions = 'eeform4_submissions';
    protected $table_products = 'eeform4_products';
    protected $table_product_master = 'eeform4_product_master';
    protected $table_contact_history = 'eeform4_contact_history';
    protected $table_health_tracking = 'eeform4_health_tracking';

    public function __construct() {
        parent::__construct();
        
        // Enable error reporting for debugging
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        $this->load->database();
        
        // 初始化產品主檔
        $this->init_product_master();
    }
    
    /**
     * 初始化產品主檔資料
     */
    private function init_product_master() {
        try {
            // 檢查產品主檔是否為空
            $count = $this->db->count_all($this->table_product_master);
            
            if ($count == 0) {
                log_message('debug', 'Initializing product master table');
                
                $products = [
                    [
                        'product_code' => 'ENERGY_ESSENCE001',
                        'product_name' => '活力發酵精萃',
                        'product_category' => 'supplement',
                        'description' => '活力發酵精萃',
                        'sort_order' => 1,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'REISHI_EX001',
                        'product_name' => '白鶴靈芝EX',
                        'product_category' => 'supplement',
                        'description' => '白鶴靈芝EX',
                        'sort_order' => 2,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'VITAMIN_C001',
                        'product_name' => '美力C錠',
                        'product_category' => 'supplement',
                        'description' => '美力C錠',
                        'sort_order' => 3,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'ENERGY_CRYSTAL001',
                        'product_name' => '鶴力晶',
                        'product_category' => 'supplement',
                        'description' => '鶴力晶',
                        'sort_order' => 4,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'REISHI_TEA001',
                        'product_name' => '白鶴靈芝茶',
                        'product_category' => 'tea',
                        'description' => '白鶴靈芝茶',
                        'sort_order' => 5,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'SOAP001',
                        'product_name' => '淨白活膚蜜皂',
                        'product_category' => 'skincare',
                        'description' => '淨白活膚蜜皂',
                        'sort_order' => 6,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'MASK001',
                        'product_name' => '活顏泥膜',
                        'product_category' => 'skincare',
                        'description' => '活顏泥膜',
                        'sort_order' => 7,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'product_code' => 'TONER001',
                        'product_name' => '化粧水',
                        'product_category' => 'skincare',
                        'description' => '化粧水',
                        'sort_order' => 8,
                        'is_active' => true,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];
                
                $this->db->insert_batch($this->table_product_master, $products);
                log_message('debug', 'Product master table initialized with ' . count($products) . ' products');
            }
            
        } catch (Exception $e) {
            log_message('error', 'Failed to initialize product master: ' . $e->getMessage());
        }
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
     * 保存產品資料
     * @param int $submission_id 提交記錄ID
     * @param array $products 產品資料
     * @return bool
     */
    public function save_products($submission_id, $products) {
        try {
            log_message('debug', 'save_products called with submission_id: ' . $submission_id);
            log_message('debug', 'save_products products data: ' . json_encode($products));
            
            $this->db->trans_start();
            
            // 刪除現有的產品記錄
            $this->db->where('submission_id', $submission_id);
            $deleted = $this->db->delete($this->table_products);
            log_message('debug', 'Deleted existing products for submission ' . $submission_id . ': ' . ($deleted ? 'success' : 'failed'));
            
            // 取得產品主檔資料來建立映射
            $product_master = $this->get_all_products();
            log_message('debug', 'Product master data: ' . json_encode($product_master));
            
            $product_mapping = [];
            
            foreach ($product_master as $product) {
                // 建立前端欄位名稱對應 (product_code 轉為小寫並加上 product_ 前綴)
                $field_name = 'product_' . strtolower($product['product_code']);
                $product_mapping[$field_name] = [
                    'code' => $product['product_code'],
                    'name' => $product['product_name']
                ];
            }
            
            log_message('debug', 'Product mapping: ' . json_encode($product_mapping));
            
            $saved_count = 0;
            
            // 插入產品記錄
            foreach ($products as $key => $product) {
                log_message('debug', 'Processing product key: ' . $key . ', data: ' . json_encode($product));
                
                if (isset($product_mapping[$key])) {
                    $quantity = isset($product['quantity']) ? (int)$product['quantity'] : 0;
                    
                    log_message('debug', 'Found mapping for ' . $key . ', quantity: ' . $quantity);
                    
                    if ($quantity > 0) {
                        $product_data = [
                            'submission_id' => $submission_id,
                            'product_code' => $product_mapping[$key]['code'],
                            'product_name' => $product_mapping[$key]['name'],
                            'quantity' => $quantity,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        log_message('debug', 'Inserting product data: ' . json_encode($product_data));
                        
                        $insert_result = $this->db->insert($this->table_products, $product_data);
                        
                        if ($insert_result) {
                            $saved_count++;
                            log_message('debug', 'Product saved successfully: ' . $key);
                        } else {
                            $db_error = $this->db->error();
                            log_message('error', 'Failed to insert product ' . $key . ': ' . json_encode($db_error));
                        }
                    } else {
                        log_message('debug', 'Skipping product ' . $key . ' - quantity is 0');
                    }
                } else {
                    log_message('warning', 'No mapping found for product key: ' . $key);
                    log_message('debug', 'Available mappings: ' . implode(', ', array_keys($product_mapping)));
                }
            }
            
            log_message('debug', 'Total products saved: ' . $saved_count);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();
                log_message('error', 'Transaction failed: ' . json_encode($db_error));
                throw new Exception('保存產品資料失敗 - 事務回滾');
            }
            
            log_message('debug', 'save_products completed successfully');
            return true;
            
        } catch (Exception $e) {
            log_message('error', 'save_products exception: ' . $e->getMessage());
            $this->db->trans_rollback();
            throw new Exception('保存產品資料失敗: ' . $e->getMessage());
        }
    }

    /**
     * 取得提交記錄的產品數據
     * @param int $submission_id 提交記錄ID
     * @return array
     */
    public function get_products_by_submission($submission_id) {
        try {
            log_message('debug', 'get_products_by_submission called for submission_id: ' . $submission_id);
            
            $this->db->select('p.*, pm.sort_order');
            $this->db->from($this->table_products . ' p');
            $this->db->join($this->table_product_master . ' pm', 'p.product_code = pm.product_code', 'left');
            $this->db->where('p.submission_id', $submission_id);
            $this->db->order_by('pm.sort_order', 'ASC');
            $this->db->order_by('p.product_code', 'ASC');
            
            $compiled_query = $this->db->get_compiled_select();
            log_message('debug', 'get_products_by_submission query: ' . $compiled_query);
            
            $this->db->select('p.*, pm.sort_order');
            $this->db->from($this->table_products . ' p');
            $this->db->join($this->table_product_master . ' pm', 'p.product_code = pm.product_code', 'left');
            $this->db->where('p.submission_id', $submission_id);
            $this->db->order_by('pm.sort_order', 'ASC');
            $this->db->order_by('p.product_code', 'ASC');
            
            $query = $this->db->get();
            
            if (!$query) {
                $db_error = $this->db->error();
                log_message('error', 'get_products_by_submission query failed: ' . json_encode($db_error));
                return [];
            }
            
            $products = $query->result_array();
            log_message('debug', 'get_products_by_submission found ' . count($products) . ' products');
            log_message('debug', 'get_products_by_submission results: ' . json_encode($products));
            
            return $products;
            
        } catch (Exception $e) {
            log_message('error', 'get_products_by_submission exception: ' . $e->getMessage());
            throw new Exception('取得產品資料失敗: ' . $e->getMessage());
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
     * 根據ID取得單一提交記錄 (包含產品)
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
                'is_active' => false
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
                        'product_category' => isset($product['category']) ? $product['category'] : 'supplement',
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
                        'product_category' => isset($product['category']) ? $product['category'] : 'supplement',
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
}