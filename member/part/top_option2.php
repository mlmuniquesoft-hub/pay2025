<?php
// Initialize notification variables
if(isset($_SESSION['roboMember']) && isset($mysqli)) {
    $member = $_SESSION['roboMember'];
    $Noerte = $mysqli->query("SELECT * FROM `view` WHERE `user`='".$member."' AND `active`='1' ORDER BY `serial` DESC");
    $NomerNoty = $Noerte ? mysqli_num_rows($Noerte) : 0;
    
    // Initialize member info
    $result3 = $mysqli->query("select * from member where user='".$member."' ");
    $memberInfo = mysqli_fetch_array($result3);
    if(!$memberInfo) {
        $memberInfo = array('log_user' => '', 'user' => '', 'pack' => 0);
    }
    
    // Initialize profile info
    $result1 = $mysqli->query("select * from profile where `user`='".$memberInfo['log_user']."' OR `user`='".$memberInfo['user']."' ");
    $ProfileInfo = mysqli_fetch_array($result1);
    if(!$ProfileInfo) {
        $ProfileInfo = array('photo' => 'default.jpg', 'name' => 'User');
    }
} else {
    $NomerNoty = 0;
    $Noerte = null;
    $memberInfo = array('log_user' => '', 'user' => '', 'pack' => 0);
    $ProfileInfo = array('photo' => 'default.jpg', 'name' => 'User');
}
?>
<body class=" ">
    <!-- START TOPBAR -->
    <div class='page-topbar gradient-blue1'>
        <div class='logo-area crypto'>
            <a href="index.php" class="logo-text">
                <span class="logo-main">Capitol</span><span class="logo-sub">Money</span><span class="logo-accent">Pay</span>
            </a>
            <style>
                .logo-text {
                    display: inline-block;
                    text-decoration: none;
                    font-family: 'Arial', sans-serif;
                    font-weight: bold;
                    font-size: 24px;
                    line-height: 1.2;
                    margin: 10px 20px;
                    color: #fff;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
                    transition: all 0.3s ease;
                }
                .logo-text:hover {
                    color: #fff;
                    text-decoration: none;
                    transform: scale(1.05);
                }
                .logo-main {
                    color: #FFD700;
                    font-size: 26px;
                    letter-spacing: 1px;
                }
                .logo-sub {
                    color: #87CEEB;
                    font-size: 24px;
                    margin: 0 2px;
                }
                .logo-accent {
                    color: #98FB98;
                    font-size: 26px;
                    letter-spacing: 1px;
                }
                @media (max-width: 768px) {
                    .logo-text {
                        font-size: 18px;
                        margin: 8px 15px;
                    }
                    .logo-main, .logo-accent {
                        font-size: 20px;
                    }
                    .logo-sub {
                        font-size: 18px;
                    }
                }
            </style>
        </div>
        
        <!-- Mobile Sidebar Fix CSS -->
        <style>
        /* Fix mobile sidebar display issues */
        @media (max-width: 767px) {
            /* Ensure sidebar has proper background and visibility */
            .page-sidebar {
                background: #2c3e50 !important; /* Proper dark background instead of magenta */
                color: #fff !important;
                z-index: 9999 !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 250px !important;
                height: 100vh !important;
                transform: translateX(-100%) !important;
                transition: transform 0.3s ease !important;
                overflow-y: auto !important;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1) !important;
            }
            
            /* Show sidebar when expanded */
            .page-sidebar.expandit {
                transform: translateX(0) !important;
            }
            
            /* Ensure sidebar content is visible */
            .page-sidebar .page-sidebar-wrapper {
                background: rgba(0, 0, 0, 0.3) !important;
                color: #fff !important;
                height: 100% !important;
                padding-top: 60px !important;
            }
            
            .page-sidebar .wraplist {
                background: rgba(0, 0, 0, 0.3) !important;
                color: #fff !important;
                margin-top: 0 !important;
            }
            
            .page-sidebar .wraplist li a {
                color: #fff !important;
                text-decoration: none !important;
            }
            
            .page-sidebar .wraplist li a:hover {
                background: rgba(255,255,255,0.1) !important;
                color: #fff !important;
            }
            
            /* Overlay for mobile when sidebar is open */
            body.sidebar-open::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 9998;
                display: block;
            }
            
            /* Ensure main content shifts properly */
            #main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
        </style>
        
        <div class='quick-area'>
            <div class='pull-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="sidebar-toggle-wrap">
                        <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class='pull-right'>
                <ul class="info-menu right-links list-inline list-unstyled">
                    <li class="notify-toggle-wrapper spec">
                        <a href="#" data-toggle="dropdown" class="toggle Notify" data-table="view">
                            <i class="fa fa-bell"></i>
                            <span class="badge badge-accent" id="NotiCon"><?php echo $NomerNoty; ?></span>
                        </a>
                        <ul class="dropdown-menu notifications animated fadeIn">
                            <li class="total">
                                <span class="small" style="color: brown;">
                                You have <strong><?php echo $NomerNoty; ?></strong> new notifications.
                                <a href="javascript:;" class="pull-right reDSD" data-sers="All">Mark all as Read</a>
                            </span>
                            </li>
                            <li class="list" >

                                <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                    <?php
									if($Noerte && mysqli_num_rows($Noerte) > 0) {
										while($mydfsIo=mysqli_fetch_assoc($Noerte)){
											if($mydfsIo['types']=="credit"){
												$dfgdf="available";
												$sfs="plus";
												
											}elseif($mydfsIo['types']=="debit"){
												$dfgdf="away";
												$sfs="minus";
											}else{
												$dfgdf="busy";
											}
									?>
									<li class="unread <?php echo $dfgdf; ?>">
                                        <!-- available: success, warning, info, error -->
                                        <a href="javascript:;" class="reDSD" data-sers="<?php echo $mydfsIo['serial']?>">
                                            <div class="notice-icon">
                                                <i class="fa fa-<?php echo $sfs; ?>"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong><?php echo $mydfsIo['description']?></strong>
                                                    <span class="time small"><?php echo date("M d-Y H:i:s", strtotime($mydfsIo['date'])); ?></span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
									<?php } } else { ?>
                                    <li class="unread">
                                        <a href="javascript:;">
                                            <div class="notice-icon">
                                                <i class="fa fa-info"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>No notifications</strong>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>

                            </li>

                            <li class="external">
                                <a href="../index.php?route=view_notification&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <span>Read All Notifications</span>
                                </a>
                            </li>
                        </ul>
                    </li>
					<script>
						$(".Notify").on("click", function(){
							let fdfgfd=$(this).attr("data-table");
							const werwe=$.ajax({
								method:"GET",
								url:"../viewdata/UpdateNotify.php",
								data:{acsf:fdfgfd}
							});
							werwe.done((redf)=>{
								$("#NotiCon").text(redf);
							})
							
						});
					</script>
                    <li class="message-toggle-wrapper spec">
                        <a href="#" data-toggle="dropdown" class="toggle mr-15">
                            <i class="fa fa-envelope"></i>
                            <span class="badge badge-accent">0</span>
                        </a>
                        <ul class="dropdown-menu messages animated fadeIn">

                            <li class="list" style="display:none;">

                                <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                    <li class="unread status-available">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-1.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Clarine Vassar</strong>
                                                    <span class="time small">- 15 mins ago</span>
                                                <span class="profile-status available pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-away">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-2.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Brooks Latshaw</strong>
                                                    <span class="time small">- 45 mins ago</span>
                                                <span class="profile-status away pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-busy">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-3.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Clementina Brodeur</strong>
                                                    <span class="time small">- 1 hour ago</span>
                                                <span class="profile-status busy pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-offline">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-4.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Carri Busey</strong>
                                                    <span class="time small">- 5 hours ago</span>
                                                <span class="profile-status offline pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-offline">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-5.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Melissa Dock</strong>
                                                    <span class="time small">- Yesterday</span>
                                                <span class="profile-status offline pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-available">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-1.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Verdell Rea</strong>
                                                    <span class="time small">- 14th Mar</span>
                                                <span class="profile-status available pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-busy">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-2.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Linette Lheureux</strong>
                                                    <span class="time small">- 16th Mar</span>
                                                <span class="profile-status busy pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-away">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-3.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Araceli Boatright</strong>
                                                    <span class="time small">- 16th Mar</span>
                                                <span class="profile-status away pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                            </li>

                            <li class="external">
                                <a href="javascript:;">
                                    <span>Read All Messages</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                    
                    <li class="profile">
                        <a href="#" data-toggle="dropdown" class="toggle">
                            <img src="/member/photo/<?php echo $ProfileInfo['photo']; ?>" alt="user-image" class="img-circle img-inline">
                            <span><?php echo $ProfileInfo['name']; ?><i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu profile animated fadeIn">
                            <li>
                                <a href="../index.php?route=security&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Account Security'); ?>">
                                    <i class="fa fa-wrench"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a href="../index.php?route=profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="../index.php?route=support&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <i class="fa fa-info"></i> Support
                                </a>
                            </li>
                            <li class="last">
                                <a href="../logout.php">
                                    <i class="fa fa-lock"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>