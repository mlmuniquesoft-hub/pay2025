<div class="wrapper main-wrapper row" style='min-height:100vh'>
	<div class="col-xs-12">
		<div class="page-title">
			<div class="pull-left">
				<!-- PAGE HEADING TAG - START -->
				<h1 class="title">Account Activation</h1>
				<div style="background: linear-gradient(45deg, #dc3545, #c82333); padding: 8px 15px; border-radius: 25px; display: inline-block; margin-top: 5px;">
					<span style="color: #fff; font-weight: bold; font-size: 14px;">🔐 One-Time $10 Activation Required</span>
				</div>
				<!-- PAGE HEADING TAG - END -->
			</div>

			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
					</li>
					<li class="active" style="color:white">
						<strong>Account Activation</strong>
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- MAIN CONTENT AREA STARTS -->

	<div class="col-lg-12">
		
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
		
		<?php if($memberInfo['paid'] == 1): ?>
		<!-- Already Activated -->
		<section class="box has-border-left-3">
			<div class="content-body text-center" style="padding: 50px;">
				<div style="background: linear-gradient(45deg, #28a745, #20c997); padding: 30px; border-radius: 15px;">
					<i class="fa fa-check-circle" style="font-size: 80px; color: #fff; margin-bottom: 20px;"></i>
					<h2 style="color: #fff; margin-bottom: 15px;">✅ Account Already Activated!</h2>
					<p style="color: #fff; font-size: 16px; margin-bottom: 20px;">Your account is fully activated and ready for trading.</p>
					<a href="index.php?route=trade_plan&tild=<?php echo base64_encode(time()); ?>" class="btn btn-warning btn-lg">
						<i class="fa fa-robot"></i> View D.Bot Plans
					</a>
				</div>
			</div>
		</section>
		
		<?php else: ?>
		<!-- Activation Required -->
		<section class="box has-border-left-3">
			<div class="content-body">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						
						<!-- Activation Card -->
						<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
							<div class="text-center">
								<i class="fa fa-unlock-alt" style="font-size: 60px; color: #fff; margin-bottom: 20px;"></i>
								<h2 style="color: #fff; margin-bottom: 15px;">Account Activation Required</h2>
								<p style="color: #fff; font-size: 16px; margin-bottom: 20px;">Activate your account with a one-time $10 fee to start trading and earning commissions.</p>
								
								<div style="background: rgba(255,255,255,0.1); border-radius: 10px; padding: 20px; margin: 20px 0;">
									<h3 style="color: #fff; margin-bottom: 15px;">💰 Activation Benefits</h3>
									<ul style="list-style: none; padding: 0; color: #fff; text-align: left;">
										<li style="margin: 8px 0;"><i class="fa fa-check" style="color: #28a745; margin-right: 10px;"></i> Access to all D.Bot trading packages ($100-$25,000)</li>
										<li style="margin: 8px 0;"><i class="fa fa-check" style="color: #28a745; margin-right: 10px;"></i> Earn $1 commission when you refer someone for activation</li>
										<li style="margin: 8px 0;"><i class="fa fa-check" style="color: #28a745; margin-right: 10px;"></i> Multi-level trading commissions (8%-1%-1%)</li>
										<li style="margin: 8px 0;"><i class="fa fa-check" style="color: #28a745; margin-right: 10px;"></i> Daily trading returns up to 1%</li>
										<li style="margin: 8px 0;"><i class="fa fa-check" style="color: #28a745; margin-right: 10px;"></i> 2.0x return multiplier on all packages</li>
									</ul>
								</div>
								
								<div style="background: rgba(255,255,255,0.1); border-radius: 10px; padding: 20px; margin: 20px 0;">
									<h3 style="color: #fff; margin-bottom: 15px;">💰 Activation Commission</h3>
									<div class="text-center">
										<div style="background: #28a745; border-radius: 8px; padding: 15px; margin: 10px auto; max-width: 200px;">
											<h4 style="color: #fff; margin: 0;">Direct Sponsor</h4>
											<h3 style="color: #fff; margin: 5px 0;">10% = $1</h3>
											<p style="color: #fff; margin: 0; font-size: 12px;">One-time only</p>
										</div>
									</div>
								</div>
								
								<div style="background: rgba(255,255,255,0.1); border-radius: 10px; padding: 20px; margin: 20px 0;">
									<h3 style="color: #fff; margin-bottom: 15px;">🏆 Trading Commission (on deposits)</h3>
									<div class="row">
										<div class="col-md-4">
											<div style="background: #28a745; border-radius: 8px; padding: 15px; margin: 5px;">
												<h4 style="color: #fff; margin: 0;">Level 1</h4>
												<h3 style="color: #fff; margin: 5px 0;">8%</h3>
												<p style="color: #fff; margin: 0; font-size: 12px;">Direct Referrals</p>
											</div>
										</div>
										<div class="col-md-4">
											<div style="background: #ffc107; border-radius: 8px; padding: 15px; margin: 5px;">
												<h4 style="color: #000; margin: 0;">Level 2</h4>
												<h3 style="color: #000; margin: 5px 0;">1%</h3>
												<p style="color: #000; margin: 0; font-size: 12px;">2nd Level</p>
											</div>
										</div>
										<div class="col-md-4">
											<div style="background: #17a2b8; border-radius: 8px; padding: 15px; margin: 5px;">
												<h4 style="color: #fff; margin: 0;">Level 3</h4>
												<h3 style="color: #fff; margin: 5px 0;">1%</h3>
												<p style="color: #fff; margin: 0; font-size: 12px;">3rd Level</p>
											</div>
										</div>
									</div>
									<p style="color: #fff; text-align: center; margin: 10px 0 0 0; font-size: 14px;">Total: 10% distributed across 3 levels</p>
								</div>
								
								<div style="background: rgba(220, 53, 69, 0.2); border: 2px solid #dc3545; border-radius: 10px; padding: 20px; margin: 20px 0;">
									<h3 style="color: #fff; margin-bottom: 15px;">⚠️ Important Notes</h3>
									<ul style="list-style: none; padding: 0; color: #fff; text-align: left; font-size: 14px;">
										<li style="margin: 5px 0;">• One-time activation fee of $10 (required for all new accounts)</li>
										<li style="margin: 5px 0;">• Sponsor gets 10% commission ($1) on your activation</li>
										<li style="margin: 5px 0;">• No additional activation fees for package upgrades</li>
										<li style="margin: 5px 0;">• All trading commissions apply only after activation</li>
									</ul>
								</div>
							</div>
						</div>
						
						<!-- Activation Form -->
						<div style="background: #fff; border-radius: 15px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
							<div class="text-center">
								<h3 style="color: #333; margin-bottom: 20px;">💳 Activate Your Account</h3>
								<div style="background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
									<h2 style="color: #dc3545; margin: 0;">$10.00</h2>
									<p style="color: #666; margin: 5px 0;">One-time activation fee</p>
								</div>
								
								<form action="viewdata/process_activation.php" method="POST" id="activationForm">
									<input type="hidden" name="activation_amount" value="10">
									<input type="hidden" name="user_id" value="<?php echo $member; ?>">
									<input type="hidden" name="payment_method" value="wallet_balance">
									
									<div style="background: #e3f2fd; border-radius: 8px; padding: 20px; margin: 15px 0;">
										<?php 
											$balanceData = remainAmn22($member);
											$balance = $balanceData['final'] ?? 0;
										?>
										<div class="text-center">
											<h4 style="color: #1976d2; margin: 0 0 10px 0;">💰 Account Balance</h4>
											<h2 style="color: #1976d2; margin: 0;">$<?php echo number_format($balance, 2); ?></h2>
											<?php if($balance >= 10): ?>
											<p style="color: #28a745; margin: 10px 0 0 0; font-size: 16px; font-weight: bold;">✅ Sufficient balance available</p>
											<?php else: ?>
											<p style="color: #dc3545; margin: 10px 0 0 0; font-size: 16px; font-weight: bold;">❌ Insufficient balance. Please deposit funds first.</p>
											<?php endif; ?>
										</div>
									</div>
									
									<button type="submit" class="btn btn-success btn-lg btn-block" style="margin-top: 20px; border-radius: 25px;">
										<i class="fa fa-unlock"></i> Activate Account - $10
									</button>
								</form>
								
								<div style="margin-top: 20px;">
									<small style="color: #666;">
										By activating your account, you agree to our terms and conditions.<br>
										Your sponsor will receive a $1 commission upon successful activation.
									</small>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>
	</div>

</div>

<style>
.activation-card {
	transition: all 0.3s ease;
}
.activation-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}
.commission-box {
	transition: all 0.3s ease;
}
.commission-box:hover {
	transform: scale(1.05);
}
</style>

<script>
$(document).ready(function() {
	$('#activationForm').submit(function(e) {
		var balance = <?php echo $balance ?? 0; ?>;
		
		if (balance < 10) {
			e.preventDefault();
			alert('Insufficient balance. Please deposit funds first.');
			return false;
		}
		
		// Show loading state
		$(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
	});
});
</script>