<SCRIPT src="http://localhost/arsoa/public/js/pm.js" type=text/javascript></SCRIPT>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form" ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/question/qa_save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 
    
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            題庫類型：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">
						<select class="form-control" name="classid" id="classid" required>
                <option value="">選擇題庫類型</option>
                <?php foreach ($class as $key => $item){  ?>
                            <option value="<?=$item['classid']?>" <?php if ($data['classid'] == $item['classid']){ echo 'selected'; } ?>><?=$item['classtitle']?></option>
                <?php } ?>                  
            </select>  
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            題目：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="title" id="title" value="<?=$data['title']?>" required placeholder="請輸入題目">
					</div>
			</div>
		</div>
					   
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            題目圖檔：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						   <?php
						      $params = array(
			  	              'Folder' => 'question', 
			  	              'Name'   => 'img',
			  	              'FileName' => $data['img'],
			  	              'Width'   => 800
			  	              );			  	                			  	            
                  $this->ui->UIUpLoadfile($params);      
               ?>
			         <p class="help-block">尺寸寬為 <font color=red>800 px</font> 不限高，
			         檔案格式限 <?php echo "<font color=red>".strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit))."</font>";?>，大小不得超過 
			         <font color=red><?=FC_FileSize?></font> KB</p>			                  
					</div>
			</div>
		</div>
		
		<div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            題目不顯示：</label>
			    <div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="checkbox" name="no_title" id="no_title" value="Y" <?php if ($data['no_title'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="no_title">&nbsp;當有上傳圖檔時才會儲存  </label>
					</div>
			</div>
		</div>
		
		<div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            答案類型：</label>
			    <div class="col-sm-8">
			    <div class="col-md-3 grid_box1">
						    <?php
                  $params = array(
			  	           'Name' => 'ans_config_type', 
			  	           'id' => 'ans_config_type', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'select',
			  	           'Node'=> "//參數設定檔/答案類型/KIND",
			  	           'Value' => $data['ans_config']['type'],
			  	           'Class' => 'form-control',
			  	           'onchange' => 'ans_config_type_change();',
			  	           'All' => 'N'
			  	           );		
                  $this->ui->xmlform($params);
                  ?>      
					</div>
					<div class="col-md-2 grid_box1" id="div_config_set" style="display:none;">
						    <?php
                  $params = array(
			  	           'Name' => 'ans_config_set', 
			  	           'id' => 'ans_config_set', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'select',
			  	           'Node'=> "//參數設定檔/勾選類型/KIND",
			  	           'Value' => (isset($data['ans_config']['set'])) ? $data['ans_config']['set'] : '',
			  	           'Class' => 'form-control',			  	           
			  	           'onchange' => 'ans_config_set_change();',
			  	           'All' => 'N'
			  	           );		
                  $this->ui->xmlform($params);
                  ?>    
					</div>					
					<div class="col-md-3 grid_box1" id="div_config_set_num" style="display:none;">
						   <input type="text" size="3" style="width:85px" id="ans_config_num" name="ans_config_num" value="<?php echo (isset($data['ans_config']['num'])) ? $data['ans_config']['num'] : ''; ?>" placeholder="數字" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control">
					</div>
			</div>
		</div>
		
		<?php 
		$data_num = 0; 
		$data_sort = 0;
		?>
		
		<div class="form-group" id="div_config_set_sel">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            答案設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-12 grid_box1">		
		            <table class="table table-bordered" id="qa_list">
                          <thead>
                              <tr>
                                <th scope="col" width=30></th>
                                <th scope="col" width=80>排序</th>                                            
                                <th scope="col">答案選項</th>                                
                              </tr> 
                           </thead>
                           <tfoot>
                              <tr>
                                <th colspan=3>
                                   <input type="button" class="qa_button_add btn btn-success btn-block" data-rule="required" value="+ 增加答案選項">
                                </th>
                              </tr>
                           </tfoot>      
                           <tbody>             
                           <?php
                           if (isset($data['ans_data']['ans']) && $data['ans_data']['ans'] ){
                               foreach ($data['ans_data']['ans'] as $key => $item){ 
	                                 $data_num++;
	                                 $data_sort++;	                                
	                                 $ada = '<tr id="qa_'.$data_num.'">
                                                <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$data_num.');">X</span></td>                                                
                                                <td><input type="text" size="3" style="width:55px" id="data_sort_'.$data_num.'" name="data_sort_'.$data_num.'" value="'.$data_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
                                                <td><input type="text" style="width:100%" id="data_title_'.$data_num.'" name="data_title_'.$data_num.'" value="'.$item.'" class="form-control"></td>                   
                                           </tr>';
                                   echo $ada;
	                             }
                           }?>                 
                           </tbody>          
                </table>  
               
            </div>		
			</div>
		</div>
		
		     
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label" style="margin-top: -5px;"><font class=DMIn>*</font>&nbsp;            題庫狀態：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	           'Name' => 'status', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'radio',
			  	           'Node'=> "//參數設定檔/題庫狀態/KIND",
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
  <input type="hidden" name="Sclass" value="<?=$Sclass?>">
  
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/question/qa_list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br><br><br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_num?>">
	 <input type="hidden" id="data_sort" name="data_sort" value="<?=$data_sort?>">
</form>
<script>
	
$(document).ready(function() {
   $('.qa_button_add').on('click', function(e) {      
      
      var anum = parseFloat($("#data_num").val())+1;
      var ansort = parseFloat($("#data_sort").val())+1;
      $("#data_num").val(anum);      
      $("#data_sort").val(ansort);
      
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td><input type="text" style="width:100%" id="data_title_'+anum+'" name="data_title_'+anum+'" class="form-control"></td>'+                                      
                   '</tr>';
      $("#qa_list tbody").append(addrow);
            
   });   
});

function ans_config_type_change(){
	 
	 document.getElementById('div_config_set').style.display='none';                 	           	 
	 document.getElementById('div_config_set_num').style.display='none';
	 document.getElementById('div_config_set_sel').style.display='';
   var ans_config_type = $("#ans_config_type").val();   
   if (ans_config_type == 'C'){
       document.getElementById('div_config_set').style.display='';       
       document.getElementById('div_config_set_num').style.display='';      
   }
   if (ans_config_type == 'T' || ans_config_type == 'A'){
	     document.getElementById('div_config_set_sel').style.display='none';
	 }
}

function ans_config_set_change(){
	 
	 document.getElementById('div_config_set_num').style.display='none';                 	 
   var ans_config_type = $("#ans_config_type").val();   
   if (ans_config_type == 'C'){
       document.getElementById('div_config_set_num').style.display='';                 
   }
	
}

<?php if (isset($edit)){ ?>
	ans_config_type_change();
	ans_config_set_change();
<?php } ?>	

function del(id){
     $("#data_title_" + id).val('');     
     $("#qa_" + id).remove();          
}   

function oForm_onsubmit(form)
{    
        var check = true;
	      var data_num = parseInt($('#data_num').val());
	      var data_qa_num = 0;
	      var errmsg = '';
	      var focusstr = '';
	      document.getElementById('div_errmsg').style.display="none";
	      if (data_num > 0){	      	 
	      	 	document.getElementById('div_errmsg').style.display="none";	      	 
	          for (i=1 ; i <= data_num;i++){	          	  
	          	  var h_sort = parseInt($('#data_sort_'+i).val());	          	  
	          	  for (j=1 ; j <= data_num;j++){　
	          	  	  if (i != j){
	          	  	      var csort = parseInt($('#data_sort_'+j).val());
	          	  	      if (csort == h_sort)
	          	  	      {
	          	  	      	 errmsg = '資料排序有同樣的數字';	         
	          	  	      	 if (focusstr ==''){ focusstr = 'data_sort_'+i; } 	       	      	 
	          	  	      }
	          	  	  }
	          	  }
	          	  
	          	  if ($('#data_title_'+i).val() == ''){
	          	      if (errmsg > ''){ errmsg = errmsg+','; }
	          	      errmsg = errmsg+'答案選項未填寫';
	          	      if (focusstr ==''){ focusstr = 'data_title_'+i; }
	          	  }
	          	  if ($('#data_title_'+i).val() > ''){
	          	  	  data_qa_num++;
	          	  }     
             }	      
	      }else{
	      	   if ($("#ans_config_type").val() != 'T' && $("#ans_config_type").val() != 'A'){
	      	       errmsg = '尚未設定答案！';
	      	   }
	      }
	      
	      if ($("#ans_config_type").val() == 'C' && $("#ans_config_set").val() != 'X'){
	      	  if ($("#ans_config_num").val() == '' && $("#ans_config_num").val() <= 0){
	      	      errmsg = '答案類型-數字設定有誤！';	
	      	      if (focusstr ==''){ focusstr = 'ans_config_num'; } 	       	      	 
	      	  }
	      }

	      if (data_qa_num == 0){
	      	  if ($("#ans_config_type").val() != 'T' && $("#ans_config_type").val() != 'A'){
	      	      errmsg = '尚未設定答案！';
	      	  }
	      }
	      
	      if (errmsg > ''){
	      	  document.getElementById('div_errmsg').style.display="";
	      	  $('#div_errmsg').html(errmsg);	
	      	  if (focusstr > ''){ 
	      	      $('#'+focusstr).focus();
	      	  }
	      	  check = false;
	      }
	          
	      if (check){
	            return true;
	      }else{
              return false;
        }

}
</SCRIPT>
<div style="height:900px;"></div>