<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle" style="color:#000;">D.Bot Image</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="color:#000;">
				<img id="FullPic" src="" style="height: 100%;width: 100%;" />
		  </div>
		  <div class="modal-footer">
			<button type="button" id="closeSS" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

<div class="wrapper main-wrapper row" style='min-height:100vh'>
	<div class="col-xs-12">
		<div class="page-title">

			<div class="pull-left">
				<!-- PAGE HEADING TAG - START -->
				<h1 class="title">D.Bot Plans <small style="color: #fff; font-size: 14px;">+ $10 Membership Fee per upgrade</small></h1>
				<div style="background: linear-gradient(45deg, #ffc107, #ff9800); padding: 8px 15px; border-radius: 25px; display: inline-block; margin-top: 5px;">
					<span style="color: #000; font-weight: bold; font-size: 14px;">⭐ 0.7% Potential Daily Return Available ⭐</span>
				</div>
				<!-- PAGE HEADING TAG - END -->
			</div>

			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
					</li>
					<li class="active" style="color:white">
						<strong>D.Bot Plans (+$10 Membership Fee)</strong>
					</li>
				</ol>
			</div>

		</div>
	</div>
	<div class="clearfix"></div>
	<!-- MAIN CONTENT AREA STARTS -->

	<div class="col-lg-12">
		<section class="box ">
			
			<div class="content-body">
				<div class="row">
					<div class="col-xs-12">

						<!-- start -->

						<div class="pricing-tables">

							<div class="row">
								<?php
									$userPack=$memberInfo['pack'];
									$Pasdf=$mysqli->query("SELECT * FROM `package` WHERE `active`='1' ORDER BY `serial` ASC");
									$packageCount = 0;
									while($allPack=mysqli_fetch_assoc($Pasdf)){
										$packageCount++;
										// Determine package tier and daily return rates
										$tier = '';
										$multiplier = 2.0; // All packages have 2.0x multiplier
										$dailyReturn = 0;
										$workingDays = 5; // Monday to Friday (Saturday & Sunday off)
										
										if($allPack['pack_amn'] >= 100 && $allPack['pack_amn'] <= 999) {
											$tier = 'BASIC';
											$dailyReturn = 0.5;
											$dailyReturnText = 'Upto 0.5%';
											$bgColor = '#28a745';
										} elseif($allPack['pack_amn'] >= 1000 && $allPack['pack_amn'] <= 4999) {
											$tier = 'PREMIUM';
											$dailyReturn = 0.7;
											$dailyReturnText = 'Upto 0.7%';
											$bgColor = '#17a2b8';
										} else {
											$tier = 'VIP';
											$dailyReturn = 1.0;
											$dailyReturnText = 'Upto 1%';
											$bgColor = '#ffc107';
										}
										
										$totalCost = $allPack['pack_amn'] + 10; // Add $10 membership fee
										$expectedReturn = $allPack['pack_amn'] * $multiplier;
										$dailyEarning = ($allPack['pack_amn'] * $dailyReturn / 100);
										$weeklyEarning = $dailyEarning * $workingDays;
										$monthlyEarning = $weeklyEarning * 4;
							?>
							<div class="col-sm-6 col-md-4 col-lg-3">
								<div style="background: <?php echo $bgColor; ?>; z-index: 1; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" class="price-pack <?php if($allPack['serial'] > $userPack){echo 'recommended'; } ?>">
									<div class="head" style="background: #2c3e50; border-radius: 10px 10px 0 0;">
										<h3 style="color: #fff; margin: 0; padding: 15px;"><?php echo $tier; ?> PACKAGE</h3>
										<h4 style="color: #f39c12; margin: 0; padding: 0 15px 15px;">D.Bot $<?php echo number_format($allPack['pack_amn'], 0); ?></h4>
									</div>
									<a class="TradePic" href="#" data-src="../images/interface.png" data-toggle="modal" data-target="#exampleModalLong">
										<img src="../images/interface.png" style="height: 180px; width: 130px; object-fit: contain; background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px; padding: 10px; margin: 10px auto; display: block;" />
									</a>
									<ul class="item-list list-unstyled" style="padding: 0 15px; color: #fff;">
										<li style="margin: 6px 0; font-size: 13px;"><i class="fa fa-robot" style="color: #f39c12;"></i> <strong><?php echo floor($allPack['pack_amn']/100); ?></strong> D.Bot Units</li>
										<li style="margin: 6px 0; font-size: 13px;"><i class="fa fa-star" style="color: #f39c12;"></i> <strong><?php echo number_format($allPack['pack_amn']/10, 1); ?></strong> Trading Scores</li>
										<li style="margin: 6px 0; font-size: 13px;"><i class="fa fa-chart-line" style="color: #f39c12;"></i> <strong>2.0x</strong> Return Multiplier</li>
										<li style="margin: 6px 0; font-size: 13px; background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px;"><i class="fa fa-percentage" style="color: #f39c12;"></i> <strong><?php echo $dailyReturnText; ?></strong> Potential Daily Return</li>
										<?php if($dailyReturn == 0.7): ?>
										<li style="margin: 6px 0; font-size: 12px; color: #ffeb3b; font-weight: bold;"><i class="fa fa-star" style="color: #ffeb3b;"></i> <strong>0.7% Potential Daily Return</strong></li>
										<?php endif; ?>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-calendar-day" style="color: #f39c12;"></i> <strong>$<?php echo number_format($dailyEarning, 2); ?></strong> Daily Earning</li>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-calendar-week" style="color: #f39c12;"></i> <strong>$<?php echo number_format($weeklyEarning, 2); ?></strong> Weekly (Mon-Fri)</li>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-calendar-alt" style="color: #f39c12;"></i> <strong>$<?php echo number_format($monthlyEarning, 2); ?></strong> Monthly Est.</li>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-dollar-sign" style="color: #f39c12;"></i> <strong>$<?php echo number_format($expectedReturn, 0); ?></strong> Total Return</li>
										<li style="margin: 6px 0; font-size: 11px; color: #ffeb3b;"><i class="fa fa-clock" style="color: #f39c12;"></i> Sat & Sun Off</li>
										<?php if(isset($allPack['min_deposit']) && isset($allPack['max_deposit'])): ?>
										<li style="margin: 6px 0; font-size: 11px;"><i class="fa fa-info-circle" style="color: #f39c12;"></i> Range: $<?php echo number_format($allPack['min_deposit'], 0); ?> - $<?php echo number_format($allPack['max_deposit'], 0); ?></li>
										<?php endif; ?>
									</ul>
									<div class="price" style="padding: 15px; background: rgba(0,0,0,0.1); margin: 0;">
										<h3 style="color: #fff; margin: 0; font-size: 24px;"><span class="symbol">$</span><?php echo number_format($allPack['pack_amn'], 0); ?></h3>
										<h5 style="color: #f39c12; margin: 5px 0; font-weight: bold;">+ $10 Membership Fee</h5>
										<h4 style="color: #fff; margin: 5px 0; font-size: 16px;">Total: $<?php echo number_format($totalCost, 0); ?></h4>
									</div>
									<div style="padding: 15px;">
										<button type="button" class="btn btn-lg btn-block <?php if($allPack['serial']<=$userPack){echo 'btn-secondary disabled'; }else{echo 'btn-warning Upgrade';} ?>" data-pack="<?php echo base64_encode(time().'/'.$allPack['serial'].'/D.Bot'.$allPack['pack_amn']); ?>" style="border-radius: 25px; font-weight: bold;">
											<?php if($allPack['serial']<=$userPack){echo '<i class="fa fa-check"></i> Current Plan'; }else{echo '<i class="fa fa-arrow-up"></i> Upgrade Now';} ?>
										</button>
									</div>
								</div>
							</div>
							<?php } ?>							</div>
							<!-- row-->

						</div>
						<!-- end -->

					</div>
				</div>
			</div>
		</section>
	</div>

</div>
<style>
.price-pack {
	transition: all 0.3s ease;
	border: 2px solid transparent;
}
.price-pack:hover {
	transform: translateY(-5px);
	border-color: #f39c12;
	box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.price-pack.recommended {
	border-color: #28a745;
}
.item-list {
	min-height: 220px;
}
.item-list li {
	display: flex;
	align-items: center;
	gap: 8px;
	line-height: 1.4;
}
.btn-block {
	width: 100%;
}
.daily-info {
	background: rgba(255,255,255,0.1);
	border-radius: 5px;
	padding: 8px;
	margin: 8px 0;
	border-left: 3px solid #f39c12;
}
.potential-return {
	background: rgba(255,235,59,0.2);
	border: 1px solid #ffeb3b;
	animation: glow 2s ease-in-out infinite alternate;
}
@keyframes glow {
	from { box-shadow: 0 0 5px rgba(255,235,59,0.5); }
	to { box-shadow: 0 0 15px rgba(255,235,59,0.8); }
}
@media (max-width: 768px) {
	.col-sm-6.col-md-4.col-lg-3 {
		width: 100%;
		margin-bottom: 20px;
	}
	.price-pack {
		max-width: 300px;
		margin: 0 auto;
	}
}
@media (min-width: 769px) and (max-width: 991px) {
	.col-sm-6.col-md-4.col-lg-3 {
		width: 50%;
	}
}
@media (min-width: 992px) and (max-width: 1199px) {
	.col-sm-6.col-md-4.col-lg-3 {
		width: 33.333%;
	}
}
@media (min-width: 1200px) {
	.col-sm-6.col-md-4.col-lg-3 {
		width: 25%;
	}
}
</style>
<script>
	$(".TradePic").on("click", function(){
		let iMsd=$(this).attr("data-src");
		$("#FullPic").attr("src",iMsd);
	});
	$(".Upgrade").on("click", function(){
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
</script>