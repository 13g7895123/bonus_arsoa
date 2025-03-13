<div class="mb-4">
    <div class="container">
        <div class="card bg-light mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right">Q01</div>
                    <div class="col-md-11">個人基本健康狀況資訊：</div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">                        
                                <?php foreach ($form_q2_set['q1'] as $key => $item){
                                	        ?>                                	      
                                	        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="checkbox" name="q1[]" id="q1_<?=$key+1?>" value="<?=$item?>" onClick="bq(<?=$key?>,'A');"
                                          <?php 
                                          if (isset($q1) && $q1 > ''){
                                          	  $tmp_q1 = explode(',',$q1);
                                          	  if (in_array($item,$tmp_q1)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                                          <label class="form-check-label" for="q1_<?=$key+1?>"><?=$item?>　</label>
                                        </div>
                                  <?php } ?>                                  
								                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="q1[]" id="q1_97_1" value="其它" onClick="bq(11,'A');"
                                    <?php 
                                          $q1_other = '';
                                          if (isset($q1) && $q1 > ''){
                                          	  if (substr_count($q1,"其它(")>0){					                                          	  
                                          	  	  echo ' checked';
                                          	  	  $q1_other=trim($this->block_service->PF_GetStr($q1,"其它(",")",1));					
                                          	  }                                          	  
                                          }
                                    ?>>
                                    <label class="form-check-label" for="q1_97_1">其它請註明：</label>
									                  <input type="text" name="q1_other" id="q1_other" value="<?=$q1_other?>" maxlength="30">
                                  </div>	  
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="q1[]" id="q1_99_1" value="無" onClick="bq(12,'B');"
                                    <?php 
                                          $q1_other = '';
                                          if (isset($q1) && $q1 > ''){
                                          	  if (substr_count($q1,"無")>0){					                                          	  
                                          	  	  echo ' checked';
                                          	  }                                          	  
                                          }
                                    ?>>
                                     <label class="form-check-label" for="q1_99_1">無　</label>
                                  </div>                                
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right">Q02</div>
                    <div class="col-md-11">抽煙</div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">
                    	              <?php foreach ($form_q2_set['q2'] as $key => $item){
                                	        ?>                                	      
                                	        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="q2" id="q2_<?=$key+1?>" value="<?=$item?>"
                                          <?php 
                                          if (isset($q2) && $q2 == $item){
                                          	  echo ' checked';                                          	  
                                          }
                                          ?>>
                                          <label class="form-check-label" for="q2_<?=$key+1?>"><?=$item?>　</label>
                                        </div>
                                  <?php } ?>
                                  
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right">Q03</div>
                    <div class="col-md-11">喝酒</div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">
                                  <?php foreach ($form_q2_set['q3'] as $key => $item){
                                	        ?>                                	      
                                	        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="q3" id="q3_<?=$key+1?>" value="<?=$item?>"
                                          <?php 
                                          if (isset($q3) && $q3 == $item){
                                          	  echo ' checked';                                          	  
                                          }
                                          ?>>
                                          <label class="form-check-label" for="q3_<?=$key+1?>"><?=$item?>　</label>
                                        </div>
                                  <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right">Q04</div>
                    <div class="col-md-11">眼部健康狀況：</div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">
                                  <?php foreach ($form_q2_set['q4'] as $key => $item){
                                	        ?>                                	      
                                	        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="checkbox" name="q4[]" id="q4_<?=$key+1?>" value="<?=$item?>"
                                          <?php 
                                          if (isset($q4) && $q4 > ''){
                                          	  $tmp_q4 = explode(',',$q4);
                                          	  if (in_array($item,$tmp_q4)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                                          <label class="form-check-label" for="q4_<?=$key+1?>"><?=$item?>　</label>
                                        </div>
                                  <?php } ?>
								                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="q4[]" id="q4_11" value="眼部曾經手術，病因"
                                    <?php 
                                          $q4_other = '';
                                          if (isset($q4) && $q4 > ''){
                                          	  if (substr_count($q4,"眼部曾經手術，病因(")>0){					                                          	  
                                          	  	  echo ' checked';
                                          	  	  $q4_other=trim($this->block_service->PF_GetStr($q4,"眼部曾經手術，病因(",")",1));					
                                          	  }                                          	  
                                          }
                                    ?>>
                                    <label class="form-check-label" for="q4_11">眼部曾經手術，病因：</label>
									                  <input type="text" name="q4_other" id="q4_other" value="<?=$q4_other?>" maxlength="30">
                                  </div>	
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-light mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 border-right">Q05</div>
                    <div class="col-md-11">生活習慣：</div>
                </div>
                <div class="row">
                    <div class="col-md-1 border-right"></div>
                    <div class="col-md-11">
                                  <?php foreach ($form_q2_set['q5'] as $key => $item){
                                	        ?>                                	      
                                	        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="checkbox" name="q5[]" id="q5_<?=$key+1?>" value="<?=$item?>"
                                          <?php 
                                          if (isset($q5) && $q5 > ''){
                                          	  $tmp_q5 = explode(',',$q5);
                                          	  if (in_array($item,$tmp_q5)){
                                          	  	  echo ' checked';
                                          	  }
                                          }
                                          ?>>
                                          <label class="form-check-label" for="q5_<?=$key+1?>"><?=$item?>　</label>
                                        </div>
                                  <?php } ?>
								                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="q5[]" id="q5_97_1" value="其它"
                                    <?php 
                                          $q5_other = '';
                                          if (isset($q5) && $q5 > ''){
                                          	  if (substr_count($q5,"其它(")>0){					                                          	  
                                          	  	  echo ' checked';
                                          	  }
                                          	  $q5_other=trim($this->block_service->PF_GetStr($q5,"其它(",")",1));					
                                          }
                                    ?>>
                                    <label class="form-check-label" for="q5_97_1">其它請註明：</label>
									                  <input type="text" name="q5_other" id="q5_other" value="<?=$q5_other?>" maxlength="30">
                                  </div>	                                  		
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>         
<script>
function bq(jnum,jtype){				                    
				 var fields = document.getElementsByName("q1[]");   
				 if (jtype == 'B'){ 
				     if (fields[12].checked){ 
				         for (var i=0 ; i< 12;i++){ 
				              fields[i].checked = false; 
				         }  
				         $("#q1_other").val('');
				     } 
				 }else{ 
				     if (fields[jnum].checked){ 
				         fields[12].checked = false; 
				     } 
				 } 
} 
</script>	