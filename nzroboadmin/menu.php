<?php
	//session_destroy();
    $memberid = $_SESSION["Admin"];
    $query = "select * from admin where user_id='".$memberid."' ";
    $result=$mysqli->query($query);
    $row= mysqli_fetch_array($result);
?>
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                        <li class="dropdown profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $row["user_id"];?><span class="caret"></span></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li class="profile-img">
                                    <!--<img src="img/profile/picjumbo.com_HNCK4153_resize.jpg" class="profile-img">-->
                                </li>
                                <li>
                                    <div class="profile-info">
                                        <h4 class="username"><?php echo $row["user_id"];?></h4>
                                        <p><?php echo $row["email"];?></p>
                                        <p><?php echo $row['last_login']; ?></p>
                                        <div class="btn-group margin-bottom-2x" role="group">
                                            <a href="profile.php" type="button" class="btn btn-default"><i class="fa fa-user"></i> Profile</a>
                                            <a href="logout.php" type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="side-menu sidebar-inverse" >
                <nav class="navbar navbar-default" role="navigation" style="background-color: #5f5a5a;">
                    <div class="side-menu-container">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="home.php">
                                <div class="icon fa fa-paper-plane"></div>
                                <div class="title"><?php echo $Commn; ?></div>
                            </a>
                            <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                                <i class="fa fa-times icon"></i>
                            </button>
                        </div>
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="home.php">
                                    <span class="icon fa fa-tachometer"></span><span class="title">Home</span>
                                </a>
                            </li>
                            <li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dropdown-element">
                                    <span class="icon fa fa-desktop"></span><span class="title">Profile</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-element" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="profile.php">Update Profile</a>
                                            </li>
                                            <li><a href="profilepassw.php">Profile Password</a>
                                            </li>
                                            <li><a href="trpassw.php">Transaction Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
						<li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dropdown-1element">
                                    <span class="icon fa fa-desktop"></span><span class="title">Company Statement</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-1element" class="panel-collapse collapse">
                                    <div class="panel-body">
                                      <ul class="nav navbar-nav">
                                           <li><a href="dailyinout.php">Daily In Out</a></li>
                                           <li><a href="membertrans.php">Member Transfer Daily</a></li>
                                           <li><a href="member_purchase.php" style="font-weight:bold;font-size:16px;">Member Purchase Daily</a></li>
                                           <li><a href="membertrans2.php">Member Withdraw Daily</a></li>
                                      </ul>
                                    </div>
                                </div>
                            </li>
							<!--<li>
                                <a href="bonus_play.php">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">Bonus Play</span>
                                </a>
                            </li>
							<li>
                                <a href="activation_coupon.php">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">Activation Coupon</span>
                                </a>
                            </li>
							-->
							
                            <li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dropdown-table">
                                    <span class="icon fa fa-table"></span><span class="title">Balance Sheet</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-table" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="total_balance.php">Balance Sheet (A)</a></li>
                                            <li><a href="total_balance2.php">Balance Sheet (B)</a></li>
										
                                        </ul>
                                    </div>
                                </div>
                            </li>
							<li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dr2opdown-table">
                                    <span class="icon fa fa-table"></span><span class="title">Member Balance</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dr2opdown-table" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="transfer_member.php">Transfer To Member</a></li>
                                            <li><a href="transfer_member_report.php">Transfer Report</a></li>
											<li><a href="deduct_mem_balance.php">Balance Deduct From Member</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
							
						<?php
						
							//if($_SESSION['OriginalAdmin']=="superadmin"){
						?>
                            <li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dropdown-tabl">
                                    <span class="icon fa fa-table"></span><span class="title">Member</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-tabl" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="member_all.php">Total Member Summary</a></li>
                                            <li><a href="currentbalnace_list.php?mm=0">Member C.B Summary</a></li>
                                            
                                           <!-- <li><a href="member_play_report.php">Member Board Played Summary</a></li>-->
                                            <li><a href="member_all_today.php">Total Member Today</a></li>
                                           
                                            <li><a href="member_all_acheiver.php">Total Rank Acheivers</a></li>
                                            <!--<li><a href="member_all_duration.php">Total Rank Duration</a></li>-->
                                            <li><a href="member_block.php">Active/Inactive Member</a></li>
											<li><a href="member_edit.php">Member Edit</a></li>
											
											<li><a href="member_withdraw_report.php">Member Withdraw Report</a></li>
											<li><a href="member_transfer_report.php">Member Transfer Report</a></li>
											
                                        </ul>
                                    </div>
                                </div>
                            </li>  
						<li>
							<a href="package.php">
								<span class="icon fa fa-file-text-o"></span><span class="title">Package</span>
							</a>
						</li>
						<li>
							<a href="product.php">
								<span class="icon fa fa-file-text-o"></span><span class="title">Product</span>
							</a>
						</li>
						<li>
							<a href="allproduct.php">
								<span class="icon fa fa-file-text-o"></span><span class="title">All Products</span>
							</a>
						</li>
						<li>
							<a href="payment.php">
								<span class="icon fa fa-file-text-o"></span><span class="title">Payment</span>
							</a>
						</li>
						
						<li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#dropdown-manual-deposits">
                                    <span class="icon fa fa-coins"></span><span class="title">Manual Deposits</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-manual-deposits" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="manual_deposits_verify.php">
                                                <i class="fa fa-eye"></i> Verify Deposits
                                                <?php 
                                                    // Show pending count badge
                                                    $pending_count = $mysqli->query("SELECT COUNT(*) as count FROM manual_deposits WHERE status = 'pending'")->fetch_assoc()['count'] ?? 0;
                                                    if($pending_count > 0) {
                                                        echo '<span class="badge" style="background: #ff6b6b; color: white; margin-left: 5px;">'.$pending_count.'</span>';
                                                    }
                                                ?>
                                            </a></li>
                                            <li><a href="manage_wallets.php">
                                                <i class="fa fa-wallet"></i> Manage Wallets
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
						
						<li>
							<a href="send_message.php">
								<span class="icon fa fa-file-text-o"></span><span class="title">Send Message</span>
							</a>
						</li>
						
						
						<li>
                                <a href="offer_create.php">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">Create Offer</span>
                                </a>
                            </li>
							
												
						
						
							<li>
                                <a href="announcements.php">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">Announcements</span>
                                </a>
                            </li>
							<li>
                                <a href="promotion.php">
                                    <span class="icon fa fa-file-text-o"></span><span class="title">Promotion</span>
                                </a>
                            </li>
							<?php //} ?>
							
							<li class="panel panel-default dropdown">
                                <a data-toggle="collapse" href="#Games1">
                                    <span class="icon fa fa-table"></span><span class="title">Support</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="Games1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li><a href="inquiry.php">Inquiry</a>
                                            </li>
                                            <li><a href="problem.php">Problem</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
							<li>
								<a href="logout.php">
                                    <span class="icon fa fa-thumbs-o-up"></span><span class="title">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>