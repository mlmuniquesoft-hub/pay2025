<?php
    session_start(); 
	    if(!isset($_SESSION['Admin']))
    	{
    	header("Location:logout.php");
		exit();
    	}  
	else
	{
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
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Send to Agent
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
																<th>Agent Id</th>
																<th>USD</th>
															</tr>
<?php
	$t = $mysqli->query("SELECT * FROM admin_trans_receive where user_transfer='".$memberid."'");
	if(!$t) die(mysqli_error());
						   
	$a= mysqli_fetch_object($t);
	$total_items= mysqli_num_rows($t);
	$limit = isset($_GET['limit']) ? $_GET['limit'] : 15;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 14) || ($limit > 16))
	{$limit = 15; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
						
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					

	$q = $mysqli->query("SELECT * FROM admin_trans_receive where user_transfer='".$memberid."' ORDER BY `date` DESC LIMIT $set_limit, $limit");
	if(!$q) die(mysql_error());
	$err = mysqli_num_rows($q);	  
	while($querygetexeres= mysqli_fetch_object($q))
	{
?>
														</thead>
														<thead>
															<tr>
																<th><?php echo $querygetexeres->date;?></th>
																<th><?php echo $querygetexeres->user_receive; ?></th>
																<th>$ <?php echo $querygetexeres->amount;?></th>
															</tr>
														</thead>
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
							<!--.row-->
                        </div>
						<!--.col-lg-3 -->
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Withdraw from Agent
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
																<th>Agent Id</th>
																<th>USD</th>
															</tr>
<?php
	$t = $mysqli->query("SELECT * FROM admin_trans_receive where user_receive='".$memberid."'");
	if(!$t) die(mysqli_error());
						   
	$a= mysqli_fetch_object($t);
	$total_items= mysqli_num_rows($t);
	$limit = isset($_GET['limit']) ? $_GET['limit'] : 15;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 14) || ($limit > 16))
	{$limit = 15; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
						
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					

	$q = $mysqli->query("SELECT * FROM admin_trans_receive where user_receive='".$memberid."' LIMIT $set_limit, $limit");
	if(!$q) die(mysql_error());
	$err = mysqli_num_rows($q);	  
	while($querygetexeres= mysqli_fetch_object($q))
	{
?>
														</thead>
														<thead>
															<tr>
																<th><?php echo $querygetexeres->date;?></th>
																<th><?php echo $querygetexeres->user_transfer; ?></th>
																<th>$ <?php echo $querygetexeres->amount;?></th>
															</tr>
														</thead>
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
							<!--.row-->
                        </div>
						<!--.col-lg-3 -->
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
