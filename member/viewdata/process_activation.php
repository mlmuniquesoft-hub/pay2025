<?php
session_start();
include '../../db/db.php';
include '../../db/functions.php';

// Check if user is logged in
if (!isset($_SESSION['roboMember']) || empty($_SESSION['roboMember'])) {
    header('Location: ../../login/');
    exit();
}

$member = $_SESSION['roboMember'];

// Check if user is already activated
$memberQuery = $mysqli->query("SELECT `paid`, `sponsor` FROM `member` WHERE `user`='$member'");
$memberInfo = mysqli_fetch_assoc($memberQuery);

if ($memberInfo['paid'] == 1) {
    $_SESSION['error'] = "Account is already activated!";
    header('Location: ../index.php?route=activation');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'] ?? '';
    $activation_amount = floatval($_POST['activation_amount'] ?? 0);
    $user_id = $_POST['user_id'] ?? '';
    
    // Validate input
    if ($activation_amount != 10) {
        $_SESSION['error'] = "Invalid activation amount!";
        header('Location: ../index.php?route=activation');
        exit();
    }
    
    if ($user_id != $member) {
        $_SESSION['error'] = "Invalid user ID!";
        header('Location: ../index.php?route=activation');
        exit();
    }
    
    if (empty($payment_method)) {
        $_SESSION['error'] = "Please select a payment method!";
        header('Location: ../index.php?route=activation');
        exit();
    }
    
    $mysqli->autocommit(FALSE); // Start transaction
    
    try {
        if ($payment_method === 'wallet_balance') {
            // Process balance payment
            $balanceData = remainAmn22($member);
            $currentBalance = $balanceData['final'] ?? 0;
            
            if ($currentBalance < 10) {
                throw new Exception("Insufficient balance. Current balance: $" . number_format($currentBalance, 2));
            }
            
            // Record activation fee as debit transaction in view table
            $date = date("Y-m-d");
            $description = "Account Activation Fee - $10.00";
            $debitRecord = $mysqli->query("INSERT INTO `view` 
                (`user`, `date`, `description`, `amount`, `types`) 
                VALUES 
                ('$member', '$date', '$description', '10', 'debit')");
                
            if (!$debitRecord) {
                throw new Exception("Failed to record activation transaction");
            }
            
            // Record balance transaction for tracking
            $balanceRecord = $mysqli->query("INSERT INTO `balance_record` 
                (`user`, `taka`, `purpose`, `transaction_id`, `date_added`) 
                VALUES 
                ('$member', '-10', 'Account Activation Fee', 'ACTIVATION_" . time() . "', NOW())");
                
            if (!$balanceRecord) {
                throw new Exception("Failed to record balance transaction");
            }
            
            // Activate account
            $activateAccount = $mysqli->query("UPDATE `member` SET `paid`='1', `activation_date`=NOW() WHERE `user`='$member'");
            
            if (!$activateAccount) {
                throw new Exception("Failed to activate account");
            }
            
            // Process sponsor commission (10% of $10 = $1)
            $sponsor = $memberInfo['sponsor'];
            if (!empty($sponsor) && $sponsor != 0) {
                // Debug: Log activation commission attempt
                $activationDebug = "\n=== ACTIVATION COMMISSION PROCESS ===\n";
                $activationDebug .= "Date: " . date('Y-m-d H:i:s') . "\n";
                $activationDebug .= "Member: $member\n";
                $activationDebug .= "Sponsor: $sponsor\n";
                file_put_contents('../../commission_debug.log', $activationDebug, FILE_APPEND);
                
                // Check if sponsor is activated
                $sponsorQuery = $mysqli->query("SELECT `paid` FROM `member` WHERE `user`='$sponsor'");
                $sponsorInfo = mysqli_fetch_assoc($sponsorQuery);
                
                if ($sponsorInfo && $sponsorInfo['paid'] == 1) {
                    $commission = 1.00; // 10% of $10
                    
                    // Add commission to sponsor balance using view table (credit transaction)
                    $description = "Activation Commission from Member $member - $1.00";
                    $creditRecord = $mysqli->query("INSERT INTO `view` 
                        (`user`, `date`, `description`, `amount`, `types`) 
                        VALUES 
                        ('$sponsor', '$date', '$description', '$commission', 'credit')");
                    
                    if (!$creditRecord) {
                        throw new Exception("Failed to add sponsor commission");
                    }
                    
                    // Record sponsor commission in balance_record for tracking
                    $sponsorRecord = $mysqli->query("INSERT INTO `balance_record` 
                        (`user`, `taka`, `purpose`, `transaction_id`, `date_added`) 
                        VALUES 
                        ('$sponsor', '+$commission', 'Activation Commission from Member $member', 'ACT_COMM_" . time() . "', NOW())");
                        
                    if (!$sponsorRecord) {
                        throw new Exception("Failed to record sponsor commission");
                    }
                    
                    // Record in commission table
                    $commission = (float) $commission; // Ensure proper data type
                    $level = 1; // Activation is always level 1
                    
                    $commissionSql = "INSERT INTO commission_record 
                        (user, from_user, amount, type, level, date_added) 
                        VALUES 
                        ('$sponsor', '$member', $commission, 'activation', $level, NOW())";
                    
                    $commissionInsert = $mysqli->query($commissionSql);
                    
                    if (!$commissionInsert) {
                        // Log error but don't fail activation for commission record issue
                        error_log("Activation commission record insertion failed: " . $mysqli->error);
                        error_log("SQL: $commissionSql");
                    } else {
                        error_log("Activation commission record inserted successfully with ID: " . $mysqli->insert_id);
                    }
                }
            }
            
            $mysqli->commit();
            $_SESSION['success'] = "Account activated successfully! You can now access all trading packages.";
            
        } elseif ($payment_method === 'bitcoin') {
            // For Bitcoin payment, redirect to crypto processor
            // This would typically integrate with a payment gateway
            $mysqli->rollback();
            $_SESSION['info'] = "Bitcoin payment integration is being prepared. Please contact support for manual Bitcoin payment.";
            
        } elseif ($payment_method === 'manual_deposit') {
            // For manual deposit, create pending activation record
            $pendingActivation = $mysqli->query("INSERT INTO `pending_activations` 
                (`user_id`, `amount`, `payment_method`, `status`, `date_created`) 
                VALUES 
                ('$member', '10', 'manual_deposit', 'pending', NOW())");
                
            if (!$pendingActivation) {
                throw new Exception("Failed to create pending activation record");
            }
            
            $mysqli->commit();
            $_SESSION['info'] = "Manual deposit request submitted. Please contact support with your payment details. Your account will be activated after verification.";
        }
        
    } catch (Exception $e) {
        $mysqli->rollback();
        $_SESSION['error'] = "Activation failed: " . $e->getMessage();
    }
    
    $mysqli->autocommit(TRUE); // Reset autocommit
    
    header('Location: ../index.php?route=activation');
    exit();
}

// If not POST request, redirect back
header('Location: ../index.php?route=activation');
exit();
?>