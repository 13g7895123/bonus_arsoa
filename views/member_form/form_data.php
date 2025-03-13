<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">               
               <div class="col-md-9 mb130 mt-lg-5" role="main">                  
                  <h1 class="h2-3d font-libre"><strong><?=$title?></strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">                    
                        
                        <div class="row">                                	
  												<div class="form-group mx-sm-3 mb-2">
  												  <label for="name" class="sr-only">手機號碼</label>
  												  <input type="text" class="form-control" id="check_mobile" name="check_mobile" placeholder="手機號碼" value="<?php if (isset($check_mobile)){ echo $check_mobile;} ?>" maxlength="10" onKeyUp="value=value.replace(/[^0123456789]/g,'')" required>
  												</div>
  												<input type="button" class="btn btn-primary mb-2" onclick="check_mobile_form('<?=$qtype?>','S');" style="height: 46px;" value="下一步">    											  
  												<span id="check_mobile_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
                        </div>
                        <form name="oForm" id="oForm"  method="post" action="<?=base_url('member_form/data_save')?>" onSubmit="return Form_data_check(this);">
                        <div class="row" id="form_personal" style="margin-top: 30px;">                           
                        </div>            
                        <div id="form_question">					        	
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
function check_mobile_form(qtype,stype)
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
                    data:{
	                        "check_mobile":$("#check_mobile").val(),
	                        "stype" : stype,
	                        "ok_message" : '<?=$ok_message?>'
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

function Form_data_check(obj)
{ 
	    var bErrorFlag='N';
      var focusObj;
      
      $("#personal_div").css('display','none'); 
      $("#q1_div").css('display','none'); 
      $("#q3_div").css('display','none'); 
	    
      if ($("#mobile").val() != $("#mobile_old").val()){
      	  $.ajax({
               url: base_url+"member_form/check_mobile/edit_mobile",
               type: "POST",
               dataType: "json",
               data:{"check_mobile":$("#mobile").val()
               },
               success: function(data){                    
                   if (data.status){                            
                       $("#personal_div").css('display','block'); 
                       $("#personal_errmsg").html(data.errmsg);                      
                       $("#mobile").focus();
                       bErrorFlag = 'Y';
                   }    
               },
               error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.responseText);
               }
          });      	
      }
      
      console.log(bErrorFlag);
      if (bErrorFlag == 'Y'){          
          return false;  
      }else{
      	  return true;        	  
      }
}
<?php if (isset($check_mobile) && $check_mobile > ''){ ?>
	check_mobile_form('data','E');	
<?php } ?>	
</script>