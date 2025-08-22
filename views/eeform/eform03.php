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
                    <form action="<?php echo base_url('Eform/saveEform03'); ?>" method="POST" class="text-left" id="eform03">
                      <div class="row">
                        <div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>

                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員姓名</label>
                          <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填會員姓名" required />
                        </div>
                        <div class="col-sm-4 mb30">
                          <label class="label-custom">會員編號</label>
                          <input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" required />
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">年齡</label>
                          <input type="number" name="age" class="form-control form-control-custom" placeholder="限填數字" required />
                        </div>
                        <div class="col-sm-2 mb30">
                          <label class="label-custom">身高</label>
                          <input type="number" name="height" class="form-control form-control-custom" placeholder="限填數字" required />
                        </div>
                        <div class="col-sm-12 mb30">
                          <label class="label-custom">目標</label>
                          <input type="text" name="goal" class="form-control form-control-custom" placeholder="請填寫目標…" required />
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
                                    <label class="label-custom">計畫a.</label>
                                    <input type="text" name="plan_a" class="form-control form-control-custom" placeholder="請填寫目標…" />
                                  </div>

                                  <div class="col-sm-12 mb20">
                                    <label class="label-custom">計畫b.</label>
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

                <div class="mb75">
                  <h4><strong>電子表單</strong></h4>
                  <a href="eform01.php" class="btn btn-outline-secondary btn-block">肌膚諮詢記錄表</a>
                  <a href="eform02.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(肌膚)</a>
                  <a href="eform03.php" class="btn btn-outline-secondary btn-block active">微微卡日記</a>
                  <a href="eform04.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(保健)</a>
                  <a href="eform05.php" class="btn btn-outline-secondary btn-block">健康諮詢表</a>
                </div>

                <!--<div class="mb65">
                    <h4>產品分類</h4>

                    <div class="article-list-mini">
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p01.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">肌膚保養系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p02.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">彩妝系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p04.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p05.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">美髮、美體系列</a></h5>
                        </div>
                      </div>
					  <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p03.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                    </div>
                  </div>-->




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
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header bg-gradient-primary text-white border-0">
          <h5 class="modal-title" id="confirmModalLabel">
            <i class="fas fa-clipboard-check mr-2"></i>確認表單內容
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
          <div class="container-fluid">
            
            <!-- 基本資料卡片 -->
            <div class="card mb-4 border-left-primary shadow-sm">
              <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-primary">
                  <i class="fas fa-user mr-2"></i>基本資料
                </h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="badge badge-light mr-2">姓名</span>
                      <span class="text-dark font-weight-bold" id="confirm-member-name"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="badge badge-light mr-2">編號</span>
                      <span class="text-dark font-weight-bold" id="confirm-member-id"></span>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="badge badge-light mr-2">年齡</span>
                      <span class="text-dark font-weight-bold" id="confirm-age"></span> 歲
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="d-flex align-items-center">
                      <span class="badge badge-light mr-2">身高</span>
                      <span class="text-dark font-weight-bold" id="confirm-height"></span> cm
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-light mr-2">目標</span>
                      <span class="text-dark font-weight-bold" id="confirm-goal"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 行動計畫卡片 -->
            <div class="card mb-4 border-left-warning shadow-sm">
              <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-warning">
                  <i class="fas fa-tasks mr-2"></i>自身行動計畫
                </h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-warning mr-2">計畫1</span>
                      <span class="text-dark" id="confirm-action-plan-1"></span>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-warning mr-2">計畫2</span>
                      <span class="text-dark" id="confirm-action-plan-2"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 身體數據卡片 -->
            <div class="card mb-4 border-left-info shadow-sm">
              <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-info">
                  <i class="fas fa-heartbeat mr-2"></i>身體數據
                </h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <div class="text-center p-3 border bg-light">
                      <div class="text-info font-weight-bold mb-1">體重</div>
                      <div class="h5 font-weight-bold text-dark" id="confirm-weight"></div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="text-center p-3 border bg-light">
                      <div class="text-info font-weight-bold mb-1">血壓(收)</div>
                      <div class="h5 font-weight-bold text-dark" id="confirm-blood-pressure-high"></div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="text-center p-3 border bg-light">
                      <div class="text-info font-weight-bold mb-1">血壓(舒)</div>
                      <div class="h5 font-weight-bold text-dark" id="confirm-blood-pressure-low"></div>
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <div class="text-center p-3 border bg-light">
                      <div class="text-info font-weight-bold mb-1">腰圍</div>
                      <div class="h5 font-weight-bold text-dark" id="confirm-waist"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 執行項目卡片 -->
            <div class="card mb-4 border-left-success shadow-sm">
              <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-success">
                  <i class="fas fa-check-circle mr-2"></i>執行項目
                </h6>
              </div>
              <div class="card-body">
                <div id="confirm-checkboxes-container"></div>
              </div>
            </div>

            <!-- 其他計畫卡片 -->
            <div class="card mb-4 border-left-secondary shadow-sm">
              <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold text-secondary">
                  <i class="fas fa-clipboard-list mr-2"></i>其他計畫
                </h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-secondary mr-2">計畫a</span>
                      <span class="text-dark" id="confirm-plan-a"></span>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-secondary mr-2">計畫b</span>
                      <span class="text-dark" id="confirm-plan-b"></span>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                      <span class="badge badge-secondary mr-2">其他</span>
                      <span class="text-dark" id="confirm-other"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>取消
          </button>
          <button type="button" class="btn btn-danger btn-lg px-4 shadow-sm" onclick="submitForm()">
            <i class="fas fa-paper-plane mr-2"></i>確認送出
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
  
  <!-- Custom CSS for enhanced UI -->
  <style>
    .bg-gradient-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .border-left-primary {
      border-left: 4px solid #4e73df !important;
    }
    
    .border-left-warning {
      border-left: 4px solid #f6c23e !important;
    }
    
    .border-left-info {
      border-left: 4px solid #36b9cc !important;
    }
    
    .border-left-success {
      border-left: 4px solid #1cc88a !important;
    }
    
    .border-left-secondary {
      border-left: 4px solid #858796 !important;
    }
    
    .modal-content {
      border-radius: 0px;
    }
    
    .card {
      border-radius: 0px;
      transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
      transform: translateY(-2px);
    }
    
    .badge {
      font-size: 0.85rem;
      min-width: 60px;
      text-align: center;
    }
    
    .btn-lg {
      transition: all 0.3s ease;
    }
    
    .btn-lg:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    
    .modal-body::-webkit-scrollbar {
      width: 8px;
    }
    
    .modal-body::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 0px;
    }
    
    .modal-body::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 0px;
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
    // 控制測試按鈕顯示的變數
    var showTestButton = true; // 設為 false 可隱藏測試按鈕
    
    // 頁面載入時檢查是否顯示測試按鈕
    $(document).ready(function() {
      if (showTestButton) {
        document.getElementById('testDataButton').style.display = 'block';
      }
    });
    
    // 填入測試資料的函數
    function fillTestData() {
      document.querySelector('input[name="member_name"]').value = '張小明';
      document.querySelector('input[name="member_id"]').value = 'M001234';
      document.querySelector('input[name="age"]').value = '35';
      document.querySelector('input[name="height"]').value = '170';
      document.querySelector('input[name="goal"]').value = '減重5公斤並維持健康體態';
      document.querySelector('input[name="action_plan_1"]').value = '每天早上做30分鐘瑜珈';
      document.querySelector('input[name="action_plan_2"]').value = '晚餐後散步1小時';
      document.querySelector('input[name="weight"]').value = '70.5';
      document.querySelector('input[name="blood_pressure_high"]').value = '120';
      document.querySelector('input[name="blood_pressure_low"]').value = '80';
      document.querySelector('input[name="waist"]').value = '85.0';
      document.querySelector('input[name="hand_measure"]').checked = true;
      document.querySelector('input[name="exercise"]').checked = true;
      document.querySelector('input[name="weika"]').checked = true;
      document.querySelector('input[name="water_intake"]').checked = true;
      document.querySelector('input[name="plan_a"]').value = '每日記錄飲食內容';
      document.querySelector('input[name="plan_b"]').value = '每週量體重2次';
      document.querySelector('input[name="other"]').value = '保持充足睡眠';
    }

    function showConfirmModal() {
      // 驗證必填欄位
      var memberName = document.querySelector('input[name="member_name"]').value;
      var memberId = document.querySelector('input[name="member_id"]').value;
      var age = document.querySelector('input[name="age"]').value;
      var height = document.querySelector('input[name="height"]').value;
      var goal = document.querySelector('input[name="goal"]').value;

      if (!memberName || !memberId || !age || !height || !goal) {
        alert('請填寫所有必填欄位');
        return;
      }

      // 填入確認視窗的內容
      document.getElementById('confirm-member-name').textContent = memberName;
      document.getElementById('confirm-member-id').textContent = memberId;
      document.getElementById('confirm-age').textContent = age;
      document.getElementById('confirm-height').textContent = height;
      document.getElementById('confirm-goal').textContent = goal;
      
      // 自身行動計畫
      document.getElementById('confirm-action-plan-1').textContent = document.querySelector('input[name="action_plan_1"]').value || '(未填寫)';
      document.getElementById('confirm-action-plan-2').textContent = document.querySelector('input[name="action_plan_2"]').value || '(未填寫)';
      
      // 身體數據
      document.getElementById('confirm-weight').textContent = document.querySelector('input[name="weight"]').value || '(未填寫)';
      document.getElementById('confirm-blood-pressure-high').textContent = document.querySelector('input[name="blood_pressure_high"]').value || '(未填寫)';
      document.getElementById('confirm-blood-pressure-low').textContent = document.querySelector('input[name="blood_pressure_low"]').value || '(未填寫)';
      document.getElementById('confirm-waist').textContent = document.querySelector('input[name="waist"]').value || '(未填寫)';
      
      // 執行項目 (checkbox)
      var checkboxes = [
        {name: 'hand_measure', label: '用手測量', icon: 'fa-hand-paper'},
        {name: 'exercise', label: '運動(30分)', icon: 'fa-running'},
        {name: 'health_supplement', label: '保健食品', icon: 'fa-pills'},
        {name: 'weika', label: '微微卡', icon: 'fa-apple-alt'},
        {name: 'water_intake', label: '飲水量', icon: 'fa-tint'}
      ];
      var checkboxesContainer = document.getElementById('confirm-checkboxes-container');
      var checkedItems = [];
      
      checkboxes.forEach(function(item) {
        var checkbox = document.querySelector('input[name="' + item.name + '"]');
        if (checkbox && checkbox.checked) {
          checkedItems.push('<span class="badge badge-success mr-2 mb-2 p-2"><i class="fas ' + item.icon + ' mr-1"></i>' + item.label + '</span>');
        }
      });
      
      if (checkedItems.length > 0) {
        checkboxesContainer.innerHTML = checkedItems.join('');
      } else {
        checkboxesContainer.innerHTML = '<span class="text-muted"><i class="fas fa-info-circle mr-2"></i>無選擇項目</span>';
      }
      
      // 其他計畫
      document.getElementById('confirm-plan-a').textContent = document.querySelector('input[name="plan_a"]').value || '(未填寫)';
      document.getElementById('confirm-plan-b').textContent = document.querySelector('input[name="plan_b"]').value || '(未填寫)';
      document.getElementById('confirm-other').textContent = document.querySelector('input[name="other"]').value || '(未填寫)';
      
      // 顯示模態視窗
      $('#confirmModal').modal('show');
    }

    function submitForm() {
      document.getElementById('eform03').submit();
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