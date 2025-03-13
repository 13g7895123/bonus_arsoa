<SCRIPT language=JavaScript>
function oForm_onsubmit(oform){
   PF_FieldDisabled(form)//將全部button Disabled
   return true;
}
</SCRIPT>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind)?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/feedback_save/'.$kind.'/'.$ftype ); ?>" onsubmit="return oForm_onsubmit(this);"> 
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">姓名：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['name'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">手機：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['phone'])?>
			   </div>		  
			</div>
		</div>
	<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font color=red>*</font> 電子郵件：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="email" class="form-control" maxlength="100" name="email" id="email" required value="<?php echo $data['email']?>" placeholder="請輸入Email">
					</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">詢問標題：</label>
			<div class="col-sm-8"><div class="col-md-2 grid_box1">
						<?php echo htmlspecialchars($data['title'])?>	
			</div>
			</div>
		</div>
      <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">詢問內容：</label>
			<div class="col-sm-8"><div class="col-md-2 grid_box1">
						<?php echo $this->block_service->PF_Vbcrlf(htmlspecialchars($data['memo']))?>	
			</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">詢問時間：</label>
			<div class="col-sm-8"><div class="col-md-2 grid_box1">
						<?php echo date("Y-m-d H:i:s" , strtotime($data['crdt']))?>	
			</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font color=red>*</font> 回覆信件主旨：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="retitle" id="retitle" required value="<?php echo $data['retitle']?>" placeholder="請輸入回覆信件主旨">
					</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font color=red>*</font> 回覆信件主旨：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<textarea name="rebody" cols="40" rows="20" id="rebody" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['rebody']?></textarea>
						  <font color=red>將寄電子郵件回覆</font>
					</div>
			</div>
		</div>
		

<?php if ($data['redate'] > ''){?>
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">最近回應時間：</label>
			<div class="col-sm-8"><div class="col-md-2 grid_box1">
						<?php echo date("Y-m-d H:i:s" , strtotime($data['redate']))?>	
			</div>
			</div>
		</div>		
<?php }?>
    
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
          <?php if ($_SESSION['admin_session']['admin_status'] == '999'){ ?>
          <input type="button" value="回上一頁" onClick="document.GoBackForm.submit()" class="btn btn-info">          
          <?php } ?>
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