  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
        <?= $this->block_service->load_html_header(); ?>


        <div class="section-mini">



          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>會員服務追蹤管理表(保健)</strong></h1>
                  <div class="mb30">
                    <div class="container">
                      <form action="#" method="POST" class="text-left" id="eform04">
                        <div class="row">
                          <div class="col-sm-12 text-right mb30">填寫日期：<span id="current-date"></span></div>

                          <div class="col-sm-3 mb30">
                            <label class="label-custom">姓名</label>
                            <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名" value="<?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : ''; ?>" required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">會員編號</label>
                            <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="<?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : ''; ?>" required />
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
                                      <label class="label-custom">活力發酵精萃</label>
                                      <input type="number" name="product_energy_essence001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">白鶴靈芝EX</label>
                                      <input type="number" name="product_reishi_ex001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">美力C錠</label>
                                      <input type="number" name="product_vitamin_c001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">鶴力晶</label>
                                      <input type="number" name="product_energy_crystal001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">白鶴靈芝茶</label>
                                      <input type="number" name="product_reishi_tea001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">淨白活膚蜜皂</label>
                                      <input type="number" name="product_soap001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">活顏泥膜</label>
                                      <input type="number" name="product_mask001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">化粧水</label>
                                      <input type="number" name="product_toner001" style="width: 100%;" placeholder="請填寫數量…" min="0">
                                    </div>


                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <h5>健康困擾</h5>
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="疲勞" id="health_fatigue">
                                        <label class="form-check-label" for="health_fatigue">疲勞</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="失眠" id="health_insomnia">
                                        <label class="form-check-label" for="health_insomnia">失眠</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="免疫力差" id="health_immunity">
                                        <label class="form-check-label" for="health_immunity">免疫力差</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="消化不良" id="health_digestion">
                                        <label class="form-check-label" for="health_digestion">消化不良</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="皮膚問題" id="health_skin">
                                        <label class="form-check-label" for="health_skin">皮膚問題</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="關節疼痛" id="health_joints">
                                        <label class="form-check-label" for="health_joints">關節疼痛</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="記憶力衰退" id="health_memory">
                                        <label class="form-check-label" for="health_memory">記憶力衰退</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="血糖控制" id="health_blood_sugar">
                                        <label class="form-check-label" for="health_blood_sugar">血糖控制</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="其他" id="health_other">
                                        <label class="form-check-label" for="health_other">其他</label>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <h5>每日建議產品&攝取量</h5>
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">活力發酵精萃建議攝取量</label>
                                      <input type="text" name="recommend_energy_essence" style="width: 100%;" placeholder="例：每日1-2包，餐前30分鐘">
                                    </div>
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">白鶴靈芝EX建議攝取量</label>
                                      <input type="text" name="recommend_reishi_ex" style="width: 100%;" placeholder="例：每日2-3粒，餐後服用">
                                    </div>
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">美力C錠建議攝取量</label>
                                      <input type="text" name="recommend_vitamin_c" style="width: 100%;" placeholder="例：每日1-2錠，飯後服用">
                                    </div>
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">鶴力晶建議攝取量</label>
                                      <input type="text" name="recommend_energy_crystal" style="width: 100%;" placeholder="例：每日1包，溫開水沖泡">
                                    </div>
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">白鶴靈芝茶建議攝取量</label>
                                      <input type="text" name="recommend_reishi_tea" style="width: 100%;" placeholder="例：每日1-2包，熱水沖泡">
                                    </div>
                                    <div class="col-sm-6 mb20">
                                      <label class="label-custom">綜合建議</label>
                                      <input type="text" name="recommend_general" style="width: 100%;" placeholder="整體建議攝取時間和注意事項">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">LINE</label>
                            <input type="text" name="line_contact" class="form-control form-control-custom" placeholder="請填寫LINE聯絡狀況，300字元內…" />
                          </div>

                          <div class="col-sm-12 mb30">
                            <label class="label-custom">TEL</label>
                            <input type="text" name="tel_contact" class="form-control form-control-custom" placeholder="請填寫電話聯絡狀況，300字元內…" />
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

                <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                  <!-- 側邊欄清單 -->
                  <?= $this->block_service->electronic_form_right_menu('eform4'); ?>
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
    
    <style>
      .modal-content { border-radius: 0px; }
      .modal-body::-webkit-scrollbar { width: 8px; }
      .modal-body::-webkit-scrollbar-track { background: #f1f1f1; }
      .modal-body::-webkit-scrollbar-thumb { background: #c1c1c1; }
      .modal-body::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
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
      var showTestButton = true;
      
      $(document).ready(function() {
        // 自動填入當天日期
        var today = new Date();
        var currentDate = today.getFullYear() + '-' + 
                         String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                         String(today.getDate()).padStart(2, '0');
        
        $('#current-date').text(currentDate);
        $('input[name="join_date"]').val(currentDate);
        $('input[name="meeting_date"]').val(currentDate);
        
        if (showTestButton) $('#testDataButton').show();
      });
      
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
        $('input[name="skin_health_condition"]').val('測試健康狀況描述');
        
        // 產品數量測試資料
        $('input[name="product_energy_essence001"]').val('2');
        $('input[name="product_reishi_ex001"]').val('3');
        $('input[name="product_vitamin_c001"]').val('2');
        $('input[name="product_energy_crystal001"]').val('1');
        $('input[name="product_reishi_tea001"]').val('2');
        $('input[name="product_soap001"]').val('1');
        $('input[name="product_mask001"]').val('2');
        $('input[name="product_toner001"]').val('3');
        
        // 健康困擾測試資料
        $('input[value="疲勞"]').prop('checked', true);
        $('input[value="失眠"]').prop('checked', true);
        $('input[value="皮膚問題"]').prop('checked', true);
        
        // 每日建議產品&攝取量測試資料
        $('input[name="recommend_energy_essence"]').val('每日1-2包，餐前30分鐘溫開水沖泡');
        $('input[name="recommend_reishi_ex"]').val('每日2-3粒，餐後服用，建議搭配溫開水');
        $('input[name="recommend_vitamin_c"]').val('每日1-2錠，飯後服用，增強免疫力');
        $('input[name="recommend_energy_crystal"]').val('每日1包，溫開水沖泡，空腹服用效果佳');
        $('input[name="recommend_reishi_tea"]').val('每日1-2包，熱水沖泡，可當茶飲用');
        $('input[name="recommend_general"]').val('建議搭配均衡飲食，適量運動，充足睡眠');
        
        $('input[name="line_contact"]').val('與會員保持良好互動，定期關心產品使用狀況');
        $('input[name="tel_contact"]').val('每月電話追蹤，了解產品效果和需求');
        $('input[name="meeting_date"]').val('2025-09-15');
      }

      function showConfirmModal() {
        // Basic validation
        var memberName = $('input[name="member_name"]').val();
        var memberId = $('input[name="member_id"]').val();
        var joinDate = $('input[name="join_date"]').val();
        var gender = $('select[name="gender"]').val();
        var age = $('input[name="age"]').val();

        if (!memberName || !memberId || !joinDate || !gender || !age) {
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
        // Collect health concerns
        var healthConcerns = [];
        $('input[name="health_concerns[]"]:checked').each(function() {
          healthConcerns.push($(this).val());
        });

        var formData = {
          member_name: $('input[name="member_name"]').val(),
          member_id: $('input[name="member_id"]').val(),
          join_date: $('input[name="join_date"]').val(),
          gender: $('select[name="gender"]').val(),
          age: $('input[name="age"]').val(),
          skin_health_condition: $('input[name="skin_health_condition"]').val(),
          product_energy_essence001: $('input[name="product_energy_essence001"]').val(),
          product_reishi_ex001: $('input[name="product_reishi_ex001"]').val(),
          product_vitamin_c001: $('input[name="product_vitamin_c001"]').val(),
          product_energy_crystal001: $('input[name="product_energy_crystal001"]').val(),
          product_reishi_tea001: $('input[name="product_reishi_tea001"]').val(),
          product_soap001: $('input[name="product_soap001"]').val(),
          product_mask001: $('input[name="product_mask001"]').val(),
          product_toner001: $('input[name="product_toner001"]').val(),
          health_concerns: healthConcerns,
          recommend_energy_essence: $('input[name="recommend_energy_essence"]').val(),
          recommend_reishi_ex: $('input[name="recommend_reishi_ex"]').val(),
          recommend_vitamin_c: $('input[name="recommend_vitamin_c"]').val(),
          recommend_energy_crystal: $('input[name="recommend_energy_crystal"]').val(),
          recommend_reishi_tea: $('input[name="recommend_reishi_tea"]').val(),
          recommend_general: $('input[name="recommend_general"]').val(),
          line_contact: $('input[name="line_contact"]').val(),
          tel_contact: $('input[name="tel_contact"]').val(),
          meeting_date: $('input[name="meeting_date"]').val()
        };

        $.ajax({
          url: '<?php echo base_url("api/eeform4/submit"); ?>',
          method: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              Swal.fire({
                title: '提交成功！',
                text: '表單已成功提交',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
              }).then(() => {
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