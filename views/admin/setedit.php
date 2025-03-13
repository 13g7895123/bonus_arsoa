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
<?php if (isset($okmsg) && $okmsg > ""){ ?>   
   <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>成功！</strong>&nbsp;<?php echo $okmsg?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>

<div class="panel-body panel-body-inputin">
<form name="oForm" class="form-horizontal" method="post" language="javascript" action="<?php echo base_url( 'wadmin/admin/setsave/'.$kind ); ?>" > 
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<div class="alert alert-danger" role="alert">
 文字框內的值請勿填寫 <strong>雙引號、大於、小於、分號</strong>
</div>
<?php

for ($i = 0;$i<count($set);$i++){ 	
	$set[$i]=trim($set[$i]);
	if ($set[$i]!='' && substr_count($set[$i],"?")==0){
		if (substr($set[$i],0,2)=='//'){
	?>
	 <div class="alert alert-info" role="alert">
					<?php echo substr($set[$i],2,strlen($set[$i]))?>
    </div>
	<?php
		}else{
			$GLOBALS["str"]=$set[$i];
			$fieldname="";
			$fieldvalue="";
			$fieldtitle="";
			$fieldmemo="";
			//$fieldtitle=substr($array[$i],2,strlen($array[$i]));
			//$DBString['DB_TYPE']="MySql";					//資料庫種類
			if (substr($set[$i],0,6)=='DEFINE'){					
					$typ="DEFINE";	
					$fieldname=$this->block_service->PF_GetStr($GLOBALS["str"],"\"","\"",1);
					$fieldvalue=$this->block_service->PF_GetStr($GLOBALS["str"],",\"","\"",1);	
					$fieldtitle=$this->block_service->PF_GetStr($GLOBALS["str"],"//","",1);	
					if (substr_count($fieldtitle,"(")>0){					
						$fieldtitle=$this->block_service->PF_GetStr($fieldtitle,"","(",1);	
						$fieldmemo=$this->block_service->PF_GetStr($GLOBALS["str"],"",")",1);	
					}
			}else{
					$typ=$this->block_service->PF_GetStr($GLOBALS["str"],"$","[",1);	
					$fieldname=$this->block_service->PF_GetStr($GLOBALS["str"],"['","']",1);
					$fieldvalue=$this->block_service->PF_GetStr($GLOBALS["str"],"\"","\"",1);	
					//PF_print($GLOBALS["str"]);
					$fieldtitle=$this->block_service->PF_GetStr($GLOBALS["str"],"//","",1);	
					if (substr_count($fieldtitle,"(")>0){					
						$fieldtitle=$this->block_service->PF_GetStr($fieldtitle,"","(",1);	
						$fieldmemo=$this->block_service->PF_GetStr($GLOBALS["str"],"",")",1);	
					}
					
			}	
		
?>
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><?php echo $fieldtitle?>：</label>
			<div class="col-md-3 grid_box1">
						<input type="text" class="form-control" name="<?php echo $fieldname?>" id="<?php echo $fieldname?>" value="<?php echo htmlspecialchars($fieldvalue)?>" placeholder="<?php echo $fieldmemo?>">
					
			</div>
		</div>
		
<?php
		}		
	}
} 
?>
	</div>

<table width="98%" align=center border="0" cellspacing="1" cellpadding="0" >
<tr>
<td colspan=2 style="text-align:center;">
<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">

<input type="reset" value="取消" class="btn btn-info">

<input type="hidden" name="send" value="OK">
</td>
</tr></table><br><br>

</form>
</div>