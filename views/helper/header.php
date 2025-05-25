<?php
if ($web_page == 'index'){
    //header-fixed
  ?>
  <header id="header" class="header header-fixed" style="background: #ffffff00;">
  <?php
}else{  
  ?>
  <header id="header" class="header">
  <?php
}
?>
<div class="container-fluid clearfix">
  <div class="brand">
    <a href="<?=base_url()?>" title="<?=FC_Web?>">
      <div class="brand-name"><img src="<?=base_url()?>public/images/logo.png" style="max-width: 125px;" alt="<?=FC_Web?>"></div>
    </a>
  </div>
  <button class="nav-toggle-btn a-nav-toggle">
              <span class="nav-toggle-title">Menu</span>
              <span class="nav-toggle nav-toggle-sm">
                <span class="stick stick-1"></span>
                <span class="stick stick-2"></span>
                <span class="stick stick-3"></span>
              </span>
            </button>
</div>
          
<div class="hide-menu a-nav-toggle"></div>
  <div class="menu">
    <div class="menu-lang">
          <?php
          $member_session = $this->session->userdata('member_session');                  
          if (isset($member_session['c_no']) && $member_session['c_no'] > '') {                 
              ?>
              <div class="row mb-3">
		           <div class="col-lg-8 px-0 text-center text-md-left py-2 pl-3">
			         <h5><?=$member_session['c_name']?> 您好！</h5>
	                <a href="<?=base_url('member/logout')?>" style="color: #e4024b;">登出</a> ｜ 
	                <a href="<?=base_url('member/changepwd')?>" style="color: #e4024b;">變更密碼</a> ｜ 
	                <a href="<?=base_url('order/cart')?>" style="color: #e4024b;">購物車
	                <span class="badge badge-danger badge-pill" id="show_prd_num1"><?=$this->front_order_model->check_cart_num()?></span></a>
	              </div>
		           <div class="col-lg-4 justify-content-center py-2"></div>
			       </div>
	     <?php }else{ ?>
	             <div class="row mb-3"> 
	               <div class="col-lg-4 justify-content-center py-2"></div>
			         </div>
	     <?php } ?> 
  </div>
            
<div class="menu-main" id="accordion">
  <?php if ($prd_menu){ ?>
  <ul class="border-danger border-bottom mb-2">
    <?php foreach ($prd_menu as $key => $item){ 
    	    $menu_name = $item['p_name'];
    	    if ($item['menu_name'] > ''){
    	    	  $menu_name = $item['menu_name'];
    	    }
    	    ?>
          <li class="mb-0"><a href="<?=base_url('product/'.$item['p_no'])?>" class="animsition-link" data-animsition-out-class="fade-out" data-text="<?=$menu_name?>"><?=$menu_name?></a></li>
    <?php } ?>
  </ul>
  <?php } ?>
  <ul>
   <?php if (1==2){ ?>
    <li class="active"><a href="<?=base_url()?>" class="animsition-link" data-animsition-out-class="fade-out" data-text="Home">Home</a></li>
	<?php } ?>	
    <li><a data-text="產品資訊" data-toggle="collapse" href="#menuStudio" role="button" aria-expanded="false" aria-controls="menuStudio">產品資訊</a>
      <div class="collapse" id="menuStudio" data-parent="#accordion">
        <ul>
		    <?php if (1==2){ ?>
		    <li><a href="<?=base_url()?>wake" class="animsition-link" data-animsition-out-class="fade-out" data-text="喚醒肌膚的力量">喚醒肌膚的力量</a></li>
		    <?php } ?>
          <li><a href="<?=base_url()?>category/skin" class="animsition-link" data-animsition-out-class="fade-out" data-text="肌膚保養系列">肌膚保養系列</a></li>
          <?php if ($this->session->userdata('member_session')['c_no'] === '000000'): ?>
            <li><a href="<?=base_url()?>member/product/5" class="animsition-link" data-animsition-out-class="fade-out" data-text="肌能調理宅配專案">肌能調理宅配專案</a></li>
          <?php endif; ?>
          <li><a href="<?=base_url()?>category/makeup" class="animsition-link" data-animsition-out-class="fade-out" data-text="彩粧系列">彩粧系列</a></li>
          <li><a href="<?=base_url()?>category/hair_body" class="animsition-link" data-animsition-out-class="fade-out" data-text="美髮、美體系列">美髮、美體系列</a></li>
          <li><a href="<?=base_url()?>category/health" class="animsition-link" data-animsition-out-class="fade-out" data-text="保健食品系列">保健食品系列</a></li>
          <?php if ($this->session->userdata('member_session')['c_no'] === '000000'): ?>
            <li><a href="<?=base_url()?>member/product/4" class="animsition-link" data-animsition-out-class="fade-out" data-text="健康宅配專案">健康宅配專案</a></li>
          <?php endif; ?>
          <li><a href="<?=base_url()?>category/clean" class="animsition-link" data-animsition-out-class="fade-out" data-text="健康飲用水系列">健康飲用水系列</a></li>                    
          <?php if (isset($member_session['c_no']) && $member_session['c_no'] > '' && $this->session->userdata('member_session')['d_posn'] <= 50) {      ?>
            <li><a href="<?=base_url()?>category/other" class="animsition-link" data-animsition-out-class="fade-out" data-text="輔銷產品">輔銷產品</a></li>          
          <?php } ?>
        </ul>
      </div>
    </li>
		
		<li><a href="<?=base_url()?>beauty" class="animsition-link" data-animsition-out-class="fade-out" data-text="美麗分享">美麗分享</a></li>
		  
		<li><a href="<?=base_url()?>member" class="animsition-link" data-animsition-out-class="fade-out" data-text="會員專區">會員專區</a></li>
		<?php if (isset($member_session['c_no']) && $member_session['c_no'] > '') {      ?>
		          <li><a href="<?=base_url()?>reward" class="animsition-link" data-animsition-out-class="fade-out" data-text="紅利兌換專區">紅利兌換專區</a></li>  
		<?php } ?>  
		<?php 
		if (isset($this->session->userdata('member_session')['d_posn']) && $this->session->userdata('member_session')['d_posn'] < 60 && $this->session->userdata('member_session')['d_posn'] > ''){ ?>      
		          <li><a href="<?=base_url()?>member_admin" class="animsition-link" data-animsition-out-class="fade-out" data-text="組織專區">組織專區</a></li>		  
		<?php } ?>
		<?php if (1==2){ ?>  
		<!--<li><a href="<?=base_url()?>reward" class="animsition-link" data-animsition-out-class="fade-out" data-text="紅利兌換專區">紅利兌換專區</a></li>
		  
		<li><a data-text="情報分享" data-toggle="collapse" href="#menuNews" role="button" aria-expanded="false" aria-controls="menuNews">情報分享</a>
              <div class="collapse" id="menuNews" data-parent="#accordion">
                <ul>
                  <li><a href="<?=base_url()?>news/list1" class="animsition-link" data-animsition-out-class="fade-out" data-text="最新消息">最新消息</a></li>
                  <li><a href="<?=base_url()?>news/list2" class="animsition-link" data-animsition-out-class="fade-out" data-text="媒體介紹">媒體介紹</a></li>
                  <li><a href="<?=base_url()?>news/list3" class="animsition-link" data-animsition-out-class="fade-out" data-text="美麗情報">美麗情報</a></li>
                </ul>
              </div>
            </li>-->
      <?php } ?>
		<li><a href="<?=base_url()?>about" class="animsition-link" data-animsition-out-class="fade-out" data-text="認識安露莎">認識安露莎</a></li>				  
    <li><a href="<?=base_url()?>contact" class="animsition-link" data-animsition-out-class="fade-out" data-text="聯絡我們">聯絡我們</a></li>				
  </ul>
</div>
<div class="menu-footer">
                <ul class="social social-rounded">
                <?php $this->block_service->load_share();?>
                </ul>
   <div class="menu-copyright">&copy; <?=date('Y')?> <strong>Arsoa</strong>. All Rights Reserved.<!--<br /> designed by <strong>Mdesign.</strong>--></div>
</div>
</div>
</header>