<style>
    /* EForm2 Admin Styles */
    .eform2-admin {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    
    .dashboard-card {
        border-left: 4px solid #007bff !important;
        transition: transform 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border-radius: 8px !important;
    }
    
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .status-badge {
        font-size: 0.75rem !important;
        padding: 0.25rem 0.5rem !important;
        border-radius: 4px !important;
        font-weight: 500;
    }
    
    .table-actions {
        white-space: nowrap;
        min-width: 120px;
    }
    
    .table-actions .btn {
        margin: 0 2px;
        padding: 0.25rem 0.5rem;
    }
    
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .filters-section {
        background-color: #f8f9fa !important;
        border-radius: 8px !important;
        padding: 1.5rem !important;
        margin-bottom: 1.5rem !important;
        border: 1px solid #e9ecef;
    }
    
    .filters-section .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .card {
        border-radius: 8px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    }
    
    .card-header {
        background-color: #fff !important;
        border-bottom: 1px solid #e9ecef !important;
        font-weight: 600;
        padding: 1rem 1.25rem;
    }
    
    .table th {
        background-color: #f8f9fa !important;
        border-top: none !important;
        font-weight: 600;
        color: #495057;
        font-size: 0.875rem;
        padding: 0.75rem;
    }
    
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,0.02) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05) !important;
    }
    
    .pagination .page-link {
        color: #007bff;
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        border-radius: 4px !important;
    }
    
    .modal-content {
        border-radius: 8px !important;
        border: none !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef !important;
        padding: 1rem 1.25rem;
    }
    
    .modal-body {
        padding: 1.25rem;
    }
    
    .alert {
        border-radius: 6px !important;
        border: none !important;
        font-weight: 500;
    }
    
    .spinner-border {
        color: #007bff !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-card {
            margin-bottom: 1rem;
        }
        
        .table-actions .btn {
            padding: 0.25rem;
            margin: 0 1px;
        }
        
        .table-actions .btn i {
            font-size: 0.75rem;
        }
        
        .filters-section .row > div {
            margin-bottom: 1rem;
        }
    }
    
    /* Fix any potential conflicts with admin template */
    .eform2-admin .form-control {
        display: block !important;
        width: 100% !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        font-weight: 400 !important;
        line-height: 1.5 !important;
        color: #495057 !important;
        background-color: #fff !important;
        background-image: none !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }
    
    .eform2-admin .form-control:focus {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #80bdff !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
</style>
    <div class="container-fluid py-4 eform2-admin">
        <div class="row mb-4">
            <div class="col-12">
                <h2><i class="fas fa-clipboard-list"></i> EForm2 管理系統</h2>
                <p class="text-muted">管理電子表單提交記錄</p>
            </div>
        </div>

        <!-- 統計儀表板 -->
        <div class="row mb-4" id="stats-dashboard">
            <div class="col-md-3">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">總提交數</h6>
                                <h3 id="stat-total" class="mb-0">-</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" style="border-left-color: #28a745;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">已完成</h6>
                                <h3 id="stat-completed" class="mb-0">-</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" style="border-left-color: #ffc107;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">處理中</h6>
                                <h3 id="stat-processing" class="mb-0">-</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card" style="border-left-color: #6c757d;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">今日提交</h6>
                                <h3 id="stat-today" class="mb-0">-</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-day fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 篩選器 -->
        <div class="filters-section">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">搜尋</label>
                    <input type="text" class="form-control" id="search-input" placeholder="會員姓名、聯絡方式">
                </div>
                <div class="col-md-2">
                    <label class="form-label">狀態</label>
                    <select class="form-control" id="status-filter">
                        <option value="">全部</option>
                        <option value="submitted">已提交</option>
                        <option value="processing">處理中</option>
                        <option value="completed">已完成</option>
                        <option value="cancelled">已取消</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">開始日期</label>
                    <input type="date" class="form-control" id="start-date">
                </div>
                <div class="col-md-2">
                    <label class="form-label">結束日期</label>
                    <input type="date" class="form-control" id="end-date">
                </div>
                <div class="col-md-2">
                    <label class="form-label">每頁筆數</label>
                    <select class="form-control" id="per-page">
                        <option value="10">10</option>
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-primary" id="apply-filters">
                        <i class="fas fa-search"></i> 搜尋
                    </button>
                </div>
            </div>
        </div>

        <!-- 資料表 -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">提交記錄列表</h5>
                <button class="btn btn-success btn-sm" id="refresh-data">
                    <i class="fas fa-sync-alt"></i> 重新整理
                </button>
            </div>
            <div class="card-body">
                <div id="loading-indicator" class="text-center py-3" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">載入中...</span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>會員姓名</th>
                                <th>性別</th>
                                <th>年齡</th>
                                <th>加入日期</th>
                                <th>預約見面日</th>
                                <th>聯絡方式</th>
                                <th>狀態</th>
                                <th>提交日期</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- 動態載入資料 -->
                        </tbody>
                    </table>
                </div>

                <!-- 分頁 -->
                <nav aria-label="分頁導覽">
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- 動態生成分頁 -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- 詳細資料模態框 -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">提交詳細資料</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detail-content">
                    <!-- 動態載入詳細資料 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 狀態更新模態框 -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">更新狀態</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="status-form">
                        <input type="hidden" id="status-submission-id">
                        <div class="mb-3">
                            <label class="form-label">新狀態</label>
                            <select class="form-control" id="new-status" required>
                                <option value="submitted">已提交</option>
                                <option value="processing">處理中</option>
                                <option value="completed">已完成</option>
                                <option value="cancelled">已取消</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">管理員備註</label>
                            <textarea class="form-control" id="admin-note" rows="3" placeholder="選填"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="save-status">儲存</button>
                </div>
            </div>
        </div>
    </div>

<script>
    class EForm2Admin {
        constructor() {
            this.currentPage = 1;
            this.perPage = 20;
            this.filters = {};
            this.init();
        }

        init() {
            this.loadStats();
            this.loadData();
            this.bindEvents();
        }

        bindEvents() {
            // 篩選器事件
            $('#apply-filters').on('click', () => this.applyFilters());
            $('#search-input').on('keypress', (e) => {
                if (e.which === 13) this.applyFilters();
            });
            
            // 重新整理
            $('#refresh-data').on('click', () => {
                this.loadStats();
                this.loadData();
            });

            // 狀態更新
            $('#save-status').on('click', () => this.updateStatus());

            // 每頁筆數變更
            $('#per-page').on('change', () => {
                this.perPage = parseInt($('#per-page').val());
                this.currentPage = 1;
                this.loadData();
            });
        }

        async loadStats() {
            try {
                const response = await fetch('/api/eeform/eeform2/stats');
                const result = await response.json();
                
                if (result.success) {
                    const stats = result.data;
                    $('#stat-total').text(stats.total || 0);
                    $('#stat-completed').text(stats.completed || 0);
                    $('#stat-processing').text(stats.processing || 0);
                    $('#stat-today').text(stats.today || 0);
                }
            } catch (error) {
                console.error('載入統計資料失敗:', error);
            }
        }

        async loadData() {
            $('#loading-indicator').show();
            
            try {
                const params = new URLSearchParams({
                    page: this.currentPage,
                    limit: this.perPage,
                    ...this.filters
                });

                const response = await fetch(`/api/eeform/eeform2/list?${params}`);
                const result = await response.json();
                
                if (result.success) {
                    this.renderTable(result.data.data);
                    this.renderPagination(result.data.pagination);
                } else {
                    this.showAlert('載入資料失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('載入資料失敗:', error);
                this.showAlert('載入資料失敗，請稍後再試', 'danger');
            } finally {
                $('#loading-indicator').hide();
            }
        }

        renderTable(data) {
            const tbody = $('#data-table-body');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.append('<tr><td colspan="10" class="text-center">無資料</td></tr>');
                return;
            }

            data.forEach(item => {
                const statusBadge = this.getStatusBadge(item.status);
                const row = `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.member_name}</td>
                        <td>${item.gender}</td>
                        <td>${item.age}</td>
                        <td>${item.join_date}</td>
                        <td>${item.meeting_date || '-'}</td>
                        <td>
                            ${item.line_contact ? `LINE: ${item.line_contact}<br>` : ''}
                            ${item.tel_contact ? `TEL: ${item.tel_contact}` : ''}
                        </td>
                        <td>${statusBadge}</td>
                        <td>${item.submission_date}</td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-info" onclick="admin.viewDetail(${item.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="admin.showStatusModal(${item.id}, '${item.status}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="admin.deleteSubmission(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        renderPagination(pagination) {
            const paginationEl = $('#pagination');
            paginationEl.empty();

            if (pagination.total_pages <= 1) return;

            // 上一頁
            const prevDisabled = pagination.current_page === 1 ? 'disabled' : '';
            paginationEl.append(`
                <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="#" onclick="admin.changePage(${pagination.current_page - 1})">上一頁</a>
                </li>
            `);

            // 頁碼
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

            for (let i = startPage; i <= endPage; i++) {
                const active = i === pagination.current_page ? 'active' : '';
                paginationEl.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" onclick="admin.changePage(${i})">${i}</a>
                    </li>
                `);
            }

            // 下一頁
            const nextDisabled = pagination.current_page === pagination.total_pages ? 'disabled' : '';
            paginationEl.append(`
                <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="#" onclick="admin.changePage(${pagination.current_page + 1})">下一頁</a>
                </li>
            `);
        }

        getStatusBadge(status) {
            const statusMap = {
                'submitted': { class: 'bg-primary', text: '已提交' },
                'processing': { class: 'bg-warning', text: '處理中' },
                'completed': { class: 'bg-success', text: '已完成' },
                'cancelled': { class: 'bg-secondary', text: '已取消' }
            };
            
            const statusInfo = statusMap[status] || { class: 'bg-secondary', text: status };
            return `<span class="badge ${statusInfo.class} status-badge">${statusInfo.text}</span>`;
        }

        applyFilters() {
            this.filters = {
                search: $('#search-input').val(),
                status: $('#status-filter').val(),
                start_date: $('#start-date').val(),
                end_date: $('#end-date').val()
            };
            
            // 移除空值
            Object.keys(this.filters).forEach(key => {
                if (!this.filters[key]) delete this.filters[key];
            });

            this.currentPage = 1;
            this.loadData();
        }

        changePage(page) {
            if (page < 1) return;
            this.currentPage = page;
            this.loadData();
        }

        async viewDetail(id) {
            try {
                const response = await fetch(`/api/eeform/eeform2/submission/${id}`);
                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    const content = `
                        <div class="row">
                            <div class="col-md-6">
                                <h6>基本資料</h6>
                                <p><strong>ID:</strong> ${data.id}</p>
                                <p><strong>會員姓名:</strong> ${data.member_name}</p>
                                <p><strong>性別:</strong> ${data.gender}</p>
                                <p><strong>年齡:</strong> ${data.age}</p>
                                <p><strong>加入日期:</strong> ${data.join_date}</p>
                                <p><strong>預約見面日:</strong> ${data.meeting_date || '未預約'}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>聯絡資料</h6>
                                <p><strong>LINE:</strong> ${data.line_contact || '未提供'}</p>
                                <p><strong>電話:</strong> ${data.tel_contact || '未提供'}</p>
                                <p><strong>肌膚狀況:</strong> ${data.skin_health_condition || '未填寫'}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>系統資料</h6>
                                <p><strong>狀態:</strong> ${this.getStatusBadge(data.status)}</p>
                                <p><strong>提交日期:</strong> ${data.submission_date}</p>
                                <p><strong>建立時間:</strong> ${data.created_at}</p>
                                ${data.admin_note ? `<p><strong>管理員備註:</strong> ${data.admin_note}</p>` : ''}
                            </div>
                        </div>
                    `;
                    
                    $('#detail-content').html(content);
                    new bootstrap.Modal($('#detailModal')[0]).show();
                } else {
                    this.showAlert('載入詳細資料失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('載入詳細資料失敗:', error);
                this.showAlert('載入詳細資料失敗，請稍後再試', 'danger');
            }
        }

        showStatusModal(id, currentStatus) {
            $('#status-submission-id').val(id);
            $('#new-status').val(currentStatus);
            $('#admin-note').val('');
            new bootstrap.Modal($('#statusModal')[0]).show();
        }

        async updateStatus() {
            const id = $('#status-submission-id').val();
            const status = $('#new-status').val();
            const adminNote = $('#admin-note').val();

            if (!status) {
                this.showAlert('請選擇狀態', 'warning');
                return;
            }

            try {
                const response = await fetch(`/api/eeform/eeform2/update_status/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status,
                        admin_note: adminNote
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    bootstrap.Modal.getInstance($('#statusModal')[0]).hide();
                    this.showAlert('狀態更新成功', 'success');
                    this.loadData();
                    this.loadStats();
                } else {
                    this.showAlert('更新失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('更新狀態失敗:', error);
                this.showAlert('更新狀態失敗，請稍後再試', 'danger');
            }
        }

        async deleteSubmission(id) {
            if (!confirm('確定要刪除此記錄嗎？此操作無法復原。')) {
                return;
            }

            try {
                const response = await fetch(`/api/eeform/eeform2/delete/${id}`, {
                    method: 'DELETE'
                });

                const result = await response.json();
                
                if (result.success) {
                    this.showAlert('刪除成功', 'success');
                    this.loadData();
                    this.loadStats();
                } else {
                    this.showAlert('刪除失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('刪除失敗:', error);
                this.showAlert('刪除失敗，請稍後再試', 'danger');
            }
        }

        showAlert(message, type) {
            // 移除現有警告
            $('.alert').remove();
            
            const alert = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            $('body').prepend(alert);
            
            // 3秒後自動消失
            setTimeout(() => {
                $('.alert').alert('close');
            }, 3000);
        }
    }

    // 頁面載入完成後初始化
    $(document).ready(function() {
        const admin = new EForm2Admin();
        window.admin = admin; // 設為全域變數供按鈕使用
    });
</script>