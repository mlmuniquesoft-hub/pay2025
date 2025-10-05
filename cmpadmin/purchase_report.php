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
		$date=$_GET['date'];
		$DATE3=$_GET['date2'];
		function uSERiFG($user){
			global $mysqli;
			$hjgs=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
			$hjgs2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$hjgs['log_user']."' OR `user`='".$user."'"));
			return $hjgs2;
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
											<i class="fa fa-bar-chart-o fa-fw"></i> Total Member Accounts Summary
											<div class="pull-right"> </div>
										</div>
										<!-- /.panel-heading -->
										<div class="panel-body">
											
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
																	<th>User Info:</th>
																	<th>Sponsor:</th>         
																	<th>Upline:</th>         
																	<th>New Purchase:</th>
																	<th>Current Balance:</th>
																	<th>Total Purchase:</th>
																	
																</tr>
															</thead>
<?php
	$t =  $mysqli->query("SELECT * FROM upgrade WHERE DATE(`date`) BETWEEN '".$date."' AND '".$DATE3."'");
	
						   
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

	$q =  $mysqli->query("SELECT * FROM upgrade WHERE DATE(`date`) BETWEEN '".$date."' AND '".$DATE3."' ORDER BY serial DESC LIMIT $set_limit,$limit");
	$i=1;
	$err = mysqli_num_rows($q);	  
	while($querygetexeres= mysqli_fetch_object($q)){
	   $mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$querygetexeres->user."'"));
	   //$mghh22=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh['user']."' OR `user`='".$mghh['log_user']."'"));
?>
															<tbody>
																<tr>
																	<td><?php echo $i++; ?></td>     
																	<td><a class="btn btn-success" href="member_login.php?user=<?php echo $querygetexeres->user; ?>" id="color"><?php echo $querygetexeres->user; ?></a></td> 
																	<td>
																		<?php $userInfo=uSERiFG($querygetexeres->user); ?>
																		Name: <?php echo $userInfo['name']; ?><br/>
																		Email: <?php echo $userInfo['email']; ?><br/>
																		Mobile: <?php echo $userInfo['mobile']; ?><br/>
																	</td>
																	<td>
																		<?php $userInfo=uSERiFG($mghh['sponsor']); ?>
																		Member ID: <?php echo $mghh['sponsor']; ?><br/>
																		Name: <?php echo $userInfo['name']; ?><br/>
																		Email: <?php echo $userInfo['email']; ?><br/>
																		Mobile: <?php echo $userInfo['mobile']; ?><br/>
																	</td>
																	<td>
																		<?php $userInfo=uSERiFG($mghh['upline']); ?>
																		Member ID: <?php echo $mghh['upline']; ?><br/>
																		Name: <?php echo $userInfo['name']; ?><br/>
																		Email: <?php echo $userInfo['email']; ?><br/>
																		Mobile: <?php echo $userInfo['mobile']; ?><br/>
																	</td>
																	<td>$<?php echo $querygetexeres->amount; ?></td>
																	<td>$<?php echo remainAmn($querygetexeres->user); ?></td>
																	<td>$<?php 
																	$dfkjghk=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as tyoi FROM `upgrade` WHERE `user`='".$querygetexeres->user."'"));
																	echo $dfkjghk['tyoi']; 
																	?></td>
																	
																</tr>
   <?php  } ?>
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
					$(".newCVB").on("click", function(){
						var ttyu=$(this).attr("data-sdfg");
						$(".recovFD"+ttyu).show();
					});
					$(".NewREcv").on("click", function(){
						var ttyu2=$(this).attr("data-sert");
						var ttyu21=$(".ertyu"+ttyu2).val();
						//console.log(ttyu2);
						//console.log(ttyu21);
						var sdfgh=$.ajax({
							method:"GET",
							url:'',
							data:{dgdf:ttyu2,redf:ttyu21}
						});
						sdfgh.done(function(erww){
							console.log(erww);
						});
					});
					
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
