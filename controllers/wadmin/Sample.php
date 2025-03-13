<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service',
            'line_service',
            'api_line_service'
        ));        
        
        $this->load->library( 'ui' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_admin_model' );
        $this->load->model( 'sample_model' );           
        $this->load->model( 'question_model' );           
        
        
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function list($kind)
    {
       
        $data['Search'] = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $like = array();
        $where['a.s_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.s_title'      => $data['Search'],
                     'a.s_desc'      => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_sample',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.s_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'sample';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	  $data['list']['rows'][$key]['s_reply_count'] = $this->sample_model->charge_find_count($item['s_id'],'S');
        	  $data['list']['rows'][$key]['i_reply_count'] = $this->sample_model->charge_find_count($item['s_id'],'I');
        	  $data['list']['rows'][$key]['f_reply_count'] = $this->sample_model->charge_find_count($item['s_id'],'F');
        	  
        	  $data['list']['rows'][$key]['s_reply_count_Y'] = $this->sample_model->charge_find_count($item['s_id'],'S','Y');
        	  $data['list']['rows'][$key]['i_reply_count_Y'] = $this->sample_model->charge_find_count($item['s_id'],'I','Y');
        	  $data['list']['rows'][$key]['f_reply_count_Y'] = $this->sample_model->charge_find_count($item['s_id'],'F','Y');
        	  
        	  $data['list']['rows'][$key]['line_disable_num'] = $this->sample_model->charge_disable_count($item['s_id']);        	          	  
        	  $data['list']['rows'][$key]['line_disable_num_Y'] = $this->sample_model->charge_disable_count($item['s_id'],'Y');
        	  
        	  $data['list']['rows'][$key]['reply_count'] = $data['list']['rows'][$key]['s_reply_count'] + $data['list']['rows'][$key]['i_reply_count'] + $data['list']['rows'][$key]['f_reply_count'];
        	  $data['list']['rows'][$key]['reply_count_Y'] = $data['list']['rows'][$key]['s_reply_count_Y'] + $data['list']['rows'][$key]['i_reply_count_Y'] + $data['list']['rows'][$key]['f_reply_count_Y'];
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/sample_list', $data);
        
    }
    
    public function modify($kind,$type = 'N')
    {
        $data_post = $this->input->post();
        
        $data['edit'] = 0;
        $data['Search'] = '';        
        $data['Page'] = 1;
        $data['data'] = array();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (!empty($this->input->get( 'edit' ))){
                 $data['edit'] = (int)$this->input->get( 'edit' );
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }                       
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }          
        }
        
        if($data['edit'] == '') {
            $data['modify_name'] = '新增';
            $data['data'] = array(
                'edit'     => 0,
                'p_no'  => '',
                's_title'  => '',
                's_desc'   => '',                                
                's_start'  => '',
                's_end'    => '',
                'set_hour' => '18',
                's_num'    => '0',
                'f_num'    => '0',
                'i_num'    => '0',
                'status'   => 'N',
                'use_line' => 'Y'
            );
        }
        else {
            $where  = array ('s_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_sample',$where);
            
            if (!$data['data']){
                redirect( 'sample/list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['set_data']   = json_decode($data['data']['set_data'], true);                                                 
                $data['data']['sample_data']   = json_decode($data['data']['sample_data'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['s_id'] = 0;
                $data['data']['status'] = 'N';
            }
        }
                
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $data['question']  = $this->front_base_model->get_data('ap_question',array('classid' => 'QA5','status' => 'Y'),array('q_id'=>'asc'));  
        
        $this->layout->view('admin/sample_modify', $data);      
          
    }
    
    // 存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                                      
             $data = array (
                        's_title'=> $data_post['s_title'], 
                        'p_no'=> $data_post['p_no'],     
                        's_desc'=> $data_post['s_desc'],   
                        's_start'=> $data_post['s_start'],   
                        's_end'=> $data_post['s_end'],   
                        'f_start'=> $data_post['f_start'],   
                        'f_end'=> $data_post['f_end'],   
                        'i_start'=> $data_post['i_start'],   
                        'i_end'=> $data_post['i_end'],   
                        'i_num'=> $data_post['i_num'],   
                        's_num'=> $data_post['s_num'],   
                        'f_num'=> $data_post['f_num'],   
                        'line_title'=> $data_post['line_title'],   
                        'line_msg'  => $data_post['line_msg'],   
                        'line_out_title'=> $data_post['line_out_title'],   
                        'line_out_msg'  => $data_post['line_out_msg'],   
                        'line_charge_title'=> $data_post['line_charge_title'],   
                        'line_charge_msg'  => $data_post['line_charge_msg'],   
                        'reminder_hour'=> $data_post['reminder_hour'],   
                        'lock_days'=> $data_post['lock_days'],   
                        'reminder_msg'=> $data_post['reminder_msg'],   
                        'reminder_referrer_msg'=> $data_post['reminder_referrer_msg'],   
                        'set_hour'  => $data_post['set_hour'],   
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             $sample_num = 0;
             $srr = array();        
             $dsrr = array();        
             if ($data_post['sample_num'] > 0) {
                 $sort = 1;
                 // 題目數
                 for ($i = 1; $i <= $data_post['sample_num']; $i++) {
                     $sample_title = isset($data_post['sample_title_' . $i]) ? $data_post['sample_title_' . $i] : '';
                     if ($sample_title > ''){  // 有才存檔
                         $sample_num++;                                
                         $srr[$data_post['sample_sort_'.$i]]['sample_title'] = $sample_title;
                     }
                 }
             
                 ksort($srr); 
                 $arr = array();
                 $sort = 0;
                 foreach ($srr as $key => $item)
                 {
                      $sort++;
                      $dsr = array(
                                               'title'      => $item['sample_title'],                                             
                                  );            
                      $dsrr[] = $dsr;
                 }                        
             }                         
             $data['sample_num'] = $sample_num;       
             $data['sample_data']   = json_encode($dsrr);
             
             $q_num = 0;
             $srr = array();   
             $dsrr = array();                  
             if ($data_post['data_num'] > 0) {
                 $sort = 1;
                 // 題目數
                 for ($i = 1; $i <= $data_post['data_num']; $i++) {
                     $q_id = isset($data_post['q_id_' . $i]) ? $data_post['q_id_' . $i] : '';
                     if ($q_id > ''){  // 有選問卷才存檔
                         $q_num++;                                
                         $srr[$data_post['data_sort_'.$i]]['q_id'] = $q_id;
                         $srr[$data_post['data_sort_'.$i]]['day']  = $data_post['data_day_' . $i];
                     }
                 }
             
                 ksort($srr); 
                 $arr = array();
                 $sort = 0;
                 foreach ($srr as $key => $item)
                 {
                      $sort++;
                      $dsr = array(
                                               'q_id'      => $item['q_id'],
                                               'day'       => $item['day'],                                               
                                  );            
                      $dsrr[] = $dsr;
                 }                        
             }                         
             $data['q_num'] = $q_num;       
             $data['set_data']   = json_encode($dsrr);
             
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['s_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_sample',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $id = $this->front_base_model->insert_table('ap_sample',$data);
                 
                 $checkcode = generatorPassword(2).$id.generatorPassword(4);
                 
                 $this->front_base_model->update_table('ap_sample',array('checkcode' => $checkcode),array('s_id'=>$id));  
                 $okmsg =  "新增成功！";
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( 'wadmin/sample/list/'.$kind);
             
        }    
    
    }
    
     // 索取列表
    public function charge_list($kind,$S_id = '')
    {
    	  
        $data['Search'] = '';  
        $data['Follow'] = ''; 
        $data['Status'] = ''; 
        
        $data['S_id'] = '';        	
        if ($S_id > ''){
            $data['S_id'] = $S_id;        	
        }        
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Follow'])){
                 $data['Follow'] = $data_post['Follow'];
             }
             if (isset($data_post['Status'])){
                 $data['Status'] = $data_post['Status'];
             }
             if (isset($data_post['S_id']) && $data_post['S_id'] > ''){
                 $data['S_id'] = $data_post['S_id'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }   
             if (isset($data_post['s_num']) && $data_post['s_num'] > 0){
             	   for ($i = 1;$i<=$data_post['s_num'];$i++)
             	   { 
             	   	    if (isset($data_post['s_id_'.$i])){
             	   	        $upchk = false;
             	   	        $s_id = $data_post['s_id_'.$i];             	   	        
             	   	        if (isset($data_post['del_'.$s_id]) && $data_post['del_'.$s_id] == 'Y'){ // 刪除
             	   	            $udata['status'] = 'D';
             	   	            $upchk = true;
             	   	        }else{
             	   	        	  if (isset($data_post['outdt_'.$s_id]) && $data_post['outdt_'.$s_id] > ''){ // 寄送日期
             	   	        	  	  $udata['status'] = 'Y';
             	   	        	  	  $udata['outdt'] = $data_post['outdt_'.$s_id];
             	   	        	  	  $upchk = true;
             	   	        	  }
             	   	        }
             	   	        if ($upchk){
             	   	            $udata['updt'] = date('Y-m-d H:i:s');
             	   	            $udata['account'] = $_SESSION['admin_session']['admin_name'];
             	   	            
             	   	            $this->sample_model->charge_update_data($s_id,$udata);
                          }
             	   	    }
             	   }
             }                  
        }
              
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        
        if ($data['S_id'] > ''){
            $where['a.s_id'] = $data['S_id'];
        }
        if ($data['Follow'] > ''){
        	  $where['u.follow'] = $data['Follow'];
        }
        if ($data['Status'] > ''){
        	  $where['a.status'] = $data['Status'];
        }
                
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.uname'        => $data['Search'],
                     'a.tel'        => $data['Search'],
                     'a.address'        => $data['Search'],
                     'a.user_id'       => $data['Search'],
                     'a.display_name'  => $data['Search']
                    );
        }            	  
    	  
    	  $data['list'] = $this->sample_model->page_list( 'ap_sample_charge',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.id' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'sample';
    	  
    	  $data['kind'] = 'F002'; 
    	  
    	  $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $data['class']  = $this->front_base_model->get_data('ap_sample',array('s_id >' => '0'),array('s_id'=>'desc'));  
    	      	  
        $this->layout->view('admin/sample_charge_list', $data);      
    }
    
    
    
    public function send_list($kind)
    {
       
        $data['Search'] = '';
        $data['S_id'] = '';        	
        $data['Follow'] = ''; 
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['S_id'])){
                 $data['S_id'] = $data_post['S_id'];        	
             }
             if (isset($data_post['Follow'])){
                 $data['Follow'] = $data_post['Follow'];
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $like = array();        
        $where['a.status'] = 'Y';  
                
        if ($data['Search'] > ''){
            $like = array(
                     'a.uname'  => $data['Search'],                  
                     'a.tel'  => $data['Search'],                  
                     'a.address'  => $data['Search'],                  
                     'a.display_name'  => $data['Search'],   
                    );
        }
                
        if ($data['S_id'] > ''){
            $where['a.s_id'] = $data['S_id'];
        }
        if ($data['Follow'] > ''){
        	  $where['u.follow'] = $data['Follow'];
        }
        
        $data['list'] = $this->sample_model->charge_page_list( 'ap_sample_charge',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.send_date' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'question';
                
        foreach ($data['list']['rows'] as $key => $item){        	
        	     
        	       $data['list']['rows'][$key]['reply'] = $this->question_model->find_reply_list('S',$item['user_id'],$item['s_id']);        	              	       
        }       	              	       
        
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數      
        
        $data['class']  = $this->front_base_model->get_data('ap_sample',array('s_id >' => '0'),array('s_id'=>'desc'));    
                                      
        $this->layout->view('admin/sample_charge_reply_list', $data);
        
    }
    
    
    public function send_again()
    {
           
        $result = array('msg' => '已成功寄送！');
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             $rid = 0;
             if (isset($data_post['id'])){
                 $rid = $data_post['id'];
                 $reply_data = $this->question_model->reply_find_one('rid',$rid,'N');   
                 if ($reply_data){
                 	   if ($reply_data['status'] == 'Y'){
                 	   	   $result['msg'] = '此筆問卷已填答完成無法重新寄送！';
                 	   }else{
                 	   	   $result['msg'] = $this->block_service->sample_send_line($rid,'sample_again',$reply_data['p_num']);       			     
                 	   	   
                 	   	   if ($result['msg'] == ''){
                 	   	       $udata = array(
                                            'crdt' => date('Y-m-d H:i:s'),
                                            'opdt' => null,
                                            'ckdt' => null
                                           );                                                            
                             $this->question_model->reply_update_data($rid,$udata);
                             $result['msg'] = '已成功寄送！';
                         }
                 	   }
                 }else{
                 	   $result['msg'] = '無此筆問卷請再確認！';
                 }
             }
        }
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;   
    }
    
    public function question_reply_show($rid)
    {
    	  $result = array('html' => '');    
        
        $reply_data = $this->question_model->reply_find_one('rid',$rid,'N');
        
        $reply        = json_decode($reply_data['reply'], true);		            
        
        $q_desc = '';            
        if ($reply_data['q_desc'] > '' ){
        	  $q_desc = $reply_data['q_desc'];
        	  $q_desc .= '<br>';
        }
                                        
        $result['html'] = $q_desc.'<p class="fs14 text-right mb-3">填答時間：'.$reply_data['okdt'].'</p>';
        foreach ( $reply as $key => $item){
						         $num = $key + 1;
						         $result['html'] .= '   <div class="card mb-3">
                          <div class="card-body">
                            <div class="row">
								             <div class="col-md-auto border-right">Q'.sprintf('%02d',$num).'</div>
								             <div class="col-md-auto">'.$item['title'].'<br>
									           <span class="text-danger">'.$item['ans'].'</span>
								            </div>
							             </div>
                          </div>
                        </div>';
        }
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;  
    }
    
    public function excel_export($id)
    {
               /* $where['a.s_id']    = $id; 
                $where['a.status <>']  = 'D'; 
                
                $listdata = $this->sample_model->charge_page_list( 'ap_sample_charge',$where, // where
                     array(),   // like
                     1,
                     5000, 
                     NULL  // group by
                     , array( 'a.id' => 'asc' )    // order by
                );       
                */
                mb_internal_encoding('utf-8');

                header("Pragma: public"); // required
                header("Expires: 0");
                header('Content-Encoding: UTF-8');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false); // required for certain browsers
                header("Content-Type: application/csv; charset=UTF-8");
                header('Content-Disposition:filename="試用組_'.$id.'-' . date_format(new Datetime('now'), 'Y-m-d') . '.csv"');
                header("Content-Transfer-Encoding: binary");
                echo "\xEF\xBB\xBF";
                $file = fopen('php://output', 'w');
                $header = array('索取序號',
                                'Line 資訊',
                                'Line 暱稱',
                                '來源',
                                '推薦人編號',
                                '推薦人姓名',
                                '姓名',
                                '姓別',
                                '生日',
                                '電話',
                                '郵遞區號',
                                '地址',
                                '選擇試用組',
                                '申請時間',
                                '出貨時間',
                );
                fputcsv($file, $header);
                $data = $this->sample_model->excel_data($id);
                foreach ($data as $val) {
                    fputcsv($file, $val);
                }
                fclose($file);
                exit;
                
            
                if ($listdata)
                {                       
                	  $filename  = "試用組_".$listdata['rows'][0]['s_id']."-".date('Y-m-d');
                	       
                	  $excel_row = 0;
        
        	          $this->load->library("PHPExcel");
        	          
        	          $objPHPExcel = new PHPExcel();
                    
                    $objPHPExcel->setActiveSheetIndex(0);
		                //Set Title
                    $objPHPExcel->getActiveSheet()->setTitle('索取名單');
                    
                    $ex = 0;
                                        
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '索取序號');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('8');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, 'Line 資訊');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('40');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, 'Line 暱稱');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('30');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '來源');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('6');         
                                        
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '推薦人編號');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('12');     
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '推薦人姓名');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('15');     
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '姓名');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('15');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '姓別');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('8');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '生日');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('15');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '電話');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('15');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '郵遞區號');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('13');         
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '地址');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('35');     
                    
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '選擇試用組');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('35');        
                    
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '申請時間');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('20');    
                                            
                    $ex++;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ex, 1, '出貨時間');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($this->block_service->ecellx($ex))->setWidth('20');    
                                  
                    // 標題底色
                    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->block_service->ecell($ex,1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB ( '00CCD1D1' );                   
                    
                    if ($listdata['rows']){
                        $nrow = 1;            
                        foreach($listdata['rows'] as $key1 => $item){                    
                            $nrow++;
                            	                            
                            $ey = 0;
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['id']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['user_id']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['display_name']);
                            
                            $ey++;
                            if ($item['s_type'] == 'S'){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, '業務');	
                            }
                            if ($item['s_type'] == 'I'){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, 'IG');	
                            }
                            if ($item['s_type'] == 'F'){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, 'FB');	
                            }
                            if ($item['s_type'] == 'L'){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, 'LINE');	
                            }
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['referrer_c_no']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['referrer_name']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['uname']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['sex']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['bday']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['tel']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['postal']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['address']);
                            $objPHPExcel->getActiveSheet()->getStyle($this->block_service->ecell($ey,$nrow))->getAlignment()->setWrapText(true); //可跳行                  
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['sel_sample']);
                            $objPHPExcel->getActiveSheet()->getStyle($this->block_service->ecell($ey,$nrow))->getAlignment()->setWrapText(true); //可跳行                  
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['crdt']);
                            
                            $ey++;
                            
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($ey, $nrow, $item['outdt']);
                                                     
                        }                            
                    }
                                      
                    // 上下置中
                    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->block_service->ecell($ex,$nrow))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                                
                    
                    //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    
                    //Header
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("Cache-Control: no-store, no-cache, must-revalidate");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    
                    //Nama File
                    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                    
                    //Download
                    $objWriter->save("php://output");
                                         
                    $objPHPExcel->disconnectWorksheets();
                    unset($objWriter, $objPHPExcel);
                    
            
                }else{
                   echo '無資料可供下載!'; 
                   exit;
                }      
                exit;         
    }    
    
    public function analyze($q_id)
    {
            
         $where['q_id']    = $q_id; 
         $where['status']  = 'Y'; 
         
         $listdata  = $this->front_admin_model->list_data('ap_question_reply',$where);  
            
         if ($listdata)
         {      
             $data['listdata'] = $listdata;
             $data['web_page'] = 'analyze';
             
             $this->layout->view('admin/question_analyze', $data);                              
         }else{             
             alert('無此問卷資料(或尚無人填寫)！',base_url('wadmin/question/list/Q003'));
             exit;
         }         
    }
    
    public function check_line()
    {
    	   $result = array('msg' => '操作有誤！','line_disable_num'=> 0);    
    	   
    	   $data_post = $this->input->post();
         if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
        	     $where  = array ('s_id' => $data_post['s_id']);                 
               $ap_sample = $this->front_admin_model->get_data('ap_sample',$where);
               if (date('Y-m-d',strtotime($ap_sample['line_test_dt'])) == date('Y-m-d')){
        	         $result['msg'] = '此試用組今天 ('.$ap_sample['line_test_dt'].') 已偵測過！';
        	     }else{
        	     	   $sql = "select a.user_id,a.id 
        	     	             from ap_sample_charge a 
                             join line_user u on a.user_id = u.user_id and TO_DAYS(u.last_insteractive) <> TO_DAYS(now()) 
                            where a.s_id = ".$data_post['s_id']." 
                            order by a.user_id  ";    
                   $send_data = $this->front_base_model->small_query($sql);
                   $i = 0;
    	             if ($send_data){
    	                 $line_disable_num = 0;
    	                 foreach ($send_data as $key => $item)
    	                 {    	               
                                $line_user_data = $this->line_service->get_line_user($item['user_id'] ,'',true);                      	  
    	  	                      if ($line_user_data['follow'] == 'disable'){
    	  	              	          $line_disable_num++;    	  	              	          
    	  	              	      }
    	  	             }
    	  	  
    	  	             $line_disable_num   = $this->sample_model->charge_disable_count($data_post['s_id']);        	          	  
        	             $line_disable_num_Y = $this->sample_model->charge_disable_count($data_post['s_id'],'Y');
        	  
    	  	             $result['msg'] = '索取封鎖人數：'.$line_disable_num.' <br> 通過封鎖人數：'.$line_disable_num_Y.'';    	  	             
    	  	             
    	  	         }
    	  	         $where['s_id'] = $data_post['s_id'];                 
                   $this->front_base_model->update_table('ap_sample',array('line_test_dt' => date('Y-m-d H:i:s')),$where);     
        	     }
         }
    	   $this->output->set_content_type('application/json');            
         echo json_encode($result);
         exit; 
        
    }
}