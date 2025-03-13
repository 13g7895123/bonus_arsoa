<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_admin_model' );
        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_product_model' );
        
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl='.base_url('sale') );
        }
        
        $order_by = array ('sale_sort'=> 'asc');   
        $where  = array ('nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );             
        $list = $this->front_base_model->get_data('ap_sale',$where,$order_by);
                
        $meta['title2'] = '當月販促活動';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        
        $data = array(
            'list'         => $list,
            'meta'         => $meta
        );
        
        $data['meta']['canonical'] = site_url();      
        
        _timer('*** before layout ***');
     
        $this->layout->view('sale', $data);
    }
    
    public function detail($sid)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $where  = array ('id' => $sid,'nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );             
        $list = $this->front_base_model->get_data('ap_sale',$where);
        
        if ($list){
            $item = $list[0];        
            $report_data['bodyhtml'] = '<p><img src="'.base_url('public/func/'.$item['field1']).'" class="img-fluid" alt="'.$item['title'].'"></p>';
            if ($item['body'] > ''){
                $report_data['bodyhtml'] .=     $item['body'];
            }
            $this->output->set_content_type('application/json');
            echo json_encode($report_data);
        }else{
            die('操作有誤!');
        }
        exit;
    }
      
}