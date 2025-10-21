<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		//require_once '../db/template.php';
	}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
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
                        <div class="col-sm-3 col-xs-12"></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Transfer to Member
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
										<p style="color: red;font-size:16px;"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></p>
										<p style="color: green;font-size:16px;"><?php echo isset($_SESSION['msg1']) ? $_SESSION['msg1'] : ''; ?></p>
<form class="form-horizontal" action="balance_transfer_action.php" method="post" method="post">
	<div class="form-group">
		<label class="col-sm-3 control-label">Member ID:</label>
		<div class="col-sm-8">
		<input type="text" name="user" class="form-control" placeholder="Member ID" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Amount:</label>
		<div class="col-sm-8">
		<input type="text" name="quantity" class="form-control" placeholder="Amount" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Transaction Pin:</label>
		<div class="col-sm-8">
		<input type="password" name="pincode" class="form-control" placeholder="Pin" />
		<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-5">
		</div>
		<div class="col-sm-3">
		<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
		</div>
		<div class="col-sm-3">		
		<input class="btn btn-danger btn-lg btn-block" type="reset" name="reset" value="Refresh">
		</div>
	</div>
</form>	
										</div>
										<!-- /.row -->
									</div>
									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->
                            </div>
							<!--.row-->
                        </div>
						<!--.col-lg-6 -->
                    </div>
                </div>
            </div>
        </div>
			<?php require_once'footer.php'?>
        <div>
<?php 
unset($_SESSION['msg']);
unset($_SESSION['msg1']);
?>
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
