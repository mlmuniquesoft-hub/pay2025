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
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Pending Balance Sheet
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
		<p style="color: red;font-size:16px;margin-left:15px;"><?php echo $_GET['msg']; ?></p>
			<thead>
				<tr>
					<th>Withdrawl Date</th>
					<th>Member</th>
					<th>Pay ID</th>
					<th>Amount</th>
					<th>Status</th>
				</tr>
		<?php
			/*$t =   $mysqli->query("SELECT * FROM trans_receive where user_receive='".$memberid."' and status='Pending'");
			if(!$t) die( mysqli_error());
								   
			$a=  mysqli_fetch_object($t);
			$total_items=  mysqli_num_rows($t);
			$limit=$_GET['limit'];
			$type=$_GET['type'];
			$page=$_GET['page'];
			if((!$limit)  || (is_numeric($limit) == false) || ($limit < 14) || ($limit > 16))
 			{$limit = 15; }
			if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
			{$page = 1; }
								
			$total_pages= ceil($total_items / $limit);
			$set_limit=$page * $limit - ($limit);					
		
			$q =   $mysqli->query("SELECT * FROM trans_receive where user_receive='".$memberid."' and status='Pending' LIMIT $set_limit, $limit");
			if(!$q) die( mysqli_error());
			$err =  mysqli_num_rows($q);	  
	        while($querygetexeres=  mysqli_fetch_object($q))
	        {*/
	    ?>
				<tr>
					<td><?php echo $querygetexeres->date;?></td>
					<td><?php echo $querygetexeres->user_trans;?></td>
					<td><?php echo $querygetexeres->serialno;?></td>
					<td><?php echo $querygetexeres->ammount;?></td>
					<td><?php echo $querygetexeres->status;?></td>
				</tr>
			</thead>
		</table>
	</div>
	<!-- /.table-responsive -->
		<?php 
			/*$cat = urlencode($cat); 
            $prev_page = $page - 1;
			if($prev_page >= 1) 
			{echo("<b>&lt;&lt;</b> <a href=statement_transfer.php?limit=$limit&amp;page=$prev_page><b>Prev.</b></a>");}
			for($a = 1; $a <= $total_pages; $a++)
			{
			if($a == $page)
			{echo("<b> $a</b> | ");	}
			else 
			{echo("  <a href=statement_transfer.php?limit=$limit&amp;page=$a> $a </a> | ");}
			}
			$next_page = $page + 1;
			if($next_page <= $total_pages) 
			{ echo("<a href=statement_transfer.php?limit=$limit&amp;page=$next_page><b>Next</b></a> &gt; &gt;");}*/
 	    ?>
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
                        <div class="col-sm-6 col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Paid Balance Sheet
									<div class="pull-right"> </div>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-lg-12">
	<div class="table-responsive">
		<table class="table table-bordered table-hover table-striped">
		<p style="color: red;font-size:16px;margin-left:15px;"><?php echo $_GET['msg']; ?></p>
			<thead>
				<tr>
					<th>Withdrawl Date</th>
					<th>Member</th>
					<th>Amount</th>
					<th>Status</th>
				</tr>
		<?php
			/*$t =   $mysqli->query("SELECT * FROM trans_receive where user_receive='".$memberid."' and status='Paid'");
			if(!$t) die( mysqli_error());
								   
			$a=  mysqli_fetch_object($t);
			$total_items=  mysqli_num_rows($t);
			$limit=$_GET['limit'];
			$type=$_GET['type'];
			$page=$_GET['page'];
			if((!$limit)  || (is_numeric($limit) == false) || ($limit < 14) || ($limit > 16))
 			{$limit = 15; }
			if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
			{$page = 1; }
								
			$total_pages= ceil($total_items / $limit);
			$set_limit=$page * $limit - ($limit);					
		
			$q =   $mysqli->query("SELECT * FROM trans_receive where user_receive='".$memberid."' and status='Paid' LIMIT $set_limit, $limit");
			if(!$q) die( mysqli_error());
			$err =  mysqli_num_rows($q);	  
	        while($querygetexeres=  mysqli_fetch_object($q))
	        {*/
	    ?>
				<tr>
					<td><?php echo $querygetexeres->date;?></td>
					<td><?php echo $querygetexeres->user_trans;?></td>
					<td><?php echo $querygetexeres->ammount;?></td>
					<td><?php echo $querygetexeres->status;?></td>
				</tr>
			<?php //} ?>
			</thead>
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
