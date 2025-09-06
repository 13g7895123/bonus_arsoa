<?php
// Simple migration runner script
require_once 'index.php';

// Get the CI instance
$CI =& get_instance();

// Load migration library
$CI->load->library('migration');

echo "Starting database migrations...\n";

try {
    if ($CI->migration->current()) {
        echo "Migrations completed successfully!\n";
        echo "Current migration version: " . $CI->migration->get_version() . "\n";
    } else {
        echo "Migration failed!\n";
        echo "Error: " . $CI->migration->error_string() . "\n";
    }
} catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
}

// Show created tables
echo "\nChecking created tables:\n";
$tables = $CI->db->list_tables();
foreach ($tables as $table) {
    if (strpos($table, 'eeform') === 0) {
        echo "- $table\n";
    }
}

echo "Migration process completed.\n";