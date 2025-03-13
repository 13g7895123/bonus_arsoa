<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">               
               <div class="col-md-9 mb130 mt-lg-5" role="main">
                  <form name="oForm" id="oForm"  method="post" action="<?=base_url('member_form/form_save/'.$qtype)?>">
                  <input type="hidden" name="edit" value="Y" >    
                  <h1 class="h2-3d font-libre"><strong><?=$form_set[$qtype]?></strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">                                           
                        <div class="row" id="form_personal" >
                        	  <?=$personal?>
                        </div>                      
                    </div>
                  </div>
					        
					        <div id="form_question">
					        	  <?=$question?>
                  </div>   
                  <div class="row" align=center>
                     <div class="col-md-6">
                       <input type="button" id="save" class="btn btn-outline-danger btn-block" value="確認送出">                  
                     </div>     
                     <div class="col-md-6">
                       <input type="button" id="edit" class="btn btn-outline-secondary btn-block" value="回上頁修改">                  
                     </div>   
                  </div>     
			          	</form>
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
function check_name_form(qtype)
{
      $("#check_name_msg").html('');
      if ($("#check_name").val() == ''){
     	    $("#check_name_msg").html('真實姓名未填寫！'); 
      }else{
          $.ajax({
                url: base_url+"member_form/check_name/"+qtype,
                type: "POST",
                dataType: "json",
                data:{"check_name":$("#check_name").val()
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

$(document).ready(function() { 
   $('#save').click(function(){
      $('#oForm').attr('action', '<?=base_url('member_form/form_save/'.$qtype)?>');
      document.oForm.submit();
   });
   
   
   $('#edit').click(function(){
      $('#oForm').attr('action', '<?=base_url('member_form/question/'.$qtype)?>');
      document.oForm.submit();
   });
   
});
</script>