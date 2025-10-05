<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/functions.php';
		require_once '../db/template.php';
		
		if(isset($_GET['chafnge'])){
			$date=$_GET['chafnge'];
			$linkp=$_GET['linkp'];
			$dsfgdsf=explode("?",$linkp);
			if($dsfgdsf[1]==''){
				$recTp=$linkp ."?date=".$date;
			}else{
				$recTp=$dsfgdsf[0] ."?date=".$date;
			}
			echo $recTp;
			die();
		}
		$date=date("Y-m-d");
		if(isset($_GET['date'])){
			$date=$_GET['date'];
		}else{
			$date=$date;
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
					<?php //require_once'topshow.php'?>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card red summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$
											<?php 
												$rtert=mysqli_fetch_assoc($board_game->query("SELECT SUM(amount) AS `Astotal` FROM `game_configure` WHERE `count_c`='2'"));
												echo $rtert['Astotal'];
											?>
											</div>
                                            <div class="sub-title">Total Play Current</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card green summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ <?php 
												$rtert=mysqli_fetch_assoc($board_game->query("SELECT SUM(curent_bal) AS `Gstotal` FROM `game_return` "));
												echo $rtert['Gstotal'];
											?></div>
                                            <div class="sub-title">Total Profit Return Current</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card yellow summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ 
											<?php 
												$rtert=mysqli_fetch_assoc($board_game->query("SELECT SUM(amount) AS `Pstotal` FROM `game_configure` WHERE `count_c`='1'"));
												echo $rtert['Pstotal'];
											?>
											</div>
                                            <div class="sub-title">Total Play Trading</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                       <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <a href="#">
                                <div class="card blue summary-inline">
                                    <div class="card-body">
                                        <div class="content">
                                            <div class="title" style="font-size: 30px;">$ 
											<?php 
												$rtert=mysqli_fetch_assoc($mysqli4->query("SELECT SUM(amount) AS `Tstotal` FROM `trade_win_reward` "));
												echo $rtert['Tstotal'];
											?>
											</div>
                                            <div class="sub-title">Total Profit Return Trading</div>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row  no-margin-bottom">
                       
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="fa fa-bar-chart-o fa-fw"></i> Total Today Games Summary
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											
											
											<div class="row">
												<div class="col-lg-12">
													<div class="table-responsive" id="new_member">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>SN:</th>       
																	<th>User:</th>
																	<th>Package:</th>
																	<th>Sponsored By:</th>
																	<th>Total Play( time ):</th>         
																	<th>Running Game Amount:</th>         
																	<th>Current Trading Balance</th>
																	<th>Current Balance</th>
																</tr>
															</thead>
<?php
	
	$fdgfd=maxMingAMEPLAYView('','',$board_game);				   
	$a= mysqli_fetch_object($t);
	$total_items= $fdgfd['totyal'];//mysqli_num_rows($t);
	$limit=$_GET['limit'];
	$type=$_GET['type'];
	$page=$_GET['page'];
	if((!$limit)  || (is_numeric($limit) == false) || ($limit < 39) || ($limit > 41))
	{$limit = 40; }
	if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
	{$page = 1; }
				
	$total_pages= ceil($total_items / $limit);
	$set_limit=$page * $limit - ($limit);					
	$fdgfd22=maxMingAMEPLAYView('',$set_limit,$board_game);
	$i=1;
	foreach($fdgfd22['total_sanitize'] as $withrwaUser){
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$withrwaUser."'"));
	   $mghh321=mysqli_fetch_assoc($mysqli->query("SELECT `final_taka` FROM `balance` WHERE `user`='".$withrwaUser."'"));
	   $mghh12=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh['log_user']."'"));
?>
															<tbody>
																<tr>
																	<td><?php echo $i++;; ?></td>     
																	<td><a class="btn btn-success" href="member_login.php?user=<?php echo $withrwaUser; ?>" id="color"><?php echo $withrwaUser; ?></a></td> 
																	<td><?php
																		if($mghh['pack']>0){
																			$uuu=$mghh['pack'];
																			settype($uuu, "integer");
																			if($uuu>0){
																				$packnnm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mghh['pack']."' "));
																				echo "<span style='color:".$packnnm['color']."'>" . $packnnm['pack'] ."</span>";
																			}else{
																				echo $mghh['pack'];
																			}
																		}else{
																			echo  "Starter";
																		}
																	?></td>     
																	
																	<td><?php echo $mghh['sponsor']; ?></td>
																	<td>
																	<span class="text-success text-center">Total:<?php echo mysqli_num_rows($board_game->query("SELECT `user` FROM `play` WHERE `user`='".$withrwaUser."' ")); ?></span><br/>
																	
																	</td>
																	
																	<td>$<?php 
																		$ertre12=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as toyu FROM `play` WHERE `user`='".$withrwaUser."' AND win='0'")); 
																		echo $ertre12['toyu'];
																	?></td>
																	<td>$<?php 
																		//$ertre112=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `trans_receive` WHERE `user_trans`='".$withrwaUser."' AND type='Withdraw' ORDER BY `date` DESC LIMIT 1")); 
																		echo gameDepositCalc($withrwaUser);;
																	?></td>
																	<td>$<?php 
																		echo $mghh321['final_taka'];
																	?></td>
																	
																	
																	
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
			<?php 
			require_once'footer.php';
			$fulllink=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			?>
        <div>
		<span id="FulLink" data-link="<?php echo $fulllink; ?>"></span>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
			
			<script>
				/* $( function() {
					$( "#datepicker" ).datepicker({
						dateFormat: "yy-mm-dd"
					});
				  } );*/
				  
				  $("#datepicker").on("keyup change", function(){ 
						var dateo=$(this).val();
						var linkm=$("#FulLink").attr("data-link");
						console.log(linkm);
						var tred=$.ajax({
							method:"GET",
							url:"",
							data:{linkp:linkm,chafnge:dateo}
						});
						tred.done(function(Banlink){
							location.href=Banlink;
							console.log(Banlink);
						});
				  });
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