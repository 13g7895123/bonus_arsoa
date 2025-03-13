<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
    <form name="oForm" class="form-horizontal" role="form" method="post" ENCTYPE="multipart/form-data" language="javascript" 
       action="<?php echo base_url( 'wadmin/line_link/save/'.$kind); ?>" onsubmit="return oForm_onsubmit(this);"> 
       	    	    		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            連結名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="link_title" id="link_title" value="<?=$data['link_title']?>" required placeholder="請輸入連結名稱">						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="link_desc" id="link_desc" value="<?php echo (isset($data['link_desc'])) ? $data['link_desc'] : ''; ?>" placeholder="請輸入說明">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;           會員設定：</label>
			    <div class="col-sm-9"><div class="col-md-8 grid_box1">
						<input type="checkbox" name="link_member" id="link_member" value="Y" <?php if (isset($data['link_member']) && $data['link_member'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="link_member">&nbsp;需有綁定安露莎會員才可使用  </label>
					</div>
			</div>
		</div>
		
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            開始日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'link_start', 
			  	                        'TheDateValue' => $data['link_start']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;   結束日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'link_end', 
			  	                        'TheDateValue' => $data['link_end']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?></div>
		</div>		
		</div>
				
		<?php 
		$line_link_num = 0; 
		$line_link_sort = 0;
	
			  
			  $img_w = 590;
			  $img_h = 285;
			  ?>				
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            連結設定：</label>			
    		    <div class="col-sm-10">			 
					      <div class="col-md-10 grid_box1">		
				            <table class="table table-bordered" id="line_link_list">
    		                      <thead>
    		                          <tr>
    		                            <th scope="col" width=30></th>                                
    		                            <th scope="col" width=80>排序</th>    		                            
    		                            <th scope="col" width=150>連結名稱</th>
    		                            <th scope="col">連結</th>
    		                            <th scope="col" width=250>連結圖片(250 x 250)</th>    		                            
    		                          </tr> 
    		                       </thead>
    		                       <tfoot>
    		                          <tr>
    		                            <th colspan=5>
    		                               <input type="button" class="button_line_link btn btn-primary btn-block" data-rule="required" value="+ 增加連結">
    		                            </th>
    		                          </tr>
    		                       </tfoot>      
    		                       <tbody>             
    		                       <?php                              
    		                       if (isset($data['link_data']) && $data['link_data'] ){
    		                           foreach ($data['link_data'] as $key => $item){ 
	  		                                                            //echo "<pre>".print_r($item,true)."</pre>";
                                                                    //exit;
	  		                               $line_link_num++;
	  		                               $line_link_sort++;
	  		                               
	  		                               $ada = '<tr id="qa_'.$line_link_num.'">
    		                                            <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$line_link_num.');">X</span></td>
    		                                            <td><input type="text" size="3" style="width:55px" id="data_sort_'.$line_link_num.'" name="data_sort_'.$line_link_num.'" value="'.$line_link_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>    		                                            
    		                                            <td><input type="text" size="20" style="width:100%" maxlength="20" id="data_title_'.$line_link_num.'" name="data_title_'.$line_link_num.'" value="'.$item['title'].'" class="form-control"></td>
    		                                            <td><input type="text" size="20" style="width:100%;min-width: 200px;" maxlength="300" id="data_link_'.$line_link_num.'" name="data_link_'.$line_link_num.'" value="'.$item['link'].'" class="form-control"></td>
    		                                            <td>';
    		                              echo $ada;    
    		                              $params = array(
			  	        										      'Folder' => 'func', 
			  	        										      'Name'   => 'data_img_'.$line_link_num,
			  	        										      'FileName' => $item['image'],
			  	        										      'Width'   => $img_w,
			  	        										      'Height'   => $img_h
			  	        										      );			  	                			  	            
                  										$this->ui->UIUpLoadfile($params);
                  										echo '<input type="hidden" name="data_img_old_'.$line_link_num.'" value="'.$item['image'].'">';
                  										
    		                              echo '        </td>          		                                            
    		                                       </tr>';    		                              
	  		                           }
    		                       }?>                 
    		                       </tbody>          
    		            </table>                  
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/line_link/list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br>
	 <input type="hidden" id="line_link_num" name="line_link_num" value="<?=$line_link_num?>">
	 <input type="hidden" id="line_link_sort" name="line_link_sort" value="<?=$line_link_sort?>">
<br>

<br><br><br>                		 
</form>
<script>
   
	
$(document).ready(function() {
   
   $('.button_line_link').on('click', function(e) {      
      
      var anum = parseFloat($("#line_link_num").val())+1;
      var ansort = parseFloat($("#line_link_sort").val())+1;
      $("#line_link_num").val(anum);      
      $("#line_link_sort").val(ansort);
            
                var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                                      
                   '     <td><input type="text" size="3" style="width:50px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td><input type="text" id="data_title_'+anum+'" name="data_title_'+anum+'" maxlength="20" value="" class="form-control"></td>'+
                   '     <td><input type="text" id="data_link_'+anum+'" name="data_link_'+anum+'" style="min-width: 200px;" maxlength="300" value="" class="form-control"></td>'+
                   '     <td><input name="data_img_'+anum+'" id="data_img_'+anum+'" type="file" class="upload" accept=".jpg,.jpeg,.gif,.png" /> </td>'+                   
                   '</tr>';
             
      $("#line_link_list tbody").append(addrow);
            
   });   
});


function del(id){
     $("#qa_" + id).remove();          
}   

function oForm_onsubmit(form)
{    
        var check = true;
	      var data_num = parseInt($('#line_link_num').val());
	      var data_qa_num = 0;
	      var errmsg = '';
	      var focusstr = '';
	      	      
	      document.getElementById('div_errmsg').style.display="none";
	      	      
	      if (errmsg == ''){
	      
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
	      		    	  var h_title = $('#data_title_'+i).val();	          	
	      		    	  var h_link = $('#data_link_'+i).val();	          		      		    	  
	      		    	  
	      		    	  if (h_title == ''){
	      		    	      if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	      errmsg = errmsg+'	連結名稱未填寫';
	      		    	      if (focusstr ==''){ focusstr = 'data_title_'+i; }
	      		    	  }
	      		    	  if (h_link == ''){
	      		    	      if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	      errmsg = errmsg+'	連結未填寫';
	      		    	      if (focusstr ==''){ focusstr = 'data_link_'+i; }
	      		    	  }	      		    	  
        		     }	  
        		     
	      		}else{
	      			   errmsg = '尚未設定連結！';
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
	        //    return true;
	      }else{
              return false;
        }

}
</SCRIPT>
<div style="height:900px;"></div>