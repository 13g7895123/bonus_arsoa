<?php
$prd_num = 0;
if (!empty($this->session->userdata('ProductList'))){
    $prd_num = count(explode( ',', $this->session->userdata('ProductList') ));
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


<a href="javascript:;" class="btn btn-outline-secondary btn-block">問卷專區　　<i class="icon ion-ios-list"></i></a>
<div class="card">
  <div class="card-body">
  <select name="type14" class="form-control">
        <option value="Q">產品體驗</option>
		<option value="A">活力發酵精萃</option>
		<option value="B">白鶴靈芝EX</option>
		<option value="C">美力C錠</option><option value="D">淨活水器、濾芯</option>
	</select>
  <select name="type14" class="form-control" style="margin-top:0.5rem;">
        <option value="Q">電訪</option>
		<option value="A">活力發酵精萃</option>
		<option value="B">白鶴靈芝EX</option>
		<option value="C">美力C錠</option><option value="D">淨活水器、濾芯</option>
	</select>
  <select name="type14" class="form-control" style="margin-top:0.5rem;">
        <option value="Q">產品諮詢</option>
		<option value="A">活力發酵精萃</option>
		<option value="B">白鶴靈芝EX</option>
		<option value="C">美力C錠</option><option value="D">淨活水器、濾芯</option>
	</select>
  <select name="type14" class="form-control" style="margin-top:0.5rem;">
        <option value="Q">試用品</option>
		<option value="A">活力發酵精萃</option>
		<option value="B">白鶴靈芝EX</option>
		<option value="C">美力C錠</option><option value="D">淨活水器、濾芯</option>
	</select>

  </div>
</div>

<?php } ?>
