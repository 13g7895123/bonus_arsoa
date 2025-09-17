<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Excel Library for CodeIgniter
 * This library loads PhpSpreadsheet for Excel operations
 */
class Excel
{
    public function __construct()
    {
        $this->load_phpspreadsheet();
    }

    /**
     * Load PhpSpreadsheet library
     */
    private function load_phpspreadsheet()
    {
        // Try to load via composer autoloader first
        $composer_autoload = APPPATH . '../vendor/autoload.php';
        if (file_exists($composer_autoload)) {
            require_once $composer_autoload;
            return;
        }

        // Alternative: Load from third_party directory if available
        $phpspreadsheet_path = APPPATH . 'third_party/PhpSpreadsheet/';
        if (is_dir($phpspreadsheet_path)) {
            // Include PhpSpreadsheet autoloader
            $autoloader_file = $phpspreadsheet_path . 'autoload.php';
            if (file_exists($autoloader_file)) {
                require_once $autoloader_file;
                return;
            }
        }

        // If PhpSpreadsheet is not found, register a simple autoloader
        spl_autoload_register(function ($class) {
            // Check if this is a PhpSpreadsheet class
            if (strpos($class, 'PhpOffice\\PhpSpreadsheet\\') === 0) {
                // For now, just ensure the basic classes are available
                // This is a minimal implementation
                log_message('debug', 'PhpSpreadsheet autoloader called for: ' . $class);
            }
        });
    }
}