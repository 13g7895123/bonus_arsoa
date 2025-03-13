<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_prd_set extends MY_Controller
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
        $this->load->model( 'question_prd_set_model' );           
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
        $where['a.p_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.p_name'      => $data['Search']
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_question_prd_set',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.p_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'sample';
        
        foreach ($data['list']['rows'] as $key => $item){        	        	 
        	  $data['list']['rows'][$key]['order_sum'] = $this->question_prd_set_model->order_find_count($item['p_id']);      
        	  $data['list']['rows'][$key]['order_sum_send'] = $this->question_prd_set_model->order_find_count($item['p_id'],'Y');      
        	  $data['list']['rows'][$key]['order_sum_reply'] = $this->question_prd_set_model->question_reply_send_find_count($item['p_id']);
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/question_prd_set_list', $data);
        
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
                'edit'    => 0,
                'title' => '',
                'img'  => '',
                'p_name' => '',
                'p_no' => '',
                'line_title' => '',
                'line_msg' => '',
                'classid' => '',
                'no_title' => 'N',
                'web_sort' => '0',
                'ans_data'=> '',
                'line_push' => 'N',
                'ans_config' => array('type' => 'R','set' => 'X','set_num' => ''),
                'status' => 'Y'
            );
            $data['data']['line_push'] = 'N';
            if (isset($data_post['AddSubmit_line'])){
                $data['data']['line_push'] = 'Y';
            }
            if (isset($data_post['AddSubmit'])){
                $data['data']['line_push'] = 'Q';
            }
        }
        else {
            $where  = array ('p_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_question_prd_set',$where);
            
            if (!$data['data']){
                redirect( 'wadmin/question_prd_set/list/'.$kind ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['set_data']   = json_decode($data['data']['set_data'], true);                    
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['p_id'] = 0;
            }    
        }
                        
        $data['web_page'] = 'question_prd_set';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $data['question']  = $this->front_base_model->get_data('ap_question',array('classid' => 'QA2','status' => 'Y'),array('q_id'=>'asc'));  
        
        $this->layout->view('admin/question_prd_set', $data);      
         
    }
        
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             
             $data = array (
                        'p_no'=> $data_post['p_no'],   
                        'p_name'=> $data_post['p_name'],   
                        'status'    => $data_post['status'],   
                        'web_sort'  => $data_post['web_sort'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
                     
             if ($data_post['line_push'] == 'Y'){
             	   $data['line_title'] = $data_post['line_title'];
             	   $data['line_msg'] = $data_post['line_msg'];
             	   $data['set_hour'] = $data_post['set_hour'];
             }
             
             $ans_num = 0;
             $srr = array();          
            
             if ($data_post['data_num'] > 0) {
                 $sort = 1;
                 // 題目數
                 for ($i = 1; $i <= $data_post['data_num']; $i++) {
                     $q_id = isset($data_post['q_id_' . $i]) ? $data_post['q_id_' . $i] : '';
                     if ($q_id > ''){  // 有選問卷才存檔
                         $ans_num++;                                
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
             $data['q_num'] = $ans_num;       
             $data['set_data']   = json_encode($dsrr);
           
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['p_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_question_prd_set',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $checkcode = 'P'.substr(md5(microtime(true)), 0, 8);
                 $data['checkcode'] = $checkcode;     
                 $data['crdt'] = date('Y-m-d H:i:s');     
                 $data['line_push'] = $data_post['line_push'];     
                 $id = $this->front_base_model->insert_table('ap_question_prd_set',$data);                 
                 $okmsg =  "新增成功！";
             }            
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
                        
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
             PF_submit(base_url('wadmin/question_prd_set/list/'.$kind) ,$ahidden);
             
        }    
    
    }
    
    public function send_list($kind,$P_id = '')
    {
       
        $data['Search'] = '';
        $data['Sclass'] = '';
        
        $data['P_id'] = '';        	
        if ($P_id > ''){
            $data['P_id'] = $P_id;        	
        }                
        
        $data['Follow'] = ''; 
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['P_id'])){
                 $data['P_id'] = $data_post['P_id'];
             }
             if (isset($data_post['Follow'])){
                 $data['Follow'] = $data_post['Follow'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $like = array();
        $where = array();
        
        if ($data['P_id'] > ''){
            $where['a.p_id'] = $data['P_id'];
        }
        
        if ($data['Follow'] > ''){
        	  $where['u.follow'] = $data['Follow'];
        }      
                
        if ($data['Search'] > ''){
            $like = array(
                     'm.c_no'     => $data['Search'],
                     'u.display_name'  => $data['Search'],
                     'm.c_name'  => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->question_prd_set_model->reply_page_list( 'ap_member_order_his',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.send_date' => 'desc', 'a.hid' => 'desc',  )    // order by
            );       
                
        $data['web_page'] = 'question';
                
        foreach ($data['list']['rows'] as $key => $item){        	
        	       $data['list']['rows'][$key]['reply'] = $this->question_model->find_reply_list('P',$item['c_no'],$item['p_id']);        	              	       
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數  
        
        $data['class']  = $this->front_base_model->get_data('ap_question_prd_set',array('p_id >' => '0'),array('p_id'=>'desc'));        
                                   
        $this->layout->view('admin/question_reply_list', $data);
        
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