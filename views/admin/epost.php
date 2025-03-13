<?php


?>

<script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
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
<form name="oForm" class="form-horizontal" method="post" language="javascript" action="<?php echo base_url( 'wadmin/func/epost/'.$kind ); ?>" > 
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<?php
/*
if ($url > '' && $url <> $edit){
    echo "<div align=center>";
    echo "<a href=\"../".$url."\" target=_blank>";
    echo "瀏覽線上網頁</a><br> ";
    echo "</div>";
}
*/
?>
<div class="form-group">
	<label for="focusedinput" class="col-sm-2 control-label">內容：</label>
	<div class="col-sm-8"><div class="col-md-12 grid_box1">
<?php
if ($type == 'html'){
    ?>
    <textarea name="epostbody" id="epostbody" cols="70" rows="40" class="form-control1"><?php if (isset($epostbody)){ echo $epostbody; }?></textarea>
    <script>
       CKEDITOR.replace('epostbody' ,{
		    filebrowserImageBrowseUrl : '<?php echo base_url('assets/filemanager/index.html');?>'
	    });
    </script>
    <?php
}else if ($type == 'line'){	?>
	  <input type="text" name="epostbody" class="form-control" value="<?php echo $epostbody?>">
<?php	 
}else{	
?>
    <textarea name="epostbody" style="width:100%" class="form-control" rows="25" ><?php echo $epostbody?></textarea>
<?php
}?>
	</div>
	</div>
</div>
<br>
<div class="panel-footer">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2" align=center>
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;
          <input type="button" value="回上一頁" onClick="document.GoBackForm.submit()" class="btn btn-info">          
				</div>
			</div>
</div>	  
<input type="hidden" name="send" value="OK">
</td>
</tr></table><br><br>

</form>
</div>