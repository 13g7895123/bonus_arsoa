<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/question/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增問卷" class="btn btn-sm btn-success warning_3">
       <?php HIDDEN($this->PATH_INFO,"AddSubmit")?>
    </form>
    <!-- 新增機制 E -->       
  </div>
  <div>    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="Sclass" id="Sclass" style="border-color: #8a6d3b;">
           <option value="" <?php if ($Sclass == '' || $Sclass == ''){ echo 'selected'; } ?>>全部問卷類型</option>
           <?php foreach ($class as $key => $item){  ?>
                       <option value="<?=$item['classid']?>" <?php if ($Sclass == $item['classid']){ echo 'selected'; } ?>><?=$item['classtitle']?></option>
           <?php } ?>                  
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Sclass,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>&nbsp;</th>  
      <th>問卷編號 / 類型 / 名稱</th>      
      <th>問卷填寫人數</th>
      <th>問卷狀態</th>      
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
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_question_url').'/'.$rs['checkcode'];
		            $q_config   = json_decode($rs['q_config'], true);                                                 
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/question/modify/'.$kind ); ?>?edit=<?php echo $rs["q_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;                      
                      <a class="btn btn-xs btn-default" href="<?php echo base_url( 'question/preview/'.$rs["checkcode"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/question/modify/'.$kind ); ?>/C?edit=<?php echo $rs["q_id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> QrCode 
                      </a>
                    </td>                               
                    <td>
                    	       <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;background-color: #17a2b8;border-color: #999999;">
                                 問卷編號
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=$rs['q_id']?>
                                 </span>
                                 &nbsp;&nbsp;類型&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php echo $classtitle[$rs["classid"]]?> 
                                 </span>
                                 &nbsp;&nbsp;題數&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=$rs["q_num"]?> 
                                 </span>
                                 <?php if ($rs["q_date"] != '0000-00-00 00:00:00'){ ?>
                                     &nbsp;&nbsp;活動日期&nbsp;
                                     <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                        <?=date('Y-m-d',strtotime($rs["q_date"]))?>
                                     </span>                                 
                                 <?php } ?>
                                 <?php if ($q_config['member'] == 'Y'){ ?>
                                     <span style="background-color: #ffffff;color:red;margin-left: 5px;border-radius:3px;padding:5px;">
                                        限會員
                                     </span>                                 
                                 <?php } ?>
                             </span> 
                         <br> 
                         <?php echo htmlspecialchars($rs["q_title"])?>                      
                    </td>      
                    <td>
                    	 <?=number_format($rs['reply_count'])?> 人
                    	 <?php if ($rs['reply_count'] > 0){ ?>                    	 
                    	           &nbsp;
                    	           <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;" href="<?=base_url('wadmin/question/reply_list/'.$rs['q_id'])?>" target="question_<?=$rs['q_id']?>"><span class="lnr lnr-users"></span> 名單檢視</a>                    	
                    	           
                    	           <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;" href="<?=base_url('wadmin/question/excel_export/'.$rs['q_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 匯出Excel</a>
                    	           <?php if ( $_SERVER['HTTP_HOST'] == 'localhost'){    ?>
                    	                 <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;" href="<?=base_url('wadmin/question/analyze/'.$rs['q_id'].'')?>" target="_analyze"><span class="lnr lnr-pie-chart"></span> 分析</a>
                    	           <?php } ?>
                    	 <?php } ?>
                    </td>          
                    <td><?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/題庫狀態/KIND/傳回值","資料",$rs["status"])?></td>
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?></td>                    
                </tr>
                <tr id="div_link_<?=$j?>" style="display:none">    
                	<td colspan=8>
                		<table >
                			<tr>
                			 <td>
                			 	問卷編號 : <?php echo $rs["q_id"]?>     <br>
                			 	問卷網址 : 
                			 	<a href="<?=$liff_url?>" target=_blank><span id="question_liff_<?=$j?>"><?=$liff_url?></span></a>
                			 	&nbsp;
                			 	<input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('question_liff_<?=$j?>')" value="複製網址">
                		   </td> 
                		   <td>
                		     <img src="<?=base_url('reg?c='.$liff_url)?>" class="img-fluid" width="150">
                		   </td> 
                		  </tr>   
                		 </table>  
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
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search,$Sclass)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$Sclass='',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">';
              echo '<input type="hidden" name="Sclass" value="'.$Sclass.'">';
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