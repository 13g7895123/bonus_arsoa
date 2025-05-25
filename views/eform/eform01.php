<style>
#signaturePad {
    border: 2px solid #000;
    width: 400px;
    height: 200px;
    cursor: crosshair;
}
</style>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
        <div class="wrapper parallax-start">
            <?= $this->block_service->load_html_header(); ?>
            <div class="section-mini">
                <div class="section-item text-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                                <form id="eform_main_1">
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
                                            <div class="row">
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">收貨人</label>
                                                    <input type="text" name="consignee_name" class="form-control form-control-custom" placeholder="請填收貨人" value="<?=$userdata['c_name'];?>" />
                                                </div>
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">手機</label>
                                                    <input type="text" name="consignee_cellphone_number" class="form-control form-control-custom" placeholder="請填手機" value="<?=$userdata['cell1'];?>" />
                                                </div>
                                                <div class="col-sm-4 mb30">
                                                    <label class="label-custom">聯絡電話</label>
                                                    <input type="text" name="consignee_contact_phone_number" class="form-control form-control-custom" placeholder="請填聯絡電話" value="<?=$userdata['cell1'];?>" />
                                                </div>
                                                <div class="col-sm-12 mb30">
                                                    <label class="label-custom">送貨地址</label>
                                                    <input type="text" name="delivery_address" class="form-control form-control-custom" placeholder="請填寫完整地址" value="<?=$userdata['addr_dl'];?>" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <p>付款郵局：郵政劃撥帳號：50049675</p>
                                                    <p>付款銀行：合作金庫銀行復旦分行銀行代號：006　帳號：1254-717-706612　受款人：台灣安露莎股份有限公司</p>
                                                    <p>付款方式：</p>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="creditCard" value="credit_card">
                                                        <label class="form-check-label" for="creditCard">信用卡（請填寫下欄框內資料） </label>
                                                    </div>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="postalTransfer" value="postal_transfer">
                                                        <label class="form-check-label" for="postalTransfer">劃撥交易序碼：</label>
                                                        <input type="text" name="postal_transaction_number">
                                                    </div>
                                                    <div class="form-check form-check mb20">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="atmTransfer" value="atm_transfer">
                                                        <label class="form-check-label" for="atmTransfer">ATM轉帳、銀行電匯（帳號後五碼）：</label>
                                                        <input type="text" name="atm_transaction_number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="credit_card_form" style="display:none">
                                    <div class="container mb-4 wow fadeInUp">
                                        <div class="card bg-light border-danger">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="form-check form-check mb20">
                                                            <label class="form-check-label" for="inlineRadio4">本人</label>
                                                            <input type="text" name="member_name">
                                                            <label class="form-check-label" for="inlineRadio4">身份證字號</label>
                                                            <input type="text" name="member_id_card_number">
                                                            授權台灣安露莎股份有限公司使用本人之信用卡支付以下訂購人之消費貨款（以電腦系統金額為主），無任何異議。
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">持卡人姓名：</label>
                                                            <input type="text" name="cardholder_name">
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">會員編號：</label>
                                                            <input type="text" name="c_no">
                                                        </div>
                                                        <div class="col-sm-4 mb30">
                                                            <label class="label-custom">聯絡電話：</label>
                                                            <input type="text" name="contact_phone_number">
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">發卡銀行：</label>
                                                            <input type="text" name="bank_name">
                                                            銀行（若使用安露莎授權卡支付請務必填寫發卡銀行與持卡人簽名）
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label" for="inlineRadio4">信用卡卡號（共16碼）：</label>
                                                            <input type="text" name="card_number_1" id="card_number_1" size="4" maxlength="4"> - 
                                                            <input type="text" name="card_number_2" id="card_number_2" size="4" maxlength="4"> - 
                                                            <input type="text" name="card_number_3" id="card_number_3" size="4" maxlength="4"> - 
                                                            <input type="text" name="card_number_4" id="card_number_4" size="4" maxlength="4">
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">有效期限：</label>
                                                            <input type="text" name="card_expiry_month" id="card_expiry_month" size="4" maxlength="2">月 20
                                                            <input type="text" name="card_expiry_year" id="card_expiry_year" size="4" maxlength="2">年
                                                        </div>
                                                        <div class="col-sm-12 mb30">
                                                            <label class="form-check-label">持卡人簽名：</label>
                                                            <div style="display: flex; flex-direction: column;">
                                                                <canvas id="signaturePad" width="400" height="200"></canvas>
                                                                <button id="clearSignaturePadBtn" type="button">清除簽名</button>
                                                            </div>
                                                            （同信用卡背面簽名）
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                    <hr class="mt-0 mb-4">
                                <form id="eform_main_2">
                                    <div class="container mb-4 wow fadeInUp">
                                        <div class="card bg-light border-info">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-3 mb30">
                                                            <label class="label-custom">貨號：</label>
                                                            <input type="text" name="p_no">
                                                        </div>
                                                        <div class="col-sm-6 mb30">
                                                            <label class="label-custom">品名：</label>
                                                            <input type="text" name="p_name" style="width: 100%;">
                                                        </div>
                                                        <div class="col-sm-3 mb30">
                                                            <label class="label-custom">建議售價：</label>
                                                            <input type="number" step="1" min="0" name="r_price" id="r_price">
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
                                <form id="eform_main_3">
                                    <div class="wow fadeInUp" data-wow-delay=".2s">
                                        <div class="col-12 text-right">
                                            <p class="fs20">代下單會員姓名：<input type="text" name="substitute_order_name" value="<?=$userdata['c_name'];?>"></p>
                                        </div>
                                        <div class="col-12 text-right">
                                            <p class="fs20">付款合計金額：<input type="text" readonly name="totol_amount"></p>
                                        </div>
                                    </div>
                                </form>
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
                this.signatured = false; // 是否有簽名

                // 設定筆刷樣式
                this.ctx.lineWidth = 2;
                this.ctx.lineCap = "round";
                this.ctx.strokeStyle = "#000";

                // 綁定事件
                this.init();
            }

            // 取得相對座標 (適用於滑鼠 & 觸控)
            getPosition(event) {
                const rect = this.canvas.getBoundingClientRect();
                if (event.touches) {
                    return {
                        x: event.touches[0].clientX - rect.left,
                        y: event.touches[0].clientY - rect.top
                    };
                } else {
                    return {
                        x: event.offsetX,
                        y: event.offsetY
                    };
                }
            }

            // 監聽滑鼠 & 觸控事件
            init() {
                // 滑鼠事件
                this.canvas.addEventListener('mousedown', (e) => this.startDraw(e));
                this.canvas.addEventListener('mousemove', (e) => this.draw(e));
                this.canvas.addEventListener('mouseup', () => this.stopDraw());
                this.canvas.addEventListener('mouseleave', () => this.stopDraw());

                // 觸控事件
                this.canvas.addEventListener('touchstart', (e) => this.startDraw(e), { passive: false });
                this.canvas.addEventListener('touchmove', (e) => this.draw(e), { passive: false });
                this.canvas.addEventListener('touchend', () => this.stopDraw());
                this.canvas.addEventListener('touchcancel', () => this.stopDraw());
            }

            // 開始繪圖
            startDraw(event) {
                event.preventDefault(); // 防止手機滾動畫面
                this.signatured = true;
                this.drawing = true;
                const pos = this.getPosition(event);
                this.ctx.beginPath();
                this.ctx.moveTo(pos.x, pos.y);
            }

            // 繪製過程
            draw(event) {
                if (!this.drawing) return;
                event.preventDefault();
                const pos = this.getPosition(event);
                this.ctx.lineTo(pos.x, pos.y);
                this.ctx.stroke();
            }

            // 停止繪圖
            stopDraw() {
                this.drawing = false;
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

            
            const eform1 = (function() {
                $("input[name='payment_method']").change(function () {
                    // 先將所有的輸入框禁用並清空
                    $("input[name='postal_transaction_number'], input[name='atm_transaction_number']").prop("disabled", true).val("");
                    // 將信用卡資訊隱藏
                    $("#credit_card_form").hide();
                    $("#credit_card_form")[0].reset();
                    // 根據選中的 radio 啟用對應的輸入框
                    if ($("#postalTransfer").is(":checked")) {
                        $("input[name='postal_transaction_number']").prop("disabled", false);
                    } else if ($("#atmTransfer").is(":checked")) {
                        $("input[name='atm_transaction_number']").prop("disabled", false);
                    } else if ($("#creditCard").is(":checked")) {
                        $("#credit_card_form").show();
                        $("input[name='member_name']").val('<?=$userdata['c_name'];?>');
                        $("input[name='cardholder_name']").val('<?=$userdata['c_name'];?>');
                        $("input[name='c_no']").val('<?=$userdata['c_no'];?>');
                        $("input[name='contact_phone_number']").val('<?=$userdata['cell1'];?>');
                    }
                });

                // 預設禁用所有輸入框
                $("input[name='postal_transaction_number'], input[name='atm_transaction_number']").prop("disabled", true);
                
                $("#clearSignaturePadBtn").click(function () {
                    var canvas = document.getElementById("signaturePad"); // 確保獲取的是 DOM
                    var ctx = canvas.getContext("2d");
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });
                // 簽名
                const signaturePad = new signature('signaturePad');
                signaturePad.init();

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

                function checkForm() {
                    let selectedPayment = $("input[name='payment_method']:checked").val();

                    if (!selectedPayment) {
                        return false;
                    }

                    if (selectedPayment === "postal_transfer") {
                        if ($("input[name='postal_transaction_number']").val() === '') {
                            return false;
                        }
                    }
                    if (selectedPayment === "atm_transfer") {
                        if ($("input[name='atm_transaction_number']").val() === '') {
                            return false;
                        }
                    }
                    return true;
                }

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
                    
                    mainData = getFormData($('#eform_main_1'), mainData);
                    mainData = getFormData($('#eform_main_2'), mainData);
                    mainData = getFormData($('#eform_main_3'), mainData);

                    creditData = getFormData($('#credit_card_form'), creditData);
                    // 處理簽名
                    if (signaturePad.signatured) {
                        const blob = await signaturePad.getSignatureBlob();
                        formData.append('signature', blob, 'signature.png');
                    }
                    
                    detailData = getFormData($('#eform_detail'), detailData);

                    // 將 JSON 物件轉為字串，然後加入 FormData
                    formData.append('mainData', JSON.stringify(mainData));
                    formData.append('creditData', JSON.stringify(creditData));
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
                

                $("#back2Top").click(function(event) {
                    event.preventDefault();
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                    return false;
                });

                function calculateAmount(index) {
                    let price = parseFloat($("#r_price").val()) || 0; // 獲取建議售價
                    if ($("input[name='purchaser_num_" + index + "']").val() != "") {
                        let quantity = parseInt($("input[name='purchaser_num_" + index + "']").val()) || 0; // 獲取數量
                        let total = price * quantity; // 計算金額
                        
                        $("input[name='purchaser_amount_" + index + "']").val(total); // 更新金額
                        calculateTotal(); // 更新總計金額
                    }
                }
                function calculateTotal() {
                    let totalAmount = 0;
                    $("input[name^='purchaser_amount_']").each(function() {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                    $("input[name='totol_amount']").val(totalAmount); // 更新總計金額
                }
                
                // 當建議售價變更時，重新計算所有金額
                $("#r_price").on("input", function() {
                    $("input[name^='purchaser_num_']").each(function() {
                        let index = $(this).attr("name").split("_").pop();
                        calculateAmount(index);
                    });
                });
                // 當數量輸入框變更時，計算對應的金額
                $('#eform_detail').on("input", "input[name^='purchaser_num_']", function() {
                    let index = $(this).attr("name").split("_").pop();
                    calculateAmount(index);
                });
            })();
            
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