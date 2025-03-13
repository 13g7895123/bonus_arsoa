<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
  <form name="oForm" class="form-horizontal" role="form"  ENCTYPE="multipart/form-data" method="post" language="javascript" 
       action="<?php echo base_url( 'wadmin/func/skin_ans_save/'.$kind ); ?>"> 

    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">結果：</label>			
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
				<?=$data['id']?></div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">肌膚類型：</label>			
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
				<?=$data['stype']?></div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">肌膚年齡：</label>			
			<div class="col-sm-8"><div class="col-md-4 grid_box1">
				<?=$data['age']?></div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">像這樣的肌膚問題有：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-12 grid_box1">
						<textarea name="question" cols="100%" rows="6" id="question" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['question']?></textarea>
			   </div>		  
			</div>
		</div>	
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">您還要注意：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-12 grid_box1">
						<textarea name="attention" cols="100%" rows="6" id="attention" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['attention']?></textarea>
			   </div>		  
			</div>
		</div>	
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">建議保養方式：</label>			
        <div class="col-sm-8">			 
			   <div class="col-md-12 grid_box1">
						<textarea name="keep" cols="100%" rows="6" id="keep" required class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?php echo $data['keep']?></textarea>
			   </div>		  
			</div>
		</div>
		
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label">推薦使用：</label>			
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
		            <table class="table table-bordered" id="skin_prd_list">
                          <thead>
                              <tr>
                                <th scope="col"></th>                                            
                                <th scope="col">產品編號</th>
                                <th scope="col">產品名稱</th>
                                <th scope="col">產品狀態</th>                                
                                <th scope="col">排序</th>
                              </tr> 
                           </thead>
                           <tbody>             
                           <?php
                           if (isset($piddata) && $piddata ){
                               foreach ($piddata as $key => $item){ 
	                                 $data_num++;
	                                 $data_sort++;
	                                 if ($item["is_visual"] || $item["c_price"] > 0){
                                        $item['is_visual'] = "上架";                 
                                    }else{
                                        $item['is_visual'] = "下架";                 
                                    }
	                                 $ada = '<tr id="skin_prd_'.$data_num.'">
                                                <td><span class="glyphicon glyphicon-trash" onclick="del('.$data_num.');"></span></td>
                                                <td><input type="text" size="6" style="border-style:none" name="pid_'.$data_num.'" value="'.$item['p_no'].'" readonly class="form-control"></td>
                                                <td>'.$item['p_name'].'</td>
                                                <td>'.$item['is_visual'].'</td>      
                                                <td><input type="text" size="3" id="pid_sort_'.$data_num.'" maxlength="2" onKeyUp="value=value.replace(/[^123456789]/g,\'\')" name="pid_sort_'.$data_num.'" value="'.$data_num.'" class="form-control"></td>
                                           </tr>';
                                   echo $ada;
	                             }
                           }?>                 
                           </tbody>          
                </table>    
            </div>		  
			</div>
		</div>                                 
                                            
  <br>
  <input type="hidden" name="send" value="OK">
  <?php if (isset($edit)){ ?>
  <input type="hidden" name="edit" value="<?php echo $edit?>">
  <?php } ?>
  <div class="panel-footer">
			<div class="row">
				<div class="col-sm-12 col-sm-offset-2">
					<input type="submit" value="確定" class="btn btn_5 btn-lg btn-primary">&nbsp;&nbsp;
          <input type="reset"  value="取消" class="btn btn-info">&nbsp;&nbsp;          
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/func/skin_ans/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br><br><br>
	 <input type="hidden" id="data_num" name="data_num" value="<?=$data_num?>">
	 <input type="hidden" id="data_sort" name="data_sort" value="<?=$data_sort?>">
</form>
<script>
function del(id){
     $("#skin_prd_" + id).remove();     
     $("#pid_sort_" + id).var('');
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
                      
                      var addrow = '<tr id="skin_prd_'+anum+'">'+
                                   '     <td><span class="glyphicon glyphicon-trash" onclick="del('+anum+');"></span></td>'+                                                      
                                   '     <td><input type="text" size="6" style="border-style:none" name="pid_'+anum+'" value="'+data.p_no+'" readonly class="form-control"></td>'+                                   
                                   '     <td>'+data.p_name+'</td>'+
                                   '     <td>'+data.is_visual+'</td>'+
                                   '     <td><input type="text" size="3" id="pid_sort_'+anum+'" maxlength="2" onKeyUp="value=value.replace(/[^123456789]/g,\'\')" name="pid_sort_'+anum+'" value="'+ansort+'" class="form-control"></td>'+
                                   '</tr>';
                        $("#skin_prd_list tbody").append(addrow);
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