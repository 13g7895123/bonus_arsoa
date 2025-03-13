<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

        <div class="section">
          <div class="section-item">
            <div class="container">
              <div class="mt50 mb60">
                <div class="rounded-logo rounded-logo-md mb90 wow fadeInUp">
                  
                  <div class="logo"><img src="<?=base_url()?>public/images/logo.png" alt="<?=FC_Web?>"></div>
                </div>

                <h1 class="h1-md mb20 col-md-8 mx-auto text-justify wow fadeInUp" data-wow-delay=".2s" style="text-align-last: justify;"><a href="tel:<?=FC_service_free_tel?>" class="phone-link">免付費會員服務電話：<?=FC_service_free_tel?></a><br>免付費健康諮詢專線：0809-086-555<br>
免付費化粧品諮詢專線：0809-091-677</h1>
                <h2 class="fs42 wow fadeInUp" data-wow-delay=".4s"><a href="mailto:<?=FC_CorpEmail?>" class="text-black text-underline"><?=FC_CorpEmail?></a></h2>
                <h3 class="fs30 text-grey mt90 wow fadeInUp" data-wow-delay=".6s"><?=FC_Address?></h3>
              </div>

            </div>
          </div>
        </div>

        <div class="container-fluid">
          <div class="image mask-skew wow fadeIn" data-wow-offset="150" data-wow-duration="0.2s" data-wow-delay=".3s">
            <div class="mask wow slideInLeft" data-wow-offset="150" data-wow-duration="1.2s" data-wow-delay=".3s"><div class="inside"></div></div>
            <img src="<?=base_url()?>public/images/pic161.jpg" alt="" class="img-fluid" />
          </div>
        </div>

        <div class="section">
          <div class="section-item">
            <div class="container wow fadeInUp" data-wow-delay=".2s">
              <h3 class="fs36 mb120">聯絡我們</h3>              
              <form name="oForm" class="text-left" method="post" language="javascript" action="<?php echo base_url( 'contact/send' ); ?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <div class="row">
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">姓名</label>
                    <input type="text" class="form-control form-control-custom" name="name" maxlength="20" placeholder="您的姓名" required/>
                  </div>
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">手機號碼</label>
                    <input type="text" class="form-control form-control-custom" name="phone" maxlength="15" onKeyUp="value=value.replace(/[^0123456789]/g,'')" placeholder="格式為09XXXXXXXX" required />
                  </div>
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">Email</label>
                    <input type="email" class="form-control form-control-custom" name="email"  maxlength="100" placeholder="您的電子信箱" required/>
                  </div>
                  <div class="col-sm-12 mb30">
                    <label class="label-custom">主旨</label>
                    <input type="text" class="form-control form-control-custom" name="title" maxlength="100" placeholder="請輸入主旨" required/>
                  </div>
                  <div class="col-sm-12 mb30">
                    <label class="label-custom">內容</label>
                    <textarea rows="9" cols="30" class="form-control form-control-custom" name="memo" placeholder="請輸入內容" required></textarea>
                  </div>
                </div>
                <div class="mt40 text-center"><input type="submit" name="ok" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');"  class="btn btn-link fs18 text-black text-underline"value="送出表單"></div>
              </form>
            </div>
          </div>
        </div>

      </div>
       
      <?=$this->block_service->load_html_footer(); ?>  
</div>