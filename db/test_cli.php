<?php
echo "PHP CLI Test: Working\n";
echo "Arguments: " . print_r($argv, true) . "\n";

// Test basic PHP functionality
echo "Date: " . date('Y-m-d H:i:s') . "\n";

// Test file inclusion
if(file_exists('db.php')) {
    echo "db.php exists\n";
} else {
    echo "db.php NOT found\n";
}

echo "Script completed\n";
?>