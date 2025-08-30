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