<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends MY_Controller
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
        
        
        $meta['title2'] = '聯絡我們';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
                        
        $data['js'] = array(
            'main'
        );

        _timer('*** before layout ***');
     
        $this->layout->view('contact', $data);
    }   
     
    public function send()
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){            
             $data = array(
                         'ftype' => 'A',
                         'name'  => $data_post['name'], 
                         'email'  => $data_post['email'], 
                         'phone'  => $data_post['phone'], 
                         'memo'   => $data_post['memo'], 
                         'crdt'   => date('Y-m-d H:i:s')
                     );
             
             $this->front_base_model->insert_table('ap_feedback',$data);
             
             $this->block_service->send_email(FC_Email,'安露莎聯絡我們系統通知信函','詳情請至後台查看！');	
             
             redirect( base_url('webmsg/7000') );
             exit;
        } 
    
    }
}