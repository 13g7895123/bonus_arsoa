<style>
    #signatureCredit, #signatureCreditAgreement {
        border: 2px solid #000;
        width: 400px;
        height: 200px;
        cursor: crosshair;
    }
</style>
<body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
        <div class="wrapper">
            <?= $this->block_service->load_html_header(); ?>
            <div class="section-item text-left">

                <div class="container">
                    <div class="row">
                        <div class="col-md-8 mb130 mt-lg-5" role="main">
                            <form id="eform_main_1">
                                <h1 class="h2-3d font-libre"><strong>產品訂購單</strong></h1>
                                <div class="container wow fadeInUp" data-wow-delay=".2s">
                                    <div class="row">
                                        <div class="col-sm-4 mb30">
                                            <label class="label-custom">訂購會員姓名：</label>
                                            <input type="text" name="c_name" class="form-control form-control-custom" placeholder="真實姓名" value="<?=$userdata['c_name'];?>" />
                                        </div>
                                        <div class="col-sm-4 mb30">
                                            <label class="label-custom">會員編號：</label>
                                            <input type="text" name="c_no" class="form-control form-control-custom" placeholder="請填會員編號" value="<?=$userdata['c_no'];?>" />
                                        </div>
                                        <div class="col-sm-4 mb30">
                                            <label class="label-custom">推薦人：</label>
                                            <input type="text" name="recommend_person" class="form-control form-control-custom" placeholder="請填推薦人" />
                                        </div>
                                        <div class="col-sm-4 mb30">
                                            <label class="label-custom">收貨人姓名：</label>
                                            <input type="text" name="consignee_name" class="form-control form-control-custom" placeholder="請填收貨人" value="<?=$userdata['c_name'];?>" />
                                        </div>
                                        <div class="col-sm-4 mb30">
                                            <label class="label-custom">電話：</label>
                                            <input type="text" name="consignee_cellphone_number" class="form-control form-control-custom" placeholder="請填電話" value="<?=$userdata['cell1'];?>" />
                                        </div>
                                        <div class="col-sm-6 mb30">
                                            <label class="label-custom">收貨人地址：郵遞區號</label>
                                            <input type="text" name="consignee_postal_code" class="form-control form-control-custom" placeholder="請填郵遞區號" value="<?=$userdata['zip_dl'];?>" />
                                        </div>
                                        <div class="col-sm-12 mb30">
                                            <label class="label-custom">收貨人地址：地址</label>
                                            <input type="text" name="consignee_address" class="form-control form-control-custom" placeholder="請填寫地址" value="<?=$userdata['addr_dl'];?>" />
                                        </div>
                                        <div class="col-sm-12">
                                            <p>付款方式：付款金額(以電腦系統金額為主)</p>
                                            <div class="mb30 d-flex flex-row align-items-center">
                                                <!-- 信用卡 -->
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card">
                                                    <label class="form-check-label" for="creditCard">信用卡</label>
                                                </div>
                                                
                                                <!-- 信用卡類別 -->
                                                <div class="d-flex flex-row" id="cardTypeGroup">
                                                    (
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="card_type" id="visa" value="VISA" disabled>
                                                        <label class="form-check-label" for="visa">VISA</label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="card_type" id="master" value="MASTER" disabled>
                                                        <label class="form-check-label" for="master">MASTER</label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="card_type" id="jcb" value="JCB" disabled>
                                                        <label class="form-check-label" for="jcb">JCB</label>
                                                    </div>
                                                    )
                                                </div>
                                                
                                                <!-- 其他付款方式 -->
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="postalTransfer" value="postal_transfer">
                                                    <label class="form-check-label" for="postalTransfer">郵政劃撥</label>
                                                </div>
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" name="payment_method" id="atmTransfer" value="atm_transfer">
                                                    <label class="form-check-label" for="atmTransfer">ATM轉帳</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="credit_card_form" style="display:none">
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">消費金額：NT＄ </label>
                                                        <input type="text" name="credit_card_consumption_amount">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">消費日期： </label>
                                                        <input type="date" name="credit_card_consumption_date">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">發卡銀行： </label>
                                                        <input type="text" name="bank_name">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">信用卡卡號（共16碼）：</label>
                                                        <input type="text" name="card_number_1" id="card_number_1" size="4" maxlength="4"> - 
                                                        <input type="text" name="card_number_2" id="card_number_2" size="4" maxlength="4"> - 
                                                        <input type="text" name="card_number_3" id="card_number_3" size="4" maxlength="4"> - 
                                                        <input type="text" name="card_number_4" id="card_number_4" size="4" maxlength="4">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">背面末3碼(信用卡背面簽名處上方)： </label>
                                                        <input type="text" name="creditCardCvv" size="5" maxlength="3">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">有效期限： </label>
                                                        <input type="text" name="card_expiry_month" id="card_expiry_month" size="4" maxlength="2">月
                                                        <input type="text" name="card_expiry_year" id="card_expiry_year" size="4" maxlength="2">年
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">持卡人簽名(需與信用卡上一致)： </label>
                                                        <div style="display: flex; flex-direction: column;">
                                                            <canvas id="signatureCredit" width="400" height="200"></canvas>
                                                            <button id="clearCreditSignatureBtn" type="button">清除簽名</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="credit_card_statement_form" style="display:none">
                                <div class="row mb-4 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="text-danger">★持卡人非訂購會員本人，務必完整填寫信用卡使用同意申明書。</p>
                                        <div class="card bg-light border-info mb30">
                                            <div class="card-body">
                                                <p class="fs20">信用卡使用同意聲明書 </p>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">持卡人本人： </label>
                                                        <input type="text" name="cardholder_name">
                                                        ；
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">身份證字號： </label>
                                                        <input type="text" name="cardholder_id_card_number" maxlength="10">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">本人授權台灣安露莎公司就訂購會員 </label>
                                                        <input type="text" name="credit_card_statement_agree_text">
                                                        ；
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">購買產品合計 </label>
                                                        <input type="text" name="credit_card_statement_agree_total_amount">
                                                        元
                                                    </div>
                                                    <div>得使用本人留存之信用卡資訊，填寫信用卡授權書向銀行請款支付上開消費金額，毋須再與本人電話確認。</div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">持卡人簽名：</label>
                                                        <div style="display: flex; flex-direction: column;">
                                                            <canvas id="signatureCreditAgreement" width="400" height="200"></canvas>
                                                            <button id="clearCreditAgreementBtn" type="button">清除簽名</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">日期：</label>
                                                        <input type="date" name="credit_card_statement_agree_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="eform_detail">
                                <hr class="mt-0 mb-4">
                                <?=$subView;?>
                                <hr class="my-4">
                            </form>
                            <form id="eform_main_2">
                                <div class="wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-12 text-right">
                                        <p class="fs20">建議售價合計：<input type="text" readonly name="totol_amount" id="totalAmount"></p>
                                    </div>
                                    <div class="col-12 text-right">
                                        <p class="fs20">代下單會員姓名：<input type="text" name="substitute_order_name" value="<?=$userdata['c_name'];?>"></p>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="wow fadeInUp" data-wow-delay=".2s">
                                <p class="text-danger">※訂購金額每滿建議售價4,000元，即附贈全產品型錄一本，滿建議售價2,000元，免付運費100元※</p>
                                <p class="text-danger">付款銀行：合作金庫銀行 復旦分行 銀行代號：006　　帳號：1254-717-706612　　受款人：台灣安露莎股份有限公司</p>
                                <p class="text-danger">付款郵局：郵政劃撥帳號： 50049675　　受款人：台灣安露莎股份有限公司</p>
                            </div>

                            <hr class="my-4">
                            <button type="button" id="submit_btn" class="btn btn-outline-danger btn-block">送出表單</button>
                        </div>
                        <div class="col-lg-1 d-none d-xl-block"></div>
                        <aside role="complementary" class="aside col-xl-3 col-md-3">
                            <div class="mt100 mb75">
                                <?= $this->block_service->member_right_menu('online_form'); ?>
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

    <script>
        class signature {
            constructor(canvasId) {
                this.canvasId = canvasId;
                this.canvas = document.getElementById(canvasId);
                this.ctx = this.canvas.getContext('2d');
                this.drawing = false;
                this.signatured = false;    // 是否有簽名

                // 設定筆刷樣式
                this.ctx.lineWidth = 2;
                this.ctx.lineCap = "round";
                this.ctx.strokeStyle = "#000";
            }

            // 監聽滑鼠事件
            init() {
                $('#' + this.canvasId).on('mousedown', (e) => {
                    console.log('mousedown');
                    this.signatured = true;
                    this.drawing = true;
                    this.ctx.beginPath();
                    this.ctx.moveTo(e.offsetX, e.offsetY);
                });

                $('#' + this.canvasId).on('mousemove', (e) => {
                    if (this.drawing) {
                        this.ctx.lineTo(e.offsetX, e.offsetY);
                        this.ctx.stroke();
                    }
                });

                $('#' + this.canvasId).on('mouseup mouseleave', () => {
                    this.drawing = false;
                });
            }

            // 取得簽名 Blob（圖片格式）
            getSignatureBlob() {
                return new Promise((resolve, reject) => {
                    if (!this.signatured) {
                        reject("請先簽名！");
                        return;
                    }
                    this.canvas.toBlob((blob) => {
                        if (blob) {
                            resolve(blob);
                        } else {
                            reject("轉換失敗");
                        }
                    }, "image/png");
                });
            }
        }
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
            
            const eform6 = (function() {
                $("#clearCreditSignatureBtn").click(function () {
                    var canvas = document.getElementById("signatureCredit"); // 確保獲取的是 DOM
                    var ctx = canvas.getContext("2d");
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });
                $("#clearCreditAgreementBtn").click(function () {
                    var canvas = document.getElementById("signatureCreditAgreement"); // 確保獲取的是 DOM
                    var ctx = canvas.getContext("2d");
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });

                function getFormData($form, returnData){
                    let data = $form.serializeArray();
                    $.map(data, function(n, i) {
                        if (returnData[n['name']] != null) {
                            returnData[n['name']] += "," + n['value'];
                        } else {
                            returnData[n['name']] = n['value'];
                        }
                    });
                    return returnData;
                }

                $('input[name="payment_method"]').change(function () {
                    $('#credit_card_form').hide();
                    $("#credit_card_form")[0].reset();
                    $('#credit_card_statement_form').hide();
                    $("#credit_card_statement_form")[0].reset();
                    if ($('#creditCard').is(':checked')) {
                        $('#credit_card_form').show();
                        $('#credit_card_statement_form').show();
                        $('input[name="card_type"]').prop('disabled', false);
                    } else {
                        $('input[name="card_type"]').prop('disabled', true).prop('checked', false);
                    }
                });

                const signatureCredit = new signature('signatureCredit');
                const signatureCreditAgreement = new signature('signatureCreditAgreement');
                signatureCredit.init();
                signatureCreditAgreement.init();

                $('#submit_btn').on('click', async function() {
                    if (!checkForm()) {
                        Swal.fire({
                            icon: "error",
                            title: "系統訊息",
                            text: "請檢查欄位是否皆已填寫",
                            showConfirmButton: false,
                            timer: 3000
                        })
                        return;
                    }
                    const formData = new FormData();
                    let mainData = {};
                    let detailData = {};
                    let creditData = {};
                    let creditStatementData = {};

                    mainData = getFormData($('#eform_main_1'), mainData);
                    mainData = getFormData($('#eform_main_2'), mainData);

                    detailData = getFormData($('#eform_detail'), detailData);
                    creditData = getFormData($('#credit_card_form'), creditData);
                    creditStatementData = getFormData($('#credit_card_statement_form'), creditStatementData);

                    // 處理簽名
                    if (signatureCredit.signatured) {
                        const blob = await signatureCredit.getSignatureBlob();
                        formData.append('signatureCredit', blob, 'signatureCredit.png');
                    }
                    if (signatureCreditAgreement.signatured) {
                        const blob = await signatureCreditAgreement.getSignatureBlob();
                        formData.append('signatureCreditAgreement', blob, 'signatureCreditAgreement.png');
                    }

                    // 將 JSON 物件轉為字串，然後加入 FormData
                    formData.append('mainData', JSON.stringify(mainData));
                    formData.append('creditData', JSON.stringify(creditData));
                    formData.append('creditStatementData', JSON.stringify(creditStatementData));
                    formData.append('detailData', JSON.stringify(detailData));

                    $.ajax({
                        url: '<?=$apiUrl;?>',
                        type: 'POST',
                        data: formData,
                        processData: false,  // 不處理數據
                        contentType: false,  // 不設置內容類型
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "系統訊息",
                                text: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            // 3 秒後刷新頁面
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        },
                        error: function(xhr, status, error) {
                            let errorResponse = xhr.responseJSON || { message: "資料新增失敗" };
                            Swal.fire({
                                icon: "error",
                                title: "系統訊息",
                                text: errorResponse.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                });

                function checkForm() {
                    let selectedPayment = $("input[name='payment_method']:checked").val();

                    if (!selectedPayment) {
                        return false;
                    }

                    if (selectedPayment === "credit_card") {
                        if ($("input[name='card_type']:checked").length === 0) {
                            return false;
                        }
                    }
                    return true;
                }

                function calculateTotal() {
                    let total = 0;

                    // 遍歷所有 .product-item，計算總金額
                    $('.product-item').each(function () {
                        let quantity = parseInt($(this).find('.quantity').val()) || 0;
                        let price = parseFloat($(this).find('.price').val()) || 0;
                        total += quantity * price;
                    });

                    // 更新合計金額
                    $('#totalAmount').val(total);
                }
                const $formDetail = $('#eform_detail');
                $formDetail.find('.quantity, .price').on('input', calculateTotal);
            })();

            $("#back2Top").click(function(event) {
                event.preventDefault();
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                return false;
            });
        });
        /*Scroll to top when arrow up clicked BEGIN*/
        $(window).scroll(function() {
            var height = $(window).scrollTop();
            if (height > 100) {
                $('#back2Top').fadeIn();
            } else {
                $('#back2Top').fadeOut();
            }
        });
        /*Scroll to top when arrow up clicked END*/
    </script>

</body>

</html>