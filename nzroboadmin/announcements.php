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
                        <div class="row">
							<div class="col-sm-3"></div>
							<div class="col-sm-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Announcements Setting
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row" style="padding: 20px;">
<?php
$query = "SELECT * FROM notice where user='admin'"; 
$exe=$mysqli->query($query);
$result=mysqli_fetch_array($exe);
?>
<form action="notice_action_1.php" method="POST" > 
	<div class="form-group">
		<p style="font-size:18px;"><span id="fade"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></span></p>
	</div>
	<div class="form-group">
		<label>Font-Type:</label>
		<input type="text" name="body_font" value="<?php echo $result['font']; ?>" class="form-control"/>
	</div>
	<div class="form-group">
		<label>Font-Color:</label>
		<input type="color" name="body_color" value="<?php echo $result['color']; ?>" class="form-control"/>
	</div>

	<div class="form-group">
		<label>Font-Size:</label>
		<input type="text" name="body_size" value="<?php echo $result['font_size']; ?>" class="form-control">
	</div>

	<textarea class="form-control" rows="3" cols="23" name="body_text"><?php echo $result['body']; ?></textarea>
	<input type="hidden" name="notice_for" value="annoucement" />
	<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>" />

	<button type="reset" value="Refresh" class="btn btn-primary">Refresh</button>
	<button type="submit" value="Submit" class="btn btn-success">Submit</button>
</form> 
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
    </div>
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
