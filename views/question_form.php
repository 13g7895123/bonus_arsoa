<?php
$q_num = 0;
$h_required = 0;
$n_required = 0;
foreach ($question_data['q_ans'] as $key => $item){ 
	$q_num++;
	if ($item['required'] == 'Y'){
		  $h_required++;
	}else{
		  $n_required++;
	}
}
// 全部都是必填

$d_required_title = '<div id="div_required" style="color: red;font-size:14px; margin-top: 15px; margin-bottom: 5px;">必填</div>';
$m_required_title = '<span style="color: red;font-size:14px;">&nbsp;必填</span>';
if ($q_num == $h_required){
	  $d_required_title = '';
	  $m_required_title = '';
}
?>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        <form class="form-horizontal upload_form" action="<?=$action?>" method="post" data-toggle="validator" role="form">    	         	
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="section-mini">			
          <div class="section-item text-center"> 
             <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <h1 class="h2-3d font-libre">
                                        <strong><?=$question_data['q_title']?></strong>
                                    </h1>
                                    <?php if ($question_data['q_desc'] > ''){ ?>
                                             <div class="news-info mb30 text-left"><?=$question_data['q_desc']?></div>
                                    <?php } ?>        
                                    <div class="mb-4">
                                        <div class="container">
                                          <?php                                         
                                          foreach ($question_data['q_ans'] as $key => $item){ 
                                          	             $ans = '';
                                          	             if (isset($ans_data[$key]['ans'])){
                                          	                 $ans = trim($ans_data[$key]['ans']);	                                          	             	
                                          	             }                                          	             
                                          	             $inum = $key + 1;
                                          	             $itype = 'radio';
                                          	             $iname = 'q_'.$inum.'';
                                          	                                                       	       
                                          	             if ($item['ans_config']['type'] == 'C'){
                                          	             	   $itype = 'checkbox';
                                          	             	   $iname = 'q_'.$inum.'[]';
                                          	             }
                                          	             $irequired = '';
                                          	             if ($item['required'] == 'Y'){
                                          	             	   $irequired = 'required';
                                          	             }
                                          	             
                                          	             $bgcolor = '';
                                          	             $dclass = 'card mb-3';
                                          	             if ($key % 2 == 1 && isset($question_data['q_config']['color_background1']) && $question_data['q_config']['color_background1'] > ''){
                                          	             	   $bgcolor = 'background-color:#'.$question_data['q_config']['color_background1'].';';
                                          	             }
                                          	             if ($key % 2 == 0 && isset($question_data['q_config']['color_background2']) && $question_data['q_config']['color_background2'] > ''){
                                          	             	   $bgcolor = 'background-color:#'.$question_data['q_config']['color_background2'].';';
                                          	             }
                                          	             if ($key % 2 == 1){
                                          	                 $dclass .= ' bg-light';                                          	                 
                                          	             }
                                          	             
                                          	             $img = '';
                                          	             if (trim($item['img']) > 0){
                                          	                 $img = '<img src="'.base_url('public/question/'.$item['img']).'" style="width:100%">';
                                          	             }
                                          	             ?>                                           
                                                         <div class="<?=$dclass?>" style="
                                                         	   <?php  if (isset($question_data['q_config']['color_border']) && $question_data['q_config']['color_border'] > ''){
                                                         	              echo 'border-color:#'.$question_data['q_config']['color_border'].';';
                                                         	          }
                                                         	          echo $bgcolor;
                                                         	   ?>" id="q_div_<?=$inum?>">
                                                             <div class="card-body">
                                                                 <div class="row mb-3">
                                                                     <div class="col-md-1 border-right">
                                                                     	<?php
                                                                     	if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     	 	  echo '<span style="color:#'.$question_data['q_config']['color_font'].';">';
                                                                      }
                                                                      ?>
                                                                     	問題<?=sprintf('%2d', $inum)?>
                                                                     	<?php
                                                                     	if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     	 	  echo '</span>';
                                                                      }
                                                                      ?>
                                                                     	<?php
                                                                     	if ($item['required'] == 'Y' && $platform == 'MOBILE'){  
                                                                     		  echo $m_required_title;
                                                                      }?></div>
                                                                     <div class="col-md-11 text-left">
                                                                     	<?php if ($item['no_title'] != 'Y'){ 
                                                                     		        if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     		        	  echo '<span style="color:#'.$question_data['q_config']['color_font'].';">';
                                                                     		        }
                                                                     		        echo $item['title'];
                                                                     		        if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     		        	  echo '</span>';
                                                                     		        }
                                                                     		    } ?>
                                                                     	<?=$img?>                                                                     	
                                                                     	</div>
                                                                 </div>
                                                                 <div class="row">
                                                                     <div class="col-md-1 border-right"><?php
                                                                     	if ($item['required'] == 'Y' && $platform == 'DESKTOP'){
                                                                     		  echo $d_required_title;
                                                                      }?></div>
                                                                     <div class="col-md-11 text-left">
                                                                     	<?php 
                                                                     	if ($item['ans_config']['type'] == 'T'){
                                                                     	    echo '<input type="text" style="margin-top: -30px;" class="form-control" placeholder="限輸入100字" name="'.$iname.'" id="'.$iname.'" value="'.$ans.'" maxlength="100" '.$irequired.'>';
                                                                     	}elseif($item['ans_config']['type'] == 'A'){                                                                     		
                                                                     	    ?>
                                                                          <textarea style="margin-top: -30px;" name="<?php echo $iname?>" id="<?php echo $iname?>" cols="3" rows="4" placeholder="限輸入300字" class="form-control" onpropertychange="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight" onClick="if(this.scrollHeight>=180)this.style.posHeight=this.scrollHeight"><?=$ans?></textarea>
																																					<script>
																																					$(document).ready(function(){
																																					  var maxCharacters = 300;
																																					  $('#<?php echo $iname?>').on('input', function() {
																																					    var text = $(this).val();
																																					    if (text.length > maxCharacters) {
																																					      $(this).val(text.substring(0, maxCharacters));
																																					    }
																																					  });
																																					});
																																					</script>
                                                                     	    <?php
                                                                      }else{
                                                                      	    $ans_array = explode(',',$ans);                                                                      	    
                                                                     	      foreach ($item['ans_data']['ans'] as $akey => $aitem){                                                                     	
                                                                     		           $selected = '';
                                                                     		           $checked = '';
                                                                     		       	   if (in_array($aitem,$ans_array)){
                                                                     		       	   	   $selected = ' selected';
                                                                     		       	   	   $checked = ' checked';
                                                                     		       	   }
                                                                     		           if ($item['ans_config']['type'] == 'S'){                                                                      		       	   
                                                                     		           	   if ($akey == 0){
                                                                     		           	   	   echo '<select class="form-control" name="'.$iname.'" id="'.$iname.'" '.$irequired.'>';
                                                                     		           	   	   echo '<option value="">請選擇</option>';
                                                                     		           	   }   
                                                                     		           	   echo '<option value="'.$aitem.'" '.$selected.'>'.$aitem.'</option>';
                                                                     		           	   if (($akey + 1) == $item['ans_data']['count']){
                                                                     		           	   	   echo '</select>';
                                                                     		           	   }
                                                                     		           }else{
                                                                     		              ?>   
                                                                                      <div class="form-check">
                                                                                          <input class="form-check-input" type="<?=$itype?>" name="<?=$iname?>" id="q_<?=$inum?>_<?=$akey?>" value="<?=$aitem?>" <?=$checked ?>>
                                                                                          <label class="form-check-label" for="q_<?=$inum?>_<?=$akey?>">
                                                                                          <?php
                                                                                          if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     		            	        echo '<span style="color:#'.$question_data['q_config']['color_font'].';">';
                                                                     		                  }
                                                                     		                  echo $aitem;
                                                                     		                  if (isset($question_data['q_config']['color_font']) && $question_data['q_config']['color_font'] > ''){
                                                                     		                   	  echo '</span>';
                                                                     		                  }?></label>
                                                                                      </div>
                                                                       <?php       }
                                                                            }                                                                            
                                                                       } ?>  
                                                                            <div class="clearfix"></div>
                                                                            <div id="div_errmsg_<?=$inum?>" style="display:none;color: red;font-size:14px; margin-top: 5px; margin-bottom: 5px;"></div>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                          <?php } ?>                                               
                                        </div>
                                    </div>
                                    <hr class="mt-0 mb-4">
                                    <?php if (isset($line_push) && $line_push == 'Q'){ 
                                    	        $checked = '';
                                              if ($show_web == 'N'){
                                              	   $checked = ' checked';
                                              }
                                    	        ?>
                                              <label style="margin-bottom: 15px;"><input type="checkbox" name="show_web" id="show_web" value="N"
                                              	<?=$checked?>
                                              	> 不願意顯示在官網</label>
                                    <?php } ?>
                                    <?php 
                                          $submit = false;
                                          if (isset($view) && $view){ ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit_preview">內容檢視 無法送出</button>     
                                    <?php }else{  
                                  	          if ($preview){ ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit_preview">後台預覽 無法送出</button>    
                                    <?php    }else{ 
                                    	            $submit = true;
                                    	            ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit">送出表單</button>
                                    <?php    } 
                                          }?>      
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        <?=$this->block_service->load_html_footer(); ?>  
     </div>     
</div>
<?php if ($submit){ ?>
<script>
function question_check(selq,selcnt){
	  $("input[name='"+selq+"[]']").attr('disabled', true);
    if ($("input[name='"+selq+"[]']:checked").length >= selcnt) {
        $("input[name='"+selq+"[]']:checked").attr('disabled', false);
    } else {
       $("input[name='"+selq+"[]']").attr('disabled', false);
    }    
}	
$(document).ready(function () {        
        //提交前檢查
        $("#contact-submit").click(function () {
            var jsub = true;
            var focusstr = '';
            <?php 
                $script = '';
                $script1 = '';
                foreach ($question_data['q_ans'] as $key => $item){                 	         
            	             $inum = $key + 1;
            	             $iname = 'q_'.$inum.'';
            	             echo "document.getElementById('div_errmsg_".$inum."').style.display='none';";
            	             if ($item['required'] == 'Y'){  // 必填
            	                 if ($item['ans_config']['type'] == 'C'){          	             	   
            	                 	   ?>
            	                 	   if($("input[name='<?=$iname?>[]']:checked").length==0){  /*至少要勾*/
                                       $('#div_errmsg_<?=$inum?>').html('這是必答問題。');	
                                       document.getElementById('div_errmsg_<?=$inum?>').style.display='';
                                       if (focusstr ==''){ focusstr = '<?=$inum?>'; } 	       	      	 
                                       jsub = false;
                                   }
            	                 	   <?php            	                 	   
            	                 }
            	                 if ($item['ans_config']['type'] == 'S'){
            	                 ?>
            	                     if ($('#<?=$iname?> option:selected').val() == ''){            	                     	   
                                       $('#div_errmsg_<?=$inum?>').html('這是必答問題。');	
                                       document.getElementById('div_errmsg_<?=$inum?>').style.display='';
                                       if (focusstr ==''){ focusstr = '<?=$inum?>'; } 	       	      	 
                                       jsub = false;
            	                     }
            	                 <?php	
            	                 }            	                 
            	                 if ($item['ans_config']['type'] == 'R'){
            	                 ?> 	            	                    
            	                  	var method =$("input[name='<?=$iname?>']:checked").val(); 
                                  if( typeof(method) == "undefined"){ 
            	                  		  $('#div_errmsg_<?=$inum?>').html('這是必答問題。');	
                                       document.getElementById('div_errmsg_<?=$inum?>').style.display='';
                                       if (focusstr ==''){ focusstr = '<?=$inum?>'; } 	       	      	 
                                       jsub = false;
            	                  	}
            	                 <?php
            	                 }
            	             }            	             
            	             if ($item['ans_config']['type'] == 'C'){         // 勾選            	              	 
            	              	 echo " if (jsub){ ";
            	              	 if ($item['ans_config']['set'] == 'E' || $item['ans_config']['set'] == 'M'){   //  剛好和最多,限制數量
            	                     $script1 .= " question_check('".$iname."',".$item['ans_config']['num']."); ";
            	                     $script .= "$('input[type=checkbox]').click(function() { question_check('".$iname."',".$item['ans_config']['num']."); }); ";
            	                     if ($item['ans_config']['set'] == 'E'){  // 需剛好等於
            	                     ?>
            	                 	   if($("input[name='<?=$iname?>[]']:checked").length != <?=$item['ans_config']['num']?>){ //至少要勾一個頻道
                                       $('#div_errmsg_<?=$inum?>').html('至少要勾選 <?=$item['ans_config']['num']?> 個');	
                                       document.getElementById('div_errmsg_<?=$inum?>').style.display='';
                                       if (focusstr ==''){ focusstr = '<?=$inum?>'; } 	       	      	 
                                       jsub = false;
                                   }
            	                 	   <?php	
            	                     }
            	                 }else{  // 需大於
            	                 	   ?>
            	                 	   if($("input[name='<?=$iname?>[]']:checked").length < <?=$item['ans_config']['num']?>){ //至少要勾幾個
                                       $('#div_errmsg_<?=$inum?>').html('至少要勾選 <?=$item['ans_config']['num']?> 個以上');	
                                       document.getElementById('div_errmsg_<?=$inum?>').style.display='';
                                       if (focusstr ==''){ focusstr = '<?=$inum?>'; } 	       	      	 
                                       jsub = false;
                                   }
            	                 	   <?php
            	                 }
            	                 echo " } ";
            	             }
            	    
            	  } 
            ?>	           
            if(jsub){
               $(".upload_form:first").submit();
            }else{
            	 $('html,body').animate({scrollTop:$('#q_div_'+focusstr).offset().top}, 500);
            	 return false;
            }
        });        
        <?=$script?>
        <?=$script1?>
});
</script>
<?php } ?>