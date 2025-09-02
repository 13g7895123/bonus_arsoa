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
19. 檢視的時候一樣把狀態拿掉，最下方的關閉按鈕無法使用，調整一下檢視的排版，現在有很多不好看的情況，文字會有很長的可能，請預留空間
20. 搜尋按鈕請往下調整，與旁邊的下拉選單齊高，彈出視窗的顯示欄位名稱條大一點，內容請多一點padding，彈窗可以寬一點沒關係，確保內容乾淨又好看
21. 幾個問題，彈窗title移除被景色，保持圓角，彈窗內容每一個block之前多一點間隔，每一個block可以寬一點，block對內容幫我加上padding，讓整個彈窗寬度多一點，多很多也沒有關係，右上角的叉叉位置跑掉了
22. 找到border mb-6 rounded這個class的element，加入內距，且需要是在彈窗中
23. 彈窗中的資料格式請參考該彈窗中的系統資料的格式，label+input，不要像上面那樣，太醜了，原本的input樣式怎麼不見了
24. 刪除按鈕沒有用sweet alert提示，表格幫我加入分頁的功能，彈窗的叉叉幫我拿掉，並且表格中的文字幫我放大一點
25. 完成以下功能
    - 幫我在title旁邊多一顆編輯商品的按鈕，點進去可以調整eform02的商品，前後台的相關地方都會跟著調整
    - 表單幫我加入匯出excel的功能
26. 完成以下功能
    - 編輯商品需要可以新增刪除修改商品
    - 匯出Excel的部分是每一份表單多一顆匯出的按鈕，匯出的內容是前台的表單內容
27. 完成以下功能
    - 編輯商品的儲存變更請幫我用POST，並確認前後端都要修改，路由檔案沒有加
    - 商品應該是存在資料庫的，不要使用任何實體檔案儲存，e
    - 匯出的EXCEL幫我調整格式，請用欄位與value的方式顯示
28. 27點調整後編輯商品又沒有帶入當前的商品資料了
29. 前台的eform2沒有多這一個產品，請幫我同步更新
30. 幫我把以下項目加入CLAUDE.md
    - 如果專案以連結git的repo，於docs\prompt.md完成每一個項目後，執行add commit push，且不可有協同開發者
31. 我在後台的eeform_manage_eeform02的編輯商品中，把產品刪掉儲存後，再次打開編輯他又出現了
32. 新增的商品請幫我加在最後面即可
33. 檢視詳細資料的時候，似乎排序又變更了
34. 幫我移除項目刪除的功能
35. 幫我以這個eeform_manage_eeform02為模板，建置出eeform_manage_eeform04的後台，基本上只有產品不一樣而已
36. Cannot redeclare Eeform4Model::get_submission_by_id()
37. 完成以下功能
    - 為甚麼搜尋長的不一樣
    - 編輯商品的按鈕移到title右側
    - 表單標題也不見了
    - 表單顯示內容是一堆html
38. 你誤會我的意思了，我要的搜尋是02的，幫我把目前的都改回原先02的搜尋，可以透過git log查詢原先的程式碼，然後表單顯示的內容04還是一樣是錯的
39. 02顯示改回來了，但資料沒有正常出現，04畫面都沒改，一樣全部都是錯的
40. 我目前看到04的data-table-body是一整駝的html，然後02的編輯商品的彈出視窗，幫我寬度改成跟04一樣
41. 02編輯商品的彈窗的CSS請比照04的辦理，04的顯示頁面字體請比照02辦理
42. 完成以下項目
    - 02與04的搜尋按鈕顏色請統一
    - 搜尋功能的字體與相關css請統一
    - 提交記錄列表的重新整理按鈕兩個頁面請統一移到最右側
    - 該頁面所有按鈕的hover顏色可以幫我加深就好嗎，不要藍變綠很噁心
43. 兩邊的按鈕樣式還是一樣沒有統一，請幫我統一比照02的處理
44. 幫我實作eform/eform5這個頁面的後台管理，請存取git log，實作完成包含側邊欄設定的完整項目，需要留意model與controller在做的時候，不要重複新增一樣的function
45. 檢視詳細資料的時候會跳出載入失敗，幫我確認一下問題，Call to a member function result_array() on bool
46. 目前職業與建議都是有填資料的，但後台的檢視詳細資料都沒有顯示這部分的資料
47. 前台還是一樣沒有顯示職業與健康困擾的資訊
48. 不好意思，前台是正常的，幫我改回來，我指的是後台的部分
49. 幫我回到這個頁面，每筆資料的檢視滑上去的時候幫我顯示顯示的文字，編輯也是，然後他檢視或編輯的時候會打API，/api/eeform1/submission/5，例如這支，但回傳的data中的skin_scores都是空的，幫我檢查一下是否真的是空的資料，還是邏輯有錯誤
50. 幫我看一下/eform/eform3_list與/eform/eform3的功能，建立後台的功能，規則與44點一樣
51. 幫我看一下/eform/eform1_list與/eform/eform1的功能，建立後台的功能，規則與44點一樣
52. 51點的api路徑錯了，應該要到的eeform資料夾中才對，我檔案拉進去了，幫我同步調整其他地方
53. 目前目前form1與form3後台載入資料都有問題，請確認API是否正常，並且，該兩份表單，在前台是兩層的，幫我確認後台這樣的結構是否符合
54. eeform3的controller幫我移到eeform這個資料夾中，並同步調整路由的配置，確認功能可以正常運行
55. /api/eeform/eeform1/list這隻API一樣是錯的，Call to a member function result_array() on bool，同步確認eeform3是否有一樣的錯誤
56. 承55，錯誤訊息為"Call to a member function num_rows() on bool"
57. 幫我在/eform/eform1的會員自動帶入資料的部分加入調整，原先controller代入的不變，但在進入網頁後，幫我多打一支API，執行這個SQL"Select c_no from member where c_no=@x or d_spno=@x"，@x的部分是會員編號，如果有傳回一筆以上的會員資料，幫我把姓名的地方改成下拉選單，內容為取得的會員資料，會員編號改成readonly，會依據他選擇的姓名更新會員編號，同時需要留意送出時有抓到正確資料
58. 目前沒有看到任何57點的功能有實現，幫我多加一點console以判斷功能是否正常
59. jquery.lazyload.min.js:1 Uncaught TypeError: $(...).lazyload is not a function是因為跳了這個錯誤導致console都失效嗎
60. 承57.為甚麼我進頁面沒有看到打API確認的request
61. 為甚麼/eform/eform1的路徑顯示/eform/eform2的表格
62. 請幫我把57製作在/eform/eform1的功能，同步製作到/eform/eform2、/eform/eform4中
63. 幫我移除/wadmin/admin_eeform/eeform_manage_eeform05這個頁面表單詳細資料中的系統資料與提交資訊兩個區塊
64. 幫我完成以下功能
    - 先幫我add commit push
    - 關閉/eform/eform1~/eform/eform5的填入測試資料的功能
    - /eform/eform3的計畫A改成計畫1，B改成2
    - 幫我add commit push
65. 幫我讀取docs\sql\eeform1.md，針對這個功能的sql寫一個刪除所有資料的sql加在最下面
66. 幫我參考65點，同步新增docs\sql\eeform2.md~docs\sql\eeform5.md的部分
67. /eform/eform3這個頁面，如果第二次填的話，請幫我自動帶入年齡與身高
68. 這三個欄位為必填"姓名、生日、電話"，幫我用紅色的字體，並且確認有必填驗證，67點的部分帶入資料幫我欄位唯讀