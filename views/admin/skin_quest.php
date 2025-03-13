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

<div class="tab-pane active" id="horizontal-form">
<!--傳給下一頁的參數-->

<?php for ($i = 1;$i<=15;$i++){ 
              $qtitle = "題目".$i;
              if ($i == 12){
                  $qtitle = "A選項";
              }
              if ($i == 13){
                  $qtitle = "B選項";
              }
              if ($i == 14){
                  $qtitle = "C選項";
              }
              if ($i == 15){
                  $qtitle = "D選項";
              }
             
              ?>
			        <div class="form-group">
                <label for="exampleFormControlInput1"><?=$qtitle?>：</label>
                <input type="text" class="form-control" name="question<?=$i?>" id="question<?=$i?>" value="<?=$skin_data['question'.$i]?>" required placeholder="請輸入<?=$qtitle?>" maxlength="50" >
              </div>
<?php } ?>
</div>
   <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<input type="submit" value="確定修改" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="重設" class="btn btn-info">&nbsp;&nbsp;          
				</div>
			</div>
	 </div>
<br><br>

</form>

</div>