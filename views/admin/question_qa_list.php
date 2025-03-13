<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
    <!-- 新增機制 S -->    
    <form name="AddoForm" method="post" action="<?php echo base_url( 'wadmin/question/qa_modify/'.$kind ); ?>">    
       <input type="submit" name="AddSubmit" value="新增題庫" class="btn btn-sm btn-success warning_3">
       <?php HIDDEN($this->PATH_INFO,"AddSubmit")?>
    </form>
    <!-- 新增機制 E -->       
  </div>
  <div>    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="Sclass" id="Sclass" style="border-color: #8a6d3b;">
           <option value="" <?php if ($Sclass == '' || $Sclass == ''){ echo 'selected'; } ?>>全部題庫類型</option>
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
      <th>題庫編號</th>    
      <th>題庫類型</th>
      <th>題目</th>      
      <th>題庫設定</th>
      <th>狀態</th>
      <th>最後修改日期</th>
      <th>最後修改人</th>
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
		            $ans_config = json_decode($rs['ans_config'], true);
                ?>
                <tr class="<?php echo $bgclass?>">
                 <td>
                   <input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/question/qa_modify/'.$kind ); ?>?edit=<?php echo $rs["qa_id"]?>';" alt="編輯" border="0" >                                      
                   &nbsp;|&nbsp;
                   <input  type="submit" value="複製" class="btn btn-xs btn-info" style="height:20px;width:34px;font-size: 12px;padding: .1rem .2rem;vertical-align: middle;text-align: center;" onclick="javascript:action='<?php echo base_url( 'wadmin/question/qa_modify/'.$kind ); ?>/C?edit=<?php echo $rs["qa_id"]?>';" alt="複製" border="0" >                                      
                 </td>
                 <td>
                      <?php echo $rs["qa_id"]?>                      
                 </td>   
                 <td>
                      <?php echo $classtitle[$rs["classid"]]?>                      
                 </td>                
                 <td>
                      <?php echo htmlspecialchars($rs["title"])?>                      
                 </td>                
                 <td>
                      <?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/答案類型/KIND/傳回值","資料",$ans_config['type'])?>
                      
                      <?php 
                      if ($ans_config['type'] == 'C'){
                      	  echo '(';
                      	  echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/勾選類型/KIND/傳回值","資料",$ans_config['set']);
                      	  echo ' ';
                      	  echo $ans_config['num'];
                      	  echo ' 筆)';
                      }
                      ?>
                 </td>                
                 <td><?php echo $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/題庫狀態/KIND/傳回值","資料",$rs["status"])?></td>
                 <td><?php echo $this->block_service->PF_FD($rs["updt"])?></td>
                 <td><?php echo $rs["account"]?></td>                 
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