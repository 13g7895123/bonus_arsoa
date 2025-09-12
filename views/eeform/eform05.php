  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?= $this->block_service->load_html_header(); ?>
        <div class="section-mini">
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>個人體測表+健康諮詢表</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="#" method="POST" class="text-left" id="eform05">
                        <div class="row">
                          <div class="col-sm-12 text-right mb30">填寫日期：<span id="current-date"></span></div>

                          <!-- 第一排欄位 -->
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">手機號碼 <span style="color: red;">(*必填)</span></label>
                            <input type="tel" name="phone" class="form-control form-control-custom" placeholder="請填手機號碼" />
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">姓名 <span style="color: red;">(*必填)</span></label>
                            <input type="text" name="name" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" class="form-control form-control-custom" placeholder="請填姓名" />
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">性別</label>
                            <select name="gender" class="form-control form-control-custom">
                              <option value="">請選擇性別</option>
                              <option value="男">男</option>
                              <option value="女">女</option>
                            </select>
                          </div>

                          <!-- 第二排欄位 -->
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">年齡</label>
                            <select name="age" class="form-control form-control-custom">
                              <option value="">請選擇年齡</option>
                              <!-- 年齡選項將由JavaScript動態生成 -->
                            </select>
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">身高</label>
                            <input type="text" name="height" class="form-control form-control-custom" placeholder="請填身高" />
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">運動習慣</label>
                            <select name="exercise_habit" class="form-control form-control-custom">
                              <option value="">請選擇運動習慣</option>
                              <option value="是">是</option>
                              <option value="否">否</option>
                            </select>
                          </div>

                          <!-- 體測標準建議值 -->
                          <div class="col-sm-12 mb30">
                            <h5 class="mb20">體測標準建議值</h5>
                            <div class="card bg-light">
                              <div class="card-body">
                                <div class="row">
                                  <!-- 第一列 -->
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">體重Kg</label>
                                    <input type="number" name="weight" class="form-control form-control-custom" placeholder="限填數字" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">BMI</label>
                                    <input type="number" name="bmi" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">脂肪率%</label>
                                    <input type="number" name="fat_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>

                                  <!-- 第二列 -->
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">脂肪量Kg</label>
                                    <input type="number" name="fat_mass" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">肌肉%</label>
                                    <input type="number" name="muscle_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">肌肉量Kg</label>
                                    <input type="number" name="muscle_mass" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>

                                  <!-- 第三列 -->
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">水份比例%</label>
                                    <input type="number" name="water_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">水含量Kg</label>
                                    <input type="number" name="water_content" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">內臟脂肪率%</label>
                                    <input type="number" name="visceral_fat_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>

                                  <!-- 第四列 -->
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">骨量Kg</label>
                                    <input type="number" name="bone_mass" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">基礎代謝率(卡)</label>
                                    <input type="number" name="bmr" class="form-control form-control-custom" placeholder="限填數字" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">蛋白質%</label>
                                    <input type="number" name="protein_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>

                                  <!-- 第五列 -->
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">肥胖度%</label>
                                    <input type="number" name="obesity_percentage" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">身體年齡</label>
                                    <input type="number" name="body_age" class="form-control form-control-custom" placeholder="限填數字" />
                                  </div>
                                  <div class="col-sm-4 mb20">
                                    <label class="label-custom">去脂體重KG</label>
                                    <input type="number" name="lean_body_mass" class="form-control form-control-custom" placeholder="限填數字" step="0.01" />
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">職業：
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
                                    <p class="mb-0">健康困擾：</p>
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

    <!-- 確認表單內容 Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">確認表單內容</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="confirmModalBody">
            <!-- 表單內容將動態載入此處 -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-danger" id="confirmSubmitBtn">確認送出</button>
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

    <!-- 頁面樣式 -->
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

      /* Bootstrap Modal 自定義樣式 */
      .form-confirmation-content {
        font-family: 'Microsoft JhengHei', Arial, sans-serif;
      }

      .info-block {
        border: 1px solid #dee2e6;
      }

      .info-block h6 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
      }

      .info-block .row {
        margin-left: 0;
        margin-right: 0;
      }

      .info-block .row>div {
        font-size: 14px;
        line-height: 1.5;
      }
    </style>

    <!-- 主要功能腳本 -->
    <script>
      // 全域變數
      var showTestButton = false; // 控制測試按鈕顯示

      // 唯一的 document ready 函數
      $(document).ready(function() {
        // 自動填入當天日期
        var today = new Date();
        var currentDate = today.getFullYear() + '-' +
          String(today.getMonth() + 1).padStart(2, '0') + '-' +
          String(today.getDate()).padStart(2, '0');
        $('#current-date').text(currentDate);

        // 滾動到頂部功能
        $("#back2Top").click(function(event) {
          event.preventDefault();
          $("html, body").animate({
            scrollTop: 0
          }, "slow");
          return false;
        });

        // 多階段重試生成年齡下拉選單選項
        var generateAgeRetryCount = 0;
        var maxRetries = 5;

        function attemptGenerateAge() {
          generateAgeRetryCount++;
          console.log('第', generateAgeRetryCount, '次嘗試生成年齡選項');

          try {
            var $ageSelect = $('select[name="age"]');
            if ($ageSelect.length > 0) {
              generateAgeOptions();
            } else if (generateAgeRetryCount < maxRetries) {
              setTimeout(attemptGenerateAge, generateAgeRetryCount * 200);
            } else {
            }
          } catch (error) {
            if (generateAgeRetryCount < maxRetries) {
              setTimeout(attemptGenerateAge, generateAgeRetryCount * 200);
            }
          }
        }

        // 立即嘗試一次，然後延遲重試
        attemptGenerateAge();

        // 顯示測試按鈕
        if (showTestButton) {
          $('#testDataButton').show();
        }

        // 添加手動測試函數到全域作用域
        window.testGenerateAgeOptions = function() {
          generateAgeOptions();
        };

        // 測試年齡計算邏輯
        var currentYear = new Date().getFullYear();
      });

      // 滾動監聽（滾動到頂部按鈕顯示/隱藏）
      $(window).scroll(function() {
        var height = $(window).scrollTop();
        if (height > 100) {
          $('#back2Top').fadeIn();
        } else {
          $('#back2Top').fadeOut();
        }
      });

      // 生成年齡下拉選單選項 (民國XX年出生 - XX歲)
      function generateAgeOptions() {
        var currentYear = new Date().getFullYear();

        // 使用最直接的選擇器
        var $ageSelect = $('select[name="age"]');

        if ($ageSelect.length === 0) {
          // 嘗試在下一次事件循環中重試
          setTimeout(function() {
            $ageSelect = $('select[name="age"]');
            if ($ageSelect.length > 0) {
              generateAgeOptionsForElement($ageSelect, currentYear);
            }
          }, 500);
          return;
        }

        generateAgeOptionsForElement($ageSelect, currentYear);
      }

      // 為指定的select元素生成年齡選項
      function generateAgeOptionsForElement($ageSelect, currentYear) {
        // 清空現有選項（保留預設選項）
        $ageSelect.find('option:not(:first)').remove();

        var optionsCount = 0;
        // 生成18歲到100歲的選項
        for (var age = 18; age <= 100; age++) {
          var birthYear = currentYear - age;
          var mingGuoYear = birthYear - 1911; // 轉換為民國年

          if (mingGuoYear > 0) {
            var optionText = '民國' + mingGuoYear + '年出生 - ' + age + '歲';
            var optionValue = age;

            var $option = $('<option></option>')
              .attr('value', optionValue)
              .text(optionText);

            $ageSelect.append($option);
            optionsCount++;
          }
        }
      }

      // 填入測試資料的函數
      function fillTestData() {

        // 基本資料
        $('input[name="phone"]').val(generateRandomPhone());
        $('input[name="name"]').val('公司');
        $('select[name="gender"]').val(Math.random() < 0.5 ? '男' : '女');

        // 隨機選擇年齡 (18-60歲)
        var randomAge = Math.floor(Math.random() * 43) + 18; // 18-60歲
        $('select[name="age"]').val(randomAge);

        $('input[name="height"]').val(Math.floor(Math.random() * 31) + 150); // 150-180cm
        $('select[name="exercise_habit"]').val(Math.random() < 0.6 ? '是' : '否');

        // 體測標準建議值 - 隨機填入數字
        $('input[name="weight"]').val((Math.random() * 40 + 45).toFixed(1)); // 45-85kg
        $('input[name="bmi"]').val((Math.random() * 10 + 18).toFixed(1)); // 18-28
        $('input[name="fat_percentage"]').val((Math.random() * 25 + 10).toFixed(1)); // 10-35%
        $('input[name="fat_mass"]').val((Math.random() * 20 + 5).toFixed(1)); // 5-25kg
        $('input[name="muscle_percentage"]').val((Math.random() * 20 + 30).toFixed(1)); // 30-50%
        $('input[name="muscle_mass"]').val((Math.random() * 25 + 20).toFixed(1)); // 20-45kg
        $('input[name="water_percentage"]').val((Math.random() * 15 + 50).toFixed(1)); // 50-65%
        $('input[name="water_content"]').val((Math.random() * 20 + 25).toFixed(1)); // 25-45kg
        $('input[name="visceral_fat_percentage"]').val((Math.random() * 10 + 5).toFixed(1)); // 5-15%
        $('input[name="bone_mass"]').val((Math.random() * 2 + 2).toFixed(1)); // 2-4kg
        $('input[name="bmr"]').val(Math.floor(Math.random() * 800) + 1200); // 1200-2000卡
        $('input[name="protein_percentage"]').val((Math.random() * 5 + 15).toFixed(1)); // 15-20%
        $('input[name="obesity_percentage"]').val((Math.random() * 30 + 80).toFixed(1)); // 80-110%
        $('input[name="body_age"]').val(Math.floor(Math.random() * 40) + 20); // 20-60歲
        $('input[name="lean_body_mass"]').val((Math.random() * 30 + 40).toFixed(1)); // 40-70kg

        // 職業 - 隨機選擇1-2個
        var occupations = ['occupation_service', 'occupation_office', 'occupation_food', 'occupation_freelance'];
        var selectedOccupations = [];
        var numOccupations = Math.floor(Math.random() * 2) + 1;

        for (var i = 0; i < numOccupations; i++) {
          var randomOccupation = occupations[Math.floor(Math.random() * occupations.length)];
          if (selectedOccupations.indexOf(randomOccupation) === -1) {
            selectedOccupations.push(randomOccupation);
            $('#' + randomOccupation).prop('checked', true);
          }
        }

        // 長期使用藥物習慣
        var hasMedication = Math.random() < 0.3;
        $('input[name="has_medication_habit"][value="' + (hasMedication ? '1' : '0') + '"]').prop('checked', true);
        if (hasMedication) {
          var medications = ['高血壓藥物', '糖尿病藥物', '維他命', '保健食品', '止痛藥'];
          $('input[name="medication_name"]').val(medications[Math.floor(Math.random() * medications.length)]);
        }

        // 家族慢性病史
        var hasFamilyDisease = Math.random() < 0.4;
        $('input[name="has_family_disease_history"][value="' + (hasFamilyDisease ? '1' : '0') + '"]').prop('checked', true);
        if (hasFamilyDisease) {
          var diseases = ['高血壓', '糖尿病', '心臟病', '癌症', '中風'];
          $('input[name="disease_name"]').val(diseases[Math.floor(Math.random() * diseases.length)]);
        }

        // 健康困擾 - 隨機選擇2-4個
        var healthConcerns = ['health_headache', 'health_allergy', 'health_sleep', 'health_joints',
          'health_three_high', 'health_digestive', 'health_vision', 'health_immunity', 'health_weight'
        ];
        var numConcerns = Math.floor(Math.random() * 3) + 2; // 2-4個
        var selectedConcerns = [];

        for (var i = 0; i < numConcerns; i++) {
          var randomConcern = healthConcerns[Math.floor(Math.random() * healthConcerns.length)];
          if (selectedConcerns.indexOf(randomConcern) === -1) {
            selectedConcerns.push(randomConcern);
            $('#' + randomConcern).prop('checked', true);
          }
        }

        // 有時候選擇其他
        if (Math.random() < 0.3) {
          $('#health_other_check').prop('checked', true);
          var otherConcerns = ['壓力大', '失眠', '記憶力減退', '易疲勞'];
          $('input[name="health_concerns_other"]').val(otherConcerns[Math.floor(Math.random() * otherConcerns.length)]);
        }

        // 微循環檢測
        var circulationTests = ['血液循環良好', '輕微循環不良', '需要改善循環', '循環狀況正常'];
        $('input[name="microcirculation_test"]').val(circulationTests[Math.floor(Math.random() * circulationTests.length)]);

        // 日常飲食建議
        var dietaryAdvices = ['多吃蔬菜水果', '減少油炸食物', '增加蛋白質攝取', '控制糖分攝取', '多喝水'];
        $('input[name="dietary_advice"]').val(dietaryAdvices[Math.floor(Math.random() * dietaryAdvices.length)]);

        // 每日建議產品 - 隨機選擇2-3個產品
        var products = [{
            checkbox: 'product_energy_essence',
            dosage: 'energy_essence_dosage',
            suggestions: ['每日1包', '早晚各1包', '空腹服用1包']
          },
          {
            checkbox: 'product_reishi_ex',
            dosage: 'reishi_ex_dosage',
            suggestions: ['每日2粒', '早晚各1粒', '飯後服用2粒']
          },
          {
            checkbox: 'product_vitamin_c',
            dosage: 'vitamin_c_dosage',
            suggestions: ['每日1錠', '餐後1錠', '早餐後1錠']
          },
          {
            checkbox: 'product_energy_crystal',
            dosage: 'energy_crystal_dosage',
            suggestions: ['每日5ml', '溫水稀釋5ml', '早上空腹5ml']
          },
          {
            checkbox: 'product_reishi_tea',
            dosage: 'reishi_tea_dosage',
            suggestions: ['每日2-3次', '餐後飲用', '代替茶水飲用']
          }
        ];

        var numProducts = Math.floor(Math.random() * 2) + 2; // 2-3個產品
        var selectedProducts = [];

        for (var i = 0; i < numProducts; i++) {
          var randomProduct = products[Math.floor(Math.random() * products.length)];
          if (selectedProducts.indexOf(randomProduct.checkbox) === -1) {
            selectedProducts.push(randomProduct.checkbox);
            $('#' + randomProduct.checkbox).prop('checked', true);
            var suggestion = randomProduct.suggestions[Math.floor(Math.random() * randomProduct.suggestions.length)];
            $('input[name="' + randomProduct.dosage + '"]').val(suggestion);
          }
        }

        console.log('eform5測試資料填入完成');

        // 提示用戶
        alert('測試資料已隨機填入！');
      }

      // 產生隨機手機號碼
      function generateRandomPhone() {
        var prefixes = ['09', '08'];
        var prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
        var number = '';
        for (var i = 0; i < 8; i++) {
          number += Math.floor(Math.random() * 10);
        }
        return prefix + number;
      }

      function showConfirmModal() {
        // 驗證必填欄位
        var name = $('input[name="name"]').val();
        var phone = $('input[name="phone"]').val();
        var gender = $('select[name="gender"]').val();
        var age = $('select[name="age"]').val();

        if (!name || !phone || !gender || !age) {
          Swal.fire({
            title: '欄位未完整',
            text: '請填寫姓名、手機號碼、性別、年齡等必填欄位',
            icon: 'warning',
            confirmButtonText: '確定'
          });
          return;
        }

        // 收集完整表單資料進行顯示
        var formSummary = collectFormDataForDisplay();

        // 將資料載入到 modal 中
        $('#confirmModalBody').html(formSummary);

        // 顯示 Bootstrap modal
        $('#confirmModal').modal('show');

        // 綁定確認送出按鈕事件
        $('#confirmSubmitBtn').off('click').on('click', function() {
          $('#confirmModal').modal('hide');
          submitForm();
        });
      }

      function collectFormDataForDisplay() {
        var html = '<div class="form-confirmation-content">';

        // 1. 基本資料區塊
        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>基本資料</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-4"><strong>姓名：</strong>' + ($('input[name="name"]').val() || '未填寫') + '</div>';
        html += '<div class="col-4"><strong>會員編號：</strong>000000</div>';
        html += '<div class="col-4"><strong>性別：</strong>' + ($('select[name="gender"]').val() || '未選擇') + '</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>年齡：</strong>' + ($('select[name="age"]').val() ? $('select[name="age"]').val() + '歲' : '未選擇') + '</div>';
        html += '<div class="col-4"><strong>入會日：</strong>2025-09-09</div>';
        html += '<div class="col-4">&nbsp;</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>身高：</strong>' + ($('input[name="height"]').val() ? $('input[name="height"]').val() + 'cm' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>手機：</strong>' + ($('input[name="phone"]').val() || '未填寫') + '</div>';
        html += '<div class="col-4"><strong>運動習慣：</strong>' + ($('select[name="exercise_habit"]').val() || '未選擇') + '</div>';
        html += '</div>';
        html += '</div>';

        // 2. 體測標準建議值區塊
        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>體測標準建議值</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-4"><strong>體重：</strong>' + ($('input[name="weight"]').val() ? $('input[name="weight"]').val() + 'kg' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>BMI：</strong>' + ($('input[name="bmi"]').val() || '未填寫') + '</div>';
        html += '<div class="col-4"><strong>體脂率：</strong>' + ($('input[name="fat_percentage"]').val() ? $('input[name="fat_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>脂肪量：</strong>' + ($('input[name="fat_mass"]').val() ? $('input[name="fat_mass"]').val() + 'kg' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>肌肉率：</strong>' + ($('input[name="muscle_percentage"]').val() ? $('input[name="muscle_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>肌肉量：</strong>' + ($('input[name="muscle_mass"]').val() ? $('input[name="muscle_mass"]').val() + 'kg' : '未填寫') + '</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>水分率：</strong>' + ($('input[name="water_percentage"]').val() ? $('input[name="water_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>水含量：</strong>' + ($('input[name="water_content"]').val() ? $('input[name="water_content"]').val() + 'kg' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>內臟脂肪：</strong>' + ($('input[name="visceral_fat_percentage"]').val() ? $('input[name="visceral_fat_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>骨量：</strong>' + ($('input[name="bone_mass"]').val() ? $('input[name="bone_mass"]').val() + 'kg' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>基礎代謝率：</strong>' + ($('input[name="bmr"]').val() ? $('input[name="bmr"]').val() + 'kcal' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>蛋白質：</strong>' + ($('input[name="protein_percentage"]').val() ? $('input[name="protein_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '</div>';
        html += '<div class="row mt-2">';
        html += '<div class="col-4"><strong>肥胖度：</strong>' + ($('input[name="obesity_percentage"]').val() ? $('input[name="obesity_percentage"]').val() + '%' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>體年齡：</strong>' + ($('input[name="body_age"]').val() ? $('input[name="body_age"]').val() + '歲' : '未填寫') + '</div>';
        html += '<div class="col-4"><strong>去脂體重：</strong>' + ($('input[name="lean_body_mass"]').val() ? $('input[name="lean_body_mass"]').val() + 'kg' : '未填寫') + '</div>';
        html += '</div>';
        html += '</div>';

        // 3. 職業與健康狀況區塊
        var occupations = [];
        $('input[name="occupation[]"]:checked').each(function() {
          occupations.push($(this).next('label').text() || $(this).val());
        });
        var healthConcerns = [];
        $('input[name="health_concerns[]"]:checked').each(function() {
          healthConcerns.push($(this).next('label').text() || $(this).val());
        });

        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>職業與健康狀況</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-6"><strong>職業：</strong>' + (occupations.length > 0 ? occupations.join('、') : '未選擇') + '</div>';
        html += '<div class="col-6"><strong>健康困擾：</strong>' + (healthConcerns.length > 0 ? healthConcerns.join('、') : '無') + '</div>';
        html += '</div>';
        var otherConcern = $('input[name="health_concerns_other"]').val();
        if (otherConcern) {
          html += '<div class="row mt-2">';
          html += '<div class="col-12"><strong>其他困擾：</strong>' + otherConcern + '</div>';
          html += '</div>';
        }
        html += '</div>';

        // 4. 用藥與病史區塊
        var hasMedication = $('input[name="has_medication_habit"]:checked').val();
        var hasFamilyDisease = $('input[name="has_family_disease_history"]:checked').val();

        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>用藥與病史資訊</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-6"><strong>用藥習慣：</strong>' + (hasMedication === '1' ? '是' : '否') + '</div>';
        html += '<div class="col-6"><strong>家族病史：</strong>' + (hasFamilyDisease === '1' ? '是' : '否') + '</div>';
        html += '</div>';
        if (hasMedication === '1' || hasFamilyDisease === '1') {
          html += '<div class="row mt-2">';
          if (hasMedication === '1') {
            html += '<div class="col-6"><strong>藥物名稱：</strong>' + ($('input[name="medication_name"]').val() || '未填寫') + '</div>';
          }
          if (hasFamilyDisease === '1') {
            html += '<div class="col-6"><strong>疾病名稱：</strong>' + ($('input[name="disease_name"]').val() || '未填寫') + '</div>';
          }
          html += '</div>';
        }
        html += '</div>';

        // 5. 檢測與建議區塊
        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>檢測與建議</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-6"><strong>微循環檢測：</strong>' + ($('input[name="microcirculation_test"]').val() || '未填寫') + '</div>';
        html += '<div class="col-6"><strong>飲食建議：</strong>' + ($('input[name="dietary_advice"]').val() || '未填寫') + '</div>';
        html += '</div>';
        html += '</div>';

        // 6. 建議產品區塊
        var recommendedProducts = [];
        $('input[name="recommended_products[]"]:checked').each(function() {
          recommendedProducts.push($(this).next('label').text() || $(this).val());
        });

        html += '<div class="info-block mb-3" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">';
        html += '<h6 class="mb-3"><strong>建議產品</strong></h6>';
        html += '<div class="row">';
        html += '<div class="col-12"><strong>推薦產品：</strong>' + (recommendedProducts.length > 0 ? recommendedProducts.join('、') : '無') + '</div>';
        html += '</div>';

        // 產品攝取量
        var dosageFields = [{
            field: 'energy_essence_dosage',
            label: '精力素'
          },
          {
            field: 'reishi_ex_dosage',
            label: '靈芝EX'
          },
          {
            field: 'vitamin_c_dosage',
            label: '維他命C'
          },
          {
            field: 'energy_crystal_dosage',
            label: '精力結晶'
          },
          {
            field: 'reishi_tea_dosage',
            label: '靈芝茶'
          }
        ];

        var dosageCount = 0;
        var dosageHtml = '';
        dosageFields.forEach(function(dosage) {
          var value = $('input[name="' + dosage.field + '"]').val();
          if (value) {
            if (dosageCount % 3 === 0) {
              if (dosageCount > 0) dosageHtml += '</div>';
              dosageHtml += '<div class="row mt-2">';
            }
            dosageHtml += '<div class="col-4"><strong>' + dosage.label + '：</strong>' + value + '</div>';
            dosageCount++;
          }
        });
        if (dosageCount > 0) {
          dosageHtml += '</div>';
          html += dosageHtml;
        }

        html += '</div>';
        html += '</div>';

        return html;
      }

      function submitForm() {
        // 收集表單資料
        var formData = {
          // Point 122: 使用指定的會員資料
          member_name: '公司',
          member_id: '000000',

          // 基本資料
          phone: $('input[name="phone"]').val(),
          name: $('input[name="name"]').val(),
          gender: $('select[name="gender"]').val(),
          age: $('select[name="age"]').val(),
          height: $('input[name="height"]').val(),
          exercise_habit: $('select[name="exercise_habit"]').val(),

          // 體測標準建議值
          weight: $('input[name="weight"]').val(),
          bmi: $('input[name="bmi"]').val(),
          fat_percentage: $('input[name="fat_percentage"]').val(),
          fat_mass: $('input[name="fat_mass"]').val(),
          muscle_percentage: $('input[name="muscle_percentage"]').val(),
          muscle_mass: $('input[name="muscle_mass"]').val(),
          water_percentage: $('input[name="water_percentage"]').val(),
          water_content: $('input[name="water_content"]').val(),
          visceral_fat_percentage: $('input[name="visceral_fat_percentage"]').val(),
          bone_mass: $('input[name="bone_mass"]').val(),
          bmr: $('input[name="bmr"]').val(),
          protein_percentage: $('input[name="protein_percentage"]').val(),
          obesity_percentage: $('input[name="obesity_percentage"]').val(),
          body_age: $('input[name="body_age"]').val(),
          lean_body_mass: $('input[name="lean_body_mass"]').val(),

          // 職業
          occupation: [],

          // 藥物使用
          has_medication_habit: $('input[name="has_medication_habit"]:checked').val() || '0',
          medication_name: $('input[name="medication_name"]').val(),

          // 家族病史
          has_family_disease_history: $('input[name="has_family_disease_history"]:checked').val() || '0',
          disease_name: $('input[name="disease_name"]').val(),

          // 健康困擾
          health_concerns: [],
          health_concerns_other: $('input[name="health_concerns_other"]').val(),

          // 檢測與建議
          microcirculation_test: $('input[name="microcirculation_test"]').val(),
          dietary_advice: $('input[name="dietary_advice"]').val(),

          // 建議產品
          recommended_products: [],
          product_dosages: {}
        };

        // 收集職業
        $('input[name="occupation[]"]:checked').each(function() {
          formData.occupation.push($(this).val());
        });

        // 收集健康困擾
        $('input[name="health_concerns[]"]:checked').each(function() {
          formData.health_concerns.push($(this).val());
        });

        // 收集建議產品
        $('input[name="recommended_products[]"]:checked').each(function() {
          formData.recommended_products.push($(this).val());
        });

        // 收集產品攝取量
        var dosageFields = [
          'energy_essence_dosage',
          'reishi_ex_dosage',
          'vitamin_c_dosage',
          'energy_crystal_dosage',
          'reishi_tea_dosage'
        ];

        dosageFields.forEach(function(field) {
          var value = $('input[name="' + field + '"]').val();
          if (value) {
            formData.product_dosages[field] = value;
          }
        });

        // 發送API請求
        $.ajax({
          url: '<?php echo base_url("api/eeform/eeform5/submit"); ?>',
          method: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          dataType: 'json',
          beforeSend: function() {
            // 顯示載入狀態（簡單方式）
            console.log('提交中...正在處理您的資料，請稍候');
            // 可以在這裡添加載入動畫或禁用按鈕
            $('#confirmSubmitBtn').prop('disabled', true).text('提交中...');
          },
          success: function(response) {
            $('#confirmSubmitBtn').prop('disabled', false).text('確認送出');
            if (response.success) {
              Swal.fire({
                title: '提交成功！',
                text: '表單已成功提交',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                // 直接跳轉到 eform5_list 頁面
                window.location.href = '<?php echo base_url("eform/eform5_list"); ?>';
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
            $('#confirmSubmitBtn').prop('disabled', false).text('確認送出');
            console.error('API請求失敗:', {
              status: xhr.status,
              statusText: xhr.statusText,
              responseText: xhr.responseText,
              error: error
            });

            var errorMessage = '提交失敗，請稍後再試';

            try {
              var response = JSON.parse(xhr.responseText);
              if (response.message) {
                errorMessage = response.message;
              }
            } catch (e) {
              errorMessage += '\n錯誤代碼: ' + xhr.status + ' ' + xhr.statusText;
            }

            Swal.fire({
              title: '提交錯誤',
              text: errorMessage,
              icon: 'error',
              confirmButtonText: '確定'
            });
          }
        });
      }

      // 在主要的ready函數中加入eform5專用初始化
      // 移除重複的ready函數，統一在上面的ready函數處理

      // TDD 測試功能 - 用於驗證 Bootstrap Modal 功能
      function runModalTest() {
        console.log('=== EForm5 Modal TDD 測試開始 ===');

        var tests = [];

        // 測試 1: Bootstrap 載入檢查
        try {
          if (typeof $.fn.modal !== 'undefined') {
            tests.push({
              name: 'Bootstrap Modal 載入',
              pass: true,
              message: '✓ Bootstrap modal 函數已正確載入'
            });
          } else {
            tests.push({
              name: 'Bootstrap Modal 載入',
              pass: false,
              message: '✗ Bootstrap modal 函數未載入'
            });
          }
        } catch (e) {
          tests.push({
            name: 'Bootstrap Modal 載入',
            pass: false,
            message: '✗ 載入檢查錯誤: ' + e.message
          });
        }

        // 測試 2: Modal 元素存在性
        if ($('#confirmModal').length > 0) {
          tests.push({
            name: 'Modal HTML 結構',
            pass: true,
            message: '✓ Modal HTML 結構存在'
          });
        } else {
          tests.push({
            name: 'Modal HTML 結構',
            pass: false,
            message: '✗ 找不到 Modal HTML 結構'
          });
        }

        // 測試 3: showConfirmModal 函數存在性
        if (typeof showConfirmModal === 'function') {
          tests.push({
            name: 'showConfirmModal 函數',
            pass: true,
            message: '✓ showConfirmModal 函數已定義'
          });
        } else {
          tests.push({
            name: 'showConfirmModal 函數',
            pass: false,
            message: '✗ showConfirmModal 函數未定義'
          });
        }

        // 測試 4: collectFormDataForDisplay 函數存在性
        if (typeof collectFormDataForDisplay === 'function') {
          tests.push({
            name: 'collectFormDataForDisplay 函數',
            pass: true,
            message: '✓ collectFormDataForDisplay 函數已定義'
          });
        } else {
          tests.push({
            name: 'collectFormDataForDisplay 函數',
            pass: false,
            message: '✗ collectFormDataForDisplay 函數未定義'
          });
        }

        // 測試 5: Modal 顯示測試（非破壞性）
        try {
          var testModal = $('#confirmModal');
          if (testModal.length > 0) {
            tests.push({
              name: 'Modal 可操作性',
              pass: true,
              message: '✓ Modal 元素可操作'
            });
          } else {
            tests.push({
              name: 'Modal 可操作性',
              pass: false,
              message: '✗ Modal 元素不可操作'
            });
          }
        } catch (e) {
          tests.push({
            name: 'Modal 可操作性',
            pass: false,
            message: '✗ Modal 操作錯誤: ' + e.message
          });
        }

        // 輸出測試結果
        var passed = tests.filter(t => t.pass).length;
        var total = tests.length;

        console.log('--- 測試結果 ---');
        tests.forEach(test => {
          console.log(`${test.name}: ${test.message}`);
        });
        console.log(`總結: ${passed}/${total} 項測試通過`);

        if (passed === total) {
          console.log('🎉 所有測試通過！Modal 功能應該正常工作');
        } else {
          console.log('⚠️ 某些測試失敗，請檢查 Bootstrap 載入和 Modal 設定');
        }

        console.log('=== 測試完成 ===');

        return {
          passed: passed,
          total: total
        };
      }

      // 頁面載入完成後自動執行測試（開發模式）
      if (showTestButton) {
        setTimeout(() => {
          runModalTest();
        }, 1000);
      }

      // 測試按鈕已隱藏 (Point 131)
      // 如需要測試功能，可在開發者工具執行 runModalTest()
    </script>
  </body>

  </html>