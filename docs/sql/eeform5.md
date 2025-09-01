# 健康諮詢表 (EForm05) 資料庫結構設計

## 概述
此文檔設計了一個完整的資料庫結構，用於存儲健康諮詢表的所有資料。設計考慮了資料正規化、效能優化、以及未來功能擴展的需求。

## 主要資料表

### 1. eeform5_submissions (表單提交主表)
```sql
CREATE TABLE eeform5_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
    birth_year SMALLINT UNSIGNED NOT NULL COMMENT '出生西元年',
    birth_month TINYINT UNSIGNED NOT NULL COMMENT '出生西元月',
    height SMALLINT UNSIGNED NOT NULL COMMENT '身高(公分)',
    has_medication_habit BOOLEAN DEFAULT FALSE COMMENT '是否有長期用藥習慣',
    medication_name VARCHAR(255) NULL COMMENT '使用藥物名稱',
    has_family_disease_history BOOLEAN DEFAULT FALSE COMMENT '是否有家族慢性病史',
    disease_name VARCHAR(255) NULL COMMENT '疾病名稱',
    microcirculation_test TEXT NULL COMMENT '微循環檢測結果',
    dietary_advice TEXT NULL COMMENT '日常飲食建議',
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed', 'completed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_birth_year_month (birth_year, birth_month),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康諮詢表主表';
```

### 2. eeform5_occupations (職業選項表)
```sql
CREATE TABLE eeform5_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    occupation_type ENUM('service', 'office', 'restaurant', 'freelance', 'other') NOT NULL COMMENT '職業類型',
    occupation_name VARCHAR(100) NOT NULL COMMENT '職業名稱',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type),
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選項記錄表';
```

### 3. eeform5_health_issues (健康困擾記錄表)
```sql
CREATE TABLE eeform5_health_issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    issue_code VARCHAR(50) NOT NULL COMMENT '困擾代碼',
    issue_name VARCHAR(100) NOT NULL COMMENT '困擾名稱',
    other_description VARCHAR(255) NULL COMMENT '其他描述',
    severity ENUM('mild', 'moderate', 'severe') NULL COMMENT '嚴重程度',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_issue_code (issue_code),
    UNIQUE KEY uk_submission_issue (submission_id, issue_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾記錄表';
```

### 4. eeform5_health_issues_master (健康困擾主檔)
```sql
CREATE TABLE eeform5_health_issues_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    issue_code VARCHAR(50) NOT NULL UNIQUE COMMENT '困擾代碼',
    issue_name VARCHAR(100) NOT NULL COMMENT '困擾名稱',
    issue_category VARCHAR(50) NULL COMMENT '困擾類別',
    description TEXT NULL COMMENT '詳細描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_issue_code (issue_code),
    INDEX idx_issue_category (issue_category),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾主檔';
```

### 5. eeform5_product_recommendations (產品建議表)
```sql
CREATE TABLE eeform5_product_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    recommended_dosage VARCHAR(100) NULL COMMENT '建議用量',
    usage_timing VARCHAR(100) NULL COMMENT '使用時機',
    notes TEXT NULL COMMENT '備註',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品建議記錄表';
```

### 6. eeform5_product_master (產品主檔)
```sql
CREATE TABLE eeform5_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_type ENUM('supplement', 'tea', 'other') DEFAULT 'supplement' COMMENT '產品類型',
    default_dosage VARCHAR(100) NULL COMMENT '預設建議用量',
    description TEXT NULL COMMENT '產品描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_product_code (product_code),
    INDEX idx_product_type (product_type),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品主檔';
```

### 7. eeform5_consultation_records (諮詢記錄表)
```sql
CREATE TABLE eeform5_consultation_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    consultation_date DATE NOT NULL COMMENT '諮詢日期',
    consultant_name VARCHAR(100) NULL COMMENT '諮詢師姓名',
    consultation_type ENUM('initial', 'follow_up', 'review') DEFAULT 'initial' COMMENT '諮詢類型',
    consultation_notes TEXT NULL COMMENT '諮詢記錄',
    health_assessment TEXT NULL COMMENT '健康評估',
    recommendations TEXT NULL COMMENT '建議事項',
    next_consultation_date DATE NULL COMMENT '下次諮詢日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_consultation_date (consultation_date),
    INDEX idx_consultation_type (consultation_type),
    INDEX idx_next_consultation_date (next_consultation_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='諮詢記錄表';
```

### 8. eeform5_submissions_archive (歷史歸檔表)
```sql
CREATE TABLE eeform5_submissions_archive LIKE eeform5_submissions;

ALTER TABLE eeform5_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';
```

## 預設資料

### 預設健康困擾項目
```sql
-- 插入預設健康困擾項目
INSERT INTO eeform5_health_issues_master (issue_code, issue_name, issue_category, sort_order) VALUES
('HEADACHE', '經常頭痛', 'neurological', 1),
('ALLERGY', '過敏問題', 'immune', 2),
('SLEEP', '睡眠不佳', 'mental', 3),
('JOINT', '骨關節問題', 'musculoskeletal', 4),
('METABOLIC', '三高問題(血糖/血脂肪/血壓)', 'metabolic', 5),
('DIGESTIVE', '腸胃健康問題', 'digestive', 6),
('VISION', '視力問題', 'sensory', 7),
('IMMUNITY', '免疫力', 'immune', 8),
('WEIGHT', '體重困擾', 'metabolic', 9),
('OTHER', '其他', 'other', 10);
```

### 預設產品資料
```sql
-- 插入預設產品資料
INSERT INTO eeform5_product_master (product_code, product_name, product_type, default_dosage, sort_order) VALUES
('VITAL001', '活力精萃', 'supplement', '每日2次，每次1包', 1),
('LINGZHI001', '白鶴靈芝EX', 'supplement', '每日1-2次，每次2粒', 2),
('VITC001', '美力C錠', 'supplement', '每日1次，每次2錠', 3),
('CRYSTAL001', '鶴力晶', 'supplement', '每日1次，每次1包', 4),
('TEA001', '白鶴靈芝茶', 'tea', '每日1-2包', 5);
```

### 預設職業選項
```sql
-- 預設職業對應
-- service: 服務業
-- office: 上班族
-- restaurant: 餐飲業
-- freelance: 自由業
-- other: 其他
```

## 索引優化建議
1. 主要查詢索引已在表結構中定義
2. 根據實際查詢需求可能需要增加複合索引
3. 定期分析查詢效能並優化索引
4. 考慮為常用的查詢組合建立複合索引

## 資料維護建議
1. 定期歸檔超過兩年的歷史資料到 archive 表
2. 實施資料備份策略
3. 定期清理無效或測試資料
4. 監控表格大小和查詢效能
5. 定期更新健康困擾主檔和產品主檔

## 特別說明
此表單為健康諮詢專用表單，設計上考慮了多選項目（職業、健康困擾）和產品推薦的靈活性。透過主檔表的設計，可以方便地新增或修改選項，而不需要更改程式碼。

---

## 完整SQL語句 (可直接複製貼上至資料庫)

```sql
-- eeform5 健康諮詢表 完整SQL

-- 1. 建立表單提交主表
CREATE TABLE eeform5_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
    birth_year SMALLINT UNSIGNED NOT NULL COMMENT '出生西元年',
    birth_month TINYINT UNSIGNED NOT NULL COMMENT '出生西元月',
    height SMALLINT UNSIGNED NOT NULL COMMENT '身高(公分)',
    has_medication_habit BOOLEAN DEFAULT FALSE COMMENT '是否有長期用藥習慣',
    medication_name VARCHAR(255) NULL COMMENT '使用藥物名稱',
    has_family_disease_history BOOLEAN DEFAULT FALSE COMMENT '是否有家族慢性病史',
    disease_name VARCHAR(255) NULL COMMENT '疾病名稱',
    microcirculation_test TEXT NULL COMMENT '微循環檢測結果',
    dietary_advice TEXT NULL COMMENT '日常飲食建議',
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed', 'completed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_birth_year_month (birth_year, birth_month),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康諮詢表主表';

-- 2. 建立職業選項表
CREATE TABLE eeform5_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    occupation_type ENUM('service', 'office', 'restaurant', 'freelance', 'other') NOT NULL COMMENT '職業類型',
    occupation_name VARCHAR(100) NOT NULL COMMENT '職業名稱',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type),
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選項記錄表';

-- 3. 建立健康困擾記錄表
CREATE TABLE eeform5_health_issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    issue_code VARCHAR(50) NOT NULL COMMENT '困擾代碼',
    issue_name VARCHAR(100) NOT NULL COMMENT '困擾名稱',
    other_description VARCHAR(255) NULL COMMENT '其他描述',
    severity ENUM('mild', 'moderate', 'severe') NULL COMMENT '嚴重程度',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_issue_code (issue_code),
    UNIQUE KEY uk_submission_issue (submission_id, issue_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾記錄表';

-- 4. 建立健康困擾主檔
CREATE TABLE eeform5_health_issues_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    issue_code VARCHAR(50) NOT NULL UNIQUE COMMENT '困擾代碼',
    issue_name VARCHAR(100) NOT NULL COMMENT '困擾名稱',
    issue_category VARCHAR(50) NULL COMMENT '困擾類別',
    description TEXT NULL COMMENT '詳細描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_issue_code (issue_code),
    INDEX idx_issue_category (issue_category),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾主檔';

-- 5. 建立產品建議表
CREATE TABLE eeform5_product_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    recommended_dosage VARCHAR(100) NULL COMMENT '建議用量',
    usage_timing VARCHAR(100) NULL COMMENT '使用時機',
    notes TEXT NULL COMMENT '備註',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品建議記錄表';

-- 6. 建立產品主檔
CREATE TABLE eeform5_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_type ENUM('supplement', 'tea', 'other') DEFAULT 'supplement' COMMENT '產品類型',
    default_dosage VARCHAR(100) NULL COMMENT '預設建議用量',
    description TEXT NULL COMMENT '產品描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_product_code (product_code),
    INDEX idx_product_type (product_type),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品主檔';

-- 7. 建立諮詢記錄表
CREATE TABLE eeform5_consultation_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    consultation_date DATE NOT NULL COMMENT '諮詢日期',
    consultant_name VARCHAR(100) NULL COMMENT '諮詢師姓名',
    consultation_type ENUM('initial', 'follow_up', 'review') DEFAULT 'initial' COMMENT '諮詢類型',
    consultation_notes TEXT NULL COMMENT '諮詢記錄',
    health_assessment TEXT NULL COMMENT '健康評估',
    recommendations TEXT NULL COMMENT '建議事項',
    next_consultation_date DATE NULL COMMENT '下次諮詢日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_consultation_date (consultation_date),
    INDEX idx_consultation_type (consultation_type),
    INDEX idx_next_consultation_date (next_consultation_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='諮詢記錄表';

-- 8. 建立歷史歸檔表
CREATE TABLE eeform5_submissions_archive LIKE eeform5_submissions;

ALTER TABLE eeform5_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';

-- 9. 插入預設健康困擾項目
INSERT INTO eeform5_health_issues_master (issue_code, issue_name, issue_category, sort_order) VALUES
('HEADACHE', '經常頭痛', 'neurological', 1),
('ALLERGY', '過敏問題', 'immune', 2),
('SLEEP', '睡眠不佳', 'mental', 3),
('JOINT', '骨關節問題', 'musculoskeletal', 4),
('METABOLIC', '三高問題(血糖/血脂肪/血壓)', 'metabolic', 5),
('DIGESTIVE', '腸胃健康問題', 'digestive', 6),
('VISION', '視力問題', 'sensory', 7),
('IMMUNITY', '免疫力', 'immune', 8),
('WEIGHT', '體重困擾', 'metabolic', 9),
('OTHER', '其他', 'other', 10);

-- 10. 插入預設產品資料
INSERT INTO eeform5_product_master (product_code, product_name, product_type, default_dosage, sort_order) VALUES
('VITAL001', '活力精萃', 'supplement', '每日2次，每次1包', 1),
('LINGZHI001', '白鶴靈芝EX', 'supplement', '每日1-2次，每次2粒', 2),
('VITC001', '美力C錠', 'supplement', '每日1次，每次2錠', 3),
('CRYSTAL001', '鶴力晶', 'supplement', '每日1次，每次1包', 4),
('TEA001', '白鶴靈芝茶', 'tea', '每日1-2包', 5);
```

## 刪除所有資料的 SQL 語句

### 方法一：利用外鍵級聯刪除（推薦）

```sql
-- 由於所有子表都設定了 ON DELETE CASCADE，
-- 只需要刪除主表，相關資料會自動級聯刪除
DELETE FROM eeform5_submissions;

-- 如需清空主檔表（注意：這會移除所有預設設定）
-- DELETE FROM eeform5_health_issues_master;
-- DELETE FROM eeform5_product_master;

-- 清空歷史歸檔表
DELETE FROM eeform5_submissions_archive;

-- 重設自增ID（可選）
ALTER TABLE eeform5_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform5_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_issues AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_issues_master AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_recommendations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_master AUTO_INCREMENT = 1;
ALTER TABLE eeform5_consultation_records AUTO_INCREMENT = 1;
ALTER TABLE eeform5_submissions_archive AUTO_INCREMENT = 1;
```

### 方法二：逐步刪除（明確控制）

```sql
-- 先刪除子表資料（按外鍵依賴順序）
DELETE FROM eeform5_occupations;
DELETE FROM eeform5_health_issues;
DELETE FROM eeform5_product_recommendations;
DELETE FROM eeform5_consultation_records;

-- 刪除主表資料
DELETE FROM eeform5_submissions;

-- 清空歷史歸檔表
DELETE FROM eeform5_submissions_archive;

-- 可選：清空主檔表（會移除所有預設設定）
-- DELETE FROM eeform5_health_issues_master;
-- DELETE FROM eeform5_product_master;

-- 重設自增ID
ALTER TABLE eeform5_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform5_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_issues AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_issues_master AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_recommendations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_master AUTO_INCREMENT = 1;
ALTER TABLE eeform5_consultation_records AUTO_INCREMENT = 1;
ALTER TABLE eeform5_submissions_archive AUTO_INCREMENT = 1;
```

### 方法三：使用 TRUNCATE（最快速，但會重設ID）

```sql
-- 注意：由於外鍵約束，需要先停用外鍵檢查
SET FOREIGN_KEY_CHECKS = 0;

-- 清空所有資料表
TRUNCATE TABLE eeform5_occupations;
TRUNCATE TABLE eeform5_health_issues;
TRUNCATE TABLE eeform5_product_recommendations;
TRUNCATE TABLE eeform5_consultation_records;
TRUNCATE TABLE eeform5_submissions;
TRUNCATE TABLE eeform5_submissions_archive;

-- 可選：清空主檔表
-- TRUNCATE TABLE eeform5_health_issues_master;
-- TRUNCATE TABLE eeform5_product_master;

-- 重新啟用外鍵檢查
SET FOREIGN_KEY_CHECKS = 1;
```

### 條件式刪除範例

```sql
-- 刪除特定日期範圍的資料
DELETE FROM eeform5_submissions 
WHERE submission_date BETWEEN '2024-01-01' AND '2024-12-31';

-- 刪除特定會員的所有記錄
DELETE FROM eeform5_submissions 
WHERE member_name = '王小明';

-- 刪除草稿狀態的記錄
DELETE FROM eeform5_submissions 
WHERE status = 'draft';

-- 刪除指定天數前的舊資料
DELETE FROM eeform5_submissions 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 365 DAY);

-- 刪除特定年齡範圍的記錄
DELETE FROM eeform5_submissions 
WHERE YEAR(NOW()) - birth_year BETWEEN 18 AND 30;

-- 刪除特定諮詢記錄
DELETE FROM eeform5_consultation_records 
WHERE consultation_date < DATE_SUB(NOW(), INTERVAL 180 DAY);
```

### 重設主檔為預設資料

```sql
-- 重設健康困擾主檔為預設狀態
TRUNCATE TABLE eeform5_health_issues_master;

-- 重新插入預設健康困擾項目
INSERT INTO eeform5_health_issues_master (issue_code, issue_name, issue_category, sort_order) VALUES
('HEADACHE', '經常頭痛', 'neurological', 1),
('ALLERGY', '過敏問題', 'immune', 2),
('SLEEP', '睡眠不佳', 'mental', 3),
('JOINT', '骨關節問題', 'musculoskeletal', 4),
('METABOLIC', '三高問題(血糖/血脂肪/血壓)', 'metabolic', 5),
('DIGESTIVE', '腸胃健康問題', 'digestive', 6),
('VISION', '視力問題', 'sensory', 7),
('IMMUNITY', '免疫力', 'immune', 8),
('WEIGHT', '體重困擾', 'metabolic', 9),
('OTHER', '其他', 'other', 10);

-- 重設產品主檔為預設狀態
TRUNCATE TABLE eeform5_product_master;

-- 重新插入預設產品資料
INSERT INTO eeform5_product_master (product_code, product_name, product_type, default_dosage, sort_order) VALUES
('VITAL001', '活力精萃', 'supplement', '每日2次，每次1包', 1),
('LINGZHI001', '白鶴靈芝EX', 'supplement', '每日1-2次，每次2粒', 2),
('VITC001', '美力C錠', 'supplement', '每日1次，每次2錠', 3),
('CRYSTAL001', '鶴力晶', 'supplement', '每日1次，每次1包', 4),
('TEA001', '白鶴靈芝茶', 'tea', '每日1-2包', 5);
```

### 安全刪除前的備份

```sql
-- 在執行大量刪除前，建議先備份資料
CREATE TABLE eeform5_backup_before_delete AS
SELECT 
    s.*,
    'eeform5_submissions' as table_name,
    NOW() as backup_time
FROM eeform5_submissions s;

-- 同樣方式備份其他表
CREATE TABLE eeform5_occupations_backup AS SELECT * FROM eeform5_occupations;
CREATE TABLE eeform5_health_issues_backup AS SELECT * FROM eeform5_health_issues;
CREATE TABLE eeform5_health_issues_master_backup AS SELECT * FROM eeform5_health_issues_master;
CREATE TABLE eeform5_product_recommendations_backup AS SELECT * FROM eeform5_product_recommendations;
CREATE TABLE eeform5_product_master_backup AS SELECT * FROM eeform5_product_master;
CREATE TABLE eeform5_consultation_records_backup AS SELECT * FROM eeform5_consultation_records;
CREATE TABLE eeform5_archive_backup AS SELECT * FROM eeform5_submissions_archive;
```