<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed.');

class Schedule extends MY_Controller {

    /**
     * 建構式，預設載入模組 {}
     */
    private $_var = array();
    function __construct() {
        parent:: __construct();
        $this->load->model('front_order_model');
    }

    public function index() {
         
        // 將3天前的訂單 改為訂單失敗
        $this->check_order(3);

    }
    
    public function check_order($day){
        echo $day;
        exit;
    }

}