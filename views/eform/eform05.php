<style>
#signaturePad {
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
            <div class="section-mini">
                <div class="section-item text-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mb130 mt-lg-5" role="main">
                                <h1 class="h2-3d font-libre"><strong>《信用卡付款授權書》</strong></h1>
                                <div class="mb30">
                                    <div class="wow fadeInUp" data-wow-delay=".2s">
                                        <p class="fs20">本人於訂購安露莎產品時，如果選擇以信用卡方式支付貨款，限本人同意授權以本信用卡支付，特立此書，以茲證明。</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">會員編號： </label>
                                                        <input type="text" size="10" maxlength="6" id="member_code" name="member_code" value="<?= $userdata['c_no']; ?>">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">會員姓名： </label>
                                                        <input type="text" value="<?= $userdata['c_name']; ?>">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline"> 信用卡卡別：
                                                        <input class="card_type form-check-input" type="checkbox" id="visa" value="VISA">
                                                        <label class="form-check-label" for="visa">VISA</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="card_type form-check-input" type="checkbox" id="master" value="MASTER">
                                                        <label class="form-check-label" for="master">MASTER</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="card_type form-check-input" type="checkbox" id="jcb" value="JCB">
                                                        <label class="form-check-label" for="jcb">JCB</label>
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">信用卡卡號（共16碼）：</label>
                                                        <input type="text" size="4" maxlength="4" name="creditCardNumber1" id="creditCardNumber1">
                                                        -
                                                        <input type="text" size="4" maxlength="4" name="creditCardNumber2" id="creditCardNumber2">
                                                        -
                                                        <input type="text" size="4" maxlength="4" name="creditCardNumber3" id="creditCardNumber3">
                                                        -
                                                        <input type="text" size="4" maxlength="4" name="creditCardNumber4" id="creditCardNumber4">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">有效月年： </label>
                                                        <input type="text" size="2" maxlength="2" name="creditCardExpireMonth" id="creditCardExpireMonth">
                                                        月
                                                        <input type="text" size="2" maxlength="2" name="creditCardExpireYear" id="creditCardExpireYear">
                                                        年
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="creditCardBank">發卡銀行： </label>
                                                        <input type="text" name="creditCardBank" id="creditCardBank">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="creditCardCvv">背面末3碼： </label>
                                                        <input type="text" size="3" maxlength="3" name="creditCardCvv" id="creditCardCvv">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="creditCardName">信用卡英文姓名： </label>
                                                        <input type="text" name="creditCardName" id="creditCardName">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb30 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="fs20">※詳閱並同意信用卡授權相關說明及注意事項後簽名。</p>
                                    </div>
                                </div>

                                <div class="mb30 wow fadeInUp d-flex flex-column justify-content-between">
                                    <div class="mb30">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="date1">日期： </label>
                                            <input type="text" size="4" maxlength="4" name="date1" id="date1">
                                            年
                                            <input type="text" size="2" maxlength="2" name="date2" id="date2">
                                            月
                                            <input type="text" size="2" maxlength="2" name="date3" id="date3">
                                            日
                                        </div>
                                    </div>
                                    <div class="mb30">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="signaturePad">持卡人簽名： </label>
                                            <canvas id="signaturePad" width="400" height="200"></canvas>
                                            <button id="clearBtn">清除簽名</button>
                                            (與信用卡一致)
                                        </div>
                                    </div>
                                </div>

                                <div class="mb30 wow fadeInUp">
                                    <div class="form-group mb30">
                                        <label for="creditCardFront">信用卡（正面）</label>
                                        <input type="file" class="form-control-file" id="creditCardFront" name="creditCardFront">
                                    </div>
                                    <div class="form-group mb30">
                                        <label for="creditCardBack">信用卡（背面）</label>
                                        <input type="file" class="form-control-file" id="creditCardBack" name="creditCardBack">
                                    </div>
                                </div>

                                <hr class="mt-0 mb-4">

                                <div class="row mb30 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="">注意事項：</p>
                                        <ol>
                                            <li>資料建檔完成後，訂貨時只需在訂單上清楚填寫本人的消費金額、消費日期、發卡銀行，並由持卡人於訂單上簽名（與信用卡之簽名相符）即可。</li>
                                            <li>信用卡噩失或邁期，請重新填寫授權書，並郵寄或直接遞交至本公司。</li>
                                            <li>每位會員，最多可建檔三張信用卡資料。</li>
                                        </ol>
                                    </div>
                                </div>


                                <hr class="my-4">
                                <button id="submit" class="btn btn-outline-danger btn-block">送出表單</button>



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
    class CardType {
        constructor() {
            this.cardType = '';
        }

        setCardType(cardType) {
            this.cardType = cardType;
        }

        clearCardType() {
            $('.card_type').each((index, element) => {
                $(element).prop('checked', false);
            });
        }

        changeCardType() {
            $(`.card_type[value="${this.cardType}"]`).prop('checked', true);
        }
        
        updateRender() {
            this.clearCardType();                   // 清除所有checked
            this.changeCardType();     // 設定checked
        }
    }

    class CreditCardData {
        constructor() {
            this.creditCardNumber = '';
            this.creditCardData = {
                'cardType': '',
                'creditCardNumber': '',
                'creditCardExpireMonth': '',
                'creditCardExpireYear': '',
                'creditCardBank': '',
                'creditCardCvv': '',
                'creditCardEnglishName': '',
            };
        }

        getcreditCardNumber() {
            for (let i = 0; i < 4; i++) {
                this.creditCardNumber += String($('#creditCardNumber' + (i + 1)).val());
            }
        }

        getcreditCardData() {
            this.creditCardData.cardType = $('.card_type:checked').val();
            this.creditCardData.creditCardNumber = this.creditCardNumber;
            this.creditCardData.creditCardExpireMonth = $('#creditCardExpireMonth').val();
            this.creditCardData.creditCardExpireYear = $('#creditCardExpireYear').val();
            this.creditCardData.creditCardBank = $('#creditCardBank').val();
            this.creditCardData.creditCardCvv = $('#creditCardCvv').val();
            this.creditCardData.creditCardEnglishName = $('#creditCardName').val();
        }
    }
    </script>
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

            const cardType = new CardType();
            const creditCardData = new CreditCardData();

            // 選擇信用卡類別
            $('.card_type').click(function() {
                if ($(this).prop('checked')) {
                    let value = $(this).val(); // 取得 value
                    cardType.setCardType(value);
                    cardType.updateRender();

                    return;
                }

                cardType.clearCardType();
            });

            // 簽名
            let canvas = document.getElementById('signaturePad');
            let ctx = canvas.getContext('2d');
            let drawing = false;
            let signatured = false;     // 是否有簽名

            // 設定筆刷樣式
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.strokeStyle = "#000";

            // 監聽滑鼠事件
            $('#signaturePad').on('mousedown', function(e) {
                signatured = true;
                drawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            });

            $('#signaturePad').on('mousemove', function(e) {
                if (drawing) {
                    ctx.lineTo(e.offsetX, e.offsetY);
                    ctx.stroke();
                }
            });

            $('#signaturePad').on('mouseup mouseleave', function() {
                drawing = false;
            });

            $('#submit').click(function() {

                // 顯示載入中提示
                Swal.fire({
                    title: '處理中...',
                    text: '正在提交您的申請',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                creditCardData.getcreditCardNumber();
                creditCardData.getcreditCardData();

                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create FormData and append file
                    let formData = new FormData();
                    formData.append('c_name', $('#member_code').val());
                    formData.append('credit', JSON.stringify(creditCardData.creditCardData));
                    formData.append('year', $('#date1').val());
                    formData.append('month', $('#date2').val());
                    formData.append('day', $('#date3').val());

                    if (signatured) {
                        formData.append('signature', blob, 'signature.png');
                    }

                    let creditCardFront = $('#creditCardFront')[0].files[0];
                    let creditCardBack = $('#creditCardBack')[0].files[0];
                    
                    // Append credit card files if they exist
                    if (creditCardFront) {
                        formData.append('creditCardFront', creditCardFront);
                    }
                    if (creditCardBack) {
                        formData.append('creditCardBack', creditCardBack); 
                    }
                    
                    // Send file via AJAX
                    $.ajax({
                        url: '<?=$apiUrl;?>', 
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: '提交成功', 
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                });
            });
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