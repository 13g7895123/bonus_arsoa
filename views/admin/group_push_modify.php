<?php
$disabled = '';
if ($reply_count > 0){
	  $disabled = ' disabled';
}
$disabled = '';
$qa_class = array(
                   'T' => '文字訊息',
                   'G' => '圖片訊息'
                  );

$selstr1 = '';
foreach($qa_class as $st_key => $st_value) {
        $selstr1 .= '<option value="'.$st_key.'">'.$st_value.'</option>';
}                  
?>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form" ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/member_line/group_push_save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 
    		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            群組貼標名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="ta_title" id="ta_title" value="<?php echo (isset($data['ta_title'])) ? $data['ta_title'] : ''; ?>" required placeholder="請輸入群組貼標名稱">						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            Line訊息設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-12 grid_box1">		
		            <table class="table table-bordered" id="qa_list">
                          <thead>
                              <tr>                              	
                                <th scope="col" width=80>排序</th>                                            
                                <th scope="col" width=180>訊息類型</th>
                                <th scope="col">訊息　（文字訊息可使用[name]變數，系統會更換為會員姓名。）</th>
                              </tr> 
                           </thead>                                                      
                           <tbody>             
                           <?php        
                           $data_sort = 0;
                           for ($data_num = 1;$data_num<=3;$data_num++){ 
	                                 
	                                 $data_sort++;	                                
	                                 
	                                 echo '<tr id="qa_'.$data_num.'">';                                                
                                   
                                   echo '<td><input type="text" size="3" style="width:55px" id="data_sort_'.$data_num.'" '.$disabled.' name="data_sort_'.$data_num.'" value="'.$data_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
                                                <td>
                                                   <select id="data_type_'.$data_num.'" name="data_type_'.$data_num.'" '.$disabled.' class="form-control" onChange="change_data_type('.$data_num.')" style="width:100%">
                                                    ';
                                   foreach($qa_class as $st_key => $st_value) {
                                           $selected = '';
	                                         if (isset($data['ta_data'][$data_num]['type']) && $data['ta_data'][$data_num]['type'] == $st_key){
	                                         	   $selected = ' selected';
	                                         }
                                           echo '<option value="'.$st_key.'" '.$selected.'>'.$st_value.'</option>';
                                   }                
                                   $t_msg = '';                                   
                                   $g_msg = '';
                                   $t_none = '';                                   
                                   $g_none = '';                                   
                                   if (isset($data['ta_data'][$data_num]['type']) && $data['ta_data'][$data_num]['type'] == 'G'){
                                       $g_msg = $data['ta_data'][$data_num]['data'];
                                       $t_none = ' style="display:none;"';                                   
                                   }else{
                                   	   $t_msg = $data['ta_data'][$data_num]['data'];
                                   	   $g_none = ' style="display:none;"';                                   
                                   }
                                   echo     '</select></td>
                                                 
                                                 <td>
                                                    <div id="ta_div_T_'.$data_num.'" '.$t_none.'><textarea '.$disabled.' cols="20" rows="5" id="data_T_'.$data_num.'" name="data_T_'.$data_num.'" class="form-control">'.$t_msg.'</textarea></div>
                                                    <div id="ta_div_G_'.$data_num.'" '.$g_none.'>';
                                                    
						                                        $params = array(
			  	                                                'Folder' => 'question', 
			  	                                                'Name'   => 'data_G_'.$data_num,
			  	                                                'FileName' => $g_msg
			  	                                                );			  	                			  	            
                                                    $this->ui->UIUpLoadfile($params);      
                                                    
			                             echo             '<p class="help-block">尺寸寬為 <font color=red>800 px</font> 不限高，
			                                              檔案格式限 <font color=red>'.strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit)).'</font>，大小不得超過
			                                              <font color=red>'.FC_FileSize.'</font> KB</p>	 ';
                                   echo             '</div>
                                                 </td>
                                           </tr>';
                                   
                           }                          
                           ?>                 
                           </tbody>          
                </table>  
               
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/member_line/group_push_list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <!--
	 <div class="panel-footer">
	   <font color=red>※注意事項：</font><br>
	   1.當有送出Line訊息，Line訊息設定將無法更動。<br>
	 </div>	 
	 -->
	 <br><br><br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_sort?>">	 
</form>
<script>
   

function change_data_type(num)
{
	
        //變動第一個下拉選單 
        document.getElementById('ta_div_T_'+num).style.display="none";
        document.getElementById('ta_div_G_'+num).style.display="none";
        
        document.getElementById('ta_div_'+$("#data_type_"+num).val()+'_'+num).style.display="";
        
        
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
	          	  var data_type = $("#data_type_"+i).val();
	          	  if (data_type == 'T'){
	          	  	  if ($('#data_T_'+i).val() > ''){
	          	  	  	  data_qa_num++;
	          	  	  }
	          	  }else{
	          	  	  if ($('#data_G_'+i).val()> ''){
	          	  	      data_qa_num++;
	          	  	      if (PF_CheckFileType('jpg;jpeg;gif;png',eval('form.data_G_'+i))==false){
                            errmsg = '檔案格式有問題！';	         
	          	  	          if (focusstr ==''){ focusstr = 'data_G_'+i; } 	       	      	                      
                        }   
                    }
	          	  }
             }	      
	      }else{
	      	   errmsg = '尚未設定Line訊息設定！';
	      }
	      
	      if (data_qa_num == 0){
	      	  errmsg = '尚未設定Line訊息設定！';
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
	      	    for (i=1 ; i <= data_num;i++){	          	  
	          	     var data_type = $("#data_type_"+i).val();
	          	     if (data_type == 'T'){
	          	     	   $('#data_G_'+i).val('');	          	     	   
	          	     }
              }	      
	            return true;
	      }else{
              return false;
        }

}

</SCRIPT>