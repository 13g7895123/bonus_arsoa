# CI3 專案功能與測試文檔

## 專案概述

CI3 專案是從原始專案轉移並重構的 CodeIgniter 3 應用程式，專注於電子表單（EForm）功能的實現。專案採用 Docker 容器化部署，包含完整的前後台管理功能。

## 專案架構

### 目錄結構
```
ci3/
├── application/           # CodeIgniter 應用程式主目錄
│   ├── config/           # 設定檔案
│   ├── controllers/      # 控制器
│   │   ├── api/eeform/  # API 控制器
│   │   ├── admin/       # 後台管理控制器
│   │   └── Eform.php    # 前台表單控制器
│   ├── models/eeform/   # 資料模型
│   ├── views/           # 視圖檔案
│   │   ├── eeform/      # 前台表單視圖
│   │   ├── admin/       # 後台管理視圖
│   │   ├── layout/      # 版面配置
│   │   └── helper/      # 輔助視圖
│   ├── migrations/      # 資料庫遷移檔案
│   ├── service/         # 服務層
│   └── core/           # 核心擴充
├── docker/              # Docker 配置
├── public/              # 公開資源
│   └── assets/         # CSS/JS 檔案
├── docs/               # 文檔資料夾
├── docker-compose.yml  # Docker Compose 配置
├── .env               # 環境變數
└── README.md          # 專案說明
```

## 環境配置

### Docker 環境
專案使用 Docker Compose 管理多個服務：

#### 服務配置
- **nginx**: Nginx 網頁服務器 (Alpine 版本)
- **php**: PHP 7.4 with FPM
- **db**: MySQL 5.7 資料庫
- **phpmyadmin**: 資料庫管理介面

#### 環境變數 (.env)
```env
# Docker Compose 環境變數
WEB_PORT=9119        # 網頁服務埠號
DB_PORT=9219         # 資料庫埠號
PMA_PORT=9319        # phpMyAdmin 埠號

# 資料庫配置
DB_ROOT_PASSWORD=rootpassword
DB_NAME=ci3_database
DB_USER=ci3_user
DB_PASSWORD=ci3_password
```

### 快速啟動
```bash
# 1. 複製環境設定檔
cp .env.example .env

# 2. 啟動容器
docker-compose up -d --build

# 3. 執行資料庫遷移
php migrate.php

# 4. 測試訪問
# 網頁應用程式: http://localhost:9119
# phpMyAdmin: http://localhost:9319
```

## 已實現功能

### 電子表單系統

#### 前台表單 (Frontend Forms)
1. **EForm1** - 肌膚檢測表單
   - 路徑: `/eform/eform1`
   - 功能: 會員基本資料、肌膚狀況評估
   - 特色: 自動帶入會員資訊、智慧化表單填寫

2. **EForm2** - 會員服務追蹤表單 (肌膚)
   - 路徑: `/eform/eform2` 
   - 功能: 產品使用追蹤、效果評估
   - 特色: 動態產品選擇、測試資料功能

3. **EForm4** - 進階肌膚分析表單
   - 路徑: `/eform/eform4`
   - 功能: 詳細肌膚分析、產品建議
   - 特色: 健康困擾評估、個人化建議

#### 後台管理系統 (Backend Management)
1. **Form1 管理** - `/admin/form1`
   - 提交記錄查看
   - 詳細資料檢視
   - 資料匯出功能

2. **Form2 管理** - `/admin/form2`
   - 會員追蹤管理
   - 產品編輯功能
   - Excel 匯出

3. **Form4 管理** - `/admin/form4`
   - 進階分析管理
   - 批次處理功能
   - 統計報表

#### API 端點系統
- **EForm1 API**: `/api/eeform/eeform1/`
  - `POST /submit` - 提交表單資料
  - `GET /list` - 取得提交記錄列表
  - `GET /submission/{id}` - 取得特定提交資料

- **EForm2 API**: `/api/eeform/eeform2/`
  - 完整 CRUD 操作
  - 產品管理 API
  - 資料統計功能

- **EForm4 API**: `/api/eeform/eeform4/`
  - 進階分析 API
  - 批次處理端點
  - 報表生成功能

### 資料庫架構

#### 遷移檔案 (Migrations)
專案包含 5 個主要遷移檔案：

1. **20250906000001_add_eeform1_tables.php**
   - eeform1_submissions: 基本提交資料
   - eeform1_skin_scores: 肌膚評分資料
   - eeform1_product_usage: 產品使用記錄

2. **20250906000002_add_eeform2_tables.php**
   - eeform2_submissions: Form2 提交資料
   - eeform2_products: 產品資訊管理
   - eeform2_usage_tracking: 使用追蹤

3. **20250906000003_add_eeform3_tables.php**
   - eeform3_submissions: Form3 相關資料表

4. **20250906000004_add_eeform4_tables.php**
   - eeform4_submissions: Form4 提交資料
   - eeform4_health_concerns: 健康困擾記錄
   - eeform4_recommendations: 建議記錄

5. **20250906000005_add_eeform5_tables.php**
   - eeform5_submissions: Form5 相關資料表

## 技術特色

### 前端技術
- **jQuery**: 主要 JavaScript 框架
- **Bootstrap**: 響應式 CSS 框架
- **日期選擇器**: 自定義日期輸入元件
- **Ajax**: 非同步資料傳輸
- **動態表單**: 智慧化表單填寫功能

### 後端技術
- **CodeIgniter 3**: PHP 框架
- **MVC 架構**: 清晰的代碼分離
- **Service 層**: 業務邏輯封裝
- **Migration 系統**: 資料庫版本控制
- **RESTful API**: 標準化 API 設計

### 安全特性
- **輸入驗證**: 完整的表單驗證機制
- **SQL 注入防護**: 使用 Active Record
- **CSRF 保護**: 表單令牌驗證
- **資料清理**: 輸入資料淨化

## 測試框架

### 自動化測試腳本

#### 1. test_all_forms.php
```bash
#!/usr/bin/env php
php test_all_forms.php
```
**功能**:
- 測試所有表單頁面載入
- API 端點連通性測試
- 資料庫連線驗證
- 檔案結構完整性檢查

#### 2. test_css.php
```bash
php test_css.php
```
**功能**:
- CSS 檔案載入測試
- 樣式相容性檢查
- 響應式布局驗證

#### 3. test_eforms.php
```bash
php test_eforms.php
```
**功能**:
- 表單提交功能測試
- 資料驗證測試
- JavaScript 功能測試

#### 4. run_tests.sh
```bash
./run_tests.sh
```
**功能**:
- 執行所有測試腳本
- 生成測試報告
- 錯誤日誌收集

### 測試覆蓋範圍

#### A. 前端測試
- ✅ 頁面載入測試
- ✅ CSS 樣式套用測試
- ✅ JavaScript 功能測試
- ✅ 響應式設計測試
- ✅ 表單驗證測試

#### B. 後端測試
- ✅ 控制器載入測試
- ✅ 模型功能測試
- ✅ Service 層測試
- ✅ API 端點測試
- ✅ 資料庫操作測試

#### C. 整合測試
- ✅ 前後端整合測試
- ✅ 資料流測試
- ✅ 使用者流程測試
- ✅ 錯誤處理測試

## 部署與維護

### 開發環境設置
```bash
# 1. 複製專案
git clone <repository>
cd ci3

# 2. 設定環境
cp .env.example .env
# 編輯 .env 設定適當的埠號

# 3. 啟動服務
docker-compose up -d --build

# 4. 初始化資料庫
php migrate.php

# 5. 執行測試
php test_all_forms.php
```

### 生產環境部署檢查清單
- [ ] 環境變數設定正確
- [ ] 資料庫遷移已執行
- [ ] Web 服務器配置正確
- [ ] SSL 憑證配置 (如適用)
- [ ] 防火牆規則設定
- [ ] 備份機制建立
- [ ] 監控系統配置
- [ ] 日誌系統配置

### 維護與更新
1. **資料庫維護**
   - 定期備份資料庫
   - 執行資料庫最佳化
   - 監控資料庫效能

2. **應用程式維護**
   - 更新 PHP 依賴套件
   - 安全性更新
   - 效能最佳化

3. **Docker 維護**
   - 定期更新 Docker 映像
   - 清理無用容器和映像
   - 監控資源使用量

## 故障排除

### 常見問題

#### 1. CSS 樣式問題
**問題**: 頁面樣式顯示異常
**解決方案**:
```bash
# 檢查 CSS 檔案是否存在
php test_css.php

# 確認檔案路徑
ls -la ci3/public/assets/css/
```

#### 2. 資料庫連線問題
**問題**: 無法連接資料庫
**解決方案**:
```bash
# 檢查資料庫服務狀態
docker-compose ps

# 查看資料庫日誌
docker-compose logs db

# 重啟資料庫服務
docker-compose restart db
```

#### 3. API 404 錯誤
**問題**: API 端點返回 404
**解決方案**:
- 檢查路由配置 `application/config/routes.php`
- 確認控制器檔案存在
- 檢查 .htaccess 配置

#### 4. 表單提交失敗
**問題**: 表單無法提交
**解決方案**:
- 檢查 CSRF 令牌
- 驗證表單欄位
- 查看錯誤日誌 `application/logs/`

### 日誌與除錯

#### 錯誤日誌位置
- **應用程式日誌**: `ci3/application/logs/`
- **nginx 日誌**: 透過 `docker-compose logs nginx` 查看
- **PHP 日誌**: 透過 `docker-compose logs php` 查看
- **資料庫日誌**: 透過 `docker-compose logs db` 查看

#### 除錯模式
```php
// 在 application/config/config.php 設定
$config['log_threshold'] = 4; // 啟用所有日誌級別
```

## 效能最佳化

### 前端最佳化
- CSS/JS 檔案合併與壓縮
- 圖片最佳化與快取
- 瀏覽器快取設定
- CDN 使用 (如適用)

### 後端最佳化
- 資料庫查詢最佳化
- 快取機制實現
- Session 管理最佳化
- 記憶體使用最佳化

### 資料庫最佳化
- 索引最佳化
- 查詢最佳化
- 連線池管理
- 定期維護

## 安全性考量

### 資料保護
- 敏感資料加密
- 輸入資料驗證
- 輸出資料過濾
- SQL 注入防護

### 存取控制
- 使用者認證
- 權限管理
- Session 安全
- API 存取控制

### 系統安全
- 定期安全更新
- 日誌監控
- 異常檢測
- 備份與復原

## 未來擴展

### 計劃功能
- [ ] EForm3 和 EForm5 完整實現
- [ ] 進階報表系統
- [ ] 行動應用程式整合
- [ ] 即時通知系統
- [ ] 多語言支援

### 技術升級路徑
- CodeIgniter 4 升級評估
- PHP 8+ 相容性
- 現代化前端框架整合
- 微服務架構考量

## 總結

CI3 專案成功實現了從原始專案的轉移與重構，提供了完整的電子表單管理解決方案。專案具備以下優勢：

1. **完整性**: 包含前台、後台、API 的完整功能
2. **可維護性**: 清晰的代碼結構和文檔
3. **可擴展性**: 模組化設計便於功能擴展
4. **穩定性**: 完整的測試框架保證代碼品質
5. **可部署性**: Docker 容器化部署簡化操作

專案為後續的功能開發和系統擴展提供了堅實的基礎。

---

**文檔建立日期**: 2025-09-07  
**專案版本**: CI3 v1.0  
**維護狀態**: ✅ 正常維護中  
**負責人**: Claude Code Assistant