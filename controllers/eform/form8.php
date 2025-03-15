<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form8 extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
    }

    public function submit()
    {
        $postData = $this->input->post();
        print_r($postData); die();
        // api url: base_url() . eform/form8/submit
        print_r(base_url()); die();
        print_r(1234); die();
    }
}