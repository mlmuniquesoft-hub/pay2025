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
										<i class="fa fa-bar-chart-o fa-fw"></i> Package
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
												<p style="color: red;font-size:16px;"><?php echo isset($_SESSION['msg']) ? $_SESSION['msg'] : ''; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo isset($_SESSION['msg1']) ? $_SESSION['msg1'] : ''; ?></p> 	  	
												<form class="form-horizontal" action="package_create_action.php" method="POST">
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Package Name :</label>
														<div class="col-sm-9">
															<select name="package" class="form-control" required>
																<option value="">Select Package Type</option>
																<option value="Basic Package">Basic Package</option>
																<option value="Premium Package">Premium Package</option>
																<option value="VIP Package">VIP Package</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Package Amount ($) :</label>
														<div class="col-sm-9">
															<input type="number" name="pack_amn" class="form-control" placeholder="Package Amount ($)" step="0.01" required />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">React Amount ($) :</label>
														<div class="col-sm-9">
															<input type="number" name="react_amn" class="form-control" placeholder="React/Return Amount ($)" step="0.01" required />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Game Renew Days :</label>
														<div class="col-sm-9">
															<input type="number" name="game_renew" class="form-control" placeholder="Game Renewal Period (Days)" min="1" required />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Description :</label>
														<div class="col-sm-9">
															<textarea name="dessc" class="form-control" rows="3" placeholder="Package description and features" required></textarea>
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">CID Description :</label>
														<div class="col-sm-9">
															<textarea name="cid_dessc" class="form-control" rows="2" placeholder="CID specific description"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Ads Amount ($) :</label>
														<div class="col-sm-9">
															<input type="number" name="ads_amount" class="form-control" placeholder="Advertisement Amount ($)" step="0.01" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Direct Commission (%) :</label>
														<div class="col-sm-9">
															<input type="number" name="direct_com" class="form-control" placeholder="Direct Commission (%)" step="0.01" required />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Game Slots :</label>
														<div class="col-sm-4">
															<input type="number" name="min_slot" class="form-control" placeholder="Min Game Slots" min="1" required />
														</div>
														<div class="col-sm-4">
															<input type="number" name="max_slot" class="form-control" placeholder="Max Game Slots" min="1" required />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank Commission (%) :</label>
														<div class="col-sm-9">
															<input type="number" name="rank_com" class="form-control" placeholder="Rank Commission (%)" step="0.01" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank Slots :</label>
														<div class="col-sm-9">
															<input type="number" name="rank_slot" class="form-control" placeholder="Rank Slots" min="1" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Country Settings :</label>
														<div class="col-sm-4">
															<input type="text" name="active_country" class="form-control" placeholder="Active Countries (comma separated)" />
														</div>
														<div class="col-sm-4">
															<input type="text" name="inactive_country" class="form-control" placeholder="Inactive Countries (comma separated)" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Package Settings :</label>
														<div class="col-sm-3">
															<select name="rank_active" class="form-control">
																<option value="1">Rank Active</option>
																<option value="0">Rank Inactive</option>
															</select>
														</div>
														<div class="col-sm-3">
															<select name="active" class="form-control">
																<option value="1">Package Active</option>
																<option value="0">Package Inactive</option>
															</select>
														</div>
														<div class="col-sm-3">
															<input type="color" name="color" class="form-control" value="#3498db" title="Package Color" />
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-12">
															<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>"/>
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
						<div class="row col-md-12 custyle">
						<div class="table-responsive">
						<table class="table table-striped custab">
						<thead>
						
							<tr>
								<th>Serial</th>
								<th>Package Name</th>
								<th>Charge</th>
								<th>Sponsor Comission</th>
								
								<th>Tree Color</th>
								<th>On/Off</th>
								<th>Rank On/Off</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
							<?php
								$hhh=$mysqli->query("SELECT * FROM `package`");
								$n=1;
								while($pascs=mysqli_fetch_assoc($hhh)){
							?>
								<tr class="del<?php echo $pascs['serial']; ?>">
									<td><?php echo $n++; ?></td>
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="pack" value="<?php echo $pascs['pack']; ?>"></td>
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="pack_amn" value="<?php echo $pascs['pack_amn']; ?>"></td>
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="direct_com" value="<?php echo $pascs['direct_com']; ?>"></td>
									
									
									<td style="width:100px;"><input type="color" class="form-control ssdd" data-serial="<?php echo $pascs['serial']; ?>" data-cols="color" value="<?php echo $pascs['color']; ?>"></td>
									<td>
										<form action="#" data-toggle="validator">
											<div class="form-group has-feedback">
												<label class="input-group upgg" data-vals="1" data-serial="<?php echo $pascs['serial']; ?>" data-cols="active">
													<span class="input-group-addon">
														<input type="radio"  name="test" value="1" <?php if($pascs['active']==1){echo "checked"; }?>/>
													</span>
													<div class="form-control form-control-static">
														Active
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
											<div class="form-group has-feedback ">
												<label class="input-group upgg" data-vals="0" data-serial="<?php echo $pascs['serial']; ?>" data-cols="active">
													<span class="input-group-addon">
														<input type="radio" name="test" value="0" <?php if($pascs['active']==0){echo "checked"; }?>/>
													</span>
													<div class="form-control form-control-static">
														Inactive
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
										</form>
									</td>
									
									<td>
										<form action="#" data-toggle="validator">
											<div class="form-group has-feedback">
												<label class="input-group upgg" data-vals="1" data-serial="<?php echo $pascs['serial']; ?>" data-cols="rank_active">
													<span class="input-group-addon">
														<input type="radio"  name="test2" value="1" <?php if($pascs['rank_active']==1){echo "checked"; }?>/>
													</span>
													<div class="form-control form-control-static">
														Active
													</div>
													<span class="glyphicon form-control-feedback "></span>
												</label>
											</div>
											<div class="form-group has-feedback ">
												<label class="input-group upgg" data-vals="0" data-serial="<?php echo $pascs['serial']; ?>" data-cols="rank_active">
													<span class="input-group-addon">
														<input type="radio" name="test2" value="0" <?php if($pascs['rank_active']==0){echo "checked"; }?>/>
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
										<button href="#" class="btn btn-danger btn-sm upgg" data-vals="Delete" data-serial="<?php echo $pascs['serial']; ?>"><span class="glyphicon glyphicon-remove"></span> Delete</button>
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
			<?php 
			require_once('footer.php');
			unset($_SESSION['msg']);
			unset($_SESSION['msg1']);
			
			?>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
            <script>
				$(document).ready(function(){
					$(".uupp").on("keyup", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
							});
						}
					});
					$(".ssdd").on("change", function(){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"package"}
							});
						}
					})
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
            
            <!-- Package Auto-fill Script -->
            <script>
            $(document).ready(function() {
                $('select[name="package"]').change(function() {
                    var packageType = $(this).val();
                    
                    // Auto-populate based on your package structure
                    switch(packageType) {
                        case 'Basic Package':
                            $('input[name="pack_amn"]').val('500');
                            $('input[name="react_amn"]').val('525'); // 5% return
                            $('input[name="game_renew"]').val('30');
                            $('input[name="direct_com"]').val('5');
                            $('input[name="ads_amount"]').val('50');
                            $('input[name="min_slot"]').val('1');
                            $('input[name="max_slot"]').val('3');
                            $('input[name="rank_com"]').val('2');
                            $('input[name="rank_slot"]').val('5');
                            $('input[name="color"]').val('#3498db');
                            $('textarea[name="dessc"]').val('Entry-level package for new investors. Investment range: $100-$999. Daily ROI up to 0.5%. Perfect for beginners starting their trading journey.');
                            $('textarea[name="cid_dessc"]').val('Basic tier with standard features and support');
                            $('input[name="active_country"]').val('US,CA,UK,AU');
                            break;
                        case 'Premium Package':
                            $('input[name="pack_amn"]').val('2500');
                            $('input[name="react_amn"]').val('2675'); // 7% return
                            $('input[name="game_renew"]').val('45');
                            $('input[name="direct_com"]').val('7');
                            $('input[name="ads_amount"]').val('150');
                            $('input[name="min_slot"]').val('2');
                            $('input[name="max_slot"]').val('5');
                            $('input[name="rank_com"]').val('3');
                            $('input[name="rank_slot"]').val('10');
                            $('input[name="color"]').val('#e67e22');
                            $('textarea[name="dessc"]').val('Mid-tier package for experienced investors. Investment range: $1,000-$4,999. Daily ROI up to 0.7%. Enhanced features and priority support.');
                            $('textarea[name="cid_dessc"]').val('Premium tier with advanced features and priority support');
                            $('input[name="active_country"]').val('US,CA,UK,AU,DE,FR,JP');
                            break;
                        case 'VIP Package':
                            $('input[name="pack_amn"]').val('7500');
                            $('input[name="react_amn"]').val('8250'); // 10% return
                            $('input[name="game_renew"]').val('60');
                            $('input[name="direct_com"]').val('10');
                            $('input[name="ads_amount"]').val('500');
                            $('input[name="min_slot"]').val('3');
                            $('input[name="max_slot"]').val('10');
                            $('input[name="rank_com"]').val('5');
                            $('input[name="rank_slot"]').val('20');
                            $('input[name="color"]').val('#8e44ad');
                            $('textarea[name="dessc"]').val('Premium package for high-value investors. Investment range: $5,000+. Daily ROI up to 1%. VIP features, dedicated support, and exclusive benefits.');
                            $('textarea[name="cid_dessc"]').val('VIP tier with exclusive features and dedicated account manager');
                            $('input[name="active_country"]').val('US,CA,UK,AU,DE,FR,JP,SG,HK,CH');
                            break;
                    }
                });
            });
            </script>
</body>

</html>
