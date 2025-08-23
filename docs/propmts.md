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