<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skin_test extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
                
        $meta['title1'] = FC_Web.' - 肌膚檢測';
        $meta['title2'] = '肌膚檢測';
                
        $data = array(
            'meta'        => $meta
        );
        
        $data['meta']['canonical'] = site_url();      
        
        $data['skin_data'] = $this->front_base_model->get_data('cht_test',array('id'=>1),'',1);             
        
                
        _timer('*** before layout ***');
     
        $this->layout->view('skin_test', $data);
    }   
  
  
    public function ans($id = 0)
    {
        $data_post = $this->input->post();
        if ($id == 0 && is_array( $data_post ) && sizeof( $data_post ) > 0){            
             
             // 檢測羅輯
             $point = 0;
             for ($i =  1;$i<= 15;$i++){
                  if ($data_post['a'.$i] == 'y'){
                      $point++;
                  }
                  if ($data_post['a'.$i] == 'n'){
                      $point--;
                  }
             }
             
             $age = (int)$data_post['age'];
             //小於9
             if ($age <= 9){
                 $fpoint = 0;
             }
             if ($age >= 10 && $age <= 18){
                 if (in_array($point, range(-11,-15))){
                     $fpoint = -2;
                 }elseif(in_array($point, range(-7,-10))){
                     $fpoint = -1;
                 }elseif(in_array($point, range(-2,-6))){
                     $fpoint = 0; 
                 }elseif(in_array($point, range(-1,0))){
                     $fpoint = 1; 
                 }elseif(in_array($point, range(1,2))){
                     $fpoint = 2; 
                 }elseif($point == 3){
                     $fpoint = 3; 
                 }elseif(in_array($point, range(4,6))){
                     $fpoint = 4;     
                 }elseif(in_array($point, range(7,8))){
                     $fpoint = 5;     
                 }elseif(in_array($point, range(9,10))){
                     $fpoint = 6;     
                 }elseif(in_array($point, range(11,12))){
                     $fpoint = 7;     
                 }elseif(in_array($point, range(13,15))){
                     $fpoint = 8;     
                 }
             }
             
             if ($age >= 19 && $age <= 22){   
                 if (in_array($point, range(-12,-15))){
                     $fpoint = -3;
                 }elseif(in_array($point, range(-8,-11))){
                     $fpoint = -2;
                 }elseif(in_array($point, range(-4,-7))){
                     $fpoint = -1; 
                 }elseif(in_array($point, range(-3,1))){
                     $fpoint = 0; 
                 }elseif(in_array($point, range(2,4))){
                     $fpoint = 1; 
                 }elseif(in_array($point, range(5,6))){
                     $fpoint = 2;     
                 }elseif(in_array($point, range(7,8))){
                     $fpoint = 3;     
                 }elseif(in_array($point, range(9,10))){
                     $fpoint = 4;     
                 }elseif(in_array($point, range(11,12))){
                     $fpoint = 5;         
                 }elseif($point == 13){
                     $fpoint = 6;         
                 }elseif($point == 14){
                     $fpoint = 7;         
                 }elseif($point == 15){
                     $fpoint = 8;             
                 }
             }
             
             if ($age >= 23 && $age <= 28){   
                 if (in_array($point, range(-13,-15))){
                     $fpoint = -5;
                 }elseif(in_array($point, range(-10,-12))){
                     $fpoint = -4;         
                 }elseif(in_array($point, range(-7,-9))){
                     $fpoint = -3;         
                 }elseif(in_array($point, range(-6,-4))){
                     $fpoint = -2;             
                 }elseif(in_array($point, range(-1,-3))){
                     $fpoint = -1;            
                 }elseif(in_array($point, range(0,3))){
                     $fpoint = 0;                      
                 }elseif(in_array($point, range(4,5))){
                     $fpoint = 1;                          
                 }elseif(in_array($point, range(6,7))){
                     $fpoint = 2;
                 }elseif(in_array($point, range(8,9))){
                     $fpoint = 3;    
                 }elseif(in_array($point, range(10,11))){
                     $fpoint = 4;        
                 }elseif(in_array($point, range(12,13))){
                     $fpoint = 5;            
   		           }elseif($point == 14){
                     $fpoint = 6;         
                 }elseif($point == 15){
                     $fpoint = 7;                                 
                 }
             }
              
             if ($age >= 29 && $age <= 35){   
                 if (in_array($point, range(-12,-15))){
                     $fpoint = -5;
                 }elseif(in_array($point, range(-9,-11))){
                     $fpoint = -4;    
                 }elseif(in_array($point, range(-8,-6))){
                     $fpoint = -3;           
                 }elseif(in_array($point, range(-3,-5))){
                     $fpoint = -2;           
                 }elseif(in_array($point, range(0,-2))){
                     $fpoint = -1;           
                 }elseif(in_array($point, range(1,4))){
                     $fpoint = 0;           
                 }elseif(in_array($point, range(5,6))){
                     $fpoint = 1;           
                 }elseif(in_array($point, range(7,8))){
                     $fpoint = 2;               
                 }elseif(in_array($point, range(9,10))){
                     $fpoint = 3;               
                 }elseif(in_array($point, range(11,12))){
                     $fpoint = 4;                   
                 }elseif(in_array($point, range(13,14))){
                     $fpoint = 5;                   
                 }elseif($point == 15){
                     $fpoint = 6;
                 }
            }
            
            if ($age >= 36 && $age <= 41){   
                  if (in_array($point, range(-14,-15))){
                     $fpoint = -6;
   	              }elseif(in_array($point, range(-11,-13))){
                     $fpoint = -5;                   
                  }elseif(in_array($point, range(-8,-10))){
                     $fpoint = -4;                      
                  }elseif(in_array($point, range(-7,-5))){
                     $fpoint = -3;                         
                  }elseif(in_array($point, range(-4,-2))){
                     $fpoint = -2;                            
                  }elseif(in_array($point, range(-1,0))){
                     $fpoint = -1;                            
                  }elseif(in_array($point, range(1,4))){
                     $fpoint = 0;                               
                  }elseif(in_array($point, range(5,6))){
                     $fpoint = 1;                                  
                  }elseif(in_array($point, range(7,9))){
                     $fpoint = 2;                                     
                  }elseif(in_array($point, range(10,12))){
                     $fpoint = 3;                                        
                  }elseif(in_array($point, range(13,14))){
                     $fpoint = 4;                                        
                  }elseif($point == 15){
                     $fpoint = 5;
                 }
            }   
            
            if ($age >= 42 && $age <= 50){   
                  if (in_array($point, range(-14,-15))){
                     $fpoint = -7;
   	              }elseif(in_array($point, range(-12,-13))){
                     $fpoint = -6;                   
                  }elseif(in_array($point, range(-10,-11))){
                     $fpoint = -5;                      
                  }elseif(in_array($point, range(-9,-7))){
                     $fpoint = -4;                         
                  }elseif(in_array($point, range(-6,-4))){
                     $fpoint = -3;                            
                  }elseif(in_array($point, range(-3,-2))){
                     $fpoint = -2;                            
                  }elseif(in_array($point, range(-1,1))){
                     $fpoint = -1;                               
                  }elseif(in_array($point, range(2,5))){
                     $fpoint = 0;                                  
                  }elseif(in_array($point, range(6,8))){
                     $fpoint = 1;                                     
                  }elseif(in_array($point, range(9,11))){
                     $fpoint = 2;
                  }elseif(in_array($point, range(12,13))){
                     $fpoint = 3;   
                  }elseif(in_array($point, range(14,15))){
                     $fpoint = 4;      
                  }
            }     
   		
   		      if ($age >= 51 && $age <= 60){   
                  if (in_array($point, range(-14,-15))){
                     $fpoint = -8;
   	              }elseif(in_array($point, range(-12,-13))){
                     $fpoint = -7;  
                  }elseif(in_array($point, range(-11,-10))){
                     $fpoint = -6;     
                  }elseif(in_array($point, range(-7,-9))){
                     $fpoint = -5;        
                  }elseif(in_array($point, range(-4,-6))){
                     $fpoint = -4;           
                  }elseif(in_array($point, range(-2,-3))){
                     $fpoint = -3;              
                  }elseif(in_array($point, range(-1,0))){
                     $fpoint = -2;                 
                  }elseif(in_array($point, range(1,3))){
                     $fpoint = -1;                    
                  }elseif(in_array($point, range(4,6))){
                     $fpoint = 0;                       
                  }elseif(in_array($point, range(7,9))){
                     $fpoint = 1;                          
                  }elseif(in_array($point, range(10,12))){
                     $fpoint = 2;                             
                  }elseif(in_array($point, range(13,15))){
                     $fpoint = 3;                                
                  }
             }
             
             if ($age >= 61 && $age <= 70){   
                  if (in_array($point, range(-14,-15))){
                     $fpoint = -8;
   	              }elseif(in_array($point, range(-12,-13))){
                     $fpoint = -7;  
                  }elseif(in_array($point, range(-9,-11))){
                     $fpoint = -6;     
                  }elseif(in_array($point, range(-6,-8))){
                     $fpoint = -5;        
                  }elseif(in_array($point, range(-4,-5))){
                     $fpoint = -4;           
                  }elseif(in_array($point, range(-2,-3))){
                     $fpoint = -3;              
                  }elseif(in_array($point, range(-1,1))){
                     $fpoint = -2;                 
                  }elseif(in_array($point, range(2,4))){
                     $fpoint = -1;                    
                  }elseif(in_array($point, range(5,7))){
                     $fpoint = 0;                       
                  }elseif(in_array($point, range(8,11))){
                     $fpoint = 1;                          
                  }elseif(in_array($point, range(12,15))){
                     $fpoint = 2;                                
                  }
             }   
             
             if ($age >= 71){   
                  if ($point == -15){
                     $fpoint = -10;
   	              }elseif(in_array($point, range(-13,-14))){
                     $fpoint = -9;  
                  }elseif(in_array($point, range(-11,-12))){
                     $fpoint = -8;     
                  }elseif(in_array($point, range(-9,-10))){
                     $fpoint = -7;        
                  }elseif(in_array($point, range(-7,-8))){
                     $fpoint = -6;           
                  }elseif(in_array($point, range(-4,-6))){
                     $fpoint = -5;              
                  }elseif(in_array($point, range(-2,-3))){
                     $fpoint = -4;                 
                  }elseif(in_array($point, range(-1,0))){
                     $fpoint = -3;                    
                  }elseif(in_array($point, range(1,4))){
                     $fpoint = -2;                       
                  }elseif(in_array($point, range(5,8))){
                     $fpoint = -1;                          
                  }elseif(in_array($point, range(9,15))){
                     $fpoint = 0;                             
                  }
             }
             
             $skinAge = $age + $fpoint;
              
             // 來判別肌膚分類
             if ($data_post['a12']=="y" && ($data_post['a13']=="n" || $data_post['a13']=="o") && ($data_post['a14']=="n" || $data_post['a14']=="o") && ($data_post['a15']=="n" || $data_post['a15']=="o")){
               	$skin = "A";
             }
             
             if ($data_post['a12'] == "y" && $data_post['a13'] == "y" && ($data_post['a14']=="n" || $data_post['a14']=="o") && ($data_post['a15']=="n" || $data_post['a15']=="o")){
             	  $skin = "A";
             }
             
             if ($data_post['a12'] == "y" && ($data_post['a13']=="n" || $data_post['a13']=="o") && ($data_post['a14']=="n" || $data_post['a14']=="o") && $data_post['a15'] == "y" ){
             	   $skin = "A";
             }
             
             if ($data_post['a12'] == "y" && $data_post['a13'] == "y" && ($data_post['a14']=="n" || $data_post['a14']=="o") && $data_post['a15'] == "y" ){
             	  $skin = "A";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && ($data_post['a13']=="n" || $data_post['a13']=="o") && ($data_post['a14']=="n" || $data_post['a14']=="o") && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
             	   $skin = "B";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && $data_post['a13']=="y" && ($data_post['a14']=="n" || $data_post['a14']=="o") && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
                	$skin = "B";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && $data_post['a13'] == "y" && ($data_post['a14']=="n" || $data_post['a14']=="o") && $data_post['a15'] == "y" ){
             	    $skin = "B";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && ($data_post['a13']=="n" || $data_post['a13']=="o") && $data_post['a14'] == "y" && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
             	    $skin = "C";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && $data_post['a13'] == "y" && $data_post['a14'] == "y" && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
             	    $skin = "C";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && ($data_post['a13']=="n" || $data_post['a13']=="o") && $data_post['a14'] == "y" && $data_post['a15'] == "y" ){
             	    $skin = "C";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && $data_post['a13'] == "y" && $data_post['a14'] == "y" && $data_post['a15'] == "y" ){
             	    $skin = "C";
             }
             
             if (($data_post['a12']=="n" || $data_post['a12']=="o") && ($data_post['a13']=="n" || $data_post['a13']=="o") && ($data_post['a14']=="n" || $data_post['a14']=="o") && $data_post['a15'] == "y" ){
             	    $skin = "D";
             }
             
             if ($data_post['a12'] == "y" && ($data_post['a13']=="n" || $data_post['a13']=="o") && $data_post['a14'] == "y" && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
                	$skin = "D";
             }
             
             if ($data_post['a12'] == "y" && $data_post['a13'] == "y" && $data_post['a14'] == "y" && ($data_post['a15']=="n" || $data_post['a15']=="o") ){
                	$skin = "D";
             }
             
             if ($data_post['a12'] == "y" && ($data_post['a13']=="n" || $data_post['a13']=="o") && $data_post['a14'] == "y" && $data_post['a15'] == "y" ){
                	$skin = "D";
             }
             
             if ($data_post['a12'] == "y" && $data_post['a13'] == "y" && $data_post['a14'] == "y" && $data_post['a15'] == "y" ){
                	$skin = "D";
             }
             
             if ($skin == 'B'){
                 if ($skinAge <= 28){
                     $id = 1;
                 }
                 if ($skinAge >= 29 && $skinAge <= 50){
                     $id = 2;
                 }
                 if ($skinAge >= 51 && $skinAge <= 100){
                     $id = 3;
                 }
             }
             
             if ($skin == 'A'){
                 if ($skinAge <= 28){
                     $id = 4;
                 }
                 if ($skinAge >= 29 && $skinAge <= 50){
                     $id = 5;
                 }
                 if ($skinAge >= 51 && $skinAge <= 100){
                     $id = 6;
                 }
             }
             if ($skin == 'C'){
                 if ($skinAge <= 28){
                     $id = 7;
                 }
                 if ($skinAge >= 29 && $skinAge <= 50){
                     $id = 8;
                 }
                 if ($skinAge >= 51 && $skinAge <= 100){
                     $id = 9;
                 }
             }
             if ($skin == 'D'){
                 if ($skinAge <= 28){
                     $id = 10;
                 }
                 if ($skinAge >= 29 && $skinAge <= 50){
                     $id = 11;
                 }
                 if ($skinAge >= 51 && $skinAge <= 100){
                     $id = 12;
                 }
             }
        }else{
             $skinAge = ''; 
        }
        if ($id > 0){
             $data['skin_ans'] = $this->front_base_model->get_data('cht_test_ans',array('id'=>$id ),'',1);   
             
             if ($data['skin_ans']['pid'] > ''){                 
                 $sqlcase = ' case p.p_no ';
                 $sqlin = '';
                 $FAr = explode(",",$data['skin_ans']['pid']);              
	              for ($i=0;$i< count($FAr);$i++){
	                   if ($sqlin > ''){ $sqlin .= ","; }
	                   $sqlin .= "'".$FAr[$i]."'";
	                   $sqlcase .= " when '".$FAr[$i]."' then ".$i." ";
	              }
	              $sqlcase .= " end psort ";
	              $sql = "select p.* ,".$sqlcase."
                          from product p
                         where p.p_no in (".$sqlin.")
                           and p.is_list=1 
                           and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                          order by psort ";
                 $pdata = $this->front_base_model->small_query($sql);
                
                 if ($pdata){
	                  $data['piddata'] = $pdata;
                 }
             }
        
             $meta['title1'] = FC_Web.' - 肌膚檢測';
             $meta['title2'] = '肌膚檢測';
             $data['meta'] = $meta;                
             $data['meta']['canonical'] = site_url();      
             $data['skinAge'] = $skinAge;                   
                        
             _timer('*** before layout ***');
     
             $this->layout->view('skin_test_ans', $data);
        }else{
             redirect( base_url('webmsg/9999') );
             exit; 
        }
        
    }
}