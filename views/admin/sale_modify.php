<SCRIPT src="http://localhost/arsoa/public/js/pm.js" type=text/javascript></SCRIPT>
<SCRIPT language=JavaScript>
function oForm_onsubmit(form){    
                         if (PF_FormMulti('1','TEXT',form.title,'標題')==false){return false;}
			                                     if (form.field1_old.value.length > 0 && form.field1_del.value != 'Y'){			  		              
			  		            }else{
                            if (PF_FormMulti('1','TEXT',form.field1,'圖檔')==false){
                                return false;
                            }else{
                                if (PF_CheckFileType('jpg;jpge;gif;png',form.field1)==false){
                                    alert('檔案格式有問題！');
                                    return false;
                                }                            
                            } 
                        }
                      if (PF_FormMulti('1','DATETIME',form.begindate,'開始日期')==false){return false;}
                      if (PF_FormMulti('1','TEXT',form.nshow,'上下架')==false){return false;}
			             PF_FieldDisabled(form);
}
</SCRIPT>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/sale_save/'.$kind ); ?>" onsubmit="return oForm_onsubmit(this);"> 

		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            標題：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="title" id="title" value="<?=$data['title']?>" required placeholder="請輸入標題">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            標題2：</label>
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
						<input type="text" class="form-control" maxlength="50" name="title2" id="title2" value="<?=$data['title2']?>"  placeholder="請輸入標題2">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">販促簡述：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-4 grid_box1">						 
			  	 	 <textarea name="descr" id="descr" style="width:100%;Height:100px" rows="50"
			  	 	    class="form-control1"><?php if (isset($data['descr'])){ echo $data['descr']; }?></textarea>
			   </div>		  
			</div>
		</div>		
	   
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            圖檔：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<?php
						$params = array(
			  	              'Folder' => 'func', 
			  	              'Name'   => 'field1',
			  	              'FileName' => $data['field1'],
			  	              'Width'   => 800,
			  	              'Height'   => 600
			  	              );			  	                			  	            
                  $this->ui->UIUpLoadfile($params);      
                  ?>
			         <p class="help-block">尺寸為<font color=red>800 X 600 </font>，
			         檔案格式限 <?php echo "<font color=red>".strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit))."</font>";?>，大小不得超過 
			         <font color=red><?=FC_FileSize?></font> KB</p>			                  
					</div>
			</div>
		</div>
		
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            活動開始日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'show_stdt', 
			  	                        'TheDateValue' => $data['show_stdt']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
      <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">            活動結束日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'show_eddt', 
			  	                        'TheDateValue' => $data['show_eddt']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?><div class="col-sm-6 jlkdfj1">(不填寫為不限時間)</div>			</div>
		</div>		
		</div>

		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            上架日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'begindate', 
			  	                        'TheDateValue' => $data['begindate']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
      <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">            下架日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'closedate', 
			  	                        'TheDateValue' => $data['closedate']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?><div class="col-sm-6 jlkdfj1">(不填寫為不限時間)</div>			</div>
		</div>		
		</div>

		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            上下架：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	           'Name' => 'nshow', 
			  	           'XmlDoc' => $this->XmlDoc,
			  	           'Type'=> 'radio',
			  	           'Node'=> "//參數設定檔/上下架/KIND",
			  	           'Value' => $data['nshow']
			  	           );		
                  $this->ui->xmlform($params);
                  ?>      
                  </div>
         </div>
		</div>	
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">            順序：</label>
			 <div class="col-sm-8"><div class="col-md-12 grid_box1">						
         <input type="text" class="form-control" data-placement="bottom" style="width:180px" class="form-control" name="sale_sort" value="<?=$data['sale_sort']?>" size="10" maxlength="10" >
       </div>		
       <div class="col-sm-6 jlkdfj1">(小到大排序)</div>			</div>
		</div>		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">產品設定：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-3 grid_box1">
			          <input type="text" class="form-control" maxlength="10" name="addpid" id="addpid" placeholder="請輸入產品編號">
			   </div>		  
			   <div class="col-md-1 grid_box1">
			          <input type="button" value="加入" class="btn btn-danger" onclick="addprd();">
			   </div>		  
			   <div class="col-md-4 grid_box1" id="addmsg">
			          
			   </div>		  
			</div>
		</div>
		<?php 
		$data_num = 0; 
		$data_sort = 0;
		?>
		<div class="form-group">
		  <label for="focusedinput" class="col-sm-2 control-label"></label>			
        <div class="col-sm-8">			 
			   <div class="col-md-12 grid_box1">		
		            <table class="table table-bordered" id="prd_list">
                          <thead>
                              <tr>
                                <th scope="col"></th>                                            
                                <th scope="col">產品編號</th>
                                <th scope="col">產品名稱</th>
                                <th scope="col">產品狀態</th>                                
                                <th scope="col">數量</th>
                              </tr> 
                           </thead>
                           <tbody>             
                           <?php
                           if (isset($data['product']) && $data['product'] ){
                               foreach ($data['product'] as $key => $item){ 
	                                 $data_num++;
	                                 $data_sort++;
	                                 if ($item["is_visual"] || $item["c_price"] > 0){
                                        $item['is_visual'] = "上架";                 
                                    }else{
                                        $item['is_visual'] = "下架";                 
                                    }
	                                 $ada = '<tr id="prd_'.$data_num.'">
                                                <td><span class="glyphicon glyphicon-trash" onclick="del('.$data_num.');"></span></td>
                                                <td><input type="text" size="6" style="border-style:none" name="pid_'.$data_num.'" value="'.$item['p_no'].'" readonly class="form-control"></td>
                                                <td>'.$item['p_name'].'</td>
                                                <td>'.$item['is_visual'].'</td>      
                                                <td><input type="text" size="3" id="pid_num_'.$data_num.'" maxlength="2" onKeyUp="value=value.replace(/[^123456789]/g,\'\')" name="pid_num_'.$data_num.'" value="'.$product_num[$item['p_no']].'" class="form-control"></td>
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
			<label for="focusedinput" class="col-sm-2 control-label">販促內容：</label>			
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
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;          
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/func/sale/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br><br><br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_num?>">
	 <input type="hidden" id="data_sort" name="data_sort" value="<?=$data_sort?>">
</form>
<script>
function del(id){
     $("#prd_" + id).remove();     
     $("#pid_num_" + id).var('');
     $("#pid_" + id).var('');        
     
}   

function addprd(){
     var pid = $('input[name=addpid]').val();
     if (pid == ''){
         $("#addmsg").html("<font color=red>產品編號未輸入!</font>");
     }else{
          $.ajax({
                url: base_url + "wadmin/func/skin_ans_addpid/<?php echo $edit?>",                
                type: "POST",
                dataType: "json",
                data:{"pid":pid},
                success: function(data){
                    console.log(data);
                    if(data.status){  
                      var anum = parseFloat($("#data_num").val())+1;
                      var ansort = parseFloat($("#data_sort").val())+1;
                      $("#data_num").val(anum);      
                      $("#data_sort").val(ansort);   
                      
                      var addrow = '<tr id="prd_'+anum+'">'+
                                   '     <td><span class="glyphicon glyphicon-trash" onclick="del('+anum+');"></span></td>'+                                                      
                                   '     <td><input type="text" size="6" style="border-style:none" name="pid_'+anum+'" value="'+data.p_no+'" readonly class="form-control"></td>'+                                   
                                   '     <td>'+data.p_name+'</td>'+
                                   '     <td>'+data.is_visual+'</td>'+
                                   '     <td><input type="text" size="3" id="pid_num_'+anum+'" maxlength="2" onKeyUp="value=value.replace(/[^123456789]/g,\'\')" name="pid_num_'+anum+'" value="1" class="form-control"></td>'+
                                   '</tr>';
                        $("#prd_list tbody").append(addrow);
                        console.log('1');
                        $('input[name=addpid]').val('');
                    }else{
                        $("#addmsg").html("<font color=red>"+data.errmsg+"!</font>");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

         }); 
     }
}
</script>