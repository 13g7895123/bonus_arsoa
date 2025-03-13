<?php if (isset($question_date)){ ?>
<?php }else{ ?>
          <h3 class="fs20 mt30 mb30"><?=$question_title?></h3>
<?php } ?>          
			          	
<div class="container mb-4">
    <div class="card bg-light">
    	<div class="card-body">
<?php if (isset($question_date)){ ?>
          <div class="row">
					   <div class="col-6">
						    <h3 class="fs20 mt10 mb30"><?=$question_title?></h3>
					   </div>
  					 <div class="col-6 text-right">
						     <p class="mt10 mb30">實測日期：<?=$question_date?></p>
					   </div>
					</div>
<?php }else{ ?>

<?php } ?>  
                <div class="container">
                    <div class="row">
                      <div class="col-sm-4 mb30">
                        <label class="label-custom" style="text-transform:none;">體重Kg<?php if (isset($mark)){ echo $mark;}?></label>
                        <input type="text" class="form-control form-control-custom" placeholder="限填數字<?php if ($required > ''){ echo '(必填)';} ?>" <?=$required?> <?php if (isset($readonly)){ echo $readonly;}?> id="<?=$iname?>f1" name="<?=$iname?>f1" maxlength="5" value="<?php if (isset($data) && isset($data['f1'])){ echo show_number($data['f1'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
                      <div class="col-sm-4 mb30">
                        <label class="label-custom">BMI</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f2" name="<?=$iname?>f2" maxlength="5" value="<?php if (isset($data) && isset($data['f2']) && $data['f2'] > ''){ echo show_number($data['f2'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
                      <div class="col-sm-4 mb30">
                        <label class="label-custom">脂肪率%<?php if (isset($mark)){ echo $mark;}?></label>
                        <input type="text" class="form-control form-control-custom" placeholder="限填數字<?php if ($required > ''){ echo '(必填)';} ?>" <?=$required?> <?php if (isset($readonly)){ echo $readonly;}?> id="<?=$iname?>f3" name="<?=$iname?>f3" maxlength="5" value="<?php if (isset($data) && isset($data['f3'])){ echo show_number($data['f3'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
                      <div class="col-sm-4 mb30">
                        <label class="label-custom" style="text-transform:none;">脂肪量Kg</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f4" name="<?=$iname?>f4" maxlength="5" value="<?php if (isset($data) && isset($data['f4']) && $data['f4'] > ''){ echo show_number($data['f4'],1); }  ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
                      <div class="col-sm-4 mb30">
                        <label class="label-custom">肌肉%</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f5" name="<?=$iname?>f5" maxlength="5" value="<?php if (isset($data) && isset($data['f5'])  && $data['f5'] > ''){ echo show_number($data['f5'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom" style="text-transform:none;">肌肉量Kg</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f6" name="<?=$iname?>f6" maxlength="5" value="<?php if (isset($data) && isset($data['f6'])  && $data['f6'] > ''){ echo show_number($data['f6'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">水份比例%</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f7" name="<?=$iname?>f7" maxlength="5" value="<?php if (isset($data) && isset($data['f7'])  && $data['f7'] > ''){ echo show_number($data['f7'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    	                <div class="col-sm-4 mb30">
                        <label class="label-custom" style="text-transform:none;">水含量Kg</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f8" name="<?=$iname?>f8" maxlength="5" value="<?php if (isset($data) && isset($data['f8'])  && $data['f8'] > ''){ echo show_number($data['f8'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">內臟脂肪率%<?php if (isset($mark)){ echo $mark;}?></label>
                        <input type="text" class="form-control form-control-custom" placeholder="限填數字<?php if ($required > ''){ echo '(必填)';} ?>" <?=$required?> <?php if (isset($readonly)){ echo $readonly;}?> id="<?=$iname?>f9" name="<?=$iname?>f9" maxlength="5" value="<?php if (isset($data) && isset($data['f9'])  && $data['f9'] > ''){ echo show_number($data['f9'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom" style="text-transform:none;">骨量Kg<?php if (isset($mark)){ echo $mark;}?></label>
                        <input type="text" class="form-control form-control-custom" placeholder="限填數字<?php if ($required > ''){ echo '(必填)';} ?>" <?=$required?> <?php if (isset($readonly)){ echo $readonly;}?> id="<?=$iname?>f10" name="<?=$iname?>f10" maxlength="5" value="<?php if (isset($data) && isset($data['f10']) && $data['f10'] > ''){ echo show_number($data['f10'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">基礎代謝率(卡)<?php if (isset($mark)){ echo $mark;}?></label>
                        <input type="text" class="form-control form-control-custom" placeholder="限填數字<?php if ($required > ''){ echo '(必填)';} ?>" <?=$required?> <?php if (isset($readonly)){ echo $readonly;}?> id="<?=$iname?>f11" name="<?=$iname?>f11" maxlength="5" value="<?php if (isset($data) && isset($data['f11'])  && $data['f11'] > ''){ echo show_number($data['f11'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">蛋白質%</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f12" name="<?=$iname?>f12" maxlength="5" value="<?php if (isset($data) && isset($data['f12'])  && $data['f12'] > ''){ echo show_number($data['f12'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">肥胖度%</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f13" name="<?=$iname?>f13" maxlength="5" value="<?php if (isset($data) && isset($data['f13'])  && $data['f13'] > ''){ echo show_number($data['f13'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">身體年齡</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f14" name="<?=$iname?>f14" maxlength="5" value="<?php if (isset($data) && isset($data['f14']) && $data['f14'] > ''){ echo show_number($data['f14'],1);} ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
    		              <div class="col-sm-4 mb30">
                        <label class="label-custom">去脂體重Kg</label>
                        <input type="text" class="form-control form-control-custom" <?php if (isset($readonly) && $readonly > ''){ echo $readonly;}else{ echo 'placeholder="限填數字"'; } ?> id="<?=$iname?>f15" name="<?=$iname?>f15" maxlength="5" value="<?php if (isset($data) && isset($data['f15']) && $data['f15'] > ''){ echo show_number($data['f15'],1); } ?>" onkeyup="this.value=this.value.toString().match(/^\d+(?:\.\d{0,1})?/)"/>
                      </div>
                    </div>                                    
                </div>
                <?php if (isset($question_checkcode)){
                	        ?>
                          <div align=center>
    	                       <button type="button" class="btn btn-secondary" onClick="location.href='<?=base_url('member_form/modify/q1/'.$question_checkcode)?>';">修改</button>
    	                    </div>
    	          <?php } ?>
    	</div>    	
    </div>
</div>