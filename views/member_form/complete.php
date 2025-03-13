<style>
.form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}
</style>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row" id="printArea">             
               <div class="col-md-9 mb130 mt-lg-5" role="main">
                  
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
                  <div class="text-right" id="printbutton">
                  	<div class="row" align=center>
                       <div class="col-md-6">
                         <a href="javascript:void(0);" id="btnPrint" onclick="onprint()" value="print" class="btn btn-outline-danger btn-block"><i class="icon ion-printer"></i>　列印</a>
                       </div>     
                       <div class="col-md-6">
                         <a href="<?=base_url('member_form/pdf/'.$qtype.'/'.$checkcode)?>" target=_blank class="btn btn-outline-danger btn-block"><i class="icon ion-ios-download"></i>　下載PDF</a>              
                       </div>   
                    </div>                      
                  </div> 
			          	
			         </div>			          
               
               <aside role="complementary" class="aside col-xl-3 col-md-3 mb130" id="leftmenu">					
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
//列印功能
function printHtml(html) {
var bodyHtml = document.body.innerHTML;
document.body.innerHTML = html;
window.print();
document.body.innerHTML = bodyHtml;
window.location.reload(); //列印輸出後更新頁面
}
function onprint() {
//去除超連結設置
$('a').each(function(index) {
$(this).replaceWith($(this).html());
});
$( "#leftmenu" ).hide();
$( "#printbutton" ).hide();

var html = $("#printArea").html();
printHtml(html);

}

</script>