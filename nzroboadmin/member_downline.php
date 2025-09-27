<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		require_once '../db/functions.php';
		
		$refer=$_GET['ref'];
		$tableq=$_GET['table'];
		if($refer==''){
			//echo "<script>javascript:history.back()</script>";
			//die();
		}elseif($refer!=''){
			$referral=$_GET['ref'];
		}
		
		$table="member";
		$iiuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$referral."'"));
		$leftall=explode(",", $iiuu['totalLeftId']);
		$rightall=explode(",", $iiuu['totalrightId']);
		

		function CountUserqq($user,$table, &$sess){
			global $mysqli;
			if(!in_array($user, $sess)){
				array_push($sess, $user);
			}
			$users=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$user."'");
			while($user=mysqli_fetch_assoc($users)){
				//$_SESSION[$sess]=$_SESSION[$sess]+1;
				if(!in_array($user['user'], $sess)){
					array_push($sess, $user['user']);
				}
				CountUserqq($user['user'], $table, $sess);
			}
		}
		
		
		function leftRightqq($usse, $table){
			global $mysqli;
			$eer=array();
			$mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
			while($uuui=mysqli_fetch_assoc($mmm)){
				if($uuui['position']==1){
					$eer['left']=$uuui['user'];
				}elseif($uuui['position']==2){
					$eer['right']=$uuui['user'];
				}
			}
			return $eer;
		}
		
		
		$usekk=leftRightqq($referral, $table);
		
		if($leftall[0]==''){
			$totalLeft=array();
		}else{
			$totalLeft=$leftall;
		}
		if($rightall[0]==''){
			$totalRight=array();
		}else{
			$totalRight=$rightall;
		}
		
		//$activveRight=activeFilter($totalRight);
		//$activveLeft=activeFilter($totalLeft);
		//var_dump($activveLeft);
		//var_dump($totalLeft);
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
											<i class="fa fa-bar-chart-o fa-fw"></i> Total <span id="POssd">Left</span> Member Accounts Summary ( <?php echo $referral?> )
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											
											<div class="row">
												<div class="col-sm-3">
													<?php
														//$total_member=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member`"));
													?>
													<button type="button" class="btn btn-info">Total Down Member (<?php echo count($totalLeft)+count($totalRight); ?>)</button>
												</div>
								
											</div>
											<div class="row" >
												<div class="col-sm-6">
													<button class="btn btn-info leftVal" data-hide="Right" data-show="Left">Left</button>
												</div>
												<div class="col-sm-6">
													<button class="btn btn-info leftVal" data-hide="Left" data-show="Right">Right</button>
												</div>
												
											</div>
											<div class="row">
												<div class="col-lg-12" id="Left">
													<div class="table-responsive" id="new_member">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>SN:</th>       
																	<th>User:</th>
																	<th>Package:</th>
																	<th>Sponsor:</th>
																	<th>Ref:</th>
																	<th>Dep:</th>         
																	<th>Self Sponsor:</th>         
																	<th>Gen:</th>
																	<th>Rank:</th>
																	<th>Net:</th>                    
																	<th>Position</th>                    
																	<th>View Downline</th>               
																</tr>
															</thead>
<?php
	
	foreach($totalLeft as $usersa){
		//echo $usersa;
	   $querygetexeres=mysqli_fetch_object($mysqli->query("SELECT * FROM `balance` WHERE `user`='".$usersa."'"));
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$querygetexeres->user."'"));
	   $mghh2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$mghh['sponsor']."'"));
	   $mghh21=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh2['user']."' OR `user`='".$mghh2['log_user']."'"));
?>
															<tbody>
																<tr>
																	<td><?php echo $querygetexeres->serialno; ?></td>     
																	<td><a class="btn btn-success" href="member_login.php?user=<?php echo $querygetexeres->user; ?>" id="color"><?php echo $querygetexeres->user; ?></a></td> 
																	<td><?php
																		if($mghh['pack']!='0'){
																			
																			$packnnm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mghh['pack']."' "));
																			echo "<span style='color:".$packnnm['color']."'>" . $packnnm['pack'] ."</span>";
																			
																		}else{
																			echo  "Starter";
																		}
																	?></td>     
																	<td>
																		Login ID: <?php echo $mghh['sponsor']; ?><br/>
																		Name: <?php echo $mghh21['name']; ?><br/>
																		Email: <?php echo $mghh21['email']; ?><br/>
																		Mobile: <?php echo $mghh21['mobile']; ?><br/>
																	</td>
																	<td><?php echo $querygetexeres->direct_taka; ?></td>
																	<td><?php echo $querygetexeres->bcpp_taka; ?></td>
																	<td>
																		<a href="member_total_sponsor.php?uud=<?php echo base64_encode($querygetexeres->user); ?>" class="btn btn-danger">
																			<?php
																				echo mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `sponsor`='".$querygetexeres->user."' AND `pack`>'0'"));
																			?>
																		</a>
																		
																	</td>  	 
																	<td><?php echo $querygetexeres->generation_taka; ?></td> 
																	<td></td>  	 
																	<td><?php echo $querygetexeres->final_taka; ?></td>
																	<td>Left</td>
																	<td><a href="member_downline.php" class="btn btn-info">View Downline</a></td>
																</tr>
<?php } ?>
															</tbody>
														</table>
													</div>
													<!-- /.table-responsive -->
												</div>
												<div class="col-lg-12" id="Right" style="display:none;">
													<div class="table-responsive" id="new_member">
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>SN:</th>       
																	<th>User:</th>
																	<th>Package:</th>
																	<th>Sponsor:</th>
																	<th>Ref:</th>
																	<th>Dep:</th>         
																	<th>Self Sponsor:</th>         
																	<th>Gen:</th>
																	<th>Rank:</th>
																	<th>Net:</th>                    
																	<th>Position</th>                    
																	<th>View Downline</th>                
																</tr>
															</thead>
<?php
	
	foreach($totalRight as $usersa2){
	   $querygetexeres=mysqli_fetch_object($mysqli->query("SELECT * FROM `balance` WHERE `user`='".$usersa2."'"));
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$querygetexeres->user."'"));
	   $mghh2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$mghh['sponsor']."'"));
	   $mghh21=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh2['user']."' OR `user`='".$mghh2['log_user']."'"));
?>
															<tbody>
																<tr>
																	<td><?php echo $querygetexeres->serialno; ?></td>     
																	<td><a class="btn btn-success" href="member_login.php?user=<?php echo $querygetexeres->user; ?>" id="color"><?php echo $querygetexeres->user; ?></a></td> 
																	<td><?php
																		if($mghh['pack']!='0'){
																			$packnnm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mghh['pack']."' "));
																			echo "<span style='color:white;padding:5px;background-color:".$packnnm['color']."'>" . $packnnm['pack'] ."</span>";
																			
																		}else{
																			echo  "Starter";
																		}
																	?></td>     
																	<td>
																		Login ID: <?php echo $mghh['sponsor']; ?><br/>
																		Name: <?php echo $mghh21['name']; ?><br/>
																		Email: <?php echo $mghh21['email']; ?><br/>
																		Mobile: <?php echo $mghh21['mobile']; ?><br/>
																	</td>
																	<td><?php echo $querygetexeres->direct_taka; ?></td>
																	<td><?php echo $querygetexeres->bcpp_taka; ?></td>
																	<td>
																		<a href="member_total_sponsor.php?uud=<?php echo base64_encode($querygetexeres->user); ?>" class="btn btn-danger">
																			<?php
																				echo mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `sponsor`='".$querygetexeres->user."' AND `pack`>'0'"));
																			?>
																		</a>
																		
																	</td>  	 
																	<td><?php echo $querygetexeres->generation_taka; ?></td> 
																	<td></td>  	 
																	<td><?php echo $querygetexeres->final_taka; ?></td>
																	<td>Right</td>
																	<td><a href="member_downline.php" class="btn btn-info">View Downline</a></td>
																</tr>
<?php } ?>
															</tbody>
														</table>
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
					$(".leftVal").on("click", function(){
						var ttk=$(this).attr("data-hide");
						var ttk22=$(this).attr("data-show");
						$("#POssd").text(ttk22);
						$("#"+ttk).hide();
						$("#"+ttk22).show();
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
				  if(tiil=="Create Pin"){
					$("#caash").show();
				  }else{
					  $("#caash").hide();
				  }
				 
				});
				$("#avvootr").on("click", function(){
					var selValue;
					$("#error").text("");
					$("#succs").text("");
					var ytr=$("#trnpin").val();
					var usr=$("#recipient-name").val();
					var usrww=$("#accTo").val();
					if(usrww=="Create Pin"){
						selValue=$('input[name=rbnNumber]:checked').val();
					}else{
						selValue=0;
					}
					
					if(ytr!=''){
						var req=$.ajax({
							method:"GET",
							url:"",
							data:{user:usr, piin:ytr,accssd:usrww,ddect:selValue}
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
