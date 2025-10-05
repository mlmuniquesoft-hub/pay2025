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
		if(isset($_GET['chafnge'])){
			$date=$_GET['chafnge'];
			$linkp=$_GET['linkp'];
			$dsfgdsf=explode("?",$linkp);
			if($dsfgdsf[1]==''){
				$recTp=$linkp ."?date=".$date;
			}else{
				$recTp=$dsfgdsf[0] ."?date=".$date;
			}
			echo $recTp;
			die();
		}
		$date=date("Y-m-d");
		if(isset($_GET['date'])){
			$date=$_GET['date'];
		}else{
			$date=$date;
		}
		$DATE3=date('Y-m-d');
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
											<i class="fa fa-bar-chart-o fa-fw"></i> Total Purchase Summary (<?php echo date("d M-Y", strtotime($date)); ?> To <?php echo date("d M-Y", strtotime($DATE3)); ?>)
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row" id="filter">
												<div class="col-sm-6 col-xs-12">
													<input type="date" id="datepicker" value="<?php echo $date; ?>" class="form-control">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive" id="new_member">
														<table class="table table-bordered table-hover table-striped">
															<thead style="background: #0000ff2e;">
																<tr>
																	<th>SN:</th>       
																	<th>User:</th>
																	<th>Package:</th>
																	<th>First Purchase Date</th>
																	<th>First Purchase Amount</th>
																	<th>Sponsored By:</th>
																	<th>Total Purchase:</th>         
																	
																	<th>Last Purchase Date</th>
																	<th>Last Purchase Amount</th>
																	<th>Last Amount Receive From</th>
																	<th>Current Balance</th>
																</tr>
															</thead>
<?php
	
	$t=$mysqli->query("SELECT DISTINCT `user` FROM `upgrade` WHERE  DATE(`date`) BETWEEN '".$date."' AND '".$DATE3."'");				   
	$a= mysqli_fetch_object($t);
	$total_items= mysqli_num_rows($t);
	$limit=$_GET['limit'];
	$type=$_GET['type'];
	$page=$_GET['page'];
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 39) || ($limit > 41))
	{$limit = 40; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
				
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					

	$werI=$mysqli->query("SELECT DISTINCT `user` FROM `upgrade` WHERE  DATE(`date`) BETWEEN '".$date."' AND '".$DATE3."' ORDER BY `date` DESC LIMIT $set_limit, $limit");
	//var_dump("SELECT * FROM `trans_receive` WHERE `type`='Transfer'  AND DATE(`time`)='".$date."' ORDER BY `time` DESC LIMIT $set_limit, $limit");
	$i=1;
	while($JKSHFKS=mysqli_fetch_assoc($werI)){
		$withrwaUser=$JKSHFKS['user'];
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$withrwaUser."'"));
	   $mghh321=mysqli_fetch_assoc($mysqli->query("SELECT `final_taka` FROM `balance` WHERE `user`='".$withrwaUser."'"));
	   $mghh12=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh['user']."' OR `user`='".$mghh['log_user']."'"));
?>
															<tbody>
																<tr>
																	<td><?php echo $i++;; ?></td>     
																	<td><a class="btn btn-success" href="member_login.php?user=<?php echo $withrwaUser; ?>" id="color"><?php echo $withrwaUser; ?></a></td> 
																	<td><?php
																		if($mghh['pack']>0){
																			$uuu=$mghh['pack'];
																			settype($uuu, "integer");
																			if($uuu>0){
																				$packnnm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mghh['pack']."' "));
																				echo "<span style='color:".$packnnm['color']."'>" . $packnnm['pack'] ."</span>";
																			}else{
																				echo $mghh['pack'];
																			}
																		}else{
																			echo  "Starter";
																		}
																	?></td>     
																	<td><?php 
																		$ertre1121=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$withrwaUser."' ORDER BY `date` ASC LIMIT 1")); 
																		echo date("Y-m-d", strtotime($ertre1121['date']));
																	?></td>
																	
																	<td>$<?php 
																		echo $ertre1121['amount'];
																	?></td>
																	<td><?php echo $mghh['sponsor']; ?></td>
																	<td>$<?php 
																	$PurChsd=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as tolkg FROM `upgrade` WHERE `user`='".$withrwaUser."' "));
																	 echo $PurChsd['tolkg'];
																	?></td>
																	
																	
																	<td><?php 
																		$ertre112=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$withrwaUser."' ORDER BY `date` DESC LIMIT 1")); 
																		echo date("Y-m-d", strtotime($ertre112['date']));
																	?></td>
																	
																	<td>$<?php 
																		echo $ertre112['amount'];
																	?></td>
																	<td>
																	<?php 
																		$ertre112=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `trans_receive` WHERE `user_receive`='".$withrwaUser."' AND `type`='Transfer' AND `account`='Member' ORDER BY `date` DESC LIMIT 1")); 
																	?>
																	<a class="btn btn-info" href="member_login.php?user=<?php echo $ertre112['user_trans']; ?>" id="color">
																	<?php 
																		
																		echo $ertre112['user_trans'] ." : ". $ertre112['ammount'];
																	?>
																	</a>
																	</td>
																	<td>$<?php echo number_format(remainAmn($mghh['user']),2,'.',''); ?></td>
																	
																	
																	
																</tr>
<?php } ?>
															</tbody>
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
			<script>
				$("#datepicker").on("keyup change", function(){ 
					var dateo=$(this).val();
					var linkm=$("#FulLink").attr("data-link");
					console.log(linkm);
					var tred=$.ajax({
						method:"GET",
						url:"",
						data:{linkp:linkm,chafnge:dateo}
					});
					tred.done(function(Banlink){
						location.href=Banlink;
						//console.log(Banlink);
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
