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
                            <label class="label-custom">會員編號</label>
                            <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="<?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : ''; ?>" readonly required />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">姓名</label>
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
                          <div class="col-sm-12 mb30">
                            <label class="label-custom">肌膚/健康狀況</label>
                            <input type="text" name="skin_health_condition" class="form-control form-control-custom" placeholder="請填寫肌膚/健康狀況…" />
                          </div>

                          <!-- 健康關注區域 -->
                          <div class="col-sm-12 mb30">
                            <h5>健康關注</h5>
                            <div class="card bg-light">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="疲勞" id="concern_fatigue">
                                        <label class="form-check-label" for="concern_fatigue">疲勞</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="失眠" id="concern_insomnia">
                                        <label class="form-check-label" for="concern_insomnia">失眠</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="免疫力差" id="concern_immunity">
                                        <label class="form-check-label" for="concern_immunity">免疫力差</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="消化不良" id="concern_digestion">
                                        <label class="form-check-label" for="concern_digestion">消化不良</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="皮膚問題" id="concern_skin">
                                        <label class="form-check-label" for="concern_skin">皮膚問題</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="關節疼痛" id="concern_joint">
                                        <label class="form-check-label" for="concern_joint">關節疼痛</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="記憶力衰退" id="concern_memory">
                                        <label class="form-check-label" for="concern_memory">記憶力衰退</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="health_concerns[]" value="血糖控制" id="concern_blood_sugar">
                                        <label class="form-check-label" for="concern_blood_sugar">血糖控制</label>
                                      </div>
                                    </div>
                                    <div class="col-sm-12 mb20">
                                      <label class="label-custom">其他健康關注：</label>
                                      <input type="text" name="other_health_concerns" class="form-control form-control-custom" placeholder="請填寫其他健康關注…" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- 訂購產品 -->
                          <div class="col-sm-12 mb30">
                            <h5>訂購產品</h5>
                            <div class="card bg-light">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">活力發酵精萃</label>
                                      <input type="number" name="product_energy_essence001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">白鶴靈芝EX</label>
                                      <input type="number" name="product_reishi_ex001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">美力C錠</label>
                                      <input type="number" name="product_vitamin_c001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">鶴力晶</label>
                                      <input type="number" name="product_energy_crystal001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">白鶴靈芝茶</label>
                                      <input type="number" name="product_reishi_tea001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">淨白活膚蜜皂</label>
                                      <input type="number" name="product_soap001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">活顏泥膜</label>
                                      <input type="number" name="product_mask001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                    <div class="col-sm-3 mb20">
                                      <label class="label-custom">化粧水</label>
                                      <input type="number" name="product_toner001" class="form-control form-control-custom" placeholder="請填寫數量…" min="0" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- 每日建議攝取量 -->
                          <div class="col-sm-12 mb30">
                            <h5>每日建議攝取量</h5>
                            <div class="card bg-light">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-sm-4 mb20">
                                      <label class="label-custom">活力發酵精萃 建議攝取</label>
                                      <input type="text" name="daily_energy_essence" class="form-control form-control-custom" placeholder="例: 每日1-2次，每次1包" />
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <label class="label-custom">白鶴靈芝EX 建議攝取</label>
                                      <input type="text" name="daily_reishi_ex" class="form-control form-control-custom" placeholder="例: 每日2次，每次2粒" />
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <label class="label-custom">美力C錠 建議攝取</label>
                                      <input type="text" name="daily_vitamin_c" class="form-control form-control-custom" placeholder="例: 每日1次，每次1錠" />
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <label class="label-custom">鶴力晶 建議攝取</label>
                                      <input type="text" name="daily_energy_crystal" class="form-control form-control-custom" placeholder="例: 每日1次，每次5ml" />
                                    </div>
                                    <div class="col-sm-4 mb20">
                                      <label class="label-custom">白鶴靈芝茶 建議攝取</label>
                                      <input type="text" name="daily_reishi_tea" class="form-control form-control-custom" placeholder="例: 每日2-3次" />
                                    </div>
                                    <div class="col-sm-12 mb20">
                                      <label class="label-custom">其他建議</label>
                                      <textarea name="other_daily_recommendations" class="form-control form-control-custom" rows="3" placeholder="請填寫其他每日建議，如飲食、運動等…"></textarea>
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
                  <?= $this->block_service->electronic_form_right_menu('eform4'); ?>
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

            <!-- 健康關注 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  健康關注
                </h6>
              </div>
              <div class="p-3" id="confirm-health-concerns">
                <!-- Health concerns will be populated here -->
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

            <!-- 每日建議攝取量 -->
            <div class="border mb-4">
              <div class="bg-light p-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                  每日建議攝取量
                </h6>
              </div>
              <div class="p-3" id="confirm-daily-recommendations">
                <!-- Daily recommendations will be populated here -->
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
      });
      
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
        $('input[name="age"]').val('35');
        $('input[name="skin_health_condition"]').val('整體健康狀況良好，偶有疲勞感');
        
        // 健康關注測試資料
        $('input[name="health_concerns[]"][value="疲勞"]').prop('checked', true);
        $('input[name="health_concerns[]"][value="免疫力差"]').prop('checked', true);
        $('input[name="health_concerns[]"][value="皮膚問題"]').prop('checked', true);
        $('input[name="other_health_concerns"]').val('睡眠品質偶爾不佳');
        
        // 產品數量測試資料
        $('input[name="product_energy_essence001"]').val('2');
        $('input[name="product_reishi_ex001"]').val('1');
        $('input[name="product_vitamin_c001"]').val('3');
        $('input[name="product_energy_crystal001"]').val('1');
        $('input[name="product_reishi_tea001"]').val('2');
        $('input[name="product_soap001"]').val('1');
        $('input[name="product_mask001"]').val('2');
        $('input[name="product_toner001"]').val('1');
        
        // 每日建議攝取量測試資料
        $('input[name="daily_energy_essence"]').val('每日早晚各1包，空腹服用');
        $('input[name="daily_reishi_ex"]').val('每日2次，每次2粒，飯後服用');
        $('input[name="daily_vitamin_c"]').val('每日1錠，餐後服用');
        $('input[name="daily_energy_crystal"]').val('每日1次，每次5ml，溫水稀釋');
        $('input[name="daily_reishi_tea"]').val('每日2-3次，可搭配餐飲');
        $('textarea[name="other_daily_recommendations"]').val('建議搭配規律運動，每週3-4次，每次30分鐘。維持充足睡眠，每日7-8小時。');
        
        $('input[name="line_contact"]').val('與會員保持良好互動，定期關心保健品使用狀況及身體變化');
        $('input[name="tel_contact"]').val('每月電話追蹤，了解產品使用效果和健康狀況改善情形');
      }

      function showConfirmModal() {
        // 驗證必填欄位
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

        // 填入確認視窗的內容
        $('#confirm-member-name').text(memberName);
        $('#confirm-member-id').text(memberId);
        $('#confirm-join-date').text(joinDate);
        $('#confirm-gender').text(gender);
        $('#confirm-age').text(age);
        $('#confirm-meeting-date').text($('input[name="meeting_date"]').val() || '(未填寫)');
        $('#confirm-skin-health').text($('input[name="skin_health_condition"]').val() || '(未填寫)');
        
        // 聯絡資訊
        $('#confirm-line-contact').text($('input[name="line_contact"]').val() || '(未填寫)');
        $('#confirm-tel-contact').text($('input[name="tel_contact"]').val() || '(未填寫)');
        
        // 收集健康關注
        var healthConcerns = [];
        $('input[name="health_concerns[]"]:checked').each(function() {
          healthConcerns.push($(this).val());
        });
        
        var otherHealthConcerns = $('input[name="other_health_concerns"]').val();
        if (otherHealthConcerns) {
          healthConcerns.push('其他: ' + otherHealthConcerns);
        }
        
        var healthConcernsHtml = '';
        if (healthConcerns.length > 0) {
          healthConcerns.forEach(function(concern) {
            healthConcernsHtml += '<span class="badge badge-secondary mr-1 mb-1">' + concern + '</span>';
          });
        } else {
          healthConcernsHtml = '<span class="text-muted">未選擇任何健康關注項目</span>';
        }
        $('#confirm-health-concerns').html(healthConcernsHtml);
        
        // 收集產品資料
        var productData = [];
        var productNames = {
          'product_energy_essence001': '活力發酵精萃',
          'product_reishi_ex001': '白鶴靈芝EX',
          'product_vitamin_c001': '美力C錠',
          'product_energy_crystal001': '鶴力晶',
          'product_reishi_tea001': '白鶴靈芝茶',
          'product_soap001': '淨白活膚蜜皂',
          'product_mask001': '活顏泥膜',
          'product_toner001': '化粧水'
        };

        Object.keys(productNames).forEach(function(key) {
          var quantity = $('input[name="' + key + '"]').val();
          if (quantity && parseInt(quantity) > 0) {
            productData.push({
              name: productNames[key],
              quantity: quantity
            });
          }
        });

        var productHtml = '';
        if (productData.length > 0) {
          productData.forEach(function(product) {
            productHtml += '<div class="d-flex align-items-center mb-2">';
            productHtml += '<span class="text-muted mr-3" style="min-width: 120px;">' + product.name + '：</span>';
            productHtml += '<span class="text-dark">' + product.quantity + ' 個</span>';
            productHtml += '</div>';
          });
        } else {
          productHtml = '<span class="text-muted">未訂購任何產品</span>';
        }
        $('#confirm-products').html(productHtml);
        
        // 收集每日建議攝取量
        var dailyRecommendations = [];
        var dailyFields = {
          'daily_energy_essence': '活力發酵精萃建議攝取',
          'daily_reishi_ex': '白鶴靈芝EX建議攝取',
          'daily_vitamin_c': '美力C錠建議攝取',
          'daily_energy_crystal': '鶴力晶建議攝取',
          'daily_reishi_tea': '白鶴靈芝茶建議攝取'
        };
        
        Object.keys(dailyFields).forEach(function(key) {
          var value = $('input[name="' + key + '"]').val();
          if (value) {
            dailyRecommendations.push({
              name: dailyFields[key],
              value: value
            });
          }
        });
        
        var otherRecommendations = $('textarea[name="other_daily_recommendations"]').val();
        if (otherRecommendations) {
          dailyRecommendations.push({
            name: '其他建議',
            value: otherRecommendations
          });
        }
        
        var dailyHtml = '';
        if (dailyRecommendations.length > 0) {
          dailyRecommendations.forEach(function(rec) {
            dailyHtml += '<div class="mb-3">';
            dailyHtml += '<div class="font-weight-bold text-dark mb-1">' + rec.name + '</div>';
            dailyHtml += '<div class="text-muted">' + rec.value + '</div>';
            dailyHtml += '</div>';
          });
        } else {
          dailyHtml = '<span class="text-muted">未填寫任何每日建議</span>';
        }
        $('#confirm-daily-recommendations').html(dailyHtml);
        
        // 顯示模態視窗
        $('#confirmModal').modal('show');
      }

      function submitForm() {
        // 收集表單資料
        var formData = {
          member_name: $('input[name="member_name"]').val(),
          member_id: $('input[name="member_id"]').val(),
          join_date: $('input[name="join_date"]').val(),
          gender: $('select[name="gender"]').val(),
          age: $('input[name="age"]').val(),
          skin_health_condition: $('input[name="skin_health_condition"]').val(),
          line_contact: $('input[name="line_contact"]').val(),
          tel_contact: $('input[name="tel_contact"]').val(),
          meeting_date: $('input[name="meeting_date"]').val(),
          health_concerns: [],
          other_health_concerns: $('input[name="other_health_concerns"]').val(),
          daily_recommendations: {},
          other_daily_recommendations: $('textarea[name="other_daily_recommendations"]').val()
        };

        // 收集健康關注
        $('input[name="health_concerns[]"]:checked').each(function() {
          formData.health_concerns.push($(this).val());
        });

        // 收集產品資料
        var productFields = [
          'product_energy_essence001',
          'product_reishi_ex001', 
          'product_vitamin_c001',
          'product_energy_crystal001',
          'product_reishi_tea001',
          'product_soap001',
          'product_mask001',
          'product_toner001'
        ];
        
        productFields.forEach(function(field) {
          var quantity = $('input[name="' + field + '"]').val();
          if (quantity && parseInt(quantity) > 0) {
            formData[field] = parseInt(quantity);
          }
        });
        
        // 收集每日建議攝取量
        var dailyFields = [
          'daily_energy_essence',
          'daily_reishi_ex',
          'daily_vitamin_c',
          'daily_energy_crystal',
          'daily_reishi_tea'
        ];
        
        dailyFields.forEach(function(field) {
          var value = $('input[name="' + field + '"]').val();
          if (value) {
            formData.daily_recommendations[field] = value;
          }
        });

        // 發送API請求
        $.ajax({
          url: '<?php echo base_url("api/eeform4/submit"); ?>',
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

      // Point 62: Member lookup functionality (同步 Point 57 功能到 eform4)
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
        console.log('[Point 62 - eform4] ===== 初始化會員資料功能開始 =====');
        console.log('[Point 62 - eform4] 當前使用者資料:', currentUserData);
        console.log('[Point 62 - eform4] 會員編號是否存在:', !!currentUserData.member_id);
        
        // 設定會員編號欄位
        $('input[name="member_id"]').val(currentUserData.member_id);
        console.log('[Point 62 - eform4] 設定會員編號欄位為:', currentUserData.member_id);
        
        // Point 60: 無論是否有會員編號，都進行測試API呼叫來確認端點是否正常
        console.log('[Point 62 - eform4] ===== 開始測試API端點 =====');
        if (currentUserData.member_id && currentUserData.member_id.trim() !== '') {
          console.log('[Point 62 - eform4] 有會員編號，開始查詢相關會員資料...');
          console.log('[Point 62 - eform4] 正常API呼叫，member_id:', currentUserData.member_id);
          lookupMemberData(currentUserData.member_id);
        } else {
          console.log('[Point 62 - eform4] 沒有會員編號，但仍進行測試API呼叫來確認端點...');
          // 使用測試ID來確認API端點是否正常運作
          console.log('[Point 62 - eform4] 使用測試ID "TEST123" 進行API測試');
          lookupMemberData('TEST123');
          
          // 設定預設姓名
          console.log('[Point 62 - eform4] 使用預設姓名:', currentUserData.member_name);
          $('input[name="member_name"]').val(currentUserData.member_name);
        }
      }

      // 查詢會員資料
      function lookupMemberData(memberId) {
        var apiUrl = '<?php echo base_url("api/eeform4/member_lookup/"); ?>' + memberId;
        console.log('[Point 62 - eform4] ===== API 呼叫詳細資訊 =====');
        console.log('[Point 62 - eform4] 開始查詢會員資料 API');
        console.log('[Point 62 - eform4] API URL:', apiUrl);
        console.log('[Point 62 - eform4] 查詢會員ID:', memberId);
        console.log('[Point 62 - eform4] Base URL:', '<?php echo base_url(); ?>');
        console.log('[Point 62 - eform4] 完整 API 路徑:', apiUrl);
        console.log('[Point 62 - eform4] 開始發送 AJAX 請求...');
        
        $.ajax({
          url: apiUrl,
          method: 'GET',
          dataType: 'json',
          beforeSend: function(xhr) {
            console.log('[Point 62 - eform4] ===== AJAX 請求即將發送 =====');
            console.log('[Point 62 - eform4] 請求方法: GET');
            console.log('[Point 62 - eform4] 請求 URL:', apiUrl);
            console.log('[Point 62 - eform4] 資料類型: json');
            console.log('[Point 62 - eform4] AJAX 請求已發送，等待回應...');
          },
          success: function(response) {
            console.log('[Point 62 - eform4] API 回應成功:', response);
            
            if (response.success && response.data) {
              memberData = response.data.members;
              console.log('[Point 62 - eform4] 找到會員資料數量:', memberData.length);
              console.log('[Point 62 - eform4] 會員資料內容:', memberData);
              
              if (memberData.length > 1) {
                // 多個會員：顯示下拉選單
                console.log('[Point 62 - eform4] 多個會員匹配，顯示下拉選單');
                isMultipleMembers = true;
                setupMemberDropdown();
              } else if (memberData.length === 1) {
                // 單個會員：使用文字輸入框
                console.log('[Point 62 - eform4] 單個會員匹配，使用文字輸入框');
                console.log('[Point 62 - eform4] 會員姓名:', memberData[0].c_name);
                isMultipleMembers = false;
                $('input[name="member_name"]').val(memberData[0].c_name);
                currentUserData.member_name = memberData[0].c_name;
              } else {
                // 沒有找到會員：使用預設值
                console.log('[Point 62 - eform4] 沒有找到會員，使用預設值');
                isMultipleMembers = false;
                $('input[name="member_name"]').val(currentUserData.member_name);
              }
            } else {
              console.log('[Point 62 - eform4] API 回應格式不正確:', response);
            }
          },
          error: function(xhr, status, error) {
            console.error('[Point 62 - eform4] ===== API 呼叫失敗詳細資訊 =====');
            console.error('[Point 62 - eform4] API 查詢失敗:', {
              status: status,
              error: error,
              xhr: xhr,
              responseText: xhr.responseText
            });
            console.error('[Point 62 - eform4] HTTP 狀態碼:', xhr.status);
            console.error('[Point 62 - eform4] HTTP 狀態文字:', xhr.statusText);
            console.error('[Point 62 - eform4] 回應內容:', xhr.responseText);
            console.error('[Point 62 - eform4] AJAX 狀態:', status);
            console.error('[Point 62 - eform4] 錯誤類型:', error);
            console.error('[Point 62 - eform4] 請求的 URL:', apiUrl);
            
            // 出錯時使用預設值
            console.log('[Point 62 - eform4] 因為API失敗，使用預設會員姓名:', currentUserData.member_name);
            $('input[name="member_name"]').val(currentUserData.member_name);
          },
          complete: function(xhr, status) {
            console.log('[Point 62 - eform4] ===== AJAX 請求完成 =====');
            console.log('[Point 62 - eform4] 最終狀態:', status);
            console.log('[Point 62 - eform4] HTTP 狀態碼:', xhr.status);
            console.log('[Point 62 - eform4] 請求已完成 (成功或失敗)');
          }
        });
      }

      // 設定會員下拉選單
      function setupMemberDropdown() {
        console.log('[Point 62 - eform4] ===== 設定會員下拉選單 =====');
        console.log('[Point 62 - eform4] 會員資料:', memberData);
        
        var $nameInput = $('input[name="member_name"]');
        var $nameSelect = $('select[name="member_name_select"]');
        
        console.log('[Point 62 - eform4] 找到姓名輸入框:', $nameInput.length > 0);
        console.log('[Point 62 - eform4] 找到姓名下拉選單:', $nameSelect.length > 0);
        
        // 清空下拉選單選項
        $nameSelect.empty();
        $nameSelect.append('<option value="">請選擇會員</option>');
        
        // 加入會員選項
        var currentUserSelected = false;
        memberData.forEach(function(member) {
          var option = $('<option value="' + member.c_no + '" data-name="' + member.c_name + '">' + 
                         member.c_name + ' (' + member.c_no + ')</option>');
          
          // Point 77: 檢查是否為當前使用者，如果是則設為預設選擇
          if (member.c_no === currentUserData.member_id || 
              member.c_name === currentUserData.member_name) {
            option.prop('selected', true);
            currentUserSelected = true;
            console.log('[Point 77 - eform4] 預設選擇當前使用者:', member.c_name, member.c_no);
          }
          
          $nameSelect.append(option);
        });
        
        // Point 77: 更新會員編號（根據目前選擇的會員）
        var selectedOption = $nameSelect.find('option:selected');
        if (selectedOption.val()) {
          $('input[name="member_id"]').val(selectedOption.val());
          currentUserData.member_id = selectedOption.val();
          currentUserData.member_name = selectedOption.data('name');
          console.log('[Point 77 - eform4] 根據預設選擇更新會員資料:', {
            memberId: currentUserData.member_id,
            memberName: currentUserData.member_name
          });
        }
        
        // 隱藏輸入框，顯示下拉選單
        $nameInput.hide();
        $nameSelect.show();
        
        console.log('[Point 62 - eform4] 下拉選單設定完成，已隱藏輸入框');
        
        // 綁定選擇事件
        $nameSelect.off('change.memberLookup').on('change.memberLookup', function() {
          var selectedOption = $(this).find('option:selected');
          var newMemberId = selectedOption.val();
          var newMemberName = selectedOption.data('name');
          
          console.log('[Point 62 - eform4] 會員選擇變更:', {
            newMemberId: newMemberId,
            newMemberName: newMemberName
          });
          
          if (newMemberId) {
            // 更新會員編號和姓名
            $('input[name="member_id"]').val(newMemberId);
            currentUserData.member_id = newMemberId;
            currentUserData.member_name = newMemberName;
            
            console.log('[Point 62 - eform4] 更新後的會員資料:', currentUserData);
          }
        });
      }

      // 修改提交表單函數以處理會員選擇
      var originalSubmitForm = submitForm;
      submitForm = function() {
        console.log('[Point 62 - eform4] ===== 表單提交開始 =====');
        console.log('[Point 62 - eform4] 是否為多重會員:', isMultipleMembers);
        console.log('[Point 62 - eform4] 下拉選單是否可見:', $('select[name="member_name_select"]').is(':visible'));
        
        // 收集表單資料
        var memberId, memberName;
        
        // 根據是否為多重會員選擇不同的取值方式
        if (isMultipleMembers && $('select[name="member_name_select"]').is(':visible')) {
          console.log('[Point 62 - eform4] 使用下拉選單模式取得會員資料');
          // 使用下拉選單的值
          var selectedOption = $('select[name="member_name_select"]').find('option:selected');
          memberId = selectedOption.val();
          memberName = selectedOption.data('name');
          console.log('[Point 62 - eform4] 從下拉選單取得:', {
            memberId: memberId,
            memberName: memberName
          });
        } else {
          console.log('[Point 62 - eform4] 使用輸入框模式取得會員資料');
          // 使用輸入框和當前會員資料
          memberId = currentUserData.member_id;
          memberName = $('input[name="member_name"]').val();
          console.log('[Point 62 - eform4] 從輸入框取得:', {
            memberId: memberId,
            memberName: memberName
          });
        }
        
        console.log('[Point 62 - eform4] 最終會員資料:', {
          member_id: memberId,
          member_name: memberName
        });
        
        // 確保表單欄位有正確的值
        $('input[name="member_id"]').val(memberId);
        $('input[name="member_name"]').val(memberName);
        
        // 呼叫原始的提交函數
        originalSubmitForm();
      }

      // 頁面載入時初始化會員資料
      $(document).ready(function() {
        console.log('[Point 62 - eform4] ===== 頁面載入完成，開始初始化會員查詢功能 =====');
        
        // 延遲執行以確保其他初始化完成
        setTimeout(function() {
          initializeMemberData();
        }, 500);
      });
    </script>

  </body>

  </html>