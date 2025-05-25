<style>
#signaturePad,
#signaturePadAgreement,
#signaturePadCheck {
    border: 2px solid #000;
    width: 300px;
    height: 150px;
    cursor: crosshair;
}

#signaturePadPost{
    border: 2px solid #000;
    width: 100%;
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
                                <h1 class="h2-3d font-libre"><strong>《肌能調理宅配訂單暨入會申請書》</strong></h1>
                                <div class="mb30">
                                    <div class="container wow fadeInUp" data-wow-delay=".2s">
                                        <form action="#" class="text-left" id="healthSubscriptionForm">
                                            <div class="row mb30">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="form_type" id="form_type_new" value="new">
                                                    <label class="form-check-label" for="form_type_new">新增</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="form_type" id="form_type_change" value="change">
                                                    <label class="form-check-label" for="form_type_change">異動：</label>
                                                    (自<input type="number" name="change_year" id="change_year" size="6" maxlength="4">年
                                                    <input type="number" name="change_month" id="change_month" size="4" maxlength="2">月起　
                                                    <input class="form-check-input" type="radio" name="change_type" id="change_type_card" value="card">
                                                    <label class="form-check-label" for="change_type_card">改卡</label>　
                                                    <input class="form-check-input" type="radio" name="change_type" id="change_type_item" value="item">
                                                    <label class="form-check-label" for="change_type_item">改品項</label>　　
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="order_date_check" id="order_date_check" value="1">
                                                    <label class="form-check-label" for="order_date_check">訂購日期：</label>
                                                    <input type="number" name="order_year" id="order_year" size="4" maxlength="4">年
                                                    <input type="number" name="order_month" id="order_month" size="4" maxlength="2">月
                                                    <input type="number" name="order_day" id="order_day" size="4" maxlength="2">日
                                                </div>
                                            </div>
                                            <div class="row mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="member_id">會員編號：</label>
                                                    <input type="text" name="member_id" id="member_id" size="8" maxlength="6" value="<?= $userdata['c_no']; ?>">
                                                    (欲以健康宅配專案入會，請將此申請表正本繳回本公司)
                                                </div>
                                            </div>
                                            <div class="row mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="order_member_name">訂購會員姓名：</label>
                                                    <input type="text" name="order_member_name" id="order_member_name" size="10" maxlength="8">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="member_id_card_number">身分證字號：</label>
                                                    <input type="text" name="member_id_card_number" id="member_id_card_number" size="10" maxlength="10">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">生日：</label>
                                                    <input type="number" name="birth_year" id="birth_year" size="4" maxlength="4">年
                                                    <input type="number" name="birth_month" id="birth_month" size="4" maxlength="2">月
                                                    <input type="number" name="birth_day" id="birth_day" size="4" maxlength="2">日
                                                </div>
                                            </div>
                                            <div class="row mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="shipping_address">收件地址：</label>
                                                    <input type="text" name="shipping_address" id="shipping_address" size="50">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="recipient_name">收件人：</label>
                                                    <input type="text" name="recipient_name" id="recipient_name" size="10" maxlength="8">
                                                </div>
                                            </div>
                                            <div class="row mb30">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="contact_phone">聯絡電話：</label>
                                                    <input type="tel" name="contact_phone" id="contact_phone" size="10" maxlength="10">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="referrer_id">推薦人會員編號：</label>
                                                    <input type="text" name="referrer_id" id="referrer_id" size="10" maxlength="8">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="referrer_name">推薦人姓名：</label>
                                                    <input type="text" name="referrer_name" id="referrer_name" size="10" maxlength="8">
                                                </div>
                                            </div>
                                            <div class="row mb30">
                                                <table class="table table-bordered mb-2 text-center">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th colspan="2">專案選項 ( 一次3期 / 6個月為一完整循環 )</th>
                                                            <th>每期贈品</th>
                                                            <th>每期宅配金額</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="checkbox" name="product[]" id="product_Q0001" value="Q0001"></td>
                                                            <td class="text-left">Q0001 135g 淨白活膚蜜皂 +安露莎化粧水Ⅰ</td>
                                                            <td>安露莎活妍泥膜(0BP）</td>
                                                            <td>2,580元/55BP</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" name="product[]" id="product_Q0002" value="Q0002"></td>
                                                            <td class="text-left">Q0002 135g 淨白活膚蜜皂 +安露莎化粧水Ⅱ</td>
                                                            <td>安露莎活妍泥膜(0BP）</td>
                                                            <td>2,790元/63BP</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" name="product[]" id="product_Q0003" value="Q0003"></td>
                                                            <td class="text-left">Q0003 135g 淨白活膚蜜皂 +安露莎活膚化粧水</td>
                                                            <td>安露莎活妍泥膜(0BP）</td>
                                                            <td>2,950元/65BP</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="checkbox" name="product[]" id="product_Q0004" value="Q0004"></td>
                                                            <td class="text-left">Q0004 AP柔敏潔顏皂 + AP柔敏化粧水2瓶</td>
                                                            <td>安露莎精華液Ⅰ(0BP）</td>
                                                            <td>3,500元/81BP</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-8">
                                        <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <div class="container">
                                                    <form action="#" class="text-left">
                                                        <div class="row mb30">
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
                                                        <div class="row d-flex justify-content-between mb30">
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label" for="monthly_payment">每月付款金額：</label>
                                                                <input type="number" name="monthly_payment" id="monthly_payment" size="10">元
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label" for="bank_name">發卡銀行：</label>
                                                                <input type="text" name="bank_name" id="bank_name" size="10" maxlength="8">
                                                            </div>
                                                        </div>
                                                        <div class="row mb30">
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">信用卡卡號（共16碼）：</label>
                                                                <input type="text" name="card_number[]" id="card_number_1" size="4" maxlength="4"> - 
                                                                <input type="text" name="card_number[]" id="card_number_2" size="4" maxlength="4"> - 
                                                                <input type="text" name="card_number[]" id="card_number_3" size="4" maxlength="4"> - 
                                                                <input type="text" name="card_number[]" id="card_number_4" size="4" maxlength="4">
                                                            </div>
                                                        </div>
                                                        <div class="row mb30">
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label" for="card_expiry">有效期限：</label>
                                                                <input type="text" name="card_expiry_month" id="card_expiry_month" size="6" maxlength="4">月<input type="text" name="card_expiry_year" id="card_expiry_year" size="4" maxlength="2">年
                                                            </div>
                                                        </div>
                                                        <div class="row mb30">
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label" for="signaturePad">持卡人簽名： </label>
                                                                <div style="display: flex; flex-direction: column;">
                                                                    <canvas id="signaturePad" width="400" height="200"></canvas>
                                                                    <button id="clearBtn">清除簽名</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="use_member_auth" id="use_member_auth" value="1">
                                                                <label class="form-check-label" for="use_member_auth">使用訂購會員授權卡，僅須填寫發卡銀行與持卡人簽名 </label>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="card bg-light border-danger wow fadeInUp h-100" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <div class="">
                                                    <p class="text-center fs20">郵局帳戶授權人簽名 </p>
                                                    <div style="display: flex; flex-direction: column;">
                                                        <canvas id="signaturePadPost" width="400" height="200"></canvas>
                                                        <button id="clearBtnPost">清除簽名</button>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="auth_date">日期：</label>
                                                    <input type="text" name="auth_date_year" id="auth_date_year" size="4" maxlength="4">年<input type="text" name="auth_date_month" id="auth_date_month" size="3" maxlength="2">月<input type="text" name="auth_date_day" id="auth_date_day" size="3" maxlength="2">日
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb30">
                                    <div class="col-lg-12">
                                        <div class="form-check form-check-inline">
                                            付款方式：
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_credit_card" value="credit_card">
                                            <label class="form-check-label" for="payment_method_credit_card">信用卡付款 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_withdrawal" value="transfer">
                                            <label class="form-check-label" for="payment_method_withdrawal">劃撥 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_atm" value="atm">
                                            <label class="form-check-label" for="payment_method_atm">ATM轉帳 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_post_office" value="post">
                                            <label class="form-check-label" for="payment_method_post_office">郵局扣款 (須填寫<a href="#">自動轉帳付款授權書</a>) </label>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-0 mb-4">

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card bg-light border-info wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <p class="fs20">信用卡使用同意聲明書 ★持卡人非訂購會員本人，務必完整填寫信用卡使用同意申明書。</p>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="cardholder_name">持卡人本人：</label>
                                                        <input type="text" name="cardholder_name" id="cardholder_name"> ；
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="cardholder_id_card_number">身份證字號：</label>
                                                        <input type="text" name="cardholder_id_card_number" id="cardholder_id_card_number">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="auth_member_name">本人授權台灣安露莎公司就訂購會員</label>
                                                        <input type="text" name="auth_member_name" id="auth_member_name"> ；
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="auth_amount">購買產品合計每月</label>
                                                        <input type="text" name="auth_amount" id="auth_amount">元得使用本人留存之信用卡資訊，填寫信用卡授權書向銀行請款支付上開消費金額，毋須再與本人電話確認。
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="signaturePadAgreement">持卡人簽名：</label>
                                                        <div style="display: flex; flex-direction: column;">
                                                            <canvas id="signaturePadAgreement" width="400" height="200"></canvas>
                                                            <button id="clearBtnAgreement">清除簽名</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="auth_date">日期：</label>
                                                        <input type="date" name="auth_date" id="auth_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <p class="text-danger">郵政劃撥帳號：50049675 銀行轉帳帳號：合作金庫復旦分行(006) 1254-717-706612 受款人：台灣安露莎股份有限公司</p>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12 mb30">
                                        <div class="card bg-light wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
                                                <p class="">關於您的會員註冊以及其他特定資料，台灣安露莎股份有限公司(以下簡稱"本公司")均依照『個人資料保護法』進行保護與規範。在您了解並同意簽署本協議書時（會員是否生效仍須經本公司核准），您同意本公司依據『個人資料保護法』進行您包括但不限於姓名、身份證字號、出生年月日、電話、戶籍/居住地址等個人資料的蒐集與利用。參加人知悉並確認於加入會員後，本公司得依參加人之傳銷組織，將參加人包含地址、電話、會員編號等「個人資料」及後代會員有關銷售品名、項目、售價、訂購數、業績等「銷售資料」揭露於會員網站，供所屬支部及優秀地區本部傳銷組織人員登入查詢並供本公司佣金計算使用。</p>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="signaturePadCheck">※本人已明確知悉並同意上開個人資料之揭露及使用：(本人親筆簽名)</label>
                                                        <div style="display: flex; flex-direction: column;">
                                                            <canvas id="signaturePadCheck" width="400" height="200"></canvas>
                                                            <button id="clearBtnCheck">清除簽名</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-end">
                                        <div class="mb30">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="order_by_member">代下單會員姓名：</label>
                                                <input type="text" name="order_by_member" id="order_by_member">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-0 mb-4">

                                <div class="row mb-4">
                                    <div class="col-lg-12 mb30">
                                        <p class="text-danger">＊ 提醒您 ＊</p>
                                        <ol class="text-danger">
                                            <li>滿六期循環後，仍會持續為您進行宅配配送。您可隨時終止本活動專案，請務必於出貨日前來電客服告知。</li>
                                            <li>每一循環第6期無法展延，達連續二期未付款，視為終止宅配專案申請，須繳回第一期與活動相關之贈品。</li>
                                            <li>若已提出期約解約，於解約當月欲續簽，請於當月結帳日前向客服部提出申請，可享有持續保健獎勵。</li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12 mb30">
                                        <div class="card bg-light wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-title text-center">注意事項</div>
                                            <div class="card-body bg-white">
                                                <ol>
                                                    <li>填寫健康宅配專案申請表者，即成為安露莎合歡會員並可享會員獨享福利(詳閱會員手冊或電洽服務專線)</li>
                                                    <li>如於1至6期之間有中止、提前出貨、一次領取任一行為視為終止宅配專案申請，須繳回當期所有贈品。</li>
                                                    <li>於第6個月結束時，若更換宅配訂單訂購內容，並於第7個月連續出貨，可視為持續宅配訂單，持續保健獎勵內容以新簽定產品為準(包含更換訂購不同數量宅配訂單)</li>
                                                    <li>以信用卡、劃撥、ATM轉帳等方式者，於當日下午三點前完成付款即於當日出貨。郵局扣款者於付款完成隔日出貨(遇假日順延)</li>
                                                    <li>郵局扣款僅提供宅配專案使用。郵局自動轉帳付款授權書建檔需六個工作天，如欲於指定出貨日能順利出貨，首次申請者請於兩星期前將授權書正本寄至公司建檔，並以郵局核對完成此申請方能生效。</li>
                                                    <li>如欲使用官網組織專區，請填寫合歡會員協議書。</li>
                                                    <li>安露莎另有「化粧品、健康飲用水系列」，如欲購買請洽服務專線0809-080-608。</li>
                                                </ol>
                                            </div>
                                            <div class="card-title text-center">退換貨辦法</div>
                                            <div class="card-body bg-white">
                                                安露莎公司基於對顧客及會員的產品品質滿意保證，於產品售出後，若有任何不滿意，只要在品質滿意保證期(30天)內，符合下列退換貨規定者，本公司提供換貨或退貨的服務。
                                                <ol>
                                                    <li>產品更換規則：
                                                        <ol>
                                                            <li>一般退換貨
                                                                <ol>
                                                                    <li>申請時請檢附以下資料郵寄至本公司。
                                                                        <ol>
                                                                            <li>填妥產品退換申請表。
                                                                                <ol>
                                                                                    <li>請於換貨欄寫明換貨原因、產品貨號及數量。</li>
                                                                                    <li>註明退費或換貨及發票號碼後親筆簽名。</li>
                                                                                </ol>
                                                                            </li>
                                                                            <li>檢附產品。</li>
                                                                            <li>若欲將貨款退給非發票本人，則須另檢附「退款委託申請書」為依據。</li>
                                                                        </ol>
                                                                    </li>
                                                                    <li>備齊上列資料後，以掛號郵寄至以下地址： 「106台北市大安區信義路三段149號9樓 台灣安露莎股份有限公司客服部 收」</li>
                                                                    <li>請保留所有單據影本備查。</li>
                                                                </ol>
                                                            </li>
                                                            <li>不符合退換貨條件的內容說明
                                                                <ol>
                                                                    <li>產品已逾有效期限。</li>
                                                                    <li>自提領日算起，超過六個月以上之拆封產品(瑕疵品除外)</li>
                                                                    <li>促銷品、贈品、示範品及文件(瑕疵品除外)</li>
                                                                    <li>產品或包裝已拆封：
                                                                        <ol>
                                                                            <li>化粧品：產品使用量超過原容量之二分之一。</li>
                                                                            <li>保健食品：產品已拆封。</li>
                                                                            <li>保健飲用水系列產品：產品外箱已拆封。</li>
                                                                        </ol>
                                                                    </li>
                                                                    <li>錯誤使用或蓄意破壞。</li>
                                                                    <li>存放不當：曝曬或冷凍。<br>【注意】不符合換貨處理規定的產品，公司會將原產品退還，運費由會員負擔。</li>
                                                                </ol>
                                                            </li>
                                                            <li>收到非訂購產品時<br>請致電免付費客服專線0809-080-608，客服人員會立即為您 服務。</li>
                                                        </ol>
                                                    </li>
                                                    <li>會員解除契約及終止契約規範：
                                                        <ol>
                                                            <li>會員得自訂約日起算三十日內，以書面通知安露莎解除或終止契約。</li>
                                                            <li>安露莎應於契約解除或終止生效後三十日內，接受會員退貨之申請、受領會員送回之產品，並返還會員購買退貨產品所付價金及其他給付安露莎之款項。</li>
                                                            <li>安露莎依前述規定返還會員之款項，得扣除產品返還時因可歸責於會員之事由致產品毀損滅失之價值，及因該進貨對該會員給付之獎金或報酬。由安露莎取回退貨者，並得扣除取回該產品所需運費。</li>
                                                            <li>會員於解約權期間經過後，仍得隨時以書面終止契約，退出安露莎，並要求退貨。但其所持有產品自可提領之日起算已逾六個月者，不得要求退貨。</li>
                                                            <li>安露莎應於契約終止生效後三十日內，接受會員退貨之申請，並以會員原購價格百分之九十買回會員所持有之產品。</li>
                                                            <li>安露莎依前述規定買回會員所持有之產品時，得扣除因該項交易對該會員給付之獎金或報酬。其取回產品之價值有減損者，亦得扣除減損之金額。由安露莎取回退貨者，並得扣除取回該產品所需運費。</li>
                                                            <li>會員依上述規定行使解除權或終止權時，安露莎不得向會員請求因該契約解除或終止所受之損害賠償或違約金。產品係由第三人提供者，會員依上述規定行使解除權或終止權時，安露莎應依上述規定辦理退貨及買回，並負擔會員因該交易契約解除或終止所生之損害賠償或違約金。</li>
                                                            <li>終止契約通知書應由會員親自簽名、載明終止日期，且必須親交或郵寄（不可用傳真）至安露莎公司，該終止契約通知書送達於安露莎公司方生效力。</li>
                                                        </ol>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
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
                    <table class="table table-striped mb-2">
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

            // 簽名
            const signaturePad = new signature('signaturePad');
            const signaturePadPost = new signature('signaturePadPost');
            const signaturePadAgreement = new signature('signaturePadAgreement');
            const signaturePadCheck = new signature('signaturePadCheck');

            signaturePad.init();
            signaturePadAgreement.init();
            signaturePadCheck.init();
            signaturePadPost.init();

            $('#submit').on('click', async function() {
                // 顯示載入中提示
                Swal.fire({
                    title: '處理中...',
                    text: '正在提交您的申請',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 收集所有表單數據
                const formData = new FormData();
                formData.append('form_type', $('input[name="form_type"]:checked').val());
                formData.append('change_year', $('#change_year').val());
                formData.append('change_month', $('#change_month').val());
                formData.append('change_type', $('input[name="change_type"]:checked').val());
                formData.append('order_date_check', $('#order_date_check').is(':checked'));
                formData.append('order_year', $('#order_year').val());
                formData.append('order_month', $('#order_month').val());
                formData.append('order_day', $('#order_day').val());
                formData.append('c_no', $('#member_id').val());
                formData.append('order_member_name', $('#order_member_name').val());
                formData.append('member_id_card_number', $('#member_id_card_number').val());
                formData.append('birth_year', $('#birth_year').val());
                formData.append('birth_month', $('#birth_month').val());
                formData.append('birth_day', $('#birth_day').val());
                formData.append('shipping_address', $('#shipping_address').val());
                formData.append('recipient_name', $('#recipient_name').val());
                formData.append('contact_phone', $('#contact_phone').val());
                formData.append('referrer_id', $('#referrer_id').val());
                formData.append('referrer_name', $('#referrer_name').val());
                formData.append('products', $('input[name="product[]"]:checked').map(function() { return $(this).val(); }).get());
                formData.append('card_type', $('input[name="card_type"]:checked').val());
                formData.append('monthly_payment', $('#monthly_payment').val());
                formData.append('bank_name', $('#bank_name').val());
                formData.append('card_number', [
                    $('#card_number_1').val(),
                    $('#card_number_2').val(),
                    $('#card_number_3').val(),
                    $('#card_number_4').val()
                ]);
                formData.append('card_expiry_month', $('#card_expiry_month').val());
                formData.append('card_expiry_year', $('#card_expiry_year').val());
                formData.append('use_member_auth', $('#use_member_auth').is(':checked'));
                formData.append('auth_date_year', $('#auth_date_year').val());
                formData.append('auth_date_month', $('#auth_date_month').val());
                formData.append('auth_date_day', $('#auth_date_day').val());
                formData.append('payment_method', $('input[name="payment_method"]:checked').map(function() { return $(this).val(); }).get());
                formData.append('cardholder_name', $('#cardholder_name').val());
                formData.append('cardholder_id_card_number', $('#cardholder_id_card_number').val());
                formData.append('auth_member_name', $('#auth_member_name').val());
                formData.append('auth_amount', $('#auth_amount').val());
                formData.append('auth_date', $('#auth_date').val());
                formData.append('order_by_member', $('#order_by_member').val());

                // 處理簽名
                if (signaturePad.signatured) {
                    const blob = await signaturePad.getSignatureBlob();
                    formData.append('signature', blob, 'signature.png');
                }

                if (signaturePadPost.signatured) {
                    const blob = await signaturePadPost.getSignatureBlob();
                    formData.append('signaturePost', blob, 'signaturePost.png');
                }

                if (signaturePadAgreement.signatured) {
                    const blob = await signaturePadAgreement.getSignatureBlob();
                    formData.append('signatureAgreement', blob, 'signatureAgreement.png');
                }

                if (signaturePadCheck.signatured) {
                    const blob = await signaturePadCheck.getSignatureBlob();
                    formData.append('signatureCheck', blob, 'signatureCheck.png');
                }

                // 發送 AJAX 請求
                $.ajax({
                    url: '<?=$apiUrl;?>',
                    method: 'POST',
                    data: formData,
                    processData: false,  // 不處理數據
                    contentType: false,  // 不設置內容類型
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == '200') {
                            Swal.fire({
                                icon: 'success',
                                title: '提交成功', 
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                //window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '提交失敗',
                                text: response.message || '提交過程中發生錯誤，請稍後再試',
                                confirmButtonText: '確定'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: '系統錯誤',
                            text: '提交過程中發生錯誤，請稍後再試',
                            confirmButtonText: '確定'
                        });
                        console.error('Error:', error);
                    }
                });
            });

            // 清除簽名
            $('#clearBtn').click(function() {
                const canvas = document.getElementById("signaturePad"); // 確保獲取的是 DOM
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            $('#clearBtnPost').click(function() {
                const canvas = document.getElementById("signaturePadPost"); // 確保獲取的是 DOM
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            $('#clearBtnAgreement').click(function() {
                const canvas = document.getElementById("signaturePadAgreement"); // 確保獲取的是 DOM
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            $('#clearBtnCheck').click(function() {
                const canvas = document.getElementById("signaturePadCheck"); // 確保獲取的是 DOM
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
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