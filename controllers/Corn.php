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
           echo 'GO 產品體驗';
           /*
           //$time_h = (int)date('H');
           
           //if ($time_h == 1){
               // $this->front_base_model->small_query('delete from ap_corn_log where crdt < date_add(now(), interval -60 day)');
           //}
           */
           $sql = "select p_id,p_no,p_name
    	               from ap_question_prd_set
    	              where status = 'Y'
    	                and line_push = 'Y'
                    order by p_id  ";    
           $send_data = $this->front_base_model->small_query($sql);
           if ($send_data){
    	         foreach ($send_data as $key => $item)
    	         {    	               	
                    echo $item['p_id'];
                    echo ' ';
                    echo $item['p_no'];
                    echo ' ';
                    echo $item['p_name'];                   
                    $this->question($item['p_id']);  
                    echo 'OK';
                    echo '<br>';
               }
           }
           echo 'GO sample';
           
           $this->sample();   // 試用品問卷送出
           
           echo 'GO sample out';
           
           $this->sample_out();  // 出貨通知
           
           echo 'OK';
           
           echo 'GO sample_reminder ';
           
           $this->sample_reminder();   // 試用品問卷催填
           
           exit;
    }
    
    /*
    http://localhost/arsoa/corn/job/A/1
    https://www.arsoa.tw/corn/job
    */
    public function job($settype = 'ALL',$act_id = '',$set_sort = '')
    {
    	    /* $messages[] = array(
                            'type' => 'text',
                            'text' => "親愛的 TEST CronJob ".date('Y-m-d H:i:s').""
           );  
    	     
    	     $send_result = $this->api_line_service->push('U1f8c9566bd3519855409230932767d38',$messages);    	     
    	     echo "<pre>".print_r($send_result,true)."</pre>";
    	     */
    	     $now = date('Y-m-d H').':'.floor(date('i') /10).'0:00';
    	     
    	     if ($settype == 'ALL' || $settype == 'A'){
    	     	    $add_sql = '';
    	     	    if ($act_id > '' && (int)$act_id > 0 && (int)$set_sort > 0){
    	     	        $add_sql = ' and a.act_id = '.$act_id.' ';	
    	     	        $add_sql .= ' and q.set_sort = '.$set_sort.' ';	
    	     	    }else{
    	     	    	  $add_sql = " and q.set_date = '".$now."' ";
    	     	    }
    	     		  $sql = "select a.act_id,q.q_id,q.id,c.user_id,c.display_name,c.c_no,m.c_name,q.set_sort,c.id 
    	     		                  from ap_activity a 
    	     		                  join ap_activity_question q on a.act_id = q.act_id and q.status = 'Y' 
    	     		                  join ap_activity_charge c on a.act_id = c.act_id and c.status = 'Y' 
    	     		             left join member m on m.c_no = c.c_no
    	     		           where a.status = 'Y'    	     
    	     		             ".$add_sql."
           		           order by a.act_id,q.set_sort ";    
           		  
           		  $send_data = $this->front_base_model->small_query($sql);
           		  if ($send_data){
    	     		       $send_num = 0;    	     		       
    	     		       $send_false = 0;    	     		       
    	     		       foreach ($send_data as $key => $item)
    	     		       {    
    	     		                echo "[活動編號:".$act_id."][問卷編號:".$item['q_id']."][報名編號:".$item['id']."]";
    	     		                echo "[".$item['user_id']."][".$item['display_name']."]";

    	     		                $set = array(
           		   	                 'c_no' => $item['c_no'],
           		   	                 'c_name' => $item['c_name'],
           		   	                 'set_sort' => $item['set_sort'],
           		   	                 'line_user_id' => $item['user_id'],
           		   	                 'line_display_name' => $item['display_name']
           		   	            );
           		   	            $push_data = $this->block_service->activity_push_line($item['act_id'],$set);
           		                if ($push_data['success'] == 1){
           		                	  $send_num++;    	     
           		                }else{
           		                	  $send_false++;
           		                }
           		                echo $push_data['msg'];
           		                echo "<br>";
    	     		       }    	          	
    	     		  }
    	     		  echo '推送成功：'.$send_num.'<br>';
    	     		  echo '推送失敗：'.$send_false.'';
    	     		  echo '<br>';
    	     }
    	     exit;
    }
    
    public function tt()
    {
            $sql = "select a.user_id,a.id
    	                     from ap_sample_charge a
                         order by a.user_id  ";    
            $send_data = $this->front_base_model->small_query($sql);
            $i = 0;
    	      if ($send_data){
    	          foreach ($send_data as $key => $item)
    	          {    	               	             
                        $line_user_data = $this->line_service->get_line_user($item['user_id'] ,'',true);                      	  
    	  	              if ($line_user_data['follow'] == 'disable'){
    	  	              	  echo $i;
    	  	              	  echo '.';
    	  	              	  echo $line_user_data['user_id'];    	  	              	  
    	  	              	  echo '<br>';
     				                $this->front_base_model->update_table('ap_sample_charge',array('msg' =>'封鎖') ,array ('id' => $item['id']));     
    	  	              }
    	  	      }
    	      }
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
       
       http://localhost/arsoa/corn/question/Q000/2022-06-28
       
       https://www.arsoa.tw/corn/question/2/2023-08-18
    */
    public function question($p_id,$setday = '')
    {
    	
    	      $set = 'N';
    	      if ($setday == ''){ // 有設定時間,沒指定就是今天的時間
    	          $today = strtotime(date("Y-n-j"));
    	      }else{
    	      	  $set = 'Y';
    	          $today = strtotime(date("Y-n-j",strtotime($setday)));
    	      }     	      
    	      
    	      $time_h = (int)date('H');
    	      
    	      // -- 抓出有要送售後服務的設定 
    	      if ( $_SERVER['HTTP_HOST'] == 'localhost' || $set == 'Y'){   // 本機測試
    	           $sql = "SELECT *,HOUR(NOW()) as syshour FROM `ap_question_prd_set` WHERE `p_id` = '".$p_id."' and line_push = 'Y' AND `status` = 'Y' ORDER BY `crdt` DESC limit 1";
    	      }else{
                 $sql = "SELECT *,HOUR(NOW()) as syshour FROM `ap_question_prd_set` WHERE `p_id` = '".$p_id."' and line_push = 'Y' AND `set_hour` = HOUR(NOW()) AND `status` = 'Y' ORDER BY `crdt` DESC limit 1";
            }
            $question_prd_set = $this->front_base_model->small_query($sql);
    	      
    	      $corn_log_id = $this->front_base_model->insert_table('ap_corn_log',array('doing'=>'question_'.$p_id,'sql'=>$sql,'log'=> json_encode($question_prd_set),'crdt'=>date('Y-m-d H:i:s')));
    	     
    	      // 有代表有要寄送
    	      if ($question_prd_set){
    	      	   $question_prd_set = $question_prd_set[0];
    	      	   
    	      	   $set_data = json_decode($question_prd_set['set_data'], true);              	           	    
    	      	   //echo "<pre>".print_r($question_prd_set,true)."</pre>";    	           	    	      
    	           echo "[".$question_prd_set['p_id']."] ";
    	           echo $question_prd_set['p_name'];
    	           echo '<br>';
    	           $sql = "select a.*,m.c_name,l.user_id,l.display_name,l.follow,m.d_spno
    	                     from ap_member_order_his a 
    	                     join member m on a.c_no = m.c_no
    	                     join member_line e on a.c_no = e.c_no
    	                     join line_user l on l.user_id = e.user_id  
                          where a.status = 'Y'
                            and a.p_id = '".$p_id."'  
                                                                            
                            and ifnull(e.user_id,'') > ''             
                          order by m.d_spno,a.send_num ";    
                          
                          //and a.c_no = '000000'        
      
                 $send_data = $this->front_base_model->small_query($sql);
    	           if ($send_data){
    	
    	           	   // $this->front_base_model->update_table('ap_corn_log',array('data'=> json_encode($send_data)) ,array('id'=> $corn_log_id ));     
    	
    	           	   $d_spno = '';
    	           	   $spno_member = array();
    	               foreach ($send_data as $key => $item)
    	               {
    	               	        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	               	            echo "<pre>".print_r($item,true)."</pre>";             
    	               	        }
    	               	        
    	               	        if ($d_spno > '' && $d_spno != trim($item['d_spno'])){  // 通知推薦人    	               	        	  
    	               	        	  if (count($spno_member) > 0){
    	               	        	      self::send_spno($p_id,$d_spno,$spno_member);
    	               	        	  }
    	               	        	  $spno_member = array();
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
    	               	        	  	      echo '[F 天數不同不寄 '.$diff_day.'天 ('.date('Y-m-d',$buy_date).' '.$set_data[$send_num]['day'].')]';    	               	        	  	      
    	               	        	  	  }
    	               	        	  	  
    	               	        	  }
    	               	        }else{ // 已寄過
    	               	        //	echo "<pre>".print_r($item,true)."</pre>";

    	               	        	  $reply_data = $this->question_model->reply_find_one('rid',$item['last_rid'],'N');       // 抓最後一寄的記錄                          	  
                              	  if ($reply_data['status'] == 'Y'){ // 已填                                  	  	  
                              	                                  	      
                              	      $buy_date = strtotime(date('Y-n-j',strtotime($reply_data['okdt'])));
                              	     // echo "[today = ".date('Y-m-d',$today)."]";
                              	     // echo "[buy_date = ".date('Y-m-d',$buy_date)."]";
                              	      
                              	      $diff_day = ($today - $buy_date) / 86400;  // 購買和今天相差天數
                              	      if ($diff_day == (int)$set_data[$send_num]['day']){
                              	      	  echo '[寄 '.$diff_day .' == '.$set_data[$send_num]['day'].' ]';
    	               	        	  	  }else{    	               	        	  	  	
    	               	        	  	  	  $send_line = false;
    	               	        	  	      echo '[N 天數不同不寄 '.$diff_day.'天 ('.date('Y-m-d',$buy_date).' '.$set_data[$send_num]['day'].')]';    	               	        	  	      
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
                                                        	       $rid				= $check_data['rid'];
                                                        	       $checkcode	= $check_data['checkcode'];
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
       			                                                                       'p_no'         => $p_id,
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
       			                                            	  	  $h_data = array();
       			                                            	  	  if ($msg == ''){
       			                                            	  	      $spno_member[$p_num][] = array(                                                                      
                                                                      'rid'    => $rid,
                                                                      'p_num'  => $p_num,
                                                                      'checkcode'  => $checkcode,
                                                                      'c_no'   => trim($item['c_no']),
                                                                      'c_name' => trim($item['c_name']),
                                                                    );
       			                                            	  	      
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
                              $d_spno = trim($item['d_spno']);
                              echo '<br>';    	                  
    	               }
    	               
    	               if (count($spno_member) > 0){  // 通知推薦人    	               	        	      	               	        	  
    	               	   self::send_spno($p_id,$d_spno,$spno_member);
    	               }
    	           }    	           
    	      }
    }
         
    // https://www.arsoa.tw/question/v?r=eyJkbyI6InF1ZXN0aW9uX3ZpZXciLCJyaWQiOiIzOCIsImNoZWNrY29kZSI6ImEwOGQzODg5MjYwNDM2MzNkN2Y5NmNjYTYzYjE1MTFhIn0   
    // http://localhost/arsoa/question/v?r=eyJkbyI6InF1ZXN0aW9uX3ZpZXciLCJyaWQiOiIzOCIsImNoZWNrY29kZSI6ImEwOGQzODg5MjYwNDM2MzNkN2Y5NmNjYTYzYjE1MTFhIn0   
    private function send_spno($p_id,$d_spno,$spno_member)
    {
    	      echo $d_spno;
    	      
    	      $prd_set_data = $this->front_base_model->get_data('ap_question_prd_set',array('p_id' => $p_id),array('p_id'=>'asc'))[0];       
    	        	      
    	      $sql = "select distinct m.c_name,l.user_id,l.display_name
    	                from member m 
    	                join member_line e on m.c_no = e.c_no
    	                join line_user l on l.user_id = e.user_id  
                     where m.c_no = '".$d_spno."'                                                
                       and ifnull(e.user_id,'') > '' ";                                              
            $send_data = $this->front_base_model->small_query($sql);                        
    	      if ($send_data){  // 上線有綁定 Line
    	      	  $send_data = $send_data[0];
    	      	  
    	      	  $line_user_data = $this->line_service->get_line_user($send_data['user_id'] ,'',true);     
    	  	      if ($line_user_data['follow'] == 'disable'){
    	  	  	      $msg = '會員將安露莎Line封鎖，無法寄送！';            
    	  	      }else{ 
    	  	  	      $val['line_title'] = $prd_set_data['line_title'];                    
                    $val['line_title2'] = '問卷發送通知';                     
                    $val['name'] = '親愛的 '.trim($send_data['c_name']).' 會員您好';                           
                    $val['line_msg'] = '今日發出組織問卷清單如下';
                    
                    $amsg = array();
                    foreach ($spno_member as $key => $item){
                    	       $msg  = "第 ".$key." 次問卷：";
                    	       $qurl = '';
                    	       $qname = '';
                    	       foreach ($item as $key1 => $atem){
                    	       	        if ($qname > ''){ $qname .= "、"; }
                    	       	        $qname .= trim($atem['c_name']);
                    	       	        if ($qurl == ''){
                    	       	            $_url_data = str_replace('=', '', str_replace('/', '_',base64_encode(json_encode(array('do' => 'question_view', 'rid' => $atem['rid'], 'checkcode' => $atem['checkcode'])))));                     	       	            
                    	       	            $qurl = "https://www.arsoa.tw/question/v?r=".$_url_data;
                    	       	        }
                    	       }                    	       
                    	       $amsg[] = array(
                    	                         'msg' => $msg."\n".$qname,
                    	                         'qurl' => $qurl
                    	                      );
                    	       
                    }
                    
                    $val['amsg'] = $amsg;                    
                    
                    $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'question_msg');            
               
                    $messages[]  = array(
                          'type'     => 'flex',
                          'altText'  => $prd_set_data['line_title'].' '.$val['line_title2'],
                          'contents' => array(
                              'type'     => 'carousel',
                              'contents' => $bubble_data
                          )
                    );
                                         
                    $send_result = $this->api_line_service->push($send_data['user_id'],$messages);
                    //echo "<pre>".print_r($send_result,true)."</pre>";
                    //exit; 
                    $this->load->model( 'Line_push_log' );                                            
                    // 推送記錄
                    $this->Line_push_log->insert_log($send_data['user_id'],'question_view',$d_spno,$messages,$send_result['http_code'],$send_result['result']);
                    
                    if ($send_result['http_code'] == 429) {  // 訊息數不足
                        $msg = 'Line 訊息數不足';                       
                    }elseif($send_result['http_code'] == 200){  // 寄送成功
                        $msg = '寄送成功 ';
                    }       
    	      	      echo '寄送成功 ';
    	      	  }
    	      }else{
    	      	  echo '未綁定';
    	      }
    	      echo '<br>';    	      
    }
    
    /*
    https://www.arsoa.tw/corn/sample/2022-07-31/18
    */    
    public function sample($setday = '',$time_h = '')
    {
    	
    	      if ($setday == ''){ // 有設定時間,沒指定就是今天的時間
    	          $today = strtotime(date("Y-n-j"));
    	      }else{
    	          $today = strtotime(date("Y-n-j",strtotime($setday)));
    	      }    	      
    	      
    	      if ($time_h == ''){
    	        //  $time_h = (int)date('H');
    	      }
    	       
    	      if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	        //   $time_h = 18;
    	      }
    	            
    	      $sql = "select a.*,m.c_name,l.user_id,l.display_name,l.follow,m.c_no,s.set_data,HOUR(NOW()) as syshour,a.c_no as uc_no
    	                              from ap_sample_charge a 
    	                              join ap_sample s on a.s_id = s.s_id 
    	                              join line_user l on l.user_id = a.user_id      	                              
    	                              left join member m on a.referrer_c_no = m.c_no
    	                              left join member_line e on a.referrer_c_no = e.c_no    	                              
                                   where a.status = 'Y'   
                                     and s.set_hour = HOUR(NOW())                                                                               
                                   order by m.c_no,a.s_id,a.send_num ";
            $send_data = $this->front_base_model->small_query($sql);
            $corn_log_id = $this->front_base_model->insert_table('ap_corn_log',array('doing'=>'sample','sql'=>$sql,'log'=> json_encode($send_data),'crdt'=>date('Y-m-d H:i:s')));
            $corn_log = array();
    	      if ($send_data){    	                    	  
    	          $c_no = '';
    	          $s_id = '';
    	          $spno_member = array();
    	          foreach ($send_data as $key => $item)
    	          {
    	          	        $set_data = json_decode($item['set_data'], true);
    	          	        
    	          	        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	          	            echo "<pre>".print_r($item,true)."</pre>";             
    	          	        }
    	          	        
    	          	        if ($c_no > '' && ($c_no != trim($item['c_no']) || $s_id != trim($item['s_id']))){  // 通知推薦人
    	          	        	  if (count($spno_member) > 0){
    	          	        	      self::send_sample_spno($s_id,$c_no,$c_name,$spno_member);
    	          	        	  }
    	          	        	  $spno_member = array();
    	          	        }
    	          	        
    	          	        echo $key;
    	          	        echo '.';    	                        	        
                          echo "[".$item['user_id']."]";
                          echo "[send_num = ".$item['send_num']."]";
                         
    	          	        $send_line = true;
    	          	        $send_num = $item['send_num'];
    	          	        $outdt = strtotime($item['outdt']);
    	          	        if ($send_num == 0){ // 從未寄過    	               	        	  
    	          	        	  $diff_day = ($today - $outdt) / 86400;  // 購買和今天相差天數
    	          	        	  if ($send_num == 0 && $diff_day > 15){  //送出ap_member_order_his 的資料，若當下該會員沒綁定，保留15天，有綁再傳！過15天就不管了。
    	          	        	  	  echo '[相差 15 天過期了]';
    	          	        	  	  $send_line = false;
    	          	        	  }else{
    	          	        	  	  if ($diff_day >= (int)$set_data[0]['day']){
    	          	        	  	      echo '[寄]';
    	          	        	  	  }else{    	               	        	  	  	
    	          	        	  	  	  $send_line = false;
    	          	        	  	      echo '[F 天數不同不寄 '.$diff_day.'天 ('.date('Y-m-d',$outdt).' '.$set_data[$send_num]['day'].')]';    	               	        	  	      
    	          	        	  	  }
    	          	        	  	  
    	          	        	  }
    	          	        }else{ // 已寄過
    	          	        	  $reply_data = $this->question_model->reply_find_one('rid',$item['last_rid'],'N');       // 抓最後一寄的記錄                          	  
                           	  if ($reply_data['status'] == 'Y'){ // 已填                                  	  	  
                         	        $outdt = strtotime(date('Y-n-j',strtotime($reply_data['okdt'])));                                    	       
                         	        $diff_day = ($today - $outdt) / 86400;  // 購買和今天相差天數
                         	        if ($diff_day == (int)$set_data[$send_num]['day']){
                         	      	    echo '[寄 '.$diff_day .' == '.$set_data[$send_num]['day'].' ]';
    	          	        	  	  }else{    	               	        	  	  	
    	          	        	  	  	  $send_line = false;
    	          	        	  	      echo '[N 天數不同不寄 '.$diff_day.'天 ('.date('Y-m-d',$outdt).' '.$set_data[$send_num]['day'].')]';    	               	        	  	      
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
                                                   	       $rid				= $check_data['rid'];
                                                   	       $checkcode	= $check_data['checkcode'];
                                                   	       echo "[有記錄:".$rid."]";
                                                   	   }else{
                                                   	   	   echo "[已填完:".$check_data['rid']."]";
                                                   	   }
                                                   }else{                                                                                               	          	               	                                                       	                  	            
                             	            	            // 有沒有看到記錄
                             	            	            $checkcode = md5(uniqid());
       			                                            $reply_data = array(
       			                                                                  'c_type'       => 'S',
       			                                                                  'c_no'         => $item['uc_no'],
       			                                                                  'c_name'       => $item['uname'],
       			                                                                  'p_no'         => $item['s_id'],
       			                                                                  'p_num'        => $p_num,
       			                                                                  'user_id'      => $item['user_id'],       				                                                       
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
       			                                       	  	      $msg = $this->block_service->sample_send_line($rid,'sample_corn',$p_num);   
       			                                       	  	  }
       			                                       	  	  $h_data = array();
       			                                       	  	  if ($msg == ''){
       			                                       	  	      $spno_member[$p_num][] = array(                                                                      
                                                                 'rid'    => $rid,
                                                                 'p_num'  => $p_num,
                                                                 'checkcode'  => $checkcode,
                                                                 'c_no'   => trim($item['c_no']),
                                                                 'c_name' => trim($item['uname']),
                                                               );
       			                                       	  	       
       			                                       	  	       $corn_log[] = array(
       			                                       	  	                            'id'  => $item['id'],
       			                                       	  	                            'rid' => $rid
       			                                       	  	                           );
       			                                       	  	      
       			                                       	  	       $h_data['send_num']   = $p_num;
       			                                       	  	       $h_data['last_rid']   = $rid;
       			                                       	  	       $h_data['send_date']  = date('Y-m-d H:i:s');
     				                                                   $where = array ('id' => $item['id']);
     				                                                   $this->front_base_model->update_table('ap_sample_charge',$h_data ,$where);     
     				                                                    
     				                                                   echo "[已寄送:".$rid."]";
     				                                               }else{ 
                                                       	     //  $h_data['msg']   = $msg;       			                                                     	  	       
     				                                                 //  $where = array ('id' => $item['id']);
     				                                                 //  $this->front_base_model->update_table('ap_sample_charge',$h_data ,$where);     
                                                               echo "[".$msg."]";
                                                           }
                                                   }
                                           }else{
                                           	   echo '[問卷未上線]';
                                           }                         
                                                                                                     
                             	       }
                             }
                         }
                         $c_no   = trim($item['c_no']);
                         $c_name = trim($item['c_name']);
                         $s_id   = trim($item['s_id']);
                         echo '<br>';    	                  
    	          }
    	          
    	          if ($c_no > '' && count($spno_member) > 0){  // 通知推薦人    	               	        	      	               	        	  
    	          	  self::send_sample_spno($s_id,$c_no,$c_name,$spno_member);
    	          }
    	      }
    	      
    	      if (count($corn_log) > 0){
    	      	  // $this->front_base_model->update_table('ap_corn_log',array('data'=> json_encode($corn_log)) ,array('id' => $corn_log_id));     
    	      }
    }
    
    private function send_sample_spno($s_id,$c_no,$c_name,$spno_member)
    {
    	      echo $s_id;
    	      echo '-';
    	      echo $c_no;
    	      echo '-';
    	      echo $c_name;
    	      echo '-';
    	    //  echo "<pre>".print_r($spno_member,true)."</pre>";
    	      
    	      $set_data = $this->front_base_model->get_data('ap_sample',array('s_id' => $s_id),array('s_id'=>'asc'))[0];       
    	        	      
    	    //  echo "<pre>".print_r($set_data,true)."</pre>";

    	      $sql = "select distinct m.c_name,l.user_id,l.display_name
    	                from member m 
    	                join member_line e on m.c_no = e.c_no
    	                join line_user l on l.user_id = e.user_id  
                     where m.c_no = '".$c_no."'                                                
                       and ifnull(e.user_id,'') > '' ";                                              
            $send_data = $this->front_base_model->small_query($sql);            
    	      if ($send_data){  // 上線有綁定 Line
    	      	  $send_data = $send_data[0];
    	      	  
    	      	  $line_user_data = $this->line_service->get_line_user($send_data['user_id'] ,'',true);     
    	  	      if ($line_user_data['follow'] == 'disable'){
    	  	  	      $msg = '會員將安露莎Line封鎖，無法寄送！';            
    	  	      }else{ 
    	  	  	      $val['line_title'] = $set_data['line_charge_title'];                    
                    $val['line_title2'] = '試用組問卷發送通知';                     
                    $val['name'] = '親愛的 '.trim($send_data['c_name']).' 會員您好';                           
                    $val['line_msg'] = '今日發出試用組問卷清單如下';
                    
                    $amsg = array();
                    foreach ($spno_member as $key => $item){
                    	       $msg  = "第 ".$key." 次問卷：";
                    	       $qurl = '';
                    	       $qname = '';
                    	       foreach ($item as $key1 => $atem){
                    	       	        if ($qname > ''){ $qname .= "、"; }
                    	       	        $qname .= trim($atem['c_name']);
                    	       	        if ($qurl == ''){
                    	       	            $_url_data = str_replace('=', '', str_replace('/', '_',base64_encode(json_encode(array('do' => 'question_view', 'rid' => $atem['rid'], 'checkcode' => $atem['checkcode'])))));                     	       	            
                    	       	            $qurl = "https://www.arsoa.tw/question/v?r=".$_url_data;
                    	       	        }
                    	       }                    	       
                    	       $amsg[] = array(
                    	                         'msg' => $msg."\n".$qname,
                    	                         'qurl' => $qurl
                    	                      );
                    	       
                    }
                    
                    $val['amsg'] = $amsg;                    
                    
                    $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'question_msg');            
               
                    $messages[]  = array(
                          'type'     => 'flex',
                          'altText'  => $set_data['line_charge_title'].' '.$val['line_title2'],
                          'contents' => array(
                              'type'     => 'carousel',
                              'contents' => $bubble_data
                          )
                    );
                    
                  //  echo "<pre>".print_r($messages,true)."</pre>";
                                         
                    $send_result = $this->api_line_service->push($send_data['user_id'],$messages);
                    //echo "<pre>".print_r($send_result,true)."</pre>";
                    //exit; 
                    $this->load->model( 'Line_push_log' );                                            
                    // 推送記錄
                    $this->Line_push_log->insert_log($send_data['user_id'],'sample_view',$c_no,$messages,$send_result['http_code'],$send_result['result']);
                    
                    if ($send_result['http_code'] == 429) {  // 訊息數不足
                        $msg = 'Line 訊息數不足';                       
                    }elseif($send_result['http_code'] == 200){  // 寄送成功
                        $msg = '寄送成功 ';
                    }       
    	      	      echo '寄送成功 ';
    	      	  }
    	      }else{
    	      	  echo '未綁定';
    	      }
    	      echo '<br>';    	      
    }
    
    
     /*
    http://localhost/arsoa/corn/sample_out
    */    
    public function sample_out()
    {    	    	         
    	      // and HOUR(NOW()) = 18
    	      $sql = "select a.*,m.c_name,l.user_id,l.display_name,l.follow,m.c_no,s.set_data,HOUR(NOW()) as syshour,a.c_no as uc_no,s.s_title,s.line_out_title,s.line_out_msg
    	                              from ap_sample_charge a 
    	                              join ap_sample s on a.s_id = s.s_id 
    	                              join line_user l on l.user_id = a.user_id      	                              
    	                              left join member m on a.referrer_c_no = m.c_no
    	                              left join member_line e on a.referrer_c_no = e.c_no    	                              
                                   where a.status = 'Y'                                        
                                     and ifnull(s.line_out_title,'') > ''
                                     and ifnull(a.line_out_dt,'') = ''
                                     and a.outdt is not null
                                     and a.outdt >= DATE_FORMAT(date_add(now(), interval -1 day),'%Y-%m-%d')
                                   order by m.c_no,a.s_id,a.outdt ";
            $send_data = $this->front_base_model->small_query($sql);
            $corn_log_id = $this->front_base_model->insert_table('ap_corn_log',array('doing'=>'sample_out','sql'=>$sql,'log'=> json_encode($send_data),'crdt'=>date('Y-m-d H:i:s')));
            $corn_log = array();
    	      if ($send_data){    	       	      	        	  
    	          $c_no = '';
    	          $s_id = '';
    	          $spno_member = array();
    	          foreach ($send_data as $key => $item)
    	          {
    	          	      
    	          	        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	          	            echo "<pre>".print_r($item,true)."</pre>";             
    	          	        }
    	          	        
    	          	        if ($c_no > '' && ($c_no != trim($item['c_no']) || $s_id != trim($item['s_id']))){  // 通知推薦人    	               	        	  
    	          	        	  if (count($spno_member) > 0){
    	          	        	      self::send_sample_out_spno($s_id,$c_no,$c_name,$spno_member);
    	          	        	  }
    	          	        	  $spno_member = array();
    	          	        }
    	          	        
    	          	        echo $key;
    	          	        echo '.';    	                        	        
                          echo "[".$item['user_id']."]";
                          
    	          	        $outdt = strtotime($item['outdt']);
    	          	                   	                       
       			              if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
       			                  $msg = '';  
       			              }else{
       			                  $msg = $this->block_service->sample_out_send_line($item['id'],$item,'sample_out');   
       			              }
       			              $h_data = array();
       			              
       			              $spno_member[] = array(                                                                      
                                'c_no'   => trim($item['c_no']),
                                'c_name' => trim($item['uname']),
                          );
       			              
       			              $corn_log[] = array(
       			                                   's_id'   => $item['s_id'],
       			                                   'id'     => $item['id'],
       			                                  );
       			              
       			              $h_data['line_out_dt']  = date('Y-m-d H:i:s');
       			              $h_data['line_out_msg'] = $msg;
     				              $where = array ('id' => $item['id']);
     				              $this->front_base_model->update_table('ap_sample_charge',$h_data ,$where);     
     				               
     				              echo "[推送:".$item['id'].":".$msg."]";
                          echo '<br>';                                         
                          
                       
                         $c_no   = trim($item['c_no']);
                         $c_name = trim($item['c_name']);
                         $s_id   = trim($item['s_id']);
                         echo '<br>';    	                  
    	          }
    	          
    	          if ($c_no > '' && count($spno_member) > 0){  // 通知推薦人    	               	        	      	               	        	  
    	          	  self::send_sample_out_spno($s_id,$c_no,$c_name,$spno_member);
    	          }
    	      }
    	      
    	      if (count($corn_log) > 0){
    	      	  // $this->front_base_model->update_table('ap_corn_log',array('data'=> json_encode($corn_log)) ,array('id' => $corn_log_id));     
    	      }
    }
    
    private function send_sample_out_spno($s_id,$c_no,$c_name,$spno_member)
    {
    	      echo $s_id;
    	      echo '-';
    	      echo $c_no;
    	      echo '-';
    	      echo $c_name;    	      
    	      echo '-';
    	      
    	      $set_data = $this->front_base_model->get_data('ap_sample',array('s_id' => $s_id),array('s_id'=>'asc'))[0];       
    	    
    	      $sql = "select distinct m.c_name,l.user_id,l.display_name
    	                from member m 
    	                join member_line e on m.c_no = e.c_no
    	                join line_user l on l.user_id = e.user_id  
                     where m.c_no = '".$c_no."'                                                
                       and ifnull(e.user_id,'') > '' ";                                              
            $send_data = $this->front_base_model->small_query($sql);            
    	      if ($send_data){  // 上線有綁定 Line
    	      	  $send_data = $send_data[0];
    	    
    	      	  $line_user_data = $this->line_service->get_line_user($send_data['user_id'] ,'',true);     
    	  	      if ($line_user_data['follow'] == 'disable'){
    	  	  	      $msg = '會員將安露莎Line封鎖，無法寄送！';            
    	  	      }else{ 
    	  	  	      $val['line_title'] = $set_data['line_out_title'];                    
                    $val['line_title2'] = '試用組出貨通知';                     
                    $val['name'] = '親愛的 '.trim($send_data['c_name']).' 會員您好';                           
                    $val['line_msg'] = '今日來賓申請試用組出貨名單如下';
                    $val['line_msg'] .= "\n";                    
                    $qname = '';
                    foreach ($spno_member as $key => $item){
                    	       if ($qname > ''){ $qname .= "、"; }
                    	       $qname .= trim($item['c_name']);                    	       
                    }
                    $val['line_msg'] .= $qname;
                                        
                    $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'sample_msg');            
               
                    $messages[]  = array(
                          'type'     => 'flex',
                          'altText'  => $set_data['line_out_title'].' '.$val['line_title2'],
                          'contents' => array(
                              'type'     => 'carousel',
                              'contents' => $bubble_data
                          )
                    );
                    
                  //  echo "<pre>".print_r($messages,true)."</pre>";
                                         
                    $send_result = $this->api_line_service->push($send_data['user_id'],$messages);
                    //echo "<pre>".print_r($send_result,true)."</pre>";
                    //exit; 
                    $this->load->model( 'Line_push_log' );                                            
                    
                    // 推送記錄
                    $this->Line_push_log->insert_log($send_data['user_id'],'sample_out_'.$s_id,$c_no,$messages,$send_result['http_code'],$send_result['result']);
                    
                    if ($send_result['http_code'] == 429) {  // 訊息數不足
                        $msg = 'Line 訊息數不足';                       
                    }elseif($send_result['http_code'] == 200){  // 寄送成功
                        $msg = '寄送成功 ';
                    }       
    	      	      echo '寄送成功 ';
    	      	  }
    	      }else{
    	      	  echo '未綁定';
    	      }
    	      echo '<br>';    	      
    }
    
    /*
    http://localhost/arsoa/corn/sample_reminder
    */    
    public function sample_reminder($setday = '')
    {
    	     if ($setday == ''){ // 有設定時間,沒指定就是今天的時間
    	         $today = strtotime(date("Y-m-d H:i:s"));
    	     }else{
    	         $today = strtotime(date("Y-m-d H:i:s",strtotime($setday)));
    	     }    	      
    	      
    	     $sql = "  select a.*,q.crdt as question_crdt,m.c_name,l.user_id,l.display_name,l.follow,m.c_no,s.set_data,a.c_no as uc_no,s.s_title,s.reminder_msg,s.reminder_referrer_msg,s.reminder_hour,q.rid,q.p_num,q.checkcode
    	                              from ap_sample_charge a 
    	                              join ap_sample s on a.s_id = s.s_id 
    	                              join ap_question_reply q on a.user_id = q.user_id and q.p_no = s.s_id and q.status = 'P'
    	                              join line_user l on l.user_id = a.user_id      	                              
    	                              left join member m on a.referrer_c_no = m.c_no
    	                              left join member_line e on a.referrer_c_no = e.c_no    	                              
                                   where a.status = 'Y'                                        
                                     and ifnull(s.reminder_hour,0) > 0
                                     and ifnull(s.reminder_msg,'') > ''
                                   order by m.c_no,a.s_id,a.outdt ";
            $send_data = $this->front_base_model->small_query($sql);
            $corn_log_id = $this->front_base_model->insert_table('ap_corn_log',array('doing'=>'sample_reminder','sql'=>$sql,'log'=> json_encode($send_data),'crdt'=>date('Y-m-d H:i:s')));
            $corn_log = array();
    	      if ($send_data){    	                    	  
    	          $c_no = '';
    	          $s_id = '';
    	          $spno_member = array();
    	          foreach ($send_data as $key => $item)
    	          {
    	          	        $set_data = json_decode($item['set_data'], true);
    	          	        
    	          	        if ($c_no > '' && ($c_no != trim($item['c_no']) || $s_id != trim($item['s_id'])  )){  // 通知推薦人    	               	        	  
    	          	        	  if (count($spno_member) > 0){
    	          	        	      self::sample_reminder_spno($s_id,$c_no,$c_name,$spno_member);
    	          	        	  }
    	          	        	  $spno_member = array();
    	          	        }
    	          	        
    	          	        
    	          	        echo $key;
    	          	        echo '.';    	                        	        
                          echo "[".$item['user_id']."]";
                          echo "[".$item['question_crdt']."]";
                         
    	          	        $send_line = true;    	          	       
    	          	        $question_crdt = strtotime($item['question_crdt']);
    	          	        
    	          	        $diff_hour = round(($today - $question_crdt) / 3600,0);  // 距離小時數
    	          	        echo "[".$diff_hour."]";
    	          	        if ((int)$item['reminder_hour'] == $diff_hour){    	               	          
                             if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
    	          	                echo "<pre>".print_r($item,true)."</pre>";             
    	          	           }
                             
       			                 if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試    
       			                     $msg = '';  
       			                 }else{
       			                     $msg = $this->block_service->sample_send_line($item['rid'],'sample_reminder',$item['p_num']);   
       			                 }
       			                 $h_data = array();
       			                 if ($msg == ''){
       			                     $spno_member[$item['p_num']][] = array(                                                                      
                                    'rid'    => $item['rid'],
                                    'p_num'  => $item['p_num'],
                                    'checkcode'  => $item['checkcode'],
                                    'c_no'   => trim($item['c_no']),
                                    'c_name' => trim($item['uname']),
                                  );
       			                      
       			                      $corn_log[] = array(
       			                                           'id'  => $item['id'],
       			                                           'rid' => $item['rid']
       			                                          );
       			                     
       			                      $h_data['send_date']  = date('Y-m-d H:i:s');
     				                      $where = array ('id' => $item['id']);
     				                      $this->front_base_model->update_table('ap_sample_charge',$h_data ,$where);     
     				                       
     				                      echo "[已寄送:".$item['rid']."]";
     				                  }else{ 
                                  echo "[".$msg."]";
                              }                             
                          }
                          $c_no   = trim($item['c_no']);
                          $s_id   = trim($item['s_id']);
                          $c_name = trim($item['c_name']);
                          echo '<br>';    	                  
    	          }
    	          
    	          if ($c_no > '' && count($spno_member) > 0){  // 通知推薦人    	               	        	      	               	        	  
    	          	  self::sample_reminder_spno($s_id,$c_no,$c_name,$spno_member);
    	          }
    	      }
    	      
    	      if (count($corn_log) > 0){
    	      	  // $this->front_base_model->update_table('ap_corn_log',array('data'=> json_encode($corn_log)) ,array('id' => $corn_log_id));     
    	      }
    }
    
    private function sample_reminder_spno($s_id,$c_no,$c_name,$spno_member)
    {
    	      echo $s_id;
    	      echo '-';
    	      echo $c_no;
    	      echo '-';
    	      echo $c_name;
    	      echo '-';
    	    //  echo "<pre>".print_r($spno_member,true)."</pre>";
    	      
    	      $set_data = $this->front_base_model->get_data('ap_sample',array('s_id' => $s_id),array('s_id'=>'asc'))[0];       
    	        	      
    	      if ($set_data['reminder_referrer_msg'] > ''){  // 有設定催填問卷推薦人訊息,才會寄
    	          $sql = "select distinct m.c_name,l.user_id,l.display_name
    	                    from member m 
    	                    join member_line e on m.c_no = e.c_no
    	                    join line_user l on l.user_id = e.user_id  
                         where m.c_no = '".$c_no."'                                                
                           and ifnull(e.user_id,'') > '' ";                                              
                $send_data = $this->front_base_model->small_query($sql);            
    	          if ($send_data){  // 上線有綁定 Line
    	          	  $send_data = $send_data[0];
    	          	  
    	          	  $line_user_data = $this->line_service->get_line_user($send_data['user_id'] ,'',true);     
    	  	          if ($line_user_data['follow'] == 'disable'){
    	  	      	      $msg = '會員將安露莎Line封鎖，無法寄送！';            
    	  	          }else{ 
    	  	      	      $val['line_title'] = $set_data['line_charge_title'];                    
                        $val['line_title2'] = '試用組問卷發送通知';                     
                        $val['name'] = '親愛的 '.trim($send_data['c_name']).' 會員您好';                           
                        $val['line_msg'] = $set_data['reminder_referrer_msg'];
                        
                        $amsg = array();
                        foreach ($spno_member as $key => $item){
                        	       $msg  = "第 ".$key." 次問卷：";
                        	       $qurl = '';
                        	       $qname = '';
                        	       foreach ($item as $key1 => $atem){
                        	       	        if ($qname > ''){ $qname .= "、"; }
                        	       	        $qname .= trim($atem['c_name']);
                        	       	        if ($qurl == ''){
                        	       	            $_url_data = str_replace('=', '', str_replace('/', '_',base64_encode(json_encode(array('do' => 'question_view', 'rid' => $atem['rid'], 'checkcode' => $atem['checkcode'])))));                     	       	            
                        	       	            $qurl = "https://www.arsoa.tw/question/v?r=".$_url_data;
                        	       	        }
                        	       }                    	       
                        	       $amsg[] = array(
                        	                         'msg' => $msg."\n".$qname,
                        	                         'qurl' => $qurl
                        	                      );
                        	       
                        }
                        
                        $val['amsg'] = $amsg;                    
                        
                        $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'question_msg');            
                   
                        $messages[]  = array(
                              'type'     => 'flex',
                              'altText'  => $set_data['line_charge_title'].' '.$val['line_title2'],
                              'contents' => array(
                                  'type'     => 'carousel',
                                  'contents' => $bubble_data
                              )
                        );
                        
                      //  echo "<pre>".print_r($messages,true)."</pre>";
                                             
                        $send_result = $this->api_line_service->push($send_data['user_id'],$messages);
                        //echo "<pre>".print_r($send_result,true)."</pre>";
                        //exit; 
                        $this->load->model( 'Line_push_log' );                                            
                        // 推送記錄
                        $this->Line_push_log->insert_log($send_data['user_id'],'sample_view',$c_no,$messages,$send_result['http_code'],$send_result['result']);
                        
                        if ($send_result['http_code'] == 429) {  // 訊息數不足
                            $msg = 'Line 訊息數不足';                       
                        }elseif($send_result['http_code'] == 200){  // 寄送成功
                            $msg = '寄送成功 ';
                        }       
    	          	      echo '寄送成功 ';
    	          	  }
    	          }else{
    	          	  echo '未綁定';
    	          }
    	      }
    	      echo '<br>';    	      
    }
    
    
}