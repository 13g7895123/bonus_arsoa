<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/lottery/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增抽獎(輪盤)" class="btn btn-sm btn-success warning_3">
       <input type="submit" name="AddSubmit" value="新增抽獎(刮刮樂)" class="btn btn-sm btn-success warning_3">
       <input type="submit" name="AddSubmit" value="新增抽獎(拉霸)" class="btn btn-sm btn-success warning_3">
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
      <th>抽獎設定</th>      
      <th>獎項列表</th>
      <th>抽獎時間&nbsp;|&nbsp;抽獎人數</th>
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
		    
		            $event_url   = $this->config->item('lottery_html_url').'/K/'.$rs['checkcode'];
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_lottery_url').'/'.$rs['checkcode'];		
		            
		            $lot_config   = json_decode($rs['lot_config'], true);                                                     
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/lottery/modify/'.$kind ); ?>?edit=<?php echo $rs["lot_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;                      
                      <a class="btn btn-xs btn-default" href="<?php echo base_url( 'lottery/preview/'.$rs["checkcode"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/lottery/modify/'.$kind ); ?>/C?edit=<?php echo $rs["lot_id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> QrCode 
                      </a>
                      <br><br>
                      編號：<?=$rs['lot_id']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/上下架/KIND/傳回值","資料",$rs["status"])?>                             
                    </td>                               
                    <td>   
                    	     抽獎模組：<?=$lottory_type[$rs['lot_type']]?>
                    	     <br><br>
                    	     <?=$rs['lot_title']?>
                    	     <br>
                    	     <?php if ($lot_config['addr'] == 'Y'){ ?>
                    	               <br>中獎人需填寫收件資訊
                    	     <?php } ?>          
                           <?php if ($lot_config['member'] == 'Y'){ ?>
                    	               <br>安露莎全部會員可抽獎
                    	     <?php } ?>          
                    	     <?php if ($lot_config['charge'] == 'Y'){ ?>
                    	               <br>指定的會員才可抽獎
                    	     <?php } ?>          
                    	     <?php if ($lot_config['question'] == 'Y'){ ?>
                    	               <br><a href="<?=base_url('wadmin/question/reply_list/'.$lot_config['q_id'])?>" title="檢視問卷填寫名單">(<?=$lot_config['q_id']?>) 填完問卷才可抽獎</a>
                    	     <?php } ?>          
                    </td>
                    <td style="padding: 5px !important;">
                    	     <?php foreach ($rs['lot_data'] as $key => $item){ ?>
                    	            <span class="btn btn-sm btn-info text-white" style="margin-bottom: 2px;margin-top: 2px;background-color: #17a2b8;border-color: #999999;">
                                        <?=($key+1)?>
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$item['title']?>
                                        </span>
                                        &nbsp;&nbsp;數量&nbsp;
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$item['num']?>
                                        </span>
                                        &nbsp;&nbsp;已抽&nbsp;
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$item['use_num']?>
                                        </span>
                                  </span> 
                                  <br>
                           <?php } ?>       
                    </td>      
                    <td>                    	 
                    	         
                      <?=$rs['lot_start']?> ~ <?=$rs['lot_end']?>       	 
                      <br><br>
                    	          <table class="table table-bordered" id="lottery_list" style="margin-bottom:0px">                    	 	 
                    	           <tr style="background-color: #364F6A;height:25px;border-color: #2d4259;color: #ffffff;">
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  指定未抽獎
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  中獎
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  未中獎
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  再抽一次
                    	           	</td>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  抽獎總人數
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
                    	           	  <?=number_format($rs['c_num'])?>	
                    	           	</td>
                    	           	<td align=center>
                    	           		<?=number_format(($rs['a_num']))?>	
                    	           	</td>                 
                    	           	<td align=center>
                    	           		<?=number_format(($rs['all_num']))?>	
                    	           	</td>
                    	           </tr>	                    	           
                    	           <tr>
                    	           	<td colspan=5 align=center>
                    	           		<?php if (($rs['y_num']+$rs['c_num']) > 0){ ?>      
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/lottery/charge_list/L002/'.$rs['lot_id'])?>" target="lottery_<?=$rs['lot_id']?>"><span class="lnr lnr-users"></span> 抽獎名單檢視</a>                    	
                      	                      &nbsp;
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: green;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/lottery/excel_export/'.$rs['lot_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 中獎名單匯出Excel</a>
                    	              <?php }else{ 
                    	              	          echo '尚無抽獎人數';                    	 	                  
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
                			 	抽獎編號 : <?php echo $rs["lot_id"]?>     <br>
                			 	
                			 	抽獎網址(Line): 
                			 	<a href="<?=$liff_url?>" target=_blank><span id="question_liff_<?=$j?>"><?=$liff_url?></span></a>
                			 	&nbsp;
                			 	<input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('question_liff_<?=$j?>')" value="複製網址">
                		   </td> 
                		   <td>
                		     <img src="<?=base_url('reg?c='.$liff_url)?>" class="img-fluid" width="150">
                		   </td> 
                		   <td>
                		   	 抽獎網址(對外): 
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

function check_line(lot_id){        
      /*  alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要進行 line 狀態偵測（一天只能偵測一次），試用組編號：'+lot_id+'？<br><br>', function (e) {  
          if (e) {  
          */
              $.ajax({
                url: base_url + "wadmin/lottery/check_line",                
                type: "POST",
                dataType: "json",
                data:{"lot_id":lot_id},
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
