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
    
    /* Make modals extra wide */
    #detailModal .modal-dialog,
    #productModal .modal-dialog {
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

    <!-- 編輯商品的 Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">編輯商品設定</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-sm" onclick="admin.addProduct()">
                            <i class="lnr lnr-plus-circle"></i> 新增產品
                        </button>
                    </div>
                    <div id="products-container">
                        <!-- 產品清單會在這裡動態載入 -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="admin.closeProductModal()">取消</button>
                    <button type="button" class="btn btn-primary" onclick="admin.saveProducts()">儲存變更</button>
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
            apiBaseUrl: '/api/eeform/eeform2',
            productsData: []
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

            // 綁定編輯商品按鈕
            document.getElementById('edit-products-btn').addEventListener('click', function() {
                admin.showProductModal();
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
                const healthCondition = item.skin_health_condition 
                    ? (item.skin_health_condition.length > 50 
                        ? item.skin_health_condition.substring(0, 50) + '...' 
                        : item.skin_health_condition)
                    : '';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="display: none;">${item.id}</td>
                    <td>
                        <strong>${item.member_name || ''}</strong>
                    </td>
                    <td>
                        ${item.gender || ''} / ${item.age || ''}歲
                    </td>
                    <td>${item.join_date || ''}</td>
                    <td title="${item.skin_health_condition || ''}">${healthCondition}</td>
                    <td class="text-sm">
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
                    </td>
                `;
                tbody.appendChild(row);
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">會員姓名</label>
                                <input type="text" class="form-control" value="${data.member_name || ''}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">性別</label>
                                <input type="text" class="form-control" value="${data.gender || ''}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">年齡</label>
                                <input type="text" class="form-control" value="${data.age ? data.age + ' 歲' : ''}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">入會日</label>
                                <input type="text" class="form-control" value="${data.join_date || ''}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">見面日</label>
                                <input type="text" class="form-control" value="${data.meeting_date || ''}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">肌膚/健康狀況</label>
                                <textarea class="form-control" rows="3" readonly>${data.skin_health_condition || ''}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // 產品資料區塊
            let productsHtml = `
                <div class="border mb-6 rounded" style="padding: 1.5rem;">
                    <h6 class="mb-3">產品訂購</h6>
            `;
            
            if (data.products && data.products.length > 0) {
                productsHtml += '<div class="row">';
                data.products.forEach(product => {
                    productsHtml += `
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label">${product.product_name}</label>
                                <input type="text" class="form-control" value="${product.quantity} 個" readonly>
                            </div>
                        </div>
                    `;
                });
                productsHtml += '</div>';
            } else {
                productsHtml += '<p class="text-muted">未訂購任何產品</p>';
            }
            
            productsHtml += '</div>';

            // 聯絡資訊區塊
            let contactHtml = `
                <div class="border mb-6 rounded" style="padding: 1.5rem;">
                    <h6 class="mb-3">聯絡資訊</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">LINE聯絡狀況</label>
                                <textarea class="form-control" rows="3" readonly>${data.line_contact || ''}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">電話聯絡狀況</label>
                                <textarea class="form-control" rows="3" readonly>${data.tel_contact || ''}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">填寫日期</label>
                                <input type="text" class="form-control" value="${data.submission_date || ''}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.innerHTML = systemDataHtml + basicDataHtml + productsHtml + contactHtml;
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
                    confirmButtonColor: '#007bff'
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

        // 產品管理相關功能
        admin.showProductModal = async function() {
            try {
                // 載入目前的產品設定從資料庫
                const response = await fetch(`${admin.apiBaseUrl}/products`);
                const result = await response.json();
                
                if (result.success && result.data) {
                    admin.productsData = result.data;
                    admin.renderProducts(result.data);
                } else {
                    admin.productsData = admin.getDefaultProducts();
                    admin.renderProducts(admin.productsData);
                }
                
                $('#productModal').modal('show');
            } catch (error) {
                console.error('載入產品設定失敗:', error);
                admin.productsData = admin.getDefaultProducts();
                admin.renderProducts(admin.productsData);
                $('#productModal').modal('show');
            }
        };

        admin.getDefaultProducts = function() {
            return [
                {product_code: 'SOAP001', product_name: '淨白活膚蜜皂', product_category: 'soap', sort_order: 1},
                {product_code: 'SOAP002', product_name: 'AP柔敏潔顏皂', product_category: 'soap', sort_order: 2},
                {product_code: 'MASK001', product_name: '活顏泥膜', product_category: 'other', sort_order: 3},
                {product_code: 'TONER001', product_name: '安露莎化粧水I', product_category: 'toner', sort_order: 4},
                {product_code: 'TONER002', product_name: '安露莎化粧水II', product_category: 'toner', sort_order: 5},
                {product_code: 'TONER003', product_name: '安露莎活膚化粧水', product_category: 'toner', sort_order: 6},
                {product_code: 'TONER004', product_name: '柔敏化粧水', product_category: 'toner', sort_order: 7},
                {product_code: 'SERUM001', product_name: '安露莎精華液I', product_category: 'serum', sort_order: 8},
                {product_code: 'SERUM002', product_name: '安露莎精華液II', product_category: 'serum', sort_order: 9},
                {product_code: 'SERUM003', product_name: '安露莎活膚精華液', product_category: 'serum', sort_order: 10},
                {product_code: 'SERUM004', product_name: '美白精華液', product_category: 'serum', sort_order: 11},
                {product_code: 'LOTION001', product_name: '保濕潤膚液', product_category: 'lotion', sort_order: 12},
                {product_code: 'OIL001', product_name: '美容防皺油', product_category: 'other', sort_order: 13},
                {product_code: 'GEL001', product_name: '保濕凝膠', product_category: 'other', sort_order: 14},
                {product_code: 'ESSENCE001', product_name: '亮采晶萃', product_category: 'other', sort_order: 15},
                {product_code: 'SUNSCREEN001', product_name: '防曬隔離液', product_category: 'other', sort_order: 16},
                {product_code: 'FOUNDATION001', product_name: '保濕粉底液', product_category: 'foundation', sort_order: 17},
                {product_code: 'POWDER001', product_name: '絲柔粉餅', product_category: 'foundation', sort_order: 18}
            ];
        };

        admin.renderProducts = function(products) {
            const container = $('#products-container');
            container.empty();

            // products 現在是數組格式，按照 sort_order 排序（新產品會在最後面）
            const sortedProducts = Array.isArray(products) ? products.sort((a, b) => {
                const orderA = parseInt(a.sort_order) || 0;
                const orderB = parseInt(b.sort_order) || 0;
                return orderA - orderB;
            }) : [];
            
            if (sortedProducts.length === 0) {
                container.append('<div class="text-center text-muted py-3">尚無產品，請點擊「新增產品」按鈕新增產品</div>');
                return;
            }

            sortedProducts.forEach((productData, index) => {
                const productHtml = `
                    <div class="product-item mb-3 p-3 border rounded" data-product-id="${productData.id || ''}" data-product-code="${productData.product_code || ''}">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="form-label">產品代碼</label>
                                <input type="text" class="form-control product-code" value="${productData.product_code || ''}" placeholder="例：SOAP001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">產品名稱</label>
                                <input type="text" class="form-control product-name" value="${productData.product_name || ''}" placeholder="例：淨白活膚蜜皂">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">操作</label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="admin.removeProduct(this)">刪除</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">產品類別</label>
                                <select class="form-control product-category">
                                    <option value="soap" ${productData.product_category === 'soap' ? 'selected' : ''}>清潔</option>
                                    <option value="toner" ${productData.product_category === 'toner' ? 'selected' : ''}>化妝水</option>
                                    <option value="serum" ${productData.product_category === 'serum' ? 'selected' : ''}>精華液</option>
                                    <option value="lotion" ${productData.product_category === 'lotion' ? 'selected' : ''}>乳液</option>
                                    <option value="foundation" ${productData.product_category === 'foundation' ? 'selected' : ''}>底妝</option>
                                    <option value="other" ${productData.product_category === 'other' ? 'selected' : ''}>其他</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">產品描述</label>
                                <input type="text" class="form-control product-description" value="${productData.description || ''}" placeholder="產品描述（選填）">
                            </div>
                        </div>
                    </div>
                `;
                container.append(productHtml);
            });
        };

        admin.addProduct = function() {
            const container = $('#products-container');
            const productHtml = `
                <div class="product-item mb-3 p-3 border rounded" data-product-id="" data-product-code="">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label">產品代碼</label>
                            <input type="text" class="form-control product-code" value="" placeholder="例：SOAP003">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">產品名稱</label>
                            <input type="text" class="form-control product-name" value="" placeholder="例：新產品名稱">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">操作</label>
                            <div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="admin.removeProduct(this)">刪除</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label class="form-label">產品類別</label>
                            <select class="form-control product-category">
                                <option value="soap">清潔</option>
                                <option value="toner">化妝水</option>
                                <option value="serum">精華液</option>
                                <option value="lotion">乳液</option>
                                <option value="foundation">底妝</option>
                                <option value="other" selected>其他</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">產品描述</label>
                            <input type="text" class="form-control product-description" value="" placeholder="產品描述（選填）">
                        </div>
                    </div>
                </div>
            `;
            container.append(productHtml);
        };

        admin.removeProduct = function(button) {
            $(button).closest('.product-item').remove();
        };

        admin.saveProducts = async function() {
            const productItems = $('.product-item');
            const products = [];
            
            productItems.each(function() {
                const $item = $(this);
                const code = $item.find('.product-code').val().trim();
                const name = $item.find('.product-name').val().trim();
                const category = $item.find('.product-category').val();
                const description = $item.find('.product-description').val().trim();
                const id = $item.data('product-id');
                
                if (code && name) {
                    const product = {
                        code: code,
                        name: name,
                        category: category,
                        description: description || null
                    };
                    
                    if (id) {
                        product.id = id;
                    }
                    
                    products.push(product);
                }
            });
            
            if (products.length === 0) {
                admin.showAlert('請至少新增一個產品', 'warning');
                return;
            }

            try {
                const response = await fetch(`${admin.apiBaseUrl}/products`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({products: products})
                });

                const result = await response.json();

                if (result.success) {
                    admin.showAlert('產品設定儲存成功', 'success');
                    $('#productModal').modal('hide');
                } else {
                    admin.showAlert('儲存失敗: ' + result.message, 'danger');
                }
            } catch (error) {
                console.error('儲存產品設定失敗:', error);
                admin.showAlert('儲存失敗，請稍後再試', 'danger');
            }
        };

        admin.closeProductModal = function() {
            $('#productModal').modal('hide');
        };
    </script>