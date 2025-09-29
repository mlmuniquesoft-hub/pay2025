<?php
// Debug script to test verification
$base64 = 'U1VNT04wMQ==';
$decoded = base64_decode($base64);
echo "Base64: " . $base64 . "\n";
echo "Decoded: " . $decoded . "\n";

// Test database connection
require_once("../../db/db.php");

if($mysqli->connect_error) {
    echo "Database connection failed: " . $mysqli->connect_error . "\n";
    exit;
}

// Check what's in info_verify table
$result = $mysqli->query("SELECT * FROM `info_verify` WHERE `user`='".$decoded."'");
echo "Records found for user '".$decoded."': " . $result->num_rows . "\n";

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "User: " . $row['user'] . "\n";
        echo "Active: " . $row['active'] . "\n";
        echo "Email: " . $row['email'] . "\n";
        echo "---\n";
    }
}

// Also check case variations
$result2 = $mysqli->query("SELECT * FROM `info_verify` WHERE UPPER(`user`)=UPPER('".$decoded."')");
echo "Records found with case insensitive search: " . $result2->num_rows . "\n";

if($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
        echo "User: " . $row['user'] . "\n";
        echo "Active: " . $row['active'] . "\n";
        echo "Email: " . $row['email'] . "\n";
        echo "---\n";
    }
}
?>