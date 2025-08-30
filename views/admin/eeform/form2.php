<!-- Sweet Alert 2 CDN needed in the head section -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    /* EForm2 Admin Styles */
    .eform2-admin {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        padding: 2rem !important;
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
        background-color: #f8f9fa !important;
    }
    
    .modal-body {
        padding: 1.25rem;
    }
    
    /* View Detail Modal Specific Styling */
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
    
    /* Make modal extra wide */
    #detailModal .modal-dialog {
        max-width: 1800px !important;
        margin: 1.75rem auto;
        width: 95vw;
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
        color: #007bff;
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
    
    /* Search button enhancement */
    #apply-filters {
        height: calc(1.5em + 0.75rem + 2px);
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,123,255,0.3);
        transition: all 0.2s ease;
    }
    
    #apply-filters:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.4);
    }
    
    /* Form spacing improvements */
    .filters-section {
        margin-bottom: 2rem !important;
    }
    
    .filters-section .row > div {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    /* Make table text larger */
    .table th,
    .table td {
        font-size: 1rem !important;
        line-height: 1.6 !important;
    }
    
    .table th {
        font-weight: 600 !important;
    }
    
    /* Custom margin-bottom for better block spacing */
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
    
    /* Product modal scrollable styles */
    #productModal .modal-body {
        max-height: 70vh !important;
        overflow-y: auto !important;
    }
    
    #productModal .modal-body::-webkit-scrollbar {
        width: 8px;
    }
    
    #productModal .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    #productModal .modal-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    #productModal .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    #productModal .product-item {
        transition: all 0.2s ease;
    }
    
    #productModal .product-item:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
</style>
    <div class="container-fluid py-4 eform2-admin">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2>會員服務追蹤管理表(肌膚)</h2>
                <div class="header-buttons">
                    <button class="btn btn-outline-primary" id="edit-products-btn">
                        <i class="lnr lnr-cog"></i> 編輯商品
                    </button>
                </div>
            </div>
        </div>


        <!-- 篩選器 -->
        <div class="filters-section">
            <div class="row d-flex align-items-end">
                <div class="col-md-3">
                    <label class="form-label">搜尋</label>
                    <input type="text" class="form-control" id="search-input" placeholder="會員姓名、聯絡方式">
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
                    <button class="btn btn-primary w-100" id="apply-filters" style="margin-top: 25px">
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
                                <th>性別</th>
                                <th>年齡</th>
                                <th>加入日期</th>
                                <th>預約見面日</th>
                                <th>聯絡方式</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">會員服務追蹤管理表(肌膚) - 詳細資料</h5>
                </div>
                <div class="modal-body" id="detail-content" style="max-height: 70vh; overflow-y: auto;">
                    <!-- 動態載入詳細資料 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
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

    <!-- 產品管理模態框 -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">eform02 產品管理</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted mb-0">產品列表</h6>
                        <button type="button" class="btn btn-primary btn-sm" id="add-product-btn">
                            <i class="lnr lnr-plus-circle"></i> 新增產品
                        </button>
                    </div>
                    <form id="product-form">
                        <div id="products-container">
                            <!-- 動態載入產品列表 -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="save-products">儲存變更</button>
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

            // 編輯商品按鈕
            $('#edit-products-btn').on('click', () => this.showProductModal());

            // 儲存產品變更
            $('#save-products').on('click', () => this.saveProducts());

            // 新增產品按鈕
            $(document).on('click', '#add-product-btn', () => this.addProduct());
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
                tbody.append('<tr><td colspan="8" class="text-center">無資料</td></tr>');
                return;
            }

            data.forEach(item => {
                const statusBadge = this.getStatusBadge(item.status);
                const row = `
                    <tr>
                        <td style="display: none;">${item.id}</td>
                        <td>${item.member_name}</td>
                        <td>${item.gender}</td>
                        <td>${item.age}</td>
                        <td>${item.join_date}</td>
                        <td>${item.meeting_date || '-'}</td>
                        <td>
                            ${item.line_contact ? `LINE: ${item.line_contact}<br>` : ''}
                            ${item.tel_contact ? `TEL: ${item.tel_contact}` : ''}
                        </td>
                        <td>${item.submission_date}</td>
                        <td class="table-actions">
                            <button class="btn btn-sm btn-info" onclick="admin.viewDetail(${item.id})" title="檢視詳細資料" data-toggle="tooltip">
                                <i class="lnr lnr-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-success" onclick="admin.exportSingleForm(${item.id})" title="匯出此表單" data-toggle="tooltip">
                                <i class="lnr lnr-download"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="admin.deleteSubmission(${item.id})" title="刪除記錄" data-toggle="tooltip">
                                <i class="lnr lnr-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
            
            // Initialize tooltips for new buttons
            $('[data-toggle="tooltip"]').tooltip();
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
                    
                    // 產品資料處理
                    let productHtml = '';
                    if (data.products && data.products.length > 0) {
                        productHtml = '<div class="row">';
                        data.products.forEach((product, index) => {
                            productHtml += `
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label class="text-muted small mb-1">${product.product_name}</label>
                                        <div class="text-dark font-weight-normal"><strong>${product.quantity}</strong> 個</div>
                                    </div>
                                </div>
                            `;
                        });
                        productHtml += '</div>';
                    } else {
                        productHtml = '<div class="form-group"><div class="text-center py-2"><span class="text-muted">未訂購任何產品</span></div></div>';
                    }
                    
                    const content = `
                        <div class="container-fluid">
                            <!-- 基本資料 -->
                            <div class="border mb-6 rounded">
                                <div class="bg-light p-3 border-bottom">
                                    <h6 class="m-0 font-weight-bold text-dark">基本資料</h6>
                                </div>
                                <div class="p-5">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">姓名</label>
                                                <div class="text-dark font-weight-normal" style="word-wrap: break-word; word-break: break-all;">${data.member_name || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">會員編號</label>
                                                <div class="text-dark font-weight-normal" style="word-wrap: break-word;">${data.member_id || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">性別</label>
                                                <div class="text-dark font-weight-normal">${data.gender || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">年齡</label>
                                                <div class="text-dark font-weight-normal">${data.age ? data.age + ' 歲' : '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">入會日</label>
                                                <div class="text-dark font-weight-normal">${data.join_date || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">見面日</label>
                                                <div class="text-dark font-weight-normal">${data.meeting_date || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">健康狀況</label>
                                                <div class="text-dark font-weight-normal" style="word-wrap: break-word; white-space: pre-wrap;">${data.skin_health_condition || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 產品訂購 -->
                            <div class="border mb-6 rounded">
                                <div class="bg-light p-3 border-bottom">
                                    <h6 class="m-0 font-weight-bold text-dark">產品訂購</h6>
                                </div>
                                <div class="p-5">
                                    ${productHtml}
                                </div>
                            </div>

                            <!-- 聯絡資訊 -->
                            <div class="border mb-6 rounded">
                                <div class="bg-light p-3 border-bottom">
                                    <h6 class="m-0 font-weight-bold text-dark">聯絡資訊</h6>
                                </div>
                                <div class="p-5">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">LINE 聯絡</label>
                                                <div class="text-dark font-weight-normal" style="word-wrap: break-word; white-space: pre-wrap;">${data.line_contact || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label class="text-muted small mb-1">電話聯絡</label>
                                                <div class="text-dark font-weight-normal" style="word-wrap: break-word; white-space: pre-wrap;">${data.tel_contact || '(未填寫)'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#detail-content').html(content);
                    $('#detailModal').modal('show');
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
            $('#statusModal').modal('show');
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
                    $('#statusModal').modal('hide');
                    this.showAlert('狀態更新成功', 'success');
                    this.loadData();
                } else {
                    this.showAlert('更新失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('更新狀態失敗:', error);
                this.showAlert('更新狀態失敗，請稍後再試', 'danger');
            }
        }

        async deleteSubmission(id) {
            // 使用 Sweet Alert 確認刪除
            let confirmed = false;
            if (typeof Swal !== 'undefined') {
                const result = await Swal.fire({
                    title: '確定要刪除此記錄嗎？',
                    text: '此操作無法復原！',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消'
                });
                confirmed = result.isConfirmed;
            } else {
                confirmed = confirm('確定要刪除此記錄嗎？此操作無法復原。');
            }
            
            if (!confirmed) {
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
                } else {
                    this.showAlert('刪除失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('刪除失敗:', error);
                this.showAlert('刪除失敗，請稍後再試', 'danger');
            }
        }

        async showProductModal() {
            try {
                // 載入目前的產品設定
                const response = await fetch('/api/eeform/eeform2/products');
                const result = await response.json();
                
                if (result.success && result.data) {
                    this.renderProducts(result.data);
                } else {
                    // 如果沒有資料，顯示空的產品列表
                    this.renderProducts({});
                }
                
                $('#productModal').modal('show');
            } catch (error) {
                console.error('載入產品資料失敗:', error);
                this.showAlert('載入產品資料失敗', 'danger');
                // 顯示空的產品列表作為備援
                this.renderProducts({});
                $('#productModal').modal('show');
            }
        }

        renderProducts(products) {
            const container = $('#products-container');
            container.empty();

            // 將產品按照 key 排序
            const sortedProducts = Object.entries(products).sort((a, b) => a[0].localeCompare(b[0]));
            
            if (sortedProducts.length === 0) {
                container.append('<div class="text-center text-muted py-3">尚無產品，請點擊「新增產品」按鈕新增產品</div>');
                return;
            }

            sortedProducts.forEach(([productKey, productData], index) => {
                const productHtml = `
                    <div class="product-item mb-3 p-3 border rounded" data-product-key="${productKey}">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="form-label">產品代碼</label>
                                <input type="text" class="form-control product-code" value="${productData.code || ''}" placeholder="例：SOAP001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">產品名稱</label>
                                <input type="text" class="form-control product-name" value="${productData.name || ''}" placeholder="請輸入產品名稱">
                            </div>
                            <div class="col-md-2 text-end">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete-product-btn" title="刪除產品">
                                        <i class="lnr lnr-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.append(productHtml);
            });

            // 綁定刪除按鈕事件
            container.find('.delete-product-btn').on('click', (e) => {
                const productItem = $(e.target).closest('.product-item');
                this.deleteProduct(productItem);
            });
        }

        addProduct() {
            const container = $('#products-container');
            
            // 移除空狀態訊息
            container.find('.text-center.text-muted').remove();
            
            // 生成新的產品 key
            const timestamp = Date.now();
            const productKey = `new_product_${timestamp}`;
            
            const productHtml = `
                <div class="product-item mb-3 p-3 border rounded bg-light" data-product-key="${productKey}">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">產品代碼 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control product-code" value="" placeholder="例：SOAP001" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">產品名稱 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control product-name" value="" placeholder="請輸入產品名稱" required>
                        </div>
                        <div class="col-md-2 text-end">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-danger btn-sm delete-product-btn" title="刪除產品">
                                    <i class="lnr lnr-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            container.append(productHtml);
            
            // 綁定新增產品的刪除按鈕事件
            const newItem = container.find(`[data-product-key="${productKey}"]`);
            newItem.find('.delete-product-btn').on('click', (e) => {
                const productItem = $(e.target).closest('.product-item');
                this.deleteProduct(productItem);
            });
            
            // 聚焦到第一個輸入框
            newItem.find('.product-code').focus();
        }

        deleteProduct(productItem) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '確定要刪除此產品嗎？',
                    text: '此操作無法復原！',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '確定刪除',
                    cancelButtonText: '取消'
                }).then((result) => {
                    if (result.isConfirmed) {
                        productItem.remove();
                        
                        // 如果沒有產品了，顯示空狀態
                        if ($('#products-container .product-item').length === 0) {
                            $('#products-container').append('<div class="text-center text-muted py-3">尚無產品，請點擊「新增產品」按鈕新增產品</div>');
                        }
                    }
                });
            } else {
                if (confirm('確定要刪除此產品嗎？此操作無法復原。')) {
                    productItem.remove();
                    
                    // 如果沒有產品了，顯示空狀態
                    if ($('#products-container .product-item').length === 0) {
                        $('#products-container').append('<div class="text-center text-muted py-3">尚無產品，請點擊「新增產品」按鈕新增產品</div>');
                    }
                }
            }
        }

        async saveProducts() {
            try {
                // 驗證所有產品資料
                const productItems = $('#products-container .product-item');
                const products = {};
                const errors = [];
                
                productItems.each(function() {
                    const $item = $(this);
                    const productKey = $item.data('product-key');
                    const code = $item.find('.product-code').val().trim().toUpperCase();
                    const name = $item.find('.product-name').val().trim();
                    
                    // 驗證必填欄位
                    if (!code) {
                        errors.push('所有產品都必須填寫產品代碼');
                        return false;
                    }
                    if (!name) {
                        errors.push('所有產品都必須填寫產品名稱');
                        return false;
                    }
                    
                    // 檢查代碼是否重複
                    const existingProduct = Object.values(products).find(p => p.code === code);
                    if (existingProduct) {
                        errors.push(`產品代碼 "${code}" 重複，請使用不同的代碼`);
                        return false;
                    }
                    
                    products[productKey] = {
                        code: code,
                        name: name
                    };
                });
                
                if (errors.length > 0) {
                    this.showAlert(errors[0], 'warning');
                    return;
                }
                
                const response = await fetch('/api/eeform/eeform2/products', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ products: products })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    $('#productModal').modal('hide');
                    this.showAlert('產品設定更新成功', 'success');
                    // 重新載入資料以反映變更
                    this.loadData();
                } else {
                    this.showAlert('更新失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('更新產品設定失敗:', error);
                this.showAlert('更新產品設定失敗，請稍後再試', 'danger');
            }
        }


        async exportSingleForm(id) {
            try {
                const response = await fetch(`/api/eeform/eeform2/export_single/${id}`);
                
                if (!response.ok) {
                    throw new Error('匯出請求失敗');
                }
                
                const blob = await response.blob();
                
                // 創建下載連結
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                
                // 設定檔名
                const now = new Date();
                const timestamp = now.toISOString().slice(0, 19).replace(/:/g, '-');
                a.download = `eform02_表單_${id}_${timestamp}.xlsx`;
                
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                this.showAlert('Excel 表單已成功匯出', 'success');
            } catch (error) {
                console.error('匯出表單失敗:', error);
                this.showAlert('匯出表單失敗，請稍後再試', 'danger');
            }
        }

        showAlert(message, type) {
            // 使用 Sweet Alert 顯示通知
            if (typeof Swal !== 'undefined') {
                // 判斷通知類型
                let icon = 'info';
                if (type === 'success') icon = 'success';
                else if (type === 'danger' || type === 'error') icon = 'error';
                else if (type === 'warning') icon = 'warning';
                
                Swal.fire({
                    title: message,
                    icon: icon,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                // 備援：使用原本的 Bootstrap alert
                $('.alert').remove();
                const alert = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                $('body').prepend(alert);
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 3000);
            }
        }
    }

    // 頁面載入完成後初始化
    $(document).ready(function() {
        const admin = new EForm2Admin();
        window.admin = admin; // 設為全域變數供按鈕使用
    });
</script>