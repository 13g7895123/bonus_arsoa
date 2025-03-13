<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
        <div class="wrapper">
            <?= $this->block_service->load_html_header(); ?>
            <div class="section-mini">
                <div class="section-item text-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                                <h1 class="h2-3d font-libre"><strong>0917單一產品訂購單-new</strong></h1>
                                <div class="mb30">
                                    <div class="alert alert-danger" role="alert">
                                        為節省您寶貴的時間，表單送出前請自行確認：<br>
                                        <ol>
                                            <li>信用卡欄位是否填妥。</li>
                                            <li>收件地址、聯絡電話是否正確。</li>
                                            <li>※為必填項目，未完整填妥，恕不受理。</li>
                                        </ol>
                                    </div>
                                    <div class="container">
                                        <form action="#" class="text-left">
                                            <div class="row">
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">收貨人</label>
                                                    <input type="text" class="form-control form-control-custom" placeholder="真實姓名" />
                                                </div>
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">手機</label>
                                                    <input type="text" class="form-control form-control-custom" placeholder="請填09xx-xxx-xxx" />
                                                </div>
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">聯絡電話</label>
                                                    <input type="text" class="form-control form-control-custom" placeholder="限填數字" />
                                                </div>
                                                <div class="col-sm-12 mb30">
                                                    <label class="label-custom">送貨地址</label>
                                                    <input type="text" class="form-control form-control-custom" placeholder="請填寫完整地址…" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <p>付款郵局：郵政劃撥帳號：50049675</p>
                                                    <p>付款銀行：合作金庫銀行復旦分行銀行代號：006　帳號：1254-717-706612　受款人：台灣安露莎股份有限公司</p>
                                                    <p>付款方式：</p>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                        <label class="form-check-label" for="inlineRadio4">信用卡（請填寫下欄框內資料） </label>
                                                    </div>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                        <label class="form-check-label" for="inlineRadio4">劃撥交易序碼：</label>
                                                        <input type="text">
                                                    </div>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                        <label class="form-check-label" for="inlineRadio4">ATM轉帳、銀行電匯（帳號後五碼）：</label>
                                                        <input type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="container mb-4 wow fadeInUp">
                                    <div class="card bg-light border-danger">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="form-check form-check mb20">
                                                            <label class="form-check-label" for="inlineRadio4">本人</label>
                                                            <input type="text">
                                                            <label class="form-check-label" for="inlineRadio4">身份證字號</label>
                                                            <input type="text">
                                                            授權台灣安露莎股份有限公司使用本人之信用卡支付以下訂購人之消費貨款（以電腦系統金額為主），無任何異議。
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">持卡人姓名：</label>
                                                            <input type="text">
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text">
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">聯絡電話：</label>
                                                            <input type="text">
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">發卡銀行：</label>
                                                            <input type="text">
                                                            銀行（若使用安露莎授權卡支付請務必填寫發卡銀行與持卡人簽名）
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label" for="inlineRadio4">信用卡卡號（共16碼）：</label>
                                                            <input type="text" size="4" maxlength="4"> - <input type="text" size="4" maxlength="4"> - <input type="text" size="4" maxlength="4"> - <input type="text" size="4" maxlength="4">
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">有效期限：</label>
                                                            <input type="text" size="4" maxlength="2">月 20<input type="text" size="4" maxlength="2">年
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">持卡人簽名：</label>
                                                            <input type="text"> （同信用卡背面簽名）
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="container mb-4 wow fadeInUp">
                                    <div class="card bg-light border-info">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3 mb30">
                                                            <label class="label-custom">貨號：</label>
                                                            <input type="text">
                                                        </div>
                                                        <div class="col-sm-6 mb30">
                                                            <label class="label-custom">品名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3 mb30">
                                                            <label class="label-custom">建議售價：</label>
                                                            <input type="text">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-0 mb-4">

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container mb-2 wow fadeInUp">
                                    <div class="card bg-light ">
                                        <div class="card-body">
                                            <div class="container">
                                                <form action="#" class="text-left">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">姓名：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">數量：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="label-custom">金額：</label>
                                                            <input type="text" style="width: 100%;">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-12 text-right">
                                        <p class="fs20">代下單會員姓名：<input type="text"></p>
                                    </div>
                                    <div class="col-12 text-right">
                                        <p class="fs20">付款合計金額：<input type="text"></p>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <a href="#" class="btn btn-outline-danger btn-block">送出表單</a>
                            </div>
                            <div class="col-lg-1 d-none d-xl-block"></div>
                            <aside role="complementary" class="aside col-xl-3 col-md-3">
                                <div class="mt100 mb75">
                                    <?= $this->block_service->member_right_menu('N'); ?>
                                </div>
                            </aside>
                        </div>
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
    <script src="<?= base_url('public/online_form/js/') ?>smoothscroll.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>popper.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>bootstrap.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>animsition.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>owl.carousel.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>wow.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>jquery.pagepiling.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>isotope.pkgd.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>jquery.fancybox.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>TweenMax.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>ScrollMagic.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>animation.gsap.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>jquery.viewport.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>jquery.countdown.min.js"></script>
    <script src="<?= base_url('public/online_form/js/') ?>script.js"></script>


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

</body>

</html>