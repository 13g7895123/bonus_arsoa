<div class="footer">
		    <div class="footer-flash-about home-flash-dark">
          <div class="container">
            <br><br><!--Tell us more about what you want to accomplish with your organisation. We help you think of possible solutions in an ever-changing digital world.-->
            <div class="mt-4"><a href="mailto:<?=FC_CorpEmail?>" class="underline"><strong><?=FC_CorpEmail?></strong></a></div>
          </div>
        </div>

        <div class="home-flash-dark pt-0 pb-0"><div class="container"><hr class="mt-0 mb-0"></div></div>
        
        <div class="footer-flash home-flash-dark">
          <div class="container">
            <div class="footer-content-flash">
              <div class="row">
                <div class="col-md-4 col-6 mb-5">
                  <h5>總公司</h5>
                  <div class="contact-item"><?=FC_Address1?><?=FC_Address2?><br /> <?=FC_Address3?></div>
                  <div class="contact-item"><a href="mailto:<?=FC_CorpEmail?>"><?=FC_CorpEmail?></a></div>
                  <div class="contact-item"><a href="tel:<?=FC_service_tel?>" class="phone-link"><?=FC_service_tel?></a></div>
                </div>

                <div class="col-md-3 col-6 mb-5">
                  <h5>help</h5>
                  <ul class="footer-nav">
					          <li><a href="<?=base_url('skin_test')?>">肌膚諮詢</a></li>
					          <li><a href="<?=base_url('help')?>">安露莎問與答</a></li>
                    <li><a href="<?=base_url('copyright')?>">版權說明</a></li>
                    <li><a href="<?=base_url('privacy_policy')?>">隱私權聲明</a></li>
                    <li><a href="<?=base_url('returns')?>">購物與退換貨</a></li>
                  </ul>
                </div>

                <div class="col-md-2 col-6 mb-5">
                  <h5>quick links</h5>
                  <ul class="footer-nav">
                    <li><a href="<?=base_url()?>">Home</a></li>
                    <li><a href="<?=base_url('about')?>">認識安露莎</a></li>                    
                    <li><a href="<?=base_url('category/skin')?>">產品資訊</a></li>
					          <li><a href="<?=base_url('beauty')?>">美麗分享</a></li>
					          <li><a href="<?=base_url('member')?>">會員專區</a></li>
                  </ul>
                </div>

                <div class="col-md-3 col-6 mb-5">
                  <ul class="social social-rounded">
                    <?php $this->block_service->load_share();?>
                  </ul>
                </div>
              </div>
            </div>

            <div class="site-info">
              <div class="row">
                <div class="col-6">
                  <div class="copyright text-left">&copy; <?=date('Y')?> <strong>Arsoa</strong>. All Rights Reserved.</div>
                </div>
                <div class="col-6">
                  <!--<div class="text-right">Designed by <strong>Mdesign.</strong></div>-->
                </div>
              </div>
            </div>
          </div>
        </div>
</div>