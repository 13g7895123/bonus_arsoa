<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_eeform extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Load necessary helpers
        $this->load->helper('url');
        
        // Load models
        $this->load->model('eeform/Eeform1Model');
        $this->load->model('eeform/Eeform2Model');
        $this->load->model('eeform/Eeform4Model');
    }

    public function form1()
    {
        $this->load->view('admin/eeform/form1');
    }

    public function form2()
    {
        $this->load->view('admin/eeform/form2');
    }

    public function form4()
    {
        $this->load->view('admin/eeform/form4');
    }

    // Test method to verify controller is working
    public function test()
    {
        echo "Admin_eeform controller is working! Time: " . date('Y-m-d H:i:s');
    }
}