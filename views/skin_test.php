<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>
        <div class="section-mini">

          <div class="section-item text-left">			  
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5" role="main">
                  <h1 class="h2-3d font-libre"><strong>肌膚諮詢</strong></h1>
                  <div class="news-info mb30">
                    此肌膚類別檢測可以測出您的肌膚年齡，以及肌膚所屬的類型，再針對不同肌膚年齡和類型加以診斷以建議調理方式。
                  </div>

                  <form name="oForm" class="text-left" method="post" language="javascript" action="<?php echo base_url( 'skin_test/ans' ); ?>">
							    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <div class="mb-4">
				         	  <div class="container">
					              <div class="card bg-light mb-3">
                          <div class="card-body">
                            <p class="card-text">請輸入您的年齡（限數字）　
                              <input type="text" name="age" id="age" maxlength="3" required onKeyUp="value=value.replace(/[^0123456789]/g,'')">
                            </p>
                          </div>
                        </div>
						  <?php for ($i=1;$i<=15;$i++){ ?>
						            <div class="card mb-3">
                          <div class="card-body">
                            <div class="row">
								                <div class="col-md-1 border-right">Q<?=sprintf("%02d",$i)?></div>
								                <div class="col-md-7"><?=$skin_data['question'.$i]?></div>
								                <div class="col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="a<?=$i?>" id="a<?=$i?>1" value="y" required>
                                    <label class="form-check-label" for="a<?=$i?>1">Yes　</label>
                                  </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="a<?=$i?>" id="a<?=$i?>2" value="n">
                                    <label class="form-check-label" for="a<?=$i?>2">No　</label>
                                  </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="a<?=$i?>" id="a<?=$i?>3" value="o">
                                    <label class="form-check-label" for="a<?=$i?>3">以上皆非</label>
                                  </div>
                              </div>
							               </div>
                          </div>
                        </div>
						  <?php } ?>
						  
				 

                    </div>

                  </div>

                  <hr class="mt-0 mb-4">
				          <input type="submit"  class="btn btn-outline-danger btn-block" name="ok" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');"  value="送出諮詢">
                  </form>
                </div>
                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                 
                 <?=$this->block_service->help_menu('skin_test'); ?>
				  
                </aside>
              </div>
            </div>
          </div>

        </div>
      </div>
      
      <?=$this->block_service->load_html_footer(); ?>      
      
</div>