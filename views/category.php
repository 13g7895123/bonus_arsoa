<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

         <div class="section-mini">

          <div class="section-item text-left"></div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-10 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong><?=$brand_title?></strong></h1>
                  <?php if ($prdtype == 'hair'){ ?>
                    <div class="news-info mb30 d-none d-sm-block">
                    <div class="row mb65">
						<div class="col-md-8 col-sm-12">
                        <h3 class="mb-5 text-secondary font-weight-normal" style="font-size: 2.62rem;">清潔、滋潤、維持<br>來自自然の能量</h3>
                      </div>
                      <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair01.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">良質水</h4>
							<h5>擁有理想的礦物質比例，親膚性佳的優質好水。</h5>
							<hr>
							<p>添加於安露莎洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素、安露莎絲沐美髮噴霧等產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair02.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">植物性溫泉水(蘑薾水)</h4>
							<h5>含有礦物質與保濕成分，觸感溫潤的植物性溫泉水。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐護髮洗髮精、安露莎絲沐護髮素產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair03.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">白鶴靈芝萃取精華</h4>
							<h5>安露莎獨家配方，維持頭皮的健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素等產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair04.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">海蓬子萃取精華</h4>
							<h5>富含礦物質，維持頭皮健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素等產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair05.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">牡丹萃取精華</h4>
							<h5>萃取自牡丹根皮，維持頭皮健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐洗髮精、安露莎絲沐護髮洗髮精產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair06.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">白芒花-δ-內酯</h4>
							<h5>利用吹風機的熱度，使髮絲表面滑順。</h5>
							<hr>
							<p>作為毛髮保養成分，添加於安露莎絲沐潤絲精、安露莎絲沐護髮護髮霜、安露莎絲沐美髮精華油等產品中。</p>
						  </div>
                      </div>
						<div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair07.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">葵花籽油</h4>
							<h5>萃取自向日葵花籽，輕盈的使用感，維持髮絲滋潤。</h5>
							<hr>
							<p>作為毛髮保養成分，添加於安露莎絲沐美髮精華油等產品中。</p>
						  </div>
                      </div>
					  
					  </div>
                  </div>
					
				  <div class="d-sm-none mb65">
					      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
							  <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                              <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
							  <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
							  <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
                              <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
                            </ol>
                            <div class="carousel-inner">
                              <div class="carousel-item active px-3">
                                <div class="col-md-8 col-sm-12">
                        <h3 class="mb-5 text-secondary font-weight-normal" style="font-size: 2.62rem;">清潔、滋潤、維持<br>來自自然の能量</h3>
                      </div>
                              </div>
                              <div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair01.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">良質水</h4>
							<h5>擁有理想的礦物質比例，親膚性佳的優質好水。</h5>
							<hr>
							<p>添加於安露莎洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素、安露莎絲沐美髮噴霧等產品中。</p>
						  </div>
                      </div>
                              </div>
                              <div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair02.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">植物性溫泉水(蘑薾水)</h4>
							<h5>含有礦物質與保濕成分，觸感溫潤的植物性溫泉水。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐護髮洗髮精、安露莎絲沐護髮素產品中。</p>
						  </div>
                      </div>
                              </div>
								<div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair03.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">白鶴靈芝萃取精華</h4>
							<h5>安露莎獨家配方，維持頭皮的健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素等產品中。</p>
						  </div>
                      </div>
                              </div>
								<div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair04.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">海蓬子萃取精華</h4>
							<h5>富含礦物質，維持頭皮健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎洗髮精、安露莎絲沐護髮洗髮精、安露莎絲沐潤絲精、安露莎絲沐護髮素等產品中。</p>
						  </div>
                      </div>
                              </div>
								<div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair05.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">牡丹萃取精華</h4>
							<h5>萃取自牡丹根皮，維持頭皮健康。</h5>
							<hr>
							<p>作為保濕成分，添加於安露莎絲沐洗髮精、安露莎絲沐護髮洗髮精產品中。</p>
						  </div>
                      </div>
                              </div>
								<div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair06.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">白芒花-δ-內酯</h4>
							<h5>利用吹風機的熱度，使髮絲表面滑順。</h5>
							<hr>
							<p>作為毛髮保養成分，添加於安露莎絲沐潤絲精、安露莎絲沐護髮護髮霜、安露莎絲沐美髮精華油等產品中。</p>
						  </div>
                      </div>
                              </div>
								<div class="carousel-item px-3">
                                <div class="col-md-4 col-sm-12 mb65">
                        <div><img src="<?=base_url('public/images/hair07.jpg')?>" class="img-fluid">
							<h4 class="text-center mt-3">葵花籽油</h4>
							<h5>萃取自向日葵花籽，輕盈的使用感，維持髮絲滋潤。</h5>
							<hr>
							<p>作為毛髮保養成分，添加於安露莎絲沐美髮精華油等產品中。</p>
						  </div>
                      </div>
                              </div>
                            </div>
                          </div>
						</div>

                  <?php }else{ ?>   
                         <div class="news-info mb30"></div>
                  <?php } ?>  
                  <div class="article-content article-news mb65">
                    <p class="lead"><?=$title1?></p>
                    <p><?=$title2?></p>
                      
                    <?php                     
                          $prdnum = 0;
                          foreach ($list_data as $key => $item)
                          {
                                   $prdnum++;
                                   ?>
                                   <div class="article-author mb65 border-top-0">
                                     <div class="row justify-content-center"> 
                                     <?=$this->block_service->prdlist($prdnum,$item); ?>
                                     </div>
                                   </div><?php
                          } ?>
                   </div>

                  <div class="row mb30">
                    <div class="col-sm-6 mb30">                  
                    </div>
                    <div class="col-sm-6 mb30 text-right-sm">
                      <ul class="social social-rounded social-follow">
                        <li class="social-title">分享至：</li>
                        <?php $this->block_service->share($share_url,$brand_title,$prdtype); ?>
                      </ul>
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
