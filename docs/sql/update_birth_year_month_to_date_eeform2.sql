-- Update birth_year_month field to support full date (YYYY-MM-DD) format in eeform2_submissions table
-- This script modifies the existing VARCHAR(7) field to VARCHAR(10) to accommodate the day component

-- Update the column to support YYYY-MM-DD format
ALTER TABLE eeform2_submissions
MODIFY COLUMN birth_year_month VARCHAR(10) NOT NULL COMMENT '出生年月日(YYYY-MM-DD)';

-- Verify the change
SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_COMMENT, COLUMN_DEFAULT, IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'eeform2_submissions'
  AND COLUMN_NAME = 'birth_year_month';

SELECT 'birth_year_month column updated to support YYYY-MM-DD format successfully!' as result;