<body class="theme-orange fixed-footer fixed-footer-lg">
  <div class="animsition">
    <div class="wrapper">
      <?= $this->block_service->load_html_header(); ?>


      <div class="section-mini">


        <div class="section-item text-left">
          <div class="container">
            <div class="row">
              <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                <h1 class="h2-3d font-libre"><strong>會員服務追蹤管理表(肌膚)</strong></h1>
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

                      <div class="card mb-3">
                        <div class="card-body">
                          <table class="table table-striped mb-2 text-center">
                            <thead class="thead-dark">
                              <tr>
                                <th width="33%">會員</th>
                                <th width="33%">最後填寫日期</th>
                                <th width="17%">已填寫</th>
                                <th width="17%">查看</th>
                              </tr>
                            </thead>
                            <tbody id="submissions-table-body">
                              <tr>
                                <td colspan="4" class="text-center text-muted p-4">
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
                <a href="<?php echo base_url('eform/eform2'); ?>" class="btn btn-outline-danger btn-block">填寫會員服務追蹤管理表(肌膚)</a>
                    </div>


                  </div>
                </div>

              </div>

              <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

              <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                <!-- 側邊欄清單 -->
                <?= $this->block_service->electronic_form_right_menu('eform2'); ?>
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
          '<tr><td colspan="4" class="text-center text-warning p-4">' +
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
        url: '<?php echo base_url("api/eeform/eeform2/submissions/"); ?>' + currentMemberId,
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
            '<tr><td colspan="4" class="text-center text-danger p-4">' +
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
        $('#submissions-table-body').html('<tr><td colspan="4" class="text-center text-warning p-4"><i class="icon ion-information-circled mr-2"></i>資料格式錯誤</td></tr>');
        return;
      }

      if (submissions.length === 0) {
        var emptyMessage = '';
        if ($('#search').val().trim()) {
          // 搜尋結果為空
          emptyMessage =
            '<tr><td colspan="4" class="text-center text-muted p-4">' +
            '<div><i class="icon ion-search" style="font-size: 2rem; opacity: 0.5;"></i></div>' +
            '<div class="mt-2">找不到符合 "' + $('#search').val().trim() + '" 的記錄</div>' +
            '<div class="small mt-1">請嘗試使用不同的關鍵字搜尋</div>' +
            '</td></tr>';
        } else {
          // 沒有任何記錄
          emptyMessage =
            '<tr><td colspan="4" class="text-center text-muted p-4">' +
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
        // 會員資訊 - 包含姓名和電話
        tableRows += '<td nowrap="nowrap" class="text-center">' + (submission.member_name || '-') + '<br>' + (submission.phone || '-') + '</td>';
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
        tableRows += '<td colspan="4">';
        tableRows += '<div class="card-body">';
        tableRows += '<div class="row mb-3">';
        tableRows += '<div class="col-md-auto border-right">已填寫</div>';
        tableRows += '<div class="col-md-10">';
        tableRows += '<ul class="list-inline text-left" style="margin-top: -10px;">';
        tableRows += '<li class="list-inline-item">';
        tableRows += '<span title="填寫時間：' + displayDate + '">' + displayDate + '</span>　　';
        tableRows += '<a href="javascript:void(0);" onclick="question_reply_show(\'' + (submission.id || index) + '\',\'' + (submission.member_name || '會員') + ' 的肌膚諮詢記錄表\');" data-toggle="modal" data-target="#exampleModal" title="檢視">';
        tableRows += '<i class="icon ion-clipboard" style="font-size: 1.1rem;"></i>';
        tableRows += '</a>　｜　';
        tableRows += '<a href="javascript:void(0);" onclick="question_reply_edit(\'' + (submission.id || index) + '\',\'' + (submission.member_name || '會員') + ' 的肌膚諮詢記錄表\');" data-toggle="modal" data-target="#exampleModal" title="編輯">';
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
        url: '<?php echo base_url("api/eeform/eeform2/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            console.log('=== API Response Debug ===');
            console.log('Raw API response:', response.data);
            console.log('Skin scores data structure:', {
              has_skin_scores: !!(response.data.skin_scores),
              skin_scores_length: response.data.skin_scores ? response.data.skin_scores.length : 0,
              has_moisture_scores: !!(response.data.moisture_scores),
              moisture_scores_length: response.data.moisture_scores ? response.data.moisture_scores.length : 0
            });
            if (response.data.skin_scores) {
              console.log('Skin scores sample:', response.data.skin_scores.slice(0, 3));
            }
            if (response.data.moisture_scores) {
              console.log('Moisture scores sample:', response.data.moisture_scores.slice(0, 3));
            }
            console.log('==========================');

            var transformedData = transformApiDataToFormStructure(response.data);
            displayOriginalFormContent(transformedData, false); // false = 檢視模式
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

      // 儲存當前編輯的記錄ID供更新時使用
      window.currentEditingSubmissionId = submissionId;

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
        url: '<?php echo base_url("api/eeform/eeform2/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            console.log('=== Edit API Response Debug ===');
            console.log('Raw API response for edit:', response.data);
            console.log('Skin scores data structure:', {
              has_skin_scores: !!(response.data.skin_scores),
              skin_scores_length: response.data.skin_scores ? response.data.skin_scores.length : 0,
              has_moisture_scores: !!(response.data.moisture_scores),
              moisture_scores_length: response.data.moisture_scores ? response.data.moisture_scores.length : 0
            });
            if (response.data.skin_scores) {
              console.log('Skin scores sample:', response.data.skin_scores.slice(0, 3));
            }
            if (response.data.moisture_scores) {
              console.log('Moisture scores sample:', response.data.moisture_scores.slice(0, 3));
            }
            console.log('===============================');

            var transformedData = transformApiDataToFormStructure(response.data);
            displayOriginalFormContent(transformedData, true); // true = 編輯模式
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

    // 轉換eform2資料結構為平面結構
    function transformApiDataToFormStructure(apiData) {
      if (!apiData) return null;

      // eform2的簡單資料結構
      var formData = {
        id: apiData.id || null,
        member_id: apiData.member_id || null,
        member_name: apiData.member_name || '',
        join_date: apiData.join_date || '',
        gender: apiData.gender || '',
        age: apiData.age || '',
        skin_health_condition: apiData.skin_health_condition || '',
        line_contact: apiData.line_contact || '',
        tel_contact: apiData.tel_contact || '',
        meeting_date: apiData.meeting_date || '',
        submission_date: apiData.submission_date || '',
        created_at: apiData.created_at || '',
        updated_at: apiData.updated_at || '',
        form_filler_id: apiData.form_filler_id || null,
        form_filler_name: apiData.form_filler_name || ''
      };

      console.log('Raw eform2 fields from API:', {
        member_name: apiData.member_name,
        gender: apiData.gender,
        age: apiData.age,
        skin_health_condition: apiData.skin_health_condition
      });

      // 處理產品資料
      if (apiData.products && Array.isArray(apiData.products)) {
        formData.products = apiData.products;
        console.log('Processing eform2 products:', apiData.products);
      } else {
        formData.products = [];
        console.log('No products data found');
      }

      // eform2沒有複雜的生活方式資料結構

      // eform2的產品資料結構已在上面處理

      // eform2沒有複雜的肌膚困擾資料結構

      // eform2沒有過敏狀況資料結構

      // eform2沒有建議內容資料結構

      // eform2沒有肌膚評分資料結構

      console.log('Transformed form data:', formData);
      return formData;
    }

    // 顯示eform2表單內容
    function displayOriginalFormContent(data, isEditable) {
      if (!data) {
        showFormError('無效的資料格式');
        return;
      }

      console.log('Displaying eform2 form with transformed data:', data);

      var disabled = isEditable ? '' : ' disabled readonly';
      var currentDate = new Date().toISOString().slice(0, 10);

      // 建構eform2表單內容
      var html = '<div class="mb30" style="background-color: #ffffff; padding: 20px;">';
      html += '<div class="container">';
      html += '<form action="#" class="text-left" style="background-color: #ffffff;">';
      html += '<div class="row">';

      // 填寫日期
      var displayDate = data.submission_date || data.created_at || currentDate;
      if (displayDate !== currentDate) {
        try {
          var date = new Date(displayDate);
          displayDate = date.getFullYear() + '-' +
            String(date.getMonth() + 1).padStart(2, '0') + '-' +
            String(date.getDate()).padStart(2, '0');
        } catch (e) {
          displayDate = currentDate;
        }
      }
      html += '<div class="col-sm-12 text-right mb30">填寫日期：' + displayDate + '</div>';

      // 基本資料
      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">會員編號</label>';
      html += '<input type="text" name="member_id" class="form-control form-control-custom" placeholder="請填會員編號" value="' + (data.member_id || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">姓名</label>';
      html += '<input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名" value="' + (data.member_name || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">入會日</label>';
      html += '<input type="date" name="join_date" class="form-control form-control-custom" value="' + (data.join_date || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">性別</label>';
      html += '<select name="gender" class="form-control form-control-custom"' + disabled + '>';
      html += '<option value="">請選擇</option>';
      html += '<option value="女"' + ((data.gender === '女') ? ' selected' : '') + '>女</option>';
      html += '<option value="男"' + ((data.gender === '男') ? ' selected' : '') + '>男</option>';
      html += '</select>';
      html += '</div>';

      html += '<div class="col-sm-3 mb30">';
      html += '<label class="label-custom">年齡</label>';
      html += '<input type="number" name="age" class="form-control form-control-custom" placeholder="限填數字" value="' + (data.age || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">肌膚/健康狀況</label>';
      html += '<input type="text" name="skin_health_condition" class="form-control form-control-custom" placeholder="請填寫肌膚/健康狀況…" value="' + (data.skin_health_condition || '') + '"' + disabled + ' />';
      html += '</div>';

      // 訂購產品
      html += '<div class="col-sm-12 mb30">';
      html += '<h5>訂購產品</h5>';
      html += '<div class="card bg-light" style="background-color: #f8f9fa !important;">';
      html += '<div class="card-body" style="background-color: #f8f9fa;">';
      html += '<div class="container">';
      html += '<div class="row">';
      if (data.products && Array.isArray(data.products) && data.products.length > 0) {
        data.products.forEach(function(product, index) {
          html += '<div class="col-md-4 mb-3">';
          html += '<div class="form-check">';
          html += '<input class="form-check-input" type="checkbox" checked' + disabled + '>';
          html += '<label class="form-check-label">' + (product.product_name || '產品 ' + (index + 1)) + '</label>';
          html += '</div>';
          html += '<div class="ml-3">';
          html += '<small class="text-muted">建議用量: ' + (product.dosage || '-') + '</small>';
          html += '</div>';
          html += '</div>';
        });
      } else {
        html += '<div class="col-12 text-center text-muted">暫無產品資料</div>';
      }
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';

      // 聯絡資訊
      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">LINE</label>';
      html += '<input type="text" name="line_contact" class="form-control form-control-custom" placeholder="請填寫LINE聯絡狀況，300字元內…" value="' + (data.line_contact || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">TEL</label>';
      html += '<input type="text" name="tel_contact" class="form-control form-control-custom" placeholder="請填寫電話聯絡狀況，300字元內…" value="' + (data.tel_contact || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">見面日</label>';
      html += '<input type="date" name="meeting_date" class="form-control form-control-custom" value="' + (data.meeting_date || '') + '"' + disabled + ' />';
      html += '</div>';

      // 代填者資訊
      if (data.form_filler_name || data.form_filler_id) {
        html += '<div class="col-sm-12 mb30">';
        html += '<hr class="my-4">';
        html += '<h5>代填者資訊</h5>';
        html += '<div class="row">';
        html += '<div class="col-sm-6 mb30">';
        html += '<label class="label-custom">代填者編號</label>';
        html += '<input type="text" name="form_filler_id" class="form-control form-control-custom" value="' + (data.form_filler_id || '') + '"' + disabled + ' />';
        html += '</div>';
        html += '<div class="col-sm-6 mb30">';
        html += '<label class="label-custom">代填者姓名</label>';
        html += '<input type="text" name="form_filler_name" class="form-control form-control-custom" value="' + (data.form_filler_name || '') + '"' + disabled + ' />';
        html += '</div>';
        html += '</div>';
        html += '</div>';
      }
      // 編輯模式的更新按鈕
      if (isEditable) {
        html += '<div class="col-sm-12 mb30">';
        html += '<hr class="my-4">';
        html += '<button type="button" class="btn btn-outline-danger btn-block" onclick="updateEform2Data()">更新表單</button>';
        html += '</div>';
      }

      html += '</div>';
      html += '</form>';
      html += '</div>';
      html += '</div>';

      $('#exampleModal .modal-body').html(html);
    }

    // 新增檢測數據區塊 - eform2不需要此功能，保留空函數以避免錯誤
    function addTestDataSection(categoryName, data, disabled) {
      return ''; // eform2不需要檢測數據區塊
    }

    // 更新eform2表單資料
    function updateEform2Data() {
      // 收集eform2表單數據
      var formData = {
        // 基本資料
        member_id: $('#exampleModal input[name="member_id"]').val(),
        member_name: $('#exampleModal input[name="member_name"]').val(),
        join_date: $('#exampleModal input[name="join_date"]').val(),
        gender: $('#exampleModal select[name="gender"]').val(),
        age: $('#exampleModal input[name="age"]').val(),
        skin_health_condition: $('#exampleModal input[name="skin_health_condition"]').val(),
        line_contact: $('#exampleModal input[name="line_contact"]').val(),
        tel_contact: $('#exampleModal input[name="tel_contact"]').val(),
        meeting_date: $('#exampleModal input[name="meeting_date"]').val(),
        form_filler_id: $('#exampleModal input[name="form_filler_id"]').val(),
        form_filler_name: $('#exampleModal input[name="form_filler_name"]').val()
      };

      console.log('Collected eform2 data:', formData);

      // 獲取當前編輯的記錄ID
      var submissionId = window.currentEditingSubmissionId || 1;

      // 發送更新請求
      $.ajax({
        url: '<?php echo base_url("api/eeform/eeform2/submission/"); ?>' + submissionId,
        method: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          if (response && response.success) {
            // 使用SweetAlert顯示成功訊息
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: '更新成功！',
                text: '表單已成功更新',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#exampleModal').modal('hide');
                loadSubmissions();
              });
            } else {
              alert('更新成功！');
              $('#exampleModal').modal('hide');
              loadSubmissions();
            }
          } else {
            showUpdateError('更新失敗: ' + (response.message || '未知錯誤'));
          }
        },
        error: function(xhr, status, error) {
          var errorMessage = '更新失敗';
          if (xhr.status === 404) {
            errorMessage = '找不到指定的記錄';
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
          showUpdateError(errorMessage);
        }
      });
    }

    // 顯示表單錯誤訊息
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">戶外日曬時間：</div>';
      var sunlightFields = [{
          name: 'sunlight_1_2h',
          label: '1~2小時'
        },
        {
          name: 'sunlight_3_4h',
          label: '3~4小時'
        },
        {
          name: 'sunlight_5_6h',
          label: '5~6小時'
        },
        {
          name: 'sunlight_8h_plus',
          label: '8小時以上'
        }
      ];
      sunlightFields.forEach(function(option, index) {
        var checked = (data[option.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + option.name + '" id="modal_' + option.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + option.name + '">' + option.label + ' </label>';
        html += '</div>';
      });
      html += '</div>';

      // 待在空調環境
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">待在空調環境：</div>';
      var airconditionFields = [{
          name: 'aircondition_1h',
          label: '1小時內'
        },
        {
          name: 'aircondition_2_4h',
          label: '2~4小時'
        },
        {
          name: 'aircondition_5_8h',
          label: '5~8小時'
        },
        {
          name: 'aircondition_8h_plus',
          label: '8小時以上'
        }
      ];
      airconditionFields.forEach(function(option, index) {
        var checked = (data[option.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + option.name + '" id="modal_' + option.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + option.name + '">' + option.label + ' </label>';
        html += '</div>';
      });
      html += '</div>';

      // 睡眠狀況
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">睡眠狀況：</div>';
      var sleepFields = [{
          name: 'sleep_9_10',
          label: '晚上9:00~10:59就寢'
        },
        {
          name: 'sleep_11_12',
          label: '晚上11:00~12:59就寢'
        },
        {
          name: 'sleep_after_1',
          label: '凌晨1點之後就寢'
        }
      ];
      sleepFields.forEach(function(option, index) {
        var checked = (data[option.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + option.name + '" id="modal_' + option.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + option.name + '">' + option.label + ' </label>';
        html += '</div>';
      });
      var sleepOtherChecked = (data.sleep_other == 1) ? ' checked' : '';
      html += '<div class="form-check form-check-inline">';
      html += '<input class="form-check-input" type="checkbox" name="sleep_other" id="modal_sleep_other" value="1"' + sleepOtherChecked + disabled + '>';
      html += '<label class="form-check-label" for="modal_sleep_other">其他： </label>';
      html += '<input type="text" name="sleep_other_text" value="' + (data.sleep_other_text || '') + '"' + disabled + '>';
      html += '</div></div>';

      // 現在使用產品
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="form-check form-check-inline">現在使用產品：</div>';
      var productFields = [{
          name: 'product_honey_soap',
          label: '蜜皂'
        },
        {
          name: 'product_mud_mask',
          label: '泥膜'
        },
        {
          name: 'product_toner',
          label: '化妝水'
        },
        {
          name: 'product_serum',
          label: '精華液'
        },
        {
          name: 'product_premium',
          label: '極緻系列'
        },
        {
          name: 'product_sunscreen',
          label: '防曬'
        }
      ];
      productFields.forEach(function(product, index) {
        var checked = (data[product.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + product.name + '" id="modal_' + product.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + product.name + '">' + product.label + ' </label>';
        html += '</div>';
      });
      var productOtherChecked = (data.product_other == 1) ? ' checked' : '';
      html += '<div class="form-check form-check-inline">';
      html += '<input class="form-check-input" type="checkbox" name="product_other" id="modal_product_other" value="1"' + productOtherChecked + disabled + '>';
      html += '<label class="form-check-label" for="modal_product_other">其他： </label>';
      html += '<input type="text" name="product_other_text" value="' + (data.product_other_text || '') + '"' + disabled + '>';
      html += '</div></div>';

      // 肌膚困擾
      html += '<div class="col-sm-12 mb50">';
      html += '<div class="card bg-light" style="background-color: #f8f9fa !important;">';
      html += '<div class="card-body" style="background-color: #f8f9fa;">';
      html += '<div class="container">';
      html += '<div class="row"><p class="mb-0">肌膚困擾：</p></div>';
      html += '<div class="row mb30">';
      var skinIssueFields = [{
          name: 'skin_issue_elasticity',
          label: '沒有彈性'
        },
        {
          name: 'skin_issue_luster',
          label: '沒有光澤'
        },
        {
          name: 'skin_issue_dull',
          label: '暗沉'
        },
        {
          name: 'skin_issue_spots',
          label: '斑點'
        },
        {
          name: 'skin_issue_pores',
          label: '毛孔粗大'
        },
        {
          name: 'skin_issue_acne',
          label: '痘痘粉刺'
        },
        {
          name: 'skin_issue_wrinkles',
          label: '皺紋細紋'
        },
        {
          name: 'skin_issue_rough',
          label: '粗糙'
        },
        {
          name: 'skin_issue_irritation',
          label: '癢、紅腫'
        },
        {
          name: 'skin_issue_dry',
          label: '乾燥'
        },
        {
          name: 'skin_issue_makeup',
          label: '上妝不服貼'
        }
      ];
      skinIssueFields.forEach(function(issue, index) {
        var checked = (data[issue.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + issue.name + '" id="modal_' + issue.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + issue.name + '">' + issue.label + ' </label>';
        html += '</div>';
      });
      var skinIssueOtherChecked = (data.skin_issue_other == 1) ? ' checked' : '';
      html += '<div class="form-check form-check-inline">';
      html += '<input class="form-check-input" type="checkbox" name="skin_issue_other" id="modal_skin_issue_other" value="1"' + skinIssueOtherChecked + disabled + '>';
      html += '<label class="form-check-label" for="modal_skin_issue_other">其他： </label>';
      html += '<input type="text" name="skin_issue_other_text" value="' + (data.skin_issue_other_text || '') + '"' + disabled + '>';
      html += '</div></div>';
      html += '<div class="row"><p class="mb-0">肌膚是否容易過敏：</p></div>';
      html += '<div class="row">';
      var allergyFields = [{
          name: 'allergy_frequent',
          label: '經常'
        },
        {
          name: 'allergy_seasonal',
          label: '偶爾(換季時)'
        },
        {
          name: 'allergy_never',
          label: '不會'
        }
      ];
      allergyFields.forEach(function(option, index) {
        var checked = (data[option.name] == 1) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="checkbox" name="' + option.name + '" id="modal_' + option.name + '" value="1"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_' + option.name + '">' + option.label + ' </label>';
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
      html += '<div class="alert alert-warning" role="alert" style="background-color: #fff3cd !important; border-color: #ffeaa7; opacity: 1 !important;">';
      html += '<div class="row">';
      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">化妝水：</label>';
      html += '<input type="text" name="toner_suggestion" class="form-control form-control-custom" value="' + (data.toner_suggestion || '') + '"' + disabled + ' />';
      html += '</div>';
      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">精華液：</label>';
      html += '<input type="text" name="serum_suggestion" class="form-control form-control-custom" value="' + (data.serum_suggestion || '') + '"' + disabled + ' />';
      html += '</div>';
      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">建議內容</label>';
      html += '<input type="text" name="suggestion_content" class="form-control form-control-custom" placeholder="請填寫建議內容…" value="' + (data.suggestion_content || '') + '"' + disabled + ' />';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';

      // 肌膚檢測數據
      html += '<div class="col-sm-12 mb30">';
      html += '<div class="card bg-light" style="background-color: #f8f9fa !important;">';
      html += '<div class="card-body" style="background-color: #f8f9fa;">';
      html += '<div class="container">';
      html += '<div class="row">';
      html += '<div class="col-sm-8 mb30">';
      html += '<div class="form-check form-check-inline">肌膚類型：</div>';
      var skinTypes = [{
          value: 'normal',
          label: '中性'
        },
        {
          value: 'combination',
          label: '混合性'
        },
        {
          value: 'oily',
          label: '油性'
        },
        {
          value: 'dry',
          label: '乾性'
        },
        {
          value: 'sensitive',
          label: '敏感性'
        }
      ];
      skinTypes.forEach(function(type) {
        var checked = (data.skin_type === type.value) ? ' checked' : '';
        html += '<div class="form-check form-check-inline">';
        html += '<input class="form-check-input" type="radio" name="skin_type" id="modal_skin_' + type.value + '" value="' + type.value + '"' + checked + disabled + '>';
        html += '<label class="form-check-label" for="modal_skin_' + type.value + '">' + type.label + ' </label>';
        html += '</div>';
      });
      html += '</div>';
      html += '<div class="col-sm-4 mb30">';
      html += '<div class="form-check form-check-inline">';
      html += '<label class="form-check-label" for="modal_skin_age">肌膚年齡： </label>';
      html += '<input type="number" name="skin_age" id="modal_skin_age" value="' + (data.skin_age || '') + '" style="width: 80%;"' + disabled + '>';
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
      var html = '<div class="col-sm-12 mb20" style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;">';
      html += '<label class="label-custom">' + categoryName + '</label>';
      html += '<div class="row">';

      // 查找對應的評分資料
      var categoryScores = [];
      if (data.moisture_scores && Array.isArray(data.moisture_scores)) {
        // 根據 categoryName 匹配對應的資料
        var categoryMapping = {
          '水潤': 'moisture',
          '膚色': 'complexion',
          '紋理': 'texture',
          '敏感': 'sensitivity',
          '油脂': 'oil',
          '色素': 'pigment',
          '皺紋': 'wrinkle',
          '毛孔': 'pore'
        };

        var categoryKey = categoryMapping[categoryName] || 'moisture';
        categoryScores = data.moisture_scores.filter(function(score) {
          return score.category === categoryKey;
        });

        console.log('Processing category:', categoryName, '-> key:', categoryKey);
        console.log('Available scores:', data.moisture_scores.length);
        console.log('Filtered scores for', categoryName, ':', categoryScores);
      } else {
        console.log('No moisture_scores data available for', categoryName);
      }

      // Get the category key for field naming
      var categoryKey = {
        '水潤': 'moisture',
        '膚色': 'complexion',
        '紋理': 'texture',
        '敏感': 'sensitivity',
        '油脂': 'oil',
        '色素': 'pigment',
        '皺紋': 'wrinkle',
        '毛孔': 'pore'
      } [categoryName] || 'moisture';

      // 三組日期和數字輸入
      for (var i = 0; i < 3; i++) {
        var scoreData = categoryScores[i] || {};
        console.log('Score data for', categoryName, 'index', i, ':', scoreData);

        // 日期和數字輸入只顯示資料庫資料，沒有資料時顯示空白
        var dateValue = scoreData.measurement_date || '';
        var scoreValue = scoreData.score_value || '';

        console.log('Extracted values - date:', dateValue, 'score:', scoreValue);

        html += '<div class="col-sm-4 mb20">';
        html += '<div class="row">';
        html += '<div class="col-lg-6"><input type="text" name="' + categoryKey + '_date_' + i + '" class="form-control form-control-custom" placeholder="請填日期…" value="' + dateValue + '"' + disabled + '></div>';
        html += '<div class="col-lg-6"><input type="text" name="' + categoryKey + '_number_' + i + '" class="form-control form-control-custom" placeholder="限填數字…" value="' + scoreValue + '"' + disabled + '></div>';
        html += '</div>';
        html += '</div>';
      }

      html += '</div>';
      html += '<div class="row">';

      // 三組下拉選單和數字輸入 - 設定預設值
      var defaultValues = [{
          type: 'severe',
          value: '0'
        },
        {
          type: 'warning',
          value: '6'
        },
        {
          type: 'healthy',
          value: '8'
        }
      ];

      for (var i = 0; i < 3; i++) {
        var scoreData2 = categoryScores[i] || {};
        console.log('Dropdown score data for', categoryName, 'index', i, ':', scoreData2);

        // 下拉選單保持預設值邏輯，數值欄位只顯示資料庫資料
        var scoreType = scoreData2.score_type || defaultValues[i].type;
        var scoreValue2 = scoreData2.score_value || '';

        console.log('Dropdown values - type:', scoreType, 'value:', scoreValue2);

        // Create field names based on category and score type
        var scoreTypeField = categoryKey + '_' + scoreType;

        html += '<div class="col-sm-4 mb20">';
        html += '<div class="row">';
        html += '<div class="col-lg-6">';
        html += '<select name="' + scoreTypeField + '_type" class="form-control form-control-custom"' + disabled + '>';
        html += '<option value="">請選擇</option>';
        var options = [{
            value: 'severe',
            label: '嚴重、盡快改善'
          },
          {
            value: 'warning',
            label: '有問題、要注意'
          },
          {
            value: 'healthy',
            label: '健康'
          }
        ];
        options.forEach(function(option) {
          var selected = (scoreType === option.value) ? ' selected' : '';
          html += '<option value="' + option.value + '"' + selected + '>' + option.label + '</option>';
        });
        html += '</select>';
        html += '</div>';
        html += '<div class="col-lg-6"><input type="text" name="' + scoreTypeField + '" class="form-control form-control-custom" placeholder="限填數字…" value="' + scoreValue2 + '"' + disabled + '></div>';
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
      // 收集表單數據 - 使用proper field names
      var formData = {
        // 基本資料
        member_name: $('#exampleModal input[name="member_name"]').val(),
        birth_year: $('#exampleModal select[name="birth_year"]').val(),
        birth_month: $('#exampleModal select[name="birth_month"]').val(),
        phone: $('#exampleModal input[name="phone"]').val(),

        // 職業選擇
        occupation_service: $('#exampleModal input[name="occupation_service"]').is(':checked') ? 1 : 0,
        occupation_office: $('#exampleModal input[name="occupation_office"]').is(':checked') ? 1 : 0,
        occupation_restaurant: $('#exampleModal input[name="occupation_restaurant"]').is(':checked') ? 1 : 0,
        occupation_housewife: $('#exampleModal input[name="occupation_housewife"]').is(':checked') ? 1 : 0,

        // 戶外日曬時間
        sunlight_1_2h: $('#exampleModal input[name="sunlight_1_2h"]').is(':checked') ? 1 : 0,
        sunlight_3_4h: $('#exampleModal input[name="sunlight_3_4h"]').is(':checked') ? 1 : 0,
        sunlight_5_6h: $('#exampleModal input[name="sunlight_5_6h"]').is(':checked') ? 1 : 0,
        sunlight_8h_plus: $('#exampleModal input[name="sunlight_8h_plus"]').is(':checked') ? 1 : 0,

        // 空調環境時間
        aircondition_1h: $('#exampleModal input[name="aircondition_1h"]').is(':checked') ? 1 : 0,
        aircondition_2_4h: $('#exampleModal input[name="aircondition_2_4h"]').is(':checked') ? 1 : 0,
        aircondition_5_8h: $('#exampleModal input[name="aircondition_5_8h"]').is(':checked') ? 1 : 0,
        aircondition_8h_plus: $('#exampleModal input[name="aircondition_8h_plus"]').is(':checked') ? 1 : 0,

        // 睡眠狀況
        sleep_9_10: $('#exampleModal input[name="sleep_9_10"]').is(':checked') ? 1 : 0,
        sleep_11_12: $('#exampleModal input[name="sleep_11_12"]').is(':checked') ? 1 : 0,
        sleep_after_1: $('#exampleModal input[name="sleep_after_1"]').is(':checked') ? 1 : 0,
        sleep_other: $('#exampleModal input[name="sleep_other"]').is(':checked') ? 1 : 0,
        sleep_other_text: $('#exampleModal input[name="sleep_other_text"]').val(),

        // 現在使用產品
        product_honey_soap: $('#exampleModal input[name="product_honey_soap"]').is(':checked') ? 1 : 0,
        product_mud_mask: $('#exampleModal input[name="product_mud_mask"]').is(':checked') ? 1 : 0,
        product_toner: $('#exampleModal input[name="product_toner"]').is(':checked') ? 1 : 0,
        product_serum: $('#exampleModal input[name="product_serum"]').is(':checked') ? 1 : 0,
        product_premium: $('#exampleModal input[name="product_premium"]').is(':checked') ? 1 : 0,
        product_sunscreen: $('#exampleModal input[name="product_sunscreen"]').is(':checked') ? 1 : 0,
        product_other: $('#exampleModal input[name="product_other"]').is(':checked') ? 1 : 0,
        product_other_text: $('#exampleModal input[name="product_other_text"]').val(),

        // 肌膚困擾
        skin_issue_elasticity: $('#exampleModal input[name="skin_issue_elasticity"]').is(':checked') ? 1 : 0,
        skin_issue_luster: $('#exampleModal input[name="skin_issue_luster"]').is(':checked') ? 1 : 0,
        skin_issue_dull: $('#exampleModal input[name="skin_issue_dull"]').is(':checked') ? 1 : 0,
        skin_issue_spots: $('#exampleModal input[name="skin_issue_spots"]').is(':checked') ? 1 : 0,
        skin_issue_pores: $('#exampleModal input[name="skin_issue_pores"]').is(':checked') ? 1 : 0,
        skin_issue_acne: $('#exampleModal input[name="skin_issue_acne"]').is(':checked') ? 1 : 0,
        skin_issue_wrinkles: $('#exampleModal input[name="skin_issue_wrinkles"]').is(':checked') ? 1 : 0,
        skin_issue_rough: $('#exampleModal input[name="skin_issue_rough"]').is(':checked') ? 1 : 0,
        skin_issue_irritation: $('#exampleModal input[name="skin_issue_irritation"]').is(':checked') ? 1 : 0,
        skin_issue_dry: $('#exampleModal input[name="skin_issue_dry"]').is(':checked') ? 1 : 0,
        skin_issue_makeup: $('#exampleModal input[name="skin_issue_makeup"]').is(':checked') ? 1 : 0,
        skin_issue_other: $('#exampleModal input[name="skin_issue_other"]').is(':checked') ? 1 : 0,
        skin_issue_other_text: $('#exampleModal input[name="skin_issue_other_text"]').val(),

        // 過敏狀況
        allergy_frequent: $('#exampleModal input[name="allergy_frequent"]').is(':checked') ? 1 : 0,
        allergy_seasonal: $('#exampleModal input[name="allergy_seasonal"]').is(':checked') ? 1 : 0,
        allergy_never: $('#exampleModal input[name="allergy_never"]').is(':checked') ? 1 : 0,

        // 建議內容
        toner_suggestion: $('#exampleModal input[name="toner_suggestion"]').val(),
        serum_suggestion: $('#exampleModal input[name="serum_suggestion"]').val(),
        suggestion_content: $('#exampleModal input[name="suggestion_content"]').val(),

        // 肌膚類型
        skin_type: $('#exampleModal input[name="skin_type"]:checked').val(),
        skin_age: $('#exampleModal input[name="skin_age"]').val()
      };

      // 收集肌膚評分資料（8個類別，每個類別3種評分類型）
      var skinCategories = ['moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore'];
      var scoreTypes = ['severe', 'warning', 'healthy'];

      skinCategories.forEach(function(category) {
        scoreTypes.forEach(function(scoreType) {
          var fieldName = category + '_' + scoreType;
          var scoreValue = $('#exampleModal input[name="' + fieldName + '"]').val();
          if (scoreValue && scoreValue.trim() !== '') {
            formData[fieldName] = scoreValue.trim();
          }
        });

        // 收集日期和數字資料（每個類別3組）
        for (var i = 0; i < 3; i++) {
          var dateField = category + '_date_' + i;
          var numberField = category + '_number_' + i;
          var dateValue = $('#exampleModal input[name="' + dateField + '"]').val();
          var numberValue = $('#exampleModal input[name="' + numberField + '"]').val();

          if (dateValue && dateValue.trim() !== '') {
            formData[dateField] = dateValue.trim();
          }
          if (numberValue && numberValue.trim() !== '') {
            formData[numberField] = numberValue.trim();
          }
        }
      });

      console.log('Collected form data with skin scores:', formData);

      // 獲取當前編輯的記錄ID (需要從全局變量或其他方式獲取)
      var submissionId = window.currentEditingSubmissionId || 1;

      // 發送更新請求
      $.ajax({
        url: '<?php echo base_url("api/eeform/eeform2/submission/"); ?>' + submissionId,
        method: 'POST', // 使用POST而非PUT
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          if (response && response.success) {
            // 使用SweetAlert顯示成功訊息
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: '更新成功！',
                text: '表單已成功更新',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                $('#exampleModal').modal('hide');
                // 重新載入表格數據
                loadSubmissions();
              });
            } else {
              alert('更新成功！');
              $('#exampleModal').modal('hide');
              loadSubmissions();
            }
          } else {
            showUpdateError('更新失敗: ' + (response.message || '未知錯誤'));
          }
        },
        error: function(xhr, status, error) {
          var errorMessage = '更新失敗';
          if (xhr.status === 404) {
            errorMessage = '找不到指定的記錄';
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
          showUpdateError(errorMessage);
        }
      });
    }

    // 顯示更新錯誤訊息
    function showUpdateError(message) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: '更新失敗',
          text: message,
          icon: 'error',
          confirmButtonText: '確定'
        });
      } else {
        alert('更新失敗: ' + message);
      }
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
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* 確保模態視窗背景不透明 */
    .modal-content {
      background-color: #ffffff !important;
      opacity: 1 !important;
    }

    .modal-body {
      background-color: #ffffff !important;
      opacity: 1 !important;
    }

    .card.bg-light {
      background-color: #f8f9fa !important;
      opacity: 1 !important;
    }

    .form-control-custom {
      background-color: #ffffff !important;
      opacity: 1 !important;
    }

    .alert-warning {
      background-color: #fff3cd !important;
      opacity: 1 !important;
    }

    /* Table empty state styles */
    #submissions-table-body td {
      vertical-align: middle;
    }

    /* Enhanced error state button */
    .retry-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Search form enhancements */
    #search {
      border-radius: 0.25rem;
      border: 2px solid #dee2e6;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    #search:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
  </style>

  <!-- Modal -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModal" aria-hidden="true" id="exampleModal">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="submissionModalTitle">會員服務追蹤管理表(肌膚)詳細資料</h5>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>