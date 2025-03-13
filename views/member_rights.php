<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
           <?=$this->block_service->load_html_header(); ?>

            <div class="section-mini pt-0">

          <div class="section-item text-left">
			  
          </div>


          <div class="section-item text-left">
            <div class="container">
		
              <div class="row">
                <div class="col-md-9 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>權益規範</strong></h1>
				  <p>(註：您必須安裝Adobe Reader 5.0版以上，才可以閱讀此區)</p>
                  <div class="news-info mb30">
                    
                  </div>
					<!--手機版時讓它是直接開pdf-->
				  <div class="mb65 d-md-none">
					<a href="<?=base_url('public/rights/br01.pdf')?>" class="btn btn-outline-secondary btn-block">晉升條件及福利</a>
					<a href="<?=base_url('public/rights/br02.pdf')?>" class="btn btn-outline-secondary btn-block">事業制度補充說明</a>
					<a href="<?=base_url('public/rights/br03.pdf')?>" class="btn btn-outline-secondary btn-block">安露莎事業特色</a>
					<a href="<?=base_url('public/rights/br04.pdf')?>" class="btn btn-outline-secondary btn-block">品質保證和退、換貨處理規則</a>
					<a href="<?=base_url('public/rights/br05.pdf')?>" class="btn btn-outline-secondary btn-block">多層次傳銷管理法</a>
					</div>
					
				  <!--桌機版時讓它是tab且embed pdf-->
                  <div class="mb65 d-none d-md-block">
					<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">晉升條件及福利</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">事業制度補充說明</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu2">安露莎事業特色</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu3">品質保證和退、換貨處理規則</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu4">多層次傳銷管理法</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane container active" id="home">
	  <div class="embed-responsive embed-responsive-16by9">
    <object class="embed-responsive-item" data="<?=base_url('public/rights/br01.pdf')?>" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="<?=base_url('public/rights/br01.pdf')?>">here</a>.</p>
    </object>
    </div>
	</div>
  <div class="tab-pane container fade" id="menu1">
    <div class="embed-responsive embed-responsive-16by9">
    <object class="embed-responsive-item" data="<?=base_url('public/rights/br02.pdf')?>" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="<?=base_url('public/rights/br02.pdf')?>">here</a>.</p>
    </object>
    </div>
  </div>
  <div class="tab-pane container fade" id="menu2">
    <div class="embed-responsive embed-responsive-16by9">
    <object class="embed-responsive-item" data="<?=base_url('public/rights/br03.pdf')?>" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="<?=base_url('public/rights/br03pdf')?>">here</a>.</p>
    </object>
    </div> 
  </div>
  <div class="tab-pane container fade" id="menu3">
    <div class="embed-responsive embed-responsive-16by9">
    <object class="embed-responsive-item" data="<?=base_url('public/rights/br04.pdf')?>" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="<?=base_url('public/rights/br04.pdf')?>">here</a>.</p>
    </object>
    </div>
  </div>
  <div class="tab-pane container fade" id="menu4">
    <div class="embed-responsive embed-responsive-16by9">
    <object class="embed-responsive-item" data="<?=base_url('public/rights/br05.pdf')?>" type="application/pdf" internalinstanceid="9" title="">
        <p>Your browser isn't supporting embedded pdf files. You can download the file
            <a href="<?=base_url('public/rights/br05.pdf')?>">here</a>.</p>
    </object>
    </div>
  </div>
</div>

                  </div>
                  <hr class="mt-0 mb70">
              </div>              
                 <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">                  
				         <?=$this->block_service->member_right_menu('rights'); ?>				   
				         <br><br>
                 <?=$this->block_service->member_right_prdclass(); ?>				  	  
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>