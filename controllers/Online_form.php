<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online_form extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        // $this->load->model( 'front_member_model' );
        // $this->load->model( 'front_order_model' );
        // $this->load->model( 'front_base_model' );
        // $this->load->model( 'front_product_model' );
        // $this->load->model( 'front_mssql_model' );
                      
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }

    public function form1()
    {
        // print_r(123); die();
        // print_r(base_url()); die();
        $this->layout->view('./eform/eform01', $data);
    }
}