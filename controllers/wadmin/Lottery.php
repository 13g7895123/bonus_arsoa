<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lottery extends MY_Controller
{
    private $lottory_type  = array('1' => '輪盤', '2' => '刮刮樂', '3' => '拉霸');
    
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
        $this->load->model( 'lottery_model' );           
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
        $where['a.lot_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.lot_title'      => $data['Search'],
                     'a.lot_desc'      => $data['Search'],
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'ap_lottery',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.lot_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'lottery';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	 
        	  $data['list']['rows'][$key]['y_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'Y');
        	  $data['list']['rows'][$key]['c_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'C');
        	  $data['list']['rows'][$key]['n_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'N');
        	  $data['list']['rows'][$key]['a_num'] = $this->lottery_model->charge_find_count($item['lot_id'],'A');
        	  $data['list']['rows'][$key]['all_num'] = $this->lottery_model->charge_find_dis_count($item['lot_id']);
        	          	  
        	  $data['list']['rows'][$key]['lot_data'] = json_decode($item['lot_data'], true);
        	  if ($data['list']['rows'][$key]['lot_data']){
        	  	  foreach ($data['list']['rows'][$key]['lot_data'] as $akey => $aitem){
        	  	  	       $data['list']['rows'][$key]['lot_data'][$akey]['use_num'] = $this->lottery_model->charge_find_use_count($item['lot_id'],$akey);
        	  	  }
        	  }          	    	
        }
         	
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數   
        $data['lottory_type'] = $this->lottory_type;                  
                                      
        $this->layout->view('admin/lottery_list', $data);
        
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
            
            $lot_type = 1;
            if ($data_post['AddSubmit'] == '新增抽獎(刮刮樂)'){
                $lot_type = 2;	
            }
            if ($data_post['AddSubmit'] == '新增抽獎(拉霸)'){
                $lot_type = 3;	
            }
            $data['data'] = array(
                'edit'     => 0,
                'lot_type' => $lot_type,
                'lot_title'  => '',
                'lot_desc'   => '',                                
                'lot_start'  => '',
                'lot_end'    => '',
                'lot_img' => '',
                'status'   => 'N',
                'lot_bg_img' => '',
                'lot_config' => array('member'=>'N','charge'=>'N','question'=>'N'),                
            );
        }
        else {
            $where  = array ('lot_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_lottery',$where);
            
            if (!$data['data']){
                redirect( 'lottery/list' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['lot_data']   = json_decode($data['data']['lot_data'], true);                                                 
                $data['data']['lot_config']   = json_decode($data['data']['lot_config'], true);                                                 
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0; 
                $data['data']['lot_img'] = ''; 
                $data['data']['lot_bg_img'] = '';                 
                $data['data']['lot_id'] = 0;
                $data['data']['status'] = 'N';
            }
        }
                
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['lottory_type'] = $this->lottory_type;             
        
        $data['kind'] = $kind;
        
        $data['question']  = $this->front_base_model->get_data('ap_question',array('classid' => 'QA7','status' => 'Y'),array('q_id'=>'asc'));  
        
        $this->layout->view('admin/lottery_modify', $data);      
          
    }
    
    // 存檔
    public function save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
        {
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $data = array (
                        'lot_title'=> $data_post['lot_title'], 
                        'lot_desc'=> $data_post['lot_desc'],                             
                        'lot_start'=> $data_post['lot_start'],   
                        'lot_end'=> $data_post['lot_end'],   
                        'status'    => $data_post['status'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             $lot_num = 0;
             $srr = array();        
             $dsrr = array();        
             if ($data_post['lottery_num'] > 0) {
                 $sort = 1;
                 // 題目數
                 for ($i = 1; $i <= $data_post['lottery_num']; $i++) {
                     $title = isset($data_post['data_title_' . $i]) ? $data_post['data_title_' . $i] : '';
                     $type = isset($data_post['data_type_' . $i]) ? $data_post['data_type_' . $i] : '';
                     $num = isset($data_post['data_num_' . $i]) ? $data_post['data_num_' . $i] : '';
                     
                     $image = '';
                     if ($data_post['lot_type'] == '2'){
                     	   if (isset($file_data['data_img_' . $i]['name'])){
                     	   	   $image = $file_data['data_img_' . $i]['name'];
                     	   }else{                     	   
                     	       $image = $data_post['data_img_old_' . $i];
                     	   }
                     }
                     
                     $set_item = 'N';
                     if ($data_post['data_set_item'] == $i){
                         $set_item = 'Y';	
                     }
                     if ($title > '' && $type > '' && $num > ''){  // 有才存檔
                         $lot_num++;
                         $srr[$data_post['data_sort_'.$i]]['title'] = $title;
                         $srr[$data_post['data_sort_'.$i]]['type'] = $type;
                         $srr[$data_post['data_sort_'.$i]]['num'] = $num;
                         $srr[$data_post['data_sort_'.$i]]['image'] = $image;
                         $srr[$data_post['data_sort_'.$i]]['set_item'] = $set_item;
                     }
                 }
            
                 ksort($srr); 
                 $arr = array();
                 $sort = 0;
                 foreach ($srr as $key => $item)
                 {
                      $sort++;
                      $dsr = array(
                                     'title'			=> $item['title'],
                                     'type'				=> $item['type'],
                                     'num'				=> $item['num'],
                                     'image'			=> $item['image'],
                                     'set_item'		=> $item['set_item'],
                                  );            
                      $dsrr[] = $dsr;
                 }                        
             }                         
           
             $data['lot_num'] = $lot_num;
             $data['lot_data']   = json_encode($dsrr);
             
             $lot_config = array(
                                  'background_color' => isset($data_post['background_color']) ? $data_post['background_color'] : '',
                                  'addr' => isset($data_post['lot_config_addr']) ? $data_post['lot_config_addr'] : 'N',
                                  'member' => isset($data_post['lot_config_member']) ? $data_post['lot_config_member'] : 'N',
                                  'charge' => isset($data_post['lot_config_charge']) ? $data_post['lot_config_charge'] : 'N',
                                  'question' => isset($data_post['lot_config_question']) ? $data_post['lot_config_question'] : 'N',
                                  'q_id' => isset($data_post['lot_config_q_id']) ? $data_post['lot_config_q_id'] : 'N',
                                );
             
             $data['lot_config']   = json_encode($lot_config);
             
             $img = '';             
             $bg_img = '';             
             if ($file_data){
                 // 檔案判斷
                 if (isset($file_data['lot_img']['name'])){
                     $img = $file_data['lot_img']['name'];    
                 }
                 if (isset($file_data['lot_bg_img']['name'])){
                     $bg_img = $file_data['lot_bg_img']['name'];    
                 }
             }
             
             if ($img > '' || (isset($data_post['lot_img_del']) && $data_post['lot_img_del'] == 'Y')){
                 $data['lot_img'] = $img;
             }else{
             	   if (isset($data_post['lot_img_old']) && $data_post['lot_img_old'] > ''){
             	       $data['lot_img'] = $data_post['lot_img_old']; 
             	   }else{
             	   	   $data['lot_img'] = '';
             	   }
             }
             
             if ($bg_img > '' || (isset($data_post['lot_bg_img_del']) && $data_post['lot_bg_img_del'] == 'Y')){
                 $data['lot_bg_img'] = $bg_img;
             }else{
             	   if (isset($data_post['lot_bg_img_old']) && $data_post['lot_bg_img_old'] > ''){
             	       $data['lot_bg_img'] = $data_post['lot_bg_img_old']; 
             	   }else{
             	   	   $data['lot_bg_img'] = '';
             	   }
             }
             
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['lot_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_lottery',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $data['lot_type'] = $data_post['lot_type'];
                 $id = $this->front_base_model->insert_table('ap_lottery',$data);
                 
                 $checkcode = generatorPassword(4).$id.generatorPassword(4);
                 
                 $this->front_base_model->update_table('ap_lottery',array('checkcode' => $checkcode),array('lot_id'=>$id));  
                 $okmsg =  "新增成功！";
             }
                          
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( 'wadmin/lottery/list/'.$kind);
             
        }    
    
    }
    
     // 抽獎列表
    public function charge_list($kind,$lot_id = '')
    {
    	  
                
        $data['Search'] = '';  
        $data['Follow'] = ''; 
        $data['Status'] = ''; 
        
        $data['lot_id'] = '';        	
        if ($lot_id > ''){
            $data['lot_id'] = $lot_id;        	
        }        
         
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['break_bid']) && $data_post['break_bid'] > 0){   // 有值代表要刪掉
        		     $this->front_base_model->delete_table('ap_lottery_charge',array('id'=>$data_post['break_bid']));   
        		     $data['ok_message'] = '已刪除！';           
        		 }
             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Follow'])){
                 $data['Follow'] = $data_post['Follow'];
             }
             if (isset($data_post['Status'])){
                 $data['Status'] = $data_post['Status'];
             }
             if (isset($data_post['lot_id']) && $data_post['lot_id'] > ''){
                 $data['lot_id'] = $data_post['lot_id'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }   
             if (isset($data_post['s_num']) && $data_post['s_num'] > 0){
             	   for ($i = 1;$i<=$data_post['s_num'];$i++)
             	   { 
             	   	    if (isset($data_post['lot_id_'.$i])){
             	   	        $upchk = false;
             	   	        $lot_id = $data_post['lot_id_'.$i];             	   	        
             	   	        if (isset($data_post['del_'.$lot_id]) && $data_post['del_'.$lot_id] == 'Y'){ // 刪除
             	   	            $udata['status'] = 'D';
             	   	            $upchk = true;
             	   	        }else{
             	   	        	  if (isset($data_post['outdt_'.$lot_id]) && $data_post['outdt_'.$lot_id] > ''){ // 寄送日期
             	   	        	  	  $udata['status'] = 'Y';
             	   	        	  	  $udata['outdt'] = $data_post['outdt_'.$lot_id];
             	   	        	  	  $upchk = true;
             	   	        	  }
             	   	        }
             	   	        if ($upchk){
             	   	            $udata['updt'] = date('Y-m-d H:i:s');
             	   	            $udata['account'] = $_SESSION['admin_session']['admin_name'];
             	   	            
             	   	            $this->lottery_model->charge_update_data($lot_id,$udata);
                          }
             	   	    }
             	   }
             }                  
        }
              
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        
        if ($data['lot_id'] > ''){
            $where['a.lot_id'] = $data['lot_id'];
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
                     'a.c_no'        => $data['Search'],
                     'a.name'        => $data['Search'],
                     'a.mobile'        => $data['Search'],
                     'a.address'        => $data['Search'],
                     'a.user_id'       => $data['Search'],
                     'a.email'  => $data['Search'],
                     'a.display_name'  => $data['Search'],
                    );
        }            	  
    	  
    	  $data['list'] = $this->lottery_model->charge_page_list( 'ap_lottery_charge',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.id' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'sample';
    	  
    	  $data['kind'] = 'L002'; 
    	  
    	  $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $data['class']  = $this->front_base_model->get_data('ap_lottery',array('lot_id >' => '0'),array('lot_id'=>'desc'));  
    	      	  
        $this->layout->view('admin/lottery_charge_list', $data);      
    }
    
    
    public function excel_export($id)
    {
            
                mb_internal_encoding('utf-8');

                header("Pragma: public"); // required
                header("Expires: 0");
                header('Content-Encoding: UTF-8');
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: private", false); // required for certain browsers
                header("Content-Type: application/csv; charset=UTF-8");
                header('Content-Disposition:filename="抽獎_中獎名單_'.$id.'-' . date_format(new Datetime('now'), 'Y-m-d') . '.csv"');
                header("Content-Transfer-Encoding: binary");
                echo "\xEF\xBB\xBF";
                $file = fopen('php://output', 'w');
                $header = array('序號',
                                'Line 資訊',
                                'Line 暱稱',
                                '中獎項目',
                                '獎品名稱',
                                '會員編號',
                                '姓名',
                                '手機',                          
                                '郵遞區號',
                                '地址',
                                '抽獎時間',
                );
                fputcsv($file, $header);
                $data = $this->lottery_model->excel_data($id);
                foreach ($data as $val) {
                    fputcsv($file, $val);
                }
                fclose($file);
                exit;
    }    
    
}