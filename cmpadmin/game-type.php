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
										<i class="fa fa-bar-chart-o fa-fw"></i> Game type Setup
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
								<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p> 	  	
								<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg1']; ?></p> 	  	
								<form class="form-horizontal" action="game_type_set_action.php" method="POST">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">Type Name:</label>
										<div class="col-sm-9">
											<input type="text" name="game_type" class="form-control" placeholder="Game Type" />
										</div>
									</div>
									<div class="col-sm-9 " style="padding-top: 20px;">
										<div id="field">
											<div id="field0">
										<!-- Text input-->
												<div class="form-group">
													<label class="col-md-4 control-label" for="action_id">Amount Slot</label>  
													<div class="col-md-4">
														<input id="action_id" name="action_id[]" type="number" placeholder="" class="form-control input-md">
													</div>
												</div>
											</div>
										</div>
									
									
										<div class="form-group">
										  <div class="col-md-4">
											<button id="add-more" name="add-more" class="btn btn-primary">Add More</button>
										  </div>
										</div>
									<br><br>
									</div>
	
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">Return Amount :</label>
										<div class="col-sm-9">
											<input type="text" name="return_amount" class="form-control" placeholder="Return Amount" />
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">Return Distribation :</label>
										<div class="col-sm-4">
											<input type="text" name="bounes_wallet" class="form-control" placeholder="B.W " />
										</div>
										<div class="col-sm-4">
											<input type="text" name="current_welt" class="form-control" placeholder="C.W " />
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">Renew  :</label>
										<div class="col-sm-9">
											<input type="text" name="renew_duration" class="form-control" placeholder="Renew " />
										</div>
									</div>
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">Renew Charge :</label>
										<div class="col-sm-9">
											<input type="text" name="renew_charge" class="form-control" placeholder="Renew Charge " />
										</div>
									</div>
									
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-3 control-label">How many time play</label>
										<div class="col-sm-4">
											<div class="form-group has-feedback">
												<label class="input-group onetime">
													<span class="input-group-addon">
														<input type="radio" name="tiimm" value="0" />
													</span>
													<div class="form-control form-control-static">
														Onetime
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group has-feedback ">
												<label class="input-group" id="multiple">
													<span class="input-group-addon">
														<input type="radio" name="tiimm" value="1" />
														<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
													</span>
													<div class="form-control form-control-static">
														Multiple
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
												<div class="form-group multiple" style="display:none;">
													<input type="number" name="time_play" class="form-control" placeholder="How Many Time" />
												</div>
											</div>
										</div>
										
									</div>
									
									<div class="form-group">
										<div class="col-sm-8">
										</div>
										<div class="col-sm-2">
										<button type="submit" class="btn btn-primary btn-lg btn-block" style="background-color: rgb(68, 157, 68);">Submit</button>
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
					
					<div class="container">
    <div class="row col-md-11 custyle">
    <div class="table-responsive">
    <table class="table table-striped table-bordered custab">
    <thead>
    
        <tr>
            <th>ID</th>
            <th>Game Type</th>
            <th>Slot</th>
            <th>Return Amount</th>
            <th>Return Distribation</th>
            <th>Renew After</th>
            <th>Renew Charge</th>
            <th>Trade Fixed</th>
            <th>On/Off</th>
			
            <th class="text-center">Action</th>
        </tr>
    </thead>
			<?php
				$nnmm=$mysqli->query("SELECT * FROM `gamesetup`");
				$n=1;
				while($yyy=mysqli_fetch_assoc($nnmm)){
			?>
            <tr class="del<?php echo $yyy['serial']; ?>">
                <td><?php echo $n++; ?></td>
                <td style="min-width: 211px;"><input type="text" value="<?php echo $yyy['game_type']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="game_type" name="return_amount" class="form-control uupp" placeholder=" " /></td>
                <td style="min-width: 211px;"><input type="text" value="<?php echo $yyy['action_id']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="action_id" name="return_amount" class="form-control uupp" placeholder=" " /></td>
                <td styyle="min-width: 100px;">
					<?php $yyyj=explode("/", $yyy['return_amount']); ?>
					Win Return
					<input type="text" value="<?php echo $yyyj[0]; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="return_amount" id="jj<?php echo $yyy['serial']; ?>" name="return_amount" class="form-control uupp" placeholder=" " />
					Lose Return
					<input type="text" value="<?php echo $yyyj[1]; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="return_amount" id="jj2<?php echo $yyy['serial']; ?>" name="return_amount" class="form-control uupp" placeholder=" " />
				</td>
				
                <td>
					Current: <input type="text" value="<?php echo $yyy['current_welt']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="current_welt" name="return_amount" class="form-control uupp" placeholder=" " /></br>
					Bonus: <input type="text" value="<?php echo $yyy['bounes_wallet']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="bounes_wallet" name="return_amount" class="form-control uupp" placeholder=" " />
				</td>
                <td><input type="text" value="<?php echo $yyy['renew_duration']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="renew_duration" name="return_amount" class="form-control uupp" placeholder=" " /></td>
                <td><input type="text" value="<?php echo $yyy['renew_charge']; ?>" data-serial="<?php echo $yyy['serial']; ?>" data-cols="renew_charge" name="return_amount" class="form-control uupp" placeholder=" " /></td>
                <td>
					<form action="#" data-toggle="validator">
						<div class="form-group has-feedback">
							<label class="input-group upgg" data-vals="0" data-serial="<?php echo $yyy['serial']; ?>" data-cols="fix_trade">
								<span class="input-group-addon">
									<input type="radio" name="test" value="0" <?php if($yyy['fix_trade']==0){echo "checked"; }?> />
								</span>
								<div class="form-control form-control-static">
									On
								</div>
								<span class="glyphicon form-control-feedback "></span>
							</label>
						</div>
						<div class="form-group has-feedback ">
							<label class="input-group upgg" data-vals="1" data-serial="<?php echo $yyy['serial']; ?>" data-cols="fix_trade">
								<span class="input-group-addon">
									<input type="radio" name="test" value="1"  <?php if($yyy['fix_trade']==1){echo "checked"; }?> />
								</span>
								<div class="form-control form-control-static">
									Off
								</div>
								<span class="glyphicon form-control-feedback "></span>
							</label>
						</div>
					</form>
				</td>
				<td>
					<form action="#" data-toggle="validator">
						<div class="form-group has-feedback">
							<label class="input-group upgg" data-vals="0" data-serial="<?php echo $yyy['serial']; ?>" data-cols="active">
								<span class="input-group-addon">
									<input type="radio" name="test" value="0" <?php if($yyy['active']==0){echo "checked"; }?> />
								</span>
								<div class="form-control form-control-static">
									Active
								</div>
								<span class="glyphicon form-control-feedback "></span>
							</label>
						</div>
						<div class="form-group has-feedback ">
							<label class="input-group upgg" data-vals="1" data-serial="<?php echo $yyy['serial']; ?>" data-cols="active">
								<span class="input-group-addon">
									<input type="radio" name="test" value="1"  <?php if($yyy['active']==1){echo "checked"; }?> />
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
				<button class="btn btn-danger upgg" data-vals="Delete" data-serial="<?php echo $yyy['serial']; ?>"><span class="glyphicon glyphicon-remove"></span> Delete</button>
				</td>
            </tr>
			<?php } ?>
            
    </table>
    </div>
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
            <script >
				$(document).ready(function(){
					$("#multiple").on("click", function(){
						$(".multiple").show();
					});
					$(".onetime").on("click", function(){
						$(".multiple").hide();
					});
					
					$(".uupp").on("keyup", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						if(cols=="return_amount"){
							var dd1=$("#jj"+srl).val();
							var dd2=$("#jj2"+srl).val();
							vals=dd1+"/"+dd2;
							
						}
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"gamesetup"}
							});
						}
						
					});
					
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"gamesetup"}
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
            <script type="text/javascript" src="js/table.js"></script>
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
