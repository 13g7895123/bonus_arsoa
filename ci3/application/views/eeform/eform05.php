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
                    <label class="label-custom">手機號碼</label>
                    <input type="tel" name="phone" class="form-control form-control-custom" placeholder="請填手機號碼" />
                  </div>
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">姓名</label>
                    <input type="text" name="name" class="form-control form-control-custom" placeholder="請填姓名" />
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
                    <div id="testDataButton" style="display: block;" class="mb-3">
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
<script>
  // 控制測試按鈕顯示的變數
  var showTestButton = true; // 設為 true 顯示測試按鈕

  // 頁面載入時檢查是否顯示測試按鈕
  $(document).ready(function() {
    console.log('eform5 頁面載入完成');
    console.log('DOM 已載入完成');
    console.log('jQuery 版本:', $.fn.jquery);
    
    // 設定固定的會員資料 (Point 122)
    console.log('設定會員資料為: 公司 (000000)');
    
    // 自動填入當天日期
    var today = new Date();
    var currentDate = today.getFullYear() + '-' +
      String(today.getMonth() + 1).padStart(2, '0') + '-' +
      String(today.getDate()).padStart(2, '0');

    $('#current-date').text(currentDate);

    // 延遲生成年齡下拉選單選項，確保DOM完全渲染
    setTimeout(function() {
      try {
        generateAgeOptions();
        console.log('年齡選項生成完成');
      } catch (error) {
        console.error('生成年齡選項時發生錯誤:', error);
      }
    }, 100);

    // 顯示測試按鈕
    console.log('showTestButton 狀態:', showTestButton);
    if (showTestButton) {
      console.log('顯示測試按鈕');
      $('#testDataButton').show();
    } else {
      console.log('隱藏測試按鈕');
    }
    
    // 添加手動測試函數到全域作用域
    window.testGenerateAgeOptions = function() {
      console.log('手動測試年齡選項生成...');
      generateAgeOptions();
    };
    
    // 測試年齡計算邏輯
    var currentYear = new Date().getFullYear();
    console.log('當前年份:', currentYear);
    console.log('18歲計算測試:', (currentYear - 18), '→ 民國', (currentYear - 18 - 1911), '年');
    console.log('100歲計算測試:', (currentYear - 100), '→ 民國', (currentYear - 100 - 1911), '年');
  });

  // 生成年齡下拉選單選項 (民國XX年出生 - XX歲)
  function generateAgeOptions() {
    console.log('開始生成年齡選項');
    var currentYear = new Date().getFullYear();
    
    // 嘗試多種選擇器來找到年齡下拉選單
    var $ageSelect = $('select[name="age"]');
    
    if ($ageSelect.length === 0) {
      $ageSelect = $('#eform05 select[name="age"]');
    }
    
    if ($ageSelect.length === 0) {
      $ageSelect = $('select').filter(function() {
        return $(this).attr('name') === 'age';
      });
    }
    
    console.log('找到年齡下拉選單元素:', $ageSelect.length);
    console.log('年齡下拉選單元素:', $ageSelect);
    
    if ($ageSelect.length === 0) {
      console.error('未找到年齡下拉選單元素');
      // 列出所有的 select 元素來除錯
      console.log('頁面上所有的 select 元素:', $('select'));
      return;
    }
    
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
        $ageSelect.append('<option value="' + optionValue + '">' + optionText + '</option>');
        optionsCount++;
      }
    }
    
    console.log('成功生成年齡選項數量:', optionsCount);
    console.log('最終年齡選項總數:', $ageSelect.find('option').length);
  }

  // 填入測試資料的函數
  function fillTestData() {
    console.log('開始填入eform5測試資料');
    
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
                         'health_three_high', 'health_digestive', 'health_vision', 'health_immunity', 'health_weight'];
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
    var products = [
      {checkbox: 'product_energy_essence', dosage: 'energy_essence_dosage', suggestions: ['每日1包', '早晚各1包', '空腹服用1包']},
      {checkbox: 'product_reishi_ex', dosage: 'reishi_ex_dosage', suggestions: ['每日2粒', '早晚各1粒', '飯後服用2粒']},
      {checkbox: 'product_vitamin_c', dosage: 'vitamin_c_dosage', suggestions: ['每日1錠', '餐後1錠', '早餐後1錠']},
      {checkbox: 'product_energy_crystal', dosage: 'energy_crystal_dosage', suggestions: ['每日5ml', '溫水稀釋5ml', '早上空腹5ml']},
      {checkbox: 'product_reishi_tea', dosage: 'reishi_tea_dosage', suggestions: ['每日2-3次', '餐後飲用', '代替茶水飲用']}
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
    // 驗證必填欄位 - eform5 使用的是 name, phone 等欄位
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

    // 顯示確認資訊
    Swal.fire({
      title: '確認送出表單',
      html: `
        <div class="text-left">
          <p><strong>姓名：</strong>${name}</p>
          <p><strong>手機：</strong>${phone}</p>
          <p><strong>性別：</strong>${gender}</p>
          <p><strong>年齡：</strong>${age}歲</p>
        </div>
      `,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '確認送出',
      cancelButtonText: '取消'
    }).then((result) => {
      if (result.isConfirmed) {
        submitForm();
      }
    });
  }

  function submitForm() {
    console.log('開始提交eform5表單');
    
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

    console.log('收集到的表單資料:', formData);

    // 發送API請求
    $.ajax({
      url: '<?php echo base_url("api/eeform/eeform5/submit"); ?>',
      method: 'POST',
      data: JSON.stringify(formData),
      contentType: 'application/json',
      dataType: 'json',
      beforeSend: function() {
        // 顯示載入狀態
        Swal.fire({
          title: '提交中...',
          text: '正在處理您的資料，請稍候',
          icon: 'info',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading()
          }
        });
      },
      success: function(response) {
        if (response.success) {
          Swal.fire({
            title: '提交成功！',
            text: '表單已成功提交',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
          }).then(() => {
            location.reload();
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
</script>
</div>