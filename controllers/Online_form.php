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
        $data = array();
        $this->layout->view('./eform/eform01', $data);
    }

    public function form2()
    {
        $data = array();
        $this->layout->view('./eform/eform02', $data);
    }

    public function form3()
    {
        $data = array();
        $this->layout->view('./eform/eform03', $data);
    }

    public function form4()
    {
        $data = array();
        $this->layout->view('./eform/eform04', $data);
    }

    public function form5()
    {
        $data = array();
        $this->layout->view('./eform/eform05', $data);
    }

    public function form6()
    {
        $data = array();
        $this->layout->view('./eform/eform06', $data);
    }

    public function form7()
    {
        $data = array();
        $this->layout->view('./eform/eform07', $data);
    }

    public function form8()
    {
        $data = array();
        $this->layout->view('./eform/eform08', $data);
    }
}