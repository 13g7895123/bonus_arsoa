<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
      <input type="button" value="抽獎設定" onclick="location.href='<?php echo base_url( 'wadmin/lottery/list/L001' ); ?>';" class="btn btn-info">                    
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="lot_id" id="lot_id" style="border-color: #8a6d3b;">
           <option value="" <?php if ($lot_id == '' || $lot_id == ''){ echo 'selected'; } ?>>全部抽獎</option>
           <?php foreach ($class as $key => $item){  ?>
                       <option value="<?=$item['lot_id']?>" <?php if ($lot_id == $item['lot_id']){ echo 'selected'; } ?>>(<?=$item['lot_id']?>) <?=$item['lot_title']?></option>
           <?php } ?>                  
       </select>              
     </div>
     <div style="float:left;margin-left: 5px;">       
       <select class="form-control" name="Status" id="Status" style="border-color: #8a6d3b;">
                <option value="" <?php if (!isset($Status) || $Status == ''){ echo 'selected'; } ?>>抽奬狀態(全部)</option>
                <option value="Y" <?php if (isset($Status) && $Status == 'Y'){ echo 'selected'; } ?>>中獎</option>
                <option value="C" <?php if (isset($Status) && $Status == 'C'){ echo 'selected'; } ?>>未中獎</option>          
                <option value="N" <?php if (isset($Status) && $Status == 'N'){ echo 'selected'; } ?>>未抽獎</option>
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
      <div class="clearfix"></div>
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$lot_id,$Follow,$Status,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>序號</th>            
      <th>抽奬人資訊</th>  
      <th>抽獎資訊</th>    
      <th>中獎資訊</th>
      <th>收件資訊</th>
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
		foreach ( $list['rows'] as $key => $rs ){
			          $j++;	
		            $bgclass= ($j % 2 == 0 ? "active" : "warning");  
		            $lot_config = json_decode($rs['lot_config'], true);  

                ?>
                <tr class="<?php echo $bgclass?>">
                  <td><?=$rs["id"]?>
                  	 &nbsp;&nbsp;| &nbsp;&nbsp;
                  	<span class="btn btn-sm btn-danger text-white" style="margin-top: 5px;" onclick="break_bind(<?=$rs["id"]?>);" >刪除重抽</span>
                  	</td>                  
                  <td style="font-family:serif;">
                  	  
                                <div style="float:left">
                                	   <img src='<?=$rs['picture_url']?>' width='100px'>                                  
                                </div>
                                <div style="float:left;margin-left: 5px;">
                  	                <span class="btn btn-sm btn-info text-white">
                                        暱稱
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$rs['display_name']?>
                                        </span>                                        
                                    </span> 
                                    <?php
                                    if($rs['follow'] == 'enable') {
                                     //   echo '<span class="btn btn-sm btn-primary text-white">啟用</span>';                                     
                                    }
                                    else {
                                        echo '<span class="btn btn-sm btn-danger text-white" style="height:36px;font-size: 16px;">封鎖</span>';
                                    }   
                                    ?>
                                    <div class="clearfix"></div>              
                                    <div style="margin-top: 5px;">
                                        <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs['user_id']); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                                    </div>   
                                    <div class="clearfix" style="margin-top: 5px;"></div> 
                                   
                                </div>
                      
                 </td>
                 <td style="font-family:serif;">
                     <?php
                     echo '抽獎編號：'.htmlspecialchars($rs['lot_id']);                     
                     echo '<br>';
                     echo '抽獎名稱：'.htmlspecialchars($rs['lot_title_main']);                                          
                     ?>
                 </td>
                 <td style="font-family:serif;">
                     <?php                                          
                     if ($rs['status'] == 'Y'){
                     	   echo '已中獎';                     	   
                     	   echo '<br>';                     	   
                     	   echo '獎品名稱：('.($rs['lot_key']+1).') '.$rs['lot_title'];
                     }elseif ($rs['status'] == 'C'){
                     	   echo '未中獎';                     	   
                     }elseif ($rs['status'] == 'A'){
                     	   echo '再抽一次';                     	   	   
                     }elseif ($rs['status'] == 'N'){	
                     	   echo '未抽獎';
                     }
                     echo '<br>';
                     if ($rs['status'] != 'N'){
                         echo '抽獎時間：'.date($rs['lot_dt']);                                          
                     }
                     ?>
                 </td>
                 <td style="font-family:serif;">
                  <?php  
                     if (trim($rs['c_no']) > ''){
                         echo '會員編號：'.htmlspecialchars($rs['c_no']);
                         echo '<br>';
                     }
                     if ($rs['status'] == 'Y'){                      	   
                     	   if ($lot_config['addr'] == 'Y'){                     	   	   
                     	   	   if ($rs['address'] > ''){                      					
                      					echo '姓名：'.htmlspecialchars($rs['name']);                      		
                      					echo '<br>';
                      					echo '手機：'.htmlspecialchars($rs['mobile']);
                      					echo '<br>';
                      					echo '地址：'.htmlspecialchars($rs['postal']).' '.htmlspecialchars($rs['address']);
                      			 }else{
                      			 	  echo '未填寫';
                      			 }
                         }else{
                         	   echo '現場領取';
                         }
                     }
                  ?>
                  </td>
                            
                </tr>
                <?php }  ?>
                <input type="hidden" name="break_bid" id="break_bid" value="0">
</table>
</div>


</form>

<form name="PageForm" method="post" action="<?=$this->PATH_INFO?>">
  <?php
  $this->block_service->PJ_ToUrlPageNew("document.PageForm",$PageSize,$Page,$PageCount,$RecordCount)
  ?>
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search,$lot_id,$Follow,$Status)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$lot_id='',$Follow='',$Status = '',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">'; 
              echo '<input type="hidden" name="lot_id" value="'.$lot_id.'">';
              echo '<input type="hidden" name="Follow" value="'.$Follow.'">';
              echo '<input type="hidden" name="Status" value="'.$Status.'">';
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>
<script>
function break_bind(bid){
        $("#break_bid").val('0');
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要刪除重抽？<br><br>', function (e) {  
          if (e) {  
              $("#break_bid").val(bid);
              document.oForm.submit();
          } else {  
           // alertify.log('你按下了 cancel');  
          }  
        });     
}
</script>