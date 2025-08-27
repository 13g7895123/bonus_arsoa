1. 這個專案他沒有任何環境，所以執行後請不用在本地進行任何測試，都是無效的，幫我寫進CLAUDE.md
2. 幫我讀取views\eeform\eform03.php，這隻檔案，完成表單送出的功能
3. 送出前先顯示一個確認視窗，上面羅列所有表單項目，以確認是否正確填寫，確認後才送出，取消則關閉視窗
4. 請幫我針對確認視窗、視窗內表單內容、按鈕進行UI優化
5. 幫我調整送出的確認視窗就好，表單請不要調整
6. 幫我多加一個按鈕，填入測試資料，點下去會為表單填入假資料，並且用一個變數控制他是否顯示
7. 每一個任務執行完請幫我下一個commit並push到遠端，且不要包含有任何協作的資訊在裡面，幫我執行後寫入CLAUDE.md
8. 幫我移除表單的圓角
9. 請幫我把確認的頁面調整成素一點的樣式
10. 紀錄git操作這件事情不用每次完成任務都寫入CLAUDE.md，幫我更新CLAUDE.md
11. 幫我依據上方eform03的規則，完成views\eeform\eform01.php，先處理前端表單即可，後端先不用
12. 請幫我處理每一個欄位都要有測試資料
13. 確認表單也請幫我補齊
14. 必填欄位沒有填到出生西元月
15. js剛剛幫我新增上去的部分，幫我改成用jquery的方式撰寫，並且把style的部分移到最上面
16. 幫我針對最下方的新增日期的功能實作，在他上面預設會有一組填日期與填數字，按下新增日期的時候會多一組，當總共有三組的時候，請隱藏新增日期的按鈕
17. 新增的部分幫我維持橫向，不要變成直的
18. 幫我確認所有的checkbox都可以用文字點選
19. 針對views\eeform\eform03.php的部分，js的功能幫我改成jquery
20. 針對views\eeform\eform03.php的部分，設計一個優秀且可擴充的資料表結構，寫入docs\sql\eeform3.md中
21. 這是一個ci3的專案，因為我沒有migration的權限，請讀取
    1. views\eeform\eform03.php，取得當前的表單功能
    2. docs\sql\eeform3.md這支檔案，取得資料表結構
設計出針對這個功能的api，Controller的話請寫入controllers\api\Eeform.php，Model的話寫入models\eeform\eform3.php，Service寫入service\eeform\eform3.php，請幫我用這幾個服務撰寫，完成後需要同步更新views\eeform\eform03.php，讓他吃到正確的API
22. 21點的api送出後，她出現500錯誤，但是沒有錯誤訊息我無法查錯，幫我讓api回復可以顯示錯誤
23. 幫我從頭到尾檢查一遍功能，依據目前調整的檔名與class更新所有有用到的地方
24. 錯誤請用"error_reporting(-1); ini_set('display_errors', 1);"這個呈現，移除所有用log的方式
25. 幫我針對eeform3檢查當前的code，從controller、models、service一路檢查下來，確認為甚麼會出錯，"Service not available in controller"
26. 幫我把eform3用到的表單列出來，寫入docs\sql\eeform3.md的最下面
27. 幫我把sql\eeform3.md的表單改名eform03的地方改成eeform03，並同步修改專案用用到eeform3用到的地方，確認一下是不是只要有改models\eeform\Eeform3Model.php這支檔案即可
28. 再來把eeform03改成eeform3
29. 幫我針對views/eeform/eform03_list.php進行修改，她會是eform03.php的上一層，資料在這兩層會是有相關的，幫我讀取該兩個頁面，完成eform03_list.php的部分，同時，如果有超連結失效的地方也幫我改成正確的
30. 請幫我把標題改回來，不要任意修改標題
31. eform03_list請幫我重新確認，如果要走API的部分請幫我走API，不要看到任何假資料，我記得user資料是有透過controller傳入view的
32. eform03_list最下方的表格，如果沒有資料請幫我顯示對應的錯誤
33. 幫我找出/api/eeform3/submissions/000000這個API錯誤的原因，她只有報500錯誤，這樣查不出錯誤的原因
34. 承33，我找到錯誤原因是因為controllers\api\Eeform3.php這支檔案的$this->load->service('eeform/Eeform3Service', NULL, 'eform3_service');這一行載入錯誤導致的，幫我確認相關檔案，並修復這個錯誤
35. 針對你前面提出的結果，如果我把她檔案改成小寫了，再幫我檢查一次，為甚麼還是500
36. 問題是我根本連除錯的地方都沒跑出來，你可以用心再檢查一次嗎
37. 似乎不是路由的問題，因為我在controller是有跑到的，只是她在引入service的時候出錯了
38. 檢查一下目前Eeform3中使用service的情況是否有錯誤
39. 幫我調整架構，原本service的部分可以改成由model處理嗎
40. 承39，不用測試，直接更新即可
41. 幫我調整一下，現在eform3_list會自動帶入會員姓名與會員編號，eform3幫我改成也可以自動填入，如果姓名或是編號有錯誤，則跳出通知後回到eform3_list這一頁
42. 幫我把通知改成swal
43. 幫我把填入測試資料的部分，移除會員姓名與會員編號，並把測試資料的功能打開
44. 送出表單後請直接回到eform3_list這一頁
45. 提交成功，請幫我移除確定按鈕，並於1.5秒後自動關閉通知後跳轉
46. 完成以下功能
    - eform3_list的共同行動部分，幫我確認為甚麼沒有顯示資料
    - 訂單內容顯示的是錯誤的，請依據正確內容顯示，看是否要用API的方式存取
    - 我要修改也沒有帶出正確的資訊
47. 模態視窗標題修正，這個項目請幫我改回來
48. 完成以下功能
    - 最上面的年齡、身高、目標，請以最新的那張表單的資料的資訊顯示，自身行動計畫1、自身行動計畫2也是
    - 表單中共同行動都沒有顯示資料，幫我確認是否有問題
49. 幫我調整一下，目標、自身行動計畫1、自身行動計畫2抓第一次的資料，並且後續不給變更，且在eform3會自動帶入
50. viewSubmission執行後顯示的內容沒有依據表單顯示，editSubmission也是，幫我確認一下
51. 完成以下功能
    - editSubmission時，目標、自身行動計畫1、自身行動計畫2，幫我改為readonly不可調整
    - viewSubmission、editSubmission執行後，計畫A、計畫B與其他的資料沒有帶出來
52. 完成以下功能
    - 從viewSubmission的我要修改點下去後，那個訂單內容的視窗會無法往下滑
    - editSubmission點更新表單後會顯示更新失敗，且不是用sweet alert
53. 52點的第二項是因為他用PUT去更新，幫我確認一下API是允許甚麼方法並更新
54. 目前PUT沒有被伺服器允許，幫我改成用POST的方式，並且針對上一點的調整，要同步更新eform3這一個頁面的部份，避免改完他的送出無法使用
55. 目前eform3_list這一頁getActivityBadges這個功能的資料在api中都沒有對應的物件資料，幫我確認一下
56. eform3_list、eform3幫我移除偵錯用的console.log，並且把eform3填入測試資料關閉
57. 讀取eform1_list、eform1，eform1_list是eform1的上一頁，幫我完善eform1_list的功能，假資料就先幫我移除
58. 目前eform1送出的API是404的頁面，幫我確認專案的controller資料夾，確認是哪裡的問題
59. 我說的是eform1，不是eform1_list，請幫我重新確認，我看目前更新的都是eform1_list
60. 幫我讀取eform1、eform1_list，針對這兩個頁面設計他的資料庫table，並把sql語法寫入docs\sql\eeform1.md中
61. 結構是否有問題，沒有eeform1_lifestyle_options，卻有INSERT
62. docs\sql\eeform1.md更新後，有確認eform1、eform1_list用到的api是否有同步更新嗎
63. 目前看eform1送出後沒有資料到資料庫，eform1_list出現API服務不存在或路徑錯誤
64. 請參照eform3的api路徑，把eform1的api改過去那裡，並移除舊的部分，且確認view的部分有同步修改
65. controllers的部分沒有同步更新，沒有更新到api/eeform1/submit
66. The action you have requested is not allowed.
67. /api/eeform1/submit這支API出現404錯誤，請幫我修復
68. Unable to locate the model you have specified: 
69. eform1_list沒有顯示填寫完的資料，而且搜尋會直接重整頁面，幫我用前端的方式處理API
70. 搜尋點下去沒有打API，幫我確認問題，填寫完的eform1表單要掛在當前使用者名下，讓eform1_list可以顯示，確認目前邏輯是否符合，不符的話請修改調整
71. eeform1_submissions沒有member_id，更新前請確認是否有需要更新資料表
72. eform1_list的部分，幫我調整排版，請參照0fa0434這個commit移除假資料前的版型排版
73. 請幫我調整列表的部分就好，其餘我改好引入的header footer那些不要變更
74. 我指的列表是指會員資訊那個地方
75. 幫我完成檢視功能
76. 請檢視0fa0434這個commit，還原他的檢視功能，不要亂改
77. viewSubmissionDetail、editSubmissionDetail請確實參照0fa0434這個commit，完成其功能與切版
78. 目前看到打開後的視窗似乎有部分內容有背景變透明的情況，請重新確認一次
79. 你好像打開後的視窗內容重複顯示了兩次，幫我改成正常的顯示一次就好
80. 送出表單的按鈕不見了
81. 幫我viewSubmissionDetail、editSubmissionDetail時把該表單資料帶入 ✅
82. 目前console中有看到從資料庫存取的資料，但是沒有帶入到彈窗顯示的表單中 ✅
83. Transformed form data，這個就錯了，我看到職業有兩筆資料，轉換後全部都是零，幫我確實確認一次 ✅
84. 上面的表單沒有問題了，但下面肌膚類型往下的還是沒有資料 ✅
85. "肌膚類型下面的部分，第一個下拉選單，請預設"嚴重、盡快改善"，第二個預設"有問題、要注意"，第三個"健康"，後面的INPUT用各個對應的數值，上方的日期跟數字也是對應的
86. 請修正85點，我指的是eform1_list，預覽與編輯的表單部分，幫我移除eform1，並更新eform1_list
87. 除了下拉選單以外的資料，目前填入的都不是資料庫的資料，幫我檢查一下並修正
88. 第87點，API回傳的moisture_scores都是空的，但是我在填表單的時候是有測試資料的，幫我確認是否為API的問題
89. 請移除eform1的肌膚類型往下的欄位的預設值
90. 請幫我重新viewe過一次docs\sql\eeform1.md的資料表設計，為甚麼eform1下方的表單，只有水潤有資料表紀錄資料，其餘都沒有，請幫我完整調整過，我要整個表單的資料是完整的，調整完後請同步更新API的controller、model、service，並檢查view的eform1_list、eform1有沒有需要同步調整的
91. 我看91點只有改model，controller跟service幫我確認是否有需要調整的地方
92. 目前這支API"/api/eeform1/submission/2"，似乎沒有吃到剛剛新增的表單的資料，並帶到前端，幫我檢查，並且要確認前端有正確顯示資料
93. 我排查了一下他存入skin_scores，但是API顯示空資料，幫我確認
94. 請幫我檢查程式邏輯，資料庫沒問題，資料表我都已經建立好了
95. 幫我確認最後填寫日期的欄位為甚麼時間都是一樣的，是否資料表中只記錄到日期，查看docs\sql\eeform1.md並修正
96. eform1_list更新表單打的這支API，/api/eeform1/submission/6，他用POST，但是後端沒有改導致，Method not allowed