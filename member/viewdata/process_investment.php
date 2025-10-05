<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../db/db.php';
include '../../db/functions.php';

// Check if user is logged in
if (!isset($_SESSION['roboMember']) || empty($_SESSION['roboMember'])) {
    header('Location: ../../login/');
    exit();
}

$member = $_SESSION['roboMember'];

// Check if user is activated
$memberQuery = $mysqli->query("SELECT `paid`, `sponsor`, `pin` FROM `member` WHERE `user`='$member'");
$memberInfo = mysqli_fetch_assoc($memberQuery);

if ($memberInfo['paid'] != 1) {
    $_SESSION['error'] = "Account is not activated! Please activate your account first.";
    header('Location: ../index.php?route=activation');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tier = $_POST['tier'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    $user_id = $_POST['user_id'] ?? '';
    $transaction_pin = $_POST['transaction_pin'] ?? '';
    
    // Validate input
    if ($amount < 100) {
        $_SESSION['error'] = "Minimum investment amount is $100!";
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    
    if ($user_id != $member) {
        $_SESSION['error'] = "Invalid user ID!";
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    
    if (empty($tier) || empty($transaction_pin)) {
        $_SESSION['error'] = "Please fill all required fields!";
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    // Verify transaction PIN
    if ($memberInfo['pin'] != $transaction_pin) {
        $_SESSION['error'] = "Invalid transaction PIN!";
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    
    // Validate amount range
    $validAmount = false;
    $packageName = '';
    if ($amount >= 100 && $amount <= 999) {
        $validAmount = true;
        $packageName = 'Basic Package';
    } elseif ($amount >= 1000 && $amount <= 4999) {
        $validAmount = true;
        $packageName = 'Premium Package';
    } elseif ($amount >= 5000 && $amount <= 25000) {
        $validAmount = true;
        $packageName = 'VIP Package';
    }
    
    if (!$validAmount) {
        $_SESSION['error'] = "Invalid investment amount for the selected tier!";
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    
    // Check if user already has an active investment
    // $existingInvestment = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total_invested FROM `upgrade` WHERE `user`='$member'"));
    // if ($existingInvestment['total_invested'] > 0) {
    //     $_SESSION['error'] = "You already have an active investment. Multiple investments not allowed.";
    //     header('Location: ../index.php?route=trade_plan');
    //     exit();
    // }
    
    // Check balance
    $balanceData = remainAmn22($member);
    $currentBalance = $balanceData['final'] ?? 0;
    
    
    if ($currentBalance < $amount) {
        $_SESSION['error'] = "Insufficient balance. Required: $" . number_format($amount, 2) . " | Available: $" . number_format($currentBalance, 2);
        header('Location: ../index.php?route=trade_plan');
        exit();
    }
    
    $mysqli->autocommit(FALSE); // Start transaction
    
    try {
        // Set date for all transactions
        $date = date("Y-m-d");
        
        // Debug: Log investment attempt
        error_log("Investment attempt: User=$member, Amount=$amount, Package=$packageName, Date=$date");
        
        // Record investment as debit transaction in view table (this is how the system tracks balance)
        $description = "$packageName Investment - $" . number_format($amount, 2);
        $debitRecord = $mysqli->query("INSERT INTO `view` 
            (`user`, `date`, `description`, `amount`, `types`) 
            VALUES 
            ('$member', '$date', '$description', '$amount', 'debit')");
            
        if (!$debitRecord) {
            throw new Exception("Failed to record investment transaction: " . $mysqli->error);
        }
        
        // Record balance transaction in balance_record for tracking
        $balanceRecord = $mysqli->query("INSERT INTO `balance_record` 
            (`user`, `taka`, `purpose`, `transaction_id`, `date_added`) 
            VALUES 
            ('$member', '-$amount', '$packageName Investment', 'INV_" . time() . "', NOW())");
            
        if (!$balanceRecord) {
            throw new Exception("Failed to record balance transaction");
        }
        
        // Insert investment record
        $invoiceNum = 'INV_' . time() . '_' . $member;
        $activationDate = date("Y-m-d H:i:s");
        
        $investmentRecord = $mysqli->query("INSERT INTO `upgrade` 
            (`user`, `package`, `amount`, `bonus`, `shopping`, `sponsor`, `upline`, `invoice`, `charge`, `date`) 
            VALUES 
            ('$member', '$packageName', '$amount', '0', '0', '{$memberInfo['sponsor']}', '{$memberInfo['sponsor']}', '$invoiceNum', '0', '$activationDate')");
            
        if (!$investmentRecord) {
            throw new Exception("Failed to record investment");
        }
        
        // Update member pack status
        $updateMember = $mysqli->query("UPDATE `member` SET `pack`='1' WHERE `user`='$member'");
        
        if (!$updateMember) {
            throw new Exception("Failed to update member status");
        }
        
        // Process multi-level trading commissions (8%-1%-1%) using proper 3-level distribution
        $commissionLevels = [
            1 => 8, // 8% for direct referrals (Level 1)
            2 => 1, // 1% for 2nd level upline
            3 => 1  // 1% for 3rd level upline
        ];
        
        // Build sponsor chain for 3 levels
        $sponsorChain = [];
        $currentSponsor = $memberInfo['sponsor'];
        
        // Get 3 levels of sponsors
        for ($i = 1; $i <= 3; $i++) {
            if (!$currentSponsor || $currentSponsor == '') {
                break;
            }
            
            $sponsorQuery = $mysqli->query("SELECT `user`, `paid`, `sponsor` FROM `member` WHERE `user`='$currentSponsor'");
            $sponsorInfo = mysqli_fetch_assoc($sponsorQuery);
            
            if ($sponsorInfo) {
                $sponsorChain[$i] = [
                    'user' => $sponsorInfo['user'],
                    'paid' => $sponsorInfo['paid'],
                    'sponsor' => $sponsorInfo['sponsor']
                ];
                $currentSponsor = $sponsorInfo['sponsor'];
            } else {
                break;
            }
        }
        
        // Debug: Log sponsor chain
        error_log("Sponsor chain for $member: " . json_encode($sponsorChain));
        error_log("Total levels to process: " . count($sponsorChain));
        
        // Write initial debug info to custom log file
        $initialDebug = "\n=== NEW INVESTMENT COMMISSION PROCESS ===\n";
        $initialDebug .= "Date: " . date('Y-m-d H:i:s') . "\n";
        $initialDebug .= "Member: $member\n";
        $initialDebug .= "Amount: $amount\n";
        $initialDebug .= "Package: $packageName\n";
        $initialDebug .= "Sponsor Chain: " . json_encode($sponsorChain) . "\n";
        file_put_contents('../../commission_debug.log', $initialDebug, FILE_APPEND);
        
        // Debug: Check commission_record table before processing
        $tableCheck = $mysqli->query("SELECT COUNT(*) as cnt FROM commission_record");
        if ($tableCheck) {
            $beforeCount = $tableCheck->fetch_assoc()['cnt'];
            error_log("Commission records before processing: $beforeCount");
            file_put_contents('../../commission_debug.log', "Records before: $beforeCount\n", FILE_APPEND);
        }
        
        // Distribute commissions to each level
        foreach ($sponsorChain as $level => $sponsorData) {
            $sponsorUser = $sponsorData['user'];
            $sponsorPaid = $sponsorData['paid'];
            
            // Only pay commission if sponsor is activated
            if ($sponsorPaid == 1) {
                $commissionRate = $commissionLevels[$level];
                $commissionAmount = round(($amount * $commissionRate / 100), 2);
                
                // Debug: Log commission calculation and verify data types
                error_log("Level $level: Sponsor=$sponsorUser, Rate=$commissionRate%, Amount=$commissionAmount");
                error_log("Variable types - Level: " . gettype($level) . " ($level), Amount: " . gettype($commissionAmount) . " ($commissionAmount)");
                
                // Ensure proper data types
                $level = (int) $level;
                $commissionAmount = (float) $commissionAmount;
                
                // Add commission to sponsor's balance using view table (credit transaction)
                $description = "Level $level Trading Commission ($commissionRate%) from $member ($packageName)";
                $creditRecord = $mysqli->query("INSERT INTO `view` 
                    (`user`, `date`, `description`, `amount`, `types`) 
                    VALUES 
                    ('$sponsorUser', '$date', '$description', '$commissionAmount', 'credit')");
                
                if (!$creditRecord) {
                    throw new Exception("Failed to add commission for level $level sponsor $sponsorUser: " . $mysqli->error);
                }
                
                // Record commission transaction in balance_record for tracking
                $transactionId = 'COMM_' . time() . '_L' . $level . '_' . substr(md5($member . $sponsorUser), 0, 6);
                $sponsorRecord = $mysqli->query("INSERT INTO `balance_record` 
                    (`user`, `taka`, `purpose`, `transaction_id`, `date_added`) 
                    VALUES 
                    ('$sponsorUser', '+$commissionAmount', '$description', '$transactionId', NOW())");
                    
                if (!$sponsorRecord) {
                    throw new Exception("Failed to record balance for level $level sponsor $sponsorUser: " . $mysqli->error);
                }
                
                // Record in commission_record table for reporting
                $commissionSql = "INSERT INTO commission_record 
                    (user, from_user, amount, type, level, date_added) 
                    VALUES 
                    ('$sponsorUser', '$member', $commissionAmount, 'trading', $level, NOW())";
                
                // Debug: Log the actual SQL being executed
                error_log("Executing commission SQL: $commissionSql");
                
                // Write detailed debug to custom log file
                $debugLog = "=== COMMISSION DEBUG ===\n";
                $debugLog .= "Timestamp: " . date('Y-m-d H:i:s') . "\n";
                $debugLog .= "Member: $member\n";
                $debugLog .= "Sponsor: $sponsorUser\n";
                $debugLog .= "Level: $level (" . gettype($level) . ")\n";
                $debugLog .= "Amount: $commissionAmount (" . gettype($commissionAmount) . ")\n";
                $debugLog .= "SQL: $commissionSql\n";
                file_put_contents('../../commission_debug.log', $debugLog, FILE_APPEND);
                
                $commissionInsert = $mysqli->query($commissionSql);
                
                if (!$commissionInsert) {
                    $errorDetails = "COMMISSION INSERT FAILED!\n";
                    $errorDetails .= "Error: " . $mysqli->error . "\n";
                    $errorDetails .= "Error Number: " . $mysqli->errno . "\n";
                    $errorDetails .= "SQL State: " . $mysqli->sqlstate . "\n";
                    $errorDetails .= "Connection ID: " . $mysqli->thread_id . "\n";
                    $errorDetails .= "Character Set: " . $mysqli->character_set_name() . "\n";
                    
                    file_put_contents('../../commission_debug.log', $errorDetails, FILE_APPEND);
                    error_log("Commission record insertion failed for level $level: " . $mysqli->error);
                    error_log("SQL State: " . $mysqli->sqlstate);
                    error_log("MySQL Error Number: " . $mysqli->errno);
                    error_log("Attempted SQL: $commissionSql");
                    error_log("Attempted values: user=$sponsorUser, from_user=$member, amount=$commissionAmount, type=trading, level=$level");
                    
                    // Try a simpler test insert to debug
                    $testInsert = $mysqli->query("INSERT INTO commission_record (user, from_user, amount, type, level, date_added) VALUES ('debug_test', 'debug_from', 1.00, 'trading', 1, NOW())");
                    if ($testInsert) {
                        error_log("Test insert worked - issue with variables");
                        file_put_contents('../../commission_debug.log', "Test insert worked - issue with variables\n", FILE_APPEND);
                        $mysqli->query("DELETE FROM commission_record WHERE user='debug_test'");
                    } else {
                        error_log("Test insert also failed: " . $mysqli->error);
                        file_put_contents('../../commission_debug.log', "Test insert also failed: " . $mysqli->error . "\n", FILE_APPEND);
                    }
                    
                    throw new Exception("Failed to record commission in commission_record table for level $level: " . $mysqli->error);
                } else {
                    // Debug: Confirm successful insert
                    $successLog = "SUCCESS! Insert ID: " . $mysqli->insert_id . "\n";
                    file_put_contents('../../commission_debug.log', $successLog, FILE_APPEND);
                    error_log("Commission record successfully inserted with ID: " . $mysqli->insert_id);
                }
                
                // Debug: Log successful commission record
                error_log("Successfully recorded commission: Level $level, Amount $commissionAmount for sponsor $sponsorUser from $member");
            } else {
                // Log skipped inactive sponsor
                error_log("Skipped Level $level commission for inactive sponsor: $sponsorUser");
            }
        }
        
        // Debug: Check commission_record table after processing
        $tableCheckAfter = $mysqli->query("SELECT COUNT(*) as cnt FROM commission_record");
        if ($tableCheckAfter) {
            $afterCount = $tableCheckAfter->fetch_assoc()['cnt'];
            error_log("Commission records after processing: $afterCount");
            
            // Show recent commission records for this investment
            $recentCommissions = $mysqli->query("SELECT * FROM commission_record WHERE from_user='$member' ORDER BY id DESC LIMIT 5");
            if ($recentCommissions && $recentCommissions->num_rows > 0) {
                error_log("Recent commissions for $member:");
                while ($comm = $recentCommissions->fetch_assoc()) {
                    error_log("  Level {$comm['level']}: {$comm['user']} got {$comm['amount']} on {$comm['date_added']}");
                }
            } else {
                error_log("No commission records found for $member after investment!");
            }
        }
        
        $mysqli->commit();
        $_SESSION['success'] = "🎉 Investment successful! You invested $" . number_format($amount, 2) . " in the $packageName. Returns will start from the next business day.";
        
    } catch (Exception $e) {
        $mysqli->rollback();
        $_SESSION['error'] = "Investment failed: " . $e->getMessage() . " (Debug: Line " . $e->getLine() . ")";
        error_log("Investment Error for user $member: " . $e->getMessage() . " at line " . $e->getLine());
    }
    
    $mysqli->autocommit(TRUE); // Reset autocommit
    
    header('Location: ../index.php?route=trade_plan');
    exit();
}

// If not POST request, redirect back
header('Location: ../index.php?route=trade_plan');
exit();
?>