<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller
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
                
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    	  
	  public function index($rid='',$print = 'N')
    {
    	  $adminstr = '';
    	  if ($this->session->userdata('member_session')['d_posn'] >= 60){
    	  	  $rid = 10;
    	  }else{
    	  	  if (!('01' <= $this->session->userdata('member_session')['d_posn'] &&  '59' >= $this->session->userdata('member_session')['d_posn'])){  // 沒有權限不能進組織專區
                 alert( '抱歉您沒有權限使用該功能！' ,base_url('member/main'));
                 exit;
            }  
            $adminstr = '組織專區';
    	  }
    	  
    	  if ((!empty($this->session->userdata('webis_org')) && !($this->session->userdata('webis_org') == '1')) || !($this->session->userdata('member_session')['is_org'] == 1)){  // 是否整個組織專區鎖死
   	        alert( $adminstr.'維護中，暫停使用！' ,base_url('member/main'));
   	        exit;
   	    }
    	  
        $data_post = $this->input->post();
       
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){     
             //ini_set('display_errors', 0);  
             switch ($rid) {
                 case 1:
                     $params = [ 
                         [$data_post['y1']."".$data_post['m1'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN] 
                     ]; 
                     $spsql = "{CALL ww_q_bndtl(?,?)}";
                     $spkey = "ww_q_bndtl_".$data_post['y1']."".$data_post['m1'];
                     $showtitle = "".$data_post['y1']." 年 ".$data_post['m1']." 月 會員佣金明細表";
                     break;
                 case 2:
                     $params = [ 
                         [$data_post['y2']."".$data_post['m2'],  SQLSRV_PARAM_IN],     
                         [$data_post['y21']."".$data_post['m21'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [1,  SQLSRV_PARAM_IN] 
                     ]; 
                     $spsql = "{CALL ww_q_hisbona(?,?,?,?)}";                         
                     $spkey = "ww_q_hisbona_".$data_post['y2']."".$data_post['m2']."_".$data_post['y21']."".$data_post['m21']."_1";
                     $showtitle = "歷史獎金明細";
                     break;
                 case 3:
                     $params = [ 
                         [$data_post['y3']."".$data_post['m3'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r3'],  SQLSRV_PARAM_IN],     
                         [$data_post['type3'],  SQLSRV_PARAM_IN]
                     ]; 
                     $spsql = "{CALL ww_q_org(?,?,?,?)}";                         
                     $spkey = "ww_q_org_".$data_post['y3']."".$data_post['m3']."_".$data_post['type3']."".$data_post['r3'];                                          
                     $showtitle = "".$data_post['y3']." 年 ".$data_post['m3']." 月 組織業績資料";
                     break;
                 case 4:
                     $params = [ 
                         [$data_post['y4']."".$data_post['m4'],  SQLSRV_PARAM_IN],     
                         [$data_post['y41']."".$data_post['m41'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [2,  SQLSRV_PARAM_IN] 
                     ]; 
                     $spsql = "{CALL ww_q_hisbona(?,?,?,?)}";                         
                     $spkey = "ww_q_hisbona_".$data_post['y4']."".$data_post['m4']."_".$data_post['y41']."".$data_post['m41']."_2";
                     $showtitle = "歷史業績明細";
                     break;
                 case 5:    
                     $showtitle = "".$data_post['y5']." 年 ".$data_post['m5']." 月 直接推薦資料";
                     $params = [ 
                         [$data_post['y5']."".$data_post['m5'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [0,  SQLSRV_PARAM_IN], 
                         [1,  SQLSRV_PARAM_IN], 
                     ]; 
                     $spsql = "{CALL ww_q_1org(?,?,?,?)}";                         
                     $spkey = "ww_q_1org_".$data_post['y5']."".$data_post['m5']."_0_1";                     
                     break;
                 case 6:    
                     $params = [ 
                         [$data_post['y6']."".$data_post['m6'],  SQLSRV_PARAM_IN],     
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r6'],  SQLSRV_PARAM_IN], 
                         [$data_post['type6'],  SQLSRV_PARAM_IN], 
                     ]; 
                     $spsql = "{CALL ww_q_orgcnt(?,?,?,?)}";                         
                     $spkey = "ww_q_orgcnt_".$data_post['y6']."".$data_post['m6']."_".$data_post['type6']."_".$data_post['r6']."";                     
                     $showtitle = "".$data_post['y6']." 年 ".$data_post['m6']." 月 組織人數統計";
                     break;                     
                 case 7:                
                     $params = [ 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r7'],  SQLSRV_PARAM_IN], 
                         [$data_post['type7'],  SQLSRV_PARAM_IN], 
                     ]; 
                     $spsql = "{CALL ww_q_hiscnt(?,?,?)}";                         
                     $spkey = "ww_q_hiscnt_".$data_post['type7']."_".$data_post['r7']."";
                     $showtitle = "歷史組織人數";
                     break;  
                 case 8:                                    
                     $params = [ 
                         [$data_post['y8']."".$data_post['m8'],  SQLSRV_PARAM_IN], 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r8'],  SQLSRV_PARAM_IN], 
                         [$data_post['type8'],  SQLSRV_PARAM_IN], 
                     ]; 
                     $spsql = "{CALL ww_q_orgup(?,?,?,?)}";                         
                     $spkey = "ww_q_orgup_".$data_post['y8']."".$data_post['m8']."_".$data_post['type8']."_".$data_post['r8']."";
                     $showtitle = "".$data_post['y8']." 年 ".$data_post['m8']." 月晉升名單";
                     break;                       
                 case 9:
                     $params = [ 
                         [$data_post['y9']."".$data_post['m9'],  SQLSRV_PARAM_IN], 
                         [$data_post['y91']."".$data_post['m91'],  SQLSRV_PARAM_IN], 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r9'],  SQLSRV_PARAM_IN], 
                         [$data_post['type9'],  SQLSRV_PARAM_IN], 
                     ]; 
                     $spsql = "{CALL ww_q_prosale(?,?,?,?,?)}";
                     $spkey = "ww_q_prosale_".$data_post['y9']."".$data_post['m9']."_".$data_post['y91']."".$data_post['m91']."_".$data_post['type9']."_".$data_post['r9']."";
                     $showtitle = "".$data_post['y9']."".$data_post['m9']." ~ ".$data_post['y91']."".$data_post['m91']." 期間產品統計";
                     break;  
                 case 10:                
                     $params = [ 
                         [$data_post['y10'],  SQLSRV_PARAM_IN], 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                     ]; 
                     $spsql = "{CALL ww_q_yearsale(?,?)}";                         
                     $spkey = "ww_q_yearsale_".$data_post['y10']."";
                     $showtitle = "".$data_post['y10']." 年度進貨資枓";
                     break;  
                 case 11:
                     $params = [ 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],     
                         [$data_post['dno'],  SQLSRV_PARAM_IN], 
                         [$data_post['y11']."".$data_post['m11'],  SQLSRV_PARAM_IN],
                         [$data_post['y111']."".$data_post['m111'],  SQLSRV_PARAM_IN],
                     ]; 
                                         
                     $spsql = "{CALL ww_q_orddtl(?,?,?,?)}";
                     $spkey = "ww_q_orddtl_".$data_post['dno']."_".$data_post['y11']."".$data_post['m11']."_".$data_post['y111']."".$data_post['m111'];
                     $showtitle = "".$data_post['y11']."".$data_post['m11']." ~ ".$data_post['y111']."".$data_post['m111']." 期間訂購品項統計";
                     break;
                 case 12:
                     $params = [ 
                         [$data_post['y12']."".$data_post['m12'],  SQLSRV_PARAM_IN], 
                         [$data_post['y121']."".$data_post['m121'],  SQLSRV_PARAM_IN], 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         [$data_post['r12'],  SQLSRV_PARAM_IN], 
                         [$data_post['type12'],  SQLSRV_PARAM_IN], 
                         [$data_post['o12'],  SQLSRV_PARAM_IN], 
                     ];                      
                     $spsql = "{CALL ww_q_uamt(?,?,?,?,?,?)}";
                     $spkey = "ww_q_uamt_".$data_post['y12']."".$data_post['m12']."_".$data_post['y121']."".$data_post['m121']."_".$data_post['type12']."_".$data_post['r12']."_".$data_post['o12']."";
                     $showtitle = "".$data_post['y12']."".$data_post['m12']." ~ ".$data_post['y121']."".$data_post['m121']." 建議售價查詢";
                     break;  
                 case 13:
                     $params = [ 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                         ['2',  SQLSRV_PARAM_IN], 
                         [$data_post['y13']."".$data_post['m13'],  SQLSRV_PARAM_IN],                              
                         [$data_post['type13'],  SQLSRV_PARAM_IN], 
                         [$data_post['o13'],  SQLSRV_PARAM_IN], 
                     ];                  
                     //echo "<pre>".print_r($params,true)."</pre>";
                     $spsql = "{CALL ww_q_star(?,?,?,?,?)}";
                     $spkey = "ww_q_star_".$data_post['y13']."".$data_post['m13']."_".$data_post['o13']."_".$data_post['type13']."";
                     $showtitle = "".$data_post['y13']."".$data_post['m13']." 赴日研修顆星";
                     $data['datatitle'] = "".$data_post['y13']."".$data_post['m13']." 月份";
                     break;     
                 case 14:
                     $month14 = 0;
                     if (isset($data_post['month14']) && $data_post['month14'] == '1'){
                         $month14 = 1;
                     }	
                 
                     $params = [ 
                         [$data_post['type14'],  SQLSRV_PARAM_IN], 
                         [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],                         
                         [$month14,  SQLSRV_PARAM_IN], 
                     ];                                       
                     $spsql = "{CALL ww_q_helord(?,?,?)}";
                     $spkey = "ww_q_helord_".$data_post['type14']."_".$month14;
                     
                     break;         
                                           
                 default:                    
                     break;
             }   
             $report_data['spsql']  = $spsql;
             $report_data['sparray'] = print_r($params,true);
           //  echo "<pre>".print_r($params,true)."</pre>";
            // echo "<pre>".print_r($spsql,true)."</pre>";
             
             $data["data_post"] = $data_post;
             if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
                  $where  = array ('c_no' => $this->session->userdata('member_session')['c_no'], 'spkey' => $spkey);            
                  $q_data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);                 
             }else{                 
                  $msconn = $this->front_mssql_model->ms_connect();
                  if ($rid == 14){
                  	 $typetitle = '';
                  	 $ww_q_helpro = $this->front_mssql_model->get_data($msconn,"{CALL ww_q_helpro}",array());
                     if ($ww_q_helpro){
                         foreach ($ww_q_helpro as $item){
                         	    if (trim($item['helno']) == $data_post['type14']){
                         	        $typetitle = trim($item['helna']);
                         	        break;
                         	    }
                         }
                     }
                     
                     $showtitle = '';
                     $data['datatitle'] = '';
                     $data['typetitle'] = $typetitle;
                  }
                  
                  $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
                  
                  if ($this->session->userdata('member_session')['c_no'] == '000000'){
                      $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey));                        
                      $this->db->insert('ap_ms_data', array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey,'data' => json_encode($q_data),'crdt' => date('Y-m-d')));            
                  }   
             }
             if ($q_data){
                 $data['q_data'] = $q_data;   
                 
                 if ($rid == '2' || $rid == '4'){
                     foreach ($data['q_data'] as $key => $rs){
                              $bn_mon = trim($rs["bn_mon"]);
	           	       }
	                   $showtitle = "".$data_post['y'.$rid]."".$data_post['m'.$rid]." - ".$bn_mon." ".$showtitle;	              
                 }         
                      
                 $report_data['bodyhtml'] = '<table width="98%" align=center border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                               <td width="170" align="left" valign="top"><img src="'.base_url('public/images/logo.png').'" alt="台灣安露莎股份有限公司" /></td>
                                               <td width=630><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                               	   <tr><td align=center><b>台灣安露莎股份有限公司</td></tr>
                                               	   <tr><td align=center><b>'.$showtitle.'</td></tr>
                                                   </table></td>
                                              </tr>
                                            </table>';
                                            
                 $report_data['bodyhtml'] .= $this->load->view('report/report_'.$rid, $data,true);
                 
                 $report_data['bodyhtml'] .= '<br>';
                 if ($print == 'N'){
                     $hidden = '';
                     foreach ($data_post as $key => $val){
                          $hidden .= '<input type="hidden" name="'.$key.'" value="'.$val.'">';
                     }                 
                     $report_data['bodyhtml'] .= '<div align="center">
                                               <form name="oForm" id="oForm" method="post" language="javascript" action="'.base_url( 'report/index/'.$rid.'/Y').'" target="_report">
                                               <input type="hidden" name="'.$this->security->get_csrf_token_name().'" id="'.$this->security->get_csrf_token_name().'_report" value="'.$this->security->get_csrf_hash().'">							
                                               '.$hidden.'
                                               <input type="submit" class="btn btn-info" value="列印" onClick="chg_token(\''.$this->security->get_csrf_token_name().'_report\');" >
                                               </form>
                                               </div>';
                 }
             }else{                  
                 $report_data['bodyhtml'] = '<br>&nbsp;&nbsp;<img src="'.base_url('public/images/icon_warning.png').'" alt="台灣安露莎股份有限公司" />無資料！';
             }
        }
        if ($print == 'Y'){
        	  echo '<body onload="window.print()">';
            echo  $report_data['bodyhtml']; 
        }else{
           $this->output->set_content_type('application/json');
           echo json_encode($report_data);
        }
        exit;
    }
	   
}