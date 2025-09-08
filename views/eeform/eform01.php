<!doctype html>
<html lang="zh-Hant-TW">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">
    <meta name="description" content="Arsoa 安露莎化粧品 - 肌膚諮詢記錄表">
    <meta name="author" content="Paul, Logan Cee">

    <title>Arsoa 安露莎化粧品 - 肌膚諮詢記錄表</title>

    <!-- CSS -->
    <link href="<?= base_url(); ?>views/eeform/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/animsition.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/socicon.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/ionicons.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>views/eeform/css/jquery.fancybox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="<?= base_url(); ?>views/eeform/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url(); ?>favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

  </head>

  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?= $this->block_service->load_html_header(); ?>
        <div class="section-mini">
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>肌膚諮詢記錄表</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="#" method="POST" class="text-left" id="eform01" novalidate>
                        <div class="row">
                          <div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>

                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員編號</label>
                            <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" readonly />
                          </div>
                          
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員姓名</label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填會員姓名" required />
                            <select name="member_name_select" class="form-control form-control-custom" style="display: none;" disabled required>
                              <option value="">請選擇會員</option>
                            </select>
                          </div>
                          <div class="col-sm-5 mb30">
                            <label class="label-custom">出生年月</label>
                            <input type="month" name="birth_date" class="form-control form-control-custom" min="1980-01" max="2010-12" required />
                            <!-- Keep hidden fields for backward compatibility -->
                            <input type="hidden" name="birth_year" />
                            <input type="hidden" name="birth_month" />
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
                              <input class="form-check-input" type="checkbox" name="sleep_9_10" id="sleep_9_10" value="1">
                              <label class="form-check-label" for="sleep_9_10">晚上9:00~10:59就寢　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sleep_11_12" id="sleep_11_12" value="1">
                              <label class="form-check-label" for="sleep_11_12">晚上11:00~12:59就寢　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sleep_after_1" id="sleep_after_1" value="1">
                              <label class="form-check-label" for="sleep_after_1">凌晨1點之後就寢　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="sleep_other" id="sleep_other" value="1">
                              <label class="form-check-label" for="sleep_other">其他： </label>
                              <input type="text" name="sleep_other_text">
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">現在使用產品：</div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_honey_soap" id="product_honey_soap" value="1">
                              <label class="form-check-label" for="product_honey_soap">蜜皂　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_mud_mask" id="product_mud_mask" value="1">
                              <label class="form-check-label" for="product_mud_mask">泥膜　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_toner" id="product_toner" value="1">
                              <label class="form-check-label" for="product_toner">化妝水　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_serum" id="product_serum" value="1">
                              <label class="form-check-label" for="product_serum">精華液　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_premium" id="product_premium" value="1">
                              <label class="form-check-label" for="product_premium">極緻系列　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_sunscreen" id="product_sunscreen" value="1">
                              <label class="form-check-label" for="product_sunscreen">防曬　</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="product_other" id="product_other" value="1">
                              <label class="form-check-label" for="product_other">其他： </label>
                              <input type="text" name="product_other_text">
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
                                      <input class="form-check-input" type="checkbox" name="skin_issue_elasticity" id="skin_issue_elasticity" value="1">
                                      <label class="form-check-label" for="skin_issue_elasticity">沒有彈性 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_luster" id="skin_issue_luster" value="1">
                                      <label class="form-check-label" for="skin_issue_luster">沒有光澤 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_dull" id="skin_issue_dull" value="1">
                                      <label class="form-check-label" for="skin_issue_dull">暗沉 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_spots" id="skin_issue_spots" value="1">
                                      <label class="form-check-label" for="skin_issue_spots">斑點 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_pores" id="skin_issue_pores" value="1">
                                      <label class="form-check-label" for="skin_issue_pores">毛孔粗大 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_acne" id="skin_issue_acne" value="1">
                                      <label class="form-check-label" for="skin_issue_acne">痘痘粉刺 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_wrinkles" id="skin_issue_wrinkles" value="1">
                                      <label class="form-check-label" for="skin_issue_wrinkles">皺紋細紋 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_rough" id="skin_issue_rough" value="1">
                                      <label class="form-check-label" for="skin_issue_rough">粗糙 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_irritation" id="skin_issue_irritation" value="1">
                                      <label class="form-check-label" for="skin_issue_irritation">癢、紅腫 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_dry" id="skin_issue_dry" value="1">
                                      <label class="form-check-label" for="skin_issue_dry">乾燥 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_makeup" id="skin_issue_makeup" value="1">
                                      <label class="form-check-label" for="skin_issue_makeup">上妝不服貼 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="skin_issue_other" id="skin_issue_other" value="1">
                                      <label class="form-check-label" for="skin_issue_other">其他： </label>
                                      <input type="text" name="skin_issue_other_text">
                                    </div>
                                  </div>
                                  <div class="row">
                                    <p class="mb-0">肌膚是否容易過敏：</p>
                                  </div>
                                  <div class="row">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="allergy_frequent" id="allergy_frequent" value="1">
                                      <label class="form-check-label" for="allergy_frequent">經常 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="allergy_seasonal" id="allergy_seasonal" value="1">
                                      <label class="form-check-label" for="allergy_seasonal">偶爾(換季時) </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="allergy_never" id="allergy_never" value="1">
                                      <label class="form-check-label" for="allergy_never">不會 </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <hr class="my-4">
                          </div>

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
                                              <input type="text" name="moisture_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="moisture_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="moisture_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="water-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="complexion_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="complexion_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="complexion_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="complexion-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="texture_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="texture_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="texture_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="texture-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="sensitivity_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="sensitivity_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="sensitivity_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="sensitivity-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="oil_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="oil_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="oil_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="oil-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="pigment_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="pigment_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="pigment_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="pigment-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="wrinkle_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="wrinkle_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="wrinkle_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="wrinkle-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                                              <input type="text" name="pore_severe" class="form-control form-control-custom" placeholder="限填數字 ex. 0 - 1">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:orange;"></i> 有問題、要注意：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="pore_warning" class="form-control form-control-custom" placeholder="限填數字 ex. 5 - 7">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
                                            <div class="col-lg-auto">
                                              <p><i class="ico ion-record" style="color:green;"></i> 健康：</p>
                                            </div>
                                            <div class="col-lg-auto">
                                              <input type="text" name="pore_healthy" class="form-control form-control-custom" placeholder="限填數字 ex. 8 - 10">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="pore-date-container">
                                        <div class="row">
                                          <div class="col-sm-4 mb20 date-input-group">
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
                            <!-- 確保送出表單按鈕始終可見 -->
                            <button type="button" class="btn btn-outline-danger btn-block" onclick="showConfirmModal()" style="display: block !important;">送出表單</button>
                          </div>

                        </div>
                      </form>
                    </div>
                  </div>

                </div>

                <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                  <!-- 側邊欄清單 -->
                  <?= $this->block_service->electronic_form_right_menu('eform1'); ?>
                </aside>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?= $this->block_service->load_html_footer(); ?>
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
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-center">
                        <span class="text-muted mr-3" style="min-width: 80px;">出生年月：</span>
                        <span class="text-dark" id="confirm-birth-date"></span>
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

              <!-- 生活習慣 -->
              <div class="border mb-4">
                <div class="bg-light p-3 border-bottom">
                  <h6 class="m-0 font-weight-bold text-dark">
                    生活習慣
                  </h6>
                </div>
                <div class="p-3">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-start">
                        <span class="text-muted mr-3" style="min-width: 100px;">戶外日曬：</span>
                        <span class="text-dark" id="confirm-sunlight"></span>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-start">
                        <span class="text-muted mr-3" style="min-width: 100px;">空調環境：</span>
                        <span class="text-dark" id="confirm-aircondition"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- 建議內容 -->
              <div class="border mb-4">
                <div class="bg-light p-3 border-bottom">
                  <h6 class="m-0 font-weight-bold text-dark">
                    建議內容
                  </h6>
                </div>
                <div class="p-3">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-start">
                        <span class="text-muted mr-3" style="min-width: 80px;">化妝水：</span>
                        <span class="text-dark" id="confirm-toner-suggestion"></span>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-start">
                        <span class="text-muted mr-3" style="min-width: 80px;">精華液：</span>
                        <span class="text-dark" id="confirm-serum-suggestion"></span>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-start">
                        <span class="text-muted mr-3" style="min-width: 80px;">建議內容：</span>
                        <span class="text-dark" id="confirm-suggestion-content"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- 肌膚評估 -->
              <div class="border mb-4">
                <div class="bg-light p-3 border-bottom">
                  <h6 class="m-0 font-weight-bold text-dark">
                    肌膚評估
                  </h6>
                </div>
                <div class="p-3">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-center">
                        <span class="text-muted mr-3" style="min-width: 80px;">肌膚類型：</span>
                        <span class="text-dark" id="confirm-skin-type"></span>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <div class="d-flex align-items-center">
                        <span class="text-muted mr-3" style="min-width: 80px;">肌膚年齡：</span>
                        <span class="text-dark" id="confirm-skin-age"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- 其他資訊 -->
              <div class="border mb-4">
                <div class="bg-light p-3 border-bottom">
                  <h6 class="m-0 font-weight-bold text-dark">
                    其他資訊
                  </h6>
                </div>
                <div class="p-3">
                  <div class="text-muted">表單包含詳細的肌膚評估數據和其他選項，上述為主要填寫內容的確認。</div>
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
              ．訂購會員：000000 公司<br>
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
                <ol>
                  <li>請您於交易完成時，記下網購單號，以便追蹤查詢進度。</li>
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
    <script>
      window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')
    </script>
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
      // 新增日期功能 - jQuery版本，支援最多3組，達到上限時隱藏按鈕
      $(document).ready(function() {
        // 定義所有容器和按鈕的對應關係
        var addButtonConfigs = [
          { buttonId: '#add-button1', containerId: '#water-date-container' },
          { buttonId: '#add-button2', containerId: '#complexion-date-container' },
          { buttonId: '#add-button3', containerId: '#texture-date-container' },
          { buttonId: '#add-button4', containerId: '#sensitivity-date-container' },
          { buttonId: '#add-button5', containerId: '#oil-date-container' },
          { buttonId: '#add-button6', containerId: '#pigment-date-container' },
          { buttonId: '#add-button7', containerId: '#wrinkle-date-container' },
          { buttonId: '#add-button8', containerId: '#pore-date-container' }
        ];

        // 為每個按鈕設置點擊事件
        $.each(addButtonConfigs, function(index, config) {
          $(config.buttonId).on('click', function() {
            var $container = $(config.containerId);
            var currentGroups = $container.find('.date-input-group').length;
            
            // 檢查是否已達到最大數量（3組）
            if (currentGroups < 3) {
              // 複製第一個日期輸入組
              var $newGroup = $container.find('.date-input-group:first').clone();
              
              // 清空複製組的輸入值
              $newGroup.find('input').val('');
              
              // 將新組添加到現有的row中（橫向排列）
              var $firstRow = $container.find('.row:first');
              $firstRow.append($newGroup);
              
              // 檢查是否達到3組，如果是則隱藏按鈕
              if (currentGroups + 1 >= 3) {
                $(config.buttonId).hide();
              }
            }
          });
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        // init controller
        var controller = new ScrollMagic.Controller();

        // build scenes
        new ScrollMagic.Scene({
            triggerElement: '.section-mini',
            triggerHook: 1,
            duration: '200%'
          })
          .setTween('.article-promo-item', {
            backgroundPosition: '50% 100%',
            ease: Linear.easeNone
          })
          .addTo(controller);

      });
    </script>

    <script>
      // 添加全域錯誤處理，防止 JS 錯誤影響 console 功能
      window.addEventListener('error', function(e) {
        // 錯誤處理但不輸出 console
        return true; // 防止錯誤中斷執行
      });
      
      // 控制測試按鈕顯示的變數
      var showTestButton = false; // 設為 true 顯示測試按鈕
      
      // 取得目前登入使用者資訊
      var currentUserData = {
        member_id: '<?php echo isset($userdata['c_no']) ? $userdata['c_no'] : ''; ?>',
        member_name: '<?php echo isset($userdata['c_name']) ? $userdata['c_name'] : ''; ?>'
      };

      // 會員資料相關變數
      var memberData = [];
      var isMultipleMembers = false;

      // 初始化會員資料
      function initializeMemberData() {
        // 設定會員編號欄位，預設為 000000
        if (!currentUserData.member_id || currentUserData.member_id.trim() === '') {
          currentUserData.member_id = '000000';
        }
        $('input[name="member_id"]').val(currentUserData.member_id);
        
        // 查詢會員資料
        if (currentUserData.member_id && currentUserData.member_id.trim() !== '') {
          lookupMemberData(currentUserData.member_id);
        } else {
          // 使用測試ID來確認API端點是否正常運作
          lookupMemberData('TEST123');
          
          // 設定預設姓名
          $('input[name="member_name"]').val(currentUserData.member_name);
        }
      }

      // 查詢會員資料
      function lookupMemberData(memberId) {
        var apiUrl = '<?php echo base_url("api/eeform1/member_lookup/"); ?>' + memberId;
        
        $.ajax({
          url: apiUrl,
          method: 'GET',
          dataType: 'json',
          beforeSend: function(xhr) {
            // AJAX 請求正在發送
          },
          success: function(response) {
            
            if (response.success && response.data) {
              memberData = response.data.members;
              
              if (memberData.length > 1) {
                // 多個會員：顯示下拉選單
                isMultipleMembers = true;
                setupMemberDropdown();
              } else if (memberData.length === 1) {
                // 單個會員：使用文字輸入框
                isMultipleMembers = false;
                $('input[name="member_name"]').val(memberData[0].c_name);
                currentUserData.member_name = memberData[0].c_name;
              } else {
                // 沒有找到會員：使用預設值
                isMultipleMembers = false;
                $('input[name="member_name"]').val(currentUserData.member_name);
              }
            } else {
              // API 回應格式不正確
            }
          },
          error: function(xhr, status, error) {
            // API 呼叫失敗
            // 出錯時使用預設值
            $('input[name="member_name"]').val(currentUserData.member_name);
          },
          complete: function(xhr, status) {
            // AJAX 請求完成
          }
        });
      }

      // 設定會員下拉選單
      function setupMemberDropdown() {
        
        var $nameInput = $('input[name="member_name"]');
        var $nameSelect = $('select[name="member_name_select"]');
        
        // 隱藏輸入框，顯示下拉選單
        $nameInput.hide().prop('required', false).prop('disabled', true);
        $nameSelect.show().prop('required', true).prop('disabled', false);
        
        // 清空並重新填充選項
        $nameSelect.empty().append('<option value="">請選擇會員</option>');
        
        var currentUserSelected = false;
        memberData.forEach(function(member, index) {
          var option = $('<option value="' + member.c_no + '" data-name="' + member.c_name + '">' + 
                         member.c_name + '</option>');
          
          // 檢查是否為當前使用者，如果是則設為預設選擇
          if (member.c_no === currentUserData.member_id || 
              member.c_name === currentUserData.member_name) {
            option.prop('selected', true);
            currentUserSelected = true;
          }
          
          $nameSelect.append(option);
        });
        
        // 更新會員編號（根據目前選擇的會員）
        var selectedOption = $nameSelect.find('option:selected');
        if (selectedOption.val()) {
          $('input[name="member_id"]').val(selectedOption.val());
          currentUserData.member_id = selectedOption.val();
          currentUserData.member_name = selectedOption.data('name');
        }
        
        // 綁定選擇事件
        $nameSelect.off('change').on('change', function() {
          var selectedOption = $(this).find('option:selected');
          
          if (selectedOption.val()) {
            var newMemberId = selectedOption.val();
            var newMemberName = selectedOption.data('name');
            
            // 更新會員編號和姓名
            $('input[name="member_id"]').val(newMemberId);
            currentUserData.member_id = newMemberId;
            currentUserData.member_name = newMemberName;
          }
        });
      }

      // 頁面載入時檢查是否顯示測試按鈕 - jQuery版本
      $(document).ready(function() {
        
        // 修復 lazyload 錯誤 - 檢查並安全初始化 lazyload
        if (typeof $.fn.lazyload !== 'undefined') {
          try {
            $("img.lazy").lazyload({threshold: 200});
          } catch (e) {
            // lazyload 初始化失敗，但不影響其他功能
          }
        }
        
        if (showTestButton) {
          $('#testDataButton').show();
        }
        
        // 初始化會員資料
        initializeMemberData();
      });

      // 填入測試資料的函數 - jQuery版本
      function fillTestData() {
        // 確保必填欄位都有資料
        
        // 必填欄位 - 一定要填寫
        // 會員姓名 - 若是下拉選單且有選項，保持選擇；若是輸入框則填入
        if (!$('select[name="member_name_select"]').is(':visible')) {
          // 只有在輸入框且沒有值時才填入
          if (!$('input[name="member_name"]').val()) {
            $('input[name="member_name"]').val('王小華');
          }
        }
        
        // 出生年月 - 必填
        if (!$('input[name="birth_date"]').val()) {
          var randomYear = 1990 + Math.floor(Math.random() * 20);
          var randomMonth = 1 + Math.floor(Math.random() * 12);
          $('input[name="birth_date"]').val(randomYear + '-' + (randomMonth < 10 ? '0' : '') + randomMonth);
        }
        
        // 電話 - 必填
        if (!$('input[name="phone"]').val()) {
          var phonePrefix = ['0912', '0933', '0988', '0975', '0910'];
          var randomPhone = phonePrefix[Math.floor(Math.random() * phonePrefix.length)] + Math.floor(100000 + Math.random() * 900000);
          $('input[name="phone"]').val(randomPhone);
        }

        // 職業選擇 - 隨機選擇
        var occupations = ['occupation_service', 'occupation_office', 'occupation_restaurant', 'occupation_housewife'];
        occupations.forEach(function(occ) {
          if (Math.random() > 0.5) {
            $('input[name="' + occ + '"]').prop('checked', Math.random() > 0.5);
          }
        });

        // 戶外日曬時間 - 隨機選擇一個
        var sunlightOptions = ['sunlight_1_2h', 'sunlight_3_4h', 'sunlight_5_6h', 'sunlight_8h_plus'];
        if (Math.random() > 0.3) {
          var randomSunlight = sunlightOptions[Math.floor(Math.random() * sunlightOptions.length)];
          $('input[name="' + randomSunlight + '"]').prop('checked', true);
        }

        // 空調環境時間 - 隨機選擇一個
        var airConditionOptions = ['aircondition_1h', 'aircondition_2_4h', 'aircondition_5_8h', 'aircondition_8h_plus'];
        if (Math.random() > 0.3) {
          var randomAirCondition = airConditionOptions[Math.floor(Math.random() * airConditionOptions.length)];
          $('input[name="' + randomAirCondition + '"]').prop('checked', true);
        }

        // 建議內容 - 隨機填寫
        var tonerSuggestions = ['麗蓓思朵化妝水', '保濕化妝水', '清爽型化妝水', '滋潤型化妝水'];
        var serumSuggestions = ['保濕亮采肌底液', '美白精華液', '抗老精華液', '修護精華液'];
        var suggestions = ['建議加強保濕護理', '建議使用防曬產品', '建議定期清潔', '建議溫和護膚'];
        
        if (Math.random() > 0.4) {
          $('input[name="toner_suggestion"]').val(tonerSuggestions[Math.floor(Math.random() * tonerSuggestions.length)]);
        }
        if (Math.random() > 0.4) {
          $('input[name="serum_suggestion"]').val(serumSuggestions[Math.floor(Math.random() * serumSuggestions.length)]);
        }
        if (Math.random() > 0.4) {
          $('input[name="suggestion_content"]').val(suggestions[Math.floor(Math.random() * suggestions.length)]);
        }

        // 肌膚類型 - 隨機選擇
        var skinTypes = ['normal', 'combination', 'oily', 'dry', 'sensitive'];
        if (Math.random() > 0.3) {
          var randomSkinType = skinTypes[Math.floor(Math.random() * skinTypes.length)];
          $('input[name="skin_type"][value="' + randomSkinType + '"]').prop('checked', true);
        }

        // 肌膚年齡 - 隨機填寫
        if (Math.random() > 0.4) {
          $('input[name="skin_age"]').val(20 + Math.floor(Math.random() * 30));
        }

        // 評分欄位 - 隨機填寫部分欄位
        var scoreCategories = ['moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore'];
        scoreCategories.forEach(function(category) {
          if (Math.random() > 0.4) { // 60%機率填寫這個類別
            var severeVal = Math.floor(Math.random() * 3);
            var warningVal = 3 + Math.floor(Math.random() * 4);
            var healthyVal = 7 + Math.floor(Math.random() * 3);
            
            $('input[name="' + category + '_severe"]').val(severeVal);
            $('input[name="' + category + '_warning"]').val(warningVal);
            $('input[name="' + category + '_healthy"]').val(healthyVal);
          }
        });

        // 睡眠狀況 - 隨機選擇
        var sleepOptions = ['sleep_9_10', 'sleep_11_12', 'sleep_after_1', 'sleep_other'];
        if (Math.random() > 0.3) {
          var randomSleep = sleepOptions[Math.floor(Math.random() * sleepOptions.length)];
          $('input[name="' + randomSleep + '"]').prop('checked', true);
          if (randomSleep === 'sleep_other' && Math.random() > 0.5) {
            $('input[name="sleep_other_text"]').val('不規律睡眠');
          }
        }

        // 現在使用產品 - 隨機選擇多個
        var products = ['product_honey_soap', 'product_mud_mask', 'product_toner', 'product_serum', 'product_premium', 'product_sunscreen', 'product_other'];
        products.forEach(function(product) {
          if (Math.random() > 0.6) { // 40%機率選中每個產品
            $('input[name="' + product + '"]').prop('checked', true);
            if (product === 'product_other' && Math.random() > 0.5) {
              $('input[name="product_other_text"]').val('其他保養品');
            }
          }
        });

        // 肌膚困擾 - 隨機選擇多個
        var skinIssues = ['skin_issue_elasticity', 'skin_issue_luster', 'skin_issue_dull', 'skin_issue_spots', 
                          'skin_issue_pores', 'skin_issue_acne', 'skin_issue_wrinkles', 'skin_issue_rough', 
                          'skin_issue_irritation', 'skin_issue_dry'];
        var selectedIssues = 0;
        skinIssues.forEach(function(issue) {
          if (Math.random() > 0.7 && selectedIssues < 5) { // 30%機率選中，最多選5個
            $('input[name="' + issue + '"]').prop('checked', true);
            selectedIssues++;
          }
        });

        // 過敏狀況 - 隨機選擇
        var allergyOptions = ['allergy_none', 'allergy_seasonal', 'allergy_food', 'allergy_cosmetics'];
        if (Math.random() > 0.4) {
          var randomAllergy = allergyOptions[Math.floor(Math.random() * allergyOptions.length)];
          $('input[name="' + randomAllergy + '"]').prop('checked', true);
        }

        // console.log('測試資料已隨機填入完成');
      }

      function showConfirmModal() {
        // 驗證必填欄位 - jQuery版本
        var memberName = '';
        
        // 檢查是否使用下拉選單 - 與提交邏輯一致
        if (isMultipleMembers && $('select[name="member_name_select"]').is(':visible')) {
          // 從下拉選單取值
          var selectedOption = $('select[name="member_name_select"]').find('option:selected');
          var selectedValue = selectedOption.val();
          var selectedDataName = selectedOption.data('name');
          var selectedText = selectedOption.text();
          
          // 驗證下拉選單資訊
          
          // 檢查是否選擇了實際的會員（不是預設的"請選擇會員"選項）
          if (selectedValue && selectedValue !== '' && selectedDataName) {
            memberName = selectedDataName;
          } else {
            memberName = ''; // 沒有選擇實際會員，視為空值
          }
        } else {
          // 從輸入框取值
          memberName = $('input[name="member_name"]').val();
        }
        
        var birthDate = $('input[name="birth_date"]').val();
        var phone = $('input[name="phone"]').val();

        var missingFields = [];
        if (!memberName) missingFields.push('會員姓名');
        if (!birthDate) missingFields.push('出生年月');
        if (!phone) missingFields.push('電話');
        
        // 為往後相容性，從年月中提取年月
        var birthYear = '', birthMonth = '';
        if (birthDate) {
          // 處理 YYYY-MM 格式
          var parts = birthDate.split('-');
          if (parts.length === 2) {
            birthYear = parseInt(parts[0]);
            birthMonth = parseInt(parts[1]);
            // 更新隱藏欄位以保持API相容性
            $('input[name="birth_year"]').val(birthYear);
            $('input[name="birth_month"]').val(birthMonth);
          }
        }

        if (missingFields.length > 0) {
          alert('請填寫以下必填欄位：\n' + missingFields.join('、'));
          return;
        }

        // 填入確認視窗的內容 - jQuery版本
        $('#confirm-member-name').text(memberName);
        // 顯示 YYYY-MM 格式為 "YYYY年MM月"
        var birthDateDisplay = '';
        if (birthDate) {
          var parts = birthDate.split('-');
          if (parts.length === 2) {
            birthDateDisplay = parts[0] + '年' + parts[1] + '月';
          }
        }
        $('#confirm-birth-date').text(birthDateDisplay || '(未填寫)');
        $('#confirm-phone').text(phone);

        // 職業選擇
        var occupations = [{
            name: 'occupation_service',
            label: '服務業'
          },
          {
            name: 'occupation_office',
            label: '上班族'
          },
          {
            name: 'occupation_restaurant',
            label: '餐飲業'
          },
          {
            name: 'occupation_housewife',
            label: '家管'
          }
        ];
        var checkedOccupations = [];

        $.each(occupations, function(index, item) {
          var $checkbox = $('input[name="' + item.name + '"]');
          if ($checkbox.length && $checkbox.is(':checked')) {
            checkedOccupations.push(item.label);
          }
        });

        if (checkedOccupations.length > 0) {
          $('#confirm-occupation').html('<span class="text-dark">' + checkedOccupations.join('、') + '</span>');
        } else {
          $('#confirm-occupation').html('<span class="text-muted">未選擇</span>');
        }

        // 戶外日曬時間
        var sunlightOptions = [{
            name: 'sunlight_1_2h',
            label: '1~2小時'
          },
          {
            name: 'sunlight_3_4h',
            label: '3~4小時'
          },
          {
            name: 'sunlight_5_6h',
            label: '5~6小時'
          },
          {
            name: 'sunlight_8h_plus',
            label: '8小時以上'
          }
        ];
        var checkedSunlight = [];

        $.each(sunlightOptions, function(index, item) {
          var $checkbox = $('input[name="' + item.name + '"]');
          if ($checkbox.length && $checkbox.is(':checked')) {
            checkedSunlight.push(item.label);
          }
        });

        $('#confirm-sunlight').html(checkedSunlight.length > 0 ?
          '<span class="text-dark">' + checkedSunlight.join('、') + '</span>' :
          '<span class="text-muted">未選擇</span>');

        // 空調環境時間
        var airconditionOptions = [{
            name: 'aircondition_1h',
            label: '1小時內'
          },
          {
            name: 'aircondition_2_4h',
            label: '2~4小時'
          },
          {
            name: 'aircondition_5_8h',
            label: '5~8小時'
          },
          {
            name: 'aircondition_8h_plus',
            label: '8小時以上'
          }
        ];
        var checkedAircondition = [];

        $.each(airconditionOptions, function(index, item) {
          var $checkbox = $('input[name="' + item.name + '"]');
          if ($checkbox.length && $checkbox.is(':checked')) {
            checkedAircondition.push(item.label);
          }
        });

        $('#confirm-aircondition').html(checkedAircondition.length > 0 ?
          '<span class="text-dark">' + checkedAircondition.join('、') + '</span>' :
          '<span class="text-muted">未選擇</span>');

        // 建議內容 - jQuery版本
        var tonerSuggestion = $('input[name="toner_suggestion"]').val();
        $('#confirm-toner-suggestion').text(tonerSuggestion || '(未填寫)');

        var serumSuggestion = $('input[name="serum_suggestion"]').val();
        $('#confirm-serum-suggestion').text(serumSuggestion || '(未填寫)');

        var suggestionContent = $('input[name="suggestion_content"]').val();
        $('#confirm-suggestion-content').text(suggestionContent || '(未填寫)');

        // 肌膚類型 - jQuery版本
        var skinTypeValue = $('input[name="skin_type"]:checked').val();
        var skinTypeLabels = {
          'normal': '中性',
          'combination': '混合性',
          'oily': '油性',
          'dry': '乾性',
          'sensitive': '敏感性'
        };
        $('#confirm-skin-type').text(
          skinTypeValue ? (skinTypeLabels[skinTypeValue] || skinTypeValue) : '(未選擇)'
        );

        // 肌膚年齡 - jQuery版本
        var skinAge = $('input[name="skin_age"]').val();
        $('#confirm-skin-age').text(
          skinAge ? skinAge + '歲' : '(未填寫)'
        );

        // 顯示模態視窗
        $('#confirmModal').modal('show');
      }

      function submitForm() {
        
        // 收集表單資料
        var memberName = '';
        var memberId = '';
        var formFillerID = '<?php echo $userdata['c_no'];?>'; // 代填問卷者（當前登入使用者）
        var formFillerName = '<?php echo $userdata['c_name'];?>'; // 代填問卷者姓名
        
        // 根據是否為多重會員選擇不同的取值方式
        if (isMultipleMembers && $('select[name="member_name_select"]').is(':visible')) {
          // 使用下拉選單的值 - 只取姓名，不取會員編號
          var selectedOption = $('select[name="member_name_select"]').find('option:selected');
          var selectedValue = selectedOption.val();
          var selectedDataName = selectedOption.data('name');
          
          // 提交時驗證下拉選單資訊
          
          // 確保選擇了有效的會員
          if (selectedValue && selectedValue !== '' && selectedDataName) {
            memberId = selectedValue; // 被填表人編號（僅用於顯示，不送出）
            memberName = selectedDataName; // 被填表人姓名
          } else {
            // 沒有選擇有效會員，使用空值
            memberId = '';
            memberName = '';
          }
        } else {
          // 使用輸入框和當前會員資料
          memberId = currentUserData.member_id;
          memberName = $('input[name="member_name"]').val();
        }
        
        var formData = {
          // 使用者識別資訊
          member_id: memberId, // 保留欄位但可能為空（相容性）
          member_name: memberName, // 被填表人姓名
          form_filler_id: formFillerID, // 代填問卷者ID（當前登入使用者）
          form_filler_name: formFillerName, // 代填問卷者姓名
          birth_date: $('input[name="birth_date"]').val(),
          birth_year: $('input[name="birth_year"]').val(), // 從日期提取的年份
          birth_month: $('input[name="birth_month"]').val(), // 從日期提取的月份
          phone: $('input[name="phone"]').val(),
          
          // 職業選擇
          occupation_service: $('input[name="occupation_service"]').is(':checked') ? 1 : 0,
          occupation_office: $('input[name="occupation_office"]').is(':checked') ? 1 : 0,
          occupation_restaurant: $('input[name="occupation_restaurant"]').is(':checked') ? 1 : 0,
          occupation_housewife: $('input[name="occupation_housewife"]').is(':checked') ? 1 : 0,
          
          // 戶外日曬時間
          sunlight_1_2h: $('input[name="sunlight_1_2h"]').is(':checked') ? 1 : 0,
          sunlight_3_4h: $('input[name="sunlight_3_4h"]').is(':checked') ? 1 : 0,
          sunlight_5_6h: $('input[name="sunlight_5_6h"]').is(':checked') ? 1 : 0,
          sunlight_8h_plus: $('input[name="sunlight_8h_plus"]').is(':checked') ? 1 : 0,
          
          // 空調環境時間
          aircondition_1h: $('input[name="aircondition_1h"]').is(':checked') ? 1 : 0,
          aircondition_2_4h: $('input[name="aircondition_2_4h"]').is(':checked') ? 1 : 0,
          aircondition_5_8h: $('input[name="aircondition_5_8h"]').is(':checked') ? 1 : 0,
          aircondition_8h_plus: $('input[name="aircondition_8h_plus"]').is(':checked') ? 1 : 0,
          
          // 睡眠狀況
          sleep_9_10: $('input[name="sleep_9_10"]').is(':checked') ? 1 : 0,
          sleep_11_12: $('input[name="sleep_11_12"]').is(':checked') ? 1 : 0,
          sleep_after_1: $('input[name="sleep_after_1"]').is(':checked') ? 1 : 0,
          sleep_other: $('input[name="sleep_other"]').is(':checked') ? 1 : 0,
          sleep_other_text: $('input[name="sleep_other_text"]').val(),
          
          // 現在使用產品
          product_honey_soap: $('input[name="product_honey_soap"]').is(':checked') ? 1 : 0,
          product_mud_mask: $('input[name="product_mud_mask"]').is(':checked') ? 1 : 0,
          product_toner: $('input[name="product_toner"]').is(':checked') ? 1 : 0,
          product_serum: $('input[name="product_serum"]').is(':checked') ? 1 : 0,
          product_premium: $('input[name="product_premium"]').is(':checked') ? 1 : 0,
          product_sunscreen: $('input[name="product_sunscreen"]').is(':checked') ? 1 : 0,
          product_other: $('input[name="product_other"]').is(':checked') ? 1 : 0,
          product_other_text: $('input[name="product_other_text"]').val(),
          
          // 肌膚困擾
          skin_issue_elasticity: $('input[name="skin_issue_elasticity"]').is(':checked') ? 1 : 0,
          skin_issue_luster: $('input[name="skin_issue_luster"]').is(':checked') ? 1 : 0,
          skin_issue_dull: $('input[name="skin_issue_dull"]').is(':checked') ? 1 : 0,
          skin_issue_spots: $('input[name="skin_issue_spots"]').is(':checked') ? 1 : 0,
          skin_issue_pores: $('input[name="skin_issue_pores"]').is(':checked') ? 1 : 0,
          skin_issue_acne: $('input[name="skin_issue_acne"]').is(':checked') ? 1 : 0,
          skin_issue_wrinkles: $('input[name="skin_issue_wrinkles"]').is(':checked') ? 1 : 0,
          skin_issue_rough: $('input[name="skin_issue_rough"]').is(':checked') ? 1 : 0,
          skin_issue_irritation: $('input[name="skin_issue_irritation"]').is(':checked') ? 1 : 0,
          skin_issue_dry: $('input[name="skin_issue_dry"]').is(':checked') ? 1 : 0,
          skin_issue_makeup: $('input[name="skin_issue_makeup"]').is(':checked') ? 1 : 0,
          skin_issue_other: $('input[name="skin_issue_other"]').is(':checked') ? 1 : 0,
          skin_issue_other_text: $('input[name="skin_issue_other_text"]').val(),
          
          // 過敏狀況
          allergy_frequent: $('input[name="allergy_frequent"]').is(':checked') ? 1 : 0,
          allergy_seasonal: $('input[name="allergy_seasonal"]').is(':checked') ? 1 : 0,
          allergy_never: $('input[name="allergy_never"]').is(':checked') ? 1 : 0,
          
          // 建議內容
          toner_suggestion: $('input[name="toner_suggestion"]').val(),
          serum_suggestion: $('input[name="serum_suggestion"]').val(),
          suggestion_content: $('input[name="suggestion_content"]').val(),
          
          // 肌膚類型
          skin_type: $('input[name="skin_type"]:checked').val(),
          skin_age: $('input[name="skin_age"]').val(),
          
          // 各種評分資料
          moisture_severe: $('input[name="moisture_severe"]').val(),
          moisture_warning: $('input[name="moisture_warning"]').val(),
          moisture_healthy: $('input[name="moisture_healthy"]').val(),
          
          // 膚色評分
          complexion_severe: $('input[name="complexion_severe"]').val(),
          complexion_warning: $('input[name="complexion_warning"]').val(),
          complexion_healthy: $('input[name="complexion_healthy"]').val(),
          
          // 紋理評分
          texture_severe: $('input[name="texture_severe"]').val(),
          texture_warning: $('input[name="texture_warning"]').val(),
          texture_healthy: $('input[name="texture_healthy"]').val(),
          
          // 敏感評分
          sensitivity_severe: $('input[name="sensitivity_severe"]').val(),
          sensitivity_warning: $('input[name="sensitivity_warning"]').val(),
          sensitivity_healthy: $('input[name="sensitivity_healthy"]').val(),
          
          // 油脂評分
          oil_severe: $('input[name="oil_severe"]').val(),
          oil_warning: $('input[name="oil_warning"]').val(),
          oil_healthy: $('input[name="oil_healthy"]').val(),
          
          // 色素評分
          pigment_severe: $('input[name="pigment_severe"]').val(),
          pigment_warning: $('input[name="pigment_warning"]').val(),
          pigment_healthy: $('input[name="pigment_healthy"]').val(),
          
          // 皺紋評分
          wrinkle_severe: $('input[name="wrinkle_severe"]').val(),
          wrinkle_warning: $('input[name="wrinkle_warning"]').val(),
          wrinkle_healthy: $('input[name="wrinkle_healthy"]').val(),
          
          // 毛孔評分
          pore_severe: $('input[name="pore_severe"]').val(),
          pore_warning: $('input[name="pore_warning"]').val(),
          pore_healthy: $('input[name="pore_healthy"]').val()
        };

        // 發送API請求
        $.ajax({
          url: '<?php echo base_url("api/eeform1/submit"); ?>',
          method: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          dataType: 'json',
          beforeSend: function() {
            // 顯示載入狀態
            $('#confirmModal .modal-footer button').prop('disabled', true);
            $('#confirmModal .modal-footer button').text('提交中...');
          },
          success: function(response) {
            if (response.success) {
              Swal.fire({
                title: '提交成功！',
                text: '肌膚諮詢記錄表已成功提交，1.5秒後自動返回列表頁面',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
              }).then(() => {
                $('#confirmModal').modal('hide');
                // 直接跳轉到 eform1_list 頁面
                window.location.href = '<?php echo base_url("eform/eform1_list"); ?>';
              });
            } else {
              Swal.fire({
                title: '提交失敗',
                text: '提交失敗：' + response.message,
                icon: 'error',
                confirmButtonText: '確定'
              });
            }
          },
          error: function(xhr, status, error) {
            // console.error('提交失敗:', error);
            Swal.fire({
              title: '提交失敗',
              text: '網絡錯誤，請稍後再試',
              icon: 'error',
              confirmButtonText: '確定'
            });
          },
          complete: function() {
            // 恢復按鈕狀態
            $('#confirmModal .modal-footer button').prop('disabled', false);
            $('#confirmModal .modal-footer button').text('確認送出');
          }
        });
      }
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?= base_url(); ?>views/eeform/js/jquery.min.js"><\/script>')</script>
    <script src="<?= base_url(); ?>views/eeform/js/smoothscroll.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/animsition.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/owl.carousel.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/wow.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/jquery.pagepiling.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/isotope.pkgd.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/jquery.fancybox.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/TweenMax.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/ScrollMagic.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/animation.gsap.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/jquery.viewport.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/jquery.countdown.min.js"></script>
    <script src="<?= base_url(); ?>views/eeform/js/script.js"></script>

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
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          return false;
        });

      });
      /*Scroll to top when arrow up clicked END*/
    </script>

  </body>

  </html>