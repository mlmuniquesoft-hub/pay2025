<?php
    session_start(); 
	if((!isset($_SESSION['Admin']))&&(!isset($_SESSION['token'])))			{
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
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
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
					<?php //require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
						<div class="col-sm-12">
							<h3 style="text-align:center;color: red;"><?php echo $_SESSION['msg']?></h3>
							<h3 style="text-align:center;color: green;"><?php echo $_SESSION['msg2']?></h3>
						</div>
                        <div class="col-sm-12">
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Game Type Create
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<form class="form-horizontal" id="formElem" name="formElem" action="gmaeType_action.php" method="post">
												<div class="form-group">
													<label class="col-sm-3 control-label">Game Type Name</label>
													<div class="col-sm-8">				
														<input id="ads_link" name="pack"  class="form-control"  type="text" placeholder="Pack Name" />
													</div>
												</div>
												<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
												<input type="hidden" name="dts" value="<?php echo base64_encode("multichallenge"); ?>" />
												<div class="form-group">
													<div class="col-sm-3"></div>
													<div class="col-sm-4">
														<button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
													</div>
													<div class="col-sm-4">
														<button type="reset" class="btn btn-danger btn-lg btn-block">Refresh</button>
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
                        </div><!-- /.col-sm-6 (nested) -->
					</div>
					<div class="row  no-margin-bottom">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i>Game Type List
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
															<th scope="col">Type Name</th>
															
														</tr>
													</thead>
				<?php
					$date=date("Y-m-d");
					$q = $multichallenge->query("SELECT * FROM `gametype`");
					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						
					
						
				?>
													<tbody>
														<tr>
															<td><?php echo $n++; ?></td>										
															<td><input type="text" style="min-width:100px;" class="form-control update" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="type_name" value="<?php echo $querygetexeres->type_name; ?>"></td>
														</tr>
													</tbody>
				<?php } ?>
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
			<script>
				$(document).ready(function(){
					$(".update").on("keyup",function(){
						var ser=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						var vals=$(this).val();
						console.log(vals);
						if(vals!=''){
							var req=$.ajax({
								method:"GET",
								url:"type_update_action.php",
								data:{column:cols,serial:ser, value:vals,dts:"multichallenge"}
							});
							req.done(function(ress){
								console.log(ress);
							});
						}
					});
					$(".acct").on("click",function(){
						var ser=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");//="con_active"
						var secols=$(this).attr("data-secondcols");
						var vals=$(this).val();
						if((cols=="ads_coons")&&(vals==1)){
							$(".adsOffer"+ser).show();
						}
						
						if(vals!=''){
							var req=$.ajax({
								method:"GET",
								url:"offer_update_action.php",
								data:{column:cols,table:"package",serial:ser, value:vals,cols2:secols}
							});
							req.done(function(msd){
								console.log(msd);
							});
						}
					});
					$(".update_color").on("change",function(){
						var ser=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						var vals=$(this).val();
						if(vals!=''){
							var req=$.ajax({
								method:"GET",
								url:"pack_update_action.php",
								data:{column:cols,serial:ser, value:vals}
							});
						}
					});
				});
			</script>
			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
			<!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>

<!-- Include Date Range Picker 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>-->

</body>
</html>