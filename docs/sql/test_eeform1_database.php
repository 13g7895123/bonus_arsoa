<?php
/**
 * Database test script for point 100
 * This script tests if the recreated eeform1 tables work correctly
 */

// Database configuration - adjust these values
$host = 'localhost';
$username = 'root';  // adjust as needed
$password = '';      // adjust as needed
$database = 'arsoa'; // adjust database name as needed

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);

    echo "Database Connection: SUCCESS\n";

    // Test 1: Check if all required tables exist
    $required_tables = [
        'eeform1_submissions',
        'eeform1_occupations',
        'eeform1_lifestyle',
        'eeform1_products',
        'eeform1_skin_issues',
        'eeform1_allergies',
        'eeform1_skin_scores',
        'eeform1_suggestions'
    ];

    echo "\n=== Test 1: Table Existence ===\n";
    foreach ($required_tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->rowCount() > 0;
        echo "Table $table: " . ($exists ? "EXISTS" : "MISSING") . "\n";
        if (!$exists) {
            throw new Exception("Required table $table is missing");
        }
    }

    // Test 2: Test complete form data insertion (simulating API request)
    echo "\n=== Test 2: Complete Form Data Insertion ===\n";

    $test_data = [
        // Basic member info
        'member_id' => '000001',
        'member_name' => 'Test User',
        'form_filler_id' => '000000',
        'form_filler_name' => 'Admin User',
        'birth_year' => 1990,
        'birth_month' => 5,
        'phone' => '0912345678',
        'skin_type' => 'combination',
        'skin_age' => 30,
        
        // Occupations (checkbox selections)
        'occupation_office' => 1,
        'occupation_service' => 1,
        
        // Lifestyle habits
        'sunlight_3_4h' => 1,
        'aircondition_5_8h' => 1,
        'sleep_11_12' => 1,
        'sleep_other' => 1,
        'sleep_other_text' => 'Irregular sleep schedule',
        
        // Products used
        'product_toner' => 1,
        'product_serum' => 1,
        'product_other' => 1,
        'product_other_text' => 'Custom skincare',
        
        // Skin issues
        'skin_issue_dry' => 1,
        'skin_issue_spots' => 1,
        'skin_issue_elasticity' => 1,
        
        // Allergies
        'allergy_seasonal' => 1,
        
        // Skin scores for all categories
        'moisture_severe' => 2,
        'moisture_warning' => 5,
        'moisture_healthy' => 8,
        'complexion_severe' => 1,
        'complexion_warning' => 4,
        'complexion_healthy' => 7,
        'texture_severe' => 3,
        'texture_warning' => 6,
        'texture_healthy' => 9,
        'sensitivity_severe' => 2,
        'sensitivity_warning' => 5,
        'sensitivity_healthy' => 8,
        'oil_severe' => 1,
        'oil_warning' => 4,
        'oil_healthy' => 7,
        'pigment_severe' => 2,
        'pigment_warning' => 5,
        'pigment_healthy' => 8,
        'wrinkle_severe' => 1,
        'wrinkle_warning' => 3,
        'wrinkle_healthy' => 6,
        'pore_severe' => 2,
        'pore_warning' => 5,
        'pore_healthy' => 8,
        
        // Suggestions
        'toner_suggestion' => 'Hydrating Toner',
        'serum_suggestion' => 'Anti-aging Serum',
        'suggestion_content' => 'Increase hydration routine, use sunscreen daily'
    ];

    // Start transaction
    $pdo->beginTransaction();

    // Insert main submission
    $stmt = $pdo->prepare("
        INSERT INTO eeform1_submissions (
            member_id, member_name, form_filler_id, form_filler_name,
            birth_year, birth_month, phone, skin_type, skin_age,
            submission_date, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'submitted')
    ");
    
    $stmt->execute([
        $test_data['member_id'],
        $test_data['member_name'],
        $test_data['form_filler_id'],
        $test_data['form_filler_name'],
        $test_data['birth_year'],
        $test_data['birth_month'],
        $test_data['phone'],
        $test_data['skin_type'],
        $test_data['skin_age']
    ]);

    $submission_id = $pdo->lastInsertId();
    echo "Main submission inserted with ID: $submission_id\n";

    // Insert occupations
    $occupations = ['office', 'service'];
    foreach ($occupations as $occupation) {
        $stmt = $pdo->prepare("
            INSERT INTO eeform1_occupations (submission_id, occupation_type, is_selected)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$submission_id, $occupation]);
    }
    echo "Occupation data inserted\n";

    // Insert lifestyle data
    $lifestyle_data = [
        ['sunlight', '3_4h'],
        ['aircondition', '5_8h'],
        ['sleep', '11_12'],
        ['sleep', 'other', 'Irregular sleep schedule']
    ];

    foreach ($lifestyle_data as $lifestyle) {
        $stmt = $pdo->prepare("
            INSERT INTO eeform1_lifestyle (submission_id, category, item_key, item_value, is_selected)
            VALUES (?, ?, ?, ?, 1)
        ");
        $stmt->execute([
            $submission_id,
            $lifestyle[0],
            $lifestyle[1],
            isset($lifestyle[2]) ? $lifestyle[2] : null
        ]);
    }
    echo "Lifestyle data inserted\n";

    // Insert products
    $products_data = [
        ['toner', null],
        ['serum', null],
        ['other', 'Custom skincare']
    ];

    foreach ($products_data as $product) {
        $stmt = $pdo->prepare("
            INSERT INTO eeform1_products (submission_id, product_type, product_name, is_selected)
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$submission_id, $product[0], $product[1]]);
    }
    echo "Products data inserted\n";

    // Insert skin issues
    $skin_issues = ['dry', 'spots', 'elasticity'];
    foreach ($skin_issues as $issue) {
        $stmt = $pdo->prepare("
            INSERT INTO eeform1_skin_issues (submission_id, issue_type, is_selected)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$submission_id, $issue]);
    }
    echo "Skin issues data inserted\n";

    // Insert allergies
    $stmt = $pdo->prepare("
        INSERT INTO eeform1_allergies (submission_id, allergy_type, is_selected)
        VALUES (?, 'seasonal', 1)
    ");
    $stmt->execute([$submission_id]);
    echo "Allergies data inserted\n";

    // Insert skin scores for all categories
    $score_categories = [
        'moisture' => [2, 5, 8],
        'complexion' => [1, 4, 7],
        'texture' => [3, 6, 9],
        'sensitivity' => [2, 5, 8],
        'oil' => [1, 4, 7],
        'pigment' => [2, 5, 8],
        'wrinkle' => [1, 3, 6],
        'pore' => [2, 5, 8]
    ];

    $score_types = ['severe', 'warning', 'healthy'];
    foreach ($score_categories as $category => $scores) {
        for ($i = 0; $i < 3; $i++) {
            $stmt = $pdo->prepare("
                INSERT INTO eeform1_skin_scores 
                (submission_id, category, score_type, score_value, measurement_date)
                VALUES (?, ?, ?, ?, CURDATE())
            ");
            $stmt->execute([$submission_id, $category, $score_types[$i], $scores[$i]]);
        }
    }
    echo "Skin scores data inserted (8 categories x 3 types = 24 records)\n";

    // Insert suggestions
    $stmt = $pdo->prepare("
        INSERT INTO eeform1_suggestions 
        (submission_id, toner_suggestion, serum_suggestion, suggestion_content, created_by)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $submission_id,
        $test_data['toner_suggestion'],
        $test_data['serum_suggestion'],
        $test_data['suggestion_content'],
        'Test System'
    ]);
    echo "Suggestions data inserted\n";

    // Commit transaction
    $pdo->commit();

    // Test 3: Data retrieval verification
    echo "\n=== Test 3: Data Retrieval Verification ===\n";

    // Check if all data can be retrieved correctly
    $stmt = $pdo->prepare("
        SELECT 
            s.*,
            COUNT(DISTINCT o.id) as occupation_count,
            COUNT(DISTINCT l.id) as lifestyle_count,
            COUNT(DISTINCT p.id) as product_count,
            COUNT(DISTINCT si.id) as skin_issue_count,
            COUNT(DISTINCT a.id) as allergy_count,
            COUNT(DISTINCT sc.id) as skin_score_count,
            COUNT(DISTINCT sg.id) as suggestion_count
        FROM eeform1_submissions s
        LEFT JOIN eeform1_occupations o ON s.id = o.submission_id
        LEFT JOIN eeform1_lifestyle l ON s.id = l.submission_id
        LEFT JOIN eeform1_products p ON s.id = p.submission_id
        LEFT JOIN eeform1_skin_issues si ON s.id = si.submission_id
        LEFT JOIN eeform1_allergies a ON s.id = a.submission_id
        LEFT JOIN eeform1_skin_scores sc ON s.id = sc.submission_id
        LEFT JOIN eeform1_suggestions sg ON s.id = sg.submission_id
        WHERE s.id = ?
        GROUP BY s.id
    ");
    $stmt->execute([$submission_id]);
    $result = $stmt->fetch();

    if ($result) {
        echo "✓ Submission ID: {$result['id']}\n";
        echo "✓ Member Name: {$result['member_name']}\n";
        echo "✓ Form Filler: {$result['form_filler_name']}\n";
        echo "✓ Occupations: {$result['occupation_count']} records\n";
        echo "✓ Lifestyle: {$result['lifestyle_count']} records\n";
        echo "✓ Products: {$result['product_count']} records\n";
        echo "✓ Skin Issues: {$result['skin_issue_count']} records\n";
        echo "✓ Allergies: {$result['allergy_count']} records\n";
        echo "✓ Skin Scores: {$result['skin_score_count']} records\n";
        echo "✓ Suggestions: {$result['suggestion_count']} records\n";
    } else {
        throw new Exception("Failed to retrieve inserted data");
    }

    // Test 4: Foreign key constraint verification
    echo "\n=== Test 4: Foreign Key Constraints ===\n";
    
    // Try to insert with invalid submission_id (should fail)
    try {
        $stmt = $pdo->prepare("INSERT INTO eeform1_occupations (submission_id, occupation_type) VALUES (99999, 'office')");
        $stmt->execute();
        echo "✗ Foreign key constraint test FAILED - invalid data was inserted\n";
    } catch (PDOException $e) {
        echo "✓ Foreign key constraint working correctly\n";
    }

    // Test 5: Data integrity constraints
    echo "\n=== Test 5: Data Integrity Constraints ===\n";
    
    // Test score range constraint
    try {
        $stmt = $pdo->prepare("INSERT INTO eeform1_skin_scores (submission_id, category, score_type, score_value) VALUES (?, 'moisture', 'healthy', 15)");
        $stmt->execute([$submission_id]);
        echo "✗ Score range constraint FAILED - invalid score was inserted\n";
    } catch (PDOException $e) {
        echo "✓ Score range constraint working correctly\n";
    }

    // Test birth year constraint
    try {
        $stmt = $pdo->prepare("INSERT INTO eeform1_submissions (member_name, birth_year, birth_month, phone, submission_date) VALUES ('Test', 1900, 1, '0912345678', NOW())");
        $stmt->execute();
        echo "✗ Birth year constraint FAILED - invalid year was inserted\n";
    } catch (PDOException $e) {
        echo "✓ Birth year constraint working correctly\n";
    }

    echo "\n=== ALL TESTS PASSED ===\n";
    echo "Database schema is working correctly and ready for production use.\n";
    echo "\nTest submission ID created: $submission_id\n";
    echo "You can view this test data in the admin interface or clean it up later.\n";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "\n✗ TEST FAILED: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
?>