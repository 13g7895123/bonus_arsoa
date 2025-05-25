<style>
#signaturePad {
    border: 2px solid #000;
    width: 300px;
    height: 150px;
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
                                <h1 class="h2-3d font-libre"><strong>單次宅配單異動申請書</strong></h1>
                                <div class="row d-flex justify-content-between mb30 wow fadeInUp" data-wow-delay=".2s">
                                    <p class="text-danger">★務必於宅配出貨日的前3個工作天提出申請書。</p>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineRadio4">異動日期： </label>
                                        <input type="text" name="change_date">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <p class="fs20">◆ 申請異動的會員資訊：</p>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="c_no">會員編號： </label>
                                                        <input type="text" size="10" maxlength="6" id="c_no" name="c_no" value="<?= $userdata['c_no']; ?>">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="c_name">會員姓名： </label>
                                                        <input type="text" value="<?= $userdata['c_name'];?>" id="c_name">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="member_contact_phone">聯絡電話： </label>
                                                        <input type="text" size="12" maxlength="10" value="<?= $userdata['cell1']; ?>" id="member_contact_phone">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <input class="muscle_energy_home_delivery_ten_days form-check-input" type="checkbox" name="muscle_energy_home_delivery_ten_days" id="muscle_energy_home_delivery_ten_days" value="muscle_energy_home_delivery_ten_days">
                                                        <label class="form-check-label" for="muscle_energy_home_delivery_ten_days">肌能宅配10日 </label>
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline"> 保健宅配　
                                                        <input class="health_care form-check-input" type="checkbox" id="five_days" value="five_days">
                                                        <label class="form-check-label" for="five_days">5日 </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="health_care form-check-input" type="checkbox" id="twenty_days" value="twenty_days">
                                                        <label class="form-check-label" for="twenty_days">20日 </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="health_care form-check-input" type="checkbox" id="vitality_fermentation_extract" value="vitality_fermentation_extract">
                                                        <label class="form-check-label" for="vitality_fermentation_extract">活力發酵精萃 </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="health_care form-check-input" type="checkbox" id="white_crane_ganoderma_extract" value="white_crane_ganoderma_extract">
                                                        <label class="form-check-label" for="white_crane_ganoderma_extract">白鶴靈芝EX </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="health_care form-check-input" type="checkbox" id="beauty_C_tablets" value="beauty_C_tablets">
                                                        <label class="form-check-label" for="beauty_C_tablets">美力C錠 </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb30 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="fs20">◆ 出貨日異動</p>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="shipped_in_advance" id="shipped_in_advance" value="shipped_in_advance">
                                                <label class="form-check-label" for="shipped_in_advance">須提前出貨 </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="delivery_date">日期： </label>
                                                <input type="text" id="delivery_date" name="delivery_date" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <p class="fs20">◆ 收件人地址異動</p>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="postal_code">郵遞區號： </label>
                                                <input type="text" name="postal_code" id="postal_code">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="delivery_address">收件地址： </label>
                                                <input type="text" name="delivery_address" id="delivery_address">
                                            </div>
                                        </div>
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="consignee_name">收件人： </label>
                                                <input type="text" name="consignee_name" id="consignee_name">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="consignee_contact_phone_number">收件人聯絡電話： </label>
                                                <input type="text" name="consignee_contact_phone_number" id="consignee_contact_phone_number">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-4 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="fs20">◆ 單次信用卡異動：(如無異動不需填寫) ※若為授權卡異動請一併提供《信用卡付款授權書》。</p>
                                        <div class="card bg-light border-danger">
                                            <div class="card-body">
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="credit_c_no">會員編號： </label>
                                                        <input type="text" size="10" maxlength="6" id="credit_c_no">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="credit_c_name">會員姓名： </label>
                                                        <input type="text" id="credit_c_name">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="credit_contact_phone">聯絡電話： </label>
                                                        <input type="text" size="12" maxlength="10" id="credit_contact_phone">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        信用卡卡別：
                                                        <input class="form-check-input" type="radio" name="card_type" id="card_type_visa" value="VISA">
                                                        <label class="form-check-label" for="card_type_visa">VISA</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="card_type" id="card_type_master" value="MASTER">
                                                        <label class="form-check-label" for="card_type_master">MASTER</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="card_type" id="card_type_jcb" value="JCB">
                                                        <label class="form-check-label" for="card_type_jcb">JCB</label>
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="monthly_payment">每月付款金額： </label>
                                                        <input type="text" id="monthly_payment">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="bank">發卡銀行： </label>
                                                        <input type="text" id="bank">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="card_number_1">信用卡卡號（共16碼）：</label>
                                                        <input type="text" size="4" maxlength="4" id="card_number_1">
                                                        -
                                                        <input type="text" size="4" maxlength="4" id="card_number_2">
                                                        -
                                                        <input type="text" size="4" maxlength="4" id="card_number_3">
                                                        -
                                                        <input type="text" size="4" maxlength="4" id="card_number_4">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="card_expiry_month">有效期限： </label>
                                                        <input type="text" size="4" maxlength="2" id="card_expiry_month">
                                                        月
                                                        <input type="text" size="4" maxlength="2" id="card_expiry_year">
                                                        年
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">持卡人簽名： </label>
                                                        <div style="display: flex; flex-direction: column;">
                                                            <canvas id="signaturePad" width="300" height="150"></canvas>
                                                            <button id="clearBtn">清除簽名</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb30 wow fadeInUp">
                                    <div class="mb30">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label" for="agent_application">代理申請會員姓名 (或會員編號)： </label>
                                            <input type="text" name="agent_application" id="agent_application">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_1">姓名：</label>
                                            <input type="text" id="name_1">　
                                            <label class="label-custom" for="member_code_1">會員編號：</label>
                                            <input type="text" id="member_code_1">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_1">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_1"><input type="text" class="w-100 mb-2" id="delivery_item_1">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_1">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_1"><input type="text" class="w-100 mb-2" id="redemption_item_1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_2">姓名：</label>
                                            <input type="text" id="name_2">　
                                            <label class="label-custom" for="member_code_2">會員編號：</label>
                                            <input type="text" id="member_code_2">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_2">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_2"><input type="text" class="w-100 mb-2" id="delivery_item_2">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_2">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_2"><input type="text" class="w-100 mb-2" id="redemption_item_2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_3">姓名：</label>
                                            <input type="text" id="name_3">　
                                            <label class="label-custom" for="member_code_3">會員編號：</label>
                                            <input type="text" id="member_code_3">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_3">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_3"><input type="text" class="w-100 mb-2" id="delivery_item_3">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_3">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_3"><input type="text" class="w-100 mb-2" id="redemption_item_3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_4">姓名：</label>
                                            <input type="text" id="name_4">　
                                            <label class="label-custom" for="member_code_4">會員編號：</label>
                                            <input type="text" id="member_code_4">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_4">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_4"><input type="text" class="w-100 mb-2" id="delivery_item_4">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_4">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_4"><input type="text" class="w-100 mb-2" id="redemption_item_4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_5">姓名：</label>
                                            <input type="text" id="name_5">　
                                            <label class="label-custom" for="member_code_5">會員編號：</label>
                                            <input type="text" id="member_code_5">
                                        </div>  
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_5">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_5"><input type="text" class="w-100 mb-2" id="delivery_item_5">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_5">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_5"><input type="text" class="w-100 mb-2" id="redemption_item_5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_6">姓名：</label>
                                            <input type="text" id="name_6">　
                                            <label class="label-custom" for="member_code_6">會員編號：</label>
                                            <input type="text" id="member_code_6">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_6">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_6"><input type="text" class="w-100 mb-2" id="delivery_item_6">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_6">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_6"><input type="text" class="w-100 mb-2" id="redemption_item_6">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb-2 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12 mb-2">
                                        <div class="form-check form-check-inline">
                                            <label class="label-custom" for="name_7">姓名：</label>
                                            <input type="text" id="name_7">　
                                            <label class="label-custom" for="member_code_7">會員編號：</label>
                                            <input type="text" id="member_code_7">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="card bg-light ">
                                            <div class="card-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="delivery_date_7">宅配日 & 品項：</label>
                                                            <input type="text" class="w-100 mb-2" id="delivery_date_7"><input type="text" class="w-100 mb-2" id="delivery_item_7">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="label-custom" for="purchase_item_7">訂購品項 & 兌換紅利商品：</label>
                                                            <input type="text" class="w-100 mb-2" id="purchase_item_7"><input type="text" class="w-100 mb-2" id="redemption_item_7">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-4">

                                <div class="row mb30 wow fadeInUp" data-wow-delay=".2s">
                                    <div class="col-lg-12">
                                        <p class="">注意事項：</p>
                                        <ol>
                                            <li>每月宅配出貨日前2個工作天為前置作業時間，請務必須於宅配出貨日的前3個工作天(含)完成異動申請，若前置作業時間(含出貨當日)提出異動，將於當期宅配出貨完畢後受理，不保證在宅配正常出貨期間內處理完畢。為避免影響當月佣金領取資格，請務必於宅配出貨日前3個工作天(含)提出異動申請，以確保自身權益。</li>
                                            <li>如長期變更宅配循環、宅配品項、扣款之信用卡，請重新填寫宅配訂單並勾選變更。</li>
                                        </ol>
                                    </div>
                                </div>


                                <hr class="my-4">
                                <button type="button" id="submit" class="btn btn-outline-danger btn-block">送出表單</button>
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

            // 肌能宅配10日
            class MuscleEenergy {
                constructor() {
                    this.data = [];
                    this.isChecked = false;
                }

                // 取得資料
                fetchData() {
                    // 先清空 data，避免重複累積舊資料
                    this.data = [];

                    // 使用箭頭函式確保 this 指向 MuscleEenergy 類別
                    $('.muscle_energy_home_delivery_ten_days').each((index, element) => {
                        if ($(element).is(':checked')) {
                            this.data.push($(element).val());
                        }
                    });

                    // 判斷是否有選擇
                    this.isChecked = this.data.length > 0;
                }
            }
                
            // 健保宅配
            class HealthCare {
                constructor() {
                    this.data = [];
                    this.isChecked = false;
                }

                // 取得資料
                fetchData() {
                    // 先清空 data，避免重複累積舊資料
                    this.data = [];

                    // 使用箭頭函式確保 this 指向 HealthCare 類別
                    $('.health_care').each((index, element) => {
                        if ($(element).is(':checked')) {
                            this.data.push($(element).val());
                        }
                    });
                }

                // 5日
                fetchFiveDays() {
                    if (this.data.includes('five_days')) {
                        return true;
                    }
                    return false;
                }

                // 20日
                fetchTwentyDays() {
                    if (this.data.includes('twenty_days')) {
                        return true;
                    }
                    return false;
                }

                // 活力發酵精萃
                fetchVitalityFermentationExtract() {
                    if (this.data.includes('vitality_fermentation_extract')) {
                        return true;
                    }
                    return false;
                }
                
                // 白鶴靈芝EX
                fetchWhiteCraneGanodermaExtract() {
                    if (this.data.includes('white_crane_ganoderma_extract')) {
                        return true;
                    }
                    return false;
                }

                // 美力C錠
                fetchBeautyCTablets() {
                    if (this.data.includes('beauty_C_tablets')) {
                        return true;
                    }
                    return false;
                }
            }

            // 出貨日異動
            class ChangeDeliveryDate {
                constructor() {
                    this.isChecked = false;
                    this.date = '';
                }

                // 取得資料
                fetchData() {
                    // 確認勾選
                    this.isChecked = false;
                    if ($("#shipped_in_advance").prop("checked")) {
                        this.isChecked = true;
                    }
                    
                    if ($('input[name="delivery_date"]').val() !== '') {
                        this.date = $('input[name="delivery_date"]').val();
                    }
                }

                // 更新渲染
                updateRender() {
                    // 預設禁用
                    $("#delivery_date").prop("disabled", true); 

                    // 確認勾選
                    if (this.isChecked) {
                        $("#delivery_date").prop("disabled", false); 
                    }
                }
            }

            const muscleEenergy = new MuscleEenergy();
            const healthCare = new HealthCare();
            const changeDeliveryDate = new ChangeDeliveryDate();

            // 須提前出貨
            $('input[name="shipped_in_advance"]').on('change', function() {
                changeDeliveryDate.fetchData();
                changeDeliveryDate.updateRender();
            });

            // 簽名
            const signaturePad = new signature('signaturePad');

            signaturePad.init();

            $('#submit').click(async function() {
                muscleEenergy.fetchData();
                healthCare.fetchData();
                changeDeliveryDate.fetchData();

                const formData = new FormData();
                formData.append('change_date', $('input[name="change_date"]').val());
                formData.append('c_no', $('#c_name').val());
                formData.append('muscle_energy_home_delivery_ten_days', muscleEenergy.isChecked);
                formData.append('five_days', healthCare.fetchFiveDays());
                formData.append('twenty_days', healthCare.fetchTwentyDays());
                formData.append('vitality_fermentation_extract', healthCare.fetchVitalityFermentationExtract());
                formData.append('white_crane_ganoderma_extract', healthCare.fetchWhiteCraneGanodermaExtract());
                formData.append('beauty_C_tablets', healthCare.fetchBeautyCTablets());
                formData.append('delivery_date', changeDeliveryDate.date);
                formData.append('postal_code', $('input[name="postal_code"]').val());
                formData.append('delivery_address', $('input[name="delivery_address"]').val());
                formData.append('consignee_name', $('input[name="consignee_name"]').val());
                formData.append('consignee_contact_phone_number', $('input[name="consignee_contact_phone_number"]').val());

                // 信用卡
                formData.append('credit_c_no', $('#credit_c_no').val());
                formData.append('credit_c_name', $('#credit_c_name').val());
                formData.append('credit_contact_phone', $('#credit_contact_phone').val());
                formData.append('card_type', $('input[name="card_type"]:checked').val());
                formData.append('monthly_payment', $('#monthly_payment').val());
                formData.append('bank', $('#bank').val());
                formData.append('card_number', $('#card_number_1').val().toString() + $('#card_number_2').val().toString() + $('#card_number_3').val().toString() + $('#card_number_4').val().toString());
                formData.append('card_expiry_month', $('#card_expiry_month').val());
                formData.append('card_expiry_year', $('#card_expiry_year').val());
                
                // 處理簽名
                if (signaturePad.signatured) {
                    const blob = await signaturePad.getSignatureBlob();
                    formData.append('signature', blob, 'signature.png');
                }

                // 代理申請
                formData.append('agent_application', $('#agent_application').val());

                // 細項
                for (let i = 1; i <= 7; i++) {
                    formData.append('name_' + i, $('#name_' + i).val());
                    formData.append('member_code_' + i, $('#member_code_' + i).val());
                    formData.append('delivery_date_' + i, $('#delivery_date_' + i).val());
                    formData.append('delivery_item_' + i, $('#delivery_item_' + i).val());
                    formData.append('purchase_item_' + i, $('#purchase_item_' + i).val());
                    formData.append('redemption_item_' + i, $('#redemption_item_' + i).val());
                }
                
                $.ajax({
                    url: '<?=$apiUrl;?>',
                    type: 'POST',
                    processData: false,  // 不處理數據
                    contentType: false,  // 不設置內容類型
                    data: formData,
                    success: function(response) {
                        if (response.status == '200') {
                            Swal.fire({
                                icon: 'success',
                                title: '提交成功', 
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                // window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '提交失敗',
                                text: response.message || '提交過程中發生錯誤，請稍後再試',
                                confirmButtonText: '確定'
                            });
                        }
                    }
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