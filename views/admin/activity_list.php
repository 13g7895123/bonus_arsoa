<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/activity/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增" class="btn btn-sm btn-success warning_3">
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
      <th>活動設定</th>
      <th>活動人數</th>
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
		    
		            $event_url   = $this->config->item('lottery_html_url').'/A/'.$rs['checkcode'];
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_activity_url').'/'.$rs['checkcode'];		
		            
		            $act_config   = json_decode($rs['act_config'], true);                                                     
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/activity/modify/'.$kind ); ?>?edit=<?php echo $rs["act_id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/activity/modify/'.$kind ); ?>/C?edit=<?php echo $rs["act_id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> QrCode 
                      </a>
                      <br><br>
                      編號：<?=$rs['act_id']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/上下架/KIND/傳回值","資料",$rs["status"])?>                             
                    </td>                               
                    <td>   
                    	     <?=$rs['act_title']?>
                    	     
                    	     <br>
                    	     報名時間：<?=$rs['act_start']?> ~ <?=$rs['act_end']?>                    	     
                    	     <br>
                    	     <?php
                    	     if (isset($rs['set_question'])){
                    	         foreach ($rs['set_question'] as $kt => $item){
                    	         	  if ($item['status'] == 'Y' && $item['q_id'] > 0){
                    	         	      if ($item['set_sort'] == 1){
	                                    	  $datitle = '報名成功問卷';	                                    	  
	                                    }else{
	                                    	  $datitle = '問卷 '.($item['set_sort']-1);
	                                    } 
                    	         	      ?>
                    	         	      <span class="btn btn-sm btn-info text-white" style="margin-bottom: 5px;margin-top: 5px;background-color: #17a2b8;border-color: #999999;">
                                            <?=$datitle?>
                                            <?php if ($item['set_sort'] > 1){ ?>
                                                <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                                   <?=date('Y-m-d H:i',strtotime($item['set_date']))?>
                                                </span>
                                            <?php } ?>
                                            <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                               (<?=$item['q_id']?>) <?=$item['q_title']?>                                               
                                            </span>
                                            &nbsp;&nbsp;推送&nbsp;
                                            <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                               <?=$item['all_reply_count']?>                                               
                                            </span>
                                            &nbsp;&nbsp;填寫&nbsp;
                                            <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                               <?=$item['reply_count']?>
                                               <?php if ($item['reply_count'] > 0){ ?>
                                               			&nbsp;
                                               			<a href="<?=base_url('wadmin/question/reply_list/'.$item['q_id'])?>" target=_blank>
                                               				  檢視
                                               			</a>&nbsp;|&nbsp;<a href="<?=base_url('wadmin/question/excel_export/'.$item['q_id'])?>" target=_blank>
                                               				  下載
                                               			</a>
                                               <?php } ?>
                                            </span>
                                            <?php      
                                            $total = 0;
                    	                      foreach ($reg_type as $key => $item12){ 
                    	           	                   $total += $rs['num_'.$key];
                    	           	          }                    	           	          
                                            $push_num = $total - $item['reply_count'];
                                            if ($push_num > 0){?>
                                            	 <span style="margin-left: 5px;margin-top: -5px;">
                                                  <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="push_line(<?=$rs['act_id']?>,<?=$item['q_id']?>,<?=$item['set_sort']?>);" style="height:28px;width:84px;font-size: 12px;padding: .2rem .2rem;vertical-align: middle;text-align: center;">
                                                  	  推播未填寫 <?=$push_num?>
                                                  </a>
                                               </span>
                                            	
                                               <?php
                                            } ?>
                                      </span> 
                                      <br><?php
                                  }
                    	         }
                    	     }
                    	     ?>                    	     
                    </td>
                    <td>
                    	
                    	<table class="table table-bordered" id="lottery_list" style="margin-bottom:0px">                    	 	 
                    	           <tr style="background-color: #364F6A;height:25px;border-color: #2d4259;color: #ffffff;">
                    	           <?php foreach ($reg_type as $key => $item){ ?>
                    	           	<td style="color:#FFFFFF" align=center>
                    	           	  <?=$item?>
                    	           	</td>
                    	           <?php } ?>	
                    	           <td style="color:#FFFFFF" align=center>
                    	           	 合計
                    	           </td>
                    	           </tr>	
                    	           <tr>
                    	           <?php 
                    	               $total = 0;
                    	               foreach ($reg_type as $key => $item){ 
                    	           	      $total += $rs['num_'.$key];
                    	           	      ?>
                    	           	      <td align=center>
                    	           	        <?=number_format($rs['num_'.$key])?>	
                    	           	      </td>
                    	           <?php } ?>		      
                    	           	<td align=center>
                    	           	  <?=number_format($total)?>	
                    	           	</td>
                    	           </tr>	                    	           
                    	           <tr>
                    	           	<td colspan=5 align=center>
                    	           		<?php if ($total > 0){ ?>      
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: #17a2b8;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/activity/charge_list/C002/'.$rs['act_id'])?>" target="lottery_<?=$rs['act_id']?>"><span class="lnr lnr-users"></span> 報到名單檢視</a>                    	
                      	                      &nbsp;
                    	                        <a class="btn btn-sm btn-warning text-white" style="background-color: green;border-color: #17a2b8;height:30px;vertical-align: middle;padding: .3rem .4rem;text-align: center;" href="<?=base_url('wadmin/activity/excel_export/'.$rs['act_id'].'')?>" target="_blank"><span class="lnr lnr-pie-chart"></span> 名單匯出Excel</a>
                    	              <?php }else{ 
                    	              	          echo '尚無人報到';                    	 	                  
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
                			 	活動編號 : <?php echo $rs["act_id"]?>     <br>
                			 	
                			 	活動報到網址(Line): 
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

function push_line(act_id,q_id,act_sort){
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要推播未填寫？<br><br>活動編號：'+act_id+' ( 問卷編號：'+q_id+' )？<br><br>', function (e) {  
           if (e) {  
              window.open('<?=base_url('corn/job/A')?>/'+act_id+'/'+act_sort, '活動編號：'+act_id, config='height=500,width=800');
                           
          }  
        }); 
}

</script>	
