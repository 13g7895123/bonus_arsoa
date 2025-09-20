-- Add missing fields to eeform2_submissions table
-- This script adds member_id, form_filler_id, form_filler_name, and birth_year_month fields if they don't exist

-- Add member_id field (會員編號)
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND COLUMN_NAME = 'member_id') = 0,
        'ALTER TABLE eeform2_submissions ADD COLUMN member_id VARCHAR(50) NULL COMMENT ''會員編號'' AFTER id',
        'SELECT ''Column member_id already exists'' AS message'
    )
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add form_filler_id field (代填問卷者ID)
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND COLUMN_NAME = 'form_filler_id') = 0,
        'ALTER TABLE eeform2_submissions ADD COLUMN form_filler_id VARCHAR(50) NULL COMMENT ''代填問卷者ID'' AFTER member_name',
        'SELECT ''Column form_filler_id already exists'' AS message'
    )
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add form_filler_name field (代填問卷者姓名)
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND COLUMN_NAME = 'form_filler_name') = 0,
        'ALTER TABLE eeform2_submissions ADD COLUMN form_filler_name VARCHAR(100) NULL COMMENT ''代填問卷者姓名'' AFTER form_filler_id',
        'SELECT ''Column form_filler_name already exists'' AS message'
    )
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add birth_year_month field (出生年月日)
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND COLUMN_NAME = 'birth_year_month') = 0,
        'ALTER TABLE eeform2_submissions ADD COLUMN birth_year_month DATE NULL COMMENT ''出生年月日'' AFTER age',
        'SELECT ''Column birth_year_month already exists'' AS message'
    )
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add indexes for better query performance
SET @index_sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND INDEX_NAME = 'idx_member_id') = 0,
        'ALTER TABLE eeform2_submissions ADD INDEX idx_member_id (member_id)',
        'SELECT ''Index idx_member_id already exists'' AS message'
    )
);
PREPARE index_stmt FROM @index_sql;
EXECUTE index_stmt;
DEALLOCATE PREPARE index_stmt;

SET @index_sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND INDEX_NAME = 'idx_form_filler_id') = 0,
        'ALTER TABLE eeform2_submissions ADD INDEX idx_form_filler_id (form_filler_id)',
        'SELECT ''Index idx_form_filler_id already exists'' AS message'
    )
);
PREPARE index_stmt FROM @index_sql;
EXECUTE index_stmt;
DEALLOCATE PREPARE index_stmt;

SET @index_sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND INDEX_NAME = 'idx_birth_year_month') = 0,
        'ALTER TABLE eeform2_submissions ADD INDEX idx_birth_year_month (birth_year_month)',
        'SELECT ''Index idx_birth_year_month already exists'' AS message'
    )
);
PREPARE index_stmt FROM @index_sql;
EXECUTE index_stmt;
DEALLOCATE PREPARE index_stmt;

-- Display final structure to confirm the changes
SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_DEFAULT, IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'eeform2_submissions'
ORDER BY ORDINAL_POSITION;