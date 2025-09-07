# EEFORM1 肌膚諮詢記錄表 資料庫設計

## 資料表結構概述

EEFORM1 肌膚諮詢記錄表系統需要以下資料表來完整儲存表單數據：

1. `eeform1_submissions` - 主要提交記錄表
2. `eeform1_occupations` - 職業選擇記錄表
3. `eeform1_lifestyle` - 生活方式記錄表  
4. `eeform1_products` - 使用產品記錄表
5. `eeform1_skin_issues` - 肌膚困擾記錄表
6. `eeform1_allergies` - 過敏狀況記錄表
7. `eeform1_skin_scores` - 肌膚評分記錄表（支援8種評分類別）
8. `eeform1_suggestions` - 建議內容記錄表

## SQL 建表語句

### 1. 主要提交記錄表 (eeform1_submissions)

```sql
CREATE TABLE eeform1_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT '記錄ID',
    member_id VARCHAR(50) NULL COMMENT '會員編號',
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名（被填表人）',
    form_filler_id VARCHAR(50) NULL COMMENT '代填問卷者ID（當前登入使用者）',
    form_filler_name VARCHAR(100) NULL COMMENT '代填問卷者姓名',
    birth_year SMALLINT NOT NULL COMMENT '出生西元年',
    birth_month TINYINT NOT NULL COMMENT '出生西元月',
    phone VARCHAR(20) NOT NULL COMMENT '電話號碼',
    
    -- 肌膚類型與年齡
    skin_type ENUM('normal', 'combination', 'oily', 'dry', 'sensitive') NULL COMMENT '肌膚類型',
    skin_age TINYINT NULL COMMENT '肌膚年齡',
    
    -- 系統欄位
    submission_date DATETIME NOT NULL COMMENT '填寫日期時間',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_id (member_id),
    INDEX idx_member_name (member_name),
    INDEX idx_phone (phone),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚諮詢記錄主表';
```

### 2. 職業選擇記錄表 (eeform1_occupations)

```sql
CREATE TABLE eeform1_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    occupation_type ENUM('service', 'office', 'restaurant', 'housewife') NOT NULL COMMENT '職業類型',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選擇記錄表';
```

### 3. 生活方式記錄表 (eeform1_lifestyle)

```sql
CREATE TABLE eeform1_lifestyle (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    category ENUM('sunlight', 'aircondition', 'sleep') NOT NULL COMMENT '生活方式類別',
    item_key VARCHAR(50) NOT NULL COMMENT '項目鍵值',
    item_value VARCHAR(255) NULL COMMENT '項目值（用於其他選項的文字內容）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_lifestyle (submission_id, category, item_key),
    INDEX idx_submission_id (submission_id),
    INDEX idx_category (category),
    INDEX idx_item_key (item_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='生活方式記錄表';
```

### 4. 使用產品記錄表 (eeform1_products)

```sql
CREATE TABLE eeform1_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    product_type ENUM('honey_soap', 'mud_mask', 'toner', 'serum', 'premium', 'sunscreen', 'other') NOT NULL COMMENT '產品類型',
    product_name VARCHAR(255) NULL COMMENT '產品名稱（用於其他選項）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_product (submission_id, product_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_type (product_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用產品記錄表';
```

### 5. 肌膚困擾記錄表 (eeform1_skin_issues)

```sql
CREATE TABLE eeform1_skin_issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    issue_type ENUM('elasticity', 'luster', 'dull', 'spots', 'pores', 'acne', 'wrinkles', 'rough', 'irritation', 'dry', 'makeup', 'other') NOT NULL COMMENT '困擾類型',
    issue_description TEXT NULL COMMENT '困擾描述（用於其他選項）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_issue (submission_id, issue_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_issue_type (issue_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚困擾記錄表';
```

### 6. 過敏狀況記錄表 (eeform1_allergies)

```sql
CREATE TABLE eeform1_allergies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    allergy_type ENUM('frequent', 'seasonal', 'never') NOT NULL COMMENT '過敏類型',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_allergy (submission_id, allergy_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_allergy_type (allergy_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='過敏狀況記錄表';
```

### 7. 肌膚評分記錄表 (eeform1_skin_scores)

```sql
CREATE TABLE eeform1_skin_scores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    category ENUM('moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore') NOT NULL COMMENT '評分類別',
    score_type ENUM('severe', 'warning', 'healthy') NOT NULL COMMENT '評分類型',
    score_value TINYINT NOT NULL DEFAULT 0 COMMENT '評分值 (0-10)',
    measurement_date DATE NULL COMMENT '測量日期',
    measurement_number INT NULL COMMENT '測量數值',
    notes TEXT NULL COMMENT '備註',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_category_score (submission_id, category, score_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_category (category),
    INDEX idx_score_type (score_type),
    INDEX idx_measurement_date (measurement_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚評分記錄表';
```

### 8. 建議內容記錄表 (eeform1_suggestions)

```sql
CREATE TABLE eeform1_suggestions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    toner_suggestion VARCHAR(255) NULL COMMENT '化妝水建議',
    serum_suggestion VARCHAR(255) NULL COMMENT '精華液建議',
    suggestion_content TEXT NULL COMMENT '建議內容',
    created_by VARCHAR(100) NULL COMMENT '建議者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='建議內容記錄表';
```

## 初始化資料說明

### 資料儲存方式說明

本資料庫設計採用動態儲存方式，當使用者填寫表單時：

1. **基本資料**直接儲存在 `eeform1_submissions` 表中
2. **多選項目**（如職業、生活方式、產品使用等）儲存在對應的關聯表中
3. **肌膚評分資料**儲存在 `eeform1_skin_scores` 表中，支援8種評分類別
4. **生活方式選項**包含以下類別和鍵值：

#### 肌膚評分類別說明 (skin_scores)
- `moisture` - 水潤度評分
- `complexion` - 膚色評分  
- `texture` - 紋理評分
- `sensitivity` - 敏感度評分
- `oil` - 油脂分泌評分
- `pigment` - 色素沉澱評分
- `wrinkle` - 皺紋評分
- `pore` - 毛孔評分

每個類別都包含三種評分類型：
- `severe` - 嚴重、盡快改善
- `warning` - 有問題、要注意
- `healthy` - 健康

#### 日曬時間選項 (sunlight)
- `1_2h` - 1~2小時  
- `3_4h` - 3~4小時
- `5_6h` - 5~6小時
- `8h_plus` - 8小時以上

#### 空調環境選項 (aircondition)  
- `1h` - 1小時以內
- `2_4h` - 2~4小時
- `5_8h` - 5~8小時
- `8h_plus` - 8小時以上

#### 睡眠時間選項 (sleep)
- `9_10` - 9~10點
- `11_12` - 11~12點  
- `after_1` - 1點後
- `other` - 其他

### 範例資料插入

```sql
-- 範例：插入一筆完整的肌膚諮詢記錄
INSERT INTO eeform1_submissions (member_id, member_name, birth_year, birth_month, phone, skin_type, skin_age, submission_date) 
VALUES ('000001', '王小華', 1990, 5, '0912345678', 'combination', 25, CURDATE());

-- 取得剛插入的記錄ID
SET @submission_id = LAST_INSERT_ID();

-- 插入職業資料
INSERT INTO eeform1_occupations (submission_id, occupation_type) VALUES 
(@submission_id, 'service'),
(@submission_id, 'office');

-- 插入生活方式資料
INSERT INTO eeform1_lifestyle (submission_id, category, item_key) VALUES
(@submission_id, 'sunlight', '3_4h'),
(@submission_id, 'aircondition', '5_8h'),
(@submission_id, 'sleep', '11_12');

-- 插入肌膚困擾
INSERT INTO eeform1_skin_issues (submission_id, issue_type) VALUES
(@submission_id, 'dull'),
(@submission_id, 'spots'),
(@submission_id, 'dry');

-- 插入肌膚評分資料（8個類別的完整評分）
INSERT INTO eeform1_skin_scores (submission_id, category, score_type, score_value, measurement_date, measurement_number) VALUES
-- 水潤類別
(@submission_id, 'moisture', 'severe', 2, CURDATE(), 25),
(@submission_id, 'moisture', 'warning', 6, CURDATE(), 45),
(@submission_id, 'moisture', 'healthy', 8, CURDATE(), 75),
-- 膚色類別
(@submission_id, 'complexion', 'severe', 3, CURDATE(), 30),
(@submission_id, 'complexion', 'warning', 7, CURDATE(), 50),
(@submission_id, 'complexion', 'healthy', 9, CURDATE(), 80),
-- 紋理類別
(@submission_id, 'texture', 'severe', 1, CURDATE(), 20),
(@submission_id, 'texture', 'warning', 5, CURDATE(), 40),
(@submission_id, 'texture', 'healthy', 7, CURDATE(), 70),
-- 敏感類別
(@submission_id, 'sensitivity', 'severe', 4, CURDATE(), 35),
(@submission_id, 'sensitivity', 'warning', 6, CURDATE(), 55),
(@submission_id, 'sensitivity', 'healthy', 8, CURDATE(), 85),
-- 油脂類別
(@submission_id, 'oil', 'severe', 2, CURDATE(), 25),
(@submission_id, 'oil', 'warning', 5, CURDATE(), 45),
(@submission_id, 'oil', 'healthy', 7, CURDATE(), 75),
-- 色素類別
(@submission_id, 'pigment', 'severe', 3, CURDATE(), 30),
(@submission_id, 'pigment', 'warning', 6, CURDATE(), 50),
(@submission_id, 'pigment', 'healthy', 9, CURDATE(), 80),
-- 皺紋類別
(@submission_id, 'wrinkle', 'severe', 1, CURDATE(), 15),
(@submission_id, 'wrinkle', 'warning', 4, CURDATE(), 35),
(@submission_id, 'wrinkle', 'healthy', 6, CURDATE(), 65),
-- 毛孔類別
(@submission_id, 'pore', 'severe', 2, CURDATE(), 20),
(@submission_id, 'pore', 'warning', 5, CURDATE(), 40),
(@submission_id, 'pore', 'healthy', 8, CURDATE(), 70);

-- 插入建議內容
INSERT INTO eeform1_suggestions (submission_id, toner_suggestion, serum_suggestion, suggestion_content) VALUES
(@submission_id, '麗蓓思朵化妝水', '保濕亮采肌底液', '建議加強保濕護理，每日使用面膜2-3次');
```

## 資料查詢範例

### 查詢會員的完整諮詢記錄

```sql
SELECT 
    s.*,
    -- 職業資訊
    GROUP_CONCAT(DISTINCT o.occupation_type) as occupations,
    -- 肌膚困擾
    GROUP_CONCAT(DISTINCT si.issue_type) as skin_issues,
    -- 過敏狀況
    GROUP_CONCAT(DISTINCT a.allergy_type) as allergies,
    -- 建議內容
    sg.toner_suggestion,
    sg.serum_suggestion,
    sg.suggestion_content
FROM eeform1_submissions s
LEFT JOIN eeform1_occupations o ON s.id = o.submission_id AND o.is_selected = 1
LEFT JOIN eeform1_skin_issues si ON s.id = si.submission_id AND si.is_selected = 1  
LEFT JOIN eeform1_allergies a ON s.id = a.submission_id AND a.is_selected = 1
LEFT JOIN eeform1_suggestions sg ON s.id = sg.submission_id
WHERE s.member_id = '000001'
GROUP BY s.id
ORDER BY s.created_at DESC;
```

### 統計肌膚類型分佈

```sql
SELECT 
    skin_type,
    COUNT(*) as count,
    ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM eeform1_submissions), 2) as percentage
FROM eeform1_submissions 
WHERE skin_type IS NOT NULL
GROUP BY skin_type
ORDER BY count DESC;
```

### 查詢特定時期的諮詢記錄

```sql
SELECT 
    DATE_FORMAT(submission_date, '%Y-%m') as month,
    COUNT(*) as submission_count,
    COUNT(DISTINCT phone) as unique_members
FROM eeform1_submissions
WHERE submission_date >= '2024-01-01'
GROUP BY DATE_FORMAT(submission_date, '%Y-%m')
ORDER BY month DESC;
```

## 索引優化建議

```sql
-- 複合索引：常用查詢組合
CREATE INDEX idx_member_date ON eeform1_submissions (member_id, submission_date);
CREATE INDEX idx_member_name_date ON eeform1_submissions (member_name, submission_date);
CREATE INDEX idx_phone_date ON eeform1_submissions (phone, submission_date);
CREATE INDEX idx_skin_type_date ON eeform1_submissions (skin_type, submission_date);

-- 全文搜索索引（用於建議內容搜索）
ALTER TABLE eeform1_suggestions ADD FULLTEXT KEY ft_content (suggestion_content);
```

## 資料完整性約束

```sql
-- 確保評分值在合理範圍內
ALTER TABLE eeform1_skin_scores 
ADD CONSTRAINT chk_score_range CHECK (score_value >= 0 AND score_value <= 10);

-- 確保出生年月在合理範圍內
ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_birth_year CHECK (birth_year >= 1950 AND birth_year <= 2010),
ADD CONSTRAINT chk_birth_month CHECK (birth_month >= 1 AND birth_month <= 12);

-- 確保肌膚年齡在合理範圍內
ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_skin_age CHECK (skin_age >= 18 AND skin_age <= 80);
```

## 資料表更新 (既有系統升級)

如果既有系統的 `eeform1_submissions` 表沒有 `member_id` 欄位，請執行以下 SQL 語句進行更新：

```sql
-- 新增 member_id 欄位
ALTER TABLE eeform1_submissions 
ADD COLUMN member_id VARCHAR(50) NULL COMMENT '會員編號' AFTER id;

-- Point 80: 新增代填問卷者追蹤欄位
ALTER TABLE eeform1_submissions 
ADD COLUMN form_filler_id VARCHAR(50) NULL COMMENT '代填問卷者ID（當前登入使用者）' AFTER member_name,
ADD COLUMN form_filler_name VARCHAR(100) NULL COMMENT '代填問卷者姓名' AFTER form_filler_id;

-- 修改 member_name 註解
ALTER TABLE eeform1_submissions 
MODIFY COLUMN member_name VARCHAR(100) NOT NULL COMMENT '會員姓名（被填表人）';

-- 新增索引
CREATE INDEX idx_member_id ON eeform1_submissions (member_id);
CREATE INDEX idx_form_filler_id ON eeform1_submissions (form_filler_id);
CREATE INDEX idx_form_filler_name ON eeform1_submissions (form_filler_name);

-- 新增複合索引
CREATE INDEX idx_member_date ON eeform1_submissions (member_id, submission_date);

-- 如果需要根據電話號碼或會員姓名映射 member_id，可以執行類似以下更新語句：
-- UPDATE eeform1_submissions SET member_id = phone WHERE member_id IS NULL;
-- 或根據實際會員系統的邏輯進行對應
```

## 備份與維護

```sql
-- 定期清理草稿狀態超過30天的記錄
DELETE FROM eeform1_submissions 
WHERE status = 'draft' 
AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);

-- 建議定期備份重要資料
CREATE TABLE eeform1_submissions_backup AS 
SELECT * FROM eeform1_submissions 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR);
```

## 刪除所有資料的 SQL 語句

### 方法一：利用外鍵級聯刪除（推薦）

```sql
-- 由於所有子表都設定了 ON DELETE CASCADE，
-- 只需要刪除主表，相關資料會自動級聯刪除
DELETE FROM eeform1_submissions;

-- 重設自增ID（可選）
ALTER TABLE eeform1_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform1_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform1_lifestyle AUTO_INCREMENT = 1;
ALTER TABLE eeform1_products AUTO_INCREMENT = 1;
ALTER TABLE eeform1_skin_issues AUTO_INCREMENT = 1;
ALTER TABLE eeform1_allergies AUTO_INCREMENT = 1;
ALTER TABLE eeform1_skin_scores AUTO_INCREMENT = 1;
ALTER TABLE eeform1_suggestions AUTO_INCREMENT = 1;
```

### 方法二：逐步刪除（明確控制）

```sql
-- 先刪除子表資料（按外鍵依賴順序）
DELETE FROM eeform1_occupations;
DELETE FROM eeform1_lifestyle;
DELETE FROM eeform1_products;
DELETE FROM eeform1_skin_issues;
DELETE FROM eeform1_allergies;
DELETE FROM eeform1_skin_scores;
DELETE FROM eeform1_suggestions;

-- 最後刪除主表資料
DELETE FROM eeform1_submissions;

-- 重設自增ID
ALTER TABLE eeform1_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform1_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform1_lifestyle AUTO_INCREMENT = 1;
ALTER TABLE eeform1_products AUTO_INCREMENT = 1;
ALTER TABLE eeform1_skin_issues AUTO_INCREMENT = 1;
ALTER TABLE eeform1_allergies AUTO_INCREMENT = 1;
ALTER TABLE eeform1_skin_scores AUTO_INCREMENT = 1;
ALTER TABLE eeform1_suggestions AUTO_INCREMENT = 1;
```

### 方法三：使用 TRUNCATE（最快速，但會重設ID）

```sql
-- 注意：由於外鍵約束，需要先停用外鍵檢查
SET FOREIGN_KEY_CHECKS = 0;

-- 清空所有資料表
TRUNCATE TABLE eeform1_occupations;
TRUNCATE TABLE eeform1_lifestyle;
TRUNCATE TABLE eeform1_products;
TRUNCATE TABLE eeform1_skin_issues;
TRUNCATE TABLE eeform1_allergies;
TRUNCATE TABLE eeform1_skin_scores;
TRUNCATE TABLE eeform1_suggestions;
TRUNCATE TABLE eeform1_submissions;

-- 重新啟用外鍵檢查
SET FOREIGN_KEY_CHECKS = 1;
```

### 條件式刪除範例

```sql
-- 刪除特定日期範圍的資料
DELETE FROM eeform1_submissions 
WHERE submission_date BETWEEN '2024-01-01' AND '2024-12-31';

-- 刪除特定會員的所有記錄
DELETE FROM eeform1_submissions 
WHERE member_id = 'MEMBER001';

-- 刪除草稿狀態的記錄
DELETE FROM eeform1_submissions 
WHERE status = 'draft';

-- 刪除指定天數前的舊資料
DELETE FROM eeform1_submissions 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 365 DAY);
```

### 安全刪除前的備份

```sql
-- 在執行大量刪除前，建議先備份資料
CREATE TABLE eeform1_backup_before_delete AS
SELECT 
    s.*,
    'eeform1_submissions' as table_name,
    NOW() as backup_time
FROM eeform1_submissions s;

-- 同樣方式備份其他表
CREATE TABLE eeform1_occupations_backup AS SELECT * FROM eeform1_occupations;
CREATE TABLE eeform1_lifestyle_backup AS SELECT * FROM eeform1_lifestyle;
CREATE TABLE eeform1_products_backup AS SELECT * FROM eeform1_products;
CREATE TABLE eeform1_skin_issues_backup AS SELECT * FROM eeform1_skin_issues;
CREATE TABLE eeform1_allergies_backup AS SELECT * FROM eeform1_allergies;
CREATE TABLE eeform1_skin_scores_backup AS SELECT * FROM eeform1_skin_scores;
CREATE TABLE eeform1_suggestions_backup AS SELECT * FROM eeform1_suggestions;
```

---

## 🚀 一鍵建立所有資料表 SQL 語句

以下是所有 EEFORM1 系統所需資料表的完整建立語句，可以直接複製貼上執行：

```sql
-- ========================================
-- EEFORM1 肌膚諮詢記錄表 - 完整資料庫建立
-- ========================================

-- 1. 主要提交記錄表 (eeform1_submissions)
CREATE TABLE eeform1_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT COMMENT '記錄ID',
    member_id VARCHAR(50) NULL COMMENT '會員編號',
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名（被填表人）',
    form_filler_id VARCHAR(50) NULL COMMENT '代填問卷者ID（當前登入使用者）',
    form_filler_name VARCHAR(100) NULL COMMENT '代填問卷者姓名',
    birth_year SMALLINT NOT NULL COMMENT '出生西元年',
    birth_month TINYINT NOT NULL COMMENT '出生西元月',
    phone VARCHAR(20) NOT NULL COMMENT '電話號碼',
    
    -- 肌膚類型與年齡
    skin_type ENUM('normal', 'combination', 'oily', 'dry', 'sensitive') NULL COMMENT '肌膚類型',
    skin_age TINYINT NULL COMMENT '肌膚年齡',
    
    -- 系統欄位
    submission_date DATETIME NOT NULL COMMENT '填寫日期時間',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_id (member_id),
    INDEX idx_member_name (member_name),
    INDEX idx_phone (phone),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_form_filler_id (form_filler_id),
    INDEX idx_form_filler_name (form_filler_name),
    INDEX idx_member_date (member_id, submission_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚諮詢記錄主表';

-- 2. 職業選擇記錄表 (eeform1_occupations)
CREATE TABLE eeform1_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    occupation_type ENUM('service', 'office', 'restaurant', 'housewife') NOT NULL COMMENT '職業類型',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選擇記錄表';

-- 3. 生活方式記錄表 (eeform1_lifestyle)
CREATE TABLE eeform1_lifestyle (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    category ENUM('sunlight', 'aircondition', 'sleep') NOT NULL COMMENT '生活方式類別',
    item_key VARCHAR(50) NOT NULL COMMENT '項目鍵值',
    item_value VARCHAR(255) NULL COMMENT '項目值（用於其他選項的文字內容）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_lifestyle (submission_id, category, item_key),
    INDEX idx_submission_id (submission_id),
    INDEX idx_category (category),
    INDEX idx_item_key (item_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='生活方式記錄表';

-- 4. 使用產品記錄表 (eeform1_products)
CREATE TABLE eeform1_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    product_type ENUM('honey_soap', 'mud_mask', 'toner', 'serum', 'premium', 'sunscreen', 'other') NOT NULL COMMENT '產品類型',
    product_name VARCHAR(255) NULL COMMENT '產品名稱（用於其他選項）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_product (submission_id, product_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_type (product_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用產品記錄表';

-- 5. 肌膚困擾記錄表 (eeform1_skin_issues)
CREATE TABLE eeform1_skin_issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    issue_type ENUM('elasticity', 'luster', 'dull', 'spots', 'pores', 'acne', 'wrinkles', 'rough', 'irritation', 'dry', 'makeup', 'other') NOT NULL COMMENT '困擾類型',
    issue_description TEXT NULL COMMENT '困擾描述（用於其他選項）',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_issue (submission_id, issue_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_issue_type (issue_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚困擾記錄表';

-- 6. 過敏狀況記錄表 (eeform1_allergies)
CREATE TABLE eeform1_allergies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    allergy_type ENUM('frequent', 'seasonal', 'never') NOT NULL COMMENT '過敏類型',
    is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_allergy (submission_id, allergy_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_allergy_type (allergy_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='過敏狀況記錄表';

-- 7. 肌膚評分記錄表 (eeform1_skin_scores)
CREATE TABLE eeform1_skin_scores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    category ENUM('moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore') NOT NULL COMMENT '評分類別',
    score_type ENUM('severe', 'warning', 'healthy') NOT NULL COMMENT '評分類型',
    score_value TINYINT NOT NULL DEFAULT 0 COMMENT '評分值 (0-10)',
    measurement_date DATE NULL COMMENT '測量日期',
    measurement_number INT NULL COMMENT '測量數值',
    notes TEXT NULL COMMENT '備註',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    UNIQUE KEY uk_submission_category_score (submission_id, category, score_type),
    INDEX idx_submission_id (submission_id),
    INDEX idx_category (category),
    INDEX idx_score_type (score_type),
    INDEX idx_measurement_date (measurement_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚評分記錄表';

-- 8. 建議內容記錄表 (eeform1_suggestions)
CREATE TABLE eeform1_suggestions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '提交記錄ID',
    toner_suggestion VARCHAR(255) NULL COMMENT '化妝水建議',
    serum_suggestion VARCHAR(255) NULL COMMENT '精華液建議',
    suggestion_content TEXT NULL COMMENT '建議內容',
    created_by VARCHAR(100) NULL COMMENT '建議者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    
    FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='建議內容記錄表';

-- ========================================
-- 資料完整性約束
-- ========================================

-- 確保評分值在合理範圍內
ALTER TABLE eeform1_skin_scores 
ADD CONSTRAINT chk_score_range CHECK (score_value >= 0 AND score_value <= 10);

-- 確保出生年月在合理範圍內
ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_birth_year CHECK (birth_year >= 1950 AND birth_year <= 2010),
ADD CONSTRAINT chk_birth_month CHECK (birth_month >= 1 AND birth_month <= 12);

-- 確保肌膚年齡在合理範圍內
ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_skin_age CHECK (skin_age >= 18 AND skin_age <= 80);

-- ========================================
-- 優化索引（可選）
-- ========================================

-- 複合索引：常用查詢組合
CREATE INDEX idx_member_name_date ON eeform1_submissions (member_name, submission_date);
CREATE INDEX idx_phone_date ON eeform1_submissions (phone, submission_date);
CREATE INDEX idx_skin_type_date ON eeform1_submissions (skin_type, submission_date);

-- 全文搜索索引（用於建議內容搜索）
ALTER TABLE eeform1_suggestions ADD FULLTEXT KEY ft_content (suggestion_content);
```