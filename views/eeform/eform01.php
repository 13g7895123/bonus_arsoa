<!doctype html>
<html lang="zh-Hant-TW">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">
    <meta name="description" content="Arsoa 安露莎化粧品">
    <meta name="author" content="Paul, Logan Cee">

    <title>Arsoa 安露莎化粧品 - Single Post With Sidebar</title>

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/owl.carousel.min.css" rel="stylesheet">
    <link href="css/owl.theme.default.min.css" rel="stylesheet">
    <link href="css/socicon.css" rel="stylesheet">
    <link href="css/ionicons.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/jquery.fancybox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

  </head>

  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?php include("includes/header.php"); ?>
		  
		  
        <div class="section-mini">

          <!--<div class="section-item text-left">
            <div class="article-promo">
              <div class="article-promo-item" style="background:url(img/love_bg.jpg); min-height: 20.375rem;">
              </div>
            </div>
			  
			  <div class="breadcrumb"><div class="container">
				  <a href="index.html" title="首頁">首頁</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="javascript:;" title="會員專區">會員專區</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="love.html" title="ARSOA Ai">ARSOA Ai</a></div>
				  </div>
			  
          </div>-->
			
			

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>肌膚諮詢記錄表</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="<?php echo base_url('Eform/saveEform01'); ?>" method="POST" class="text-left" id="eform01">
                        <div class="row">
							<div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>
							
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員姓名</label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填會員姓名" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">出生西元年</label>
                            <select name="birth_year" class="form-control form-control-custom" required>
                              <option value="">請選擇</option>
                              <option value="2005">2005</option>
                              <option value="2004">2004</option>
                              <option value="2003">2003</option>
                              <option value="2002">2002</option>
                            </select>
                          </div>
                          <div class="col-sm-2 mb30">
                            <label class="label-custom">出生西元月</label>
                            <select name="birth_month" class="form-control form-control-custom" required>
                              <option value="">請選擇</option>
                              <option value="1">1月</option>
                              <option value="2">2月</option>
                              <option value="3">3月</option>
                              <option value="4">4月</option>
                            </select>
                          </div>
						  <div class="col-sm-3 mb30">
                            <label class="label-custom">電話</label>
                            <input type="tel" name="phone" class="form-control form-control-custom" placeholder="請填09xxxxxxxx" required />
                          </div>
							
                          <div class="col-sm-12 mb30">
							  <div class="form-check form-check-inline">職業：</div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="occupation_service" id="occupation_service" value="1">
                              <label class="form-check-label" for="occupation_service">服務業　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="occupation_office" id="occupation_office" value="1">
                              <label class="form-check-label" for="occupation_office">上班族　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="occupation_restaurant" id="occupation_restaurant" value="1">
                              <label class="form-check-label" for="occupation_restaurant">餐飲業　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="occupation_housewife" id="occupation_housewife" value="1">
                              <label class="form-check-label" for="occupation_housewife">家管 </label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <div class="form-check form-check-inline">戶外日曬時間：</div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sunlight_1_2h" id="sunlight_1_2h" value="1">
                              <label class="form-check-label" for="sunlight_1_2h">1~2小時　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sunlight_3_4h" id="sunlight_3_4h" value="1">
                              <label class="form-check-label" for="sunlight_3_4h">3~4小時　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sunlight_5_6h" id="sunlight_5_6h" value="1">
                              <label class="form-check-label" for="sunlight_5_6h">5~6小時　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sunlight_8h_plus" id="sunlight_8h_plus" value="1">
                              <label class="form-check-label" for="sunlight_8h_plus">8小時以上　</label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <div class="form-check form-check-inline">待在空調環境：</div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="aircondition_1h" id="aircondition_1h" value="1">
                              <label class="form-check-label" for="aircondition_1h">1小時內　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="aircondition_2_4h" id="aircondition_2_4h" value="1">
                              <label class="form-check-label" for="aircondition_2_4h">2~4小時　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="aircondition_5_8h" id="aircondition_5_8h" value="1">
                              <label class="form-check-label" for="aircondition_5_8h">5~8小時　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="aircondition_8h_plus" id="aircondition_8h_plus" value="1">
                              <label class="form-check-label" for="aircondition_8h_plus">8小時以上　</label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <div class="form-check form-check-inline">睡眠狀況：</div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">晚上9:00~10:59就寢　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">晚上11:00~12:59就寢　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">凌晨1點之後就寢　</label>
                            </div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <div class="form-check form-check-inline">現在使用產品：</div>
							  <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">蜜皂　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">泥膜　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">化妝水　</label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">精華液　</label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">極緻系列　</label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">防曬　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb50">
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
								  <div class="row">
									  <p class="mb-0">肌膚困擾：</p>
									</div>
                                  <div class="row mb30">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">沒有彈性 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">沒有光澤 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">暗沉 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">斑點 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">毛孔粗大 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">痘痘粉刺 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">皺紋細紋 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">粗糙 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">癢、紅腫 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">乾燥 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">上妝不服貼 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                                  </div>
								  <div class="row">
									  <p class="mb-0">肌膚是否容易過敏：</p>
									</div>
                                  <div class="row">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">經常 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">偶爾(換季時) </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">不會 </label>
                            </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
							
						<div class="col-sm-12"><hr class="my-4"></div>
							
						  <div class="col-sm-12 mb30">
							<h4>建議內容：</h4>
                            <div class="alert alert-warning" role="alert">
							<div class="row">
                              <div class="col-sm-6 mb30">
                                <label class="label-custom">化妝水：</label>
                                <input type="text" name="toner_suggestion" class="form-control form-control-custom" placeholder="" />
                              </div>
                              <div class="col-sm-6 mb30">
                                <label class="label-custom">精華液：</label>
                                <input type="text" name="serum_suggestion" class="form-control form-control-custom" placeholder="" />
                              </div>
							  <div class="col-sm-12 mb30">
                                <label class="label-custom">建議內容</label>
                                <input type="text" name="suggestion_content" class="form-control form-control-custom" placeholder="請填寫建議內容…" />
                              </div>
							</div>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
									<div class="col-sm-8 mb30">
										<div class="form-check form-check-inline">肌膚類型：</div>
										<div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="skin_type" id="skin_normal" value="normal">
                                        <label class="form-check-label" for="skin_normal">中性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="skin_type" id="skin_combination" value="combination">
                                        <label class="form-check-label" for="skin_combination">混合性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="skin_type" id="skin_oily" value="oily">
                                        <label class="form-check-label" for="skin_oily">油性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="skin_type" id="skin_dry" value="dry">
                                        <label class="form-check-label" for="skin_dry">乾性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="skin_type" id="skin_sensitive" value="sensitive">
                                        <label class="form-check-label" for="skin_sensitive">敏感性 </label>
                                      </div>
                                    </div>
									<div class="col-sm-4 mb30">
                                      <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="skin_age">肌膚年齡： </label>
                                        <input type="number" name="skin_age" id="skin_age" style="width: 80%;">
                                      </div>
                                    </div>
									  
                                    <div class="col-sm-12 mb30">
										<label class="label-custom">水潤</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button1" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
                                    <div class="col-sm-12 mb30">
										<label class="label-custom">膚色</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button2" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">紋理</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button3" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">敏感</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button4" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">油脂</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button5" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">色素</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button6" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">皺紋</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button7" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
									<div class="col-sm-12 mb30">
										<label class="label-custom">毛孔</label>
                                        <div class="row">
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:red;"></i> 嚴重、盡快改善：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                              </div>
                                              </div>
                                          </div>
                                            <div class="col-sm-4 mb20">
                                            <div class="row">
                                                <div class="col-lg-auto">
                                                <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                              </div>
                                                <div class="col-lg-auto">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb20" id="water-status-section">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="請填日期…">
                                              </div>
                                                <div class="col-lg-6">
                                                <input type="text" class="form-control form-control-custom" placeholder="限填數字…">
                                              </div>
                                              </div>
                                          </div>
                                          </div>
											<a href="javascript:;" class="btn btn-primary btn-xs" id="add-button8" style="color:white;"><i class="ico ion-plus" style="color:white;"></i> 新增日期</a>
										<hr>
                                    </div>
									  
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <hr class="my-4">
							  <div id="testDataButton" style="display: none;" class="mb-3">
								<button type="button" class="btn btn-outline-info btn-sm" onclick="fillTestData()">
								  <i class="fas fa-flask mr-1"></i>填入測試資料
								</button>
							  </div>
							  <button type="button" class="btn btn-outline-danger btn-block" onclick="showConfirmModal()">送出表單</button>
							</div>
							
                        </div>
						</form>
                    </div>
                  </div>

                </div>

                <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				  <div class="mb75">
<h4><strong>電子表單</strong></h4>
<a href="eform01_list.php" class="btn btn-outline-secondary btn-block active">肌膚諮詢記錄表</a>
<div class="card d-none">
  <div class="card-body">
    <a href="eform01_list.php" class="btn btn-outline-secondary btn-block text-left">填寫紀錄</a>
    <a href="eform01.php" class="btn btn-outline-secondary btn-block text-left">我要填寫</a>
  </div>
</div>
<a href="eform02.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(肌膚)</a>
<a href="eform03_list.php" class="btn btn-outline-secondary btn-block">微微卡日記</a>
<a href="eform04.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(保健)</a>
<a href="eform05.php" class="btn btn-outline-secondary btn-block">健康諮詢表</a>
</div>

                  <!--<div class="mb65">
                    <h4>產品分類</h4>

                    <div class="article-list-mini">
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p01.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">肌膚保養系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p02.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">彩妝系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p04.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p05.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">美髮、美體系列</a></h5>
                        </div>
                      </div>
					  <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p03.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                    </div>
                  </div>-->

                  
				  
				  
                </aside>
              </div>
            </div>
          </div>

        </div>


      </div>

      <?php include("includes/footer.php"); ?>

    </div>

  <!-- Confirm Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content border">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title text-dark" id="confirmModalLabel">
            確認表單內容
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
          <div class="container-fluid">
            
            <!-- 基本資料 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  基本資料
                </h6>
              </div>
              <div class="p-3">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 80px;">會員姓名：</span>
                      <span class="text-dark" id="confirm-member-name"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 80px;">出生年：</span>
                      <span class="text-dark" id="confirm-birth-year"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 80px;">出生月：</span>
                      <span class="text-dark" id="confirm-birth-month"></span>
                    </div>
                  </div>
                  <div class="col-md-2 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">電話：</span>
                      <span class="text-dark" id="confirm-phone"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 職業選擇 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  職業選擇
                </h6>
              </div>
              <div class="p-3">
                <div id="confirm-occupation"></div>
              </div>
            </div>

            <!-- 其他資訊 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  其他填寫資訊
                </h6>
              </div>
              <div class="p-3">
                <div class="text-muted">由於表單內容較多，僅顯示基本必填資訊。請確認基本資料無誤後送出。</div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer border-top bg-white">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            取消
          </button>
          <button type="button" class="btn btn-danger" onclick="submitForm()">
            確認送出
          </button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">訂單內容</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
			．訂單編號：W191015005<br>
			．訂購日期：2019/10/15 14:50<br>
			．付款狀態：付款未完成<br>
			．訂購會員：000000  公司<br>
			．收件人姓名：公司<br>
			．收件人地址：106 台北市大安區信義路三段149號9樓(台灣安露莎) <br>
			．收件人聯絡電話：02-2706-3111 <br>
			．電子郵件信箱：abc@qbc.com<br>
			．付款人身份證字號：A123456789 
		  </p>
		  <table class="table table-striped table-responsive mb-2">
  <thead class="thead-dark">
    <tr>
      <th>#</th>
      <th>產品編號</th>
      <th>產品名稱</th>
      <th>建議售價</th>
      <th>銷售折扣</th>
      <th>BP</th>
      <th style="width: 10%">訂購<br>數量</th>
      <th>應付小計</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>00421628 </td>
      <td>安露莎淨白活膚蜜皂環保精裝135g</td>
      <td>1,600 元</td>
      <td>60%</td>
      <td>28</td>
      <td>1</td>
      <td>960 元</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>00401555</td>
      <td>麗蓓思朵-化粧液</td>
      <td>1,500 元</td>
      <td>60%</td>
      <td>28</td>
      <td>1</td>
      <td>900 元</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>00401563</td>
      <td>麗蓓思朵-保濕亮采肌底液</td>
      <td>1,750 元</td>
      <td>60%</td>
      <td>37</td>
      <td>1</td>
      <td>1,050 元</td>
    </tr>
	<tr>
      <th scope="row">4</th>
      <td>0385769</td>
      <td>可佳媽媽淨活水器-CJ230 ST</td>
      <td>29,500 元</td>
      <td>無折扣</td>
      <td>600</td>
      <td>1</td>
      <td>29,500 元</td>
    </tr>
  </tbody>
</table>
		  <div class="row">
	<div class="col-md-6">
		<p>
			備註：<br>
			<ol><li>請您於交易完成時，記下網購單號，以便追蹤查詢進度。</li>
				<li>本公司保留出貨與否權利。</li>
				<li>購滿建議售價 2,000 元，免付運費 100 元。</li>
				<li>為保障會員用卡安全，本公司僅接受訂貨人本人持有之信用卡。</li>
				<li>一但確定您要的贈品數量後，請按更改數量確認；否則將會造成資料的遺失。</li>
		</ol>
		</p>
	</div>
	<div class="col-md-6">
		<table class="table">
  <thead>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">BP</th>
      <th scope="col">建議售價</th>
      <th scope="col">優惠價</th>
      <th scope="col">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">A類</th>
      <td>93</td>
      <td>4,850</td>
      <td>2,910</td>
      <td>元</td>
    </tr>
    <tr>
      <th scope="row">B類</th>
      <td>600</td>
      <td>29,500</td>
      <td>29,500</td>
      <td>元</td>
    </tr>
    <tr>
      <th scope="row">合計</th>
      <td>693</td>
      <td>34,350</td>
      <td>32,410</td>
      <td>元</td>
    </tr>
    <tr>
      <th scope="row">取件方式</th>
      <td>貨運</td>
      <td>運費：</td>
      <td>0</td>
      <td>元</td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>應付總計：</td>
      <td>32,410</td>
      <td>元</td>
    </tr>
  </tbody>
</table>
	</div>
	
				    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>
	
	<a id="back2Top" title="Back to top" href="#"><i class="ico ion-arrow-right-b"></i></a>


    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.pagepiling.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/TweenMax.min.js"></script>
    <script src="js/ScrollMagic.min.js"></script>
    <script src="js/animation.gsap.min.js"></script>
    <script src="js/jquery.viewport.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/script.js"></script>
	

<script>
        // 點擊「新增」按鈕時
        document.getElementById('add-button1').addEventListener('click', function() {
            var section = document.getElementById('water-status-section');
            var newSection = section.cloneNode(true); // 複製現有區塊
            section.parentElement.appendChild(newSection); // 把複製的區塊加到原來區塊的下方
        });
    </script>

    <script>
      $(document).ready(function() {
        // init controller
        var controller = new ScrollMagic.Controller();

        // build scenes
        new ScrollMagic.Scene({triggerElement: '.section-mini', triggerHook: 1, duration: '200%'})
              .setTween('.article-promo-item', {backgroundPosition: '50% 100%', ease: Linear.easeNone})
              .addTo(controller);

      });
    </script>
  <!-- Simple CSS for clean UI -->
  <style>
    .modal-content {
      border-radius: 0px;
    }
    
    .modal-body::-webkit-scrollbar {
      width: 8px;
    }
    
    .modal-body::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    
    .modal-body::-webkit-scrollbar-thumb {
      background: #c1c1c1;
    }
    
    .modal-body::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
  </style>

  <script>
    // 控制測試按鈕顯示的變數
    var showTestButton = true; // 設為 false 可隱藏測試按鈕
    
    // 頁面載入時檢查是否顯示測試按鈕
    $(document).ready(function() {
      if (showTestButton) {
        document.getElementById('testDataButton').style.display = 'block';
      }
    });
    
    // 填入測試資料的函數
    function fillTestData() {
      // 基本資料
      document.querySelector('input[name="member_name"]').value = '王小華';
      document.querySelector('select[name="birth_year"]').value = '2003';
      document.querySelector('select[name="birth_month"]').value = '5';
      document.querySelector('input[name="phone"]').value = '0912345678';
      
      // 職業選擇
      document.querySelector('input[name="occupation_service"]').checked = true;
      document.querySelector('input[name="occupation_office"]').checked = true;
      
      // 戶外日曬時間
      document.querySelector('input[name="sunlight_3_4h"]').checked = true;
      
      // 空調環境時間
      document.querySelector('input[name="aircondition_5_8h"]').checked = true;
      
      // 建議內容
      if (document.querySelector('input[name="toner_suggestion"]')) {
        document.querySelector('input[name="toner_suggestion"]').value = '麗蓓思朵化妝水';
      }
      if (document.querySelector('input[name="serum_suggestion"]')) {
        document.querySelector('input[name="serum_suggestion"]').value = '保濕亮采肌底液';
      }
      if (document.querySelector('input[name="suggestion_content"]')) {
        document.querySelector('input[name="suggestion_content"]').value = '建議加強保濕護理，每日使用面膜2-3次';
      }
      
      // 肌膚類型
      if (document.querySelector('input[name="skin_type"][value="combination"]')) {
        document.querySelector('input[name="skin_type"][value="combination"]').checked = true;
      }
      
      // 肌膚年齡
      if (document.querySelector('input[name="skin_age"]')) {
        document.querySelector('input[name="skin_age"]').value = '25';
      }
      
      // 評分欄位（水潤）
      if (document.querySelector('input[name="moisture_severe"]')) {
        document.querySelector('input[name="moisture_severe"]').value = '0';
      }
      if (document.querySelector('input[name="moisture_warning"]')) {
        document.querySelector('input[name="moisture_warning"]').value = '6';
      }
      if (document.querySelector('input[name="moisture_healthy"]')) {
        document.querySelector('input[name="moisture_healthy"]').value = '8';
      }
      
      // 填入其他可能存在的評分欄位
      var scoreFields = [
        'complexion_severe', 'complexion_warning', 'complexion_healthy',
        'texture_severe', 'texture_warning', 'texture_healthy',
        'sensitivity_severe', 'sensitivity_warning', 'sensitivity_healthy',
        'oil_severe', 'oil_warning', 'oil_healthy',
        'pigment_severe', 'pigment_warning', 'pigment_healthy',
        'wrinkle_severe', 'wrinkle_warning', 'wrinkle_healthy',
        'pore_severe', 'pore_warning', 'pore_healthy'
      ];
      
      scoreFields.forEach(function(fieldName) {
        var field = document.querySelector('input[name="' + fieldName + '"]');
        if (field) {
          if (fieldName.includes('severe')) {
            field.value = '1';
          } else if (fieldName.includes('warning')) {
            field.value = '6';
          } else if (fieldName.includes('healthy')) {
            field.value = '9';
          }
        }
      });
      
      // 日期欄位（如果存在）
      var dateFields = document.querySelectorAll('input[placeholder*="請填日期"]');
      dateFields.forEach(function(field, index) {
        field.value = '2025-0' + ((index % 9) + 1) + '-15';
      });
      
      // 數字欄位（如果存在）
      var numberFields = document.querySelectorAll('input[placeholder*="限填數字…"]');
      numberFields.forEach(function(field, index) {
        field.value = (index % 10) + 1;
      });
      
      // 睡眠狀況checkbox（選擇其中幾個）
      var sleepCheckboxes = document.querySelectorAll('input[type="checkbox"]');
      sleepCheckboxes.forEach(function(checkbox, index) {
        // 隨機選中一些checkbox，但不要全選
        if (index % 3 === 0) {
          checkbox.checked = true;
        }
      });
      
      // 現在使用產品checkbox（選擇幾個常用的）
      var productCheckboxes = document.querySelectorAll('input[type="checkbox"]');
      productCheckboxes.forEach(function(checkbox, index) {
        if (index % 4 === 1) {
          checkbox.checked = true;
        }
      });
      
      // 肌膚困擾checkbox（選擇幾個常見問題）
      var skinIssueCheckboxes = document.querySelectorAll('input[type="checkbox"]');
      skinIssueCheckboxes.forEach(function(checkbox, index) {
        if (index % 5 === 2) {
          checkbox.checked = true;
        }
      });
      
      // 其他text input欄位
      var otherTextInputs = document.querySelectorAll('input[type="text"]:not([name])');
      otherTextInputs.forEach(function(input, index) {
        if (input.style.width === '80%') {
          input.value = '其他備註' + (index + 1);
        } else {
          input.value = '測試內容' + (index + 1);
        }
      });
      
      // 所有沒有name屬性的number類型input
      var otherNumberInputs = document.querySelectorAll('input[type="number"]:not([name])');
      otherNumberInputs.forEach(function(input, index) {
        input.value = (index % 10) + 1;
      });
      
      console.log('測試資料已填入完成');
    }

    function showConfirmModal() {
      // 驗證必填欄位
      var memberName = document.querySelector('input[name="member_name"]').value;
      var birthYear = document.querySelector('select[name="birth_year"]').value;
      var birthMonth = document.querySelector('select[name="birth_month"]').value;
      var phone = document.querySelector('input[name="phone"]').value;

      if (!memberName || !birthYear || !birthMonth || !phone) {
        alert('請填寫所有必填欄位');
        return;
      }

      // 填入確認視窗的內容
      document.getElementById('confirm-member-name').textContent = memberName;
      document.getElementById('confirm-birth-year').textContent = birthYear + '年';
      document.getElementById('confirm-birth-month').textContent = birthMonth + '月';
      document.getElementById('confirm-phone').textContent = phone;
      
      // 職業選擇
      var occupations = [
        {name: 'occupation_service', label: '服務業'},
        {name: 'occupation_office', label: '上班族'},
        {name: 'occupation_restaurant', label: '餐飲業'},
        {name: 'occupation_housewife', label: '家管'}
      ];
      var occupationContainer = document.getElementById('confirm-occupation');
      var checkedOccupations = [];
      
      occupations.forEach(function(item) {
        var checkbox = document.querySelector('input[name="' + item.name + '"]');
        if (checkbox && checkbox.checked) {
          checkedOccupations.push(item.label);
        }
      });
      
      if (checkedOccupations.length > 0) {
        occupationContainer.innerHTML = '<span class="text-dark">' + checkedOccupations.join('、') + '</span>';
      } else {
        occupationContainer.innerHTML = '<span class="text-muted">未選擇</span>';
      }
      
      // 顯示模態視窗
      $('#confirmModal').modal('show');
    }

    function submitForm() {
      document.getElementById('eform01').submit();
    }
  </script>

	<script>
	  /*Scroll to top when arrow up clicked BEGIN*/
$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 100) {
        $('#back2Top').fadeIn();
    } else {
        $('#back2Top').fadeOut();
    }
});
$(document).ready(function() {
    $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

});
 /*Scroll to top when arrow up clicked END*/
	  </script>

  </body>
</html>
