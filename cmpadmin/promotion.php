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
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Promotion Setting
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row" style="padding: 20px;">
	<?php
		if(isset($_GET['slide'])){
		$serial=$_GET['slide'];
		$query_slide=mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM slide WHERE serial='".$serial."'"));
		}
	?>
	<form class="form-horizontal" action="slide_upload.php" method="post" enctype="multipart/form-data">
		<p style="color: red; text-align: center;"> <?php echo $_SESSION['msg']; ?> </p>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Image Description</label>
			<div class="col-sm-4">
				<input type="text" class="form-control"  name="desc" max-length="100" value="<?php echo $query_slide['desc']; ?>" />
			</div>
		</div>
		<input type="hidden" name="serial" value="<?php echo $serial; ?>">
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Original Image</label>
			<div class="col-sm-4">
				<input type="file" class="form-control"  name="img1" value="<?php echo  $query_slide['image']; ?>" <?php if(isset($_GET['slide'])){echo disabled; } ?>/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Top Value</label>
			<div class="col-sm-4">
				<input type="number" class="form-control"  name="top" value="<?php echo $query_slide['top']?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Left Value</label>
			<div class="col-sm-4">
				<input type="number" class="form-control"  name="left" value="<?php echo $query_slide['left']?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Text Color</label>
			<div class="col-sm-4">
				<input type="color" class="form-control"  name="text_color" value="<?php echo $query_slide['text_color']?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label">Background Color</label>
			<div class="col-sm-4">
				<input type="color" class="form-control"  name="background" value="<?php echo $query_slide['background']?>"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2"></div>
			<?php 
			if(isset($_GET['slide'])){
			?>
			<div class="col-sm-4">
			<button type="submit" name="update" class="btn btn-success btn-block">Update</button>
			</div>
			<?php } else{ ?>
			<div class="col-sm-4">
			<button type="submit" name="submit" class="btn btn-success btn-block">Submit</button>
			</div>
			<div class="col-sm-4">
			<button type="reset" class="btn btn-primary btn-block">Refresh</button>
			</div>
			<?php } ?>
		</div>
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