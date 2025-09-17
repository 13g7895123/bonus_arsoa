<!-- Sweet Alert 2 CDN needed in the head section -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    /* EForm1 Admin Styles */
    .eform1-admin {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        padding: 2rem !important;
    }
    
    .dashboard-card {
        border-left: 4px solid #17a2b8 !important;
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
        font-size: 1rem !important;
        padding: 0.75rem;
        line-height: 1.6 !important;
    }
    
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-color: #e9ecef;
        font-size: 1rem !important;
        line-height: 1.6 !important;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,0.02) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(23,162,184,0.05) !important;
    }
    
    .pagination .page-link {
        color: #17a2b8;
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        border-radius: 4px !important;
    }
    
    .btn-outline-primary {
        color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-outline-primary:hover {
        background-color: #17a2b8;
        border-color: #17a2b8;
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
    #detailModal .modal-dialog {
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
        background-color: #fff !important;
        border-radius: 8px 8px 0 0;
        color: #495057;
    }
    
    .modal-body {
        padding: 2rem !important;
        background-color: #f8f9fa;
    }
    
    /* View Detail Modal Specific Styling - matching form2 */
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
        border: 2px solid #e9ecef !important;
        border-radius: 12px !important;
        background-color: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin: 0 -1rem 3rem -1rem !important;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }
    
    #detailModal .border:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
    
    .modal-footer {
        border-top: 1px solid #e9ecef !important;
        padding: 1rem 1.5rem !important;
    }
    
    .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
        color: #495057;
    }
    
    /* Section borders */
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
    
    /* Search button enhancement - matching form2 style with cyan theme */
    #apply-filters {
        height: calc(1.5em + 0.75rem + 2px);
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(23,162,184,0.3);
        transition: all 0.2s ease;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    #apply-filters:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(23,162,184,0.4);
        background-color: #138496;
        border-color: #117a8b;
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
    .eform1-admin .form-control {
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
    
    .eform1-admin .form-control:focus {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #5dbeaa !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25) !important;
    }
    
    /* Button hover effects - darker colors */
    .btn-primary:hover {
        background-color: #138496 !important;
        border-color: #117a8b !important;
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
    
    /* Custom margin-bottom for better block spacing - matching form2 */
    .mb-6 {
        margin-bottom: 3rem !important;
    }
    
    .alert {
        border-radius: 6px !important;
        border: none !important;
        font-weight: 500;
    }
    
    .spinner-border {
        color: #17a2b8 !important;
    }
</style>

<div class="eform1-admin">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2>會員服務追蹤管理表(肌膚諮詢)</h2>
            <div class="header-buttons">
                <button class="btn btn-danger" id="delete-test-data-btn">
                    <i class="lnr lnr-trash"></i> 刪除測試資料
                </button>
            </div>
        </div>
    </div>

    <!-- 篩選器 -->
    <div class="filters-section">
        <div class="row d-flex align-items-end">
            <div class="col-md-3">
                <label class="form-label">搜尋</label>
                <input type="text" class="form-control" id="search-input" placeholder="會員姓名、電話">
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
                <button class="btn btn-primary w-100" id="apply-filters" style="margin-top: 25px;">
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
                            <th>填寫者</th>
                            <th>會員姓名</th>
                            <th>出生年月日</th>
                            <th>電話</th>
                            <th>肌膚類型</th>
                            <th>肌膚年齡</th>
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
                <h5 class="modal-title">肌膚諮詢記錄表詳細資料</h5>
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
        apiBaseUrl: '/api/eeform/eeform1'
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

        // 綁定刪除測試資料按鈕
        document.getElementById('delete-test-data-btn').addEventListener('click', function() {
            admin.deleteAllTestData();
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
                    admin.totalRecords = data.data.pagination ? data.data.pagination.total : data.data.length;
                    if (data.data.pagination) {
                        admin.renderPagination(data.data.pagination);
                    }
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
                    <td colspan="8" class="text-center py-4 text-muted">
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

            // 格式化肌膚類型
            const skinTypeMap = {
                'normal': '中性',
                'combination': '混合性',
                'oily': '油性',
                'dry': '乾性',
                'sensitive': '敏感性'
            };
            const displaySkinType = skinTypeMap[item.skin_type] || item.skin_type || '-';

            const row = `
                <tr>
                    <td style="display: none;">${item.id}</td>
                    <td>${escapeHtml(item.form_filler_name || '')}</td>
                    <td>${escapeHtml(item.member_name || '')}</td>
                    <td>${item.birth_year || ''}年${item.birth_month || ''}月${item.birth_day || ''}日</td>
                    <td>${escapeHtml(item.phone || '')}</td>
                    <td>${displaySkinType}</td>
                    <td>${item.skin_age || ''}歲</td>
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
        
        // 系統資料區塊
        let systemDataHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">系統資料</h6>
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">記錄ID</label>
                                <div>${data.id || ''}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">建立時間</label>
                                <div>${data.created_at || ''}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 基本資料區塊
        let basicDataHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">基本資料</h6>
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">會員姓名</label>
                                <div>${data.member_name || ''}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">出生年月日</label>
                                <div>${data.birth_year || ''}年${data.birth_month || ''}月${data.birth_day || ''}日</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">電話</label>
                                <div>${data.phone || ''}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 職業與生活習慣區塊
        let lifestyleHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">職業與生活習慣</h6>
                </div>
                <div class="p-3">
                    <div class="row">
        `;
        
        // 顯示選中的職業
        if (data.occupations && data.occupations.length > 0) {
            const selectedOccupations = data.occupations.filter(occ => occ.is_selected == 1);
            if (selectedOccupations.length > 0) {
                lifestyleHtml += `
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="form-label">職業</label>
                            <div>`;
                selectedOccupations.forEach((occ, index) => {
                    const occupationMap = {
                        'service': '服務業',
                        'office': '上班族',
                        'restaurant': '餐飲業',
                        'housewife': '家管'
                    };
                    lifestyleHtml += occupationMap[occ.occupation_type] || occ.occupation_type;
                    if (index < selectedOccupations.length - 1) lifestyleHtml += '、';
                });
                lifestyleHtml += `</div>
                        </div>
                    </div>
                `;
            }
        }

        // 顯示生活習慣
        if (data.lifestyle && data.lifestyle.length > 0) {
            const sunlightItems = data.lifestyle.filter(item => item.category === 'sunlight' && item.is_selected == 1);
            const acItems = data.lifestyle.filter(item => item.category === 'aircondition' && item.is_selected == 1);
            const sleepItems = data.lifestyle.filter(item => item.category === 'sleep' && item.is_selected == 1);

            if (sunlightItems.length > 0) {
                lifestyleHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">戶外日曬時間</label>
                            <div>`;
                sunlightItems.forEach(item => {
                    const sunlightMap = {
                        '1_2h': '1~2小時',
                        '3_4h': '3~4小時', 
                        '5_6h': '5~6小時',
                        '8h_plus': '8小時以上'
                    };
                    lifestyleHtml += sunlightMap[item.item_key] || item.item_key;
                });
                lifestyleHtml += `</div>
                        </div>
                    </div>
                `;
            }

            if (acItems.length > 0) {
                lifestyleHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">空調環境</label>
                            <div>`;
                acItems.forEach(item => {
                    const acMap = {
                        '1h': '1小時內',
                        '2_4h': '2~4小時',
                        '5_8h': '5~8小時',
                        '8h_plus': '8小時以上'
                    };
                    lifestyleHtml += acMap[item.item_key] || item.item_key;
                });
                lifestyleHtml += `</div>
                        </div>
                    </div>
                `;
            }

            if (sleepItems.length > 0) {
                lifestyleHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">睡眠狀況</label>
                            <div>`;
                sleepItems.forEach(item => {
                    const sleepMap = {
                        '9_10': '晚上9:00~10:59就寢',
                        '11_12': '晚上11:00~12:59就寢',
                        'after_1': '凌晨1點之後就寢',
                        'other': '其他' + (item.item_value ? ': ' + item.item_value : '')
                    };
                    lifestyleHtml += sleepMap[item.item_key] || item.item_key;
                });
                lifestyleHtml += `</div>
                        </div>
                    </div>
                `;
            }
        }

        lifestyleHtml += `
                    </div>
                </div>
            </div>
        `;

        // 使用產品區塊
        let productsHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">現在使用產品</h6>
                </div>
                <div class="p-3">
        `;
        
        if (data.products && data.products.length > 0) {
            const selectedProducts = data.products.filter(prod => prod.is_selected == 1);
            if (selectedProducts.length > 0) {
                productsHtml += '<div class="row">';
                selectedProducts.forEach((prod, index) => {
                    const productMap = {
                        'honey_soap': '蜜皂',
                        'mud_mask': '泥膜',
                        'toner': '化妝水',
                        'serum': '精華液',
                        'premium': '極緻系列',
                        'sunscreen': '防曬',
                        'other': '其他' + (prod.product_name ? ': ' + prod.product_name : '')
                    };
                    if (index % 3 === 0 && index > 0) productsHtml += '</div><div class="row">';
                    productsHtml += `
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">產品 ${index + 1}</label>
                                <div>${productMap[prod.product_type] || prod.product_type}</div>
                            </div>
                        </div>
                    `;
                });
                productsHtml += '</div>';
            } else {
                productsHtml += '<p class="text-muted">未選擇任何產品</p>';
            }
        } else {
            productsHtml += '<p class="text-muted">未選擇任何產品</p>';
        }
        
        productsHtml += `
                </div>
            </div>
        `;

        // 肌膚困擾區塊
        let skinIssuesHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">肌膚困擾</h6>
                </div>
                <div class="p-3">
        `;
        
        if (data.skin_issues && data.skin_issues.length > 0) {
            const selectedIssues = data.skin_issues.filter(issue => issue.is_selected == 1);
            if (selectedIssues.length > 0) {
                skinIssuesHtml += '<div class="row">';
                selectedIssues.forEach((issue, index) => {
                    const issueMap = {
                        'elasticity': '沒有彈性',
                        'luster': '沒有光澤',
                        'dull': '暗沉',
                        'spots': '斑點',
                        'pores': '毛孔粗大',
                        'acne': '痘痘粉刺',
                        'wrinkles': '皺紋細紋',
                        'rough': '粗糙',
                        'irritation': '癢、紅腫',
                        'dry': '乾燥',
                        'makeup': '上妝不服貼',
                        'other': '其他' + (issue.issue_description ? ': ' + issue.issue_description : '')
                    };
                    if (index % 3 === 0 && index > 0) skinIssuesHtml += '</div><div class="row">';
                    skinIssuesHtml += `
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">困擾 ${index + 1}</label>
                                <div>${issueMap[issue.issue_type] || issue.issue_type}</div>
                            </div>
                        </div>
                    `;
                });
                skinIssuesHtml += '</div>';
            } else {
                skinIssuesHtml += '<p class="text-muted">無特殊肌膚困擾</p>';
            }
        } else {
            skinIssuesHtml += '<p class="text-muted">無特殊肌膚困擾</p>';
        }

        // 過敏狀況
        if (data.allergies && data.allergies.length > 0) {
            const selectedAllergies = data.allergies.filter(allergy => allergy.is_selected == 1);
            if (selectedAllergies.length > 0) {
                skinIssuesHtml += '<div class="row mt-3">';
                skinIssuesHtml += '<div class="col-md-12"><div class="form-group"><label class="form-label">過敏狀況</label><div>';
                selectedAllergies.forEach(allergy => {
                    const allergyMap = {
                        'frequent': '經常',
                        'seasonal': '偶爾(換季時)',
                        'never': '不會'
                    };
                    skinIssuesHtml += allergyMap[allergy.allergy_type] || allergy.allergy_type;
                });
                skinIssuesHtml += '</div></div></div></div>';
            }
        }
        
        skinIssuesHtml += `
                </div>
            </div>
        `;

        // 建議內容區塊
        let suggestionsHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">建議內容</h6>
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">化妝水</label>
                                <div>${data.suggestions && data.suggestions.toner_suggestion || ''}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">精華液</label>
                                <div>${data.suggestions && data.suggestions.serum_suggestion || ''}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">建議內容</label>
                                <div>${data.suggestions && data.suggestions.suggestion_content || ''}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 肌膚檢測數據區塊
        let skinTestHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">肌膚檢測數據</h6>
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">肌膚類型</label>
                                <div>`;
        
        const skinTypeMap = {
            'normal': '中性',
            'combination': '混合性',
            'oily': '油性',
            'dry': '乾性',
            'sensitive': '敏感性'
        };
        skinTestHtml += skinTypeMap[data.skin_type] || data.skin_type || '';

        skinTestHtml += `</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">肌膚年齡</label>
                                <div>${data.skin_age || ''}歲</div>
                            </div>
                        </div>
                    </div>
        `;

        // 顯示評分數據
        if (data.skin_scores && data.skin_scores.length > 0) {
            const categories = ['水潤', '膚色', '紋理', '敏感', '油脂', '色素', '皺紋', '毛孔'];
            const categoryMap = {
                'moisture': '水潤',
                'complexion': '膚色',
                'texture': '紋理',
                'sensitivity': '敏感',
                'oil': '油脂',
                'pigment': '色素',
                'wrinkle': '皺紋',
                'pore': '毛孔'
            };

            categories.forEach(categoryName => {
                const categoryKey = Object.keys(categoryMap).find(key => categoryMap[key] === categoryName);
                if (categoryKey) {
                    const categoryScores = data.skin_scores.filter(score => score.category === categoryKey);
                    if (categoryScores.length > 0) {
                        skinTestHtml += `
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>${categoryName}檢測資料</h6>
                                </div>
                            </div>
                            <div class="row">
                        `;
                        categoryScores.forEach((score, index) => {
                            const scoreTypeMap = {
                                'severe': '嚴重、盡快改善',
                                'warning': '有問題、要注意',
                                'healthy': '健康'
                            };
                            skinTestHtml += `
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">${scoreTypeMap[score.score_type] || score.score_type}</label>
                                        <div>`;
                            if (score.measurement_date) {
                                skinTestHtml += score.measurement_date + ' - ';
                            }
                            skinTestHtml += `數值: ${score.score_value || ''}`;
                            skinTestHtml += `</div>
                                    </div>
                                </div>
                            `;
                        });
                        skinTestHtml += '</div>';
                    }
                }
            });
        }

        skinTestHtml += `
                </div>
            </div>
        `;

        // 提交資訊區塊
        let submissionHtml = `
            <div class="border mb-6 rounded">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0">提交資訊</h6>
                </div>
                <div class="p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">提交日期</label>
                                <div>${data.submission_date || ''}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">最後更新</label>
                                <div>${data.updated_at || ''}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = basicDataHtml + lifestyleHtml + productsHtml + skinIssuesHtml + suggestionsHtml + skinTestHtml;
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
                confirmButtonColor: '#17a2b8'
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
                <td colspan="8" class="text-center py-4 text-danger">
                    <i class="lnr lnr-warning" style="font-size: 2rem;"></i>
                    <div class="mt-2">${message}</div>
                    <button class="btn btn-outline-primary btn-sm mt-2" onclick="admin.loadData()">重新載入</button>
                </td>
            </tr>
        `;
    };

    admin.deleteAllTestData = function() {
        if (typeof Swal !== 'undefined') {
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
                    admin.performDeleteAllTestData();
                }
            });
        } else {
            if (confirm('您確定要刪除所有測試資料嗎？此操作無法復原！')) {
                admin.performDeleteAllTestData();
            }
        }
    };

    admin.performDeleteAllTestData = async function() {
        try {
            // 顯示載入指示
            const deleteBtn = document.getElementById('delete-test-data-btn');
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="lnr lnr-sync lnr-spin"></i> 刪除中...';
            deleteBtn.disabled = true;

            const response = await fetch(`${admin.apiBaseUrl}/delete_all_test_data`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                admin.showAlert('所有測試資料已成功刪除', 'success');
                // 重新載入資料
                admin.loadData();
            } else {
                admin.showAlert('刪除失敗: ' + (result.message || '未知錯誤'), 'error');
            }
        } catch (error) {
            console.error('刪除測試資料失敗:', error);
            admin.showAlert('刪除失敗，請稍後再試', 'error');
        } finally {
            // 恢復按鈕狀態
            const deleteBtn = document.getElementById('delete-test-data-btn');
            deleteBtn.innerHTML = '<i class="lnr lnr-trash"></i> 刪除測試資料';
            deleteBtn.disabled = false;
        }
    };
</script>