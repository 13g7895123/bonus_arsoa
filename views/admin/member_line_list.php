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
           <option value="A" <?php if ($Swp1 == 'A' || $Swp1 == ''){ echo 'selected'; } ?>>全部會員</option>
           <option value="Y" <?php if ($Swp1 == 'Y'){ echo 'selected'; } ?>>全部綁定成功會員</option>
           <option value="M" <?php if ($Swp1 == 'M'){ echo 'selected'; } ?>>會員登入-綁定成功會員</option>
           <option value="B" <?php if ($Swp1 == 'B'){ echo 'selected'; } ?>>由Line-綁定成功會員</option>
           <option value="J" <?php if ($Swp1 == 'J'){ echo 'selected'; } ?>>加入會員-綁定成功會員</option>                      
           <option value="N" <?php if ($Swp1 == 'N'){ echo 'selected'; } ?>>加入會員-未綁定成功會員</option>         
           <option value="D" <?php if ($Swp1 == 'D'){ echo 'selected'; } ?>>封鎖LINE會員</option>  
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
<input type="hidden" name="break_bid" id="break_bid" value="0">
<?php HIDDEN($this->PATH_INFO,"oForm",$Swp1,$Search,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>會員編號</th>            
      <th>Line 資訊</th>
      <th>綁定方式 / 時間</th>
      <th>會員資訊</th>            
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
                  <?php echo htmlspecialchars($rs["c_no"])?><!--
                    <br><br>
                    <input  type="submit" value="備註編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'member_line/modify/'.$kind ); ?>?edit=<?php echo $rs["bid"]?>';" alt="備註編輯" border="0" >                                        
                    -->
                  </td>                  
                  <td style="font-family:serif;">
                  	  <?php if ($rs['user_id'] > ''){ ?>
                  	     
                                <div style="float:left">
                                	   <img src='<?=$rs['picture_url']?>' width='120px'>                                  
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
                                    <div style="margin-top: 5px;">
                                        <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs['user_id']); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                                    </div>   
                                    <?php
                                    echo '<span class="btn btn-sm btn-danger text-white" style="margin-top: 5px;" onclick="break_bind(\''.$rs["c_no"].'\','.$rs['bid'].');" >解除綁定</span>';
                                    
                                ?>  
                                </div>
                      <?php } ?>
                  </td>
                  <td style="font-family:serif;">
                  <?php           	
                      if ($rs["bind_type"] == 'J'){
                      	  echo '<b>加入會員綁定</b><br>';
                      	  echo '入會單號：'.$rs["join_no"].'（'.htmlspecialchars($rs["c_name"]).'）<br>';                      	  
                      	  echo '入會時間：'.$rs["cdate"];                      	  
                      }elseif ($rs["bind_type"] == 'B'){
                      	  echo '<b>由Line登入綁定</b>';
                      }else{
                      	  echo '<b>會員登入綁定</b>';
                      }                      
                      echo '<br>';
                      if ($rs['user_id'] > ''){
                          echo '綁定時間：'.$rs["bind_date"];
                          echo '<br>';
                          echo '異動時間：'.$rs["last_insteractive"];                      	      
                      }else{
                      	  if ($rs["last_date"] > ''){
                      	      echo '綁定時間：'.$rs["bind_date"];
                              echo '<br>';
                      	      echo '解除綁定時間：'.$rs["last_date"]; 
                      	  }
                      }
                  ?>
                  </td>
                  <td style="font-family:serif;">
                  <?php           
                  	if ($rs["d_pos"] > ''){
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
<script>
function break_bind(c_no,bid){
        $("#break_bid").val('0');
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要解除綁定會員編號：'+c_no+'？<br><br>', function (e) {  
          if (e) {  
              $("#break_bid").val(bid);
              document.oForm.submit();
          } else {  
           // alertify.log('你按下了 cancel');  
          }  
        });     
}
</script>