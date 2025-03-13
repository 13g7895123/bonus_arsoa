<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ad_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }
     
    // 左右門簾
    public function load_html_door($platform){
         $html = '';
         if ($platform == 'DESKTOP'){
             $html = $this->load->view('dfp/html_door', null,true);
         }          
         return $html;        
    }
    
    //頂部廣告
    public function load_html_top_ad($platform){      
         $html = $this->load->view('dfp/html_top_ad',array('platform'=>$platform),true);         
         return $html;     
    }
    
    //MENU 和內容中間的廣告 
    public function top_nav_ad($platform){       
       $html = $this->load->view('dfp/top_nav_ad',array('platform'=>$platform),true);         
       return $html;   
    }
    
    public function load_html_home_ad($platform){       
       $html = $this->load->view('dfp/html_home_ad',array('platform'=>$platform),true);         
       return $html;   
    }
            
    public function pc_two_ad($platform){
       $html = $this->load->view('dfp/pc_two_ad',array('platform'=>$platform),true);         
       return $html;   
    }
    
    public function pc_two_ad2($platform){
       $html = $this->load->view('dfp/pc_two_ad2',array('platform'=>$platform),true);         
       return $html;   
    }
    
    public function pc_two_ad3($platform){
       $html = $this->load->view('dfp/pc_two_ad3',array('platform'=>$platform),true);         
       return $html;   
    }
        
    public function m_ad($platform){
       $html = $this->load->view('dfp/m_ad',array('platform'=>$platform),true);         
       return $html;   
    }
    
    public function dfp($code,$platform){
       $html = $this->load->view('dfp/dfp',array('code'=>$code,'platform'=>$platform),true);         
       return $html;   
    }
    //video
    public function video_ad($platform){
        $html = $this->load->view('dfp/video_ad',array('platform'=>$platform),true);         
        return $html;   
    }
        
}