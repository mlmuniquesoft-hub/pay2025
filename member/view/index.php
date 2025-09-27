	<div class="wrapper main-wrapper row" style=''>
		
		<div class='col-xs-12'>
			<div class="page-title" style="background:#d8c8777a">

				<div class="spull-left">
					<!-- PAGE HEADING TAG - START -->
					<marquee scrollamount="5" scrolldelay="100"><h1 class="title" id="Hometitle">NZ Dashboard</h1></marquee>
					<!-- PAGE HEADING TAG - END -->
				</div>

			</div>
		</div>
		<div class="clearfix"></div>
		
		<div class="col-lg-12">
			<section class="box nobox marginBottom0">
				<div class="content-body">
					<div class="row">
					   
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="statistics-box" style="background-color: #193492d9;">
								<div class="mb-15">
									<i class="pull-left ico-icon icon-md icon-info">
										<i class="fa fa-university" aria-hidden="true" style="font-size: 49px;"></i>
									</i>
									<div class="stats">
										<h3 class="boldy mb-5 " style="color:#5bec74!important;font-size: 18px;">$<span id="FinalAmount"></span></h3>
										<span style="font-size: 12px;">Account Balance</span>
									</div>
								</div>
								<span class="crypto1"><canvas width="239" height="60"></canvas></span>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="statistics-box" style="background-color:#193492d9">
								<div class="mb-15">
									<i class="pull-left ico-icon icon-md icon-success">
										<i class="fa fa-arrow-circle-right" style="font-size: 49px;"></i>
									</i>
									<div class="stats">
										<h3 class="boldy mb-5" style="font-size: 18px;">$<span id="TotaoIn"></span></h3>
										<span style="font-size: 12px;">Total Received</span>
									</div>
								</div>
								<span class="crypto2"><canvas width="239" height="60"></canvas></span>

							</div> 
						</div>
						
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="statistics-box" style="background-color:#193492d9">
								<div class="mb-15">
									<i class="pull-left ico-icon icon-md icon-warning">
										<i class="fa fa-arrow-circle-left" style="font-size: 49px;"></i>
									</i>
									<div class="stats">
										<h3 class="boldy mb-5" style="font-size: 18px;">$<span id="TotaoOut"></span></h3>
										<span style="font-size: 12px;">Total Transfered</span>
									</div>
								</div>
								<span class="crypto3"><canvas width="239" height="60"></canvas></span>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="statistics-box" style="background-color:#193492d9">
								<div class="mb-15">
									<i class="pull-left ico-icon icon-md icon-warning">
										<i class="fa fa-arrow-circle-left" style="font-size: 49px;"></i>
									</i>
									<div class="stats">
										<h3 class="boldy mb-5" style="font-size: 18px;">$<span id="shopping"></span></h3>
										<span style="font-size: 12px;">Shopping Balance</span>
									</div>
								</div>
								<span class="crypto1"><canvas width="239" height="60"></canvas></span>
							</div>
						</div>
						<div class="col-lg-3 col-sm-6 col-xs-12">
							<div class="statistics-box" style="background-color:#193492d9">
								<div class="mb-15">
									<i class="pull-left ico-icon icon-md icon-primary">
										<img src="pack_qr/qr-code<?php echo floor($jkfghkd['pack_amn']); ?>.png" class="ico-icon-o" alt="">
									</i>
									<div class="stats">
										<h3 class="boldy mb-5" style="font-size: 14px;"><span id="bOTqTY1" style="color: yellow;"><?php echo $jkfghkd['pack']; ?></span></h3>
										<?php
											if($memberInfo['paid']==1){
												if(RemainingReturn($member)<=0){
													echo "<span style='color: #020202;font-size: 22px;font-weight:bold;padding: 5px 19px;background: #ef7d45;margin-top: 7px;display: block;text-align: center;'>Expired</span>";
												}else{
													echo "<span style='color: #020202;font-size: 22px;font-weight:bold;padding: 5px 19px;background: #2dda1a;margin-top: 7px;display: block;text-align: center;'>Active</span>";
													
												}
												
											}else{
												echo "<span style='color: #020202;font-size: 22px;padding: 5px 19px;background: #b73c0b;margin-top: 7px;display: block;text-align: center;'>Inactive</span>";
											}
										?>
										
									</div>
								</div>
								<span class="crypto4"><canvas width="239" height="60"></canvas></span>
							</div>
						</div>
						
					</div>
					<!-- End .row -->
				</div>
			</section>
		</div>
		<div class="clearfix"></div>

		<div class="col-xs-12 col-md-4">
			<section class="box " style="background-image: url('image/blockchain.jpg');width:100%;height:100%; /*#0f383eed;*/">
				<header class="panel_header">
					<h2 class="title pull-left">ROI Status</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body pb10">
					<div class="row">
						<div class="col-xs-8 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 mb-20">
							<canvas id="donut-chartjs" width="400" height="400"></canvas>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="token-info">
								<div class="info-wrapper three" style="background-color: #1a4bb5;">
									<div class="token-descr">
										<h3 class="bold mt-0 mb-0"><?php echo floor(RemainingReturnPer($member)+RemainingReturnPer($member)*.50);?>%</h3>
										Completed
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="token-info">
								<div class="info-wrapper five" style="background-color: #1a4bb5;">
									<div class="token-descr">
										<h3 class="bold mt-0 mb-0"><?php 
										if($memberInfo['paid']==1){
											echo 400;//RemainingReturn($member);
										}else{
											echo 0;
										}
										?>%</h3>
										Bot Working
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="token-info">
								<div class="info-wrapper two" style="background-color: #1a4bb5;">
									<div class="token-descr">
										<h3 style="font-size: 15px;padding: 6px 0px;" class="bold mt-0 mb-0">$<?php echo TtalIncome($member)+TtalShopping($member); ?></h3>
										<span style="font-size: 13px;">Received</span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-xs-12">
							<div class="token-info">
								<div class="info-wrapper default" style="background-color: #1a4bb5;">
									<div class="token-descr">
										<h3 style="font-size: 15px;padding: 6px 0px;" class="bold mt-0 mb-0">$<?php echo number_format(RemainingReturn($member)-TtalShopping($member),2,'.',''); ?></h3>
										Working....
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-6 col-xs-12">
					<div class="r1_graph1 db_box db_box_large has-shadow2 mt-15" style="background-color: #50497275;">
						<div class="pat-info-wrapper">
							<div class="pat-info text-left">
								<h5 class=''>Total Earning</h5>
								<h6>Complete transactions</h6>
							</div>
							<div class="pat-val relative">
								<h4 class="value blue-text"><i class="complete fa fa-arrow-up"></i><?php 
								$jkhgkfd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_return` ORDER BY `serial` DESC"));
								echo $jkhgkfd['bonus_bal']; ?>%<span>increase By</span></h4>
							</div>
						</div>
						<span class="sparkline15">Loading...</span>
					</div>
				</div>

				<div class="col-lg-6 col-xs-12">
					<section class="box has-border-left-3" style="background-color: #35321ded;">
						<div class="content-body">    
							<div class="uprofile-image " style="margin:0px;">
								<img alt="" src="/member/photo/<?php echo $ProfileInfo['photo']; ?>" class="img-responsive">
							</div>
							<div class="uprofile-name" style="margin: 0 0 15px;font-size:15x;">
								<h3 style="font-size: 20px;margin: 1px 0 -2px;">
									<a href="#"><?php echo strtoupper($memberInfo['user']); ?></a>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<span class="uprofile-status online"></span>
								</h3>
								<p class="uprofile-title" style="margin: 0 0 -11px;font-size: 18px;color: #3cea3c;"><?php
									$kljgk=0;
									if($memberInfo['paid']==1){
										if(RemainingReturn($member)<=0){
											$sdfs=$memberInfo['pack']+1;
											$allPack=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$sdfs."'"));
											echo "<a href='#'class='Upgrade' data-pack='". base64_encode(time()."/".$allPack['serial']."/NZBOT".$allPack['pack_amn']) ."' style='color: #fd6a6a;font-size: 24px;'>Purchase New Bot</a><br/>";
										}else{
											echo "<span style='color: #49f549;font-size: 24px;'>Active Trader</span><br/>";
										}
										$CheckRank=$mysqli->query("SELECT * FROM `ranks` WHERE `user`='".$member."' ORDER BY `serial` DESC");
										$kljgk=mysqli_num_rows($CheckRank);
										if($kljgk>0){
											$InRagf=mysqli_fetch_assoc($CheckRank);
											echo "<span style='color: #d6d854;font-size: 16px;'>". strtoupper($InRagf['rank']) ."</span>";
										}
									}else{
										echo "<span style='color: #d85465;font-size: 24px;'>Inactive Trader</span>";
									}
									
								?> </p>
							</div>
							<div class="uprofile-info" style="margin-bottom: 0px;background: #e8b2b2;">
								<ul class="list-unstyled">
									<li style="color: #1f1e1e;"><i class="fa fa-android"></i> <?php echo $jkfghkd['pack_amn']/100; ?></li>
									<li style="color: #1f1e1e;"><i class="fa fa-shopping-bag"></i> <?php echo $jkfghkd['pack']; ?></li>
									<li style="color: #1f1e1e;"><i class="fa fa-usd"></i> <?php echo $jkfghkd['pack_amn']; ?></li>
								</ul>
							</div>
							<?php if($kljgk>0){
								$date=date("Y-m-d");
							?>
								<div >
									<h3>State Score: <?php  echo StateScore($member,$date);?></h3>
								</div>
							<?php } ?>
							
						</div>
					</section>
				</div>
				<div class="clearfix"></div>
				<div class="col-lg-12">
					<div class="ask-box active" onclick="location.href='index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Fund'); ?>'">
						<div class="ask-circle">
						  <img src="../data/crypto-dash/crypto-buy.png" alt="">
						</div>
						<div class="ask-info">
						  <h3 class="w-text bold">Deposit From Crypto And P2P Directly and Easily</h3>
						  <p class="g2-text mb-0">You Can Add Deposit From Your BTC Wallet Directly Within Short Time</p>
						</div>
						<div class="ask-arrow">
						  <a href="index.php?route=deposit&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Deposit Fund'); ?>"><span class="fa fa-angle-right"></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		
			<div class="col-lg-6">
				<?php 
					$jhgdInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$member."'"));
				?>
				<div class="dotted-wrapper mt-15">
					
					<div class="ref-payout">
						<img src="../data/as.png" alt="">
						<span class="w-text">Share Your Side A </span>
					</div>
					<div class="payout-address mt-30">
						<h3 class="text-warning" style="font-size: 22px;">Collected Score: <?php echo $jhgdInfo['left_score']; ?></h3>
						<h3 class="text-default" style="font-size: 27px;" >Team member: <?php 
						
						$LEftMEM=explode(",", $jhgdInfo['totalLeftId']);
						if($LEftMEM[0]==''){
							echo 0;
						}else{
							echo count($LEftMEM);
						}
						?></h3>
						<p>A Side Link Below:</p>
						<p class="text-warning" id="copied1" style="display:none;">Copied the text</p>
						<div class="input-group primary mb-30">
							
							<input type="text" class="form-control text-left transparent" id="WalletAddress1" value="https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."1/".time()); ?>" aria-describedby="basic-addon1">
							<span class="input-group-addon orange-bg CopyAs" data-ss='1' id="basic-addon1"><span class="arrow"></span><i class="fa fa-copy"></i></span>
						</div>
						<div class="col-md-3 col-lg-3" style="margin:2px;">
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."1/".time()); ?>" class="btn btn-success btn-block" style="color:white;font-size:18px;"><i class="fa fa-facebook"></i> <span > </span></a>
						</div>
						
						<div class="col-md-3 col-lg-3 MemmMobile"  style="margin:2px;">
							<a target="_blank" href="fb-messenger://share/?link=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."1/".time()); ?>" class="btn btn-success btn-block" style="color:white;font-size:18px;"><i class="fa fa-comment-o"></i> <span ></span></a>
						</div>
						
						<div class="col-md-3 col-lg-3" style="margin:2px;">
							<a target="_blank" href="https://twitter.com/home?status=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."1/".time()); ?>" class="btn btn-success btn-block" style="color:white;font-size:18px;"><i class="fa fa-twitter"></i> <span > </span></a>
						</div>
						
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				
				<div class="dotted-wrapper mt-15">
					
					<div class="ref-payout">
						<img src="../data/bs.png" alt="">
						<span class="w-text">Share Your Side B </span>
					</div>
					<div class="payout-address mt-30">
						<h3 class="text-warning" style="font-size: 22px;">Collected Score: <?php echo $jhgdInfo['right_score']; ?></h3>
						<h3 class="text-default" style="font-size: 27px;" >Team member: <?php 
						$RIghtMEM=explode(",", $jhgdInfo['totalrightId']);
						if($RIghtMEM[0]==''){
							echo 0;
						}else{
							echo count($RIghtMEM);
						}
						?></h3>
						<p>B Side Link Below:</p>
						<p class="text-warning" id="copied2" style="display:none;">Copied the text</p>
						<div class="input-group primary mb-30">
							<input type="text" class="form-control text-left transparent" id="WalletAddress2" value="https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."2/".time()); ?>" aria-describedby="basic-addon1">
							<span class="input-group-addon orange-bg CopyAs" data-ss='2' id="basic-addon1"><span class="arrow"></span><i class="fa fa-copy"></i></span>
						</div>
						<div class="col-md-3 col-lg-3" style="margin:2px;">
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."2/".time()); ?>" class="btn btn-warning btn-block" style="color:white;font-size:18px;"><i class="fa fa-facebook"></i> <span > </span></a>
						</div>
						
						<div class="col-md-3 col-lg-3 MemmMobile"  style="margin:2px;">
							<a target="_blank" href="fb-messenger://share/?link=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."2/".time()); ?>" class="btn btn-warning btn-block" style="color:white;font-size:18px;"><i class="fa fa-comment-o"></i> <span ></span></a>
						</div>
						
						<div class="col-md-3 col-lg-3" style="margin:2px;">
							<a target="_blank" href="https://twitter.com/home?status=https://nzrobotrade.com/member/nz-register.php?keys=<?php echo base64_encode(time()."/".$member."/"."2/".time()); ?>" class="btn btn-warning btn-block" style="color:white;font-size:18px;"><i class="fa fa-twitter"></i> <span > </span></a>
						</div>
						
					</div>
				</div>
				
			</div>
			<script>
				$(".CopyAs").on("click", function(){
					let fgdf=$(this).attr("data-ss");
					console.log($("#WalletAddress"+fgdf).val());
					var copyText = $("#WalletAddress"+fgdf);
					copyText.select();
					document.execCommand("copy");
					$("#copied"+fgdf).show();
				});
				
				$(".Upgrade").on("click", function(e){
					e.preventDefault();
					e.stopPropagation();
					const packInfo=$(this).attr("data-pack");
					const redfg=$.ajax({
						method:"POST",
						dataType:'json',
						url:"viewdata/pack_info.php",
						data:{packs:packInfo}
					});
					redfg.done((ress)=>{
						location.href=ress.url;
					});
				});
				
				if ($("#flot-realtime").length) {
					// We use an inline data source in the example, usually data would
					// be fetched from a server

					var rtdata = [],
						totalPoints = 3000;

					function RealTimegetRandomData() {

						if (rtdata.length > 0)
							rtdata = rtdata.slice(1);

						// Do a random walk

						while (rtdata.length < totalPoints) {

							var prev = rtdata.length > 0 ? rtdata[rtdata.length - 1] : 50,
								y = prev + Math.random() * 10 - 5;

							if (y < 0) {
								y = 0;
							} else if (y > 100) {
								y = 100;
							}

							rtdata.push(y);
						}

						// Zip the generated y values with the x values

						var res = [];
						for (var i = 0; i < rtdata.length; ++i) {
							res.push([i, rtdata[i]])
						}

						return res;
					}

					// Set up the control widget

					var updateInterval = 100000;
					$("#updateInterval").val(updateInterval).change(function() {
						var v = $(this).val();
						if (v && !isNaN(+v)) {
							updateInterval = +v;
							if (updateInterval < 1) {
								updateInterval = 1;
							} else if (updateInterval > 20000) {
								updateInterval = 20000;
							}
							$(this).val("" + updateInterval);
						}
					});

					var realplot = $.plot("#flot-realtime", [RealTimegetRandomData()], {
						series: {
							shadowSize: 10 // Drawing is faster without shadows
						},
						yaxis: {
							min: 0,
							max: 10000
						},
						xaxis: {
							show: true
						},
						colors: ["#FFF"],
						grid: {
							tickColor: "#FFF",
							borderWidth: 1,
							borderColor: "#f5efef"
						},
					});

					function realtimeupdate() {

						realplot.setData([RealTimegetRandomData()]);

						// Since the axes don't change, we don't need to call realplot.setupGrid()

						realplot.draw();
						setTimeout(realtimeupdate, updateInterval);
					}

					realtimeupdate();

				}
				
				
				
			</script>
		

		<!-- MAIN CONTENT AREA ENDS -->
	</div>
	<script src="income.js"></script>