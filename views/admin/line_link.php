<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/line_link/modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增" class="btn btn-sm btn-success warning">
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
      <th>連結設定</th>            
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
		    
		            $liff_url = 'https://liff.line.me/'.$this->config->item('line_liff_link_url').'/'.$rs['checkcode'];		
		            
		           // $lot_config   = json_decode($rs['lot_config'], true);                                                     
                ?>
                <tr class="<?php echo $bgclass?>">
                    <td>
                    	<input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/line_link/modify/'.$kind ); ?>?edit=<?php echo $rs["id"]?>';" alt="編輯" border="0" >                                      
                      &nbsp;|&nbsp;                      
                      <a class="btn btn-xs btn-default" href="<?php echo base_url( 'link/preview/'.$rs["checkcode"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                      &nbsp;|&nbsp;
                      <input type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/line_link/modify/'.$kind ); ?>/C?edit=<?php echo $rs["id"]?>';" alt="複製" border="0" >
                      &nbsp;|&nbsp;
                      <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="linkopen(<?=$j?>);" style="height:20px;width:64px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;">
                      <i class="lnr lnr-link"></i> 連結 
                      </a>
                      <br><br>
                      編號：<?=$rs['id']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/上下架/KIND/傳回值","資料",$rs["status"])?>                             
                    </td>                               
                    <td>   
                    	     <?=$rs['link_title']?>
                    	     <br>
                    	     連結數量：<?=$rs['link_num']?>
                    	     <?php if ($rs['link_member'] == 'Y'){ ?>
                    	               <br>限會員
                    	     <?php }else{ ?>                                     
                    	               <br>不限會員
                    	     <?php } ?>                                     
                    	     <br>
                    	     開始日期：<?=$rs['link_start']?>
                    	     <br>
                    	     結束日期：<?php
                    	     if ($rs['link_end'] != '0000-00-00 00:00:00'){
                    	     	   echo $rs['link_end'];
                    	     }else{
                    	     	   echo '不限時間';
                    	     }                    	     
                    	     ?>
                    </td>
                   
                    <td><?php echo $rs["account"]?><br><?php echo $this->block_service->PF_FD($rs["updt"])?></td>                    
                </tr>
                <tr id="div_link_<?=$j?>" style="display:none">    
                	<td colspan=8>
                		<table >
                			<tr>
                			 <td>
                			 	編號 : <?php echo $rs["id"]?>     <br>
                			 	
                			 	連結網址(Line Liff): 
                			 	<a href="<?=$liff_url?>" target=_blank><span id="question_liff_<?=$j?>"><?=$liff_url?></span></a>
                			 	&nbsp;
                			 	<input type="button" class="btn btn-xs btn-default" onclick="copyidtxt('question_liff_<?=$j?>')" value="複製網址">
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
	setTimeout(()=>{$("#tip").remove();},1000);
}

</script>	
