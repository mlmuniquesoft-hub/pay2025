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
					<div class="row col-md-12 custyle">
						<form action="">
						<table class="table table-striped custab">
						<thead>
						
							<tr>
								<th>ID</th>
								<th>Package Name</th>
								<th>Change</th>
								<th>Active</th>
								
								<th class="text-center">Action</th>
							</tr>
						</thead>
							<tr>
								<td>1</td>
								<td>
									News <br />
									News <br />
									News <br />
								</td>
								<td>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-7 control-label" style="text-align: center;">News</label>
										<div class="col-sm-5">
											<input type="text" name="package1" class="form-control" placeholder="" />
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-7 control-label" style="text-align: center;">News</label>
										<div class="col-sm-5">
											<input type="text" name="package2" class="form-control" placeholder=" " />
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-7 control-label" style="text-align: center;">News</label>
										<div class="col-sm-5">
											<input type="text" name="package3" class="form-control" placeholder=" " />
										</div>
									</div>
								</td>
								<td>
									<form action="#" data-toggle="validator">
										<div class="form-group has-feedback">
											<label class="input-group">
												<span class="input-group-addon">
													<input type="radio" name="test" value="0" />
												</span>
												<div class="form-control form-control-static">
													Active
												</div>
												<span class="glyphicon form-control-feedback "></span>
											</label>
										</div>
										<div class="form-group has-feedback ">
											<label class="input-group">
												<span class="input-group-addon">
													<input type="radio" name="test" value="1" />
												</span>
												<div class="form-control form-control-static">
													Inactive
												</div>
												<span class="glyphicon form-control-feedback "></span>
											</label>
										</div>
									</form>
								</td>
							   
								
								
								<td class="text-center"><a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Cancel</a></td>
							</tr>
						</table>
						</form>
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
