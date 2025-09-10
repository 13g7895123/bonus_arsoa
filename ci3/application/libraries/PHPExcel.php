<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PHPExcel Loader for CodeIgniter
 * This file loads the PHPExcel library for use in CodeIgniter
 */

// Include PHPExcel main class files
$phpexcel_path = APPPATH . 'third_party/PHPExcel/';

// Check if PHPExcel directory exists
if (!is_dir($phpexcel_path)) {
    show_error('PHPExcel library not found in third_party directory');
}

// Autoloader function for PHPExcel classes
spl_autoload_register(function ($class) {
    $phpexcel_path = APPPATH . 'third_party/PHPExcel/';
    
    // PHPExcel classes start with 'PHPExcel'
    if (strpos($class, 'PHPExcel') === 0) {
        // Remove PHPExcel prefix and convert to path
        $path = str_replace('PHPExcel', '', $class);
        $path = str_replace('_', '/', $path);
        
        // Build the full file path
        if ($path === '') {
            // Main PHPExcel class
            $file = $phpexcel_path . 'PHPExcel.php';
        } else {
            $file = $phpexcel_path . ltrim($path, '/') . '.php';
        }
        
        // Include the file if it exists
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Include main PHPExcel class
require_once $phpexcel_path . 'Autoloader.php';
require_once $phpexcel_path . 'IOFactory.php';

// Create main PHPExcel class if it doesn't exist
if (!class_exists('PHPExcel')) {
    class PHPExcel {
        
        private $_properties;
        private $_security;
        private $_worksheetCollection = array();
        private $_activeSheetIndex = 0;
        
        public function __construct() {
            // Initialize PHPExcel
            $this->_properties = new PHPExcel_DocumentProperties();
            $this->_security = new PHPExcel_DocumentSecurity();
            
            // Create first worksheet
            $this->createSheet();
            $this->setActiveSheetIndex(0);
        }
        
        public function createSheet($iSheetIndex = null) {
            $newSheet = new PHPExcel_Worksheet($this);
            $this->addSheet($newSheet, $iSheetIndex);
            return $newSheet;
        }
        
        public function addSheet(PHPExcel_Worksheet $pSheet = null, $iSheetIndex = null) {
            if(is_null($iSheetIndex)) {
                $this->_worksheetCollection[] = $pSheet;
            } else {
                array_splice($this->_worksheetCollection, $iSheetIndex, 0, array($pSheet));
            }
            return $pSheet;
        }
        
        public function setActiveSheetIndex($pIndex = 0) {
            if ($pIndex > count($this->_worksheetCollection) - 1) {
                throw new Exception("Sheet index out of bounds.");
            } else {
                $this->_activeSheetIndex = $pIndex;
            }
            return $this->getActiveSheet();
        }
        
        public function getActiveSheet() {
            return $this->_worksheetCollection[$this->_activeSheetIndex];
        }
        
        public function disconnectWorksheets() {
            foreach($this->_worksheetCollection as $k => &$worksheet) {
                $worksheet->disconnectCells();
                $this->_worksheetCollection[$k] = null;
            }
            unset($worksheet);
            $this->_worksheetCollection = array();
        }
    }
}

// Include additional required classes
$required_files = array(
    'Worksheet.php',
    'DocumentProperties.php', 
    'DocumentSecurity.php',
    'Style.php',
    'Style/Fill.php',
    'Style/Color.php',
    'Style/Alignment.php',
    'Style/Font.php',
    'Writer/Excel2007.php'
);

foreach ($required_files as $file) {
    $filepath = $phpexcel_path . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}