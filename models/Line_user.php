<?php
/*
 *  Line User 資料
 */
class Line_user extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'line_user';
    }

    // 新增
    public function insert_data($data,$db = 'default')
    {
        $data['cdate']   = date('Y-m-d H:i:s');
        $data['status']  = 'normal';
        $this->db_master = $this->load->database($db, true);
        return ($this->db_master->insert($this->table, $data)) ? true : false;
    }

    // 修改
    public function update_data($user_id, $data,$db = 'default')
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('user_id', $user_id);
        $this->db_master->where('status', 'normal');
        return ($this->db_master->update($this->table, $data)) ? true : false;
    }

    // 刪除
    public function delete_data($user_id)
    {
        $data['status']  = 'delete';
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('user_id', $user_id);
        return ($this->db_master->update($this->table, $data)) ? true : false;
    }

    // 取資料 - 單筆
    public function find_one($user_id,$db = 'default')
    {
        $this->db = $this->load->database($db, true);
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'normal');
        $result = $this->db->get()->result_array();
        return (count($result) > 0) ? $result[0] : array();
    }

    /*
     *  條件式查詢
     */
    public function find_all($param = array(), $limit = array(), $order = array(), $where_in = array(), $where_not_in = array())
    {
        self::_query_find_all($param, $where_in, $where_not_in);

        if(!empty($limit) && $limit != 'all') {
            if(is_array($limit)) {
                $this->db->limit($limit[1], $limit[0]);
            }
            else {
                $this->db->limit($limit);
            }
        }

        if(!empty($order) && is_array($order)) {
            foreach($order as $field => $sort) {
                $this->db->order_by($field, $sort);
            }
        }

        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return (count($result) > 0) ? $result : array();
    }

    /*
     *  條件式筆數計算
     */
    public function count_all($param = array(), $where_in = array(), $where_not_in = array())
    {
        self::_query_find_all($param, $where_in, $where_not_in);
        $total = $this->db->count_all_results();
        return $total;
    }

    // 組成sql內容 - find_all, count_all
    private function _query_find_all($param, $where_in, $where_not_in)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from($this->table);

        if(isset($param['select']) && !empty($param['select'])) {
            $this->db->select($param['select']);
            unset($param['select']);
        }

        if(!empty($param)) {
            foreach($param as $key=>$value) {
                if(!empty($value) || $value == '') {
                    if($value === '*notNull') {
                        $this->db->where($key . ' IS NOT NULL', null, false);
                    }
                    else {
                        $this->db->where($key, $value);
                    }
                }
                else {
                    $this->db->where($key . ' IS NULL', null, false);
                }
            }
        }
        $this->db->where('status', 'normal');

        if(!empty($where_in) && is_array($where_in)) {
            foreach($where_in as $index => $value) {
                if(!empty($value)) {
                    $this->db->where_in($index, $value);
                }
            }
        }

        if(!empty($where_not_in) && is_array($where_not_in)) {
            foreach($where_not_in as $index => $value) {
                if(!empty($value)) {
                    $this->db->where_not_in($index, $value);
                }
            }
        }
    }
}