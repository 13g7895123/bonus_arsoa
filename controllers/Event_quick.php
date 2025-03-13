<?php
/*
 *   Liff功能 - 活動用 - 觸發並主動發送訊息
 *
    開啟LIFF頁觸發活動第0題-自動發送    
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_quick extends MY_Controller
{
    private $response    = array('success' => false, 'msg' => '', 'data' => '', 'error' => '');

    public function __construct()
    {
        parent::__construct();

        $this->load->library('layout', array('layout' => '../template/layout_liff'));
    }

    /* 
       e = 體驗
       r = 預約
    */
    public function share($type,$checkcode = '')
    {
        if ($type == 'e'){
            $this->load->model( 'sample_model' );           
        }
        
        $data = array();       
        
        if ($checkcode == ''){        
            $get = $this->input->get();
            
            $query = isset($get['query']) ? $get['query'] : '';
            
            if ($query > ''){
            	  $checkcode = trim($query);
            	  if ($type == 'e'){
                    $data = $this->sample_model->find_one('checkcode',substr($checkcode,1));
                }
            }
        }else{
        	  if ($type == 'e'){ 
        	      $data = $this->sample_model->find_one('checkcode',substr($checkcode,1));
        	  }
        }
        
        if ($data){
            $data['data']               = $data;
            if ($type == 'e'){
                $data['web']['title']       = $data['s_title'];
            }
            $data['web']['url']         = base_url($type.'/'.$sample_data['checkcode']);
            
            $data['liff_url']   = 'https://liff.line.me/';
            //$data['liff_url']   = 'line://app/';
            if ($type == 'e'){
                $data['liff_url']  .= $this->config->item('line_liff_sample_url');
            }
            //$data['liff_url']  .= '/sample/liff?query=' . $query;            
            $data['liff_url']  .= '/' . $checkcode;            
        }else{
       	   alert('操作有誤，活動未開始或結束（S99-'.$checkcode.'）！',base_url());
           exit;  
       }
        
        $data['css'] = array();
        
        $data['js']  = array('event_quick_share');
        
        $this->layout->view('share', $data);
    }
    
     /* 
      抽獎
    */
    public function lottery($checkcode)
    {
    	      
            $data['liff_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$checkcode;		
            $data['css'] = array();        
            $data['js']  = array('event_quick_share');        
            $this->layout->view('share', $data);
            
    }
    
    // 同意書
    public function consent($checkcode)
    {
    	      
            $data['liff_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_consent_url').'/'.$checkcode;		
            $data['css'] = array();        
            $data['js']  = array('event_quick_share');        
            $this->layout->view('share', $data);
            
    }

}