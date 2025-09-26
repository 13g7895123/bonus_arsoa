-- Add identity field to eeform2_submissions table
-- This field tracks whether the submission is for a member or guest

ALTER TABLE eeform2_submissions ADD COLUMN identity VARCHAR(10) NULL COMMENT '身份標識 (member/guest)' AFTER status;

-- Add index for better query performance
ALTER TABLE eeform2_submissions ADD INDEX idx_identity (identity);