<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>電子表單1 - 管理後台</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .admin-container {
            padding: 2rem;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .filters-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table th {
            background-color: #17a2b8;
            color: white;
            font-weight: 600;
        }
        
        .table-actions .btn {
            margin: 0 2px;
        }
        
        .modal-xl {
            max-width: 90%;
        }
        
        .detail-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .detail-section h6 {
            color: #17a2b8;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 0.75rem;
        }
        
        .detail-label {
            font-weight: 600;
            width: 150px;
            color: #495057;
        }
        
        .detail-value {
            flex: 1;
            color: #212529;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-file-alt"></i> 電子表單1 管理後台</h2>
            <div class="header-buttons">
                <button class="btn btn-danger" id="delete-test-data-btn">
                    <i class="fas fa-trash"></i> 刪除測試資料
                </button>
            </div>
        </div>
        
        <!-- Filters Section -->
        <div class="filters-section">
            <h5 class="mb-3">搜尋篩選</h5>
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">會員編號</label>
                    <input type="text" class="form-control" id="filter-member-id" placeholder="輸入會員編號">
                </div>
                <div class="col-md-3">
                    <label class="form-label">會員姓名</label>
                    <input type="text" class="form-control" id="filter-member-name" placeholder="輸入會員姓名">
                </div>
                <div class="col-md-3">
                    <label class="form-label">開始日期</label>
                    <input type="date" class="form-control" id="filter-start-date">
                </div>
                <div class="col-md-3">
                    <label class="form-label">結束日期</label>
                    <input type="date" class="form-control" id="filter-end-date">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button class="btn btn-primary" id="apply-filters">
                        <i class="fas fa-search"></i> 搜尋
                    </button>
                    <button class="btn btn-secondary" id="reset-filters">
                        <i class="fas fa-undo"></i> 重置
                    </button>
                    <button class="btn btn-success float-end" id="refresh-data">
                        <i class="fas fa-sync"></i> 重新整理
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Table Section -->
        <div class="table-container">
            <h5 class="mb-3">提交記錄列表</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>會員編號</th>
                            <th>會員姓名</th>
                            <th>出生年月</th>
                            <th>代填者</th>
                            <th>提交時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="data-table-body">
                        <tr>
                            <td colspan="7" class="text-center">載入中...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center" id="pagination">
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">表單詳細資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-detail-content">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
        let currentPage = 1;
        const itemsPerPage = 20;
        
        // Load data function
        function loadData(page = 1) {
            currentPage = page;
            const filters = {
                member_id: $('#filter-member-id').val(),
                member_name: $('#filter-member-name').val(),
                start_date: $('#filter-start-date').val(),
                end_date: $('#filter-end-date').val()
            };
            
            $.ajax({
                url: '<?php echo base_url("api/eeform1/list"); ?>',
                method: 'GET',
                data: {
                    page: page,
                    limit: itemsPerPage,
                    ...filters
                },
                success: function(response) {
                    if (response.success) {
                        renderTable(response.data);
                        renderPagination(response.total, response.page, response.limit);
                    } else {
                        $('#data-table-body').html('<tr><td colspan="7" class="text-center text-danger">載入失敗</td></tr>');
                    }
                },
                error: function() {
                    $('#data-table-body').html('<tr><td colspan="7" class="text-center text-danger">載入失敗</td></tr>');
                }
            });
        }
        
        // Render table
        function renderTable(data) {
            if (!Array.isArray(data)) {
                $('#data-table-body').html('<tr><td colspan="7" class="text-center text-danger">資料格式錯誤</td></tr>');
                return;
            }
            
            if (data.length === 0) {
                $('#data-table-body').html('<tr><td colspan="7" class="text-center">無資料</td></tr>');
                return;
            }
            
            let html = '';
            data.forEach(function(item) {
                html += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.member_id || '-'}</td>
                        <td>${item.member_name || '-'}</td>
                        <td>${item.birth_date || '-'}</td>
                        <td>${item.form_filler_name || '-'}</td>
                        <td>${item.created_at || '-'}</td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-info view-detail" data-id="${item.id}" title="檢視">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-item" data-id="${item.id}" title="刪除">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#data-table-body').html(html);
        }
        
        // Render pagination
        function renderPagination(total, page, limit) {
            const totalPages = Math.ceil(total / limit);
            let html = '';
            
            // Previous button
            html += `<li class="page-item ${page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${page - 1}">上一頁</a>
                     </li>`;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= page - 2 && i <= page + 2)) {
                    html += `<li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                             </li>`;
                } else if (i === page - 3 || i === page + 3) {
                    html += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }
            
            // Next button
            html += `<li class="page-item ${page === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${page + 1}">下一頁</a>
                     </li>`;
            
            $('#pagination').html(html);
        }
        
        // View detail
        $(document).on('click', '.view-detail', function() {
            const id = $(this).data('id');
            
            $.ajax({
                url: '<?php echo base_url("api/eeform/eeform1/submission"); ?>/' + id,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderDetailModal(response.data);
                        $('#detailModal').modal('show');
                    } else {
                        Swal.fire('錯誤', '無法載入資料', 'error');
                    }
                },
                error: function() {
                    Swal.fire('錯誤', '無法載入資料', 'error');
                }
            });
        });
        
        // Render detail modal
        function renderDetailModal(data) {
            let html = '<div class="detail-section">';
            html += '<h6>基本資料</h6>';
            html += '<div class="detail-row"><span class="detail-label">會員編號：</span><span class="detail-value">' + (data.member_id || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="detail-label">會員姓名：</span><span class="detail-value">' + (data.member_name || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="detail-label">出生年月：</span><span class="detail-value">' + (data.birth_date || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="detail-label">身高：</span><span class="detail-value">' + (data.height || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="detail-label">年齡：</span><span class="detail-value">' + (data.age || '-') + '</span></div>';
            html += '</div>';
            
            // Skin scores section
            if (data.skin_scores) {
                html += '<div class="detail-section">';
                html += '<h6>肌膚評分</h6>';
                for (let key in data.skin_scores) {
                    html += '<div class="detail-row"><span class="detail-label">' + key + '：</span><span class="detail-value">' + (data.skin_scores[key] || '-') + '</span></div>';
                }
                html += '</div>';
            }
            
            html += '<div class="detail-section">';
            html += '<h6>系統資訊</h6>';
            html += '<div class="detail-row"><span class="detail-label">提交時間：</span><span class="detail-value">' + (data.created_at || '-') + '</span></div>';
            html += '<div class="detail-row"><span class="detail-label">更新時間：</span><span class="detail-value">' + (data.updated_at || '-') + '</span></div>';
            html += '</div>';
            
            $('#modal-detail-content').html(html);
        }
        
        // Delete item
        $(document).on('click', '.delete-item', function() {
            const id = $(this).data('id');
            
            Swal.fire({
                title: '確認刪除',
                text: '確定要刪除這筆資料嗎？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '確定刪除',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url("api/eeform/eeform1/delete"); ?>/' + id,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('成功', '資料已刪除', 'success');
                                loadData(currentPage);
                            } else {
                                Swal.fire('錯誤', '刪除失敗', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('錯誤', '刪除失敗', 'error');
                        }
                    });
                }
            });
        });
        
        // Apply filters
        $('#apply-filters').click(function() {
            loadData(1);
        });
        
        // Reset filters
        $('#reset-filters').click(function() {
            $('#filter-member-id').val('');
            $('#filter-member-name').val('');
            $('#filter-start-date').val('');
            $('#filter-end-date').val('');
            loadData(1);
        });
        
        // Refresh data
        $('#refresh-data').click(function() {
            loadData(currentPage);
        });
        
        // Delete all test data
        $('#delete-test-data-btn').click(function() {
            Swal.fire({
                title: '確認刪除',
                text: '您確定要刪除所有測試資料嗎？此操作無法復原！',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '確定刪除',
                cancelButtonText: '取消'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteBtn = $('#delete-test-data-btn');
                    const originalText = deleteBtn.html();
                    deleteBtn.html('<i class="fas fa-spinner fa-spin"></i> 刪除中...').prop('disabled', true);

                    $.ajax({
                        url: '<?php echo base_url("api/eeform/eeform1/delete_all_test_data"); ?>',
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('成功', '所有測試資料已成功刪除', 'success');
                                loadData(1);
                            } else {
                                Swal.fire('錯誤', '刪除失敗: ' + (response.message || '未知錯誤'), 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('錯誤', '刪除失敗，請稍後再試', 'error');
                        },
                        complete: function() {
                            deleteBtn.html(originalText).prop('disabled', false);
                        }
                    });
                }
            });
        });
        
        // Pagination click
        $(document).on('click', '#pagination a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page) {
                loadData(page);
            }
        });
        
        // Initial load
        loadData(1);
    });
    </script>
</body>
</html>