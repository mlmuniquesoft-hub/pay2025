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
	 <link rel="stylesheet" type="text/css" href="css/jquery_ui.css">
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
															<th scope="col">Date</th>
															<th scope="col">Time</th>
															<th scope="col">Type</th>											
															<th scope="col">Cancel</th>
															<th scope="col">Action</th>
															<th scope="col">Status</th>
															<th scope="col">Details</th>
														</tr>
													</thead>
				<?php
					$t = $mysqli->query("SELECT * FROM `games` WHERE `type`='Poker_a' ");
					$total_items= mysqli_num_rows($t);
					$limit=$_GET['limit'];
					$type=$_GET['type'];
					$page=$_GET['page'];
					if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51)){$limit = 50; }
					if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))	{$page = 1; }								
					$total_pages= ceil($total_items / $limit);
					$set_limit=$page * $limit - ($limit);			
					$q = $mysqli->query("SELECT * FROM `games`  WHERE `type`='Poker_a' ORDER BY serial DESC LIMIT $set_limit, $limit");

					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						
					
						
				?>
													<tbody>
														<tr>
															<td><?php echo $n++; ?></td>										
															<td><?php echo $querygetexeres->date; ?></td>
															<td><?php echo $querygetexeres->time; ?></td>
															<td><?php echo $querygetexeres->type;?></td>											
															<td>
															<?php if($querygetexeres->active==1){?>
																<a href="game_cancel_action.php?game=<?php echo $querygetexeres->serial; ?>" class="btn btn-danger">Cancel</a>
															<?php } ?>
															</td>
															<td> 
															<a class="btn btn-primary" href="game_done.php?game=<?php echo $querygetexeres->serial; ?>&&team=1">Win 1</a> ||
															<a class="btn btn-success" href="game_done.php?game=<?php echo $querygetexeres->serial;?>&&team=2">Win 2</a> ||
															<a class="btn btn-info" href="game_done.php?game=<?php echo $querygetexeres->serial;?>&&team=3">Win 3</a> ||
															<a class="btn btn-warning" href="game_done.php?game=<?php echo $querygetexeres->serial;?>&&team=4">Win 4</a>
															</td>
															<td><?php if($querygetexeres->active==1){echo "Active"; }else{echo "Played";};?> </td>
															<td><?php echo $querygetexeres->details;?> </td>
															
														</tr>
													</tbody>
				<?php } ?>
												</table>
				<p align="center" style="font-family:Helvetica, Arial, sans-serif;"><center>  
				<?php 
					$cat = urlencode($cat); 
					$prev_page = $page - 1;
					if($prev_page >= 1) 
					{echo("<b>&lt;&lt;</b> <a href=?limit=$limit&amp;page=$prev_page><b>Prev.</b></a>");}
					for($a = 1; $a <= $total_pages; $a++)
					{
					if($a == $page)
					{echo("<b> $a</b> | ");	}
					else 
					{echo("  <a href=?limit=$limit&amp;page=$a> $a </a> | ");}
					}
					$next_page = $page + 1;
					if($next_page <= $total_pages) 
					{ echo("<a href=?limit=$limit&amp;page=$next_page><b>Next</b></a> &gt; &gt;");}
				?>
				</center>  
				</P> 
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
			<script type="text/javascript" src="js/datetimepicker_css.js"></script>
			<script type="text/javascript" src="js/jquery_ui.js"></script>
			
			<!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>

<!-- Include Date Range Picker 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>-->


			
			
			
		
			
</body>

</html>
