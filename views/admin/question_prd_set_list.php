<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/question_prd_set/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit_line" value="新增產品體驗(Line)" class="btn btn-sm btn-success warning_3">
       <input type="submit" name="AddSubmit_tel" value="新增產品電訪" class="btn btn-sm btn-success warning_3">
       <input type="submit" name="AddSubmit" value="新增產品諮詢" class="btn btn-sm btn-success warning_3">    
       <?php HIDDEN($this->PATH_INFO,"AddSubmit")?>
    </form>
    <!-- 新增機制 E -->       
  </div>
  <div>    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">    
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
    <div class="clearfix"></div>     
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,'',$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>編號&nbsp;|&nbsp;設定&nbsp;|&nbsp;狀態</th>  
      <th>產品體驗資訊</th>      
      <th>人數 ( 購買 | 已寄 | 已填寫 )</th>
      <th>狀態 | 顯示順序</th>  
      <th>最後修改人/日期</th>      
  </tr>
<!--傳給下一頁的參數-->

<?php

if ($list['total'] == 0) {
    if (isset($Search) && $Search > ''){
        $searchstr = "關鍵字：<font color=red>".htmlspecialchars($Search)."</font>，查詢不到任何資料"; 
    }else{
        $searchstr = '目前尚無任何資料';
    }
    echo  "<tr><td colspan=9>".$searchstr."</td></tr>";
}else{
		$j=0;
		foreach ( $list['rows'] as $rs ){
			          $j++;	
		            $bgclass= ($j % 2 == 0 ? "active" : "warning");  		           
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/question_prd_set/modify/'.$kind ); ?>?edit=<?php echo $rs["p_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/question_prd_set/modify/'.$kind ); ?>/C?edit=<?php echo $rs["p_id"]?>';" alt="複製" border="0" >
                    </td>                               
                    <td>
                    	       <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;background-color: #17a2b8;border-color: #999999;">
                                 編號
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=$rs['p_id']?>
                                 </span>
                                 &nbsp;&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php echo $rs["p_no"]?> 
                                 </span>
                                 &nbsp;&nbsp;題數&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=$rs["q_num"]?> 
                                 </span>                              
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php
                                      if ($rs["line_push"] == 'Y'){
                                      	  echo 'Line 推播';
                                      }elseif ($rs["line_push"] == 'N'){
                                      	  echo '<font color=red>電訪</font>';
                                      }elseif ($rs["line_push"] == 'Q'){
                                      	  echo '<font color=green>諮詢</font>';	  
                                      }?> 
                                 </span>                                                                                     
                             </span> 
                         <br> 
                         <?php echo htmlspecialchars($rs["p_name"])?>   
                         <?php if ($rs["line_push"] != 'Y'){
                         	         $qurl = base_url('question/product/'.$rs["checkcode"]);
                         	         echo '<br>';
                                   echo '填寫連結：<a href="'.$qurl.'" target=_blank>'.$qurl.'</a>';
                               }	
                         ?>
                    </td>      
                    <td align=center>
                    	 <?=number_format($rs['order_sum'])?>
                    	 &nbsp;|&nbsp;
                    	 <?=number_format($rs['order_sum_send'])?>
                    	 &nbsp;|&nbsp;
                    	 <?=number_format($rs['order_sum_reply'])?>
                    	 <?php if ($rs['order_sum'] > 0){ ?>                    	 
                    	           <br>
                    	           <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;" href="<?=base_url('wadmin/question_prd_set/send_list/N002/'.$rs['p_id'])?>/A" target="question_prd_set_<?=$rs['p_id']?>"><span class="lnr lnr-users"></span> 名單檢視</a>         
                    	 <?php } ?>
                    </td>          
                    <td><?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/題庫狀態/KIND/傳回值","資料",$rs["status"])?><br><br>
                    	<?=$rs["web_sort"]?></td>
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?></td>                    
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
function linkopen(j){	
	
	var display = $('#div_link_'+j).css('display');
  if ($('#div_link_'+j).is(':hidden')){
  	  $('#div_link_'+j).show();  
  }else{
  	  $('#div_link_'+j).hide();  
  }  
}	
function copyidtxt(nkey){
	var str=$("#"+nkey).html();
	var input='<input type="text" id="temp'+nkey+'" value="'+str+'">';
	$("body").append(input);$("#temp"+nkey).select();
	document.execCommand("Copy");$("#temp"+nkey).remove();
	let div='<div id="tip" style="position: absolute; top: 50%;left: 50%;transform: translate(-50%, -50%);padding: 12px 25px;background: rgba(0, 0, 0, 0.6); color: #fff;font-size: 14px;">複製成功</div>';$("body").append(div);
	setTimeout(()=>{$("#tip").remove();},1000);}
	
</script>	