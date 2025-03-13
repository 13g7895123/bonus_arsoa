<body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
        <div class="wrapper">
            <?= $this->block_service->load_html_header(); ?>
            <div class="section-item text-left">

                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mb130 mt-lg-5" role="main">
                            <h1 class="h2-3d font-libre"><strong>產品訂購單</strong></h1>
                            <div class="container wow fadeInUp" data-wow-delay=".2s">
                                <div class="row">
                                    <div class="col-sm-4 mb30">
                                        <label class="label-custom">訂購會員姓名：</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="真實姓名" />
                                    </div>
                                    <div class="col-sm-4 mb30">
                                        <label class="label-custom">會員編號：</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="限填數字" />
                                    </div>
                                    <div class="col-sm-4 mb30">
                                        <label class="label-custom">推薦人：</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="真實姓名" />
                                    </div>
                                    <div class="col-sm-4 mb30">
                                        <label class="label-custom">收貨人姓名：</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="真實姓名" />
                                    </div>
                                    <div class="col-sm-4 mb30">
                                        <label class="label-custom">電話：</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="請填09xx-xxx-xxx" />
                                    </div>
                                    <div class="col-sm-6 mb30">
                                        <label class="label-custom">收貨人地址：郵遞區號</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="限填數字" />
                                    </div>
                                    <div class="col-sm-6 mb30">
                                        <div class="form-check form-check mb20">
                                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                            <label class="form-check-label" for="inlineRadio4">同公司建檔地址 </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb30">
                                        <label class="label-custom">收貨人地址</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="縣市…" />
                                    </div>
                                    <div class="col-sm-3 mb30">
                                        <label class="label-custom">行政區</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="行政區…" />
                                    </div>
                                    <div class="col-sm-6 mb30">
                                        <label class="label-custom">完整地址</label>
                                        <input type="text" class="form-control form-control-custom" placeholder="請填寫完整地址…" />
                                    </div>
                                    <div class="col-sm-12">
                                        <p>付款方式：付款金額(以電腦系統金額為主)</p>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                <label class="form-check-label" for="inlineRadio4">信用卡</label>
                                            </div>
                                            <div class="form-check form-check-inline">（
                                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                <label class="form-check-label" for="inlineRadio4">VISA </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                <label class="form-check-label" for="inlineRadio4">MASTER </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                <label class="form-check-label" for="inlineRadio4">JCB ）</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                        <div class="card-body">
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">消費金額：NT＄ </label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">消費日期： </label>
                                                    <input type="text" size="6" maxlength="4">
                                                    年
                                                    <input type="text" size="4" maxlength="2">
                                                    月
                                                    <input type="text" size="4" maxlength="2">
                                                    日
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">發卡銀行： </label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">信用卡卡號（共16碼）：</label>
                                                    <input type="text" size="4" maxlength="4">
                                                    -
                                                    <input type="text" size="4" maxlength="4">
                                                    -
                                                    <input type="text" size="4" maxlength="4">
                                                    -
                                                    <input type="text" size="4" maxlength="4">
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">背面末3碼(信用卡背面簽名處上方)： </label>
                                                    <input type="text" size="5" maxlength="3">
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">有效月年：自西元 </label>
                                                    <input type="text" size="4" maxlength="2">
                                                    月
                                                    <input type="text" size="4" maxlength="2">
                                                    年
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">至 </label>
                                                    <input type="text" size="4" maxlength="2">
                                                    月
                                                    <input type="text" size="4" maxlength="2">
                                                    年
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">持卡人簽名(需與信用卡上一致)： </label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4 wow fadeInUp" data-wow-delay=".2s">
                                <div class="col-lg-12">
                                    <p class="text-danger">★持卡人非訂購會員本人，務必完整填寫信用卡使用同意申明書。</p>
                                    <div class="card bg-light border-info mb30">
                                        <div class="card-body">
                                            <p class="fs20">信用卡使用同意聲明書 </p>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">持卡人本人： </label>
                                                    <input type="text">
                                                    ；
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">身份證字號： </label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                            <div class="mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">本人授權台灣安露莎公司就訂購會員 </label>
                                                    <input type="text">
                                                    ；
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">購買產品合計 </label>
                                                    <input type="text">
                                                    元
                                                </div>
                                                <div>得使用本人留存之信用卡資訊，填寫信用卡授權書向銀行請款支付上開消費金額，毋須再與本人電話確認。</div>
                                            </div>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">持卡人簽名：</label>
                                                    <input type="text">
                                                    ；
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="inlineRadio4">日期：</label>
                                                    <input type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb30">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                            <label class="form-check-label" for="inlineRadio4">郵政劃撥</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                            <label class="form-check-label" for="inlineRadio4">ATM轉帳 </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr class="mt-0 mb-4">

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card bg-light ">
                                    <div class="card-body">
                                        <div class="container wow fadeInUp" data-wow-delay=".2s">
                                            <form action="#" class="text-left">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">貨號／品名：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">數量：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">建議售價：</label>
                                                        <input type="text" style="width: 100%;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="label-custom">BP：</label>
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
                                    <p class="fs20">建議售價合計：<input type="text"></p>
                                </div>
                                <div class="col-12 text-right">
                                    <p class="fs20">代下單會員姓名：<input type="text"></p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="wow fadeInUp" data-wow-delay=".2s">
                                <p class="text-danger">※訂購金額每滿建議售價4,000元，即附贈全產品型錄一本，滿建議售價2,000元，免付運費100元※</p>
                                <p class="text-danger">付款銀行：合作金庫銀行 復旦分行 銀行代號：006　　帳號：1254-717-706612　　受款人：台灣安露莎股份有限公司</p>
                                <p class="text-danger">付款郵局：郵政劃撥帳號： 50049675　　受款人：台灣安露莎股份有限公司</p>
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
        window.jQuery || document.write('<script src="<?= base_url('public/online_form/') ?>js/jquery.min.js"><\/script>')
    </script>
    <script src="<?= base_url('public/online_form/') ?>js/smoothscroll.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/popper.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/animsition.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/owl.carousel.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/wow.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/jquery.pagepiling.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/jquery.fancybox.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/TweenMax.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/ScrollMagic.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/animation.gsap.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/jquery.viewport.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/jquery.countdown.min.js"></script>
    <script src="<?= base_url('public/online_form/') ?>js/script.js"></script>


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