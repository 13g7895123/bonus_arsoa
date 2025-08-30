
<body class="theme-orange fixed-footer fixed-footer-lg">
  <div class="animsition">
    <div class="wrapper">
      <?= $this->block_service->load_html_header(); ?>


      <div class="section-mini">

        <div class="section-item text-left">
          <div class="container">
            <div class="row">
              <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                <h1 class="h2-3d font-libre"><strong>公司 微微卡日記</strong></h1>
                <div class="mb30">
                  <div class="container">
                    <form action="#" class="text-left">
                      <div class="row">

                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員姓名</label>
                          <p id="member-name"><?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : '未設定'; ?></p>
                        </div>
                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員編號</label>
                          <p id="member-id"><?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : '未設定'; ?></p>
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">年齡</label>
                          <p id="member-age"><?php echo isset($userdata['age']) ? htmlspecialchars($userdata['age']) : '-'; ?></p>
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">身高</label>
                          <p id="member-height"><?php echo isset($userdata['height']) ? htmlspecialchars($userdata['height']) : '-'; ?></p>
                        </div>
                        <div class="col-sm-12 mb30">
                          <label class="label-custom">目標</label>
                          <p id="member-goal"><?php echo isset($userdata['goal']) ? htmlspecialchars($userdata['goal']) : '未設定'; ?></p>
                        </div>

                        <div class="col-sm-12 mb20">
                          <div class="alert alert-danger" role="alert"> 共同行動計畫：<br>
                            <ol>
                              <li>用手測量飲食</li>
                              <li>運動</li>
                              <li>保健食品</li>
                              <li>微微卡執行</li>
                            </ol>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <div class="alert alert-warning" role="alert">
                            <div class="col-sm-12 mb30">
                              <label class="label-custom">自身行動計畫1.</label>
                              <p id="action-plan-1"><?php echo isset($userdata['action_plan_1']) ? htmlspecialchars($userdata['action_plan_1']) : '未設定'; ?></p>
                            </div>
                            <div class="col-sm-12 mb30">
                              <label class="label-custom">自身行動計畫2.</label>
                              <p id="action-plan-2"><?php echo isset($userdata['action_plan_2']) ? htmlspecialchars($userdata['action_plan_2']) : '未設定'; ?></p>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <div class="card bg-light ">
                            <div class="card-body">
                              <table class="table table-striped mb-2 text-center">
                                <thead class="thead-dark">
                                  <tr>
                                    <th>填寫日期</th>
                                    <th>體重</th>
                                    <th>血壓(收)</th>
                                    <th>血壓(舒)</th>
                                    <th>腰圍</th>
                                    <th>共同行動</th>
                                    <th>功能</th>
                                  </tr>
                                </thead>
                                <tbody id="submissions-table-body">
                                  <tr>
                                    <td colspan="7" class="text-center text-muted p-4">
                                      <div><i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i></div>
                                      <div class="mt-2">載入中，請稍候...</div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <hr class="my-4">
                          <a href="<?php echo base_url('eform/eform3'); ?>" class="btn btn-outline-danger btn-block">填寫微微卡日記</a>
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
  <!-- Modal form03view -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="form03view">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">訂單內容</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb30">
            <div class="container">
              <form action="#" class="text-left">
                <div class="row">
                  <div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>

                  <div class="col-sm-4 mb30">
                    <label class="label-custom">會員姓名</label>
                    <p>公司</p>
                  </div>
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">會員編號</label>
                    <p>000000</p>
                  </div>
                  <div class="col-sm-2 mb30">
                    <label class="label-custom">年齡</label>
                    <p>30</p>
                  </div>
                  <div class="col-sm-2 mb30">
                    <label class="label-custom">身高</label>
                    <p>183</p>
                  </div>
                  <div class="col-sm-12 mb30">
                    <label class="label-custom">目標</label>
                    <p>達成健康完美體態！各方面狀況都優等！</p>
                  </div>

                  <div class="col-sm-12 mb20">
                    <div class="alert alert-danger" role="alert"> 共同行動計畫：<br>
                      <ol>
                        <li>用手測量飲食</li>
                        <li>運動</li>
                        <li>保健食品</li>
                        <li>微微卡執行</li>
                      </ol>
                    </div>
                  </div>

                  <div class="col-sm-12 mb30">
                    <div class="alert alert-warning" role="alert">
                      <div class="col-sm-12 mb30">
                        <label class="label-custom">自身行動計畫1.</label>
                        <p>計畫目標1.的內容計畫目標1.的內容計畫目標1.的內容計畫目標1.的內容</p>
                      </div>
                      <div class="col-sm-12 mb30">
                        <label class="label-custom">自身行動計畫2.</label>
                        <p>計畫目標2.的內容計畫目標2.的內容</p>
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
                              <p>62</p>
                            </div>
                            <div class="col-sm-3 mb20">
                              <label class="label-custom">血壓(收)：</label>
                              <p>65</p>
                            </div>
                            <div class="col-sm-3 mb20">
                              <label class="label-custom">血壓(舒)：</label>
                              <p>118</p>
                            </div>
                            <div class="col-sm-3 mb30">
                              <label class="label-custom">腰圍(公分)：</label>
                              <p>90</p>
                            </div>
                            <hr>
                            <div class="col-sm-12 mb30">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked>
                                <label class="form-check-label" for="inlineRadio4">用手測量 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked>
                                <label class="form-check-label" for="inlineRadio4">運動(30分) </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked>
                                <label class="form-check-label" for="inlineRadio4">保健食品 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked>
                                <label class="form-check-label" for="inlineRadio4">微微卡 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3" checked>
                                <label class="form-check-label" for="inlineRadio4">飲水量 </label>
                              </div>
                            </div>

                            <div class="col-sm-12 mb20">
                              <label class="label-custom">計畫a.</label>
                              <p>教棵抄了，頭南貓躲幼古成家片，牠亮爬信安。走怕害目裝笑訴、王語車進有免成犬光歌帶起又種活因固父石生？草幼祖苦，食竹福鼻蝴小五。</p>
                            </div>

                            <div class="col-sm-12 mb20">
                              <label class="label-custom">計畫b.</label>
                              <p>魚車起公原蝸干地雨即抓真文「欠次日成細孝孝穿玉花」給吧午現這學下甲真在者共忍院過祖奶春元寫、冒玩錯清！有胡頁，寫三登扒筆安心坐菜安園根草比綠首意，完松麼更貓雨。</p>
                            </div>

                            <div class="col-sm-12 mb30">
                              <label class="label-custom">其他</label>
                              <p>原重白哭怕去兩丁雨找玩因春也收松同「扒者清或洋貫汗」流打戊里、像活胡肉道科昔示那田兔那笑友菜口亭上、根問夕從尤像而國言貫工耍一呀米吹前尼；做口牙種香、抓世連，首香家出屋乙，唱同意羊想您。</p>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 mb30">
                    <hr class="my-4">
                    <a href="javascript:;" class="btn btn-outline-danger btn-block" onclick="switchToEditModal()">我要修改</a>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal form03edit -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="form03edit">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">訂單內容</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb30">
            <div class="container">
              <form action="#" class="text-left">
                <div class="row">
                  <div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>

                  <div class="col-sm-4 mb30">
                    <label class="label-custom">會員姓名</label>
                    <input type="text" class="form-control form-control-custom" placeholder="請填會員姓名" />
                  </div>
                  <div class="col-sm-4 mb30">
                    <label class="label-custom">會員編號</label>
                    <input type="text" class="form-control form-control-custom" placeholder="請填會員編號" />
                  </div>
                  <div class="col-sm-2 mb30">
                    <label class="label-custom">年齡</label>
                    <input type="text" class="form-control form-control-custom" placeholder="限填數字" />
                  </div>
                  <div class="col-sm-2 mb30">
                    <label class="label-custom">身高</label>
                    <input type="text" class="form-control form-control-custom" placeholder="限填數字" />
                  </div>
                  <div class="col-sm-12 mb30">
                    <label class="label-custom">目標</label>
                    <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
                  </div>

                  <div class="col-sm-12 mb20">
                    <div class="alert alert-danger" role="alert"> 共同行動計畫：<br>
                      <ol>
                        <li>用手測量飲食</li>
                        <li>運動</li>
                        <li>保健食品</li>
                        <li>微微卡執行</li>
                      </ol>
                    </div>
                  </div>

                  <div class="col-sm-12 mb30">
                    <div class="alert alert-warning" role="alert">
                      <div class="col-sm-12 mb30">
                        <label class="label-custom">自身行動計畫1.</label>
                        <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
                      </div>
                      <div class="col-sm-12 mb30">
                        <label class="label-custom">自身行動計畫2.</label>
                        <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
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
                              <input type="text" style="width: 100%;" placeholder="限填數字">
                            </div>
                            <div class="col-sm-3 mb20">
                              <label class="label-custom">血壓(收)：</label>
                              <input type="text" style="width: 100%;" placeholder="限填數字">
                            </div>
                            <div class="col-sm-3 mb20">
                              <label class="label-custom">血壓(舒)：</label>
                              <input type="text" style="width: 100%;" placeholder="限填數字">
                            </div>
                            <div class="col-sm-3 mb30">
                              <label class="label-custom">腰圍(公分)：</label>
                              <input type="text" style="width: 100%;" placeholder="限填數字">
                            </div>
                            <hr>
                            <div class="col-sm-12 mb30">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio4">用手測量 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio4">運動(30分) </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio4">保健食品 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio4">微微卡 </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio4">飲水量 </label>
                              </div>
                            </div>

                            <div class="col-sm-12 mb20">
                              <label class="label-custom">計畫a.</label>
                              <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
                            </div>

                            <div class="col-sm-12 mb20">
                              <label class="label-custom">計畫b.</label>
                              <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
                            </div>

                            <div class="col-sm-12 mb30">
                              <label class="label-custom">其他</label>
                              <input type="text" class="form-control form-control-custom" placeholder="請填寫目標…" />
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 mb30">
                    <hr class="my-4">
                    <button type="button" class="btn btn-outline-danger btn-block" onclick="updateSubmission()">更新表單</button>
                  </div>

                </div>
              </form>
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
  
  <!-- Custom styles for enhanced error states -->
  <style>
    /* Loading spinner animation */
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    /* Table empty state styles */
    #submissions-table-body td {
      vertical-align: middle;
    }
    
    /* Enhanced error state button */
    .retry-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    // 全域變數
    var currentMemberId = '<?php echo isset($userdata['c_no']) ? $userdata['c_no'] : ''; ?>'; // 從控制器取得會員ID
    var currentSubmissionId = null; // 當前選中的提交記錄ID
    
    // 頁面載入時初始化
    $(document).ready(function() {
      if (currentMemberId) {
        loadSubmissions();
        loadSubmissionsForProfile(); // 載入提交記錄更新個人資料區域
      } else {
        $('#submissions-table-body').html(
          '<tr><td colspan="7" class="text-center text-warning p-4">' +
          '<div><i class="icon ion-person" style="font-size: 2rem;"></i></div>' +
          '<div class="mt-2">請先登入會員帳號</div>' +
          '<div class="small mt-1">登入後即可查看您的微微卡日記記錄</div>' +
          '</td></tr>'
        );
      }
    });
    
    // 載入提交記錄更新個人資料區域
    function loadSubmissionsForProfile() {
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submissions/"); ?>' + currentMemberId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            var submissions = response.data && response.data.data ? response.data.data : response.data;
            if (submissions && submissions.length > 0) {
              // 取得最新的提交記錄（第一個）用於年齡、身高
              var latestSubmission = submissions[0];
              // 取得第一次的提交記錄（最後一個）用於目標、行動計畫
              var firstSubmission = submissions[submissions.length - 1];
              updateProfileFromSubmissions(latestSubmission, firstSubmission);
            }
          }
        },
        error: function(xhr, status, error) {
          console.error('載入提交記錄失敗:', error);
          // 如果載入失敗，保持現有的 userdata 顯示
        }
      });
    }
    
    // 使用提交記錄更新個人資料區域
    function updateProfileFromSubmissions(latestData, firstData) {
      // 更新年齡、身高（使用最新資料）
      if (latestData.age) $('#member-age').text(latestData.age);
      if (latestData.height) $('#member-height').text(latestData.height);
      
      // 更新目標、自身行動計畫（使用第一次資料）
      if (firstData.goal) $('#member-goal').text(firstData.goal);
      if (firstData.action_plan_1) $('#action-plan-1').text(firstData.action_plan_1);
      if (firstData.action_plan_2) $('#action-plan-2').text(firstData.action_plan_2);
    }
    
    // 載入提交記錄列表
    function loadSubmissions() {
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submissions/"); ?>' + currentMemberId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            var submissions = response.data && response.data.data ? response.data.data : response.data;
            renderSubmissionsTable(submissions);
          } else {
            var errorMsg = response && response.message ? response.message : '未知錯誤';
            $('#submissions-table-body').html(
              '<tr><td colspan="7" class="text-center text-warning p-4">' +
              '<div><i class="icon ion-alert-circled" style="font-size: 2rem;"></i></div>' +
              '<div class="mt-2">載入失敗: ' + errorMsg + '</div>' +
              '<div class="mt-2"><button class="btn btn-sm btn-outline-primary retry-btn" onclick="loadSubmissions()">重試</button></div>' +
              '</td></tr>'
            );
          }
        },
        error: function(xhr, status, error) {
          console.error('載入提交記錄失敗:', {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText,
            error: error
          });
          
          var errorMessage = '';
          var errorIcon = 'ion-alert-circled';
          
          if (xhr.status === 0) {
            errorMessage = '無法連接到服務器，請檢查網路連線';
            errorIcon = 'ion-wifi';
          } else if (xhr.status === 401) {
            errorMessage = '登入已過期，請重新登入';
            errorIcon = 'ion-person';
          } else if (xhr.status === 403) {
            errorMessage = '沒有權限訪問此資源';
            errorIcon = 'ion-locked';
          } else if (xhr.status === 404) {
            errorMessage = 'API服務不存在或路徑錯誤';
            errorIcon = 'ion-help-circled';
          } else if (xhr.status === 500) {
            errorMessage = '服務器內部錯誤，請稍後再試';
            errorIcon = 'ion-bug';
          } else if (xhr.responseText) {
            try {
              var errorResponse = JSON.parse(xhr.responseText);
              if (errorResponse.message) {
                errorMessage = errorResponse.message;
              } else {
                errorMessage = '載入失敗 (錯誤代碼: ' + xhr.status + ')';
              }
            } catch (e) {
              errorMessage = '載入失敗，響應格式錯誤 (錯誤代碼: ' + xhr.status + ')';
            }
          } else {
            errorMessage = '載入失敗，請稍後再試 (錯誤代碼: ' + xhr.status + ')';
          }
          
          $('#submissions-table-body').html(
            '<tr><td colspan="7" class="text-center text-danger p-4">' +
            '<div><i class="icon ' + errorIcon + '" style="font-size: 2rem;"></i></div>' +
            '<div class="mt-2">' + errorMessage + '</div>' +
            '<div class="mt-2"><button class="btn btn-sm btn-outline-primary retry-btn" onclick="loadSubmissions()">重試</button></div>' +
            '</td></tr>'
          );
        }
      });
    }
    
    // 渲染提交記錄表格
    function renderSubmissionsTable(submissions) {
      if (!submissions) {
        $('#submissions-table-body').html('<tr><td colspan="7" class="text-center text-warning"><i class="icon ion-information-circled mr-2"></i>資料格式錯誤</td></tr>');
        return;
      }
      
      if (submissions.length === 0) {
        $('#submissions-table-body').html(
          '<tr><td colspan="7" class="text-center text-muted p-4">' +
          '<div><i class="icon ion-document-text" style="font-size: 2rem; opacity: 0.5;"></i></div>' +
          '<div class="mt-2">目前尚無微微卡日記記錄</div>' +
          '<div class="small mt-1">點擊下方按鈕開始填寫您的第一筆記錄</div>' +
          '</td></tr>'
        );
        return;
      }
      
      var tableRows = '';
      submissions.forEach(function(submission, index) {
        var bgColor = index % 2 === 0 ? '#E4FBFC' : '#eeeeee';
        var activities = getActivityBadges(submission);
        
        tableRows += '<tr style="background-color: ' + bgColor + ';">';
        tableRows += '<td nowrap="nowrap" class="text-center">' + submission.submission_date + '</td>';
        tableRows += '<td>' + (submission.weight || '-') + '</td>';
        tableRows += '<td>' + (submission.blood_pressure_high || '-') + '</td>';
        tableRows += '<td>' + (submission.blood_pressure_low || '-') + '</td>';
        tableRows += '<td>' + (submission.waist || '-') + '</td>';
        tableRows += '<td>' + activities + '</td>';
        tableRows += '<td>';
        tableRows += '<a href="javascript:void(0);" onclick="viewSubmission(' + submission.id + ')" data-toggle="modal" data-target="#form03view">';
        tableRows += '<i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>';
        tableRows += '</a>　｜　';
        tableRows += '<a href="javascript:void(0);" onclick="editSubmission(' + submission.id + ')" data-toggle="modal" data-target="#form03edit">';
        tableRows += '<i class="icon ion-edit" style="font-size: 1.1rem;"></i>';
        tableRows += '</a>';
        tableRows += '</td>';
        tableRows += '</tr>';
      });
      
      $('#submissions-table-body').html(tableRows);
    }
    
    // 取得活動標記
    function getActivityBadges(submission) {
      var badges = [];
      
      // 檢查不同可能的資料結構
      var activities = submission.activities || [];
      
      // 如果 activities 是空的，嘗試直接從 submission 物件檢查活動欄位
      if (activities.length === 0) {
        // 直接檢查 submission 中的活動欄位
        if (submission.hand_measure == 1 || submission.hand_measure === true) {
          badges.push('<span class="badge badge-primary">手</span>');
        }
        if (submission.exercise == 1 || submission.exercise === true) {
          badges.push('<span class="badge badge-warning">運</span>');
        }
        if (submission.health_supplement == 1 || submission.health_supplement === true) {
          badges.push('<span class="badge badge-success">健</span>');
        }
        if (submission.weika == 1 || submission.weika === true) {
          badges.push('<span class="badge badge-info">微</span>');
        }
        if (submission.water_intake == 1 || submission.water_intake === true) {
          badges.push('<span class="badge badge-secondary">水</span>');
        }
      } else {
        // 使用原來的 activities 陣列處理方式
        activities.forEach(function(activity) {
          switch(activity.item_key) {
            case 'hand_measure':
              badges.push('<span class="badge badge-primary">手</span>');
              break;
            case 'exercise':
              badges.push('<span class="badge badge-warning">運</span>');
              break;
            case 'health_supplement':
              badges.push('<span class="badge badge-success">健</span>');
              break;
            case 'weika':
              badges.push('<span class="badge badge-info">微</span>');
              break;
            case 'water_intake':
              badges.push('<span class="badge badge-secondary">水</span>');
              break;
          }
        });
      }
      
      return badges.join(' ');
    }
    
    // 檢視提交記錄
    function viewSubmission(submissionId) {
      currentSubmissionId = submissionId;
      
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success && response.data) {
            populateViewModal(response.data);
          } else {
            Swal.fire({
              title: '載入失敗',
              text: response.message || '未知錯誤',
              icon: 'error',
              confirmButtonText: '確定'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('載入詳細資料失敗:', error);
          Swal.fire({
            title: '載入失敗',
            text: '載入詳細資料失敗，請稍後再試',
            icon: 'error',
            confirmButtonText: '確定'
          });
        }
      });
    }
    
    // 編輯提交記錄
    function editSubmission(submissionId) {
      currentSubmissionId = submissionId;
      
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success && response.data) {
            populateEditModal(response.data);
          } else {
            Swal.fire({
              title: '載入失敗',
              text: response.message || '未知錯誤',
              icon: 'error',
              confirmButtonText: '確定'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('載入編輯資料失敗:', error);
          Swal.fire({
            title: '載入失敗',
            text: '載入編輯資料失敗，請稍後再試',
            icon: 'error',
            confirmButtonText: '確定'
          });
        }
      });
    }
    
    // 從檢視模態視窗切換到編輯模態視窗
    function switchToEditModal() {
      // 先關閉檢視模態視窗
      $('#form03view').modal('hide');
      
      // 等待檢視模態視窗完全關閉後再開啟編輯模態視窗
      $('#form03view').on('hidden.bs.modal', function() {
        // 移除事件監聽器避免重複綁定
        $(this).off('hidden.bs.modal');
        
        // 確保當前有選中的提交記錄
        if (currentSubmissionId) {
          // 開啟編輯模態視窗並載入資料
          editSubmission(currentSubmissionId);
          $('#form03edit').modal('show');
        }
      });
    }
    
    // 填入檢視模態視窗
    function populateViewModal(data) {
      // 填寫日期
      $('#form03view .col-sm-12.text-right').html('填寫日期：' + (data.submission_date || '未設定'));
      
      // 基本資料 - 使用更精確的選擇器
      $('#form03view .row > .col-sm-4:has(label:contains("會員姓名")) p').text(data.member_name || '未設定');
      $('#form03view .row > .col-sm-4:has(label:contains("會員編號")) p').text(data.member_id || '未設定');
      $('#form03view .row > .col-sm-2:has(label:contains("年齡")) p').text(data.age || '未設定');
      $('#form03view .row > .col-sm-2:has(label:contains("身高")) p').text(data.height || '未設定');
      $('#form03view .row > .col-sm-12:has(label:contains("目標")) p').text(data.goal || '未設定');
      
      // 自身行動計畫
      $('#form03view .alert-warning .col-sm-12:has(label:contains("自身行動計畫1")) p').text(data.action_plan_1 || '未設定');
      $('#form03view .alert-warning .col-sm-12:has(label:contains("自身行動計畫2")) p').text(data.action_plan_2 || '未設定');
      
      // 身體數據 - 使用更精確的選擇器
      $('#form03view .card .row .col-sm-3:has(label:contains("體重")) p').text((data.weight || '未填寫') + (data.weight ? ' 公斤' : ''));
      $('#form03view .card .row .col-sm-3:has(label:contains("血壓(收)")) p').text(data.blood_pressure_high || '未填寫');
      $('#form03view .card .row .col-sm-3:has(label:contains("血壓(舒)")) p').text(data.blood_pressure_low || '未填寫');
      $('#form03view .card .row .col-sm-3:has(label:contains("腰圍")) p').text((data.waist || '未填寫') + (data.waist ? ' 公分' : ''));
      
      // 共同行動項目 (checkboxes) - 處理不同的資料結構
      var activities = data.activities || [];
      
      // 重置所有checkbox
      $('#form03view .form-check-input').prop('checked', false);
      
      if (activities.length > 0) {
        // 如果有 activities 陣列，使用原來的方式
        var activityMap = {
          'hand_measure': 0,
          'exercise': 1, 
          'health_supplement': 2,
          'weika': 3,
          'water_intake': 4
        };
        
        activities.forEach(function(activity) {
          if (activityMap.hasOwnProperty(activity.item_key)) {
            var index = activityMap[activity.item_key];
            $('#form03view .form-check-input').eq(index).prop('checked', true);
          }
        });
      } else {
        // 如果沒有 activities 陣列，直接檢查欄位
        if (data.hand_measure == 1 || data.hand_measure === true) $('#form03view .form-check-input').eq(0).prop('checked', true);
        if (data.exercise == 1 || data.exercise === true) $('#form03view .form-check-input').eq(1).prop('checked', true);
        if (data.health_supplement == 1 || data.health_supplement === true) $('#form03view .form-check-input').eq(2).prop('checked', true);
        if (data.weika == 1 || data.weika === true) $('#form03view .form-check-input').eq(3).prop('checked', true);
        if (data.water_intake == 1 || data.water_intake === true) $('#form03view .form-check-input').eq(4).prop('checked', true);
      }
      
      $('#form03view .card .row .col-sm-12:has(label:contains("計畫a.")) p').text(data.plans[0].plan_content || '未填寫');
      $('#form03view .card .row .col-sm-12:has(label:contains("計畫b.")) p').text(data.plans[1].plan_content || '未填寫');
      $('#form03view .card .row .col-sm-12:has(label:contains("其他")) p').text(data.plans[2].plan_content || '未填寫');
    }
    
    // 填入編輯模態視窗
    function populateEditModal(data) {
      // 填寫日期
      $('#form03edit .col-sm-12.text-right').html('填寫日期：' + (data.submission_date || '未設定'));
      
      // 基本資料 - 使用更精確的選擇器
      $('#form03edit .row > .col-sm-4:has(label:contains("會員姓名")) input').val(data.member_name || '');
      $('#form03edit .row > .col-sm-4:has(label:contains("會員編號")) input').val(data.member_id || '');
      $('#form03edit .row > .col-sm-2:has(label:contains("年齡")) input').val(data.age || '');
      $('#form03edit .row > .col-sm-2:has(label:contains("身高")) input').val(data.height || '');
      
      // 目標欄位 - 設為唯讀
      var goalInput = $('#form03edit .row > .col-sm-12:has(label:contains("目標")) input');
      goalInput.val(data.goal || '').attr('readonly', true).css('background-color', '#f8f9fa');
      
      // 自身行動計畫 - 設為唯讀
      var actionPlan1Input = $('#form03edit .alert-warning .col-sm-12:has(label:contains("自身行動計畫1")) input');
      actionPlan1Input.val(data.action_plan_1 || '').attr('readonly', true).css('background-color', '#f8f9fa');
      
      var actionPlan2Input = $('#form03edit .alert-warning .col-sm-12:has(label:contains("自身行動計畫2")) input');
      actionPlan2Input.val(data.action_plan_2 || '').attr('readonly', true).css('background-color', '#f8f9fa');
      
      // 身體數據 - 使用更精確的選擇器
      $('#form03edit .card .row .col-sm-3:has(label:contains("體重")) input').val(data.weight || '');
      $('#form03edit .card .row .col-sm-3:has(label:contains("血壓(收)")) input').val(data.blood_pressure_high || '');
      $('#form03edit .card .row .col-sm-3:has(label:contains("血壓(舒)")) input').val(data.blood_pressure_low || '');
      $('#form03edit .card .row .col-sm-3:has(label:contains("腰圍")) input').val(data.waist || '');
      
      // 共同行動項目 (checkboxes) - 處理不同的資料結構
      var activities = data.activities || [];
      
      // 重置所有checkbox
      $('#form03edit .form-check-input').prop('checked', false);
      
      if (activities.length > 0) {
        // 如果有 activities 陣列，使用原來的方式
        var activityMap = {
          'hand_measure': 0,
          'exercise': 1,
          'health_supplement': 2,
          'weika': 3,
          'water_intake': 4
        };
        
        activities.forEach(function(activity) {
          if (activityMap.hasOwnProperty(activity.item_key)) {
            var index = activityMap[activity.item_key];
            $('#form03edit .form-check-input').eq(index).prop('checked', true);
          }
        });
      } else {
        // 如果沒有 activities 陣列，直接檢查欄位
        if (data.hand_measure == 1 || data.hand_measure === true) $('#form03edit .form-check-input').eq(0).prop('checked', true);
        if (data.exercise == 1 || data.exercise === true) $('#form03edit .form-check-input').eq(1).prop('checked', true);
        if (data.health_supplement == 1 || data.health_supplement === true) $('#form03edit .form-check-input').eq(2).prop('checked', true);
        if (data.weika == 1 || data.weika === true) $('#form03edit .form-check-input').eq(3).prop('checked', true);
        if (data.water_intake == 1 || data.water_intake === true) $('#form03edit .form-check-input').eq(4).prop('checked', true);
      }
            
      $('#form03edit .card .row .col-sm-12:has(label:contains("計畫a.")) input').val(data.plans[0].plan_content || '');
      $('#form03edit .card .row .col-sm-12:has(label:contains("計畫b.")) input').val(data.plans[1].plan_content || '');
      $('#form03edit .card .row .col-sm-12:has(label:contains("其他")) input').val(data.plans[2].plan_content || '');
    }
    
    // 更新提交記錄
    function updateSubmission() {
      if (!currentSubmissionId) {
        alert('請先選擇要更新的記錄');
        return;
      }
      
      // 收集編輯表單的資料
      var formData = collectEditFormData();
      
      if (!validateFormData(formData)) {
        return;
      }
      
      $.ajax({
        url: '<?php echo base_url("api/eeform3/update/"); ?>' + currentSubmissionId,
        method: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
          $('button[onclick="updateSubmission()"]').prop('disabled', true).text('更新中...');
        },
        success: function(response) {
          if (response && response.success) {
            Swal.fire({
              title: '更新成功',
              text: '資料已成功更新',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              $('#form03edit').modal('hide');
              loadSubmissions();
            });
          } else {
            Swal.fire({
              title: '更新失敗',
              text: response.message || '未知錯誤',
              icon: 'error',
              confirmButtonText: '確定'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('更新失敗:', error);
          Swal.fire({
            title: '更新失敗',
            text: '請稍後再試',
            icon: 'error',
            confirmButtonText: '確定'
          });
        },
        complete: function() {
          $('button[onclick="updateSubmission()"]').prop('disabled', false).text('更新表單');
        }
      });
    }
    
    // 收集編輯表單資料
    function collectEditFormData() {
      return {
        // 基本資料 - 使用更精確的選擇器
        member_name: $('#form03edit .row > .col-sm-4:has(label:contains("會員姓名")) input').val() || '',
        member_id: $('#form03edit .row > .col-sm-4:has(label:contains("會員編號")) input').val() || '',
        age: $('#form03edit .row > .col-sm-2:has(label:contains("年齡")) input').val() || '',
        height: $('#form03edit .row > .col-sm-2:has(label:contains("身高")) input').val() || '',
        goal: $('#form03edit .row > .col-sm-12:has(label:contains("目標")) input').val() || '',
        
        // 自身行動計畫
        action_plan_1: $('#form03edit .alert-warning .col-sm-12:has(label:contains("自身行動計畫1")) input').val() || '',
        action_plan_2: $('#form03edit .alert-warning .col-sm-12:has(label:contains("自身行動計畫2")) input').val() || '',
        
        // 身體數據 - 使用更精確的選擇器
        weight: $('#form03edit .card .row .col-sm-3:has(label:contains("體重")) input').val() || '',
        blood_pressure_high: $('#form03edit .card .row .col-sm-3:has(label:contains("血壓(收)")) input').val() || '',
        blood_pressure_low: $('#form03edit .card .row .col-sm-3:has(label:contains("血壓(舒)")) input').val() || '',
        waist: $('#form03edit .card .row .col-sm-3:has(label:contains("腰圍")) input').val() || '',
        
        // 共同行動項目 (checkboxes)
        hand_measure: $('#form03edit .form-check-input:eq(0)').is(':checked') ? 1 : 0,
        exercise: $('#form03edit .form-check-input:eq(1)').is(':checked') ? 1 : 0,
        health_supplement: $('#form03edit .form-check-input:eq(2)').is(':checked') ? 1 : 0,
        weika: $('#form03edit .form-check-input:eq(3)').is(':checked') ? 1 : 0,
        water_intake: $('#form03edit .form-check-input:eq(4)').is(':checked') ? 1 : 0,
        
        // 其他計畫 - 使用更精確的選擇器（注意標籤包含點號）
        plan_a: $('#form03edit .card .row .col-sm-12:has(label:contains("計畫a.")) input').val() || '',
        plan_b: $('#form03edit .card .row .col-sm-12:has(label:contains("計畫b.")) input').val() || '',
        other: $('#form03edit .card .row .col-sm-12:has(label:contains("其他")) input').val() || ''
      };
    }
    
    // 驗證表單資料
    function validateFormData(data) {
      var requiredFields = ['member_name', 'member_id', 'age', 'height', 'goal'];
      
      for (var i = 0; i < requiredFields.length; i++) {
        if (!data[requiredFields[i]] || data[requiredFields[i]].trim() === '') {
          alert('請填寫所有必填欄位');
          return false;
        }
      }
      
      return true;
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