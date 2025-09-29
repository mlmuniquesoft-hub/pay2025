<?php
// Quick test to check profile table structure
session_start();
$_SESSION['token'] = "dfgdfgdf";
require_once("../../db/db.php");

header('Content-Type: text/plain');

echo "Testing profile table structure:\n";
echo "================================\n\n";

// Get a sample record to see column names
$test_query = "SELECT * FROM profile LIMIT 1";
$test_result = mysqli_query($mysqli, $test_query);

if($test_result) {
    echo "Profile table exists!\n";
    echo "Number of columns: " . mysqli_num_fields($test_result) . "\n";
    echo "Column names:\n";
    
    $fields = mysqli_fetch_fields($test_result);
    foreach($fields as $field) {
        echo "- " . $field->name . " (" . $field->type . ")\n";
    }
    
    echo "\nSample record:\n";
    $sample = mysqli_fetch_assoc($test_result);
    if($sample) {
        foreach($sample as $key => $value) {
            echo "$key: " . (strlen($value) > 50 ? substr($value, 0, 50) . "..." : $value) . "\n";
        }
    }
} else {
    echo "Error accessing profile table: " . mysqli_error($mysqli) . "\n";
}

echo "\n\nTesting member table structure:\n";
echo "===============================\n\n";

// Also check member table
$member_query = "SELECT * FROM member LIMIT 1";
$member_result = mysqli_query($mysqli, $member_query);

if($member_result) {
    echo "Member table exists!\n";
    echo "Number of columns: " . mysqli_num_fields($member_result) . "\n";
    echo "Column names:\n";
    
    $fields = mysqli_fetch_fields($member_result);
    foreach($fields as $field) {
        echo "- " . $field->name . " (" . $field->type . ")\n";
    }
} else {
    echo "Error accessing member table: " . mysqli_error($mysqli) . "\n";
}
?>