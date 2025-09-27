<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $Adminnb; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="lib/css/select2.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
</head>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
		<?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php //require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-8 col-xs-8">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> New Play Bonus
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg1']; ?></p> 	  	
												<form class="form-horizontal" action="bonusPlay_create_action.php" method="POST">
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Bonus Name:</label>
														<div class="col-sm-9">
															<input type="text" name="bonusName" class="form-control" placeholder="Bonus Name" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Bonus For:</label>
														<div class="col-sm-9">
															<input type="radio" name="bonusFor"  placeholder="Coupon Quantity" value="1" checked />User &nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" name="bonusFor"  placeholder="Coupon Quantity" value="2"/>Sponsor
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Applicable For:</label>
														<div class="col-sm-9">
															<input type="checkbox" name="appliFor[]" class="sdfsd" placeholder="Coupon Quantity" data-show="Packd" data-hide="dfgfd" value="1"  />Activation &nbsp;&nbsp;&nbsp;&nbsp;
															<input type="checkbox" name="appliFor[]" class="sdfsd"  placeholder="Coupon Quantity" data-show="Tradeamn" data-hide="dfgfd" value="2"/>Trading
														</div>
													</div>
													<div class="form-group " style="display:none;" id="Packd">
														<label for="inputEmail3" class="col-sm-3 control-label">Required Package:</label>
														<div class="col-sm-9">
															<?php
																$hjgd=$mysqli->query("SELECT * FROM `package`");
																while($AllPack=mysqli_fetch_assoc($hjgd)){
															?>
															<input type="checkbox" name="packs[]"  placeholder="Coupon Quantity" value="<?php echo $AllPack['serial']; ?>" checked /><?php echo $AllPack['pack']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
															<?php } ?>
														</div>
													</div>
													<div class="form-group " style="display:none;" id="Tradeamn">
														<label for="inputEmail3" class="col-sm-3 control-label">Minimum Amount:</label>
														<div class="col-sm-9">
															<input type="number" name="minimumAmn" class="form-control" placeholder="Minimum Amount" />
														</div>
													</div>
													
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Bonus With:</label>
														<div class="col-sm-9">
															<input type="radio" name="bonusWith"  placeholder="Coupon Quantity" value="1" checked />Fixed Amount &nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" name="bonusWith"  placeholder="Coupon Quantity" value="2"/>Percent Amount
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Game Amount:</label>
														<div class="col-sm-9">
															<input type="number" name="rewardAmn" class="form-control" placeholder="Game Amount" />
														</div>
													</div>
													
													
													
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Transaction Password:</label>
														<div class="col-sm-9">
															<input type="password" name="trPass" class="form-control" placeholder="Transaction Password" />
															<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
														</div>
													</div>
													
													<div class="form-group">
														
														<div class="col-sm-4"></div>
														<div class="col-sm-4">
															<button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: rgb(68, 157, 68);">Submit</button>
														</div>
														<div class="col-sm-4">
															<button type="reset" class="btn btn-danger btn-lg btn-block">Refresh</button>
														</div>
													</div>
												</form>
												<!-- /.form -->
											</div>
											<!-- /.col-lg-12 (nested) -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->
                            </div>
                        </div>
                    </div>
					
					
					<div class="container">
						<div class="row col-md-12 custyle">
						
						<h3 id="finalMess" class="text-center"></h3>
						<div class="table-responsive">
						<table class="table table-striped table-bordered custab">
						<thead>
							<tr>
								<th>Serial</th>
								<th>Bonus Name</th>
								<th>Bonus For</th>
								<th>Applicable For</th>
								<th>Required Package</th>
								<th>Minimum Amount</th>
								<th>Bonus With</th>
								<th>Game Amount</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						
							<?php
								$hhh=$mysqli->query("SELECT * FROM `bunus_play`  ORDER BY `serial` DESC LIMIT 30");
								$n=1;
								while($pascs=mysqli_fetch_assoc($hhh)){
									
							?>
								<tr class="del<?php echo $pascs['serial']; ?>">
									
									<td><?php echo $n++; ?></td>
									<td><?php echo $pascs['bonusName']; ?></td>
									<td>
										<input type="radio" name="bonusFor<?php echo $pascs['serial']; ?>"  placeholder="Coupon Quantity" value="1" <?php if($pascs['bonusFor']==1){echo "checked"; } ?> />User &nbsp;&nbsp;&nbsp;&nbsp;<br/>
										<input type="radio" name="bonusFor<?php echo $pascs['serial']; ?>"  placeholder="Coupon Quantity" value="2" <?php if($pascs['bonusFor']==2){echo "checked"; } ?>/>Sponsor
									</td>
									<td>
										<?php $erte=explode("/", $pascs['appliFor']); ?>
										<input type="checkbox" name="appliFor[]" class="sdfsd2" placeholder="Coupon Quantity" data-show="Packd12" data-hide="dfgfd11" value="1"  <?php if(in_array(1,$erte)){echo "checked"; }?> />Activation &nbsp;&nbsp;&nbsp;&nbsp;<br/>
										<input type="checkbox" name="appliFor[]" class="sdfsd2"  placeholder="Coupon Quantity" data-show="Tradeamn12" data-hide="dfgfd11" value="2" <?php if(in_array(2,$erte)){echo "checked"; }?> />Trading
									</td>
									<td>
										<?php 
										$pasdf=explode("/", $pascs['packs']);
										$dfgdf=$mysqli->query("SELECT * FROM `package`");
										while($pacvb=mysqli_fetch_assoc($dfgdf)){
										?>
										<input type="checkbox" name="appliFor2[]" class="ChangeUser" data-serial="<?php echo $pascs->serial; ?>" data-cols="packs"  placeholder="Coupon Quantity" data-show="Tradeamnw" data-hide="dfgfdw" value="<?php echo $pacvb['serial']; ?>" <?php if(in_array($pacvb['serial'],$pasdf)){echo "checked"; }?> /><?php echo $pacvb['pack']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
										<?php } ?>
									</td>
									<td><input type="number" name="minimumAmn" class="form-control uupp" data-cols="minimumAmn" data-serial="<?php echo $pascs['serial']; ?>" value="<?php echo $pascs['minimumAmn']; ?>" placeholder="Minimum Amount" /></td>
									<td>
										<input type="radio" class="upgg" data-vals="1" data-cols="bonusWith" data-serial="<?php echo $pascs['serial']; ?>" name="bonusWith<?php echo $pascs['serial']; ?>"   value="1" <?php if($pascs['bonusWith']==1){echo "checked"; } ?> />Fixed Amount &nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" class="upgg" data-vals="2" data-cols="bonusWith" data-serial="<?php echo $pascs['serial']; ?>" name="bonusWith<?php echo $pascs['serial']; ?>"   value="2" <?php if($pascs['bonusWith']==2){echo "checked"; } ?>/>Percent Amount
									</td>
									<td><input type="number" name="minimumAmn" class="form-control uupp" data-cols="rewardAmn" data-serial="<?php echo $pascs['serial']; ?>" value="<?php echo $pascs['rewardAmn']; ?>" placeholder="Minimum Amount" /></td>
									<td>
										<div class="form-group has-feedback">
											<label class="input-group upgg" data-vals="1" data-serial="<?php echo $pascs['serial']; ?>" data-cols="active">
												<span class="input-group-addon">
													<input type="radio"  name="test<?php echo $pascs['serial']; ?>" value="1" <?php if($pascs['active']==1){echo "checked"; }?>/>
												</span>
												<div class="form-control form-control-static">
													Active 
												</div>
												<span class="glyphicon form-control-feedback "></span>
											</label>
										</div>
										<div class="form-group has-feedback">
											<label class="input-group upgg" data-vals="0" data-serial="<?php echo $pascs['serial']; ?>" data-cols="active">
												<span class="input-group-addon">
													<input type="radio"  name="test<?php echo $pascs['serial']; ?>" value="0" <?php if($pascs['active']==0){echo "checked"; }?>/>
												</span>
												<div class="form-control form-control-static">
													Inactive 
												</div>
												<span class="glyphicon form-control-feedback "></span>
											</label>
										</div>
									</td>
									
								</tr>
								<?php } ?>
								
						</table>
						</div>
						</div>
					</div>
                </div>
            </div>
        </div>
			<?php 
			require_once('footer.php');
			unset($_SESSION['msg']);
			unset($_SESSION['msg1']);
			
			?>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
            <script>
				$(document).ready(function(){
					$(".ChangeUser").on("click", function(){
						var ttoo=$(this).val();
						var serd=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						
						var resd=$.ajax({
							method:"GET",
							url:"remove_ele.php",
							data:{rets:ttoo,cols:cols, serd:serd,tds:"bunus_play", cvbd:"Change User"}
						});
						resd.done(function(reaas){
							$(".removeOption"+ttoo).hide();
							console.log(reaas);
						});
					});
					$(".upgg").on("click", function(e){
							//e.preventDefault();
							//e.stopPropagation();
							var vals=$(this).attr("data-vals");
							var srl=$(this).attr("data-serial");
							var cols=$(this).attr("data-cols");
							if(vals=="Delete"){
								$(".del"+srl).hide();
							}
							if(vals!=''){
								var reqq=$.ajax({
									method:"GET",
									url: "info_update_action.php",
									data:{vas: vals, sers: srl, coll:cols, tbs:"bunus_play"}
								});
								reqq.done(function(sfds){
									console.log(sfds);
								});
							}
						});
					$(".uupp").on("keyup", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"bunus_play"}
							});
						}
						
					});
					$(".sdfsd").on("click", function(){
						var shg=$(this).attr("data-show");
						var shg22=$(this).attr("data-hide");
						if($(".sdfsd:checked")==true){
							console.log("Checked");
						}else{
							console.log($(this).val());
							
						}
						$("."+shg22).hide();
						$("#"+shg).show();
					});
					$(".ddgg").on("click", function(){
						var $checkboxes = $(' input[type="checkbox"]');
						var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
						//console.log(countCheckedCheckboxes);
						$('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
						var ttt=$(this).val();
						$(".hideall").hide();
						$("#kkj"+ttt).show();
					});
					var srl;
					$(".kjfdghdfj").on("focusin", function(){
						$(".dfgdf").text("");
					});
					$(".SendInvoice").on("click", function(e){
						//e.preventDefault();
						//e.stopPropagation();
						
						srl=$(this).attr("data-serial");
						var cols="user";
						var vals=$("#vall"+srl).val();
						
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "sendBonus_invoice.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"bonus_invoice"}
							});
							reqq.done(function(ress){
								console.log(ress);
								var tt=JSON.parse(ress);
								if(tt[0]==1){
									$("#finalMess").css("color","green");
									$("#finalMess").text(tt[1]);
									$("#del"+srl).hide();
								}else{
									$("#info"+srl).css("color","red");
									$("#info"+srl).text(tt[1]);
								}
							});
						}else{
							$("#info"+srl).css("color","red");
							$("#info"+srl).text("Please Insert User ID");
						}
					});
					
				});
				
			
			</script>
            <script type="text/javascript" src="lib/js/Chart.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
            <script type="text/javascript" src="lib/js/select2.full.min.js"></script>
            <script type="text/javascript" src="lib/js/ace/ace.js"></script>
            <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
            <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
