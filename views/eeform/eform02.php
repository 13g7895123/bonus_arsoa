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
                          <div class="col-sm-12 text-right mb30">填寫日期：<span id="current-date"></span></div>

                          <div class="col-sm-3 mb30">
                            <label class="label-custom">會員編號</label>
                            <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="<?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : ''; ?>" readonly required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">姓名<span style="color: red;">(*必填)</span></label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" required />
                            <select name="member_name_select" class="form-control form-control-custom" style="display: none;" required>
                              <option value="">請選擇會員</option>
                            </select>
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
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">出生年月日<span style="color: red;">(*必填)</span></label>
                            <input type="date" name="birth_year_month" class="form-control form-control-custom" required />
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
                                  <div class="row" id="products-container">
                                    <!-- 動態載入產品 -->
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
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 60px;">姓名：</span>
                      <span class="text-dark" id="confirm-member-name"></span>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 70px;">會員編號：</span>
                      <span class="text-dark" id="confirm-member-id"></span>
                    </div>
                  </div>
                  <div class="col-md-2 mb-3">
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
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="text-muted mr-3" style="min-width: 70px;">出生年月日：</span>
                      <span class="text-dark" id="confirm-birth-year-month"></span>
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
      var showTestButton = false; // 設為 true 顯示測試按鈕
      var productsData = []; // 存儲從API載入的產品資料
      
      // 頁面載入時檢查是否顯示測試按鈕
      $(document).ready(function() {
        // 自動填入當天日期
        var today = new Date();
        var currentDate = today.getFullYear() + '-' + 
                         String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                         String(today.getDate()).padStart(2, '0');
        
        $('#current-date').text(currentDate);
        $('input[name="join_date"]').val(currentDate);
        
        if (showTestButton) {
          $('#testDataButton').show();
        }
        
        // 載入產品資料
        loadProducts();
      });
      
      // 載入產品資料
      function loadProducts() {
        $.ajax({
          url: '<?php echo base_url("api/eeform/eeform2/products"); ?>',
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.success && response.data) {
              productsData = response.data;
              renderProducts(response.data);
            } else {
              console.error('載入產品資料失敗:', response.message);
              // 顯示錯誤訊息或使用預設產品
              renderDefaultProducts();
            }
          },
          error: function(xhr, status, error) {
            console.error('載入產品資料失敗:', error);
            // 使用預設產品作為備援
            renderDefaultProducts();
          }
        });
      }
      
      // 渲染產品列表
      function renderProducts(products) {
        var container = $('#products-container');
        container.empty();
        
        if (!products || products.length === 0) {
          container.append('<div class="col-12"><p class="text-muted">暫無可用產品</p></div>');
          return;
        }
        
        products.forEach(function(product) {
          var fieldName = 'product_' + product.product_code.toLowerCase();
          var productHtml = `
            <div class="col-sm-3 mb20">
              <label class="label-custom">${product.product_name}</label>
              <input type="number" name="${fieldName}" style="width: 100%;" 
                     placeholder="請填寫數量…" min="0" 
                     data-product-code="${product.product_code}"
                     data-product-name="${product.product_name}">
            </div>
          `;
          container.append(productHtml);
        });
      }
      
      // 預設產品 (備援)
      function renderDefaultProducts() {
        var defaultProducts = [
          {product_code: 'SOAP001', product_name: '淨白活膚蜜皂'},
          {product_code: 'SOAP002', product_name: 'AP柔敏潔顏皂'},
          {product_code: 'MASK001', product_name: '活顏泥膜'},
          {product_code: 'TONER001', product_name: '安露莎化粧水I'},
          {product_code: 'TONER002', product_name: '安露莎化粧水II'},
          {product_code: 'TONER003', product_name: '安露莎活膚化粧水'},
          {product_code: 'TONER004', product_name: '柔敏化粧水'},
          {product_code: 'SERUM001', product_name: '安露莎精華液I'},
          {product_code: 'SERUM002', product_name: '安露莎精華液II'},
          {product_code: 'SERUM003', product_name: '安露莎活膚精華液'},
          {product_code: 'SERUM004', product_name: '美白精華液'},
          {product_code: 'LOTION001', product_name: '保濕潤膚液'},
          {product_code: 'OIL001', product_name: '美容防皺油'},
          {product_code: 'GEL001', product_name: '保濕凝膠'},
          {product_code: 'ESSENCE001', product_name: '亮采晶萃'},
          {product_code: 'SUNSCREEN001', product_name: '防曬隔離液'},
          {product_code: 'FOUNDATION001', product_name: '保濕粉底液'},
          {product_code: 'POWDER001', product_name: '絲柔粉餅'}
        ];
        renderProducts(defaultProducts);
      }
      
      // 填入測試資料的函數
      function fillTestData() {
        // 只在用戶資料為空時填入測試資料
        if (!$('input[name="member_name"]').val()) {
          $('input[name="member_name"]').val('測試會員');
        }
        if (!$('input[name="member_id"]').val()) {
          $('input[name="member_id"]').val('TEST001');
        }
        $('input[name="join_date"]').val('2023-01-15');
        $('select[name="gender"]').val('女');
        $('input[name="age"]').val('30');
        $('input[name="birth_year_month"]').val('1994-03-15');
        $('input[name="skin_health_condition"]').val('輕微乾燥，偶有敏感');
        
        // 動態填入產品數量測試資料
        $('#products-container input[type="number"]').each(function(index) {
          var testQuantities = [2, 1, 3, 2, 1, 2, 1, 2, 1, 1, 2, 3, 1, 2, 1, 2, 1, 2];
          var quantity = testQuantities[index % testQuantities.length] || 1;
          $(this).val(quantity);
        });
        
        $('input[name="line_contact"]').val('與會員保持良好互動，定期關心產品使用狀況');
        $('input[name="tel_contact"]').val('每月電話追蹤，了解產品效果和需求');
      }

      function showConfirmModal() {
        // 驗證必填欄位
        var memberName = $('input[name="member_name"]').val();
        var memberId = $('input[name="member_id"]').val();
        var joinDate = $('input[name="join_date"]').val();
        var gender = $('select[name="gender"]').val();
        var age = $('input[name="age"]').val();
        var birthYearMonth = $('input[name="birth_year_month"]').val();

        if (!memberName || !memberId || !joinDate || !birthYearMonth) {
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
        $('#confirm-join-date').text(joinDate);
        $('#confirm-gender').text(gender);
        $('#confirm-age').text(age);
        // 將 YYYY-MM-DD 格式轉換為 YYYY年MM月DD日 格式顯示
        var birthDateDisplay = '';
        if (birthYearMonth) {
          var parts = birthYearMonth.split('-');
          if (parts.length === 3) {
            birthDateDisplay = parts[0] + '年' + parts[1] + '月' + parts[2] + '日';
          } else {
            birthDateDisplay = birthYearMonth; // 如果格式不正確，直接顯示原值
          }
        }
        $('#confirm-birth-year-month').text(birthDateDisplay || '(未填寫)');
        $('#confirm-meeting-date').text($('input[name="meeting_date"]').val() || '(未填寫)');
        $('#confirm-skin-health').text($('input[name="skin_health_condition"]').val() || '(未填寫)');
        
        // 聯絡資訊
        $('#confirm-line-contact').text($('input[name="line_contact"]').val() || '(未填寫)');
        $('#confirm-tel-contact').text($('input[name="tel_contact"]').val() || '(未填寫)');
        
        // 收集產品資料 (動態)
        var productData = [];

        // 收集所有產品輸入框的數據
        $('#products-container input[type="number"]').each(function() {
          var $input = $(this);
          var name = $input.attr('name');
          var value = $input.val();
          var label = $input.closest('.col-sm-3').find('label').text();
          var productCode = $input.data('product-code');
          var productName = $input.data('product-name');
          
          if (value && parseInt(value) > 0) {
            productData.push({
              name: name,
              label: productName || label,
              quantity: value,
              product_code: productCode
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
          member_id: memberId, // 保留欄位但可能為空（相容性）
          member_name: memberName, // 被填表人姓名
          form_filler_id: formFillerID, // 代填問卷者ID（當前登入使用者）
          form_filler_name: formFillerName, // 代填問卷者姓名
          join_date: $('input[name="join_date"]').val(),
          gender: $('select[name="gender"]').val(),
          age: $('input[name="age"]').val(),
          birth_year_month: $('input[name="birth_year_month"]').val(),
          skin_health_condition: $('input[name="skin_health_condition"]').val(),
          line_contact: $('input[name="line_contact"]').val(),
          tel_contact: $('input[name="tel_contact"]').val(),
          meeting_date: $('input[name="meeting_date"]').val(),
          products: {}
        };

        // 收集產品資料 (動態)
        $('#products-container input[type="number"]').each(function() {
          var $input = $(this);
          var name = $input.attr('name');
          var value = $input.val();
          var label = $input.closest('.col-sm-3').find('label').text();
          var productCode = $input.data('product-code');
          var productName = $input.data('product-name');
          
          if (name && (value || value === '0')) {
            formData.products[name] = {
              name: productName || label,
              quantity: parseInt(value) || 0,
              product_code: productCode
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
                // 直接跳轉到 eform2_list 頁面
                window.location.href = '<?php echo base_url("eform/eform2_list"); ?>';
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
        // 設定會員編號欄位
        $('input[name="member_id"]').val(currentUserData.member_id);
        
        // Point 60: 無論是否有會員編號，都進行測試API呼叫來確認端點是否正常
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
        var apiUrl = '<?php echo base_url("api/eeform2/member_lookup/"); ?>' + memberId;
        
        $.ajax({
          url: apiUrl,
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log('[Point 62 - eform2] API 回應成功:', response);
            
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
              console.log('[Point 62 - eform2] API 回應格式不正確:', response);
            }
          },
          error: function(xhr, status, error) {            
            // 出錯時使用預設值
            $('input[name="member_name"]').val(currentUserData.member_name);
          },
          complete: function(xhr, status) {}
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

      // 修改提交表單函數以處理會員選擇
      var originalSubmitForm = submitForm;
      submitForm = function() {        
        // 收集表單資料
        var memberId, memberName;
        
        // 根據是否為多重會員選擇不同的取值方式
        if (isMultipleMembers && $('select[name="member_name_select"]').is(':visible')) {
          // 使用下拉選單的值
          var selectedOption = $('select[name="member_name_select"]').find('option:selected');
          memberId = selectedOption.val();
          memberName = selectedOption.data('name');
        } else {
          // 使用輸入框和當前會員資料
          memberId = currentUserData.member_id;
          memberName = $('input[name="member_name"]').val();
        }
                
        // 確保表單欄位有正確的值
        $('input[name="member_id"]').val(memberId);
        $('input[name="member_name"]').val(memberName);
        
        // 呼叫原始的提交函數
        originalSubmitForm();
      }

      // 頁面載入時初始化會員資料
      $(document).ready(function() {
        console.log('[Point 62 - eform2] ===== 頁面載入完成，開始初始化會員查詢功能 =====');
        
        // 延遲執行以確保其他初始化完成
        setTimeout(function() {
          initializeMemberData();
        }, 500);
      });
    </script>

  </body>

  </html>