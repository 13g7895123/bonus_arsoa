<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
        
        <div class="section-mini pt-0">

          <div class="section-item text-left d-none d-sm-block">           
          </div>

          <div class="section-item text-left">
			      <div class="container">
				
              <div class="row">
                <div class="col-md-12" role="main">
                  <h1 class="h2-3d font-libre"><strong>紅利兌換專區</strong></h1>
					<hr class="mt-0 mb-3">
				  </div>
				 </div>				 
				 <?php $this->block_service->load_reward_cart($mp); ?>				 
			  </div>
			  <div class="container">
                <div class="slide-body">
					<div class="row">
						<div class="col-md-6">
						<!--<h3>熱門兌換商品：</h3>-->
						</div>
						<div class="col-md-6 text-center text-md-right">
			<select name="prdtype" id="prdtype" class="orderby hasCustomSelect border" aria-label="Shop order" style="-webkit-appearance: menulist-button; width: 198px; opacity: 1; height: 29px; font-size: 14px;">					
        <?php
          // 移除指定項目
          $removeItem = array('health', 'clean');
          foreach ($wp1 as $key => $item){
            if (in_array($item['wp1_en_name'], $removeItem)){
              unset($wp1[$key]);
            }
          }
        ?>
					<?php foreach ($wp1 as $key => $item){ ?>
					         <option value="<?=$item['wp1_en_name']?>"><?=$item['wp1_na']?></option>
					<?php } ?>
			</select>
			
			<select name="mp" id="mp" class="orderby hasCustomSelect border" aria-label="Shop order" style="-webkit-appearance: menulist-button; width: 198px; opacity: 1; height: 29px; font-size: 14px;">
					<option value="" selected="selected">依點數範圍篩選：</option>
					<option value="1-999">1 - 999 點</option>
					<option value="1000-1999">1000 - 1999 點</option>
					<option value="2000-2999">2000 - 2999 點</option>
					<option value="3000-3999">3000 - 3999 點</option>
					<option value="4000">4000 點以上</option>
			</select>
							
					  </div>
					</div>
                  <div class="row mb130" id="reward_prdlist">
                        
                          
                    </div>
                    <div class="col-12 text-center my-5">					
                     <br>
                     <br>
					     </div>					
                </div>
              </div>
          </div>

        </div>


      </div>
      <?=$this->block_service->load_html_footer(); ?>            
</div>

<script>
$( "#mp,#prdtype" ).change(function() {
  reward_change();
});

function reward_change()
{
   console.log($( "#prdtype" ).val());
      $.ajax({
                url: base_url + "reward/prdlist",
                type: "POST",
                dataType: "json",
                data:{"prdtype":$( "#prdtype" ).val(),
                      "mp":$( "#mp" ).val(),
                      "csrf_name": getCookie("csrf_cookie_name"),
                      "csrf_test_name": getCookie("csrf_cookie_name")
                },
                success: function(data){
                    if(data.status){      
                         $('#reward_prdlist').html( data.html );
                    }else{
                          $('#reward_prdlist').html( data.errmsg );
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            }); 
}

</script>
<?php 
$GLOBALS['injava'] = "<script>window.onload = function() {reward_change();};</script>";
?>