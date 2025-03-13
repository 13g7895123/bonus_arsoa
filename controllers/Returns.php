<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
               
        $meta['title2'] = '購物與退換貨';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
                
        
        $data['js'] = array(
            'main'
        );
        
        $where  = array ('epostid' => '6109');            
        $data['remark'] = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];

        _timer('*** before layout ***');
     
        $this->layout->view('returns', $data);
    }   
}