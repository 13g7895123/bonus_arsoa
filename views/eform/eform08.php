<body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
        <div class="wrapper">
            <?= $this->block_service->load_html_header(); ?>
            <div class="section-mini">
                <div class="section-item text-left">
                    <div class="container">
                        <div class="row wow fadeInUp" data-wow-delay=".2s">
                            <div class="col-md-8 mb130 mt-lg-5" role="main">
                                <h1 class="h2-3d font-libre"><strong>自動轉帳付款授權書</strong></h1>
                                <div class="row d-flex justify-content-between mb30">
                                    <p class="text-danger"></p>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineRadio4">媒體產生日期： </label>
                                        <input type="text" id="media_date">
                                    </div>
                                </div>

                                <div class="row mb30">
                                    <div class="col-lg-12">
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">立授權書人（以下稱授權人）： </label>
                                                <input type="text" id="name1">
                                            </div>
                                            <p>授權郵局依照 台灣安露莎股份有限公司提供之資料，自授權人在郵局開立之儲金帳戶以自動轉帳付款方式，交付 貨款 款項；惟帳戶餘額不足支付帳款時，則不予轉帳。</p>
                                            <p>郵局如因電腦系統故障、電腦設備故障、電信線路故障、停電、斷電、第三人之行為、不可抗力或其他不可歸責於郵局之事由致無法於 約定日期完成轉帳作業時，郵局得順延至前開障礙事由排除後始進行轉帳作業，因而所致之遲延或損失，授權人同意免除郵局之一切責任。但該障礙事由係郵局之故意或重大過失所致者，不在此限。</p>
                                            <p>授權人同意於郵局轉帳金額與應繳帳款不符時，自行洽 台灣安露莎股份有限公司 查詢釐清 及辦理補、退款等事宜，且授權書上屬於 台灣安露莎股份有限公司 與授權人間權利義務之約定事項與郵局無關者，概與郵局無涉。</p>
                                            <p>本授權書簽訂完成後，其效力不受帳戶印鑑變更影響；原付款帳戶辦理轉移者，將自動由新帳戶繼續扣款。授權人欲終止轉帳扣款時，應以書面方式向郵局或台灣安露莎股份有限公司辦妥終止授權手續。</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <p class="fs20">◆ 授權人</p>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">戶名： </label>
                                                <input type="text" id="name2">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">身份證統一編號： </label>
                                                <input type="text" id="id_number">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">存簿帳號： </label>
                                                <input type="text" id="account_number">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">劃撥帳號： </label>
                                                <input type="text" id="transfer_account">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">聯絡電話：
                                                <label class="form-check-label" for="inlineRadio4">（宅）： </label>
                                                <input type="text" size="12" maxlength="10" id="phone_home">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">（公）： </label>
                                                <input type="text" size="12" maxlength="10" id="phone_office">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">（手機）： </label>
                                                <input type="text" size="12" maxlength="10" id="phone_mobile">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">聯絡地址： </label>
                                                <input type="text" size="50" maxlength="50" id="address">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-group mb30">
                                                <label for="exampleFormControlFile1">授權人用印（帳戶印鑑）</label>
                                                <input type="file" class="form-control-file" id="file" name="file">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio4">授權書填寫日期： </label>
                                                <input type="text" size="4" maxlength="2" id="year">
                                                年
                                                <input type="text" size="4" maxlength="2" id="month">
                                                月
                                                <input type="text" size="4" maxlength="2" id="day">
                                                日
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="mb30">
                                    <div class="mb30">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="inlineRadio4">授權人簽名： </label>
                                            <input type="text" id="sign">
                                        </div>
                                    </div>
                                </div>


                                <hr class="my-4">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>_eform08" value="<?php echo $this->security->get_csrf_hash(); ?>">
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

            $('#submit_btn').click(function() {
                submitForm();
            });

            function submitForm() {
                const apiUrl = '<?=$apiUrl;?>';

                const formData = {
                    media_date: $('#media_date').val(),
                    name1: $('#name1').val(),
                    id_number: $('#id_number').val(),
                    account_number: $('#account_number').val(),
                    transfer_account: $('#transfer_account').val(),
                    phone_home: $('#phone_home').val(),
                    phone_office: $('#phone_office').val(),
                    phone_mobile: $('#phone_mobile').val(),
                    address: $('#address').val(),
                    file: $('#file').val(),
                    '<?=$this->security->get_csrf_token_name();?>': $('#<?=$this->security->get_csrf_token_name(); ?>_eform08').val()
                };

                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                    }
                });
            }
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