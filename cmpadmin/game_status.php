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
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">

						
						
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Add Games
									<div class="pull-right"> </div>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered table-hover table-striped">
													<thead>
														<tr>
															<th scope="col">Serial</th>	
															<th scope="col">User ID</th>																
															<th scope="col">Date</th>
															<th scope="col">Time</th>															
															<th scope="col">Game</th>
															<th scope="col">Type</th>											
															<th scope="col">First Team</th>
															<th scope="col">Second  Team</th>
															<th scope="col">Slot</th>
															<th scope="col">My Choice</th>
															<th scope="col">Status</th>
															<th scope="col"><--Update-Details--></th>
															<th scope="col">Delete</th>															
														</tr>
													</thead>
				<?php

					$count= mysqli_num_rows($mysqli->query("SELECT * FROM `play` "));
					$limit=$_GET['limit'];
					$type=$_GET['type'];
					$page=$_GET['page'];
					if((!$limit)||(is_numeric($limit)==false)){$limit=100;}
					if((!$page)||(is_numeric($page)==false)){$page=1;}
					$total=ceil($count/$limit);
					$set=(($page*$limit)-$limit);		
					$q = $mysqli->query("SELECT * FROM `play` ORDER BY serial DESC LIMIT $set, $limit");

					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						
					
						
				?>
													<tbody>
														<tr>
															<td><?php echo $n++; ?></td>
															<td><?php echo $querygetexeres->user; ?></td>															
															<td><?php echo $querygetexeres->date; ?></td>
															<td><?php echo $querygetexeres->enddate; ?></td>															
															<td><?php echo $querygetexeres->gameid;?></td>	
															<td><?php echo $querygetexeres->type;?></td>																
															
															<td><?php echo $querygetexeres->team_a;?></td>
															<td><?php echo $querygetexeres->team_b;?> </td>
															<td><?php echo $querygetexeres->slot;?> </td>															
															<td><?php echo $querygetexeres->draw;?> </td>	
															
															
															
															
<td><?php if($querygetexeres->active==0){echo "Not Played"; }elseif($querygetexeres->active==1){echo "Game Win"; }elseif($querygetexeres->active==2){echo "Game Lose"; }else{echo "Played";};?> </td>
															<td>
															<a href="game_m_done.php?game=<?php echo $querygetexeres->serial; ?>&&team=3">Draw</a> ||
															<a href="game_m_done.php?game=<?php echo $querygetexeres->serial;?>&&team=1">Win</a> ||
															<a href="game_m_done.php?game=<?php echo $querygetexeres->serial;?>&&team=2">Lose</a>
															</td>
															<td>
															<a href="game_m_done.php?game=<?php echo $querygetexeres->serial;?>&&team=5&&amount=<?php echo $querygetexeres->slot;?>&&member=<?php echo $querygetexeres->user; ?>">Delete</a>
															</td>															
														</tr>
													</tbody>
				<?php } ?>
												</table>
	<p align="center"><center>  
		<?php 
			$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href=?limit=$limit&amp;page=$prev_page&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>Prev </b></a>");}
			$a = $page ;if($a <= $total){ echo(" | <a href=?limit=$limit&amp;page=$a&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$a</b></a> | ");}			
			$b = $page + 1;if($b <= $total){ echo(" <a href=?limit=$limit&amp;page=$b&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$b</b></a> | ");}			
			$c = $page + 2;if($c <= $total){ echo(" <a href=?limit=$limit&amp;page=$c&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$c</b></a> | ");}	
			$d = $page + 3;if($d <= $total){ echo(" <a href=?limit=$limit&amp;page=$d&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$d</b></a> | ");}
			$d = $page + 4;if($d <= $total){ echo(" <a href=?limit=$limit&amp;page=$d&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$d</b></a> | ");}
			$e = $page + 5;if($e <= $total){ echo(" <a href=?limit=$limit&amp;page=$e&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$e</b></a> | ");}			
			$f = $page + 6;if($f <= $total){ echo(" <a href=?limit=$limit&amp;page=$f&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$f</b></a> | ");}			
			$g = $page + 7;if($g <= $total){ echo(" <a href=?limit=$limit&amp;page=$g&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$g</b></a> | ");}
			$h = $page + 8;if($h <= $total){ echo(" <a href=?limit=$limit&amp;page=$h&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$h</b></a> | ");}			
			$i = $page + 9;if($i <= $total){ echo(" <a href=?limit=$limit&amp;page=$i&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$i</b></a> | ");}			
			$j = $page + 10;if($j <= $total){ echo(" <a href=?limit=$limit&amp;page=$j&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>$j</b></a> | ");}
			$next_page = $page + 1;if($next_page <= $total){ echo(" <a href=?limit=$limit&amp;page=$next_page&amp;type=$type&amp;item=$item&amp;start=$start&amp;end=$end><b>Next</b></a> <b>&gt;&gt;</b>");}
		?>	
	</p> 	
	<p align="center"><center> 
		<form method="get" action="" align="center">
			<?php if($count==0){echo "Note: <font color=#FF0000>No Record Found</font>";} ?>
			<span style="align:center;color:green;">Total Pages </span>
			<b style="align:center;color:blue;"><?php echo $total;?></b>
			<span style="align:center;color:red;"> Showing <input type="text"  name="page" value="<?php echo $page;?>" size="4" style="margin-left:0px;margin-right:0px;"/></span>
			<input type="hidden" name="limit" value="<?php echo $limit;?>" />
			<input type="hidden" name="type" value="<?php echo $type;?>" />
			<input type="hidden" name="item" value="<?php echo $item;?>" />
			<input type="hidden" name="start" value="<?php echo $start;?>" />
			<input type="hidden" name="end" value="<?php echo $end;?>" />			
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
			
			
			
		
			
</body>

</html>
