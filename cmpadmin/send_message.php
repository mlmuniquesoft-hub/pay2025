<?php
    session_start(); 
	    if(!isset($_SESSION['Admin']))
    	{
    	header("Location:logout.php");
		exit();
    	}  
	else
	{
	require '../db/db.php';
	
	}           
?>
	<!DOCTYPE html>
<html>

<head>
    <title>NZ Support</title>
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
		<script src="https://cdn.tiny.cloud/1/xa1x2rt1m6ydm1w53n5m1yaors5sl9v3xnnrbtdhydyxrbb1/tinymce/5/tinymce.min.js"></script>
		<script>tinymce.init({ selector:'#message' });</script>
</head>
<?php
    $memberid = $_SESSION["Admin"];
    $query = "select * from `admin` where user_id='".$memberid."' ";
    $result=  $mysqli->query($query);
    $row =  mysqli_fetch_array($result);
?>

<body class="flat-blue">
    <div class="app-container expanded">
        <div class="row content-container">
		<?php 
		if($_SESSION['OriginalAdmin']!="message"){
			require_once'menu.php';
		}
		
		?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php if($_SESSION['OriginalAdmin']!="message"){ require_once'topshow.php';}?>
                    <div class="row  no-margin-bottom">
                        <div class="row">
							<div class="col-sm-3"></div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Send Email
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<div class="col-xs-12">
													<p style="color: red;font-size:16px;margin-left:15px;"><?php 
														if(isset($_SESSION['msg'])) {
															echo $_SESSION['msg']; 
															unset($_SESSION['msg']);
														}
													?></p>
													<p style="color: green;font-size:16px;margin-left:15px;"><?php 
														if(isset($_SESSION['msg1'])) {
															echo $_SESSION['msg1']; 
															unset($_SESSION['msg1']);
														}
													?></p>
													<form class="form-horizontal" action="send_message_action.php" method="post" name="memberpasschng">
														<div class="form-group" style="margin:10px 0;">
															<label class="col-sm-3 control-label">Send Criteria:</label>
															<div class="col-sm-8">
																<input type="radio" class="SendOPty" name="send_cri" value="1" checked />User ID &nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" class="SendOPty" name="send_cri" value="2" />All User &nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio" class="SendOPty" name="send_cri" value="3" />Country User &nbsp;&nbsp;&nbsp;&nbsp;<br/>
																<input type="radio" class="SendOPty" name="send_cri" value="4" />User Pack
															</div>
														</div>
														<div class="form-group" style="margin:10px 0;">
															<label class="col-sm-3 control-label">Send To:</label>
															<div class="col-sm-8">
																<input type="checkbox" class="SendOPty1" name="send_to[]" value="1" checked />Notify Account &nbsp;&nbsp;&nbsp;&nbsp;
																<input type="checkbox" class="SendOPty1" name="send_to[]" value="2" />Send Mail &nbsp;&nbsp;&nbsp;&nbsp;
																
															</div>
														</div>
														
														<div class="form-group opirtr" id="SendOp1" style="margin:10px 0;">
															<label class="col-sm-3 control-label">User ID:</label>
															<div class="col-sm-8">
																<input type="text" name="user_id" class="form-control" placeholder="User ID">
															</div>
														</div>
														<div class="form-group opirtr" id="SendOp2" style="display:none;margin:10px 0;">
															
														</div>
														<div class="form-group opirtr" id="SendOp3" style="display:none;margin:10px 0;">
															<label class="col-sm-3 control-label">Country:</label>
															<div class="col-sm-8">
																
																<select name="countr" class="form-control">
																	<option value="">Select Country</option>
																<?php
																	$jkhgd=$mysqli->query("SELECT * FROM `country`");
																	while($allBv=mysqli_fetch_assoc($jkhgd)){
																?>
																	<option value="<?php echo $allBv['name']; ?>"><?php echo $allBv['name']; ?></option>
																<?php
																	}
																?>
																</select>
															</div>
														</div>
														<div class="form-group opirtr" id="SendOp4" style="display:none;margin:10px 0;">
															<label class="col-sm-3 control-label">Package:</label>
															<div class="col-sm-8">
																
																<select name="packj" class="form-control">
																	<option value="">Select Package</option>
																<?php
																	$jkhgd=$mysqli->query("SELECT * FROM `package`");
																	while($allBv=mysqli_fetch_assoc($jkhgd)){
																?>
																	<option value="<?php echo $allBv['serial']; ?>"><?php echo $allBv['pack']; ?></option>
																<?php
																	}
																?>
																</select>
															</div>
														</div>
														
														<div class="form-group" style="margin:10px 0;">
															<label class="col-sm-3 control-label">Subject:</label>
																<div class="col-sm-8">
																	<input type="text" name="subj" class="form-control" placeholder="Subject">
																	<input type="hidden" name="location" value="<?php echo $_SERVER["PHP_SELF"]; ?>">
																</div>
														</div>
														<div class="form-group" style="margin:10px 0;">
															<label class="col-sm-3 control-label">Message:</label>
																<div class="col-sm-8">
																	<textarea class="form-control" id="message" name="mess" placeholder="Type Message"></textarea>
																</div>
														</div>
														<div class="form-group" style="margin:10px 0;">
															<div class="col-sm-3"></div>
															<div class="col-sm-4">
																<button class="btn btn-lg btn-block my-btn" name="submit" type="submit" />Send Email</button>
															</div>
															<div class="col-sm-4">
																<button class="btn btn-lg btn-block my-btn" name="reset" type="reset" />Refresh</button>
															</div>
														</div>
													</form>
												</div>
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
							
							<!--.col-lg-3 --> 
						</div>
						<!--.row-->                        
                    </div>
                </div>
            </div>
        </div>
			<?php require_once'footer.php'?>
	</div>
<?php 
unset($_SESSION['msg']);
unset($_SESSION['msg1']);
?>
            <!-- Javascript Libs -->
             <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
            <script type="text/javascript" >
				$(".SendOPty").on("click", function(){
					let sdfs=$(this).val();
					$(".opirtr").hide();
					$("#SendOp"+sdfs).show();
				});
			</script>
            <script type="text/javascript" src="lib/js/Chart.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
        
            <script type="text/javascript" src="lib/js/ace/ace.js"></script>
            <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
            <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <!--<script type="text/javascript" src="js/index.js"></script>-->
</body>

</html>
