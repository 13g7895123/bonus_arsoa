<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/func/func_modify/'.$kind ); ?>">    
    <input type="submit" name="AddSubmit" value="新增" class="btn btn-sm btn-success warning_3">
    <?php HIDDEN($this->PATH_INFO,"AddSubmit")?>
    </form>
    <!-- 新增機制 E -->       
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
    <div class="form-group has-warning">
      <input type="text" name="Search" value="<?php 
           if (isset($Search)){ 
               echo htmlspecialchars($Search);
           } ?>" class="form-control1" style="width:200px"  placeholder="關鍵字搜尋" />
      <input type="submit" value="查詢" class="btn btn-sm btn-info"/>		
      <?php HIDDEN($this->PATH_INFO,"SearchoForm")?>
    </div>
    </form>
    <!-- 搜尋機制 E -->   
  </div>
</div>
<script>
function delchk(){
   if($("input[name='del[]']:checked").length > 0){    
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要刪除？<br><br>', function (e) {  
          if (e) {  
              document.oForm.submit();
          } else {  
           // alertify.log('你按下了 cancel');  
          }  
        });  
    }else{
        alertify.alert("尚未勾選！<br><br>");
    }
}
$(document).ready(function(){
  $("#CheckAll").click(function(){
   if($("#CheckAll").prop("checked")){//如果全選按鈕有被選擇的話（被選擇是true）
    $("input[name='del[]']").prop("checked",true);//把所有的核取方框的property都變成勾選
   }else{
    $("input[name='del[]']").prop("checked",false);//把所有的核取方框的property都取消勾選
   }
  })
})
</script>

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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>      
      <input type="button" name="DelSubmit" id="DelSubmit" value="刪除" class="btn btn-xs btn-danger" onclick="delchk();" >
      &nbsp;&nbsp;|&nbsp;&nbsp;
      <input type="checkbox" name="CheckAll" value="核取方塊" id="CheckAll" />      
      </th>
      <?php $this->block_service->PM_listtitle($Xmlspec)?>
  </tr>
<!--傳給下一頁的參數-->

<?php

if ($list['total'] == 0) {
    if (isset($Search) && $Search > ''){
        $searchstr = "關鍵字：<font color=red>".htmlspecialchars($Search)."</font>，查詢不到任何資料"; 
    }else{
        $searchstr = '目前尚無任何資料';
    }
    echo  "<tr><td colspan=12>".$searchstr."</td></tr>";
}else{
		$j=0;
		foreach ( $list['rows'] as $rs ){
			       $j++;	
		          $bgclass= ($j % 2 == 0 ? "active" : "warning");  
                ?>
                <tr class="<?php echo $bgclass?>">
                 <td>
                   <input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/func/func_modify/'.$kind ); ?>?edit=<?php echo $rs["id"]?>';" alt="編輯" border="0" >
                      <?php if ($kind == '4000'){ ?>
                                &nbsp;&nbsp;|&nbsp;&nbsp;       
                                <a href="../news_detail.php?id=<?php echo $rs["id"]?>&chk=Y" target=_blank>預覽</a>
                      <?php } ?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <input type="checkbox" name="del[]" id="del[]" value="<?php echo $rs["id"]?>">
                 </td>
                 <?php $this->block_service->PM_list($Xmlspec,$rs)?>
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