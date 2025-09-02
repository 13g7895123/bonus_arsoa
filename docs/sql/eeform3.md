# 微微卡日記表單 (EForm03) 資料庫結構設計

## 概述
此文檔設計了一個可擴充且高效的資料庫結構，用於存儲微微卡日記表單的所有資料。設計考慮了資料正規化、效能優化、以及未來功能擴展的需求。

## 主要資料表

### 1. eeeform3_submissions (表單提交主表)
```sql
CREATE TABLE eeeform3_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
    member_id VARCHAR(50) NOT NULL COMMENT '會員編號',
    age TINYINT UNSIGNED NOT NULL COMMENT '年齡',
    height SMALLINT UNSIGNED NOT NULL COMMENT '身高(cm)',
    goal TEXT NOT NULL COMMENT '目標',
    action_plan_1 TEXT NULL COMMENT '自身行動計畫1',
    action_plan_2 TEXT NULL COMMENT '自身行動計畫2',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
    submission_date DATE NOT NULL COMMENT '填寫日期',
    
    INDEX idx_member_id (member_id),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='微微卡日記表單主表';
```

### 2. eeeform3_body_data (身體數據表)
```sql
CREATE TABLE eeeform3_body_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    weight DECIMAL(5,2) NULL COMMENT '體重(公斤)',
    blood_pressure_high SMALLINT UNSIGNED NULL COMMENT '收縮壓',
    blood_pressure_low SMALLINT UNSIGNED NULL COMMENT '舒張壓',
    waist DECIMAL(5,2) NULL COMMENT '腰圍(公分)',
    measurement_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '測量時間',
    
    FOREIGN KEY (submission_id) REFERENCES eeeform3_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_measurement_time (measurement_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='身體數據記錄表';
```

### 3. eeform3_activity_items (活動項目主表)
```sql
CREATE TABLE eeform3_activity_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_key VARCHAR(50) NOT NULL UNIQUE COMMENT '活動項目鍵值',
    item_name VARCHAR(100) NOT NULL COMMENT '活動項目名稱',
    description TEXT NULL COMMENT '項目描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_item_key (item_key),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活動項目主表';
```

### 4. eeform3_activity_records (活動記錄表)
```sql
CREATE TABLE eeform3_activity_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    activity_item_id INT NOT NULL COMMENT '活動項目ID',
    is_completed BOOLEAN DEFAULT FALSE COMMENT '是否完成',
    completion_time TIMESTAMP NULL COMMENT '完成時間',
    notes TEXT NULL COMMENT '備註',
    
    FOREIGN KEY (submission_id) REFERENCES eeeform3_submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_item_id) REFERENCES eeform3_activity_items(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_activity (submission_id, activity_item_id),
    INDEX idx_submission_id (submission_id),
    INDEX idx_activity_item_id (activity_item_id),
    INDEX idx_is_completed (is_completed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='活動完成記錄表';
```

### 5. eeform3_plans (計畫記錄表)
```sql
CREATE TABLE eeform3_plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    plan_type ENUM('plan_a', 'plan_b', 'other') NOT NULL COMMENT '計畫類型',
    plan_content TEXT NOT NULL COMMENT '計畫內容',
    priority TINYINT DEFAULT 1 COMMENT '優先順序',
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending' COMMENT '執行狀態',
    target_date DATE NULL COMMENT '目標完成日期',
    actual_completion_date DATE NULL COMMENT '實際完成日期',
    
    FOREIGN KEY (submission_id) REFERENCES eeeform3_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_plan_type (plan_type),
    INDEX idx_status (status),
    INDEX idx_target_date (target_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='個人計畫記錄表';
```

## 初始資料

### 活動項目基礎資料
```sql
INSERT INTO eeform3_activity_items (item_key, item_name, description, sort_order) VALUES
('hand_measure', '用手測量', '使用手部測量飲食份量', 1),
('exercise', '運動(30分)', '每日至少30分鐘運動', 2),
('health_supplement', '保健食品', '按時服用保健食品', 3),
('weika', '微微卡', '微微卡產品使用', 4),
('water_intake', '飲水量', '每日飲水量記錄', 5);
```

## 視圖 (Views)

### 1. 完整表單資料視圖
```sql
CREATE VIEW v_eeform3_complete_data AS
SELECT 
    s.id,
    s.member_name,
    s.member_id,
    s.age,
    s.height,
    s.goal,
    s.action_plan_1,
    s.action_plan_2,
    s.submission_date,
    s.status,
    s.created_at,
    bd.weight,
    bd.blood_pressure_high,
    bd.blood_pressure_low,
    bd.waist,
    GROUP_CONCAT(
        CASE WHEN ar.is_completed = 1 
        THEN ai.item_name 
        END SEPARATOR '、'
    ) as completed_activities,
    COUNT(ar.id) as total_activity_count,
    SUM(CASE WHEN ar.is_completed = 1 THEN 1 ELSE 0 END) as completed_activity_count
FROM eeform3_submissions s
LEFT JOIN eeform3_body_data bd ON s.id = bd.submission_id
LEFT JOIN eeform3_activity_records ar ON s.id = ar.submission_id
LEFT JOIN eeform3_activity_items ai ON ar.activity_item_id = ai.id
GROUP BY s.id, bd.id;
```

### 2. 會員進度統計視圖
```sql
CREATE VIEW v_member_progress_stats AS
SELECT 
    member_id,
    member_name,
    COUNT(*) as total_submissions,
    MAX(submission_date) as last_submission_date,
    AVG(
        (SELECT COUNT(*) FROM eeform3_activity_records ar2 
         WHERE ar2.submission_id = s.id AND ar2.is_completed = 1)
    ) as avg_completed_activities,
    AVG(bd.weight) as avg_weight,
    AVG(bd.blood_pressure_high) as avg_bp_high,
    AVG(bd.blood_pressure_low) as avg_bp_low,
    AVG(bd.waist) as avg_waist
FROM eeform3_submissions s
LEFT JOIN eeform3_body_data bd ON s.id = bd.submission_id
GROUP BY member_id, member_name;
```

## 索引優化建議

### 1. 複合索引
```sql
-- 會員ID + 提交日期的複合索引，用於查詢特定會員的歷史記錄
CREATE INDEX idx_member_date ON eeform3_submissions (member_id, submission_date DESC);

-- 提交日期 + 狀態的複合索引，用於管理介面篩選
CREATE INDEX idx_date_status ON eeform3_submissions (submission_date DESC, status);
```

### 2. 部分索引 (MySQL 8.0+)
```sql
-- 只對已提交的表單建立索引
CREATE INDEX idx_submitted_date ON eeform3_submissions (submission_date DESC) 
WHERE status = 'submitted';
```

## 擴展性考慮

### 1. 水平分表策略
當資料量大時，可考慮按年度分表：
```sql
-- 例：eeform3_submissions_2024, eeform3_submissions_2025
```

### 2. 歷史資料歸檔
```sql
CREATE TABLE eeform3_submissions_archive LIKE eeform3_submissions;
-- 定期將舊資料移至歷史表
```

### 3. 快取策略
- 會員最新一筆記錄快取
- 統計資料定期預計算
- 活動項目資料記憶體快取

## 安全性考量

### 1. 資料加密
```sql
-- 敏感資料可考慮加密儲存
ALTER TABLE eeform3_submissions 
ADD COLUMN encrypted_member_id VARBINARY(255) COMMENT '加密會員編號';
```

### 2. 審計日誌
```sql
CREATE TABLE eeform3_audit_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    operation ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    user_id INT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## 效能監控

### 1. 慢查詢監控
定期檢查慢查詢日誌，優化查詢效能

### 2. 表大小監控
```sql
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'DB Size (MB)'
FROM information_schema.tables 
WHERE table_schema = DATABASE() 
AND table_name LIKE 'eeform3_%'
ORDER BY (data_length + index_length) DESC;
```

## 備份策略

1. **每日全量備份**：凌晨時段進行完整資料庫備份
2. **即時增量備份**：使用二進制日誌進行增量備份
3. **跨地域備份**：重要資料定期同步至異地備份系統

## 總結

此資料庫結構設計具備以下優勢：
1. **正規化設計**：避免資料重複，確保資料一致性
2. **高擴展性**：支援新增活動項目、計畫類型等
3. **效能優化**：合適的索引設計，支援高併發查詢
4. **資料完整性**：外鍵約束確保資料關聯正確
5. **便於維護**：清晰的表結構和命名規範
6. **安全可靠**：包含審計、備份等安全機制

透過此設計，系統可以有效地存儲和管理微微卡日記表單的所有資料，並為未來的功能擴展提供良好的基礎。

## EForm03 表單欄位清單

### 基本資訊欄位
| 欄位名稱 | HTML名稱 | 類型 | 必填 | 驗證規則 | 描述 |
|---------|---------|------|------|---------|------|
| 會員姓名 | member_name | text | ✓ | required | 會員的真實姓名 |
| 會員編號 | member_id | text | ✓ | required | 會員唯一識別編號 |
| 年齡 | age | number | ✓ | required, numeric | 會員年齡 |
| 身高 | height | number | ✓ | required, numeric | 身高(公分) |
| 目標 | goal | text | ✓ | required | 會員設定的健康目標 |

### 行動計畫欄位
| 欄位名稱 | HTML名稱 | 類型 | 必填 | 驗證規則 | 描述 |
|---------|---------|------|------|---------|------|
| 自身行動計畫1 | action_plan_1 | text | | | 個人制定的行動計畫第一項 |
| 自身行動計畫2 | action_plan_2 | text | | | 個人制定的行動計畫第二項 |

### 身體數據欄位
| 欄位名稱 | HTML名稱 | 類型 | 必填 | 驗證規則 | 描述 |
|---------|---------|------|------|---------|------|
| 體重 | weight | number | | step="0.1", numeric | 體重(公斤)，允許小數點 |
| 血壓(收縮壓) | blood_pressure_high | number | | numeric | 收縮壓數值 |
| 血壓(舒張壓) | blood_pressure_low | number | | numeric | 舒張壓數值 |
| 腰圍 | waist | number | | step="0.1", numeric | 腰圍(公分)，允許小數點 |

### 活動執行項目 (Checkbox)
| 欄位名稱 | HTML名稱 | 類型 | 必填 | 驗證規則 | 描述 |
|---------|---------|------|------|---------|------|
| 用手測量 | hand_measure | checkbox | | boolean | 使用手部測量飲食份量 |
| 運動(30分) | exercise | checkbox | | boolean | 每日至少30分鐘運動 |
| 保健食品 | health_supplement | checkbox | | boolean | 按時服用保健食品 |
| 微微卡 | weika | checkbox | | boolean | 微微卡產品使用 |
| 飲水量 | water_intake | checkbox | | boolean | 每日飲水量記錄 |

### 計畫內容欄位
| 欄位名稱 | HTML名稱 | 類型 | 必填 | 驗證規則 | 描述 |
|---------|---------|------|------|---------|------|
| 計畫a | plan_a | text | | | 個人制定的計畫內容A |
| 計畫b | plan_b | text | | | 個人制定的計畫內容B |
| 其他 | other | text | | | 其他補充計畫或備註 |

### 表單功能特性

#### 1. 資料驗證
- **必填欄位檢查**：會員姓名、會員編號、年齡、身高、目標為必填
- **數值格式檢查**：年齡、身高必須為數字
- **小數點支援**：體重和腰圍支援0.1精度的小數點輸入

#### 2. 使用者互動功能
- **測試資料填入**：提供一鍵填入測試資料功能（可透過變數控制顯示）
- **確認視窗**：送出前顯示完整表單內容供確認
- **AJAX提交**：使用API方式提交表單，提供即時回饋

#### 3. 測試資料內容
```javascript
預設測試資料：
- 會員姓名：張小明
- 會員編號：M001234  
- 年齡：35
- 身高：170
- 目標：減重5公斤並維持健康體態
- 行動計畫1：每天早上做30分鐘瑜珈
- 行動計畫2：晚餐後散步1小時
- 體重：70.5
- 血壓(收)：120
- 血壓(舒)：80
- 腰圍：85.0
- 已勾選活動：用手測量、運動(30分)、微微卡、飲水量
- 計畫a：每日記錄飲食內容
- 計畫b：每週量體重2次
- 其他：保持充足睡眠
```

#### 4. API整合
- **提交端點**：POST `/api/eeform3/submit`
- **資料格式**：JSON格式傳送
- **錯誤處理**：完整的錯誤回饋機制
- **狀態追蹤**：提交過程中的載入狀態顯示

#### 5. 確認視窗設計
- **分類顯示**：基本資料、行動計畫、身體數據、執行項目、其他計畫
- **素樸風格**：簡潔的視覺設計，無圓角樣式
- **響應式**：支援各種螢幕尺寸的顯示

## 刪除所有資料的 SQL 語句

### 方法一：利用外鍵級聯刪除（推薦）

```sql
-- 由於所有子表都設定了 ON DELETE CASCADE，
-- 只需要刪除主表，相關資料會自動級聯刪除
DELETE FROM eeform3_submissions;

-- 清空活動項目主表（如需要）
-- DELETE FROM eeform3_activity_items;

-- 清空審計日誌表（如需要）
-- DELETE FROM eeform3_audit_log;

-- 清空歷史歸檔表
-- DELETE FROM eeform3_submissions_archive;

-- 重設自增ID（可選）
ALTER TABLE eeform3_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeeform3_body_data AUTO_INCREMENT = 1;
ALTER TABLE eeform3_activity_items AUTO_INCREMENT = 1;
ALTER TABLE eeform3_activity_records AUTO_INCREMENT = 1;
ALTER TABLE eeform3_audit_log AUTO_INCREMENT = 1;
ALTER TABLE eeform3_submissions_archive AUTO_INCREMENT = 1;
```

### 方法二：逐步刪除（明確控制）

```sql
-- 先刪除子表資料（按外鍵依賴順序）
DELETE FROM eeform3_activity_records;
DELETE FROM eeeform3_body_data;

-- 刪除主表資料
DELETE FROM eeform3_submissions;

-- 可選：清空活動項目主表
-- DELETE FROM eeform3_activity_items;

-- 清空審計日誌表
DELETE FROM eeform3_audit_log;

-- 清空歷史歸檔表
DELETE FROM eeform3_submissions_archive;

-- 重設自增ID
ALTER TABLE eeform3_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeeform3_body_data AUTO_INCREMENT = 1;
ALTER TABLE eeform3_activity_items AUTO_INCREMENT = 1;
ALTER TABLE eeform3_activity_records AUTO_INCREMENT = 1;
ALTER TABLE eeform3_audit_log AUTO_INCREMENT = 1;
ALTER TABLE eeform3_submissions_archive AUTO_INCREMENT = 1;
```

### 方法三：使用 TRUNCATE（最快速，但會重設ID）

```sql
-- 注意：由於外鍵約束，需要先停用外鍵檢查
SET FOREIGN_KEY_CHECKS = 0;

-- 清空所有資料表
TRUNCATE TABLE eeform3_activity_records;
TRUNCATE TABLE eeeform3_body_data;
TRUNCATE TABLE eeform3_submissions;
TRUNCATE TABLE eeform3_audit_log;
TRUNCATE TABLE eeform3_submissions_archive;

-- 可選：清空活動項目主表
-- TRUNCATE TABLE eeform3_activity_items;

-- 重新啟用外鍵檢查
SET FOREIGN_KEY_CHECKS = 1;
```

### 條件式刪除範例

```sql
-- 刪除特定日期範圍的資料
DELETE FROM eeform3_submissions 
WHERE submission_date BETWEEN '2024-01-01' AND '2024-12-31';

-- 刪除特定會員的所有記錄
DELETE FROM eeform3_submissions 
WHERE member_id = 'M001234';

-- 刪除草稿狀態的記錄
DELETE FROM eeform3_submissions 
WHERE status = 'draft';

-- 刪除指定天數前的舊資料
DELETE FROM eeform3_submissions 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 365 DAY);

-- 刪除特定時期的身體數據記錄
DELETE FROM eeeform3_body_data 
WHERE measurement_time < DATE_SUB(NOW(), INTERVAL 180 DAY);

-- 刪除舊的審計日誌
DELETE FROM eeform3_audit_log 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
```

### 重設活動項目為預設資料

```sql
-- 如果需要重設活動項目主表為預設狀態
TRUNCATE TABLE eeform3_activity_items;

-- 重新插入預設活動項目
INSERT INTO eeform3_activity_items (item_name, item_key, is_active) VALUES
('用手測量', 'hand_measure', TRUE),
('運動(30分)', 'exercise', TRUE),
('保健食品', 'health_supplement', TRUE),
('微微卡', 'weika', TRUE),
('飲水量', 'water_intake', TRUE);
```

### 安全刪除前的備份

```sql
-- 在執行大量刪除前，建議先備份資料
CREATE TABLE eeform3_backup_before_delete AS
SELECT 
    s.*,
    'eeform3_submissions' as table_name,
    NOW() as backup_time
FROM eeform3_submissions s;

-- 同樣方式備份其他表
CREATE TABLE eeform3_body_data_backup AS SELECT * FROM eeeform3_body_data;
CREATE TABLE eeform3_activity_records_backup AS SELECT * FROM eeform3_activity_records;
CREATE TABLE eeform3_activity_items_backup AS SELECT * FROM eeform3_activity_items;
CREATE TABLE eeform3_audit_log_backup AS SELECT * FROM eeform3_audit_log;
CREATE TABLE eeform3_archive_backup AS SELECT * FROM eeform3_submissions_archive;
```

### 注意事項

此表單設計僅會員姓名為必填欄位，其他欄位均為可選填。如需修改必填欄位，請同步更新前端驗證和後端Model驗證邏輯。
