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
            'c_no' => 'DEMO001',
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
            'apiUrl' => $this->apiBaseUrl . 'eeform1/submit'
        );

        $this->load->view('eeform/eform01', $data);
    }

    public function eform1_list()
    {
        $data = array(
            'userdata' => $this->userdata,
            'apiUrl' => $this->apiBaseUrl . 'eeform1/submit'
        );
        
        $this->load->view('eeform/eform01_list', $data);
    }

    // Test method to verify controller is working
    public function test()
    {
        echo "Eform controller is working! Time: " . date('Y-m-d H:i:s');
    }
}