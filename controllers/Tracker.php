<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracker extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model( 'front_base_model' );    
        $this->load->model( 'front_order_model' );         
    }
    
    // 網站瀏覽人數統計
    public function webview() 
    {    
       //  if (isset($_SERVER['HTTP_REFERER'])){
       //      $ktype = parse_url($_SERVER['HTTP_REFERER'])['path']; 
       //  }
         $ktype = 'index';
        
         if (empty($this->session->userdata( 'webview_'.$ktype))){
             $sql = "INSERT INTO ap_viewcount (kind,ktype,kid,hits,createdate) VALUES ('View','".$ktype."',1,1,now())
                            ON DUPLICATE KEY UPDATE hits=hits+1";                         
             $this->db->query($sql);
             $this->session->set_userdata( 'webview_'.$ktype, 'Y' );
             echo 'OK';
         }else{
             echo 'NOOK';
         }
         exit;
    }
    
    // 點擊次數
    public function banners() 
    {
        $post = $this->input->post();        
 
        $type           = $post['type'];
        $id             = $post['id'];
        
        if ($type > '' && $id > ''){
            if ($type == 'f'){ 
                $atable = 'ap_func_data';
            }
            $this->front_base_model->count_pageview($atable,'banners','clicks','id',$id);
            echo 'OK';
        }                   
        exit;     
    }    
}