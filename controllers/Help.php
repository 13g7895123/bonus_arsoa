<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->library( 'user_agent' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        
        $meta['title2'] = '安露莎問與答';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $where  = array ('kind' => '6100','nshow' => 'Y');
        $order_by = array ('atype'=> 'asc','boardsort'=> 'asc');   
        $help = $this->front_base_model->get_data('ap_func_data',$where,$order_by);
        
        foreach ($help as $key => $item){
            $data['help'][$item['atype']][] = $item;
        }
        
        $data['meta'] = $meta;
        
        $data['js'] = array(
            'main'
        );

        _timer('*** before layout ***');
     
        $this->layout->view('help', $data);
    }   


}