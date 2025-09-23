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
 8. 目前有一支GET的API用於測試預儲程序，API路徑為/api/eeform1/test_procedure，執行後出現這個錯誤，"MySQL 預儲程序執行失敗: MySQL 預儲程序調用失敗: Unknown column 'member_type' in 'field list'"，如果預儲程序有疑問，可以看一下第五點，幫我修復後確認邏輯沒問題即可，不用測試，沒有環境可以測試
 9. 請確認一下預儲程序是否有分為測試與正式模式，並確保API有符合可以使用
 10. 看到/eform/eform1這一頁，針對第三點的那三個特定欄位檢查，在輸入後達成檢測條件(即三個欄位都有資料)時，請用sweetalert調出提示，icon為warnig，title為"系統提示"，text為"確認來賓資料，請稍後"，並且執行測試的預儲程序的API，且確認回傳的code，code小於等於1就提示icon為success，title為"系統提示"，text為"檢測成功，請繼續填寫表單"，否則提示錯誤"檢驗錯誤，請確認資料是否有誤"，完成後執行正式的預儲程序API，取得c_no存到資料庫

