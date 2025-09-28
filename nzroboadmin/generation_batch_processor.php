<?php
session_start(); 
if(!isset($_SESSION['Admin'])){
    header("Location:logout.php");
    exit();
}

require '../db/db.php';
require '../db/functions.php';
require '../db/generation.php';

// Set execution limits
set_time_limit(300); // 5 minutes
ini_set('memory_limit', '512M');

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$batch_size = 100; // Process 100 users at a time
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Get total user count first
$total_query = mysqli_query($mysqli, "SELECT COUNT(DISTINCT m.user) as total FROM `member` m 
                                     INNER JOIN `upgrade` u ON m.user = u.user 
                                     WHERE DATE(m.time)<='".$date."' AND m.paid='1'");
$total_result = mysqli_fetch_assoc($total_query);
$total_users = $total_result['total'] ?: 0;

// Get users for this batch
$users_query = mysqli_query($mysqli, "SELECT DISTINCT m.user FROM `member` m 
                                     INNER JOIN `upgrade` u ON m.user = u.user 
                                     WHERE DATE(m.time)<='".$date."' AND m.paid='1' 
                                     ORDER BY m.user 
                                     LIMIT $batch_size OFFSET $offset");

$processed = 0;
$errors = 0;

echo "<h3>Generation Bonus Batch Processing</h3>";
echo "<p><strong>Date:</strong> $date</p>";
echo "<p><strong>Total Users:</strong> $total_users</p>";
echo "<p><strong>Current Batch:</strong> " . ($offset + 1) . " - " . min($offset + $batch_size, $total_users) . "</p>";

echo "<div style='border: 1px solid #ddd; padding: 10px; background: #f9f9f9; margin: 10px 0; max-height: 300px; overflow-y: auto;'>";

// Ensure table structure
createGenerationIncomeTable();

$SkipUser = array("habib", "kingkhan");

while($user_row = mysqli_fetch_assoc($users_query)) {
    $user_id = $user_row['user'];
    
    if(!in_array(strtolower($user_id), $SkipUser)) {
        try {
            user_update11($user_id, $date);
            echo "✅ Processed: $user_id<br>";
            $processed++;
        } catch(Exception $e) {
            echo "❌ Error processing $user_id: " . $e->getMessage() . "<br>";
            $errors++;
        }
    }
    
    // Flush output for real-time feedback
    flush();
    ob_flush();
}

echo "</div>";

$next_offset = $offset + $batch_size;
$remaining = $total_users - $next_offset;

echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
echo "<h4>Batch Results:</h4>";
echo "<p>✅ <strong>Processed:</strong> $processed users</p>";
echo "<p>❌ <strong>Errors:</strong> $errors users</p>";
echo "<p>📊 <strong>Progress:</strong> " . min($next_offset, $total_users) . " / $total_users (" . round((min($next_offset, $total_users) / $total_users) * 100, 1) . "%)</p>";

if($remaining > 0) {
    echo "<p>⏳ <strong>Remaining:</strong> $remaining users</p>";
    echo "<div style='margin-top: 15px;'>";
    echo "<a href='generation_batch_processor.php?date=$date&offset=$next_offset' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>Process Next Batch ($batch_size users)</a>";
    echo " <a href='generation_batch_processor.php?date=$date&offset=0' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-left: 10px;'>Restart from Beginning</a>";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-top: 15px;'>";
    echo "<h4>🎉 All Users Processed!</h4>";
    echo "<p>Generation bonus processing completed for $date</p>";
    echo "</div>";
}
echo "</div>";

echo "<div style='margin-top: 20px;'>";
echo "<a href='daily_return_settings.php' style='background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>← Back to Admin Panel</a>";
echo "</div>";
?>