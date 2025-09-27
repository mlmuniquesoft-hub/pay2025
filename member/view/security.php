	<div class="modal fade col-xs-12" id="cmpltadminModal-30" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog animated flipInX">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Authenticator Set</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h3 id="Mess"></h3>
					</div>
					<div class="row" id="GHssdd" style="display:none;">
						<div class="col-lg-8 no-pl mt-30">
							<p class="text-success" id="copied" style="display:none;">Copied the text</p>
							<div class="form-group mb-0" >
								<label class="form-label mb-10" style="color:black;">Authenticator Backup Code</label>
								<span class="desc " style="color:black;">(Please Copy This And Keep It Save In Secure Place)</span>
								<div class="input-group primary">
									<span class="input-group-addon">                
									<span class="arrow"></span>
									</span>
									<input type="text" class="form-control" id="WalletAddress" value="">
								</div>
							</div>
						</div>
						<div class="col-lg-4 no-pl mt-30">
							<a href="#" class="btn btn-primary btn-corner" id="CopyAs"><i class="fa fa-copy"></i></a>
						</div>
					</div>
					<div class="form-group">
						<img id="QrImg" style="width:200px;height:200px;"/><br/>
						<p style="color:black;"> Scan This With Your Authenticator Apps </p>
					</div>
					<div class="form-group">
						<label style="color:black;">Authenticator Code</label>
						<input type="text" id="Codesf" class="form-control" placeholder="Authenticator Code" />
					</div>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button class="btn btn-success" id="TuAuthh" type="button">Turn ON</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade col-xs-12" id="TurnnOff" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Authenticator Turn <span class="accDF"></span></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<h3 id="Mess2"></h3>
					</div>
					<div class="form-group">
						<label style="color:black;">Authenticator Backup Code</label>
						<input type="text" id="Codesf2" class="form-control" placeholder="Authenticator Code" />
						<input type="hidden" id="AccF"  />
					</div>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
					<button class="btn btn-danger" id="TuAuthhOf" type="button">Turn <span class="accDF"></span></button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$("#CopyAs").on("click", function(){
			var copyText = $("#WalletAddress");
			copyText.select();
			document.execCommand("copy");
			$("#copied").show();
		});
		$("#TuAuthh").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			const Coodf=$("#Codesf").val();
			const redfgg=$.ajax({
				method:"GET",
				url:"/authenticator/auth.php",
				data:{user:'',code:Coodf,Asd:"Check"}
			});
			redfgg.done((resd)=>{
				let ewer=JSON.parse(resd);
				$("#Mess").text(ewer['mess']);
				$("#GHssdd").show();
				$("#WalletAddress").val(ewer['secrate']);
				if(ewer['sts']==1){
					$("#TurnOn").remove();
				}
				
			});
		});
		$("#TuAuthhOf").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			
			const Coodf=$("#Codesf2").val();
			const AccF=$("#AccF").val();
			const redfgg=$.ajax({
				method:"GET",
				url:"/authenticator/auth.php",
				data:{user:'',code:Coodf,AccF:AccF,Asd:"Off"}
			});
			redfgg.done((resd)=>{
				console.log(resd);
				let ewer=JSON.parse(resd);
				$("#Mess2").text(ewer['mess']);
				if(ewer['sts']==1){
					$(".TurnOff").remove();
				}
				
			});
		});
	</script>
	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-xs-12">
			<div class="page-title">

				<div class="pull-left">
					<!-- PAGE HEADING TAG - START -->
					<h1 class="title">Account Security</h1>
					<!-- PAGE HEADING TAG - END -->
				</div>

				<div class="pull-right hidden-xs">
					<ol class="breadcrumb">
						<li>
							<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
						</li>
						<li class="active" style="color:white;">
							<strong>Account Security</strong>
						</li>
					</ol>
				</div>

			</div>
		</div>
		
		
		
		
		
		<div class="col-xs-12">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Authenticator</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p>You Can Use Google,Microsoft, Or Authy Authenticator to Secure Your Account</p>
							<?php
								$hgfs=mysqli_num_rows($mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$member."'"));
								if($hgfs<1){
							?>
							<button class="btn btn-info" id="TurnOn">Turn ON</button>
							<?php }else{
								$hgfs=mysqli_num_rows($mysqli->query("SELECT * FROM `auth_set` WHERE `user`='".$member."' AND `active`='1'"));
								if($hgfs>0){
							?>
							<button class="btn btn-danger TurnOff"  data-ww="Off" data-toggle="modal" href="#TurnnOff">Turn Off</button>
							<?php  }else{ ?>
							<button class="btn btn-success TurnOff"  data-ww="ON" data-toggle="modal" href="#TurnnOff">Turn On</button>
							<?php } } ?>
							<button class="" style="display:none;" id="Atthenns" data-toggle="modal" href="#cmpltadminModal-30"></button>
							<button class="" style="display:none;" id="AtthennsOF" ></button>
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<script>
			$(".TurnOff").on("click", function(e){
				$(".accDF").text($(this).attr("data-ww"));
				$("#AccF").val($(this).attr("data-ww"));
			});
			$("#TurnOn").on("click", function(e){
				e.preventDefault();
				e.stopPropagation();
				const redfgg=$.ajax({
					method:"GET",
					url:"/authenticator/auth.php",
					data:{user:'<?php echo $member; ?>',Asd:"Set"}
				});
				redfgg.done((resd)=>{
					let ewer=JSON.parse(resd);
					$("#Atthenns").trigger("click");
					$("#QrImg").attr("src",ewer['url']);
					console.log(resd);
				});
			});
		</script>
		<div class="col-xs-12 col-md-6">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Update Login Password</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form id="Profile_pIsv" action="password_action.php" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<?php if(isset($_SESSION['msg'])){ ?>
									<h3 class="alert alert-danger"><?php echo $_SESSION['msg']; ?></h3>
									<?php } ?>
									<?php if(isset($_SESSION['msg1'])){ ?>
									<h3 class="alert alert-success"><?php echo $_SESSION['msg1']; ?></h3>
									<?php } ?>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">Current Password</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="oldPassword" id="oldPassword">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">New Password</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="newPassword1" id="newPassword1">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">Confirm Password</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="newPassword2" id="newPassword2">
									</div>
								</div>
								<input type="hidden" value="<?php echo $actual_link; ?>" name="location" id="location">
								<div class="form-group">
									<button type="submit" class="btn btn-info" >Update Password</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="col-xs-12 col-md-6">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Update Transaction Code</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form id="Profile_pIsv" action="pin_action.php" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<?php if(isset($_SESSION['msg3'])){ ?>
									<h3 class="alert alert-danger"><?php echo $_SESSION['msg3']; ?></h3>
									<?php } ?>
									<?php if(isset($_SESSION['msg4'])){ ?>
									<h3 class="alert alert-success"><?php echo $_SESSION['msg4']; ?></h3>
									<?php } ?>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">Current Code</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="oldPassword" id="oldPassword">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">New Code</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="newPassword1" id="newPassword1">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">Confirm Code</label>
									
									<div class="controls">
										<input type="password" class="form-control" name="newPassword2" id="newPassword2">
										<input type="hidden" value="<?php echo $actual_link; ?>" name="location" id="location">
									</div>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-info" >Update Code</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		
	</div>
	