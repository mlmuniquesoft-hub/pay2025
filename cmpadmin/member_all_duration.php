<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		
		if(isset($_GET['pacg'])){
			$pDSer=$_GET['serd'];
			$pCSer=$_GET['pacg'];
			$werwe=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `rank_duration` WHERE `serial`='".$pDSer."'"));
			$packY=array();
			$packYNB=array();
			$finalMNb=array();
			$weww=explode(",",$werwe['pin_bonus']);
			foreach($weww as $rtwe){
				if($rtwe!=''){
					$werwkl=explode("/", $rtwe);
					array_push($packY,$werwkl[0]);
					$packYNB[$werwkl[0]]=$werwkl[1];
				}
			}
			if(in_array($pCSer,$packY)){
				$werwkj=array_search($pCSer,$packY);
				unset($packY[$werwkj]);
				//echo "Same";
			}else{
				array_push($packY,$pCSer);
			}
			
			foreach($packY as $asjh){
				$wrweJHG=$asjh ."/". $packYNB[$asjh];
				array_push($finalMNb,$wrweJHG);
			}
			$Finasdlk=implode(",",$finalMNb);
			$mysqli->query("UPDATE `rank_duration` SET `pin_bonus`='".$Finasdlk."' WHERE `serial`='".$pDSer."'");
			die();
		}
		if(isset($_GET['durser'])){
			$pDSer=$_GET['durser'];
			$pCSer=$_GET['passer'];
			$piamn=$_GET['piamn'];
			$werwe=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `rank_duration` WHERE `serial`='".$pDSer."'"));
			$packY=array();
			$packYNB=array();
			$finalMNb=array();
			$weww=explode(",",$werwe['pin_bonus']);
			foreach($weww as $rtwe){
				if($rtwe!=''){
					$werwkl=explode("/", $rtwe);
					array_push($packY,$werwkl[0]);
					$packYNB[$werwkl[0]]=$werwkl[1];
				}
			}
			if(!in_array($pCSer,$packY)){
				array_push($packY,$pCSer);
				$packYNB[$pCSer]=$piamn;
			}else{
				$packYNB[$pCSer]=$piamn;
			}
			
			foreach($packY as $asjh){
				$wrweJHG=$asjh ."/". $packYNB[$asjh];
				array_push($finalMNb,$wrweJHG);
			}
			$Finasdlk=implode(",",$finalMNb);
			$mysqli->query("UPDATE `rank_duration` SET `pin_bonus`='".$Finasdlk."' WHERE `serial`='".$pDSer."'");
			die();
		}
		
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
										<i class="fa fa-bar-chart-o fa-fw"></i> Rank Duration
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body" style="background-color: azure;">
										<div class="row">
											<div class="col-lg-12">
												<p style="color: red;font-size:16px;"><?php echo $_SESSION['msg']; ?></p> 	  	
												<p style="color: green;font-size:16px;"><?php echo $_SESSION['msg1']; ?></p> 	  	
												<form class="form-horizontal" action="rank_create_action.php" method="POST">
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank Name :</label>
														<div class="col-sm-9">
														<?php $rryy=array("Bronze", "Silver", "Gold", "Platinum","Diamond","Crown Diamond", "Titanium", "Ambassador", "Royal Ambassador", "Crown Ambassador", "Emiretars", "Champion");?>
															<select name="rank_name" class="form-control">
																<option value=''>Select Rank Name</option>
																<?php foreach($rryy as $rankj){?>
																<option value='<?php echo $rankj; ?>'><?php echo $rankj; ?></option>
																<?php } ?>
															</select>
															
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank Amount:</label>
														<div class="col-sm-9">
															<input type="text" name="rank_amn" class="form-control" placeholder="Rank Amount" />
														</div>
													</div>
													<div class="form-group" style="margin-bottom:10px;">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank Duration (Week):</label>
														<div class="col-sm-9">
															<input type="text" name="rank_duration" class="form-control" placeholder="Rank Duration" />
														</div>
													</div>
													<div class="form-group">
														<label for="inputEmail3" class="col-sm-3 control-label">Rank PIN:</label>
														<div class="col-sm-9">
															<?php
																$mygh=$mysqli->query("SELECT * FROM `package`");
																while($ertre=mysqli_fetch_assoc($mygh)){
															?>
															<div class="row">
																<div class="col-sm-2" style="margin-bottom: 10px;">
																	<input type="checkbox" name="pacPin[]"  value="<?php echo $ertre['serial']?>" /><?php echo $ertre['pack']?>
																</div>
																<div class="col-sm-6" style="margin-bottom: 10px;">
																	<input type="number" name="pinAmn<?php echo $ertre['serial']?>" class="form-control" placeholder="Pin Amount" />
																</div>
															</div>
																<?php } ?>
														</div>
													</div>
													
													
													<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>"/>
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
								<th>Rank Name</th>
								<th>Rank Amount</th>
								<th>Rank Duration (Week)</th>
								<th>PIN Amount</th>
								<th>On/Off</th>
								
							</tr>
						</thead>
							<?php
								$hhh=$mysqli->query("SELECT * FROM `rank_duration`");
								$n=1;
								while($pascs=mysqli_fetch_assoc($hhh)){
							?>
								<tr class="del<?php echo $pascs['serial']; ?>">
									<td><?php echo $n++; ?></td>
									<td><?php echo $pascs['rank_name']?></td>
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="rank_amn" value="<?php echo $pascs['rank_amn']; ?>"></td>
									<td><input type="text" class="form-control uupp" data-serial="<?php echo $pascs['serial']; ?>" data-cols="rank_duration" value="<?php echo $pascs['rank_duration']; ?>"> Week</td>
									<td><?php
											$packjj=array();
											$amnPakk=array();
											$werew=explode(",",$pascs['pin_bonus']);
											foreach($werew as $sdfsd){
												$werewoIU=explode("/", $sdfsd);
												array_push($packjj, $werewoIU[0]);
												$amnPakk[$werewoIU[0]]=$werewoIU[1];
											}
											$mygh=$mysqli->query("SELECT * FROM `package`");
											while($ertre=mysqli_fetch_assoc($mygh)){
										?>
										<div class="row">
											<div class="col-sm-4" style="margin-bottom: 10px;">
												<input type="checkbox" name="pacPin[]" data-sedf="<?php echo $pascs['serial']; ?>" class="rankUY" value="<?php echo $ertre['serial']; ?>" <?php if(in_array($ertre['serial'],$packjj)){ echo "checked";}?>/><?php echo $ertre['pack']?>
											</div>
											<div class="col-sm-6" style="margin-bottom: 10px;">
												<input type="number" data-sedf="<?php echo $pascs['serial']; ?>" name="<?php echo $ertre['serial']?>" class="form-control poKj" placeholder="Pin Amount" value="<?php echo $amnPakk[$ertre['serial']]; ?>" />
											</div>
										</div>
										<?php } ?>
									</td>
									
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"rank_duration"}
							});
						}
						
					});
					$(".poKj").on("focusout", function(e){
						var trww=$(this).attr("data-sedf");
						var trww2=$(this).attr("name");
						var rtr2=$(this).val();
						var sdfg=$.ajax({
							method:"GET",
							url:"",
							data:{durser:trww,passer:trww2,piamn:rtr2}
						});
						sdfg.done(function(qwe){
							console.log(qwe);
						});
					});
					$(".rankUY").on("click", function(e){
						var rtr=$(this).attr("data-sedf");
						var rtr2=$(this).val();
						
						var reqw=$.ajax({
							method:"GET",
							url:"",
							data:{serd:rtr, pacg:rtr2}
						});
						reqw.done(function(redf){
							console.log(redf);
						});
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"rank_duration"}
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"rank_duration"}
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
</body>

</html>
