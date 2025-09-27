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
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Balance Sheet (A)
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
																	<td>Purchase BOT:</td>
																	<td>$ <?php 
																	$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk2 FROM `upgrade`"));
																	$memberBot=$kdfgdf2['tolk2'];
																	if($memberBot>0){
																		echo $memberBot;
																	}else{
																		echo '0.00';
																	}
																	
																	?></td>
																</tr>
																
																<tr>
																	<td>Membership Charge:</td>
																	<td>$ <?php 
																	$kdfgdf2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(charge) AS tolk2 FROM `upgrade`"));
																	$memberChagre=$kdfgdf2['tolk2'];
																	if($memberChagre>0){
																		echo $memberChagre;
																	}else{
																		echo '0.00';
																	}
																	?></td>
																</tr>
																
																<tr>
																	<td>&nbsp;</td>
																	<td>&nbsp;</td>
																</tr>
																<tr>
																	<td>Total Deposit Return:</td>
																	<td>$ <?php 
																		$kdfgdf211=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS tolk211 FROM `game_return`"));
																		$deposit=$kdfgdf211['tolk211'];
																		if($deposit>0){
																			echo $deposit;
																		}else{
																			echo '0.00';
																		}
																	?></td>
																</tr>
																
																<tr>
																	<td>Total Sponsor Commission:</td>
																	<td>$ <?php 
																		$kdfgdf21=mysqli_fetch_assoc($mysqli->query("SELECT SUM(bonus) AS tolk21 FROM `upgrade`"));
																		$sponsor=$kdfgdf21['tolk21'];
																		if($sponsor>0){
																			echo $sponsor;
																		}else{
																			echo '0.00';
																		}
																	?></td>
																</tr>
																<tr>
																	<td>Total Binary Commission:</td>
																	<td>$ <?php 
																		$kdfgdf211=mysqli_fetch_assoc($mysqli->query("SELECT SUM(slot_match) AS tolk211 FROM `binary_income`"));
																		$binary=$kdfgdf211['tolk211'];
																		if($binary>0){
																			echo $binary;
																		}else{
																			echo '0.00';
																		}
																	?></td>
																</tr>
																<tr>
																	<td>Total Generation Commission:</td>
																	<td>$ <?php 
																		$kdfgdf211=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS tolk211 FROM `generation_income`"));
																		$genCom=$kdfgdf211['tolk211'];
																		if($genCom>0){
																			echo $genCom;
																		}else{
																			echo '0.00';
																		}
																	?></td>
																</tr>
																
																<tr>
																	<td>Total Global Return:</td>
																	<td>$ <?php 
																		$kdfgdf211=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS tolk211 FROM `game_return2`"));
																		$global=$kdfgdf211['tolk211'];
																		if($global>0){
																			echo $global;
																		}else{
																			echo '0.00';
																		}
																	?></td>
																</tr>
																<tr>
																	<td>Total Rank Bonus:</td>
																	<td>$ <?php 
																		//$kdfgdf211=mysqli_fetch_assoc($mysqli->query("SELECT SUM(curent_bal) AS tolk211 FROM `game_return2`"));
																		echo '0.00';//$global=$kdfgdf211['tolk211'];
																	?></td>
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
