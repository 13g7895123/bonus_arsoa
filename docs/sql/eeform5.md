# 個人體測表+健康諮詢表 (EForm05) 資料庫結構設計

## 概述
此文檔設計了一個完整的資料庫結構，用於存儲個人體測表+健康諮詢表的所有資料。包含了完整的體測標準建議值欄位，以及更詳細的個人基本資料收集。

## 主要資料表

### 1. eeform5_submissions (表單提交主表)
```sql
CREATE TABLE eeform5_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
    member_id VARCHAR(50) NOT NULL COMMENT '會員編號',
    phone VARCHAR(20) NULL COMMENT '手機號碼',
    gender ENUM('男', '女') NULL COMMENT '性別',
    age TINYINT UNSIGNED NULL COMMENT '年齡',
    height VARCHAR(20) NULL COMMENT '身高',
    exercise_habit ENUM('是', '否') NULL COMMENT '運動習慣',
    
    -- 體測標準建議值欄位
    weight DECIMAL(5,2) NULL COMMENT '體重Kg',
    bmi DECIMAL(5,2) NULL COMMENT 'BMI',
    fat_percentage DECIMAL(5,2) NULL COMMENT '脂肪率%',
    fat_mass DECIMAL(5,2) NULL COMMENT '脂肪量Kg',
    muscle_percentage DECIMAL(5,2) NULL COMMENT '肌肉%',
    muscle_mass DECIMAL(5,2) NULL COMMENT '肌肉量Kg',
    water_percentage DECIMAL(5,2) NULL COMMENT '水份比例%',
    water_content DECIMAL(5,2) NULL COMMENT '水含量Kg',
    visceral_fat_percentage DECIMAL(5,2) NULL COMMENT '內臟脂肪率%',
    bone_mass DECIMAL(5,2) NULL COMMENT '骨量Kg',
    bmr INT NULL COMMENT '基礎代謝率(卡)',
    protein_percentage DECIMAL(5,2) NULL COMMENT '蛋白質%',
    obesity_percentage DECIMAL(5,2) NULL COMMENT '肥胖度%',
    body_age TINYINT UNSIGNED NULL COMMENT '身體年齡',
    lean_body_mass DECIMAL(5,2) NULL COMMENT '去脂體重KG',
    
    -- 原有健康資料欄位
    has_medication_habit BOOLEAN DEFAULT FALSE COMMENT '是否有長期用藥習慣',
    medication_name VARCHAR(255) NULL COMMENT '使用藥物名稱',
    has_family_disease_history BOOLEAN DEFAULT FALSE COMMENT '是否有家族慢性病史',
    disease_name VARCHAR(255) NULL COMMENT '疾病名稱',
    microcirculation_test TEXT NULL COMMENT '微循環檢測結果',
    dietary_advice TEXT NULL COMMENT '日常飲食建議',
    
    -- 系統欄位
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed', 'completed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_member_id (member_id),
    INDEX idx_phone (phone),
    INDEX idx_gender (gender),
    INDEX idx_age (age),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='個人體測表+健康諮詢表主表';
```

### 2. eeform5_occupations (職業選項表)
```sql
CREATE TABLE eeform5_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    occupation_type ENUM('服務業', '上班族', '餐飲業', '自由業', '其他') NOT NULL COMMENT '職業類型',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type),
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選項記錄表';
```

### 3. eeform5_health_concerns (健康困擾記錄表)
```sql
CREATE TABLE eeform5_health_concerns (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    concern_type ENUM('經常頭痛', '過敏問題', '睡眠不佳', '骨關節問題', '三高問題', '腸胃健康問題', '視力問題', '免疫力', '體重困擾', '其他') NOT NULL COMMENT '健康困擾類型',
    other_description VARCHAR(255) NULL COMMENT '其他困擾描述',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_concern_type (concern_type),
    UNIQUE KEY uk_submission_concern (submission_id, concern_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾記錄表';
```

### 4. eeform5_product_recommendations (產品建議表)
```sql
CREATE TABLE eeform5_product_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_name ENUM('活力精萃', '白鶴靈芝EX', '美力C錠', '鶴力晶', '白鶴靈芝茶') NOT NULL COMMENT '產品名稱',
    recommended_dosage VARCHAR(200) NULL COMMENT '建議用量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_name (product_name),
    UNIQUE KEY uk_submission_product (submission_id, product_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品建議記錄表';
```

### 5. eeform5_submissions_archive (歷史歸檔表)
```sql
CREATE TABLE eeform5_submissions_archive LIKE eeform5_submissions;

ALTER TABLE eeform5_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';
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

## 特別說明
此表單為個人體測表+健康諮詢表，包含了完整的體測標準建議值欄位，包含15個體測相關數據。同時包含完整的基本資料收集，包含手機號碼、性別、年齡和運動習慣等資訊。

---

## 完整SQL語句 (可直接複製貼上至資料庫)

```sql
-- eeform5 個人體測表+健康諮詢表 完整SQL

-- 1. 建立表單提交主表
CREATE TABLE eeform5_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '會員姓名',
    member_id VARCHAR(50) NOT NULL COMMENT '會員編號',
    phone VARCHAR(20) NULL COMMENT '手機號碼',
    gender ENUM('男', '女') NULL COMMENT '性別',
    age TINYINT UNSIGNED NULL COMMENT '年齡',
    height VARCHAR(20) NULL COMMENT '身高',
    exercise_habit ENUM('是', '否') NULL COMMENT '運動習慣',
    
    -- 體測標準建議值欄位
    weight DECIMAL(5,2) NULL COMMENT '體重Kg',
    bmi DECIMAL(5,2) NULL COMMENT 'BMI',
    fat_percentage DECIMAL(5,2) NULL COMMENT '脂肪率%',
    fat_mass DECIMAL(5,2) NULL COMMENT '脂肪量Kg',
    muscle_percentage DECIMAL(5,2) NULL COMMENT '肌肉%',
    muscle_mass DECIMAL(5,2) NULL COMMENT '肌肉量Kg',
    water_percentage DECIMAL(5,2) NULL COMMENT '水份比例%',
    water_content DECIMAL(5,2) NULL COMMENT '水含量Kg',
    visceral_fat_percentage DECIMAL(5,2) NULL COMMENT '內臟脂肪率%',
    bone_mass DECIMAL(5,2) NULL COMMENT '骨量Kg',
    bmr INT NULL COMMENT '基礎代謝率(卡)',
    protein_percentage DECIMAL(5,2) NULL COMMENT '蛋白質%',
    obesity_percentage DECIMAL(5,2) NULL COMMENT '肥胖度%',
    body_age TINYINT UNSIGNED NULL COMMENT '身體年齡',
    lean_body_mass DECIMAL(5,2) NULL COMMENT '去脂體重KG',
    
    -- 原有健康資料欄位
    has_medication_habit BOOLEAN DEFAULT FALSE COMMENT '是否有長期用藥習慣',
    medication_name VARCHAR(255) NULL COMMENT '使用藥物名稱',
    has_family_disease_history BOOLEAN DEFAULT FALSE COMMENT '是否有家族慢性病史',
    disease_name VARCHAR(255) NULL COMMENT '疾病名稱',
    microcirculation_test TEXT NULL COMMENT '微循環檢測結果',
    dietary_advice TEXT NULL COMMENT '日常飲食建議',
    
    -- 系統欄位
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed', 'completed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_member_id (member_id),
    INDEX idx_phone (phone),
    INDEX idx_gender (gender),
    INDEX idx_age (age),
    INDEX idx_submission_date (submission_date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='個人體測表+健康諮詢表主表';

-- 2. 建立職業選項表
CREATE TABLE eeform5_occupations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    occupation_type ENUM('服務業', '上班族', '餐飲業', '自由業', '其他') NOT NULL COMMENT '職業類型',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_occupation_type (occupation_type),
    UNIQUE KEY uk_submission_occupation (submission_id, occupation_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選項記錄表';

-- 3. 建立健康困擾記錄表
CREATE TABLE eeform5_health_concerns (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    concern_type ENUM('經常頭痛', '過敏問題', '睡眠不佳', '骨關節問題', '三高問題', '腸胃健康問題', '視力問題', '免疫力', '體重困擾', '其他') NOT NULL COMMENT '健康困擾類型',
    other_description VARCHAR(255) NULL COMMENT '其他困擾描述',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_concern_type (concern_type),
    UNIQUE KEY uk_submission_concern (submission_id, concern_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康困擾記錄表';

-- 4. 建立產品建議表
CREATE TABLE eeform5_product_recommendations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_name ENUM('活力精萃', '白鶴靈芝EX', '美力C錠', '鶴力晶', '白鶴靈芝茶') NOT NULL COMMENT '產品名稱',
    recommended_dosage VARCHAR(200) NULL COMMENT '建議用量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform5_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_name (product_name),
    UNIQUE KEY uk_submission_product (submission_id, product_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品建議記錄表';

-- 5. 建立歷史歸檔表
CREATE TABLE eeform5_submissions_archive LIKE eeform5_submissions;

ALTER TABLE eeform5_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';
```

## 刪除所有資料的 SQL 語句

### 方法一：利用外鍵級聯刪除（推薦）

```sql
-- 由於所有子表都設定了 ON DELETE CASCADE，
-- 只需要刪除主表，相關資料會自動級聯刪除
DELETE FROM eeform5_submissions;

-- 清空歷史歸檔表
DELETE FROM eeform5_submissions_archive;

-- 重設自增ID（可選）
ALTER TABLE eeform5_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform5_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_concerns AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_recommendations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_submissions_archive AUTO_INCREMENT = 1;
```

### 方法二：逐步刪除（明確控制）

```sql
-- 先刪除子表資料（按外鍵依賴順序）
DELETE FROM eeform5_occupations;
DELETE FROM eeform5_health_concerns;
DELETE FROM eeform5_product_recommendations;

-- 刪除主表資料
DELETE FROM eeform5_submissions;

-- 清空歷史歸檔表
DELETE FROM eeform5_submissions_archive;

-- 重設自增ID
ALTER TABLE eeform5_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform5_occupations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_health_concerns AUTO_INCREMENT = 1;
ALTER TABLE eeform5_product_recommendations AUTO_INCREMENT = 1;
ALTER TABLE eeform5_submissions_archive AUTO_INCREMENT = 1;
```

### 方法三：使用 TRUNCATE（最快速，但會重設ID）

```sql
-- 注意：由於外鍵約束，需要先停用外鍵檢查
SET FOREIGN_KEY_CHECKS = 0;

-- 清空所有資料表
TRUNCATE TABLE eeform5_occupations;
TRUNCATE TABLE eeform5_health_concerns;
TRUNCATE TABLE eeform5_product_recommendations;
TRUNCATE TABLE eeform5_submissions;
TRUNCATE TABLE eeform5_submissions_archive;

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

-- 刪除特定會員編號的記錄
DELETE FROM eeform5_submissions 
WHERE member_id = '000000';

-- 刪除草稿狀態的記錄
DELETE FROM eeform5_submissions 
WHERE status = 'draft';

-- 刪除指定天數前的舊資料
DELETE FROM eeform5_submissions 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 365 DAY);

-- 刪除特定年齡範圍的記錄
DELETE FROM eeform5_submissions 
WHERE age BETWEEN 18 AND 30;

-- 刪除特定性別的記錄
DELETE FROM eeform5_submissions 
WHERE gender = '男';
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
CREATE TABLE eeform5_health_concerns_backup AS SELECT * FROM eeform5_health_concerns;
CREATE TABLE eeform5_product_recommendations_backup AS SELECT * FROM eeform5_product_recommendations;
CREATE TABLE eeform5_archive_backup AS SELECT * FROM eeform5_submissions_archive;
```