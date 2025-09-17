-- 為 eeform4_submissions 表添加出生年月欄位
-- 執行日期: 2025年9月13日

-- 添加出生年月日欄位 (必填，日期格式 YYYY-MM-DD)
ALTER TABLE `eeform4_submissions`
ADD COLUMN `birth_year_month` VARCHAR(10) NOT NULL DEFAULT ''
AFTER `gender`;

-- 為欄位添加註釋
ALTER TABLE `eeform4_submissions`
MODIFY COLUMN `birth_year_month` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '出生年月日(格式: YYYY-MM-DD)';