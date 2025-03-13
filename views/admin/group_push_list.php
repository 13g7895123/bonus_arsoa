
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/member_line/group_push_modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增群組貼標訊息" class="btn btn-sm btn-success warning_3">
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>&nbsp;</th>  
      <th>群組貼標編號 / 名稱</th>            
      <th>推送人數</th>      
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
		            $ta_data   = json_decode($rs['ta_data'], true);                                                 
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/member_line/group_push_modify/'.$kind ); ?>?edit=<?php echo $rs["ta_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/member_line/group_push_modify/'.$kind ); ?>/C?edit=<?php echo $rs["ta_id"]?>';" alt="複製" border="0" >                      
                      </a>
                    </td>                               
                    <td>
                    	       <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;background-color: #17a2b8;border-color: #999999;">
                                 編號
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=$rs['ta_id']?>
                                 </span>
                                 &nbsp;&nbsp;訊息數&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=count($ta_data)?> 
                                 </span>                            
                             </span> 
                         <br> 
                         <?php echo htmlspecialchars($rs["ta_title"])?>                      
                    </td>     
                     
                    <td>
                    	 
                    	<table style="width:100%;border-top-style: hidden;border-left-style: hidden;border-right-style: hidden;border: 1px solid;">
                                       <tr style="background-color: #364F6A;height:25px;border-color: #2d4259;color: #ffffff;">
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;" colspan=3 align="ceter">可推送</td>                                           
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;" align="ceter">已推送</td>
                                       </tr>
                                       <tr style="border: 1px solid;">
                                          <td style="padding: .1rem;width:20px;border: 1px solid #ccc;text-align:center;">未推</td> 
                                          <td style="padding: .1rem;width:30px;border: 1px solid #ccc;text-align:center;">未綁</td>
                                          <td style="padding: .1rem;width:30px;border: 1px solid #ccc;text-align:center;">封鎖</td>
                                          <td style="padding: .1rem;width:20px;border: 1px solid #ccc;text-align:center;">成功</td>                                           
                                       </tr>
                                       <tr style="border: 1px solid;"> 
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;"><?=number_format($rs['reply_count'][0])?></td>
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;"><?=number_format($rs['reply_count'][3])?></td>
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;"><?=number_format($rs['reply_count'][2])?></td>
                                          <td style="padding: .1rem;border: 1px solid #ccc;text-align:center;"><?=number_format($rs['reply_count'][1])?></td>
                                       </tr>
                                       <tr>
                                       	 <td colspan=4 style="padding: .1rem;border: 1px solid #ccc;text-align:center;">
                                       	 	<?php if ($rs['reply_count'][0] + $rs['reply_count'][3]  + $rs['reply_count'][2] > 0){ ?>                                                    
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-info text-white" style="background: #00b900;height:38px;width:84px;padding: .6rem .4rem;vertical-align: middle;text-align: center;" onclick="linkopen(<?=$j?>);">我要推送</a>	
                                          <?php } ?>
                                       	 	&nbsp;
                                       	 	<a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;" href="<?=base_url('wadmin/member_line/group_push_log/'.$kind.'/'.$rs['ta_id'])?>" target="group_push_log_<?=$rs['ta_id']?>"><span class="lnr lnr-users"></span> 名單檢視</a>                    	</td>
                                       </tr>
                       </table>
                    </td>    
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?></td>                    
                </tr>
                <tr id="div_link_<?=$j?>" style="display:none">    
                	<td colspan=8>
                		<table style="width:100%;">
                			<tr>
                			 <td style="width:150px;">
                			  群組貼標編號 : <?php echo $rs["ta_id"]?>
                			 </td>	
                			 <td style="width:150px;">
                			 	<input type="checkbox" name="q_status0_<?=$rs['ta_id']?>" id="q_status0_<?=$rs['ta_id']?>" value="Y" checked> 
						            <label style="font-size:18px;margin-top: 5px;" for="q_status0_<?=$rs['ta_id']?>">&nbsp;未推 ( <?=number_format($rs['reply_count'][0])?> )</label>
						            <br>
						            <input type="checkbox" name="q_status3_<?=$rs['ta_id']?>" id="q_status3_<?=$rs['ta_id']?>" value="Y"> 
						            <label style="font-size:18px;margin-top: 5px;" for="q_status3_<?=$rs['ta_id']?>">&nbsp;未綁 ( <?=number_format($rs['reply_count'][3])?> )</label>
						            <br>
						            <input type="checkbox" name="q_status2_<?=$rs['ta_id']?>" id="q_status2_<?=$rs['ta_id']?>" value="Y"> 
						            <label style="font-size:18px;margin-top: 5px;" for="q_status2_<?=$rs['ta_id']?>">&nbsp;封鎖 ( <?=number_format($rs['reply_count'][2])?> )</label>
						
                		   </td> 
                		   <td style="width:150px;">
                		   	<div style="margin-top: 5px;">
                             <a href="javascript:void(0)" onclick="group_line_push(<?=$rs['ta_id']?>);"><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                        </div>   
                		   </td>     
                		   <td>
                		   	 <iframe id="group_line_push_list_<?=$rs['ta_id']?>" src="<?=base_url('public/images/loading_background.png')?>" frameborder="1" style="border: 1px solid #ccc;width:100%;height:130px;"></iframe>                         
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
function group_line_push(ta_id){
     $( "#group_line_push_list_"+ta_id ).html('');
     var q_status0 = 'N';
     var q_status2 = 'N';
     var q_status3 = 'N';
     if ($('#q_status2_'+ta_id).is(":checked"))
     {
         q_status2 = 'Y';
     }
     if ($('#q_status0_'+ta_id).is(":checked"))
     {
         q_status0 = 'Y';
     }
     if ($('#q_status3_'+ta_id).is(":checked"))
     {
         q_status3 = 'Y';
     }
     
     $('#group_line_push_list_'+ta_id).attr("src", "<?=base_url('wadmin/member_line')?>/group_push_go/"+ta_id+'/'+q_status0+'/'+q_status2+'/'+q_status3);
     
}	
</script>	