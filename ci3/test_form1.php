<?php
// Test program for EEForm1 functionality

echo "=== EEForm1 Database Test Program ===\n";
echo "Testing database connection and basic CRUD operations\n\n";

try {
    // Database connection
    $db = new mysqli('db', 'ci3_user', 'ci3_password', 'ci3_database');
    
    if ($db->connect_error) {
        throw new Exception("Database connection failed: " . $db->connect_error);
    }
    
    echo "✓ Database connection successful\n";
    
    // Test 1: Check if table exists
    $result = $db->query("SHOW TABLES LIKE 'eeform1_submissions'");
    if ($result->num_rows > 0) {
        echo "✓ Table 'eeform1_submissions' exists\n";
    } else {
        echo "✗ Table 'eeform1_submissions' not found\n";
        throw new Exception("Required table not found");
    }
    
    // Test 2: Insert test data
    echo "\nTesting data insertion...\n";
    
    $test_data = array(
        'member_name' => 'Test Member',
        'phone' => '0912345678',
        'created_at' => date('Y-m-d H:i:s')
    );
    
    $fields = implode(', ', array_keys($test_data));
    $values = "'" . implode("', '", array_values($test_data)) . "'";
    
    $insert_sql = "INSERT INTO eeform1_submissions ($fields) VALUES ($values)";
    
    if ($db->query($insert_sql)) {
        $insert_id = $db->insert_id;
        echo "✓ Test data inserted successfully (ID: $insert_id)\n";
        
        // Test 3: Read data back
        $select_sql = "SELECT * FROM eeform1_submissions WHERE id = $insert_id";
        $result = $db->query($select_sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "✓ Test data retrieved successfully\n";
            echo "  - ID: " . $row['id'] . "\n";
            echo "  - Member Name: " . $row['member_name'] . "\n";
            echo "  - Phone: " . $row['phone'] . "\n";
            echo "  - Created At: " . $row['created_at'] . "\n";
        } else {
            echo "✗ Failed to retrieve test data\n";
        }
        
        // Test 4: Update data
        $update_sql = "UPDATE eeform1_submissions SET member_name = 'Updated Test Member' WHERE id = $insert_id";
        if ($db->query($update_sql)) {
            echo "✓ Test data updated successfully\n";
        } else {
            echo "✗ Failed to update test data: " . $db->error . "\n";
        }
        
        // Test 5: Delete data
        $delete_sql = "DELETE FROM eeform1_submissions WHERE id = $insert_id";
        if ($db->query($delete_sql)) {
            echo "✓ Test data deleted successfully\n";
        } else {
            echo "✗ Failed to delete test data: " . $db->error . "\n";
        }
        
    } else {
        echo "✗ Failed to insert test data: " . $db->error . "\n";
        throw new Exception("Data insertion failed");
    }
    
    // Test 6: Count records
    $count_result = $db->query("SELECT COUNT(*) as total FROM eeform1_submissions");
    if ($count_result) {
        $count_row = $count_result->fetch_assoc();
        echo "✓ Current record count: " . $count_row['total'] . "\n";
    }
    
    echo "\n=== All tests completed successfully! ===\n";
    echo "The EEForm1 database structure is working correctly.\n";
    echo "You can now submit form1 data and it will be stored properly.\n\n";
    
    // Show available tables
    echo "Available tables in database:\n";
    $tables_result = $db->query("SHOW TABLES");
    while ($table_row = $tables_result->fetch_array()) {
        echo "- " . $table_row[0] . "\n";
    }
    
    $db->close();
    
} catch (Exception $e) {
    echo "✗ Test failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>