<div class="col-sm-4 mb30">
 <label class="label-custom">手機號碼</label>
      <?php if ($personal_data['type'] == 'complete'){
    		        ?>    		        
    		        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="mobile" name="mobile" maxlength="10" placeholder="手機號碼" readonly value="<?php if (isset($personal_data['mobile'])){ echo $personal_data['mobile']; }?>" />
    		        <?php
    		    }else{
    	?>       
               <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="mobile" name="mobile" maxlength="10" placeholder="手機號碼" value="<?php if (isset($personal_data['mobile'])){ echo $personal_data['mobile']; }?>" />
	    <?php } ?>    
  <input type="hidden" name="mobile_old" id="mobile_old" value="<?php if (isset($personal_data['mobile'])){ echo $personal_data['mobile']; }?>" />
 </div>
 
 <div class="col-sm-4 mb30">
   <label class="label-custom">姓名</label>    
      <?php if ($personal_data['type'] == 'complete'){
    		        ?>    		        
    		        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="name" name="name" maxlength="10" placeholder="真實姓名" readonly required value="<?php if (isset($personal_data['name'])){ echo $personal_data['name']; }?>" />
    		        <?php
    		    }else{
    	?>       
                <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="name" name="name" maxlength="10" placeholder="真實姓名" required value="<?php if (isset($personal_data['name'])){ echo $personal_data['name']; }?>" />
	    <?php } ?>          	
 </div> 
 
 <div class="col-sm-4 mb30">
   <label class="label-custom">性別</label>    
      <?php if ($personal_data['type'] == 'complete'){
    		        ?>    		        
    		        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="sex" name="sex" placeholder="性別" readonly value="<?=$personal_data['sex']?>" />
    		        <?php
    		    }else{
    	?>       
               <select class="form-control form-control-custom" id="sex" name="sex" required>
	              <option value="" selected>請選擇</option>
	              <option value="男" <?php if (isset($personal_data['sex']) && $personal_data['sex'] == '男'){ echo 'selected'; }?>>男</option>
	              <option value="女" <?php if (isset($personal_data['sex']) && $personal_data['sex'] == '女'){ echo 'selected'; }?>>女</option>
	             </select>
	    <?php } ?>      
 </div>
 <div class="col-sm-4 mb30">
   <label class="label-custom">年齡</label>
    <?php if ($personal_data['type'] == 'complete'){
   	        $s_y = $personal_data['birth_year'] - 1911;
   	        $s_age = date('Y') - $personal_data['birth_year'];
   	        
   	        $birth_year = "民國 ".$s_y." 年 出生 - ".$s_age." 歲";
   	        ?>
   	        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="birth_year_show" name="birth_year_show" placeholder="年齡" readonly value="<?=$birth_year?>" />
   	        <input type="hidden" name="birth_year" id="birth_year" value="<?=$personal_data['birth_year']?>">						     
   	        <?php
         }else{
   ?>
            <select class="form-control form-control-custom" id="birth_year" name="birth_year" required>
	 	          <option value="" selected>請選擇</option>
	 	          <?php
	 	          $s_year_start = date('Y') - 10;  													   
	 	          $s_year_end = date('Y') - 90;  	
	 	          for ($i = $s_year_start;$i>=$s_year_end;$i--)
	 	          { 
	 	          	    $s_age = date('Y') - $i;
	 	          	    $s_y = $i - 1911;
	 	          	    $s_selected = '';
	 	          	    if (isset($personal_data['birth_year']) && $personal_data['birth_year'] == $i){
	 	          	        $s_selected = ' selected';	
	 	          	    }
	 	          	    
	 	          	    echo "<option value='".$i."' ".$s_selected.">民國 ".$s_y." 年 出生 - ".$s_age." 歲</option>";
	 	          }
	 	          ?>
	 	        </select>
	 <?php } ?>   
 </div>                               

          <div class="col-sm-4 mb30">
               <label class="label-custom">身高</label>
               <?php if ($personal_data['type'] == 'complete'){
    		        ?>
    	          	        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="q2" name="q2" placeholder="身高" readonly value="<?=$personal_data['q2']?>" />
    	          	        <?php
    	          	    }else{
    	          ?>
                         <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="q2" name="q2" placeholder="身高" onKeyUp="value=value.replace(/[^\d\#\-\(\)]/g,'')" maxlength="3" value="<?php if (isset($personal_data['q2']) && $personal_data['q2'] > ''){ echo $personal_data['q2']; }?>" />
	              <?php } ?> 
          </div>                       
          <div class="col-sm-4 mb30">
               <label class="label-custom">運動習慣</label>
                <?php if ($personal_data['type'] == 'complete'){
    		        ?>
    	          	        <input type="text" class="form-control form-control-custom" style="padding: 8px;" id="q1" name="q1" placeholder="運動習慣" readonly value="<?=$personal_data['q1']?>" />
    	          	        <?php
    	          	    }else{
    	          ?>
                         <select class="form-control form-control-custom" id="q1" name="q1" required>
	                         <option value="" selected>請選擇</option>
          	               <option value="有" <?php if (isset($personal_data['q1']) && $personal_data['q1'] == '有'){ echo 'selected'; }?>>有</option>
          	               <option value="無" <?php if (isset($personal_data['q1']) && $personal_data['q1'] == '無'){ echo 'selected'; }?>>無</option>
	                       </select>
	              <?php } ?> 
          </div>  
          
<div class="col-sm-12" id="personal_div" style="display:none;">
    <div class="alert alert-danger" role="alert" id="personal_errmsg">  
    </div>
</div>  
<?php if ($qtype == 'data'){ 

                    $data['question_title'] = '體測標準建議值 <span style="font-size:14px;color:red">(*全部有填寫才可記錄個人體測檢量表)</span>';
                   
                    $data['data'] = $personal_data;
    	          	  
    	          	  $data['required'] = '';
    	          	  
    	          	  $data['mark'] = ' <span style="font-size:14px;color:red">*</span>';
    	          	  
    	          	  $data['iname'] = '';
    	          	      	                  	      	  
    	              echo $this->load->view('member_form/question_q1', $data, TRUE);
?>    	              

<div class="col-sm-12" id="q1_div" style="display:none;">
    <div class="alert alert-danger" role="alert" id="q1_errmsg">  
    </div>
</div>  
<?php } ?>

<?php if ($qtype == 'data' || $qtype == 'q3'){ 
          if ($qtype == 'data'){
              echo '<h3 class="fs20 mt30 mb30">肌膚諮詢資料填寫 <span style="font-size:14px;color:red">(有填寫才可記錄肌膚諮詢表)</span></h3>';
          }else{
          	  echo '<h3 class="fs20 mt30 mb30">肌膚諮詢資料</h3>';
          } ?>
<div class="col-sm-12">
    <div class="container">
        <div class="card bg-light mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right" style="white-space:nowrap;">Q01</div>
                    <div class="col-md-11">肌膚困擾：<?php 
                    	      if (!isset($personal_data['q3']) || $personal_data['q3'] == ''){ 
                    	          echo '請自行勾選（可複選）';
    		                    } ?></div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">
                       <?php if (isset($personal_data['q3']) && $personal_data['q3'] > '' && $personal_data['type'] == 'complete'){
                       	         echo $personal_data['q3'];         
                       	         ?>
                       	         <input type="hidden" name="q3" id="q3" value="<?=$personal_data['q3']?>">						     
                       	         <?php              	         
                       	     }else{ ?> 
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_1" value="缺乏彈性" onClick="bq(0,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('缺乏彈性',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>
                                          >
                            <label class="form-check-label" for="q3_1">缺乏彈性　</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_2" value="不夠光澤" onClick="bq(1,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('不夠光澤',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_2">不夠光澤　</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_3" value="暗沉" onClick="bq(2,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('暗沉',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_3">暗沉 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_4" value="斑點" onClick="bq(3,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('斑點',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_4">斑點 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_5" value="毛孔粗大" onClick="bq(4,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('毛孔粗大',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_5">毛孔粗大 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_6" value="痘痘粉刺" onClick="bq(5,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('痘痘粉刺',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_6">痘痘粉刺 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_7" value="皺紋" onClick="bq(6,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('皺紋',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_7">皺紋 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_8" value="粗糙" onClick="bq(7,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('粗糙',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_8">粗糙 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_9" value="泛紅" onClick="bq(8,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('泛紅',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_9">泛紅 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_10" value="癢" onClick="bq(9,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('癢',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_10">癢 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_11" value="紅腫" onClick="bq(10,'A');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('紅腫',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_11">紅腫 </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="q3[]" id="q3_12" value="無" onClick="bq(11,'B');"
                                          <?php 
                                          if (isset($personal_data['q3']) && $personal_data['q3'] > ''){
                                          	  $tmp_q3 = explode(',',$personal_data['q3']);
                                          	  if (in_array('無',$tmp_q3)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                            <label class="form-check-label" for="q3_12">無 </label>
                        </div>
                        <?php } ?> 
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($personal_data['q4']) && $personal_data['q4'] > '' && $personal_data['type'] == 'complete'){ ?>                  
                  <div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">        					            
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_1"><?=$personal_data['q4']?> </label>
        					            <input type="hidden" name="q4" id="q4" value="<?=$personal_data['q4']?>">						                            	      
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-center">肌膚特徵：<?=$form_q4_set[$personal_data['q4'].'_time']?></div>
        					    <div class="col-md-4 text-center">建議產品：<?=$form_q4_set[$personal_data['q4'].'_hz']?></div>
        					</div>                  	         
        <?php }else{ ?>               	     
        					<div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">  Q02      					        
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-center">肌膚特徵</div>
        					    <div class="col-md-4 text-center">建議產品</div>
        					</div>
        					<div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">
        					            <input class="form-check-input" type="radio" name="q4" id="q4_1" required value="普通肌"
        					            <?php 
                              if (isset($personal_data['q4']) && $personal_data['q4'] == '普通肌'){
                              	  echo ' checked';
                              }
                              ?>
        					            >
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_1">普通肌 </label>
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-left"><?=$form_q4_set['普通肌_time']?></div>
        					    <div class="col-md-4 text-left"><?=$form_q4_set['普通肌_hz']?></div>
        					</div>
        					<div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">
        					            <input class="form-check-input" type="radio" name="q4" id="q4_2" value="油性肌"
        					            <?php 
                              if (isset($personal_data['q4']) && $personal_data['q4'] == '油性肌'){
                              	  echo ' checked';
                              }
                              ?>>
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_2">油性肌 </label>
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-left"><?=$form_q4_set['油性肌_time']?></div>
        					    <div class="col-md-4 text-left"><?=$form_q4_set['油性肌_hz']?></div>
        					</div>
        					<div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">
        					            <input class="form-check-input" type="radio" name="q4" id="q4_3" value="乾性肌"
        					            <?php 
                              if (isset($personal_data['q4']) && $personal_data['q4'] == '乾性肌'){
                              	  echo ' checked';
                              }
                              ?>>
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_3">乾性肌 </label>
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-left"><?=$form_q4_set['乾性肌_time']?></div>
        					    <div class="col-md-4 text-left"><?=$form_q4_set['乾性肌_hz']?></div>
        					</div>
        					<div class="row mb-3 border-bottom">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">
        					            <input class="form-check-input" type="radio" name="q4" id="q4_4" value="混合肌"
        					            <?php 
                              if (isset($personal_data['q4']) && $personal_data['q4'] == '混合肌'){
                              	  echo ' checked';
                              }
                              ?>>
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_4">混合肌 </label>
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-left"><?=$form_q4_set['混合肌_time']?></div>
        					    <div class="col-md-4 text-left"><?=$form_q4_set['混合肌_hz']?></div>
        					</div>
        					<div class="row mb-3">
        					    <div class="col-md-3">
        					        <div class="form-check form-check-inline">
        					            <input class="form-check-input" type="radio" name="q4" id="q4_5" value="敏感肌"
        					            <?php 
                              if (isset($personal_data['q4']) && $personal_data['q4'] == '敏感肌'){
                              	  echo ' checked';
                              }
                              ?>>
        					            <label class="form-check-label btn btn-outline-info btn-block" for="q4_5">敏感肌 </label>
        					        </div>
        					    </div>
        					    <div class="col-md-5 text-left"><?=$form_q4_set['敏感肌_time']?></div>
        					    <div class="col-md-4 text-left"><?=$form_q4_set['敏感肌_hz']?></div>
        					</div>  
 
<script>
function bq(jnum,jtype){				                    
				 var fields = document.getElementsByName("q3[]");   
				 if (jtype == 'B'){ 
				     if (fields[11].checked){ 
				         for (var i=0 ; i< 11;i++){ 
				              fields[i].checked = false; 
				         }  
				     } 
				 }else{ 
				     if (fields[jnum].checked){ 
				         fields[11].checked = false; 
				     } 
				 } 
} 
</script>	      
        <?php } ?>               	     
    </div>    
</div>

<div class="col-sm-12" id="q3_div" style="display:none;">
    <div class="alert alert-danger" role="alert" id="q3_errmsg">  
    </div>
</div> 
<?php } ?>