<?php
    session_start();
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		$date=date("Y-m-d");
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
                                <div class="card  summary-inline" style="background-color: #efe8e8;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php echo mysqli_num_rows($mysqli->query("SELECT DISTINCT(`log_user`) FROM `member`")); ?></div>
                                            <div class="sub-title">Total CID</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background-color: #efe8e8;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php echo mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member`")); ?></div>
                                            <div class="sub-title">Total Member</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background-color: #efe8e8;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php echo mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `pack`>'0'")); ?></div>
                                            <div class="sub-title">Total Active Member</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
						
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card summary-inline" style="background-color: #efe8e8;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php echo mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE DATE(`time`)='".$date."' ")); ?></div>
                                            <div class="sub-title">Total Member Today <?php //echo "SELECT `serial` FROM `member` WHERE DATE(`time`)='".$date."' "?></div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card summary-inline" style="background-color: #efe8e8;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;"><?php echo mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `pack`>'0' AND DATE(`date`)='".$date."'")); ?></div>
                                            <div class="sub-title">Total Active Member Today</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
					
					
					
					<?php
						$mnbvg=$mysqli->query("SELECT * FROM `package`");
						while($mnbgf=mysqli_fetch_assoc($mnbvg)){
					?>
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card  summary-inline" style="background: <?php echo $mnbgf['color']?>;">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;color:#FFF;"> <?php
											echo mysqli_num_rows($mysqli->query("SELECT `serial` FROM `member` WHERE `pack`='".$mnbgf['serial']."'"));		
									?></div>
                                            <div class="sub-title" style="color:#FFF;"><?php echo $mnbgf['pack']; ?> Pack</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
					<?php } ?>
					
					<?php
					// Get manual deposit statistics
					$manual_deposits_stats = $mysqli->query("SELECT 
						COUNT(*) as total_deposits,
						SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
						SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_count,
						SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
						SUM(CASE WHEN status = 'approved' THEN amount ELSE 0 END) as approved_amount,
						SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as pending_amount
						FROM manual_deposits");
					
					$deposit_stats = $manual_deposits_stats ? $manual_deposits_stats->fetch_assoc() : [
						'total_deposits' => 0, 'pending_count' => 0, 'approved_count' => 0, 
						'rejected_count' => 0, 'approved_amount' => 0, 'pending_amount' => 0
					];
					?>
					
					<!-- Manual Deposits Statistics -->
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="manual_deposits_verify.php">
                            <div class="card summary-inline" style="background: linear-gradient(45deg, #007bff, #0056b3);">
                                <div class="card-body">
                                    <div class="content">
                                        <div class="title" style="font-size: 30px; color: #FFF;"><?php echo $deposit_stats['total_deposits']; ?></div>
                                        <div class="sub-title" style="color: #FFF;">Manual Deposits</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="manual_deposits_verify.php?status=pending">
                            <div class="card summary-inline" style="background: linear-gradient(45deg, #ffc107, #ff8c00);">
                                <div class="card-body">
                                    <div class="content">
                                        <div class="title" style="font-size: 30px; color: #000;">
											<?php echo $deposit_stats['pending_count']; ?>
											<?php if($deposit_stats['pending_count'] > 0): ?>
												<i class="fa fa-exclamation-triangle" style="color: #ff0000; font-size: 20px;"></i>
											<?php endif; ?>
										</div>
                                        <div class="sub-title" style="color: #000;">Pending Verification</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="manual_deposits_verify.php?status=approved">
                            <div class="card summary-inline" style="background: linear-gradient(45deg, #28a745, #20c997);">
                                <div class="card-body">
                                    <div class="content">
                                        <div class="title" style="font-size: 30px; color: #FFF;"><?php echo $deposit_stats['approved_count']; ?></div>
                                        <div class="sub-title" style="color: #FFF;">Approved Deposits</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <a href="manual_deposits_verify.php">
                            <div class="card summary-inline" style="background: linear-gradient(45deg, #17a2b8, #138496);">
                                <div class="card-body">
                                    <div class="content">
                                        <div class="title" style="font-size: 24px; color: #FFF;">$<?php echo number_format($deposit_stats['approved_amount'], 2); ?></div>
                                        <div class="sub-title" style="color: #FFF;">Approved Amount</div>
                                    </div>
                                    <div class="clear-both"></div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					
					
                    <div class="row  no-margin-bottom">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
								<!--<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Depositors
										<div class="pull-right"> </div>
									</div>
									
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="table-responsive">
													<table class="table table-bordered table-hover table-striped">
														<thead>
															<tr>
																<th>SN:</th>       
																<th>User Id:</th>
																<th>Member Name:</th>
																<th>Sponsor:</th>
																<th>JoinDate:</th>
																<th>Account:</th>	
																<th>Status:</th>
																<th>Deposit:</th>
																<th>Return:</th>  	  
																<th>Direct:</th> 
																<th>Receive:</th>  	 	       
																<th>Genera:</th> 
																<th>Net:</th>
															</tr>
<?php							   
	$items= mysqli_num_rows($mysqli->query("SELECT * FROM member "));	
	if((!$limit)||(is_numeric($limit) == false)||($limit<99)||($limit>101)){$limit=100;}
	if((!$page)||(is_numeric($page) == false)||($page<0)||($page>$items)){$page=1;}								
	$pages=ceil($items / $limit);
	$set=$page*$limit - ($limit);
	$q =  $mysqli->query("SELECT * FROM member ORDER BY serialno ASC LIMIT $set, $limit");
	
	
	
	while($res= mysqli_fetch_object($q))		
	{
	$row1 = mysqli_fetch_array($mysqli->query("select* from balance where user_id='".$res->user_id."'"));
	$row2 = mysqli_fetch_array($mysqli->query("select* from member_data where user_id='".$res->user_id."'"));
?>
														</thead>
														<tbody>
															<tr>
																<td><?php echo $res->serialno;?></td>     
																<td><?php echo $res->user_id;?></td>  
																<td><?php echo $row2["name"];?></td>
																<td><?php echo $res->reffereduser;?></td>  
																<td><?php echo $res->join_date;?></td> 
																<td><?php if($res->suspend==1){echo "Suspend";}else{echo "Active";}?></td> 
																<td><?php echo $row2["rank"];?></td>                                        
																<td><?php echo $row1["bcpp_taka"];?></td>  
																<td><?php echo $row1["donar_gift_taka"];?></td>                                 
																<td><?php echo $row1["direct_taka"];?></td>
																<td><?php echo $row1["receive_taka"];?></td>
																<td><?php echo $row1["generation_taka"];?></td> 
																<td><?php echo $res->final_taka;?></td>
															</tr>
														</tbody>
<?php } ?>
													</table>
<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
<?php 
	$cat = urlencode($cat); 
	$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href=?limit=$limit&amp;page=$prev_page><b>Prev</b></a>");}
	$a = $page ;if($a <= $total_pages){ echo("|<a href=?limit=$limit&amp;page=$a><b>$a</b></a>|");}			
	$b = $page + 1;if($b <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$b><b>$b</b></a>|");}			
	$c = $page + 2;if($c <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$c><b>$c</b></a>|");}	
	$d = $page + 3;if($d <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$d = $page + 4;if($d <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$e = $page + 5;if($e <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$e><b>$e</b></a>|");}			
	$f = $page + 6;if($f <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$f><b>$f</b></a>|");}			
	$g = $page + 7;if($g <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$g><b>$g</b></a>|");}
	$h = $page + 8;if($h <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$h><b>$h</b></a>|");}			
	$i = $page + 9;if($i <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$i><b>$i</b></a>|");}			
	$j = $page + 10;if($j <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$j><b>$j</b></a>|");}
	$next_page = $page + 1;if($next_page <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$next_page><b>Next</b></a> &gt;&gt;");}
?>	
	<form method="get" action="" style="text-align: center;">
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;">Total Pages </span>
		
		<b style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:blue;font-size:13px;">
		<?php echo $total_pages;?></b>
		
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> Show 
			<input type="text"  name="page" value="<?php echo $page;?>" size="4" />
			<input type="hidden" name="limit" value="<?php echo $limit;?>" />
		</span>
		<input type="submit"  value="Submit" /> 
	</form>     
</p> 
												</div>
											</div>
										</div>
									</div>
								</div>-->
                            </div>
                        </div><!-- /.col-sm-12 (nested) -->
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
