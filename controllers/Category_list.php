<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_list extends MY_Controller
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
    
    public function index($prdtype)
    {
      
        $where['wp2_en_name'] = $prdtype;
        $cat_data = $this->front_product_model->cat_wp_one("wp2_type",$where);
         
        if (!($cat_data)){
            redirect( base_url('webmsg/9999') );
            exit;
        }
        
        switch ($prdtype){
             case 'arsoa':
                  $meta['image'] = base_url('public/images/arsoa_all.png');
                  break;
             case 'makeup':
                  $meta['image'] = base_url('public/images/img00.png');
                  break;     
             case 'hair':
                  $meta['image'] = base_url('public/images/hair01.png');
                  break;     
             case 'prisiyno':
                  $meta['image'] = base_url('public/images/body01.png');
                  break;     
             case 'georina':
                  $meta['image'] = base_url('public/images/img00a.png');
                  break;     
             case 'cochamama':
                  $meta['image'] = base_url('public/images/ccmm01.png');
                  break;     
             case 'seiryu':
                  $meta['image'] = base_url('public/images/cl.png');
                  break;     
        }

        $list_data = $this->front_product_model->prd_list(2,$cat_data['wp2_no']);
        
        $meta['title2'] = $cat_data['wp2_na'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];      
        $meta['url'] = base_url('category_list').$prdtype;   
         
        $data = array(
            'prdtype'      => $prdtype,
            'meta'         => $meta,
            'share_url'    => base_url('category_list/'.$prdtype),
            'title1'       => $cat_data['wp2_title1'],
            'title2'       => $cat_data['wp2_title2'],            
            'brand_title'  => $cat_data['wp2_na'],
            'cat_data'     => $cat_data,
            'list_data'    => $list_data
        );
        
        $layout = 'category';
                     
        _timer('*** before layout ***');
     
        $this->layout->view($layout, $data);
        
    }
    
}