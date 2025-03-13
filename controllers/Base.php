<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->model( 'front_base_model' );
    }
    
    public function captcha_img() {
        return base_url( 'login/securimage_jpg' );
    }
    
    public function ini_se(){
		    $this->load->library('securimage/securimage');
        $img=new Securimage();
		    $img->show();
		    $img->check("initital");
	    	echo json_encode("ok");
	    	exit;
	 }
	 	
    //驗證碼設定
    public function securimage_jpg() {
        $this->load->library( 'securimage/securimage' );
        $img = new Securimage();
        $img->charset = '0123456789';
        $img->image_width = 100;
        $img->image_height = 45;
        $img->perturbation = 0.1;    //干擾雜訊度
        $img->num_lines = 0;        //線條數
        $img->text_transparency_percentage = 20; // 100 為全透明
        $img->image_bg_color = new Securimage_Color( "#f6f6f6" );
        $img->use_transparent_text = TRUE;
        //$img->use_wordlist = true; 		
        $img->show(); // 套背景圖並顯示		
    }
     
    public function prd_class2($prd_class1)
    {
        $this->output->set_content_type('application/json');
        $data  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => $prd_class1),array('classsort'=>'asc'));       
        echo json_encode($data);
        exit;
    }
        
    public function town($cityno)
    {
        $this->output->set_content_type('application/json');
        $town  = $this->front_base_model->get_data('town',array('cityno' => $cityno),array('postal'=>'asc'));       
        echo json_encode($town);
        exit;
    }
    
}