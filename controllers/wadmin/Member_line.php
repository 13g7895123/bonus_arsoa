<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_line extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service'
        ));
        
        $this->load->library( 'ui' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_admin_model' );    
        $this->load->model( 'Line_push_log' );    
        $this->load->model( 'Member_line_model' );
           
        
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試   
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function list($kind)
    {
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
                
        $data['Search'] = '';
        $Swp1 = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }          
             if (isset($data_post['Swp1'])){
                 $Swp1 =  $data_post['Swp1'];
             }     
        }
        
        if (isset($data_post['break_bid']) && $data_post['break_bid'] > 0){   // 有值代表要解除綁定
            $udate = array(
                            'user_id'   => '',
                            'last_date' => date('Y-m-d H:i:s')
                          );
            $this->Member_line_model->update_data($data_post['break_bid'],$udate);
            $data['ok_message'] = '已解除綁定！';           
        }
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
       // $where['a.bind_type <>'] = 'L';
        
        if (!($Swp1 == 'A' || $Swp1 == '')){
        	  switch ($Swp1) {						    
						    case 'Y':
						        $where['a.user_id >'] = '';
						        break;
						    case 'M':
						        $where['a.user_id >'] = '';
						        $where['a.bind_type'] = 'M';
						        break;
						    case 'J':
						        $where['a.user_id >'] = '';
						        $where['a.bind_type'] = 'J';
						        break;    
						    case 'B':
						        $where['a.user_id >'] = '';
						        $where['a.bind_type'] = 'B';
						        break;        
						    case 'N':
						        $where['a.user_id'] = '';
						        $where['a.bind_type'] = 'J';
						        break;
						    case 'D':
						        $where['u.follow'] = 'disable';
						        break;    
						    default:						        
						}            
        }
        
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_name'        => $data['Search'],
                     'a.user_id'       => $data['Search'],
                     'a.join_no'  		 => $data['Search'],
                     'a.c_no'          => $data['Search'],
                     'u.display_name'          => $data['Search'],
                     'a.admin_remark'  => $data['Search']
                    );
        }        
        
        $data['list'] = $this->Member_line_model->page_list( 'member_line',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.bid' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'member';
        
        $data['kind'] = $kind;
        $data['Swp1'] = $Swp1;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        

        $this->layout->view('admin/member_line_list', $data);
        
    }
    
    public function push_list($kind)
    {
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
                
        $data['Search'] = '';
        $Swp1 = '';
        
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }          
             if (isset($data_post['Swp1'])){
                 $Swp1 =  $data_post['Swp1'];
             }     
        }
                
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where = array();
        
        if (substr($Swp1,1,1) == 'D'){  //封鎖的
        	  $where['u.follow'] = 'disable';						
        }
        
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'l.c_no'          => $data['Search'],
                     'm.c_name'        => $data['Search'],
                     'm.cell1'         => $data['Search'],
                     'u.user_id'       => $data['Search'],
                     'u.display_name'	 => $data['Search']
                    );
        }        
        
        $data['list'] = $this->Line_push_log->page_list( $Swp1,$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.cdate' => 'desc' )    // order by
        );       
        
        $data['web_page'] = 'member';
        
        $data['kind'] = $kind;
        $data['Swp1'] = $Swp1;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        

        $this->layout->view('admin/member_line_push_list', $data);
        
    }
    
    public function push($kind,$user_id)
    {
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
                
        $data_post = $this->input->post();
               
        $data['user_id'] = $user_id;
        foreach ($data_post as $key => $item){
                 $data[$key] = $item;       
        }
        
        if (!isset($data['Page'])){
        	  $data['Page'] = 1;
        	  $data['Swp1'] = 'L';
        	  $data['Search'] = '';
        }
        
        $data['user_id'] = $user_id;
                        
        $data['kind'] = $kind;
                
        $data['web_page'] = 'modify';
        
        $user_data = $this->Line_push_log->page_list( 'A',array('u.user_id' => $user_id), // where
            array(),   // like
            1,
            1
            , NULL  // group by
            , array( 'a.cdate' => 'desc' )    // order by
        );         
        if ($user_data['total'] > 0){
            $data['rs'] = $user_data['rows'][0];
        }else{
            $this->session->set_flashdata( 'errmsg', '無此 Line 會員資料！' );             
            redirect( 'wadmin/member_line/push_list/'.$kind);
            exit;
        }
                   
        $this->layout->view('admin/member_line_push', $data);       
          
    }
    
    public function push_log($user_id)
    {
         
         $readwhere['a.user_id'] = $user_id;        
         
         $data['log'] = $this->Line_push_log->page_list('L',array('u.user_id' => $user_id ),array(),   // like
             1,
             100000000
             , NULL  // group by
             , array( 'a.cdate' => 'desc' )    // order by
         );    
          
         if ($data['log']['total'] == 0){
         	   $result['html'] = '<font color=red>尚無任何推送訊息！</div>';
         }else{
             $result['html'] = $this->load->view( 'admin/member_line_push_list_log', $data, TRUE );
         }
          
         $this->output->set_content_type('application/json');            
         echo json_encode($result);
         exit;    
         
    }
    
    public function push_send($user_id)
    {
         $result = array('status' => 0,'msg' => '操作有誤！');
                  
         $this->load->service(array(
            'line_service',
            'api_line_service'
         ));
         
         $data_post = $this->input->post();
                  
         $line_user_data = $this->line_service->get_line_user($user_id ,'',true);             
         
         if ($line_user_data){
             if ($line_user_data['follow'] == 'enable'){
             	   $send_text = trim($data_post['send_text']);
             	   $c_no = 0;
             	   if (substr_count($send_text,'[name]') > 0){             	   	             	       
             	       $line_id_data = $this->Member_line_model->find_one('user_id',$user_id);
             	       if ($line_id_data){
             	       	   $c_no = (int)$line_id_data['c_no'];
             	       	   $send_text = str_replace("[name]",trim($line_id_data['c_name']),$send_text);
             	       }else{
             	       	   $send_text = str_replace("[name]",trim($line_user_data['display_name']),$send_text);
             	       }
             	   }
             	   $messages[]  = array(
                       'type'     => 'text',
                       'text'     => $send_text
                 );
                                      
                 $send_result = $this->api_line_service->push($user_id,$messages);
                  
                 // 推送記錄
                 $this->Line_push_log->insert_log($user_id,'member_push',$c_no,$messages,$send_result['http_code'],$send_result['result']);
                 
                 if ($send_result['http_code'] == 429) {  // 訊息數不足
                     $result['msg'] = 'Line 訊息數不足';                       
                     $result['status'] = 1;
                 }elseif($send_result['http_code'] == 200){  // 寄送成功
                     $result['msg'] = '寄送成功 ';
                     $result['status'] = 1;
                 }       
             	   
             }else{
             	   $result['msg'] = '此用戶封鎖，故無法傳送訊息！';
             }
         }else{
         	  $result['msg'] = '無此用戶！';
         }
         $this->output->set_content_type('application/json');            
         echo json_encode($result);
         exit;      
    }
    
    
    public function group_push_list($kind)
    {
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->load->model( 'line_ta_model' );
        
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
        $where['a.ta_id > '] = 0;
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.ta_title'      => $data['Search'],
                     'a.ta_desc'      => $data['Search']
                    );
        }        
        
        $data['list'] = $this->block_service->page_list( 'line_ta',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.ta_id' => 'desc' )    // order by
            );       
                
        $data['web_page'] = 'group_push_list';
        
        foreach ($data['list']['rows'] as $key => $item){        	
        	  $data['list']['rows'][$key]['reply_count'][0] = $this->line_ta_model->find_count($item['ta_id'],0);
        	  $data['list']['rows'][$key]['reply_count'][1] = $this->line_ta_model->find_count($item['ta_id'],1);
        	  $data['list']['rows'][$key]['reply_count'][2] = $this->line_ta_model->find_count($item['ta_id'],2);
        	  $data['list']['rows'][$key]['reply_count'][3] = $this->line_ta_model->find_count($item['ta_id'],3);
        }
        
        $data['kind'] = $kind;
        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
                                      
        $this->layout->view('admin/group_push_list', $data);
        
    }
    
    
    public function group_push_modify($kind,$type = 'N')
    {
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
        $this->load->model( 'line_ta_model' );
        
        $data_post = $this->input->post(NULL, FALSE );
        
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
        
        $data['reply_count'] = 0;
        if($data['edit'] == '') {
            $data['modify_name'] = '新增';
            $data['data']  = array(
                'edit'     => 0,
                'ta_title' => '',
                'ta_desc'  => '',
                'ta_data'  => '',
                'status'   => 'Y'
            );
        }
        else {
            $where  = array ('ta_id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('line_ta',$where);
            
            if (!$data['data']){
                redirect( 'member_line/group_push_list/U902' ); 
            }
            
            if(!empty($data['data'])) {
                $data['modify_name'] = '修改';
                $data['data']['ta_data']   = json_decode($data['data']['ta_data'], true);
            }
            else {
                $data['modify_enable'] = false;
            }
            if ($type == 'C'){ // 複製
                $data['modify_name'] = '新增';
                $data['edit'] = 0;
                $data['data']['status'] = 'Y';
            }else{            	  
        	      $data['reply_count'] = $this->line_ta_model->find_count($data['data']['ta_id'],1);        	
            }      
        }
                        
        $data['web_page'] = 'modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/group_push_modify', $data);      
          
    }
    
    
    public function group_push_save($kind)
    {
        $data_post = $this->input->post(NULL, FALSE );
     
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                            
             $file_data = $this->block_service->PF_Upload("question",true,FC_FileLimit);	
             
             $ta_num = 0;
             $ta_data = array();             
             if ($data_post['data_num'] > 0) {             
                 $sort = 1;                 
                 for ($i = 1; $i <= $data_post['data_num']; $i++) {
                     $data_type = isset($data_post['data_type_' . $i]) ? $data_post['data_type_' . $i] : '';                     
                     if ($data_type > ''){  // 有值才存檔
                         if ($data_type == 'T'){
                             if ($data_post['data_T_'.$i] > ''){
                                 $ta_data[$data_post['data_sort_'.$i]]['type'] = 'T';
                                 $ta_data[$data_post['data_sort_'.$i]]['data'] = $data_post['data_T_'.$i];
                                 $ta_num++;
                             }                             
                         }else{
                             $img = '';
                             $ta_data[$data_post['data_sort_'.$i]]['type'] = 'G';
                             if (isset($file_data['data_G_'.$i]) && $file_data['data_G_'.$i] > ''){
                                 $img = $file_data['data_G_'.$i]['name'];
                             }
                             if ($img > '' || (isset($data_post['data_G_'.$i.'_del']) && $data_post['data_G_'.$i.'_del'] == 'Y')){
                                 $ta_data[$data_post['data_sort_'.$i]]['data'] = $img;
                                 $ta_num++;
                             }else{
                             	   if (isset($data_post['data_G_'.$i.'_old']) && $data_post['data_G_'.$i.'_old'] > ''){
                             	       $ta_data[$data_post['data_sort_'.$i]]['data'] = $data_post['data_G_'.$i.'_old']; 
                             	       $ta_num++;
                                 }
                             }                             
                         }
                     }
                 }             
                 ksort($ta_data);                  
             }                         
             
             $data = array (
                        'ta_title'  => $data_post['ta_title'],                        
                        'ta_data'   => json_encode($ta_data),                        
                        'status'    => 'Y',   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
                                     
             if (isset($data_post['edit']) && $data_post['edit'] > 0){                           
                 $where['ta_id'] = $data_post['edit'];                 
                 $this->front_base_model->update_table('line_ta',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');
                 $data['checkcode'] = 'LP'.substr(md5(microtime(true)), 0, 18);
                 $id = $this->front_base_model->insert_table('line_ta',$data);
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
           
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
       
             PF_submit(base_url('wadmin/member_line/group_push_list/'.$kind) ,$ahidden);
             exit;
             
        }    
    
    }
    
    public function group_push_go($ta_id,$status0,$status2,$status3)
    {
         $this->load->model( 'line_ta_model' );
        
         $this->load->service(array(
            'line_service',
            'api_line_service'
         ));
         
         $ta_data            = $this->front_admin_model->get_data('line_ta',array ('ta_id' => $ta_id));
         $ta_data['ta_data'] = json_decode($ta_data['ta_data'], true);
         
         $array_status = array(
                                '0' => $status0,
                                '2' => $status2,
                                '3' => $status3,                               
                               );
                              
         $send_n = 0;                      
         foreach ($array_status as $status => $chk)
         {
                  if ($chk == 'Y'){
                      $push_list = $this->line_ta_model->find_list($ta_id,$status);

                      if ($push_list){                                          
                          foreach ($push_list as $key => $item)
                          {
                               $send_n++;
                               echo $send_n;
                               echo '.';
                               echo $item['c_no'];
                               echo ' ';
                               echo $item['c_name'];
                               echo "[";
                               if ($item['member_user_id'] > ''){
                                   $line_user_data = $this->line_service->get_line_user($item['member_user_id'],'',true);       
                                   if ($line_user_data['follow'] == 'enable'){
                                       $reply = array();
                                       foreach ($ta_data['ta_data'] as $akey => $aitem)
                                       { 
                                                if ($aitem['type'] == 'T'){
                                                    $reply[] = array(
                                                        'type' => 'text',
                                                        'text' => str_replace("[name]",$item['c_name'],$aitem['data'])
                                                    );   
                                                }elseif($aitem['type'] == 'G'){
                                                    $img = 'https://www.arsoa.tw/public/question/'.$aitem['data'];
                                                    $reply[] = array(
                                                          "type" => "image",
                                                          "originalContentUrl" => $img,
                                                          "previewImageUrl" => $img
                                                    );   
                                                }
                                        }
                                        
                                        // 送訊息
                                        $push_result = $this->api_line_service->push($item['member_user_id'],$reply);
                                        
                                        // 推送記錄
                                        $this->Line_push_log->insert_log($item['member_user_id'],'line_ta',$item['ta_member_id'],$reply,$push_result['http_code'],$push_result['result']);
                                                                                    
                                        $data = array(
                                                     'status'   => 0,
                                                     'push_num' => $item['push_num'] + 1,
                                                     'user_id'  => $item['member_user_id'],
                                                     'updt'     => date('Y-m-d H:i:s')
                                                    );                                                                                  
                                        $status = 0;
                                        // 發送成功
                                        if ($push_result['http_code'] == 200) {
                                            echo "<font color=green>發送成功</font>";
                                                
                                            $data['status'] = 1;
                                            $data['push_cont'] = json_encode($reply);
                                        }else{
                                            if ($push_result['http_code'] == 429) {
                                                echo "<font color=red>發送失敗 (LINE 額度已用完) </font>"; 
                                            }else{
                                                echo "<font color=red>發送失敗</font>";
                                            }
                                        }  
                                        
                                        $where['ta_member_id'] = $item['ta_member_id'];                 
                                        $this->front_base_model->update_table('line_ta_member',$data,$where);                                       
                                   }else{
                                       //  封鎖
                                       $data = array(
                                                    'status'   => 2,
                                                    'push_num' => $item['push_num'] + 1,
                                                    'updt'     => date('Y-m-d H:i:s')
                                                   );                                      
                                       $where['ta_member_id'] = $item['ta_member_id'];                 
                                       $this->front_base_model->update_table('line_ta_member',$data,$where);       
                                       echo "<font color=red>已封鎖</font>";                 
                                   }
                               }else{
                                       // 未綁
                                       $data = array(
                                                    'status'   => 3,
                                                    'push_num' => $item['push_num'] + 1,
                                                    'updt'     => date('Y-m-d H:i:s')
                                                   );                                      
                                       $where['ta_member_id'] = $item['ta_member_id'];                 
                                       $this->front_base_model->update_table('line_ta_member',$data,$where);
                                       echo "<font color=red>未綁定</font>";                 
                               }
                               echo "]<br>";
                          }
                      }
                  }
         }
        echo '寄送完成';
        exit;         
    }
    
    public function group_push_log($kind,$ta_id)
    {
    	  $data_post = $this->input->post(NULL, FALSE );
        
        $data['Search'] = '';
        $data['Sclass'] = '';
        $data['Page'] = 1;
        $Page = 1;        
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }          
             if (isset($data_post['Sclass'])){
                 $data['Sclass'] = $data_post['Sclass'];
             }          
             if (isset($data_post['Page'])){
                 $data['Page']   = $data_post['Page'];
             }          
        }
    	  
    	  $this->load->model( 'line_ta_model' );
    	  
    	  $data['list'] = $this->line_ta_model->find_list_all($ta_id);
    	          
        $data['PageSize'] = 10;
        
        $where = array();
       // $where['a.status'] = 'Y';
        $where['a.ta_id'] = $ta_id;
                
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'a.c_name'        => $data['Search'],
                     'a.c_no'          => $data['Search'],
                     'a.user_id'       => $data['Search']
                    );
        }            	  
    	  
    	  $data['list'] = $this->line_ta_model->page_list( 'line_ta_member',$where, // where
            $like,   // like
            $data['Page'],
            $data['PageSize']
            , NULL  // group by
            , array( 'a.status' => 'asc','a.updt' => 'desc' )    // order by
        );       
        
    	  
    	  $ta_data            = $this->front_admin_model->get_data('line_ta',array ('ta_id' => $ta_id));
        $ta_data['ta_data'] = json_decode($ta_data['ta_data'], true);
    	  
    	  $data['ta_data'] = $ta_data;
    	  $data['ta_id'] = $ta_id;
    	  
    	  $data['web_page'] = 'modify';
           
        $data['kind'] = $kind;            
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
    	  
    	  $this->layout->view('admin/group_push_log', $data); 
    }
  
}