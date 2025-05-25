<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_prod extends MY_Controller
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
        
        $layout = 'category_'.$cat_data['wp2_no'];

        $meta['title2'] = $cat_data['wp2_na'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];      
        
        $meta['url'] = base_url('category_prod/'.$prdtype);   
        
        $data = array(
            'prdtype'      => $prdtype,
            'meta'         => $meta,
            'share_url'    => base_url('category_prod/'.$prdtype),
            'title1'       => $cat_data['wp2_title1'],
            'title2'       => $cat_data['wp2_title2'],            
            'brand_title'  => $cat_data['wp2_na']
        );
        
        _timer('*** before layout ***');
     
        $this->layout->view($layout, $data);
        
    }
    
    public function list($prdtype)
    {
      
        $where['wp3_en_name'] = $prdtype;
        $cat_data = $this->front_product_model->cat_wp_one("wp3_type",$where);
       
        if (!($cat_data)){
            redirect( base_url('webmsg/9999') );
            exit;
        }

        $list_data = $this->front_product_model->prd_list(3, $cat_data['wp3_no']);
        
        $meta['title2'] = $cat_data['wp3_na'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];   
        $meta['url'] = base_url('category_prod/list/'.$prdtype);   
        
        
        $data = array(
            'prdtype'      => $prdtype,
            'meta'         => $meta,
            'share_url'    => base_url('category_prod/list/'.$prdtype),
            'title1'       => $cat_data['wp3_title1'],
            'title2'       => $cat_data['wp3_title2'],            
            'brand_title'  => $cat_data['wp3_na'],
            'cat_data'     => $cat_data,
            'list_data'    => $list_data
        );
                
        $layout = 'category';
                     
        _timer('*** before layout ***');
     
        $this->layout->view($layout, $data);
        
    }
}