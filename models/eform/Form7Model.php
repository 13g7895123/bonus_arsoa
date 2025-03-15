<?php
/*
 *  活動
 */
class Form7Model extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data)
    {
        return $this->db->insert('eform7_pri', $data);
    }
    
}