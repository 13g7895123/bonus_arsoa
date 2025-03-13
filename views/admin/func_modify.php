<SCRIPT src="<?php echo base_url('public/js/pm.js')?>" type=text/javascript></SCRIPT>
<SCRIPT language=JavaScript>
function oForm_onsubmit(form){    
<?php $this->block_service->PM_onsubmit($Xmlspec)?>
PF_FieldDisabled(form);
}
</SCRIPT>

<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/func_save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 

  <?php $this->block_service->PM_Modify($Xmlspec,$pmdata)?>
  <br>
  <input type="hidden" name="send" value="OK">
  <?php if (isset($edit)){ ?>
  <input type="hidden" name="edit" value="<?php echo $edit?>">
  <?php } ?>
  <?php HIDDEN($Search,$Page)?>
  <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;
          <input type="button" value="回上一頁" onClick="document.GoBackForm.submit()" class="btn btn-info">          
				</div>
			</div>
	 </div>
	 <br><br><br>
</form>

<base target="_self">
<form name="GoBackForm"  method="post" language="javascript" action="<?php echo $GoBackUrl?>">
<?php HIDDEN($Search,$Page)?>
</form> 	

<?php 
/* 共用的參數 */ 
function HIDDEN($Search='',$Page=1){
          echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          echo '<input type="hidden" name="Search" value="'.$Search.'">';              
}?>