<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eeform1Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function test()
    {
        return 'Eeform1Model loaded successfully';
    }
}