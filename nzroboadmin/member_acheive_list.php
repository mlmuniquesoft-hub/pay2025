<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		
		$date=date("Y-m-d");
		if(isset($_GET['piin'])){
			$pinn=$_GET['piin'];
			$user=$_GET['user'];
			$usrww=$_GET['accssd'];
			$ret=array();
			if($pinn==""){
				array_push($ret, 0);
				array_push($ret, "Insert Transaction Pin To Approve");
				echo json_encode($ret);
				die();
			}
			if($user==""){
				array_push($ret, 0);
				array_push($ret, "Select User ID To Approve");
				echo json_encode($ret);
				die();
			}
			$mmCheck=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pinn."'"));
			if($mmCheck>0){
				if(count($ret)==0){
					if($usrww=="Create Pin"){
						$mysqli->query("UPDATE `member` SET `node`='1' WHERE `user`='".$user."'");
						array_push($ret, 1);
						array_push($ret, "Approved Successful");
						echo json_encode($ret);
						die();
					}elseif($usrww=="Terminal"){
						$mysqli3->query("INSERT INTO `terminal_member`( `user`) VALUES ('".$user."')");
						array_push($ret, 1);
						array_push($ret, "Terminal Approved Successful");
						echo json_encode($ret);
						die();
					}else{
						array_push($ret, 0);
						array_push($ret, "Update Your Browser");
						echo json_encode($ret);
						die();
					}
					
				}
			}else{
				array_push($ret, 0);
				array_push($ret, "Invalid Transaction Password");
				echo json_encode($ret);
				die();
			}
			
		}
			
		if(isset($_GET['tbb'])){
			$table=$_GET['tbb'];
			$cols=$_GET['cco'];
			$ttrr=$mysqli->query("SELECT DISTINCT $cols FROM $table");
			echo "<div class=\"col-sm-4\"></div>
				<div class=\"col-sm-4\">
				<select class='form-control ffiill' data-tds=\"".$cols."\" data-tbs=\"".$table."\">
				<option value=''>Select Option</option>
			";
			
			while($ggff=mysqli_fetch_assoc($ttrr)){
				$tyutr=$ggff[$cols];
				settype($tyutr);
				if($cols=="pack"){
					$yytruu=$mysqli->query("SELECT * FROM `package` WHERE `serial`='".$ggff[$cols]."'");
					$chheeccpac=mysqli_num_rows($yytruu);
					if($chheeccpac>0){
						$ghjk=mysqli_fetch_assoc($yytruu);
						$packll=$ghjk['pack'];
						$yy=mysqli_num_rows($mysqli->query("SELECT `user`,`$cols` FROM `$table` WHERE `$cols`='".$ggff[$cols]."'"));
						if($ggff[$cols]!=''){
							echo "<option value='".$ggff[$cols]."'>".$packll. " ( " . $yy ." )</option>";
						}
					}
				}else{
					$yy=mysqli_num_rows($mysqli->query("SELECT `user`,`$cols` FROM `$table` WHERE `$cols`='".$ggff[$cols]."'"));
					if($ggff[$cols]!=''){
						echo "<option value='".$ggff[$cols]."'>".$ggff[$cols]. " ( " . $yy ." )</option>";
					}
				}
				
			}
			echo "</select></div>";
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
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">New message</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form>
			  <div class="form-group">
				<p class="bg-danger text-danger" id="error" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<p class="bg-success text-success" id="succs" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Recipient:</label>
				<input type="text" class="form-control" id="recipient-name" readonly />
				<input type="hidden"  id="accTo" />
			  </div>
			  <div class="form-group">
				<label for="message-text" class="col-form-label">Transaction Pin:</label>
				<input type="password" class="form-control" id="trnpin" />
			  </div>
			  
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="avvootr">Approve</button>
		  </div>
		</div>
	  </div>
	</div>




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
											<i class="fa fa-bar-chart-o fa-fw"></i> Total Today Member Accounts Summary
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-4">
													<?php
														$rank=$_GET['user'];
														$total_member=mysqli_num_rows($mysqli->query("SELECT `user` FROM `ranks` WHERE `rank`='".$rank."' "));
													?>
													<button type="button" class="btn btn-info">Total Member (<?php echo $total_member; ?>)</button>
												</div>
												<div class="col-sm-4">
													<?php
														$rank=$_GET['user'];
														$total_memberCurrent=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total FROM `ranks` WHERE `rank`='".$rank."' "));
													?>
													<button type="button" class="btn btn-info">Total Current Amount ( $<?php echo $total_memberCurrent['total']; ?>)</button>
												</div>
												<div class="col-sm-4">
													<?php
														$rank=$_GET['user'];
														$total_memberBonus=mysqli_fetch_assoc($mysqli->query("SELECT SUM(c_wallet) as total2 FROM `ranks` WHERE `rank`='".$rank."' "));
													?>
													<button type="button" class="btn btn-info">Total Bonus Amount ($<?php echo $total_memberBonus['total2']; ?>)</button>
												</div>
											</div>
											<div class="row" id="filter">
											
											</div>
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive" id="new_member">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>SN:</th>
																	<th>User ID:</th>
																	<th>User Name:</th>
																	<th>Phone Number:</th>
																	<th>Current Amount:</th>
																	<th>Bonus Amount:</th>
																	<th>Achieve Date:</th>
																</tr>
															</thead>
<?php
	
	$t =  $mysqli->query("SELECT `user` FROM `ranks` WHERE `rank`='".$rank."' ");
	
						   
	$a= mysqli_fetch_object($t);
	$total_items= mysqli_num_rows($t);
	$limit=$_GET['limit'];
	$type=$_GET['type'];
	$page=$_GET['page'];
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 39) || ($limit > 41))
	{$limit = 40; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
						
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					

	$q =  $mysqli->query("SELECT * FROM `ranks` WHERE `rank`='".$rank."' ORDER BY serial DESC LIMIT $set_limit, $limit");
	//echo "SELECT * FROM `member` WHERE `date`='".$date."' AND `pack`!='' ORDER BY serial DESC LIMIT $set_limit, $limit";
	$n=1; 
	while($querygetexeres= mysqli_fetch_object($q)){
	   $mghh2=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$querygetexeres->user."' ORDER BY `serial` ASC LIMIT 1"));
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT `name`,`mobile` FROM `profile` WHERE `user`='".$querygetexeres->user."' OR `user`='".$mghh2['log_user']."'"));
	   
?>
															<tbody>
																<tr>
																	<td><?php echo $n++; ?></td>     
																	<td><a class="btn btn-info" href="member_login.php?user=<?php echo $mghh2['user']; ?>"><?php echo $mghh2['user']; ?></td> 
																	
																	<td><?php echo $mghh['name']; ?></td> 
																	<td><?php echo $mghh['mobile']; ?></td> 
																	<td><?php echo $querygetexeres->amount; ?></td>
																	<td><?php echo $querygetexeres->c_wallet; ?></td>
																	<td><?php echo date("Y-m-d", strtotime($querygetexeres->date)); ?></td>
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
													<!-- /.table-responsive -->
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
                </div>
            </div>
        </div>
			<?php require_once'footer.php'?>
        <div>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
			<script>
				$(window).scroll(function (event) {
					var scroll = $(window).scrollTop();
					console.log(scroll);
					// Do something
				});
				
				$(document).ready(function(){
					$("#yyy").on("focusout", function(){
						var iii=$(this).val();
						var req=$.ajax({
							method:"GET",
							url:"search_member.php",
							data:{check:"test", user:iii}
						});
						req.done(function(msg){
							$("#new_member").html(msg);
							//console.log(msg);
						});
					});
				});
			
				$(document).ready(function(){
					
					$(".criterr").on("click", function(e){
						e.preventDefault();
						e.stopPropagation();
						var sse=$(this).text();
						$(".search").text(sse);
						$(".search").attr("data-ssff", sse);
						$(".input-group-btn").removeClass("open");
					});
					$(".spe_create").on("click", function(e){
						e.preventDefault();
						e.stopPropagation();
						var sse=$(this).attr("data-uuss");
						console.log(sse);
					});
					
					var yy=setInterval(function(){
						$("#kjhhh").on("click", function(e){
							console.log("gfhghg");
						});
						$(".ffiill").on("change", function(){
							var hhgg=$(this).val();
							var cols=$(this).attr("data-tds");
							var tbale=$(this).attr("data-tbs");
							var req=$.ajax({
								method:"GET",
								url:"search_member.php",
								data:{hh:hhgg,tbs:tbale,cols:cols}
							});
							req.done(function(msg){
								$("#new_member").html(msg);
							});
							console.log(hhgg);
						});
						$("#new_member").on("scroll", function(){
							var hhg=$("body").scrollTop();
							console.log(hhg);
						})
					},1000);
					
				
					
					$(".actii").on("click", function(){
						var cols=$(this).attr("data-tds");
						var tbale=$(this).attr("data-tbs");
						var req=$.ajax({
							method:"GET",
							url: "",
							data: {tbb:tbale, cco:cols}
						});
						req.done(function(msg){
							$("#filter").html(msg);
							console.log(msg);
						});
					});
				})
				$('#exampleModal').on('show.bs.modal', function (event) {
				  var button = $(event.relatedTarget)
				  var recipient = button.data('whatever')
				  var tiil = button.data('tiil')
				  //var termil = button.data('termil')
				  var modal = $(this)
				  modal.find('.modal-title').text(tiil +' Access To '+ recipient)
				  modal.find('.modal-body #recipient-name').val(recipient)
				  modal.find('.modal-body #accTo').val(tiil)
				});
				$("#avvootr").on("click", function(){
					$("#error").text("");
					$("#succs").text("");
					var ytr=$("#trnpin").val();
					var usr=$("#recipient-name").val();
					var usrww=$("#accTo").val();
					if(ytr!=''){
						var req=$.ajax({
							method:"GET",
							url:"",
							data:{user:usr, piin:ytr,accssd:usrww}
						});
						req.done(function(rett){
							var fds=JSON.parse(rett);
							if(fds[0]==1){
								console.log(rett);
								$("#succs").text(fds[1]);
							}else{
								$("#error").text(fds[1]);
							}
						});
					}else{
						$("#error").text("Insert Transaction password");
					}
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
