<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
    <form name="oForm" class="form-horizontal" role="form" method="post" ENCTYPE="multipart/form-data" language="javascript" 
       action="<?php echo base_url( 'wadmin/activity/save/'.$kind); ?>"> 
       	    			   	    				
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            活動名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="act_title" id="act_title" value="<?=$data['act_title']?>" required placeholder="請輸入活動名稱">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            活動說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="act_desc" id="act_desc" value="<?php echo (isset($data['act_desc'])) ? $data['act_desc'] : ''; ?>" placeholder="請輸入活動說明">
					</div>
			</div>
		</div>
				
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            活動開始報到時間：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'act_start', 
			  	                        'TheDateValue' => $data['act_start']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;   活動結束報到時間：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'act_end', 
			  	                        'TheDateValue' => $data['act_end']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?></div>
		   </div>		
		</div>
				
		<div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            問卷推播設定：</label>			
        <div class="col-sm-8">			 
			      <div class="col-md-12 grid_box1">		
		            <table class="table table-bordered" id="qa_list">
                           <thead>
                              <tr>
                                <th scope="col" colspan=2> 推播設定 ( <font color=red>日期和問卷都有設定才會生效</font> )</th>
                                <th scope="col">問卷</th>
                              </tr> 
                           </thead>                          
                           <tbody>   
                           <?php                                                         
                               for ($data_num = 1;$data_num<=4 ;$data_num++){ 
                               	    echo '<tr>';
                               	    $set_item = array();
                               	    if (isset($set_question) && count($set_question) > 0){
                               	    	  foreach ($set_question as $key => $item){
                               	    	  	       if ($item['set_sort'] == $data_num){
                               	    	  	       	   $set_item = $item;
                               	    	  	       	   echo '<input type="hidden" name="set_id_'.$data_num.'" value="'.$item['id'].'">';
                               	    	  	       	   if ($item['status'] == 'D'){
                               	    	  	       	       $set_item = array();
                               	    	  	           }
                               	    	  	       }                               	    	  	       
                               	    	  }
                               	    }
	                                  $col = '';
	                                  if ($data_num == 1){
	                                  	  $datitle = '報名成功問卷推播 (<font color=red>超過時間不推播</font>)';
	                                  	 // $col = ' colspan="2"';
	                                  }else{
	                                  	  $datitle = '問卷 '.($data_num-1);
	                                  }
	                                  ?>	                                  
                                                <td <?=$col?>><?=$datitle?></td>
                                    <?php if ($data_num > 1 || 1==1){   
                                    	        $set_date = '';
                                    	        if (isset($set_item['set_date']) && $set_item['set_date'] != '0000-00-00 00:00:00'){
                                    	        	  $set_date = $set_item['set_date'];
                                    	        }
                                    	        echo '<td><div style="float:left;">';                                    	        
                                    	        $this->block_service->set_push_time('push_time_'.$data_num,$set_date);
                                              echo '</td>';
                                          } ?>
                                                <td>
                                                   <select id="q_id_<?=$data_num?>" name="q_id_<?=$data_num?>" class="form-control" style="width:100%">
                                                      <option value="">請選擇活動問卷</option>
                                   <?php                   
                                   foreach($question as $st_key => $st_value) {
                                           $selected = '';
	                                         if (isset($item['q_id']) && $set_item['q_id'] == $st_value['q_id']){
	                                         	   $selected = ' selected';
	                                         }
	                                         ?>
                                           <option value="<?=$st_value['q_id']?>" <?=$selected?>>(<?=$st_value['q_id']?>) <?=$st_value['q_title']?></option>
                                           <?php
                                   }                
                                   ?>         
                                          </select></td>                                                                                                  
                                           </tr>
                                   <?php
                                  
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
  <input type="hidden" name="data_num" value="<?=$data_num?>">
  <input type="hidden" name="Search" value="<?=$Search?>">  
  <input type="hidden" name="act_type" value="<?=$data['act_type']?>">  
    
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/activity/list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br>
<br>
<br>
<br><br><br>                		 
</form>

<div style="height:900px;"></div>