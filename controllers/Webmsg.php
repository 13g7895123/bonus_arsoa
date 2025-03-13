<?php

class Webmsg extends MY_Controller {
   
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

    public function index($code) 
    {
        
        
        $meta['title2'] = '網站訊息';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
                                        
        $data = array(
            'meta'        => $meta
        );
                
        $data['msg'] = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/ERROR/KIND/傳回值","資料",$code);
                                
        _timer('*** before layout ***');
                        
        $this->layout->view( 'webmsg' ,$data);
    }
}