<?php

if (!isset($data['name'])){
    $data['name'] = ''; 
}
if (!isset($data['email'])){
    $data['email'] = ''; 
}
if (!isset($data['status'])){
    $data['status'] = '2'; 
}

?>

<SCRIPT language=JavaScript>
function oForm_onsubmit(oform){
   if (oform.pwd.value.length > 0){
       if (oform.pwd.value != oform.pwd1.value ) {
           alert('密碼與確認密碼不符！');
           oform.pwd1.focus();
           return false;
       }
   }   
   return true;
}
</SCRIPT>
<div id="page-wrapper">
	<div class="graphs">
    <?php 
     if ($_SESSION['admin_session']['admin_status'] == '999'){ 
         echo $this->block_service->PJ_PageTitle($this->XmlDoc,$kind); 
     }else{
         ?>
         <div class="but_list">
  	         <ol class="breadcrumb">
  	          <li>個人資料設定</li>  	         
  	         </ol>  	
         </div>   
         <?php
     }
    ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/admin_save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 

    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">帳號：</label>			
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
				<?php if ($edit==""){
				            $passstr = "請輸入密碼，長度必須在4到15個字元﹝英文字母或任一數字均算一個字元，請勿使用空白鍵﹞";
				            $passrequired = "required";
				            ?>
				            <input type="text" class="form-control" maxlength="15" name="account" id="account" required placeholder="請輸入帳號，長度必須在4到15個字元﹝英文字母或任一數字均算一個字元，請勿使用空白鍵﹞">					        
        <?php }else{ 
                    $passstr = "如欲修改密碼，可輸入新密碼即可更改！";
                    $passrequired = "";
                    ?>
                    <input type="text" class="form-control" name="account" id="account" value="<?=$data['account']?>" readonly>
                  <?php
              }?></div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">密碼：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<input type="password" class="form-control" maxlength="15" name="pwd" id="pwd" autocomplete="off" data-toggle="tooltip" data-placement="bottom" placeholder="<?=$passstr?>"<?=$passrequired?>>
			   </div>		  
			</div>
		</div>
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">確認密碼：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="password" class="form-control" maxlength="15" name="pwd1" id="pwd1" autocomplete="off" placeholder="請再輸入密碼！">
					</div>
			</div>
		</div>
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">姓名：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="text" class="form-control" maxlength="15" name="name" id="name" value="<?=$data['name']?>" required placeholder="請輸入姓名">
					</div>
			</div>
		</div>
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">Email：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="email" class="form-control" maxlength="100" name="email" id="email" value="<?=$data['email']?>" placeholder="請輸入Email">
					</div>
			</div>
		</div>
    <?php 
       if ($_SESSION['admin_session']['admin_status'] == '999'){
    ?>
              <div class="form-group">
		          	<label for="inputPassword" class="col-sm-2 control-label">角色：</label>
		          	<div class="col-sm-8"><div class="col-md-12 grid_box1">
		          		<?php
		          		 $params = array(
			  	           'Name'   => 'status', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'   => 'radio',
			  	           'Node'   => "//參數設定檔/角色/KIND",
			  	           'Value'  => $data['status']			  	           
			  	         );
			  	         $this->ui->xmlform($params);
                  ?></div>
		          	</div>
		          </div>
    <?php 
       }
    ?>
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