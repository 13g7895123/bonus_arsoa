<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
      <input type="button" value="LINE群組貼標訊息傳送管理" onclick="location.href='<?php echo base_url( 'wadmin/member_line/group_push_list/'.$kind ); ?>';" class="btn btn-info">                    
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
    <div style="margin-bottom: 15px;margin-left: 8px;">       
       (<?=$ta_data['ta_id']?>) <?=$ta_data['ta_title']?>
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
<input type="hidden" name="break_bid" id="break_bid" value="0">
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>訊息傳送序號</th>            
      <th>Line 資訊</th>      
      <th>會員資訊</th>   
      <th>傳送狀態</th>
      <th>建立時間</th>
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
                  <td><?=$rs["ta_member_id"]?>
                  <!--<br><br>
                  <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs["user_id"]); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                  -->
                  </td>                  
                  <td style="font-family:serif;">
                  	  <?php if ($rs['user_id'] > ''){ ?>                  	     
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
                                </div>
                      <?php } ?>
                 </td>
                <td style="font-family:serif;">      
                      <?php           
                      if ($rs["d_pos"] > ''){
                      	    echo '會員編號：'.$rs['c_no'];
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
                            echo '</div>';
                        }
                      ?>
                  </td>
                  <td style="font-family:serif;">
                  <?php     
                       switch ($rs['status']){
		       		         	       case "1":
		                                echo '<font color=green>傳送成功</font>';
		                                echo '<br>';
		                                echo '傳送時間：'.$rs['updt'];
		                                echo '<br>';
		                                echo '傳送次數：'.$rs['push_num'];		                                
		       		         		          break;
		       		         		     case "2":
		                                echo '<font color=red>會員封鎖</font>';
		                                echo '<br>';
		                                echo '傳送時間：'.$rs['updt'];
		                                echo '<br>';
		                                echo '傳送次數：'.$rs['push_num'];		                                
		       		         		          break;     
		       		         		     case "3":
		                                echo '<font color=red>會員未綁定</font>';
		                                echo '<br>';
		                                echo '傳送時間：'.$rs['updt'];
		                                echo '<br>';
		                                echo '傳送次數：'.$rs['push_num'];		                                
		       		         		          break;          
		       		         	       default:
		       		         	            echo '未傳送';
		        	         }
                  ?>
                  </td>        
                  <td style="font-family:serif;">
                  	<?=$rs["cdate"]?>
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
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">'; 
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>
<script>
function break_bind(bid){
        $("#break_bid").val('0');
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要無效刪除？<br><br>', function (e) {  
          if (e) {  
              $("#break_bid").val(bid);
              document.oForm.submit();
          } else {  
           // alertify.log('你按下了 cancel');  
          }  
        });     
}
</script>