<body class="theme-orange" id="main">
 <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header('index'); ?>

        <ul class="social social-rounded social-rounded-fixed social-rounded-dark">
          <?php $this->block_service->load_share();?>
        </ul>

        <div class="establised">establised 1972</div>
        <!--<div class="copyright-fixed">&copy; Arsoa 2020.&nbsp; by Mdesign.</div>-->

        <div class="home-piling a-pagepiling full-height">
          <div class="section pp-scrollable slide slide1 slide-dark">
            <div class="slide-container">                       
              <div class="video-container a-video" data-vimeo-width="640" data-vimeo-height="360" style="display: none;"><iframe src="<?=$mvurl?>" allowfullscreen></iframe></div>
              <div class="slide-bg">
				          <div class="inside" style="background-image: url(<?=base_url()?>public/func/<?=$index_banner['field1']?>);"></div>
				          <div class="container slide-container">
      				     <!--<div class="row">
				        <div class="col-sm-7 d-none d-md-block">
                            <h1 class="slide-title font-libre" style="text-shadow: 2px 2px 5px #999;"><span class="text-primary"><?=$index_banner['title']?></span><br /> <?=$index_banner['field2']?></h1>
                            <div class="slide-body">
                              <h3 class="slide-title-sub d-none d-sm-block"><?=$index_banner['descr']?></h3>
                              <div class="slide-descr d-none d-sm-block"><?=$index_banner['body']?></div>
                            </div>
                          </div>
				        </div>-->
				        </div>
				      </div>
              <div class="slide-video-container slide-container">
                <div class="container">
                  <div class="row slide-content">                    
                  </div>
                  <a href="javascript:;" data-toggle="modal" data-target="#arsoavideos" class="btn-play btn-play-md"><i class="icon ion-ios-play"></i></a>
                </div>
              </div>
            </div>
          </div>          

          <div class="section pp-scrollable slide slide2">
            <div class="slide-container">
              <div class="slide-bg slide-bg-circle">
				  <div class="inside" style="background-image: url(<?=base_url()?>public/images/piling-pic2.png);"></div>
				</div>
              <div class="container">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="solution-num text-texture">50</div>
                    <div class="solution-num-title">Years<br /> Experience</div>
                  </div>
                  <div class="col-lg-6">
                    <h2 class="slide-title font-libre">引領新時代價值觀與生活態度<br />不斷追求觸及心靈的真幸福</h2>

                    <div class="accordion solution-collapse" id="solutions">
                      <div class="solution-collapse-item">
                        <div class="solution-collapse-item-title font-libre" id="headingOne">
                          <a class="" href="" data-toggle="collapse" data-target="#solution1" aria-expanded="true" aria-controls="solution1">
                            從追求「量」到重視「質」
                            <i class="icon-plus"></i>
                          </a>
                        </div>

                        <div id="solution1"  class="collapse show" aria-labelledby="headingOne" data-parent="#solutions">
                          <div class="card-body">
                            從追求「量」到重視「質」、從重視「物質」到追求「心靈」。其實，世人的價值觀已出現極大的變化。身處於這樣的時代裡才終於體會到，唯有真心感到滿足的事物，才能帶來真正的幸福。安露莎率先洞悉到這個時代的變化，並已邁向創造新價值之路。<br>其最大根基在於，實踐與大自然共生的生活型態。<br>因為從企業據點「小淵澤」的大自然中，激發出帶給人類身體超乎想像的能量。
                          </div>
                        </div>
                      </div>
                      <div class="solution-collapse-item">
                        <div class="solution-collapse-item-title font-libre" id="headingTwo">
                          <a class=" collapsed" href="" data-toggle="collapse" data-target="#solution2" aria-expanded="false" aria-controls="solution2">
                            真善美的三健精神概念
                            <i class="icon-plus"></i>
                          </a>
                        </div>
                        <div id="solution2" class="collapse" aria-labelledby="headingTwo" data-parent="#solutions">
                          <div class="card-body">
                            安露莎確信，「心、體、肌」三大健康中，存在著誕生真善美的「三健精神」概念、及置身於大自然中，重新調整平衡的重要性。另外，透過親手栽種農作物，而實際體會到該如何珍惜每天應有的「飲食」態度下，目前已著手研究生機延壽飲食法(Macrobiotic)。
                          </div>
                        </div>
                      </div>
                      <div class="solution-collapse-item">
                        <div class="solution-collapse-item-title font-libre" id="headingThree">
                          <a class=" collapsed" href="" data-toggle="collapse" data-target="#solution3" aria-expanded="false" aria-controls="solution3">
                            與自然調和的生活模式
                            <i class="icon-plus"></i>
                          </a>
                        </div>
                        <div id="solution3" class="collapse" aria-labelledby="headingThree" data-parent="#solutions">
                          <div class="card-body">
                            安露莎的產品就是向大自然學習、實踐與實際感受下所孕育而成。<br>為了與自然融為一體，我們抱持向大自然學習的態度，提倡並加以實踐與自然合而為一的生活方式。在大自然提供的生存環境中，我們感受生命的氣息，心靈也獲得豐富的滋養，並且重視自然環境的維護。
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
			
		  <div class="section pp-scrollable slide slide3">
            <div class="slide-container">
				<div class="slide-bg"><div class="inside"></div></div>
              <div class="container feature">
				  <p class="text-center">
					  <img src="<?=base_url()?>public/images/3step01.png" class="img-fluid">
				  </p>
				  <p class="text-center">
					  <img src="<?=base_url()?>public/images/3step02.png" class="img-fluid">
				  </p>
				  <p class="text-center">
					  <img src="<?=base_url()?>public/images/3step03.png" class="img-fluid">
				  </p>


        <p class="subtitle_noline">肌能調理三步驟，喚醒肌膚的力量<br class="sp">“三大機能、<br class="pc">三大主張。</p>
        
        <ul class="step">
          <li class="step1 fadeup active">
            <div class="photo">
              <span class="fadeinin">清潔</span>
              <img src="<?=base_url()?>public/images/img01.png" class="img-fluid" alt="洗うことから、うつくしく。">
            </div>
            <h3>美麗肌膚，<br class="sp">從清潔開始</h3>
            <p>護膚首重「清潔」，<br>
              為喚醒肌膚原有能力而誕生的「蜜皂」，<br>
              是安露莎的原點。</p>
            <a href="product/00421636" class="btn">觀看產品</a>
          </li>

          <li class="step2 fadeup active">
            <div class="photo">
              <span class="fadeinin">清除</span>
              <img src="<?=base_url()?>public/images/img02.png" class="img-fluid" alt="肌に差がつく、透明感">
            </div>
            <h3>截然不同的透明感。</h3>
            <p>美麗的肌膚，<br>
              必須要有正常的代謝週期，<br>
              安露莎著眼於「清除」的步驟。</p>
            <a href="product/00421652" class="btn">觀看產品</a>
          </li>
        </ul>

        <ul class="step step--line">
          <li class="step3 fadeup active">
            <div class="photo">
              <span class="fadeinin">滋潤</span>
              <img src="<?=base_url()?>public/images/img03.png" class="img-fluid" alt="水のチカラで、潤う素肌へ">
            </div>
            <h3>以水的力量<br class="sp">潤澤肌膚。</h3>
            <p>利用「水」，精心打造的「滋潤」化粧水，<br>
              觸感清爽而能確實保濕。</p>
            <a href="product/00421678" class="btn">觀看產品</a>
          </li>

          <li class="step4 fadeup active">
            <div class="photo">
              <span class="fadeinin">維持</span>
              <img src="<?=base_url()?>public/images/img04.png" class="img-fluid" alt="肌が呼吸する、美しさが活きる。">
            </div>
            <h3>會呼吸的肌膚，<br class="sp">展現活力之美。</h3>
            <p>抹在水分飽滿的肌膚上，<br>
              不只帶來滋潤，還能「維持」<br>
              肌膚機能的精華液。</p>
            <a href="product/00421701" class="btn">觀看產品</a>
          </li>
        </ul>

        <ul class="step step">
          <li class="step5 fadeup active">
            <div class="photo">
              <img src="<?=base_url()?>public/images/img05.png" class="img-fluid" alt="悩みに応えて美しさを際立たす、スペシャルケア。">
            </div>
            <h3>因應肌膚困擾、<br class="sp">打造耀眼美肌，<br>貼近需求的極緻呵護保養。</h3>
            <p>不論如何重視保養，<br>肌膚的狀況與問題，<br>還是會隨著年紀、季節與環境的變化而改變。 </p>
            <a href="category_list/arsoa" class="btn">觀看產品</a>
          </li>
		  <li class="step6 fadeup active">
            <div class="photo">
              <img src="<?=base_url()?>public/images/img06.png" class="img-fluid" alt="十分に保護することが必要な方に。">
            </div>
            <h3>溫和調理肌膚，<br>強化肌膚的防護力。</h3>
            <p>當肌膚防護降低，水份就容易從肌膚底層蒸發。<br>
              季節交替、環境變化、壓力因素也<br>容易引起肌膚問題。<br>
              </p>
            <a href="category_list/amuny" class="btn">觀看產品</a>
          </li>
        </ul>

       </div>
            </div>
          </div>

          <div class="section pp-scrollable slide slide4">
            <div class="slide-container">
				<div class="slide-bg"><div class="inside"></div></div>
              <div class="container">
                <div class="slide-body">
                  <?=$this->block_service->class_main(); ?>  
<br class="my-5"><br class="my-5">				  
                </div>
              </div>
            </div>
          </div>

          

          <!--<div class="section pp-scrollable slide slide6 slide-dark">
            <div class="slide-container">
              <div class="slide-bg">
				  <div class="inside d-none d-lg-block" style="background-image: url(<?=base_url()?>public/images/bg-piling5.jpg);"></div>
				  <div class="inside d-lg-none" style="background-image: url(<?=base_url()?>public/images/bg-piling5m.jpg);"></div>
				</div>
                <div class="container">
                <div class="row justify-content-end">
                  <div class="col-lg-7 col-12">
                    <p class="font-libre font-weight-bold" style="font-size: 1.25rem">為了女性的美麗和健康，繼續勇往直前。現在，美容和健康的意義正在重新審視。永遠成為一個年輕而閃亮的女人。為自己和家人過上健康活潑的生活。此外，所有的心靈，身體和皮膚都是健康的。在永恆不變的「三墾精神」的主題下，真正的美麗誕生了，我們提出產品和生活方式建議。</p>
					  <p>代表取締役社長　滝口 玲子</p>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
          
             <div class="section pp-scrollable slide slide7">
            <div class="slide-container">
              <div class="slide-bg">
				  <div class="inside d-none d-sm-block" style="background-image: url(<?=base_url()?>public/images/bg-piling6.jpg);"></div></div>
              <div class="slide-bg slide-bg-circle">
				  <div class="inside" style="background-image: url(<?=base_url()?>public/images/piling-pic2.png);"></div>
				</div>
              <div class="container">
                <div class="row slide-content mb65">
                  <div class="col-md-6 mb-4">
                    <h2 class="slide-title font-libre h2"><span class="text-primary"><?=FC_Address1?></span> <?=FC_Address2?></h2>
                    <div class="slide-body">
                      <div class="slide-contact-address"><?=FC_Address3?></div>
                      <div class="slide-contact-mail"><a href="mailto:<?=FC_CorpEmail?>" class="underline"><?=FC_CorpEmail?></a></div>
                      <div class="slide-contact-phone"><a href="tel:<?=FC_service_tel?>" class="phone-link"><?=FC_service_tel?></a></div>
                    </div>
                  </div>
				  <div class="col-md-6 text-right align-self-end d-none d-sm-block">
					<a class="btn btn-primary btn-rounded mr-4" href="https://www.google.com.tw/maps/place/106%E5%8F%B0%E5%8C%97%E5%B8%82%E5%A4%A7%E5%AE%89%E5%8D%80%E4%BF%A1%E7%BE%A9%E8%B7%AF%E4%B8%89%E6%AE%B5149%E8%99%9F9/@25.0336308,121.540014,17z/data=!3m1!4b1!4m5!3m4!1s0x3442abd48540e0b1:0x6568a94e88839d31!8m2!3d25.0336308!4d121.5422027?hl=zh-TW" target="_blank">Google Map觀看 <i class="icon ion-ios-arrow-right"></i></a>
					</div>
					<div class="col-md-6 text-center align-self-end d-sm-none">
						<img src="<?=base_url()?>public/images/map_sm.png" class="img-fluid">
					<a class="btn btn-primary btn-rounded mr-4" href="https://www.google.com.tw/maps/place/106%E5%8F%B0%E5%8C%97%E5%B8%82%E5%A4%A7%E5%AE%89%E5%8D%80%E4%BF%A1%E7%BE%A9%E8%B7%AF%E4%B8%89%E6%AE%B5149%E8%99%9F9/@25.0336308,121.540014,17z/data=!3m1!4b1!4m5!3m4!1s0x3442abd48540e0b1:0x6568a94e88839d31!8m2!3d25.0336308!4d121.5422027?hl=zh-TW" target="_blank">Google Map觀看 <i class="icon ion-ios-arrow-right"></i></a>
					</div>
                </div>
				<div class="text-center text-md-left">
                <a class="btn btn-primary btn-rounded mr-md-4" href="<?=base_url()?>contact">聯絡我們 <i class="icon ion-ios-arrow-right"></i></a>
				</div>
              </div>
            </div>
          </div>

        </div>



      </div>

    </div>
    
	<!-- Modal -->
<div class="modal fade" id="arsoavideos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<h5 class="modal-title" id="exampleModalLongTitle">加入安露莎</h5>-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
		  <div class="row">
			  <div class="col-md-6">
			  <a href="public/videos/arsoa01.mp4" data-fancybox>
				  <img src="<?=base_url()?>public/images/video01.jpg" class="img-fluid"><br>木村佳乃-安露莎保養三步驟</a></div>
			  <div class="col-md-6">
				  <a href="public/videos/2019Reborn key visual.mp4" data-fancybox>
				  <img src="<?=base_url()?>public/images/video02.jpg" class="img-fluid"><br>2019Reborn key visual</a>
			  </div>
		  </div>
      </div>
    </div>
  </div>
</div>
	
<!-- 20230825日研修 -->
<!--<script type="text/javascript">
    $(window).on('load', function() {
        $('#japan').modal('show');
    });
</script>-->
	
	<!-- Modal -->
<div class="modal fade" id="japan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<h5 class="modal-title" id="exampleModalLongTitle">加入安露莎</h5>-->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center p-0">
		  <div class="row">
			  <div class="col-md-12">
				  <img src="<?=base_url()?>public/images/官網結帳日異動公告視窗-1.jpg" class="img-fluid">
			  </div>
		  </div>
      </div>
    </div>
  </div>
</div>
