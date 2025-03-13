<?php
/*
 *  連結
 */
class Line_link_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'ap_line_link';
    }
    
    // 取資料 - 單筆
    public function find_one($key,$val, $preview = FALSE)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from($this->table);
        $this->db->where($key, $val);
        if (!$preview){
            $this->db->where('status', 'Y');
        }
        $result = $this->db->get()->result_array();               
        
        return (count($result) > 0) ? $result[0] : array();
    }
        
}