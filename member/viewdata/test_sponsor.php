<?php
// Simple test for sponsor validation
require_once("../../db/db.php");

$sponsor_id = isset($_GET['sponsor_id']) ? $_GET['sponsor_id'] : 'robotrade';

echo "<h3>Testing Sponsor ID: " . htmlspecialchars($sponsor_id) . "</h3>";

// Test database connection
if(!$mysqli) {
    echo "<p style='color:red'>Database connection failed</p>";
    exit;
}

echo "<p style='color:green'>Database connected successfully</p>";

// Check sponsor in member table
$checkSponsor = mysqli_query($mysqli, "SELECT `user`, `pack`, `log_user` FROM `member` WHERE `user`='".$sponsor_id."'");

if(!$checkSponsor) {
    echo "<p style='color:red'>Query error: " . mysqli_error($mysqli) . "</p>";
    exit;
}

if(mysqli_num_rows($checkSponsor) < 1) {
    echo "<p style='color:red'>Sponsor ID not found</p>";
    exit;
}

$sponsorData = mysqli_fetch_assoc($checkSponsor);
echo "<p>Sponsor found:</p>";
echo "<ul>";
echo "<li>User: " . htmlspecialchars($sponsorData['user']) . "</li>";
echo "<li>Pack: " . htmlspecialchars($sponsorData['pack']) . "</li>";
echo "<li>Log User: " . htmlspecialchars($sponsorData['log_user']) . "</li>";
echo "</ul>";

// Check profile
$profileQuery = mysqli_query($mysqli, "SELECT `name` FROM `profile` WHERE `user`='".$sponsor_id."' OR `user`='".$sponsorData['log_user']."'");
if($profileQuery && mysqli_num_rows($profileQuery) > 0) {
    $profile = mysqli_fetch_assoc($profileQuery);
    echo "<p>Profile found: " . htmlspecialchars($profile['name']) . "</p>";
} else {
    echo "<p style='color:orange'>No profile found</p>";
}

echo "<br><a href='checksponsor.php?sponsor_id=" . urlencode($sponsor_id) . "'>Test JSON API</a>";
?>