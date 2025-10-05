<?php 
// Modern Bootstrap 5 Tree View
session_start();
if(!isset($_SESSION['roboMember'])){
    header("Location: ../nz-login.html");
    exit();
}

// Include database and functions
require_once("../../db/db.php");
require_once("../../db/functions.php");
require_once("../part/sideTree.php");

$member = $_SESSION['roboMember'];

// Get member info
$result3 = $mysqli->query("select * from member where user='".$member."' ");
$memberInfo = mysqli_fetch_array($result3); 
if(!$memberInfo) {
    $memberInfo = array('log_user' => '', 'user' => '', 'pack' => 0, 'paid' => 0);
}

// Get profile info
$result1 = $mysqli->query("select * from profile where `user`='".$memberInfo['log_user']."' OR `user`='".$memberInfo['user']."' ");
$ProfileInfo = mysqli_fetch_array($result1); 
if(!$ProfileInfo) {
    $ProfileInfo = array('photo' => 'default.jpg', 'name' => 'User');
}

// Handle referral parameter
$refer = isset($_GET['ref']) ? $_GET['ref'] : '';
if($refer == ''){
    $referral = strtolower($_SESSION['roboMember']);
} else {
    $referral = strtolower(base64_decode($_GET['ref']));
}

// Get member tree data
$iiuu = mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$_SESSION['roboMember']."'"));
if(!$iiuu || $iiuu === null) {
    $iiuu = array('totalLeftId' => '', 'totalrightId' => '');
}

$leftall = explode(",", strtolower($iiuu['totalLeftId']));
$rightall = explode(",", strtolower($iiuu['totalrightId']));
$ttt = array_merge($leftall, $rightall);
array_unshift($ttt, $referral);

// Security check
if($referral != $_SESSION['roboMember']){
    if(!in_array($referral, $ttt)){
        echo "<script>history.back()</script>";
        die();
    }
}

// Get left and right users using original function
function leftRightww12($usse, $table){
    global $mysqli;
    $eer=array();
    $mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
    while($uuui=mysqli_fetch_assoc($mmm)){
        if($uuui['position']==1){
            $eer['left']=$uuui['user'];
        }elseif($uuui['position']==2){
            $eer['right']=$uuui['user'];
        }
    }
    return $eer;
}

$usekk = leftRightww12($referral, "member");
if(!isset($usekk['left'])) $usekk['left'] = '';
if(!isset($usekk['right'])) $usekk['right'] = '';

// Get user profile data
$usermmmqq = mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$referral."'"));
if(!$usermmmqq || $usermmmqq === null) {
    $usermmmqq = array('user' => $referral, 'log_user' => $referral);
}

$userProfile = mysqli_fetch_assoc($mysqli->query("SELECT `name`,`photo`,`user` FROM `profile` WHERE `user`='".$usermmmqq['log_user']."'"));
if(!$userProfile || $userProfile === null) {
    $userProfile = array('name' => 'Unknown User', 'photo' => 'default.jpg', 'user' => $referral);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Tree View - Capitol Money Pay</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Tree CSS -->
    <link rel="stylesheet" href="css/modern-tree.css">
</head>
<body class="bg-dark">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <button class="btn btn-outline-light me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand fw-bold" href="#">
                <span class="text-warning">Capitol</span>
                <span class="text-info">Money</span>
                <span class="text-success">Pay</span>
            </a>
            
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="../data/profile/<?php echo $ProfileInfo['photo']; ?>" alt="Profile" class="rounded-circle me-2" width="32" height="32">
                        <?php echo $ProfileInfo['name']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="../index.php"><i class="fas fa-dashboard me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="../index.php?route=profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebar">
                <div class="position-sticky pt-3">
                    <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
                        <span>NAVIGATION</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="../index.php">
                                <i class="fas fa-dashboard me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-warning" href="index.php">
                                <i class="fas fa-sitemap me-2"></i>Tree View
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="../index.php?route=sponsor_list">
                                <i class="fas fa-users me-2"></i>Team
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="../index.php?route=trade_plan">
                                <i class="fas fa-chart-line me-2"></i>Plans
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">
                        <span>TREE TOOLS</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <button class="nav-link text-light btn btn-link" onclick="zoomIn()">
                                <i class="fas fa-search-plus me-2"></i>Zoom In
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-light btn btn-link" onclick="zoomOut()">
                                <i class="fas fa-search-minus me-2"></i>Zoom Out
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-light btn btn-link" onclick="resetZoom()">
                                <i class="fas fa-expand-arrows-alt me-2"></i>Reset
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link text-light btn btn-link" onclick="toggleFullscreen()">
                                <i class="fas fa-expand me-2"></i>Fullscreen
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-light">
                        <i class="fas fa-sitemap me-2 text-primary"></i>Network Tree View
                    </h1>
                    
                    <!-- Search and Tools -->
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <input type="text" class="form-control" id="searchUser" placeholder="Search user...">
                            <button class="btn btn-primary" onclick="searchInTree()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <?php if($_SESSION['roboMember'] != $referral): ?>
                        <a href="index.php?ref=<?php echo base64_encode($_SESSION['roboMember']); ?>" class="btn btn-warning">
                            <i class="fas fa-arrow-left me-1"></i>Back to My Tree
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Package Legend -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-dark border-secondary">
                            <div class="card-header">
                                <h6 class="mb-0 text-light"><i class="fas fa-palette me-2"></i>Package Legend</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php
                                    $plans = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K");
                                    $packages = $mysqli->query("SELECT * FROM `package`");
                                    $i = 0;
                                    while($package = mysqli_fetch_assoc($packages)){
                                        $textColor = (($package['pack']=="NZBOT500")||($package['pack']=="NZBOT300")||($package['pack']=="NZBOT50000")) ? "#040404" : "#FFF";
                                    ?>
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="badge" style="background:<?php echo $package['color']; ?>;color:<?php echo $textColor; ?>;width:100%;">
                                            <?php echo $package['pack']. " (".$plans[$i] .")"; ?>
                                        </div>
                                    </div>
                                    <?php $i++; } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tree Container -->
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark border-secondary">
                            <div class="card-body p-2">
                                <div id="treeContainer" class="tree-container">
                                    <div id="tree" class="tree-content">
                                        <div class="tree-zoom-container">
                                            <!-- Tree will be rendered here -->
                                            <div class="tree-node-container">
                                                <table class="tree-table" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <!-- Root User -->
                                                        <tr class="node-row">
                                                            <td class="node-cell" colspan="4">
                                                                <div class="bs5-tree-node">
                                                                    <?php InfoPartTree($referral,""); ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <div class="tree-line-down"></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tree-line-left"></td>
                                                            <td class="tree-line-right-top"></td>
                                                            <td class="tree-line-left-top"></td>
                                                            <td class="tree-line-right"></td>
                                                        </tr>
                                                        
                                                        <!-- First Level (Left and Right) -->
                                                        <tr>
                                                            <td class="child-node" colspan="2">
                                                                <table class="tree-table" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="node-cell" colspan="4">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php 
                                                                                    InfoPartTree($usekk['left'], $referral);
                                                                                    $userLeft1 = leftRightww12($usekk['left'], "member");
                                                                                    if(!isset($userLeft1['left'])) $userLeft1['left'] = '';
                                                                                    if(!isset($userLeft1['right'])) $userLeft1['right'] = '';
                                                                                    ?>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <div class="tree-line-down"></div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tree-line-left"></td>
                                                                            <td class="tree-line-right-top"></td>
                                                                            <td class="tree-line-left-top"></td>
                                                                            <td class="tree-line-right"></td>
                                                                        </tr>
                                                                        <!-- Second Level Left Branch -->
                                                                        <tr>
                                                                            <td class="second-level-node" colspan="2">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php InfoPartTree($userLeft1['left'], $usekk['left']); ?>
                                                                                </div>
                                                                            </td>
                                                                            <td class="second-level-node" colspan="2">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php InfoPartTree($userLeft1['right'], $usekk['left']); ?>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="child-node" colspan="2">
                                                                <table class="tree-table" cellpadding="0" cellspacing="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="node-cell" colspan="4">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php 
                                                                                    InfoPartTree($usekk['right'], $referral);
                                                                                    $userRight1 = leftRightww12($usekk['right'], "member");
                                                                                    if(!isset($userRight1['left'])) $userRight1['left'] = '';
                                                                                    if(!isset($userRight1['right'])) $userRight1['right'] = '';
                                                                                    ?>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <div class="tree-line-down"></div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="tree-line-left"></td>
                                                                            <td class="tree-line-right-top"></td>
                                                                            <td class="tree-line-left-top"></td>
                                                                            <td class="tree-line-right"></td>
                                                                        </tr>
                                                                        <!-- Second Level Right Branch -->
                                                                        <tr>
                                                                            <td class="second-level-node" colspan="2">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php InfoPartTree($userRight1['left'], $usekk['right']); ?>
                                                                                </div>
                                                                            </td>
                                                                            <td class="second-level-node" colspan="2">
                                                                                <div class="bs5-tree-node">
                                                                                    <?php InfoPartTree($userRight1['right'], $usekk['right']); ?>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tree JS -->
    <script src="js/modern-tree.js"></script>
</body>
</html>

