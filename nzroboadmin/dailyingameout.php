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
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php 
											$poiu=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`final_taka`) as totta FROM `balance`")); 
											echo $poiu['totta'];
											
											?></div>
                                            <div class="sub-title">Total Current Balance</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">
											<?php 
												$poiu2=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`c_balance`) as bonus FROM `deposit_amn`")); 
												echo $poiu2['bonus'];
											
											?>
										</div>
                                            <div class="sub-title">Total Trading Balance (IN)</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">
											<?php 
												$poiu22=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`amount`) as uniss FROM `deposit_out`"));
												echo $poiu22['uniss'];
											?>
										</div>
                                            <div class="sub-title">Total Trading Balance (Lost)</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card red summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">
											<?php 
												
												echo $poiu2['bonus']-$poiu22['uniss'];
											?>
										</div>
                                            <div class="sub-title">Current Trading Balance</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Balance Sheet
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
																	<th>Date</th>
																	<th>User Win Amount</th>
																	<th>User Lose Amount</th>
																	<th>Company Profit Amount</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																	$toatlProfit=0;
																	for($i=1;$i<=7;$i++){
																		$date=date("Y-m-d", strtotime("-$i days"));
																		$reddsws=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS `dsds` FROM `lose_invest` WHERE DATE(date)='".$date."'"));
																		$reddsws2=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`amount`) AS `sdsd` FROM `deposit_out` WHERE DATE(date)='".$date."'"));
																		$reddsws22=mysqli_fetch_assoc($board_game->query("SELECT SUM(`amount`) AS `sdsdq` FROM `lose_invest` WHERE DATE(date)='".$date."'"));
																		
																		$curgam=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`curent_bal`) AS `curgam` FROM `game_return` WHERE DATE(date)='".$date."'"));
																		$curgam22=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`amount`) AS `curgam2` FROM `trade_win_reward` WHERE DATE(date)='".$date."'"));
																		$bonusgam=mysqli_fetch_assoc($board_game->query("SELECT SUM(`curent_bal`) AS `boogam` FROM `game_return` WHERE DATE(date)='".$date."'"));
																?>
																<tr>
																	<td><?php echo $date;?></td>
																	<td>
																		Win In Current: $<?php echo $curgam['curgam']; ?><br/>
																		Win In Trading: $<?php echo $curgam22['curgam2']; ?><br/>
																		Win From Board Play(Current): $<?php echo $bonusgam['boogam']; ?><br/>
																		Total Lose: $<?php echo $Uytr22=$curgam['curgam']+$curgam22['curgam2']; ?><br/>
																	</td>
																	<td>
																		Lose From Current: $<?php echo $reddsws['dsds']; ?><br/>
																		Lose From Trading: $<?php echo $reddsws2['sdsd']; ?><br/>
																		Lose In Board Play: $<?php echo $reddsws22['sdsdq']; ?><br/>
																		Total Lose: $<?php echo $Uytr=$reddsws2['sdsd']+$reddsws['dsds']; ?><br/>
																	</td>
																	
																	<td>
																		$<?php 
																		$twtt=$reddsws22['sdsdq']-$bonusgam['boogam'];
																		echo $InTotal=(($Uytr-$Uytr22)+$twtt);$toatlProfit=$toatlProfit+$InTotal; ?><br/>
																	</td>
																	
																</tr>
																<?php } ?>
																<tr>
																	<td colspan="3" align="right">Total:</td>
																	<td>
																		$<?php 
																		echo $toatlProfit; ?><br/>
																	</td>
																	
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