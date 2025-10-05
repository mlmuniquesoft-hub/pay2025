<?php
session_start(); 
if(!isset($_SESSION['Admin'])){
    header("Location:logout.php");
    exit();
}

require '../db/db.php';

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get generation bonus statistics
$total_bonuses = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(*) as total, SUM(amount) as total_amount FROM generation_income WHERE DATE(date) = '$date'"));
$unique_recipients = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(DISTINCT user) as recipients FROM generation_income WHERE DATE(date) = '$date'"));
$level_breakdown = mysqli_query($mysqli, "SELECT level, COUNT(*) as count, SUM(amount) as total FROM generation_income WHERE DATE(date) = '$date' GROUP BY level ORDER BY level");

header('Content-Type: application/json');
echo json_encode([
    'date' => $date,
    'total_bonuses' => $total_bonuses['total'] ?: 0,
    'total_amount' => number_format($total_bonuses['total_amount'] ?: 0, 2),
    'unique_recipients' => $unique_recipients['recipients'] ?: 0,
    'level_breakdown' => mysqli_fetch_all($level_breakdown, MYSQLI_ASSOC)
]);
?>