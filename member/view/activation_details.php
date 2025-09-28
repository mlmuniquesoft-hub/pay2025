	<?php
		$GetPack=explode("/", base64_decode($_GET['paccg']));
		$HJkk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$GetPack[2]."'"));
	?>
	<div class="modal fade col-xs-12" id="TurnnOff" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog animated flipInX" style="max-width: 600px;">
			<div class="modal-content">
				<div class="modal-header" style="background: linear-gradient(135deg, #1E3A8A, #3B82F6); color: white;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
					<h4 class="modal-title">🤖 Activate Trading Robot Package</h4>
				</div>
				<div class="modal-body" style="padding: 30px;">
					<div class="form-group">
						<h3 id="Mess2" style="color: #28a745;"></h3>
					</div>
					
					<!-- Range Selection -->
					<div class="form-group">
						<label style="color: #1f2937; font-weight: bold; margin-bottom: 15px;">📊 Select Investment Amount Range:</label>
						<div class="row">
							<div class="col-md-6">
								<div class="range-card" data-range="starter" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px; margin-bottom: 10px; cursor: pointer; transition: all 0.3s;">
									<div style="text-align: center;">
										<h5 style="color: #059669; margin: 0;">🌱 Basic Range</h5>
										<p style="margin: 5px 0; font-size: 14px; color: #6b7280;">$100 - $999</p>
										<small style="color: #dc2626; font-weight: bold;">0.5% Daily Return</small>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="range-card" data-range="premium" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px; margin-bottom: 10px; cursor: pointer; transition: all 0.3s;">
									<div style="text-align: center;">
										<h5 style="color: #dc2626; margin: 0;">⭐ Premium Range</h5>
										<p style="margin: 5px 0; font-size: 14px; color: #6b7280;">$1000 - $4999</p>
										<small style="color: #dc2626; font-weight: bold;">0.7% Daily Return</small>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="range-card" data-range="vip" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px; margin-bottom: 15px; cursor: pointer; transition: all 0.3s;">
									<div style="text-align: center;">
										<h5 style="color: #7c3aed; margin: 0;">👑 VIP Range</h5>
										<p style="margin: 5px 0; font-size: 14px; color: #6b7280;">$5000+</p>
										<small style="color: #dc2626; font-weight: bold;">1.0% Daily Return</small>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Amount Input -->
					<div class="form-group">
						<label style="color: #1f2937; font-weight: bold;">💰 Enter Investment Amount:</label>
						<div class="input-group">
							<div class="input-group-addon" style="background: #f3f4f6; border: 1px solid #d1d5db;">$</div>
							<input type="number" id="customAmount" class="form-control" placeholder="Enter amount" min="100" style="border: 1px solid #d1d5db;" />
						</div>
						<small id="amountHelper" style="color: #6b7280; font-size: 12px;">Select a range above or enter custom amount (minimum $100)</small>
					</div>

					<!-- Package Summary -->
					<div id="packageSummary" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin: 20px 0; display: none;">
						<h6 style="color: #1f2937; margin-bottom: 10px;">📋 Package Summary:</h6>
						<div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
							<span>Investment Amount:</span>
							<span id="summaryAmount" style="font-weight: bold;">$0</span>
						</div>
						<div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
							<span>Activation Fee:</span>
							<span style="font-weight: bold; color: #dc2626;">$10</span>
						</div>
						<div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
							<span>Daily Return Rate:</span>
							<span id="summaryRate" style="font-weight: bold; color: #059669;">0%</span>
						</div>
						<div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-top: 10px; border-top: 1px solid #e2e8f0;">
							<span style="font-weight: bold;">Total Cost:</span>
							<span id="summaryTotal" style="font-weight: bold; font-size: 18px; color: #dc2626;">$10</span>
						</div>
					</div>

					<div class="form-group">
						<label style="color: #1f2937; font-weight: bold;">🔐 Transaction Code (PIN):</label>
						<input type="password" id="Codesf2" class="form-control" placeholder="Enter your transaction PIN" style="border: 1px solid #d1d5db;" />
					</div>
					<input type="hidden" id="AccF" value="<?php echo $_GET['paccg']; ?>" />
					<input type="hidden" id="selectedAmount" value="0" />
				</div>
				<div class="modal-footer" style="background: #f8fafc;">
					<button data-dismiss="modal" class="btn btn-default" type="button">❌ Cancel</button>
					<button class="btn btn-success" id="TuAuthhOf" type="button" disabled>🚀 Activate Package</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		var invvc;
		
		// Range selection functionality
		$('.range-card').on('click', function() {
			$('.range-card').removeClass('selected').css({
				'border-color': '#e5e7eb',
				'background': 'white'
			});
			
			$(this).addClass('selected').css({
				'border-color': '#3b82f6',
				'background': '#eff6ff'
			});
			
			const range = $(this).data('range');
			let minAmount, maxAmount, rate;
			
			switch(range) {
				case 'starter':
					minAmount = 100;
					maxAmount = 999;
					rate = 0.5;
					$('#customAmount').attr('min', 100).attr('max', 999).attr('placeholder', 'Enter amount ($100 - $999)');
					break;
				case 'premium':
					minAmount = 1000;
					maxAmount = 4999;
					rate = 0.7;
					$('#customAmount').attr('min', 1000).attr('max', 4999).attr('placeholder', 'Enter amount ($1000 - $4999)');
					break;
				case 'vip':
					minAmount = 5000;
					maxAmount = 99999;
					rate = 1.0;
					$('#customAmount').attr('min', 5000).attr('max', 99999).attr('placeholder', 'Enter amount ($5000+)');
					break;
			}
			
			$('#amountHelper').text(`Selected: ${range.toUpperCase()} Range - $${minAmount}${maxAmount < 99999 ? ' - $' + maxAmount : '+'} (${rate}% daily return)`);
		});
		
		// Amount input functionality
		$('#customAmount').on('input', function() {
			const amount = parseFloat($(this).val()) || 0;
			updatePackageSummary(amount);
		});
		
		function updatePackageSummary(amount) {
			if(amount >= 100) {
				let rate;
				if(amount >= 100 && amount <= 999) rate = 0.5;
				else if(amount >= 1000 && amount <= 4999) rate = 0.7;
				else rate = 1.0;
				
				const total = amount + 10;
				
				$('#summaryAmount').text('$' + amount.toLocaleString());
				$('#summaryRate').text(rate + '% Daily');
				$('#summaryTotal').text('$' + total.toLocaleString());
				$('#selectedAmount').val(amount);
				$('#packageSummary').show();
				$('#TuAuthhOf').prop('disabled', false);
			} else {
				$('#packageSummary').hide();
				$('#TuAuthhOf').prop('disabled', true);
			}
		}
		
		$("#TuAuthhOf").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			const Coodf=$("#Codesf2").val();
			const AccF=$("#AccF").val();
			const customAmount = $("#selectedAmount").val();
			
			if(!customAmount || customAmount < 100) {
				$("#Mess2").text("Please select a valid amount (minimum $100)").css("color","#dc2626");
				return;
			}
			
			if(!Coodf) {
				$("#Mess2").text("Please enter your transaction code").css("color","#dc2626");
				return;
			}
			
			$("#TuAuthhOf").text("Processing...").prop('disabled', true);
			
			const redfgg=$.ajax({
				method:"POST",
				url:"viewdata/order_bot.php",
				data:{user:'',code:Coodf,AccF:AccF,Asd:invvc,customAmount:customAmount}
			});
			redfgg.done((resd)=>{
				console.log(resd);
				let ewer=JSON.parse(resd);
				
				if(ewer['sts']==1){
					// Success message with proper styling
					$("#Mess2").html(`
						<div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin: 10px 0; text-align: center;">
							<h4 style="margin: 0 0 10px 0; color: #155724;">✅ Activation Successful!</h4>
							<p style="margin: 0; font-size: 16px; font-weight: bold;">${ewer['mess']}</p>
							<small style="color: #6c757d; font-size: 14px;">Redirecting in 3 seconds...</small>
						</div>
					`);
					
					$(".TurnOff").remove();
					$("#TuAuthhOf").remove();
					$(".Acct").remove();
					
					setTimeout(() => {
						location.reload();
					}, 3000);
				}else{
					// Error message with proper styling
					$("#Mess2").html(`
						<div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin: 10px 0; text-align: center;">
							<h5 style="margin: 0 0 5px 0; color: #721c24;">❌ Activation Failed</h5>
							<p style="margin: 0; font-size: 14px;">${ewer['mess']}</p>
						</div>
					`);
					$("#TuAuthhOf").text("🚀 Activate Package").prop('disabled', false);
				}
			}).fail(() => {
				$("#Mess2").html(`
					<div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin: 10px 0; text-align: center;">
						<h5 style="margin: 0 0 5px 0; color: #721c24;">⚠️ Connection Error</h5>
						<p style="margin: 0; font-size: 14px;">Please check your internet connection and try again.</p>
					</div>
				`);
				$("#TuAuthhOf").text("🚀 Activate Package").prop('disabled', false);
			});
		});
	</script>
	
	<div class="wrapper main-wrapper row" style="min-height:100vh;">

		<div class="col-xs-12">
			<div class="page-title">

				<div class="pull-left">
					<!-- PAGE HEADING TAG - START -->
					<h1 class="title">💰 Capitol Money Pay - Investment Plans <small style="color: #fff; font-size: 14px;">+ $10 Activation Fee</small></h1>
					<!-- PAGE HEADING TAG - END -->
				</div>

				<div class="pull-right hidden-xs">
					<ol class="breadcrumb">
						<li>
							<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title="><i class="fa fa-home"></i>Home</a>
						</li>
						<li class="active" style="color:white;">
							<strong>Investment Package</strong>
						</li>
					</ol>
				</div>

			</div>
		</div>
		<div class="clearfix"></div>
		<!-- MAIN CONTENT AREA STARTS -->
		<div class="col-lg-4">
			<div class="row">
				
				<div class="col-md-12">
					<section class="box has-border-left-3">
						<div class="content-body ">    
							
						   <div class=" mt-30">
								<div class="prof-contain relative">
									<img alt="" src="https://capitolmoneypay.com/assets/images/investment-plans.png" class="img-responsive" style="border-radius: 10px;">
									<span class="prof-check fa fa-check"></span>
								</div>
							</div>
							<div class="uprofile-name">
								<h3>
									<a href="#" style="color: #b2b7c4ff;">Capitol Money Pay Investment</a>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<span class="uprofile-status online"></span>
								</h3>
								<p class="uprofile-title" style="color: #f0f3edff; font-weight: bold;">Flexible Investment Ranges</p>
								<div style="background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #3b82f6; color: #000000;">
									<div style="margin-bottom: 10px; color: #000000;"><strong style="color: #000000;">🌱 Starter:</strong> $100 - $999 <span style="color: #dc2626; float: right;">0.5% Daily</span></div>
									<div style="margin-bottom: 10px; color: #000000;"><strong style="color: #000000;">⭐ Premium:</strong> $1000 - $4999 <span style="color: #dc2626; float: right;">0.7% Daily</span></div>
									<div style="color: #000000;"><strong style="color: #000000;">👑 VIP:</strong> $5000+ <span style="color: #dc2626; float: right;">1.0% Daily</span></div>
								</div>
								<p class="uprofile-title" style="color: #e8ecf0ff; font-weight: bold;">All plans include $10 activation fee</p>
							</div>
							
							<div class="uprofile-buttons">
								<a class="btn btn-md btn-primary Acct" data-toggle="modal" href="#TurnnOff" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border: none;">🚀 Start Investing</a>
							</div>
							<script>
								$(".Acct").on("click", function(){
									invvc=$("#InvoiNumber").text();
								});
							</script>
							
						</div>
					</section>
				</div>
				<div class="col-lg-12">
					<section class="box has-border-left-3">
						<header class="panel_header gradient-blue">
							<h2 class="title pull-left w-text">📈 Investment Opportunities & Returns</h2>
							
						</header>
						<div class="content-body">
							<div class="row">
								<div class="col-xs-12 mt-20">
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">🌱 Basic Range (0.5% Daily)<span class="number"><b class="blue-text">$100 - $999</b></span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:25% !important; background: linear-gradient(to right, #059669, #10b981);"></div>
										</div>
									</div>
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">⭐ Premium Range (0.7% Daily)<span class="number"><b class="blue-text">$1000 - $4999</b></span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:50% !important; background: linear-gradient(to right, #dc2626, #ef4444);"></div>
										</div>
									</div>
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">👑 VIP Range (1.0% Daily)<span class="number"><b class="blue-text">$5000+</b></span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:75% !important; background: linear-gradient(to right, #7c3aed, #8b5cf6);"></div>
										</div>
									</div>
									<div class=" trade-limit mb-0">
										<h6 class="angle-round" style="color:white;">💰 All Plans + $10 Activation<span class="number"><b class="blue-text">Start Today!</b></span></h6>
										<div class="progress progress-cls mb-0">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:100% !important; background: linear-gradient(to right, #f59e0b, #f97316);"></div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>

		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-12">
					<section class="box has-border-left-3">
						<header class="panel_header gradient-blue">
							<h2 class="title pull-left w-text">💼 Investment Package Information</h2>
						</header>                                
						<div class="content-body">    
							<div class="row">
								<div class="form-container mt-20 no-padding-right no-padding-left over-h">
									<div class="table-responsive">
										<table class="table table-bordered" style="background: #fff; color: #333;">
											<thead>
												<tr style="background: #f8f9fa;">
													<th style="width: 40%; font-weight: bold; color: #495057;">Package Details</th>
													<td style="color: #007bff; font-weight: bold;">Flexible Investment Ranges</td>
												</tr>
												<tr style="background: #e8f5e8;">
													<th style="font-weight: bold; color: #495057;">🌱 Basic Range</th>
													<td style="color: #28a745; font-weight: bold;">$100 - $999 (0.5% Daily)</td>
												</tr>
												<tr style="background: #fff3cd;">
													<th style="font-weight: bold; color: #495057;">⭐ Premium Range</th>
													<td style="color: #dc2626; font-weight: bold;">$1000 - $4999 (0.7% Daily)</td>
												</tr>
												<tr style="background: #f3e8ff;">
													<th style="font-weight: bold; color: #495057;">👑 VIP Range</th>
													<td style="color: #7c3aed; font-weight: bold;">$5000+ (1.0% Daily)</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Investment Terms</th>
													<td>Monday to Friday (Weekends Off)</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Return Multiplier</th>
													<td style="color: #17a2b8; font-weight: bold;">2.0x Total Return Target</td>
												</tr>
												<tr style="background: #e3f2fd;">
													<th style="font-weight: bold; color: #495057;">Activation Fee</th>
													<td style="font-weight: bold; color: #dc2626;">$10 (One-time)</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Example: $1000 Investment</th>
													<td>
														<div style="font-size: 14px;">
															<div>💰 Investment: $1000</div>
															<div>📊 Daily Return: $7 (0.7%)</div>
															<div>📅 Weekly: $35 (5 days)</div>
															<div>🎯 Total Target: $2000</div>
															<div style="color: #dc2626; font-weight: bold;">💳 Total Cost: $1010</div>
														</div>
													</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Example: $500 Investment</th>
													<td>
														<div style="font-size: 14px;">
															<div>💰 Investment: $500</div>
															<div>📊 Daily Return: $2.50 (0.5%)</div>
															<div>📅 Weekly: $12.50 (5 days)</div>
															<div>🎯 Total Target: $1000</div>
															<div style="color: #dc2626; font-weight: bold;">💳 Total Cost: $510</div>
														</div>
													</td>
												</tr>
												<tr class="alert alert-info" style="background: #ccd3d6ff; border-color: #3b82f6;">
													<th style="font-weight: bold; color: #1e40af;">📝 How It Works</th>
													<td style="color: #000000;">
														<div style="font-size: 14px;">
															<div style="color: #000000;">1️⃣ Choose your investment amount</div>
															<div style="color: #000000;">2️⃣ Pay $10 activation fee</div>
															<div style="color: #000000;">3️⃣ Earn daily returns Mon-Fri</div>
															<div style="color: #000000;">4️⃣ Reach 2x return target</div>
														</div>
													</td>
												</tr>
												
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
				
			

		<!-- MAIN CONTENT AREA ENDS -->
	</div>