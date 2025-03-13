<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;"></div>
  <div>    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="Swp1" id="Swp1" style="border-color: #8a6d3b;">
           <option value="A" <?php if ($Swp1 == 'A' || $Swp1 == ''){ echo 'selected'; } ?>>全部主分類</option>
           <?php foreach ($wp1 as $key => $item){  ?>
                       <option value="<?=$item['wp1_no']?>" <?php if ($Swp1 == $item['wp1_no']){ echo 'selected'; } ?>><?=$item['wp1_na']?></option>
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
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Swp1,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>&nbsp;</th>      
      <th>產品分類</th>
      <th>產品編號</th>
      <th>產品名稱</th>
      <?php if ($kind == '2000'){ ?>
      <th>建議售價</th>
      <th>MENU顯示</th>      
      <?php }else{ ?>
      <th>點數</th>
      <?php } ?> 
      <th>瀏覽數</th>      
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
                ?>
                <tr class="<?php echo $bgclass?>">
                 <td>
                   <input  type="submit" value="編輯" class="btn btn-xs btn-default" onclick="javascript:action='<?php echo base_url( 'wadmin/product/modify/'.$kind ); ?>?edit=<?php echo $rs["p_no"]?>';" alt="編輯" border="0" >                   
                   &nbsp;|&nbsp;
                   <?php if ($kind == '2000'){ ?>
                   <a class="btn btn-xs btn-default" href="<?php echo base_url( 'product/'.$rs["p_no"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                   <?php }else{ ?>  
                   <a class="btn btn-xs btn-default" href="<?php echo base_url( 'reward/product/'.$rs["p_no"]); ?>" alt="預覽" border="0" target="_prd">預覽</a>
                   <?php } ?>
                 </td>
                 <td>
                      <?php echo htmlspecialchars($rs["wp1_na"])?>
                      <?php if ($rs["wp2_na"] > ''){ 
                                echo " > ".$rs["wp2_na"];
                            }
                            if ($rs["wp3_na"] > ''){ 
                                echo " > ".$rs["wp3_na"];
                            } ?>                  
                 </td>
                 <td><?php echo htmlspecialchars($rs["p_no"])?></td>
                 <td><?php echo htmlspecialchars($rs["p_name"])?></td>   
                 <?php if ($kind == '2000'){ ?>
                           <td><?php echo number_format($rs["c_price"])?><br>BP:<?php echo number_format($rs["pv"])?></td>
                           <td><?php  
                                if (isset($rs["menu_sort"]) && $rs["menu_sort"] > 0){
                                    echo $rs["menu_sort"]; 
                                    echo '<br>';
                                    echo $rs["menu_name"];
                                }?></td>                          
                 <?php }else{ ?>
                           <td><?php echo number_format($rs["m_mp"])?></td>
                 <?php } ?>
                 <td><?=number_format($rs["hits"])?></td>
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
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search,$Swp1)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$Swp1='',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">';
              echo '<input type="hidden" name="Swp1" value="'.$Swp1.'">';
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>