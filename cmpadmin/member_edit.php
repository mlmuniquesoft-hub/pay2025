<?php
	session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		//var_dump($mysqli2);
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
											<i class="fa fa-bar-chart-o fa-fw"></i> Rename User ID
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<form class="form-horizontal" action="rename_action.php" method="post">
													<div class="form-group">
														<h3 class="text-center text-success"><?php echo $_SESSION['rename1']; ?></h3>
														<h3 class="text-center text-danger"><?php echo $_SESSION['rename']; ?></h3>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Current User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="pastID" class="form-control" placeholder="Current User Id" />
														</div>
													</div>
													
													<div class="form-group">
														<label class="col-sm-4 control-label">New User Id:</label>
														<div class="col-sm-8">
															<input type="text" name="newID" class="form-control" placeholder="New User Id" />
															<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-6"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
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
								<div class="col-xs-12 col-sm-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Re-Password Member id
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<p style="color: red;font-size:16px;"><?php echo $_GET['msg']; ?></p>
												<form class="form-horizontal" action="member_pass_pin_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="user" class="form-control" placeholder="User Id" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Type:</label>
														<div class="col-sm-7">
															<select class="form-control" name="type" >
																<option value="pass">Password</option>
																<option value="pin">Tr-Pin</option>			 					 
															</select>
														</div>
													</div>
													<div class="form-group" >
														<label class="col-sm-4 control-label">Default Value :</label>
														<div class="col-sm-8">
															<h4 class="text-warning" style="margin:0;padding:0;">123456</h4>
														</div>
													</div>
													<div class="form-group" style="display:none;">
														<label class="col-sm-4 control-label">New Password :</label>
														<div class="col-sm-8">
															<input type="password" name="newPassword1" class="form-control" placeholder="New Password" value="123456" />
														</div>
													</div>
													
													<div class="form-group" style="display:none;">
														<label class="col-sm-4 control-label">Re-Password:</label>
														<div class="col-sm-8">
															<input type="password" name="newPassword2" class="form-control" placeholder="New Password" value="123456"/>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-4"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Set Default">
														</div>
														<div class="col-sm-4">
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
								</div><!-- /.col-sm-12 (nested) -->
							</div>
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
															<input type="hidden" name="mee" value="member" />
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
													$member_id=$_GET['member'];
													$query = "select * from member where user='".$member_id."' ";
													$result= $mysqli->query($query);
													$row = mysqli_fetch_array($result);	
													$query1 = "select * from `profile` where user='".$row['log_user']."' ";
													$result1= $mysqli->query($query1);
													$row1 = mysqli_fetch_array($result1);
													$query2 = "select * from balance where user='".$member_id."' ";
													$result2= $mysqli->query($query2);
													$row2 = mysqli_fetch_array($result2);	
													if($member_id!=''){
													?> 	  	
												<form class="form-horizontal" action="profile_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="user_id" class="form-control" value="<?php echo $row["user"];?>" placeholder="User Id" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Name :</label>
														<div class="col-sm-8">
															<input type="text" name="user_name" class="form-control" value="<?php echo $row1["name"];?>" placeholder="Name" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">E-Mail :</label>
														<div class="col-sm-8">
															<input type="text" name="email" class="form-control" value="<?php echo $row1["email"];?>" placeholder="E-Mail" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Contact Number :</label>
														<div class="col-sm-8">
															<input type="text" name="contact" class="form-control" value="<?php echo $row1["mobile"];?>" placeholder="number" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Package:</label>
														<div class="col-sm-8">
															<select class="form-control" name="pacc">
																<option value="">Select Package</option>
																<?php
																	$myJJ=$mysqli->query("SELECT * FROM `package` ");
																	while($Allpass=mysqli_fetch_assoc($myJJ)){
																?>
																<option value="<?php echo $Allpass['serial']; ?>" <?php if($Allpass['serial']==$row['pack']){echo "selected";}?>><?php echo $Allpass['pack']; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Reffer Condition:</label>
														<div class="col-sm-8">
															<input type="radio" class="ssdf" data-show="RefAmn" data-hide="ssa" name="Jkkm" value="1" <?php if($row['ref_con']>0){echo "checked"; }?>/>Yes &nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" class="ssdf" data-show="ssa" data-hide="RefAmn" name="Jkkm" value="0" <?php if($row['ref_con']==0){echo "checked"; }?>/>No 
														</div>
													</div>
													<div class="form-group" id="RefAmn" style="display:<?php if($row['ref_con']>0){echo "block"; }else{echo "none";}?>;">
														<label class="col-sm-4 control-label">Reffer Amount:</label>
														<div class="col-sm-8">
															<input type="number" name="REfmn" value="<?php echo $row['ref_con']; ?>" class="form-control" />
															
														</div>
													</div>
													
													<div class="form-group">
														<div class="col-sm-6"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
														</div>
													</div>
												</form>
												<?php }?>
											</div>
											<!-- /.row -->
										</div>
										<!-- /.panel-body -->
									</div>
									<!-- /.panel -->
								</div>
								<div class="col-xs-12 col-sm-6">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Update  Member Placement
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<p style="color: red;font-size:16px;"><?php //echo $_GET['msg']; ?></p>
												<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg4']; ?></p>
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg3']; ?></p>
												<form class="form-horizontal" action="search_by_member_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User Id :</label>
														<div class="col-sm-8">
															<input type="text" name="userID" class="form-control" placeholder="User Id" />
															<input type="hidden" name="mee" value="member2" />
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
													$member_id=$_GET['member2'];
													$query = "select * from member where user='".$member_id."' ";
													$result= $mysqli->query($query);
													$row = mysqli_fetch_array($result);	
													$query1 = "select * from `profile` where user='".$row['log_user']."' ";
													$result1= $mysqli->query($query1);
													$row1 = mysqli_fetch_array($result1);
													$query2 = "select * from balance where user='".$member_id."' ";
													$result2= $mysqli->query($query2);
													$row2 = mysqli_fetch_array($result2);	
													if($member_id!=''){
													?> 	  	
												<form class="form-horizontal" action="profile_place_action.php" method="post">
													<div class="form-group">
														<label class="col-sm-4 control-label">User CID :</label>
														<div class="col-sm-6">
															<input type="text" name="user_cid" id="user_cid" class="form-control" value="<?php echo $row["log_user"];?>" placeholder="User CID" />
															<input type="hidden" name="user_cid_prev"  value="<?php echo $row["log_user"];?>" />
															<input type="hidden" name="update_user"  value="<?php echo $member_id;?>" />
														</div>
														<div class="col-sm-2">
															<button class="btn btn-info btn-block" type="button" id="check-Cid">Check</button>
														</div>
													</div>
													<div class="form-group">
														<p style="color:red;text-align:center;" id="error"></p>
														<p style="color:green;text-align:center;" id="succ"></p>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Placement ID :</label>
														<div class="col-sm-8">
															<input type="text" name="user_placeId" class="form-control" value="<?php echo $row["upline"];?>" placeholder="Placement ID" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Placement Position :</label>
														<div class="col-sm-8">
															<input type="radio" name="place_user"  value="1" <?php if($row['position']=="1"){echo "checked";}?> />Left  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio" name="place_user"  value="2" <?php if($row['position']=="2"){echo "checked";}?> />Right  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Sponsor ID :</label>
														<div class="col-sm-8">
															<input type="text" name="sponsorr" class="form-control" value="<?php echo $row["sponsor"];?>" placeholder="Sponsor ID" />
														</div>
													</div>
													
													<div class="form-group">
														<div class="col-sm-6"></div>
														<div class="col-sm-4">
															<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
														</div>
													</div>
												</form>
												<?php }?>
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
			unset($_SESSION['rename1']);
			unset($_SESSION['rename']);
		?>
		<!-- Javascript Libs -->
		<script type="text/javascript" src="lib/js/jquery.min.js"></script>
		<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
		<script >
			$(document).ready(function(){
				$(".ssdf").on("click", function(){
					var yy=$(this).attr("data-show");
					var yy2=$(this).attr("data-hide");
					$("#"+yy2).hide();
					$("#"+yy).show();
				});
				$("#check-Cid").on("click", function(){
					$("#error").text("");
					$("#succ").text("");
					var hhg=$("#user_cid").val();
					if(hhg!=''){
						var ffdd=$.ajax({
							method:"GET",
							url:"",
							data:{ccdd:hhg}
						});
						ffdd.done(function(ffgg){
							console.log(ffgg);
							var ttt=JSON.parse(ffgg);
							if(ttt[0]==1){
								$("#succ").text(ttt[1]);
							}else{
								$("#error").text(ttt[1]);
							}
						});
					}else{
						$("#error").text("You Have To Give CID");
					}
				});
			});
		</script>
		
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