<?php
	session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		if(isset($_GET['ccdd'])){
			$cggh=$_GET['ccdd'];
			$rett=array();
			if($cggh==''){
				array_push($rett, 0);
				array_push($rett, "Empty CID");
				echo json_encode($rett);
				die();
			}
			$chh=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `log_user`='".$cggh."'"));
			if($chh>0){
				array_push($rett, 0);
				array_push($rett, "Already Used");
				echo json_encode($rett);
				die();
			}else{
				array_push($rett, 1);
				array_push($rett, "This CID Is Available");
				echo json_encode($rett);
				die();
			}
			die();
		}
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
								<div class="col-xs-12 col-sm-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i>Update Member Information
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<p style="color: red;font-size:16px;"><?php echo $_GET['msg']; ?></p>
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p>
												<form class="form-horizontal" action="search_by_member_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="userID" class="form-control" placeholder="User Id" />
															<input type="hidden" name="mee" value="member3" />
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-6"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
														</div>
													</div>
												</form> 
													<?php
													$member_id=$_GET['member3'];
													$query = "select * from member where user='".$member_id."' ";
													$result= $mysqli->query($query);
													$row = mysqli_fetch_array($result);	
													$query1 = "select * from `profile` where user='".$row['log_user']."' ";
													$result1= $mysqli->query($query1);
													$row1 = mysqli_fetch_array($result1);
													$query2 = "select * from balance where user='".$member_id."' ";
													$result2= $mysqli->query($query2);
													$row2 = mysqli_fetch_array($result2);	
													$Decudt=mysqli_fetch_assoc($mysqli->query("SELECT SUM(`amount`) AS asda FROM `bal_deduct` WHERE `user`='".$member_id."'"));
													if($member_id!=''){
													?> 	  	
												<form class="form-horizontal" action="bal_deduct_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="user_id" class="form-control" value="<?php echo $row["user"];?>" placeholder="User Id" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Curent Balance:</label>
														<div class="col-sm-8">
															<input type="text" name="ddd" class="form-control" value="<?php echo $row2["final_taka"];?>" placeholder="Balance" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Previous Deduct:</label>
														<div class="col-sm-8">
															<input type="text" name="ddd22" class="form-control" value="<?php echo $Decudt["asda"];?>" placeholder="Balance" readonly />
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-sm-4 control-label">Deduct Reason:</label>
														<div class="col-sm-8">
															<input type="text" name="dddres" class="form-control" value="" placeholder="Deduct Reason" />
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-sm-4 control-label">Deduct Amount:</label>
														<div class="col-sm-8">
															<input type="text" name="ddaamn" class="form-control" value="" placeholder="Amount USD" />
														</div>
													</div>
													
													
													<div class="form-group">
														<div class="col-sm-6"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
														</div>
													</div>
												</form>
												<?php } ?>
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
			</div>
		<?php 
			unset($_SESSION['msg']);
			unset($_SESSION['msg4']);
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