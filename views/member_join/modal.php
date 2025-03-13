	<!-- Modal -->
<div class="modal fade" id="join_product" tabindex="-1" role="dialog" aria-labelledby="join_product" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="p_name"></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
			    <aside role="complementary" class="aside col-xl-12 col-md-12">
              <div class="mb65 text-center">
                   <img src="" id="p_imgsrc" class="img-fluid mb20" onerror="this.src='<?=base_url('public/images/default_arsoa.png')?>';">
              </div>
          </aside>
                <div class="col-md-12 mb130" role="main">
									<h1 class="text-right"><span class="text-danger" id="p_price"></span><span id="p_unit">元</span></h1>
									<hr class="mt-0 mb40">
              		<div class="container">
              		  <div class="slide-body">
              		    <div class="row" id="p_desc"></div>
              		  </div>
              		</div>
                </div>                
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>