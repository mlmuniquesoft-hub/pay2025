<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
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
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Balance Sheet (B)
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>Name of all Criteria: </th>
																	<th>USD</th>
																</tr>
															</thead>
															<tbody>
																
																
																<tr>
																	<td>Send To Member:</td>
																	<td>$ <?php 
																	$kdfgdf21=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `admin_trans_receive`"));
																	$msdfsd=$kdfgdf21['tolk2'];
																	if($msdfsd>0){
																		echo $msdfsd;
																	}else{
																		echo '0.00';
																	}
																	?></td>
																</tr>
																<tr style="background:#b8ea89e0;">
																	<td>BTC Deposit:</td>
																	<td>$ <?php 
																	$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `req_fund`"));
																	$memberChagre=$kdfgdf2['tolk2'];
																	if($memberChagre>0){
																		echo $memberChagre;
																	}else{
																		echo '0.00';
																	}
																	echo "<br/>";
																	$baseUrl="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
																	$ere=json_decode(file_get_contents($baseUrl));
																	echo "Current Balance: $ ". number_format(RetunExchane("USD",$ere->balance/100000000), 2,'.','');
																	?>
																	
																	</td>
																</tr>
																<tr style="background:#ec7878;color:#FFF;">
																	<td>Total Debt:</td>
																	<td>$ <?php 
																	$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `upgrade`"));
																	$memberBot2=$memberBot*4;
																	if($memberBot2>0){
																		echo $memberBot2;
																	}else{
																		echo '0.00';
																	}
																	?>
																	</td>
																</tr>
																<tr style="background:#dc7bd6;color:#FFF;">
																	<td>Purchase BOT:</td>
																	<td>$ <?php 
																	$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `upgrade`"));
																	$memberBot=$kdfgdf2['tolk2'];
																	if($memberBot>0){
																		echo $memberBot;
																	}else{
																		echo '0.00';
																	}
																	
																	?>
																	</td>
																</tr>
																
																<tr style="background-color: #dc7bd68f;">
																	<td>Total Commission Add:</td>
																	<td>$ <?php 
																	$memberBot22=TtalcOMMISIO('aDMIN');
																	if($memberBot22>0){
																		echo $memberBot22;
																	}else{
																		echo '0.00';
																	}
																	?>
																	</td>
																</tr>
																<tr style="background-color: #e8b449de;">
																	<td>Total Member Balance:</td>
																	<td>$ <?php 
																	$memberBot2212=mysqli_fetch_assoc($mysqli->query("SELECT SUM(final_taka) as tootl1 FROM `balance` "));
																	$hdfgd12=$memberBot2212['tootl1'];
																	if($hdfgd12>0){
																		echo $hdfgd12;
																	}else{
																		echo '0.00';
																	}
																	?>
																	</td>
																</tr>
																<tr style="background-color: #d4cece;">
																	<td>Total Withdraw Pay:</td>
																	<td>$ <?php 
																	$memberBot22=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) as tootl FROM `trans_receive` WHERE `type`='Withdraw' AND `status`='Paid'"));
																	$hdfgd=$memberBot22['tootl'];
																	if($hdfgd>0){
																		echo $hdfgd;
																	}else{
																		echo '0.00';
																	}
																	?>
																	</td>
																</tr>
																<tr style="background-color: #d4cece;">
																	<td>Total Withdraw Pending:</td>
																	<td>$ <?php 
																	$memberBot221=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) as tootl FROM `trans_receive` WHERE `type`='Withdraw' AND `status`='Pending'"));
																	$hdfgd1=$memberBot221['tootl'];
																	if($hdfgd1>0){
																		echo $hdfgd1;
																	}else{
																		echo '0.00';
																	}
																	?>
																	</td>
																</tr>
																
																
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td>Total In Amount:</td>
																	<td>$ <?php 
																	$in=$memberBot; 
																	 if($in>0){
																		 echo $in;
																	 }else{
																		 echo '0.00';
																	 }
																	?></td>
																</tr>
																<tr>
																	<td>Total Out Amount:</td>
																	<td>$ <?php 
																	$out=$deposit+$sponsor+$binary+$genCom+$global; 
																	if($out>0){
																		echo $out;
																	}else{
																		echo '0.00';
																	}
																	?></td>
																</tr>
																<tr>
																	<td>Total Balance</td>
																	<td>$ <?php if($in-$out>0){echo $in-$out;}else{echo '0.00'; } ?></td>
																</tr>
															</tbody>
														</table>
													</div>
													<!-- /.table-responsive -->
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
                </div>
            </div>
        </div>
			<?php require_once'footer.php'?>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
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
