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
												<form class="form-horizontal" action="bonusCoupon_create_action.php" method="POST">
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Coupon Quantity:</label>
														<div class="col-sm-9">
															<input type="text" name="pinQQ" class="form-control" placeholder="Coupon Quantity" value="1"/>
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
						<a class="btn btn-info" href="bonusPin_use.php"> View Sold Pin</a>
						<h3 id="finalMess" class="text-center"></h3>
						<div class="table-responsive">
						<table class="table table-striped custab">
						<thead>
						
							<tr>
								<th>Serial</th>
								<th>Coupon Number</th>
								<th class="text-center">Receive User</th>
							</tr>
						</thead>
							<?php
								$hhh=$mysqli->query("SELECT * FROM `bonus_invoice` WHERE `user`!='' ORDER BY `serial` DESC LIMIT 30");
								$n=1;
								while($pascs=mysqli_fetch_assoc($hhh)){
							?>
								<tr class="del<?php echo $pascs['serial']; ?>">
									<td><?php echo $n++; ?></td>
									<td><?php echo $pascs['invoice_num']; ?></td>
									<td class="text-center">
										<?php echo $pascs['user']; ?>
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
