<?php
$selstr1 = '';
foreach($qa_class as $st_key => $st_value) {
        $selstr1 .= '<option value="'.$st_value['classid'].'">'.$st_value['classtitle'].'</option>';
}
$disabled = '';
if ($reply_count > 0){
	  $disabled = ' disabled';
}
?>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form" ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/question/save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 
    
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            問卷類型：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">
						<select class="form-control" name="classid" id="classid" required <?=$disabled?>>
                <option value="">選擇問卷類型</option>
                <?php foreach ($class as $key => $item){  ?>
                            <option value="<?=$item['classid']?>" <?php if ($data['classid'] == $item['classid']){ echo 'selected'; } ?>><?=$item['classtitle']?></option>
                <?php } ?>                  
            </select>  
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            問卷名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="q_title" id="q_title" value="<?=$data['q_title']?>" required placeholder="請輸入問卷名稱">
						所有設備皆斷行<?=htmlspecialchars('<br>') ?><br>
            手機上才斷行<?=htmlspecialchars("<br class='d-block d-md-none'>") ?>
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            問卷前言：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="q_desc" id="q_desc" value="<?php echo (isset($data['q_desc'])) ? $data['q_desc'] : ''; ?>" placeholder="請輸入問卷前言">
					</div>
			</div>
		</div>
		
		<div class="form-group">
		    	<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp; 活動日期：</label>
			    <div class="col-sm-8"><div class="col-md-8 grid_box1">
			    	<?php
						          $params = array(
			  	                        'TheDateField' => 'q_date', 
			  	                        'TheDateValue' => $data['q_date']
			  	                        );			  	                
                      $this->ui->PJ_JInputDate('date',$params);      
            ?>
					</div>
			</div>
		</div>
		
		<div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            問卷設定：</label>
			    <div class="col-sm-9"><div class="col-md-8 grid_box1">
						<input type="checkbox" name="q_config_member" id="q_config_member" value="Y" <?php if (isset($data['q_config']['member']) && $data['q_config']['member'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="q_config_member">&nbsp;有綁定 Line的安露莎會員 才可填寫  </label>
						<br>
						<table style="border-spacing: 5px;border-collapse: separate;">
							<tr>
								<td>問卷字色：</td>
								<td colspan=3>
						      <input type="text" class="form-control" style="width:200px" maxlength="6" name="color_font" id="color_font" value="<?php if (isset($data['q_config']['color_font'])){ echo $data['q_config']['color_font']; }?>">
						    </td>
						  </tr>						  
						  <tr>
								<td>問卷框色：</td>
								<td colspan=3>
						      <input type="text" class="form-control" style="width:200px" maxlength="6" name="color_border" id="color_border" value="<?php if (isset($data['q_config']['color_border'])){ echo $data['q_config']['color_border']; }?>">
						    </td>
						  </tr>
						  <tr>
								<td>問卷底色(單)：</td>
								<td>
						      <input type="text" class="form-control" style="width:200px" maxlength="6" name="color_background1" id="color_background1" value="<?php if (isset($data['q_config']['color_background1'])){ echo $data['q_config']['color_background1']; }?>">
						    </td>
						    <td>問卷底色(雙)：</td>
								<td>
						      <input type="text" class="form-control" style="width:200px" maxlength="6" name="color_background2" id="color_background2" value="<?php if (isset($data['q_config']['color_background2'])){ echo $data['q_config']['color_background2']; }?>">
						    </td>
						  </tr>
						</table>  
					</div>
			</div>
		</div>
					
		<?php 
		$data_num = 0; 
		$data_sort = 0;
		?>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            題庫設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-12 grid_box1">		
		            <table class="table table-bordered" id="qa_list">
                          <thead>
                              <tr>
                              	<?php if ($disabled == ''){ ?>
                                <th scope="col" width=30></th>
                                <?php } ?>
                                <th scope="col" width=80>排序</th>                                            
                                <th scope="col" width=280>題庫類型</th>                      
                                <th scope="col">題庫</th>
                                <th scope="col" width=60>必填</th>
                              </tr> 
                           </thead>
                           
                           <tfoot>
                              <tr>
                                <th colspan=5 align=center>
                                	<?php if ($disabled == ''){ ?>
                                      <input type="button" class="button_add btn btn-success btn-block" data-rule="required" value="+ 增加答案選項">
                                  <?php }else{ ?>    
                                          <center><font color=red>已有人填寫，故無法修改題庫 </font></center>
                                  <?php } ?>    
                                </th>
                              </tr>
                           </tfoot>                                 
                           <tbody>             
                           <?php   
                           $script1 = '';  
                           $script2 = '';  
                           if (isset($data['q_data']) && $data['q_data'] ){
                               foreach ($data['q_data'] as $key => $item){ 
	                                 
	                                 $data_num++;
	                                 $data_sort++;	                                
	                                 $checked = '';
	                                 if ($item['required'] == 'Y'){
	                                 	   $checked = ' checked';
	                                 }
	                                 
	                                 $ada = '<tr id="qa_'.$data_num.'">';
                                                
                                   if ($disabled == ''){              
                                       $ada .= '<td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$data_num.');">X</span></td>';
                                   }
                                   $ada .= '<td><input type="text" size="3" style="width:50px" id="data_sort_'.$data_num.'" '.$disabled.' name="data_sort_'.$data_num.'" value="'.$data_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
                                                <td>
                                                   <select id="qa_class_'.$data_num.'" name="qa_class_'.$data_num.'" '.$disabled.' class="form-control" onChange="change_qa_class('.$data_num.')" style="width:100%">
                                                      <option value="">請選擇題庫類型</option>';
                                                      
                                   foreach($qa_class as $st_key => $st_value) {
                                           $selected = '';
	                                         if (isset($item['classid']) && $item['classid'] == $st_value['classid']){
	                                         	   $selected = ' selected';
	                                         }
                                           $ada .= '<option value="'.$st_value['classid'].'" '.$selected.'>'.$st_value['classtitle'].'</option>';
                                   }                
                                   
                                   $ada .=     '</select></td>
                                                 <td>
                                                 <select id="qaid_'.$data_num.'" name="qaid_'.$data_num.'" '.$disabled.' class="form-control" style="width:100%">';
                                                 $ada .=  '<option value="">請選擇題庫</option>';
                                   foreach ($qq_class[$item['classid']] as $sc_key => $sc_value){
                                   	        $selected = '';
                                   	        if ($sc_value['qa_id'] == $item['qaid']){
                                   	        	  $selected = ' selected';
                                   	        }                                   	        	                                         
                                   	        $ada .=  '<option value="'.$sc_value['qa_id'].'"'.$selected.'>('.$sc_value['qa_id'].') '.$sc_value['title'].'</option>';
                                   }
                                   $ada .=        '</select>                                                 
                                                 </td>
                                                 <td><input type="checkbox" id="qa_required_'.$data_num.'" '.$disabled.' name="qa_required_'.$data_num.'" '.$checked.' value="Y"></td>
                                           </tr>';
                                   echo $ada;
                                   
                                   //$script1 .= 'change_qa_class('.$data_num.');';
                                   //$script2 .= '$("#qaid_'.$data_num.'").val("'.$item['qaid'].'");';
	                             }
                           }?>                 
                           </tbody>          
                </table>  
               
            </div>		
			</div>
		</div>
		
		     
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label" style="margin-top: -5px;"><font class=DMIn>*</font>&nbsp;            問卷狀態：</label>
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
	 <div class="panel-footer">
	   <font color=red>※注意事項：</font><br>
	   1.問卷儲存後其選擇的題庫，如有異動請重新儲存問卷。<br>
	   2.當有人填寫過問卷，此問卷題庫設定將無法更動。<br>
	   3.刪除問卷全部的填寫記錄，問卷將可修改。<br>
	 </div>
	 <br><br><br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_num?>">
	 <input type="hidden" id="data_sort" name="data_sort" value="<?=$data_sort?>">
</form>
<script>
   
	
$(document).ready(function() {
   $('.button_add').on('click', function(e) {      
      
      var anum = parseFloat($("#data_num").val())+1;
      var ansort = parseFloat($("#data_sort").val())+1;
      $("#data_num").val(anum);      
      $("#data_sort").val(ansort);
      
      var sqlstr1 = '<select id="qa_class_'+anum+'" name="qa_class_'+anum+'" class="form-control" onChange="change_qa_class('+anum+')" style="width:100%"><option value="">請選擇題庫類型</option><?=$selstr1?></select>';
            
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                   
                   '     <td><input type="text" size="3" style="width:50px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+
                   '     <td><select id="qaid_'+anum+'" name="qaid_'+anum+'" class="form-control" style="width:100%"></select></td>'+                   
                   '     <td><input type="checkbox" id="qa_required_'+anum+'" name="qa_required_'+anum+'" checked value="Y"></td>'+
                   '</tr>';
      $("#qa_list tbody").append(addrow);
            
   });   
});

function change_qa_class(num)
{
        //變動第一個下拉選單 
        $('#qaid_'+num).empty().append($('<option></option>').val('').text('請選擇題庫'));        
        var qa_class = $.trim($('#qa_class_'+num+' option:selected').val());        
        if(qa_class.length != 0)
        {
            $.getJSON('<?=base_url('wadmin/question/qa_select/')?>'+ qa_class, function(data)
            {
                $.each(data, function(i, item){
                    $('#qaid_'+num).append($('<option></option>').val(item.qa_id).text('('+item.qa_id+') '+item.title));
                });
            });      
        }
}

function del(id){
     $("#qaid_" + id).val('');     
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
	          	  if  ($('#qa_'+i).length > 0) {
	          	       var qaid = $.trim($('#qaid_'+i+' option:selected').val());
	          	       if (qaid == ''){
	          	           if (errmsg > ''){ errmsg = errmsg+','; }
	          	           errmsg = errmsg+'	題庫未選擇';
	          	           if (focusstr ==''){ focusstr = 'qaid_'+i; }
	          	       }else{
	          	       	   for (j=1 ; j <= data_num;j++){　
	          	           	  if (i != j){
	          	           	      var cqaid = parseInt($.trim($('#qaid_'+j+' option:selected').val()));
	          	           	      if (cqaid == qaid)
	          	           	      {
	          	           	      	 errmsg = '選擇題庫有重覆';	         
	          	           	      	 if (focusstr ==''){ focusstr = 'qaid_'+i; } 	       	      	 
	          	           	      }
	          	           	  }
	          	           }
	          	       	   data_qa_num++;
	          	       }     
	          	  }
             }	      
	      }else{
	      	   errmsg = '尚未設定題庫！';
	      }
	      
	      if (data_qa_num == 0){
	      	  errmsg = '尚未設定題庫！';
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
<?=$script1?>
window.onload = function() {
  <?=$script2?>
};  
</SCRIPT>

<div style="height:900px;"></div>