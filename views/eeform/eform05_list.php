<body class="theme-orange fixed-footer fixed-footer-lg">
  <div class="animsition">
    <div class="wrapper">
      <?= $this->block_service->load_html_header(); ?>


      <div class="section-mini">


        <div class="section-item text-left">
          <div class="container">
            <div class="row">
              <div class="col-md-9 mb130 mt-lg-5 wow fadeInUp" role="main" data-wow-delay=".2s">
                <h1 class="h2-3d font-libre"><strong>個人體測表+健康諮詢表</strong></h1>
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
                      <a href="<?php echo base_url('eform/eform5'); ?>" class="btn btn-outline-danger btn-block">填寫個人體測表+健康諮詢表</a>
                    </div>


                  </div>
                </div>

              </div>

              <!--<div class="col-lg-1 d-none d-xl-block"></div>-->

              <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                <!-- 側邊欄清單 -->
                <?= $this->block_service->electronic_form_right_menu('eform5'); ?>
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
        '<tr><td colspan="4" class="text-center text-muted p-4">' +
        '<div><i class="icon ion-loading-c" style="font-size: 2rem; animation: spin 1s linear infinite;"></i></div>' +
        '<div class="mt-2">載入中，請稍候...</div>' +
        '</td></tr>'
      );

      $.ajax({
        url: '<?php echo base_url("api/eeform/eeform5/submissions/"); ?>' + currentMemberId,
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
              '<tr><td colspan="4" class="text-center text-warning p-4">' +
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
        // var displayDate = submission.submission_date || submission.created_at || '-';
        var displayDate = submission.updated_at || submission.created_at || '-';
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
        tableRows += '<td nowrap="nowrap" class="text-center">' + (submission.member_name || '-') + '</td>';
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
        tableRows += '<ul class="list-inline text-left">';
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
        url: '<?php echo base_url("api/eeform/eeform5/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {
            console.log('=== EForm5 API Response Debug ===');
            console.log('Raw eform5 API response:', response.data);
            console.log('====================================');

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
        url: '<?php echo base_url("api/eeform/eeform5/submission/"); ?>' + submissionId,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response && response.success) {

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

    // 轉換eform5資料結構為平面結構
    function transformApiDataToFormStructure(apiData) {
      if (!apiData) return null;

      // eform5的資料結構（個人體測表+健康諮詢表）
      var formData = {
        id: apiData.id || null,
        member_id: apiData.member_id || null,
        member_name: apiData.member_name || '',
        phone: apiData.phone || '',
        gender: apiData.gender || '',
        age: apiData.age || '',
        height: apiData.height || '',
        exercise_habit: apiData.exercise_habit || '',
        
        // 體測標準建議值
        weight: apiData.weight || '',
        bmi: apiData.bmi || '',
        fat_percentage: apiData.fat_percentage || '',
        fat_mass: apiData.fat_mass || '',
        muscle_percentage: apiData.muscle_percentage || '',
        muscle_mass: apiData.muscle_mass || '',
        water_percentage: apiData.water_percentage || '',
        water_content: apiData.water_content || '',
        visceral_fat_percentage: apiData.visceral_fat_percentage || '',
        bone_mass: apiData.bone_mass || '',
        bmr: apiData.bmr || '',
        protein_percentage: apiData.protein_percentage || '',
        obesity_percentage: apiData.obesity_percentage || '',
        body_age: apiData.body_age || '',
        lean_body_mass: apiData.lean_body_mass || '',
        
        // 其他表單欄位
        has_medication_habit: apiData.has_medication_habit || '',
        medication_name: apiData.medication_name || '',
        has_family_disease_history: apiData.has_family_disease_history || '',
        disease_name: apiData.disease_name || '',
        microcirculation_test: apiData.microcirculation_test || '',
        dietary_advice: apiData.dietary_advice || '',
        health_concerns_other: apiData.health_concerns_other || '',
        
        // 職業和健康困擾陣列資料
        occupations: apiData.occupations || [],
        health_concerns: apiData.health_concerns || [],
        products: apiData.products || [],
        
        // 系統欄位
        submission_date: apiData.submission_date || '',
        created_at: apiData.created_at || '',
        updated_at: apiData.updated_at || ''
      };

      console.log('Raw eform5 fields from API:', {
        member_name: apiData.member_name,
        phone: apiData.phone,
        gender: apiData.gender,
        age: apiData.age,
        height: apiData.height,
        exercise_habit: apiData.exercise_habit,
        occupations: apiData.occupations,
        health_concerns: apiData.health_concerns,
        products: apiData.products
      });

      console.log('Transformed form data:', formData);
      return formData;
    }

    // 顯示eform5表單內容
    function displayOriginalFormContent(data, isEditable) {
      if (!data) {
        showFormError('無效的資料格式');
        return;
      }

      console.log('Displaying eform5 form with transformed data:', data);

      var disabled = isEditable ? '' : ' disabled readonly';
      var currentDate = new Date().toISOString().slice(0, 10);

      // 建構eform5表單內容（個人體測表+健康諮詢表）
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
            String(date.getDate()).padStart(2, '0') + ' ' +
            String(date.getHours()).padStart(2, '0') + ':' +
            String(date.getMinutes()).padStart(2, '0');
        } catch (e) {
          displayDate = currentDate;
        }
      }
      html += '<div class="col-sm-12 text-right mb30">填寫日期：' + displayDate + '</div>';

      // 第一排欄位
      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">手機號碼</label>';
      html += '<input type="tel" name="phone" class="form-control form-control-custom" placeholder="請填手機號碼" value="' + (data.phone || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">姓名</label>';
      html += '<input type="text" name="member_name" class="form-control form-control-custom" placeholder="請填姓名" value="' + (data.name || data.member_name || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">性別</label>';
      html += '<select name="gender" class="form-control form-control-custom"' + disabled + '>';
      html += '<option value="">請選擇性別</option>';
      html += '<option value="男"' + ((data.gender === '男') ? ' selected' : '') + '>男</option>';
      html += '<option value="女"' + ((data.gender === '女') ? ' selected' : '') + '>女</option>';
      html += '</select>';
      html += '</div>';

      // 第二排欄位
      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">年齡</label>';
      html += '<select name="age" class="form-control form-control-custom"' + disabled + '>';
      html += '<option value="">請選擇年齡</option>';
      
      // 生成年齡選項 (18-100歲)
      var currentYear = new Date().getFullYear();
      for (var age = 18; age <= 100; age++) {
        var mingguoYear = currentYear - 1911 - age;
        var selected = (data.age == age) ? ' selected' : '';
        html += '<option value="' + age + '"' + selected + '>民國' + mingguoYear + '年出生 - ' + age + '歲</option>';
      }
      
      html += '</select>';
      html += '</div>';

      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">身高</label>';
      html += '<input type="text" name="height" class="form-control form-control-custom" placeholder="請填身高" value="' + (data.height || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-4 mb30">';
      html += '<label class="label-custom">運動習慣</label>';
      html += '<select name="exercise_habit" class="form-control form-control-custom"' + disabled + '>';
      html += '<option value="">請選擇運動習慣</option>';
      html += '<option value="是"' + ((data.exercise_habit === '是') ? ' selected' : '') + '>是</option>';
      html += '<option value="否"' + ((data.exercise_habit === '否') ? ' selected' : '') + '>否</option>';
      html += '</select>';
      html += '</div>';

      // 體測標準建議值
      html += '<div class="col-sm-12 mb30">';
      html += '<h5>體測標準建議值</h5>';
      html += '<div class="card bg-light" style="border: 1px solid #ccc;">';
      html += '<div class="card-body">';
      html += '<div class="row">';

      // 體測欄位（每三個一列）
      var bodyTestFields = [
        {name: 'weight', label: '體重Kg'},
        {name: 'bmi', label: 'BMI'},
        {name: 'fat_percentage', label: '脂肪率%'},
        {name: 'fat_mass', label: '脂肪量Kg'},
        {name: 'muscle_percentage', label: '肌肉%'},
        {name: 'muscle_mass', label: '肌肉量Kg'},
        {name: 'water_percentage', label: '水份比例%'},
        {name: 'water_content', label: '水含量Kg'},
        {name: 'visceral_fat_percentage', label: '內臟脂肪率%'},
        {name: 'bone_mass', label: '骨量Kg'},
        {name: 'bmr', label: '基礎代謝率(卡)'},
        {name: 'protein_percentage', label: '蛋白質%'},
        {name: 'obesity_percentage', label: '肥胖度%'},
        {name: 'body_age', label: '身體年齡'},
        {name: 'lean_body_mass', label: '去脂體重KG'}
      ];

      bodyTestFields.forEach(function(field, index) {
        html += '<div class="col-sm-4 mb20">';
        html += '<label class="label-custom">' + field.label + '</label>';
        html += '<input type="text" name="' + field.name + '" class="form-control form-control-custom" placeholder="限填數字" value="' + (data[field.name] || '') + '"' + disabled + ' />';
        html += '</div>';
      });

      html += '</div>';
      html += '</div>';
      html += '</div>';
      html += '</div>';

      // 職業資料（陣列）
      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">職業</label>';
      if (data.occupations && data.occupations.length > 0) {
        var occupationList = data.occupations.map(function(occ) {
          return occ.occupation_type || occ;
        }).join(', ');
        html += '<input type="text" name="occupations_display" class="form-control form-control-custom" value="' + occupationList + '"' + disabled + ' />';
      } else {
        html += '<input type="text" name="occupations_display" class="form-control form-control-custom" placeholder="無" value=""' + disabled + ' />';
      }
      html += '</div>';

      // 健康困擾資料（陣列）
      html += '<div class="col-sm-12 mb30">';
      html += '<label class="label-custom">健康困擾</label>';
      if (data.health_concerns && data.health_concerns.length > 0) {
        var healthList = data.health_concerns.map(function(concern) {
          return concern.concern_type || concern;
        }).join(', ');
        html += '<input type="text" name="health_concerns_display" class="form-control form-control-custom" value="' + healthList + '"' + disabled + ' />';
      } else {
        html += '<input type="text" name="health_concerns_display" class="form-control form-control-custom" placeholder="無" value=""' + disabled + ' />';
      }
      html += '</div>';

      // 其他健康資訊
      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">其他健康困擾</label>';
      html += '<input type="text" name="health_concerns_other" class="form-control form-control-custom" value="' + (data.health_concerns_other || '') + '"' + disabled + ' />';
      html += '</div>';

      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">是否有服藥習慣</label>';
      if (isEditable) {
        html += '<select name="has_medication_habit" class="form-control form-control-custom"' + disabled + '>';
        html += '<option value="">請選擇</option>';
        html += '<option value="1"' + ((data.has_medication_habit == 1) ? ' selected' : '') + '>是</option>';
        html += '<option value="0"' + ((data.has_medication_habit == 0) ? ' selected' : '') + '>否</option>';
        html += '</select>';
      } else {
        var medicationText = data.has_medication_habit == 1 ? '是' : (data.has_medication_habit == 0 ? '否' : '');
        html += '<input type="text" name="has_medication_habit" class="form-control form-control-custom" value="' + medicationText + '"' + disabled + ' />';
      }
      html += '</div>';

      if (data.has_medication_habit == 1 && data.medication_name) {
        html += '<div class="col-sm-6 mb30">';
        html += '<label class="label-custom">藥物名稱</label>';
        html += '<input type="text" name="medication_name" class="form-control form-control-custom" value="' + (data.medication_name || '') + '"' + disabled + ' />';
        html += '</div>';
      }

      html += '<div class="col-sm-6 mb30">';
      html += '<label class="label-custom">是否有家族病史</label>';
      if (isEditable) {
        html += '<select name="has_family_disease_history" class="form-control form-control-custom"' + disabled + '>';
        html += '<option value="">請選擇</option>';
        html += '<option value="1"' + ((data.has_family_disease_history == 1) ? ' selected' : '') + '>是</option>';
        html += '<option value="0"' + ((data.has_family_disease_history == 0) ? ' selected' : '') + '>否</option>';
        html += '</select>';
      } else {
        var familyHistoryText = data.has_family_disease_history == 1 ? '是' : (data.has_family_disease_history == 0 ? '否' : '');
        html += '<input type="text" name="has_family_disease_history" class="form-control form-control-custom" value="' + familyHistoryText + '"' + disabled + ' />';
      }
      html += '</div>';

      if (data.has_family_disease_history == 1 && data.disease_name) {
        html += '<div class="col-sm-6 mb30">';
        html += '<label class="label-custom">病名</label>';
        html += '<input type="text" name="disease_name" class="form-control form-control-custom" value="' + (data.disease_name || '') + '"' + disabled + ' />';
        html += '</div>';
      }

      // 微循環檢測和飲食建議
      if (data.microcirculation_test) {
        html += '<div class="col-sm-12 mb30">';
        html += '<label class="label-custom">微循環檢測</label>';
        html += '<textarea name="microcirculation_test" class="form-control form-control-custom" rows="3"' + disabled + '>' + (data.microcirculation_test || '') + '</textarea>';
        html += '</div>';
      }

      if (data.dietary_advice) {
        html += '<div class="col-sm-12 mb30">';
        html += '<label class="label-custom">飲食建議</label>';
        html += '<textarea name="dietary_advice" class="form-control form-control-custom" rows="3"' + disabled + '>' + (data.dietary_advice || '') + '</textarea>';
        html += '</div>';
      }

      // 建議產品資料（陣列）
      if (data.products && data.products.length > 0) {
        html += '<div class="col-sm-12 mb30">';
        html += '<label class="label-custom">建議產品</label>';
        html += '<div class="card bg-light" style="border: 1px solid #ccc;">';
        html += '<div class="card-body">';
        data.products.forEach(function(product) {
          html += '<div class="mb-2">';
          html += '<strong>' + (product.product_name || '') + '</strong>';
          if (product.recommended_dosage) {
            html += ' - 用量: ' + product.recommended_dosage;
          }
          html += '</div>';
        });
        html += '</div>';
        html += '</div>';
        html += '</div>';
      }

      html += '</div>';

      // 代填者資訊 - 已隱藏
      // 編輯模式的更新按鈕
      if (isEditable) {
        html += '<div class="col-sm-12 mb30">';
        html += '<hr class="my-4">';
        html += '<button type="button" class="btn btn-outline-danger btn-block" onclick="updateEform5Data()">更新表單</button>';
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

    // 更新eform5表單資料
    function updateEform5Data() {
      // 收集eform5表單數據
      var formData = {
        // 基本資料
        member_name: $('#exampleModal input[name="member_name"]').val(),
        phone: $('#exampleModal input[name="phone"]').val(),
        gender: $('#exampleModal select[name="gender"]').val(),
        age: $('#exampleModal select[name="age"]').val(),
        height: $('#exampleModal input[name="height"]').val(),
        exercise_habit: $('#exampleModal select[name="exercise_habit"]').val(),
        
        // 體測数据
        weight: $('#exampleModal input[name="weight"]').val(),
        bmi: $('#exampleModal input[name="bmi"]').val(),
        fat_percentage: $('#exampleModal input[name="fat_percentage"]').val(),
        fat_mass: $('#exampleModal input[name="fat_mass"]').val(),
        muscle_percentage: $('#exampleModal input[name="muscle_percentage"]').val(),
        muscle_mass: $('#exampleModal input[name="muscle_mass"]').val(),
        water_percentage: $('#exampleModal input[name="water_percentage"]').val(),
        water_content: $('#exampleModal input[name="water_content"]').val(),
        visceral_fat_percentage: $('#exampleModal input[name="visceral_fat_percentage"]').val(),
        bone_mass: $('#exampleModal input[name="bone_mass"]').val(),
        bmr: $('#exampleModal input[name="bmr"]').val(),
        protein_percentage: $('#exampleModal input[name="protein_percentage"]').val(),
        obesity_percentage: $('#exampleModal input[name="obesity_percentage"]').val(),
        body_age: $('#exampleModal input[name="body_age"]').val(),
        lean_body_mass: $('#exampleModal input[name="lean_body_mass"]').val(),
        
        // 其他健康資訊
        health_concerns_other: $('#exampleModal input[name="health_concerns_other"]').val(),
        has_medication_habit: $('#exampleModal select[name="has_medication_habit"]').val() || $('#exampleModal input[name="has_medication_habit"]').val(),
        medication_name: $('#exampleModal input[name="medication_name"]').val(),
        has_family_disease_history: $('#exampleModal select[name="has_family_disease_history"]').val() || $('#exampleModal input[name="has_family_disease_history"]').val(),
        disease_name: $('#exampleModal input[name="disease_name"]').val(),
        microcirculation_test: $('#exampleModal textarea[name="microcirculation_test"]').val(),
        dietary_advice: $('#exampleModal textarea[name="dietary_advice"]').val(),
        
        submission_date: new Date().toISOString().split('T')[0]
      };

      console.log('Collected eform5 data:', formData);

      // 獲取當前編輯的記錄ID
      var submissionId = window.currentEditingSubmissionId || 1;

      // 發送更新請求
      $.ajax({
        url: '<?php echo base_url("api/eeform/eeform5/submission/"); ?>' + submissionId,
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
    function showFormError(message) {
      $('#exampleModal .modal-body').html(
        '<div class="text-center p-4">' +
        '<i class="icon ion-alert-circled" style="font-size: 2rem; color: #dc3545;"></i>' +
        '<div class="mt-2 text-danger">' + message + '</div>' +
        '<div class="mt-3"><button class="btn btn-sm btn-outline-primary" onclick="$(\'#exampleModal\').modal(\'hide\');">關閉</button></div>' +
        '</div>'
      );
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