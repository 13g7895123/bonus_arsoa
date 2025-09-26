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

### 2024-01-01 - ww_chkguest API 修正
- **項目19-22**: ww_chkguest 預儲程序 API 完整實作與修正
- 移除電話參數，修正預儲程序參數數量錯誤
- 建立完整的 API 使用文檔於 `docs/info/ww_chkguest.md`
- API 端點：`/api/eeform1/ww_chkguest_test` (測試模式) 和 `/api/eeform1/ww_chkguest_create` (正式模式)
- 修正 MSSQL 預儲程序調用參數數量問題

## 專案功能說明

### eform03 微微卡日記表單
- 完整的表單送出功能，包含資料驗證
- 送出前確認視窗，採用簡潔素樸的設計風格
- 測試資料填入功能（可透過變數控制顯示）
- 所有圓角樣式已移除，採用直角設計