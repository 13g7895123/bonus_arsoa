<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">               
               <div class="col-md-9 mb130 mt-lg-5" role="main">                  
                  <h1 class="h2-3d font-libre"><strong><?=$data['p_name']?></strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">                    
                       <form id="oForm"> 
                        <div class="row">                                	
  												<div class="form-group mx-sm-3 mb-2" style="width:160px">
  												  <label for="name" class="sr-only">查詢姓名或編號</label>
  												  <input type="text" class="form-control" id="Search" name="Search" placeholder="查詢會員編號" value="<?php if (isset($Search)){ echo $Search;} ?>" maxlength="10" onKeyUp="value=value.replace(/[^0123456789]/g,'')" >
  												</div>
  												<?php if ($data['line_push'] == 'Q'){ ?>
  																	<div class="form-group mx-sm-3 mb-2">  											 						   
                                         <select name="q_num" id="q_num" class="form-control">
                                         	  <?php if (isset($data['set_data'])){ 
                                         	  	        $n = 0;
                                         	  	        foreach ($data['set_data'] as $key => $item){
                                         	  	        	       $n++;
                                         	  	        	       echo '<option value="'.$n.'">'.trim($item['q_title']).'</option>';
                                         	  	        }
                                         	        }	
                                         	  ?>
                                         </select> 
  											  					</div>
  											  <?php }else{ ?>
  											    				<input type="hidden" name="q_num" id="q_num"  value="1">							  
  											  <?php } ?>
  												<input type="submit" id="contact-submit" style="height: 46px;" class="btn btn-primary mb-2" value="搜尋">
  												
  												<span id="check_mobile_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
                        </div>
                        
                        <div class="row" id="form_msg" style="margin-top: 10px;margin-left: 20px;color:red;font-size:18px">
                        </div>            
                       
			          	   </form>  
			 

                    </div>
                  </div>					        					        
			         </div>			          
               
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

$('#oForm').submit(function(event) {        
        event.preventDefault(); 
        if ($("#Search").val() > '') {
        	    $('#form_msg').html('');
              var post_object = {
                 "Search"  : $("#Search").val(),
                 "q_num" : $("#q_num").val()
              };
              post_object[csrf_token_name] = getCookie(csrf_cookie_name);
              
              $.ajax({
                     url: base_url+"question/product_check/<?=$data['checkcode']?>",
                     type:"post",
                     data: post_object,
			            dataType:"json",
			            success: function(data){			          
                            if (data.gourl > ''){        
                            	  window.location.href = data.gourl;
                            }else{                                
                                if (data.errtype == 'clear'){
                                    $("#Search").val('');
                                }
                                $('#form_msg').html(data.errmsg);
                                $('#Search').focus();
                            }
                     },
                     error: function (xhr, ajaxOptions, thrownError) {
                         console.log(xhr.responseText);
                   }
              
              });	            
        } else {
            $('#Search').focus();
            $('#form_msg').html('會員編號未填寫');            
            // 處理錯誤
        }
});
    	
</script>	