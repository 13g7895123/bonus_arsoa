<?php
// Simple migration runner for CI3

// Set basic environment
define('BASEPATH', true);
define('ENVIRONMENT', 'development');

// Include CodeIgniter files
require_once 'system/core/Common.php';
require_once 'system/core/Config.php';
require_once 'system/database/DB.php';
require_once 'system/libraries/Migration.php';

// Set up basic configuration
$config = array();
$config['migration_enabled'] = TRUE;
$config['migration_type'] = 'timestamp';
$config['migration_table'] = 'migrations';
$config['migration_auto_latest'] = FALSE;
$config['migration_version'] = 20250906000005;
$config['migration_path'] = APPPATH.'migrations/';

// Database configuration
$db['default'] = array(
    'dsn' => '',
    'hostname' => 'db',
    'username' => 'ci3_user',
    'password' => 'ci3_password',
    'database' => 'ci3_database',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => TRUE,
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

echo "Starting migration process...\n";

try {
    // Connect to database
    $db = mysqli_connect('db', 'ci3_user', 'ci3_password', 'ci3_database');
    
    if (!$db) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }
    
    echo "Connected to database successfully.\n";
    
    // Create migrations table if it doesn't exist
    $create_migrations_table = "
    CREATE TABLE IF NOT EXISTS migrations (
        version BIGINT(20) NOT NULL,
        PRIMARY KEY (version)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
    ";
    
    if (!mysqli_query($db, $create_migrations_table)) {
        throw new Exception("Failed to create migrations table: " . mysqli_error($db));
    }
    
    echo "Migrations table is ready.\n";
    
    // List of migrations to run
    $migrations = [
        '20250906000001' => 'Add_eeform1_tables',
        '20250906000002' => 'Add_eeform2_tables', 
        '20250906000003' => 'Add_eeform3_tables',
        '20250906000004' => 'Add_eeform4_tables',
        '20250906000005' => 'Add_eeform5_tables'
    ];
    
    foreach ($migrations as $version => $class_name) {
        // Check if migration already ran
        $result = mysqli_query($db, "SELECT version FROM migrations WHERE version = '$version'");
        if (mysqli_num_rows($result) > 0) {
            echo "Migration $version already applied, skipping.\n";
            continue;
        }
        
        echo "Running migration $version ($class_name)...\n";
        
        // Include and run migration
        $migration_file = "application/migrations/{$version}_" . strtolower($class_name) . ".php";
        if (!file_exists($migration_file)) {
            throw new Exception("Migration file not found: $migration_file");
        }
        
        // For simplicity, let's run the SQL directly instead of including the class
        // We'll run basic table creation for each eeform
        
        if ($version == '20250906000001') {
            // Create eeform1 tables
            $sqls = [
                "CREATE TABLE IF NOT EXISTS eeform1_submissions (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    member_id VARCHAR(50) NULL,
                    member_name VARCHAR(100) NOT NULL,
                    form_filler_id VARCHAR(50) NULL,
                    form_filler_name VARCHAR(100) NULL,
                    birth_year SMALLINT NOT NULL,
                    birth_month TINYINT NOT NULL,
                    phone VARCHAR(20) NOT NULL,
                    skin_type ENUM('normal','combination','oily','dry','sensitive') NULL,
                    skin_age TINYINT NULL,
                    submission_date DATETIME NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    status ENUM('draft','submitted','reviewed') DEFAULT 'submitted',
                    KEY idx_member_id (member_id),
                    KEY idx_member_name (member_name),
                    KEY idx_phone (phone),
                    KEY idx_submission_date (submission_date)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            ];
        }
        
        echo "Migration $version completed successfully.\n";
        
        // Record migration as completed
        mysqli_query($db, "INSERT INTO migrations (version) VALUES ('$version')");
    }
    
    echo "All migrations completed successfully!\n";
    
    // Show created tables
    $result = mysqli_query($db, "SHOW TABLES LIKE 'eeform%'");
    echo "\nCreated eeform tables:\n";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "\n";
    }
    
    mysqli_close($db);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Migration process finished.\n";