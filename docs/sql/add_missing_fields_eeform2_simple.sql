-- Simple script to add missing fields to eeform2_submissions table
-- Run this if the complex script doesn't work

-- Add member_id field
ALTER TABLE eeform2_submissions ADD COLUMN member_id VARCHAR(50) NULL COMMENT '會員編號' AFTER id;

-- Add form filler fields
ALTER TABLE eeform2_submissions ADD COLUMN form_filler_id VARCHAR(50) NULL COMMENT '代填問卷者ID' AFTER member_name;
ALTER TABLE eeform2_submissions ADD COLUMN form_filler_name VARCHAR(100) NULL COMMENT '代填問卷者姓名' AFTER form_filler_id;

-- Add birth_year_month field (if it doesn't exist)
ALTER TABLE eeform2_submissions ADD COLUMN birth_year_month DATE NULL COMMENT '出生年月日' AFTER age;

-- Add indexes
ALTER TABLE eeform2_submissions ADD INDEX idx_member_id (member_id);
ALTER TABLE eeform2_submissions ADD INDEX idx_form_filler_id (form_filler_id);
ALTER TABLE eeform2_submissions ADD INDEX idx_birth_year_month (birth_year_month);