<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind)?>
  </div> 
  <?php if (isset($ok_message) && $ok_message > ""){ ?>   
   <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>成功！</strong>&nbsp;<?php echo $ok_message?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/admin_closepay/'.$kind ); ?>"> 
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">提前通知：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">
					 <select name='dh' class="form-control" style="width:280px">
           <?php
             for ($i = 0;$i <= 6;$i++){
                 $selected = "";
                 if ($i == $data['dh']){
                     $selected = " selected";
                 }
                 ?>
                 <option value="<?=$i?>"<?=$selected?>><?=$i?> 小時</option>
            <?php
            }  ?>
              </select>
			   </div>		  
			</div>
		</div>
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">鎖定時間起：</label>
			    <div class="col-sm-8"><div class="col-md-4 grid_box1">
					<?php
						$params = array(
			  	                        'TheDateField' => 'stdt', 
			  	                        'TheDateValue' => $data['stdt'],
			  	                        'Required' => 'Y'
			  	                        );			  	                
            $this->ui->PJ_JInputDate('datetime',$params); 
						?>	
					</div>
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">鎖定時間迄：</label>
			    <div class="col-sm-8"><div class="col-md-4 grid_box1">
						<?php
						$params = array(
			  	                        'TheDateField' => 'eddt', 
			  	                        'TheDateValue' => $data['eddt'],
			  	                        'Required' => 'Y'
			  	                        );			  	                
            $this->ui->PJ_JInputDate('datetime',$params); 
						?>
					</div>
			</div>
		</div>
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">是否啟用：</label>
			    <div class="col-sm-8"><div class="col-md-4 grid_box1">
						  <?php
						   $params = array(
			  	           'Name' => 'chk', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=>'radio',
			  	           'Node'=> "//參數設定檔/啟用/KIND",
			  	           'Value' => $data['chk']
			  	           );			  	     
               $this->ui->xmlform($params);
               ?>
					</div>
			</div>
		</div>		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">最後修改時間：</label>
			    <div class="col-sm-8"><div class="col-md-4 grid_box1">
						  <?php echo $data['updt']?>
					</div>
			</div>
		</div>	
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">最後修改人：</label>
			    <div class="col-sm-8"><div class="col-md-4 grid_box1">
						  <?php echo $data['account']?>
					</div>
			</div>
		</div>	
  <br>
  <input type="hidden" name="send" value="OK">  
  <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;       
				</div>
			</div>
	 </div>
	 <br><br><br>
</form>