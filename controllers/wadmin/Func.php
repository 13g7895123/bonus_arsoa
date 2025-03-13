<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Func extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        
        $this->load->library('ui');
                        
        $this->load->model( 'front_admin_model' );
        $this->load->model( 'front_product_model' );
        $this->load->model( 'front_base_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
       
        $this->admin_session = $this->session->userdata( 'admin_session' );        
        $this->PATH_INFO = $_SERVER['PATH_INFO'];        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function item_list($kind)
    {
        if (!empty($this->input->get( 'classtype' ))){
            $data['classtype'] = $this->input->get( 'classtype' );
        }
        $data['wstype'] = 1;
        
        if (!empty($this->input->get( 'wstype' ))){
            $data['wstype'] = $this->input->get( 'wstype' );
        }
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                     
           if ($data_post['_submit'] == 'D'){
               if ($data_post['sortid'] > ''){
                   $this->front_base_model->delete_table('ap_itemclass',array('classid'=>$data_post['sortid']));                                           
                   $okmsg = '刪除成功！';
               }
           }else{
               if ($data_post['hnum'] > 0){
                   $J = 0;        
                   if ($data_post['sortid'] > ''){
                       $array=explode(",", $data_post['sortid']);	                
                       for ($i=0;$i< count($array);$i++){
                            $J++;
                            $updata["classsort"] = $J;
                            $uwhere  = array ('classtype' => $data_post['classtype'],'classid' => $array[$i]);                 
                            $class_data = $this->front_admin_model->get_data('ap_itemclass',$uwhere);
                            if ($class_data){
                                if (isset($data_post['classtitle'.$array[$i]]) && $data_post['classtitle'.$array[$i]] > ''){
                                    $updata["classtitle"] = $data_post['classtitle'.$array[$i]];
                                }                            
                                $this->front_base_model->update_table('ap_itemclass',$updata,$uwhere);                            
                            }else{
                                if ($data_post['classtitle'.$array[$i]] > ''){                            
                                    $updata["classtype"] = $data_post['classtype'];
                                    $updata["classtitle"] = $data_post['classtitle'.$array[$i]];
                            
                                    if (strlen($data_post['classtype']) == 1){
                                        $classid = $data_post['classtype'].$this->front_base_model->PF_SerOrder($data_post['classtype']);
                                    }else{
                                        $classid = $data_post['classtype']."-".$this->front_base_model->PF_SerOrder($data_post['classtype']);
                                    }
                                    $updata["classid"] = $classid;
                                    $id = $this->front_base_model->insert_table('ap_itemclass',$updata);
                                }
                            }
                            unset($updata);
                       }
                    }
                }
           }
           $data['classtype'] = $data_post['classtype'];
           $data['wstype']    = $data_post['wstype'];
        }
                
        $data['kind'] = $kind;
        
        $data['web_page'] = 'item_list';
        
        // 分類要幾層
        $data['wetstype'] = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/KIND/傳回值","層級",$kind);
        
        $where['classtype ='] = $data['classtype'];
        
        $data['list'] = $this->front_admin_model->item_list($where);
        
        $this->layout->view('admin/item_list', $data);
        
    }
    
    public function list($kind)
    {
    
        $data['Search'] = '';
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (isset($data_post['del'])){
                 foreach ($data_post['del'] as $key => $editid){
                          $deldata = $this->front_admin_model->func_data($editid);      
                          if ($deldata){                                      
                                   if ($deldata["field1"] > ''){                                       
                                       $this->block_service->PF_delfile(upload_folder.'func/'.$deldata["field1"]);                                       
                                   }
                                   if ($deldata["field2"] > ''){
                                       $this->block_service->PF_delfile(upload_folder.'func/'.$deldata["field2"]);
                                   }
                                   if ($deldata["field3"] > ''){
                                       $this->block_service->PF_delfile(upload_folder.'func/'.$deldata["field3"]);
                                   }
                                   $this->front_base_model->delete_table('ap_func_data',array('id'=>$editid));                        
                          }
                 }
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $data['web_page'] = 'func_list';
        
        $data['Xmlspec'] = $this->block_service->PF_LoadXmlDoc("spec/func_".$kind.".xml");//連結XML參數設定檔
        
        $sort = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/KIND/傳回值","排序",$kind);
        
        if ($sort == $kind){          
            $sort = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/SND/傳回值","排序",$kind);
        }
                
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where['a.kind ='] = $kind;
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );

        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'title' => $data['Search'],
                     'descr' => $data['Search'],
                     'body'  => $data['Search']
                    );
        }
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.nshow' => 'desc','a.id' => 'desc' )    // order by
            );        
      
        $data['kind'] = $kind;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $this->layout->view('admin/func_list', $data);
    }
    
    // 聯絡我們
    public function feedback($kind,$ftype='A')
    {
        $data['Search'] = '';
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){            
             if (isset($data_post['del'])){
                 foreach ($data_post['del'] as $key => $editid){
                          $this->front_base_model->delete_table('ap_feedback',array('id'=>$editid));
                 }
             }
             
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $data['web_page'] = 'feedback';
                
        $sort = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/KIND/傳回值","排序",$kind);
        
        if ($sort == $kind){          
            $sort = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/SND/傳回值","排序",$kind);
        }
                
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where['a.ftype ='] = $ftype;
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );

        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'name' => $data['Search'],
                     'email' => $data['Search'],
                     'phone'  => $data['Search'],
                     'title'  => $data['Search'],
                     'memo'  => $data['Search'],
                    );
        }
        
        $data['list'] = $this->block_service->page_list( 'ap_feedback',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'crdt' => 'desc' )    // order by
        );        
            
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );
        
        $data['kind'] = $kind;
        $data['ftype'] = $ftype;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $this->layout->view('admin/feedback_list', $data);
    }
    
    /* 聯絡我們 */
    public function feedback_modify($kind,$ftype)
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
        
        $where  = array ('id' => $data['edit'],'ftype' => $ftype);        
         
        $data['data'] = $this->front_admin_model->get_data('ap_feedback',$where);
      
        if (empty($data['data']['retitle'])){ 
            $data['data']['retitle'] = FC_Web." 回覆";          
        }
                
        $data['web_page'] = 'feedback_modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
        
        $data['ftype'] = $ftype;   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/feedback_modify', $data);
      
    }
    
    public function feedback_save($kind,$ftype)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             $data = array (
                        'retitle'     => $data_post['retitle'],
                        'email'       => $data_post['email'],                        
                        'rebody'      => $data_post['rebody'],     
                        'account'     => $_SESSION['admin_session']['admin_name'],
                        'redate'      => date('Y-m-d H:i:s')
                     );
             $where['id ='] = $data_post['edit'];
             $this->front_base_model->update_table('ap_feedback',$data,$where);
             $okmsg = '回覆成功！';
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $EBody = $this->block_service->PF_ReadFile("public/email/refeedbackemail.html");             
             $where  = array ('id' => $data_post['edit'],'ftype' => $ftype);                 
             $re_data = $this->front_admin_model->get_data('ap_feedback',$where);
        
             foreach($re_data as $_key=>$_value){
					               if ($_value!=''){
					                   $EBody=str_replace("[+".$_key."+]", $this->block_service->PF_Vbcrlf($_value) ,$EBody);
					               }else{
					                   $EBody=str_replace("[+".$_key."+]", "" ,$EBody);
					               }								 
 				 }
 				 $this->block_service->send_email($re_data['email'],$re_data['retitle'],$EBody);        
 				 					           
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
             PF_submit(base_url('wadmin/func/feedback/'.$kind.'/'.$ftype) ,$ahidden);
          
        }
    }
    
    // 資料匯出 
    public function out_download($kind,$ftype)
    {
           $data['kind']  = $kind;
           $data['ftype'] = $ftype;
           
           $data_post = $this->input->post();
           if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
                $where['ftype = ']  = $ftype; 
                if ($data_post['stdt'] > ''){
                    $where["DATE_FORMAT(crdt,'%Y-%m-%d') >= "]  = $data_post['stdt']; 
                }
                if ($data_post['eddt'] > ''){
                    $where["DATE_FORMAT(crdt,'%Y-%m-%d') <= "]  = $data_post['eddt']; 
                }
                $listdata  = $this->front_admin_model->list_data('ap_feedback',$where);     
                $filetitle = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/SND/傳回值","資料", $kind);
                $filename  = $filetitle."-".date('Y-m-d');                
                if ($listdata){                
                    $this->block_service->excel_download('xlsx',$filetitle,$filename,$listdata,array('id','name','phone','email','title','memo','crdt','retitle','rebody','redate','account'),array('流水號','姓名','電話','電子信箱','問題','內容','詢問時間','回覆主旨','回覆內容','回覆時間','回覆人'));
                }else{
                   echo '無資料可供下載!'; 
                   exit;
                }                
           }
           
           //$output = $this->load->view('admin/out_main', $data, true );
           
           //echo $output;
           exit;
    }
         
    public function func_modify($kind)
    {
        $data_post = $this->input->post();
        
        $data['edit'] = 0;
        $data['Search'] = '';
        $data['Page'] = 1;
        $data['pmdata'] = array();
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
        if ($data['edit'] > 0){
            $data['pmdata'] = $this->front_admin_model->func_data($data['edit']);            
        }else{
            $data['pmdata']['nshow'] = 'N';
        }
        
        $data['Xmlspec'] = $this->block_service->PF_LoadXmlDoc("spec/func_".$kind.".xml");//連結XML參數設定檔
        
        $data['web_page'] = 'func_modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/func_modify', $data);
    }
    
    public function func_save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             
             if (!isset($data_post['nshow'])){ 
                 $data_post['nshow'] = "N"; 
             }
             if (!isset($data_post['boardsort']) || $data_post['boardsort'] == ''){ 
                 $data_post['boardsort'] = 99; 
             }
             
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $data = array (
                        'title'     => $data_post['title'],
                        'nshow'     => $data_post['nshow'],                        
                        'account'   => $_SESSION['admin_session']['admin_name'],
                        'boardsort' => $data_post['boardsort'],
                        'updt'      => date('Y-m-d H:i:s')
                     );
             
             if ($file_data){
                 // 檔案判斷
                 foreach ($file_data as $key => $item){
                        $data[$key]  = $item['name'];
                        $data[$key."_name"]  = $item['old_name'];
                        if ($data_post['edit'] > 0){ // 修改
                            // 舊圖檔刪除
                            $filen = (int)str_replace('field','',$key);                            
                            if (isset($data_post['field'.$filen.'_del']) && $data_post['field'.$filen.'_del'] == 'Y' && $data[$key] > '' && $data[$key] <> $data_post[$key.'_old']){                                 
                                $this->block_service->PF_delfile(upload_folder.'func/'.$data_post[$key.'_old']);
                            }
                        }
                 }             
             }
                          
             if (isset($data_post['atype'])){
                 if (is_array($data_post['atype'])){
                     $data['atype'] = implode(',',$data_post['atype']);
                 }else{
                     $data['atype'] = $data_post['atype'];
                 }                 
             }
             if (isset($data_post['aurl'])){
                 $data['aurl'] = $data_post['aurl'];
             }
             if (isset($data_post['d1'])){
                 $data['d1'] = $data_post['d1'];
             }
             if (isset($data_post['d2'])){
                 $data['d2'] = $data_post['d2'];
             }
             if (isset($data_post['tags'])){
                 $data['tags'] = $data_post['tags'];
             }
             if (isset($data_post['descr'])){
                 $data['descr'] = $data_post['descr'];
             }
             if (isset($data_post['body'])){
                 $data['body'] = $data_post['body'];
             }
             if (isset($data_post['field1']) && ($data_post['field1'] > '' || $data_post['field1_del'] == 'Y')){
                 $data['field1'] = $data_post['field1'];
             }
             if (isset($data_post['field2']) && ($data_post['field2'] > '' || $data_post['field2_del'] == 'Y')){
                 $data['field2'] = $data_post['field2'];
             }
             if (isset($data_post['field3']) && ($data_post['field3'] > '' || $data_post['field3_del'] == 'Y')){
                 $data['field3'] = $data_post['field3'];
             }
             if (isset($data_post['field4']) && ($data_post['field4'] > '' || $data_post['field4_del'] == 'Y')){
                 $data['field4'] = $data_post['field4'];
             }
             if (isset($data_post['begindate']) && $data_post['begindate'] > ''){
                 $data['begindate'] = $data_post['begindate'];
             }
             if (isset($data_post['closedate']) && $data_post['closedate'] > ''){
                 $data['closedate'] = $data_post['closedate'];
             }else{
             	   if (isset($data_post['edit']) && $data_post['edit'] > 0){   
             	       $upsql = "update ap_func_data set closedate = null where id = ? ; ";                                
                     $this->db->query($upsql, array( $data_post['edit']));
                 }
             }
             
             if (isset($data_post['edit']) && $data_post['edit'] > 0){          
                 $where['id ='] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_func_data',$data,$where);
                 $okmsg = '編輯成功！';
             }else{
                 $data['kind'] = $kind;
                 $data['crdt'] = date('Y-m-d H:i:s');
                 $data['hits'] = 0;             
                 $id = $this->front_base_model->insert_table('ap_func_data',$data);
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
             PF_submit(base_url('wadmin/func/list/'.$kind) ,$ahidden);
             
        }        
    }
    
    /* 鎖定結帳 */
    public function admin_closepay($kind)
    {
        $data_post = $this->input->post();

        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
            $data['dh']  = $data_post['dh'];
            $data['chk']  = $data_post['chk'];
            $data['stdt'] = $data_post['stdt'];
            $data['eddt'] = $data_post['eddt'];
            $data['account'] = $_SESSION['admin_session']['admin_name'];
            $data['updt'] = date('Y-m-d H:i:s');
            
            $where['id ='] = 1;
            $this->front_base_model->update_table('ap_dataset',$data,$where);            
            $this->session->set_flashdata( 'ok_message','鎖定結帳設定成功！' );
            redirect( base_url('wadmin/func/admin_closepay/'.$kind) );  	
        }
                
        $where  = array ('id' => 1);
         
        $data['data'] = $this->front_admin_model->get_data('ap_dataset',$where);
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );
        
        $data['web_page'] = 'closepay';
          
        $data['kind'] = $kind;
        
        $this->layout->view('admin/closepay', $data);
    }
    
    public function epost($kind)
    {
        $data_post = $this->input->post();

        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             $data = array(
                        'epostbody' => $data_post['epostbody']
                     );
             $where['epostid ='] = $kind;
                     
             $this->front_base_model->update_table('ap_epost',$data,$where);
             
             redirect( 'wadmin/func/epost/'.$kind );
             
             exit;
        }else{        
         
          $data = $this->front_admin_model->epost($kind);
          
          if ($data){
              $data = $data[0];
          }else{
              $data['epostbody'] = ''; 
          }
          
          $data['web_page'] = 'epost';
          
          $data['kind'] = $kind;
          
          $data['type'] = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/權限/選單/KIND/傳回值","形態",$kind);
                                           
          $this->layout->view('admin/epost', $data);
        }
    }
    
    public function admin_list($kind)
    {
        $this->block_service->PF_Limit("999"); 
        
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
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );

        $where['adminid > '] = 0;
        
        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'account' => $data['Search'],
                     'name' => $data['Search'],
                     'email'  => $data['Search']
                    );
        }
        
        $data['list'] = $this->block_service->page_list( 'ap_admin',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'adminid' => 'desc' )    // order by
            );        
      
        $data['kind'] = $kind;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數
        
        $data['web_page'] = 'admin_list';
        
        $this->layout->view('admin/admin_list', $data);
        
    }
    
    public function admin_modify($kind = 9999)
    {
        $data_post = $this->input->post();
        
        $data['Search'] = '';
        $data['Page'] = 1;
     
        if ($_SESSION['admin_session']['admin_status'] == '999'){            
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
                 $data['GoBackUrl'] = $data_post['GoBackUrl'];   
            }else{
                 $data['edit'] = $_SESSION['admin_session']['admin_id'];
                 $data['GoBackUrl'] = base_url('wadmin/func/admin_modify');   
            } 
        }else{
            $data['edit'] = $_SESSION['admin_session']['admin_id'];
            $data['GoBackUrl'] = base_url('wadmin/func/admin_modify');   
        }
        
        if (isset($data['edit']) && $data['edit'] > 0){
            $data['data'] = $this->front_admin_model->admin_data($data['edit']);                 
        }else{
        	  $data['edit'] = 0;
        }
        
        $data['web_page'] = 'admin_modify';        
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/admin_modify', $data);
    }
    
    /* 管理者存檔 */
    public function admin_save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if ($_SESSION['admin_session']['admin_status'] == '999'){
                 $edit = $data_post['edit'];
             }else{
                 $edit = $_SESSION['admin_session']['admin_id'];
             }
        
             $data = array (
                        'name'     => $data_post['name'],
                        'email'    => $data_post['email']
                     );
             
             if ($_SESSION['admin_session']['admin_status'] == '999'){
                  $data["status"] = $data_post['status'];        // 權限                 
             }
             if ($data_post['pwd'] > ''){
                 $data["pwd"] = md5($data_post['pwd']);          //密碼
             }
                                 
             if ($edit > 0){          
                 $where['adminid ='] = $edit;                 
                 $this->front_base_model->update_table('ap_admin',$data,$where);
                 $okmsg = '編輯成功！';
             }else{
                 $data['crdt'] = date('Y-m-d H:i:s');                 
                 $data["account"] = $data_post['account']; 
                 $id = $this->front_base_model->insert_table('ap_admin',$data);
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             if ($_SESSION['admin_session']['admin_status'] == '999'){
                 $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );                        
                 if ($data_post['Search'] > ''){
                     $ahidden['Search'] = $data_post['Search'];
                 }
                 PF_submit(base_url('wadmin/func/admin_list/'.$kind) ,$ahidden);
             }else{
                 redirect( base_url('wadmin/func/admin_modify') );  	
             }
        }        
    }
    
    
    public function viewcount($kind,$Mon = '')
    {
        $StartDate = '';
        $EndDate = '';
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
            $StartDate = $data_post['StartDate'];
            $EndDate = $data_post['EndDate'];
        }
        
        $next_date=mktime(0,0,0,date('m')-1,date('d'),date('Y'));
        if ($StartDate==""){$StartDate=date('Y-m-d',$next_date);}
        if ($EndDate==""){$EndDate=date('Y-m-d');}
        
        $xstr = '';
        $ystr = '';
        $sum = 0;
        $Week=array("日","一","二","三","四","五","六");
        if ($Mon==""){
        	  $list = $this->front_admin_model->viewcount($StartDate,$EndDate);
        	  
        }else{
            $list = $this->front_admin_model->viewcount_mon();
        }
        
        if ($list){                    
            foreach ($list as $rs) {            
                   if ($Mon==""){
                       $ahits[date('Y/m/d',strtotime($rs["createdate"]))] = $rs["hits"];
                       $sum += $rs["hits"];
                   }else{
                       if ($xstr > ''){ $xstr.= ",";$ystr.= ","; } 
                       $xstr .= '"'.$rs["createdate"].'"';
                       $ystr .= $rs["hits"];
                   }
            }
        }
        if ($Mon==""){
            $TheMaxDate = $this->ui->DateDiff('d',strtotime($StartDate),strtotime($EndDate));
            for ($i=0;$i<=$TheMaxDate;$i++){
                 if ($xstr > ''){ $xstr.= ",";$ystr.= ","; } 
                 
                 $createdate = date('Y/m/d',$this->ui->DateAdd('d',$i,strtotime($StartDate)));
            		 $xstr .= '"'.$createdate.'('.$Week[date('w',strtotime(date($createdate)))].')"';     
            		 if (isset($ahits[$createdate])){
                     $ystr .= $ahits[$createdate];
                 }else{
                     $ystr .= 0;
                 }    
            }
        }

        $data['web_page'] = 'viewcount';        
           
        $data['kind'] = $kind;       
        $data['Mon']  = $Mon;       
        $data['xstr']  = $xstr;       
        $data['ystr']  = $ystr;       
        $data['sum']  = $sum;       
        $data['StartDate']  = $StartDate;       
        $data['EndDate']  = $EndDate;       
        
        $data['total'] = $this->front_admin_model->viewcount_total()[0]['total'];
               
        $this->layout->view('admin/viewcount', $data);
      
    }
    
    public function skin_quest($kind)
    {
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                     
              $this->front_base_model->update_table('cht_test',$data_post,array('id'=>1));                            
              $data['ok_message'] = "修改成功！";
        }
        $data['skin_data'] = $this->front_admin_model->get_data('cht_test',array('id'=>1),'',1);             
        
        $data['web_page'] = 'skin_quest';        
           
        $data['kind'] = $kind;   
        
        $this->layout->view('admin/skin_quest', $data);
    }
    
    public function skin_ans($kind)
    {
           
        $data['list'] = $this->block_service->page_list( 'cht_test_ans',array(), // where
            array(),   // like
            1,
            100
            , NULL  // group by
            , array( 'id' => 'asc' )    // order by
            );        
        
        $data['web_page'] = 'skin_ans';        
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );
           
        $data['kind'] = $kind;   
        
        $this->layout->view('admin/skin_ans', $data);
    }
    
    public function skin_ans_modify($kind)
    {
        if (!empty($this->input->get( 'edit' ))){
            $data['edit'] = (int)$this->input->get( 'edit' );
        }    
        
        $data['data'] =  $this->front_admin_model->get_data('cht_test_ans',array('id'=>$data['edit']),'',1);      
        
        if ($data['data']['pid'] > ''){
             $sqlcase = ' case p.p_no ';
             $sqlin = '';
             $FAr = explode(",",$data['data']['pid']);              
	          for ($i=0;$i< count($FAr);$i++){
	               if ($sqlin > ''){ $sqlin .= ","; }
	               $sqlin .= "'".$FAr[$i]."'";
	               $sqlcase .= " when '".$FAr[$i]."' then ".$i." ";
	          }
	          $sqlcase .= " end psort ";
	          $sql = "select p.* ,".$sqlcase."
                      from product p
                     where p.p_no in (".$sqlin.")
                      order by psort ";
             $pdata = $this->front_base_model->small_query($sql);             
             if ($pdata){
	              $data['piddata'] = $pdata;
             }             
        }
                
        $data['web_page'] = 'skin_ans_modify';
           
        $data['kind'] = $kind;                     
        
        $this->layout->view('admin/skin_ans_modify', $data);       
          
    }
    
    
    public function skin_ans_save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             
             $pid = '';
             if ($data_post['data_num'] > 0){
                 $apid = array();
                 for ($i = 1;$i<=$data_post['data_num'];$i++){
                      if ($data_post['pid_'.$i] > '' && $data_post['pid_sort_'.$i] > ''){
                          $apid[$data_post['pid_sort_'.$i]]['p_no'] = $data_post['pid_'.$i];
                      }
                 }
                 ksort($apid);
                 $darr = array();
                 foreach ($apid as $key => $item){                 
                         $darr[] = $item['p_no'];
                 }                 
                 $pid = implode(",",array_unique($darr));
             }
             
             $data = array (
                        'question'     => $data_post['question'],
                        'attention'    => $data_post['attention'],                        
                        'keep'         => $data_post['keep'],          
                        'pid'          => $pid,          
                        'account'      => $_SESSION['admin_session']['admin_name'],                        
                        'updt'         => date('Y-m-d H:i:s')
                     );
             
             $where['id ='] = $data_post['edit'];                 
             $this->front_base_model->update_table('cht_test_ans',$data,$where);
             $okmsg = '編輯成功！';
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             redirect( base_url('wadmin/func/skin_ans/'.$kind) );
             
        }        
    }
    
    public function skin_ans_addpid()
    {
        
        $result = array('status' => 0, 'errmsg' => '操作有誤!');        
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             $data = $this->front_product_model->get_data($data_post['pid'],'N');  
             if ($data){
                 $result['status'] = 1;
                 $result['p_no']   = trim($data['p_no']);
                 $result['p_name'] = trim($data['p_name']);
                 if ($data["is_visual"] || $data["c_price"] > 0){
                     $result['is_visual'] = "上架";                 
                 }else{
                     $result['is_visual'] = "下架";                 
                 }
                 $result['errmsg'] = '';
             }else{
                 $result['errmsg'] = '無此產品!';
             }
        }
        $this->output->set_content_type('application/json');
        echo json_encode($result);
        exit;        
    }
    
    
    public function sale($kind)
    {
           
        $data['Search'] = '';
        $Page = 1;
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             if (isset($data_post['del'])){
                 foreach ($data_post['del'] as $key => $editid){
                          $deldata = $this->front_admin_model->func_data($editid);      
                          if ($deldata){                                      
                                   if ($deldata["field1"] > ''){                                       
                                       $this->block_service->PF_delfile(upload_folder.'func/'.$deldata["field1"]);                                       
                                   }
                                   $this->front_base_model->delete_table('ap_func_data',array('id'=>$editid));                        
                          }
                 }
             }
             if (isset($data_post['Search'])){
                 $data['Search'] = $data_post['Search'];
             }
             if (isset($data_post['Page'])){
                 $Page =  $data_post['Page'];
             }             
        }
        
        $data['web_page'] = 'sale_list';
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $data['ok_message'] = $this->session->flashdata( 'ok_message' );

        $like = array();
        
        if ($data['Search'] > ''){
            $like = array(
                     'title' => $data['Search'],
                     'descr'  => $data['Search']
                    );
        }
        
        $where['id >'] = 0;
        
        $data['list'] = $this->block_service->page_list( 'ap_sale',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , array( 'a.nshow' => 'desc','a.id' => 'desc'  )    // order by
            );        
      
        $data['kind'] = $kind;
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數        
        
        $this->layout->view('admin/sale_list', $data);
    }
    
    public function sale_modify($kind)
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
        if ($data['edit'] > 0){
            $where  = array ('id' => $data['edit']);                 
            $data['data'] = $this->front_admin_model->get_data('ap_sale',$where);
            if ($data['data']['product'] > ''){        
                $prddata = json_decode($data['data']['product'], true);
                $data['product_num'] = $prddata;

	              $sqlin = array();
	              foreach ($prddata as $key => $item){
	                       $sqlin[] = $key;
	              }
	              $pid = implode("','",array_unique($sqlin));
	              $sql = "select p.p_no,p.p_name,p.is_visual,p.c_price
                          from product p
                         where p.p_no in ('".$pid."')  ";                         
                $pdata = $this->front_base_model->small_query($sql);                  
                if ($pdata){
	                 $data['data']['product'] = $pdata;
                }          
            }
        }else{
            $data['data']['title'] = '';
            $data['data']['title2'] = '';
            $data['data']['descr'] = '';
            $data['data']['body'] = '';
            $data['data']['field1'] = '';
            $data['data']['show_stdt'] = '';
            $data['data']['show_eddt'] = '';
            $data['data']['begindate'] = date('Y-m-d H:i:s');
            $data['data']['closedate'] = '';
            $data['data']['nshow'] = 'N';
            $data['data']['sale_sort'] = '99';
        }
        
        $data['web_page'] = 'sale_modify';
        
        $data['GoBackUrl'] = $data_post['GoBackUrl'];   
           
        $data['kind'] = $kind;             
        
        $this->layout->view('admin/sale_modify', $data);
    }
    
    public function sale_save($kind)
    {
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             
             if (!isset($data_post['nshow'])){ 
                 $data_post['nshow'] = "N"; 
             }
                         
             $file_data = $this->block_service->PF_Upload("func",true,FC_FileLimit);	
             
             $data = array (
                        'title'     => $data_post['title'],
                        'title2'    => $data_post['title2'],
                        'body'      => $data_post['body'],
                        'descr'     => $data_post['descr'],
                        'nshow'     => $data_post['nshow'],                        
                        'sale_sort' => $data_post['sale_sort'],   
                        'account'   => $_SESSION['admin_session']['admin_name'],                        
                        'updt'      => date('Y-m-d H:i:s')
                     );
             
             if ($file_data){
                 // 檔案判斷
                 foreach ($file_data as $key => $item){
                        $data[$key]  = $item['name'];
                        $data[$key."_name"]  = $item['old_name'];
                        if ($data_post['edit'] > 0){ // 修改
                            // 舊圖檔刪除
                            $filen = (int)str_replace('field','',$key);                            
                            if (isset($data_post['field'.$filen.'_del']) && $data_post['field'.$filen.'_del'] == 'Y' && $data[$key] > '' && $data[$key] <> $data_post[$key.'_old']){                                 
                                $this->block_service->PF_delfile(upload_folder.'func/'.$data_post[$key.'_old']);
                            }
                        }
                 }             
             }
               
            // if (isset($data_post['descr'])){
            //     $data['descr'] = $data_post['descr'];
            // }           
             if (isset($data_post['field1']) && ($data_post['field1'] > '' || $data_post['field1_del'] == 'Y')){
                 $data['field1'] = $data_post['field1'];
             }           
             if (isset($data_post['begindate']) && $data_post['begindate'] > ''){
                 $data['begindate'] = $data_post['begindate'];
             }
             if (isset($data_post['closedate']) && $data_post['closedate'] > ''){
                 $data['closedate'] = $data_post['closedate'];
             }else{
             	   if (isset($data_post['edit']) && $data_post['edit'] > 0){   
             	       $upsql = "update ap_sale set closedate = null where id = ? ; ";                                
                     $this->db->query($upsql, array( $data_post['edit']));
                 }
             }
             
             if (isset($data_post['show_stdt']) && $data_post['show_stdt'] > ''){
                 $data['show_stdt'] = $data_post['show_stdt'];
             }
             if (isset($data_post['show_eddt']) && $data_post['show_eddt'] > ''){
                 $data['show_eddt'] = $data_post['show_eddt'];
             }else{
             	   if (isset($data_post['edit']) && $data_post['edit'] > 0){   
             	       $upsql = "update ap_sale set show_eddt = null where id = ? ; ";                                
                     $this->db->query($upsql, array( $data_post['edit']));
                 }
             }
             
             $pidstr = '';
             if ($data_post['data_num'] > 0){
                 $apid = array();
                 for ($i = 1;$i<=$data_post['data_num'];$i++){
                      if ($data_post['pid_'.$i] > '' && $data_post['pid_num_'.$i] >= '1'){
                          $apid[$data_post['pid_'.$i]] = $data_post['pid_num_'.$i];
                      }
                 }
                 $pidstr = json_encode($apid);
             }
             $data['product'] = $pidstr;
           
             if (isset($data_post['edit']) && $data_post['edit'] > 0){          
                 $where['id ='] = $data_post['edit'];                 
                 $this->front_base_model->update_table('ap_sale',$data,$where);                
                 $okmsg = '編輯成功！';
             }else{                 
                 $data['crdt'] = date('Y-m-d H:i:s');
                 $data['hits'] = 0;             
                 $id = $this->front_base_model->insert_table('ap_sale',$data);
                 $okmsg =  "新增成功！";
             }
             
             $this->session->set_flashdata( 'ok_message', $okmsg );
             
             $ahidden = array(                           
                           'Page'   =>  $data_post['Page']
                        );
             if ($data_post['Search'] > ''){
                 $ahidden['Search'] = $data_post['Search'];
             }
            
             PF_submit(base_url('wadmin/func/sale/'.$kind) ,$ahidden);
             
        }        
    }
    
    
}