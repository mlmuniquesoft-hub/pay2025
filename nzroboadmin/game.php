<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
		require '../db/functions.php';
		if(isset($_GET['dhdd'])){
			$dhdd=$_GET['dhdd'];
			$mmndfg=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `game_details` WHERE `serial`='".$dhdd."'"));
			echo $mmndfg['game_details'];
			die();
		}
		if(isset($_GET['serverTiim'])){
			echo "Server Time: " . date("d-m-Y h:i:s A") ."<br/>";
			echo "Bangladesh Time: " . date("d-m-Y h:i:s A", strtotime("+6 hours"));
			die();
		}
		
		if(isset($_GET['GameCheck'])){
			$hourrt=((($_GET['houur']-2)*60)*60);
			$minkt=($_GET['Mintk']*60);
			//echo $hourrt ." >> ".$minkt;
			$hghgj=$hourrt+$minkt;
			echo "Bangladesh Time: " .date("d-m-Y h:i:s A", time()+$hghgj);;
			die();
		}
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
                            <div class="row">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Add Games
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<form class="form-horizontal" id="formElem" name="formElem" action="game_action.php" method="post">
												<div class="form-group">
													<h3 style="color:red;text-align:center;"><?php echo $_SESSION['msg']; ?></h3>
													<h3 style="color:green;text-align:center;"><?php echo $_SESSION['msg1']; ?></h3>
												</div>
												<div class="form-group">
													<h3 id="ServerTime" style="text-align:center;color:green;"></h3>
												</div>
												<input type="hidden"  name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>">
												<div class="form-group" style="margin:10px;">
													<label class="col-sm-3 control-label">Game Type</label>
													<div class="col-sm-8">
														<select name="type" id="game_type" class="form-control">
															<option value="">Select Game Type</option>
															<?php
																$ttyy=$mysqli->query("SELECT * FROM `gamesetup` WHERE `active`='0'");
																while($hhggff=mysqli_fetch_assoc($ttyy)){
																//for($i=1;$i<=10;$i++){
															?>
															<option value="<?php echo $hhggff['serial']; ?>"><?php echo $hhggff['game_type'] ; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group" style="margin: 14px;">
													<label class="col-sm-3 control-label">Member Type</label>
													<div class="col-sm-8">
														<?php
															$mmnn=$mysqli->query("SELECT * FROM `package`");
															while($pacf=mysqli_fetch_assoc($mmnn)){
														?>
														<input type="checkbox" class="" name="user[]" value="<?php echo $pacf['serial']; ?>"><?php echo $pacf['pack']; ?> &nbsp;
														<?php } ?>
													</div>
												</div>
												
												
												<div class="form-group" style="margin: 14px;">
													<label class="col-sm-3 control-label">Member Level</label>
													<div class="col-sm-8">
														<?php
															$mmnn22=$mysqli->query("SELECT * FROM `level_user` ORDER BY `level` ASC");
															while($pacf33=mysqli_fetch_assoc($mmnn22)){
														?>
														<input type="checkbox" class="" name="level[]" value="<?php echo $pacf33['level']; ?>">Level-<?php echo $pacf33['level'] ."( ".$pacf33['user']." )"; ?> &nbsp;
														<?php } ?>
													</div>
												</div>
												<div class="form-group" style="margin: 14px;">
													<label class="col-sm-3 control-label">Use Trade Balance</label>
													<div class="col-sm-8">
														
														<input type="radio" class="" name="trade_bal" value="0" checked >Yes &nbsp;
														<input type="radio" class="" name="trade_bal" value="1">No &nbsp;
														
													</div>
												</div>
												<div class="form-group" style="margin:10px;">
													<label class="col-sm-3 control-label">Game Question</label>
													<div class="col-sm-8">
														
														<input type="text" class="form-control" name="short_ques" placeholder="Game Question ?">
														
													</div>
												</div>
												
												<div class="form-group pok-hide" style="margin:10px;">
													<label class="col-sm-3 control-label">First Team</label>
													<div class="col-sm-5">				
														<input id="f_country" name="criteria_active[]"  class="form-control remov"  type="text" placeholder="First Team" />
													</div>
													<div class="col-sm-3">				
														<input id="f_country" name="criteria_amn[]"  class="form-control remov"  type="text" placeholder="" />
													</div>
												</div>				
												<div class="form-group pok-hide draw" style="margin:10px;">
													<label class="col-sm-3 control-label">Second  Team</label>
													<div class="col-sm-5">				
														<input id="l_country" name="criteria_active[]"  class="form-control remov"  type="text" placeholder="Second  Team" />
													</div>
													<div class="col-sm-3">				
														<input id="l_country" name="criteria_amn[]"  class="form-control remov"  type="text" placeholder="" />
													</div>
													<div class="col-sm-1">				
														<button type="button" class="btn btn-info third">+</button>
													</div>
												</div>
												
												
												<div class="form-group short" style="display:none;margin:10px;" >
													<label class="col-sm-3 control-label"></label>
													<div class="col-sm-8">	
														<input type="text" name="criteria_active[]"  class=" col-sm-6 remov2" placeholder="Option" />
														<input type="text" name="criteria_amn[]"  class="col-sm-6 remov2" placeholder="Return" />
														<button type="button" class="btn btn-info insert">+</button>
													</div>
													
												</div>	
												
												<div class="form-group" style="margin:10px;">
													<label class="col-sm-3 control-label">Game Details</label>
													<div class="col-sm-8">	
														<select class="form-control" name="details" id="fullDeatils" >
															<option value="">Select Game Details</option>
															<?php 
																$fghgf2=$mysqli->query("SELECT * FROM `game_details` WHERE `active`='1'");
																while($hdfgss2=mysqli_fetch_assoc($fghgf2)){
															?>
															<option value="<?php echo $hdfgss2['serial']; ?>"><?php echo $hdfgss2['game_title']; ?></option>
															<?php } ?>
														</select>
														
													</div>
												</div>	
												
												
												<div class="form-group">
													<h3 id="StrtTimmn" style="text-align:center;color:green;"></h3>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Game Start Time</label>
													<div class="col-sm-4">	
														<input class="form-control" name="strtHours"  id="startHours" placeholder="Plus Hours" autocomplete="off"/>
													</div>
													<div class="col-sm-4">
														<input class="form-control" name="strtMinute" id="startMinute" placeholder="Plus Minute" autocomplete="off" />
													</div>
												</div>
												<div class="form-group">
													<h3 id="EndTimmn" style="text-align:center;color:green;"></h3>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Game End Time</label>
													<div class="col-sm-4">	
														<input class="form-control" name="endHours"  id="endHours" placeholder="Plus Hours" autocomplete="off" />
													</div>
													<div class="col-sm-4">
														<input class="form-control" name="endMinute"  id="endMinute" placeholder="Plus Minute" autocomplete="off" />
													</div>
												</div>
												<div class="form-group" style="margin:10px;">
													<label class="col-sm-3 control-label">Make Copy</label>
													<div class="col-sm-8">				
														<input type="number" name="copyNumber" class="form-control"  value="1" />
													</div>
												</div>
												<div class="form-group" style="margin:10px;">
													<label class="col-sm-3 control-label">Transaction Pin</label>
													<div class="col-sm-8">				
														<input type="password" name="pin" class="form-control"  placeholder="Transaction Pin" />
													</div>
												</div>
												
												
												<div class="form-group" style="margin:10px;">
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
                        
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-bar-chart-o fa-fw"></i> Upcoming Games
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
															<th scope="col">Game Type</th>
															<th scope="col">Game Criteria</th>
															<th scope="col">Member Types</th>
															<th scope="col">Member Level</th>
															<th scope="col">Win Criteria</th>
															<th scope="col">Remaining Time</th>
															<th scope="col">Change Time</th>
															<th scope="col">Action</th>											
															<th scope="col">Short Note For User</th>
															<th scope="col">Description</th>
														</tr>
													</thead>
				<?php
					$t = $mysqli->query("SELECT * FROM `games` WHERE `active`='10' ");
					$total_items= mysqli_num_rows($t);
					$limit=$_GET['limit'];
					$type=$_GET['type'];
					$page=$_GET['page'];
					if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51)){$limit = 50; }
					if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))	{$page = 1; }								
					$total_pages= ceil($total_items / $limit);
					$set_limit=$page * $limit - ($limit);			
					$q = $mysqli->query("SELECT * FROM `games` WHERE `active`='10' ORDER BY serial DESC LIMIT $set_limit, $limit");

					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						
					
						
				?>
													<tbody class="del<?php echo $querygetexeres->serial; ?>">
														<tr>
															<td><?php echo $n++; ?></td>										
															<td style="width:200px;">
																<select class="form-control ssdd" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="type" id="typed" style="width:200px;">
																	<?php
																		$hjdfg=$mysqli->query("SELECT `game_type`,`serial` FROM `gamesetup` WHERE `active`='0'");
																		while($asdfgg=mysqli_fetch_assoc($hjdfg)){
																	?>
																	<option value="<?php echo $asdfgg['serial']; ?>" <?php if($asdfgg['serial']==$querygetexeres->type){ echo "selected";} ?>><?php echo $asdfgg['game_type']; ?></option>
																	<?php } ?>
																</select>
																
															<?php 
																//$uu=mysqli_fetch_assoc($mysqli->query("SELECT `game_type`,`serial` FROM `gamesetup` WHERE `serial`='".$querygetexeres->type."'"));
															//echo $uu['game_type']; ?>
															
															</td>
															<td style="min-width: 400px;" data-serial="<?php echo $querygetexeres->serial; ?>"><?php 
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
																	echo "
																	<a class='btn btn-info Higgf".$querygetexeres->serial."' href='game_details.php?game=". base64_encode($crite[$i]) ."&serd=".base64_encode($querygetexeres->serial)."'> ". $crite[$i] . " ( ". $totalIInvest['total'] ." ) </a> &nbsp;&nbsp;&nbsp;
																	<input type='text' class='uopp GameOption".$querygetexeres->serial." removeOption".$i." ' style='display:none' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='return' data-cols='criteria_active' value='".$crite[$i]."'>
																	<input type='number' class='uopp removeOption".$i."' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='return' data-cols='criteria_amn' value='".$criteAmn[$i]."'>
																	<button style='display:none' type='button' data-serial='".$querygetexeres->serial."' class='btn btn-danger OptionRemove GameOption".$querygetexeres->serial." removeOption".$i."' data-numsd='".$i."'>X</button>
																	<span class='Higgf".$querygetexeres->serial."'><input type='radio' name='ff$n$i' class='upgg2 ' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='in' data-cols='criteria_inactive' ".$check2.">On &nbsp;&nbsp;&nbsp;</span>
																	<span class='Higgf".$querygetexeres->serial."'><input type='radio' name='ff$n$i' value='0' class='upgg2 Higgf".$querygetexeres->serial."' data-vals='".$i."' data-serial='".$querygetexeres->serial."' data-oi='out' data-cols='criteria_inactive' ".$check.">Off</span>
																	
																	<br/>";
																}
															?>
															<button type="button" style="display:none" class="btn btn-info insert GameOption<?php echo $querygetexeres->serial; ?>">+</button>
															<button type="button" data-edit="GameOption<?php echo $querygetexeres->serial; ?>" data-hide="Higgf<?php echo $querygetexeres->serial; ?>" class="btn btn-info edit">Edit</button>
															<button type="button" data-serial="<?php echo $querygetexeres->serial; ?>" style="display:none" data-edit="GameOption<?php echo $querygetexeres->serial; ?>" data-hide="Higgf<?php echo $querygetexeres->serial; ?>" class="btn btn-success editDone GameOption<?php echo $querygetexeres->serial; ?>">Done</button>
															</td>
															<td style="width:150px;">
															<?php
																$criteuser=explode("/", $querygetexeres->user);
																$mmnn=$mysqli->query("SELECT * FROM `package`");
																while($pacf=mysqli_fetch_assoc($mmnn)){
															?>
																<input  type="checkbox" class="ChangeUser" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="user" name="user[]" value="<?php echo $pacf['serial']; ?>" <?php if(in_array($pacf['serial'], $criteuser)){echo "checked";}?>><?php echo $pacf['pack']; ?> &nbsp;</br>
															<?php } ?>
															</td>
															<td style="width:150px;">
															<?php
																$leveluser=explode("/", $querygetexeres->level);
																//var_dump($leveluser);
																$mmnn12=$mysqli->query("SELECT * FROM `level_user` ORDER BY `level` ASC");
																while($pacf33=mysqli_fetch_assoc($mmnn12)){
															?>
																<input  type="checkbox" class="ChangeUser" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="level" name="level[]" value="<?php echo $pacf33['level']; ?>" <?php if(in_array($pacf33['level'], $leveluser)){echo "checked";}?>><?php echo $pacf33['level']; ?> &nbsp;</br>
															<?php } ?>
															</td>
															<td><?php 
																$crite=explode("/", $querygetexeres->criteria_active);
																$coum=count($crite)-1;
																for($i=0;$i<=$coum;$i++){
																	echo" 
																	<button class='btn btn-info' data-toggle='modal' data-target='#exampleModal' data-for='Win' data-serial='".$querygetexeres->serial."' data-whatever='".$crite[$i]."'> Win ".$crite[$i]."</button>
																	<br/>";
																}
															?></td>	
															<td style="min-width: 100px;">
															<span style="color:red" id="exh<?php echo $querygetexeres->serial; ?>"></span>
															<?php
															$rte=explode("/", $querygetexeres->endTime);
																//if(($querygetexeres->endTime!='')&&($querygetexeres->startTime!='')){
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
																		
																	//}
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
																			Live 
																		</div>
																		<span class="glyphicon form-control-feedback "></span>
																	</label>
																</div>
																<div class="form-group has-feedback">
																	<label class="input-group upgg" data-vals="0" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="active">
																		<span class="input-group-addon">
																			<input type="radio"  name="test<?php echo $querygetexeres->serial; ?>" value="0" <?php if($querygetexeres->active==0){echo "checked"; }?>/>
																		</span>
																		<div class="form-control form-control-static">
																			Inactive 
																		</div>
																		<span class="glyphicon form-control-feedback "></span>
																	</label>
																</div>
															</td>
															
															<td style="min-width: 200px;">
																<textarea class="form-control uupp" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="short_ques"><?php echo $querygetexeres->short_ques;?> </textarea>
															</td>
															<td style="min-width: 200px;">
																<textarea class="form-control uupp" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="details" ><?php echo $querygetexeres->details;?> </textarea>
															</td>
															
															
														</tr>
													</tbody>
				<?php } ?>
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
					var tywew=function(){
						$(".remov2").on("focusout", function(){
							var ttqw=$(this).val();
							var ttqw22=$(this).attr("data-cols");
							var serd=$(this).parent("td").attr("data-serial");
							console.log();//.attr("")
							console.log(ttqw);
							console.log(ttqw22);
							var resd=$.ajax({
								method:"GET",
								url:"remove_ele.php",
								data:{vals:ttqw,cols:ttqw22, serd:serd, werwe:"Add"}
							});
							resd.done(function(reaas){
								console.log(reaas);
							});
						});
					}
					var kkk=setInterval(function(){
						var ddff=$.ajax({
							method:"GET",
							url:"",
							data:{serverTiim:"fgaUUY"}
						});
						ddff.done(function(ress){
							$("#ServerTime").html(ress);
						});
						
					},1000);
					var GameTime=function(huyt,minutt,ids){
						var rettr=$.ajax({
							method:"GET",
							url:"",
							data:{GameCheck:"hjdfgfh",houur:huyt,Mintk:minutt}
						});
						rettr.done(function(redd){
							$("#"+ids).text(redd);
						});
					}
					$("#endMinute, #endHours").on("keyup", function(){
						var minnt=$("#endMinute").val();
						var hioout=$("#endHours").val();
						GameTime(hioout,minnt,"EndTimmn");
					});
					$("#startHours, #startMinute").on("keyup", function(){
						var minnt=$("#startMinute").val();
						var hioout=$("#startHours").val();
						GameTime(hioout,minnt,"StrtTimmn");
					});
					
					$(".edit").on("click", function(){
						var ttoo=$(this).attr("data-edit");
						var ttoo22=$(this).attr("data-hide");
						console.log(ttoo);
						$("."+ttoo).slideDown();
						$("."+ttoo22).slideUp();
					});
					$(".editDone").on("click", function(){
						var ttoo=$(this).attr("data-edit");
						var ttoo22=$(this).attr("data-hide");
						console.log(ttoo);
						$("."+ttoo).slideUp();
						$("."+ttoo22).slideDown();
					});
					
					
					
					$(".OptionRemove").on("click", function(){
						var ttoo=$(this).attr("data-numsd");
						var serd=$(this).attr("data-serial");
						
						var resd=$.ajax({
							method:"GET",
							url:"remove_ele.php",
							data:{rets:ttoo, serd:serd, redf:"Remove"}
						});
						resd.done(function(reaas){
							$(".removeOption"+ttoo).hide();
							console.log(reaas);
						});
					});
					$(".ChangeUser").on("click", function(){
						var ttoo=$(this).val();
						var serd=$(this).attr("data-serial");
						var cols=$(this).attr("data-cols");
						
						var resd=$.ajax({
							method:"GET",
							url:"remove_ele.php",
							data:{rets:ttoo,cols:cols, serd:serd, cvbd:"Change User"}
						});
						resd.done(function(reaas){
							//$(".removeOption"+ttoo).hide();
							console.log(reaas);
						});
					});
					
					$("#fullDeatils").on("change", function(){
						var hghhsd=$(this).val();
						var ereww=$.ajax({
							method:"GET",
							url:"",
							data:{dhdd:hghhsd}
						});
						ereww.done(function(ress){
							console.log(ress);
						});
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
									data:{gam: serd, ww:crite}
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
						  $(".insert").before( "<input type=\"text\" name=\"criteria_active[]\" data-cols='criteria_active'  class=\" col-sm-6 remov2\" placeholder=\"Option\" /><input type=\"text\" name=\"criteria_amn[]\" data-cols='criteria_amn'  class=\" col-sm-6 remov2\" placeholder=\"Return\" />" );
						tywew();
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
