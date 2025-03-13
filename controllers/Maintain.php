<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintain extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_member_model' );
        
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        $meta['title2'] = '網站維護中！';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        
        $data = array(            
            'meta'         => $meta
        );
        
        $data['meta']['canonical'] = site_url();      
        
        _timer('*** before layout ***');
     
        $this->layout->view('maintain', $data);
    }    
      
}