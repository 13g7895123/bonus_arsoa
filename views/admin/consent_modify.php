<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
    <form name="oForm" class="form-horizontal" role="form" method="post" ENCTYPE="multipart/form-data" language="javascript" 
       action="<?php echo base_url( 'wadmin/consent/save/'.$kind); ?>" onsubmit="return oForm_onsubmit(this);"> 
       	    				
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            同意書名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="c_title" id="c_title" value="<?=$data['c_title']?>" required placeholder="請輸入同意書名稱">						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            同意書說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="c_desc" id="c_desc" value="<?php echo (isset($data['c_desc'])) ? $data['c_desc'] : ''; ?>" placeholder="請輸入同意書說明">
					</div>
			</div>
		</div>
		
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            同意書內容：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<textarea name="c_body" cols="40" rows="20" id="c_body" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['c_body']?></textarea>						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            同意書勾選說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="agree_desc" id="agree_desc" value="<?php if (isset($data['c_config']['agree_desc'])){ echo $data['c_config']['agree_desc']; }?>" required placeholder="請輸入同意書勾選說明">
					</div>
			</div>
		</div>
				
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            同意書開始日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'c_start', 
			  	                        'TheDateValue' => $data['c_start']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;   同意書結束日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'c_end', 
			  	                        'TheDateValue' => $data['c_end']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?></div>
	  	</div>		
		</div>
						
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label" style="margin-top: -5px;"><font class=DMIn>*</font>&nbsp;            狀態：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	           'Name' => 'status', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'radio',
			  	           'Node'=> "//參數設定檔/上下架/KIND",
			  	           'Value' => $data['status']
			  	           );		
                  $this->ui->xmlform($params);
                  ?>      
                  </div>
         </div>
		</div>	
	          
  <br>
  <input type="hidden" name="send" value="OK">
  <input type="hidden" name="Page" value="<?=$Page?>">
  <input type="hidden" name="Search" value="<?=$Search?>">  
  
  <?php if (isset($edit)){ ?>
  <input type="hidden" name="edit" value="<?php echo $edit?>">  
  <?php } ?>
  <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<div id="div_errmsg"  style="display:none;color:red;margin-top: 5px;margin-bottom: 10px;"> 		    
          </div>    
          
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;          
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/consent/list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br>
	 
<br>

<br><br><br>                		 
</form>
<script>
   
	
$(document).ready(function() {
   
   $('.button_consent').on('click', function(e) {      
      
      var anum = parseFloat($("#consent_num").val())+1;
      var ansort = parseFloat($("#consent_sort").val())+1;
      $("#consent_num").val(anum);      
      $("#consent_sort").val(ansort);
      
      var sqlstr1 = '<select id="data_type_'+anum+'" name="data_type_'+anum+'" class="form-control" onChange="change_data_type('+anum+')" style="width:100%"><option value="Y">中獎</option><option value="C">未中獎</option></select>';
      
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                                      
                   '     <td><input type="text" size="3" style="width:50px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+
                   '     <td><input type="text" id="data_title_'+anum+'" name="data_title_'+anum+'" value="" class="form-control"></td>'+
                   '     <td><input type="text" size="3" style="width:80px;" id="data_num_'+anum+'" name="data_num_'+anum+'" value="" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'+anum+'" class="form-control"></td>'+
                   '</tr>';
      $("#consent_list tbody").append(addrow);
            
   });   
});


function del(id){
     $("#qa_" + id).remove();          
}   

function change_data_type(anum)
{
	   var data_class = $("#data_type_"+anum).val();
	   var data_title = $("#data_title_"+anum).val();
	   if (data_title == '' && data_class == 'N'){
	       $("#data_title_"+anum).val('銘謝惠顧');
	   }
}

function oForm_onsubmit(form)
{    
        var check = true;
	      var data_num = parseInt($('#consent_num').val());
	      var data_qa_num = 0;
	      var errmsg = '';
	      var focusstr = '';
	      	      
	      document.getElementById('div_errmsg').style.display="none";
	      	      
	      if (errmsg > ''){
	      	  document.getElementById('div_errmsg').style.display="";
	      	  $('#div_errmsg').html(errmsg);	
	      	  if (focusstr > ''){ 
	      	      $('#'+focusstr).focus();
	      	  }
	      	  check = false;
	      }
	          
	      if (check){
	        //    return true;
	      }else{
              return false;
        }

}
</SCRIPT>