<?php
  if (!isset($form_edit)){
  	  $form_edit = 'N';
  }
?>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">               
               <div class="col-md-9 mb130 mt-lg-5" role="main">                  
                  <h1 class="h2-3d font-libre"><strong><?=$form_set[$qtype]?></strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">                    
                        <?php if ($form_edit == 'N'){ ?>
                                  <div class="row">                                	
  											          	<div class="form-group mx-sm-3 mb-2">
  											          	  <label for="name" class="sr-only">手機號碼</label>
  											          	  <input type="text" class="form-control" id="check_mobile" name="check_mobile" placeholder="手機號碼" value="<?php if (isset($check_mobile)){ echo $check_mobile;} ?>" maxlength="10" onKeyUp="value=value.replace(/[^0123456789]/g,'')" required>
  											          	</div>
  											          	<input type="button" class="btn btn-primary mb-2" onclick="check_mobile_form('<?=$qtype?>');" style="height: 46px;" value="下一步">    											  
  											          	<span id="check_mobile_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
                                  </div>
                        <?php } ?>
                        <form name="oForm" id="oForm"  method="post" action="<?=base_url('member_form/question_save/'.$qtype)?>"<?=$onSubmit?>>
                        <div class="row" id="form_personal" style="margin-top: 30px;">      
                        	<?php if (isset($html)){ echo $html; }?>      
                        </div>            
                        <div id="form_question">		
					        	      <?php if (isset($question)){ echo $question; }?>      
                        </div>   
			          	      </form>          
                    </div>
                  </div>					        					        
			         </div>			          
               
               <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">					
         				  <?=$this->block_service->member_form_menu($qtype); ?>  
               </aside>
			        </div>
			      </div>
			    </div>  
			  </div>      	
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
       </div>
     </div>
</div>       
<script>
$( "#check_mobile" ).keypress(function(event) {
    var keynum = (event.keyCode ? event.keyCode : event.which); 
    if(keynum == '13'){ 
         check_mobile_form('<?=$qtype?>','S');
    }
});	
var bFlag=true;	
function check_mobile_form(qtype)
{
      $("#check_mobile_msg").html('');
      if ($("#check_mobile").val() == ''){
     	    $("#check_mobile_msg").html('手機號碼未填寫！'); 
      }else{
      	  if(!/^0[0-9]{8,9}$/.test( $('input[name=check_mobile]').val())){
      	  	 $("#check_mobile_msg").html('請輸入正確的手機號碼！');  
      	  }else{      	  
               $.ajax({
                    url: base_url+"member_form/check_mobile/"+qtype,
                    type: "POST",
                    dataType: "json",
                    data:{"check_mobile":$("#check_mobile").val()
                    },
                    success: function(data){                    
                        if (data.status){                            
                            $("#form_personal").html(data.html);
                            $("#form_question").html(data.question);
                        }else{
                            $("#form_personal").html(data.msg);
                        }    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.responseText);
                    }
               });
          }
      }
}

function modify(qtype,qcheckcode)
{
    $.ajax({
         url: base_url+"member_form/modify/"+qtype+"/"+qcheckcode,
         type: "GET",
         dataType: "json",
         success: function(data){                    
             if (data.status){                            
                 $("#form_personal").html(data.html);
                 $("#form_question").html(data.question);
                 $('html,body').animate({scrollTop:$('#oForm').offset().top}, 100);
             }else{
                 $("#form_personal").html(data.msg);
             }    
         },
         error: function (xhr, ajaxOptions, thrownError) {
             console.log(xhr.responseText);
         }
    });      
}

function checkbox_msg(temp,other_title){              
        var fstr = ''; 
        var fields = document.getElementsByName(temp+'[]');              
        for (var k=0 ; k< fields.length;k++){ 
             if (fields[k].checked){ 
             	   if (fstr > ''){ fstr = fstr + ',';} 
             	   fstr = fstr + fields[k].value; 
            	   if (fields[k].value == 97 || fields[k].value == other_title) {
            	   	   if (document.getElementById(""+temp+"_other").value > ''){            	   	       
            	   	       fstr = fstr + "(" + document.getElementById(""+temp+"_other").value + ")";
            	   	   }
            	   }
             } 
        }               
        return fstr;
}  

function checkbox_other(temp,other_title){              
        var fstr = 'N'; 
        var fields = document.getElementsByName(temp+'[]');              
        for (var k=0 ; k< fields.length;k++){ 
             if (fields[k].checked){              	   
            	   if (fields[k].value == other_title) {
            	   	   fstr = document.getElementById(""+temp+"_other").value;
            	   }
             } 
        }
        return fstr;
}  

function getRadiovalue(formObj) {  
 var value  = '';
 for (var i=0;i<formObj.length;i++){
      if (formObj[i].checked){
       value=formObj[i].value
             break
      }
 }
 return value
}



function Form_question_check(obj)
{ 
	    var cError="很抱歉，您尚未輸入完成！\n\n";
      var bErrorFlag=false;
      var focusObj;
      <?php if ($qtype == 'q2'){ ?>
      					var q1str = checkbox_msg('q1','其它');
      					if (q1str == ''){          
      					    cError=cError+" 個人基本健康狀況\n";          
      					 //   if ( focusObj == null ) focusObj = obj.q1[0];
      					    bErrorFlag=true;
      					}else{
      						  if (checkbox_other('q1','其它') == ''){      	  	  
      						  	  cError=cError+" 個人基本健康狀況 其它 未填寫\n";          
      					        if ( focusObj == null ) focusObj = obj.q1_other;
      					        bErrorFlag=true;      	  	  
      						  }
      					} 
      					var q2str = getRadiovalue(obj.q2);      
      					if (q2str == ''){          
      					    cError=cError+" 抽煙資訊\n";
      					    if ( focusObj == null ) focusObj = obj.q2[0];
      					    bErrorFlag=true;
      					}
      					var q3str = getRadiovalue(obj.q3);      
      					if (q3str == ''){
      					    cError=cError+" 喝酒資訊\n";
      					    if ( focusObj == null ) focusObj = obj.q3[0];
      					    bErrorFlag=true;
      					}
      					var q4str = checkbox_msg('q1','眼部曾經手術，病因');
      					if (q4str == ''){
      					    cError=cError+" 眼部健康狀況\n";
      					  //  if ( focusObj == null ) focusObj = obj.q4[0];
      					    bErrorFlag=true;
      					}else{
      						  if (checkbox_other('q4','眼部曾經手術，病因') == ''){      	  	  
      						  	  cError=cError+" 眼部曾經手術，病因 未填寫\n";          
      					        if ( focusObj == null ) focusObj = obj.q4_other;
      					        bErrorFlag=true;      	  	  
      						  }
      					} 
      					var q5str = checkbox_msg('q5','其它');
      					if (q5str == ''){
      						  cError=cError+" 生活習慣\n";
      					  //  if ( focusObj == null ) focusObj = obj.q5[0];
      					    bErrorFlag=true;
      					}else{
      						  if (checkbox_other('q5','其它') == ''){      	  	  
      						  	  cError=cError+" 生活習慣 其它 未填寫\n";          
      					        if ( focusObj == null ) focusObj = obj.q5_other;
      					        bErrorFlag=true;      	  	  
      						  }
      					}  
      <?php } ?>    
      if (bErrorFlag){
          alert(cError);
          if ( focusObj != null ) focusObj.focus();
          return false;
      }else{
          return true;
      }
}
</script>