<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
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

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th></th>
      <th>結果</th>      
      <th>肌膚類型</th>      
      <th>肌膚年齡</th>  
      <th>推薦產品編號</th>  
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
    echo  "<tr><td colspan=8>".$searchstr."</td></tr>";
}else{
		$j=0;
		foreach ( $list['rows'] as $rs ){
			       $j++;	
		          $bgclass= ($j % 2 == 0 ? "active" : "warning");  
                ?>
                <tr class="<?php echo $bgclass?>">
                  <td>
                     <input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/func/skin_ans_modify/'.$kind ); ?>?edit=<?php echo $rs["id"]?>';" alt="編輯" border="0" >
                     &nbsp;|&nbsp;
                     <a class="btn btn-xs btn-default" href="<?php echo base_url( 'Skin_test/ans/'.$rs["id"]); ?>" alt="預覽" border="0" target="_skin">預覽</a>
                  </td>
                  <td><?php echo htmlspecialchars($rs["id"])?></td>
                  <td><?php echo htmlspecialchars($rs["stype"])?></td>
                  <td><?php echo htmlspecialchars($rs["age"])?></td>   
                  <td><?php echo htmlspecialchars($rs["pid"])?></td>   
                  <td><?php echo $this->block_service->PF_FD($rs["updt"])?></td>
                  <td><?php echo $rs["account"]?></td>                               
                </tr>
                <?php }  ?>
</table>
</div>
</form>

<?php } ?>
</div>

</div>
