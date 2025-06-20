<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>     
      <div class="section-mini">
     
        <div class="section-item text-left">          
			      <div class="container">			  
			      </div>
			      <?=$this->block_service->load_order_step(3); ?> 			  			  
        </div>
          <div class="section-item text-left">
            <div class="container">    
              <div class="row" id="printArea">
                <div class="col-md-9 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong><?=$order_title?></strong></h1>
                  <div class="news-info mb30"></div>
				
				          <div class="mb65">
                      <?=$order_detail?>
                   <div class="text-right" id="printbutton">
                      <div class="btn-group" role="group" aria-label="Basic example"> 
                        <a href="javascript:void(0);" id="btnPrint" onclick="onprint()" value="print" class="btn btn-outline-secondary"><i class="icon ion-printer"></i>　訂單列印</a>
						          </div>
                    </div>            
                  </div>

                  <hr class="mt-0 mb70">
                  <div class="row">             
                    <div class="col-md-12">
                  		<p><?=$cart_remark?></p>
                  	</div>                                    
                  </div> 
                </div>
              
                <aside id="leftmenu" role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				        <div class="mb75">
                  <?=$this->block_service->member_right_menu(); ?>  
                </div>
				  
                </aside>
              
              </div>
            </div>
          </div>
        </div>
      </div>

      <?=$this->block_service->load_html_footer(); ?>  
                    
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  <?php if ($homeDelivery): ?>
  	// 使用 SweetAlert 顯示選項對話框
    Swal.fire({
      title: '系統提示', 
      text: '請選擇是否需要填寫信用卡資料',
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: '開啟表單',
      cancelButtonText: '我之前填過了',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // 點擊開啟表單 - 在新分頁開啟宅配表單
        window.open('<?=$homeDelivery_url?>', '_blank');
      }
      // 點擊我之前填過了或關閉 - 關閉 alert
    });
  <?php endif; ?>

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