<!doctype html>
<html lang="zh-Hant-TW">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">
  <meta name="description" content="Arsoa 安露莎化粧品">
  <meta name="author" content="Paul, Logan Cee">

  <title>Arsoa 安露莎化粧品 - 微微卡日記列表</title>

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
      <?= $this->block_service->load_html_header(); ?>


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
                <h1 class="h2-3d font-libre"><strong>微微卡日記管理</strong></h1>
                <div class="mb30">
                  <div class="container">
                    <form action="#" class="text-left">
                      <div class="row">

                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員姓名</label>
                          <p id="member-name">載入中...</p>
                        </div>
                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員編號</label>
                          <p id="member-id">載入中...</p>
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">年齡</label>
                          <p id="member-age">-</p>
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">身高</label>
                          <p id="member-height">-</p>
                        </div>
                        <div class="col-sm-12 mb30">
                          <label class="label-custom">目標</label>
                          <p id="member-goal">載入中...</p>
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
                              <p id="action-plan-1">載入中...</p>
                            </div>
                            <div class="col-sm-12 mb30">
                              <label class="label-custom">自身行動計畫2.</label>
                              <p id="action-plan-2">載入中...</p>
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
                                    <td colspan="7" class="text-center">載入中...</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 mb30">
                          <hr class="my-4">
                          <a href="<?php echo base_url('eeform/eform03'); ?>" class="btn btn-outline-danger btn-block">填寫微微卡日記</a>
                        </div>

                      </div>
                    </form>
                  </div>
                </div>

              </div>

              <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

              <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                <!-- 側邊欄清單 -->
                <?= $this->block_service->electronic_form_right_menu(); ?>
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
          <h5 class="modal-title">檢視微微卡日記</h5>
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
                    <a href="javascript:;" class="btn btn-outline-danger btn-block" data-dismiss="modal" data-toggle="modal" data-target="#form03edit">我要修改</a>
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
          <h5 class="modal-title">編輯微微卡日記</h5>
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
    var currentMemberId = 'M001234'; // 假設的會員ID，實際應該從登入狀態取得
    var currentSubmissionId = null; // 當前選中的提交記錄ID
    
    // 頁面載入時初始化
    $(document).ready(function() {
      loadMemberData();
      loadSubmissions();
    });
    
    // 載入會員基本資料
    function loadMemberData() {
      // 這裡應該從API獲取會員資料，暫時使用假資料
      $('#member-name').text('張小明');
      $('#member-id').text(currentMemberId);
      $('#member-age').text('35');
      $('#member-height').text('170');
      $('#member-goal').text('減重5公斤並維持健康體態');
      $('#action-plan-1').text('每天早上做30分鐘瑜珈');
      $('#action-plan-2').text('晚餐後散步1小時');
    }
    
    // 載入提交記錄列表
    function loadSubmissions() {
      $.ajax({
        url: '<?php echo base_url("api/eeform3/submissions/"); ?>' + currentMemberId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            renderSubmissionsTable(response.data.data);
          } else {
            $('#submissions-table-body').html('<tr><td colspan="7" class="text-center text-danger">載入失敗: ' + response.message + '</td></tr>');
          }
        },
        error: function(xhr, status, error) {
          console.error('載入提交記錄失敗:', error);
          $('#submissions-table-body').html('<tr><td colspan="7" class="text-center text-danger">載入失敗，請稍後再試</td></tr>');
        }
      });
    }
    
    // 渲染提交記錄表格
    function renderSubmissionsTable(submissions) {
      if (!submissions || submissions.length === 0) {
        $('#submissions-table-body').html('<tr><td colspan="7" class="text-center">尚無記錄</td></tr>');
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
      var activities = submission.activities || [];
      
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
      
      return badges.join(' ');
    }
    
    // 檢視提交記錄
    function viewSubmission(submissionId) {
      currentSubmissionId = submissionId;
      // 載入並顯示特定提交記錄的詳細資料
      // 這裡應該調用API獲取詳細資料並填入檢視模態視窗
      console.log('檢視提交記錄:', submissionId);
    }
    
    // 編輯提交記錄
    function editSubmission(submissionId) {
      currentSubmissionId = submissionId;
      // 載入並顯示特定提交記錄的詳細資料到編輯表單
      // 這裡應該調用API獲取詳細資料並填入編輯模態視窗
      console.log('編輯提交記錄:', submissionId);
    }
    
    // 更新提交記錄
    function updateSubmission() {
      if (!currentSubmissionId) {
        alert('請先選擇要更新的記錄');
        return;
      }
      
      // 收集編輯表單的資料並提交更新
      // 這裡應該實作表單資料收集和API調用
      console.log('更新提交記錄:', currentSubmissionId);
      
      // 更新完成後重新載入列表並關閉模態視窗
      $('#form03edit').modal('hide');
      loadSubmissions();
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