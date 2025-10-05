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
				<?php
					// Check if account is activated (paid = 1 means activated)
					$isActivated = ($memberInfo['paid'] == 1);
					if (!$isActivated) {
				?>
				<div style="background: linear-gradient(45deg, #dc3545, #c82333); padding: 15px; border-radius: 10px; margin-bottom: 15px; text-align: center;">
					<h3 style="color: #fff; margin: 0; font-size: 18px;">⚠️ Account Activation Required</h3>
					<p style="color: #fff; margin: 5px 0; font-size: 14px;">You must activate your account with $10 before purchasing any package</p>
					<a href="index.php?route=activation&tild=<?php echo base64_encode(time()); ?>" class="btn btn-warning btn-lg" style="margin-top: 10px;">Activate Account - $10</a>
				</div>
				<?php } ?>
				<h1 class="title">D.Bot Plans</h1>
				<div style="background: linear-gradient(45deg, #ffc107, #ff9800); padding: 8px 15px; border-radius: 25px; display: inline-block; margin-top: 5px;">
					<span style="color: #000; font-weight: bold; font-size: 14px;">⭐ 0.7% Potential Daily Return Available ⭐</span>
				</div>
				<div style="background: linear-gradient(45deg, #28a745, #20c997); padding: 8px 15px; border-radius: 20px; display: inline-block; margin-top: 5px; margin-left: 10px;">
					<span style="color: #fff; font-weight: bold; font-size: 12px;">💰 Commission: 10%-8%-1% Levels</span>
				</div>
				<!-- PAGE HEADING TAG - END -->
			</div>

			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
					</li>
					<li class="active" style="color:white">
						<strong>D.Bot Trading Plans</strong>
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
						
						<!-- Session Messages Display -->
						<?php if(isset($_SESSION['success'])): ?>
						<div class="alert alert-success alert-dismissible" style="margin-bottom: 20px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-check"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
						</div>
						<?php endif; ?>
						
						<?php if(isset($_SESSION['error'])): ?>
						<div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
						</div>
						<?php endif; ?>
						
						<?php if(isset($_SESSION['info'])): ?>
						<div class="alert alert-info alert-dismissible" style="margin-bottom: 20px;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-info-circle"></i> <?php echo $_SESSION['info']; unset($_SESSION['info']); ?>
						</div>
						<?php endif; ?>

						<!-- start -->

						<div class="pricing-tables">

							<div class="row">
								<?php
									$userPack=$memberInfo['pack'];
									$isActivated = ($memberInfo['paid'] == 1);
									
									// Define the 3 package ranges
									$packageRanges = [
										[
											'tier' => 'BASIC',
											'min_amount' => 100,
											'max_amount' => 999,
											'daily_return' => 0.5,
											'daily_return_text' => 'Upto 0.5%',
											'bg_color' => '#28a745',
											'default_amount' => 500
										],
										[
											'tier' => 'PREMIUM', 
											'min_amount' => 1000,
											'max_amount' => 4999,
											'daily_return' => 0.7,
											'daily_return_text' => 'Upto 0.7%',
											'bg_color' => '#17a2b8',
											'default_amount' => 2500
										],
										[
											'tier' => 'VIP',
											'min_amount' => 5000,
											'max_amount' => 25000,
											'daily_return' => 1.0,
											'daily_return_text' => 'Upto 1%',
											'bg_color' => '#ffc107',
											'default_amount' => 10000
										]
									];
									
									foreach($packageRanges as $index => $package) {
										$tier = $package['tier'];
										$minAmount = $package['min_amount'];
										$maxAmount = $package['max_amount'];
										$dailyReturn = $package['daily_return'];
										$dailyReturnText = $package['daily_return_text'];
										$bgColor = $package['bg_color'];
										$defaultAmount = $package['default_amount'];
										
										$multiplier = 2.0; // All packages have 2.0x multiplier
										$workingDays = 5; // Monday to Friday (Saturday & Sunday off)
										
										// Calculate with default amount for display
										$expectedReturn = $defaultAmount * $multiplier;
										$dailyEarning = ($defaultAmount * $dailyReturn / 100);
										$weeklyEarning = $dailyEarning * $workingDays;
										$monthlyEarning = $weeklyEarning * 4;
										
										// Commission structure info
										$commissionInfo = 'Trading Commission: 8% (Level 1), 1% (Level 2), 1% (Level 3)';
							?>
							<div class="col-sm-6 col-md-4 col-lg-4">
								<div style="background: <?php echo $bgColor; ?>; z-index: 1; margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" class="price-pack">
									<div class="head" style="background: #2c3e50; border-radius: 10px 10px 0 0;">
										<h3 style="color: #fff; margin: 0; padding: 15px;"><?php echo $tier; ?> PACKAGE</h3>
										<h4 style="color: #f39c12; margin: 0; padding: 0 15px 15px;">Range: $<?php echo number_format($minAmount); ?> - $<?php echo number_format($maxAmount); ?></h4>
									</div>
									<a class="TradePic" href="#" data-src="../images/interface.png" data-toggle="modal" data-target="#exampleModalLong">
										<img src="../images/interface.png" style="height: 180px; width: 130px; object-fit: contain; background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 8px; padding: 10px; margin: 10px auto; display: block;" />
									</a>
									<ul class="item-list list-unstyled" style="padding: 0 15px; color: #fff;">
										<li style="margin: 6px 0; font-size: 13px;"><i class="fa fa-robot" style="color: #f39c12;"></i> <strong>D.Bot Trading</strong></li>
										<li style="margin: 6px 0; font-size: 13px;"><i class="fa fa-star" style="color: #f39c12;"></i> <strong>2.0x</strong> Return Multiplier</li>
										<li style="margin: 6px 0; font-size: 13px; background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px;"><i class="fa fa-percentage" style="color: #f39c12;"></i> <strong><?php echo $dailyReturnText; ?></strong> Potential Daily Return</li>
										<?php if($dailyReturn == 0.7): ?>
										<li style="margin: 6px 0; font-size: 12px; color: #ffeb3b; font-weight: bold;"><i class="fa fa-star" style="color: #ffeb3b;"></i> <strong>0.7% Potential Daily Return</strong></li>
										<?php endif; ?>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-calendar-day" style="color: #f39c12;"></i> <strong><?php echo $dailyReturn; ?>%</strong> Daily Return Rate</li>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-calendar-week" style="color: #f39c12;"></i> <strong>Mon-Fri</strong> Trading Days</li>
										<li style="margin: 6px 0; font-size: 12px;"><i class="fa fa-dollar-sign" style="color: #f39c12;"></i> <strong>2.0x</strong> Total Return</li>
										<li style="margin: 6px 0; font-size: 11px; color: #ffeb3b;"><i class="fa fa-clock" style="color: #f39c12;"></i> Sat & Sun Off</li>
										<li style="margin: 6px 0; font-size: 11px;"><i class="fa fa-info-circle" style="color: #f39c12;"></i> Range: $<?php echo number_format($minAmount); ?> - $<?php echo number_format($maxAmount); ?></li>
									</ul>
									
									<?php if($isActivated): ?>
									<!-- Custom Amount Input -->
									<div style="padding: 15px; background: rgba(0,0,0,0.1);">
										<h4 style="color: #fff; margin-bottom: 10px; text-align: center;">Enter Investment Amount:</h4>
										<div class="input-group">
											<span class="input-group-addon">$</span>
											<input type="number" class="form-control investment-amount" min="<?php echo $minAmount; ?>" max="<?php echo $maxAmount; ?>" value="<?php echo $defaultAmount; ?>" placeholder="Enter amount" style="text-align: center; font-weight: bold; font-size: 16px;">
										</div>
										<small style="color: #f39c12; display: block; text-align: center; margin-top: 5px;">Range: $<?php echo number_format($minAmount); ?> - $<?php echo number_format($maxAmount); ?></small>
									</div>
									<?php endif; ?>
									
									<div class="price" style="padding: 15px; background: rgba(0,0,0,0.1); margin: 0;">
										<?php if(!$isActivated): ?>
										<h3 style="color: #dc3545; margin: 0; font-size: 20px;">⚠️ Activation Required</h3>
										<h5 style="color: #ffc107; margin: 5px 0; font-weight: bold;">One-time $10 activation needed</h5>
										<?php else: ?>
										<h3 style="color: #28a745; margin: 0; font-size: 18px;">✅ Account Activated</h3>
										<h5 style="color: #fff; margin: 5px 0; font-weight: bold;" class="package-cost">Package Cost: $<?php echo number_format($defaultAmount); ?></h5>
										<?php endif; ?>
										<small style="color: #f39c12; font-size: 11px;"><?php echo $commissionInfo; ?></small>
									</div>
									<div style="padding: 15px;">
										<?php if(!$isActivated): ?>
										<a href="index.php?route=activation&tild=<?php echo base64_encode(time()); ?>" class="btn btn-lg btn-block btn-danger" style="border-radius: 25px; font-weight: bold;">
											<i class="fa fa-lock"></i> Activate Account First - $10
										</a>
										<?php else: ?>
										<button type="button" class="btn btn-lg btn-block btn-warning invest-now" data-tier="<?php echo $tier; ?>" data-min="<?php echo $minAmount; ?>" data-max="<?php echo $maxAmount; ?>" style="border-radius: 25px; font-weight: bold;">
											<i class="fa fa-arrow-up"></i> Invest Now
										</button>
										<?php endif; ?>
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
	
	// Update package cost when amount changes
	$(".investment-amount").on("input", function(){
		const amount = parseFloat($(this).val()) || 0;
		const packageCost = $(this).closest('.price-pack').find('.package-cost');
		packageCost.html('Package Cost: $' + amount.toLocaleString());
	});
	
	// Handle investment button click
	$(".invest-now").on("click", function(){
		const tier = $(this).attr("data-tier");
		const minAmount = parseInt($(this).attr("data-min"));
		const maxAmount = parseInt($(this).attr("data-max"));
		const amountInput = $(this).closest('.price-pack').find('.investment-amount');
		const amount = parseFloat(amountInput.val()) || 0;
		
		if(amount < minAmount || amount > maxAmount) {
			alert(`Please enter an amount between $${minAmount.toLocaleString()} and $${maxAmount.toLocaleString()} for ${tier} package.`);
			return;
		}
		
		if(amount < 100) {
			alert('Minimum investment amount is $100');
			return;
		}
		
		// Redirect to investment page with custom amount
		const investmentData = {
			tier: tier,
			amount: amount,
			minAmount: minAmount,
			maxAmount: maxAmount
		};
		
		const encodedData = btoa(JSON.stringify(investmentData));
		window.location.href = `index.php?route=investment_confirm&data=${encodedData}&tild=${btoa(Date.now())}`;
	});
</script>