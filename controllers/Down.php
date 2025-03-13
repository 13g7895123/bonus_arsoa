<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Down extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();        
        $this->load->model( 'front_base_model' );       
    }
    
    public function file()
    {
        if (!empty($this->input->get( 'f' ))){
            $fdata = $this->input->get( 'f' );
        }
        $params = json_decode(base64_decode($fdata), true);             
        
        if ($params['filename'] > ''){
            
            // 下載次數加1
            if (isset($params['id'])){                 
                $this->front_base_model->count_pageview('ap_func_data','member_down','hits','id',$params['id']);                
            }
            
            $filename = upload_folder."".$params['folder']."/".$params['filename'];             
            $rfilename = APPPATH.$filename;	            
            $rfilename=str_replace("//", "/",$rfilename);              
            
            /*
            echo "<pre>".print_r($params,true)."</pre>";
            echo "[".$params['folder'].'/'.$params['filename']."]";
            echo "[".$params['filename_old']."]";
            exit;
            */
            if (file_exists($rfilename)){                               
                $this->block_service->downfilephp($params['folder'].'/'.$params['filename'],$params['filename_old']); 
                exit;
            }            
        }
        
        redirect( base_url('webmsg/D9999') );
        exit;
    }
}