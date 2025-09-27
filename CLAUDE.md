# 專案環境資訊

這個專案沒有任何環境設定，所以執行後請不要在本地進行任何測試，都是無效的。

## 重要注意事項
- 不要嘗試在本地運行或測試應用程式
- 所有測試和執行都應該在實際部署環境中進行
- 本地執行不會產生有效的結果

## Git 操作說明

docs\prompts.md中的項目完成執行標準git操作：`git add` → `git commit` → `git push`
- commit message 使用英文，不包含協作資訊
- 推送至遠端 master 分支

## 已完成項目

### 2025-09-28 - eform1/eform2 API 結構優化完成
- **項目30**: 移除多餘的 `ww_chkguest_test` API，優化 `test_procedure` API
- 移除不必要的 `ww_chkguest_test` API 方法，避免功能重複
- 修改現有 `test_procedure` API 接受前端真實資料（`cname`, `bdate`）
- 移除不必要的 `d_spno` 和 `cell` 參數，簡化 API 結構
- 更新前端呼叫原始 `test_procedure` 端點，避免 API 重複
- 移除多餘的路由配置，簡化系統架構
- **項目31**: 確認 eform2 已符合相同優化標準
- eform2 系統結構已優化：使用 `ww_chkguest_test` 和 `ww_chkguest_create` API
- 前端僅傳送必要參數（`cname`, `bdate`），後端使用預設 `d_spno` 值
- 兩系統架構統一：無重複 API，功能單一明確，提升可維護性

### 2025-09-27 - eform1/eform2 API 一致性修正完成
- **項目29**: 完整修正 eform1 和 eform2 之間的 API 一致性問題
- 為 eform1 新增 `ww_chkguest_test` API 端點匹配 eform2 功能
- 移除前端 `d_spno` 參數傳送，改為後端使用預設值 '000000'
- 移除 `cell` 電話參數要求，統一僅需 `cname` 和 `bdate` 參數
- 更新前端驗證邏輯，僅監聽姓名和生日兩個欄位
- 修正 routes.php 添加缺失的 API 路由配置
- 確保 eform1 和 eform2 具有完全一致的 API 行為和參數要求
- 統一使用 GET 方法進行測試驗證，POST 方法進行正式創建
- 整合 SweetAlert2 提供友善的使用者提示和錯誤處理

### 2025-09-27 - eform02_list 身分選擇與篩選功能
- **項目28**: 完整實作 `/eform/eform02_list` 頁面身分選擇與篩選功能
- 新增 SweetAlert2 身分選擇提示視窗（會員/來賓）
- 實作雙重搜尋介面：會員搜尋（編號/姓名）和來賓搜尋（姓名/生日）
- 頁面載入時預載所有資料，選擇身分後才顯示對應資料
- 實作前端資料篩選邏輯，確保會員和來賓資料完全分離
- 表單連結動態加入 identity 參數（?identity=member 或 ?identity=guest）
- 搜尋和清除功能都維持在選擇的身分範圍內
- 與 eform01_list 功能完全一致

### 2024-01-01 - eform2 來賓模式完整支援
- **項目1**: 完整實作 `/eform/eform2` 頁面來賓模式功能
- 支援 `identity=guest` GET 參數檢測，前後端一致處理
- 來賓模式下完全隱藏會員編號欄位（表單和確認視窗）
- 來賓模式下會員姓名改為可編輯的輸入框，讓使用者自己填寫
- 來賓模式下跳過會員資料初始化邏輯
- 前端表單驗證移除會員編號必填檢查（僅限來賓模式）
- 後端提交時排除 `member_id` 欄位，加入 `identity=guest` 參數
- 修正後端 API 和 Model 正確處理 identity 欄位
- 新增 SQL 腳本建立 identity 欄位到 eeform2_submissions 資料表
- 確保前後端驗證邏輯完全一致，identity 參數正確儲存到資料庫

## 專案功能說明

### eform03 微微卡日記表單
- 完整的表單送出功能，包含資料驗證
- 送出前確認視窗，採用簡潔素樸的設計風格
- 測試資料填入功能（可透過變數控制顯示）
- 所有圓角樣式已移除，採用直角設計