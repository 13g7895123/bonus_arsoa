<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/sample/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增試用組" class="btn btn-sm btn-success warning_3">
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
      <th>索取試用組資訊</th>      
      <th>索取人數 ( 設定 | 索取 | 通過 )</th>
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
		    
		            $fb_url   = $this->config->item('sample_html_url').'/e/F'.$rs['checkcode'];		            
		            $ig_url   = $this->config->item('sample_html_url').'/e/I'.$rs['checkcode'];		            
		            $sale_url = $this->config->item('sample_html_url').'/e/S'.$rs['checkcode'];		            
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_sample_url').'/L'.$rs['checkcode'];		
		            $sample_data   = json_decode($rs['sample_data'], true);                                                     
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/sample/modify/'.$kind ); ?>?edit=<?php echo $rs["s_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/sample/modify/'.$kind ); ?>/C?edit=<?php echo $rs["s_id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> QrCode 
                      </a>
                      <br><br>
                      編號：<?=$rs['s_id']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/題庫狀態/KIND/傳回值","資料",$rs["status"])?>        
                    </td>                               
                    <td>
                    	     
                    	     <?=$rs['s_title']?><br>
                    	     試用組數量：<?=count($sample_data)?>
                    	     <br>
                    	     <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;margin-top: 5px;background-color: #17a2b8;border-color: #999999;">
                                 FB
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=date('Y-m-d H:i:s',strtotime($rs["f_start"]))?>&nbsp;~&nbsp;<?=date('Y-m-d H:i:s',strtotime($rs["f_end"]))?>
                                 </span>
                                 &nbsp;&nbsp;數量&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php echo $rs["f_num"]?> 
                                 </span>
                           </span> 
                           <br>
                    	     <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;background-color: #17a2b8;border-color: #999999;">
                                 IG
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=date('Y-m-d H:i:s',strtotime($rs["i_start"]))?>&nbsp;~&nbsp;<?=date('Y-m-d H:i:s',strtotime($rs["i_end"]))?>
                                 </span>
                                 &nbsp;&nbsp;數量&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php echo $rs["i_num"]?> 
                                 </span>
                           </span> 
                           <br>
                    	     <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;background-color: #17a2b8;border-color: #999999;">
                                 業務行銷
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?=date('Y-m-d H:i:s',strtotime($rs["s_start"]))?>&nbsp;~&nbsp;<?=date('Y-m-d H:i:s',strtotime($rs["s_end"]))?>
                                 </span>
                                 &nbsp;&nbsp;數量&nbsp;
                                 <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                    <?php echo $rs["s_num"]?> 
                                 </span>
                           </span> 
                    </td>      
                    <td>                    	 
                    	               	 
                    	          <table class="table table-bordered" id="sample_list" style="margin-bottom:0px">                    	 	 
                    	           <tr style="background-color: #364F6A;height:25px;border-color: #2d4259;color: #ffffff;">
                    	           	<td style="color:#FFFFFF" colspan=3 align=center>
                    	           	  FB	
                    	           	</td>
                    	           	<td style="color:#FFFFFF" colspan=3 align=center>
                    	           	  IG	
                    	           	</td>
                    	           	<td style="color:#FFFFFF" colspan=3 align=center>
                    	           	  業務行銷	
                    	           	</td>
                    	           	<td style="color:#FFFFFF" colspan=3 align=center>
                    	           	  總人數	
                    	           	</td>
                    	           </tr>	
                    	           <tr>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['f_num'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['f_reply_count'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['f_reply_count_Y'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           		<?=number_format($rs['i_num'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['i_reply_count'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['i_reply_count_Y'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           		<?=number_format($rs['s_num'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['s_reply_count'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['s_reply_count_Y'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           		<?=number_format(($rs['f_num']+$rs['i_num']+$rs['s_num']))?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['reply_count'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           	  <?=number_format($rs['reply_count_Y'])?>	
                    	           	</td>
                    	           </tr>	
                    	           
                    	           <tr>
                    	           	<td colspan=12 align=center>
                    	           		<?php if ($rs['reply_count'] > 0){ ?>      
                    	              <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/sample/charge_list/F002/'.$rs['s_id'])?>"  target="sample_<?=$rs['s_id']?>"><span class="lnr lnr-users"></span> 申請檢視</a>                    	
                      	            &nbsp;
                    	              <a class="btn btn-sm btn-warning text-white" style="background-color: green;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/sample/excel_export/'.$rs['s_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 匯出Excel</a>                    	           
                    	              
                    	              <?php }else{ 
                    	              	          echo '尚無索取人數';                    	 	                  
                    	 	                  } ?>
                    	            </td>
                    	           </tr>
                    	          </table> 
                    	 
                    	 	         
                    	 
                      </td>    
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?>
                    	<br>
                    	<br>
                    	<?php if ($rs['reply_count'] > 0){                    	
                    	                            	  ?>
                    	                            	  <div id="check_line_div_<?=$rs["s_id"]?>">
                    	                            	     <a href="javascript:void(0);" id="submitbutton" onclick="check_line(<?=$rs["s_id"]?>);" class="btn btn-xs btn-info" class="btn btn-sm btn- btn-info" style="background: #00b900;height:30px;width:84px;padding: .3rem .4rem;vertical-align: middle;text-align: center;">line 狀態偵測</a> 
                    	                            	  </div>
                    	                            	  <div id="check_line_div_msg_<?=$rs["s_id"]?>">
                    	                            	     <br>
                    	                            	     <?php if ($rs["line_test_dt"] > ''){ ?>                    	                            	     
                    	                            	               最後偵測時間：<?=date('Y-m-d H:i:s',strtotime($rs["line_test_dt"]))?>                    	                            	               
                    	                            	     <?php }else{
                    	                            	     	         echo '未偵測過';
                    	                            	     	     }
                    	                            	     ?>
                    	                            	     <br>
                    	                            	     索取封鎖人數：<?php echo $rs["line_disable_num"]?>                                                       
                    	                            	     <br>
                    	                            	     通過封鎖人數：<?php echo $rs["line_disable_num_Y"]?>
                    	                            	  </div>   
                    	                            	  <?php
                    	                            
                    	       } ?>  
                     	</td>                    
                </tr>
                <tr id="div_link_<?=$j?>" style="display:none">    
                	<td colspan=8>
                		   <table width=100% style="border: 1px #ccc solid;border-collapse: collapse;" border='1'>
                			    <tr>                			 
                			 			<td width=33%>索取網址 (FB)</td>
                			 			<td width=33%>索取網址 (IG)</td>
                			 			<td width=33%>索取網址 (業務行銷)</td>
                			 		</tr>
                			 		<tr>
                			 			<td>
                			 	      <a href="<?=$fb_url?>" target=_blank><span id="fb_liff_<?=$j?>"><?=$fb_url?></span></a>
                			 	      <br>
                			 	      <input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('fb_liff_<?=$j?>')" value="複製網址">
                		        </td>                 		        
                		        <td>
                			 	      <a href="<?=$ig_url?>" target=_blank><span id="ig_liff_<?=$j?>"><?=$ig_url?></span></a>
                			 	      <br>
                			 	      <input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('ig_liff_<?=$j?>')" value="複製網址">
                		        </td> 
                		        <td>
                			 	      <a href="<?=$sale_url?>" target=_blank><span id="sale_liff_<?=$j?>"><?=$sale_url?></span></a>
                			 	      <br>
                			 	      <input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('sale_liff_<?=$j?>')" value="複製網址">
                		        </td> 
                		      </tr>
                		      <tr>
                		        <td>
                		          <img src="<?=base_url('reg?c='.$fb_url)?>" class="img-fluid" width="150">
                		        </td>                  		   
                		        <td>
                		          <img src="<?=base_url('reg?c='.$ig_url)?>" class="img-fluid" width="150">
                		        </td>                  		   
                		       	<td>
                		          <img src="<?=base_url('reg?c='.$sale_url)?>" class="img-fluid" width="150">
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

function check_line(s_id){        
      /*  alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要進行 line 狀態偵測（一天只能偵測一次），試用組編號：'+s_id+'？<br><br>', function (e) {  
          if (e) {  
          */
              $.ajax({
                url: base_url + "wadmin/sample/check_line",                
                type: "POST",
                dataType: "json",
                data:{"s_id":s_id},
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
