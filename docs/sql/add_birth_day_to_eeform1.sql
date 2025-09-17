-- Add birth_day column to eeform1_submissions table
-- This script adds the birth_day field to support full date of birth

ALTER TABLE eeform1_submissions
ADD COLUMN birth_day TINYINT NOT NULL DEFAULT 1
COMMENT '出生日期'
AFTER birth_month;

-- Update the comment to reflect the change from birth year/month to birth year/month/day
ALTER TABLE eeform1_submissions
MODIFY COLUMN birth_year SMALLINT NOT NULL COMMENT '出生西元年',
MODIFY COLUMN birth_month TINYINT NOT NULL COMMENT '出生西元月',
MODIFY COLUMN birth_day TINYINT NOT NULL COMMENT '出生西元日';

SELECT 'birth_day column added to eeform1_submissions table successfully!' as result;