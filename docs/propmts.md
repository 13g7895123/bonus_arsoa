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
69. 68點新增的欄位請幫我移除，必填驗證保留姓名即可，其餘的幫我移除
70. 移除會員姓名的必填，會員姓名與會員編號要唯讀
71. 完成以下功能
    - 幫我讀取views\admin\eeform\form3.php這支檔案
    - 922行的部分請調整，923的data[key]不會有資料，他的API回傳格式在activity_summary，請確認完API格式後幫我調整成正確的
    - js原生的部分改為jquery
72. 幫我讀取views\admin\eeform\form3.php這支檔案，他匯出EXCEL的部分會顯示html與亂碼，請幫我修正這個問題
73. 承72，匯出會出現這個錯誤Undefined index: hand_measure
74. /eform/eform4，產品沒有正常存入資料庫中，請幫我確認，另外，他有調整載入會員資料的功能，請幫我下拉選單預設為當前使用這
75. /api/eeform/eeform1/list?page=1&limit=20這支API有錯誤，"#0 C:\\inetpub\\wwwroot\\controllers\\api\\eeform\\Eeform1.php(444): Eeform1Model->get_all_submissions_paginated(1, 20, NULL, NULL, NULL)\n#1 C:\\inetpub\\system3.1.2\\core\\CodeIgniter.php(530): Eeform1->list()\n#2 C:\\inetpub\\wwwroot\\index.php(338): require_once('C:\\\\inetpub\\\\syst...')\n#3 {main}"
76. 針對74點，我選了三個產品，但是他只顯示一樣在後台的API中，幫我確認是否有正確存入，或是API邏輯錯誤
77. /eform/eform1、/eform/eform2，有調整載入會員資料的功能，請幫我下拉選單預設為當前使用者
78. 幫我關閉\views\eeform\eform01.php的所有console，需要留意是否有動到括號，不可以影響原先的功能
79. 幫我把\views\eeform\eform01.php的出生西元年與西元月整合成一個輸入，並更新相關的API檔案，幫我調整一下，我要西元年月就好，不要年月日
80. 完成以下功能，皆在/eform/eform1這個網頁路徑
    - 目前有加入會員姓名的下拉選單，幫我把顯示會員姓名的部分調整一下，目前後面會加括號並帶入會員編號，幫我移除後面括號這一段
    - 幫我打開填入假資料的功能，並且我希望假資料可以每次都任意挑欄位填寫，加以模擬使用者操作的真實性
    - 有提到會員姓名有加入下拉選單，移除後，送出的資料請幫我送出姓名即可
    - 並且幫我調整一下送出的資訊，當前使用者為代填問卷者，問卷選擇的會員為被填表人，請幫我調整後端資料庫加入這個欄位資訊，並且同步更新前後端
81. 幫我起一個ci3的專案在根目錄，請命名為ci3，並在其中建置docker-compose.yml，不要version，需要.env控制docker-compose.yml的對外PORT
82. webserver請幫我改用nginx，完成後請使用目前的.env啟用ci3傳案，並測試能正確顯示ci3的預設畫面
83. 幫我把views/eeform/eform1.php相關的檔案，包含model與controller等等，有關的檔案幫我複製一份到剛剛新建的ci3專案中
84. 請幫我把route建立起來，讓我可以使用這個功能，建立完後，請務必確認是正常可以使用的
85. 修復以下錯誤
    - Undefined property: CI_Loader::$block_service，報了這個錯誤，幫我補上service的部分，他沒有移過來
    - Call to a member function electronic_form_right_menu() ，views的helper也沒有移過來
    - 確認css可以使用
86. 你是不是沒有確認已經正常可以使用，我現在使用都一直轉圈圈，請幫我從頭到尾確認，完成後請add commit push
87. 幫我把docs\sql中的各表單的md轉成ci3的migration，並且幫我執行他，完成後ci3的form1應該可以正常送出，幫我寫測試程式，確保可以正常運行，並且正確存入資料庫中
88. css沒有吃到，請幫我重新確認
89. 從83點開始看到88點，views/eeform/eform2.php、views/eeform/eform4.php，也要轉移，包含資料庫，完成後建立測試，直到測試完成
90. 檢查轉移後的views/eeform/eform2.php、views/eeform/eform4.php，css沒有套用到，請執行後檢查，直到通過為止
91. 幫我針對後台的views/admin/eeform/form1.php、form2.php、form4.php，也複製一份到ci3，只要管理內容就好，維持可以測試功能即可，完成後，請幫我依序測試所有功能，eform1前台執行後，eform1_list有資料，後台也看的到資料，各項功能也可以運行
92. 目前第90點改完以後，views/eeform/eform2.php、views/eeform/eform4.php，頁面是無法使用的，請幫我嚴格確認一次，並且撰寫測試，然後把測試說明寫入docs\test中
93. 針對ci3的功能與測試開出一個說明檔案，寫入docs\ci3.md
94. 目前三個前台頁面似乎都有一樣的問題，css似乎沒有正常引入，請參照原先的專案，如果有使用到相關css、js檔案，請依據路徑複製到ci3專案的對應路徑中
95. js已正常載入，但css還是很多都沒有，請重新確認，並建立測試機制，確保完成所有項目的載入，以及功能正常
96. 請回顧我早上的git logs，早上七點多到八點這段時間的/eform/eform1這個路徑還是正常的，幫我修正回當時的版本
97. /eform/eform1的部分，會員名稱的部分有經過改動，變成會套用下拉選單，但是送出的時候似乎沒有加以判斷，還是以原先的input作為表單驗證的依據，進而導致使用下拉的時候表單驗證錯誤，幫我確認並修復這個問題，且需要測試是否正常，目前即使預設選擇了還是有一樣的問題
98. 預設的會員編號請幫我調整為000000，然後測試資料需要確保必填欄位都有資料
99. 程式碼中的註解與console不要出現任何point相關字樣
100. 移除目前的資料表，匯入docs\sql\eeform1.md中的建立資料庫的部分，並確保資料可以正常寫入，我開啟資料庫沒有看到，不要騙我，確實執行
101. 回覆請用繁體中文，目前資料表已經建置完成，幫我寫一支API確認可以寫入資料，我要直接可以打的API，我不要有測試介面的，幫我用GET的方式，不要POST，是不是沒有更新路由，404
102. Unknown column 'allergy_description' in 'field list'</p><p>INSERT INTO `eeform1_allergies` (`allergy_description`, `allergy_type`, `is_selected`, `submission_id`) VALUES (NULL,'seasonal',1,1)</p><p>Filename: controllers/api/eeform/Eeform1.php，寫入的資料請確認docs\sql\eeform1.md的資料表建立狀況，不要亂加入欄位
103. Duplicate entry '4-moisture-healthy' for key 'uk_submission_category_score'</p><p>INSERT INTO `eeform1_skin_scores` (`submission_id`, `category`, `score_type`, `score_value`, `measurement_date`) VALUES (4, 'moisture', 'healthy', 15, '2025-09-07')，請全部幫我確認過一遍
104. 有針對測試修改的部分同步修改正式的部分嗎
105. Swal is not defined，送出後有這個問題
106. 完成以下功能
    - /admin/form1後台頁面的部分有錯誤，data.forEach is not a function
    - 105的部分請同步確認表2與表4
    - 測試資料沒有用000000會員編號來處理
    - eform/eform1_list，資料取得錯誤，幫我確認API
107. 修復以下錯誤
    - /eform/eform1的部分，預設資料改為使用000000會員編號
    - /eform/eform1_list的API出現錯誤，請幫我寫測試，確認撈的資料有正確回覆，錯誤如下
    <p>Not unique table/alias: 's'</p><p>SELECT `s`.*
FROM `eeform1_submissions` `s`, `eeform1_submissions` `s`
WHERE `s`.`member_id` = 'DEMO001'
AND `s`.`member_id` = 'DEMO001'
ORDER BY `s`.`created_at` DESC
 LIMIT 10</p><p>Filename: models/eeform/Eeform1Model.php</p><p>Line Number: 388</p>
 108. 還是一樣是錯的阿，<p>Not unique table/alias: 's'</p><p>SELECT `s`.*
FROM `eeform1_submissions` `s`, `eeform1_submissions` `s`
WHERE `s`.`member_id` = '000000'
AND `s`.`member_id` = '000000'
ORDER BY `s`.`created_at` DESC
 LIMIT 10</p><p>Filename: models/eeform/Eeform1Model.php</p><p>Line Number: 391</p>
 109. 我選了下拉選單的人員，送出還是一樣被卡在驗證，他說我沒有填會員姓名
 110. 會員姓名送出的時候，請送出純姓名就好，不要其他的東西
 111. 完成以下功能
    - /eform/eform1送出的API錯誤了，代填問卷者的資訊請使用會員編號000000，姓名公司
    - 後台的部分一直顯示資料格式錯誤，但資料室有正確抓到的
    - 資料表的部分多顯示一個欄位，代填者的資訊
112. 完成以下功能
    - /eform/eform1_list的部分，資料請撈取代填者的資訊，不要用會員的資料去撈取
    - 這支API，/api/eeform1/member_lookup/000000，回傳的資料請用純姓名就好，後面不要帶其他資料
113. 112的第二點誤會我的意思了，我指的是會員姓名的部分不要在名字後面加資料，幫我調整回來，我還需要會員編號的資料
114. 幫我整理eeform1.md中要建立資料表的部分，全部寫在一起放到最下面，我需要一次建立全部
115. 完成以下功能
    - 讀取views\eeform\eform01.php，找到載入資料的/api/eeform1/member_lookup/{member_code}這支API，調整他，讓他回傳的資料會員姓名的部分，只要姓名就好，後面不要加其他資料
    - 再來，打開填入測試資料的功能
    - 送出的時候，幫我把當前會員的資料寫入代填入者的資訊中
    - 讀取views\eeform\eform01_list.php，這個頁面取得的資料，改為篩選代填入者的資料
    - /wadmin/admin_eeform/eeform_manage_eeform01，這個頁面表單，幫我加入一個顯示欄位，顯示代填入者的資訊
116. 115的第三點沒有代入，對應欄位為form_filler_id、form_filler_name
117. 完成以下功能
    - add commit push
    - 幫我在views\admin\eeform\form2.php的1109行加入滑順的滾到彈窗底部的功能
    - add commit push
118. 幫我為這個頁面views\admin\eeform\form2.php的datatable加入分頁的功能，預設單頁五筆，我要完整功能，包含可以設定的每頁，現在是第幾筆資料，總共有幾筆，上一頁與下一頁的功能，目前沒有總筆數資訊，也沒有可以選擇單頁筆數的功能，幫我排列好看一點，如果與原先的分頁有衝突或被覆蓋，幫我保留新的，文字請幫我全部用深色，且確定不要跑版，全部都在同一列即可，頁數跳轉的部分請在最右邊，其餘在左邊，分頁資料沒有正確顯示，顯示方式也很奇怪，請幫我確認正確，我不要再說第二遍，第一，你的顯示第幾筆，共幾筆根本沒帶資料進去，第幾頁也沒有，每頁顯示與下拉不要換行，一共三個項目，為甚麼現在每一個都在獨自的一行，似乎有一個user agent的style擋住了所有class的顯示導致跑版，幫我全部用style+!
119. 幫我在這個頁面/wadmin/admin_eeform/eeform_manage_eeform01的標題旁邊寫一顆刪除測試資料的按鈕，按刪除會刪除目前建立的所有資料，並且需要提示確認，請問一下，你的後端API呢，請確認model是否需要新增，請不要用DELETE的方式，用POST的方式處理
120. 幫我看到ci3中的/eform/eform5這個頁面，依據以下指示調整
    - 最上面的會員姓名、會員編號、出生年月、身高(公分)移除
    - 改成兩排欄位，第一排，手機號碼、姓名、性別，第二排，年齡、身高、運動習慣
    - 性別是下拉選單，選擇男女
    - 年齡則是顯示下拉，每一列內容的格式為"民國XX年出生 - XX歲"
    - 運動習慣為下拉，是與否
    - 其餘沒有提到的欄位都是input
    - 接下來下面有一個小標題"體測標準建議值"
    - 下面有一個表單，淺灰底，帶邊框，共有以下欄位，每三個一列，且placeholder都是限填數字
    - 體重Kg、BMI、脂肪率%、脂肪量Kg、肌肉%、肌肉量Kg、水份比例%、水含量Kg、內臟脂肪率%、骨量Kg、基礎代謝率(卡)、蛋白質%、肥胖度%、身體年齡、去脂體重KG
    - 後面接原先的表單，從職業那個欄位開始
    - 執行後請完整且逐項檢查一遍，看是否符合需求
121. 同一個頁面，完成以下功能
    - 年齡的部分，幫我下拉先塞入進100歲的資料，下拉選單沒有塞入近年一百歲的資料，目前看到"年齡選項將由JavaScript動態生成"，但實際上沒有生成
    - 建立這張表單的sql，姓名用member_name，並且要有member_id，寫入docs\sql\eeform5_new.md中，要幫我把建立的部分，整理一份寫在一起，讓我可以直接複製到SQL貼上，命名的部分請不要加_new，重新修改，已完成
122. 同一個頁面，完成以下功能
    - 我有看到showTestButton這個變數，但true沒有按鈕出現，幫我完成它的功能，並測試可以使用，並且塞入的資料幫我隨機
    - 送出表單的資料幫我member_name先用公司，member_id用000000
    - 同步建置表單api會用到的model與controller
    - api建置完成後更新前端的部分，確認表單送出有資料寫入各自對應的資料表中，需要建置測試機制，並測試到通過為止
    - 測試的部分，本地有docker環境，，如果容器沒有啟用，請先啟用再往下執行，請參照專案中的資訊連線測試，每次執行請務必確認執行到通過為止
    - 我沒有看到測試按鈕，資料庫也沒有東西寫入，請問你測試怎麼通過的
123. 同一個頁面，完成以下功能
    - 建立表單的部分請移除所有資料表名稱有_new的部分，並更新md檔案與model
124. 為甚麼需要eeform5_submissions_archive這張表，用繁中回答
125. 請移除這張表在code出現的地方，不需要，需要同步修改md檔案
126. 幫我為更新後的新表建立測試，需要每一項資料有正常寫入
127. 目前年齡還是沒有出現下拉選項，請務必確認網頁的內容，已有docker可以讓你測試了，不要再讓我看到錯誤
128. 幫我整理一下頁面，script只要一個就好，document ready也是，不要讓我看到一堆
129. 確認送出表單的部分，幫我用modal處理，我要看到表單完整資訊，請參考docs\source\image.png的樣式處理，不要用swal處理
130. $(...).modal is not a function，請幫我建立TDD測試，確保功能完全正確
131. 完成以下功能
    - 隱藏測試MODAL的按鈕
    - 送出後的提示請用sweet alert
    - 送出表單的api回傳錯誤Unknown column 'health_concerns_other' in 'field list'，不是說有建立TDD測試了嗎，為甚麼還會出現欄位錯誤，幫我前後端都測試過一次，確認沒有問題
    - 姓名與手機號碼幫我加上"(*必填)"，並且需要為紅色的文字
132. 完成以下功能
    - 欄位新增的部分，幫我更新docs\sql中的md檔案
    - 建議用量的部分沒有存入資料表中，幫我重新確認，並寫測試確認是否正確
133. 幫我完成/wadmin/admin_eeform/eeform_manage_eeform05這個頁面的功能
    - 請參考/wadmin/admin_eeform/eeform_manage_eeform04，建立/eform/eform5這個頁面的後台管理，須建立TDD測試機制，確保功能實作完成後都能正常運行
134. 你確定檢查過了嗎，/wadmin/admin_eeform/eeform_manage_eeform05這個頁面，光載入這個API，/api/eeform/eeform5/list?page=1&limit=20，就直接報錯誤，明明API回傳是200阿，請用心建立TDD，並確實完成，Cannot read properties of undefined (reading 'total')
135. 欄位名稱與顯示資料不匹配，點檢視打的API，/api/eeform/eeform5/submission/1，會顯示404錯誤，你真的有認真檢查過所有功能嗎
136. /wadmin/admin_eeform/eeform_manage_eeform05這個頁面，/api/eeform/eeform5/export_single/1，這支匯出EXCEL功能的API無法使用，幫我建立測試機制，確保運行正常
137. 匯出功能我套了一個模板了，幫我把內容修正成eeform5的內容即可
138. 完成以下功能
    - add commit push
    - 把/eform/eform1_list複製到/eform/eform2_list這個路徑，並且把欄位的出貨日期移除，會員(來賓)資訊改成會員，其餘保留，查看的時候可以看到內容即可，需要幫我確認是否有缺少api，有的話請幫我補齊，幫我調整一下，查看與編輯沒有顯示正確的表單資料，需要調整成/eform/eform2的資料
139. 檢查/eform/eform2_list，一堆js錯誤，到底在幹嘛
140. 訂購商品樣式請與/eform/eform2一致，代填者資訊幫我隱藏，樣式明明就是直接顯示訂購數量，到底為甚麼會變成勾選，請用心執行!
141. 更新表單的功能使用了POST，但卻method not allow，幫我調整API為POST，不要給我用PUT
142. 我更新了資料，但送出後打開一樣是沒有更新的資料，幫我確認更新資料是否有哪一段錯誤了，訂購產品的部分沒有更新，你改好之後，更新後訂購商品就不見了，一樣還是更新後訂購的產品就消失了，請用心處理，我這邊看前端POST的訂購產品資料根本沒有傳給後端，最後填寫日期沒有顯示時間，幫我加入時間，更新資料有送到後端，但是後端沒有更新進資料庫，要確認後端那裡的問題
143. 請確認Eeform2Model中的save_product更新邏輯是否有問題，必須要是更新資料，另外，幫我用insertbatch的方式完成，你刪除完之後，我去查了insertbatch的資料根本都是空的，請確認save_product這支function從開始到insertbatch這段，一定有錯誤，看是少資料還是怎樣，怎麼可能我傳了資料結果最後全部都是零
144. 承143，save_product所有用到的參數請幫我打開分析，他現在送出的東西是錯的，有資料的會變成沒資料的
145. 有辦法幫我判斷save_products這個function，被使用的時候是新增還是編輯嗎
146. 我新增了/eform/eform5_list的功能，幫我參照/eform/eform4_list的功能，補上撈取eform5的資料，以及檢視與更新表單的功能，請確保內容皆為eform5的項目
147. /api/eeform/eeform5/submissions/000000這支API顯示500錯誤，幫我修復，你改錯了不要改ci3專案裡面的，改根目錄底下的
148. eform5_list頁面編輯的時候，與原本的原件不一樣，select變成input了，請全部排查過一次
149. 先add commit push，eform5_list頁面編輯的api，與eform5送出的API是不是同一支，如果是同一支的話，幫我多一個參數分開兩個功能，有些表單欄位送出不同，不要混在一起