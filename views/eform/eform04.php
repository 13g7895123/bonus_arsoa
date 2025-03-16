<style>
    .flatpickr-input[readonly]  {
        border: none;
        border-bottom: #cccccc 1px solid;
    }
    .underline-text {
        text-decoration: underline;
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
                                <h1 class="h2-3d font-libre"><strong>《合歡會員協議書》</strong></h1>
                                <div class="container wow fadeInUp" data-wow-delay=".2s">
                                    <form id="eform_main_1">
                                        <div class="row">
                                            <div class="col-sm-12 mb30">
                                                <p class="fs20">在填寫本協議書並簽署姓名之前，請詳閱本協議書正背兩面所有條文與說明。</p>
                                            </div>
                                            <div class="col-sm-12 mb30">
                                                <div class="form-check form-check-inline"> 欲加入會員之型態請勾選　
                                                    <input class="form-check-input" type="radio" name="member_type" id="personal" value="personal">
                                                    <label class="form-check-label" for="personal">個人 </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="member_type" id="company" value="company">
                                                    <label class="form-check-label" for="company">公司</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="member_type" id="partner_organization" value="partner_organization">
                                                    <label class="form-check-label" for="partner_organization">合夥組織</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">姓名：</label>
                                                <input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">身分證號碼： </label>
                                                <input type="text" name="member_id_card_number" maxlength="10" class="form-control form-control-custom" placeholder="請填身分證字號">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">生日：</label>
                                                <input type="text" class="datapicker" name="member_birth_date" class="form-control form-control-custom" placeholder="選擇日期">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">配偶姓名：</label>
                                                <input type="text" name="spouse_name" class="form-control form-control-custom" placeholder="請填姓名">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">身分證號碼： </label>
                                                <input type="text" name="spouse_id_card_number" maxlength="10" class="form-control form-control-custom" placeholder="請填身分證字號">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">生日：</label>
                                                <input type="text" class="datapicker" name="spouse_birth_date" class="form-control form-control-custom" placeholder="選擇日期">
                                            </div>
                                            <div class="col-sm-6 mb30">
                                                <label class="label-custom">通訊地址：郵遞區號 </label>
                                                <input type="text" name="postal_code" maxlength="6" class="form-control form-control-custom" placeholder="請填郵遞區號">
                                            </div>
                                            <div class="col-sm-8 mb30">
                                                <label class="label-custom">通訊地址： </label>
                                                <input type="text" name="address" maxlength="6" class="form-control form-control-custom" placeholder="請填地址">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">手機： </label>
                                                <input type="text" name="cellphone_number" maxlength="10" class="form-control form-control-custom" placeholder="請填手機">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">電話：公司 </label>
                                                <input type="text" name="company_phone_number" maxlength="10" class="form-control form-control-custom" placeholder="請填公司電話">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">電話：住家 </label>
                                                <input type="text" name="home_phone_number" maxlength="10" class="form-control form-control-custom" placeholder="請填住家電話">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">傳真 </label>
                                                <input type="text" name="fax" maxlength="10" class="form-control form-control-custom" placeholder="請填傳真">
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="is_recieve_message" id="is_recieve_message" value="1">
                                                    <label class="form-check-label" for="is_recieve_message">我要收相關簡訊 </label>
                                                </div>
                                                <div class="form-check form-check-inline"> ※為保障會員權益，安露莎所有訊息僅提供予會員本人。 </div>
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">推薦人姓名： </label>
                                                <input type="text" name="recommend_name" maxlength="10" class="form-control form-control-custom" placeholder="請填推薦人">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">連絡電話 </label>
                                                <input type="text" name="recommend_phone_number" maxlength="10" class="form-control form-control-custom" placeholder="請填電話">
                                            </div>
                                            <div class="col-sm-4 mb30">
                                                <label class="label-custom">會員編號 </label>
                                                <input type="text" name="recommend_no" maxlength="10" class="form-control form-control-custom" placeholder="請填編號">
                                            </div>
                                            <div class="col-sm-12">
                                                <p>
                                                    本協議書為會員與台灣安露莎公司訂定之合約，本協議書正背兩面、營業守則、傭金制度及其他附屬文件均為本合約之一部分。
                                                    經本人親自簽屬後，即表示本人已詳閱所有條款，明白且同意接受該等條款。申請人為營利事業者請檢附營利事業登記證；
                                                    為外籍人士請檢附工作證或居留證影本；申請人為18歲以上未滿20歲需檢附法定代理人同意書。<b>本協議書第一連正本請寄回公司，才算正式完成入會手續</b>
                                                </p>
                                                <p>
                                                    關於您的會員註冊與其他特定資料，安露莎公司均依照『個人資料保護法』進行保護與規範。
                                                    <b class="underline-text">在您了解並同意簽屬本協議書時(會員是否生效仍須經安露莎公司核准)</b>，您同意安露莎公司依據『個人資料保護法』
                                                    進行您包括但不限於姓名、身分證字號、出生年月日、電話、戶籍/居住地等個人資料的蒐集與利用。
                                                    參加人知悉並確認於加入會員後，安露莎公司得依參加人之傳銷組織，將參加人包含地址、電話、會員編號等『個人資料』及後代會員有關銷售品名、項目、售價、訂購數、業績等『銷售資料』揭露於會員網站，供所屬
                                                    傳銷組織人員登入查詢並供安露莎公司佣金計算使用。台端可隨時為查詢、閱覽、補充或更正。
                                                    但若您不同意，亦可告知請求本公司停止處理、利用，唯恐將無法提供最完善服務。
                                                </p>
                                            </div>
                                            <div class="col-sm-6 mb30">
                                                <label class="label-custom">申請人正楷親筆簽署： </label>
                                                <input type="text" maxlength="10" class="form-control form-control-custom" placeholder="請填正楷親筆簽署">
                                            </div>
                                            <div class="col-sm-6 mb30">
                                                <label class="label-custom">日期：</label>
                                                <input type="text" class="datapicker" class="form-control form-control-custom" placeholder="選擇日期">
                                            </div>
                                            <div class="col-sm-12 mb30">
                                                <div>※申請名簽名同時代表已詳閱所有條文，並承諾各欄填寫資料所提供相關證明文件均屬實無誤，如有虛假願承擔法律責任。</div>
                                            </div>
                                        

                                            <hr class="mb30">
                                            <div class="col-sm-12">
                                                <p>※請選取入會方式:</p>
                                                <div class="mb30 d-flex flex-row align-items-center">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="join_type" id="MembershipFee" value="membership_fee">
                                                        <label class="form-check-label" for="MembershipFee">入會費750元</label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="join_type" id="amountThreshold" value="amount_threshold">
                                                        <label class="form-check-label" for="amountThreshold">購滿建議售價3500元</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p>※付款方式：</p>
                                                <div class="col-sm-12 mb30 d-flex flex-row align-items-center">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash">
                                                        <label class="form-check-label" for="cash">現場付款</label>
                                                    </div>
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
                                                </div>
                                                <div class="col-sm-12 mb30 d-flex flex-row align-items-center">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="wireTransfer" value="wire_transfer">
                                                        <label class="form-check-label" for="wireTransfer">電匯（合作金庫復旦分行帳號1254-717-706612）</label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input" type="radio" name="payment_method" id="postalTransfer" value="postal_transfer">
                                                        <label class="form-check-label" for="postalTransfer">劃撥（帳號：50049675）戶名：台灣安露莎股份有限公司</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="mb30">
                                            <div class="col-sm-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sameAsAbove">
                                                    <label class="form-check-label" for="sameAsAbove">同上列通訊地址</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb30">
                                                <label class="label-custom">收件人地址： </label>
                                                <input type="text" name="consignee_address"class="form-control form-control-custom" placeholder="請填地址">
                                            </div>
                                            <div class="col-sm-6 mb30">
                                                <label class="label-custom">收件人姓名： </label>
                                                <input type="text" name="consignee_name"class="form-control form-control-custom" placeholder="請填收件人姓名">
                                            </div>
                                            <div class="col-sm-6 mb30">
                                                <label class="label-custom">收件人電話： </label>
                                                <input type="text" name="consignee_phone_number"class="form-control form-control-custom" placeholder="請填電話">
                                            </div>
                                        </div>
                                    </form>
                                    <form id="eform_detail">
                                        <?=$subView;?>
                                    </form>
                                    <form id="eform_main_2">
                                        <div class="wow fadeInUp" data-wow-delay=".2s">
                                            <div class="col-12 text-right">
                                                <p class="fs20">總計：
                                                    <input type="text" readonly name="totol_amount" id="totalAmount"></p>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                    <ul>
                                        <li>※購滿建議售價2000元，免付運費100元。</li>
                                        <li>※如品項不敷填寫，請另填產品訂購單。</li>
                                        <li>劃撥及轉帳請檢附收據或電話以利確認。</li>
                                    </ul>
                                </div>
                                

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card bg-light border-danger wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body">
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
                                                        <label class="form-check-label" for="inlineRadio4">背面末3碼： </label>
                                                        <input type="text" size="5" maxlength="3">
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">有效期限： </label>
                                                        <input type="text" size="6" maxlength="4">
                                                        月
                                                        <input type="text" size="4" maxlength="2">
                                                        年
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">簽名： </label>
                                                        <input type="text" size="10" maxlength="8">
                                                        (與信用卡一致)
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                        <label class="form-check-label" for="inlineRadio4">同上列通訊地址 </label>
                                                    </div>
                                                </div>
                                                <div class="mb30">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">收件人地址： </label>
                                                        <input type="text" size="50" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">收件人姓名： </label>
                                                        <input type="text" size="10" maxlength="10">
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="inlineRadio4">電話： </label>
                                                        <input type="text" size="12" maxlength="10">
                                                    </div>
                                                </div>
                                            </div>
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
                                </div>

                                <hr class="mt-0 mb-4">

                                <div class="row mb-4">
                                    <div class="col-lg-12 mb30">
                                        <div class="card bg-light wow fadeInUp" data-wow-delay=".2s">
                                            <div class="card-body bg-white"> 本協議書載議的有關的共同承諾…
                                                <ol>
                                                    <li>填寫健康宅配專案申請表者，即成為安露莎合歡會員並可享會員獨享福利(詳閱會員手冊或電洽服務專線)</li>
                                                    <li>如於1至6期之間有中止、提前出貨、一次領取任一行為視為終止宅配專案申請，須繳回當期所有贈品。</li>
                                                    <li>於第6個月結束時，若更換宅配訂單訂購內容，並於第7個月連續出貨，可視為持續宅配訂單，持續保健獎勵內容以新簽定產品為準(包含更換訂購不同數量宅配訂單)</li>
                                                    <li>以信用卡、劃撥、ATM轉帳等方式者，於當日下午三點前完成付款即於當日出貨。郵局扣款者於付款完成隔日出貨(遇假日順延)</li>
                                                    <li>郵局扣款僅提供宅配專案使用。郵局自動轉帳付款授權書建檔需六個工作天，如欲於指定出貨日能順利出貨，首次申請者請於兩星期前將授權書正本寄至公司建檔，並以郵局核對完成此申請方能生效。</li>
                                                    <li>如欲使用官網組織專區，請填寫合歡會員協議書。</li>
                                                    <li>安露莎另有「化粧品、健康飲用水系列」，如欲購買請洽服務專線0809-080-608。</li>
                                                </ol>
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
                                                                    <li>存放不當：曝曬或冷凍。<br>
                                                                        【注意】不符合換貨處理規定的產品，公司會將原產品退還，運費由會員負擔。</li>
                                                                </ol>
                                                            </li>
                                                            <li>收到非訂購產品時<br>
                                                                請致電免付費客服專線0809-080-608，客服人員會立即為您 服務。</li>
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

            const eform4 = (function() {
                const $eform_main_1 = $('#eform_main_1');
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

                $eform_main_1.find(".datapicker").flatpickr({
                    locale: "zh", // 設定語系為中文
                    dateFormat: "Y-m-d", // 日期格式 YYYY-MM-DD
                    disableMobile: true // 在行動裝置上顯示桌面版
                });

                $eform_main_1.find('input[name="payment_method"]').change(function () {
                    if ($('#creditCard').is(':checked')) {
                        $('input[name="card_type"]').prop('disabled', false);
                    } else {
                        $('input[name="card_type"]').prop('disabled', true).prop('checked', false);
                    }
                });

                $eform_main_1.find('#sameAsAbove').change(function () {
                    if ($('#sameAsAbove').is(':checked')) {
                        let address = $eform_main_1.find("input[name='address']").val();
                        let name = $eform_main_1.find("input[name='member_name']").val();
                        let phone_number = $eform_main_1.find("input[name='cellphone_number']").val();
                        $("input[name='consignee_address']").val(address);
                        $("input[name='consignee_name']").val(name);
                        $("input[name='consignee_phone_number']").val(phone_number);
                    }
                });

                $('#submit_btn').click(function() {
                    submitFormData();
                });

                function checkForm() {
                    let selectedMemberType = $("input[name='member_type']:checked").val();
                    let selectedPayment = $("input[name='payment_method']:checked").val();
                    let selectedjoinType = $("input[name='join_type']:checked").val();
        
                    if (!selectedMemberType) {
                        return false;
                    }
                    if (!selectedjoinType) {
                        return false;
                    }
                    if (!selectedPayment) {
                        return false;
                    }
                    if (selectedPayment === "credit_card") {
                        let selectedCardType = $("input[name='member_type']:checked").val();
                        if (!selectedCardType) {
                            return false;
                        }
                    }
                    return true;
                }

                function submitFormData() {
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
                    let mainData = {};
                    let detailData = {};

                    mainData = getFormData($('#eform_main_1'), mainData);
                    mainData = getFormData($('#eform_main_2'), mainData);

                    detailData = getFormData($('#eform_detail'), detailData);

                    let formData = {
                        mainData,
                        detailData
                    };
                    $.ajax({
                        url: '<?=$apiUrl;?>',
                        type: 'POST',
                        data: formData,
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