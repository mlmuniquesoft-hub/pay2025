<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_agent.php';
		require_once '../db/template.php';
		$memberid=$_SESSION['Admin'];
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
    <div class="app-container">
        <div class="row content-container">
		<?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="row">
							<div class="col-sm-3"></div>
							<div class="col-sm-6 col-xs-12">
								<div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Payment Method Setup
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<div class="col-xs-12">
												   <p style="color: red;font-size:16px;margin-left:15px;"><?php echo $_SESSION['msg']; ?></p>
												   <p style="color: red;font-size:16px;margin-left:15px;"><?php echo $_SESSION['msg1']; ?></p>
													<form class="form-horizontal" action="payment_setup_action.php" method="post" name="memberpasschng">
														<div class="form-group">
															<label class="col-sm-3 control-label">Payment Option:</label>
															<div class="col-sm-3">
																<input type="radio" name="option1" class="oopp ffrr" value="Mbanking">Mbanking
															</div>
															<div class="col-sm-3">
																<input type="radio" name="option1" class="oopp ffrr" value="Bank">Bank
															</div>
															<div class="col-sm-3">
																<input type="radio" name="option1" class="oopp ffrr" value="Online">Online Gateway
															</div>
														</div>
														<div class="Mbanking hiidd">
															<div class="form-group Mbanking" style="display:none;">
																<label class="col-sm-3 control-label">Payment Option:</label>
																<div class="col-sm-3">
																	<input type="radio" name="option2" class="oopp" value="Bkash" >Bkash
																</div>
																<div class="col-sm-3">
																	<input type="radio" name="option2" class="oopp" value="Roket" >Roket
																</div>
															</div>
														</div>
														<div class="Bank hiidd">
															<div class="form-group Bank" style="display:none;">
																<label class="col-sm-3 control-label">Payment Option:</label>
																<div class="col-sm-4">
																	<input type="radio" name="option2" class="oopp ggff" value="Bank_Details">Account Details
																</div>
																<div class="col-sm-4">
																	<input type="radio" name="option2" class="oopp ggff" value="Card">DBBL NEXUS CARD
																</div>
															</div>
															<div class="Bank_Details ddffdd" style="display:none;">
																<div class="form-group">
																	<label class="col-sm-3 control-label">Bank Name:</label>
																	<div class="col-sm-8">
																		<input type="text" class="form-control" name="bank_name" placeholder="Bank Name" />
																		<input type="hidden"  name="location" value="<?php echo $_SERVER["PHP_SELF"]; ?>" />
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-sm-3 control-label">Account Holder Name:</label>
																	<div class="col-sm-8">
																		<input type="text" class="form-control" name="holder_name" placeholder="Account Holder Name" />
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-sm-3 control-label">Branch Name:</label>
																	<div class="col-sm-8">
																		<input type="text" class="form-control" name="branch" placeholder="Account Holder Name" />
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-sm-3 control-label">Account Number:</label>
																	<div class="col-sm-8">
																		<input type="text" class="form-control" name="account_number" placeholder="Account Holder Name" />
																	</div>
																</div>
															</div>
														</div>
														<input type="hidden" name="user" value="<?php echo $_SESSION['Admin']; ?>" />
														<div class="Online hiidd">
															<div class="form-group Online" style="display:none;">
																<label class="col-sm-3 control-label">Payment Option:</label>
																	<div class="col-sm-3">
																		<input type="radio" name="option2" class="oopp" value="Paypal">Paypal
																	</div>
																	<div class="col-sm-3">
																		<input type="radio" name="option2" class="oopp" value="Payza">Payza
																	</div>
															</div>
															
														</div>
														<div class="form-group Bkash Roket Payza Paypal Card ddffdd" style="display:none;">
															<label class="col-sm-3 control-label">Number:</label>
															<div class="col-sm-8">
																<input type="number" class="form-control" name="b_number" placeholder="Enter Your Card Number">
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">Password:</label>
																<div class="col-sm-8">
																	<input type="password" name="pincode" class="form-control" placeholder="Password">
																</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3"></div>
															<div class="col-sm-4">
																<button class="btn btn-success btn-lg btn-block" name="submit" type="submit" />Submit</button>
															</div>
															<div class="col-sm-4">
																<button class="btn btn-danger btn-lg btn-block" name="reset" type="reset" />Refresh</button>
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
							<div class="col-xs-12">								
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Payment Method List
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="table-responsive" style="background-color: #e4e4e4;">
													<table class="table table-bordered table-hover table-striped">
														<thead>
															<tr>
																<th>Create Date</th>
																<th>Payment Method</th>
																<th>Payment Details</th>
																<th>Status</th>
																<th>Action</th>
															</tr> 
														</thead>
     
<?php

	$q=$mysqli->query("SELECT * FROM `payment_setup` where `user`='".$memberid."' ");
	while($querygetexeres=  mysqli_fetch_object($q))
	{
	?>
						<thead class="del<?php echo $querygetexeres->serial; ?>">
							<tr>
								<th><?php echo date("Y-m-d", strtotime($querygetexeres->date));?></th>
								<th><?php echo $querygetexeres->option2;?></th>
								<th><?php 
										if($querygetexeres->b_number!=''){
											echo $querygetexeres->option1." ". $querygetexeres->b_number ."<br/>";
										}else{
											if($querygetexeres->bank_name!=''){
												echo "Bank Name:  ". $querygetexeres->bank_name ."<br/>";
											}
											if($querygetexeres->account_number!=''){
												echo "Bank Account Number:  ". $querygetexeres->account_number ."<br/>";
											}
											if($querygetexeres->branch!=''){
												echo "Bank Branch Name:  ". $querygetexeres->branch ."<br/>";
											}
											if($querygetexeres->holder_name!=''){
												echo "Account Holder Name:  ". $querygetexeres->holder_name ."<br/>";
											}
										}
								?></th>
								<td>
										<form action="#" data-toggle="validator">
											<div class="form-group has-feedback">
												<label class="input-group upgg" data-vals="1" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="active">
													<span class="input-group-addon">
														<input type="radio"  name="test" value="1" <?php if($querygetexeres->active==1){echo "checked"; }?>/>
													</span>
													<div class="form-control form-control-static">
														Active
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
											<div class="form-group has-feedback ">
												<label class="input-group upgg" data-vals="0" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="active">
													<span class="input-group-addon">
														<input type="radio" name="test" value="0" <?php if($querygetexeres->active==0){echo "checked"; }?>/>
													</span>
													<div class="form-control form-control-static">
														Inactive
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
										</form>
									</td>
								   
									
									<td class="text-center">
										<button href="#" class="btn btn-danger btn-sm upgg" data-vals="Delete" data-serial="<?php echo $querygetexeres->serial; ?>"><span class="glyphicon glyphicon-remove"></span> Delete</button>
									</td>
							</tr>
						</thead>
<?php } ?>

														
													</table>
												</div>

												<!-- /.table-responsive -->
											</div>
											<!-- /.col-xs-12 (nested) -->
										</div>
										<!-- /.row -->
									</div>
									<!-- /.panel-body -->
								</div>
								<!-- /.panel -->
							</div>
							<!--.col-lg-3 --> 
						</div>
						<!--.row-->                        
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
			
            <script >
				$(document).ready(function(){
					
					$(".upgg").on("click", function(e){
						//e.preventDefault();
						//e.stopPropagation();
						var vals=$(this).attr("data-vals");
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						if(vals=="Delete"){
							$(".del"+srl).hide();
						}
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"payment_setup"}
							});
						}
					});
					
					$(".oopp").on("click", function(){
						var yy=$(this).val();
						$("."+yy).show();
					});
					$(".ffrr").on("click", function(){
						$(".hiidd").hide();
						var yy=$(this).val();
						$("."+yy).show();
					});
					$(".ggff").on("click", function(){
						$(".ddffdd").hide();
						var yy=$(this).val();
						$("."+yy).show();
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
