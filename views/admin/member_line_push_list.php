<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
     
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
    <div style="float:left;">       
       <select class="form-control" name="Swp1" id="Swp1" style="border-color: #8a6d3b;">
           <option value="L" <?php if ($Swp1 == 'L' || $Swp1 == ''){ echo 'selected'; } ?>>推送紀錄</option>
           <option value="A" <?php if ($Swp1 == 'A'){ echo 'selected'; } ?>>系統有綁定粉絲</option>
           <option value="M" <?php if ($Swp1 == 'M'){ echo 'selected'; } ?>>綁定會員</option>
           <option value="N" <?php if ($Swp1 == 'N'){ echo 'selected'; } ?>>綁定非會員</option>
           <?php
           /*
           <option value="MD" <?php if ($Swp1 == 'MD'){ echo 'selected'; } ?>>封鎖綁定會員</option>  
           <option value="ND" <?php if ($Swp1 == 'ND'){ echo 'selected'; } ?>>封鎖非會員</option>  
           */
           ?>
       </select>              
     </div>
     <div class="form-group has-warning" style="float:left;margin-left: 5px;">
       <input type="text" name="Search" value="<?php 
           if (isset($Search)){ 
               echo htmlspecialchars($Search);
           } ?>" class="form-control" style="width:200px" placeholder="關鍵字搜尋" />
     </div>     
     <div style="float:left"> &nbsp;     
      <input type="submit" value="查詢" class="btn btn-sm btn-info" style="height:34px"/>	      	
    </div>      
      <?php HIDDEN($this->PATH_INFO,"SearchoForm")?>
    
    </form>
    <!-- 搜尋機制 E -->   
  </div>
</div>

<?php if (isset($errmsg) && $errmsg > ""){ ?>   
   <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>錯誤！</strong>&nbsp;<?php echo $errmsg?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>
<?php if (isset($ok_message) && $ok_message > ""){ ?>   
   <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>成功！</strong>&nbsp;<?php echo $ok_message?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>

<form name="oForm"  method="post" language="javascript" action="<?=$this->PATH_INFO?>" >
	
<?php HIDDEN($this->PATH_INFO,"oForm",$Swp1,$Search,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
  	  <th>推送</th>
      <th>Line 資訊</th>
      <th>會員資訊</th> 
      <th>推送訊息</th>
      <th>推送狀態 / 時間</th>            
  </tr>
<!--傳給下一頁的參數-->

<?php

if ($list['total'] == 0) {
    if (isset($Search) && $Search > ''){
        $searchstr = "關鍵字：<font color=red>".htmlspecialchars($Search)."</font>，查詢不到任何資料"; 
    }else{
        $searchstr = '目前尚無任何資料';
    }
    echo  "<tr><td colspan=8>".$searchstr."</td></tr>";
}else{
		$j=0;
		foreach ( $list['rows'] as $rs ){
		
			       $j++;	
		          $bgclass= ($j % 2 == 0 ? "active" : "warning");  
                ?>
                <tr class="<?php echo $bgclass?>">
                	<td>
                		 <input type="image" value="推送訊息" width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' onclick="javascript:action='<?php echo base_url( 'wadmin/member_line/push/'.$kind.'/'.$rs["line_user_user_id"]); ?>';submit();" alt="推送訊息" border="0" >
                	</td>
                  <td style="font-family:serif;">
                  	     
                                <div style="float:left">
                                	   <img src='<?=$rs['picture_url']?>' width='120px' onerror="this.src='<?=base_url('public/images/line_404.png')?>'">                                  
                                </div>
                                <div style="float:left;margin-left: 5px;">
                  	                <span class="btn btn-sm btn-info text-white">
                                        暱稱
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$rs['display_name']?>
                                        </span>                                        
                                    </span> 
                                    <?php
                                    if($rs['follow'] == 'enable') {
                                     //   echo '<span class="btn btn-sm btn-primary text-white">啟用</span>';                                     
                                    }
                                    else {
                                        echo '<span class="btn btn-sm btn-danger text-white" style="height:36px;font-size: 16px;">封鎖</span>';
                                    }    
                                    if ($rs["line_user_cdate"] > ''){
                                    	  echo '<div style="margin-top:5px">';
                      	                echo '建立時間：'.$rs["line_user_cdate"];
                      	                echo '</div>';
                      	            }                                                                       
                                ?>  
                                </div>
           
                  </td>
                  <td style="font-family:serif;">
                  <?php           
                  	if ($rs["member_c_no"] > ''){
                        echo htmlspecialchars($rs["member_c_no"]);
                        echo '<br>';
                        echo htmlspecialchars($rs["member_c_name"]);
                        echo "（";
                        echo htmlspecialchars($rs["mb_status"]);
                        echo "）";
                        echo '<br>';
                        echo htmlspecialchars($rs["d_pos"])."（".$rs["d_posn"]."）";
                        if ($rs["is_org"] == 0){
                            echo "組織鎖死";
                        }
                        echo '<br>';
                        echo htmlspecialchars($rs["cell1"]);
                        echo '<br>';
                        echo htmlspecialchars($rs["cell2"]);
                    }
                  ?>
                  </td>        
                  <td>
                  	<?php if ($rs["push_log_id"] > ''){                  		        
                  		        $send_array = json_decode($rs['push_cont'], true)[0];             
                  		        echo str_replace(array("\r\n", "\r", "\n", "\t"), '<br>', $send_array['text']);
                  		    }else{ ?>
                  	          尚未有推送記錄
                  	<?php } ?>
                  </td>        	
                  <td>
                  	<?php if ($rs["push_log_id"] > ''){
                  	          echo $rs["cdate"];
                  	          echo '<br>';
                  	          if ($rs["http_code"]  == 429){
                  	          	  echo 'Line 訊息數不足';
                  	          }else{
                  	          	  echo 'Line 訊息成功推送';
                  	          }
                  	      }else{ ?>
                  	          尚未有推送記錄
                  	<?php } ?>
                  </td>        	
                </tr>
                <?php }  ?>
</table>
</div>
</form>

<form name="PageForm" method="post" action="<?=$this->PATH_INFO?>">
  <?php
  $this->block_service->PJ_ToUrlPageNew("document.PageForm",$PageSize,$Page,$PageCount,$RecordCount)
  ?>
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Swp1,$Search)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Swp1 = '',$Search='',$Page=1){          
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">';              
              echo '<input type="hidden" name="Swp1" value="'.$Swp1.'">';
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>