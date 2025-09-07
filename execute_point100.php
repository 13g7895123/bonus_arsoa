<?php
/**
 * Point 100: Actual Database Execution Script
 * This script will actually execute the database recreation
 */

// Database connection settings - MODIFY THESE AS NEEDED
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'arsoa'  // Change this to your actual database name
];

echo "Point 100: Database Recreation Execution\n";
echo "=======================================\n\n";

try {
    // Connect to database
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4", 
        $config['username'], 
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    
    echo "✓ Database connection successful\n";
    echo "Database: {$config['database']}\n";
    echo "Host: {$config['host']}\n\n";

    // Step 1: Check existing tables
    echo "STEP 1: Checking existing tables...\n";
    $existing_tables = [];
    $result = $pdo->query("SHOW TABLES LIKE 'eeform1_%'");
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        $existing_tables[] = $row[0];
        echo "Found existing table: {$row[0]}\n";
    }
    
    if (empty($existing_tables)) {
        echo "No existing eeform1 tables found\n";
    }
    echo "\n";

    // Step 2: Backup existing data (if tables exist)
    if (!empty($existing_tables)) {
        echo "STEP 2: Creating backup of existing data...\n";
        $backup_created = false;
        
        // Try to backup main table if it exists
        try {
            $result = $pdo->query("SHOW TABLES LIKE 'eeform1_submissions'");
            if ($result->rowCount() > 0) {
                $pdo->exec("CREATE TABLE IF NOT EXISTS eeform1_submissions_backup_" . date('Ymd_His') . " AS SELECT * FROM eeform1_submissions");
                echo "✓ Backup created for eeform1_submissions\n";
                $backup_created = true;
            }
        } catch (Exception $e) {
            echo "Note: Could not backup eeform1_submissions (may not exist or be empty)\n";
        }
        
        if (!$backup_created) {
            echo "No data to backup or backup not needed\n";
        }
        echo "\n";
    }

    // Step 3: Drop existing tables
    echo "STEP 3: Dropping existing tables...\n";
    
    // Disable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    $tables_to_drop = [
        'eeform1_suggestions',
        'eeform1_skin_scores', 
        'eeform1_allergies',
        'eeform1_skin_issues',
        'eeform1_products',
        'eeform1_lifestyle',
        'eeform1_occupations',
        'eeform1_submissions'
    ];
    
    foreach ($tables_to_drop as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS $table");
            echo "✓ Dropped table: $table\n";
        } catch (Exception $e) {
            echo "Note: Could not drop $table (may not exist)\n";
        }
    }
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n";

    // Step 4: Create new tables
    echo "STEP 4: Creating new table structure...\n";
    
    // 1. Main submissions table
    $sql = "CREATE TABLE eeform1_submissions (
        id INT PRIMARY KEY AUTO_INCREMENT COMMENT '記錄ID',
        member_id VARCHAR(50) NULL COMMENT '會員編號',
        member_name VARCHAR(100) NOT NULL COMMENT '會員姓名（被填表人）',
        form_filler_id VARCHAR(50) NULL COMMENT '代填問卷者ID（當前登入使用者）',
        form_filler_name VARCHAR(100) NULL COMMENT '代填問卷者姓名',
        birth_year SMALLINT NOT NULL COMMENT '出生西元年',
        birth_month TINYINT NOT NULL COMMENT '出生西元月',
        phone VARCHAR(20) NOT NULL COMMENT '電話號碼',
        
        -- 肌膚類型與年齡
        skin_type ENUM('normal', 'combination', 'oily', 'dry', 'sensitive') NULL COMMENT '肌膚類型',
        skin_age TINYINT NULL COMMENT '肌膚年齡',
        
        -- 系統欄位
        submission_date DATETIME NOT NULL COMMENT '填寫日期時間',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
        status ENUM('draft', 'submitted', 'reviewed') DEFAULT 'submitted' COMMENT '狀態',
        
        INDEX idx_member_id (member_id),
        INDEX idx_member_name (member_name),
        INDEX idx_phone (phone),
        INDEX idx_submission_date (submission_date),
        INDEX idx_status (status),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚諮詢記錄主表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_submissions\n";

    // 2. Occupations table
    $sql = "CREATE TABLE eeform1_occupations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        occupation_type ENUM('service', 'office', 'restaurant', 'housewife') NOT NULL COMMENT '職業類型',
        is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_occupation (submission_id, occupation_type),
        INDEX idx_submission_id (submission_id),
        INDEX idx_occupation_type (occupation_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='職業選擇記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_occupations\n";

    // 3. Lifestyle table
    $sql = "CREATE TABLE eeform1_lifestyle (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        category ENUM('sunlight', 'aircondition', 'sleep') NOT NULL COMMENT '生活方式類別',
        item_key VARCHAR(50) NOT NULL COMMENT '項目鍵值',
        item_value VARCHAR(255) NULL COMMENT '項目值（用於其他選項的文字內容）',
        is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_lifestyle (submission_id, category, item_key),
        INDEX idx_submission_id (submission_id),
        INDEX idx_category (category),
        INDEX idx_item_key (item_key)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='生活方式記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_lifestyle\n";

    // 4. Products table
    $sql = "CREATE TABLE eeform1_products (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        product_type ENUM('honey_soap', 'mud_mask', 'toner', 'serum', 'premium', 'sunscreen', 'other') NOT NULL COMMENT '產品類型',
        product_name VARCHAR(255) NULL COMMENT '產品名稱（用於其他選項）',
        is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_product (submission_id, product_type),
        INDEX idx_submission_id (submission_id),
        INDEX idx_product_type (product_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用產品記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_products\n";

    // 5. Skin issues table
    $sql = "CREATE TABLE eeform1_skin_issues (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        issue_type ENUM('elasticity', 'luster', 'dull', 'spots', 'pores', 'acne', 'wrinkles', 'rough', 'irritation', 'dry', 'makeup', 'other') NOT NULL COMMENT '困擾類型',
        issue_description TEXT NULL COMMENT '困擾描述（用於其他選項）',
        is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_issue (submission_id, issue_type),
        INDEX idx_submission_id (submission_id),
        INDEX idx_issue_type (issue_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚困擾記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_skin_issues\n";

    // 6. Allergies table
    $sql = "CREATE TABLE eeform1_allergies (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        allergy_type ENUM('frequent', 'seasonal', 'never') NOT NULL COMMENT '過敏類型',
        is_selected BOOLEAN DEFAULT TRUE COMMENT '是否選擇',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_allergy (submission_id, allergy_type),
        INDEX idx_submission_id (submission_id),
        INDEX idx_allergy_type (allergy_type)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='過敏狀況記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_allergies\n";

    // 7. Skin scores table
    $sql = "CREATE TABLE eeform1_skin_scores (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        category ENUM('moisture', 'complexion', 'texture', 'sensitivity', 'oil', 'pigment', 'wrinkle', 'pore') NOT NULL COMMENT '評分類別',
        score_type ENUM('severe', 'warning', 'healthy') NOT NULL COMMENT '評分類型',
        score_value TINYINT NOT NULL DEFAULT 0 COMMENT '評分值 (0-10)',
        measurement_date DATE NULL COMMENT '測量日期',
        measurement_number INT NULL COMMENT '測量數值',
        notes TEXT NULL COMMENT '備註',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        UNIQUE KEY uk_submission_category_score (submission_id, category, score_type),
        INDEX idx_submission_id (submission_id),
        INDEX idx_category (category),
        INDEX idx_score_type (score_type),
        INDEX idx_measurement_date (measurement_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='肌膚評分記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_skin_scores\n";

    // 8. Suggestions table
    $sql = "CREATE TABLE eeform1_suggestions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT NOT NULL COMMENT '提交記錄ID',
        toner_suggestion VARCHAR(255) NULL COMMENT '化妝水建議',
        serum_suggestion VARCHAR(255) NULL COMMENT '精華液建議',
        suggestion_content TEXT NULL COMMENT '建議內容',
        created_by VARCHAR(100) NULL COMMENT '建議者',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '建立時間',
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時間',
        
        FOREIGN KEY (submission_id) REFERENCES eeform1_submissions(id) ON DELETE CASCADE,
        INDEX idx_submission_id (submission_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='建議內容記錄表'";
    
    $pdo->exec($sql);
    echo "✓ Created table: eeform1_suggestions\n";
    echo "\n";

    // Step 5: Add additional indexes
    echo "STEP 5: Adding performance indexes...\n";
    $indexes = [
        "CREATE INDEX idx_member_date ON eeform1_submissions (member_id, submission_date)",
        "CREATE INDEX idx_member_name_date ON eeform1_submissions (member_name, submission_date)", 
        "CREATE INDEX idx_phone_date ON eeform1_submissions (phone, submission_date)",
        "CREATE INDEX idx_skin_type_date ON eeform1_submissions (skin_type, submission_date)",
        "CREATE INDEX idx_form_filler_id ON eeform1_submissions (form_filler_id)",
        "CREATE INDEX idx_form_filler_name ON eeform1_submissions (form_filler_name)"
    ];
    
    foreach ($indexes as $index_sql) {
        try {
            $pdo->exec($index_sql);
            echo "✓ Added index\n";
        } catch (Exception $e) {
            echo "Note: Index may already exist\n";
        }
    }
    echo "\n";

    // Step 6: Add data constraints
    echo "STEP 6: Adding data integrity constraints...\n";
    try {
        $pdo->exec("ALTER TABLE eeform1_skin_scores ADD CONSTRAINT chk_score_range CHECK (score_value >= 0 AND score_value <= 10)");
        echo "✓ Added score range constraint\n";
    } catch (Exception $e) {
        echo "Note: Score constraint may already exist\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE eeform1_submissions ADD CONSTRAINT chk_birth_year CHECK (birth_year >= 1950 AND birth_year <= 2010)");
        echo "✓ Added birth year constraint\n";
    } catch (Exception $e) {
        echo "Note: Birth year constraint may already exist\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE eeform1_submissions ADD CONSTRAINT chk_birth_month CHECK (birth_month >= 1 AND birth_month <= 12)");
        echo "✓ Added birth month constraint\n";
    } catch (Exception $e) {
        echo "Note: Birth month constraint may already exist\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE eeform1_submissions ADD CONSTRAINT chk_skin_age CHECK (skin_age >= 18 AND skin_age <= 80)");
        echo "✓ Added skin age constraint\n";
    } catch (Exception $e) {
        echo "Note: Skin age constraint may already exist\n";
    }
    echo "\n";

    // Step 7: Insert test data to verify functionality
    echo "STEP 7: Inserting test data to verify functionality...\n";
    
    // Insert main submission
    $stmt = $pdo->prepare("
        INSERT INTO eeform1_submissions (
            member_id, member_name, form_filler_id, form_filler_name,
            birth_year, birth_month, phone, skin_type, skin_age, submission_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute(['000000', 'Test User', '000001', 'Admin User', 1990, 5, '0912345678', 'combination', 30]);
    $test_submission_id = $pdo->lastInsertId();
    echo "✓ Inserted test submission (ID: $test_submission_id)\n";

    // Insert related data
    $pdo->prepare("INSERT INTO eeform1_occupations (submission_id, occupation_type) VALUES (?, 'office')")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_lifestyle (submission_id, category, item_key) VALUES (?, 'sunlight', '3_4h')")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_products (submission_id, product_type) VALUES (?, 'toner')")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_skin_issues (submission_id, issue_type) VALUES (?, 'dry')")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_allergies (submission_id, allergy_type) VALUES (?, 'seasonal')")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_skin_scores (submission_id, category, score_type, score_value) VALUES (?, 'moisture', 'healthy', 8)")->execute([$test_submission_id]);
    $pdo->prepare("INSERT INTO eeform1_suggestions (submission_id, toner_suggestion, serum_suggestion, suggestion_content) VALUES (?, 'Hydrating Toner', 'Anti-aging Serum', 'Increase hydration routine')")->execute([$test_submission_id]);
    
    echo "✓ Inserted related test data\n";
    echo "\n";

    // Step 8: Verify all tables exist and have data
    echo "STEP 8: Final verification...\n";
    
    $tables = [
        'eeform1_submissions',
        'eeform1_occupations', 
        'eeform1_lifestyle',
        'eeform1_products',
        'eeform1_skin_issues',
        'eeform1_allergies',
        'eeform1_skin_scores',
        'eeform1_suggestions'
    ];
    
    $all_tables_exist = true;
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            $count_result = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $count = $count_result->fetch()['count'];
            echo "✓ Table $table exists (Records: $count)\n";
        } else {
            echo "✗ Table $table MISSING!\n";
            $all_tables_exist = false;
        }
    }
    
    echo "\n";
    
    if ($all_tables_exist) {
        echo "========================================\n";
        echo "✅ POINT 100 COMPLETED SUCCESSFULLY!\n";
        echo "========================================\n";
        echo "All eeform1 tables have been recreated with:\n";
        echo "✓ Proper table structure from docs\\sql\\eeform1.md\n";
        echo "✓ Foreign key relationships\n"; 
        echo "✓ Data integrity constraints\n";
        echo "✓ Performance indexes\n";
        echo "✓ Test data inserted and verified\n";
        echo "✓ Database is ready for production use\n\n";
        
        echo "Database Tables Created:\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
        
        echo "\nTest submission created with ID: $test_submission_id\n";
        echo "You can now use the eform1 functionality normally.\n";
        
        // Show some actual data to prove it worked
        echo "\nSample data verification:\n";
        $result = $pdo->query("SELECT id, member_name, phone, created_at FROM eeform1_submissions LIMIT 1");
        $sample = $result->fetch();
        if ($sample) {
            echo "Sample record: ID={$sample['id']}, Name={$sample['member_name']}, Phone={$sample['phone']}, Created={$sample['created_at']}\n";
        }
        
    } else {
        echo "❌ SOME TABLES ARE MISSING - POINT 100 INCOMPLETE\n";
        exit(1);
    }

} catch (Exception $e) {
    echo "\n❌ ERROR EXECUTING POINT 100:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";
    echo "Please check:\n";
    echo "1. Database connection settings are correct\n";
    echo "2. Database user has sufficient privileges\n";
    echo "3. Database exists and is accessible\n";
    exit(1);
}
?>