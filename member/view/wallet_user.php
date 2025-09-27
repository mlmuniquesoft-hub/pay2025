	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Add Wallet</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form id="Profile_pIsv" action="viewdata/add_wallet.php" method="POST" >
								<div class="form-group">
									<?php if(isset($_SESSION['msg'])){ ?>
									<h3 class="alert alert-danger"><?php echo $_SESSION['msg']; ?></h3>
									<?php } ?>
									<?php if(isset($_SESSION['msg1'])){ ?>
									<h3 class="alert alert-success"><?php echo $_SESSION['msg1']; ?></h3>
									<?php } ?>
								</div>
								<div id="TransOption">
									<div class="form-group">
									<?php
										$i=0;
										$warrt=array("BTC","ETH","LTC");
										$wallrt=array("https://s2.coinmarketcap.com/static/img/coins/32x32/1.png","https://s2.coinmarketcap.com/static/img/coins/32x32/1027.png","https://s2.coinmarketcap.com/static/img/coins/32x32/2.png");
										$wallrt22=array(
											"BTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1.png",
											"ETH"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1027.png",
											"LTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/2.png"
										);
										foreach($wallrt as $wallet){
									?>
										<button style="margin:2px;" class='btn btn-info  WalletType' data-wallet="<?php echo $warrt[$i]; ?>"><img src='<?php echo $wallet; ?>'></button>
									<?php $i++; } ?>
									
								</div>
									<div class="form-group" id="WalletId" style="display:none;">
										<label for="password" id="Wtta">External Wallet ID:</label>
										<input type="text" class="form-control" name="" id="assignTo" placeholder="">
										<span id="errorID" style="color:red;"></span>
									</div>
									
									<div class="form-group">
										<label class="form-label" for="field-2">Transaction Code</label>
										<div class="controls">
											<input type="password" class="form-control" name="TransCode" id="TransCode">
										</div>
									</div>
									<div class="form-group messDf" style="display:none;">
										<h3 class="alert alert-warning" style="color:black;" id="messDf"></h3>
									</div>
									<input type="hidden" value="<?php echo $actual_link; ?>" name="location" id="location">
									<div class="form-group">
										<button type="button" id="TrasnferAvv" class="btn btn-info" >Add Now</button>
										<button type="button" onclick="location.reload()" class="btn btn-danger" >Reset</button>
									</div>
								</div>
								<div id="TransOption2" style="display:none;">
									<div class="form-group messDf2" style="display:none;">
										<h5 class="alert alert-success" style="color:black;" id="messDf2"></h5>
									</div>
									<div class="form-group">
										<label class="form-label" for="field-2">Security Code</label>
										<div class="controls">
											<input type="text" class="form-control" name="secureCode" id="secureCode">
										</div>
									</div>
									<div class="form-group messDf3" style="display:none;">
										<h5 class="alert alert-danger" id="messDf3"></h5>
									</div>
									<div class="form-group">
										<button type="button" id="VerifyStep" class="btn btn-info" >Verify</button>
										<button type="button" onclick="location.reload()" class="btn btn-danger" >Reset</button>
									</div>
								</div>
								<button style="display:none;" id="SffD">Submit</button>
							</form>
						</div>
					</div>
					
				</div>
			</section>
		</div>
	</div>
	<script>
		$("#Profile_pIsv").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
			const assignTo=$("#assignTo").val();
			const Accdf=$(this).attr("action");
			const refdg=$.ajax({
				method:"POST",
				url:Accdf,
				data:{Wallet:Wallet,AssIgnTo:assignTo}
			});
			refdg.done((ggFD)=>{
				console.log(ggFD);
				let ggFD2=JSON.parse(ggFD);
				if(ggFD2[0]==1){
					$("#messDf2").text(ggFD[1]);
					$(".messDf2").show();
					setTimeout(function(){
						location.reload();
					},3000);
				}else{
					$("#messDf3").text(ggFD[1]);
					$(".messDf3").show();
				}
			});
		});
		$("#VerifyStep").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			const secureCode=$("#secureCode").val();
			const erdd=$.ajax({
				method:"GET",
				dataType:"json",
				url:"/login/verify.php",
				data:{secureCode:secureCode,user_id:'<?php echo $member; ?>'}
			});
			erdd.done((redds)=>{
				if(redds.sts==1){
					$("#SffD").trigger("click");
				}else{
					$("#messDf3").text(redds.mess);
					$(".messDf3").show();
				}
			});
		});
		var Wallet;
		$(".WalletType").on("click", function(){
			$(".WalletType").removeClass("btn-info");
			$(".WalletType").removeClass("btn-warning");
			$(".WalletType").addClass("btn-info");
			$(this).addClass("btn-warning");
			Wallet=$(this).attr("data-wallet");
			$("#WalletId").slideDown(1000);
			$("#Wtta").html("External <span class='text-warning'>"+Wallet+"</span> Wallet ID");
		});
	
		$("#TrasnferAvv").on("click",function(e){
			e.preventDefault();
			e.stopPropagation();
			const receiveID=$("#assignTo").val();
			const amount=$("#amount").val();
			const TransCode=$("#TransCode").val();
			console.log(receiveID);
			let rettY=$.ajax({
				method:"GET",
				url:"https://api.blockcypher.com/v1/"+Wallet.toLowerCase()+"/main/addrs/"+receiveID+"/balance",
				dataType:'json',
				statusCode: {
					404: function() {
						resdf=false;
						$("#errorID").text("Invalid "+Wallet+" Wallet ID");
						$("#errorID").parent().addClass("has-error");
					},
					400: function() {
						resdf=false;
						$("#errorID").text("Invalid "+Wallet+" Wallet ID");
						$("#errorID").parent().addClass("has-error");
					}
				  }
			})
			rettY.done((erter)=>{
				const Resdfgg=$.ajax({
					method:"POST",
					dataType:'json',
					url:"viewdata/checkTrans2.php",
					data:{receiveID:receiveID,amount:amount,TransCode:TransCode}
				});
				Resdfgg.done((ress)=>{
					if(ress.sts==1){
						$("#messDf2").text(ress.mess);
						$(".messDf2").show();
						$("#TransOption2").show();
						$("#TransOption").hide();
					}else{
						$("#messDf").text(ress.mess);
						$(".messDf").show();
					}
				});
			});
		});
	</script>
	<section class="box ">
			<header class="panel_header">
				<h2 class="title pull-left">Add Wallet</h2>
				<div class="actions panel_actions pull-right">
					<a class="box_toggle fa fa-chevron-down"></a>
					<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
				</div>
			</header>
			<div class="content-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive" data-pattern="priority-columns">
							<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
								<thead>
									<tr>
										<th>Date</th>
										<th>Wallet Type</th>
										<th>Wallet ID</th>
										<th>Receive Amount</th>
										<th>Use</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$TolkO=$mysqli->query("SELECT * FROM `wallet_address` WHERE `user`='".$member."'");
										while($allToken=mysqli_fetch_assoc($TolkO)){
											
									?>
									<tr>
										<td><?php echo date("d M Y h:i:s A", strtotime($allToken['date'])); ?></td>
										<td>
											<?php echo $allToken['wallet_type']; ?>
										</td>
										<td>
											<img style="width:60px;height:60px;" src='<?php echo $wallrt22[$allToken['wallet_type']]; ?>'>
											<?php echo $allToken['wallet']; ?>
										</td>
										<td>$0.00</td>
										<td>
											<a href='index.php?route=use_wallet&userInfo=<?php echo base64_encode($allToken['serial']); ?>&tokj=<?php echo base64_encode(time()); ?>res=<?php echo base64_encode(date("M d-Y"))?>' class="btn btn-info">Use Now</a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>
		<section>