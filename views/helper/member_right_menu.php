<?php
$prd_num = 0;
if (!empty($this->session->userdata('ProductList'))){
  $cartData = explode(',',$this->session->userdata('ProductList'));
  $cartData = array_filter($cartData, function($item){
    return $item !== '';
  }); 
  $prd_num = count($cartData);
}
if ($active > ''){
    ?>
    <h4><strong><a href="<?=base_url('member/main')?>" style="color:#444" title="會員專區">會員專區</a></strong></h4>
    <?php
}
?>
<a href="<?php echo base_url( 'order/cart' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'cart'){ echo ' active'; }?>">檢視購物車　
<?php if ($prd_num == 0){ ?>
<i class="icon ion-ios-cart-outline"></i>
<?php }else{ ?>
<i class="icon ion-ios-cart"></i>  
<?php } ?>
</a>
<a href="<?php echo base_url( 'order/orderlist' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'orderlist'){ echo ' active'; }?>">訂單查詢　　<i class="icon ion-ios-list"></i></a>

<a href="<?php echo base_url( 'member/dm_download' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'dm_download'){ echo ' active'; }?>">型錄下載　　<i class="icon ion-ios-download"></i></a>
<a href="<?php echo base_url( 'member/mdownload' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'mdownload'){ echo ' active'; }?>">表單下載　　<i class="icon ion-ios-download"></i></a>
					  
<?php if (1==2){ ?>
<a href="<?php echo base_url( 'reward' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'reward'){ echo ' active'; }?>">紅利兌換　　<i class="icon ion-ios-barcode"></i></a>
<?php } ?>

<a href="<?php echo base_url( 'member/love' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'love'){ echo ' active'; }?>">ARSOA Ai　<i class="icon ion-ios-heart"></i></a>
<a href="<?php echo base_url( 'member/rights' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'rights'){ echo ' active'; }?>">權益規範　　<i class="icon ion-ios-paper"></i></a>
<?php if ($this->session->userdata('member_session')['d_posn'] >= 60){ ?>         
         <a href="javascript:report_A();" class="btn btn-outline-secondary btn-block<?php if ($active == 'admin'){ echo ' active'; }?>">年度進貨　　<i class="icon ion-ios-analytics"></i></a>        
<?php }else{ ?>
         <a href="<?php echo base_url( 'member_admin' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($active == 'admin'){ echo ' active'; }?>">組織專區　　<i class="icon ion-ios-analytics"></i></a>
<?php } ?>

<a href="javascript:;" class="btn btn-outline-secondary btn-block">表單專區　　<i class="icon ion-ios-list"></i></a>
	<div class="card">
  <div class="card-body">
    <ul class="adminmenu pl-4">    	
    	     		  <li><a href="<?php echo base_url( 'member_form/data' ); ?>">表單個人資料維護 </a></li>
								<li><a href="<?php echo base_url( 'member_form/question/q1' ); ?>">個人體測檢量記錄表 </a></li>
								<li><a href="<?php echo base_url( 'member_form/question/q2' ); ?>">鶴力晶 體驗服務表 </a></li>
								<li><a href="<?php echo base_url( 'member_form/question/q3' ); ?>">肌膚諮詢記錄表</a></li>
		</ul>
  </div>
</div>

<!-- Roy看這兒240119 -->
<a href="javascript:;" class="btn btn-outline-secondary btn-block">問卷專區　　<i class="icon ion-ios-list"></i></a>
<div class="card">
  <div class="card-body">
    <a href="<?php echo base_url( 'question/partners/Y' ); ?>" class="btn btn-outline-secondary btn-block text-left">產品體驗</a>
    <?php
      // if (in_array($this->session->userdata('member_session')['c_no'], array('000000', '170708', '071162', '071159', '071183','230035','230776','071182'))){ 
      ?>
        <a href="<?php echo base_url( 'question/partners/N' ); ?>" class="btn btn-outline-secondary btn-block text-left">電訪紀錄</a>
        <a href="<?php echo base_url( 'question/partners/Q' ); ?>" class="btn btn-outline-secondary btn-block text-left">諮詢紀錄</a>
    
    <a href="<?php echo base_url( 'sample/partners' ); ?>" class="btn btn-outline-secondary btn-block text-left">試用品</a>
  </div>
</div>

<!-- 線上表單 -->
<a href="javascript:;" class="btn btn-outline-secondary btn-block <?=($active == 'online_form')?'active':'';?>">線上表單<i class="icon ion-ios-list"></i></a>
<div class="card">
  <div class="card-body">
    <!-- <a href="<?php echo base_url( 'online_form/form1' ); ?>" class="btn btn-outline-secondary btn-block text-left">單一產品訂購單</a>
    <a href="<?php echo base_url( 'online_form/form2' ); ?>" class="btn btn-outline-secondary btn-block text-left">健康宅配訂單暨入會申請表</a>
    <a href="<?php echo base_url( 'online_form/form3' ); ?>" class="btn btn-outline-secondary btn-block text-left">肌能調理宅配訂單暨入會申請書</a>
    <a href="<?php echo base_url( 'online_form/form4' ); ?>" class="btn btn-outline-secondary btn-block text-left">安露莎-合歡會員協議書</a> -->
    <?php if ($this->session->userdata('member_session')['c_no'] == '000000'): ?>
      <a href="<?php echo base_url( 'online_form/form5' ); ?>" class="btn btn-outline-secondary btn-block text-left">安露莎信用卡付款授權書</a>
    <?php endif; ?>
    <!-- <a href="<?php echo base_url( 'online_form/form6' ); ?>" class="btn btn-outline-secondary btn-block text-left">產品訂購單(印刷版)</a>
    <a href="<?php echo base_url( 'online_form/form7' ); ?>" class="btn btn-outline-secondary btn-block text-left">單次宅配單異動申請書</a> -->
    <!-- <a href="<?php echo base_url( 'online_form/form8' ); ?>" class="btn btn-outline-secondary btn-block text-left">郵局自動轉帳付款授權書</a> -->
  </div>
</div>


