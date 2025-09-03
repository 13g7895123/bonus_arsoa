<body class="theme-orange fixed-footer fixed-footer-lg">
  <div class="animsition">
    <div class="wrapper">
      <?= $this->block_service->load_html_header(); ?>
      <div class="section-mini">
        <div class="section-item text-left">
          <div class="container">
            <div class="row">
              <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                <h1 class="h2-3d font-libre"><strong>微微卡日記</strong></h1>
                <div class="mb30">
                  <div class="container">
                    <form action="#" method="POST" class="text-left" id="eform03">
                      <div class="row">
                        <div class="col-sm-12 text-right mb30">填寫日期：<span id="current-date"></span></div>

                        <div class="col-sm-4 mb30">
                          <label class="label-custom"><span style="color: red;">*</span>會員姓名</label>
                          <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填會員姓名" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" readonly style="background-color: #f8f9fa;" />
                        </div>
                        <div class="col-sm-4 mb30">
                          <label class="label-custom"><span style="color: red;">*</span></label>
                          <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="<?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : ''; ?>" readonly style="background-color: #f8f9fa;" />
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom"><span style="color: red;">*</span>年齡</label>
                          <input type="number" name="age" class="form-control form-control-custom" placeholder="限填數字" />
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom"><span style="color: red;">*</span>身高</label>
                          <input type="number" name="height" class="form-control form-control-custom" placeholder="限填數字" />
                        </div>
                        <div class="col-sm-12 mb30">
                          <label class="label-custom"><span style="color: red;">*</span>目標</label>
                          <input type="text" name="goal" class="form-control form-control-custom" placeholder="請填寫目標…" required />
                        </div>

                        <div class="col-sm-12 mb20">
                          <div class="alert alert-danger" role="alert" style="border-radius: 0 !important;"> 共同行動計畫：<br>
                            <ol>
                              <li>用手測量飲食</li>
                              <li>運動</li>
                              <li>保健食品</li>
                              <li>微微卡執行</li>
                            </ol>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <div class="alert alert-warning" role="alert" style="border-radius: 0 !important;">
                            <div class="col-sm-12 mb30">
                              <label class="label-custom">自身行動計畫1.</label>
                              <input type="text" name="action_plan_1" class="form-control form-control-custom" placeholder="請填寫目標…" />
                            </div>
                            <div class="col-sm-12 mb30">
                              <label class="label-custom">自身行動計畫2.</label>
                              <input type="text" name="action_plan_2" class="form-control form-control-custom" placeholder="請填寫目標…" />
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <div class="card bg-light ">
                            <div class="card-body">
                              <div class="container">
                                <div class="row">
                                  <div class="col-sm-3 mb20">
                                    <label class="label-custom">體重(公斤)：</label>
                                    <input type="number" name="weight" step="0.1" style="width: 100%;" placeholder="限填數字">
                                  </div>
                                  <div class="col-sm-3 mb20">
                                    <label class="label-custom">血壓(收)：</label>
                                    <input type="number" name="blood_pressure_high" style="width: 100%;" placeholder="限填數字">
                                  </div>
                                  <div class="col-sm-3 mb20">
                                    <label class="label-custom">血壓(舒)：</label>
                                    <input type="number" name="blood_pressure_low" style="width: 100%;" placeholder="限填數字">
                                  </div>
                                  <div class="col-sm-3 mb30">
                                    <label class="label-custom">腰圍(公分)：</label>
                                    <input type="number" name="waist" step="0.1" style="width: 100%;" placeholder="限填數字">
                                  </div>
                                  <hr>
                                  <div class="col-sm-12 mb30">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="hand_measure" id="hand_measure" value="1">
                                      <label class="form-check-label" for="hand_measure">用手測量 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="exercise" id="exercise" value="1">
                                      <label class="form-check-label" for="exercise">運動(30分) </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="health_supplement" id="health_supplement" value="1">
                                      <label class="form-check-label" for="health_supplement">保健食品 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="weika" id="weika" value="1">
                                      <label class="form-check-label" for="weika">微微卡 </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="checkbox" name="water_intake" id="water_intake" value="1">
                                      <label class="form-check-label" for="water_intake">飲水量 </label>
                                    </div>
                                  </div>

                                  <div class="col-sm-12 mb20">
                                    <label class="label-custom">計畫1.</label>
                                    <input type="text" name="plan_a" class="form-control form-control-custom" placeholder="請填寫目標…" />
                                  </div>

                                  <div class="col-sm-12 mb20">
                                    <label class="label-custom">計畫2.</label>
                                    <input type="text" name="plan_b" class="form-control form-control-custom" placeholder="請填寫目標…" />
                                  </div>

                                  <div class="col-sm-12 mb30">
                                    <label class="label-custom">其他</label>
                                    <input type="text" name="other" class="form-control form-control-custom" placeholder="請填寫目標…" />
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
                <!-- 側邊欄清單 -->
                <?= $this->block_service->electronic_form_right_menu('eform3'); ?>
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
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">姓名：</span>
                      <span class="text-dark" id="confirm-member-name"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">編號：</span>
                      <span class="text-dark" id="confirm-member-id"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">年齡：</span>
                      <span class="text-dark" id="confirm-age"></span> 歲
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">身高：</span>
                      <span class="text-dark" id="confirm-height"></span> cm
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 60px;">目標：</span>
                      <span class="text-dark" id="confirm-goal"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 行動計畫 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  自身行動計畫
                </h6>
              </div>
              <div class="p-3">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 60px;">計畫1：</span>
                      <span class="text-dark" id="confirm-action-plan-1"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 60px;">計畫2：</span>
                      <span class="text-dark" id="confirm-action-plan-2"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 身體數據 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  身體數據
                </h6>
              </div>
              <div class="p-3">
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">體重：</span>
                      <span class="text-dark" id="confirm-weight"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 80px;">血壓(收)：</span>
                      <span class="text-dark" id="confirm-blood-pressure-high"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 80px;">血壓(舒)：</span>
                      <span class="text-dark" id="confirm-blood-pressure-low"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">腰圍：</span>
                      <span class="text-dark" id="confirm-waist"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 執行項目 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  執行項目
                </h6>
              </div>
              <div class="p-3">
                <div id="confirm-checkboxes-container"></div>
              </div>
            </div>

            <!-- 其他計畫 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  其他計畫
                </h6>
              </div>
              <div class="p-3">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 70px;">計畡1：</span>
                      <span class="text-dark" id="confirm-plan-a"></span>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 70px;">計畡2：</span>
                      <span class="text-dark" id="confirm-plan-b"></span>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 70px;">其他：</span>
                      <span class="text-dark" id="confirm-other"></span>
                    </div>
                  </div>
                </div>
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

  <!-- Order Modal -->
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
    
    /* Required field labels in red */
    .required-field {
      color: #dc3545 !important;
      font-weight: 500;
    }
    
    .required-field .text-danger {
      font-weight: bold;
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
    // 控制測試按鈕顯示的變數
    var showTestButton = false; // 設為 false 隱藏測試按鈕
    
    // 頁面載入時檢查是否顯示測試按鈕
    $(document).ready(function() {
      if (showTestButton) {
        $('#testDataButton').show();
      }
      
      // 驗證會員資料
      if (validateMemberData()) {
        // 載入第一次提交記錄來自動填入目標和行動計畫
        loadFirstSubmissionData();
      }
    });
    
    // 驗證會員姓名和編號
    function validateMemberData() {
      var memberName = $('input[name="member_name"]').val();
      var memberId = $('input[name="member_id"]').val();
      
      // 檢查會員姓名或編號是否為空或預設值
      if (!memberName || !memberId || memberName === '未設定' || memberId === '未設定' || memberName.trim() === '' || memberId.trim() === '') {
        Swal.fire({
          title: '會員資料錯誤',
          text: '會員姓名或編號有誤，請先完善會員資料',
          icon: 'warning',
          confirmButtonText: '確定',
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            // 返回上一頁（eform3_list）
            if (document.referrer && document.referrer.indexOf('eform3_list') !== -1) {
              window.history.back();
            } else {
              window.location.href = '<?php echo base_url("eform/eform3_list"); ?>';
            }
          }
        });
        return false;
      }
      return true;
    }
    
    // 載入第一次提交記錄來自動填入目標和行動計畫
    function loadFirstSubmissionData() {
      var memberId = $('input[name="member_id"]').val();
      if (!memberId) return;
      
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submissions/"); ?>' + memberId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            var submissions = response.data && response.data.data ? response.data.data : response.data;
            if (submissions && submissions.length > 0) {
              // 取得第一次的提交記錄（最後一個）
              var firstSubmission = submissions[submissions.length - 1];
              
              // 自動填入目標和行動計畫（如果欄位還是空的）
              if (firstSubmission.goal && !$('input[name="goal"]').val()) {
                $('input[name="goal"]').val(firstSubmission.goal).attr('readonly', true).css('background-color', '#f8f9fa');
              }
              if (firstSubmission.action_plan_1 && !$('input[name="action_plan_1"]').val()) {
                $('input[name="action_plan_1"]').val(firstSubmission.action_plan_1).attr('readonly', true).css('background-color', '#f8f9fa');
              }
              if (firstSubmission.action_plan_2 && !$('input[name="action_plan_2"]').val()) {
                $('input[name="action_plan_2"]').val(firstSubmission.action_plan_2).attr('readonly', true).css('background-color', '#f8f9fa');
              }
              
              // 自動填入年齡和身高（第二次填寫時）並設為唯讀
              if (firstSubmission.age && !$('input[name="age"]').val()) {
                $('input[name="age"]').val(firstSubmission.age).attr('readonly', true).css('background-color', '#f8f9fa');
              }
              if (firstSubmission.height && !$('input[name="height"]').val()) {
                $('input[name="height"]').val(firstSubmission.height).attr('readonly', true).css('background-color', '#f8f9fa');
              }
            }
          }
        },
        error: function(xhr, status, error) {
          // 如果載入失敗，保持欄位可編輯
        }
      });
    }

    $(document).ready(function() {
      // 自動填入當天日期
      var today = new Date();
      var currentDate = today.getFullYear() + '-' + 
                        String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(today.getDate()).padStart(2, '0');
      
      $('#current-date').text(currentDate);
      $('input[name="join_date"]').val(currentDate);
      
      if (showTestButton) $('#testDataButton').show();
    });
    
    // 填入測試資料的函數
    function fillTestData() {
      // 會員姓名與編號已自動填入，不需要在測試資料中覆蓋
      $('input[name="age"]').val('35');
      $('input[name="height"]').val('170');
      
      // 只在欄位不是readonly的情況下填入目標和行動計畫測試資料
      if (!$('input[name="goal"]').prop('readonly')) {
        $('input[name="goal"]').val('減重5公斤並維持健康體態');
      }
      if (!$('input[name="action_plan_1"]').prop('readonly')) {
        $('input[name="action_plan_1"]').val('每天早上做30分鐘瑜珈');
      }
      if (!$('input[name="action_plan_2"]').prop('readonly')) {
        $('input[name="action_plan_2"]').val('晚餐後散步1小時');
      }
      $('input[name="weight"]').val('70.5');
      $('input[name="blood_pressure_high"]').val('120');
      $('input[name="blood_pressure_low"]').val('80');
      $('input[name="waist"]').val('85.0');
      $('input[name="hand_measure"]').prop('checked', true);
      $('input[name="exercise"]').prop('checked', true);
      $('input[name="weika"]').prop('checked', true);
      $('input[name="water_intake"]').prop('checked', true);
      $('input[name="plan_a"]').val('每日記錄飲食內容');
      $('input[name="plan_b"]').val('每週量體重2次');
      $('input[name="other"]').val('保持充足睡眠');
    }

    function showConfirmModal() {
      // 驗證必填欄位
      var memberName = $('input[name="member_name"]').val();
      var memberId = $('input[name="member_id"]').val();
      var age = $('input[name="age"]').val();
      var height = $('input[name="height"]').val();
      var goal = $('input[name="goal"]').val();

      if (!memberId || !age || !height || !goal) {
        Swal.fire({
          title: '欄位未完整',
          text: '請填寫所有必填欄位',
          icon: 'warning',
          confirmButtonText: '確定'
        });
        return;
      }

      // 填入確認視窗的內容
      $('#confirm-member-name').text(memberName);
      $('#confirm-member-id').text(memberId);
      $('#confirm-age').text(age);
      $('#confirm-height').text(height);
      $('#confirm-goal').text(goal);
      
      // 自身行動計畫
      $('#confirm-action-plan-1').text($('input[name="action_plan_1"]').val() || '(未填寫)');
      $('#confirm-action-plan-2').text($('input[name="action_plan_2"]').val() || '(未填寫)');
      
      // 身體數據
      $('#confirm-weight').text($('input[name="weight"]').val() || '(未填寫)');
      $('#confirm-blood-pressure-high').text($('input[name="blood_pressure_high"]').val() || '(未填寫)');
      $('#confirm-blood-pressure-low').text($('input[name="blood_pressure_low"]').val() || '(未填寫)');
      $('#confirm-waist').text($('input[name="waist"]').val() || '(未填寫)');
      
      // 執行項目 (checkbox)
      var checkboxes = [
        {name: 'hand_measure', label: '用手測量', icon: 'fa-hand-paper'},
        {name: 'exercise', label: '運動(30分)', icon: 'fa-running'},
        {name: 'health_supplement', label: '保健食品', icon: 'fa-pills'},
        {name: 'weika', label: '微微卡', icon: 'fa-apple-alt'},
        {name: 'water_intake', label: '飲水量', icon: 'fa-tint'}
      ];
      var checkedItems = [];
      
      $.each(checkboxes, function(index, item) {
        var checkbox = $('input[name="' + item.name + '"]');
        if (checkbox.is(':checked')) {
          checkedItems.push(item.label);
        }
      });
      
      if (checkedItems.length > 0) {
        $('#confirm-checkboxes-container').html('<span class="text-dark">' + checkedItems.join('、') + '</span>');
      } else {
        $('#confirm-checkboxes-container').html('<span class="text-muted">無選擇項目</span>');
      }
      
      // 其他計畫
      $('#confirm-plan-a').text($('input[name="plan_a"]').val() || '(未填寫)');
      $('#confirm-plan-b').text($('input[name="plan_b"]').val() || '(未填寫)');
      $('#confirm-other').text($('input[name="other"]').val() || '(未填寫)');
      
      // 顯示模態視窗
      $('#confirmModal').modal('show');
    }

    function submitForm() {
      // 收集表單資料
      var formData = {
        member_name: $('input[name="member_name"]').val(),
        member_id: $('input[name="member_id"]').val(),
        age: $('input[name="age"]').val(),
        height: $('input[name="height"]').val(),
        goal: $('input[name="goal"]').val(),
        action_plan_1: $('input[name="action_plan_1"]').val(),
        action_plan_2: $('input[name="action_plan_2"]').val(),
        weight: $('input[name="weight"]').val(),
        blood_pressure_high: $('input[name="blood_pressure_high"]').val(),
        blood_pressure_low: $('input[name="blood_pressure_low"]').val(),
        waist: $('input[name="waist"]').val(),
        hand_measure: $('input[name="hand_measure"]').is(':checked') ? 1 : 0,
        exercise: $('input[name="exercise"]').is(':checked') ? 1 : 0,
        health_supplement: $('input[name="health_supplement"]').is(':checked') ? 1 : 0,
        weika: $('input[name="weika"]').is(':checked') ? 1 : 0,
        water_intake: $('input[name="water_intake"]').is(':checked') ? 1 : 0,
        plan_a: $('input[name="plan_a"]').val(),
        plan_b: $('input[name="plan_b"]').val(),
        other: $('input[name="other"]').val()
      };

      // 發送API請求
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submit"); ?>',
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
              text: '表單已成功提交，1.5秒後自動返回列表頁面',
              icon: 'success',
              timer: 1500,
              showConfirmButton: false,
              allowOutsideClick: false,
              allowEscapeKey: false
            }).then(() => {
              $('#confirmModal').modal('hide');
              // 直接跳轉到 eform3_list 頁面
              window.location.href = '<?php echo base_url("eform/eform3_list"); ?>';
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
          console.error('API請求失敗:', {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText,
            error: error
          });
          
          var errorMessage = '提交失敗，請稍後再試';
          var debugInfo = '';
          
          try {
            var response = JSON.parse(xhr.responseText);
            if (response.message) {
              errorMessage = response.message;
            }
            if (response.errors && response.errors.length > 0) {
              errorMessage += '：\n' + response.errors.join('\n');
            }
            if (response.debug || response.trace) {
              debugInfo = '\n\n調試資訊:\n' + JSON.stringify(response, null, 2);
              console.error('詳細錯誤資訊:', response);
            }
          } catch (e) {
            // JSON解析失敗，使用預設錯誤訊息
            errorMessage += '\n錯誤代碼: ' + xhr.status + ' ' + xhr.statusText;
            if (xhr.responseText) {
              debugInfo = '\n響應內容: ' + xhr.responseText;
            }
          }
          
          Swal.fire({
            title: '提交錯誤',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: '確定',
            footer: debugInfo ? '<small>' + debugInfo + '</small>' : null
          });
        },
        complete: function() {
          // 恢復按鈕狀態
          $('#confirmModal .modal-footer button').prop('disabled', false);
          $('#confirmModal .modal-footer .btn-danger').text('確認送出');
        }
      });
    }

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