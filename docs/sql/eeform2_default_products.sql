-- 插入 eform02 預設產品資料
-- 會員服務追蹤管理表(肌膚) 預設產品清單

INSERT INTO eeform2_product_master (product_code, product_name, product_category, description, sort_order, is_active, created_at, updated_at) VALUES
('SOAP001', '淨白活膚蜜皂', 'soap', '淨白活膚蜜皂產品', 1, 1, NOW(), NOW()),
('SOAP002', 'AP柔敏潔顏皂', 'soap', 'AP柔敏潔顏皂產品', 2, 1, NOW(), NOW()),
('MASK001', '活顏泥膜', 'mask', '活顏泥膜產品', 3, 1, NOW(), NOW()),
('TONER001', '安露莎化粧水I', 'toner', '安露莎化粧水I產品', 4, 1, NOW(), NOW()),
('TONER002', '安露莎化粧水II', 'toner', '安露莎化粧水II產品', 5, 1, NOW(), NOW()),
('TONER003', '安露莎活膚化粧水', 'toner', '安露莎活膚化粧水產品', 6, 1, NOW(), NOW()),
('TONER004', '柔敏化粧水', 'toner', '柔敏化粧水產品', 7, 1, NOW(), NOW()),
('SERUM001', '安露莎精華液I', 'serum', '安露莎精華液I產品', 8, 1, NOW(), NOW()),
('SERUM002', '安露莎精華液II', 'serum', '安露莎精華液II產品', 9, 1, NOW(), NOW()),
('SERUM003', '安露莎活膚精華液', 'serum', '安露莎活膚精華液產品', 10, 1, NOW(), NOW()),
('SERUM004', '美白精華液', 'serum', '美白精華液產品', 11, 1, NOW(), NOW()),
('LOTION001', '保濕潤膚液', 'lotion', '保濕潤膚液產品', 12, 1, NOW(), NOW()),
('OIL001', '美容防皺油', 'oil', '美容防皺油產品', 13, 1, NOW(), NOW()),
('GEL001', '保濕凝膠', 'gel', '保濕凝膠產品', 14, 1, NOW(), NOW()),
('ESSENCE001', '亮采晶萃', 'essence', '亮采晶萃產品', 15, 1, NOW(), NOW()),
('SUNSCREEN001', '防曬隔離液', 'sunscreen', '防曬隔離液產品', 16, 1, NOW(), NOW()),
('FOUNDATION001', '保濕粉底液', 'foundation', '保濕粉底液產品', 17, 1, NOW(), NOW()),
('POWDER001', '絲柔粉餅', 'powder', '絲柔粉餅產品', 18, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    product_name = VALUES(product_name),
    product_category = VALUES(product_category),
    description = VALUES(description),
    sort_order = VALUES(sort_order),
    is_active = VALUES(is_active),
    updated_at = NOW();

-- 確認插入結果
SELECT COUNT(*) as total_products FROM eeform2_product_master WHERE is_active = 1;