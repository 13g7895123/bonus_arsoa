<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/consent/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增同意書" class="btn btn-sm btn-success warning_3">
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
  </div>
  <div class="clearfix"></div>     
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
      <th>同意書設定</th>            
      <th>同意書時間&nbsp;|&nbsp;同意書人數</th>
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
		    
		            $event_url   = $this->config->item('sample_html_url').'/C/'.$rs['checkcode'];
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_consent_url').'/'.$rs['checkcode'];		
		                                  
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/consent/modify/'.$kind ); ?>?edit=<?php echo $rs["c_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;                      
                      <a class="btn btn-xs btn-default" href="<?php echo base_url( 'consent/preview/'.$rs["checkcode"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/consent/modify/'.$kind ); ?>/C?edit=<?php echo $rs["c_id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> QrCode 
                      </a>
                      <br><br>
                      編號：<?=$rs['c_id']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/上下架/KIND/傳回值","資料",$rs["status"])?>                             
                    </td>                               
                    <td>   
                    	     <?=$rs['c_title']?>                    	     
                    </td>
                   
                    <td>                    	 
                    	         
                      <?=$rs['c_start']?> ~ <?=$rs['c_end']?>       	 
                      <br><br>
                    	          <table class="table table-bordered" id="consent_list" style="margin-bottom:0px">                    	 	 
                    	           <tr style="background-color: #364F6A;height:25px;border-color: #2d4259;color: #ffffff;">
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  指定未同意人數
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  同意人數
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  總人數	
                    	           	</td>
                    	           </tr>	
                    	           <tr>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['n_num'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['y_num'])?>	
                    	           	</td>                    	                     
                    	           	<td align=center>
                    	           		<?=number_format(($rs['n_num']+$rs['y_num']))?>	
                    	           	</td>
                    	           </tr>	                    	           
                    	           <tr>
                    	           	<td colspan=4 align=center>
                    	           		<?php if (($rs['y_num']+$rs['n_num']) > 0){ ?>      
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/consent/charge_list/T002/'.$rs['c_id'])?>" target="consent_<?=$rs['c_id']?>"><span class="lnr lnr-users"></span> 名單檢視</a>                    	
                      	                      &nbsp;
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: green;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/consent/excel_export/A/'.$rs['c_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 全名單匯出Excel</a>
                    	                        &nbsp;
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: green;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/consent/excel_export/Y/'.$rs['c_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 同意名單匯出Excel</a>
                    	              <?php }else{ 
                    	              	          echo '無人數';                    	 	                  
                    	 	                  } ?>
                    	            </td>
                    	           </tr>
                    	          </table> 
                      </td>    
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?></td>                    
                </tr>
                <tr id="div_link_<?=$j?>" style="display:none">    
                	<td colspan=8>
                		<table >
                			<tr>
                			 <td>
                			 	同意書編號 : <?php echo $rs["c_id"]?>     <br>
                			 	
                			 	同意書網址(Line): 
                			 	<a href="<?=$liff_url?>" target=_blank><span id="question_liff_<?=$j?>"><?=$liff_url?></span></a>
                			 	&nbsp;
                			 	<input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('question_liff_<?=$j?>')" value="複製網址">
                		   </td> 
                		   <td>
                		     <img src="<?=base_url('reg?c='.$liff_url)?>" class="img-fluid" width="150">
                		   </td> 
                		   <td>
                		   	 同意書網址(對外): 
                		   	 <a href="<?=$event_url?>" target=_blank><span id="event_url_<?=$j?>"><?=$event_url?></span></a>
                		   	 &nbsp;
                			 	<input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('event_url_<?=$j?>')" value="複製網址">
                		   </td>
                		   <td>
                		     <img src="<?=base_url('reg?c='.$event_url)?>" class="img-fluid" width="150">
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
function copyidtxt(nkey){
	var str=$("#"+nkey).html();
	var input='<input type="text" id="temp'+nkey+'" value="'+str+'">';
	$("body").append(input);$("#temp"+nkey).select();
	document.execCommand("Copy");$("#temp"+nkey).remove();
	let div='<div id="tip" style="position: absolute; top: 50%;left: 50%;transform: translate(-50%, -50%);padding: 12px 25px;background: rgba(0, 0, 0, 0.6); color: #fff;font-size: 14px;">複製成功</div>';$("body").append(div);
	setTimeout(()=>{$("#tip").remove();},1000);}

function check_line(c_id){        
      /*  alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要進行 line 狀態偵測（一天只能偵測一次），試用組編號：'+c_id+'？<br><br>', function (e) {  
          if (e) {  
          */
              $.ajax({
                url: base_url + "wadmin/consent/check_line",                
                type: "POST",
                dataType: "json",
                data:{"c_id":c_id},
                success: function(data){
                    console.log(data);
                    alertify.alert(data.msg+"<br><br>");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

         }); 
            /*  
          } else {  
           // alertify.log('你按下了 cancel');  
          }  
        });   */  
}

</script>	
