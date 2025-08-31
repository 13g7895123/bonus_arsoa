  <style>
    /* Enhanced styling for occupation and health concerns sections */
    .section-highlight {
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .section-highlight .card-body {
      padding: 1rem;
    }
    
    .section-title {
      font-size: 1.1rem;
      font-weight: bold;
      color: #495057;
      margin-bottom: 15px;
      display: block;
    }
    
    .form-check-inline {
      margin-right: 25px;
      margin-bottom: 10px;
      display: inline-flex;
      align-items: center;
    }
    
    .form-check-input {
      width: 18px;
      height: 18px;
      margin-right: 8px;
      cursor: pointer;
    }
    
    .form-check-label {
      font-size: 16px;
      color: #495057;
      cursor: pointer;
      margin-bottom: 0;
      line-height: 1.2;
    }
    
    .form-check-label:hover {
      color: #007bff;
    }
    
    /* Ensure card styling is consistent */
    .card.bg-light {
      background-color: #f8f9fa !important;
      border: 1px solid #e9ecef;
      border-radius: 8px;
    }
    
    .mb20 {
      margin-bottom: 20px;
    }
  </style>
  
  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?= $this->block_service->load_html_header(); ?>
        <div class="section-mini">
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>健康諮詢表</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="#" method="POST" class="text-left" id="eform05">
                        <div class="row">
                          <div class="col-sm-12 text-right mb30">填寫日期：<span id="current-date"></span></div>

                          <div class="col-sm-3 mb30">
                            <label class="label-custom">會員姓名</label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填會員姓名" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">會員編號</label>
                            <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="<?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : ''; ?>" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">出生年月</label>
                            <input type="month" name="birth_date" class="form-control form-control-custom" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">身高(公分)</label>
                            <input type="number" name="height" class="form-control form-control-custom" placeholder="限填數字" required />
                          </div>

                          <div class="col-sm-12 mb30">
                            <div class="card bg-light">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <p class="mb-0"><strong>職業（可複選）：</strong></p>
                                  </div>
                                  <div class="row mb20">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="occupation[]" id="occupation_service" value="服務業">
                                      <label class="form-check-label" for="occupation_service">服務業 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="occupation[]" id="occupation_office" value="上班族">
                                      <label class="form-check-label" for="occupation_office">上班族 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="occupation[]" id="occupation_food" value="餐飲業">
                                      <label class="form-check-label" for="occupation_food">餐飲業 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="occupation[]" id="occupation_freelance" value="自由業">
                                      <label class="form-check-label" for="occupation_freelance">自由業 </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">長期使用藥物習慣：
                              <input class="form-check-input" type="radio" name="has_medication_habit" id="medication_yes" value="1">
                              <label class="form-check-label" for="medication_yes">有 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="has_medication_habit" id="medication_no" value="0">
                              <label class="form-check-label" for="medication_no">無 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label">使用藥物： </label>
                              <input type="text" name="medication_name">
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">有無家族慢性病史：
                              <input class="form-check-input" type="radio" name="has_family_disease_history" id="disease_yes" value="1">
                              <label class="form-check-label" for="disease_yes">有 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="has_family_disease_history" id="disease_no" value="0">
                              <label class="form-check-label" for="disease_no">無 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <label class="form-check-label">疾病名稱： </label>
                              <input type="text" name="disease_name">
                            </div>
                          </div>

                          <div class="col-sm-12 mb50">
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <p class="mb-0"><strong>健康困擾（可複選）：</strong></p>
                                  </div>
                                  <div class="row mb30">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_headache" value="經常頭痛">
                                      <label class="form-check-label" for="health_headache">經常頭痛 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_allergy" value="過敏問題">
                                      <label class="form-check-label" for="health_allergy">過敏問題 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_sleep" value="睡眠不佳">
                                      <label class="form-check-label" for="health_sleep">睡眠不佳 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_joints" value="骨關節問題">
                                      <label class="form-check-label" for="health_joints">骨關節問題 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_three_high" value="三高問題">
                                      <label class="form-check-label" for="health_three_high">三高問題(血糖/血脂肪/血壓) </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_digestive" value="腸胃健康問題">
                                      <label class="form-check-label" for="health_digestive">腸胃健康問題 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_vision" value="視力問題">
                                      <label class="form-check-label" for="health_vision">視力問題 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_immunity" value="免疫力">
                                      <label class="form-check-label" for="health_immunity">免疫力 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_weight" value="體重困擾">
                                      <label class="form-check-label" for="health_weight">體重困擾 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_concerns[]" id="health_other_check" value="其他">
                                      <label class="form-check-label" for="health_other_check">其他： </label>
                                      <input type="text" name="health_concerns_other">
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">微循環檢測:</label>
                            <input type="text" name="microcirculation_test" class="form-control form-control-custom" placeholder="" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">日常飲食建議:</label>
                            <input type="text" name="dietary_advice" class="form-control form-control-custom" placeholder="" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <p class="label-custom mb20">每日建議產品&攝取量:</p>
                            <div class="row">
                              <div class="col-sm-12 mb20">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="recommended_products[]" id="product_energy_essence" value="活力精萃">
                                  <label class="form-check-label" for="product_energy_essence">活力精萃： </label>
                                  <input type="text" name="energy_essence_dosage" placeholder="請填建議用量…">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 mb20">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="recommended_products[]" id="product_reishi_ex" value="白鶴靈芝EX">
                                  <label class="form-check-label" for="product_reishi_ex">白鶴靈芝EX： </label>
                                  <input type="text" name="reishi_ex_dosage" placeholder="請填建議用量…">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 mb20">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="recommended_products[]" id="product_vitamin_c" value="美力C錠">
                                  <label class="form-check-label" for="product_vitamin_c">美力C錠： </label>
                                  <input type="text" name="vitamin_c_dosage" placeholder="請填建議用量…">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 mb20">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="recommended_products[]" id="product_energy_crystal" value="鶴力晶">
                                  <label class="form-check-label" for="product_energy_crystal">鶴力晶： </label>
                                  <input type="text" name="energy_crystal_dosage" placeholder="請填建議用量…">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 mb20">
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="recommended_products[]" id="product_reishi_tea" value="白鶴靈芝茶">
                                  <label class="form-check-label" for="product_reishi_tea">白鶴靈芝茶： </label>
                                  <input type="text" name="reishi_tea_dosage" placeholder="請填建議用量…">
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
                  <!-- 側邊欄清單 -->
                  <?= $this->block_service->electronic_form_right_menu('eform5'); ?>
                </aside>
              </div>
            </div>
          </div>

        </div>


      </div>

      <?= $this->block_service->load_html_footer(); ?>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
        // 自動填入當天日期
        var today = new Date();
        var currentDate = today.getFullYear() + '-' + 
                         String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                         String(today.getDate()).padStart(2, '0');
        
        $('#current-date').text(currentDate);
        
        if (showTestButton) $('#testDataButton').show();
        
        $("#back2Top").click(function(event) {
          event.preventDefault();
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          return false;
        });

      });
      /*Scroll to top when arrow up clicked END*/
      
      // 控制測試按鈕顯示的變數
      var showTestButton = true;
      
      // 填入測試資料的函數
      function fillTestData() {
        // 只在用戶資料為空時填入測試資料
        if (!$('input[name="member_name"]').val()) {
          $('input[name="member_name"]').val('測試會員');
        }
        if (!$('input[name="member_id"]').val()) {
          $('input[name="member_id"]').val('TEST001');
        }
        $('input[name="birth_date"]').val('1990-01');
        $('input[name="height"]').val('170');
        
        // 職業選項測試資料（可多選）
        $('input[name="occupation[]"][value="服務業"]').prop('checked', true);
        $('input[name="occupation[]"][value="上班族"]').prop('checked', true);
        
        // 藥物習慣測試資料
        $('input[name="has_medication_habit"][value="1"]').prop('checked', true);
        $('input[name="medication_name"]').val('測試藥物名稱');
        
        // 家族病史測試資料
        $('input[name="has_family_disease_history"][value="1"]').prop('checked', true);
        $('input[name="disease_name"]').val('測試疾病名稱'); 
        
        // 健康困擾測試資料
        $('input[name="health_concerns[]"][value="經常頭痛"]').prop('checked', true);
        $('input[name="health_concerns[]"][value="睡眠不佳"]').prop('checked', true);
        $('input[name="health_concerns[]"][value="免疫力"]').prop('checked', true);
        $('input[name="health_concerns[]"][value="其他"]').prop('checked', true);
        $('input[name="health_concerns_other"]').val('其他健康問題描述');
        
        // 產品推薦測試資料
        $('input[name="recommended_products[]"][value="活力精萃"]').prop('checked', true);
        $('input[name="energy_essence_dosage"]').val('每日1-2包，餐前30分鐘');
        $('input[name="recommended_products[]"][value="白鶴靈芝EX"]').prop('checked', true);
        $('input[name="reishi_ex_dosage"]').val('每日2-3粒，餐後服用');
        $('input[name="recommended_products[]"][value="美力C錠"]').prop('checked', true);
        $('input[name="vitamin_c_dosage"]').val('每日1-2錠，飯後服用');
        
        $('input[name="microcirculation_test"]').val('測試微循環檢測結果');
        $('input[name="dietary_advice"]').val('測試日常飲食建議');
      }
      
      function showConfirmModal() {
        // Basic validation
        var memberName = $('input[name="member_name"]').val();
        var memberId = $('input[name="member_id"]').val();
        var birthDate = $('input[name="birth_date"]').val();
        var height = $('input[name="height"]').val();

        if (!memberName || !memberId || !birthDate || !height) {
          Swal.fire({
            title: '欄位未完整',
            text: '請填寫所有必填欄位',
            icon: 'warning',
            confirmButtonText: '確定'
          });
          return;
        }

        submitForm();
      }

      function submitForm() {
        // Collect occupation data
        var occupations = [];
        $('input[name="occupation[]"]:checked').each(function() {
          occupations.push($(this).val());
        });

        // Collect health concerns data
        var healthConcerns = [];
        $('input[name="health_concerns[]"]:checked').each(function() {
          healthConcerns.push($(this).val());
        });

        // Collect recommended products data
        var recommendedProducts = [];
        $('input[name="recommended_products[]"]:checked').each(function() {
          recommendedProducts.push($(this).val());
        });

        var formData = {
          member_name: $('input[name="member_name"]').val(),
          member_id: $('input[name="member_id"]').val(),
          birth_date: $('input[name="birth_date"]').val(),
          height: $('input[name="height"]').val(),
          occupation: occupations,
          has_medication_habit: $('input[name="has_medication_habit"]:checked').val() || '0',
          medication_name: $('input[name="medication_name"]').val(),
          has_family_disease_history: $('input[name="has_family_disease_history"]:checked').val() || '0',
          disease_name: $('input[name="disease_name"]').val(),
          health_concerns: healthConcerns,
          health_concerns_other: $('input[name="health_concerns_other"]').val(),
          recommended_products: recommendedProducts,
          energy_essence_dosage: $('input[name="energy_essence_dosage"]').val(),
          reishi_ex_dosage: $('input[name="reishi_ex_dosage"]').val(),
          vitamin_c_dosage: $('input[name="vitamin_c_dosage"]').val(),
          energy_crystal_dosage: $('input[name="energy_crystal_dosage"]').val(),
          reishi_tea_dosage: $('input[name="reishi_tea_dosage"]').val(),
          microcirculation_test: $('input[name="microcirculation_test"]').val(),
          dietary_advice: $('input[name="dietary_advice"]').val()
        };

        $.ajax({
          url: '<?php echo base_url("api/eeform5/submit"); ?>',
          method: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              Swal.fire({
                title: '提交成功！',
                text: '表單已成功提交，1.5秒後自動返回列表頁面',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
              }).then(() => {
                history.go(0);
              });
            } else {
              Swal.fire({
                title: '提交失敗',
                text: '提交失敗：' + (response.message || '未知錯誤'),
                icon: 'error',
                confirmButtonText: '確定'
              });
            }
          },
          error: function(xhr, status, error) {
            Swal.fire({
              title: '提交錯誤',
              text: '提交失敗，請稍後再試',
              icon: 'error',
              confirmButtonText: '確定'
            });
          }
        });
      }
    </script>

  </body>

  </html>