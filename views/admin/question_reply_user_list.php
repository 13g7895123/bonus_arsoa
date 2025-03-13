<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
      <input type="button" value="問卷管理" onclick="location.href='<?php echo base_url( 'wadmin/question/list/'.$kind ); ?>';" class="btn btn-info">                    
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
    <div style="margin-bottom: 15px;margin-left: 8px;">       
       (<?=$question_data['q_id']?>) <?=$question_data['q_title']?>
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
    <div class="clearfix"></div>
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
      <th>問卷序號/刪除</th>            
      <th>Line 資訊</th>      
      <th>會員資訊</th>   
      <th>問卷資料</th>
      <th>問卷填寫時間</th>
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
		            
		            $ans_config   = json_decode($rs['q_ans'], true);  
		            $reply        = json_decode($rs['reply'], true);		            
                ?>
                <tr class="<?php echo $bgclass?>">
                  <td><?=$rs["rid"]?> | <?php 
                  	echo '<span class="btn btn-sm btn-danger text-white" style="margin-top: 5px;" onclick="break_bind('.$rs['rid'].');" >無效刪除</span>';
                  ?>
                  <br><br>
                  <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs["user_id"]); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
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
                                    <?php
                                    if($rs['follow'] == 'enable') {
                                     //   echo '<span class="btn btn-sm btn-primary text-white">啟用</span>';                                     
                                    }
                                    else {
                                        echo '<span class="btn btn-sm btn-danger text-white" style="height:36px;font-size: 16px;">封鎖</span>';
                                    }   
                                    
                                ?>  
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
                      foreach ($reply as $qkey => $item){
                      	  $ipx = 0;
                      	  if ($qkey > 0){
                      	      $ipx = 3;	
                      	  }
                      	  ?>
                      	  <div style="margin-top: <?=$ipx?>px;" title="<?=$item['title']?>">
                  	                <span class="btn btn-sm btn-info text-white">
                                        <?=($qkey+1)?>
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?php
                                           if ($item['ans'] == ''){
                                           	   echo '<font color=red>未填寫</font>';
                                           }else{
                                           	   echo htmlspecialchars($item['ans']);
                                           }
                                           ?>
                                        </span>                                        
                                    </span> 
                      	  </div>
                      	  <?php                     	
                      }
                  ?>
                  </td>
                  <td style="font-family:serif;">
                  <?=$rs["crdt"]?>
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