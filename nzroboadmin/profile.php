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
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Update Profile Information
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
								<p style="color: red;font-size:16px;"><?php echo $_GET['msg']; ?></p> 	  	
<form class="form-horizontal" action="profileaction.php" method="post">
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">E-Mail:</label>
		<div class="col-sm-9">
		<input type="text" name="email" class="form-control" placeholder="E-Mail" value="<?php echo $row["email"];?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Paypal ID:</label>
		<div class="col-sm-9">
		<input type="text" name="paypal_id" class="form-control" placeholder="Paypal ID" value="<?php echo $row["paypal_id"];?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Payza ID:</label>
		<div class="col-sm-9">
		<input type="text" name="payza_id" class="form-control" placeholder="Payza ID" value="<?php echo $row["payza_id"];?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Joining Date:</label>
		<div class="col-sm-9">
		<input type="text" name="join_date" class="form-control" placeholder="Joining Date" value="<?php echo $row["join_date"];?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Address:</label>
		<div class="col-sm-9">
		<textarea type="text" name="address" class="form-control" placeholder="Address"> <?php echo $row["address"];?> </textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">City:</label>
		<div class="col-sm-9">
		<input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $row['district'];?>">
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">State:</label>
		<div class="col-sm-9">
		<input type="text" name="state" class="form-control" placeholder="State" value="<?php echo $row["state"];?>">
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Post Code:</label>
		<div class="col-sm-9">
		<input type="text" name="post_code" class="form-control" placeholder="Post Code" value="<?php echo $row["post_code"];?>">
		</div>
	</div>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label">Country:</label>
		<div class="col-sm-9">
		<input type="text" name="country" class="form-control" placeholder="Country" value="<?php echo $row["country"];?>"readonly>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-8">
		</div>
		<div class="col-sm-2">
		<button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: rgb(68, 157, 68);">Update</button>
		</div>
		<div class="col-sm-2">
		<button type="reset" class="btn btn-danger btn-lg btn-block">Refresh</button>
		</div>
	</div>
</form>
												<!-- /.form -->
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
<?php unset($_SESSION['msg']);?>
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
