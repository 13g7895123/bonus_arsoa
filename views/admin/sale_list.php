<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/func/sale_modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增" class="btn btn-sm btn-success warning_3">
       <?php HIDDEN($this->PATH_INFO,"AddSubmit")?>
    </form>
    <!-- 新增機制 E -->       
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
      <th></th>
      <th>販促編號</th>      
      <th>圖片</th>      
      <th>標題</th>
      <th>產品</th>
      <th>活動時間</th>      
      <th>上下架時間</th>      
      <th>狀態</th>
      <th>順序</th>
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
                ?>
                <tr class="<?php echo $bgclass?>">
                  <td>
                     <input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/func/sale_modify/'.$kind ); ?>?edit=<?php echo $rs["id"]?>';" alt="編輯" border="0" >
                  </td>
                  <td><?php echo htmlspecialchars($rs["id"])?></td>
                  <td>
                  <?php                
                  if ( $rs['field1']  > ''){
     					     $filename = APPPATH."public/func/".$rs['field1'];     					         
                       if (file_exists($filename)){		                            
                           $link = base_url("public/func/".$rs['field1']);  
     					           echo "<a class=\"group3w\" href=\"".$link."\">";    	                  
         	                 $uiparams = array(
         	                       'Folder'   => 'func',
         	                       'FileName' => $rs['field1'],
         	                       'Style'    => "width: 300px;height:auto",
         	                       'Width'    => 300
         	                  );    	                          
                            $this->ui->DisplayObject($uiparams);    	               
         	                  echo "</a>";
     					         }
     					    }?>
                  </td>
                  <td><?php echo htmlspecialchars($rs["title"])?></td>
                  <td><?php 
                      if ($rs['product'] > ''){
                          $prddata = json_decode($rs['product'], true);              
                          foreach ($prddata as $p_no => $num){
                                   echo $p_no;
                                   echo '&nbsp;數量：';
                                   echo $num;
                                   echo '<br>';
                          }
                      }
                     ?></td>
                  <td><?php echo $rs["show_stdt"]?><br><?php echo $rs["show_eddt"]?></td>                     
                  <td><?php echo $rs["begindate"]?><br><?php echo $rs["closedate"]?></td>                  
                  <td><?php if ($rs["nshow"]=='Y'){ echo '上架';}else{echo '下架';}?></td>
                  <td><?php echo $rs["sale_sort"]?></td>
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
