<!-- Sweet Alert 2 CDN needed in the head section -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    /* EForm5 Admin Styles */
    .eform5-admin {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        padding: 2rem !important;
    }
    
    .dashboard-card {
        border-left: 4px solid #6f42c1 !important;
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
        background-color: rgba(111,66,193,0.05) !important;
    }
    
    .pagination .page-link {
        color: #6f42c1;
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        border-radius: 4px !important;
    }
    
    .btn-outline-primary {
        color: #6f42c1;
        border-color: #6f42c1;
    }
    
    .btn-outline-primary:hover {
        background-color: #6f42c1;
        border-color: #6f42c1;
    }
    
    .search-section {
        display: flex;
        align-items: end;
        gap: 10px;
    }
    
    .search-section .form-group {
        margin-bottom: 0;
        flex: 1;
    }
    
    .search-section .btn {
        flex-shrink: 0;
    }
    
    /* Make modals extra wide - matching form2 */
    #detailModal .modal-dialog,
    #productModal .modal-dialog {
        max-width: 1800px !important;
        margin: 1.75rem auto;
        width: 95vw;
    }
    
    .modal-xl {
        max-width: 90% !important;
        width: 90% !important;
    }
    
    .modal-content {
        border-radius: 8px !important;
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef !important;
        padding: 1rem 1.25rem;
        background-color: #f8f9fa !important;
    }
    
    .modal-body {
        padding: 1.25rem;
    }
    
    /* View Detail Modal Specific Styling - matching form2 */
    #detailModal .modal-body {
        padding: 2rem !important;
        background-color: #f8f9fa;
    }
    
    #detailModal .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    #detailModal .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #detailModal .modal-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    #detailModal .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    #detailModal .border {
        border-color: #e9ecef !important;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    #detailModal .form-group label {
        font-size: 1rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    #detailModal .form-group > div {
        font-size: 0.95rem;
        line-height: 1.5;
        min-height: 1.5em;
    }
    
    #detailModal .bg-light {
        background-color: #f8f9fa !important;
    }
    
    /* Improve section headers */
    #detailModal .border .bg-light h6 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Consistent input-style formatting for all modal content */
    #detailModal .form-group > div {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 0.75rem 1rem !important;
        min-height: 38px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    
    #detailModal .form-group > div:hover {
        background-color: #e9ecef;
    }
    
    /* Special styling for product quantities */
    #detailModal .form-group strong {
        color: #6f42c1;
        font-size: 1.1rem;
    }
    
    /* Modal header enhancement */
    #detailModal .modal-header {
        background-color: #fff;
        color: #495057;
        border-bottom: 1px solid #e9ecef;
        border-radius: 8px 8px 0 0;
    }
    
    #detailModal .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        color: #495057;
    }
    
    /* Section borders */
    #detailModal .border {
        border: 2px solid #e9ecef !important;
        border-radius: 10px !important;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }
    
    #detailModal .border:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef !important;
        padding: 1rem 1.5rem !important;
    }
    
    /* Responsive adjustments - matching form2 */
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
    
    #searchBtn {
        margin-top: 8px;
    }
    
    /* Search button enhancement - matching form2 style with purple theme */
    #apply-filters {
        height: calc(1.5em + 0.75rem + 2px);
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(111,66,193,0.3);
        transition: all 0.2s ease;
    }
    
    #apply-filters:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(111,66,193,0.4);
    }
    
    .table th,
    .table td {
        font-size: 1rem !important;
        line-height: 1.6 !important;
    }
    
    .table th {
        font-weight: 600 !important;
    }
    
    /* Form spacing improvements - matching form2 */
    .filters-section {
        margin-bottom: 2rem !important;
    }
    
    .filters-section .row > div {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    /* Fix any potential conflicts with admin template - matching form2 */
    .eform5-admin .form-control {
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
    
    .eform5-admin .form-control:focus {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #a56cc1 !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25) !important;
    }
    
    /* Button hover effects - darker colors */
    .btn-primary:hover {
        background-color: #0056b3 !important;
        border-color: #004085 !important;
    }
    
    .btn-success:hover {
        background-color: #1e7e34 !important;
        border-color: #1c7430 !important;
    }
    
    .btn-info:hover {
        background-color: #138496 !important;
        border-color: #117a8b !important;
    }
    
    .btn-secondary:hover {
        background-color: #545b62 !important;
        border-color: #4e555b !important;
    }
    
    .btn-danger:hover {
        background-color: #bd2130 !important;
        border-color: #b21f2d !important;
    }
    
    .btn-outline-primary:hover {
        background-color: #5a32a3 !important;
        border-color: #4e2a8e !important;
        color: #fff !important;
    }
    
    /* Custom margin-bottom for better block spacing - matching form2 */
    .mb-6 {
        margin-bottom: 3rem !important;
    }
    
    /* Make blocks wider and add more padding */
    #detailModal .border {
        margin: 0 -1rem 3rem -1rem !important;
        border-radius: 12px !important;
    }
    
    /* Add inner padding to border mb-6 rounded elements in modal */
    #detailModal .border.mb-6.rounded {
        padding: 2rem !important;
    }
    
    /* Adjust content padding inside border elements to avoid double padding */
    #detailModal .border.mb-6.rounded .p-5 {
        padding: 0 !important;
    }
    
    /* Adjust header padding to match the new structure */
    #detailModal .border.mb-6.rounded .bg-light {
        margin: -2rem -2rem 1.5rem -2rem !important;
        padding: 1rem 2rem !important;
    }
    
    #detailModal .container-fluid {
        padding: 0 2rem !important;
    }
    
    .alert {
        border-radius: 6px !important;
        border: none !important;
        font-weight: 500;
    }
    
    .spinner-border {
        color: #6f42c1 !important;
    }
</style>

<div class="eform5-admin">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2>個人體測表+健康諮詢表管理</h2>
        </div>
    </div>

    <!-- 篩選器 -->
    <div class="filters-section">
        <div class="row d-flex align-items-end">
            <div class="col-md-3">
                <label class="form-label">搜尋</label>
                <input type="text" class="form-control" id="search-input" placeholder="會員姓名、藥物、疾病">
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
            <div class="col-md-2">
                <button class="btn btn-primary w-100" id="apply-filters" style="margin-top: 25px; background-color: #6f42c1; border-color: #6f42c1;">
                    <i class="lnr lnr-magnifier"></i> 搜尋
                </button>
            </div>
        </div>
    </div>

    <!-- 資料表 -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">提交記錄列表</h5>
            <button class="btn btn-success btn-sm" id="refresh-data">
                <i class="lnr lnr-sync"></i> 重新整理
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
                            <th style="display: none;">ID</th>
                            <th>會員姓名</th>
                            <th>出生年月</th>
                            <th>身高</th>
                            <th>用藥習慣</th>
                            <th>家族病史</th>
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

<!-- 檢視詳細資料的 Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">表單詳細資料</h5>
            </div>
            <div class="modal-body submission-detail" id="detailContent">
                <!-- 詳細資料內容會在這裡動態載入 -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="admin.closeDetailModal()">關閉</button>
            </div>
        </div>
    </div>
</div>

<script>
    // 全域變數
    const admin = {
        currentPage: 1,
        pageSize: 20,
        totalRecords: 0,
        apiBaseUrl: '/api/eeform/eeform5'
    };

    // 頁面載入完成後初始化
    document.addEventListener('DOMContentLoaded', function() {
        admin.init();
    });

    admin.init = function() {
        // 載入資料
        admin.loadData();
        
        // 綁定搜尋框 Enter 事件
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                admin.loadData();
            }
        });

        // 綁定搜尋按鈕
        document.getElementById('apply-filters').addEventListener('click', function() {
            admin.loadData();
        });

        // 綁定重新整理按鈕
        document.getElementById('refresh-data').addEventListener('click', function() {
            admin.loadData();
        });

        // 綁定每頁筆數變更
        document.getElementById('per-page').addEventListener('change', function() {
            admin.pageSize = parseInt(this.value);
            admin.currentPage = 1;
            admin.loadData();
        });
    };

    admin.loadData = function(page = 1) {
        admin.currentPage = page;
        const searchValue = document.getElementById('search-input').value.trim();
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        
        // 顯示載入中
        const tbody = document.getElementById('data-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">載入中...</span>
                    </div>
                    <div class="mt-2">正在載入資料...</div>
                </td>
            </tr>
        `;

        // 構建請求參數
        const params = new URLSearchParams({
            page: page,
            limit: admin.pageSize
        });
        
        if (searchValue) {
            params.append('search', searchValue);
        }
        
        if (startDate) {
            params.append('start_date', startDate);
        }
        
        if (endDate) {
            params.append('end_date', endDate);
        }

        // 發送請求
        fetch(`${admin.apiBaseUrl}/list?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    admin.renderTable(data.data.data);
                    admin.totalRecords = data.data.pagination.total;
                    admin.renderPagination(data.data.pagination);
                    admin.updateRecordInfo(data.data.pagination);
                } else {
                    admin.showError('載入資料失敗: ' + data.message);
                }
            })
            .catch(error => {
                console.error('載入資料失敗:', error);
                admin.showError('載入資料失敗，請稍後再試');
            });
    };

    admin.renderTable = function(data) {
        const tbody = document.getElementById('data-table-body');
        
        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="lnr lnr-warning" style="font-size: 2rem;"></i>
                        <div class="mt-2">暫無資料</div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = '';
        data.forEach(item => {
            // Helper function to escape HTML
            const escapeHtml = (text) => {
                if (!text) return '';
                return text.toString()
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            };

            const row = `
                <tr>
                    <td style="display: none;">${item.id}</td>
                    <td>${escapeHtml(item.member_name || '')}</td>
                    <td>${item.birth_year || ''}年${item.birth_month || ''}月</td>
                    <td>${item.height || ''}cm</td>
                    <td>${item.has_medication_habit ? '有' : '無'}</td>
                    <td>${item.has_family_disease_history ? '有' : '無'}</td>
                    <td>${escapeHtml(item.submission_date || '')}</td>
                    <td class="table-actions">
                        <button class="btn btn-sm btn-info" onclick="admin.viewDetail(${item.id})" title="檢視詳細資料" data-toggle="tooltip">
                            <i class="lnr lnr-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success" onclick="admin.exportSingleForm(${item.id})" title="匯出此表單" data-toggle="tooltip">
                            <i class="lnr lnr-download"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
        
        // Initialize tooltips for new buttons
        $('[data-toggle="tooltip"]').tooltip();
    };

    admin.renderPagination = function(pagination) {
        const paginationElement = document.getElementById('pagination');
        if (!pagination || pagination.total_pages <= 1) {
            paginationElement.innerHTML = '';
            return;
        }

        let paginationHtml = '';
        
        // 上一頁按鈕
        if (pagination.current_page > 1) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="admin.loadData(${pagination.current_page - 1})">&laquo;</a>
                </li>
            `;
        }

        // 頁碼按鈕
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);

        if (startPage > 1) {
            paginationHtml += '<li class="page-item"><a class="page-link" href="#" onclick="admin.loadData(1)">1</a></li>';
            if (startPage > 2) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            const activeClass = i === pagination.current_page ? 'active' : '';
            paginationHtml += `
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" onclick="admin.loadData(${i})">${i}</a>
                </li>
            `;
        }

        if (endPage < pagination.total_pages) {
            if (endPage < pagination.total_pages - 1) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            paginationHtml += `<li class="page-item"><a class="page-link" href="#" onclick="admin.loadData(${pagination.total_pages})">${pagination.total_pages}</a></li>`;
        }

        // 下一頁按鈕
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="admin.loadData(${pagination.current_page + 1})">&raquo;</a>
                </li>
            `;
        }

        paginationElement.innerHTML = paginationHtml;
    };

    admin.updateRecordInfo = function(pagination) {
        // Record info element doesn't exist in reverted layout - commenting out
        // const start = (pagination.current_page - 1) * pagination.per_page + 1;
        // const end = Math.min(pagination.current_page * pagination.per_page, pagination.total);
        // document.getElementById('recordInfo').textContent = `顯示第 ${start}-${end} 筆，共 ${pagination.total} 筆資料`;
    };

    admin.viewDetail = async function(id) {
        try {
            const response = await fetch(`${admin.apiBaseUrl}/submission/${id}`);
            const result = await response.json();
            
            if (result.success && result.data) {
                admin.renderDetailModal(result.data);
                $('#detailModal').modal('show');
            } else {
                admin.showAlert('載入詳細資料失敗: ' + (result.message || '未知錯誤'), 'danger');
            }
        } catch (error) {
            console.error('載入詳細資料失敗:', error);
            admin.showAlert('載入詳細資料失敗，請稍後再試', 'danger');
        }
    };

    admin.renderDetailModal = function(data) {
        const container = document.getElementById('detailContent');
        
        // Helper function to escape HTML
        const escapeHtml = (text) => {
            if (!text) return '';
            return text.toString()
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };
        
        // 基本資料區塊
        let basicDataHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">基本資料</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">會員姓名</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.member_name || '')}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">會員編號</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.member_id || '')}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">手機號碼</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.phone || '')}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">性別</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.gender || '')}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">年齡</label>
                            <input type="text" class="form-control" value="${data.age ? data.age + ' 歲' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">身高</label>
                            <input type="text" class="form-control" value="${data.height ? data.height + ' cm' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">運動習慣</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.exercise_habit || '')}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">填寫日期</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.submission_date || '')}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 體測標準建議值區塊
        let bodyTestHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">體測標準建議值</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">體重</label>
                            <input type="text" class="form-control" value="${data.weight ? data.weight + ' Kg' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">BMI</label>
                            <input type="text" class="form-control" value="${data.bmi || ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">脂肪率</label>
                            <input type="text" class="form-control" value="${data.fat_percentage ? data.fat_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">脂肪量</label>
                            <input type="text" class="form-control" value="${data.fat_mass ? data.fat_mass + ' Kg' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">肌肉百分比</label>
                            <input type="text" class="form-control" value="${data.muscle_percentage ? data.muscle_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">肌肉量</label>
                            <input type="text" class="form-control" value="${data.muscle_mass ? data.muscle_mass + ' Kg' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">水份比例</label>
                            <input type="text" class="form-control" value="${data.water_percentage ? data.water_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">水含量</label>
                            <input type="text" class="form-control" value="${data.water_content ? data.water_content + ' Kg' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">內臟脂肪率</label>
                            <input type="text" class="form-control" value="${data.visceral_fat_percentage ? data.visceral_fat_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">骨量</label>
                            <input type="text" class="form-control" value="${data.bone_mass ? data.bone_mass + ' Kg' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">基礎代謝率</label>
                            <input type="text" class="form-control" value="${data.bmr ? data.bmr + ' 卡' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">蛋白質</label>
                            <input type="text" class="form-control" value="${data.protein_percentage ? data.protein_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">肥胖度</label>
                            <input type="text" class="form-control" value="${data.obesity_percentage ? data.obesity_percentage + ' %' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">身體年齡</label>
                            <input type="text" class="form-control" value="${data.body_age ? data.body_age + ' 歲' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">去脂體重</label>
                            <input type="text" class="form-control" value="${data.lean_body_mass ? data.lean_body_mass + ' KG' : ''}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 職業資料區塊
        let occupationHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">職業資料</h6>
        `;
        
        if (data.occupations && data.occupations.length > 0) {
            occupationHtml += '<div class="row">';
            data.occupations.forEach((occupation, index) => {
                occupationHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">職業 ${index + 1}</label>
                            <input type="text" class="form-control" value="${escapeHtml(occupation.occupation_type || '')}" readonly>
                        </div>
                    </div>
                `;
            });
            occupationHtml += '</div>';
        } else {
            occupationHtml += '<p class="text-muted">未填寫職業資料</p>';
        }
        
        occupationHtml += '</div>';

        // 健康困擾區塊
        let healthHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">健康困擾</h6>
        `;
        
        if (data.health_concerns && data.health_concerns.length > 0) {
            healthHtml += '<div class="row">';
            data.health_concerns.forEach((concern, index) => {
                healthHtml += `
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">健康困擾 ${index + 1}</label>
                            <input type="text" class="form-control" value="${escapeHtml(concern.concern_type || '')}" readonly>
                        </div>
                    </div>
                `;
            });
            healthHtml += '</div>';
            
            // 其他健康困擾
            if (data.health_concerns_other) {
                healthHtml += `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">其他健康困擾</label>
                                <input type="text" class="form-control" value="${escapeHtml(data.health_concerns_other)}" readonly>
                            </div>
                        </div>
                    </div>
                `;
            }
        } else {
            healthHtml += '<p class="text-muted">未填寫健康困擾</p>';
        }
        
        healthHtml += '</div>';

        // 產品推薦區塊
        let productsHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">產品推薦</h6>
        `;
        
        if (data.products && data.products.length > 0) {
            productsHtml += '<div class="row">';
            data.products.forEach(product => {
                productsHtml += `
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">${escapeHtml(product.product_name)}</label>
                            <input type="text" class="form-control" value="${escapeHtml(product.recommended_dosage || '未填寫用量')}" readonly>
                        </div>
                    </div>
                `;
            });
            productsHtml += '</div>';
        } else {
            productsHtml += '<p class="text-muted">未推薦任何產品</p>';
        }
        
        productsHtml += '</div>';

        // 醫療資訊區塊
        let medicalHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">醫療資訊</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">長期用藥習慣</label>
                            <input type="text" class="form-control" value="${data.has_medication_habit ? '有' : '無'}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">使用藥物</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.medication_name || '無')}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">家族慢性病史</label>
                            <input type="text" class="form-control" value="${data.has_family_disease_history ? '有' : '無'}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">疾病名稱</label>
                            <input type="text" class="form-control" value="${escapeHtml(data.disease_name || '無')}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 檢測與建議區塊
        let testHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">檢測與建議</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">微循環檢測</label>
                            <textarea class="form-control" rows="3" readonly>${escapeHtml(data.microcirculation_test || '')}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">日常飲食建議</label>
                            <textarea class="form-control" rows="3" readonly>${escapeHtml(data.dietary_advice || '')}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = basicDataHtml + bodyTestHtml + occupationHtml + healthHtml + productsHtml + medicalHtml + testHtml;
    };

    admin.closeDetailModal = function() {
        $('#detailModal').modal('hide');
    };

    admin.exportSingleForm = function(id) {
        const url = `${admin.apiBaseUrl}/export_single/${id}`;
        window.open(url, '_blank');
    };

    admin.showAlert = function(message, type = 'info') {
        if (typeof Swal !== 'undefined') {
            let icon = 'info';
            switch(type) {
                case 'success': icon = 'success'; break;
                case 'danger': case 'error': icon = 'error'; break;
                case 'warning': icon = 'warning'; break;
            }
            
            Swal.fire({
                title: type === 'error' || type === 'danger' ? '錯誤' : '通知',
                text: message,
                icon: icon,
                confirmButtonText: '確定',
                confirmButtonColor: '#6f42c1'
            });
        } else {
            alert(message);
        }
    };

    admin.showError = function(message) {
        admin.showAlert(message, 'error');
        
        // 同時在表格中顯示錯誤訊息
        const tbody = document.getElementById('data-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4 text-danger">
                    <i class="lnr lnr-warning" style="font-size: 2rem;"></i>
                    <div class="mt-2">${message}</div>
                    <button class="btn btn-outline-primary btn-sm mt-2" onclick="admin.loadData()">重新載入</button>
                </td>
            </tr>
        `;
    };
</script>