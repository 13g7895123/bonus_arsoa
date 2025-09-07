<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eform extends CI_Controller
{
    protected $userdata;
    protected $apiBaseUrl;

    public function __construct()
    {
        parent::__construct();
        
        // Load necessary helpers
        $this->load->helper('url');
        
        // Load block service
        $this->load->service('block_service');
        
        // Set user data for demo purposes - in a real app this would come from authentication
        $this->userdata = array(
            'c_no' => '000000',
            'name' => 'Demo User',
            'email' => 'demo@example.com'
        );

        // Set API base URL
        $this->apiBaseUrl = base_url() . 'api/';
    }

    public function eform1()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform1/submit',
            'title' => '電子表單1'
        );

        // Load the view content
        $content = $this->load->view('eeform/eform01', $data, TRUE);
        
        // Pass content to layout
        $layout_data = array(
            'title' => $data['title'],
            'content' => $content
        );
        
        $this->load->view('layout/main', $layout_data);
    }

    public function eform1_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform1/submit'
        );
        
        $this->load->view('eeform/eform01_list', $data);
    }

    public function eform2()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform2/submit',
            'title' => '會員服務追蹤管理表(肌膚)'
        );

        // Load the view content
        $content = $this->load->view('eeform/eform02', $data, TRUE);
        
        // Pass content to layout
        $layout_data = array(
            'title' => $data['title'],
            'content' => $content
        );
        
        $this->load->view('layout/main', $layout_data);
    }

    public function eform2_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform2/submit'
        );
        
        $this->load->view('eeform/eform02_list', $data);
    }

    public function eform4()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform4/submit',
            'title' => '會員服務追蹤管理表(保健)'
        );

        // Load the view content
        $content = $this->load->view('eeform/eform04', $data, TRUE);
        
        // Pass content to layout
        $layout_data = array(
            'title' => $data['title'],
            'content' => $content
        );
        
        $this->load->view('layout/main', $layout_data);
    }

    public function eform4_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform4/submit'
        );
        
        $this->load->view('eeform/eform04_list', $data);
    }

    // Test method to verify controller is working
    public function test()
    {
        echo "Eform controller is working! Time: " . date('Y-m-d H:i:s');
    }
}