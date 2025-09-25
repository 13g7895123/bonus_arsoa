1. 幫我調整一下/eform/eform1這一頁，get參數identify=guest，隱藏會員編號的欄位，且會員姓名為input，讓使用者自己填寫
2. 承1，幫我確認一下，get參數identify=guest的時候，後端是否會有驗證邏輯上的錯誤，檢查code的部分就好，幫我統一用identity，phone的部分為非必填
3. 幫我調整一下/eform/eform1這一頁，如果身份為來賓，請幫我偵測會員姓名、出生年月日、電話這三個欄位，每次只要有編輯，就檢查三個欄位，請離開欄位再執行檢查，如果三個欄位都有帶入資料，請幫我寫一隻function，先跳提示通知"有資料!"
4. 幫我調整一下/eform/eform1_list這一頁，提示的title請用系統提示，message才是"請選擇要編輯的表單"，icon用info
5. 讀取下面這段預儲程序，告訴我他要怎麼使用
預儲程序名稱 ：  ww_chkguest
參數  : @test  smallint  1.測試用 0.正式模式 (產生來賓編號並新增資料到 MSSQL ,MYSQL )
       @d_spno char(7)   填寫資料的會員代號 (官網登入的會員編號)
	  @cname  nvarchar(20) 來賓姓名
       @bdate  varchar(8) 來賓生日 西元年月日(個位數月日前一碼請補0) 
	  @cell    vachar(20) 來賓電話

傳回值: errcode  smallint   0.來賓身分通過驗證(正常模式會產生來賓編號回存 member 檔)
					   1.已存在此來賓(傳回該來賓的編號c_no)
                            2.已存在此來賓,但推薦人是不相同的
					   3.已存在此來賓,但她已經是會員了

範例: ww_chkguest @test , @d_spno,@cname,@bdate,@cell

 測試模式
 ww_chkguest 1 ,’000000 ‘,’章喆’,’19780615’,’0966-123-456’

正式模式
 ww_chkguest 0 ,’000000 ‘,’章喆’,’19780615’,’0966-123-456’
 6. 那針對這段預儲程序，實際上要怎麼使用他，使用API嗎? 對方說這個可以用mysql，用mysql的話要怎麼處理，我可以查詢mysql中是否有這段預儲程序嗎? 可以的話我要怎麼查詢，INFORMATION_SCHEMA要怎麼使用，完整流程為何
 7. 承6，可以幫我寫一隻API，連線到mysql與mssql，確認預儲程序是否存在，並且如果存在，用測試資料測試看看，並顯示回傳的內容，我目前使用API網址/api/eeform1/test_procedure，他都顯示404，幫我確認是哪裡的問題，請不要再改ci3專案了，跟目錄的專案才是我要用的，mssql連線的部分，請先幫我隱藏，先處理mysql就好
 8. 目前有一支GET的API用於測試預儲程序，API路徑為/api/eeform1/test_procedure，執行後出現這個錯誤，"MySQL 預儲程序執行失敗: MySQL 預儲程序調用失敗: Unknown column 'member_type' in 'field list'"，如果預儲程序有疑問，可以看一下第五點，幫我修復後確認邏輯沒問題即可，不用測試，沒有環境可以測試，告訴我可能出現這個錯誤訊息的原因，請用zh-tw回覆
 9. 請確認一下預儲程序是否有分為測試與正式模式，並確保API有符合可以使用
 10. 看到/eform/eform1這一頁，針對第三點的那三個特定欄位檢查，在輸入後達成檢測條件(即三個欄位都有資料)時，請用sweetalert調出提示，icon為warnig，title為"系統提示"，text為"確認來賓資料，請稍後"，並且執行測試的預儲程序的API，且確認回傳的code，code小於等於1就提示icon為success，title為"系統提示"，text為"檢測成功，請繼續填寫表單"，否則提示錯誤"檢驗錯誤，請確認資料是否有誤"，完成後執行正式的預儲程序API，取得c_no存到資料庫
 11. 幫我找一下這兩個功能的相關程式，採購車、組織專區，看一下是否有呼叫MSSQL 下的SP 的做法，有的話請列出來給我，請用zh-tw回答
 12. 那參考一下第五點的描述，寫一隻API使用第五點的SP程序，並告訴我要如何使用，請用zh-tw回答，等等，需要確認系統上的SP是mysql還是mssql的，如果是mysql請移除，並參考11點的相關sp用法調整出一個第五點的mssql版本，他出現這個錯誤，"Cannot redeclare Eeform1Model::check_mssql_procedure() in <b>C:\inetpub\wwwroot\models\eeform\Eeform1Model.php</b> on line <b>1465"
 13. 承12，目前測試已通過，幫我寫一支API，請依據流程，寫一支測試模式API可以驗證使用者資料，與一支正式模式可以建立來賓編號
 14. 看到/eform/eform1這一頁
	- 針對第三點的那三個特定欄位檢查，在輸入後達成檢測條件(即三個欄位都有資料)時，請用sweetalert調出提示，icon為warnig，title為"系統提示"，text為"確認來賓資料，請稍後"，並且執行第13點的測試模式API，且確認回傳的code，code小於等於1就提示icon為success，title為"系統提示"，text為"檢測成功，請繼續填寫表單"，否則提示錯誤"檢驗錯誤，請確認資料是否有誤"，然後在表單提交後後執行第13點的正式模式API，取得存到member_id欄位，並且要多代一個is_guest=0到後端，is_guest這個欄位是新的，請更新model的部分，他在eeform2_submissions這張表
15. 承14，應該是在eeform1_submissions才對，幫我更正改錯的地方，另外測試模式API要用那三個欄位的資料帶入，不要用寫死的固定資料d_spno代入目前填寫者的會員編號，其餘三個欄位分別為會員姓名、出生年月日、電話這三個欄位，記得生日要調整格式
16. 目前/eform/eform1?identity=guest這個網址送出後會出現錯誤，如果錯誤的話幫我回傳執行的錯誤訊息或是insert SQL，create_submission returned false只回了這個我無法除錯，等等，不要用error_log的方式，請幫我回傳在response就好!
17. 幫我調整一下，看到第14點，要多一個is_guest=0這個資料並沒有被帶入insert中，並且有一個identify的欄位請幫我移除，他用不到了
18. 幫我改回用identify好了，Undefined variable: identity，eeform/Eeform1Model.php，Line Number: 216，寫入資料的部分is_guest欄位沒有移除，這個用不到了，幫我全面徹查並移除，來賓判斷還是要保留，只是寫入的時候不用那個欄位了，已全面改用identity欄位

