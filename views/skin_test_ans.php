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

                  <div class="mb-4">
					  <div class="container">
					    <div class="card bg-light mb-3">
                          <div class="card-body">
                            <div class="row">
								<div class="col-md-4"><h3 class="mb-0">肌膚諮詢結果</h3></div>
								<div class="col-md-4"><p class="font-weight-bold mb-0">您的肌膚年齡為　<?=$skinAge?></p></div>
								<div class="col-md-4"><p class="font-weight-bold mb-0">類型是　<?=$skin_ans['stype']?></p></div>
							  </div>
                          </div>
                        </div>
						  
						<div class="progress-list mt50">
                <div class="progress-item wow fadeInRight" data-wow-delay=".2s">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="progress-item-num font-libre">1.</div>
                    </div>
                    <div class="col-sm-9">
                      <div class="progress-item-title">像這樣的肌膚問題有…</div>
                      <div class="fs18 text-grey"><?=str_replace("\n","<br>",$skin_ans['question'])?></div>
                    </div>
                  </div>
                </div>

                <div class="progress-item wow fadeInRight" data-wow-delay=".2s">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="progress-item-num font-libre">2.</div>
                    </div>
                    <div class="col-sm-9">
                      <div class="progress-item-title">您還要注意…</div>
                      <div class="fs18 text-grey"><?=str_replace("\n","<br>",$skin_ans['attention'])?></div>
                    </div>
                  </div>
                </div>

                <div class="progress-item wow fadeInRight" data-wow-delay=".2s">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="progress-item-num font-libre">3.</div>
                    </div>
                    <div class="col-sm-9">
                      <div class="progress-item-title">建議保養方式</div>
                      <div class="fs18 text-grey"><?=str_replace("\n","<br>",$skin_ans['keep'])?></div>
                    </div>
                  </div>
                </div>
                <?php if (isset($piddata) && $piddata){ ?>
                          <div class="progress-item wow fadeInRight" data-wow-delay=".2s">
                            <div class="row">
                              <div class="col-sm-3">
                                <div class="progress-item-num font-libre">4.</div>
                              </div>
                              <div class="col-sm-9">
                                <div class="progress-item-title">建議使用（特別選出適合您肌膚的系列保養品）</div>
                                <div class="fs18">
						                     <?php foreach ($piddata as $prdnum => $item){ 
                                           $sUrl = "";
                                           if ($item["is_view"] == 1){   //為真才可以點明細頁
                                               $sUrl = base_url('product/'.$item['p_no']);
                                           }
                                           ?>
                                           <div class="article-author mb65 border-top-0">
                                             <div class="row align-items-end">
					                                     <div class="media-body col-md-5 col-sm-12">
                                                 <h4 class="article-author-name mb-5"><a href="<?=$sUrl?>"><?=$item['p_name']?></a></h4>
                                               </div>
                                               <div class="col-md-7 col-sm-12 text-center">
                                                 <div><a href="<?=$sUrl?>"><img src="<?=base_url()?><?=$this->block_service->prd_img($item['p_no'])?>" alt="<?=$item['p_name']?>" class="img-fluid"></a></div>
                                               </div>
                                             </div>
                                           </div>
                                  
						                     <?php } ?>
						                   </div>
                              </div>
                            </div>
                          </div>
                <?php } ?>
                      </div>

                    </div>

                  </div>

                  <hr class="mt-0 mb-4">
				          	<a href="<?=base_url('skin_test')?>" class="btn btn-outline-danger btn-block">返回肌膚諮詢</a>

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