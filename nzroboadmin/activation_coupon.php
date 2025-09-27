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
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
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
                        <div class="col-sm-6 col-xs-6">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Package
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg1']; ?></p> 	  	
												<form class="form-horizontal" action="activationCoupon_create_action.php" method="POST">
													<div class="form-group">
														<label class="col-sm-4 control-label">Pin For:</label>
														<div class="col-sm-7">
															<input type="radio" name="pinfor" value='0' id="ghdfgdf" class="pinff" data-show="Package" data-hide="Games" checked />Activation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" name="pinfor" value='1' id="fgfdsgt4" class="pinff" data-show="Games" data-hide="Package" />Game Renew &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</div>
													</div>
													<div class="form-group" >
														<label class="col-sm-4 control-label">Select Package:</label>
														<div class="col-sm-7">
															<select class="form-control" name="pack" id="pack">
																<option value="">Select Package</option>
															<?php
																$hwwwhh=$mysqli->query("SELECT * FROM `package` ORDER BY `pack_amn` ASC");
																while($agennt=mysqli_fetch_assoc($hwwwhh)){
															?>
																<option value="<?php echo $agennt['serial']; ?>"><?php echo $agennt['pack'] ."( $". $agennt['pack_amn'] ." )"; ?></option>
															<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group Games" style='display:none;'>
														<label class="col-sm-4 control-label">Select Games Type:</label>
														<div class="col-sm-7" >
															<select class="form-control" name="gamess" id="gamess" >
																<option value="">Select Games Type</option>
															<?php
																$hwwwhh=$mysqli->query("SELECT * FROM `gamesetup` ORDER BY `serial` ASC");
																while($agennt=mysqli_fetch_assoc($hwwwhh)){
															?>
																<option value="<?php echo $agennt['serial']; ?>"><?php echo $agennt['game_type'] ."( $". $agennt['renew_charge'] ." )"; ?></option>
															<?php } ?>
															</select>
														</div>
													</div>
													<div class="Package">
														<div class="form-group">
															<label class="col-sm-4 control-label">Deposit Amount:</label>
															<div class="col-sm-7">
																<input type="number" name="depoamn" id="depoamn" class="form-control" placeholder="Deposit Amount" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-4 control-label">Count In Rank:</label>
															<div class="col-sm-7">
																<input type="radio" name="rankpin" value="1" checked />Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" name="rankpin" value="0" />No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</div>
														</div>
														
														<div class="form-group">
															<label class="col-sm-4 control-label">Special Reffer Condition:</label>
															<div class="col-sm-7">
																<input type="radio" class="RefCond" data-hide="fghdf" data-show="RefAmn" name="refCond" value="1"  />Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" class="RefCond" data-hide="RefAmn" data-show="dfgdf" name="refCond" value="0" checked />No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															</div>
														</div>
														
														<div class="form-group RefAmn" style="display:none;">
															<label class="col-sm-4 control-label">Reffer Amount:</label>
															<div class="col-sm-7">
																<input type="text" name="ReffAmn" id="ReffAmn" class="form-control" placeholder="Reffer Amount" />
															</div>
														</div>
														<div class="form-group" style="margin:10px;">
															<label class="col-sm-4 control-label">Payout This Pin:</label>
															<div class="col-sm-7">
																<input type="radio" name="payAcc" id="payAcc" value="1" checked /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" name="payAcc" id="payAcc" value="0" /> No Payout &nbsp;&nbsp;&nbsp;&nbsp;
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">For Exchanger:</label>
														<div class="col-sm-7">
															<input type="text" name="uufffd" id="uussdd" class="form-control" placeholder="Specific Exchanger ID" />
														</div>
													</div>
													
													
													
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-4 control-label">PIN Quantity:</label>
														<div class="col-sm-7">
															<input type="text" name="pinQQ" class="form-control" placeholder="PIN Quantity" value="1"/>
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-4 control-label">Transaction Password:</label>
														<div class="col-sm-7">
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
						<a class="btn btn-info" href="activationPin_use.php"> View Sold Pin</a>
						<h3 id="finalMess" class="text-center"></h3>
						<div class="table-responsive">
						<table class="table table-striped custab">
						<thead>
						
							<tr>
								<th>Select</th>
								<th>Serial</th>
								<th>Coupon Number</th>
								<th>Package</th>
								<th>Reffer Amount</th>
								<th>Deposit Amount</th>
								<th>PIN Payout</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<form method="POST" id="devel-generate-content-form" action="multiBonuspin_send.php">
									
									<div class="modal fade" id="exampleMoghjgdal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">New message</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			  <div class="form-group">
				<p class="bg-danger text-danger" id="error" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<p class="bg-success text-success" id="succs" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Total Select:</label>
				<input type="text" class="form-control" id="edit-count-checked-checkboxes" name="yyww" readonly />
			  </div> 
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Recipient ID:</label>
				<input type="text" class="form-control" id="recipient-name3" name="uhgf" />
			  </div>
			  <div class="form-group">
				<label for="message-text" class="col-form-label">Transaction Pin:</label>
				<input type="password" class="form-control" id="trnpin3" name="trPin"/>
				<input type="hidden" value="<?php echo $_SERVER['PHP_SELF']; ?>" name="location"/>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" id="fgjfgjfg">Send All</button>
		  </div>
		</div>
	  </div>
	</div>
							<?php
								$hhh=$mysqli->query("SELECT * FROM `invoice_req` WHERE `create_by`='' ORDER BY `serial` DESC LIMIT 30");
								$n=1;
								while($pascs=mysqli_fetch_assoc($hhh)){
									if($pascs['pin_for']==0){
										$erter=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$pascs['pack']."'"));
										$paccv=$erter['pack'];
										$paccv2='';
									}else{
										$uiuy=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `gamesetup` WHERE `serial`='".$pascs['pack']."'"));
										$paccv=$uiuy['game_type'];
										$uiuy2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$pascs['gamepack']."'"));
										$paccv2=$uiuy2['pack'];
									}
							?>
								<tr class="del<?php echo $pascs['serial']; ?>">
									<td>
										<input type="checkbox" class="ddgg" name="bbb<?php echo $pascs['serial']; ?>" value="<?php echo $pascs['serial']; ?>"  />
										<button style="display:none;" id="kkj<?php echo $pascs['serial']; ?>" type="button" class="btn btn-info btn-block hideall" data-toggle="modal" data-target="#exampleMoghjgdal" data-multi='1' data-whatever="" data-sers="<?php echo $pascs['serial']; ?>">Send Pin</button>
									</td>
									<td><?php echo $n++; ?></td>
									<td><?php echo $pascs['invoice_num']; ?></td>
									<td><?php echo $paccv ." ( ".$paccv2." ) "; ?></td>
									<td><?php echo $pascs['ref_amn']; ?></td>
									<td><?php echo $pascs['depoamn']; ?></td>
									<td><?php if($pascs['payAcc']==0){echo "No Payout";}else{echo "Yes";} ?></td>
									<td class="text-center">
										<span id="info<?php echo $pascs['serial']; ?>" class="dfgdf"></span>
										<input type="text" class="kjfdghdfj"  id="vall<?php echo $pascs['serial']; ?>" placeholder="Type User Id">
										<button href="#" class="btn btn-info btn-sm SendInvoice" data-vals="" data-serial="<?php echo $pascs['serial']; ?>"> Send To Exchanger</button>
									</td>
								</tr>
								<?php } ?>
								</form>
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
					$(".RefCond").on("click", function(){
						var tsu=$(this).attr("data-hide");
						var tsu22=$(this).attr("data-show");
						$("."+tsu22).show();
						$("."+tsu).hide();
					});
					$(".pinff").on("click", function(){
						var tdf=$(this).attr("data-show");
						var tdf22=$(this).attr("data-hide");
						$("."+tdf).show(1000);
						$("."+tdf22).hide(3000);
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
						e.preventDefault();
						e.stopPropagation();
						
						srl=$(this).attr("data-serial");
						var cols="create_by";
						var vals=$("#vall"+srl).val();
						
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "sendActive_invoice.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"invoice_req"}
							});
							reqq.done(function(ress){
								console.log(ress);
								var tt=JSON.parse(ress);
								if(tt[0]==1){
									$("#finalMess").css("color","green");
									$("#finalMess").text(tt[1]);
									$(".del"+srl).hide();
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
            <!--<script type="text/javascript" src="lib/js/select2.full.min.js"></script>-->
            <script type="text/javascript" src="lib/js/ace/ace.js"></script>
            <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
            <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
