<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

     <div class="section-mini">

        <div class="section-item text-left">
          
			  <div class="container">
			  
			  </div>
			  
			  <div class="container">
			  <div class="bs-stepper">
  <div class="bs-stepper-header" role="tablist">
    <!-- your steps here -->
    <div class="step active" data-target="#logins-part">
      <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger">
        <span class="bs-stepper-circle">1</span>
        <span class="bs-stepper-label">購物車</span>
      </button>
    </div>
    <div class="line"></div>
    <div class="step" data-target="#information-part">
      <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
        <span class="bs-stepper-circle">2</span>
        <span class="bs-stepper-label">資料填寫</span>
      </button>
    </div>
	<div class="line"></div>
    <div class="step" data-target="#information-part">
      <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger">
        <span class="bs-stepper-circle">3</span>
        <span class="bs-stepper-label">付款、訂單成立</span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content">
    <!-- your steps content here -->
    <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger"></div>
    <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger"></div>
  </div>
</div>
			  </div>
			  
          </div>
			
			

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-12 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>檢視購物車</strong></h1>
                  <div class="news-info mb30">
                    
                  </div>
					

                  <div class="mb65">
					  <div class="table-responsive">
					<table class="table table-striped mb-2 text-center">
  <thead class="thead-dark">
    <tr>
      <th>產品名稱</th>
      <th>單價</th>
      <th style="min-width: 158px;">數量</th>
      <th>小計</th>
      <th>BP小計</th>
      <th>兌換紅利</th>
      <th>加贈紅利</th>
      <th>刪除</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td nowrap="nowrap" class="text-left">安露莎淨白活膚蜜皂環保精裝135g</td>
      <td>1600</td>
      <td class="form-group">
		  <a href="javascript:;" onclick="ChangeProductNum('Minus', '85', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
        <input name="num_85" id="num_85" type="text" class="input-num" title="數量" value="1" maxlength="2">
        <a href="javascript:;" onclick="ChangeProductNum('Add', '85', '79');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a>
		</td>
      <td>1600</td>
      <td>28</td>
      <td>2800</td>
      <td>960</td>
      <td><input type="checkbox"></td>
    </tr>
    <tr>
      <td class="text-left">麗蓓思朵-化粧液</td>
      <td>1500</td>
      <td><div class="form-group"> <a href="javascript:;" onclick="ChangeProductNum('Minus', '85', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
        <input name="num_85" id="num_85" type="text" class="input-num" title="數量" value="1" maxlength="2">
        <a href="javascript:;" onclick="ChangeProductNum('Add', '85', '79');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a> </div></td>
      <td>1500</td>
      <td>28</td>
      <td>2800</td>
      <td>900</td>
      <td><input type="checkbox"></td>
    </tr>
    <tr>
      <td class="text-left">麗蓓思朵-保濕亮采肌底液</td>
      <td>1750</td>
      <td><div class="form-group"> <a href="javascript:;" onclick="ChangeProductNum('Minus', '85', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
        <input name="num_85" id="num_85" type="text" class="input-num" title="數量" value="1" maxlength="2">
        <a href="javascript:;" onclick="ChangeProductNum('Add', '85', '79');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a> </div></td>
      <td>1750</td>
      <td>37</td>
      <td>3000</td>
      <td>1,050</td>
      <td><input type="checkbox"></td>
    </tr>
	<tr>
	  <td class="text-left">可佳媽媽淨活水器-CJ230 ST</td>
	  <td>29500</td>
	  <td><div class="form-group"> <a href="javascript:;" onclick="ChangeProductNum('Minus', '85', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
	    <input name="num_85" id="num_85" type="text" class="input-num" title="數量" value="1" maxlength="2">
	    <a href="javascript:;" onclick="ChangeProductNum('Add', '85', '79');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a> </div></td>
	  <td>29500</td>
	  <td>600</td>
      <td>6000</td>
      <td>29,500</td>
      <td><input type="checkbox"></td>
    </tr>
  </tbody>
</table>
					  </div>
					  
<div class="row">	
	<div class="col-md-5">
		<table class="table text-right">
  <thead>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">BP</th>
      <th scope="col">建議售價</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">A類</th>
      <td>93</td>
      <td>4,850</td>
      </tr>
    <tr>
      <th scope="row">B類</th>
      <td>600</td>
      <td>29,500</td>
      </tr>
    <tr>
      <th scope="row">合計</th>
      <td>693</td>
      <td>34,350</td>
      </tr>
  </tbody>
</table>
	</div>
					  
					  <div class="col-md-4">
		<table class="table text-right">
  <thead>
    <tr>
		<th colspan="2" scope="col">紅利</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="text-info font-weight-bold">前期紅利</th>
      <td class="text-info font-weight-bold">1250</td>
      </tr>
    <tr>
      <th scope="row">+ 回饋紅利</th>
      <td>1000</td>
      </tr>
    <tr>
      <th scope="row">+ 加贈紅利</th>
      <td>50</td>
      </tr>
    <tr>
      <th scope="row">- 兌換紅利</th>
      <td>500</td>
    </tr>
    <tr>
      <th scope="row">= 目前結餘</th>
      <td>1800</td>
    </tr>
  </tbody>
</table>
	</div>
					  <div class="col-md-3">
		<table class="table text-right">
  <thead>
    <tr>
      <th colspan="2" scope="col">建議售價</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">合計</th>
      <td>4850</td>
      </tr>
    <!--<tr>
      <th scope="row">運費</th>
      <td>100</td>
      </tr>-->
    <tr>
      <th scope="row">總金額</th>
      <td>4950</td>
      </tr>
  </tbody>
</table>
	</div>
	
				    </div>
					<div class="text-right">
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="products.php" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　繼續訂購</a>
  <button type="button" class="btn btn-outline-secondary">更改數量</button>
  <a href="checkout.php" class="btn btn-outline-secondary">我要結帳　<i class="icon ion-ios-calculator"></i></a>
</div>
					</div>

                  </div>
<hr class="mt-0 mb70">
<div class="row">             
<div class="col-md-12">
		<p><?=$cart_remark?></p>
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