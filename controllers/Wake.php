<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wake extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        //$this->load->service(array(
        //    'cache_service',
        //    'ad_service'
        //));
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        
        $meta['title1'] = FC_Web.' - 喚醒肌膚的力量';
        $meta['title2'] = '喚醒肌膚的力量';
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
                
        _timer('*** before layout ***');
     
        $this->layout->view('wake', $data);
    }   


}