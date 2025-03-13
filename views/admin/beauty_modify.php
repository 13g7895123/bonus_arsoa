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
  <form name="oForm" class="form-horizontal" role="form" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/beauty/save/'.$kind ); ?>"> 
    
		 <?php                
        if ( $data['Files']  > ''){
            ?>
            <div class="form-group">
              <label for="focusedinput" class="col-sm-2 control-label">照片：</label>			
               <div class="col-sm-8">			 
			      <div class="col-md-4 grid_box1"> 
			        <?php
     				  $filename = APPPATH."public/beauty/".$data['Files'];     					         
                 if (file_exists($filename)){		                            
                       $link = base_url("public/beauty/".$data['Files']);  
     				        echo "<a class=\"group3w\" href=\"".$link."\">";    	                  
         	           $uiparams = array(
         	                 'Folder'   => 'beauty',
         	                 'FileName' => $data['Files'],
         	                 'Style'    => "width: 300px;height:auto",
         	                 'Width'    => 300
         	            );    	                          
                      $this->ui->DisplayObject($uiparams);    	               
         	            echo "</a>";
     				      }
     				      ?>     				  
     				    </div>		  
			</div>
		</div>
     	<?php }?>
     					    
		<div class="form-group">
		  <label for="focusedinput" class="col-sm-2 control-label">暱稱：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['nickname'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">姓名：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['uname'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">性別：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['sex'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">年齡：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['age'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">Email：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['email'])?>
			   </div>		  
			</div>
		</div>
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">職業：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['job'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">地址：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['zip'])?> <?=htmlspecialchars($data['city'])?><?=htmlspecialchars($data['area'])?><?=htmlspecialchars($data['address'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">膚質：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['skin'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">使用效果：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['effect'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">推薦品牌：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['prd_class1'])?> > <?=htmlspecialchars($data['prd_class2'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">主旨：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
						<?=htmlspecialchars($data['subject'])?>
			   </div>		  
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">分享內容：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-12 grid_box1">
						<textarea name="content" cols="100%" rows="16" id="content" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['content']?></textarea>
			   </div>		  
			</div>
		</div>		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font color=red>*</font> 上下架：</label>
    			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<?php
						   $params = array(
			  	           'Name' => 'ifShow', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'radio',
			  	           'Node'=> "//參數設定檔/分享上下架/KIND"
			  	           );			  	           
			  	     if ($data['ifShow'] > '' ){
			  	         $params['Value'] = $data['ifShow'];
			  	     }
               $this->ui->xmlform($params);
           ?>    
					</div>
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">建立時間：</label>
			<div class="col-sm-8"><div class="col-md-2 grid_box1">
						<?php echo date("Y-m-d H:i:s" , strtotime($data['cdate']))?>	
			</div>
			</div>
		</div>
		
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