<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller
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
    
    public function index($prdtype = 'skin')
    {
        $where['wp1_en_name'] = $prdtype;
        $cat_data = $this->front_product_model->cat_wp_one("wp1_type",$where);
         
        if (!($cat_data)){
            redirect( base_url('webmsg/9999') );
            exit;
        }
                        
        $meta['title2'] = $cat_data['wp1_na'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        $meta['url'] = base_url('category/').$prdtype;   
         
        $data = array(
            'prdtype'      => $cat_data['wp1_en_name'],
            'meta'         => $meta,            
            'brand_title'  => $cat_data['wp1_na'],
            'cat_data'     => $cat_data
        );
        
        
        if ($cat_data['wp1_no'] == 6){  // 輔銷品
            if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                 alert( '抱歉請先登入！',base_url('member/login') );
                 exit;
            }else{
            	   if ($this->session->userdata('member_session')['d_posn'] > 60) {
                 	     	 alert( '抱歉，您的權限不足，無法購買輔銷品！',base_url('member/main') );
                         exit;
                 }
            }
                 
            $layout = 'category_other';
            $list_data = $this->front_product_model->prd_list(1,$cat_data['wp1_no'],$this->session->userdata('member_session')['d_posn']);
            $data['list_data'] = $list_data;
        }else{         
            $layout = 'category_'.$cat_data['wp1_no'];
        }
                      
        _timer('*** before layout ***');
     
        $this->layout->view($layout, $data);
    }   
    
    
    public function laiee(){
        $layout = 'category';
        switch ($prdtype) {
            case 'skin':    // 肌膚保養系列
                 $brand_no = "01";
                 $brand_title = '肌膚保養系列';
                 $sql = "select p.*,b.brand_no,b.brand_na,
                                case b.brand_no when '01' then 1 when '02' then 2 when '03' then 3 when '04' then 4 when '14' then 7 when '13' then 8 end obrand_no                                 
                          from BRAND b join product p on b.brand_no = p.brand_no
                         where b.pro_type = '肌膚保養' 
                           and b.brand_no not in ('08','15')
                           and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                         order by obrand_no,p.mg_sort , p.pro_order ";
                 break;
            case 'makeup':    // 彩妝系列
                 $brand_no = "05";
                 $brand_title = '彩粧系列';
                 $sql = "select p.* 
                           from product p join protype t on t.pro_typeno > '00' and p.pro_typeno = t.pro_typeno
                          where p.brand_no = '05'                         
                            and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1)
                            order by t.pro_typeno,p.mg_sort , p.pro_order ";
                 break;     
            case 'health':    // 保健食品系列
                 $brand_no = "11";
                 $brand_title = '保健食品系列';
                 $sql = "select p.* from product p
                          where p.brand_no= '11'
                            and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                            order by p.mg_sort , p.pro_order ";
                 break;
            case 'clean':    // 健康飲用水系列
                 $brand_no = "10";
                 $brand_title = '健康飲用水系列';
                 $sql = "select p.* from product p
                          where p.brand_no in ('07','10')
                            and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                            order by p.brand_no,p.mg_sort , p.pro_order ";
                 break;
            case 'hair_body':    // 美髮、美體系列
                 $brand_no = "06";
                 $brand_title = '美髮、美體系列';
                 $sql = "select p.* from product p
                          where p.brand_no in ('06','12')
                            and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                            order by p.brand_no,p.mg_sort , p.pro_order ";
                 break;
            case 'other':    // 輔銷品
                 if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                      alert( '抱歉請先登入！',base_url('member/login') );
                      exit;
                 }else{
                 	   if ($this->session->userdata('member_session')['d_posn'] > 50) {
                 	     	 alert( '抱歉，權限不足購買輔銷品！',base_url('member/main') );
                         exit;
                 	   } 
                 }
        
                 $layout = 'category_other';
                 $brand_no = "88";
                 $brand_title = '輔銷品';
                 $sql = "select p.* from product p
                          where p.brand_no = '88'
                            and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                            order by p.brand_no,p.mg_sort , p.pro_order ";
                 break;     
            default:
                 redirect( base_url('webmsg/9999') );
                 exit;
        }
        
        $brand_data = $this->front_base_model->small_query("select * from brand where brand_no = '".$brand_no."'")[0];        
        if (!$brand_data){
            redirect( base_url('webmsg/9999') );
            exit;
        }
        
        $list_data = $this->front_base_model->small_query($sql);
        
        $meta['title2'] = $brand_title;
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        if ($brand_data['brand_list'] > ''){
            $meta['description'] = $brand_data['brand_list'];
        }elseif($brand_data['brand_title1'] > ''){
            $meta['description'] = $brand_data['brand_title1'];
        }elseif($brand_data['brand_title2'] > ''){
            $meta['description'] = $brand_data['brand_title2'];
        }
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'prdtype'      => $prdtype,
            'meta'         => $meta,
            'brand_data'   => $brand_data,
            'brand_title'  => $brand_title,
            'list_data'    => $list_data
        );
                      
        _timer('*** before layout ***');
     
        $this->layout->view($layout, $data);
    }   
}