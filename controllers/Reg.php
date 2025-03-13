<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service'
        ));
    }

    public function index()
    {
        
        $regcode = '';
        if (!empty($this->input->get( 'c' ))){
            $regcode = $this->input->get( 'c' );            
        }
           
        $this->load->library('ciqrcode');    
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
             $base_folder = $_SERVER['DOCUMENT_ROOT']."/arsoa/";
        }else{
             $base_folder = $_SERVER['DOCUMENT_ROOT']."/";
        }
               
        $params['size'] = 10;
        $params['level'] = 'H';
	      $params['data'] = $regcode;
	      $params['savename'] = $base_folder.'public/qrcodefile/qr_'.preg_replace("/[^A-Za-z0-9_-]/", "", $regcode).'.png';	     
	   
	      $this->ciqrcode->generate($params);
	     
	      //$logo = $base_folder.'public/images/logo.png';	  
	     
	      $QR = imagecreatefromstring(file_get_contents($params['savename']));
	      /*
        $logo = imagecreatefromstring(file_get_contents($logo));
        $QR_width = imagesx($QR);//二維碼圖片寬度
        $QR_height = imagesy($QR);//二維碼圖片高度
        $logo_width = imagesx($logo);//logo圖片寬度
        $logo_height = imagesy($logo);//logo圖片高度
        $logo_qr_width = $QR_width / 4; //logo圖片在二維碼圖片中寬度大小
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale; //logo圖片在二維碼圖片中高度大小
        $from_width = ($QR_width - $logo_qr_width) / 2;
        $from_heigth = $from_width + 22;
        //重新組合圖片並調整大小
        imagecopyresampled($QR, $logo, $from_width, $from_heigth, 0, 0, $logo_qr_width,
        $logo_qr_height, $logo_width, $logo_height);                
        */
        header("Content-Type: image/png");	
       
        ImagePng($QR);   
	      imagedestroy($QR);
       
	      if(file_exists($params['savename'])){
            unlink($params['savename']);//將檔案刪除 
        }
        exit;
    }
}