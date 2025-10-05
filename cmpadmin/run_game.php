<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		require '../db/functions.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
		$seel=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."'"));
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
	<style>
		

		/* Add a right margin to each icon */
		.fa {
			margin-left: -12px;
			margin-right: 8px;
		}
	</style>
		<script>
var GhhTime=function(ttiimm,ppllcc,ppllcc2){
	var countDownDate = new Date(ttiimm).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

		// Get todays date and time
		var now = new Date().getTime();
		
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		// Output the result in an element with id="demo"
		document.getElementById(ppllcc).innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
		 console.log("hello");
		
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById(ppllcc).innerHTML = "EXPIRED";
		}
	}, 1000);
}

	//console.log(tyyuu);

</script>
</head>

<body class="flat-blue">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="exampleModalLabel">New message</h4>
		  </div>
		  <div class="modal-body">
			<form>
			  <div class="form-group">
				<p id="error" style="text-align:center; color:red;"></p>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="control-label" id="crritt">Win Criteria:</label>
				<input type="text" class="form-control" id="recipient-name" readonly />
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="control-label" id="crritt">Last Counting Time:</label>
				<input type="text" class="form-control" id="countTime"  />
			  </div>
			  
			  <div class="form-group">
				<label for="message-text" class="control-label">Transaction Pin:</label>
				<input type="password" class="form-control" id="pin"  />
				<input type="hidden" class="form-control" id="sers"  />
			  </div>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" id="game_submit" class="btn btn-success">Win</button>
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
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Live Games
									<div class="pull-right"> </div>
								</div>
								<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-12">
											<button class="btn btn-success " id="inactiveAll">Inactive All Games Criteria</button>
											<button class="btn btn-info btload" style="display:none;">
											  <i class="fa fa-spinner fa-spin"></i>Loading
											</button>
											<h4 class="text-success text-center" id="Inactivemess"></h4>
											<div class="table-responsive">
												<table class="table table-bordered table-hover table-striped">
													<thead>
														<tr>
															<th scope="col">Check</th>										
															<th scope="col">Serial</th>										
															<th scope="col">Game Type</th>
															<th scope="col">Game Criteria</th>
															<th scope="col">Member Types</th>
															<th scope="col">Win Criteria</th>
															<th scope="col">Remaining Time</th>
															<th scope="col">Change Time</th>
															<th scope="col">Action</th>											
															<th scope="col">Action</th>
															<th scope="col">Short Note For User</th>
															<th scope="col">Description</th>
														</tr>
													</thead>
													<form method="POST" id="devel-generate-content-form" action="multiinactiveCriteria_send.php">
									
									<div class="modal fade" id="exampleMoghjgdal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">New message</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			  <div class="form-group">
				<p class="bg-danger text-danger" id="error" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<p class="bg-success text-success" id="succs" style="text-align:center;"></p>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Total Select:</label>
				<input type="text" class="form-control" id="edit-count-checked-checkboxes" name="yyww" readonly />
			  </div> 
			 
			  <div class="form-group">
				<label for="message-text" class="col-form-label">Transaction Pin:</label>
				<input type="password" class="form-control" id="trnpin3" name="trPin"/>
				<input type="hidden" value="<?php echo $_SERVER['PHP_SELF']; ?>" name="location"/>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" id="fgjfgjfg">Inactive</button>
		  </div>
		</div>
	  </div>
	</div>
				<?php
					$t = $mysqli->query("SELECT * FROM `games` WHERE `active`='1' ");
					$total_items= mysqli_num_rows($t);
					$limit=$_GET['limit'];
					$type=$_GET['type'];
					$page=$_GET['page'];
					if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51)){$limit = 50; }
					if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))	{$page = 1; }								
					$total_pages= ceil($total_items / $limit);
					$set_limit=$page * $limit - ($limit);			
					$q = $mysqli->query("SELECT * FROM `games` WHERE `active`='1' ORDER BY serial DESC LIMIT $set_limit, $limit");

					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						$IUERhh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_details` WHERE `serial`='".$querygetexeres->details."' "));
					
						
				?>
													<tbody class="del<?php echo $querygetexeres->serial; ?>">
														<tr>
															<td>
																<input type="checkbox" class="ddgg" name="bbb<?php echo $querygetexeres->serial; ?>" value="<?php echo $querygetexeres->serial; ?>"  />
																<button style="display:none;" id="kkj<?php echo $querygetexeres->serial; ?>" type="button" class="btn btn-info btn-block hideall" data-toggle="modal" data-target="#exampleMoghjgdal" data-multi='1' data-whatever="" data-sers="<?php echo $querygetexeres->serial; ?>">Inactive Now</button>
															</td>
															<td><?php echo $n++; ?></td>										
															<td><?php 
																$uu=mysqli_fetch_assoc($mysqli->query("SELECT `game_type`,`serial` FROM `gamesetup` WHERE `serial`='".$querygetexeres->type."'"));
															echo $uu['game_type']; ?>
															
															</td>
															<td style="min-width: 400px;"><?php 
																$crite=explode("/", $querygetexeres->criteria_active);
																$criteIn=explode("/", $querygetexeres->criteria_inactive);
																$criteAmn=explode("/", $querygetexeres->criteria_amn);
																$coum=count($crite)-1;
																for($i=0;$i<=$coum;$i++){
																	$check='';
																	$check2='';
																	if(in_array($crite[$i], $criteIn)){
																		$check="checked";
																	}else{
																		$check2="checked";
																	}
																	$totalIInvest=mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) as total FROM `play` WHERE `choice`='".$crite[$i]."' AND `gameid`='".$querygetexeres->serial."'"));
																	if($_SESSION['OriginalAdmin']=="superadmin"){
																	echo "<a class='btn btn-info' href='game_details.php?game=". base64_encode($crite[$i]) ."&serd=".base64_encode($querygetexeres->serial)."'> ". $crite[$i] . " ( ". $totalIInvest['total'] ." ) </a> &nbsp;&nbsp;&nbsp;
																	<input type='number' class='uopp' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='return' data-cols='criteria_amn' value='".$criteAmn[$i]."'>
																	<input type='radio' name='ff$n$i' class='upgg2' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='in' data-cols='criteria_inactive' ".$check2.">On &nbsp;&nbsp;&nbsp;
																	<input type='radio' name='ff$n$i' value='0' class='upgg2' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='out' data-cols='criteria_inactive' ".$check.">Off
																	
																	<br/>";
																	}else{
																		echo "<a class='btn btn-info' href='game_details.php?game=". base64_encode($crite[$i]) ."&serd=".base64_encode($querygetexeres->serial)."'> ". $crite[$i] . " ( ". $totalIInvest['total'] ." ) </a> &nbsp;&nbsp;&nbsp;
																	<input type='radio' name='ff$n$i' class='upgg2' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='in' data-cols='criteria_inactive' ".$check2.">On &nbsp;&nbsp;&nbsp;
																	<input type='radio' name='ff$n$i' value='0' class='upgg2' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='out' data-cols='criteria_inactive' ".$check.">Off
																	
																	<br/>";
																	}
																}
															?></td>
															<td><?php 
																$criteuser=explode("/", $querygetexeres->user);
																
																foreach($criteuser as $user){
																	$mmm=mysqli_fetch_assoc($mysqli->query("SELECT `pack`,`serial` FROM `package` WHERE `serial`='".$user."'"));
																	echo $mmm['pack']." 
																	<br/>";
																}
															?></td>
															<td><?php 
																$crite=explode("/", $querygetexeres->criteria_active);
																$coum=count($crite)-1;
																for($i=0;$i<=$coum;$i++){
																	echo" 
																	<button class='btn btn-info' type='button' data-toggle='modal' data-target='#exampleModal' data-for='Win' data-serial='".$querygetexeres->serial."' data-whatever='".$crite[$i]."'> Win ".$crite[$i]."</button>
																	<br/>";
																}
															?></td>	
															<td style="min-width: 100px;">
															<span style="color:red" id="exh<?php echo $querygetexeres->serial; ?>"></span>
															<?php
															$rte=explode("/", $querygetexeres->endTime);
																if(($querygetexeres->endTime!='')&&($querygetexeres->startTime!='')){
																		$strtTime=strtotime(GMTtmeConvert($querygetexeres->date,"-2 hours",$querygetexeres->startTime));
																		$sdfg=GMTtmeConvert($querygetexeres->date,"-2 hours",$querygetexeres->endTime);
																		$enddTime=strtotime($sdfg);
																		$enddTimeLocal=SeverToLocalTime($mysqli, $sdfg,"-0 hours");
															?>
																<script>
																	// Set the date we're counting down to
																	var tyyuu="<?php echo date("M d, Y H:i:s ", strtotime($enddTimeLocal)); ?>";
																	//var tyyuu21="<?php //echo "minsec" . $allgame['serial']; ?>";
																	var tyyuu22="<?php echo "exh" . $querygetexeres->serial; ?>";
																	
																	GhhTime(tyyuu, tyyuu22, '');
																</script>
															<?php
																		
																	}
															?>
															</td>
															<td style="min-width: 100px;">
																<input type="text" class="form-control uupp" id="Hourd<?php echo $querygetexeres->serial; ?>" data-another="mintTim<?php echo $querygetexeres->serial; ?>" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="endTime" value="<?php echo $rte[0]; ?>" >
																<input type="text" class="form-control uupp" id="mintTim<?php echo $querygetexeres->serial; ?>" data-another="Hourd<?php echo $querygetexeres->serial; ?>" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="endTime" value="<?php echo $rte[1]; ?>" >
															</td>
															<td>
																<div class="form-group has-feedback">
																	<label class="input-group upgg" data-vals="1" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="active">
																		<span class="input-group-addon">
																			<input type="radio"  name="test<?php echo $querygetexeres->serial; ?>" value="1" <?php if($querygetexeres->active==1){echo "checked"; }?>/>
																		</span>
																		<div class="form-control form-control-static">
																			Active
																		</div>
																		<span class="glyphicon form-control-feedback "></span>
																	</label>
																</div>
																<div class="form-group has-feedback ">
																	<label class="input-group upgg" data-vals="0" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="active">
																		<span class="input-group-addon">
																			<input type="radio" name="test<?php echo $querygetexeres->serial; ?>" value="0" <?php if($querygetexeres->active==0){echo "checked"; }?>/>
																		</span>
																		<div class="form-control form-control-static">
																			Inactive
																		</div>
																		<span class="glyphicon form-control-feedback "></span>
																	</label>
																</div>
															</td>
															<td>
																<button href="#" type="button" class="btn btn-danger btn-sm upgg" data-toggle='modal' data-target='#exampleModal' data-serial='<?php echo $querygetexeres->serial; ?>' data-whatever='<?php echo $querygetexeres->short_ques;?>' data-for="Cancel">Cancel</button>
															</td>
															<td style="min-width: 200px;">
																<textarea class="form-control uupp" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="short_ques"><?php echo $querygetexeres->short_ques;?> </textarea>
															</td>
															<td style="min-width: 200px;">
																<textarea class="form-control " data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="details" ><?php echo $IUERhh['game_details'];?> </textarea>
															</td>
															
															
														</tr>
													</tbody>
				<?php } ?>
				</form>
												</table>
				<p align="center" style="font-family:Helvetica, Arial, sans-serif;"><center>
				<input type="hidden" id="hhgg" value="<?php echo $seel['tr_password']; ?>">
				<?php 
					$cat = urlencode($cat); 
					$prev_page = $page - 1;
					if($prev_page >= 1) 
					{echo("<b>&lt;&lt;</b> <a href=?limit=$limit&amp;page=$prev_page><b>Prev.</b></a>");}
					for($a = 1; $a <= $total_pages; $a++)
					{
					if($a == $page)
					{echo("<b> $a</b> | ");	}
					else 
					{echo("  <a href=?limit=$limit&amp;page=$a> $a </a> | ");}
					}
					$next_page = $page + 1;
					if($next_page <= $total_pages) 
					{ echo("<a href=?limit=$limit&amp;page=$next_page><b>Next</b></a> &gt; &gt;");}
				?>
				</center>  
				</P> 
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
					$("#inactiveAll").on("click", function(){
						$(this).hide();
						$(".btload").show();
						var retty=$.ajax({
							method:"GET",
							url:"inactive_allGmae.php",
							data:{llk:"dfgfd"}
						});
						retty.done(function(redf){
							$("#Inactivemess").text("Inactive "+redf+" Games");
							$("#inactiveAll").show();
							$(".btload").hide();
						});
					});
					$(".ddgg").on("click", function(){
						var $checkboxes = $(' input[type="checkbox"]');
						var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
						//console.log(countCheckedCheckboxes);
						$('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
						var ttt=$(this).val();
						$(".hideall").hide();
						$("#kkj"+ttt).show();
					});
					$('#exampleModal').on('show.bs.modal', function (event) {
						var button = $(event.relatedTarget);
						var recipient = button.data('whatever');
						var serr = button.data('serial');
						var hhgg = button.data('for');
						var modal = $(this);
						modal.find('.modal-title').text( hhgg+ " " + recipient );
						modal.find('.modal-body #recipient-name').val(recipient);
						modal.find('.modal-body #sers').val(serr);
						modal.find('#crritt').text(hhgg+" Criteria");
						modal.find('#game_submit').text(hhgg);
					});
					$("#pin").on("focusin", function(){
						$("#error").text("");
					});
					
					
					$("#game_submit").on("click", function(){
						var serd=$("#sers").val();
						var crite=$("#recipient-name").val();
						var pin=$("#pin").val();
						var pin2=$("#hhgg").val();
						var LastcountTime=$("#countTime").val();
						var tfg=$("#game_submit").text();
						if(pin!=''){
							if(pin==pin2){
								if(tfg=="Win"){
									var trru="game_done.php";
								}else if(tfg=="Cancel"){
									trru="game_cancel.php";
								}
								var reqqq=$.ajax({
									method:"GET",
									url: trru,
									data:{gam: serd, ww:crite,LastcountTime:LastcountTime}
								});
								reqqq.done(function(msg){
									var tty=JSON.parse(msg);
									if(tty[0]==0){
										$("#error").text(tty[1]);
									}
									if(tty[0]==1){
										location.reload();
										//console.log(tty[1]);
									}
								});
							}else{
								$("#error").text("Invalid Transaction Pin");
							}
						}else{
							$("#error").text("Insert Transaction Pin");
						}
					});
				
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
					  $(".insert").on("click", function(){
						  $(".insert").before( "<input type=\"text\" name=\"criteria_active[]\"  class=\" col-sm-6 remov2\" placeholder=\"Option\" /><input type=\"text\" name=\"criteria_amn[]\"  class=\" col-sm-6 remov2\" placeholder=\"Return\" />" );
					  })
					  
					  $(".third").on("click", function(){
						  $("draw22").hide();
						  $(".draw").after( "<div class=\"form-group pok-hide draw22\" ><label class=\"col-sm-3 control-label\">Draw</label><div class=\"col-sm-5\"><input id=\"l_country\" name=\"criteria_active[]\"  class=\"form-control remov\"  type=\"text\" placeholder=\"Draw\" /></div><div class=\"col-sm-3\"><input id=\"l_country\" name=\"criteria_amn[]\"  class=\"form-control remov\"  type=\"text\" placeholder=\"\" /></div></div>" );
					  })
					  
					  
					  $("#game_type").on("change", function(){
						  var yyy=$(this).val();
						  var req=$.ajax({
							  method:"GET",
							  url: "game_info.php",
							  data:{tt:yyy}
						  });
						  req.done(function(msg){
							  var yye=JSON.parse(msg);
						  });
					  });
					  var yy=setInterval(function(){
						   $(".long").on("click", function(){
							   $(".short").hide();
								$(".draw22").hide();
							  $(".pok-hide").show();
							  $(".remov2").val("");
						  })
						  $("#short").on("click", function(){
							  $(".short").show();
							  $(".pok-hide").hide();
							  $(".remov").val("");
						  });
					  },1000);
					 
					  
					  $("#over").on("click", function(){
						  $(".Over").show();
						   $(".Goal").hide();
					  });
					  $("#goal").on("click", function(){
						  $(".Over").hide();
						  $(".Goal").show();
						  
					  });
					  
					  $(".poker").on("click", function(){
						  $(".pok-hide").slideUp();
					  });
					  $('.poker-open').on("click", function(){
						   $(".pok-hide").slideDown();
					  });
				  });

				</script>
				<script>
					$(document).ready(function(){
						$(".uupp").on("keyup", function(){
							var vals=$(this).val();
							var srl=$(this).attr("data-serial");
							var cols=$(this).attr("data-cols");
							var another=$(this).attr("data-another");
							if(another == null){
								vals=vals;
							}else{
								var YUii=$("#Hourd"+srl).val();
								var YUii22=$("#mintTim"+srl).val();
								vals=YUii +"/"+YUii22;
							}
							if(vals!=''){
								var reqq=$.ajax({
									method:"GET",
									url: "info_update_action.php",
									data:{vas: vals, sers: srl, coll:cols, tbs:"games"}
								});
							}
							
						});
						
						$(".uopp").on("keyup", function(){
							var vals=$(this).val();
							var srl=$(this).attr("data-serial");
							var cols=$(this).attr("data-cols");
							var vals2=$(this).attr("data-vals");
							
							if(vals!=''){
								var reqq=$.ajax({
									method:"GET",
									url: "info_update_action.php",
									data:{vas: vals, sers: srl, coll:cols, tbs:"games", retur:vals2}
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
									data:{vas: vals, sers: srl, coll:cols, tbs:"games"}
								});
							}
						});
						$(".upgg2").on("click", function(e){
							//e.preventDefault();
							//e.stopPropagation();
							var vals=$(this).attr("data-vals");
							var srl=$(this).attr("data-serial");
							var cols=$(this).attr("data-cols");
							var cols2=$(this).attr("data-oi");
							if(vals=="Delete"){
								$(".del"+srl).hide();
							}
							if(vals!=''){
								var reqq=$.ajax({
									method:"GET",
									url: "info_update_action.php",
									data:{vas: vals, sers: srl, coll:cols, tbs:"games",game:cols2}
								});
								reqq.done(function(msg){
									console.log(msg);
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
									data:{vas: vals, sers: srl, coll:cols, tbs:"games"}
								});
							}
						})
					});
				
				</script>
			<!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
</body>

</html>
