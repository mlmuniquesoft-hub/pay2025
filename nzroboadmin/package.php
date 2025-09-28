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
    
    <!-- Enhanced Field Update Styles -->
    <style>
        .updating-border {
            border: 2px solid #f39c12 !important;
            box-shadow: 0 0 5px rgba(243, 156, 18, 0.5) !important;
        }
        
        .success-border {
            border: 2px solid #27ae60 !important;
            box-shadow: 0 0 5px rgba(39, 174, 96, 0.5) !important;
        }
        
        .error-border {
            border: 2px solid #e74c3c !important;
            box-shadow: 0 0 5px rgba(231, 76, 60, 0.5) !important;
        }
        
        .active-selection {
            background-color: #3498db !important;
            color: white !important;
        }
        
        .update-alert {
            margin-bottom: 15px;
            z-index: 1000;
        }
        
        .custab input.form-control {
            font-size: 12px;
            padding: 4px 8px;
            height: 32px;
        }
        
        .custab .col-xs-6 {
            padding-left: 2px;
            padding-right: 2px;
        }
        
        .table-responsive {
            overflow-x: auto;
            min-height: 400px;
        }
        
        .custab th {
            background-color: #34495e;
            color: white;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
            padding: 8px 4px;
        }
        
        .custab td {
            vertical-align: middle;
            padding: 4px;
        }
        
        .btn-sm {
            font-size: 11px;
            padding: 4px 8px;
        }
        
        /* Responsive table improvements */
        @media (max-width: 1200px) {
            .custab th, .custab td {
                font-size: 10px;
                padding: 2px;
            }
            
            .custab input.form-control {
                font-size: 10px;
                padding: 2px 4px;
                height: 28px;
            }
        }
    </style>
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
								<th>Charge ($)</th>
								<th>React Amount ($)</th>
								<th>Game Renew (Days)</th>
								<th>Direct Com (%)</th>
								<th>Ads Amount ($)</th>
								<th>Min/Max Slots</th>
								<th>Rank Com (%)</th>
								<th>Tree Color</th>
								<th>Package Status</th>
								<th>Rank Status</th>
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
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="pack" value="<?php echo htmlspecialchars($pascs['pack']); ?>" placeholder="Package Name"></td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="pack_amn" value="<?php echo $pascs['pack_amn']; ?>" step="0.01" placeholder="Package Amount"></td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="react_amn" value="<?php echo $pascs['react_amn']; ?>" step="0.01" placeholder="React Amount"></td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="game_renew" value="<?php echo $pascs['game_renew']; ?>" min="1" placeholder="Days"></td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="direct_com" value="<?php echo $pascs['direct_com']; ?>" step="0.01" placeholder="Commission %"></td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="ads_amount" value="<?php echo $pascs['ads_amount']; ?>" step="0.01" placeholder="Ads Amount"></td>
									<td>
										<div class="row">
											<div class="col-xs-6">
												<input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="min_slot" value="<?php echo $pascs['min_slot']; ?>" min="1" placeholder="Min" title="Min Slots">
											</div>
											<div class="col-xs-6">
												<input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="max_slot" value="<?php echo $pascs['max_slot']; ?>" min="1" placeholder="Max" title="Max Slots">
											</div>
										</div>
									</td>
									<td><input type="number" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="rank_com" value="<?php echo $pascs['rank_com']; ?>" step="0.01" placeholder="Rank Com %"></td>
									<td style="width:80px;"><input type="color" class="form-control ssdd" data-serial="<?php echo $pascs['serial']; ?>" data-cols="color" value="<?php echo $pascs['color']; ?>" title="Package Color"></td>
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
				// Enhanced field-wise update system with debouncing
				var updateTimeout;
				
				// Real-time field updates with debouncing
				$(".uupp").on("input keyup change", function(){
					var element = $(this);
					var vals = element.val().trim();
					var srl = element.attr("data-serial");
					var cols = element.attr("data-cols");
					
					// Clear previous timeout
					clearTimeout(updateTimeout);
					
					// Visual feedback
					element.removeClass('success-border error-border').addClass('updating-border');
					
					// Debounced update (wait 800ms after user stops typing)
					updateTimeout = setTimeout(function(){
						if(vals !== ''){
							// Validate based on field type
							if(validateField(cols, vals)){
								$.ajax({
									method: "POST",
									url: "info_update_action.php",
									data: {
										vas: vals, 
										sers: srl, 
										coll: cols, 
										tbs: "package"
									},
									success: function(response){
										element.removeClass('updating-border error-border').addClass('success-border');
										showUpdateMessage('Field updated successfully!', 'success');
										// Auto-remove success styling after 2 seconds
										setTimeout(function(){
											element.removeClass('success-border');
										}, 2000);
									},
									error: function(){
										element.removeClass('updating-border success-border').addClass('error-border');
										showUpdateMessage('Update failed. Please try again.', 'error');
									}
								});
							} else {
								element.removeClass('updating-border success-border').addClass('error-border');
								showUpdateMessage('Invalid value for ' + cols, 'error');
							}
						} else {
							element.removeClass('updating-border success-border error-border');
						}
					}, 800);
				});
				
				// Radio button and action button updates
				$(".upgg").on("click", function(e){
					var element = $(this);
					var vals = element.attr("data-vals");
					var srl = element.attr("data-serial");
					var cols = element.attr("data-cols");
					
					if(vals === "Delete"){
						if(confirm('Are you sure you want to delete this package?')){
							$(".del" + srl).fadeOut('slow');
							$.ajax({
								method: "POST",
								url: "info_update_action.php",
								data: {vas: vals, sers: srl, coll: cols, tbs: "package"},
								success: function(){
									showUpdateMessage('Package deleted successfully!', 'success');
								},
								error: function(){
									$(".del" + srl).fadeIn('slow');
									showUpdateMessage('Delete failed. Please try again.', 'error');
								}
							});
						}
					} else if(vals !== ''){
						$.ajax({
							method: "POST",
							url: "info_update_action.php",
							data: {vas: vals, sers: srl, coll: cols, tbs: "package"},
							success: function(){
								showUpdateMessage('Status updated successfully!', 'success');
								// Update visual feedback for radio buttons
								element.closest('td').find('.upgg').removeClass('active-selection');
								element.addClass('active-selection');
							},
							error: function(){
								showUpdateMessage('Status update failed. Please try again.', 'error');
							}
						});
					}
				});
				
				// Color picker updates
				$(".ssdd").on("change", function(){
					var element = $(this);
					var vals = element.val();
					var srl = element.attr("data-serial");
					var cols = element.attr("data-cols");
					
					if(vals !== ''){
						$.ajax({
							method: "POST",
							url: "info_update_action.php",
							data: {vas: vals, sers: srl, coll: cols, tbs: "package"},
							success: function(){
								showUpdateMessage('Color updated successfully!', 'success');
								// Visual feedback for color change
								element.css('border', '2px solid ' + vals);
								setTimeout(function(){
									element.css('border', '');
								}, 2000);
							},
							error: function(){
								showUpdateMessage('Color update failed. Please try again.', 'error');
							}
						});
					}
				});
				
				// Field validation function
				function validateField(fieldName, value) {
					switch(fieldName) {
						case 'pack_amn':
						case 'react_amn':
						case 'ads_amount':
							return !isNaN(value) && parseFloat(value) >= 0;
						case 'game_renew':
						case 'min_slot':
						case 'max_slot':
						case 'rank_slot':
							return !isNaN(value) && parseInt(value) > 0;
						case 'direct_com':
						case 'rank_com':
							return !isNaN(value) && parseFloat(value) >= 0 && parseFloat(value) <= 100;
						case 'pack':
							return value.length > 0 && value.length <= 255;
						default:
							return true;
					}
				}
				
				// Update message display function
				function showUpdateMessage(message, type) {
					var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
					var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade in update-alert" role="alert">' +
									'<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' +
									message + '</div>';
					
					// Remove existing alerts
					$('.update-alert').remove();
					
					// Add new alert
					$('.panel-body').prepend(alertHtml);
					
					// Auto-remove after 3 seconds
					setTimeout(function(){
						$('.update-alert').fadeOut('slow', function(){
							$(this).remove();
						});
					}, 3000);
				}
			});			</script>
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
