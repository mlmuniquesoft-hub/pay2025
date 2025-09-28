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
        <div class="row content-container expanded">
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
											<i class="fa fa-bar-chart-o fa-fw"></i> Review All Agent
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
													<div class="table-responsive">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>Agent Account:</th>     
																	<th>Agent Name:</th>
																	<?php
																		if($_SESSION['OriginalAdmin']=="superadmin"){
																	?>
																	<th>Password:</th>
																	<th>Master Exchanger:</th>         
																	<th>Inactive:</th>         
																	<th>Withdraw Receive:</th>         
																	<th>Daily Limit (Withdraw):</th>         
																	<th>Transfer Receive:</th>
																	<th>Franchise:</th> 
																	<th>From Admin:</th> 
																	<th>To Admin:</th>
																	<th>To Member:</th>
																	<th>from Member:</th>
																	<?php } ?>
																	<th>Balance</th>
																</tr>
															</thead>
<?php
	$t = $mysqli->query("SELECT * FROM agent ");
	if(!$t) die(mysqli_error());
						   
	$a= mysqli_fetch_object($t);
	$total_items= mysqli_num_rows($t);
	$limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
	$type = isset($_GET['type']) ? $_GET['type'] : '';
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51))
	{$limit = 50; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
						
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					

	$q = $mysqli->query("SELECT * FROM agent LIMIT $set_limit, $limit");
	if(!$q) die(mysqli_error());
	$err = mysqli_num_rows($q);	  
	while($querygetexeres= mysqli_fetch_object($q))
	{
?>
															<tbody>
			<tr>
				 <td>
				 <?php
					$hhg=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) as total FROM `trans_receive` WHERE `user_receive`='".$querygetexeres->user_id."' AND `status`='Pending' AND `type`='Withdraw' AND `account`='Agent'"));
					$hhg2=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total2 FROM `req_fund` WHERE `user`='".$querygetexeres->user_id."' AND `active`='0'"));
				 ?>
				 <?php echo $querygetexeres->user_id; ?>
				 <a class="btn btn-info btn-block" href="agent_pending_details.php?agent=<?php echo $querygetexeres->user_id; ?>">
				  Withdraw Request ($<?php echo $hhg['total']; ?>)
				  
				 </a>
				 <a class="btn btn-success btn-block" href="agent_pending_details.php?agent=<?php echo $querygetexeres->user_id; ?>">
				 Fund Request ($<?php echo $hhg2['total2']; ?>)
				 </a>
				 </td>  
				 <td style="min-width:200px;">
					<input type="text" name="hh" class="form-control uupp" data-serial="<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->name; ?>" data-cols="name" />
				 </td>
				<?php
					if($_SESSION['OriginalAdmin']=="superadmin"){
				?>
				 <td  style="min-width:200px;">
					 <span style="color:green;">Pass: </span> 
					 <input type="text" name="hh" class="form-control uupp" data-serial="<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->password; ?>" data-cols="password" />
					 <span style="color:green;">Pin: </span> 
					 <input type="text" name="hh" class="form-control uupp" data-serial="<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->epin_password; ?>" data-cols="epin_password" />
				 </td>     
				
				 <td style="min-width:200px;">
					<input type="radio" name="hh23321<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="0" data-cols="master_exchange" <?php if($querygetexeres->master_exchange==0){echo "checked";} ?>/> SusPend <br/>
					<input type="radio" name="hh23321<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="1" data-cols="master_exchange" <?php if($querygetexeres->master_exchange==1){echo "checked";} ?>/> Active
				 </td>
				 
				 <td style="min-width:200px;">
					<input type="radio" name="hh22<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="yes" data-cols="acc_suspend" <?php if($querygetexeres->acc_suspend=="yes"){echo "checked";} ?>/> SusPend <br/>
					<input type="radio" name="hh22<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="no" data-cols="acc_suspend" <?php if($querygetexeres->acc_suspend=="no"){echo "checked";} ?>/> Active
				 </td>
				 
				 <td style="min-width:200px;">
					<input type="radio" name="hh3222<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="1" data-cols="withdraw_acc" <?php if($querygetexeres->withdraw_acc==1){echo "checked";} ?>/> Active <br/>
					<?php if($querygetexeres->withdraw_acc==1){ ?>
						<input type="text" name="hh" class="form-control uupp" data-serial="<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->withdraw_limit; ?>" data-cols="withdraw_limit" />
					<?php } ?>
					<input type="radio" name="hh3222<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="0" data-cols="withdraw_acc" <?php if($querygetexeres->withdraw_acc==0){echo "checked";} ?>/> Inactive
				 </td>
				 <td style="min-width:200px;">
					<input type="text" name="hh" class="form-control uupp" data-serial="<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->with_month_limit; ?>" data-cols="with_month_limit" />
				 </td>
				 
				 <td style="min-width:200px;">
					<input type="radio" name="hh232<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="1" data-cols="transfer_acc" <?php if($querygetexeres->transfer_acc==1){echo "checked";} ?>/> Active <br/>
					<input type="radio" name="hh232<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="0" data-cols="transfer_acc" <?php if($querygetexeres->transfer_acc==0){echo "checked";} ?>/> Inactive
				 </td>
				 <td style="min-width:200px;">
					<input type="radio" name="hh09<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="1" data-cols="franchise" <?php if($querygetexeres->franchise==1){echo "checked";} ?>/> Active <br/>
					<input type="radio" name="hh09<?php echo $querygetexeres->serialno; ?>" class="upgg" data-serial="<?php echo $querygetexeres->serialno; ?>" value="0" data-cols="franchise" <?php if($querygetexeres->franchise==0){echo "checked";} ?>/> Inactive
				 </td>
				  <td><?php echo $querygetexeres->receive_from_admin; ?></td>
				 <td><?php echo $querygetexeres->withdrow_to_admin; ?></td>      
				
				 <td><?php echo $querygetexeres->send_to_member; ?></td>
				 <td><?php echo $querygetexeres->withdrow_from_member; ?></td> 
					<?php } ?>				 
				 <td><?php echo $querygetexeres->final_balance; ?></td>
			</tr> 
<?php } ?>
															</tbody>
														</table>
<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
<?php 
	$cat = urlencode($cat); 
	$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href=?limit=$limit&amp;page=$prev_page><b>Prev</b></a>");}
	$a = $page ;if($a <= $total_pages){ echo("|<a href=?limit=$limit&amp;page=$a><b>$a</b></a>|");}			
	$b = $page + 1;if($b <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$b><b>$b</b></a>|");}			
	$c = $page + 2;if($c <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$c><b>$c</b></a>|");}	
	$d = $page + 3;if($d <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$d = $page + 4;if($d <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$e = $page + 5;if($e <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$e><b>$e</b></a>|");}			
	$f = $page + 6;if($f <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$f><b>$f</b></a>|");}			
	$g = $page + 7;if($g <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$g><b>$g</b></a>|");}
	$h = $page + 8;if($h <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$h><b>$h</b></a>|");}			
	$i = $page + 9;if($i <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$i><b>$i</b></a>|");}			
	$j = $page + 10;if($j <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$j><b>$j</b></a>|");}
	$next_page = $page + 1;if($next_page <= $total_pages){ echo("<a href=?limit=$limit&amp;page=$next_page><b>Next</b></a> &gt;&gt;");}
?>	
	<form method="get" action="" style="text-align: center;">
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;">Total Pages </span>
		
		<b style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:blue;font-size:13px;">
		<?php echo $total_pages;?></b>
		
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> Show 
			<input type="text"  name="page" value="<?php echo $page;?>" size="4" />
			<input type="hidden" name="limit" value="<?php echo $limit;?>" />
		</span>
		<input type="submit"  value="Submit" /> 
	</form>     
</p> 
													</div>
										</div>
										<!-- /.panel-body -->
									</div>
									<!-- /.panel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
			<?php require_once'footer.php'?>
        </div>
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
								data:{vas: vals, sers: srl, coll:cols, tbs:"agent"}
							});
						}
						
					});
					$(".upgg").on("click", function(e){
						var vals=$(this).val();
						var srl=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						console.log(vals);
						if(vals=="Delete"){
							$(".del"+srl).hide();
						}
						if(vals!=''){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"agent"}
							});
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
