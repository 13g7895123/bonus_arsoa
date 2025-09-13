-- Add birth_year_month field to existing eeform2_submissions table
-- This script is for updating existing databases that already have the eeform2_submissions table

-- Check if birth_year_month column already exists before adding it
SET @sql = (
    SELECT IF(
        (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = 'eeform2_submissions'
         AND COLUMN_NAME = 'birth_year_month') = 0,
        'ALTER TABLE eeform2_submissions ADD COLUMN birth_year_month VARCHAR(7) NOT NULL COMMENT ''出生年月(YYYY-MM)'' AFTER age',
        'SELECT ''Column birth_year_month already exists'' AS message'
    )
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add index for birth_year_month column (only if column was just added)
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

-- Display final structure to confirm the change
SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT, COLUMN_DEFAULT, IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'eeform2_submissions'
ORDER BY ORDINAL_POSITION;