<?php
/*
 *  Line 訊息接收記錄
 */
class Line_message_log extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'line_message_log';
    }

    // 新增
    public function insert_data($data)
    {
        $data['status']  = 'normal';
        $this->db_master = $this->load->database('default', true);
        return ($this->db_master->insert($this->table, $data)) ? true : false;
    }

    // 自動編號
    public function insert_id()
    {
        return $this->db_master->insert_id();
    }

    // 修改
    public function update_data($msgid, $data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('status', 'normal');
        $this->db_master->where('msgid', $msgid);
        return ($this->db_master->update($this->table, $data)) ? true : false;
    }

    // --- --- --- --- ---

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
        // echo $this->db->last_query();
        return (count($result) > 0) ? $result : array();
    }

    /*
     *  條件式筆數計算
     */
    public function count_all($param = array(),$db = 'default', $where_in = array(), $where_not_in = array())
    {
        self::_query_find_all($param, $where_in, $where_not_in,$db);
        $total = $this->db->count_all_results();
        // echo $this->db->last_query();
        return $total;
    }

    // 組成sql內容 - find_all, count_all
    private function _query_find_all($param, $where_in, $where_not_in,$db)
    {
        $this->db = $this->load->database($db, true);
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

    // 查詢 line user 近期活躍度 (近 n 日有傳、接送訊息數量) - reply成功量
    public function get_user_active($user_id, $day = 30,$db = 'default')
    {
        $param = array(
            'user_id'      => $user_id,
            'reply_status' => '200',
            'msg_date >='  => date('Y-m-d H:i:s', time() - (86400 * $day))
        );
        return self::count_all($param,$db);
    }

}