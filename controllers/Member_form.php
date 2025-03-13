<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_form extends MY_Controller
{
    private $form_set   =  array(
                                   'q1' => '個人體測檢量記錄表', 
                                   'q2' => '鶴力晶 體驗服務表',
                                   'q3' => '肌膚諮詢記錄表',
                                );
    
    private $form_q2_set   =  array(
                                   'q1' => array(
                                                '高血壓',
                                                '糖尿病',
                                                '自體免疫疾病（紅斑性狼瘡、僵直性脊椎炎、類風濕性關節炎）',
                                                '腦部疾病',
                                                '記憶力困擾',
                                                '睡眠困擾',
                                                '經常不明原因頭痛',
                                                '癌症家族病史',
                                                '經常性疲憊',
                                                '失智症家族史',
                                                '常期使用安眠藥習慣',
                                                ), 
                                   'q2' => array(
                                                '無',
                                                '1~3年',
                                                '3~5年',
                                                '5年以上'
                                                ),
                                   'q3' => array(
                                                '無',
                                                '有'
                                                ),
                                   'q4' => array(
                                                '近視',
                                                '老花眼',
                                                '青光眼',
                                                '白內障',
                                                '乾眼症',
                                                '經常流眼油',
                                                '畏光',
                                                '黃斑部退化',
                                                '飛蚊症',
                                                '視網膜剝離'
                                                ),             
                                   'q5' => array(
                                                '平日需大量使用視力（每日超過1小時）',
                                                '無法充份休息',
                                                '經常性感冒',
                                                '經常性熬夜',
                                                '常期扮演家庭照護者',
                                                '常需要動腦',
                                                '高壓族群',
                                                '排尿異常',
                                                '記憶力困擾'
                                                ),    
                                );
    private $form_q4_set   =  array(                                   
                                   '普通肌_time' => '水分及皮脂分量平衡。肌膚光滑、水潤有彈性。', 
                                   '普通肌_hz' => '蜜皂、泥膜、化粧水II、美白精華液EX', 
                                   '油性肌_time' => '水分足夠且皮脂分泌量過多的肌膚。易黏膩、毛孔明顯，表面泛油光。', 
                                   '油性肌_hz' => '蜜皂、泥膜、化粧水I（長青春痘）、化粧水II（無青春痘）、美白精華液EX', 
                                   '乾性肌_time' => '水分及皮脂分泌量不足，天然保護膜形成不全的肌膚。容易乾燥；易產生小細紋，脫皮的問題。', 
                                   '乾性肌_hz' => '蜜皂、泥膜、活膚化粧水、美白精華液EX / 活膚精華液', 
                                   '混合肌_time' => '水分及皮脂分泌量不平衡的肌膚。呈現黏膩感的同時又有乾燥的問題。', 
                                   '混合肌_hz' => '蜜皂、泥膜、化粧水II、美白精華液EX', 
                                   '敏感肌_time' => '皮脂分泌量不足導致肌膚容易乾燥；易有灼熱、緊繃、刺痛感等敏感反應的問題。', 
                                   '敏感肌_hz' => '蜜皂、泥膜、化粧水I / AP柔敏化粧水、精華液I', 
                                );
                                       
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->library('ui');

        $this->load->model( 'front_member_model' ); 
        $this->load->model( 'front_base_model' ); 
        $this->load->model( 'front_order_model' );        
                
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
        
    }
    
    public function data($check_mobile = '')
    {
    	  if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/data' );
            exit;
        }  
    	  
    	  $data['title'] = '表單個人資料維護';
    	  
    	  $data['qtype'] = 'data';
    	  
    	  $data['check_mobile'] = $check_mobile;
    	  
    	  $data['ok_message'] = $this->session->flashdata( 'ok_message' );

    	  _timer('*** before layout ***');
     
        $this->layout->view('member_form/form_data', $data);
    }
            
    public function check_mobile($qtype)
    {
    	 
    	 if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            $result = array('status' => 1);
            if ($qtype == 'data'){
                $result['html'] = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px">操作逾時，<a href="'.base_url('member/login?rdurl=member_form/data').'">請重新登入</a></span>！</div>';
            }else{
            	  $result['html'] = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px">操作逾時，<a href="'.base_url('member/login?rdurl=member_form/question/'.$qtype).'">請重新登入</a></span>！</div>';
            }
            $result['question'] = '';
    	      $this->output->set_content_type('application/json');            
            echo json_encode($result);
            exit;
       }  
       
       $result = array('status' => 0);                
       $data_post = $this->input->post( NULL, FALSE );
       
       $data['qtype'] = $qtype;
              
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0){          	  
            $result = array('status' => 1);
            
            $where = array(
                           'c_no'    => $this->session->userdata('member_session')['c_no'],
                           'parent_qid' => '0',
                           'qtype'   => 'set',
                           'mobile'  => trim($data_post['check_mobile']),
                          );            
    	      $personal_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);     
    	      
    	      if ($qtype == 'edit_mobile'){  // 修改判斷手機號碼是否已有人用過.
    	          if ($personal_data){
    	          	  $result['status'] = 1;
    	          	  $result['errmsg'] = '您已有一筆資料使用此手機號碼（姓名：'.$personal_data['name'].'）';
    	          }else{
    	          	  $result['status'] = 0;
    	          }
    	          $this->output->set_content_type('application/json');            
                echo json_encode($result);
                exit;   
    	      }
    	      
    	      if ($personal_data){
    	      	  $parent_qid = $personal_data['qid'];
    	      }else{
    	      	  if ($qtype != 'data'){    	      	
    	              $result['html'] = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px">尚未建檔，<a href="'.base_url('member_form/data/'.$data_post['check_mobile']).'">來去建檔</a></span>！</div>';
    	              $result['question'] = '';
    	              $this->output->set_content_type('application/json');            
                    echo json_encode($result);
                    exit;
         	      }    	      	  
    	      	  $personal_data['mobile'] = trim($data_post['check_mobile']);
    	      }
    	      
    	      $personal['personal_data'] = $personal_data;    	      
    	      $personal['form_q4_set'] = $this->form_q4_set;
    	          	      
    	      if ($qtype == 'q1'){
    	      	  if ($personal_data['f1'] == '' || $personal_data['f3'] == '' || $personal_data['f9'] == '' || $personal_data['f10'] == '' || $personal_data['f11'] == ''){
    	      	  	  $result['html'] = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px">體測標準建議值，資料未填寫完全，<a href="'.base_url('member_form/data/'.$data_post['check_mobile']).'">來去設定</a></span>！</div>';
    	              $result['question'] = '';
    	              $this->output->set_content_type('application/json');            
                    echo json_encode($result);
                    exit;
    	      	  }
    	      	  
    	      	  $data['qnum'] = 1;
    	      	      	    
    	          $data['data'] = $personal['personal_data'];     
    	      	  
    	      	  $data['question_title'] = '個人標準建議值';
    	      	  
    	      	  $data['required'] = 'required';
    	      	  $data['readonly'] = 'readonly';
    	      	  $data['iname'] = 'set_';    	      	  
    	          $result['question'] = $this->load->view('member_form/question_'.$qtype, $data, TRUE);
    	          
    	          $where = array(
                           'c_no'					=> $this->session->userdata('member_session')['c_no'],
                           'qtype'				=> $qtype,
                           'parent_qid'		=> $parent_qid,
                          );            
    	          $data['data_list'] = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'));  
    	          
    	          if ($data['data_list']){
    	          	  $data['qnum'] = $data['data_list'][0]['qnum'] + 1;
    	          } 
    	          
    	          $data['question_title'] = '第 '.$data['qnum'].' 次個人實測值<input type="hidden" name="qnum" id="qnum" value="'.$data['qnum'].'">';
    	          $data['question_date'] = date('Y-m-d');    	          
    	          $data['data'] = array();
    	          $data['required'] = 'required';
    	          $data['readonly'] = '';
    	      	  $data['iname'] = '';
    	          $result['question'] .= $this->load->view('member_form/question_'.$qtype, $data, TRUE);    	          
    	                  	          
    	      }
    	      
    	      $can_input = true;
    	      if ($qtype == 'q2'){    	      	  
    	      	  $data = array();
    	      	  $data['qnum'] = 1;
    	      	  $where = array(
                           'c_no'					=> $this->session->userdata('member_session')['c_no'],
                           'qtype'				=> $qtype,
                           'parent_qid'		=> $parent_qid,
                          );            
    	          $q2_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);  
    	          
    	      	  $data['form_q2_set'] = $this->form_q2_set;     	      	  	  
    	      	  if ($q2_data){
    	      	  	  $result['question'] = '<div class="row">
																					    <div class="col-6 mt10 mb30">建立時間：'.$q2_data['crdt'].'</div>';
										if ($q2_data['updt'] > ''){						    
  											$result['question'] .= '<div class="col-6 text-right mt10 mb30">最後修改時間：'.$q2_data['updt'].'</div>';
							      }
										$result['question'] .= '</div>';    	      	  	  
    	      	  	      	      	  	  
    	      	  	  $result['question'] .= $this->load->view('member_form/question_'.$qtype.'_show', $q2_data, TRUE);
    	      	  	  $result['question'] .= '<input type="button" class="btn btn-outline-danger btn-block" onClick="location.href=\''.base_url('member_form/modify/'.$qtype.'/'.$q2_data['checkcode']).'\';" value="修改表單">';  
    	      	  	  
    	      	  	  $can_input = false;
    	      	  }else{
    	      	      $result['question'] = $this->load->view('member_form/question_'.$qtype, $data, TRUE);
    	      	  }
    	      }
    	      
    	      if ($qtype == 'q3'){
    	      	  if ($personal_data['q3'] == '' || $personal_data['q4'] == ''){
    	      	  	  $result['html'] = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px">肌膚諮詢資料，未填寫完全，<a href="'.base_url('member_form/data/'.$data_post['check_mobile']).'">來去設定</a></span>！</div>';
    	              $result['question'] = '';
    	              $this->output->set_content_type('application/json');            
                    echo json_encode($result);
                    exit;
    	      	  }
    	      	  
    	      	  $data['qnum'] = 1;
    	      	  
    	      	  $where = array(
                           'c_no'					=> $this->session->userdata('member_session')['c_no'],
                           'qtype'				=> $qtype,
                           'parent_qid'		=> $parent_qid,
                          );            
    	          $data['data_list'] = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'));  
    	          
    	          if ($data['data_list']){
    	              $data['qnum'] = count($data['data_list'])+1;
    	          }
    	      	  
    	      	  $result['question'] = $this->load->view('member_form/question_q3', $data, TRUE);
    	      }
    	      
    	      if ($can_input && $qtype != 'data'){
    	          $result['question'] .= '<input type="submit" class="btn btn-outline-danger btn-block" value="送出表單">';
    	      }else{
    	      	  if ($qtype == 'data'){
    	      	      $result['question'] = '<input type="submit" class="btn btn-outline-danger btn-block" value="送出表單">';
    	      	  }
    	      } 
    	      
    	      if ($qtype == 'data'){
    	          $personal['personal_data']['type']       = 'data';
    	      }else{
    	          $personal['personal_data']['type']       = 'complete';    	      
    	      }
    	      $personal['qtype'] = $qtype;
    	      
    	      $data_input_date = '';
    	      if ($qtype == 'data' && isset($personal_data['crdt'])){
    	          if (isset($data_post['ok_message']) && $data_post['stype'] == 'E'){
                    $data_input_date = '<div style="text-align:center;margin:0 auto;" class="row"><span style="font-size:18px;color:green;">'.$data_post['ok_message'].'</span></div>';
                }
    	          $data_input_date .= '<div class="col-sm-12 alert alert-info"><div class="col-sm-4" style="float:left"><label class="label-custom">手機號碼</label>'.$personal_data['mobile'].'</div>';  
    	          $data_input_date .= '<div class="col-sm-4" style="float:left"><label class="label-custom">建立時間</label>'.$personal_data['crdt'].'</div>';  
 							  if ($personal_data['updt'] > ''){						    
  									$data_input_date .= '<div class="col-sm-4" style="float:left"><label class="label-custom">最後修改時間</label>'.$personal_data['updt'].'</div>'; 
							  }							  
								$data_input_date .= '</div></div>';    	      	  	  
    	      }      	      	  	  
    	      
    	      $result['html'] = $data_input_date.$this->load->view('member_form/personal', $personal, TRUE);
    	      
    	      // 有歷史記錄
    	      if (isset($data['data_list']) && $data['data_list']){
    	      	  $result['question'] .= '<br><br><div id="form_history" style="border-style:solid;width:100%;height:650px;overflow-y:scroll;overflow-x:hidden;border-color:#cccccc;border-width:1px;padding:8px 8px;">';
			          foreach ($data['data_list'] as $key => $item){
			          	       if ($key > 0){ $result['question'] .= '<hr>'; }			          	  
			          	       $hdata['question_date'] = date('Y-m-d',strtotime($item['crdt']));     
			          	       $hdata['question_checkcode'] = trim($item['checkcode']);     
			          	       if ($qtype == 'q1'){
			          	           $hdata['question_title'] = '第 '.$item['qnum'].' 次個人實測值';
    	                       $hdata['iname'] = 'q'.$item['qnum'].'_his_';
    	                       $hdata['data'] = $item;
    	                       $hdata['readonly'] = ' readonly ';
    	                       $result['question'] .= $this->load->view('member_form/question_'.$qtype, $hdata, TRUE);
    	                   }elseif($qtype == 'q3'){
    	                       $result['question'] .= '<div class="container mb-4">
                                             <div class="card bg-light">
    	                                         <div class="card-body">
    	                                         <b>講師產品使用建議</b> ('.$hdata['question_date'].')
    	                                         &nbsp;&nbsp;<a class="badge badge-secondary" href="'.base_url('member_form/modify/q3/'.$item['checkcode']).'">&nbsp;修改&nbsp;</a>
    	                                         <br>
    	                                         '.$item['t1'].'</div>
    	                                       </div>  	
    	                                     </div>';
    	                   }
			          }
			          $result['question'] .= '</div>';
    	      }			
    	      	                
    	      if ($qtype == 'q3'){
    	      	  $result['question'] .= '<img src="'.base_url('public/images/q3_1.png').'" class="img-fluid"><img src="'.base_url('public/images/q3_2.png').'" class="img-fluid">';
            }
            
            $result['question'] .= '<input type="hidden" name="check_mobile" value="'.$data_post['check_mobile'].'">';
    	 }
    	 
    	 $this->output->set_content_type('application/json');            
       echo json_encode($result);
       exit;   
    	
    }
    
    public function data_save()
    {
    	 
    	 if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/data' );
            exit;
       }  
       
       $data_post = $this->input->post( NULL, FALSE );
        
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
            
            $qid = 0;
            $where = array(
                           'c_no'    => $this->session->userdata('member_session')['c_no'],
                           'qtype'   => 'set',
                           'parent_qid' => '0',
                           'mobile'  => trim($data_post['mobile_old']),
                          );
            
    	      $check_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);               
    	      
    	      if ($check_data){
    	          $qid = $check_data['qid'];
    	      }
    	          	      
            if ($data_post['mobile_old'] != $data_post['mobile']){            	
            	  $where = array(
                           'c_no'    => $this->session->userdata('member_session')['c_no'],
                           'qtype'   => 'set',
                           'parent_qid' => '0',
                           'mobile'  => trim($data_post['mobile']),
                          );            
    	          $check_mobile_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);        
    	          if ($check_mobile_data){
            	      alert('您所修改的手機號碼 （'.$data_post['mobile'].'）已有其他的表單資料！');
            	      exit;  
            	  }
            }

    	      $set_data['mobile']    		= $data_post['mobile'];
    	      $set_data['name']     		= $data_post['name'];
    	      $set_data['sex']       		= $data_post['sex'];
    	      $set_data['birth_year']		= $data_post['birth_year'];    	          
    	      $set_data['q1']    				= $data_post['q1'];
    	      $set_data['q2']					  = $data_post['q2'];
    	      
    	      $q3 = '';    	       	   
    	      foreach ($data_post['q3'] as $item){
    	              if ($q3 > ''){ $q3 .= ','; }
    	              $q3 .= $item;
    	      }         	   	   
    	      $set_data['q3']    = $q3;
    	      $set_data['q4']    = $data_post['q4'];
    	      
    	      for ($i = 1;$i<=15;$i++){
    	      	   if ($data_post['f'.$i] > ''){
    	      	    	 $set_data['f'.$i] = $data_post['f'.$i];
    	      	   }
    	      }
    	        
    	      if ($qid > 0){    	      
    	          $checkcode = $check_data['checkcode'];    	          
    	          $set_data['updt'] = date('Y-m-d H:i:s');
    	          $where = array ('qid' => $qid,'c_no'=>$this->session->userdata('member_session')['c_no']);                              
     					  $this->front_base_model->update_table('member_form',$set_data ,$where);     
     					  
     					  $okmsg = '資料修改成功（'.$data_post['mobile'].' '.$set_data['name'].'）！';
    	      }else{    	          
    	         	$checkcode = uniqid();
    	         	$set_data['c_no']  = $this->session->userdata('member_session')['c_no'];
    	         	$set_data['qtype'] = 'set';
    	         	$set_data['parent_qid'] = '0';    	         	
    	         	$set_data['crdt']	 = date('Y-m-d H:i:s');    	         	   
    	         	$set_data['checkcode'] = $checkcode;
    	         	$this->db->insert('member_form', $set_data);
    	         	
    	         	$okmsg = '資料新增成功（'.$data_post['mobile'].' '.$set_data['name'].'）！';
    	      }
    	      
    	      $this->session->set_flashdata( 'ok_message', $okmsg );
       }
       
       redirect( 'member_form/data/'.$data_post['mobile'] );
       exit;
          
    }       
    
    
    public function question($qtype)
    {              
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/question/'.$qtype );
            exit;
        }  
               
        $data['form_set'] = $this->form_set;
        
        $data['qtype'] = $qtype;
        
        $data['onSubmit'] = '';
        if ($qtype == 'q2' || $qtype == 'q3'){
        	  $data['onSubmit'] = ' onSubmit="return Form_question_check(this);"';            
        }
        
    	  _timer('*** before layout ***');
     
        $this->layout->view('member_form/form_main', $data);      
        
    }
    
    
    public function question_save($qtype)
    {
    	 
    	 if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/question/'.$qtype );
            exit;
       }  
       
       $data_post = $this->input->post( NULL, FALSE );
        
       if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
            
            if (isset($data_post['checkcode']) && $data_post['checkcode'] > ''){     // 資料修改
                  $where = array(
                                 'c_no'    		=> $this->session->userdata('member_session')['c_no'],
                                 'qtype'   		=> $qtype,
                                 'checkcode'  => trim($data_post['checkcode']),
                                );            
    	            $chk_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);       
    	            
    	            if ($chk_data){
    	                $mdata['updt'] = date('Y-m-d H:i:s');   
    	                if ($qtype == 'q1'){
    	                    for ($i = 1;$i<=15;$i++){    	                         
    	                    	   if ($data_post['f'.$i] > ''){
    	                             $mdata['f'.$i] = $data_post['f'.$i];    	               	         
    	                         }else{
    	                             $mdata['f'.$i] = null;
    	                         }     	                         
    	                    }
    	                }
    	                if ($qtype == 'q3'){
    	                    $mdata['t1'] = $data_post['t1'];    	               	         
    	                }
    	                $checkcode = $chk_data['checkcode'];
    	                $where = array ('qid'=>$chk_data['qid'],'c_no'=>$this->session->userdata('member_session')['c_no']);                              
     				      		$this->front_base_model->update_table('member_form',$mdata ,$where);     
    	            }                 
            }else{
                  // -- 基本資料 -- 存檔            
                  $where = array(
                                 'c_no'    => $this->session->userdata('member_session')['c_no'],
                                 'qtype'   => 'set',
                                 'mobile'  => trim($data_post['mobile']),
                                );            
    	            $personal_data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);                	      
    	            
    	            $parent_qid = $personal_data['qid'];
    	            
                  $set_data = array(); 
       	          if ($qtype == 'q1'){       	           	         
    	                $mdata['c_no']  = $this->session->userdata('member_session')['c_no'];
    	                $mdata['parent_qid'] = $parent_qid;
    	                $mdata['qtype'] = $qtype;    	         
    	                
    	                for ($i = 1;$i<=15;$i++){
    	                    unset($mdata['f'.$i]);
    	                    if ($data_post['f'.$i] > ''){
    	               	        $mdata['f'.$i] = $data_post['f'.$i];
    	               	    }
    	                }
    	                $checkcode = uniqid();    	         
    	                $mdata['qnum'] = $data_post['qnum'];
    	                $mdata['checkcode'] = $checkcode;
    	                $mdata['crdt'] = date('Y-m-d H:i:s');    	         	   
    	                $this->db->insert('member_form', $mdata);
       	          }
       	         
       	          if ($qtype == 'q2'){       	   	   
       	         	   $where = array(
                                 'c_no'					=> $this->session->userdata('member_session')['c_no'],
                                 'qtype'				=> 'q2',
                                 'parent_qid'		=> $parent_qid
                                );            
    	               $mdata = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);        
       	         	   
    	               $chk_data = 'U';
       	         	   if ($mdata){
       	         	       $mdata['updt']			= date('Y-m-d H:i:s');  
       	         	       $checkcode         = $mdata['checkcode'];	
       	         	   }else{
       	         	       $chk_data = 'I';
       	         	       $mdata['parent_qid'] = $parent_qid;
       	         	       $mdata['c_no']			= $this->session->userdata('member_session')['c_no'];       	   	       
       	         	       $checkcode					= uniqid();
       	         	       $mdata['qtype']		= $qtype;
    	                   $mdata['qnum']			= 1;
    	                   $mdata['checkcode'] = $checkcode;
    	                   $mdata['crdt']			= date('Y-m-d H:i:s');    	         	   
       	         	   }
       	         	         	   	   
       	         	   $q1 = '';    	       	   
    	             	 foreach ($data_post['q1'] as $item){
    	             	          if ($q1 > ''){ $q1 .= ','; }
    	             	          $q1 .= $item;
    	             	          if ($item == '其它' && $data_post['q1_other'] > ''){
    	             	          	  $q1 .= "(".$data_post['q1_other'].")";
    	             	          }
    	             	 }    	       	   
    	             	 $mdata['q1']		= $q1;
    	             	 $mdata['q2']   = $data_post['q2'];
    	             	 $mdata['q3']   = $data_post['q3'];
    	             	 $q4 = '';
    	             	 foreach ($data_post['q4'] as $item){
    	             	          if ($q4 > ''){ $q4 .= ','; }
    	             	          $q4 .= $item;
    	             	          if ($item == '眼部曾經手術，病因' && $data_post['q4_other'] > ''){
    	             	          	  $q4 .= "(".$data_post['q4_other'].")";
    	             	          }
    	             	 }
    	             	 $mdata['q4'] = $q4;
    	             	 
    	             	 $q5 = '';
    	             	 foreach ($data_post['q5'] as $item){
    	             	          if ($q5 > ''){ $q5 .= ','; }
    	             	          $q5 .= $item;
    	             	          if ($item == '其它' && $data_post['q5_other'] > ''){
    	             	          	  $q5 .= "(".$data_post['q5_other'].")";
    	             	          }
    	             	 }
    	             	 $mdata['q5'] = $q5;
       	         	   
       	         	   if ($chk_data == 'I'){
       	         	       $this->db->insert('member_form', $mdata);    	         
       	         	   }else{
       	         	       $where = array ('qid'=>$mdata['qid'],'c_no'=>$this->session->userdata('member_session')['c_no']);                              
     				      			 $this->front_base_model->update_table('member_form',$mdata ,$where);     
       	         	   }
       	         }
       	         
       	         
       	         if ($qtype == 'q3'){       	   	   
       	         	   $mdata['c_no']  = $this->session->userdata('member_session')['c_no'];
       	         	   $mdata['parent_qid'] = $parent_qid;
    	               $mdata['t1']    = $data_post['t1'];
       	         	   $checkcode = uniqid();       	   	   
    	               $mdata['qtype'] = $qtype;
    	               $mdata['qnum'] = $data_post['qnum'];
    	               $mdata['checkcode'] = $checkcode;
    	               $mdata['crdt'] = date('Y-m-d H:i:s');    	         	   
    	               $this->db->insert('member_form', $mdata);    	         
       	         }
       	     }
       }
       
       redirect( 'member_form/complete/'.$qtype.'/'.$checkcode );
       exit;
          
    }  
    
    public function modify($qtype,$checkcode)
    {
         if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/question/'.$qtype );
            exit;
         }  
         
         $result = array('status' => 0);                
         
         $data['qtype'] = $qtype;
         
         $where = array(
                        'c_no'				=> $this->session->userdata('member_session')['c_no'],
                        'qtype'		   	=> $qtype,
                        'checkcode'   => $checkcode,
                       );
         $data = $this->front_base_model->get_data('member_form',$where,array('qid'=>'desc'),1);    
         
         if ($data){         
             $result['status'] = 1;             
             
             $parent_qid = $data['parent_qid'];
             
             if ($qtype == 'q1'){    	       	      	       	       	      	  	      	   	  
    	       	   $data['question_title'] = '第 '.$data['qnum'].' 次個人實測值<input type="hidden" name="qnum" id="qnum" value="'.$data['qnum'].'"><input type="hidden" name="checkcode" id="checkcode" value="'.$checkcode.'">';
    	       	   $data['data'] = $data;
    	       	   $data['required'] = 'required';
    	       	   $data['iname'] = '';
    	       	   $data['readonly'] = '';
    	       	   $data['question'] = $this->load->view('member_form/question_'.$qtype, $data, TRUE);
    	       }
    	       
    	       if ($qtype == 'q2'){    	       	  
    	       	   $data['form_q2_set'] = $this->form_q2_set;     	      	  	      	   	  
    	       	   $data['question'] = $this->load->view('member_form/question_'.$qtype, $data, TRUE);
    	       }
    	       
    	       if ($qtype == 'q3'){    	       	      	
    	           $data['form_q4_set'] = $this->form_q4_set;       	   
    	       	   $data['question'] = $this->load->view('member_form/question_'.$qtype, $data, TRUE);
    	       	   $data['question'] .= '<input type="hidden" name="checkcode" id="checkcode" value="'.$checkcode.'">';
    	       }
    	       $data['question'] .= '<input type="submit" class="btn btn-outline-danger btn-block" value="修改表單">';
    	       
    	       $where = array(
                        'c_no'  => $this->session->userdata('member_session')['c_no'],
                        'qtype' => 'set',
                        'qid'		=> $parent_qid
                       );            
    	       $personal['personal_data'] = $this->front_base_model->get_data('member_form',$where,'',1);      
    	       $personal['personal_data']['type'] = 'complete';
    	       $personal['qtype'] = 'q3_edit';
    	       $data['html'] = $this->load->view('member_form/personal', $personal, TRUE);
    	       
    	   }
    	   
    	   $data['form_set'] = $this->form_set;
    	   
    	   $data['onSubmit'] = '';
         if ($qtype == 'q2' || $qtype == 'q3'){
        	   $data['onSubmit'] = ' onSubmit="return Form_question_check(this);"';            
         }
         
         $data['form_edit'] = 'Y';
    	  
    	   $this->layout->view('member_form/form_main', $data); 	      
    }
    
    // http://localhost/arsoa/member_form/complete/q1/625a5ccba8cfe
    public function complete($qtype,$checkcode)
    {
    	  if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/question/'.$qtype );
            exit;
        } 
        
        if ($checkcode == ''){    	  
    	      alert( '操作有誤，請重新填寫(Q'.$qtype.'01)！' ,base_url('member_form/question/'.$qtype));
    	      exit;
    	  }
    	  
    	  $where = array(
                            'c_no'       => $this->session->userdata('member_session')['c_no'],
                            'qtype'      => $qtype,
                            'checkcode'  => $checkcode
                       );            
    	  $data = $this->front_base_model->get_data('member_form',$where,'',1);        
    	  
    	  if (!$data){    	  
    	      alert( '操作有誤，請重新填寫(Q'.$qtype.'99)！' ,base_url('member_form/question/'.$qtype));
    	      exit;
    	  }
    	  
    	  $where = array(
                        'c_no'  => $this->session->userdata('member_session')['c_no'],
                        'qtype' => 'set',
                        'qid'		=> $data['parent_qid']
                       );            
    	  $personal_data = $this->front_base_model->get_data('member_form',$where,'',1);      
        	  
    	  $data['form_set'] = $this->form_set;
    	  
    	  if ($qtype == 'q1'){    	            	      
    	      $data['question'] = $this->load->view('member_form/question_'.$qtype, array('question_title' => '個人標準建議值' ,'required' => '','iname' => 'set_','readonly' => 'readonly' ,'data' => $personal_data), TRUE);
    	      
    	      $cdata['question_title'] = '第 '.$data['qnum'].' 次個人實測值';
    	      $cdata['question_date'] = date('Y-m-d',strtotime($data['crdt']));
    	      
    	      $cdata['data'] = $data;
    	          	      
    	      $data['question'] .= $this->load->view('member_form/question_'.$qtype, $cdata, TRUE);    	       
    	      
    	      $data['personal_data']['q2']         = trim($data['q2']);
    	  }
    	   
    	  if ($qtype == 'q2'){
    	  	  $data['form_q2_set'] = $this->form_q2_set; 
    	  	  $data['question'] = $this->load->view('member_form/question_'.$qtype.'_show', $data, TRUE);    	           	  	
    	  }
    	  
    	  if ($qtype == 'q3'){
    	  	  $data['question'] = $this->load->view('member_form/question_'.$qtype.'_show', $data, TRUE);    	           	  	    	  	  
    	  	  $data['form_q4_set'] = $this->form_q4_set;
    	  }
    	      	
    	  $data['qtype']  = $qtype;
    	  
    	  $data['form_set'] = $this->form_set;
    	  
        $data['personal_data']  = $personal_data;
        
        $data['personal_data']['type']       = 'complete';
     
    	  $data['personal'] = $this->load->view('member_form/personal', $data, TRUE);      
    	      	          
    	  _timer('*** before layout ***');
     
        $this->layout->view('member_form/complete', $data);            
    }
    
    // http://localhost/arsoa/member_form/pdf/q1/625a5ccba8cfe
    public function pdf($qtype = 'q1',$checkcode = '')
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=member_form/question/'.$qtype );
            exit;
        } 
        
        $where = array(
                            'c_no'       => $this->session->userdata('member_session')['c_no'],
                            'qtype'      => $qtype,
                            'checkcode'  => $checkcode
                       );            
    	  $data = $this->front_base_model->get_data('member_form',$where,'',1);        
    	  
    	  if (!$data){    	  
    	      alert( '操作有誤，請重新填寫(Q'.$qtype.'99)！' ,base_url('member_form/question/'.$qtype));
    	      exit;
    	  }
    	      	  
    	  $data['form_set'] = $this->form_set;
    	  
    	  $where = array(
                        'c_no'  => $this->session->userdata('member_session')['c_no'],
                        'qtype' => 'set',
                        'qid'		=> $data['parent_qid']
                       );            
    	  $personal_data = $this->front_base_model->get_data('member_form',$where,'',1);      
    	      	  
    	  if ($qtype == 'q1'){
    	      
    	      $data['question'] = $this->load->view('member_form/question_'.$qtype.'_pdf', array('question_title' => '個人標準建議值' ,'question_date' => date('Y-m-d',strtotime($personal_data['crdt'])),'required' => '','iname' => 'set_','readonly' => 'readonly' ,'data' => $personal_data), TRUE);
    	      
    	      $cdata['question_title'] = '第 '.$data['qnum'].' 次個人實測值';    	      
    	      
    	      $cdata['data'] = $data;
    	      
    	      $cdata['question_date'] = date('Y-m-d',strtotime($data['crdt']));
    	      
    	      $cdata['iname'] = 'data';
    	       
    	      $data['question'] .= $this->load->view('member_form/question_'.$qtype.'_pdf', $cdata, TRUE);    	
    	      
    	      $data['personal_data']['q2']         = trim($data['q2']);       
    	  }
    	  
    	  if ($qtype == 'q2' || $qtype == 'q3'){
    	  	  $data['form_q2_set'] = $this->form_q2_set; 
    	  	  $data['question'] = $this->load->view('member_form/question_'.$qtype.'_pdf', $data, TRUE);    	           	  	
    	  }
    	      	  
    	  $data['personal'] = $this->load->view('member_form/personal_pdf', $personal_data, TRUE);      
    	  
    	 // $data['logo']     = base_url('public/images/logo.png');
    	  $data['logo']     = 'http://www.arsoa.tw/public/images/logo.png';
    	  
    	  
        $data['html'] = $data['personal'].$data['question'];
    	  
    	  $data['pdf_name'] = $this->form_set[$qtype];
    	  
    	  $data['pdf_title'] = $personal_data['name'].'_'.$this->form_set[$qtype].'_'.date('Ymd');
    	      	                   
    	  $html = $this->load->view('member_form/pdf', $data, TRUE);          	                   
                
      //  if ($pdf == 'Y'){
            $this->load->library('Pdf');
            
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetFont('msungstdlight', '', 14);
            
            $pdf->AddPage();        
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output($data['pdf_title'].'.pdf');
      //  }else{     
      //  echo $html ;            
        
        exit;
    }
    
} 