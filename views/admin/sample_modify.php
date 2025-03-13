<?php
$selstr1 = '';
foreach($question as $st_key => $st_value) {
        $selstr1 .= '<option value="'.$st_value['q_id'].'">('.$st_value['q_id'].') '.$st_value['q_title'].'</option>';
}
?>  
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
    <form name="oForm" class="form-horizontal" role="form" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/sample/save/'.$kind); ?>" onsubmit="return oForm_onsubmit(this);"> 
       	    
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            產品編號：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="8" name="p_no" id="p_no" value="<?php echo (isset($data['p_no'])) ? $data['p_no'] : ''; ?>" placeholder="請輸入產品編號">
					</div>
			</div>
		</div>
				
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            試用組名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="s_title" id="s_title" value="<?=$data['s_title']?>" required placeholder="請輸入試用組名稱">						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            試用組說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="s_desc" id="s_desc" value="<?php echo (isset($data['s_desc'])) ? $data['s_desc'] : ''; ?>" placeholder="請輸入試用組說明">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            申請成功Line訊息標題：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="line_title" id="line_title" value="<?php echo (isset($data['line_title'])) ? $data['line_title'] : ''; ?>" required placeholder="請輸入申請成功Line訊息標題">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;           申請成功Line訊息：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="line_msg" id="line_msg" value="<?php echo (isset($data['line_msg'])) ? $data['line_msg'] : ''; ?>" required placeholder="請輸入申請成功Line訊息">
					</div>
			</div>
		</div>
		
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            索取時間和數量設定：</label>
			<div class="col-sm-8">			 
			      <div class="col-md-10 grid_box1">		
				     <table class="table table-bordered" id="sample_list">
                 <thead>
                    <tr>
                      <th scope="col" width=80>來源</th>
                      <th scope="col" width=280>索取開始時間</th>
                      <th scope="col" width=280>索取結束時間</th>
                      <th scope="col" width=100>索取數量</th>
                    </tr> 
                 </thead>
                 <tr>
                 	<td>FB</td>
                 	<td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 'f_start', 
			  	                            'TheDateValue' => (isset($data['f_start'])) ? $data['f_start'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 'f_end', 
			  	                            'TheDateValue' => (isset($data['f_end'])) ? $data['f_end'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                  	 <input type="text" size="20" style="width:100%" maxlength="4" id="f_num" name="f_num" value="<?php echo (isset($data['f_num'])) ? $data['f_num'] : ''; ?>" class="form-control" required onKeyUp="value=value.replace(/[^0123456789]/g,'')">
                  </td>
                </tr>
                <tr>
                 	<td>IG</td>
                 	<td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 'i_start', 
			  	                            'TheDateValue' => (isset($data['i_start'])) ? $data['i_start'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 'i_end', 
			  	                            'TheDateValue' => (isset($data['i_end'])) ? $data['i_end'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                  	 <input type="text" size="20" style="width:100%" maxlength="4" id="i_num" name="i_num" value="<?php echo (isset($data['i_num'])) ? $data['i_num'] : ''; ?>" class="form-control" required onKeyUp="value=value.replace(/[^0123456789]/g,'')">
                  </td>
                </tr>
                <tr>
                 	<td>業務行銷</td>
                 	<td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 's_start', 
			  	                            'TheDateValue' => (isset($data['s_start'])) ? $data['s_start'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                      <?php
                      $params = array(
			  	                            'TheDateField' => 's_end', 
			  	                            'TheDateValue' => (isset($data['s_end'])) ? $data['s_end'] : '',
			  	                            'Required' => 'Y'
			  	                            );			  	                
                      $this->ui->PJ_JInputDate('datetime',$params);   
                      ?>      
                  </td>
                  <td>
                  	 <input type="text" size="20" style="width:100%" maxlength="4" id="s_num" name="s_num" value="<?php echo (isset($data['s_num'])) ? $data['s_num'] : ''; ?>" class="form-control" required onKeyUp="value=value.replace(/[^0123456789]/g,'')">
                  </td>
                </tr>
              </table>
            </div>  
         </div>
		</div>		
    
		
		<?php 
		$sample_num = 0; 
		$sample_sort = 0;
		?>		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            試用組設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-10 grid_box1">		
		            <table class="table table-bordered" id="sample_list">
                          <thead>
                              <tr>
                                <th scope="col" width=30></th>
                                <th scope="col" width=80>排序</th>
                                <th scope="col">試用組名稱  <font color=red>只設定一筆將不用選擇</font></th>
                              </tr> 
                           </thead>
                           <tfoot>
                              <tr>
                                <th colspan=5>
                                   <input type="button" class="button_sample btn btn-primary btn-block" data-rule="required" value="+ 增加試用品選項">
                                </th>
                              </tr>
                           </tfoot>      
                           <tbody>             
                           <?php                              
                           if (isset($data['sample_data']) && $data['sample_data'] ){
                               foreach ($data['sample_data'] as $key => $item){ 
	                                 
	                                 $sample_num++;
	                                 $sample_sort++;	                                	                                 
	                                 
	                                 $ada = '<tr id="qa_'.$sample_num.'">
                                                <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$sample_num.');">X</span></td>                                                
                                                <td><input type="text" size="3" style="width:55px" id="sample_sort_'.$sample_num.'" name="sample_sort_'.$sample_num.'" value="'.$sample_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
                                                <td><input type="text" size="20" style="width:100%" maxlength="50" id="sample_title_'.$sample_num.'" name="sample_title_'.$sample_num.'" value="'.$item['title'].'" class="form-control"></td>
                                           </tr>';
                                   echo $ada;                                   
	                             }
                           }?>                 
                           </tbody>          
                </table>  
               
            </div>		
			</div>
		</div>
		<!--
		   <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            是否要使用LINE詢問心得：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">						
                  <input type="checkbox" name="use_line" id="use_line" value="Y" onclick="use_linecheck();" <?php if ($data['use_line'] == 'Y'){ echo 'checked'; } ?>> 
                  
                  </div>
		</div>		
		</div>
		-->
		<div id="div_line">
		<?php 
		$data_num = 0; 
		$data_sort = 0;
		?>		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            試用組使用心得問卷設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-10 grid_box1">		
		            <table class="table table-bordered" id="qa_list">
                          <thead>
                              <tr>
                                <th scope="col" width=30></th>
                                <th scope="col" width=80>排序</th>
                                <th scope="col">問卷</th>
                                <th scope="col" width=100>相隔天數</th>
                              </tr> 
                           </thead>
                           <tfoot>
                              <tr>
                                <th colspan=5>
                                   <input type="button" class="button_add btn btn-success btn-block" data-rule="required" value="+ 增加試用組問卷選項">
                                </th>
                              </tr>
                           </tfoot>      
                           <tbody>             
                           <?php                              
                           if (isset($data['set_data']) && $data['set_data'] ){
                               foreach ($data['set_data'] as $key => $item){ 
	                                 
	                                 $data_num++;
	                                 $data_sort++;	                                	                                 
	                                 
	                                 $ada = '<tr id="qa_'.$data_num.'">
                                                <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$data_num.');">X</span></td>                                                
                                                <td><input type="text" size="3" style="width:55px" id="data_sort_'.$data_num.'" name="data_sort_'.$data_num.'" value="'.$data_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
                                                <td>
                                                   <select id="q_id_'.$data_num.'" name="q_id_'.$data_num.'" class="form-control" style="width:100%">
                                                      <option value="">請選擇試用組問卷</option>';
                                                      
                                   foreach($question as $st_key => $st_value) {
                                           $selected = '';
	                                         if (isset($item['q_id']) && $item['q_id'] == $st_value['q_id']){
	                                         	   $selected = ' selected';
	                                         }
                                           $ada .= '<option value="'.$st_value['q_id'].'" '.$selected.'>('.$st_value['q_id'].') '.$st_value['q_title'].'</option>';
                                   }                
                                   
                                   $ada .=     '</select></td>                                                 
                                                 <td><input type="text" size="3" style="width:55px" id="data_day_'.$data_num.'" name="data_day_'.$data_num.'" value="'.$item['day'].'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
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
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            使用心得Line訊息標題：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="line_charge_title" id="line_charge_title" value="<?php echo (isset($data['line_charge_title'])) ? $data['line_charge_title'] : ''; ?>" required placeholder="請輸入使用心得Line訊息標題">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;           使用心得Line訊息：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="line_charge_msg" id="line_charge_msg" value="<?php echo (isset($data['line_charge_msg'])) ? $data['line_charge_msg'] : ''; ?>" required placeholder="請輸入使用心得Line訊息">
					</div>
			</div>
		</div> 
		
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            出貨Line訊息標題：</label>
			<div class="col-sm-8"><div class="col-md-6 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="line_out_title" id="line_out_title" value="<?php echo (isset($data['line_out_title'])) ? $data['line_out_title'] : ''; ?>" placeholder="請輸入出貨Line訊息標題"> 
					</div>	
						<div class="col-md-4 grid_box1">
						<font color=red>空值將不推送 (每小時檢查推送)</font>
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;           出貨Line訊息：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="line_out_msg" id="line_out_msg" value="<?php echo (isset($data['line_out_msg'])) ? $data['line_out_msg'] : ''; ?>" placeholder="請輸入出貨Line訊息">
					</div>
			</div>
		</div> 
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            使用心得Line訊息推送時間：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">
						<select name="set_hour" class="form-control">
							 <?php for ($i = 8; $i<= 21 ;$i++){
							 	          echo '<option value="'.$i.'"';
							 	          if ($i == $data['set_hour']){
							 	              echo ' selected';
							 	          }
							 	          echo '> 每天 '.$i.' :00 送出訊息';
							 	          echo '</option>';
							 	     }
							 ?>
						</select>
					</div>
			</div>
		</div>
		</div>
		
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;           催填問卷訊息設定：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<table>
							 <tr>
							 	 <td>相隔&nbsp;</td><td><input type="text" size="3" style="width:55px" id="reminder_hour" name="reminder_hour" value="<?php echo (isset($data['reminder_hour'])) ? $data['reminder_hour'] : ''; ?>" maxlength="2" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td><td>&nbsp;小時通知</td>
							 	 <td>，隔&nbsp;</td><td><input type="text" size="3" style="width:55px" id="lock_days" name="lock_days" value="<?php echo (isset($data['lock_days'])) ? $data['lock_days'] : ''; ?>" maxlength="2" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td><td>&nbsp;天未填不能填寫</td>
							 </tr>
						</table>	 
					</div>
			</div>
		</div> 
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;           催填問卷申請人訊息設定：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="reminder_msg" id="reminder_msg" value="<?php echo (isset($data['reminder_msg'])) ? $data['reminder_msg'] : ''; ?>" placeholder="請輸入催填問卷申請人訊息">
					</div>
			</div>
		</div> 
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;           催填問卷推薦人訊息設定：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="reminder_referrer_msg" id="reminder_referrer_msg" value="<?php echo (isset($data['reminder_referrer_msg'])) ? $data['reminder_referrer_msg'] : ''; ?>" placeholder="請輸入催填問卷推薦人訊息">
					</div>
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/sample/list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_num?>">
	 <input type="hidden" id="data_sort" name="data_sort" value="<?=$data_sort?>">
	 <input type="hidden" id="sample_num" name="sample_num" value="<?=$sample_num?>">
	 <input type="hidden" id="sample_sort" name="sample_sort" value="<?=$sample_sort?>">
</form>
<script>
   
	
$(document).ready(function() {
   $('.button_add').on('click', function(e) {      
      
      var anum = parseFloat($("#data_num").val())+1;
      var ansort = parseFloat($("#data_sort").val())+1;
      $("#data_num").val(anum);      
      $("#data_sort").val(ansort);
      
      var sqlstr1 = '<select id="q_id_'+anum+'" name="q_id_'+anum+'" class="form-control" style="width:100%"><option value="">請選擇試用組問卷</option><?=$selstr1?></select>';
            
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="data_day_'+anum+'" name="data_day_'+anum+'" value="" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+                   
                   '</tr>';
      $("#qa_list tbody").append(addrow);
            
   });   
   
   $('.button_sample').on('click', function(e) {      
      
      var anum = parseFloat($("#sample_num").val())+1;
      var ansort = parseFloat($("#sample_sort").val())+1;
      $("#sample_num").val(anum);      
      $("#sample_sort").val(ansort);
      
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="sample_sort_'+anum+'" name="sample_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+                      
                   '     <td><input type="text" size="20" style="width:100%" maxlength="50" id="sample_title_'+anum+'" name="sample_title_'+anum+'" value="" class="form-control"></td>'+                   
                   '</tr>';
      $("#sample_list tbody").append(addrow);
            
   });   
});


function del(id){
     $("#qa_" + id).remove();          
}   

function use_linecheck()
{
	   document.getElementById('div_line').style.display="none";	              	    
     if ($("#use_line").attr("checked") =="checked"){ 
     	    document.getElementById('div_line').style.display="";     	
     }
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
	          	       var qid = $.trim($('#q_id_'+i+' option:selected').val());
	          	       if (qid == ''){
	          	           if (errmsg > ''){ errmsg = errmsg+','; }
	          	           errmsg = errmsg+'	問卷未選擇';
	          	           if (focusstr ==''){ focusstr = 'q_id_'+i; }
	          	       }else{
	          	       	   for (j=1 ; j <= data_num;j++){　
	          	           	  if (i != j){
	          	           	      var cqaid = parseInt($.trim($('#q_id_'+j+' option:selected').val()));
	          	           	      if (cqaid == qaid)
	          	           	      {
	          	           	      	 errmsg = '選擇問卷有重覆';	         
	          	           	      	 if (focusstr ==''){ focusstr = 'q_id_'+i; } 	       	      	 
	          	           	      }
	          	           	  }
	          	           }
	          	       	   data_qa_num++;
	          	       }     
	          	       var h_day = parseInt($('#data_day_'+i).val());	      
	          	       if (h_day == ''){
	          	           if (errmsg > ''){ errmsg = errmsg+','; }
	          	           errmsg = errmsg+'	相隔天數未填寫';
	          	           if (focusstr ==''){ focusstr = 'data_day_'+i; }
	          	       }
	          	  }	          	  
             }	      
	      }else{
	      	   errmsg = '尚未設定問卷！';
	      }
	      
	      if (data_qa_num == 0){
	      	  errmsg = '尚未設定問卷！';
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
	        //    return true;
	      }else{
              return false;
        }

}
</SCRIPT>