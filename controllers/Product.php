<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller
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
    
    public function index($p_no)
    {
        if ($p_no == ''){
            redirect( base_url('webmsg/P9999') );
            exit;
        }
         
        $data['prddata'] = $this->front_product_model->get_data($p_no);
      
        if (!$data['prddata']){
            redirect( base_url('webmsg/P9999') );
            exit;
        }
        
        $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';        
        $data['prddata']['body'] = $this->block_service->text_convert($data['platform'],$data['prddata']['body']);
        
        if ($data['prddata']['wp1_en_name'] == 'other'){
            if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                 alert( '抱歉請先登入！',base_url('member/login?rdurl=product/'.$p_no) );
                 exit;
            }
        }
        if ($data['prddata']['wp2_en_name'] > ''){
            $data['category_url'] = base_url('category_list/'.$data['prddata']['wp2_en_name']);
        }else{
            if ($data['prddata']['wp3_en_name'] > ''){
                $data['category_url'] = base_url('category_prod/'.$data['prddata']['wp3_en_name']);
            }else{
                $data['category_url'] = base_url('category/'.$data['prddata']['wp1_en_name']);
            }
        }
        
        // -- 其它商品
        $data['other_prddata'] = $this->front_product_model->other_list($p_no,$data['prddata']['wp1_no'],3);
          
        //  -- 記數 -- S            
        $this->front_base_model->count_pageview('ap_product','prd_'.$p_no,'hits','p_no',$p_no);   
        //  -- 記數 -- E
                       
        $meta['title2'] = $data['prddata']['p_name'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        if ($data['prddata']['pro_desc'] > ''){
            $meta['description'] = $data['prddata']['pro_desc'];
        }elseif($data['prddata']['p_title1'] > ''){
            $meta['description'] = $data['prddata']['p_title1'];
        }elseif($data['prddata']['p_title2'] > ''){
            $meta['description'] = $data['prddata']['p_title2'];    
        }elseif($data['prddata']['pro_title1'] > ''){
            $meta['description'] = $data['prddata']['pro_title1'];
        }elseif($data['prddata']['pro_title2'] > ''){
            $meta['description'] = $data['prddata']['pro_title2'];
        }
                
        $meta['canonical'] = base_url('product/'.$p_no);      
        
        $meta['url'] = base_url('product/'.$p_no);   
        
        $meta['image'] = base_url().$this->block_service->prd_img($p_no); 
        
        $data['meta'] = $meta;
                      
        _timer('*** before layout ***');
     
        $this->layout->view("product", $data);
    }   
}