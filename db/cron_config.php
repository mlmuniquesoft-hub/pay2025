<?php
/**
 * Cron Configuration File
 * 
 * Update these paths to match your server setup before running cron jobs
 */

// ========================================
// SERVER PATH CONFIGURATION
// ========================================

// Uncomment and update the path that matches your server:

// For cPanel hosting:
// $BASE_PATH = '/home/yourusername/public_html';

// For cPanel with httpdocs:
// $BASE_PATH = '/home/yourusername/httpdocs';

// For VPS/Dedicated with Apache:
// $BASE_PATH = '/var/www/html';

// For DirectAdmin:
// $BASE_PATH = '/home/yourusername/domains/yourdomain.com/public_html';

// For Plesk:
// $BASE_PATH = '/var/www/vhosts/yourdomain.com/httpdocs';

// Default - try to auto-detect
$BASE_PATH = dirname(__DIR__); // This tries to go up one level from db/

// ========================================
// PROCESSING CONFIGURATION
// ========================================

$CRON_CONFIG = [
    'chunk_size' => 100,        // Users processed per batch
    'memory_limit' => '2G',     // Memory allocation
    'timezone' => 'Asia/Dacca', // Your timezone
    'verbose' => false,         // Detailed output
    'delay_between_batches' => 100000, // Microseconds (0.1 second)
];

// ========================================
// AUTO-DETECTION LOGIC
// ========================================

// Try to find the correct path automatically
$possible_paths = [
    dirname(__DIR__),                           // Go up from db/ directory
    realpath(dirname(__DIR__)),                 // Resolved path
    getcwd(),                                   // Current working directory
    dirname(getcwd()),                          // Parent of working directory
    '/home/' . get_current_user() . '/public_html', // cPanel common path
    '/home/' . get_current_user() . '/httpdocs',     // Alternative cPanel path
    '/var/www/html',                            // Apache default
];

// Auto-detect the best path
foreach($possible_paths as $path) {
    if($path && is_dir($path . '/db') && file_exists($path . '/db/db.php')) {
        $BASE_PATH = $path;
        break;
    }
}

return [
    'base_path' => $BASE_PATH,
    'db_path' => $BASE_PATH . '/db',
    'config' => $CRON_CONFIG
];
?>