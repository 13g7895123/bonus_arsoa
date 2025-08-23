
  <body class="theme-orange fixed-footer fixed-footer-lg">
    <div class="animsition">
      <div class="wrapper">
      <?= $this->block_service->load_html_header(); ?>
		  
		  
        <div class="section-mini">

          <!--<div class="section-item text-left">
            <div class="article-promo">
              <div class="article-promo-item" style="background:url(img/love_bg.jpg); min-height: 20.375rem;">
              </div>
            </div>
			  
			  <div class="breadcrumb"><div class="container">
				  <a href="index.html" title="首頁">首頁</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="javascript:;" title="會員專區">會員專區</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="love.html" title="ARSOA Ai">ARSOA Ai</a></div>
				  </div>
			  
          </div>-->
			
			

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                  <h1 class="h2-3d font-libre"><strong>肌膚諮詢記錄表</strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">                    
                       <form name="oForm" id="oForm" method="post" action="https://www.arsoa.tw/sample/partners"> 
                         <div class="row">
                           <div class="form-group mx-sm-3 mb-2">
                             <label for="name" class="sr-only">查詢姓名或編號</label>
                             <input type="text" class="form-control" id="Search" name="Search" placeholder="查詢姓名或電話" value="" maxlength="10">
                           </div>
                           <input type="submit" class="btn btn-primary mb-2" style="height: 46px;" value="搜尋">
                           <span id="check_mobile_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
						   </div>
                        
                        <div class="row" id="form_personal" style="margin-top: 30px;">                           
                        </div>            
                        <div class="card mb-3">
                           <div class="card-body">
                            <table class="table table-striped mb-2 text-center">
                               <thead class="thead-dark">
                                <tr>
                                   <th width="25%">會員(來賓)資訊</th>
                                   <th width="22%">出貨日期</th>
                                   <th width="23%">最後填寫日期</th>
                                   <th width="15%">已填寫</th>
                                   <th width="15%">查看</th>
                                 </tr>
                              </thead>
                               <tbody>
                                <tr style="background-color: #E4FBFC;">
                                   <td nowrap="nowrap" class="text-center">庭毅 測試<br>
                                    0903508869</td>
                                   <td>2022-08-17</td>
                                   <td>2022-09-05 10:35</td>
                                   <td> 3 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('1');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:table-row" id="qdiv_1">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已填寫</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left" style="margin-top: -10px;">
                                           <li class="list-inline-item">
											   <span title="填寫時間：2022-08-19 18:00">2022-08-19 18:01</span>　　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>
											   </a>　｜　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-edit" style="font-size: 1.1rem;"></i>
											   </a>
											   </li>
                                           <br>
                                           <li class="list-inline-item">
											   <span title="填寫時間：2022-08-19 18:00">2022-08-19 18:01</span>　　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>
											   </a>　｜　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-edit" style="font-size: 1.1rem;"></i>
											   </a>
											   </li>
                                           <br>
										   <li class="list-inline-item">
											   <span title="填寫時間：2022-08-19 18:00">2022-08-19 18:01</span>　　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>
											   </a>　｜　
											   <a href="javascript:void();" onclick="javascript:;" data-toggle="modal" data-target="#exampleModal">
												   <i class="icon ion-edit" style="font-size: 1.1rem;"></i>
											   </a>
											   </li>
                                           <br>
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #eeeeee;">
                                   <td nowrap="nowrap" class="text-center">張國瑜<br>
                                    0935246839</td>
                                   <td>2022-08-04</td>
                                   <td>2022-08-23 18:21</td>
                                   <td>3 / 3 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('2');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_2">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left" style="margin-top: -10px;">
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-06 18:00">2022-08-17 00:00</span> &nbsp;
                                               14日養成美麗肌膚<br>
                                               第一次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('4a2082e0ecb0d06e3258cff10e82aea4','14日養成美麗肌膚&lt;br&gt;第一次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-19 18:00">2022-08-19 18:02</span> &nbsp;
                                               簡單保養肌膚越年輕！<br>
                                               第二次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('c5e9fed3ef71f408f5d77d32271b6559','簡單保養肌膚越年輕！&lt;br&gt;第二次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-23 18:00">2022-08-23 18:21</span> &nbsp;
                                               肌膚越來越水潤Q彈了<br>
                                               第三次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('d3306e513bb590e60dbd2bb80a1abe28','肌膚越來越水潤Q彈了&lt;br&gt;第三次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #E4FBFC;">
                                   <td nowrap="nowrap" class="text-center">謝銍淂<br>
                                    0970984312</td>
                                   <td>2022-08-02</td>
                                   <td>2022-08-19 18:01</td>
                                   <td>3 / 3 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('3');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_3">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left" style="margin-top: -10px;">
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-04 18:00">2022-08-05 10:02</span> &nbsp;
                                               14日養成美麗肌膚<br>
                                               第一次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('e3928bdb9c9252502342efb9f58b99d4','14日養成美麗肌膚&lt;br&gt;第一次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-07 18:00">2022-08-15 00:00</span> &nbsp;
                                               簡單保養肌膚越年輕！<br>
                                               第二次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('7edb6b51bd7afce0e3927ce9a578d33a','簡單保養肌膚越年輕！&lt;br&gt;第二次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-19 18:00">2022-08-19 18:01</span> &nbsp;
                                               肌膚越來越水潤Q彈了<br>
                                               第三次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('ab323df5a96d6091c5982e57e61cb3ed','肌膚越來越水潤Q彈了&lt;br&gt;第三次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #eeeeee;">
                                   <td nowrap="nowrap" class="text-center">韓荷仙<br>
                                    0912571849</td>
                                   <td>2022-08-02</td>
                                   <td>2022-08-10 18:17</td>
                                   <td>3 / 3 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('4');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_4">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left" style="margin-top: -10px;">
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-04 18:00">2022-08-04 19:10</span> &nbsp;
                                               14日養成美麗肌膚<br>
                                               第一次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('b8990a17a6ec212d5844f2acc1782833','14日養成美麗肌膚&lt;br&gt;第一次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-06 18:00">2022-08-06 18:01</span> &nbsp;
                                               簡單保養肌膚越年輕！<br>
                                               第二次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('8c2debbfb5c6edd0c62f4675c1db20e7','簡單保養肌膚越年輕！&lt;br&gt;第二次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                           <li class="list-inline-item"> <span title="填寫時間：2022-08-10 18:00">2022-08-10 18:17</span> &nbsp;
                                               肌膚越來越水潤Q彈了<br>
                                               第三次&nbsp;&nbsp; <a href="javascript:void();" onclick="question_reply_show('4d010e77eeb21689fe1961b37e8ccc9e','肌膚越來越水潤Q彈了&lt;br&gt;第三次');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a> </li>
                                           <br>
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #E4FBFC;">
                                   <td nowrap="nowrap" class="text-center">Ginny<br>
                                    0958931567</td>
                                   <td>2022-08-02</td>
                                   <td>尚未填寫</td>
                                   <td>1 / 0 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('5');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_5">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：2022-08-04 18:00
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #eeeeee;">
                                   <td nowrap="nowrap" class="text-center">劉德華<br>
                                    0911111111</td>
                                   <td>2022-08-02</td>
                                   <td>尚未填寫</td>
                                   <td>1 / 0 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('6');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_6">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：2022-08-04 18:00
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #E4FBFC;">
                                   <td nowrap="nowrap" class="text-center">劉靜儀<br>
                                    0975183305</td>
                                   <td>2022-08-02</td>
                                   <td>尚未填寫</td>
                                   <td>1 / 0 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('7');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_7">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：2022-08-04 18:00
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #eeeeee;">
                                   <td nowrap="nowrap" class="text-center">TEST<br>
                                    0921456789</td>
                                   <td>2022-08-04</td>
                                   <td>尚未填寫</td>
                                   <td>0 / 0 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('8');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_8">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：2022-08-12 09:46
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #E4FBFC;">
                                   <td nowrap="nowrap" class="text-center">測試<br>
                                    0123456789</td>
                                   <td>2022-08-19</td>
                                   <td>尚未填寫</td>
                                   <td>0 / 0 </td>
                                   <td><a href="javascript:void();" onclick="question_reply_div('9');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_9">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：2022-09-07 18:00
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                                <tr style="background-color: #eeeeee;">
                                   <td nowrap="nowrap" class="text-center">測試<br>
                                    0123456789</td>
                                   <td>2022-09-27</td>
                                   <td>尚未寄送</td>
                                   <td>0 / 0 </td>
                                   <td></td>
                                 </tr>
                                <tr style="display:none" id="qdiv_10">
                                   <td colspan="5"><div class="card-body">
                                       <div class="row mb-3">
                                       <div class="col-md-auto border-right">已寄送</div>
                                       <div class="col-md-10">
                                           <ul class="list-inline text-left">
                                           填寫時間：1970-01-01 08:00
                                         </ul>
                                         </div>
                                     </div>
                                     </div></td>
                                 </tr>
                              </tbody>
                             </table>
                          </div>
                         </div>
			          	   </form>  
						<div class="col-sm-12 mb30">
							  <hr class="my-4">
							  <a href="eform01.php" class="btn btn-outline-danger btn-block">填寫肌膚諮詢記錄表</a>
							</div>
			          	
<form name="PageForm" method="post" action="https://www.arsoa.tw/sample/partners">
  <input type="hidden" name="Search" value=""><input name="Submit" type="submit" value="Submit" style="display:none;"><input type="hidden" name="Page">
<nav aria-label="Page navigation example"><ul class="pagination justify-content-center"><li class="page-item disabled"><a href="javascript:void(0);" class="page-link"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li><li class="page-item active"><a href="javascript:void(0);" class="page-link">1</a></li><li class="page-item disabled"><a href="javascript:void(0);" class="page-link"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li></ul></nav>  
</form>

                    </div>
                  </div>

                </div>

                <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                  <!-- 側邊欄清單 -->
                  <?= $this->block_service->electronic_form_right_menu(); ?>
                </aside>
				  
				  
				  
              </div>
            </div>
          </div>
        </div>
      </div>
		
		

      <?= $this->block_service->load_html_footer(); ?>

    </div>

	
	<a id="back2Top" title="Back to top" href="#"><i class="ico ion-arrow-right-b"></i></a>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
    <!--<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>-->
    <!--<script src="js/smoothscroll.js"></script>-->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.pagepiling.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <!--<script src="js/jquery.fancybox.min.js"></script>-->
    <script src="js/TweenMax.min.js"></script>
    <script src="js/ScrollMagic.min.js"></script>
    <script src="js/animation.gsap.min.js"></script>
    <!--<script src="js/jquery.viewport.js"></script>
    <script src="js/jquery.countdown.min.js"></script>-->
    <script src="js/script.js"></script>
	



    <script>
      $(document).ready(function() {
        // init controller
        var controller = new ScrollMagic.Controller();

        // build scenes
        new ScrollMagic.Scene({triggerElement: '.section-mini', triggerHook: 1, duration: '200%'})
              .setTween('.article-promo-item', {backgroundPosition: '50% 100%', ease: Linear.easeNone})
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
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

});
 /*Scroll to top when arrow up clicked END*/
	  </script>
	  
	  <!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModal" aria-hidden="true" id="exampleModal">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">庭毅 測試 的肌膚諮詢記錄表</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb30">
                    <div class="container">
                      <form action="#" class="text-left">
                        <div class="row">
							<div class="col-sm-12 text-right mb30">填寫日期：2025-08-11</div>
							
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員姓名</label>
                            <input type="text" class="form-control form-control-custom" placeholder="請填會員姓名" />
                          </div>
                          <div class="col-sm-3 mb30">
                            <label class="label-custom">出生西元年</label>
                            <select class="form-control form-control-custom" id="SeleteBYear">
                              <option>請選擇</option>
                              <option>2005</option>
                              <option>2004</option>
                              <option>2003</option>
                              <option>2002</option>
                            </select>
                          </div>
                          <div class="col-sm-2 mb30">
                            <label class="label-custom">出生西元月</label>
                            <select class="form-control form-control-custom" id="SeleteBYear">
                              <option>請選擇</option>
                              <option>1月</option>
                              <option>2月</option>
                              <option>3月</option>
                              <option>4月</option>
                            </select>
                          </div>
						  <div class="col-sm-3 mb30">
                            <label class="label-custom">電話</label>
                            <input type="text" class="form-control form-control-custom" placeholder="請填09xxxxxxxx" />
                          </div>
							
                          <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">職業：
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">服務業 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">上班族 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">餐飲業 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">家管 </label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">戶外日曬時間：
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">1~2小時 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">3~4小時 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">5~6小時 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">8小時以上 </label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">待在空調環境：
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">1小時內 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">2~4小時 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">5~8小時 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">8小時以上 </label>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">睡眠狀況：
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">9:00~10:59點pm就寢 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">11:00~12:59點pm就寢 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">凌晨1點之後就寢 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="form-check form-check-inline">現在使用產品：
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">蜜皂 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">洗面乳 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">化妝水 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">精華液 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">乳液 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">防曬 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb50">
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
								  <div class="row">
									  <p class="mb-0">肌膚困擾：</p>
									</div>
                                  <div class="row mb30">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">沒有彈性 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">沒有光澤 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">暗沉 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">斑點 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">毛孔粗大 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">痘痘粉刺 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">皺紋細紋 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">粗糙 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">癢、紅腫 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">乾燥 </label>
                            </div>
							<div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">上妝不服貼 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">其他： </label>
							  <input type="text">
                            </div>
                                  </div>
								  <div class="row">
									  <p class="mb-0">肌膚是否容易過敏：</p>
									</div>
                                  <div class="row">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">經常 </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">偶爾(換季時) </label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                              <label class="form-check-label" for="inlineRadio4">不會 </label>
                            </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
							
						<div class="col-sm-12"><hr class="my-4"></div>
							
						  <div class="col-sm-12 mb30">
							<h4>建議內容：</h4>
                            <div class="alert alert-warning" role="alert">
							<div class="row">
                              <div class="col-sm-6 mb30">
                                <label class="label-custom">化妝水：</label>
                                <input type="text" class="form-control form-control-custom" placeholder="" />
                              </div>
                              <div class="col-sm-6 mb30">
                                <label class="label-custom">精華液：</label>
                                <input type="text" class="form-control form-control-custom" placeholder="" />
                              </div>
							  <div class="col-sm-12 mb30">
                                <label class="label-custom">建議內容</label>
                                <input type="text" class="form-control form-control-custom" placeholder="請填寫建議內容…" />
                              </div>
							</div>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
                            <div class="card bg-light ">
                              <div class="card-body">
                                <div class="container">
                                  <div class="row">
									<div class="col-sm-7 mb30">
                                      <div class="form-check form-check-inline">肌膚型：
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                        <label class="form-check-label" for="inlineRadio4">乾性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                        <label class="form-check-label" for="inlineRadio4">中性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                        <label class="form-check-label" for="inlineRadio4">混合性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                        <label class="form-check-label" for="inlineRadio4">敏感性 </label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                        <label class="form-check-label" for="inlineRadio4">油性 </label>
                                      </div>
                                    </div>
									<div class="col-sm-5 mb30">
                                      <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineRadio4">肌膚年齡： </label>
                                        <input type="text">
                                      </div>
                                    </div>
									  
                                    <div class="col-sm-12 mb20">
                                      <label class="label-custom">水潤</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
                                    <div class="col-sm-12 mb20">
                                      <label class="label-custom">膚色</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">紋理</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">敏感</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">油脂</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">色素</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">皺紋</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>
									  
									<div class="col-sm-12 mb20">
                                      <label class="label-custom">毛孔</label>
                                      <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
									  <div class="row">
                                        <div class="col-sm-4 mb20">
										<div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">

                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                        <div class="col-sm-4 mb20">
                                          <div class="row">
											<div class="col-lg-6"><select class="form-control form-control-custom" id="SeleteBYear">
                                            <option>請選擇</option>
                                            <option>嚴重、盡快改善</option>
                                            <option>有問題、要注意</option>
                                            <option>健康</option>
                                          </select></div>
											<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"></div>
											</div>
                                        </div>
                                      </div>
                                    </div>  
									  
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
							
						  <div class="col-sm-12 mb30">
							  <hr class="my-4">
							  <a href="#" class="btn btn-outline-danger btn-block">送出表單</a>
							</div>
							
                        </div>
						</form>
                    </div>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>

  </body>
</html>
