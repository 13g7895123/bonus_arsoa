<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
      <input type="button" value="試用組設定" onclick="location.href='<?php echo base_url( 'wadmin/sample/list/F001' ); ?>';" class="btn btn-info">                    
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="S_id" id="S_id" style="border-color: #8a6d3b;">
           <option value="" <?php if ($S_id == '' || $S_id == ''){ echo 'selected'; } ?>>全部試用組</option>
           <?php foreach ($class as $key => $item){  ?>
                       <option value="<?=$item['s_id']?>" <?php if ($S_id == $item['s_id']){ echo 'selected'; } ?>>(<?=$item['s_id']?>) <?=$item['s_title']?></option>
           <?php } ?>                  
       </select>              
     </div>
     <div style="float:left;margin-left: 5px;">       
       <select class="form-control" name="Status" id="Status" style="border-color: #8a6d3b;">
                <option value="" <?php if (!isset($Status) || $Status == ''){ echo 'selected'; } ?>>申請狀態(全部)</option>
                <option value="N" <?php if (isset($Status) && $Status == 'N'){ echo 'selected'; } ?>>未審核</option>
                <option value="Y" <?php if (isset($Status) && $Status == 'Y'){ echo 'selected'; } ?>>通過</option>           
       </select>              
     </div>
     <div style="float:left;margin-left: 5px;">       
       <select class="form-control" name="Follow" id="Follow" style="border-color: #8a6d3b;">
                <option value="" <?php if (!isset($Follow) || $Follow == ''){ echo 'selected'; } ?>>Line 狀態(全部)</option>
                <option value="enable" <?php if (isset($Follow) && $Follow == 'enable'){ echo 'selected'; } ?>>未封鎖</option>
                <option value="disable" <?php if (isset($Follow) && $Follow == 'disable'){ echo 'selected'; } ?>>封鎖</option>           
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$S_id,$Follow,$Status,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>索取序號</th>            
      <th>Line 資訊</th>  
      <th>試用包</th>       
      <th>寄送資訊</th>   
      <th>出貨資訊</th>
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
		foreach ( $list['rows'] as $key => $rs ){
			          $j++;	
		            $bgclass= ($j % 2 == 0 ? "active" : "warning");  
		                     
                ?>
                <tr class="<?php echo $bgclass?>">
                  <td><?=$rs["id"]?>
                  	<!--
                  	&nbsp;|&nbsp;  
                  	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/sample/charge_modify/'.$kind ); ?>?edit=<?php echo $rs["s_id"]?>';" alt="編輯" border="0" >                                                            
                  	-->
                  </td>                  
                  <td style="font-family:serif;">
                  	  
                                <div style="float:left">
                                	   <img src='<?=$rs['picture_url']?>' width='100px'>                                  
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
                                    ?>
                                    <div class="clearfix"></div>              
                                    <div style="margin-top: 5px;">
                                        <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs['user_id']); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                                    </div>   
                                    <div class="clearfix" style="margin-top: 5px;"></div> 
                                    <?php
                                    echo '申請方式：';
                                    if ($rs['s_type'] == 'F'){
                                    	  echo 'FB';
                                    }
                                    if ($rs['s_type'] == 'I'){
                                    	  echo 'IG';
                                    }
                                    if ($rs['s_type'] == 'S'){
                                    	  echo '業務行銷';
                                    	  echo "<br>推薦人：".$rs['referrer_c_no']." ".$rs['member_c_name']."";
                                    }
                                    if ($rs['s_type'] == 'L'){
                                    	  echo 'Line';
                                    }                                    
                                ?>  
                                </div>
                      
                 </td>
                 <td style="font-family:serif;">
                     <?php
                     echo '編號：'.htmlspecialchars($rs['s_id']);                     
                     echo '<br>';
                     echo '名稱：'.htmlspecialchars($rs['s_title']);                     
                     echo '<br>';
                     echo '索取：'.htmlspecialchars($rs['sel_sample']);   
                     echo '<br>';
                     echo '申請時間：'.$rs["crdt"];
                     ?>
                 </td>
                 <td style="font-family:serif;">
                  <?php   
                      echo '姓名：'.htmlspecialchars($rs['uname']);
                      echo '<br>';
                      echo '性別：'.htmlspecialchars($rs['sex']);
                      echo '<br>';
                      echo '生日：'.htmlspecialchars($rs['bday']);
                      echo '<br>';
                      echo '電話：'.htmlspecialchars($rs['tel']);
                      echo '<br>';
                      echo '地址：'.htmlspecialchars($rs['postal']).' '.htmlspecialchars($rs['address']);
                  ?>
                  </td>
                  <td style="font-family:serif;width:260px;">
                  	<?php if ($rs['outdt'] > ''){
                  		        echo '已寄：'.$rs['outdt'];
                  		        echo '<br>';
                  		    	  echo '修改時間：'.$rs['updt'];
                  		    	  echo '<br>';
                  		    	  echo '修改人：'.$rs['account'];                  		    	  
                  		    	  echo '<br>';
                  		    	  if ($rs['line_out_dt'] > ''){
                  		    	  	  if ($rs['line_out_msg'] == ''){
                  		    	  	  	  $rs['line_out_msg'] = '成功送出';
                  		    	  	  }
                  		    	  	  echo 'Line 出貨通知<br>';
                  		    	    	echo '推送時間：'.$rs['line_out_dt'];
                  		    	      echo '<br>';
                  		    	      echo '推送狀態：'.$rs['line_out_msg'];                  		    	  
                  		    	  }
                  		    }else{
                  		    	  if ($rs['status'] == 'D'){
                  		    	  	  echo '審核未通過';
                  		    	  	  echo '<br>';
                  		    	  	  echo '審核時間：'.$rs['updt'];
                  		    	  	  echo '<br>';
                  		    	  	  echo '審核人：'.$rs['account'];
                  		    	  	  echo '<br>';
                  		    	  }else{
                  		    	      ?>
                  		    	      <div align=center>
                  		    	        <input type="hidden" name="s_id_<?=$j?>" value="<?=$rs["id"]?>">
                  	                <input type="text" class="form-control" maxlength="10" name="outdt_<?=$rs["id"]?>" id="outdt_<?=$rs["id"]?>" value="" placeholder="填寫範例:2022-10-10">
                  	                <br>
                  	                <a href="javascript:void(0)" onclick="outdtset(<?=$rs["id"]?>,'<?=date("Y-m-d",strtotime("-1 day"))?>');" class="btn btn-xs btn-default"><?=date("Y-m-d",strtotime("-1 day"))?></a>
                  	                &nbsp;&nbsp;
                  	                <a href="javascript:void(0)" onclick="outdtset(<?=$rs["id"]?>,'<?=date("Y-m-d")?>');" class="btn btn-xs btn-default"><?=date("Y-m-d")?></a> 
                  	                <br>
                  	                <a href="javascript:void(0)" onclick="outdtset(<?=$rs["id"]?>,'<?=date("Y-m-d",strtotime("+1 day"))?>');" class="btn btn-xs btn-default"><?=date("Y-m-d",strtotime("+1 day"))?></a>
                  	                &nbsp;&nbsp;
                  	                <a href="javascript:void(0)" onclick="outdtset(<?=$rs["id"]?>,'<?=date("Y-m-d",strtotime("+2 day"))?>');" class="btn btn-xs btn-default"><?=date("Y-m-d",strtotime("+2 day"))?></a>
                  	                <div style="margin-top: 6px;">
                  	                   <input type="checkbox" name="del_<?=$rs["id"]?>" id="del_<?=$rs["id"]?>" value="Y"> 審核不通過
                  	                </div>   
                  	              </div>   
                  	              <?php  
                  	          }
                  	      }?>
                  </td>             
                </tr>
                <?php }  ?>
                <input type="hidden" name="s_num" value="<?=$j?>">
</table>
</div>

<div style="width:100%">
  <div style="float:right;margin-top: 10px;">
      <input type="submit" value="寄送日期儲存" style="border-color: #999999;" class="btn btn-primary">                    
  </div>
</div>


</form>

<form name="PageForm" method="post" action="<?=$this->PATH_INFO?>">
  <?php
  $this->block_service->PJ_ToUrlPageNew("document.PageForm",$PageSize,$Page,$PageCount,$RecordCount)
  ?>
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search,$S_id,$Follow,$Status)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$S_id='',$Follow='',$Status = '',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">'; 
              echo '<input type="hidden" name="S_id" value="'.$S_id.'">';
              echo '<input type="hidden" name="Follow" value="'.$Follow.'">';
              echo '<input type="hidden" name="Status" value="'.$Status.'">';
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>
<script>
function outdtset(id,jday)
{
	  $("#outdt_"+id).val(jday);
}	
</script>