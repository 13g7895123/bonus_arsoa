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
    <form name="oForm" class="form-horizontal" role="form" method="post" ENCTYPE="multipart/form-data" language="javascript" 
       action="<?php echo base_url( 'wadmin/lottery/save/'.$kind); ?>" onsubmit="return oForm_onsubmit(this);"> 
       	    	
    <div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            抽獎模組：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
				    <?=$lottory_type[$data['lot_type']]?>
					</div>
			</div>
		</div>
		   	    				
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            抽獎名稱：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="150" name="lot_title" id="lot_title" value="<?=$data['lot_title']?>" required placeholder="請輸入抽獎名稱">						
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            抽獎說明：</label>
			<div class="col-sm-8"><div class="col-md-8 grid_box1">
						<input type="text" class="form-control" maxlength="100" name="lot_desc" id="lot_desc" value="<?php echo (isset($data['lot_desc'])) ? $data['lot_desc'] : ''; ?>" placeholder="請輸入抽獎說明">
					</div>
			</div>
		</div>
		
		<div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            抽獎設定：</label>
			    <div class="col-sm-9"><div class="col-md-8 grid_box1">
						<table style="border-spacing: 1px;border-collapse: separate;">
							<tr>
								<td>抽獎底色：</td>
								<td colspan=3>
						      <input type="text" class="form-control" style="width:120px" maxlength="6" name="background_color" id="background_color" value="<?php if (isset($data['lot_config']['background_color'])){ echo $data['lot_config']['background_color']; }?>">
						    </td>
						  </tr>					
						</table>  
				
						<input type="checkbox" name="lot_config_addr" id="lot_config_addr" value="Y" <?php if (isset($data['lot_config']['addr']) && $data['lot_config']['addr'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="lot_config_addr">&nbsp;中獎人是否填寫收件資訊 (不勾代表現場領取)  </label>
						<br>
						<input type="checkbox" name="lot_config_member" id="lot_config_member" value="Y" <?php if (isset($data['lot_config']['member']) && $data['lot_config']['member'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="lot_config_member">&nbsp;安露莎全部會員 才可抽獎  </label>
						<br>
						<input type="checkbox" name="lot_config_charge" id="lot_config_charge" value="Y" <?php if (isset($data['lot_config']['charge']) && $data['lot_config']['charge'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="lot_config_charge">&nbsp;有指定的 會員 才可抽獎  </label>
						<br>
						<input type="checkbox" name="lot_config_question" id="lot_config_question" value="Y" <?php if (isset($data['lot_config']['question']) && $data['lot_config']['question'] == 'Y'){ echo 'checked'; } ?>> 
						<label style="font-size:18px;margin-top: 5px;" for="lot_config_question">&nbsp;填完問卷 才可抽獎  </label>
						<div width=600>
							 <select id="lot_config_q_id" name="lot_config_q_id" class="form-control" style="width:100%">
                   <option value="">請選擇問卷</option>';
                   <?php      
                      $ada = '';                                  
                      foreach($question as $st_key => $st_value) {
                              $selected = '';
	                            if (isset($data['lot_config']['q_id']) && $data['lot_config']['q_id'] == $st_value['q_id']){
	                            	   $selected = ' selected';
	                            }
                              $ada .= '<option value="'.$st_value['q_id'].'" '.$selected.'>('.$st_value['q_id'].') '.$st_value['q_title'].'</option>';
                      }         
                      echo $ada;       
                   ?>                
                </select>
					  </div>
					</div>
			</div>
		</div>
		
	  <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            抽獎開始日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'lot_start', 
			  	                        'TheDateValue' => $data['lot_start']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?>      
                  </div>
         </div>
		</div>		
    <div class="form-group">
			<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;   抽獎結束日期：</label>
			<div class="col-sm-8"><div class="col-md-12 grid_box1">						
                  <?php
                  $params = array(
			  	                        'TheDateField' => 'lot_end', 
			  	                        'TheDateValue' => $data['lot_end']
			  	                        );			  	                
                  $this->ui->PJ_JInputDate('datetime',$params);   
                  ?></div>
		</div>		
		</div>
				
		<?php 
		$lottery_num = 0; 
		$lottery_sort = 0;
		
		if ($data['lot_type'] == '1'){ 
			  $img_title = '輪盤圖檔 (順時鐘順序)';
			  $img_w = 800;
			  $img_h = 600;
				?>				
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            獎品設定：</label>			
    		    <div class="col-sm-8">			                                                                                  		    	  .
					      <div class="col-md-10 grid_box1">		
				            <table class="table table-bordered" id="lottery_list">
    		                      <thead>
    		                          <tr>
    		                            <th scope="col" width=30></th>                                
    		                            <th scope="col" width=80>排序</th>
    		                            <th scope="col" width=180>獎品類型</th>
    		                            <th scope="col">獎品名稱 (<font color=red>最少 2 項</font>)</th>
    		                            <th scope="col" width=120>數量</th>                            
    		                            <th scope="col" width=120>預設獎品</th>
    		                          </tr> 
    		                       </thead>
    		                       <tfoot>
    		                          <tr>
    		                            <th colspan=6>
    		                               <input type="button" class="button_lottery btn btn-primary btn-block" data-rule="required" value="+ 增加獎品選項">
    		                            </th>
    		                          </tr>
    		                       </tfoot>      
    		                       <tbody>             
    		                       <?php                              
    		                       if (isset($data['lot_data']) && $data['lot_data'] ){
    		                           foreach ($data['lot_data'] as $key => $item){ 
	  		                               
	  		                               $lottery_num++;
	  		                               $lottery_sort++;
	  		                               
	  		                               $type_select1 = '';
	  		                               $type_select2 = '';
	  		                               $type_select3 = '';
	  		                               if ($item['type'] == 'Y'){
	  		                                   $type_select1 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'C'){
	  		                                   $type_select2 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'A'){
	  		                                   $type_select3 = ' selected';		  		                                   
	  		                               }
	  		                               
	  		                               $set_item = '';
	  		                               if ($item['set_item'] == 'Y'){
	  		                               	   $set_item = ' checked';
	  		                               }
	  		                               
	  		                               $ada = '<tr id="qa_'.$lottery_num.'">
    		                                            <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$lottery_num.');">X</span></td>
    		                                            <td><input type="text" size="3" style="width:55px" id="data_sort_'.$lottery_num.'" name="data_sort_'.$lottery_num.'" value="'.$lottery_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td>
    		                                            <select id="data_type_'.$lottery_num.'" name="data_type_'.$lottery_num.'" class="form-control" onChange="change_data_type('.$lottery_num.')" 
    		                                                style="width:100%">
    		                                                <option value="Y" '.$type_select1.'>中獎</option>
    		                                                <option value="C" '.$type_select2.'>未中獎</option>                                                    
    		                                                <option value="A" '.$type_select3.'>再抽一次</option>    		                                                
    		                                            </select>                                                
    		                                            </td>
    		                                            <td><input type="text" size="20" style="width:100%" maxlength="50" id="data_title_'.$lottery_num.'" name="data_title_'.$lottery_num.'" value="'.$item['title'].'" class="form-control"></td>
    		                                            <td><input type="text" size="3" style="width:80px" id="data_num_'.$lottery_num.'" name="data_num_'.$lottery_num.'" value="'.$item['num'].'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'.$lottery_num.'" class="form-control" '.$set_item.'></td>
    		                                       </tr>';
    		                               echo $ada;                                   
	  		                           }
    		                       }?>                 
    		                       </tbody>          
    		            </table>                  
    		        </div>		
					</div>
				</div>
		<?php
	  }
	  if ($data['lot_type'] == '2'){ 
			  $img_title = '刮刮樂上方覆蓋圖檔';
			  $img_w = 590;
			  $img_h = 285;
			  ?>				
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            獎品設定：</label>			
    		    <div class="col-sm-10">			 
					      <div class="col-md-10 grid_box1">		
				            <table class="table table-bordered" id="lottery_list">
    		                      <thead>
    		                          <tr>
    		                            <th scope="col" width=30></th>                                
    		                            <th scope="col" width=80>排序</th>
    		                            <th scope="col" width=180>獎品類型</th>
    		                            <th scope="col" width=240>獎品名稱</th>
    		                            <th scope="col">獎品圖片(250 x 250)</th>
    		                            <th scope="col" width=120>數量</th>                   
    		                            <th scope="col" width=120>預設獎品</th>
    		                          </tr> 
    		                       </thead>
    		                       <tfoot>
    		                          <tr>
    		                            <th colspan=7>
    		                               <input type="button" class="button_lottery btn btn-primary btn-block" data-rule="required" value="+ 增加獎品選項">
    		                            </th>
    		                          </tr>
    		                       </tfoot>      
    		                       <tbody>             
    		                       <?php                              
    		                       if (isset($data['lot_data']) && $data['lot_data'] ){
    		                           foreach ($data['lot_data'] as $key => $item){ 
	  		                                                            //echo "<pre>".print_r($item,true)."</pre>";
                                                                    //exit;
	  		                               $lottery_num++;
	  		                               $lottery_sort++;
	  		                               
	  		                               $type_select1 = '';
	  		                               $type_select2 = '';
	  		                               $type_select3 = '';
	  		                               if ($item['type'] == 'Y'){
	  		                                   $type_select1 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'C'){
	  		                                   $type_select2 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'A'){
	  		                                   $type_select3 = ' selected';		  		                                   
	  		                               }
	  		                               
	  		                               $set_item = '';
	  		                               if ($item['set_item'] == 'Y'){
	  		                               	   $set_item = ' checked';
	  		                               }
	  		                               
	  		                               $ada = '<tr id="qa_'.$lottery_num.'">
    		                                            <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$lottery_num.');">X</span></td>
    		                                            <td><input type="text" size="3" style="width:55px" id="data_sort_'.$lottery_num.'" name="data_sort_'.$lottery_num.'" value="'.$lottery_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td>
    		                                            <select id="data_type_'.$lottery_num.'" name="data_type_'.$lottery_num.'" class="form-control" onChange="change_data_type('.$lottery_num.')" 
    		                                                style="width:100%">
    		                                                <option value="Y" '.$type_select1.'>中獎</option>
    		                                                <option value="C" '.$type_select2.'>未中獎</option>    
    		                                                <option value="A" '.$type_select3.'>再抽一次</option>                                                  
    		                                            </select>                                                
    		                                            </td>
    		                                            <td><input type="text" size="20" style="width:100%" maxlength="50" id="data_title_'.$lottery_num.'" name="data_title_'.$lottery_num.'" value="'.$item['title'].'" class="form-control"></td>
    		                                            <td>';
    		                              echo $ada;    
    		                              $params = array(
			  	        										      'Folder' => 'func', 
			  	        										      'Name'   => 'data_img_'.$lottery_num,
			  	        										      'FileName' => $item['image'],
			  	        										      'Width'   => $img_w,
			  	        										      'Height'   => $img_h
			  	        										      );			  	                			  	            
                  										$this->ui->UIUpLoadfile($params);
                  										echo '<input type="hidden" name="data_img_old_'.$lottery_num.'" value="'.$item['image'].'">';
                  										
    		                              echo '        </td>      
    		                                            <td><input type="text" size="3" style="width:80px" id="data_num_'.$lottery_num.'" name="data_num_'.$lottery_num.'" value="'.$item['num'].'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'.$lottery_num.'" class="form-control" '.$set_item.'></td>
    		                                       </tr>';    		                              
	  		                           }
    		                       }?>                 
    		                       </tbody>          
    		            </table>                  
    		        </div>		
					</div>
				</div>
		   <?php
	  }
	  
	  if ($data['lot_type'] == '3'){ 
			  $img_title = '拉霸圖檔 (最上方為 1 至後順序)';
			  $img_w = 120;			  
			  $img_h = '';
				?>				
				<div class="form-group">
					<label for="focusedinput" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            獎品設定：</label>			
    		    <div class="col-sm-8">			 
    		    	  <font color=red>未中獎只能設定一項並設在最後一項，圖片不用含未中獎的圖片，每個獎品高度為250，請按順序排列。</font> 
					      <div class="col-md-10 grid_box1">		
				            <table class="table table-bordered" id="lottery_list">
    		                      <thead>
    		                          <tr>
    		                            <th scope="col" width=30></th>                                
    		                            <th scope="col" width=80>排序</th>
    		                            <th scope="col" width=180>獎品類型</th>
    		                            <th scope="col">獎品名稱 (<font color=red>最少 2 項</font>)</th>
    		                            <th scope="col" width=120>數量</th>                            
    		                            <th scope="col" width=120>預設獎品</th>
    		                          </tr> 
    		                       </thead>
    		                       <tfoot>
    		                          <tr>
    		                            <th colspan=6>
    		                               <input type="button" class="button_lottery btn btn-primary btn-block" data-rule="required" value="+ 增加獎品選項">
    		                            </th>
    		                          </tr>
    		                       </tfoot>      
    		                       <tbody>             
    		                       <?php                              
    		                       if (isset($data['lot_data']) && $data['lot_data'] ){
    		                           foreach ($data['lot_data'] as $key => $item){ 
	  		                               
	  		                               $lottery_num++;
	  		                               $lottery_sort++;
	  		                               
	  		                               $type_select1 = '';
	  		                               $type_select2 = '';
	  		                               $type_select3 = '';
	  		                               if ($item['type'] == 'Y'){
	  		                                   $type_select1 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'C'){
	  		                                   $type_select2 = ' selected';		  		                                   
	  		                               }
	  		                               if ($item['type'] == 'A'){
	  		                                   $type_select3 = ' selected';		  		                                   
	  		                               }
	  		                               
	  		                               $set_item = '';
	  		                               if ($item['set_item'] == 'Y'){
	  		                               	   $set_item = ' checked';
	  		                               }
	  		                               
	  		                               $ada = '<tr id="qa_'.$lottery_num.'">
    		                                            <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('.$lottery_num.');">X</span></td>
    		                                            <td><input type="text" size="3" style="width:55px" id="data_sort_'.$lottery_num.'" name="data_sort_'.$lottery_num.'" value="'.$lottery_sort.'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td>
    		                                            <select id="data_type_'.$lottery_num.'" name="data_type_'.$lottery_num.'" class="form-control" onChange="change_data_type('.$lottery_num.')" 
    		                                                style="width:100%">
    		                                                <option value="Y" '.$type_select1.'>中獎</option>
    		                                                <option value="C" '.$type_select2.'>未中獎</option>     
    		                                                <option value="A" '.$type_select3.'>再抽一次</option>                                                 
    		                                            </select>                                                
    		                                            </td>
    		                                            <td><input type="text" size="20" style="width:100%" maxlength="50" id="data_title_'.$lottery_num.'" name="data_title_'.$lottery_num.'" value="'.$item['title'].'" class="form-control"></td>
    		                                            <td><input type="text" size="3" style="width:80px" id="data_num_'.$lottery_num.'" name="data_num_'.$lottery_num.'" value="'.$item['num'].'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>
    		                                            <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'.$lottery_num.'" class="form-control" '.$set_item.'></td>
    		                                       </tr>';
    		                               echo $ada;                                   
	  		                           }
    		                       }?>                 
    		                       </tbody>          
    		            </table>                  
    		        </div>		
					</div>
				</div>
		<?php
		    
	  }
	  ?>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn>*</font>&nbsp;            <?=$img_title?>：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
						<?php
						$params = array(
			  	              'Folder' => 'func', 
			  	              'Name'   => 'lot_img',
			  	              'FileName' => $data['lot_img'],
			  	              'Width'   => $img_w,
			  	              'Height'   => $img_h
			  	              );			  	                			  	            
                  $this->ui->UIUpLoadfile($params);      
                  ?>
			         <p class="help-block">尺寸為<font color=red><?=$img_w?> X <?=$img_h?> </font>，
			         檔案格式限 <?php echo "<font color=red>".strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit))."</font>";?>，大小不得超過 
			         <font color=red><?=FC_FileSize?></font> KB</p>			                  
					</div>
			</div>
		</div>
		
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label"><font class=DMIn></font>&nbsp;            底圖：</label>
			<div class="col-sm-8"><div class="col-md-10 grid_box1">
					    	  <?php
					      	$params = array(
			  	              'Folder' => 'func', 
			  	              'Name'   => 'lot_bg_img',
			  	              'FileName' => $data['lot_bg_img'],
			  	              'Width'   => 1280,
			  	              'Height'   => 1280
			  	              );			  	                			  	            
                  $this->ui->UIUpLoadfile($params);      
                  ?>
			         <p class="help-block">尺寸為<font color=red>1280 X 1280 </font>，
			         檔案格式限 <?php echo "<font color=red>".strtolower(str_replace(';','&nbsp;,&nbsp;',FC_ImgLimit))."</font>";?>，大小不得超過 
			         <font color=red><?=FC_FileSize?></font> KB</p>			                  
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
  <input type="hidden" name="lot_type" value="<?=$data['lot_type']?>">  
    
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
          <input type="button" value="回上一頁" onclick="location.href='<?php echo base_url( 'wadmin/lottery/list/'.$kind ); ?>';" class="btn btn-info">                    
				</div>
			</div>
	 </div>
	 <br>
	 <input type="hidden" id="lottery_num" name="lottery_num" value="<?=$lottery_num?>">
	 <input type="hidden" id="lottery_sort" name="lottery_sort" value="<?=$lottery_sort?>">
<br>
<font color=red>注意事項:<br></font>
1.當全部獎品數量使用完，其它抽獎將使用預設獎品。<br>
2.抽獎進行時，請勿增加或減少獎品設定。<br>
3.抽獎進行時，請勿調整（排序、獎品類型），可調整（獎品名稱、數量、預設獎品）。<br>
<br><br><br>                		 
</form>
<script>
   
	
$(document).ready(function() {
   
   $('.button_lottery').on('click', function(e) {      
      
      var anum = parseFloat($("#lottery_num").val())+1;
      var ansort = parseFloat($("#lottery_sort").val())+1;
      $("#lottery_num").val(anum);      
      $("#lottery_sort").val(ansort);
      
      var sqlstr1 = '<select id="data_type_'+anum+'" name="data_type_'+anum+'" class="form-control" onChange="change_data_type('+anum+')" style="width:100%"><option value="Y">中獎</option><option value="C">未中獎</option><option value="A">再抽一次</option></select>';
      
      <?php if ($data['lot_type'] == '1' || $data['lot_type'] == '3'){  ?>
      	        var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                                      
                   '     <td><input type="text" size="3" style="width:50px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+
                   '     <td><input type="text" id="data_title_'+anum+'" name="data_title_'+anum+'" value="" class="form-control"></td>'+
                   '     <td><input type="text" size="3" style="width:80px;" id="data_num_'+anum+'" name="data_num_'+anum+'" value="" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'+anum+'" class="form-control"></td>'+
                   '</tr>';
      <?php } ?>
      <?php if ($data['lot_type'] == '2'){  ?>
                var addrow = '<tr id="qa_'+anum+'">'+
                   '     <td><span class="btn badge badge-pill badge-light" style="position: inherit !important;margin-top: 8px;" onclick="del('+anum+');">X</span></td>'+                                      
                   '     <td><input type="text" size="3" style="width:50px" id="data_sort_'+anum+'" name="data_sort_'+anum+'" value="'+ansort+'" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td>'+sqlstr1+'</td>'+
                   '     <td><input type="text" id="data_title_'+anum+'" name="data_title_'+anum+'" value="" class="form-control"></td>'+
                   '     <td><input name="data_img_'+anum+'" id="data_img_'+anum+'" type="file" class="upload" accept=".jpg,.jpeg,.gif,.png" /> </td>'+
                   '     <td><input type="text" size="3" style="width:80px;" id="data_num_'+anum+'" name="data_num_'+anum+'" value="" onKeyUp="value=value.replace(/[^0123456789]/g,\'\')" class="form-control"></td>'+
                   '     <td><input type="radio" size="3" id="data_set_item" name="data_set_item" value="'+anum+'" class="form-control"></td>'+
                   '</tr>';
                   
      <?php } ?>
      $("#lottery_list tbody").append(addrow);
            
   });   
});


function del(id){
     $("#qa_" + id).remove();          
}   

function change_data_type(anum)
{
	   var data_type = $("#data_type_"+anum).val();
	   var data_title = $("#data_title_"+anum).val();
	   if (data_title == '' && data_type == 'N'){
	       $("#data_title_"+anum).val('銘謝惠顧');
	   }
	   if (data_title == '' && data_type == 'A'){
	       $("#data_title_"+anum).val('再抽一次');
	   }
}

function oForm_onsubmit(form)
{    
        var check = true;
	      var data_num = parseInt($('#lottery_num').val());
	      var data_qa_num = 0;
	      var errmsg = '';
	      var focusstr = '';
	      	      
	      document.getElementById('div_errmsg').style.display="none";
	      
	      if ($("input[name='lot_config_question']").is(":checked")){
	      	  var qaid = $.trim($('#lot_config_q_id option:selected').val());
	          if (qaid == ''){
	          	  errmsg = '尚未設定問卷！';
	          }
	      }
	      
	      if (errmsg == ''){
	      
	      		if (data_num > 0){	      	 
	      			 	document.getElementById('div_errmsg').style.display="none";	      	 
	      		    var data_set_item = $('input[name=data_set_item]:checked').val();
	      		    for (i=1 ; i <= data_num;i++){	          	  
	      		    	  var h_sort = parseInt($('#data_sort_'+i).val());	          	  
	      		    	  var data_type = $("#data_type_"+i).val();
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
	      		    	  var h_num = $('#data_num_'+i).val();	          	
	      		    	  
	      		    	  if (h_title == ''){
	      		    	      if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	      errmsg = errmsg+'	獎品名稱未填寫';
	      		    	      if (focusstr ==''){ focusstr = 'data_title_'+i; }
	      		    	  }
	      		    	  if (h_num == ''){
	      		    	      if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	      errmsg = errmsg+'	獎品數量未填寫';
	      		    	      if (focusstr ==''){ focusstr = 'data_num_'+i; }
	      		    	  }         
	      		    	  if (data_type == 'A' && data_set_item == i){
	      		    	  	  if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	      errmsg = errmsg+'	再抽一次不能設為預設獎品';
	      		    	      if (focusstr ==''){ focusstr = 'data_num_'+i; }
	      		    	  }    
        		     }	  
        		     
        		     if (data_set_item == undefined){
        		     	   if (errmsg > ''){ errmsg = errmsg+','; }
	      		    	   errmsg = errmsg+'	預設獎品未選擇';
        		     }
	      		}else{
	      			   errmsg = '尚未設定獎品！';
	      		}
	      }
	      
	      if (errmsg > ''){
	      	  //document.getElementById('div_errmsg').style.display="";
	      	  //$('#div_errmsg').html(errmsg);	
	      	  alert(errmsg);
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