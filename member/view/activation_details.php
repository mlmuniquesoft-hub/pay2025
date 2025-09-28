	<?php
		$GetPack=explode("/", base64_decode($_GET['paccg']));
		$HJkk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$GetPack[2]."'"));
	?>
	<div class="modal fade col-xs-12" id="TurnnOff" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog animated flipInX">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="color:#000;">Buy Trading Robot<span class="accDF"></span></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h3 id="Mess2"></h3>
					</div>
					<div class="form-group">
						<label style="color:black;">Transaction Code</label>
						<input type="password" id="Codesf2" class="form-control" placeholder="Transaction Code" />
					</div>
					<input type="hidden" id="AccF" value="<?php echo $_GET['paccg']; ?>" />
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
					<button class="btn btn-success" id="TuAuthhOf" type="button">Buy Now</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		var invvc;
		$("#TuAuthhOf").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			const Coodf=$("#Codesf2").val();
			const AccF=$("#AccF").val();
			const redfgg=$.ajax({
				method:"POST",
				url:"viewdata/order_bot.php",
				data:{user:'',code:Coodf,AccF:AccF,Asd:invvc}
			});
			redfgg.done((resd)=>{
				console.log(resd);
				let ewer=JSON.parse(resd);
				$("#Mess2").text(ewer['mess']);
				if(ewer['sts']==1){
					$(".TurnOff").remove();
					$("#TuAuthhOf").remove();
					$(".Acct").remove();
					$("#Mess2").css("color","green");
					$("#Mess2").css("font-weight","bold");
				}else{
					$("#Mess2").css("color","#a91f1f");
				}
				
			});
		});
	</script>
	
	<div class="wrapper main-wrapper row" style="min-height:100vh;">

		<div class="col-xs-12">
			<div class="page-title">

				<div class="pull-left">
					<!-- PAGE HEADING TAG - START -->
					<h1 class="title">D.Bot Package Details <small style="color: #fff; font-size: 14px;">+ $10 Membership Fee</small></h1>
					<!-- PAGE HEADING TAG - END -->
				</div>

				<div class="pull-right hidden-xs">
					<ol class="breadcrumb">
						<li>
							<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title="><i class="fa fa-home"></i>Home</a>
						</li>
						<li class="active" style="color:white;">
							<strong>D.Bot Package Details</strong>
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
									<img alt="" src="package/Dbot<?php echo floor($HJkk['pack_amn']); ?>-241x300.png" class="img-responsive">
									<span class="prof-check fa fa-check"></span>
								</div>
							</div>
							<div class="uprofile-name">
								<h3>
									<a href="#">D.Bot $<?php echo number_format($HJkk['pack_amn'], 0); ?></a>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<span class="uprofile-status online"></span>
								</h3>
								<?php
									$PrevPack=$memberInfo['pack'];
									settype($PrevPack, "integer");
									// Always show $10 membership fee for upgrades
									$membershipFee = 10;
									if($PrevPack < $HJkk['serial']) {
								?>
								<p class="uprofile-title" style="color: #f39c12; font-weight: bold;">Package: $<?php echo number_format($HJkk['pack_amn'], 0); ?> + $10 Membership Fee</p>
								<p class="uprofile-title" style="color: #28a745;">Total Upgrade Cost: $<?php echo number_format($HJkk['pack_amn'] + $membershipFee, 0); ?></p>
								<?php } else { 
									$PrevPackInfo=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$PrevPack."'"));
									if($PrevPackInfo) {
										echo "<p class='uprofile-title'>Current Package: D.Bot $".number_format($PrevPackInfo['pack_amn'], 0)."</p>";
									}
								?>
								<?php } ?>
							</div>
							
							<div class="uprofile-buttons">
								<a class="btn btn-md btn-primary Acct" data-toggle="modal" href="#TurnnOff">Buy Now</a>
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
							<h2 class="title pull-left w-text">Monthly Earning Opportunity</h2>
							
						</header>
						<div class="content-body">
							<div class="row">
								<div class="col-xs-12 mt-20">
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">Expected Deposit Return<span class="number"><b class="blue-text">20%</b> / 400%</span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:20% !important;"></div>
										</div>
									</div>
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">Expected Binary Earning<span class="number"><b class="blue-text">Unlimited (400%)</span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:100% !important;"></div>
										</div>
									</div>
									<div class=" trade-limit">
										<h6 class="angle-round" style="color:white;">Expected Generation Earning<span class="number"><b class="blue-text">Unlimited (400%)</span></h6>
										<div class="progress progress-cls">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:100% !important;"></div>
										</div>
									</div>
									<div class=" trade-limit mb-0">
										<h6 class="angle-round" style="color:white;">Sponsor Earning<span class="number"><b class="blue-text">Unlimited (400%)</span></h6>
										<div class="progress progress-cls mb-0">
										  <div class="progress-bar has-gradient-to-right-bottom" style="width:100% !important;"></div>
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
							<h2 class="title pull-left w-text">Robotic Bot Order Information</h2>
						</header>                                
						<div class="content-body">    
							<div class="row">
								<div class="form-container mt-20 no-padding-right no-padding-left over-h">
									<div class="table-responsive">
										<table class="table table-bordered" style="background: #fff; color: #333;">
											<thead>
												<tr style="background: #f8f9fa;">
													<th style="width: 40%; font-weight: bold; color: #495057;">Invoice Number</th>
													<td style="color: #007bff; font-weight: bold;" id="InvoiNumber"><?php echo substr(md5($HJkk['pack_amn'].".".time()),0,13); ?></td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Package Name</th>
													<td style="color: #28a745; font-weight: bold;">D.Bot $<?php echo number_format($HJkk['pack_amn'], 0); ?></td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Bot Units</th>
													<td><?php echo floor($HJkk['pack_amn'])/100; ?> Units</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Trading Scores</th>
													<td><?php echo number_format($HJkk['pack_amn']/10, 1); ?> Scores</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Return Multiplier</th>
													<td style="color: #17a2b8; font-weight: bold;">2.0x Return Multiplier</td>
												</tr>
												<tr style="background: #e8f5e8;">
													<th style="font-weight: bold; color: #495057;">Potential Daily Return</th>
													<td style="color: #28a745; font-weight: bold;"><?php 
														if($HJkk['pack_amn'] >= 100 && $HJkk['pack_amn'] <= 999) echo "Upto 0.5% Daily";
														elseif($HJkk['pack_amn'] >= 1000 && $HJkk['pack_amn'] <= 4999) echo "Upto 0.7% Daily";
														else echo "Upto 1% Daily";
													?></td>
												</tr>
												<?php if($HJkk['pack_amn'] >= 1000 && $HJkk['pack_amn'] <= 4999): ?>
												<tr style="background: #fff3cd; border: 2px solid #ffc107;">
													<th style="font-weight: bold; color: #856404;">⭐ Featured Return</th>
													<td style="color: #856404; font-weight: bold; font-size: 16px;">0.7% Potential Daily Return</td>
												</tr>
												<?php endif; ?>
												<tr>
													<th style="font-weight: bold; color: #495057;">Daily Earning</th>
													<td style="color: #28a745; font-weight: bold;">$<?php 
														$dailyRate = 0;
														if($HJkk['pack_amn'] >= 100 && $HJkk['pack_amn'] <= 999) $dailyRate = 0.5;
														elseif($HJkk['pack_amn'] >= 1000 && $HJkk['pack_amn'] <= 4999) $dailyRate = 0.7;
														else $dailyRate = 1.0;
														echo number_format($HJkk['pack_amn'] * $dailyRate / 100, 2);
													?> (Mon-Fri)</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Weekly Earning</th>
													<td style="color: #28a745; font-weight: bold;">$<?php 
														echo number_format($HJkk['pack_amn'] * $dailyRate / 100 * 5, 2);
													?> (Sat & Sun Off)</td>
												</tr>
												<tr>
													<th style="font-weight: bold; color: #495057;">Expected Return</th>
													<td style="color: #28a745; font-weight: bold;">$<?php 
														echo number_format($HJkk['pack_amn'] * 2.0, 0);
													?> (Total)</td>
												</tr>
												<tr style="background: #e3f2fd;">
													<th style="font-weight: bold; color: #495057;">Package Price</th>
													<td style="font-weight: bold;">$<?php echo number_format($HJkk['pack_amn'], 0); ?></td>
												</tr>
												<tr style="background: #fff3cd;">
													<th style="font-weight: bold; color: #495057;">Membership Fee</th>
													<td style="color: #856404; font-weight: bold;">$10</td>
												</tr>
												<tr class="alert alert-success" style="font-size:18px; background: #d4edda; border-color: #c3e6cb;">
													<th style="font-weight: bold; color: #155724;">Total Upgrade Cost</th>
													<td style="color: #155724; font-weight: bold; font-size: 20px;">$<?php echo number_format($HJkk['pack_amn'] + 10, 0); ?></td>
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