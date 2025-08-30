# 會員服務追蹤管理表(保健) (EForm04) 資料庫結構設計

## 概述
此文檔設計了一個完整的資料庫結構，用於存儲會員服務追蹤管理表(保健)的所有資料。設計考慮了資料正規化、效能優化、以及未來功能擴展的需求。

## 主要資料表

### 1. eeform4_submissions (表單提交主表)
```sql
CREATE TABLE eeform4_submissions (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員服務追蹤管理表(保健)主表';
```

### 2. eeform4_products (產品訂購明細表)
```sql
CREATE TABLE eeform4_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    quantity INT UNSIGNED NULL DEFAULT 0 COMMENT '數量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品訂購明細表';
```

### 3. eeform4_product_master (產品主檔)
```sql
CREATE TABLE eeform4_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_category ENUM('supplement', 'tea', 'skincare', 'other') DEFAULT 'supplement' COMMENT '產品類別',
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

### 4. eeform4_contact_history (聯絡歷史記錄表)
```sql
CREATE TABLE eeform4_contact_history (
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
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_contact_type (contact_type),
    INDEX idx_contact_date (contact_date),
    INDEX idx_follow_up_date (follow_up_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聯絡歷史記錄表';
```

### 5. eeform4_health_tracking (健康追蹤記錄表)
```sql
CREATE TABLE eeform4_health_tracking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    tracking_date DATE NOT NULL COMMENT '追蹤日期',
    health_status TEXT NULL COMMENT '健康狀態描述',
    improvement_notes TEXT NULL COMMENT '改善記錄',
    product_effectiveness TEXT NULL COMMENT '產品效果評估',
    next_recommendation TEXT NULL COMMENT '下次建議',
    created_by VARCHAR(100) NULL COMMENT '記錄者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_tracking_date (tracking_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康追蹤記錄表';
```

### 6. eeform4_submissions_archive (歷史歸檔表)
```sql
CREATE TABLE eeform4_submissions_archive LIKE eeform4_submissions;

ALTER TABLE eeform4_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';
```

## 預設產品資料
```sql
-- 插入預設產品資料
INSERT INTO eeform4_product_master (product_code, product_name, product_category, sort_order) VALUES
('SUPP001', '活力發酵精萃', 'supplement', 1),
('SUPP002', '白鶴靈芝EX', 'supplement', 2),
('SUPP003', '美力C錠', 'supplement', 3),
('SUPP004', '鶴力晶', 'supplement', 4),
('TEA001', '白鶴靈芝茶', 'tea', 5),
('SOAP001', '淨白活膚蜜皂', 'skincare', 6),
('MASK001', '活顏泥膜', 'skincare', 7),
('TONER001', '化粧水', 'skincare', 8);
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

## 特別說明
此表單與 eeform2 結構相似，但產品類別著重於保健食品及健康產品，並增加了健康追蹤記錄表以便長期追蹤會員健康改善狀況。

---

## 完整SQL語句 (可直接複製貼上至資料庫)

```sql
-- eeform4 會員服務追蹤管理表(保健) 完整SQL

-- 1. 建立表單提交主表
CREATE TABLE eeform4_submissions (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員服務追蹤管理表(保健)主表';

-- 2. 建立產品訂購明細表
CREATE TABLE eeform4_products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    product_code VARCHAR(50) NOT NULL COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    quantity INT UNSIGNED NULL DEFAULT 0 COMMENT '數量',
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_product_code (product_code),
    UNIQUE KEY uk_submission_product (submission_id, product_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='產品訂購明細表';

-- 3. 建立產品主檔
CREATE TABLE eeform4_product_master (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_code VARCHAR(50) NOT NULL UNIQUE COMMENT '產品代碼',
    product_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    product_category ENUM('supplement', 'tea', 'skincare', 'other') DEFAULT 'supplement' COMMENT '產品類別',
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
CREATE TABLE eeform4_contact_history (
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
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_contact_type (contact_type),
    INDEX idx_contact_date (contact_date),
    INDEX idx_follow_up_date (follow_up_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聯絡歷史記錄表';

-- 5. 建立健康追蹤記錄表
CREATE TABLE eeform4_health_tracking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    submission_id INT NOT NULL COMMENT '表單提交ID',
    tracking_date DATE NOT NULL COMMENT '追蹤日期',
    health_status TEXT NULL COMMENT '健康狀態描述',
    improvement_notes TEXT NULL COMMENT '改善記錄',
    product_effectiveness TEXT NULL COMMENT '產品效果評估',
    next_recommendation TEXT NULL COMMENT '下次建議',
    created_by VARCHAR(100) NULL COMMENT '記錄者',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES eeform4_submissions(id) ON DELETE CASCADE,
    INDEX idx_submission_id (submission_id),
    INDEX idx_tracking_date (tracking_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='健康追蹤記錄表';

-- 6. 建立歷史歸檔表
CREATE TABLE eeform4_submissions_archive LIKE eeform4_submissions;

ALTER TABLE eeform4_submissions_archive 
ADD COLUMN archived_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '歸檔時間',
ADD COLUMN archived_by VARCHAR(100) NULL COMMENT '歸檔者',
ADD COLUMN archive_reason TEXT NULL COMMENT '歸檔原因';

-- 7. 插入預設產品資料
INSERT INTO eeform4_product_master (product_code, product_name, product_category, sort_order) VALUES
('SUPP001', '活力發酵精萃', 'supplement', 1),
('SUPP002', '白鶴靈芝EX', 'supplement', 2),
('SUPP003', '美力C錠', 'supplement', 3),
('SUPP004', '鶴力晶', 'supplement', 4),
('TEA001', '白鶴靈芝茶', 'tea', 5),
('SOAP001', '淨白活膚蜜皂', 'skincare', 6),
('MASK001', '活顏泥膜', 'skincare', 7),
('TONER001', '化粧水', 'skincare', 8);
```