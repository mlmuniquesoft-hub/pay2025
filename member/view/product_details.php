	<?php
		$GetPack=explode("/", base64_decode($_GET['paccg']));
		$HJkk=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `product` WHERE `serial`='".$GetPack[2]."'"));
		//var_dump($GetPack);
	?>
	<div class="modal fade col-xs-12" id="TurnnOff" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog animated flipInX">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" style="color:#000;">Buy Product<span class="accDF"></span></h4>
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
					<input type="hidden" id="Qtyre" value="1" />
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
			const Qtyre=$("#Qtyre").val();
			const paytransid=$("#paytransid").val();
			const paywallet=$("#paywallet").val();
			const redfgg=$.ajax({
				method:"POST",
				url:"viewdata/order_product.php",
				data:{user:'',code:Coodf,AccF:AccF,Asd:invvc,pay_wallet:paywallet,pay_trans_id:paytransid,Qtyr:Qtyre}
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
					<h1 class="title">Robo Product Details</h1>
					<!-- PAGE HEADING TAG - END -->
				</div>

				<div class="pull-right hidden-xs">
					<ol class="breadcrumb">
						<li>
							<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title="><i class="fa fa-home"></i>Home</a>
						</li>
						<li class="active" style="color:white;">
							<strong>Robo Product Details</strong>
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
									<img alt="" src="../nzproducts/<?php echo $HJkk['img1']; ?>" class="img-responsive">
									<span class="prof-check fa fa-check"></span>
								</div>
							</div>
							<div class="uprofile-name">
								<h3>
									<a href="#"><?php echo $HJkk['name']; ?></a>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<span class="uprofile-status online"></span>
								</h3>
								
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
				
			</div>
		</div>

		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-12">
					<section class="box has-border-left-3">
						<header class="panel_header gradient-blue">
							<h2 class="title pull-left w-text">Product Order Information</h2>
						</header>                                
						<div class="content-body">    
							<div class="row">
								<div class="form-container mt-20 no-padding-right no-padding-left over-h">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Invoice Number</th>
													<td id="InvoiNumber"><?php echo substr(md5($HJkk['sale_price'].".".time()),0,13); ?></td>
												</tr>
												<tr>
													<th>Product Name</th>
													<td><?php echo $HJkk['name']; ?></td>
												</tr>
												<tr>
													<th>Quantity</th>
													<td>
														<input type="number" id="ProQty" class="form-control" value='1' />
													</td>
												</tr>
												
												<tr>
													<th>Price</th>
													<td>$<span id='ProiPri'><?php echo floor($HJkk['sale_price']); ?></span></td>
												</tr>
												
												<tr class="alert alert-warning" style="font-size:14px;">
													<th>Total Amount</th>
													<td>$<span id="ProiPrice"><?php echo floor($HJkk['sale_price']); ?></span></td>
												</tr>
												<tr class="alert alert-success" style="font-size:14px;">
													<th>Deduct From Shopping Balance</th>
													<td>$<span id="ProiPrice30"><?php echo floor($HJkk['sale_price'])*0.30; ?></span></td>
												</tr>
												<tr class="alert alert-success" style="font-size:14px;">
													<th>Payment :</th>
													<td>$<span id="ProiPrice70"><?php echo floor($HJkk['sale_price'])*0.70; ?></span> Into Below Wallet & input Transaction Id.</td>
												</tr>
												<tr class="alert alert-warning" style="font-size:14px;">
													<th>Wallet :</th>
													<td>bc1qu9pt0ypwmep65jqkrsja7nmm3c247cxw3kcftj</span></td>
												</tr>
												<tr>
													<th>Payment From Wallet :</th>
													<td>
														<input type="text" class="form-control" placeholder="Payment From Wallet" name="paywallet" id="paywallet">
													</td>
												</tr>
												<tr>
													<th>Transaction Id :</th>
													<td>
														<input type="text" class="form-control" placeholder="Input Your Transaction Id" name="paytransid" id="paytransid">
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
	
<script>
	$("#ProQty").on('change', function(){
		const Qty = Number($(this).val());
		const SinglePrice = Number($("#ProiPri").text());
		$("#ProiPrice").text(Qty*SinglePrice);
		$("#ProiPrice30").text(Qty*SinglePrice*0.30);
		$("#ProiPrice70").text(Qty*SinglePrice*0.70);
		$("#Qtyre").val(Qty);
	})
</script>