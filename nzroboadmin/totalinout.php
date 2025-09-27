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
																	<th>Name of all Criteria: </th>
																	<th>USD</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td>Upgradation Charge:</td>
																	<td>$<?php 
																		$ACTIVATIcHR=0;
																		$rtyrt123=$mysqli->query("SELECT DISTINCT pack FROM `invoice_req` WHERE `pin_for`='0' AND `active`='1'");
																		while($alpack=mysqli_fetch_assoc($rtyrt123)){
																			$mfsdgfd=mysqli_fetch_assoc($mysqli->query("SELECT `pack_amn` FROM `package` WHERE `serial`='".$alpack['pack']."'"));
																			$mfsdgfd22=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `invoice_req` WHERE `pack`='".$alpack['pack']."' AND `pin_for`='0' AND `active`='1'"));
																			$ACTIVATIcHR=($ACTIVATIcHR+($mfsdgfd22*$mfsdgfd['pack_amn']));
																		}
																		echo $ACTIVATIcHR;
																	?></td>
																</tr>
																<tr>
																	<td>Renew Charge:</td>
																	<td>$<?php 
																		$renchr=0;
																		$rtyrt1223=$mysqli->query("SELECT DISTINCT gamepack FROM `invoice_req` WHERE `pin_for`='1' AND `active`='1'");
																		while($alpack=mysqli_fetch_assoc($rtyrt1223)){
																			if($alpack['gamepack']>0){
																				$mfsdgfd1=mysqli_fetch_assoc($mysqli->query("SELECT `game_renew` FROM `package` WHERE `serial`='".$alpack['gamepack']."'"));
																				$mfsdgfd212=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `invoice_req` WHERE `gamepack`='".$alpack['gamepack']."' AND `pin_for`='1' AND `active`='1'"));
																				//echo $mfsdgfd1['game_renew'] ."<br/>";
																				//echo $alpack['gamepack']."<br/>";
																				//echo $mfsdgfd212;
																				
																				$renchr=($renchr+($mfsdgfd212*$mfsdgfd1['game_renew']));
																			}
																			
																		}
																		echo $renchr;
																	?></td>
																</tr>
																<tr>
																	<td>Transaction Charge:</td>
																	<td>$ <?php
																		$reddws=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`tax`) AS `chch` FROM `trans_receive`"));
																	echo $reddws['chch']?></td>
																</tr>
																<tr>
																	<td>Game Lost:</td>
																	<td> <?php 
																	$reddsws=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS `dsds` FROM `lose_invest`"));
																	$reddsws2=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`amount`) AS `sdsd` FROM `deposit_out`"));
																	$reddsws22=mysqli_fetch_assoc($board_game->query("SELECT SUM(`amount`) AS `sdsdq` FROM `lose_invest`"));
																	?>
																	Lost From Current Balance: $<?php echo $reddsws['dsds']; ?><br/>
																	Lost From Current Balance (Board): $<?php echo $reddsws22['sdsdq']*0.20; ?><br/>
																	Lost From Trading Balance: $<?php echo $reddsws2['sdsd']; ?><br/>
																	Total Lost Balance: $<?php echo $TotalLost=$reddsws2['sdsd']+$reddsws['dsds']+$reddsws22['sdsdq']*0.20; ?>
																	
																	
																	</td>
																</tr>
																<tr>
																	<td>Total In Amount</td>
																	<td>$<?php echo $TotalIn=$renchr+$TotalLost+$tattal+$tytyy+$reddws['chch']+$yyuu+$ACTIVATIcHR; ?></td>
																</tr>
																<tr>
																	<th colspan="2">Total Out</th>
																</tr>
																<tr>
																	<td>Total Sponsor Commission:</td>
																	<td>$ <?php 
																		$direct=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`direct`) AS `sssd` FROM `member`"));
																	echo $direct['sssd']?></td>
																</tr>
																<tr>
																	<td>Total Generation Commission:</td>
																	<td> <?php 
																	$genCur=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS `gencur` FROM `generation_income`"));
																	//$genbonus=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`u_amount`) AS `genboo` FROM `generation_income`"));
																	$tyuytt=$genCur['gencur'];
																	//echo "C-" .$genCur['gencur'] ."<br/>";
																	echo "Total: $ " .$tyuytt ;
																	
																	?></td>
																</tr>
																<tr>
																	<td>Total Rank Commission:</td>
																	<td><?php 
																		$rankUniq=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS `rankuu` FROM `ranks`"));
																		$rankBoo=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`c_wallet`) AS `rankcc` FROM `ranks`"));
																		$totalRank=$rankUniq['rankuu']+$rankBoo['rankcc'];
																	//echo "U-". $rankUniq['rankuu'] ."<br/>";
																	//echo "B-". $rankBoo['rankcc'] ."<br/>";
																	echo "Total: $ ". $totalRank ;
																	
																	?></td>
																</tr>
																<tr>
																	<td>Total Rank Commission (Auto Return):</td>
																	<td><?php 
																		$rankUniq4=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(`amount`) AS `rankuur` FROM `autoreturn_depo`"));
																		
																	echo "Total: $ ". $rankUniq4['rankuur'];
																	
																	?></td>
																</tr>
																
																<tr>
																	<td>Total Binary Commission:</td>
																	<td><?php
																		$selfMatch=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`slot_match`) AS `matchself` FROM `binary_income`"));
																		$cidMatch=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`matching`) AS `matchcid` FROM `uniq_binary`"));
																		$curentss=($selfMatch['matchself']*.05);
																		
																	echo "Total: $ " . $curentss;
																	
																	?></td>
																</tr>
																<tr>
																	<td>Total Game Win Reward:</td>
																	<td><?php
																		$curgam=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`curent_bal`) AS `curgam` FROM `game_return`"));
																		$bonusgam=mysqli_fetch_assoc($board_game->query("SELECT SUM(`curent_bal`) AS `boogam` FROM `game_return`"));
																		$toatlGamm=$curgam['curgam'];//+$bonusgam['boogam'];
																		echo "L/S $ ".$curgam['curgam'] ."<br/>";
																		//echo "B $ ".$bonusgam['boogam'] ."<br/>";
																		echo "Total: ".$toatlGamm;
																	
																	?></td>
																</tr>
																<tr>
																	<td>Total Out Amount</td>
																	<td>$<?php echo $totalOut=$toatlGamm+$curentss+$totalRank+$tyuytt+$direct['sssd']; ?></td>
																</tr>
																
																<tr>
																	<th>Total Balance</th>
																	<th>$ <?php echo $TotalIn-$totalOut; ?></th>
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