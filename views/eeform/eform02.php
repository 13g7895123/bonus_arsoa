  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?= $this->block_service->load_html_header(); ?>


        <div class="section-mini">


          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>會員服務追蹤管理表(肌膚)</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="#" method="POST" class="text-left" id="eform02">
                        <div class="row">
                          <div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>

                          <div class="col-sm-4 mb30">
                            <label class="label-custom">姓名</label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">入會日</label>
                            <input type="date" name="join_date" class="form-control form-control-custom" required />
                          </div>
                          <div class="col-sm-2 mb30">
                            <label class="label-custom">性別</label>
                            <select name="gender" class="form-control form-control-custom" required>
                              <option value="">請選擇</option>
                              <option value="女">女</option>
                              <option value="男">男</option>
                            </select>
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">年齡</label>
                            <input type="number" name="age" class="form-control form-control-custom" placeholder="限填數字" required />
                          </div>
                          <div class="col-sm-12 mb30">
                            <label class="label-custom">肌膚/健康狀況</label>
                            <input type="text" name="skin_health_condition" class="form-control form-control-custom" placeholder="請填寫肌膚/健康狀況…" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <h5>訂購產品</h5>
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">淨白活膚蜜皂</label>
                                      <input type="number" name="product_soap001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">AP柔敏潔顏皂</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">活顏泥膜</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎化粧水I</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎化粧水II</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎活膚化粧水</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">柔敏化粧水</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎精華液I</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎精華液II</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">安露莎活膚精華液</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">美白精華液</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">保濕潤膚液</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">美容防皺油</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">保濕凝膠</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">亮采晶萃</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">防曬隔離液</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">保濕粉底液</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">絲柔粉餅</label>
                                      <input type="text" style="width: 100%;" placeholder="請填寫數量…">
                                    </div>


                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">LINE</label>
                            <input type="text" name="line_contact" class="form-control form-control-custom" placeholder="請填寫LINE聯絡狀況，300字元內…" maxlength="300" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">TEL</label>
                            <input type="text" name="tel_contact" class="form-control form-control-custom" placeholder="請填寫電話聯絡狀況，300字元內…" maxlength="300" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">見面日</label>
                            <input type="date" name="meeting_date" class="form-control form-control-custom" />
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
                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                  <!-- 側邊欄清單 -->
                  <?= $this->block_service->electronic_form_right_menu('eform2'); ?>
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
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">性別：</span>
                      <span class="text-dark" id="confirm-gender"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">年齡：</span>
                      <span class="text-dark" id="confirm-age"></span> 歲
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">入會日：</span>
                      <span class="text-dark" id="confirm-join-date"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">見面日：</span>
                      <span class="text-dark" id="confirm-meeting-date"></span>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 80px;">健康狀況：</span>
                      <span class="text-dark" id="confirm-skin-health"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 產品訂購 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  產品訂購
                </h6>
              </div>
              <div class="p-3" id="confirm-products">
                <!-- Products will be populated here -->
              </div>
            </div>

            <!-- 聯絡資訊 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  聯絡資訊
                </h6>
              </div>
              <div class="p-3">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 60px;">LINE：</span>
                      <span class="text-dark" id="confirm-line-contact"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="text-muted mr-3" style="min-width: 60px;">電話：</span>
                      <span class="text-dark" id="confirm-tel-contact"></span>
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
      var showTestButton = false; // 設為 false 隱藏測試按鈕
      
      // 頁面載入時檢查是否顯示測試按鈕
      $(document).ready(function() {
        if (showTestButton) {
          $('#testDataButton').show();
        }
      });
      
      // 填入測試資料的函數
      function fillTestData() {
        $('input[name="member_name"]').val('測試會員');
        $('input[name="join_date"]').val('2023-01-15');
        $('select[name="gender"]').val('女');
        $('input[name="age"]').val('30');
        $('input[name="skin_health_condition"]').val('輕微乾燥，偶有敏感');
        $('input[name="product_soap001"]').val('2');
        $('input[name="line_contact"]').val('與會員保持良好互動，定期關心產品使用狀況');
        $('input[name="tel_contact"]').val('每月電話追蹤，了解產品效果和需求');
        $('input[name="meeting_date"]').val('2025-09-15');
      }

      function showConfirmModal() {
        // 驗證必填欄位
        var memberName = $('input[name="member_name"]').val();
        var joinDate = $('input[name="join_date"]').val();
        var gender = $('select[name="gender"]').val();
        var age = $('input[name="age"]').val();

        if (!memberName || !joinDate || !gender || !age) {
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
        $('#confirm-join-date').text(joinDate);
        $('#confirm-gender').text(gender);
        $('#confirm-age').text(age);
        $('#confirm-meeting-date').text($('input[name="meeting_date"]').val() || '(未填寫)');
        $('#confirm-skin-health').text($('input[name="skin_health_condition"]').val() || '(未填寫)');
        
        // 聯絡資訊
        $('#confirm-line-contact').text($('input[name="line_contact"]').val() || '(未填寫)');
        $('#confirm-tel-contact').text($('input[name="tel_contact"]').val() || '(未填寫)');
        
        // 收集產品資料
        var productData = [];
        var productMapping = {
          'product_soap001': '淨白活膚蜜皂',
          'product_soap002': 'AP柔敏潔顏皂',
          'product_mask001': '活顏泥膜',
          'product_toner001': '安露莎化粧水I',
          'product_toner002': '安露莎化粧水II',
          'product_toner003': '安露莎活膚化粧水',
          'product_toner004': '柔敏化粧水',
          'product_serum001': '安露莎精華液I',
          'product_serum002': '安露莎精華液II',
          'product_serum003': '安露莎活膚精華液',
          'product_serum004': '美白精華液',
          'product_lotion001': '保濕潤膚液',
          'product_oil001': '美容防皺油',
          'product_gel001': '保濕凝膠',
          'product_essence001': '亮采晶萃',
          'product_sunscreen001': '防曬隔離液',
          'product_foundation001': '保濕粉底液',
          'product_powder001': '絲柔粉餅'
        };

        // 收集所有產品輸入框的數據
        $('#eform02').find('input[type="number"], input[name^="product_"]').each(function() {
          var name = $(this).attr('name');
          var value = $(this).val();
          var label = $(this).closest('.col-sm-3').find('label').text();
          
          if (value && parseInt(value) > 0) {
            productData.push({
              name: name,
              label: label,
              quantity: value
            });
          }
        });

        var productHtml = '';
        if (productData.length > 0) {
          productData.forEach(function(product) {
            productHtml += '<div class="d-flex align-items-center mb-2">';
            productHtml += '<span class="text-muted mr-3" style="min-width: 120px;">' + product.label + '：</span>';
            productHtml += '<span class="text-dark">' + product.quantity + ' 個</span>';
            productHtml += '</div>';
          });
        } else {
          productHtml = '<span class="text-muted">未訂購任何產品</span>';
        }
        $('#confirm-products').html(productHtml);
        
        // 顯示模態視窗
        $('#confirmModal').modal('show');
      }

      function submitForm() {
        // 收集表單資料
        var formData = {
          member_name: $('input[name="member_name"]').val(),
          join_date: $('input[name="join_date"]').val(),
          gender: $('select[name="gender"]').val(),
          age: $('input[name="age"]').val(),
          skin_health_condition: $('input[name="skin_health_condition"]').val(),
          line_contact: $('input[name="line_contact"]').val(),
          tel_contact: $('input[name="tel_contact"]').val(),
          meeting_date: $('input[name="meeting_date"]').val(),
          products: {}
        };

        // 收集產品資料
        $('#eform02').find('input[type="number"], input[name^="product_"]').each(function() {
          var name = $(this).attr('name');
          var value = $(this).val();
          var label = $(this).closest('.col-sm-3').find('label').text();
          
          if (name && (value || value === '0')) {
            formData.products[name] = {
              name: label,
              quantity: parseInt(value) || 0
            };
          }
        });

        // 發送API請求
        $.ajax({
          url: '<?php echo base_url("api/eeform2/submit"); ?>',
          method: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          dataType: 'json',
          beforeSend: function() {
            // 顯示載入狀態
            $('#confirmModal .modal-footer button').prop('disabled', true);
            $('#confirmModal .modal-footer .btn-danger').text('提交中...');
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
                // 返回到來源頁面
                if (document.referrer) {
                  window.location.href = document.referrer;
                } else {
                  window.location.href = '<?php echo base_url("eform"); ?>';
                }
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
          },
          complete: function() {
            // 恢復按鈕狀態
            $('#confirmModal .modal-footer button').prop('disabled', false);
            $('#confirmModal .modal-footer .btn-danger').text('確認送出');
          }
        });
      }
    </script>

  </body>

  </html>