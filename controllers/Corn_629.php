<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
  每小時排程  
*/
class Corn extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();        
        
        $this->load->model( 'front_base_model' );
        $this->load->model( 'question_model' );           
        
        $this->load->service(array('line_service','api_line_service'));  // 更新 line 資料
        
    }
    
    public function index()
    {
           echo 'GO';
           
           $this->question('Q000');    
           
           echo 'OK';
           
           exit;
    }
  
    /*
       http://localhost/arsoa/corn/question
       1、未來上線時，每日發訊時間為19:00（目前不變）

       2、送出ap_member_order_his 的資料，若當下該會員沒綁定，保留15天，有綁再傳！過15天就不管了。
       
       3、推薦人也要傳訊告知其下屬有被送出填寫問卷，詳細內容明天經理會問總經理。
       
       4、問卷途中，該會員若有銷退，先前有填的問卷一律刪除
       
       5、為使測試來的及在 6/25 前可以完成 ，測試期的天數有可能改成 1111111111
       
       等上線再改回來。這點我會再確認然後再告知二位。
    */
    public function question($p_no = 'Q000',$setday = '')
    {
    	
    	      if ($setday == ''){ // 有設定時間,沒指定就是今天的時間
    	          $today = strtotime(date("Y-n-j"));
    	      }else{
    	          $today = strtotime(date("Y-n-j",strtotime($setday)));
    	      }    	      
    	      
    	      $time_h = (int)date('H');
    	       
    	      if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	           $time_h = 10;
    	      }
    	            
            // -- 抓出有要送售後服務的設定
            $where = array(
                      'p_no'       => $p_no,
                      'set_hour'   => $time_h,
                      'status'      => 'Y',
                     );            
    	      $question_prd_set = $this->front_base_model->get_data('ap_question_prd_set',$where,array('crdt'=>'desc'),1);
    	   
    	      // 有代表有要寄送
    	      if ($question_prd_set){
    	      	   $set_data = json_decode($question_prd_set['set_data'], true);              	           	    
    	      	   //echo "<pre>".print_r($question_prd_set,true)."</pre>";    	           	    	      
    	           echo "[".$question_prd_set['p_no']."] ";
    	           echo $question_prd_set['p_name'];
    	           echo '<br>';
    	           $sql = "select a.*,m.c_name,l.user_id,l.display_name,l.follow,m.d_spno
    	                     from ap_member_order_his a 
    	                     join member m on a.c_no = m.c_no
    	                     join member_line e on a.c_no = e.c_no
    	                     join line_user l on l.user_id = e.user_id  
                          where a.status = 'Y'
                            and a.p_no = '".$p_no."'                                                
                            and ifnull(e.user_id,'') > ''                            
                          order by m.d_spno,a.buy_date ";    
                          
                          //and a.c_no = '000000'        
                          
                 $send_data = $this->front_base_model->small_query($sql);        
          
    	           if ($send_data){
    	               foreach ($send_data as $key => $item)
    	               {
    	               	        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	               	            echo "<pre>".print_r($item,true)."</pre>";             
    	               	        }
    	               	        echo $key;
    	               	        echo '.';
    	               	        echo $item['c_no'];
                              echo '-';
                              echo "[".$item['user_id']."]";
                              echo "[send_num = ".$item['send_num']."]";
                              
    	               	        $send_line = true;
    	               	        $send_num = $item['send_num'];
    	               	        $buy_date = strtotime($item['buy_date']);
    	               	        if ($send_num == 0){ // 從未寄過    	               	        	  
    	               	        	  $diff_day = ($today - $buy_date) / 86400;  // 購買和今天相差天數
    	               	        	  if ($send_num == 0 && $diff_day > 15){  //送出ap_member_order_his 的資料，若當下該會員沒綁定，保留15天，有綁再傳！過15天就不管了。
    	               	        	  	  echo '[購買相差 15 天過期了]';
    	               	        	  	  $send_line = false;
    	               	        	  }else{
    	               	        	  	  if ($diff_day >= (int)$set_data[0]['day']){
    	               	        	  	      echo '[寄]';
    	               	        	  	  }else{    	               	        	  	  	
    	               	        	  	  	  $send_line = false;
    	               	        	  	      echo '[天數不到不寄 '.$diff_day.'天]';    	               	        	  	      
    	               	        	  	  }
    	               	        	  	  
    	               	        	  }
    	               	        }else{ // 已寄過
    	               	        	  $reply_data = $this->question_model->reply_find_one('rid',$item['last_rid'],'N');       // 抓最後一寄的記錄                          	  
                              	  if ($reply_data['status'] == 'Y'){ // 已填                                  	  	  
                              	      $buy_date = strtotime(date('Y-n-j',strtotime($reply_data['okdt'])));                                    	       
                              	      $diff_day = ($today - $buy_date) / 86400;  // 購買和今天相差天數
                              	      if ($diff_day == (int)$set_data[$send_num]['day']){
                              	      	  echo '[寄 '.$diff_day .' == '.$set_data[$send_num]['day'].' ]';
    	               	        	  	  }else{    	               	        	  	  	
    	               	        	  	  	  $send_line = false;
    	               	        	  	      echo '[天數不到不寄 '.$diff_day.'天]';    	               	        	  	      
    	               	        	  	  }                              	      
                              	  }else{  // 已寄過未填 或 被刪掉 不寄
                              	      $send_line = false;
                              	      echo '[已寄未填 '.$reply_data['crdt'].']';
                              	  }
    	               	        }
    	               	         
    	               	        if ($send_line){    	               	          
                                  echo '[line send]';                                  
                                  foreach ($set_data as $qkey => $qset){                                  	       
                                  	       if ($qkey == $send_num){  // 寄送    
                                  	       	    echo '[go]';                                  	       	                  	            
                                  	            
                                  	            if (isset($qset['q_id']) && $qset['q_id'] > 0){  // 抓問卷資料
                                  	            	  if (!isset($question_data_set[$qset['q_id']])){  // 問卷資料是否已在陣列中
                                  	            	  	  $question_data = $this->question_model->find_one('q_id',$qset['q_id'],true);   // 抓資料
                                  	            	      $question_data_set[$qset['q_id']] = $question_data;  // 放陣列
                                  	            	  }else{
                                  	            	      $question_data = $question_data_set[$qset['q_id']];  // 抓陣列放入
                                  	            	  }                              	            	  
                                  	            }
                                  	            
                                  	            $rid = 0;
                                  	            if ($question_data){
                                  	            	      $check_data = $this->question_model->check_reply_form($qset['q_id'],$item['user_id']);
                                  	            	      $p_num = ($send_num+1);
                                                        if ($check_data){                                                        	                                                    	   
                                                        	   if ($check_data['status'] == 'P'){                                                    	       
                                                        	       $rid = $check_data['rid'];
                                                        	       echo "[有記錄:".$rid."]";
                                                        	   }else{
                                                        	   	   echo "[已填完:".$check_data['rid']."]";
                                                        	   }
                                                        }else{                                                                                               	          	               	                                                       	                  	            
                                  	            	            // 有沒有看到記錄
                                  	            	            $checkcode = md5(uniqid());
       			                                                  $reply_data = array(
       			                                                                       'c_type'       => 'P',
       			                                                                       'c_no'         => $item['c_no'],
       			                                                                       'p_no'         => $p_no,
       			                                                                       'p_num'        => $p_num,
       			                                                                       'user_id'      => $item['user_id'],       				                                                       
       			                                                                       'c_name'       => $item['c_name'],    
       			                                                                       'q_title'      => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_title']),
       			                                                                       'q_desc'       => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_desc']),
       			                                                                       'q_ans'        => $question_data['q_ans'],
       			                                                                       'display_name' => $item['display_name'],    
       			                                                                       'q_id'         => $question_data['q_id'],
       			                                                                       'checkcode'    => $checkcode,
       			                                                                       'query'        => $question_data['checkcode'],
       			                                                                       'status'       => 'P'
       			                                                                      );       				            
       			                                                                                                 				                                  
       			                                                  $this->question_model->reply_insert_data($reply_data);
       			                                                  $rid = $this->question_model->reply_insert_id();       				                                  
       			                                                  echo "[新記錄:".$rid."]";
       			                                            }  
       			                                            
       			                                            if ($rid > 0){
       			                                            	  	  if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
       			                                            	  	      $msg = '';  
       			                                            	  	  }else{
       			                                            	  	      $msg = $this->block_service->question_send_line($rid,'question_corn_'.$p_num);   
       			                                            	  	  }
       			                                            	  	  if ($msg == ''){       			                                            	  	      
       			                                            	  	      $h_data['send_num']   = $p_num;
       			                                            	  	      $h_data['last_rid']   = $rid;
       			                                            	  	      $h_data['send_date']  = date('Y-m-d H:i:s');
     							                                                  $where = array ('hid' => $item['hid']);
     							                                                  $this->front_base_model->update_table('ap_member_order_his',$h_data ,$where);     
     							                                                   
     							                                                  echo "[已寄送:".$rid."]";
     							                                              }else{ 
                                                            	      $udata = array(
                                                                               'msg' => $msg
                                                                              );                                                            
                                                                    $this->question_model->reply_update_data($rid,$udata);                                      
                                                                    echo "[".$msg."]";
                                                                }
                                                        }                                                        
                                                }else{
                                                	   echo '[問卷未上線]';
                                                }                         
                                                                                                          
                                  	       }
                                  }
                              }
                              echo '<br>';
    	               }
    	           }    	           
    	      }
    }
}