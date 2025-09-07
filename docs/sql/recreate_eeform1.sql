-- Point 100: Remove existing tables and recreate from eeform1.md
-- This script will drop existing tables and recreate them

-- Step 1: Drop existing tables (if they exist)
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS eeform1_suggestions;
DROP TABLE IF EXISTS eeform1_skin_scores;
DROP TABLE IF EXISTS eeform1_allergies;
DROP TABLE IF EXISTS eeform1_skin_issues;
DROP TABLE IF EXISTS eeform1_products;
DROP TABLE IF EXISTS eeform1_lifestyle;
DROP TABLE IF EXISTS eeform1_occupations;
DROP TABLE IF EXISTS eeform1_submissions;

SET FOREIGN_KEY_CHECKS = 1;

-- Step 2: Create tables from schema

-- 1. Main submission table
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

-- 2. Occupations table
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

-- 3. Lifestyle table
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

-- 4. Products table
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

-- 5. Skin issues table
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

-- 6. Allergies table
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

-- 7. Skin scores table
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

-- 8. Suggestions table
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

-- Step 3: Add composite indexes for optimization
CREATE INDEX idx_member_date ON eeform1_submissions (member_id, submission_date);
CREATE INDEX idx_member_name_date ON eeform1_submissions (member_name, submission_date);
CREATE INDEX idx_phone_date ON eeform1_submissions (phone, submission_date);
CREATE INDEX idx_skin_type_date ON eeform1_submissions (skin_type, submission_date);
CREATE INDEX idx_form_filler_id ON eeform1_submissions (form_filler_id);
CREATE INDEX idx_form_filler_name ON eeform1_submissions (form_filler_name);

-- Step 4: Add data integrity constraints
ALTER TABLE eeform1_skin_scores 
ADD CONSTRAINT chk_score_range CHECK (score_value >= 0 AND score_value <= 10);

ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_birth_year CHECK (birth_year >= 1950 AND birth_year <= 2010),
ADD CONSTRAINT chk_birth_month CHECK (birth_month >= 1 AND birth_month <= 12);

ALTER TABLE eeform1_submissions 
ADD CONSTRAINT chk_skin_age CHECK (skin_age >= 18 AND skin_age <= 80);

-- Step 5: Insert a test record to verify tables work correctly
INSERT INTO eeform1_submissions (
    member_id, 
    member_name, 
    form_filler_id,
    form_filler_name,
    birth_year, 
    birth_month, 
    phone, 
    skin_type, 
    skin_age, 
    submission_date
) VALUES (
    '000000', 
    '測試用戶', 
    '000001',
    '操作員',
    1990, 
    5, 
    '0912345678', 
    'combination', 
    25, 
    NOW()
);

-- Get the inserted ID for related tables
SET @test_submission_id = LAST_INSERT_ID();

-- Insert test occupation data
INSERT INTO eeform1_occupations (submission_id, occupation_type) 
VALUES (@test_submission_id, 'office');

-- Insert test lifestyle data
INSERT INTO eeform1_lifestyle (submission_id, category, item_key) 
VALUES (@test_submission_id, 'sunlight', '3_4h');

-- Insert test skin issue data
INSERT INTO eeform1_skin_issues (submission_id, issue_type) 
VALUES (@test_submission_id, 'dry');

-- Insert test skin score data
INSERT INTO eeform1_skin_scores (submission_id, category, score_type, score_value) 
VALUES (@test_submission_id, 'moisture', 'healthy', 8);

-- Insert test suggestion data
INSERT INTO eeform1_suggestions (submission_id, toner_suggestion, serum_suggestion, suggestion_content) 
VALUES (@test_submission_id, '保濕化妝水', '保濕精華液', '建議加強保濕');

-- Verify the test data was inserted successfully
SELECT 
    'Test data inserted successfully!' as message,
    COUNT(*) as submission_count
FROM eeform1_submissions
WHERE member_id = '000000';

-- Display table structure summary
SELECT 
    'Tables created successfully' as status,
    GROUP_CONCAT(table_name SEPARATOR ', ') as created_tables
FROM information_schema.tables 
WHERE table_schema = DATABASE() 
AND table_name LIKE 'eeform1_%';