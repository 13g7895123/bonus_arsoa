<!-- Sweet Alert 2 CDN needed in the head section -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    /* EForm3 Admin Styles */
    .eform3-admin {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        padding: 2rem !important;
    }
    
    .dashboard-card {
        border-left: 4px solid #28a745 !important;
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
        background-color: rgba(40,167,69,0.05) !important;
    }
    
    .pagination .page-link {
        color: #28a745;
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        border-radius: 4px !important;
    }
    
    .btn-outline-primary {
        color: #28a745;
        border-color: #28a745;
    }
    
    .btn-outline-primary:hover {
        background-color: #28a745;
        border-color: #28a745;
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
    
    /* Make modals extra wide - matching form5 */
    #detailModal .modal-dialog,
    #activityModal .modal-dialog {
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
    
    /* View Detail Modal Specific Styling - matching form5 */
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
    
    /* Special styling for activity badges */
    .activity-badge {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        margin: 0.125rem;
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
    
    /* Responsive adjustments - matching form5 */
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
    
    /* Search button enhancement - matching form5 style with green theme */
    #apply-filters {
        height: calc(1.5em + 0.75rem + 2px);
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(40,167,69,0.3);
        transition: all 0.2s ease;
    }
    
    #apply-filters:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40,167,69,0.4);
    }
    
    .table th,
    .table td {
        font-size: 1rem !important;
        line-height: 1.6 !important;
    }
    
    .table th {
        font-weight: 600 !important;
    }
    
    /* Form spacing improvements - matching form5 */
    .filters-section {
        margin-bottom: 2rem !important;
    }
    
    .filters-section .row > div {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    /* Fix any potential conflicts with admin template - matching form5 */
    .eform3-admin .form-control {
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
    
    .eform3-admin .form-control:focus {
        color: #495057 !important;
        background-color: #fff !important;
        border-color: #80c79d !important;
        outline: 0 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
    }
    
    /* Button hover effects - green colors */
    .btn-primary:hover {
        background-color: #1e7e34 !important;
        border-color: #1c7430 !important;
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
        background-color: #1e7e34 !important;
        border-color: #1c7430 !important;
        color: #fff !important;
    }
    
    /* Custom margin-bottom for better block spacing - matching form5 */
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
        color: #28a745 !important;
    }
</style>

<div class="eform3-admin">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2>微微卡日記管理</h2>
        </div>
    </div>

    <!-- 篩選器 -->
    <div class="filters-section">
        <div class="row d-flex align-items-end">
            <div class="col-md-3">
                <label class="form-label">搜尋會員</label>
                <input type="text" class="form-control" id="search-input" placeholder="會員姓名、會員編號">
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
                <button class="btn btn-primary w-100" id="apply-filters" style="margin-top: 25px; background-color: #28a745; border-color: #28a745;">
                    <i class="lnr lnr-magnifier"></i> 搜尋
                </button>
            </div>
        </div>
    </div>

    <!-- 資料表 -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">微微卡日記記錄列表</h5>
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
                            <th>會員編號</th>
                            <th>年齡</th>
                            <th>身高</th>
                            <th>體重</th>
                            <th>完成活動</th>
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
                <h5 class="modal-title">微微卡日記詳細資料</h5>
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
        apiBaseUrl: '/api/eeform3'
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
                <td colspan="8" class="text-center py-4">
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

            // Format activities
            let activityBadges = '';
            const activities = ['hand_measure', 'exercise', 'health_supplement', 'weika', 'water_intake'];
            const activityNames = {
                'hand_measure': '手測',
                'exercise': '運動',
                'health_supplement': '保健',
                'weika': '微卡',
                'water_intake': '飲水'
            };
            
            activities.forEach(activity => {
                if (item[activity]) {
                    activityBadges += `<span class="activity-badge">${activityNames[activity]}</span>`;
                }
            });

            const row = `
                <tr>
                    <td style="display: none;">${item.id}</td>
                    <td>${escapeHtml(item.member_name || '')}</td>
                    <td>${escapeHtml(item.member_id || '')}</td>
                    <td>${item.age || ''}</td>
                    <td>${item.height || ''}cm</td>
                    <td>${item.weight ? item.weight + 'kg' : ''}</td>
                    <td>${activityBadges || '<span class="text-muted">無</span>'}</td>
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
        // Record info can be added here if needed
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
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">系統資料</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">記錄ID</label>
                            <input type="text" class="form-control" value="${data.id || ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">建立時間</label>
                            <input type="text" class="form-control" value="${data.created_at || ''}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 基本資料區塊
        let basicDataHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">基本資料</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">會員姓名</label>
                            <input type="text" class="form-control" value="${data.member_name || ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">會員編號</label>
                            <input type="text" class="form-control" value="${data.member_id || ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">年齡</label>
                            <input type="text" class="form-control" value="${data.age ? data.age + ' 歲' : ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">身高</label>
                            <input type="text" class="form-control" value="${data.height ? data.height + ' cm' : ''}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">目標</label>
                            <textarea class="form-control" rows="2" readonly>${data.goal || ''}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 行動計畫區塊
        let actionPlanHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">自身行動計畫</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">行動計畫1</label>
                            <textarea class="form-control" rows="2" readonly>${data.action_plan_1 || '未填寫'}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">行動計畫2</label>
                            <textarea class="form-control" rows="2" readonly>${data.action_plan_2 || '未填寫'}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 身體數據區塊
        let bodyDataHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">身體數據</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">體重</label>
                            <input type="text" class="form-control" value="${data.weight ? data.weight + ' kg' : '未填寫'}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">血壓(收縮)</label>
                            <input type="text" class="form-control" value="${data.blood_pressure_high || '未填寫'}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">血壓(舒張)</label>
                            <input type="text" class="form-control" value="${data.blood_pressure_low || '未填寫'}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">腰圍</label>
                            <input type="text" class="form-control" value="${data.waist ? data.waist + ' cm' : '未填寫'}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 執行活動區塊
        let activityHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">執行活動</h6>
        `;
        
        const activityNames = {
            'hand_measure': '用手測量飲食',
            'exercise': '運動(30分)',
            'health_supplement': '保健食品',
            'weika': '微微卡',
            'water_intake': '飲水量記錄'
        };
        
        let activityItems = [];
        Object.keys(activityNames).forEach(key => {
            if (data[key]) {
                activityItems.push(activityNames[key]);
            }
        });
        
        if (activityItems.length > 0) {
            activityHtml += '<div class="d-flex flex-wrap">';
            activityItems.forEach(item => {
                activityHtml += `<span class="activity-badge me-2 mb-2">${item}</span>`;
            });
            activityHtml += '</div>';
        } else {
            activityHtml += '<p class="text-muted">未執行任何活動</p>';
        }
        
        activityHtml += '</div>';

        // 計畫內容區塊
        let plansHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">計畫內容</h6>
        `;
        
        if (data.plans && data.plans.length > 0) {
            plansHtml += '<div class="row">';
            data.plans.forEach((plan, index) => {
                let planTitle = '';
                switch(plan.plan_type) {
                    case 'plan_a': planTitle = '計畫1'; break;
                    case 'plan_b': planTitle = '計畫2'; break;
                    case 'other': planTitle = '其他計畫'; break;
                    default: planTitle = '計畫' + (index + 1);
                }
                
                plansHtml += `
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">${planTitle}</label>
                            <textarea class="form-control" rows="3" readonly>${plan.plan_content || '未填寫'}</textarea>
                        </div>
                    </div>
                `;
            });
            plansHtml += '</div>';
        } else {
            plansHtml += '<p class="text-muted">未填寫計畫內容</p>';
        }
        
        plansHtml += '</div>';

        // 提交資訊區塊
        let submissionHtml = `
            <div class="border mb-6 rounded" style="padding: 1.5rem;">
                <h6 class="mb-3">提交資訊</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">提交日期</label>
                            <input type="text" class="form-control" value="${data.submission_date || ''}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">狀態</label>
                            <input type="text" class="form-control" value="${data.status || 'submitted'}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML = systemDataHtml + basicDataHtml + actionPlanHtml + bodyDataHtml + activityHtml + plansHtml + submissionHtml;
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
                confirmButtonColor: '#28a745'
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
</script>