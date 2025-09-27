<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		
		function teamcalc($team){
			global $mysqli;
			$uuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `games` WHERE `type`='Special' AND `active`='1'"));
			$teama=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$uuu['serial']."' AND `draw`='".$uuu[$team]."'");
			$teama_user=array();
			$teama_amn=array();
			while($tteama=mysqli_fetch_assoc($teama)){
				$teama_amn[$tteama['user']]=$tteama['slot'];
				$myyy=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `user`='".$tteama['user']."'"));
				array_push($teama_user, $myyy['mobile']);
			}
			
			$teama_num=array_count_values($teama_user);
			$tesma_key=array_keys($teama_num);
			$teama_num_amn=array();
			foreach($tesma_key as $teamsa){
				$hhh=$mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `mobile`='".$teamsa."'");
				$rrtt=0;
				while($jjj=mysqli_fetch_assoc($hhh)){
					if(array_key_exists($jjj['user'], $teama_amn)){
						$rrtt=$rrtt+$teama_amn[$jjj['user']];
					}
				}
				$teama_num_amn[$teamsa]=$rrtt;
			}
			
			return $teama_num_amn;
		}
		function uniqnumm(){
			global $mysqli;
			$uuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `games` WHERE `type`='Special' AND `active`='1'"));
			$teama=$mysqli->query("SELECT * FROM `play` WHERE `gameid`='".$uuu['serial']."'");
			$uniqnum=array();
			while($tteama=mysqli_fetch_assoc($teama)){
				$myyy=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `user`='".$tteama['user']."'"));
				array_push($uniqnum, $myyy['mobile']);
			}
			
			$teama_num=array_count_values($uniqnum);
			$tesm_uniq=array_keys($teama_num);
			return $tesm_uniq;
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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	 <link rel="stylesheet" type="text/css" href="css/jquery_ui.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<link type="text/css" href="css/bootstrap-timepicker.min.css" />
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
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Invalid Games
									<div class="pull-right"> </div>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered table-hover table-striped">
													<thead>
														<tr>
															<th scope="col">Serial</th>										
															<th scope="col">Number</th>
															<th scope="col">Team A Amount</th>
															<th scope="col">Team B Amount</th>
															<th scope="col">Action</th>
														</tr>
													</thead>
				<?php
					$uniqnum=uniqnumm();
					$teama=teamcalc("team_a");
					$teamb=teamcalc("team_b");
					$teama_total=0;
					$teamb_total=0;
					$n=1;
					foreach($uniqnum as $rrr)
					{
					if($teama[$rrr]!=$teamb[$rrr]){
					$teama_total=$teama_total+$teama[$rrr];
					$teamb_total=$teamb_total+$teamb[$rrr];
					$querygetexeres=mysqli_fetch_assoc($mysqli->query("SELECT `mobile`,`user` FROM `profile` WHERE `mobile`='".$rrr."'"));
				?>
													<tbody>
														<tr>
															<td><?php echo $n++; ?></td>										
															<td><?php echo $rrr; ?></td>										
															<td><?php echo $teama[$rrr]; ?></td>
															<td><?php echo $teamb[$rrr]; ?></td>
															<td>
																<a href="unequalgame_cancel_action.php?user=<?php echo $querygetexeres['user']; ?>&teama=<?php echo $teama[$rrr]; ?>&teamb=<?php echo $teamb[$rrr]; ?>" class="btn btn-danger">Cancel</a>
															</td>
														</tr>
													</tbody>
					<?php } } ?>
												<tfoot>
													<tr>
														<td></td>
														<td align="right">Total</td>
														<td><?php echo $teama_total; ?></td>
														<td><?php echo $teamb_total; ?></td>
														<td></td>
													</tr>
												<tfoot>
												</table>
				
											</div>
											<!-- /.table-responsive -->
										</div>
										<!-- /.col-lg-12 (nested) -->
									</div>
									<!-- /.row -->
								</div>								
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
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
			<script type="text/javascript" src="js/datetimepicker_css.js"></script>
			<script type="text/javascript" src="js/jquery_ui.js"></script>
				<script>
					$( function() {
					$( ".datepicker" ).datepicker({
					  dateFormat: "yy-mm-dd"
					});
					// Getter
					var dateFormat = $( ".datepicker" ).datepicker( "option", "dateFormat" );
					 
					// Setter
					$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
				  } );
				  $(document).ready(function(){
					  $(".poker").on("click", function(){
						  $(".pok-hide").slideUp();
					  });
					  $('.poker-open').on("click", function(){
						   $(".pok-hide").slideDown();
					  });
				  });

				</script>
			
			
			
			<!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>

<!-- Include Date Range Picker 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>-->


			
			
			
		
			
</body>

</html>
