<div class="page-sidebar fixedscroll" style="background-image:url('image/blockchain.jpg');margin-top: 0px;">

            <!-- MAIN MENU - START -->
			
            <div class="page-sidebar-wrapper crypto" id="main-menu-wrapper" >
				
                <ul class='wraplist' style="margin-top:60px;background:rgba(0, 0, 0, 0.38)">
			
                    <li class='menusection'>Main</li>
                    <li class="">
                        <a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>">
                            <i class="fa fa-dashboard">
                                
                            </i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
					
                    <li class="">
                        <a href="javascript:;">
                             <i class="fa fa-user">
                                
                            </i>
                            <span class="title">Trader Profile</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="index.php?route=profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('User Profile'); ?>">Trader Profile</a>
                            </li>
							<li>
                                <a class="" href="index.php?route=edit_profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Profile Edit'); ?>">Personal Settings</a>
                            </li>
							
                            <li>
                                <a class="" href="index.php?route=security&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Account Security'); ?>">Account Settings</a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="index.php?route=trade_plan&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Trader Plans'); ?>">
                            <i class="fa fa-shopping-cart">
                                
                            </i>
                            <span class="title">Robotic Shop</span>
                        </a>
                    </li>
					<li class="">
                        <a href="https://capitolmoneypay.com/product/" target="blank">
                            <i class="fa fa-shopping-cart">
                                
                            </i>
                            <span class="title">Products</span>
                        </a>
                    </li>
					<li class="">
                        <a href="javascript:;">
                             <i class="fa fa-shopping-cart">
                                
                            </i>
                            <span class="title">Buy Products</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="index.php?route=buynow&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Buy Products'); ?>">Buy Now</a>
                            </li>
							</ul>
                    </li>
					<li class="">
                        <a href="index.php?route=schedule_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Trader Plans'); ?>">
                            <img src="/image/dcrypto.jpg" style="width:30px;height:20px" />
                            <span class="title">Crypto Trading</span>
                        </a>
                    </li>
					
					<?php 
						// PHP 8.2 compatibility: Check variables exist and have valid values
						if(isset($memberInfo) && is_array($memberInfo) && isset($memberInfo['pack']) && $memberInfo['pack'] > 0){ 
							if(isset($member) && function_exists('RemainingReturn') && RemainingReturn($member) > 0){
					?>
					<style>
						.lds-ellipsis {
						  display: inline-block;
						  position: relative;
						  width: 58px;
						  height: 36px;
						  margin-top:-30px;
						}
						.lds-ellipsis div {
						  position: absolute;
						  top: 27px;
						  width: 11px;
						  height: 11px;
						  border-radius: 50%;
						  background: #fff;
						  animation-timing-function: cubic-bezier(0, 1, 1, 0);
						}
						.lds-ellipsis div:nth-child(1) {
						  left: 6px;
						  animation: lds-ellipsis1 0.6s infinite;
						}
						.lds-ellipsis div:nth-child(2) {
						  left: 6px;
						  animation: lds-ellipsis2 0.6s infinite;
						}
						.lds-ellipsis div:nth-child(3) {
						  left: 26px;
						  animation: lds-ellipsis2 0.6s infinite;
						}
						.lds-ellipsis div:nth-child(4) {
						  left: 45px;
						  animation: lds-ellipsis3 0.6s infinite;
						}
						@keyframes lds-ellipsis1 {
						  0% {
							transform: scale(0);
						  }
						  100% {
							transform: scale(1);
						  }
						}
						@keyframes lds-ellipsis3 {
						  0% {
							transform: scale(1);
						  }
						  100% {
							transform: scale(0);
						  }
						}
						@keyframes lds-ellipsis2 {
						  0% {
							transform: translate(0, 0);
						  }
						  100% {
							transform: translate(19px, 0);
						  }
						}

					</style>
                    <li class="">
                        <a href="index.php?route=turbo_bots&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Turbo Bots'); ?>">
                            <i class="fa fa-superpowers">
                                
                            </i>
                            <span class="title">Turbo Bots</span>
							<span class="label label-accent"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></span>
                        </a>
                    </li>
					<?php } } ?>
					<li class="">
                        <a href="javascript:;">
                            <i class="fa fa-share-alt">
                               
                            </i>
                            <span class="title">Networks</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="index.php?route=sponsor_list&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Sponsor Team'); ?>">Sponsor List</a>
                            </li>
                            <li>
                                 <a class="" href="index.php?route=unilevel_view&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Unilevel View'); ?>">Unilevel</a>
                            </li>
                            <li>
                                 <a class="" href="index.php?route=tree_view&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Tree View'); ?>">My Tree</a>
                            </li>
                            
                        </ul>
                    </li>
					<?php
						$MemberIDf=strtolower($_SESSION['roboMember']);
						if($MemberIDf=='kalroys'){
					?>
					<li class="">
                        <a href="javascript:;">
                            <i class="fa fa-share-alt"></i>
                            <span class="title">Team Info</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="index.php?route=member_list&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Member List'); ?>">Member List</a>
                            </li>
                            <li style="display:none;">
                                <a class="" href="index.php?route=member_today&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Member Today'); ?>">Member Today</a>
                            </li>
                            <li style="display:none;">
                                <a class="" href="index.php?route=tree_view&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Tree View'); ?>">My Tree</a>
                            </li>
                        </ul>
                    </li>
					<?php } ?>
					<li class="">
                        <a href="javascript:;">
                            <i class="fa fa-money">
                                
                            </i>
                            <span class="title">Earnings</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a class="" href="index.php?route=sponsor_honor&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Sponsor Honor'); ?>">Sponsor Honor</a>
                            </li>
							
                            <li>
                                <a class="" href="index.php?route=bot_income&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('D.Bot Trading'); ?>">D.Bot Trading</a>
                            </li>
                            <li>
                                <a class="" href="index.php?route=generation_bonus&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Generation Bonus'); ?>">Generation Bonus</a>
                            </li>
                            <?php
								$jkhgfd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as touu FROM `upgrade` WHERE `user`='".$member."'"));
								// PHP 8.2 compatibility: Check for null result
								if($jkhgfd && isset($jkhgfd['touu']) && $jkhgfd['touu']>=3000){
							?>
							 <li>
                                <a class="" href="index.php?route=global_bonus&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Generation Bonus'); ?>">Global Bonus</a>
                            </li>
							<?php } ?>
                        </ul>
                    </li>
					<li class="">
						<a href="javascript:;">
							<i class="fa fa-money">
								
							</i>
							<span class="title">Financial</span>
							<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li>
								<a class="" href="index.php?route=wallet_user&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Add Wallet/User'); ?>">Add Wallet</a>
							</li>
							<li class="">
								<ul class="sub-menu">
									<li>
										<a class="" href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Fund'); ?>">
											<i class="fa fa-bitcoin" style="margin-right: 5px; color: #f7931a;"></i>
											Add Funds
										</a>
									</li>
									<li>
										<a class="" href="index.php?route=deposit_history&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Status'); ?>">
											<i class="fa fa-clock-o" style="margin-right: 5px; color: #ffc107;"></i>
											Pending Status
										</a>
									</li>
								</ul>
							</li>
							<li>
								<a class="" href="index.php?route=withdraw&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Withdraw Fund '); ?>">
									<i class="fa fa-minus-circle" style="margin-right: 5px; color: #dc3545;"></i>
									Withdraw
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=transfer&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Transfer Fund '); ?>">
									<i class="fa fa-exchange" style="margin-right: 5px; color: #6f42c1;"></i>
									Transfer
								</a>
							</li>
							
						</ul>
					</li>					<li class="">
						<a href="javascript:;">
							<i class="fa fa-exchange">
								
							</i>
							<span class="title">Transaction History</span>
							<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<li>
								<a class="" href="index.php?route=deposit_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('All Deposit History'); ?>">
									<i class="fa fa-plus-square" style="margin-right: 5px; color: #28a745;"></i>
									All Deposits
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Manual Deposits'); ?>">
									<i class="fa fa-file-image-o" style="margin-right: 5px; color: #17a2b8;"></i>
									Manual Deposits
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=withdraw_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Withdraw History'); ?>">
									<i class="fa fa-minus-square" style="margin-right: 5px; color: #dc3545;"></i>
									Withdrawals
								</a>
							</li>
							
							<li>
								<a class="" href="index.php?route=transfer_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Transfer History'); ?>">
									<i class="fa fa-arrow-right" style="margin-right: 5px; color: #6f42c1;"></i>
									Transfers
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=activation_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Activation Report'); ?>">
									<i class="fa fa-rocket" style="margin-right: 5px; color: #f59e0b;"></i>
									Activations
								</a>
							</li>
							<li>
								<a class="" href="index.php?route=receive_report&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Receive History'); ?>">
									<i class="fa fa-arrow-left" style="margin-right: 5px; color: #20c997;"></i>
									Received
								</a>
							</li>
						</ul>
					</li>					<li class="">
                        <a href="index.php?route=common_question&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('FAQ'); ?>">
                            <i class="fa fa-linode">
                              
                            </i>
                            <span class="title">Ranks</span>
                        </a>
                    </li>
					<li class="" style="display:none;">
                        <a href="index.php?route=support&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Support Request'); ?>">
                            <i class="fa fa-question-circle">
                               
                            </i>
                            <span class="title">Support</span>
                        </a>
                    </li>
					<li class="">
                        <a href="logout.php">
                            <i class="fa fa-arrow-left" >
                                
                            </i>
                            <span class="title">Logout</span>
                        </a>
                    </li>
					<!-- <li class="GooleTrans" style="">
                        <div id="google_translate_element"></div>
                    </li> -->
					
					
                </ul>
            </div>
            <!-- MAIN MENU - END -->
        </div>
		<style>
			#google_translate_element img{
				width:80px;
			}
			#google_translate_element{
				color:white;
			}
		</style>
		<!-- Temporarily disabled Google Translate to test dropdown functionality
		<script type="text/javascript">
			function googleTranslateElementInit() {
			  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
			}
			</script>
		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		-->