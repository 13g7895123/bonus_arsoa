1. 幫我分析views/eeform/eform02、views/eeform/eform04、views/eeform/eform05，這三份表單頁面，建立對應的資料表，並寫入docs\sql中，名字的部分eform02對應eeform2，另外兩張比照辦理，可以先參考views/eeform/eform03的作法
2. 幫我整理這三份文件，把要貼到資料庫的SQL的部分，複製一份放到最下面，讓我可以直接整段選取複製貼上
3. 參考views/eeform/eform03實作views/eeform/eform02、views/eeform/eform04、views/eeform/eform05的前端功能，用jquery的方式實作，完成後，幫我撰寫後端功能，路徑在controller/api/eeform底下，命名與功能可以參考Eeform3.php，完成後請與前端串接，並從頭確保一次邏輯正確，然後到config的config.php底下加入esrf_exclude_uris以及routes.php的路由的部分
4. 幫我把填寫日期自動帶入當天日期，會員基本姓名參考views/eeform/eform03自動從上一層帶入使用者資訊，另外加入填入測試資料的按鈕，使用者資訊如果有帶入就不用在填入測試資料裡面
5. 幫我打開這三張表單的測試按鈕，form5的部分，出生西元年與西元月請用日期選擇器
6. eform04、eform05的填入測試資料似乎沒有全部做，請幫我確認
7. 修復以下問題
    - 目前三張表單的填入測試資料還是有很多欄位沒有填入，input、radio、checkbox、等等的部分，請確實都填入測試資料
    - 表五的出生年月，年分的部分無法選擇，請確認日期選擇器沒有問題
8. 修復以下問題
    - eform02、eform04，提交都找不到後端路徑404，幫我重新確認
    - eform04的健康困擾都沒勾選，每日建議產品&攝取量也都是空的，請完成後確實檢查每一個欄位都有資料
9. eform05沒有提交的功能
10. eform2的填寫日期沒有帶入當天日期，eform2、eform4的見面日請不要填入預設值
11. 幫我view過整個專案，告訴我側邊攔在哪裡設定功能與項目
12. 我看完了，他在setup.xml設定，幫我view過完整專案，寫一份它裡面的設定詳細說明在docs\sidebar.md中
13. 目前eform2的前台已經處理好了，幫我處理後台的部分，需要可以管理該份電子表單的狀況，view的路徑在views/admin/eeform/form2.php，幫我用前後端分離的方式，直接寫html+jquery，api用fetch的方式，有需要打API的話看一下eform2當初建置的是否還有需要新增調整，調整一下，views/admin/eeform/form2.php這個檔案只要boby後的內容就好，html已經有了，除非有style幫我直接寫style即可
14. API有問題，Call to undefined method Eeform2Model::get_all_submissions_paginated()，另外後台的css似乎有跑掉，請重新確認
15. 最上面Title調整為會員服務追蹤管理表(肌膚)，小標題移除，ICON幫我查詢一下目前系統用甚麼，換成對應的ICON，不要用一個沒有引入的一直錯誤，功能按鈕的ICON也是，另外幫我外邊的padding大一點，太靠邊了
16. 你是一位專業的UIUX工程師，幫我調整一下頁面，讓顯示更好看一點，另外檢視與編輯按下去出現bootstrap is not defined，按鈕移上去要出現功能的名稱
17. 移除title的icon與最上方的統計資料，搜尋的狀態與表格的狀態也拿掉，表格的ID請隱藏，操作的檢視與編輯無法使用，通知請使用sweet alert
18. 移除編輯按鈕，檢視的時候請直接顯示前台表單的樣式與內容