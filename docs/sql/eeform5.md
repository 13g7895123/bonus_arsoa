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