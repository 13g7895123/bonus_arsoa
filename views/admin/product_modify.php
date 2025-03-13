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
       action="<?php echo base_url( 'wadmin/product/save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品類別：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">						
						<?=htmlspecialchars($data['wp1_na'])?>
						<?php if ($data["wp2_na"] > ''){ 
                                echo " > ".$data["wp2_na"];
                            }
                            if ($data["wp3_na"] > ''){ 
                                echo " > ".$data["wp3_na"];
                            } ?>    
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品資訊：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['p_no'])?><br>
						<?=htmlspecialchars($data['p_name'])?><br>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品說明1：</label>			
        <div class="col-sm-10">			 
			   <div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="p_title1" id="p_title1" value="<?=$data['p_title1']?>" placeholder="產品說明1">						
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品說明2：</label>			
        <div class="col-sm-10">			 
			   <div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="p_title2" id="p_title2" value="<?=$data['p_title2']?>" placeholder="產品說明2">						
			   </div>		  
			</div>
		</div>
		<?php if ($kind == '2000'){ ?>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">售價：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?php echo number_format($data["c_price"])?><br>BP:<?php echo number_format($data["pv"])?>
			   </div>		  
			</div>
		</div>
		<?php }else{ ?>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">點數：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?php echo number_format($data["m_mp"])?>
			   </div>		  
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品內容：</label>			
        <div class="col-sm-10">			 
			   <div class="col-md-10 grid_box1">
						 <script src="<?php echo base_url('assets/ckeditor/ckeditor.js'); ?>"></script>
			  	 	 <textarea name="body" id="body" style="width:100%" rows="50"
			  	 	    class="form-control1"><?php if (isset($data['body'])){ echo $data['body']; }?></textarea>
             <script>
                CKEDITOR.replace('body' ,{
		             filebrowserImageBrowseUrl : '<?php echo base_url('assets/filemanager/index.html');?>'
	             });
             </script>
			   </div>		  
			</div>
		</div>		
		<?php if ($kind == '2000'){ 
		          if (!isset($data['menu_sort'])|| $data['menu_sort'] == 0){ 
		          	  $data['menu_sort'] = ''; 
		          	  $data['menu_name'] = '';   
		          }  
		          ?>
      <div class="form-group">
		  	<label for="focusedinput" class="col-sm-2 control-label">MENU顯示：</label>			
          <div class="col-sm-8">			 		  	   
		  				<?php if ($data['wp1_no']== '6'){
		  				       ?>
		  				       <div class="col-md-4 grid_box1">
		  				       	輔銷品不能設定
		  				       </div>		
		  				       <?php
		  				}else{
		  				   ?>
		  				       <div class="col-md-3 grid_box1">
		  				          <input type="text" class="form-control" maxlength="1" name="menu_sort" id="menu_sort" onKeyUp="value=value.replace(/[^12]/g,'')" value="<?php echo $data['menu_sort']?>" placeholder="請輸入MENU排 1 或 2">
		  				       </div>		   
		  				       <div class="col-md-5 grid_box1">
		  				       	  <input type="text" class="form-control" maxlength="50" name="menu_name" id="menu_name" value="<?php echo $data['menu_name']?>" placeholder="可輸入顯示的名稱,不輸入將使用產品名稱">
		  				       </div>
		  				<?php 
		  			   } ?>		  	   
		  	</div>
		  </div>      
		<?php } ?>
      <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">Tags：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-8 grid_box1">
						<?php 
						   $params = array(
			  	                 'Name' => 'tags', 
			  	                 'Value' => $data["tags"]
			  	                 );			  	                
               $this->ui->PJ_tags($params);        						
						?>
			   </div>		  
			</div>
		</div>
    
  <br>
  <input type="hidden" name="send" value="OK">
  <?php if (isset($edit)){ ?>
  <input type="hidden" name="edit" value="<?php echo $edit?>">
  <?php } ?>
  <?php if (isset($pid)){ ?>
  <input type="hidden" name="pid" value="<?php echo $pid?>">
  <?php } ?>
  <?php HIDDEN($Swp1,$Search,$Page)?>
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
<?php HIDDEN($Swp1,$Search,$Page)?>
</form> 	

<?php 
/* 共用的參數 */ 
function HIDDEN($Swp1='',$Search='',$Page=1){
          echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          echo '<input type="hidden" name="Search" value="'.$Search.'">';              
          echo '<input type="hidden" name="Swp1" value="'.$Swp1.'">';     
}?>