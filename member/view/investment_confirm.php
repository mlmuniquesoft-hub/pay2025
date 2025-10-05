<div class="wrapper main-wrapper row" style='min-height:100vh'>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="pull-left">
				<h1 class="title">Investment Confirmation</h1>
				<div style="background: linear-gradient(45deg, #28a745, #20c997); padding: 8px 15px; border-radius: 25px; display: inline-block; margin-top: 5px;">
					<span style="color: #fff; font-weight: bold; font-size: 14px;">💰 Confirm Your Investment</span>
				</div>
			</div>
			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=trade_plan&tild=<?php echo base64_encode(time()); ?>"><i class="fa fa-arrow-left"></i> Back to Plans</a>
					</li>
					<li class="active" style="color:white">
						<strong>Investment Confirmation</strong>
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-lg-8 col-lg-offset-2">
		<?php
			// Check if user is activated
			if($memberInfo['paid'] != 1) {
				echo '<div class="alert alert-danger text-center">';
				echo '<h3>⚠️ Account Not Activated</h3>';
				echo '<p>Please activate your account first with $10 before making any investment.</p>';
				echo '<a href="index.php?route=activation" class="btn btn-warning btn-lg">Activate Account - $10</a>';
				echo '</div>';
				return;
			}
			
			// Get investment data
			$investmentData = null;
			if(isset($_GET['data'])) {
				$investmentData = json_decode(base64_decode($_GET['data']), true);
			}
			
			if(!$investmentData) {
				echo '<div class="alert alert-danger text-center">';
				echo '<h3>❌ Invalid Investment Data</h3>';
				echo '<p>Please go back and select a valid investment package.</p>';
				echo '<a href="index.php?route=trade_plan" class="btn btn-primary">Go Back to Plans</a>';
				echo '</div>';
				return;
			}
			
			$tier = $investmentData['tier'];
			$amount = $investmentData['amount'];
			$minAmount = $investmentData['minAmount'];
			$maxAmount = $investmentData['maxAmount'];
			
			// Validate amount
			if($amount < $minAmount || $amount > $maxAmount) {
				echo '<div class="alert alert-danger text-center">';
				echo '<h3>❌ Invalid Amount</h3>';
				echo '<p>Amount must be between $' . number_format($minAmount) . ' and $' . number_format($maxAmount) . ' for ' . $tier . ' package.</p>';
				echo '<a href="index.php?route=trade_plan" class="btn btn-primary">Go Back to Plans</a>';
				echo '</div>';
				return;
			}
			
			// Calculate returns
			$dailyReturn = 0;
			if($amount >= 100 && $amount <= 999) {
				$dailyReturn = 0.5;
			} elseif($amount >= 1000 && $amount <= 4999) {
				$dailyReturn = 0.7;
			} else {
				$dailyReturn = 1.0;
			}
			
			$multiplier = 2.0;
			$workingDays = 5;
			$expectedReturn = $amount * $multiplier;
			$dailyEarning = ($amount * $dailyReturn / 100);
			$weeklyEarning = $dailyEarning * $workingDays;
			$monthlyEarning = $weeklyEarning * 4;
			
			// Check user balance
			$balanceData = remainAmn22($member);
			$balance = $balanceData['final'] ?? 0;
		?>
		
		<section class="box">
			<div class="content-body">
				<div class="row">
					<div class="col-md-12">
						
						<!-- Investment Summary -->
						<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 30px; margin-bottom: 30px; color: white;">
							<div class="text-center">
								<h2 style="margin-bottom: 20px;">📊 Investment Summary</h2>
								<div class="row">
									<div class="col-md-6">
										<div style="background: rgba(255,255,255,0.1); border-radius: 10px; padding: 20px; margin-bottom: 15px;">
											<h4 style="margin: 0;">Package Tier</h4>
											<h3 style="margin: 5px 0; color: #ffc107;"><?php echo $tier; ?></h3>
										</div>
									</div>
									<div class="col-md-6">
										<div style="background: rgba(255,255,255,0.1); border-radius: 10px; padding: 20px; margin-bottom: 15px;">
											<h4 style="margin: 0;">Investment Amount</h4>
											<h3 style="margin: 5px 0; color: #28a745;">$<?php echo number_format($amount, 2); ?></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Returns Calculation -->
						<div style="background: #f8f9fa; border-radius: 15px; padding: 30px; margin-bottom: 30px;">
							<h3 style="color: #333; text-align: center; margin-bottom: 20px;">💰 Expected Returns</h3>
							<div class="row">
								<div class="col-md-3">
									<div style="background: #28a745; color: white; text-align: center; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
										<h5 style="margin: 0;">Daily Return</h5>
										<h4 style="margin: 5px 0;"><?php echo $dailyReturn; ?>%</h4>
										<p style="margin: 0; font-size: 14px;">$<?php echo number_format($dailyEarning, 2); ?></p>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #17a2b8; color: white; text-align: center; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
										<h5 style="margin: 0;">Weekly Return</h5>
										<h4 style="margin: 5px 0;">Mon-Fri</h4>
										<p style="margin: 0; font-size: 14px;">$<?php echo number_format($weeklyEarning, 2); ?></p>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #ffc107; color: black; text-align: center; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
										<h5 style="margin: 0;">Monthly Est.</h5>
										<h4 style="margin: 5px 0;">4 Weeks</h4>
										<p style="margin: 0; font-size: 14px;">$<?php echo number_format($monthlyEarning, 2); ?></p>
									</div>
								</div>
								<div class="col-md-3">
									<div style="background: #dc3545; color: white; text-align: center; padding: 20px; border-radius: 10px; margin-bottom: 15px;">
										<h5 style="margin: 0;">Total Return</h5>
										<h4 style="margin: 5px 0;">2.0x</h4>
										<p style="margin: 0; font-size: 14px;">$<?php echo number_format($expectedReturn, 2); ?></p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Balance Check -->
						<div style="background: <?php echo $balance >= $amount ? '#d4edda' : '#f8d7da'; ?>; border: 1px solid <?php echo $balance >= $amount ? '#c3e6cb' : '#f5c6cb'; ?>; border-radius: 10px; padding: 20px; margin-bottom: 30px;">
							<div class="row">
								<div class="col-md-6">
									<h4 style="color: #333; margin: 0;">💳 Current Balance</h4>
									<h3 style="color: <?php echo $balance >= $amount ? '#155724' : '#721c24'; ?>; margin: 5px 0;">$<?php echo number_format($balance, 2); ?></h3>
								</div>
								<div class="col-md-6">
									<h4 style="color: #333; margin: 0;">Required Amount</h4>
									<h3 style="color: <?php echo $balance >= $amount ? '#155724' : '#721c24'; ?>; margin: 5px 0;">$<?php echo number_format($amount, 2); ?></h3>
									<?php if($balance >= $amount): ?>
									<p style="color: #155724; margin: 0; font-weight: bold;">✅ Sufficient balance available</p>
									<?php else: ?>
									<p style="color: #721c24; margin: 0; font-weight: bold;">❌ Insufficient balance</p>
									<p style="color: #721c24; margin: 5px 0; font-size: 14px;">Need $<?php echo number_format($amount - $balance, 2); ?> more</p>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
						<!-- Commission Structure -->
						<div style="background: #e3f2fd; border-radius: 10px; padding: 20px; margin-bottom: 30px;">
							<h4 style="color: #1976d2; margin-bottom: 15px; text-align: center;">🏆 Commission Structure</h4>
							<div class="row">
								<div class="col-md-4 text-center">
									<div style="background: #28a745; color: white; padding: 15px; border-radius: 8px;">
										<h5 style="margin: 0;">Level 1</h5>
										<h4 style="margin: 5px 0;">8%</h4>
										<p style="margin: 0; font-size: 12px;">Direct Referrals</p>
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div style="background: #ffc107; color: black; padding: 15px; border-radius: 8px;">
										<h5 style="margin: 0;">Level 2</h5>
										<h4 style="margin: 5px 0;">1%</h4>
										<p style="margin: 0; font-size: 12px;">2nd Level</p>
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div style="background: #17a2b8; color: white; padding: 15px; border-radius: 8px;">
										<h5 style="margin: 0;">Level 3</h5>
										<h4 style="margin: 5px 0;">1%</h4>
										<p style="margin: 0; font-size: 12px;">3rd Level</p>
									</div>
								</div>
							</div>
							<p style="text-align: center; margin: 15px 0 0 0; color: #1976d2; font-weight: bold;">Total: 10% distributed across 3 levels</p>
						</div>
						
						<!-- Confirmation Form -->
						<div style="background: white; border-radius: 15px; padding: 30px; text-align: center;">
							<?php if($balance >= $amount): ?>
							<form action="viewdata/process_investment.php" method="POST" id="investmentForm">
								<input type="hidden" name="tier" value="<?php echo $tier; ?>">
								<input type="hidden" name="amount" value="<?php echo $amount; ?>">
								<input type="hidden" name="user_id" value="<?php echo $member; ?>">
								
								<h3 style="color: #333; margin-bottom: 15px;">🔐 Enter Transaction PIN</h3>
								<div class="form-group" style="max-width: 300px; margin: 0 auto 20px;">
									<input type="password" name="transaction_pin" class="form-control" placeholder="Enter your transaction PIN" required style="text-align: center; font-size: 18px; padding: 15px;">
								</div>
								
								<div style="margin: 20px 0;">
									<button type="submit" class="btn btn-success btn-lg" style="margin-right: 10px; border-radius: 25px; padding: 15px 30px;">
										<i class="fa fa-check"></i> Confirm Investment - $<?php echo number_format($amount, 2); ?>
									</button>
									<a href="index.php?route=trade_plan" class="btn btn-secondary btn-lg" style="border-radius: 25px; padding: 15px 30px;">
										<i class="fa fa-arrow-left"></i> Back to Plans
									</a>
								</div>
								
								<small style="color: #666;">
									By confirming this investment, you agree to our terms and conditions.<br>
									Your investment will start generating returns from the next business day.
								</small>
							</form>
							<?php else: ?>
							<div>
								<h3 style="color: #721c24; margin-bottom: 15px;">❌ Insufficient Balance</h3>
								<p style="color: #721c24; margin-bottom: 20px;">You need $<?php echo number_format($amount - $balance, 2); ?> more to make this investment.</p>
								<a href="index.php?route=deposit" class="btn btn-primary btn-lg" style="margin-right: 10px; border-radius: 25px; padding: 15px 30px;">
									<i class="fa fa-plus"></i> Add Funds
								</a>
								<a href="index.php?route=trade_plan" class="btn btn-secondary btn-lg" style="border-radius: 25px; padding: 15px 30px;">
									<i class="fa fa-arrow-left"></i> Back to Plans
								</a>
							</div>
							<?php endif; ?>
						</div>
						
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#investmentForm').submit(function(e) {
		const pin = $('input[name="transaction_pin"]').val();
		if(pin.length < 4) {
			e.preventDefault();
			alert('Please enter a valid transaction PIN');
			return false;
		}
		
		// Show loading state
		$(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
	});
});
</script>