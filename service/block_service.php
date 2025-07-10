<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Block_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }

    // header
    public function load_html_header($web_page = '')
    {
        $this->load->model( 'front_base_model' );
        
        $data['web_page'] = $web_page;
        $data['prd_menu'] = $this->front_base_model->get_memu_data();       
        return $this->load->view('helper/header', $data, TRUE);
    }
    
    // 販促,生日活動勾選
    public function act($itype,$atype,$actdata)
    {
        $data['itype']   = $itype;
        
        $data['atype']   = $atype;
        
        $data['actdata'] = $actdata;
        
        return $this->load->view('helper/act', $data, TRUE); 
    }
    
    public function load_join_product($p_no,$p_name,$p_price,$unit = '元')
    {
    	  $data['p_no']    = $p_no;
    	  $data['p_name']  = $p_name;
    	  $data['p_price'] = $p_price;
    	  $data['unit']    = $unit;
    	  
        return $this->load->view('member_join/join_product', $data, TRUE); 
    }
    
    public function member_join_modal()
    {
    	 $data = array(); 
    	 return $this->load->view('member_join/modal', $data, TRUE); 
    }
    
    /*分享*/
    public function load_share()
    {
        $data = array();
        
        return $this->load->view('helper/share', $data, TRUE);
    }
    /*車子STEP*/
    public function load_order_step($step)
    {
        
        $data['step'] = $step;       
        return $this->load->view('helper/order_step', $data, TRUE);
    }
    
    // footer
    public function load_html_footer()
    {
        $data = array();
        
        return $this->load->view('helper/footer', $data, TRUE);
    }
    
    public function member_join_pckpro($itype,$jointype,$pckpro,$pagetype = 'M')
    {
    	  $data['jointype'] = $jointype;
    	  $data['pckpro']   = $pckpro;
    	  $data['pagetype'] = $pagetype;
    	  return $this->load->view('member_join/pckpro'.$itype, $data, TRUE);
    }
    
    public function member_join_sumdetail($sumdetail)
    {
    	  $data['sumdetail'] = $sumdetail;
    	  return $this->load->view('member_join/sumdetail', $data, TRUE);
    }   
    
    public function member_join_complete_data($data)
    {
    	  $data['data'] = $data;
    	  return $this->load->view('member_join/complete_data', $data, TRUE);
    }    
    
    // EXCEL 匯出    
    public function excel_download($dtype,$title,$filename,$listdata,$aid,$atitle)
    {
        $excel_row = 0;
        if (strtoupper($dtype) == 'XLSX'){
        	  $this->load->library("PHPExcel");
        	  
        	  $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->setActiveSheetIndex(0);
		        //Set Title
            $objPHPExcel->getActiveSheet()->setTitle($title);
            
            $xnrow = -1;
            foreach ($atitle as $key => $aitem){        
            	  $xnrow++;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key, 1, $aitem);
                // 寬度設定
                $objPHPExcel->getActiveSheet()->getColumnDimension(self::ecellx($key))->setWidth('30');         
                // 垂直居中
                $objPHPExcel->getActiveSheet()->getStyle(self::ecell($key,1))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            
            // 標題底色
            $objPHPExcel->getActiveSheet()->getStyle( 'A1:'.self::ecell($xnrow,1) )->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB ( '00CCD1D1' ); 
            
            if ($listdata){
                $nrow = 1;            
                foreach($listdata as $key1 => $item){                    
                    $nrow++;
                    //依據每個專題的不同，做不同的調整
                    foreach ($aid as $key2 => $aitem){               
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key2, $nrow, $item[$aitem]);         
                       // $objPHPExcel->getActiveSheet()->getStyle(self::ecell($key2,$nrow))->getAlignment( )->setWrapText(true); 可跳行
                    }
                }                            
            }
            
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
        }else{         
            header("Pragma: public"); // required 
            header("Expires: 0"); 
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
            header("Cache-Control: private",false); // required for certain browsers
            header("Content-type:application/vnd.ms-excel ; charset=UTF-8"); 
            header('Content-Disposition:filename="'.$filename.'.xls"'); 
            header("Content-Transfer-Encoding: binary");
            echo '<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=UTF-8">';
            
            $success_cnt = 0;
            
            $dispaly = '<table>';
            
            $dispaly = $dispaly.'<tr>';
            foreach ($atitle as $aitem){        
                $dispaly = $dispaly.('<th style="background-color:yellow;" solid>'.$aitem.'</th>');
            }
            $dispaly = $dispaly.'</tr>';
            
            foreach($listdata as $item){
                $row["ser"]=$excel_row;
                $excel_row += 1;
                $dispaly = $dispaly.'<tr>';
                //依據每個專題的不同，做不同的調整
                foreach ($aid as $aitem){    
                    $dispaly = $dispaly.('<td style="mso-number-format:\@;">'.$item[$aitem].'</td>');
                    $success_cnt++;
                }
                $dispaly = $dispaly.'</tr>';
            }
            
            $dispaly = $dispaly.'</table>';
            echo $dispaly;
        }  
        exit;
    }
    
    
    public function dataset($dtype,$itype,$no_tourl = '')
    { 
        $dataset_data = $this->front_base_model->small_query("select * from ap_dataset where chk = 'Y' and now() between DATE_ADD(stdt,INTERVAL -dh HOUR) and eddt");        
        if ($dataset_data){
        	  $dataset_data = $dataset_data[0];
            $this->session->set_userdata( 'closepaystdt' , $dataset_data['stdt'] );               
            $this->session->set_userdata( 'closepayeddt' , $dataset_data['eddt'] );  
            $stdt = strtotime($dataset_data['stdt']);
            $eddt = strtotime($dataset_data['eddt']);
           
            if (date('d',$eddt) == date('d')){
               if (date('H',$eddt) == 0 && date('i',$eddt) == 0){
                   $sed = "今日 24:00";
               }else{
                   $sed = "今日 ".date('H:i',$eddt);
               }
            }else{
               $sed = date('Y-m-d H:i',$eddt);
            }
            
            $i_title1 = '本月的網路訂購服務';
            $i_title2 = '網路訂購';
            if ($dtype == 'join'){
            	  $i_title1 = '會員登錄服務';
            	  $i_title2 = '會員登錄';
            }
            
            if ($itype == 'login' || $itype == 'form'){            	  
                if (strtotime(date('Y-m-d H:i:s')) < $stdt){
                	   $smes = "通知訊息內容：\\n\\n".$i_title1."截止時間為今日 ".date('H:i',$stdt)." 整，敬請於 ".date('H:i',$stdt)." 前完成".$i_title2."交易手續。";
                	   $smes .= "\\n並且下個月的網路訂購服務於 ".$sed." 開放使用。";
                	   $smes .= "\\n因此 ".date('Y-m-d H:i',$stdt)." ～ ".$sed." 期間的".$i_title2."服務暫時停止。但此期間其它功能使用均不受影響。";                	   
                	   if ($itype == 'login'){  // 警告,但回上頁
                	       alert( $smes );
                	   }else{  // 純警告,還是可以往下走
                	   	   alert( $smes,'N' );
                	   }
                }else{
                	   $smes = "通知訊息內容：\\n\\n".$i_title1."巳過截止時間。並且下個月的".$i_title2."服務於 ".$sed." 開放使用。\\n\\n因此 ".date('Y-m-d H:i',$stdt)."～".$sed." 期間的".$i_title2."服務暫時停止。";
                	   $smes .= "但此期間其它功能使用均不受影響。";
                	   if ($itype == 'login'){
                	   	   alert( $smes );
                	   }else{
                         alert( $smes , $no_tourl);
                         exit;
                     }
                }    
            }else{
            	  if ($stdt <= strtotime(date('Y-m-d H:i:s')) && $eddt >= strtotime(date('Y-m-d H:i:s'))){
            	   	  $smes = "通知訊息內容：\\n\\n".$i_title1."巳過截止時間。並且下個月的".$i_title2."服務於 ".$sed." 開放使用。\\n\\n因此 ".date('Y-m-d H:i',$stdt)."～".$sed." 期間的".$i_title2."服務暫時停止。";
                	  $smes .= "但此期間其它功能使用均不受影響。";
                	  if ($no_tourl > ''){
                	      alert($smes,$no_tourl);
                	  }else{
                	      alert($smes,base_url('order/cart'));
                	  }
                	  exit;
            	  }            	
            } 
        }
    }
    
    public function load_reward_cart($mp)
    {
          ?>
          <div class="row mb-3">   
					  <div class="col-lg-6 px-0 text-center text-md-left py-2">
						  <h5>您的前期紅利為：<span class="text-danger font-weight-bold"><?=number_format($mp)?></span> 點</h5>
					  </div>
					  <div class="col-lg-6 text-center text-md-right justify-content-center py-2">
				       <a href="<?=base_url('reward/index/Y')?>" style="color: #e4024b;">紅利點數兌換說明</a> ｜
				       <a href="<?=base_url('order/cart')?>" style="color: #e4024b;"> 購物車 <span id="show_prd_num2" class="badge badge-danger badge-pill"><?=$this->front_order_model->check_cart_num()?></span></a>
				    </div>
				  </div>
				  <?php
		}		  
				  
    public function admin_right_menu($active = '')
    {
        $data = array(
                  'active' => $active
                );
        
        $data['class_tel']  = $this->front_base_model->get_data('ap_question_prd_set',array('web_sort >' => 0,'line_push' => 'N'),array('web_sort'=>'asc'));        
                
        return $this->load->view('helper/admin_right_menu', $data, TRUE);
    }
    
    public function member_form_menu($qtype)
    {
        $data = array(
                  'qtype' => $qtype
                );
        
        return $this->load->view('helper/form_menu', $data, TRUE);
    }
    
    public function member_sample_menu($qtype)
    {
        
        $data = array(
                  'qtype' => $qtype,
                  'line_push' => 'S'
                );
        
        return $this->load->view('helper/question_menu', $data, TRUE);
    }
    
    // 問卷右側欄
    public function member_question_menu($line_push)
    {
        
        $data = array(
                  'line_push' => $line_push
                );
        
        return $this->load->view('helper/question_menu', $data, TRUE);
    }
    
    // 會員登入後的右邊的MENU
    public function member_right_menu($active = '')
    {
        $data = array(
                  'active' => $active
                );
        
        return $this->load->view('helper/member_right_menu', $data, TRUE);
    }
    
    // 會員登入後右邊的分類
    public function member_right_prdclass()
    {
        $data = array();
        
        return $this->load->view('helper/member_right_prdclass', $data, TRUE);
    }
    
    public function help_menu($active = '')
    {
        $data = array(
                  'active' => $active
                );
        return $this->load->view('helper/help_menu', $data, TRUE);
    }    
    
    // 管理者左側功能
    public function admin_left($admin_type)
    {
        $data['XmlDoc'] = $this->XmlDoc;         
        $data['admin_type'] = $admin_type;     
        
        return $this->load->view('admin/admin_left', $data, TRUE);
    }
    
    public function prd_img($p_no)
    {
        
        $prd_name = "public/prdimages/".$p_no.".png";        
        $dfilename = APPPATH.$prd_name;	
        $dfilename=str_replace("//", "/",$dfilename);            
        if (file_exists($dfilename)){              
            return $prd_name;
        }
        $prd_name = "public/prdimages/s".$p_no.".png";        
        $dfilename = APPPATH.$prd_name;	
        $dfilename=str_replace("//", "/",$dfilename);            
        if (file_exists($dfilename)){              
            return $prd_name;
        }
        return '';
    }
    
    public function html_img_change($body)
    {
        $body=str_replace("/userfiles/image/hadasintan/", base_url("public/images/hadasintan/"),$body);  
        return $body;
    }
    
    public function PF_LoadXmlDoc($XmlFile){
    	
    	$XmlFile = APPPATH."config/".$XmlFile;
    		
    	if (file_exists($XmlFile)){
    	  	$xml=simplexml_load_file($XmlFile) or die ("格式錯誤!");
    		  return $xml;
    	}else{
    		  die($XmlFile."檔案不存在");
    	}    	
    }
    
    public function get_chinese_weekday($datetime)
    {
         $weekday  = date('w', strtotime($datetime));
         $weeklist = array('日', '一', '二', '三', '四', '五', '六');
         return $weeklist[$weekday];
    }
    
    public function admin_select_year($fi)
    {
         $str = "<select name=\"".$fi."\" class=\"form-control\">";
         for ($i = date('Y');$i>=2007;$i--){
              $nselect = "";
              if ($i==date('Y')){
                 	$nselect = " selected";
              }
              $str .= "<option value=\"".$i."\" ".$nselect.">".$i."</option>";
         }
         $str .= "</select>";
         return $str;
    }    
    
    public function admin_select_month($fi)
    {
         $str = "<select name=\"".$fi."\" class=\"form-control\">";
         for ($i = 1;$i<=12;$i++){ 
              $nselect = "";
              if ($i==date('m')){
             	    $nselect = " selected";
              }
              $str .= "<option value=\"".sprintf("%02d",$i)."\" ".$nselect.">".sprintf("%02d",$i)."</option>";
         }
         $str .= "</select>";
         return $str;
    }     
    
    public function admin_select_num($fi,$s,$e)
    {
         $str = "<select name=\"".$fi."\" class=\"form-control\">";
         for ($i = $s;$i<=$e;$i++){ 
              $nselect = "";
              if ($i==1){
             	    $nselect = " selected";
              }
              $str .= "<option value=\"".$i."\" ".$nselect.">".$i."</option>";
         }
         $str .= "</select>";
         return $str;
    }
    
    
    public function PF_SearchXML($XmlDoc, $Note,$ReNote, $Value){
             
    	if ($Value==""){return null;}
    	$cc = '';
    	$ValueTotal = '';
    	$array=explode(",", $Value);
    		try{	
    			
    			for($i=0;$i< count($array);$i++){
    				$xPath=$Note."[.='".$array[$i]."']/parent::*";
    			
    				if (gettype($XmlDoc->xpath($xPath))=="boolean"){			
    					return $Value;
    				}
    				
    				
    				foreach ($XmlDoc->xpath($xPath) as $v) {		
    		
    			        $ValueTotal .=$cc.$v->$ReNote;
    			        $cc=',';
    			     }
    			    
    			    
    		    }
    		    //PF_print($ValueTotal);
    		    if ($ValueTotal==""){$ValueTotal=$Value;}
    		    return $ValueTotal;
    		    
    		} catch (Exception $e) {
                var_dump($e->getMessage());
            }
    
    }
    
    // 功能麵包屑
    public function PJ_PageTitle($XmlDoc,$kind){      
    ?>
         <div class="but_list">
  	         <ol class="breadcrumb">
  	         <li><a href="<?=base_url('wadmin/main')?>">管理平台</a></li><?php  
       	 	  
	 	   foreach ($XmlDoc->xpath("//參數設定檔/權限/選單[@主編號='".substr($kind,0, 1)."']") as $v) {
	 	  	        $MainTitle=$v['主選單名稱'];	 	  	  
	 	   }
	 	   $url = $this->PF_SearchXML($XmlDoc,"//參數設定檔/權限/選單/SND/傳回值","網址", $kind);
	 	   if ($url > '' && $url <> $kind){	 	    
	 	       echo "<li class=\"active\"><a href=\"".base_url('wadmin/'.$url)."\">".$MainTitle."</a></li>";
	 	   }else{
	 	       echo "<li class=\"active\">".$MainTitle."</li>";
	 	   }
	 	   
	 	   $PAGE_NAME=$this->PF_SearchXML($XmlDoc,"//參數設定檔/權限/選單/KIND/傳回值","資料", $kind);
	 	   	 	  
	      if ($PAGE_NAME <> $kind){ ?>  
  	          <li class="active"><?=$PAGE_NAME?></li>
         <?php 
         } ?>
  	         </ol>  	
         </div>   
    <?php
    }
   
    /**
     * 確認 SSO 登入的狀態
     * @params boolean $bool 是否只回傳登入狀態
     * @return mixed
     */
    public function check_login($bool = FALSE)
    {

        $member_session = $this->session->userdata('member_session');
        if ($member_session['mbr_id'] && $member_session['mbr_id'] > 0) {
            return $bool ? TRUE : array(
                'status' => TRUE,
                'data'   => $member_session
            );
        }

        return $bool ? FALSE : array('status' => FALSE);
    }
    
    // 分頁
    public function create_pagination($base_url, $total_rows = 0, $pre_page = 10)
    {

        $this->load->library('pagination');

        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $pre_page;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<div class="pagecenter"><div class="pagination">';
        $config['full_tag_close'] = '</div></div>';

        $config['first_link'] = FALSE;
        $config['first_tag_open'] = '';
        $config['first_tag_close'] = '';

        $config['last_link'] = FALSE;
        $config['last_tag_open'] = '';
        $config['last_tag_close'] = '';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';

        $config['cur_tag_open'] = '<a class="active">';
        $config['cur_tag_close'] = '</a>';

        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

    // error
    public function err404($ci)
    {

        $ci->load->library( 'user_agent' );
        
        $ci->load->library('layout', array('layout' => '../template/layout'));
        
        $platform = ( $ci->agent->is_mobile() ) ? 'MOBILE' : 'DESKTOP';    
        
        $meta['title1'] = '404 | Arsoa 安露莎化粧品';
        $meta['title2'] = '404';
                
        $data = array(
            'meta'         => $meta,
            'platform'     => $platform
        );
        
        $data['js'] = array(
              'err404'
        );
                
         _timer('*** before layout ***');
                                  
        $this->layout->view( 'errors/error_404', $data );
        
    }
    
    // 用戶IP
    public function client_ip()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $temp = explode(',' , $clientIpAddress);
            $clientIpAddress = $temp[0];
        } else {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
                                  
        return $clientIpAddress;        
    }
    //最新文章 大小分類 標籤tag 列表用
    public function list_block($input){
        $data = $input['item'];
        $article_url = $input['article_url'];
        $platform = $input['platform'];
        $imgsrc = $input['imgsrc'];
        $author_data = isset($input['item']['author_data'])?$input['item']['author_data']:array();
        //GA 用
        $ga_cat =         isset($input['ga']['ga_cat'])?        $input['ga']['ga_cat']:'category';
        $ga_action =      isset($input['ga']['ga_action'])?     $input['ga']['ga_action']:'click';
        $ga_img =         isset($input['ga']['ga_img'])?        $input['ga']['ga_img']:'category_imgs';
        $ga_title =       isset($input['ga']['ga_title'])?      $input['ga']['ga_title']:'block_title';
        $ga_description = isset($input['ga']['ga_description'])?$input['ga']['ga_description']:'block_description';
        //搜尋先不顯示作者
        $from =         isset($input['from'])?        $input['from']:'';
        //找作者
        $author_str = '';
        if($from != 'search'){
            if (!empty( $author_data['author'] ) ) {
                for ($i=1;$i<=3;$i++){
                    if (isset($author_data['author'.$i]) &&   $author_data['author'.$i] > ''){
                        $author = explode("&&",$author_data['author'.$i]);
                        if ($i > 1){
                            $author_str .= "、";
                        }
                        $author_url = 'blog';
                        $ga_author = 'blog_';
                        if ($author[1] == '1'){
                            $author_url = 'author';
                            $ga_author = 'author_';
                        }
                        $author_str .= '<a href="'.base_url( $author_url.'/'.$author[0]).'"  onclick="ga(\'send\', \'event\', \''.$ga_cat.'\', \''.$ga_action.'\', \''.$ga_author.$author[0].'\');">'.$author[2].'</a>';
                    }
                }
            }else{
                $author_str = $data['ori_author'];
            }
        }
        //找h2
        preg_match ("/<h2>(.*?)<\/h2>/si",$data['body'],$h2);
        
        if (isset($h2[1]) && $h2[1] > ''){
            $data['h2'] = strip_tags($h2[1]);
        }else{
            $data['h2'] = html2plain_substr( $data['body'], 0, 150 );
        }
        $data['h2'] = str_replace('"','\"',$data['h2']);

        $output = '<div class="col-sm-6 col-md-4 article-list-item">
            <div class="article-list-item__img">
                <a href="'. $article_url.'"  onclick="ga(\'send\', \'event\', \''.$ga_cat.'\', \''.$ga_action.'\', \''.$ga_img.'\');" title="'. $data['topic'].'">
                    <img alt="'.$data['topic'].'"                                            
                                class="lazy img-responsive" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
                                data-original="'.$imgsrc.'"/>
                </a>
            </div>
            <div class="article-list-item__intro">
                <a href="'. $article_url.'"  onclick="ga(\'send\', \'event\', \''.$ga_cat.'\', \''.$ga_action.'\', \''.$ga_title.'\');">
                    <h3>'. web_substr(  $data['topic'], 200, 200 ,$platform).'</h3>
                </a>
                <div class="article-list-item__data">
                    <div class="time">'.date( 'Y-m-d', strtotime( $data['starttime_m'] ) ).'</div>';
        if($from != 'search'){
            $output .='<div class="author">文 / '.$author_str.'</div>';
        }
        $output .= '</div>
                <a href="'. $article_url.'"  onclick="ga(\'send\', \'event\', \''.$ga_cat.'\', \''.$ga_action.'\', \''.$ga_description.'\');">
                    <p class="article-list-item__summary">'. $data['h2'] .'</p>
                </a>
            </div>
        </div>';
        return $output;
    }
    
    //截取字串 原字串,前字串,後字串,是否需加原字串
    public function PF_GetStr($str,$g1,$g2,$flag){
                   if ($str!=""){
                       if ($g1==""){
                           $instr1=0;
                       }else{
                           $instr1=strpos ($str, $g1)+strlen($g1);
                       }
                        /*
                                PF_print("instr1=".$instr1);

                                PF_print("g1=".htmlspecialchars($g1));

                                PF_print("g2=".htmlspecialchars($g2));                   

                        */    
                        if ($g2!=''){
                              if ($g1!=""){
                                  $instr2=strpos($str, $g2,$instr1)-strpos($str, $g1)-strlen($g1);
                              }else{
                                  $instr2=strpos($str, $g2,$instr1)-strlen($g1);
                              }
                        }else{
                              $instr2=strlen($str);
                        }
                        if ($instr2>0) {
                              $result = substr($str, $instr1,$instr2);
                              if ($result!=""){
                                  if ($flag=='1'){
                                      $GLOBALS["str"]=substr($str, $instr1+strlen($result),strlen($str));
                                  }
                                  return $result;
                              }
                        }
                 }      
    }
    
    public function PF_ReadFile($filename){
       
        $filename = APPPATH.$filename;
        
        if (file_exists($filename)==false){
	        	echo "Cannot open file ($filename)";
	     	   exit;
	     }
	     
	     $handle = fopen ($filename, "rb");	     
	     $contents = "";
	     while (!feof($handle)) {
	        $contents .= fread($handle, 8192);
	     }
	     fclose($handle);
	     
	     return $contents;
    }
    
    public function PF_WriteFile($filename,$Body){
	
		       $filename=APPPATH.$filename;
		       if (file_exists($filename)==false){
		       	  if ($fp = fopen($filename, "w")){ //Creates blank file
           				@fputs($fp, $Body); //Fills the file with content
           				@fclose($fp); //Closes the file
           			}
		       }else{
		       	if (is_writable($filename)) {		
		       	    if (!$handle = fopen($filename, 'w+')) {
		       	         echo "Cannot open file ($filename)";
		       	         exit;
		       	    }	
		       	    fputs($handle , stripslashes($Body) ) ;
		       	    
		       	    fclose($handle);		
		       	} else {
		       	    echo "The file $filename is not writable";
		       	}
		       }	
    }
    
    public function PJ_ToUrlPageNew($PageForm,$Pages,$Page,$PageCount,$Recordcount){
	
          	echo "<input name=\"Submit\" type=\"submit\" value=\"Submit\" style=\"display:none;\">";
          	echo "<input type=hidden name=\"Page\">\n";
          	echo "<table align=center><tr><td>";
          	$ShowPage = $Pages;
          	$Temp = intval(($Page-1)/$ShowPage) + 1;
          	
          	//echo "<br class=\"clear\">";
          	echo "頁數：".$Page." / ".$PageCount."　總筆數： ".$Recordcount."";
          	echo "</td><td width=15></td><td align=center>";
            echo "<div id=\"pagination\"><ul class=\"pagination\">";
                
          	$BackPage = ($Temp-1)*$ShowPage;
          	$NextPage = $Temp*$ShowPage+1;
          				
            if ($PageCount>=$Page && $Page<>1){
          	    echo "<li><a href=\"javascript:void(0);\" onclick=\"javascript:".$PageForm.".Page.value=".($Page-1).";".$PageForm.".submit();\" />&lt;</a></li>";
          	}else{
          	    echo "<li class=\"disabled\"><a href=\"javascript:void(0);\">&lt;</a></li>";
          	}
          	
          	$Temp = ceil($ShowPage / 2); // 當前頁前後顯示的頁碼數量

            $startPage = max(1, $Page - $Temp);
            $endPage = min($startPage + $ShowPage - 1, $PageCount);
            
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($Page == $i) {
                    echo "<li class=\"active\"><a href=\"javascript:void(0);\">$i</a></li>";
                } else {
                    echo "<li><a href=\"javascript:void(0);\" onclick=\"javascript:".$PageForm.".Page.value=".$i.";".$PageForm.".submit();\">$i</a></li>";
                }
            }
          			          	
          	if ($PageCount>$Page){
          	    echo "<li><a href=\"javascript:void(0);\" onclick=\"javascript:".$PageForm.".Page.value=".($Page+1).";".$PageForm.".submit();\" />&gt;</a></li>";
          	}else{
          	    echo "<li class=\"disabled\"><a href=\"javascript:void(0);\">&gt;</a></li>";
          	}
          	
              echo "</ul>";
              echo "</div>";
              echo "</td></tr></table>";
    
    
    }
    
    public function PJ_ToUrlPage($PageForm,$Pages,$Page,$PageCount,$Recordcount){
	
          	echo "<input name=\"Submit\" type=\"submit\" value=\"Submit\" style=\"display:none;\">";
          	echo "<input type=hidden name=\"Page\">\n";
          	echo "<nav aria-label=\"...\">";
          	$ShowPage = $Pages;
          	$Temp = intval(($Page-1)/$ShowPage) + 1;
          	
          	//echo "<br class=\"clear\">";
          	//echo "頁數：".$Page." / ".$PageCount."　總筆數： ".$Recordcount."";
          	//echo "</td><td width=15></td><td align=center>";
            echo "<ul class=\"pagination\">";
                
          	$BackPage = ($Temp-1)*$ShowPage;
          	$NextPage = $Temp*$ShowPage+1;
          				
            if ($PageCount>=$Page && $Page<>1){
          	    echo "<li><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($Page-1).";".$PageForm.".submit();\" />&lt;</a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"javascript:void(0);\">&lt;</a></li>";
          	}
          			    
              for ($I = ($Temp - 1) * $ShowPage ; $I < ($Temp * $ShowPage ); $I++ ){					     			 	
          	    if ($Page == $I+1){		
          	    	      echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:void(0);\">".($I+1)."</a></li>";
          	    }else{
          	        if ($I==($Page-1)){
          		          echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:void(0);\">".($I+1)."</a></li>";
          	        }else{
          	        	  echo "<li><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($I+1).";".$PageForm.".submit();\" />". ($I+1) ."</a></li>";
          	        }					
          	    }				 
          	    if (($I+1) >= $PageCount){break;}
          	}
          	
          	
          	if ($PageCount>$Page){
          	    echo "<li><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($Page+1).";".$PageForm.".submit();\" />&gt;</a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"javascript:void(0);\">&gt;</a></li>";
          	}
          	
              echo "</ul>";
              echo "</nav>";
            //  echo "</td></tr></table>";
    
    
    }
    
      public function PJ_ToUrlPageUrl($PageUrl,$Pages,$Page,$PageCount,$Recordcount){
	
          	
          	echo "<nav aria-label=\"...\">";
          	$ShowPage = $Pages;
          	$Temp = intval(($Page-1)/$ShowPage) + 1;
          	
          	//echo "<br class=\"clear\">";
          	//echo "頁數：".$Page." / ".$PageCount."　總筆數： ".$Recordcount."";
          	//echo "</td><td width=15></td><td align=center>";
            echo "<ul class=\"pagination\">";
                
          	$BackPage = ($Temp-1)*$ShowPage;
          	$NextPage = $Temp*$ShowPage+1;
          				
            if ($PageCount>=$Page && $Page<>1){
          	    echo "<li><a href=\"".$PageUrl."".($Page-1)."\" class=\"page-link\" />上一頁</a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"javascript:void(0);\">上一頁</a></li>";
          	}
          			    
            for ($I = ($Temp - 1) * $ShowPage ; $I < ($Temp * $ShowPage ); $I++ ){					     			 	
          	    if ($Page == $I+1){		
          	    	      echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:void(0);\">".($I+1)."</a></li>";
          	    }else{
          	        if ($I==($Page-1)){
          		          echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"javascript:void(0);\">".($I+1)."</a></li>";
          	        }else{
          	        	  echo "<li><a href=\"".$PageUrl."".($I+1)."\" class=\"page-link\" />". ($I+1) ."</a></li>";
          	        }					
          	    }				 
          	    if (($I+1) >= $PageCount){break;}
          	}
          	
          	
          	if ($PageCount>$Page){
          	    echo "<li><a href=\"".$PageUrl."".($Page+1)."\" class=\"page-link\" />下一頁</a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"javascript:void(0);\">下一頁</a></li>";
          	}
          	
              echo "</ul>";
              echo "</nav>";
    
    
    }
    
    public function PJ_ToPageNew($PageForm,$Pages,$Page,$PageCount,$Recordcount)
    {
	         echo "<input name=\"Submit\" type=\"submit\" value=\"Submit\" style=\"display:none;\">";
          	echo "<input type=hidden name=\"Page\">\n";
          	
          	echo '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
          	$ShowPage = $Pages;
          	$Temp = intval(($Page-1)/$ShowPage) + 1;
          	          	    
          	$BackPage = ($Temp-1)*$ShowPage;
          	$NextPage = $Temp*$ShowPage+1;
          				
            if ($PageCount>=$Page && $Page<>1){
          	    echo "<li class=\"page-item\"><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($Page-1).";".$PageForm.".submit();\" /><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a href=\"javascript:void(0);\" class=\"page-link\"><span aria-hidden='true'>&laquo;</span><span class='sr-only'>Previous</span></a></li>";
          	}
          			    
              for ($I = ($Temp - 1) * $ShowPage ; $I < ($Temp * $ShowPage ); $I++ ){					     			 	
          	    if ($Page == $I+1){		
          	    	      echo "<li class=\"page-item active\"><a href=\"javascript:void(0);\" class=\"page-link\">".($I+1)."</a></li>";
          	    }else{
          	        if ($I==($Page-1)){
          		          echo "<li class=\"page-item active\"><a href=\"javascript:void(0);\" class=\"page-link\">".($I+1)."</a></li>";
          	        }else{
          	        	  echo "<li class=\"page-item\"><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($I+1).";".$PageForm.".submit();\" />". ($I+1) ."</a></li>";
          	        }					
          	    }				 
          	    if (($I+1) >= $PageCount){break;}
          	}
          	
          	
          	if ($PageCount>$Page){
          	    echo "<li class=\"page-item\"><a href=\"javascript:void(0);\" class=\"page-link\" onclick=\"javascript:".$PageForm.".Page.value=".($Page+1).";".$PageForm.".submit();\" /><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
          	}else{
          	    echo "<li class=\"page-item disabled\"><a href=\"javascript:void(0);\" class=\"page-link\"><span aria-hidden='true'>&raquo;</span><span class='sr-only'>Next</span></a></li>";
          	}
          	
              echo "</ul></nav>";
    
    }
    
    
public function PF_findSplit($SplitValue,$CompareValue){
		
	if (isset($CompareValue)==false || isset($SplitValue)==false){
		  return false;
	}
	
	$tmpValue = explode(",",$SplitValue);		
	for($i=0;$i< count($tmpValue);$i++){	  
	          if (is_array($CompareValue)){
	              for($j=0;$j< count($CompareValue);$j++){
	                  if (substr_count($CompareValue[$j],$tmpValue[$i])>0) {
       	    	          return true;       	
                    }  
	              }
	          }else{
       	    if (substr_count($CompareValue,$tmpValue[$i])>0) {
       	    	  return true;       	
            }     
          }   
	}
}   
    
// 網址 求出 youtube ID 20160913
public function Get_youtube_id($mvurl,$itype = 'I'){   
  $img = '';$ichk = false;                                          
  if ($mvurl > ''){      
      if ($this->PF_findSplit("youtube",$mvurl) || $this->PF_findSplit("youtue",$mvurl)){  
          $murl = str_replace("?","&",$mvurl);
          parse_str($murl,$myArray);
          $v = $myArray["v"];
          $ichk = true;
      }else{          
          if ($this->PF_findSplit("youtu",$mvurl)){  
              $v = str_replace("https://youtu.be/","",$mvurl);
              $v = str_replace("http://youtu.be/","",$v);                      
              $ichk = true;                                        
          }
      }
      if ($ichk && mb_strlen($v,"Big5") == strlen($v) && strlen($v) < 50) {
          if ($itype == 'I'){
              $img = "http://i.ytimg.com/vi/".$v."/0.jpg";
          }else{
              $img = $v;
          }
      }
  }
  return $img; 
} 

// 網址 求出 ID 
public function Get_vimeo_id($mvurl){   
    $img = '';                            
  if ($mvurl > ''){      
       $url = parse_url($mvurl);               
       if ($url['path'] > ''){ 
           $img = str_replace("/video/","",$url['path']);           
       } 
  }
  return $img; 
} 

    
    public function PM_listtitle($Xmlspec){
	
		       $xPath="//table/Field[@list='Y']";
		       $v=$Xmlspec->xpath($xPath);
		       for($i=0;$i< count($v);$i++){			
		          	switch ($v[$i]['type']){
		       			   case "date":
		       			   case "int":
		           	?>
		       	    <th id="<?php echo $v[$i]['name']?>"  ><?php echo $v[$i]['title']?></th>
		          	<?php
		       				  break;
		       			   default:
		       	    ?>
		           	<th width=""   id="<?php echo $v[$i]['name']?>" ><?php echo $v[$i]['title']?></th>
		          	<?php
		        	}
		       }
    }
    
    public function PM_Modify($Xmlspec,$pmdata){        
	         
	         $xPath="//table/Field[@edit='Y']";
	         $v=$Xmlspec->xpath($xPath);
	         for ($i=0;$i< count($v);$i++){
		            $Field  = strval($v[$i]['name']);	
		            $title  = strval($v[$i]['title']);
		            $color  = strval($v[$i]['color']);		            
		            $set    = strval($v[$i]['Set']);		 
		            $Value  = '';		
		     
		            if (isset($pmdata[strval($Field)])){
		                $Value = $pmdata[strval($Field)];		  
		            }
		           
?>
<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><?php if (strval($v[$i]['必填'])=="Y"){?><font class=DMIn>*</font>&nbsp;<?php }?>
            <?php echo strval($v[$i]['title'])?>：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
<?php
        switch (strtolower($v[$i]['method'])){
                case "selectitemclass":            	      
            	       $UI =new UIDbForm;
                      $UI->Name=$Field;
                      $UI->conn=$conn;
                      $UI->Type="SELECT";
                      $UI->SQL="select classid,classtitle from ap_itemclass where classtype = '".strval($v[$i]['tablekey'])."' order by classsort";
                      $UI->Value=$Value;
                      $UI->class="form-control";
                      $UI->CreateHtml(); 
            	      break;               
        			 case "uiupload":             			    			    
        			       $params = array(
			  	                  'Folder' => strval($v[$i]['上傳目錄']), 
			  	                  'Name'   => $Field,
			  	                  'FileName' => $Value,
			  	                  'Width'   => strval($v[$i]['Width']),
			  	                  'Height'   => strval($v[$i]['Height'])
			  	                  );			  	                			  	            
                      $this->ui->UIUpLoadfile($params);      
                      ?>
			             <p class="help-block">尺寸為<font color=red><?php echo strval($v[$i]['Width'])?>X<?php echo strval($v[$i]['Height'])?></font>，
			                檔案格式限 <?php echo "<font color=red>".strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit))."</font>";?>，大小不得超過 
			                <font color=red><?=FC_FileSize?></font> KB</p>			
                      <?php           
                      break;  
                case "uifile":                       
                      if (!isset($v[$i]['Size'])){                          
                          $Size = $this->config->item('FC_FileSize');                          
                      }else{
                          $Size = strval($v[$i]['Size']); 
                      }
                      if (!isset($v[$i]['FileLimit'])){
                          $FileLimit = $this->config->item('FC_FileLimit');                          
                      }else{
                          $FileLimit = strval($v[$i]['FileLimit']);               
                      }
                    
        			        $params = array(
			  	                  'Folder'     => 'func', 
			  	                  //'Folder'       => strval($v[$i]['上傳目錄']), 
			  	                  'Name'         => $Field,
			  	                  'FileName'     => $Value,
			  	                  'Size'         => $Size,
			  	                  'FileLimit'    => $FileLimit
			  	                  );
			  	               
			  	            if (isset($pmdata[strval($Field)."_name"])){
		                      $params['FileName_old'] = $pmdata[strval($Field)."_name"];		  
		                  }  	  
		                  if (isset($pmdata["id"])){
		                      $params['Id'] = $pmdata["id"];		  
		                  }  	  
                      $this->ui->UIUpLoadfile($params);                                                         
                      ?><p class="help-block">
			                檔案格式限 <?php echo "<font color=red>".strtoupper(strval($v[$i]['FileLimit']))."</font>";?>，大小不得超過 
			                <font color=red><?=strval($v[$i]['Size'])?></font> KB</p>			
                      <?php           
                      break;  
                case "pj_upload":	
?>
<input name="<?php echo $Field?>" type="file" size=40 />
<?php
$UI =new DisplayObject;
$UI->Folder=strval($v[$i]['上傳目錄']);
$UI->FileName=$Value;
$UI->Width=100;
//$UI->Height="100";
$UI->CreateHtml();
if (isset($v[$i]['Width'])){
?>			
			<BR>尺寸為<?php echo strval($v[$i]['Width'])?>X<?php echo strval($v[$i]['Height'])?>pixels，檔案格式限GIF或JPG，大小不得超過 800 KB
			
<?php
}
           	          break;  
            case "pj_inputdate":  //年-月-日
                      $params = array(
			  	                        'TheDateField' => $Field, 
			  	                        'TheDateValue' => $Value
			  	                        );			  	                
                      $this->ui->PJ_JInputDate('date',$params);               
                      break;
					  case "pj_inputdatetime":  //年-月-日 時:分:秒
					            $params = array(
			  	                        'TheDateField' => $Field, 
			  	                        'TheDateValue' => $Value
			  	                        );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);               
					            break;  
            case "checkbox":
                      $checked = "";
                      if ($Value == "Y"){
                 	        $checked = " checked";
                      }
?>
<input type="checkbox" name="<?php echo $Field?>" value="Y" <?php echo $checked?>>
<?php            
          		break;  
                 case "UIUpLoad":

			$UI =new UIUpLoad;
			$UI->Folder=strval($v[$i]['上傳目錄']);
			$UI->Name=$Field;
			$UI->FileName=$Value;
			$UI->Width=$v[$i]['Width'];
			$UI->Height=$v[$i]['Height'];
			$UI->CreateHtml();
					
			
			
          		break;            		
                 case "htmlbody":
                 case "textarea":
                 
                 $th = $v[$i]['height'];
                 if ($th == ''){
                    $th = 10;
                 }
                 $tw = $v[$i]['width'];
                 if ($tw == ''){
                    $tw = 50;
                 }
?>
<textarea name="<?php echo $Field?>" cols="<?php echo $tw?>" rows="<?php echo $th?>" id="<?php echo $Field?>"  class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $Value?></textarea>
<?php                 
			  	break;
			  	case "int":
?>
<input type="text" class="form-control" data-placement="bottom" style="width:180px" class="form-control" name="<?php echo $Field?>" value="<?php echo htmlspecialchars($Value)?>" size="10" maxlength="10" >
<?php
			  	
			  	break;
			  	case "tags":
			  	     $params = array(
			  	                 'Name' => $Field, 
			  	                 'Value' => $Value
			  	                 );			  	                
               $this->ui->PJ_tags($params);               
					     break;
			  	case "xml":			  	     
			  	     $params = array(
			  	           'Name' => $Field, 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> strval($v[$i]['methodtype']),
			  	           'Node'=> "//參數設定檔/".$title."/KIND"
			  	           );			  	           
			  	     if (isset($Value) && $Value > ''){			  	         
			  	         $params['Value'] = $Value;
			  	     }else{			  	         			  	         
			  	         if ($set > ''){
			  	             $params['Value'] = $set; 
			  	         }else{    
			  	             $params['Value'] = '';
			  	         }
			  	     }   
               if (isset($v[$i]['Class'])){
                   $params['Class'] = strval($v[$i]['Class']);
               }
               if (isset($v[$i]['Onclick'])){
                   $params['Onclick'] = strval($v[$i]['Onclick']);
               }
               $this->ui->xmlform($params);
 			         break;			  	
			    case "html":
			  	 	    ?>
			  	 	    <script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
			  	 	    <textarea name="<?=$Field?>" id="<?=$Field?>" style="width:100%" rows="30"
			  	 	       class="form-control1"><?php if (isset($Value)){ echo $Value; }?></textarea>
                <script>
                   CKEDITOR.replace('<?=$Field?>' ,{
		                filebrowserImageBrowseUrl : '<?php echo base_url('assets/filemanager/index.html');?>'
	                });
                </script>
			  	 	    <?php
 			        	break;
          default:
                if ($v[$i]['maxlength'] > ""){
                    $maxstr = " maxlength=\"".strval($v[$i]['maxlength'])."\"";                    
                }                
                $sizestr = " size=\"50\"";                    
                if ($v[$i]['size'] > ""){
                    $sizestr = " size=\"".strval($v[$i]['size'])."\"";                    
                }
                $stylestr = "";                    
                if ($v[$i]['size'] > ""){
                    $stylestr = " style=\"width:".strval($v[$i]['size'])."px\"";                    
                }
?>
<input type="text" class="form-control" data-placement="bottom" name="<?php echo $Field?>" value="<?php echo htmlspecialchars($Value)?>" <?php echo $maxstr?> <?php echo $sizestr?><?php echo $stylestr?>>
<?php                
                     break;			         
         }           
?>
</div>		<?php
    echo '<div class="col-sm-6 jlkdfj1">';
		echo strval($v[$i]['Memo']);
		echo '</div>';
?>
			</div>
		</div>		
<?php
	}
}

public function PM_onsubmit($Xmlspec){	
  
		$xPath="//table/Field[@必填='Y']";
		$v=$Xmlspec->xpath($xPath);
		for($i=0;$i< count($v);$i++){			
			  $Field=$v[$i]['name'];	
			  $method=$v[$i]['method'];	
			  switch (strtolower($v[$i]['type'])){		
			  		   case "int":
			              ?>
                    if (PF_FormMulti('1','INT',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){return false;}
                    <?php
			  			      break;
			  		   case "float":
			              ?>
                    if (PF_FormMulti('1','FLOAT',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){return false;}
                    <?php
			  			      break;												
			  		   case "date":
			              ?>
                    if (PF_FormMulti('1','DATE',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){return false;}
                    <?php
			  			      break;
			  			 case "datetime":
			              ?>
                    if (PF_FormMulti('1','DATETIME',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){return false;}
                    <?php
			  			      break;    
			  		   default:
			  		        if ($method == 'uiupload' || $method == 'uifile'){		
			  		            if (isset($v[$i]['FileLimit']) && $v[$i]['FileLimit'] > ''){
			  		                $FC_ImgLimit = $v[$i]['FileLimit'];
			  		            }else{
			  		                $FC_ImgLimit = FC_ImgLimit;
			  		            }
                    ?>
                        if (form.<?php echo $Field?>_old.value.length > 0 && form.<?php echo $Field?>_del.value != 'Y'){			  		              
			  		            }else{
                            if (PF_FormMulti('1','TEXT',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){
                                return false;
                            }else{
                                if (PF_CheckFileType('<?=$FC_ImgLimit?>',form.<?php echo $Field?>)==false){
                                    alert('檔案格式有問題！');
                                    return false;
                                }                            
                            } 
                        }
                   <?php					        
			  		       }else{					   
			             ?>
                         if (PF_FormMulti('1','TEXT',form.<?php echo $Field?>,'<?php echo $v[$i]['title']?>')==false){return false;}
			             <?php
			             }
			  }
		}
		
		$xPath="//table/Field[@必填='N']";
		$v=$Xmlspec->xpath($xPath);
		for($i=0;$i< count($v);$i++){			
			  $Field=$v[$i]['name'];	
			  $method=$v[$i]['method'];	
			  if ($method == 'uiupload'){			?>      			      
			       if (form.<?php echo $Field?>.value.length > 0){
			           if (PF_CheckFileType('<?=FC_ImgLimit?>',form.<?php echo $Field?>)==false){
                      alert('檔案格式有問題！');
                      return false;
                 }      
             }
             <?php
			  }
	  }
			    
}

     public function PF_delfile($filename){
            if (substr_count($filename,".")==0) {return false;}
            $dfilename=APPPATH.$filename;	
            $dfilename=str_replace("//", "/",$dfilename);            
            if (file_exists($dfilename)){              
                unlink($dfilename);    
                /* 刪除小圖 */
                $ori_filename = basename($filename);
                foreach (FC_delimg as $key => $item){
                     $afilename = APPPATH.upload_folder."thumb/".$item."_".$ori_filename;
                     if (file_exists($afilename)){    
                         unlink($afilename);   
                     }
                }         
                /* 刪除小圖 */
            }
     }
     
     
     public function PF_Upload($UploadPath,$FileNameMethod,$FileLimit,$params = array()){
		        
		        $fileinfo = array();
		        $UploadPath=iconv("utf-8","big5",str_replace("\\", "/",$UploadPath));
		        if (substr($UploadPath, -1)!="/"){$UploadPath.="/";}						
		        
		        $APP_path = APPPATH.upload_folder;
             
		        if (file_exists($APP_path.$UploadPath)==false){
			          mkdir ($APP_path.$UploadPath, 777);
		        }		
		        if(@chmod($APP_path.$UploadPath,0777)){ 		
		        }	
		        if (is_writeable($APP_path.$UploadPath)==false){
		            $refer = base_url('wadmin/main');
		            alert( "上傳目錄異常![".$UploadPath."]", $refer );				        
				        exit;
		        }	  
		        
		        foreach ($_FILES as $Field => $v){	
		                	if ($_FILES[$Field]["size"]){
		                	    $fileinfo[$Field] = $v;   		                	 
		                	    // 擷取副檔名   
		                			$file_Sname = strtolower(substr($_FILES[$Field]['name'], strrpos($_FILES[$Field]['name'] , ".")+1));
		                			$fileinfo[$Field]['ext']     = $file_Sname;
		                			$error = '';
                          if ($this->PF_SplitCompare($FileLimit,$file_Sname)==false){		                				  
		                				  $error = "格式不符，請重新上傳！";
		                			}			
		                			
		                			if  ($_FILES[$Field]["size"] > (FC_FileSize*1024)){
		                				   $error = "檔案太大，請縮圖再上傳！";
		                			}			
		                			$fileinfo[$Field]['old_name'] = $_FILES[$Field]["name"];
		                			if ($_FILES[$Field]["error"] > 0){
		                			    $fileinfo[$Field]['error'] = "檔案上傳有誤(".$_FILES[$Field]["error"].")！";
		                			}else{
		                			    if ($error > ''){
		                			         $fileinfo[$Field]['error']     = $error;
		                			    }else{
		                			         $file_Mname = $_FILES[$Field]["name"];		                			    
		                			         
		                			         $file_name = $file_Mname;
		                			         if ($FileNameMethod){		                			    	  
		                			         	   $file_Mname = date("YmdHis").floor(intval(microtime())*1000).generatorPassword(3);		                					         
		                					         // 產生新的檔名
		                					         $file_name = $file_Mname . "." . $file_Sname;
		                				       }		                			         
		                			         
		                			         move_uploaded_file($_FILES[$Field]['tmp_name'], $APP_path.$UploadPath.$file_name);
		                			         		                			         
		                				       if (isset($params["img_width"]) || isset($params["img_height"])){
		                				           $this->load->library('ui');		                				           
		                				           $ooimg = upload_folder.$UploadPath.$file_name;
		                				           $resizeimage = $this->ui->resizeimage($ooimg,"","",$params['img_width'],$params['img_height'],0,0);
		                				       }
		                			         
		                			         $fileinfo[$Field]['name']     = $file_name;
		                			         $fileinfo[$Field]['path']     = $APP_path.$UploadPath;		                			      
		                			     }
		                			 }
 		                	}
        	}
        	return $fileinfo;
     }		
     
     
     //PF_SplitCompare(大量值,單一值)
     public function PF_SplitCompare($SplitValue,$CompareValue){
     		
     	
     	if (isset($CompareValue)==false || isset($SplitValue)==false){
     		return false;
     	}
     	
     	$CompareValue=strtolower($CompareValue);
     	$SplitValue=strtolower($SplitValue);
     
     	$SplitValue=str_replace(";",",",$SplitValue);
     	$CompareValue=str_replace(";",",",$CompareValue);
     	
     	$CompareValuesplit=explode(",",$CompareValue);	
     	$SplitValuesplit = explode(",",$SplitValue);	
     	
     	for($x=0;$x< count($CompareValuesplit);$x++){			
     		if (in_array($CompareValuesplit[$x],$SplitValuesplit)) {		
     	       		return true;
     	     }
     	}
     		return false;
     }
      
     public function PM_list($Xmlspec,$rs){
     	
     		$xPath="//table/Field[@list='Y']";
     		$v=$Xmlspec->xpath($xPath);
     		for($i=0;$i< count($v);$i++){			
     			$Field=$v[$i]['name'];
     			switch (strtolower($v[$i]['method'])){
     			        case "selectitemclass":
     			              echo "<td>";
     			              echo $this->PF_itemclass($rs[strval($Field)]);
     			              echo "</td>";
     			              break;					   
     					case "xml": 
     			              echo "<td>".$this->PF_SearchXML($this->XmlDoc,"//參數設定檔/".$v[$i]['title']."/KIND/傳回值","資料",$rs[strval($Field)])."</td>";                       
     					      break;
     					case "uiupload": 
     					          echo "<td>";
     					          if ($v[$i]['gif'] == 'Y'){					              
     					              $link = "../../../".upload_folder."".$v[$i]['上傳目錄']."/".$rs[strval($Field)];					              
     					              $filename = APPPATH."".upload_folder.$v[$i]['上傳目錄']."/".$rs[strval($Field)];			
     					              if (file_exists($filename)){		                            
     					                  echo "<a class=\"group3w\" href=\"".$link."\">";    	                  
         	                      $uiparams = array(
         	                                   'Folder'   => 'func',
         	                                   'FileName' => $rs[strval($Field)],
         	                                   'Style'    => "width: 300px;height:auto",
         	                                   'Width'    => 300
         	                                 );    	                          
                                 $this->ui->DisplayObject($uiparams);    	               
         	                      echo "</a>";
     					              }else{
     					                 echo $rs[strval($Field)]; 
     					              }
     			              }else{
     			                  echo $rs[strval($Field)]; 
     			              }              
     			              echo "</td>";
     					      break;
     					case "text":
     						     switch (strtolower($v[$i]['type'])){
     								   case "int":			           
     			                echo "<td>".$this->PF_FN($rs[strval($Field)],0)."</td>";								
     							        break;
     							   case "date":								
     							        echo "<td>".$this->PF_FD($rs[strval($Field)])."</td>";								
     							        break;
     						       default:								
     						            echo "<td>".$rs[strval($Field)]."</td>";																
     					     }						
     					     break;
     			        case "checkbox":			
     			              echo "<td>".$this->PF_SearchXML($this->XmlDoc,"//參數設定檔/".$v[$i]['title']."/KIND/傳回值","資料",$rs[strval($Field)])."</td>";			                
     			              break;
     			        case "int":
     			              echo "<td>".$this->PF_FN($rs[strval($Field)],0)."</td>";			
     			              break;
     			        case "pj_inputdate";
     			              echo "<td>".$this->PF_FD($rs[strval($Field)])."</td>";			
     			              break;
     			        default:
     			              echo "<td>".$rs[strval($Field)]."</td>";			
     			 }
     		}
     }   
     public function PF_FN($v1,$v2 = 0){
     	return number_format($v1,$v2);
     }
     
     public function PF_FD($D){
     	
     	if ($this->PF_IsDate($D)){ 
     		
      		return date("Y-m-d" , strtotime(date($D))); 
     	}
     }
     
     public function PF_FDT($D){
     	
     	if ($this->PF_IsDate($D)){ 
     		
      		return date("Y-m-d H:i:s" , strtotime(date($D))); 
     	}
     }

	   public function PF_Vbcrlf($v){
	          return str_replace( chr(13).chr(10), "<br>", $v );
     }

     public function PF_IsDate($v){
		        return preg_match("/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/",$v);	
     } 
     
     public function page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $db = $this->db;        
        $db->from( $table.' a' );        
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $db->where_in( $key, $val );
                } else {
                    $db->where( $key, $val );
                }
            }
        }
        if ( is_array( $like ) && sizeof( $like ) > 0 ) {
                $this->db->group_start();
                foreach ( $like as $key => $val ) {
                    $db->or_like( $key, $val );
                }
                $this->db->group_end();
        }
        
        $db1 = clone $db;
        $db1->select( 'count(*) as cnt' );         
        
        $query = $db1->get();
        $row = $query->row_array();
        $query->free_result();
        $total = $row['cnt'];
        
        $PageCount = ceil($total/$PageSize);
        
        $Page = ($PageCount > $Page) ? $Page : $PageCount;  /* 當所要的頁數大於總頁數,就提供總頁數即可 */
                
        if ($Page==0){$Page=1;}
			  $sysPageCut=ceil(($Page-1)*$PageSize); 
					        
        $db->select( 'a.* ' );                        
        //if ( is_array( $limit ) && sizeof( $limit ) == 2 ) {
            $db->limit( $PageSize, $sysPageCut );
        //}
        if ( is_array( $order_by ) ) {
            foreach ( $order_by as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $db->order_by( $val );
                } else {
                    $db->order_by( $key, $val );
                }
            }
        }
        $query = $db->get();
        $rows = $query->result_array();
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
    
    //可使用身份(如果有KEY代表要檢查身份),是否強制,權限號碼
    public function PF_Limit($CanUseStatus){
      		       
		       $admin_session = $this->session->userdata('admin_session');				       
		       if ($admin_session['admin_status']=="999"){
               $GLOBALS['ModifyStatus'] = true;                     
               return null;
           }
		       if ($admin_session['admin_status'] >= $CanUseStatus){
               $GLOBALS['ModifyStatus'] = true;                     
               return null;
           }
    }
    
    public function downfilephp($dfile,$rfile){
      $dfile =  trim($dfile);
      $file_extension = strtolower(substr(strrchr($dfile,"."),1));
     
      //將檔案格式設定為將要下載的檔案
      switch( $file_extension ) {
      case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "obj": $ctype="application/obj"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      case "mp3": $ctype="audio/mpeg"; break;
      case "wav": $ctype="audio/x-wav"; break;
      case "mpeg":
      case "mpg":
      case "mpe": $ctype="video/mpeg"; break;
      case "mov": $ctype="video/quicktime"; break;
      case "avi": $ctype="video/x-msvideo"; break;
      //禁止下面幾種類型的檔案被下載
      case "php":
      case "htm":
      case "xml":
      case "html":
      case "txt": die("Cannot be used for ". $file_extension ." files!"); break;      
      default: $ctype="application/force-download";
      }
             
      $handle = fopen(APPPATH.upload_folder.$dfile, "r");           
      
      if ($handle) {         
       //   ini_set("output_buffering",40960);
          
          //開始編寫header
          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Cache-Control: public");
          header("Content-Description: File Transfer");
          
          //使用利用 switch判別的檔案類型
          header("Content-Type: ".$ctype."");
          header("Content-Disposition: attachment; filename=".iconv("UTF-8","Big5",$rfile)."");
          $contents = '';
          
          while (!feof($handle)) {
              $contents = fgets($handle);
              echo $contents;
           //   ob_flush();
          //    flush();
          }
          fclose($handle);
          exit;
      }else{
          exit('檔案下載失敗'); 
      }
   }
   
   public function class_main()
   {
       ?>
        <div class="row no-gutters partner-bordered">
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/skin')?>" type="button">
                        <img src="<?=base_url()?>public/images/p01.png" alt="肌膚保養系列" />
                    </a>
                    <br>
                    <h4 class="my-2">肌膚保養系列</h4>
                    <p>專為肌膚而進化的，<br>安露莎系列保養品。</p>
                    <a href="<?=base_url('category/skin')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
            <?php //if ($this->session->userdata('member_session')['c_no'] === '000000'): ?>
                <div class="col partner-item">
                    <span class="inside">
                        <a href="<?=base_url('member/product/5')?>" type="button">
                            <img src="<?=base_url()?>public/images/m05.png" alt="肌能調理宅配專案" />
                        </a>
                        <br>
                        <h4 class="my-2">肌能調理宅配專案</h4>
                        <a href="<?=base_url('member/product/5')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                    </span>
                </div>
            <?php //endif; ?>
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/makeup')?>" type="button">
                        <img src="<?=base_url()?>public/images/p02.png" alt="彩粧系列" />
                    </a>
                    <br>
                    <h4 class="my-2">彩粧系列</h4>
                    <p>基礎彩粧是肌膚保養的延伸，<br>展現美感造型同時呵護肌膚。</p>
                    <a href="<?=base_url('category/makeup')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/health')?>" type="button">
                        <img src="<?=base_url()?>public/images/p03.png" alt="保健食品系列" />
                    </a>
                    <br>
                    <h4 class="my-2">保健食品系列</h4>
                    <p>肌膚是反映健康狀態的明鏡，<br>裡外兼顧創造美與健康。</p>
                    <a href="<?=base_url('category/health')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
            <?php //if ($this->session->userdata('member_session')['c_no'] === '000000'): ?>
                <div class="col partner-item">
                    <span class="inside">
                        <a href="<?=base_url('member/product/4')?>" type="button">
                            <img src="<?=base_url()?>public/images/m03.png" alt="健康宅配專案" />
                        </a>
                        <br>
                        <h4 class="my-2">健康宅配專案</h4>
                        <a href="<?=base_url('member/product/4')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                    </span>
                </div>
            <?php //endif; ?>
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/clean')?>" type="button">
                        <img src="<?=base_url()?>public/images/p04.png" alt="健康飲用水系列" />
                    </a>
                    <br>
                    <h4 class="my-2">健康飲用水系列</h4>
                    <p>享受健康、純淨、甘甜的好水，<br>是身體的基本渴求。</p>
                    <a href="<?=base_url('category/clean')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/hair_body')?>" type="button">
                        <img src="<?=base_url()?>public/images/p05.png" alt="美髮、美體系列" />
                    </a>
                    <br>
                    <h4 class="my-2">美髮、美體系列</h4>
                    <p>植物性溫泉水及天然香氛、<br>呵護滋潤每一吋肌膚。</p>
                    <a href="<?=base_url('category/hair_body')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
            <div class="col partner-item">
                <span class="inside">
                    <a href="<?=base_url('category/other')?>" type="button">
                        <img src="<?=base_url()?>public/images/p06.png" alt="輔銷產品" />
                    </a>
                    <br>
                    <h4 class="my-2">輔銷產品</h4>
                    <p>體驗組、旅行組、產品型錄、<br>會員手冊、販促品</p>
                    <a href="<?=base_url('category/other')?>" type="button" class="btn btn-outline-secondary btn-sm text-secondary">更多｜More</a>
                </span>
            </div>
        </div>
       <?php
   }
   
   public function prdlist($prdnum,$item,$ptype = 'L')
   {
          $data['item']   = $item;
          $data['prdnum'] = $prdnum;
          $data['ptype']  = $ptype;
          
          return $this->load->view('helper/prdlist', $data, TRUE);          
   }
   
   public function prd_color($p_no)
   {
          $this->load->model( 'front_product_model' ); 
          
          return $this->front_product_model->prd_color($p_no);
   } 
   
   public function text_convert($platform,$body)
   {
          if ($body > ''){
             // $body = preg_replace( '/(<img.*?)(style=.+?[\'|"])|((width)=[\'"]+[0-9]+[\'"]+)|((height)=[\'"]+[0-9]+[\'"]+)/i', '$1' , $body);               
             // $body = preg_replace( '/<img(.*?)>/is', "<img$1 style=\"width:100%;height:auto\">", $body );              
          }
          return $body;
   }
   
   public function share($url,$title,$utm_content)
   { 
           ?>
           <li><a href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo urlencode($url)?>?utm_source=facebook&utm_medium=social&utm_content=<?=$utm_content?>&utm_campaign=share', 'Facebook', config='height=800,width=600');" class="follow-facebook" title="分享至臉書"><i class="socicon-facebook"></i></a></li>
           <li><a 
           <?php if($this->data['platform'] == 'MOBILE'):?>
                     href="http://line.naver.jp/R/msg/text/?<?=urldecode($title)?>%0D%0A<?=$url?>?utm_source=line&utm_medium=social&utm_content=<?=$utm_content?>&utm_campaign=share" target="_blank"
           <?php else:;?>
                     href="javascript:void(0);" onclick="window.open('https://lineit.line.me/share/ui?url=' .concat(encodeURIComponent('<?=$url?>?utm_source=line&utm_medium=social&utm_content=<?=$utm_content?>&utm_campaign=share')) , 'Line', config='height=500,width=600');return false;"
           <?php endif; ?>
                 class="follow-line" title="分享至Line"><i class="socicon-line"></i></a></li>
           <input type="text" id="pageUrl" value="<?=$url?>">
           <li><a href="javascript:void(0)" onClick="CopyUrl();" class="follow-googleplus" title="複製連結"><i class="fa fa-copy"></i></a></li>
           <?php
    }               
    
    // 寄EMAIL
    public function send_email( $to = NULL, $subject = NULL, $content = NULL, $from = 0, $from_name = 0 ) 
    {
      
        $this->config->load( 'email' );
        
        $config['protocol'] = $this->config->item( 'protocol' );
        $config['mailtype'] = $this->config->item( 'mailtype' );
        $config['smtp_host'] = $this->config->item( 'smtp_host' );
        $config['smtp_port'] = $this->config->item( 'smtp_port' );
        $config['smtp_user'] = $this->config->item( 'smtp_user' );
        $config['smtp_pass'] = $this->config->item( 'smtp_pass' );        
        $config['smtp_crypto'] = $this->config->item( 'smtp_crypto' );
        $config['charset'] = $this->config->item( 'charset' );
        $config['newline'] = $this->config->item( 'newline' );        
        
        
        $content = str_replace("[+FC_Web+]", FC_Web ,$content);        
        $content = str_replace("[+FC_service_free_tel+]", FC_service_free_tel ,$content);        
        $content = str_replace("[+FC_WebUrl+]", base_url() ,$content);        
        $content = str_replace("[+FC_Email+]", FC_Email ,$content);
        $content = str_replace("[+FC_service_tel+]", $this->config->item( 'FC_service_tel' ) ,$content);
        $content = str_replace("[+FC_service_time+]", $this->config->item( 'FC_service_time' ) ,$content);
        $content = str_replace("[+FC_Company+]", $this->config->item( 'FC_Company' ) ,$content);
      
        $this->email->initialize( $config );
        $this->email->set_newline("\r\n");
       
        //if ( !$from && !$from_name ) {        
            $this->email->from(FC_Email,FC_Web);
        //} else {
        //    $this->email->from( $from, $from_name );
        //}        
        $this->email->to( $to );
        $this->email->subject( $subject );
        $this->email->message( $content );
      //  echo "<pre>".print_r($this->email,true)."</pre>";exit;
        if ( !$this->email->send() ) {
            echo $this->email->print_debugger();
        }
    }
    
    public function question_send_line($rid,$push_type)
    {
    	  $msg = '無此問卷';
    	  
    	  $question_reply  = $this->front_base_model->get_data('ap_question_reply',array('rid' => $rid),array('rid'=>'asc'));  

    	  if ($question_reply){
    	  	  
    	  	  $question_reply = $question_reply[0];    	  	  

    	  	  $line_user_data = $this->line_service->get_line_user($question_reply['user_id'] ,'',true);                      	      	  	  
    	  	  if ($line_user_data['follow'] == 'disable'){
    	  	  	    $msg = '會員將安露莎Line封鎖，無法寄送！';            
    	  	  }else{
    	         	  $question_prd_set = $this->front_base_model->get_data('ap_question_prd_set',array('p_id' => $question_reply['p_no']),array('p_id'=>'asc'))[0];     	  	  
    	         	  
    	         	  $val['liff_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$question_reply['query'];
    	         	         				                                  
       	       		$c_name = $question_reply['c_name'];                              	                
                   if ($c_name == ''){     
                   	  $c_name = $question_reply['display_name']; 
                   }                         	                
                   
                   $val['c_no']  = $question_reply['c_no'];                                      
                   $val['line_title'] = $question_prd_set['line_title'];
                   $val['name'] = '親愛的 '.trim($c_name).' 會員您好';       
                   $val['line_num'] = '第 '.$question_reply['p_num'].' 次問卷';                     
                   $val['line_msg'] = $question_prd_set['line_msg'];
                   
                   $record_code = base64_encode(json_encode(array('l' => $rid)));
                   $record_code = str_replace('=', '', str_replace('/', '_',$record_code));
                     
                   $val['record_url']  = "https://www.arsoa.tw/question/r?c=".$record_code;
                   
                   $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'question_prd');            
                  //  echo "<pre>".print_r($bubble_data,true)."</pre>";
                  //  exit;
                  // echo "<pre>".print_r($bubble_data,true)."</pre>";
                  // echo "<pre>".json_encode($bubble_data)."</pre>";
                   
                   $messages[]  = array(
                         'type'     => 'flex',
                         'altText'  => $question_prd_set['line_title'],
                         'contents' => array(
                             'type'     => 'carousel',
                             'contents' => $bubble_data
                         )
                   );
                   //   echo "<pre>".print_r($messages,true)."</pre>";              
                   
                   $send_result = $this->api_line_service->push($question_reply['user_id'],$messages);
                   //echo "<pre>".print_r($send_result,true)."</pre>";
                   //exit; 
                   $this->load->model( 'Line_push_log' );                                            
                   // 推送記錄
                   $this->Line_push_log->insert_log($question_reply['user_id'],$push_type,$question_reply['c_no'],$messages,$send_result['http_code'],$send_result['result']);
                   
                   if ($send_result['http_code'] == 429) {  // 訊息數不足
                       $msg = 'Line 訊息數不足';
                       $udata = array(
                                      'msg' => $msg
                                     );                                                            
                       $this->question_model->reply_update_data($rid,$udata);                
                   }elseif($send_result['http_code'] == 200){  // 寄送成功
                       $msg = '';
                   }               
             }
    	  }
    	  return $msg;
    }
    
    public function sample_send_line($rid,$push_type,$p_num)
    {
    	  $msg = '無此問卷';
    	  
    	  $question_reply  = $this->front_base_model->get_data('ap_question_reply',array('rid' => $rid),array('rid'=>'asc'));  
    	 
    	  if ($question_reply){

    	  	  $question_reply = $question_reply[0];    	  	  

    	  	  $line_user_data = $this->line_service->get_line_user($question_reply['user_id'] ,'',true);                      	  
    	  	  if ($line_user_data['follow'] == 'disable'){
    	  	  	    $msg = '來賓將安露莎Line封鎖，無法寄送！';            	  	  	    
     				      $this->front_base_model->update_table('ap_question_reply',array('msg' => $msg) ,array('rid' => $rid));            				      
    	  	  }else{
    	         	   $sample_data = $this->front_base_model->get_data('ap_sample',array('s_id' => $question_reply['p_no']),array('s_id'=>'asc'))[0];     	  	  
    	         	  
    	         	   $val['liff_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$question_reply['query'];
    	         	         				                                  
       	       	 	 $c_name = $line_user_data['display_name']; 
                   
                   $val['line_title'] = $sample_data['line_charge_title'];
                   $val['name'] = '親愛的 '.trim($c_name).' 來賓您好';       
                   $val['line_num'] = '第 '.$question_reply['p_num'].' 次問卷';  
                   
                   if ($push_type == 'sample_reminder'){
                   	   $val['line_msg'] = $sample_data['reminder_msg'];
                   }else{
                       $val['line_msg'] = $sample_data['line_charge_msg'];
                   }
                   
                   $record_code = base64_encode(json_encode(array('l' => $rid)));
                   $record_code = str_replace('=', '', str_replace('/', '_',$record_code));
                     
                   $val['record_url']  = "https://www.arsoa.tw/question/r?c=".$record_code;
                   
                   $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'question_prd');            
                  //  echo "<pre>".print_r($bubble_data,true)."</pre>";
                  //  exit;
                  // echo "<pre>".print_r($bubble_data,true)."</pre>";
                  // echo "<pre>".json_encode($bubble_data)."</pre>";
                   
                   $messages[]  = array(
                         'type'     => 'flex',
                         'altText'  => $sample_data['line_charge_title'],
                         'contents' => array(
                             'type'     => 'carousel',
                             'contents' => $bubble_data
                         )
                   );
                   //   echo "<pre>".print_r($messages,true)."</pre>";              
                   
                   $send_result = $this->api_line_service->push($question_reply['user_id'],$messages);
                   //echo "<pre>".print_r($send_result,true)."</pre>";
                   //exit; 
                   $this->load->model( 'Line_push_log' );                                            
                   // 推送記錄
                   $this->Line_push_log->insert_log($question_reply['user_id'],$push_type.'_'.$p_num,$question_reply['p_no'],$messages,$send_result['http_code'],$send_result['result']);
                   
                   if ($send_result['http_code'] == 429) {  // 訊息數不足
                       $msg = 'Line 訊息數不足';
                       $udata = array(
                                      'msg' => $msg
                                     );                                                            
                       $this->question_model->reply_update_data($rid,$udata);                
                   }elseif($send_result['http_code'] == 200){  // 寄送成功
                       $msg = '';
                   }               
             }
    	  }
    	  return $msg;
    }
    
    public function sample_out_send_line($id,$sample_data,$push_type)
    {
    	      $msg = '操作有誤';
    	  
    	  	  $line_user_data = $this->line_service->get_line_user($sample_data['user_id'] ,'',true);                      	  
    	  	  if ($line_user_data['follow'] == 'disable'){
    	  	  	    $msg = '來賓將安露莎Line封鎖，無法寄送！';
    	  	  }else{
    	         	   $val['line_title'] = $sample_data['line_out_title'];
                   $val['name'] = '親愛的 '.trim($sample_data['uname']).' 來賓您好';       
                   $val['line_title2'] = '出貨通知';                     
                   $val['line_msg'] = $sample_data['line_out_msg'];
                   
                   $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'sample_msg');
                   
                   $messages[]  = array(
                         'type'     => 'flex',
                         'altText'  => $sample_data['line_out_title'],
                         'contents' => array(
                             'type'     => 'carousel',
                             'contents' => $bubble_data
                         )
                   );
                                      
                   $send_result = $this->api_line_service->push($sample_data['user_id'],$messages);
                   //echo "<pre>".print_r($send_result,true)."</pre>";
                   //exit; 
                   $this->load->model( 'Line_push_log' );                                            
                   // 推送記錄
                   $this->Line_push_log->insert_log($sample_data['user_id'],$push_type,$sample_data['s_id'],$messages,$send_result['http_code'],$send_result['result']);
                   
                   if ($send_result['http_code'] == 429) {  // 訊息數不足
                       $msg = 'Line 訊息數不足';
                   }elseif($send_result['http_code'] == 200){  // 寄送成功
                       $msg = '';
                   }               
             }
    	  
    	  return $msg;
    }
    
    public function ecell($x,$y){         
        for($r="";$x>=0;$x=intval($x/26)-1){ 
            $r=chr($x%26+0x41).$r; 
        } 
        return $r . $y; 
    }
    
    public function ecellx($x){ 
        for($r="";$x>=0;$x=intval($x/26)-1){ 
            $r=chr($x%26+0x41).$r; 
        } 
        return $r; 
    } 
    
    public function set_push_time($set_str,$settime)
    {
    	            $setdate = '';
    	            $sethour = '';
    	            $setmin = '';
    	            if ($settime > ''){
    	                $setdate = date('Y-m-d',strtotime( $settime ));
    	                $sethour = date('H',strtotime( $settime ));
    	                $setmin = date('i',strtotime( $settime ));
    	            }
    	            
    	            echo '<div style="float:left">';
                  $params = array(
			  	                        'TheDateField' => $set_str.'_date',
			  	                        'TheDateValue' => $setdate
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('date',$params);
                  echo "</div>";
                  echo '<div style="float:left;margin-left:5px;"><select name="'.$set_str.'_hour" class="form-control" style="width:80px">';
                  for ($i=8;$i<=20;$i++){
                  	   echo '<option value="'.$i.'"';
                  	   if ($sethour == $i){
                  	       echo ' selected';
                  	   }
                  	   echo '>'.sprintf('%02d',$i).'</option>';
                  }
                  echo "</select></div>";
                  echo '<div style="float:left;margin-top:5px;">：</div>';
                  echo '<div style="float:left"><select name="'.$set_str.'_min" class="form-control" style="width:80px">';
                  for ($i=0;$i<60;$i+=10){
                  	   echo '<option value="'.$i.'"';
                  	   if ($setmin == $i){
                  	       echo ' selected';
                  	   }
                  	   echo '>'.sprintf('%02d',$i).'</option>';
                  }
                  echo '</select></div><div style="float:left;margin-top:5px;">&nbsp;分</div>';
                  echo '</div>';
                  
    }
    
    // 活動問卷推播
    public function activity_push_line($act_id,$set)
    {
    	     $result = array('success' => 0,'msg' => '');
    	     
    	     $question = $this->front_base_model->get_data('ap_activity_question',array('act_id' => $act_id,'set_sort' => $set['set_sort'],'status' => 'Y'),array('set_sort'=>'asc'));
    	     
        	
        	 if ($question)
        	 {
        	 	    $question = $question[0];
        	 	    
        	 	    $send = true;
        	 	    
        	 	    if ($set['set_sort'] == 1){    	          
    	          	   if (!($question['set_date'] == '0000-00-00 00:00:00' || $question['set_date'] >= date('Y-m-d H:i:s'))){
    	                   $send = false;
    	               }
    	          }
    	          
    	          if ($send){
    	            
        	 	         
        	 	        $checkcode = md5(uniqid());
       			       
       			        // 問卷資料檔
       			        $question_data = $this->question_model->find_one('q_id',$question['q_id']);
       			        
       			        $question_reply_data = $this->question_model->activity_find_one($act_id,$set['line_user_id'],$set['set_sort']);       			    
       			        
       			        if ($set['c_no'] == ''){
       			            $set['c_no'] = 0;
       			        }       			    
       			        
       			        $r_id = 0;
       			        if ($question_data && $question_reply_data){
       			        	  if ($question_reply_data['status'] == 'P'){
       			        	      $result['msg'] .= "[已送過-未填寫-再送一次]";
       			        	      $rid = $question_reply_data['rid'];
       			        	      
       			        	      $reply_data = array(
       			                             'c_no'         => $set['c_no'],
       			                             'c_name'       => trim($set['c_name']),    
       			                             'q_title'      => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_title']),
       			                             'q_desc'       => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_desc']),
       			                             'q_ans'        => $question_data['q_ans'],
       			                             'display_name' => mb_substr($set['line_display_name'],0,20),    
       			                             'q_id'         => $question_data['q_id'],
       			                             'query'        => $question_data['checkcode'],       			                         
       			                            );     
       			                            
       			        	      $this->question_model->reply_update_data($rid,$reply_data);
       			        	  }
       			        }else{
       			            $result['msg'] .= "[未送過]";
       			            $reply_data = array(
       			                             'c_type'       => 'A',
       			                             'c_no'         => $set['c_no'],
       			                             'p_no'         => $act_id,
       			                             'p_num'        => $set['set_sort'],
       			                             'user_id'      => $set['line_user_id'],       				                                                       
       			                             'c_name'       => trim($set['c_name']),    
       			                             'q_title'      => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_title']),
       			                             'q_desc'       => str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $question_data['q_desc']),
       			                             'q_ans'        => $question_data['q_ans'],
       			                             'display_name' => mb_substr($set['line_display_name'],0,20),    
       			                             'q_id'         => $question_data['q_id'],
       			                             'checkcode'    => $checkcode,
       			                             'query'        => $question_data['checkcode'],
       			                             'status'       => 'P'
       			                            );       				            
       			            $this->question_model->reply_insert_data($reply_data);
       			            
       			            $rid = $this->question_model->reply_insert_id();
       			        }
        	 	        
        	 	        if ($rid > 0){
        	 	            $msg = $this->activity_send_line($rid,'activity_'.$set['set_sort']); 
        	 	            if ($msg == ''){
        	 	            	  $result['success'] = 1;
        	 	            	  $result['msg'] .= '[推播成功]';
        	 	            	  return true;
        	 	            }else{
        	 	            	  $result['msg'] .= $msg; 
        	 	            }
        	 	        }else{
        	 	        	 $result['msg'] .= '已填寫！';        	 	    	  
        	 	        }
        	 	    }
        	 }
        	 return $result;
    }
    
    public function activity_send_line($rid,$push_type)
    {
    	  $msg = '無此問卷';
    	  
    	  $question_reply  = $this->front_base_model->get_data('ap_question_reply',array('rid' => $rid),array('rid'=>'asc'));  

    	  if ($question_reply){
    	  	  
    	  	  $question_reply = $question_reply[0];    	  	  

    	  	  $line_user_data = $this->line_service->get_line_user($question_reply['user_id'] ,'',true);                      	      	  	  
    	  	  if ($line_user_data['follow'] == 'disable'){
    	  	  	    $msg = '[封鎖，無法寄送]'; 
    	  	  	    $udata = array(
                                      'msg' => $msg
                                 );                                                            
                  $this->question_model->reply_update_data($rid,$udata);             
    	  	  }else{
    	         	  $data_set = $this->front_base_model->get_data('ap_activity',array('act_id' => $question_reply['p_no']),array('act_id'=>'asc'))[0];     	  	  
    	         	  
    	         	  $val['liff_url'] = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$question_reply['query'];
    	         	         				                                  
       	       		 $c_name = $question_reply['c_name'];                              	                
                   if ($c_name == ''){                        	  
                   	  $val['name'] = '親愛的 '.trim($question_reply['display_name']).' 您好';       
                   }else{
                   	  $val['name'] = '親愛的 '.trim($c_name).' 會員您好';        
                   }
                   
                   $val['c_no']  = $question_reply['c_no'];                                      
                   $val['line_title'] = $data_set['act_title'];                            
                   $val['line_msg'] = $question_reply['q_title'];
                   
                   $record_code = base64_encode(json_encode(array('l' => $rid)));
                   $record_code = str_replace('=', '', str_replace('/', '_',$record_code));
                     
                   $val['record_url']  = "https://www.arsoa.tw/question/r?c=".$record_code;
                   
                   $bubble_data[] = $this->api_line_service->get_bubble_cont($val, 'activity_prd');            
                                    
                   $messages[]  = array(
                         'type'     => 'flex',
                         'altText'  => $data_set['act_title'].' '.$question_reply['q_title'].'',
                         'contents' => array(
                             'type'     => 'carousel',
                             'contents' => $bubble_data
                         )
                   );
                
                   $send_result = $this->api_line_service->push($question_reply['user_id'],$messages);
                   //echo "<pre>".print_r($send_result,true)."</pre>";
                   //exit; 
                   $this->load->model( 'Line_push_log' );                                            
                   // 推送記錄
                   $this->Line_push_log->insert_log($question_reply['user_id'],$push_type,$question_reply['c_no'],$messages,$send_result['http_code'],$send_result['result']);
                   
                   if ($send_result['http_code'] == 429) {  // 訊息數不足
                       $msg = 'Line 訊息數不足';
                       $udata = array(
                                      'msg' => $msg
                                     );                                                            
                       $this->question_model->reply_update_data($rid,$udata);                
                   }elseif($send_result['http_code'] == 200){  // 寄送成功
                       $msg = '';
                   }               
             }
    	  }
    	  
    	  return $msg;
    }
    
    
}
