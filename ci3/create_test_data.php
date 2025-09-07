#!/usr/bin/env php
<?php
/**
 * Create test data for EForm testing
 */

// Check if we're in CI3 directory
if (!file_exists('application/config/config.php')) {
    echo "❌ Error: Must run this script from CI3 root directory\n";
    exit(1);
}

echo "🧪 Creating Test Data for CI3 EForms\n";
echo "====================================\n\n";

// Load basic CI bootstrap for database access
define('BASEPATH', TRUE);
chdir(__DIR__);

// Basic configuration
$config['base_url'] = 'http://localhost:9126/';
$config['index_page'] = 'index.php';

// Database configuration - update these if needed
$db_config = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ci3_test',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci'
);

try {
    // Test data for different forms
    $test_data = [
        'eform1' => [
            [
                'member_id' => 'TEST001',
                'member_name' => '測試用戶一',
                'birth_date' => '1990-01',
                'height' => '170',
                'age' => '33',
                'skin_scores' => json_encode([
                    '乾燥度' => '7',
                    '敏感度' => '5',
                    '油脂分泌' => '6',
                    '毛孔粗大' => '4'
                ]),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'member_id' => 'TEST002',
                'member_name' => '測試用戶二',
                'birth_date' => '1985-03',
                'height' => '165',
                'age' => '38',
                'skin_scores' => json_encode([
                    '乾燥度' => '8',
                    '敏感度' => '7',
                    '油脂分泌' => '3',
                    '毛孔粗大' => '6'
                ]),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ],
        'eform2' => [
            [
                'member_id' => 'TEST001',
                'member_name' => '測試用戶一',
                'join_date' => '2023-01-15',
                'gender' => '女',
                'age' => '33',
                'skin_health_condition' => '混合性肌膚，T字部位較油',
                'products' => json_encode(['保濕乳液', '溫和洗面乳', '防曬霜']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'member_id' => 'TEST003',
                'member_name' => '測試用戶三',
                'join_date' => '2023-02-20',
                'gender' => '男',
                'age' => '28',
                'skin_health_condition' => '乾燥肌膚，容易脫皮',
                'products' => json_encode(['深層保濕霜', '修護精華', '溫和去角質']),
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ]
        ],
        'eform4' => [
            [
                'member_id' => 'TEST002',
                'member_name' => '測試用戶二',
                'join_date' => '2023-01-10',
                'gender' => '女',
                'age' => '38',
                'skin_health_condition' => '敏感肌膚',
                'health_concerns' => '睡眠不足,壓力大,營養不均衡',
                'products' => json_encode(['維生素C', '膠原蛋白', '益生菌', '魚油']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'member_id' => 'TEST004',
                'member_name' => '測試用戶四',
                'join_date' => '2023-03-01',
                'gender' => '男',
                'age' => '45',
                'skin_health_condition' => '正常肌膚',
                'health_concerns' => '關節疼痛,消化不良',
                'products' => json_encode(['葡萄糖胺', '消化酵素', '綜合維他命']),
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
            ]
        ]
    ];
    
    echo "✅ Test data prepared\n";
    echo "📋 Data Summary:\n";
    foreach ($test_data as $form => $records) {
        echo "   $form: " . count($records) . " records\n";
    }
    
    // Show SQL statements that would be executed
    echo "\n📝 SQL Statements to Execute:\n";
    echo "=====================================\n";
    
    foreach ($test_data as $table => $records) {
        echo "\n-- $table table data\n";
        foreach ($records as $record) {
            $columns = implode(', ', array_keys($record));
            $values = "'" . implode("', '", array_values($record)) . "'";
            echo "INSERT INTO $table ($columns) VALUES ($values);\n";
        }
    }
    
    echo "\n🎯 Manual Steps:\n";
    echo "1. Ensure your database is running\n";
    echo "2. Run the migrations: php index.php migrate\n";
    echo "3. Execute the SQL statements above in your database\n";
    echo "4. Test the frontend forms to ensure they can submit\n";
    echo "5. Check the admin backend to see the data\n\n";
    
    echo "🌐 Test URLs:\n";
    echo "Frontend Forms:\n";
    echo "   http://localhost:9126/index.php/eform/eform1\n";
    echo "   http://localhost:9126/index.php/eform/eform2\n";
    echo "   http://localhost:9126/index.php/eform/eform4\n\n";
    echo "Admin Backend:\n";
    echo "   http://localhost:9126/index.php/admin/form1\n";
    echo "   http://localhost:9126/index.php/admin/form2\n";
    echo "   http://localhost:9126/index.php/admin/form4\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}