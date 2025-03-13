<?php

/*******************************************************************************
 * @copyright 2017 Long-teng Group
 * @auth      Ritchie <ritchie@long-teng.com.tw>
 * @version   1.0.0
 ******************************************************************************/
class Captcha extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->library( 'securimage/securimage' );
        $this->securimage->charset = '0123456789';
        $this->securimage->image_width = 100;
        $this->securimage->image_height = 45;
        $this->securimage->perturbation = 0.1;    //干擾雜訊度
        $this->securimage->num_lines = 0;        //線條數
        $this->securimage->text_transparency_percentage = 20; // 100 為全透明
        $this->securimage->image_bg_color = new Securimage_Color( "#f6f6f6" );
        $this->securimage->use_transparent_text = TRUE;
        $this->securimage->show();
    }

}
