<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        
        <div class="section-mini">			
          <div class="section-item text-center"> 
             <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <h1 class="h2-3d font-libre">
                                        <strong><?=$activity_data['act_title']?></strong>
                                    </h1>
                                    <div class="news mb30 text-center">親愛的 <?=$this->session->userdata('line_display_name')?> 您好，請填寫帶您來的朋友資訊。</div>
                                    
                                    <div class="container">                   
  																		<div class="form-group mx-sm-3 mb-2">
  																		  <label for="name" class="sr-only">會員編號</label>
  																		  <input type="text" class="form-control" style="width:300px;" id="relation_c_no" name="relation_c_no" placeholder="會員編號" value="" maxlength="6" >  																		  
  																		</div>
  																	</div>	
  																<div class="container">                                			
  																	 <div class="form-group mx-sm-3 mb-2">
  																		<input type="submit" class="btn btn-primary mb-2" id="contact-submit" style="height: 44px;" value="送出">
  																		
                        						</div>
                        						<span id="check_relation_c_no_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
                                 </div>
                                 <div class="container" id="check_form">
                                 </div>	
                                 <span id="check_reg_type_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>    
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        
        <?=$this->block_service->load_html_footer(); ?>  
     </div>     
</div>
<script>
$(document).ready(function() { 
  
   $("#contact-submit").click(function(){     
   	    if ($("#relation_c_no").val() == ''){
   	        $("#relation_c_no").focus();
   	        $("#check_relation_c_no_msg").html('會員編號未填寫！');
   	    }else{
            check_data();
        }
   });
   
});

function save() {
    
   	    if ($("#reg_type").val() == ''){
   	        $("#reg_type").focus();
   	        $("#check_reg_type_msg").html('會員關係未選擇！');
   	    }else{
            check_data_save();
        }
}



function getCookie_join(i) {
    var e = document.cookie.match(new RegExp("(^| )" + i + "=([^;]*)(;|$)"));
    return null != e ? unescape(e[2]) : null
}

function check_data(){      
       
         $.ajax({
                url: base_url+"activity/member_check/<?=$charge_check['checkcode']?>",
                type: "POST",
                dataType: "json",
                data:{"relation_c_no" :$("#relation_c_no").val(),
                      "csrf_name": getCookie_join("csrf_cookie_name"),
                      "csrf_test_name": getCookie_join("csrf_cookie_name")       
                },
                success: function(data){                    
                    if (data.success){                    
                        $("#check_relation_c_no_msg").html('');
                        $("#check_form").html(data.html);                    
                    }else{
                    	  $("#check_relation_c_no_msg").html(data.html);
                        $("#check_form").html('');                    
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}


function check_data_save(){      
       
         $.ajax({
                url: base_url+"activity/reg_save/<?=$charge_check['checkcode']?>",
                type: "POST",
                dataType: "json",
                data:{
	                    "relation_c_no" :$("#save_relation_c_no").val(),
	                    "reg_type" :$("#reg_type").val(),
                      "csrf_name": getCookie_join("csrf_cookie_name"),
                      "csrf_test_name": getCookie_join("csrf_cookie_name")       
                },
                success: function(data){                    
                    if (data.success){                    
                        window.location = data.gourl;             
                    }else{
                    	              
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}
</script>