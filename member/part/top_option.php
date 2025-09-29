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
        <div class='quick-area'>
            <div class='pull-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="sidebar-toggle-wrap">
                        <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                    <li class="topnav-item item1" style="display: none;">
                        <a href="index.php?route=schedule_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Trading Report'); ?>" class="new-link w-text">Schedule
                          <span class="badge badge-primary ml-5">New</span>
                        </a>
                    </li>
                    <li class="topnav-item active item2" style="display: none;">
                        <a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>" class="nav-link w-text">
                          <i class="fa fa-area-chart mr-10"></i>Reports
                        </a>
                    </li>
                    <li class="topnav-item item3" style="display: none;">
                        <a href="index.php?route=trading_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Trading Report'); ?>" class="nav-link w-text">
                          <img src="/image/dcrypto.jpg" style="width:30px;height:20px" />Crypto Trading
                        </a>
                    </li>
                
                    
                    <li class="hidden-sm hidden-xs searchform">
                        <form action="#" method="post">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                                <input type="text" class="form-control animated fadeIn" placeholder="Search & Enter">
                            </div>
                            <input type='submit' value="">
                        </form>
                    </li>
                </ul>
            </div>
            <div class='pull-right'>
				<?php
					$Noerte=$mysqli->query("SELECT * FROM `view` WHERE `user`='".$member."' AND `active`='1' ORDER BY `serial` DESC");
					$NomerNoty=mysqli_num_rows($Noerte);
				?>
                <ul class="info-menu right-links list-inline list-unstyled">
                    <li class="notify-toggle-wrapper spec">
                        <a href="#" data-toggle="dropdown" class="toggle Notify" data-table="view" data-id="NotiCon">
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
                                                    <span class="time small">
														<?php echo date("M d-Y ", strtotime($mydfsIo['date'])); ?>
														<?php echo date(" H:i:s", strtotime($mydfsIo['time'])); ?>
													</span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
									<?php } ?>
                                </ul>

                            </li>

                            <li class="external">
                                <a href="index.php?route=view_notification&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <span>Read All Notifications</span>
                                </a>
                            </li>
                        </ul>
                    </li>
					<script>
						$(".Notify").on("click", function(){
							let fdfgfd=$(this).attr("data-table");
							let ids=$(this).attr("data-id");
							const werwe=$.ajax({
								method:"GET",
								url:"viewdata/UpdateNotify.php",
								data:{acsf:fdfgfd}
							});
							werwe.done((redf)=>{
								$("#"+ids).text(redf);
							})
							
						});
					</script>
                    <li class="message-toggle-wrapper spec" style="display: none;">
						<?php
							$jkdfghd=$mysqli->query("SELECT * FROM `message2` WHERE `user_id`='".$memberInfo['log_user']."' AND `active`='1' ORDER BY `serial` DESC");
							$dfgfd=mysqli_num_rows($jkdfghd);
						?>
                        <a href="#" data-toggle="dropdown" class="toggle " >
                            <i class="fa fa-envelope"></i>
                            <span class="badge badge-accent" id="MesCon"><?php echo $dfgfd; ?></span>
                        </a>
                        <ul class="dropdown-menu messages animated fadeIn">

                            <li class="list" >
								<style>
									.desc p{
										font-size:11px;
									}
								</style>
                                <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                    <?php
										
										while($alMws=mysqli_fetch_assoc($jkdfghd)){
									?>
									<li class="unread status-available">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="/assets/images/cmp-logo.svg" alt="Capitol Money Pay" class="img-circle img-inline" style="height: 40px; width: auto;">
                                            </div>
                                            <div>
                                                <span class="name" >
                                                    <strong>NZ Support Center</strong>
                                                    <span class="time small"></span>
                                                <span class="profile-status available pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    <?php echo $alMws['message']; ?>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
									<?php } ?>
                                </ul>

                            </li>

                            <li class="external">
                                <a href="javascript:;" class="Notify" data-table="message2"  data-id="MesCon">
                                    <span>Read All</span>
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
                                <a href="index.php?route=security&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Account Security'); ?>">
                                    <i class="fa fa-wrench"></i> Settings
                                </a>
                            </li>
                            <li>
                                <a href="index.php?route=profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li style="display: none;">
                                <a href="index.php?route=support&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">
                                    <i class="fa fa-info"></i> Support
                                </a>
                            </li>
                            <li class="last">
                                <a href="logout.php">
                                    <i class="fa fa-lock"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>