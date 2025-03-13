<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table = FALSE;
    protected $primary_key = FALSE;
    protected $show_key = FALSE;
    protected $default_where = FALSE;

    public function __construct() {
        parent::__construct();        
    }

    public function get_query($select = '*', $where = array(), $order = array(), $limit = array(), $like = array()) {
        $this->_init();

        $default_where = array(
            $this->show_key => 'y'
        );

        $where = array_merge($default_where, $where);
        $this->db
                ->select($select)
                ->from($this->table)
                ->where($where);

        if (!empty($like)) {
            $this->db->like($like);
        }

        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        } else {
            $this->db->order_by($this->primary_key, 'asc');
        }

        if (!empty($limit)) {
            foreach ($limit as $key => $value) {
                $this->db->limit($key, $value);
            }
        }

        return $this->db->get();
    }

    public function get_query_count($select = '*', $where = array()) {
        $this->_init();

        $default_where = array(
            $this->show_key => 'y'
        );

        $where = array_merge($default_where, $where);
        $this->db
                ->select($select)
                ->from($this->table)
                ->where($where);

        return $this->db->count_all_results();
    }

    public function add($row_data) {
        $this->_init();

        $query = $this->db->insert($this->table, $row_data);

        if ($query) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function update($row_data, $where) {
        $this->_init();

        if (!is_array($where)) {
            $where = array($this->primary_key => $where);
        }

        $this->db->update($this->table, $row_data, $where);
        return $this->db->affected_rows();
    }

    private function _init() {
        if (!$this->table || !$this->primary_key || !$this->show_key) {
            $this->_error('init fault!');
        }
    }

    private function _error($err_msg) {
        $called = get_called_class();
        show_error('MY_Model ERROR: [' . $called . '] ' . $err_msg, 500);
    }

}