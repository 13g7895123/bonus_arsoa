
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
                       <form name="oForm" id="oForm"> 
                         <div class="row">
                           <div class="form-group mx-sm-3 mb-2">
                             <label for="search" class="sr-only">查詢姓名或電話</label>
                             <input type="text" class="form-control" id="search" name="search" placeholder="查詢姓名或電話" value="" maxlength="20">
                           </div>
                           <button type="button" class="btn btn-primary mb-2" style="height: 46px;" onclick="performSearch()">搜尋</button>
                           <button type="button" class="btn btn-secondary mb-2 ml-2" style="height: 46px;" onclick="clearSearch()">清除</button>
                           <span id="search_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
						   </div>
                        
                        <div class="row" id="form_personal" style="margin-top: 30px;">
                          <!-- 會員基本資料顯示區域 -->
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員姓名</label>
                            <p id="member-name"><?php echo isset($userdata['c_name']) ? htmlspecialchars($userdata['c_name']) : '未設定'; ?></p>
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">會員編號</label>
                            <p id="member-id"><?php echo isset($userdata['c_no']) ? htmlspecialchars($userdata['c_no']) : '未設定'; ?></p>
                          </div>
                          <div class="col-sm-4 mb30">
                            <label class="label-custom">電話</label>
                            <p id="member-phone"><?php echo isset($userdata['phone']) ? htmlspecialchars($userdata['phone']) : '未設定'; ?></p>
                          </div>
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
                               <tbody id="submissions-table-body">
                                <tr>
                                  <td colspan="5" class="text-center text-muted p-4">
                                    <div><i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i></div>
                                    <div class="mt-2">載入中，請稍候...</div>
                                  </td>
                                </tr>
                              </tbody>
                             </table>
                          </div>
                         </div>
			          	   </form>  
						<div class="col-sm-12 mb30">
							  <hr class="my-4">
							  <a href="<?php echo base_url('eform/eform1'); ?>" class="btn btn-outline-danger btn-block">填寫肌膚諮詢記錄表</a>
							</div>
			          	

                    </div>
                  </div>

                </div>

                <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				  <div class="mb75">
<h4><strong>電子表單</strong></h4>
<a href="eform01_list.php" class="btn btn-outline-secondary btn-block active">肌膚諮詢記錄表</a>
<div class="card d-none">
  <div class="card-body">
    <a href="eform01_list.php" class="btn btn-outline-secondary btn-block text-left">填寫紀錄</a>
    <a href="eform01.php" class="btn btn-outline-secondary btn-block text-left">我要填寫</a>
  </div>
</div>
<a href="eform02.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(肌膚)</a>
<a href="eform03_list.php" class="btn btn-outline-secondary btn-block">微微卡日記</a>
<a href="eform04.php" class="btn btn-outline-secondary btn-block">會員服務追蹤表(保健)</a>
<a href="eform05.php" class="btn btn-outline-secondary btn-block">健康諮詢表</a>
</div>

                  <!--<div class="mb65">
                    <h4>產品分類</h4>

                    <div class="article-list-mini">
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p01.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">肌膚保養系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p02.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">彩妝系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p04.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                      <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p05.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">美髮、美體系列</a></h5>
                        </div>
                      </div>
					  <div class="media article-item-mini">
                        <div class="mr-3"><a href="#" class="article-item-photo" style="height: 5.25rem;">
							<img src="img/p03.png" alt="" /></a></div>
                        <div class="media-body align-self-center">
                          <h5 class=""><a href="#" class="text-dark">保健食品系列</a></h5>
                        </div>
                      </div>
                    </div>
                  </div>-->

                  
				  
				  
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

    <script>
    // 全域變數
    var currentMemberId = '<?php echo isset($userdata['c_no']) ? $userdata['c_no'] : ''; ?>'; // 從控制器取得會員ID
    var currentSubmissionId = null; // 當前選中的提交記錄ID
    var allSubmissions = []; // 儲存所有提交記錄
    var filteredSubmissions = []; // 儲存過濾後的記錄
    
    // 頁面載入時初始化
    $(document).ready(function() {
      if (currentMemberId) {
        loadSubmissions();
      } else {
        $('#submissions-table-body').html(
          '<tr><td colspan="6" class="text-center text-warning p-4">' +
          '<div><i class="icon ion-person" style="font-size: 2rem;"></i></div>' +
          '<div class="mt-2">請先登入會員帳號</div>' +
          '<div class="small mt-1">登入後即可查看您的肌膚諮詢記錄</div>' +
          '</td></tr>'
        );
      }
      
      // 加入Enter鍵搜尋功能
      $('#search').on('keypress', function(e) {
        if (e.which == 13) {
          performSearch();
          return false;
        }
      });
    });
    
    // 載入提交記錄列表
    function loadSubmissions() {
      // 顯示載入狀態
      $('#submissions-table-body').html(
        '<tr><td colspan="6" class="text-center text-muted p-4">' +
        '<div><i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i></div>' +
        '<div class="mt-2">載入中，請稍候...</div>' +
        '</td></tr>'
      );
      
      $.ajax({
        url: '<?php echo base_url("api/eeform1/submissions/"); ?>' + currentMemberId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            var submissions = response.data && response.data.data ? response.data.data : response.data;
            if (Array.isArray(submissions)) {
              allSubmissions = submissions;
              filteredSubmissions = submissions;
              renderSubmissionsTable(submissions);
            } else {
              console.warn('Submissions data is not an array:', submissions);
              allSubmissions = [];
              filteredSubmissions = [];
              renderSubmissionsTable([]);
            }
          } else {
            var errorMsg = response && response.message ? response.message : '未知錯誤';
            $('#submissions-table-body').html(
              '<tr><td colspan="6" class="text-center text-warning p-4">' +
              '<div><i class="icon ion-alert-circled" style="font-size: 2rem;"></i></div>' +
              '<div class="mt-2">載入失敗: ' + errorMsg + '</div>' +
              '<div class="mt-2"><button class="btn btn-sm btn-outline-primary retry-btn" onclick="loadSubmissions()">重試</button></div>' +
              '</td></tr>'
            );
          }
        },
        error: function(xhr, status, error) {
          console.error('載入提交記錄失敗:', {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText,
            error: error
          });
          
          var errorMessage = '';
          var errorIcon = 'ion-alert-circled';
          
          if (xhr.status === 0) {
            errorMessage = '無法連接到服務器，請檢查網路連線';
            errorIcon = 'ion-wifi';
          } else if (xhr.status === 401) {
            errorMessage = '登入已過期，請重新登入';
            errorIcon = 'ion-person';
          } else if (xhr.status === 403) {
            errorMessage = '沒有權限訪問此資源';
            errorIcon = 'ion-locked';
          } else if (xhr.status === 404) {
            errorMessage = 'API服務不存在或路徑錯誤';
            errorIcon = 'ion-help-circled';
          } else if (xhr.status === 500) {
            errorMessage = '服務器內部錯誤，請稍後再試';
            errorIcon = 'ion-bug';
          } else if (xhr.responseText) {
            try {
              var errorResponse = JSON.parse(xhr.responseText);
              if (errorResponse.message) {
                errorMessage = errorResponse.message;
              } else {
                errorMessage = '載入失敗 (錯誤代碼: ' + xhr.status + ')';
              }
            } catch (e) {
              errorMessage = '載入失敗，響應格式錯誤 (錯誤代碼: ' + xhr.status + ')';
            }
          } else {
            errorMessage = '載入失敗，請稍後再試 (錯誤代碼: ' + xhr.status + ')';
          }
          
          $('#submissions-table-body').html(
            '<tr><td colspan="5" class="text-center text-danger p-4">' +
            '<div><i class="icon ' + errorIcon + '" style="font-size: 2rem;"></i></div>' +
            '<div class="mt-2">' + errorMessage + '</div>' +
            '<div class="mt-2"><button class="btn btn-sm btn-outline-primary retry-btn" onclick="loadSubmissions()">重試</button></div>' +
            '</td></tr>'
          );
        }
      });
    }
    
    // 渲染提交記錄表格
    function renderSubmissionsTable(submissions) {
      if (!submissions) {
        $('#submissions-table-body').html('<tr><td colspan="5" class="text-center text-warning p-4"><i class="icon ion-information-circled mr-2"></i>資料格式錯誤</td></tr>');
        return;
      }
      
      if (submissions.length === 0) {
        var emptyMessage = '';
        if ($('#search').val().trim()) {
          // 搜尋結果為空
          emptyMessage = 
            '<tr><td colspan="5" class="text-center text-muted p-4">' +
            '<div><i class="icon ion-search" style="font-size: 2rem; opacity: 0.5;"></i></div>' +
            '<div class="mt-2">找不到符合 "' + $('#search').val().trim() + '" 的記錄</div>' +
            '<div class="small mt-1">請嘗試使用不同的關鍵字搜尋</div>' +
            '</td></tr>';
        } else {
          // 沒有任何記錄
          emptyMessage = 
            '<tr><td colspan="5" class="text-center text-muted p-4">' +
            '<div><i class="icon ion-document-text" style="font-size: 2rem; opacity: 0.5;"></i></div>' +
            '<div class="mt-2">目前尚無肌膚諮詢記錄</div>' +
            '<div class="small mt-1">點擊下方按鈕開始填寫您的第一筆記錄</div>' +
            '</td></tr>';
        }
        $('#submissions-table-body').html(emptyMessage);
        return;
      }
      
      var tableRows = '';
      submissions.forEach(function(submission, index) {
        var bgColor = index % 2 === 0 ? '#E4FBFC' : '#eeeeee';
        
        // 格式化日期
        var displayDate = submission.submission_date || submission.created_at || '-';
        if (displayDate !== '-') {
          try {
            var date = new Date(displayDate);
            displayDate = date.getFullYear() + '-' + 
                        String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                        String(date.getDate()).padStart(2, '0') + ' ' +
                        String(date.getHours()).padStart(2, '0') + ':' +
                        String(date.getMinutes()).padStart(2, '0');
          } catch (e) {
            // 如果日期解析失敗，保留原始值
          }
        }
        
        // 格式化肌膚類型
        var skinTypeMap = {
          'normal': '一般性',
          'combination': '混合性',
          'oily': '油性',
          'dry': '乾性',
          'sensitive': '敏感性'
        };
        var displaySkinType = skinTypeMap[submission.skin_type] || submission.skin_type || '-';
        
        tableRows += '<tr style="background-color: ' + bgColor + ';">';
        // 會員(來賓)資訊 - 包含姓名和電話
        tableRows += '<td nowrap="nowrap" class="text-center">' + (submission.member_name || '-') + '<br>' + (submission.phone || '-') + '</td>';
        // 出貨日期 (暫時顯示為 -)
        tableRows += '<td>-</td>';
        // 最後填寫日期
        tableRows += '<td>' + displayDate + '</td>';
        // 已填寫數量 (暫時顯示為 1)
        tableRows += '<td class="text-center">1</td>';
        // 查看
        tableRows += '<td class="text-center">';
        tableRows += '<a href="javascript:void(0);" onclick="question_reply_div(' + index + ');" title="檢視">';
        tableRows += '<i class="fa fa-angle-down fa-lg menu__icon--open"></i>';
        tableRows += '</a>';
        tableRows += '</td>';
        tableRows += '</tr>';
        
        // 詳細資料行（隱藏）
        tableRows += '<tr style="display:none" id="qdiv_' + index + '">';
        tableRows += '<td colspan="5">';
        tableRows += '<div class="card-body">';
        tableRows += '<div class="row mb-3">';
        tableRows += '<div class="col-md-auto border-right">已填寫</div>';
        tableRows += '<div class="col-md-10">';
        tableRows += '<ul class="list-inline text-left" style="margin-top: -10px;">';
        tableRows += '<li class="list-inline-item">';
        tableRows += '<span title="填寫時間：' + displayDate + '">' + displayDate + '</span>　　';
        tableRows += '<a href="javascript:void(0);" onclick="question_reply_show(\'' + (submission.id || index) + '\',\'' + (submission.member_name || '會員') + ' 的肌膚諮詢記錄表\');" data-toggle="modal" data-target="#exampleModal">';
        tableRows += '<i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>';
        tableRows += '</a>　｜　';
        tableRows += '<a href="javascript:void(0);" onclick="question_reply_edit(\'' + (submission.id || index) + '\',\'' + (submission.member_name || '會員') + ' 的肌膚諮詢記錄表\');" data-toggle="modal" data-target="#exampleModal">';
        tableRows += '<i class="icon ion-edit" style="font-size: 1.1rem;"></i>';
        tableRows += '</a>';
        tableRows += '</li>';
        tableRows += '</ul>';
        tableRows += '</div>';
        tableRows += '</div>';
        tableRows += '</div>';
        tableRows += '</td>';
        tableRows += '</tr>';
      });
      
      $('#submissions-table-body').html(tableRows);
    }
    
    // 切換詳細資料顯示
    function question_reply_div(index) {
      var detailRow = $('#qdiv_' + index);
      if (detailRow.is(':visible')) {
        detailRow.hide();
      } else {
        detailRow.show();
      }
    }
    
    // 檢視表單詳細內容 (參照原版)
    function question_reply_show(submissionId, title) {
      if (!submissionId) {
        alert('提交記錄ID無效');
        return;
      }
      
      // 設置模態標題
      $('#exampleModal .modal-title').text(title);
      
      // 重置模態內容為載入狀態
      $('#exampleModal .modal-body').html(
        '<div class="text-center p-4">' +
        '<i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i>' +
        '<div class="mt-2">載入中，請稍候...</div>' +
        '</div>'
      );
      
      // 從API獲取詳細資料
      $.ajax({
        url: '<?php echo base_url("api/eeform1/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            displayOriginalFormContent(response.data, false); // false = 檢視模式
          } else {
            showFormError('無法載入表單資料: ' + (response.message || '未知錯誤'));
          }
        },
        error: function(xhr, status, error) {
          var errorMessage = '載入失敗';
          if (xhr.status === 404) {
            errorMessage = '找不到指定的表單記錄';
          } else if (xhr.status === 500) {
            errorMessage = '服務器內部錯誤';
          } else if (xhr.responseText) {
            try {
              var errorResponse = JSON.parse(xhr.responseText);
              errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
              errorMessage += ' (錯誤代碼: ' + xhr.status + ')';
            }
          }
          showFormError(errorMessage);
        }
      });
    }
    
    // 編輯表單內容 (參照原版)
    function question_reply_edit(submissionId, title) {
      if (!submissionId) {
        alert('提交記錄ID無效');
        return;
      }
      
      // 設置模態標題
      $('#exampleModal .modal-title').text(title + ' - 編輯');
      
      // 重置模態內容為載入狀態
      $('#exampleModal .modal-body').html(
        '<div class="text-center p-4">' +
        '<i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i>' +
        '<div class="mt-2">載入中，請稍候...</div>' +
        '</div>'
      );
      
      // 從API獲取詳細資料
      $.ajax({
        url: '<?php echo base_url("api/eeform1/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            displayOriginalFormContent(response.data, true); // true = 編輯模式
          } else {
            showFormError('無法載入表單資料: ' + (response.message || '未知錯誤'));
          }
        },
        error: function(xhr, status, error) {
          var errorMessage = '載入失敗';
          if (xhr.status === 404) {
            errorMessage = '找不到指定的表單記錄';
          } else if (xhr.status === 500) {
            errorMessage = '服務器內部錯誤';
          } else if (xhr.responseText) {
            try {
              var errorResponse = JSON.parse(xhr.responseText);
              errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
              errorMessage += ' (錯誤代碼: ' + xhr.status + ')';
            }
          }
          showFormError(errorMessage);
        }
      });
    }
    
    // 顯示原版表單內容
    function displayOriginalFormContent(data, isEditable) {
      if (!data) {
        showFormError('無效的資料格式');
        return;
      }
      
      var disabled = isEditable ? '' : ' disabled readonly';
      var currentDate = new Date().toISOString().slice(0, 10);
      
      // 建構完整表單內容 (參照原版設計)
      var html = '<div class="mb30">';
      html += '<div class="container">';
      html += '<form action="#" class="text-left">';
      html += '<div class="row">';
      
      // 填寫日期
      html += '<div class="col-sm-12 text-right mb30">填寫日期：' + (data.submission_date || data.created_at || currentDate) + '</div>';
      
      // 基本資料
      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">會員姓名</label>';
      html += '<input type="text" class="form-control form-control-custom" placeholder="請填會員姓名" value="' + (data.member_name || '') + '"' + disabled + ' />';
      html += '</div>';
      
      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">出生西元年</label>';
      html += '<select class="form-control form-control-custom"' + disabled + '>';
      html += '<option>請選擇</option>';
      for (var year = 2005; year >= 1930; year--) {
        var selected = (data.birth_year == year) ? ' selected' : '';
        html += '<option value="' + year + '"' + selected + '>' + year + '</option>';
      }
      html += '</select>';
      html += '</div>';
      
      html += '<div class="col-sm-2 mb30">';
      html += '<label class="label-custom">出生西元月</label>';
      html += '<select class="form-control form-control-custom"' + disabled + '>';
      html += '<option>請選擇</option>';
      for (var month = 1; month <= 12; month++) {
        var selected = (data.birth_month == month) ? ' selected' : '';
        html += '<option value="' + month + '"' + selected + '>' + month + '月</option>';
      }
      html += '</select>';
      html += '</div>';
      
      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">電話</label>';
      html += '<input type="text" class="form-control form-control-custom" placeholder="請填09xxxxxxxx" value="' + (data.phone || '') + '"' + disabled + ' />';
      html += '</div>';
      
      // 職業
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">職業：';
      var occupations = ['服務業', '上班族', '餐飲業', '家管'];
      occupations.forEach(function(job, index) {
        var checked = (data.occupations && data.occupations.some(function(o) { return o.occupation_type === job; })) ? ' checked' : '';
        html += '<input class="form-check-input" type="checkbox" value="' + job + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + job + ' </label>';
        html += '</div><div class="form-check form-check-inline">';
      });
      html += '</div></div>';
      
      // 戶外日曬時間
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">戶外日曬時間：';
      var sunlightOptions = ['1~2小時', '3~4小時', '5~6小時', '8小時以上'];
      sunlightOptions.forEach(function(option, index) {
        var checked = (data.lifestyle && data.lifestyle.some(function(l) { return l.category === 'sunlight' && l.item_value === option; })) ? ' checked' : '';
        html += '<input class="form-check-input" type="checkbox" value="' + option + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + option + ' </label>';
        html += '</div><div class="form-check form-check-inline">';
      });
      html += '</div></div>';
      
      // 待在空調環境
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">待在空調環境：';
      var airConditionOptions = ['1小時內', '2~4小時', '5~8小時', '8小時以上'];
      airConditionOptions.forEach(function(option, index) {
        var checked = (data.lifestyle && data.lifestyle.some(function(l) { return l.category === 'aircondition' && l.item_value === option; })) ? ' checked' : '';
        html += '<input class="form-check-input" type="checkbox" value="' + option + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + option + ' </label>';
        html += '</div><div class="form-check form-check-inline">';
      });
      html += '</div></div>';
      
      // 睡眠狀況
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">睡眠狀況：';
      var sleepOptions = ['9:00~10:59點pm就寢', '11:00~12:59點pm就寢', '凌晨1點之後就寢'];
      sleepOptions.forEach(function(option, index) {
        var checked = (data.lifestyle && data.lifestyle.some(function(l) { return l.category === 'sleep' && l.item_value === option; })) ? ' checked' : '';
        html += '<input class="form-check-input" type="checkbox" value="' + option + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + option + ' </label>';
        html += '</div><div class="form-check form-check-inline">';
      });
      html += '<input class="form-check-input" type="checkbox"' + disabled + '>';
      html += '<label class="form-check-label">其他： </label>';
      html += '<input type="text"' + disabled + '>';
      html += '</div></div>';
      
      // 肌膚困擾
      html += '<div class="col-sm-12 mb50">';
      html += '<div class="card bg-light">';
      html += '<div class="card-body">';
      html += '<div class="container">';
      html += '<div class="row"><p class="mb-0">肌膚困擾：</p></div>';
      html += '<div class="row mb30">';
      var skinIssues = ['沒有彈性', '沒有光澤', '暗沉', '斑點', '毛孔粗大', '痘痘粉刺', '皺紋細紋', '粗糙', '癢、紅腫', '乾燥', '上妝不服貼'];
      skinIssues.forEach(function(issue, index) {
        var checked = (data.skin_issues && data.skin_issues.some(function(i) { return i.issue_description === issue; })) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" value="' + issue + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + issue + ' </label>';
        html += '</div>';
      });
      html += '</div>';
      html += '<div class="row"><p class="mb-0">肌膚是否容易過敏：</p></div>';
      html += '<div class="row">';
      var allergyOptions = ['經常', '偶爾(換季時)', '不會'];
      allergyOptions.forEach(function(option, index) {
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox"' + disabled + '>';
        html += '<label class="form-check-label">' + option + ' </label>';
        html += '</div>';
      });
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      
      // 建議內容
      html += '<div class="col-sm-12"><hr class="my-4"></div>';
      html += '<div class="col-sm-12 mb30">';
      html += '<h4>建議內容：</h4>';
      html += '<div class="alert alert-warning" role="alert">';
      html += '<div class="row">';
      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">化妝水：</label>';
      html += '<input type="text" class="form-control form-control-custom" value="' + (data.suggestions ? data.suggestions.toner_suggestion || '' : '') + '"' + disabled + ' />';
      html += '</div>';
      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">精華液：</label>';
      html += '<input type="text" class="form-control form-control-custom" value="' + (data.suggestions ? data.suggestions.serum_suggestion || '' : '') + '"' + disabled + ' />';
      html += '</div>';
      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">建議內容</label>';
      html += '<input type="text" class="form-control form-control-custom" placeholder="請填寫建議內容…" value="' + (data.suggestions ? data.suggestions.suggestion_content || '' : '') + '"' + disabled + ' />';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      
      // 肌膚檢測數據
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="card bg-light">';
      html += '<div class="card-body">';
      html += '<div class="container">';
      html += '<div class="row">';
      html += '<div class="col-sm-7 mb30">';
      html += '<div class="form-check form-check-inline">肌膚型：';
      var skinTypes = [
        { value: 'dry', label: '乾性' },
        { value: 'normal', label: '中性' },
        { value: 'combination', label: '混合性' },
        { value: 'sensitive', label: '敏感性' },
        { value: 'oily', label: '油性' }
      ];
      skinTypes.forEach(function(type) {
        var checked = (data.skin_type === type.value) ? ' checked' : '';
        html += '<input class="form-check-input" type="radio" name="skin_type" value="' + type.value + '"' + checked + disabled + '>';
        html += '<label class="form-check-label">' + type.label + ' </label>';
        html += '</div><div class="form-check form-check-inline">';
      });
      html += '</div></div>';
      html += '<div class="col-sm-5 mb30">';
      html += '<div class="form-check form-check-inline">';
      html += '<label class="form-check-label">肌膚年齡： </label>';
      html += '<input type="text" value="' + (data.skin_age || '') + '"' + disabled + '>';
      html += '</div>';
      html += '</div>';
      
      // 檢測數據區塊 (水潤、膚色、紋理等)
      var testCategories = ['水潤', '膚色', '紋理', '敏感', '油脂', '色素', '皺紋', '毛孔'];
      testCategories.forEach(function(category) {
        html += addTestDataSection(category, data, disabled);
      });
      
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      
      if (isEditable) {
        html += '<div class="col-sm-12 mb30">';
        html += '<hr class="my-4">';
        html += '<button type="button" class="btn btn-outline-danger btn-block" onclick="updateFormData()">更新表單</button>';
        html += '</div>';
      }
      
      html += '</div>';
      html += '</form>';
      html += '</div>';
      html += '</div>';
      
      $('#exampleModal .modal-body').html(html);
    }
    
    // 新增檢測數據區塊
    function addTestDataSection(categoryName, data, disabled) {
      var html = '<div class="col-sm-12 mb20">';
      html += '<label class="label-custom">' + categoryName + '</label>';
      html += '<div class="row">';
      
      // 三組日期和數字輸入
      for (var i = 0; i < 3; i++) {
        html += '<div class="col-sm-4 mb20">';
        html += '<div class="row">';
        html += '<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="請填日期…"' + disabled + '></div>';
        html += '<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"' + disabled + '></div>';
        html += '</div>';
        html += '</div>';
      }
      
      html += '</div>';
      html += '<div class="row">';
      
      // 三組下拉選單和數字輸入
      for (var i = 0; i < 3; i++) {
        html += '<div class="col-sm-4 mb20">';
        html += '<div class="row">';
        html += '<div class="col-lg-6">';
        html += '<select class="form-control form-control-custom"' + disabled + '>';
        html += '<option>請選擇</option>';
        html += '<option>嚴重、盡快改善</option>';
        html += '<option>有問題、要注意</option>';
        html += '<option>健康</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="col-lg-6"><input type="text" class="form-control form-control-custom" placeholder="限填數字…"' + disabled + '></div>';
        html += '</div>';
        html += '</div>';
      }
      
      html += '</div>';
      html += '</div>';
      
      return html;
    }
    
    // 顯示表單錯誤訊息
    function showFormError(message) {
      $('#exampleModal .modal-body').html(
        '<div class="text-center p-4">' +
        '<i class="icon ion-alert-circled" style="font-size: 2rem; color: #dc3545;"></i>' +
        '<div class="mt-2 text-danger">' + message + '</div>' +
        '<div class="mt-3"><button class="btn btn-sm btn-outline-primary" onclick="$(\'#exampleModal\').modal(\'hide\');">關閉</button></div>' +
        '</div>'
      );
    }
    
    // 更新表單資料
    function updateFormData() {
      alert('更新功能開發中...');
    }
    
    // 執行搜尋
    function performSearch() {
      var searchTerm = $('#search').val().trim();
      $('#search_msg').text('');
      
      if (!searchTerm) {
        // 如果搜尋欄位為空，顯示所有記錄
        filteredSubmissions = allSubmissions;
        renderSubmissionsTable(allSubmissions);
        $('#search_msg').text('');
        return;
      }
      
      // 顯示搜尋中狀態
      $('#search_msg').html('<i class="icon ion-loading-c" style="animation: spin 1s linear infinite;"></i> 搜尋中...');
      
      // 模擬搜尋延遲，提供更好的用戶體驗
      setTimeout(function() {
        // 在本地資料中進行搜尋
        filteredSubmissions = allSubmissions.filter(function(submission) {
          var memberName = (submission.member_name || '').toLowerCase();
          var phone = (submission.phone || '').toLowerCase();
          var searchLower = searchTerm.toLowerCase();
          
          return memberName.includes(searchLower) || phone.includes(searchLower);
        });
        
        // 渲染搜尋結果
        renderSubmissionsTable(filteredSubmissions);
        
        // 顯示搜尋結果統計
        var resultCount = filteredSubmissions.length;
        if (resultCount === 0) {
          $('#search_msg').html('<i class="icon ion-search"></i> 找不到符合條件的記錄');
        } else {
          $('#search_msg').html('<i class="icon ion-search"></i> 找到 ' + resultCount + ' 筆記錄');
        }
      }, 300);
    }
    
    // 清除搜尋
    function clearSearch() {
      $('#search').val('');
      $('#search_msg').text('');
      filteredSubmissions = allSubmissions;
      renderSubmissionsTable(allSubmissions);
    }
    </script>
	  
	  <!-- Custom styles for enhanced error states -->
	  <style>
	    /* Loading spinner animation */
	    @keyframes spin {
	      0% { transform: rotate(0deg); }
	      100% { transform: rotate(360deg); }
	    }
	    
	    /* Table empty state styles */
	    #submissions-table-body td {
	      vertical-align: middle;
	    }
	    
	    /* Enhanced error state button */
	    .retry-btn:hover {
	      transform: translateY(-1px);
	      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	    }
	    
	    /* Search form enhancements */
	    #search {
	      border-radius: 0.25rem;
	      border: 2px solid #dee2e6;
	      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	    }
	    
	    #search:focus {
	      border-color: #007bff;
	      box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
	    }
	    
	    #search_msg {
	      font-size: 0.875rem;
	      color: #6c757d;
	    }
	    
	    /* Table row hover effects */
	    #submissions-table-body tr:hover {
	      background-color: #e3f2fd !important;
	      transition: background-color 0.2s ease;
	    }
	    
	    /* Action button improvements */
	    #submissions-table-body a {
	      text-decoration: none;
	      transition: all 0.2s ease;
	    }
	    
	    #submissions-table-body a:hover {
	      transform: scale(1.1);
	    }
	    
	    /* Search button improvements */
	    .btn {
	      transition: all 0.2s ease;
	    }
	    
	    .btn:hover {
	      transform: translateY(-1px);
	      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	    }
	  </style>
	  
	  <!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModal" aria-hidden="true" id="exampleModal">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="submissionModalTitle">肌膚諮詢記錄表詳細資料</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="submissionModalBody">
        <div class="text-center p-4">
          <i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i>
          <div class="mt-2">載入中，請稍候...</div>
        </div>
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
