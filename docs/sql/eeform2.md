# 會員服務追蹤管理表(肌膚) (EForm02) 資料庫結構設計

## 概述
此文檔設計了一個完整的資料庫結構，用於存儲會員服務追蹤管理表(肌膚)的所有資料。設計考慮了資料正規化、效能優化、以及未來功能擴展的需求。

## 主要資料表

### 1. eeform2_submissions (表單提交主表)
```sql
CREATE TABLE eeform2_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '姓名',
    join_date DATE NOT NULL COMMENT '入會日',
    gender ENUM('男', '女') NOT NULL COMMENT '性別',
    age TINYINT UNSIGNED NOT NULL COMMENT '年齡',
    birth_year_month VARCHAR(7) NOT NULL COMMENT '出生年月(YYYY-MM)',
    skin_health_condition TEXT NULL COMMENT '肌膚/健康狀況',
    line_contact VARCHAR(300) NULL COMMENT 'LINE聯絡狀況',
    tel_contact VARCHAR(300) NULL COMMENT '電話聯絡狀況',
    meeting_date DATE NULL COMMENT '見面日',
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_join_date (join_date),
    INDEX idx_submission_date (submission_date),
    INDEX idx_meeting_date (meeting_date),
    INDEX idx_birth_year_month (birth_year_month),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員服務追蹤管理表(肌膚)主表';
```

### 2. eeform2_products (產品訂購明細表)
```sql
CREATE TABLE eeform2_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    quantity INT UNSIGNED NULL DEFAULT 0 COMMENT '數量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品訂購明細表';
```

### 3. eeform2_product_master (產品主檔)
```sql
CREATE TABLE eeform2_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_category ENUM('soap', 'toner', 'serum', 'lotion', 'foundation', 'other') DEFAULT 'other' COMMENT '產品類別',
    description TEXT NULL COMMENT '產品描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_product_code (product_code),
    INDEX idx_product_category (product_category),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品主檔';
```

### 4. eeform2_contact_history (聯絡歷史記錄表)
```sql
CREATE TABLE eeform2_contact_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    contact_type ENUM('LINE', 'TEL', 'MEETING', 'OTHER') NOT NULL COMMENT '聯絡方式',
    contact_date DATE NOT NULL COMMENT '聯絡日期',
    contact_time TIME NULL COMMENT '聯絡時間',
    contact_content TEXT NULL COMMENT '聯絡內容',
    contact_result TEXT NULL COMMENT '聯絡結果',
    follow_up_date DATE NULL COMMENT '下次追蹤日期',
    created_by VARCHAR(100) NULL COMMENT '建立者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_contact_type (contact_type),
    INDEX idx_contact_date (contact_date),
    INDEX idx_follow_up_date (follow_up_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聯絡歷史記錄表';
```

### 5. eeform2_submissions_archive (歷史歸檔表)
```sql
CREATE TABLE eeform2_submissions_archive LIKE eeform2_submissions;

ALTER TABLE eeform2_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';
```

## 預設產品資料
```sql
-- 插入預設產品資料
INSERT INTO eeform2_product_master (product_code, product_name, product_category, sort_order) VALUES
('SOAP001', '淨白活膚蜜皂', 'soap', 1),
('SOAP002', 'AP柔敏潔顏皂', 'soap', 2),
('MASK001', '活顏泥膜', 'other', 3),
('TONER001', '安露莎化粧水I', 'toner', 4),
('TONER002', '安露莎化粧水II', 'toner', 5),
('TONER003', '安露莎活膚化粧水', 'toner', 6),
('TONER004', '柔敏化粧水', 'toner', 7),
('SERUM001', '安露莎精華液I', 'serum', 8),
('SERUM002', '安露莎精華液II', 'serum', 9),
('SERUM003', '安露莎活膚精華液', 'serum', 10),
('SERUM004', '美白精華液', 'serum', 11),
('LOTION001', '保濕潤膚液', 'lotion', 12),
('OIL001', '美容防皺油', 'other', 13),
('GEL001', '保濕凝膠', 'other', 14),
('ESSENCE001', '亮采晶萃', 'other', 15),
('SUNSCREEN001', '防曬隔離液', 'other', 16),
('FOUNDATION001', '保濕粉底液', 'foundation', 17),
('POWDER001', '絲柔粉餅', 'foundation', 18);
```

## 索引優化建議
1. 主要查詢索引已在表結構中定義
2. 根據實際查詢需求可能需要增加複合索引
3. 定期分析查詢效能並優化索引

## 資料維護建議
1. 定期歸檔超過一年的歷史資料到 archive 表
2. 實施資料備份策略
3. 定期清理無效或測試資料
4. 監控表格大小和查詢效能

---

## 完整SQL語句 (可直接複製貼上至資料庫)

```sql
-- eeform2 會員服務追蹤管理表(肌膚) 完整SQL

-- 1. 建立表單提交主表
CREATE TABLE eeform2_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_name VARCHAR(100) NOT NULL COMMENT '姓名',
    join_date DATE NOT NULL COMMENT '入會日',
    gender ENUM('男', '女') NOT NULL COMMENT '性別',
    age TINYINT UNSIGNED NOT NULL COMMENT '年齡',
    birth_year_month VARCHAR(7) NOT NULL COMMENT '出生年月(YYYY-MM)',
    skin_health_condition TEXT NULL COMMENT '肌膚/健康狀況',
    line_contact VARCHAR(300) NULL COMMENT 'LINE聯絡狀況',
    tel_contact VARCHAR(300) NULL COMMENT '電話聯絡狀況',
    meeting_date DATE NULL COMMENT '見面日',
    submission_date DATE NOT NULL COMMENT '填寫日期',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
    status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
    
    INDEX idx_member_name (member_name),
    INDEX idx_join_date (join_date),
    INDEX idx_submission_date (submission_date),
    INDEX idx_meeting_date (meeting_date),
    INDEX idx_birth_year_month (birth_year_month),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員服務追蹤管理表(肌膚)主表';

-- 2. 建立產品訂購明細表
CREATE TABLE eeform2_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    quantity INT UNSIGNED NULL DEFAULT 0 COMMENT '數量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品訂購明細表';

-- 3. 建立產品主檔
CREATE TABLE eeform2_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_category ENUM('soap', 'toner', 'serum', 'lotion', 'foundation', 'other') DEFAULT 'other' COMMENT '產品類別',
    description TEXT NULL COMMENT '產品描述',
    is_active BOOLEAN DEFAULT TRUE COMMENT '是否啟用',
    sort_order INT DEFAULT 0 COMMENT '排序順序',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_product_code (product_code),
    INDEX idx_product_category (product_category),
    INDEX idx_is_active (is_active),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品主檔';

-- 4. 建立聯絡歷史記錄表
CREATE TABLE eeform2_contact_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    contact_type ENUM('LINE', 'TEL', 'MEETING', 'OTHER') NOT NULL COMMENT '聯絡方式',
    contact_date DATE NOT NULL COMMENT '聯絡日期',
    contact_time TIME NULL COMMENT '聯絡時間',
    contact_content TEXT NULL COMMENT '聯絡內容',
    contact_result TEXT NULL COMMENT '聯絡結果',
    follow_up_date DATE NULL COMMENT '下次追蹤日期',
    created_by VARCHAR(100) NULL COMMENT '建立者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform2_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_contact_type (contact_type),
    INDEX idx_contact_date (contact_date),
    INDEX idx_follow_up_date (follow_up_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聯絡歷史記錄表';

-- 5. 建立歷史歸檔表
CREATE TABLE eeform2_submissions_archive LIKE eeform2_submissions;

ALTER TABLE eeform2_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';

-- 6. 插入預設產品資料
INSERT INTO eeform2_product_master (product_code, product_name, product_category, sort_order) VALUES
('SOAP001', '淨白活膚蜜皂', 'soap', 1),
('SOAP002', 'AP柔敏潔顏皂', 'soap', 2),
('MASK001', '活顏泥膜', 'other', 3),
('TONER001', '安露莎化粧水I', 'toner', 4),
('TONER002', '安露莎化粧水II', 'toner', 5),
('TONER003', '安露莎活膚化粧水', 'toner', 6),
('TONER004', '柔敏化粧水', 'toner', 7),
('SERUM001', '安露莎精華液I', 'serum', 8),
('SERUM002', '安露莎精華液II', 'serum', 9),
('SERUM003', '安露莎活膚精華液', 'serum', 10),
('SERUM004', '美白精華液', 'serum', 11),
('LOTION001', '保濕潤膚液', 'lotion', 12),
('OIL001', '美容防皺油', 'other', 13),
('GEL001', '保濕凝膠', 'other', 14),
('ESSENCE001', '亮采晶萃', 'other', 15),
('SUNSCREEN001', '防曬隔離液', 'other', 16),
('FOUNDATION001', '保濕粉底液', 'foundation', 17),
('POWDER001', '絲柔粉餅', 'foundation', 18);
```

## 刪除所有資料的 SQL 語句

### 方法一：利用外鍵級聯刪除（推薦）

```sql
-- 由於相關子表都設定了 ON DELETE CASCADE，
-- 刪除主表時會自動級聯刪除相關資料
DELETE FROM eeform2_submissions;

-- 如需清空產品主檔（注意：這會移除所有產品設定）
-- DELETE FROM eeform2_product_master;

-- 清空歷史歸檔表
DELETE FROM eeform2_submissions_archive;

-- 重設自增ID（可選）
ALTER TABLE eeform2_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform2_products AUTO_INCREMENT = 1;
ALTER TABLE eeform2_product_master AUTO_INCREMENT = 1;
ALTER TABLE eeform2_contact_history AUTO_INCREMENT = 1;
ALTER TABLE eeform2_submissions_archive AUTO_INCREMENT = 1;
```

### 方法二：逐步刪除（明確控制）

```sql
-- 先刪除子表資料（按外鍵依賴順序）
DELETE FROM eeform2_products;
DELETE FROM eeform2_contact_history;

-- 刪除主表資料
DELETE FROM eeform2_submissions;

-- 清空歷史歸檔表
DELETE FROM eeform2_submissions_archive;

-- 可選：清空產品主檔（會移除所有產品設定）
-- DELETE FROM eeform2_product_master;

-- 重設自增ID
ALTER TABLE eeform2_submissions AUTO_INCREMENT = 1;
ALTER TABLE eeform2_products AUTO_INCREMENT = 1;
ALTER TABLE eeform2_product_master AUTO_INCREMENT = 1;
ALTER TABLE eeform2_contact_history AUTO_INCREMENT = 1;
ALTER TABLE eeform2_submissions_archive AUTO_INCREMENT = 1;
```

### 方法三：使用 TRUNCATE（最快速，但會重設ID）

```sql
-- 注意：由於外鍵約束，需要先停用外鍵檢查
SET FOREIGN_KEY_CHECKS = 0;

-- 清空所有資料表
TRUNCATE TABLE eeform2_products;
TRUNCATE TABLE eeform2_contact_history;
TRUNCATE TABLE eeform2_submissions;
TRUNCATE TABLE eeform2_submissions_archive;

-- 可選：清空產品主檔
-- TRUNCATE TABLE eeform2_product_master;

-- 重新啟用外鍵檢查
SET FOREIGN_KEY_CHECKS = 1;
```

### 條件式刪除範例

```sql
-- 刪除特定日期範圍的資料
DELETE FROM eeform2_submissions 
WHERE submission_date BETWEEN '2024-01-01' AND '2024-12-31';

-- 刪除特定會員的所有記錄
DELETE FROM eeform2_submissions 
WHERE member_name = '王小明';

-- 刪除草稿狀態的記錄
DELETE FROM eeform2_submissions 
WHERE status = 'draft';

-- 刪除指定天數前的舊資料
DELETE FROM eeform2_submissions 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 365 DAY);

-- 刪除特定聯絡歷史記錄
DELETE FROM eeform2_contact_history 
WHERE contact_date < DATE_SUB(NOW(), INTERVAL 180 DAY);
```

### 重設產品主檔為預設資料

```sql
-- 如果需要重設產品主檔為預設狀態
TRUNCATE TABLE eeform2_product_master;

-- 重新插入預設產品資料
INSERT INTO eeform2_product_master (product_code, product_name, product_category, sort_order) VALUES
('SOAP001', '淨白活膚蜜皂', 'soap', 1),
('SOAP002', 'AP柔敏潔顏皂', 'soap', 2),
('MASK001', '活顏泥膜', 'other', 3),
('TONER001', '安露莎化粧水I', 'toner', 4),
('TONER002', '安露莎化粧水II', 'toner', 5),
('TONER003', '安露莎活膚化粧水', 'toner', 6),
('TONER004', '柔敏化粧水', 'toner', 7),
('SERUM001', '安露莎精華液I', 'serum', 8),
('SERUM002', '安露莎精華液II', 'serum', 9),
('SERUM003', '安露莎活膚精華液', 'serum', 10),
('SERUM004', '美白精華液', 'serum', 11),
('LOTION001', '保濕潤膚液', 'lotion', 12),
('OIL001', '美容防皺油', 'other', 13),
('GEL001', '保濕凝膠', 'other', 14),
('ESSENCE001', '亮采晶萃', 'other', 15),
('SUNSCREEN001', '防曬隔離液', 'other', 16),
('FOUNDATION001', '保濕粉底液', 'foundation', 17),
('POWDER001', '絲柔粉餅', 'foundation', 18);
```

### 安全刪除前的備份

```sql
-- 在執行大量刪除前，建議先備份資料
CREATE TABLE eeform2_backup_before_delete AS
SELECT 
    s.*,
    'eeform2_submissions' as table_name,
    NOW() as backup_time
FROM eeform2_submissions s;

-- 同樣方式備份其他表
CREATE TABLE eeform2_products_backup AS SELECT * FROM eeform2_products;
CREATE TABLE eeform2_contact_history_backup AS SELECT * FROM eeform2_contact_history;
CREATE TABLE eeform2_product_master_backup AS SELECT * FROM eeform2_product_master;
CREATE TABLE eeform2_archive_backup AS SELECT * FROM eeform2_submissions_archive;
```