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
       action="<?php echo base_url( 'wadmin/question_prd_set/save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 
    
    
    <?php if (isset($edit) && $edit > 0){ ?>
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            產品體驗編號：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">						
						<?php echo $edit?>
					</div>
			</div>
		</div>      
    <?php } ?>
   
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label" ><font class=DMIn>*</font>&nbsp;            產品體驗名稱：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">						
						<input type="text" class="form-control" maxlength="50" name="p_name" id="p_name" value="<?=$data['p_name']?>" required placeholder="請輸入產品體驗名稱">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label" ><font class=DMIn>*</font>&nbsp;            產品編號：</label>
			<div class="col-sm-8"><div class="col-md-3 grid_box1">						
						<input type="text" class="form-control" maxlength="10" name="p_no" id="p_no" value="<?=$data['p_no']?>" required placeholder="請輸入產品編號">
					</div>
			</div>
		</div>
		<?php if ($data['line_push'] == 'Y'){ ?>
		          <div class="form-group">
		          	<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            Line訊息推送時間：</label>
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
		          
		          <div class="form-group">
		          	<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            Line訊息標題：</label>
		          	<div class="col-sm-8"><div class="col-md-8 grid_box1">
		          				<input type="text" class="form-control" maxlength="50" name="line_title" id="line_title" value="<?=$data['line_title']?>" required placeholder="請輸入Line訊息標題">
		          			</div>
		          	</div>
		          </div>
		          
		          <div class="form-group">
		          	<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            Line訊息：</label>
		          	<div class="col-sm-8"><div class="col-md-10 grid_box1">
		          				<input type="text" class="form-control" maxlength="100" name="line_msg" id="line_msg" value="<?=$data['line_msg']?>" required placeholder="請輸入Line訊息">
		          			</div>
		          	</div>
		          </div>
		<?php } ?>
		<?php 
		$data_num = 0; 
		$data_sort = 0;
		?>		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            問卷設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-10 grid_box1">		
		            
                       <?php if ($data['line_push'] == 'N' || $data['line_push'] == 'Q'){ ?>                              
                           <?php
                           $max_num = 1;
                           if ($data['line_push'] == 'Q'){
                               $max_num = 2;	
                           }
                           for ($i = 1;$i <= $max_num;$i++){
                                $data_num++;
                                $qtitle = '請選擇問卷';
                                if ($data['line_push'] == 'Q'){
                                    $qtitle = '請選擇問卷 '.$data_num;  
                                }
                                
	                              $ada = '<tr id="qa_'.$data_num.'">
                                             <td>
                                                <select id="q_id_'.$data_num.'" name="q_id_'.$data_num.'" class="form-control" style="width:100%">
                                                   <option value="">'.$qtitle.'</option>';
                                
                                foreach($question as $st_key => $st_value) {
                                        $selected = '';
	                                      if (isset($data['set_data'][$i-1]['q_id']) && $data['set_data'][$i-1]['q_id'] == $st_value['q_id']){
	                                      	   $selected = ' selected';
	                                      }
                                        $ada .= '<option value="'.$st_value['q_id'].'" '.$selected.'>('.$st_value['q_id'].') '.$st_value['q_title'].'</option>';
                                }                
                                
                                $ada .=     '</select></td>                                                                                          
                                        </tr>';
                                echo $ada;
                           }
                           ?>
                           <span id="qa_1"></span>
                           <input type="hidden" name="data_sort_1" value="1">
                           <input type="hidden" name="data_day_1" value="1">
                           <input type="hidden" name="data_sort_2" value="2">
                           <input type="hidden" name="data_day_2" value="1">
                       <?php }else{ ?>
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
                                   <input type="button" class="button_add btn btn-success btn-block" data-rule="required" value="+ 增加問卷選項">
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
                                                      <option value="">請選擇問卷</option>';
                                                      
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
                      <?php } ?>     
                
               
            </div>		
			</div>
		</div>
		
		     
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label" style="margin-top: -5px;"><font class=DMIn>*</font>&nbsp;            售後服務設定：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">						
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
		
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label" style="margin-top: -5px;"><font class=DMIn>*</font>&nbsp;            前台顯示順序 ( 0不顯示 )：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">						
                  <input type="text" size="3" style="width:55px" id="web_sort" name="web_sort" value="<?=$data['web_sort']?>" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" required class="form-control">    
                  </div>
         </div>
		</div>	
	          
  <br>
  <input type="hidden" name="send" value="OK">
  <input type="hidden" name="Page" value="<?=$Page?>">
  <input type="hidden" name="Search" value="<?=$Search?>">
  <input type="hidden" name="line_push" value="<?=$data['line_push']?>">
  
  <?php if (isset($edit)){ ?>
      <input type="hidden" name="edit" value="<?php echo $edit?>">  
  <?php } ?>
  
  <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<div id="div_errmsg"  style="display:none;color:red;margin-top: 5px;margin-bottom: 10px;"> 		    
          </div>    
          
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">
				</div>
			</div>
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
      
      var sqlstr1 = '<select id="q_id_'+anum+'" name="q_id_'+anum+'" class="form-control" style="width:100%"><option value="">請選擇問卷</option><?=$selstr1?></select>';
            
      var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+                   
                   '     <td><input type="text" size="3" style="width:55px" id="data_day_'+anum+'" name="data_day_'+anum+'" value="" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+                   
                   '</tr>';
      $("#qa_list tbody").append(addrow);
            
   });   
});


function del(id){
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
	            return true;
	      }else{
              return false;
        }

}
</SCRIPT>