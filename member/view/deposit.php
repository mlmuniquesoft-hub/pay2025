	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-lg-12">
			<section class="box " style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Deposit Wallet addresses</h2>
					
				</header>
				<div class="content-body" style="padding:0;">
					<div class="row">
						<div class="col-md-12">

							<div class="row tabs-area">
								<ul class="nav nav-tabs crypto-wallet-address vertical col-xs-4 col-md-3 left-aligned primary">
									<li class="text-center relative active">
										<a href="#home-5" data-toggle="tab" aria-expanded="true">
											<img src="../data/crypto-dash/coin1.png" class="crypto-i" alt="">
											<h4>Bitcoin</h4>
										</a>
										<div class="check-span"><i class="fa fa-check"></i></div>
									</li>
									
								</ul>
								<?php 
									$hdfd=$mysqli->query("SELECT * FROM `generate_btc` WHERE `user`='".$member."'");
									$inFoAds=mysqli_fetch_assoc($hdfd);
								?>
								<div class="tab-content wallet-address-tab vertical col-xs-12 col-lg-9 left-aligned primary" style="padding-right: 0px;">
									<div class="tab-pane fade active in" id="home-5">
										<div class="row">
											<div class="col-xs-12">
												<div class="option-identity-wrapper mb-15">
													<h3 class="boldy mt-0">BTC Wallet Address</h3>
													<div class="row">
													
														<h3 id="WalletMess"></h3>
														<p class="text-success" id="copied" style="display:none;">Copied the text</p>
														<div class="col-lg-8">
															<div class="form-group mb-0">
																<label class="form-label mb-10">Wallet Address</label>
																<span class="desc ">(You can share it with traders to get Paid)</span>
																<div class="input-group primary">
																	<span class="input-group-addon">                
																	<span class="arrow"></span>
																	<i class="cc BTC-alt"></i>
																	</span>
																	<input type="text" class="form-control" id="WalletAddress" value="<?php echo $inFoAds['btc_address']; ?>">
																</div>
																
															</div>
														</div>
														<div class="col-lg-4 no-pl mt-30">
															<a href="#" class="btn btn-primary btn-corner" id="CopyAs"><i class="fa fa-copy"></i></a>
															<a href="#" class="btn btn-primary btn-corner right15" id="GenerateAddress">Generate New</a>
														</div>
													</div>
												</div>
											</div>
											
											<script src="js/qrcode.min.js"></script>
											<script>
												$("#GenerateAddress").on("click", function(e){
													e.preventDefault();
													e.stopPropagation();
													const redfg=$.ajax({
														method:"GET",
														url:"viewdata/genarate_qq.php",
														data:{generate:"BTC"}
													});
													redfg.done(function(resd){
														const Ashh=JSON.parse(resd);
														$("#WalletMess").text(Ashh['mess']);
														if(Ashh['sts']==1){
															$("#WalletAddress").val(Ashh['addr']);
															$("#WalletMess").css("color", "green");
															new QRCode(document.getElementById("QRCipde"), Ashh['addr']);
														}else{
															$("#WalletMess").css("color", "red");
														}
													});
												});
												
												$(document).ready(function(){
													$("#CopyAs").on("click", function(){
														var copyText = $("#WalletAddress");
														copyText.select();
														document.execCommand("copy");
														$("#copied").show();
													});
													let jkdg=$("#WalletAddress").val();
													if(jkdg!=''){
														new QRCode(document.getElementById("QRCipde"), jkdg);
													}
													
												});
											</script>
											<div class="col-xs-12">
												<div class="option-identity-wrapper no-mb">
													<div class="row">
														<div class="col-xs-11 col-md-4">
															<div class="option-icon" id="QRCipde" >
																
															</div>
														</div>
														<div class="col-md-8">
															<div class="scan-info left15">
																<h3 class="bold">Just scan the wallet address</h3>
																<p>1.Scan This Code</p>
																<p>2.Deposit From Your BTC Wallet</p>
																<?php
																	if(isset($_GET['paccg'])){
																		$packFF=explode("/" , base64_decode($_GET['paccg']));
																		//var_dump($packFF);
																		$cHECKpAK=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$packFF[2]."'"));
																		$cHECKpAKSS=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as Hggd FROM `upgrade` WHERE `user`='".$member."'"));
																		$dfgKKj=remainAmn($member);
																?>
																	<p class="text-warning">3.Your Selected Bot (<?php echo $cHECKpAK['pack']?>)</p>
																	<p class="text-warning">4.Please Deposit Remaining ($<?php echo number_format(($cHECKpAK['pack_amn'] -($dfgKKj+$cHECKpAKSS['Hggd'])), 2, '.',''); ?>)</p>
																<?php } ?>
																<div class="col-lg-12 no-pl mt-10" style="display:none;">
																	<a href="#" class="btn btn-primary btn-corner right15"><i class="fa fa-long-arrow-down complete color-white"></i> Recieve</a>
																	<a href="#" class="btn btn-primary btn-corner right15"><i class="fa fa-long-arrow-up complete color-white"></i> Send</a>
																	<a href="#" class="btn btn-primary btn-corner"><i class="fa fa-gear"></i></a>
																</div>
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- </div>  -->
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<section class="box">
								<header class="panel_header">
									<h2 class="title pull-left">Deposit History</h2>
									
								</header>
								<div class="content-body">
									<div class="row">
										<div class="col-xs-12">

											<div class="table-responsive" id="DepositReport" data-pattern="priority-columns">
												<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
													<thead>
														<tr>
															<th>Crypto Wallet</th>
															<th>Transaction Hash</th>
															<th>Time</th>
															<th>Status</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$InfoDeposit=$mysqli->query("SELECT * FROM `req_fund` WHERE `user`='".$member."'");
															while($allDeposit=mysqli_fetch_assoc($InfoDeposit)){
														?>
														<tr>
															<td>
																<div class="round img2">
																	<img src="../data/crypto-dash/coin1.png" alt="">
																</div>
																<div class="designer-info">
																	<h6>Bitcoin</h6>
																</div>
															</td>
															<td>
																<a class="btn btn-info" target="_blank" href="https://www.blockchain.com/btc/tx/<?php echo $allDeposit['uniq_number']; ?>">
																	<?php echo substr($allDeposit['uniq_number'],0,20); ?>
																</a>
															</td>
															<td><small class="text-muted"><?php echo date("d M-Y H:i:s", strtotime($allDeposit['date'])); ?></small></td>
															<td><span class="badge  w-70 round-success">completed</span></td>
															<td class="green-text boldy">
															 <?php 
															
															//echo ($allDeposit['amount']/100000000); ?> 
															+ $<?php echo number_format($allDeposit['amount']/9803, 2, '.',''); ?>
															
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>

										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</section>
		</div>
		
	</div>
	