<?php

class My404 extends MY_Controller {
   
    public function __construct() {
      
         parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->model( 'front_order_model' );         

        $this->load->service(array(
            'cache_service'
        ));
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }

    public function index() 
    {
       
        $meta['title1'] = FC_Web.' - Page Not Founded';
        $meta['title2'] = 'Page Not Founded';
                
        $data = array(
            'meta'        => $meta
        );
        
        $data['js'] = array(
              'err404'
        );
                
        _timer('*** before layout ***');
                        
        $this->output->set_status_header( '404' );
        
        $this->layout->view( 'errors/error_404' ,$data);
    }
}