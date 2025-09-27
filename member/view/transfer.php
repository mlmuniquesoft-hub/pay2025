	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Transfer Fund</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form id="Profile_pIsv" action="transfer_action.php" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<?php if(isset($_SESSION['msg'])){ ?>
									<h3 class="alert alert-danger"><?php echo $_SESSION['msg']; ?></h3>
									<?php } ?>
									<?php if(isset($_SESSION['msg1'])){ ?>
									<h3 class="alert alert-success"><?php echo $_SESSION['msg1']; ?></h3>
									<?php } ?>
								</div>
								<?php 
									$BalanceSts=remainAmn22($member);
									$jhfdd=floor($BalanceSts['final']/50);
									$transable=$jhfdd*50;
									if($transable>$BalanceSts['final']){
										$transable=$BalanceSts['final']-50;
										if($transable<=0){
											$transable=0;
										}
									}
									
								?>
								<div id="TransOption">
									<div class="form-group">
										<label for="password">Transfer Able Amount:</label>
										<input type="text" class="form-control" id="avaislToken" value="$<?php echo $transable; ?>" placeholder="$<?php echo $BalanceSts['final']; ?>" readonly />
										
									</div>
									<div class="form-group">
										<label class="form-label" for="field-2">Receiver ID</label>
										<div class="controls">
											<input type="text" class="form-control" name="receiveID" id="receiveID">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label" for="field-2">Amount</label>
										<div class="controls">
											<input type="text" class="form-control" name="amount" id="amount">
										</div>
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
										<button type="button" id="TrasnferAvv" class="btn btn-info" >Send</button>
										<button type="button" onclick="location.reload()" class="btn btn-danger" >Reset</button>
									</div>
								</div>
								<div id="TransOption2" style="display:none;">
									<div class="form-group messDf2" style="display:none;">
										<h5 style="background: #76af4c;color: #fff;border-radius: 10%;" class="alert alert-success text-center" id="messDf2"></h5>
									</div>
									<div class="form-group">
										<label class="form-label" for="field-2">Security Code</label>
										<div class="controls">
											<input type="text" class="form-control" name="secureCode" id="secureCode">
										</div>
									</div>
									<div class="form-group messDf3" style="display:none;">
										<h3 class="alert alert-danger" id="messDf3"></h3>
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
			const FormDDf=$(this).serialize();
			const Accdf=$(this).attr("action");
			const refdg=$.ajax({
				method:"POST",
				dataType:"json",
				url:Accdf,
				data:FormDDf
			});
			refdg.done((ggFD)=>{
				if(ggFD.sts==1){
					$("#messDf2").text(ggFD.mess);
					$(".messDf2").show();
					setTimeout(function(){
						location.reload();
					},3000);
				}else{
					$("#messDf3").text(ggFD.mess);
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
		$("#TrasnferAvv").on("click",function(e){
			e.preventDefault();
			e.stopPropagation();
			const receiveID=$("#receiveID").val();
			const amount=$("#amount").val();
			const TransCode=$("#TransCode").val();
			
			const Resdfgg=$.ajax({
				method:"POST",
				dataType:'json',
				url:"viewdata/checkTrans.php",
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
	</script>