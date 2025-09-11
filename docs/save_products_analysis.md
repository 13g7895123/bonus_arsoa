# save_products 函數參數分析報告

## 問題描述
用戶反映 eform2 的 save_products 函數在更新時會出現產品資料消失的問題，原本有資料的產品會變成空資料。

## 參數流程分析

### 1. 前端資料收集 (eform02_list.php:705)
```javascript
$('#exampleModal input[name^="product_"]').each(function() {
  var fieldName = $(this).attr('name');
  var quantity = parseInt($(this).val()) || 0;
  products[fieldName] = { quantity: quantity };
});
```
**預期格式**: `{ "product_xxx": { "quantity": 數量 } }`

### 2. Controller 接收處理 (Eeform2.php:289-301)
```php
$products = isset($input_data['products']) ? $input_data['products'] : [];
```
**接收資料後進行詳細分析**:
- 檢查 `$input_data['products']` 是否存在
- 確認資料型別 (array/object)
- 逐一分析每個產品資料的結構

### 3. Model 處理邏輯 (Eeform2Model.php:54-195)

#### 3.1 參數分析階段
- 記錄 submission_id 和其型別
- 記錄 products 陣列的完整內容和型別
- 分析陣列中每個 key-value 的結構

#### 3.2 產品主檔對應建立
```php
foreach ($product_master as $index => $product) {
    $field_name = 'product_' . strtolower($product['product_code']);
    $product_mapping[$field_name] = [
        'code' => $product['product_code'],
        'name' => $product['product_name']
    ];
}
```

#### 3.3 資料處理邏輯
支援兩種資料格式:
1. **物件格式**: `$products['product_xxx']['quantity']`
2. **直接格式**: `$products['product_xxx']` (數值)

#### 3.4 批次插入前驗證
- 記錄有數量產品的數量
- 記錄無數量產品的數量
- 顯示最終要插入的資料結構
- 插入後驗證資料庫中的記錄

## 可能問題點

### 1. 資料格式不匹配
前端送出的格式與後端預期的格式不符

### 2. 產品主檔對應錯誤
product_code 轉換成 field_name 時的對應關係錯誤

### 3. insert_batch 執行失敗
批次插入時資料庫操作失敗，但沒有拋出明確錯誤

### 4. 交易回滾
在某個環節發生錯誤導致整個交易回滾

## 調試機制

### 增強的 log 記錄
1. **Controller 層級**:
   - 原始輸入流
   - 解碼後的資料結構
   - products 資料的詳細分析

2. **Model 層級**:
   - 參數完整性檢查
   - 產品主檔資料
   - 資料對應過程
   - 批次插入前後的驗證

### 查看 log 的方法
1. 檢查 CodeIgniter 的 log 檔案 (通常在 `application/logs/`)
2. 搜尋關鍵字: `SAVE_PRODUCTS START` 或 `CONTROLLER UPDATE START`

## 建議的修復步驟

1. **測試單一產品更新**: 只選擇一個產品進行更新測試
2. **檢查產品主檔**: 確認 eeform2_product_master 表中的資料是否正確
3. **驗證資料庫權限**: 確認對 eeform2_products 表有完整的 CRUD 權限
4. **分析 log 輸出**: 查看詳細的 debug log 找出具體問題點

## 預期的正常流程

1. 前端收集產品資料 → `{"product_a01": {"quantity": 2}}`
2. Controller 接收並分離產品資料
3. Model 建立產品主檔對應關係
4. 刪除舊的產品記錄
5. 根據對應關係處理新的產品資料
6. 批次插入新的產品記錄
7. 驗證插入結果

任何一個環節出錯都會導致產品資料消失或不正確。