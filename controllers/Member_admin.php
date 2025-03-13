<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_mssql_model' );
        
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
            exit;
        }
        
        if (!('01' <= $this->session->userdata('member_session')['d_posn'] &&  '59' >= $this->session->userdata('member_session')['d_posn'])){  // 沒有權限不能進組織專區
            alert( '抱歉您沒有權限使用該功能！' ,base_url('member/main'));
            exit;
        }        
        if ((!empty($this->session->userdata('webis_org')) && !($this->session->userdata('webis_org') == '1')) || !($this->session->userdata('member_session')['is_org'] == 1)){  // 是否整個組織專區鎖死
   	        alert( '組織專區維護中，暫停使用！' ,base_url('member/main'));
   	        exit;
   	    }
        
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        
        if (empty($this->session->userdata('bp_date'))){
            $web_data = $this->front_base_model->small_query("select * from web_base limit 1")[0];
            if ($web_data){
                if ($this->block_service->PF_IsDate($web_data['bp_date'])){
                    $bp_date = $web_data['bp_date'];
                }            
   	          $this->session->set_userdata( 'bp_date', $bp_date );
   	         }
   	    }
   	     	  
   	    // 針對會員的文字通知
   	    $position = $this->front_base_model->small_query("select title1,title2,memo from position where d_posn = ".$this->session->userdata('member_session')['d_posn'])[0];
   	    
   	    $where  = array ('epostid' => 'G000');            
        $admin_remark = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
        
        $meta['title2'] = '組織專區';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'            => $meta,
            'position'        => $position,
            'admin_remark'    => str_replace(array("\n"),'<br>',$admin_remark)
        );
        
        if ($this->front_mssql_model->ms_test()){           
            $msconn = $this->front_mssql_model->ms_connect();
                
            $ww_q_monpv = $this->front_mssql_model->get_data($msconn,"{CALL ww_q_monpv('".date('Y-m-d',strtotime($this->session->userdata('bp_date')))."','".$this->session->userdata('member_session')['c_no']."')}",array());
            
            if ($ww_q_monpv){
                $data['ww_q_monpv'] = $ww_q_monpv[0];
            }
            
            $ww_q_helpro = $this->front_mssql_model->get_data($msconn,"{CALL ww_q_helpro}",array());
            
            if ($ww_q_helpro){
                $data['ww_q_helpro'] = $ww_q_helpro;
            }
        }
   	                        
        _timer('*** before layout ***');
     
        $this->layout->view('member_admin', $data);
    }   
     
    public function download($Page=1)
    {
                
        $data['web_page'] = 'member_admin_download';
        
        $meta['title2'] = '表格下載列印';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 15;
        
        $where  = array ('a.kind' => 'D000','right(a.atype,2)'=>'99','a.nshow' => 'Y','a.begindate <=' => date('Y-m-d H:i:s'),'ifnull(a.closedate,now()) >=' => date('Y-m-d H:i:s') );        
        
        $order_by = array ('a.boardsort'=>'asc','a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
            
        $data['title'] = $meta['title2'];        
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_admin_download', $data);
    }
    
    // 商德規範
    public function law()
    {
                
        $data['web_page'] = 'member_admin_law';
        
        $meta['title2'] = '商德規範';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $where  = array ('kind' => 'G004','nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        $order_by = array ('boardsort'=>'asc','begindate'=> 'desc');   
        $data['admin_law_list'] = $this->front_base_model->get_data('ap_func_data',$where,$order_by);
        
        $where  = array ('epostid' => 'G005');             
        $data['admin_law'] = $this->front_base_model->get_data('ap_epost',$where,'',1);    
        
        _timer('*** before layout ***');
     
        $this->layout->view('member_admin_law', $data);
    }
    
    // ARSOA News 月刊
    public function news($Page=1)
    {                
        $data['web_page'] = 'member_admin_news';
        
        $meta['title2'] = 'ARSOA News 月刊';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 15;
        
        $where  = array ('a.kind' => 'G002','a.nshow' => 'Y','a.begindate <=' => date('Y-m-d H:i:s'),'ifnull(a.closedate,now()) >=' => date('Y-m-d H:i:s') );        
        
        $order_by = array ('a.boardsort'=>'asc','a.begindate'=> 'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ap_func_data',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
      
        $data['Pageurl'] = 'member_admin/news';
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
                               
        _timer('*** before layout ***');
     
        $this->layout->view('member_admin_news', $data);
        
        
    }
    
    public function edunews()
    {
        $data['web_page'] = 'member_admin_edunews';
        
        $meta['title2'] = '教育訓練情報';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'        => $meta
        );
        
        $where  = array ('kind' => 'G001','nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        $order_by = array ('d1'=> 'asc');   
        $data['class'] = $this->front_base_model->get_data('ap_func_data',$where,$order_by);
        
         _timer('*** before layout ***');
     
        $this->layout->view('member_admin_edunews', $data);
        
    }
    
    public function edunews_print($id)
    {
           $this->edunews_info($id,'Y');
    }
    
    public function edunews_info($id,$print = 'N')
    {
          $result = array('status' => 0, 'errmsg' => '');        
          
          $where  = array ('kind' => 'G001','id'=>$id,'nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );            
          $item = $this->front_base_model->get_data('ap_func_data',$where,'',1);
           
          if ($item){
              //  -- 記數 -- S
              $this->front_base_model->count_pageview('ap_func_data','edunews','hits','id',$id);   
              //  -- 記數 -- E
        
              $result['html'] = '
<div class="mb65">
 <div class="card">   
  <div class="card-body">
    <h5 class="card-title">課程：'.$item['title'].'</h5>
    <h6 class="card-subtitle mb-2 text-muted">日期：'.$this->block_service->PF_FD($item['d1']).'<br>
					星期：'.$this->block_service->get_chinese_weekday($item['d1']).'<br>
					時間：'.$item['field1'].'<br>
					地點：'.$item['descr'].'<br></h6><hr>    
		      <p>'.$item['body'].'</p>    
          &&&printbutton&&&		
  </div>
 </div>
</div>';
            $result['status'] = 1;
        }else{
            $result['errmsg'] = '課程已結束！';
        }
        //<a href="#" class="btn btn-outline-danger"><i class="ion-ios-arrow-back"></i>　回上一頁</a> 
        if ($print == 'N'){          
            $printhtml = '<p class="text-center">
                          <a href="'.base_url('member_admin/edunews_print/'.$id).'" class="btn btn-outline-danger" target=_blank><i class="ion-ios-printer"></i>　友善列印</a>    
		                      </p>';
            $result['html'] = str_replace("&&&printbutton&&&", $printhtml , $result['html']);
            
            $this->output->set_content_type('application/json');        
            echo json_encode($result);
        }else{
            ?>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title><?=FC_Web?> - <?=$item['title']?></title>
            <link href="<?=base_url()?>public/css/bootstrap.min.css" rel="stylesheet">
            <div class="container-fluid clearfix">
            <p>
            <a href="<?=base_url()?>" title="<?=FC_Web?>">
              <div class="brand-name"><img src="<?=base_url()?>public/images/logo.png" style="max-width: 125px;" alt="<?=FC_Web?>"></div>
            </a> 
            </p>
            <?php
            $result['html'] = str_replace("&&&printbutton&&&", "", $result['html']);
            echo $result['html'];
            echo '</body>';
        }
        exit;
                
	  }
	   
}