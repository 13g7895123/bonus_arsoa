<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">匯出資料</button>
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
      <th>申請編號</th>                  
      <th>姓名</th>      
      <th>相關資訊</th>      
      <th>申請時間<br>申請IP</th>            
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
                /*
                <td>
                   <input type="button" value="重寄下載連結信件" class="btn btn-xs btn-default" onclick="joinsend(<?php echo $rs["jid"]?>);" alt="重寄下載連結信件" border="0" >
                </td>
                */
                ?>
                <tr class="<?php echo $bgclass?>">                  
                  <td>
                   <input type="checkbox" name="del[]" id="del[]" value="<?php echo $rs["jid"]?>">
                  </td>
                  <td><?php echo htmlspecialchars($rs["jid"])?></td>
                  <td><?php echo htmlspecialchars($rs["uname"])?></td>
                  <td><i class="fa fa-mobile" aria-hidden="true"></i>：<?php echo htmlspecialchars($rs["mobile"])?><br>
                      <i class="fa fa-phone" aria-hidden="true"></i>：<?php echo htmlspecialchars($rs["tel"])?><br>
                      <i class="fa fa-envelope" aria-hidden="true"></i>：<?php echo htmlspecialchars($rs["email"])?><br>
                      <i class="fa fa-home" aria-hidden="true"></i>：<?php echo htmlspecialchars($rs["postal"])?> <?php echo htmlspecialchars($rs["address"])?>
                  </td>
                  <td><?php echo $rs["crdt"]?><br><br>IP:<?php echo htmlspecialchars($rs["ip"])?></td>                  
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
function joinsend(id){
  	$.ajax({
	     url: base_url + "wadmin/member/joinsend/"+id,
		   type: "GET",
		   dataType: "json",	     	      
       success: function(data){	              
		     //  console.log(data.status);		       
		       if (data.status == '1'){
			         alertify.alert("申請編號:"+id+" 已成功寄出下載連結信件！<br><br>");
			     }else{
			         alertify.alert("申請編號:"+id+" 寄出失敗，請重新寄送下載連結信件！<br><br>");
			     }
		   }
	  });
}
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">入會申請-資料匯出</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="OutForm" method="post" language="javascript" action="<?php echo base_url( 'wadmin/member/join_out_download'); ?>" target=_blank>
      <div class="modal-body">        
           <h5>選擇匯出的日期（期間）：</h5>
           <p>
            <div class="form-group">		      
		      	<div class="col-sm-12">
		      	   <div class="col-md-3 grid_box1">
		      			 <?php
								    $params = array(
			  	                        'TheDateField' => 'stdt', 
			  	                        'TheDateValue' => ''
			  	                        );			  	                
                            $this->ui->PJ_JInputDate('date',$params);          
								   ?>
		      	   </div>
		      	   <div class="col-md-1 grid_box1" style="text-align:center;">
		      	   ～
		      	   </div>
		      	   <div class="col-md-3 grid_box1">
		      	        <?php
								    $params = array(
			  	                        'TheDateField' => 'eddt', 
			  	                        'TheDateValue' => ''
			  	                        );			  	                
                            $this->ui->PJ_JInputDate('date',$params);          
								   ?>
		      	   </div>
		      	</div>
		      </div>
		      <br>
          </p>        
          <br>   
          <h5>或</h5>
          <h5>選擇申請編號（區間）：</h5>
          <p>
            <div class="form-group">		      
		      	<div class="col-sm-12">
		      	   <div class="col-md-3 grid_box1">
		      			 <input type="text" name="mid" class="form-control1"/>
		      	   </div>
		      	   <div class="col-md-1 grid_box1" style="text-align:center;">
		      	   ～
		      	   </div>
		      	   <div class="col-md-3 grid_box1">
		      	        <input type="text" name="xid" class="form-control1"/>
		      	   </div>
		      	</div>
		      </div>
		      <br>
          </p>        
          
          
          
          
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary"  onclick="$('#exampleModal').modal('hide');"  value="匯出" aria-label="Close" >
      </div>
      </form>
    </div>
  </div>
</div>