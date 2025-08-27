<?php
/**
 * Debug script to test skin_scores database operations
 * This script helps identify issues with the eeform1_skin_scores table
 */

// Basic CodeIgniter setup
define('BASEPATH', TRUE);
require_once('application/config/database.php');

// Database connection setup
$db_config = $db['default'];
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Skin Scores Debug Script ===\n";
echo "Database: " . $db_config['database'] . "\n\n";

// Check if eeform1_skin_scores table exists
$table_check = $mysqli->query("SHOW TABLES LIKE 'eeform1_skin_scores'");
echo "1. Table eeform1_skin_scores exists: " . ($table_check->num_rows > 0 ? 'YES' : 'NO') . "\n";

if ($table_check->num_rows > 0) {
    // Check table structure
    $structure = $mysqli->query("DESCRIBE eeform1_skin_scores");
    echo "2. Table structure:\n";
    while ($row = $structure->fetch_assoc()) {
        echo "   - {$row['Field']}: {$row['Type']} ({$row['Null']}, {$row['Key']})\n";
    }
    
    // Count total records
    $count_query = $mysqli->query("SELECT COUNT(*) as total FROM eeform1_skin_scores");
    $count_result = $count_query->fetch_assoc();
    echo "3. Total records in table: " . $count_result['total'] . "\n";
    
    // Check for specific submission ID (change this to test with your data)
    $test_submission_id = 2;
    $records_query = $mysqli->query("SELECT * FROM eeform1_skin_scores WHERE submission_id = $test_submission_id");
    echo "4. Records for submission_id $test_submission_id: " . $records_query->num_rows . "\n";
    
    if ($records_query->num_rows > 0) {
        echo "   Sample records:\n";
        while ($row = $records_query->fetch_assoc()) {
            echo "   - ID: {$row['id']}, Category: {$row['category']}, Type: {$row['score_type']}, Value: {$row['score_value']}\n";
        }
    }
    
    // Check recent submissions
    echo "5. Recent submission IDs with skin_scores:\n";
    $recent_query = $mysqli->query("SELECT DISTINCT submission_id FROM eeform1_skin_scores ORDER BY submission_id DESC LIMIT 5");
    while ($row = $recent_query->fetch_assoc()) {
        echo "   - Submission ID: " . $row['submission_id'] . "\n";
    }
    
} else {
    // Check for old table
    $old_table_check = $mysqli->query("SHOW TABLES LIKE 'eeform1_moisture_scores'");
    echo "2. Old table eeform1_moisture_scores exists: " . ($old_table_check->num_rows > 0 ? 'YES' : 'NO') . "\n";
    
    if ($old_table_check->num_rows > 0) {
        $count_query = $mysqli->query("SELECT COUNT(*) as total FROM eeform1_moisture_scores");
        $count_result = $count_query->fetch_assoc();
        echo "3. Records in old table: " . $count_result['total'] . "\n";
    }
}

// Check eeform1_submissions table
echo "\n6. Checking main submissions table:\n";
$submissions_query = $mysqli->query("SELECT id, member_name, created_at FROM eeform1_submissions ORDER BY id DESC LIMIT 5");
if ($submissions_query) {
    echo "   Recent submissions:\n";
    while ($row = $submissions_query->fetch_assoc()) {
        echo "   - ID: {$row['id']}, Name: {$row['member_name']}, Created: {$row['created_at']}\n";
    }
} else {
    echo "   Error querying submissions table: " . $mysqli->error . "\n";
}

$mysqli->close();
echo "\n=== Debug Complete ===\n";
?>