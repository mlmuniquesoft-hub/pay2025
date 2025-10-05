<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token']))){
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<link type="text/css" href="css/bootstrap-timepicker.min.css" />
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
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i>Total Member Current Balance
									<div class="pull-right"> </div>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group col-sm-6">
												<select class="form-control act" name="sort " id="sort">
													<option>Select Sorting Order</option>
													<option value="ASC">Order By Amount Asccending</option>
													<option value="DESC">Order By Amount Decending</option>
												</select>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered table-hover table-striped">
													<thead>
														<tr>
															<th scope="col">Serial</th>										
															<th scope="col"> User ID </th>
															<th scope="col"> User Name </th>
															<!--<th scope="col">Amount</th>-->
															<th scope="col">Current Balance</th>
															
															<th scope="col">Curent Status</th>
														</tr>
													</thead>
				<?php
					$date=date("Y-m-d");
					//var_dump($date);
					$n=1;
					if(isset($_GET['date'])){
						$date=$_GET['date'];
						if($date!=''){
							$date=$_GET['date'];
						}else{
							$date=date("Y-m-d");
						}
						$query11="`date`='".$date."'";
					}else{
						$query11="`date`='".$date."'";
					}
					if(isset($_GET['order'])){
						$order=$_GET['order'];
						if($order==''){
							$order="DESC";
						}else{
							$order=$_GET['order'];
						}
						$ascc="ORDER BY `final_taka` $order";
					}else{
						$ascc="ORDER BY `final_taka` DESC";
					}
					$items= mysqli_num_rows($mysqli->query("SELECT DISTINCT `user` FROM `balance` "));	
					if((!$limit)||(is_numeric($limit) == false)||($limit<29)||($limit>30)){$limit=30;}
					if((!$page)||(is_numeric($page) == false)||($page<0)||($page>$items)){$page=1;}								
					$pages=ceil($items / $limit);
					$set=$page*$limit - ($limit);
					$q =  $mysqli->query("SELECT DISTINCT `user` FROM `balance`  $ascc LIMIT $set, $limit");
					$datew=date("m");
					$ffd=date("t");
					$fromdate="2017-$datew-01";
					$TOdate="2017-$datew-$ffd";
					$query12="DATE(date) BETWEEN '$fromdate' AND '$TOdate'";
					//echo $query12;
					while($querygetexeres2= mysqli_fetch_object($q))
					{
						$querygetexeres=mysqli_fetch_object($mysqli->query("SELECT * FROM `balance` WHERE  `user`='".$querygetexeres2->user."' $ascc "));
						$row23 = mysqli_fetch_array($mysqli->query("select * from `member` where `user`='".$querygetexeres->user."'"));
						$row2 = mysqli_fetch_array($mysqli->query("select * from `profile` where `user`='".$row23['log_user']."'"));
						$row232 = mysqli_fetch_array($mysqli->query("select * from `package` where `serial`='".$row23['pack']."'"));
				?>
													<tbody>
														<tr>
															<td><?php echo $n++; ?></td>										
															<td><a class="btn btn-success" href="member_login.php?user=<?php echo $querygetexeres->user; ?>" id="color"><?php echo $querygetexeres->user; ?></a></td>
															<td><?php echo $row2['name']; ?></td>
															<td><?php echo $querygetexeres->final_taka; ?></td>
															
															<td><?php echo $row232['pack']; ?></td>
														</tr>
													</tbody>
				<?php } ?>
												</table>
												<p style="display:none" id="date_val" data-vv="<?php echo $date; ?>">
												<p style="display:none" id="order_val" data-vv="<?php echo $order; ?>">
												<p style="display:none" id="location" data-vv="<?php echo $_SERVER['PHP_SELF']; ?>">
												<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
<?php 
	$cat = urlencode($cat); 
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href='$actual_link & limit=$limit&amp;page=$prev_page'><b>Prev</b></a>");}
	$a = $page ;if($a <= $pages){ echo("|<a href='$actual_link & limit=$limit&amp;page=$a'><b>$a</b></a>|");}			
	$b = $page + 1;if($b <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$b'><b>$b</b></a>|");}			
	$c = $page + 2;if($c <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$c'><b>$c</b></a>|");}	
	$d = $page + 3;if($d <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$d'><b>$d</b></a>|");}
	$d = $page + 4;if($d <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$d'><b>$d</b></a>|");}
	$e = $page + 5;if($e <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$e'><b>$e</b></a>|");}			
	$f = $page + 6;if($f <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$f'><b>$f</b></a>|");}			
	$g = $page + 7;if($g <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$g'><b>$g</b></a>|");}
	$h = $page + 8;if($h <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$h'><b>$h</b></a>|");}			
	$i = $page + 9;if($i <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$i'><b>$i</b></a>|");}			
	$j = $page + 10;if($j <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$j'><b>$j</b></a>|");}
	$next_page = $page + 1;if($next_page <= $pages){ echo("<a href='$actual_link & limit=$limit&amp;page=$next_page'><b>Next</b></a> &gt;&gt;");}
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
				$(document).ready(function(){
					$(".act").on("change", function(){
						var vbb=$(this).val();
						var tt=vbb.length;
						var dd=$("#date_val").attr("data-vv");
						var rr=$("#order_val").attr("data-vv");
						var ll=$("#location").attr("data-vv");
						if(tt>=8){
							location.href=ll+"?date="+vbb+"&order="+rr;
						}else{
							location.href=ll+"?date="+dd+"&order="+vbb;
						}
						
					});
				});
			</script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
			<!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>

<!-- Include Date Range Picker 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>-->

	<script>
		$(function() {
			$( "#datepicker1" ).datepicker1();
			$('#timepicker').timepicker();		
		}); 
		
		

	</script>
	<?php
		unset($_SESSION['msg']);
		unset($_SESSION['msg2']);
	?>
		
			
</body>

</html>