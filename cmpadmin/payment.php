<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php'; 
		$rett=array();
		if(isset($_GET['codesf'])){
			$codesf=$_GET['codesf'];
			if($codesf==$_SESSION['withdraa']){
				//unset($_SESSION['withdraa']);
				array_push($rett,1);
				array_push($rett,"Success");
				die(json_encode($rett));
			}else{
				array_push($rett,0);
				array_push($rett,"Invalid Site Transaction Code");
				die(json_encode($rett));
			}
		}
		if(isset($_GET['chhK'])){
			$amount=$_GET['amount'];
			
			$baseUrl="https://coopcrowds.uk/merchant/4dff5870-0a2e-4321-8d66-df4138ba4ace/balance?password=16DJkuF3SMTVCd519WycRF3zkjDoYoT5V1";
			$ere=json_decode(file_get_contents($baseUrl));
			$BtcAmn=number_format(RetunExchane22("USD",$ere->balance/100000000), 2,'.','');
			if($BtcAmn<$amount){
				array_push($rett,0);
				array_push($rett,"Insufficient Balance");
				die(json_encode($rett));
			}else{
				$user=$_GET['user'];
				$pin=$_GET['pin'];
				$checkl=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
				if($checkl<1){
					array_push($rett,0);
					array_push($rett,"Invalid Transaction Password");
					die(json_encode($rett));
				}
				
				
				$code=str_shuffle(substr(time(),3));
				$message="
					<h3 style='font-size:22px'>Site Transaction Code</h3><br/>
					<p style='font-size:16px'>
					New Withdraw Request Proceed To Confirm. 
					<br/>
					<br/>
					</p>
					<br/>
					<p><a style='margin:12px 0px;display:block;text-decoration:none;background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;padding:10px;font-size:32px;text-align:center;' href='#'>$code</a> </p>
					<br/>
					Thanks By, Capitol Money Pay Team<br/>
					<a href='mailto:support@capitolmoneypay.com'>support@capitolmoneypay.com</a>
					
				";
				
				$_SESSION['withdraa']=$code;
				//$to="yennavajo@gmail.com";
				$to="mainur22@gmail.com";
				
				$subject="Withdraw Request Confirmation";
				$from = "info@capitolmoneypay.com";
				$headers = "From:" . $from;
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "From: Capitol Money Pay <info@capitolmoneypay.com>" . "\r\n";
				mail($to,$subject,$message,$headers);
				
				array_push($rett,1);
				array_push($rett,"mail send, Success");
				die(json_encode($rett));
			}
		}
		
		
		$query = "select * from admin where user_id='".$_SESSION['OriginalAdmin']."' ";
		
		$result=  $mysqli->query($query);
		$row =  mysqli_fetch_array($result);
		
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
</head>

<body class="flat-blue">
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="exampleModalLabel">New message</h4>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group " >
								<h3 class="ffdd"></h3>
							</div>
							<div id="step1">
								<div class="form-group" style="margin-bottom:10px;">
									<label for="recipient-name" class="control-label">Recipient:</label>
									<input type="text" class="form-control" id="recipient-name" readonly />
								</div>
								<div class="form-group" style="margin-bottom:10px;">
									<label for="message-text" class="control-label">Pay From:</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="payFrom" value="1" checked />External Wallet &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" name="payFrom" value="2" />Site Wallet
								</div>
								<div class="form-group">
									<label for="message-text" class="control-label">transaction PIN:</label>
									<input type="password" class="form-control" id="pin" />
								</div>
							</div>
							<div id="step2" style="display:none;">
								<div class="form-group">
									<label for="message-text" class="control-label">Site Transaction Code:</label>
									<input type="text" class="form-control" id="verCode" />
								</div>
								<div class="form-group">
									<button type="button" class="btn btn-info" id="CheckCode">Verify Code</button>
								</div>
								
							</div>
						</form>
						<input type="hidden" class="form-control" id="vals">
						<input type="hidden" class="form-control" id="cols">
						<input type="hidden" class="form-control" id="serial">
						<input type="hidden" class="form-control" id="amn">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default ccdd" data-dismiss="modal">Close</button>
						<button type="button" id="SubCheck" class="btn btn-primary">Submit</button>
						<button type="button" id="SubFinal" class="btn btn-primary upgg" style="display:none;">Submit</button>
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
							<div class="col-xs-12">								
								<div class="panel panel-default">
									<div class="panel-heading text-warning" style="text-align: center;font-weight: bold;font-size: 16px;">
										<span style="color: #f89d30;">Withdrawal Request Pending</span>
										<div class="pull-right"> </div>
									</div>
									
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-12">
											<h3 style="color:red;text-align:center;"><?php 
												if(isset($_SESSION['msg'])) {
													echo $_SESSION['msg']; 
													unset($_SESSION['msg']);
												}
											?></h3>
											<h3 style="color:green;text-align:center;"><?php 
												if(isset($_SESSION['msg1'])) {
													echo $_SESSION['msg1']; 
													unset($_SESSION['msg1']);
												}
											?></h3>
											</div>
											<div class="col-sm-6">
												<button class="btn btn-info" id="PrintMode">Print Mode</button>
											</div>
											<div class="col-sm-6">
												<button class="btn btn-info" id="" onclick="javascript:location.reload()">Normal Mode</button>
											</div>
											 <div class="col-lg-6" style="display:none;">
												<div class="input-group">
												  <input type="text" class="form-control" id="userId" placeholder="Search User">
												  <span class="input-group-btn">
													<button class="btn btn-default" id="SearcUser" style="margin:0px;" type="button">Search</button>
												  </span>
												</div><!-- /input-group -->
											  </div><!-- /.col-lg-6 -->
											
											<script>
												
											</script>
											<div class="col-xs-12">
												<div class="table-responsive" id="searchResult">
													<table class="table table-bordered table-hover table-striped">
														<thead>
															<tr>
																
																<th>Sl. No.</th>
																<th>Date & Time</th>
																<th>Member ID</th>
																<th>Name</th>     
																<th>Net Payment(USD)</th>
																<th>Net Payment(Currency)</th>
																<th class="ShowPrint" style="display:none;">Net Payment(BDT)</th>
																
																<th>Account Informtion</th>
																<!--<th>Details</th>-->
																<th class="RemPrint">Action</th>
																<th class="RemPrint">Check</th>
																
															</tr> 
														</thead>
													<form method="POST" id="devel-generate-content-form" action="multipin_pay.php">
									
									<div class="modal fade" id="exampleMoghjgdal-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
				<input type="hidden" value="" name="Request" id="Request"/>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" id="fgjfgjfg">Pay All</button>
		  </div>
		</div>
	  </div>
	</div>
														<?php
																
															$images=array(
																"BTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1.png",
																"ETH"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1027.png",
																"LTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/2.png"
															);
															$q =$mysqli->query("SELECT * FROM trans_receive where user_receive='Office' and status='Pending' ");
															if(!$q) die( mysqli_error());
															$err =  mysqli_num_rows($q);
															$a=  mysqli_fetch_object($q);
															$total_items=  mysqli_num_rows($q);
															$limit = isset($_GET['limit']) ? $_GET['limit'] : 30;
															$type = isset($_GET['type']) ? $_GET['type'] : '';
															$page = isset($_GET['page']) ? $_GET['page'] : 1;
															if((!$limit)  || (is_numeric($limit) == false) || ($limit < 29) || ($limit > 30))
															{$limit = 30; }
															if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
															{$page = 1; }
																				
															$total_pages= ceil($total_items / $limit);
															$set_limit=$page * $limit - ($limit);					
															$n=1;
															$q2 =$mysqli->query("SELECT * FROM trans_receive where user_receive='Office' and status='Pending' ORDER BY `serialno` DESC LIMIT $set_limit, $limit");
															while($querygetexeres=  mysqli_fetch_object($q2)){
																
																$mmnn=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `specPin`,`log_user` FROM `member` WHERE `user`='".$querygetexeres->user_trans."'"));
																$mmnn22=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$querygetexeres->user_trans."' OR `user`='".$mmnn['log_user']."'"));
														?>
														<thead>
															<tr>
																
																<th><?php echo $n++;?></th>
																<th><?php 
																echo date("d-M-Y ", strtotime($querygetexeres->date));
																echo date("h:i:s A", strtotime($querygetexeres->time));
																?></th>
																<th><?php echo $querygetexeres->user_trans;?></th>
																<th><?php echo $mmnn22['name'];?></th>
																<th>$<?php echo $querygetexeres->ammount-$querygetexeres->tax;?> ($<?php echo $querygetexeres->ammount;?>)</th>
																<th>
																	<?php 
																		$CurImg=explode(":",$querygetexeres->method);
																	?>
																<img src="<?php echo $images[trim($CurImg[0])];?>" />
																<?php echo $querygetexeres->c_wallet;?></th>
																<th class="ShowPrint" style="display:none;"><?php echo (($querygetexeres->ammount-$querygetexeres->tax)*80);?></th>
																<th class="RemPrint"><?php echo $querygetexeres->method; ?></th>
																
																<td class="RemPrint">
																	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-vals="1" data-amn="<?php echo $querygetexeres->ammount-$querygetexeres->tax; ?>" data-serial="<?php echo $querygetexeres->serialno; ?>" data-cols="active" data-whatever="<?php echo $querygetexeres->user_trans; ?>">Pay Now</button>
																	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-vals="2" data-serial="<?php echo $querygetexeres->serialno; ?>" data-cols="active" data-whatever="<?php echo $querygetexeres->user_trans; ?>">Cancel</button>
																</td>
																<td class="RemPrint">
																	<input type="checkbox" class="ddgg" name="bbb<?php echo $querygetexeres->serialno; ?>" value="<?php echo $querygetexeres->serialno; ?>"  />
																	<button style="display:none;" id="kkj<?php echo $querygetexeres->serialno; ?>" type="button" class="btn btn-info btn-block hideall" data-toggle="modal" data-target="#exampleMoghjgdal" data-multi='1' data-whatever="Pay" data-sers="<?php echo $querygetexeres->serialno; ?>">Pay Now</button>
																	<button style="display:none;" id="kk2j<?php echo $querygetexeres->serialno; ?>" type="button" class="btn btn-danger btn-block hideall" data-toggle="modal" data-target="#exampleMoghjgdal" data-multi='1' data-whatever="Cancel" data-sers="<?php echo $querygetexeres->serialno; ?>">Cancel Now</button>
																</td>
																
															</tr>
														</thead>
														<?php } ?>
														</form>
													</table>
														<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
												<?php 
												$cat = isset($cat) ? $cat : ''; 
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
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading" style="text-align: center;font-weight: bold;font-size: 16px;">
								Member Paid List
								<div class="pull-right"> </div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th>Sl. No.</th>
														<th>Date & Time</th>
														<th>Member ID</th>
														<th>Name</th>
														<th>Account Informtion</th>
														<th>Net Payment(USD)</th>
														
														<th>Status</th>
													</tr>
												</thead>

												<?php
													$t =   $mysqli->query("SELECT * FROM trans_receive where user_receive='Office' and status='Paid'");
													if(!$t) die( mysqli_error());

													$a=  mysqli_fetch_object($t);
													$total_items=  mysqli_num_rows($t);
													$limit = isset($_GET['limit1']) ? $_GET['limit1'] : 15;
													$type = isset($_GET['type1']) ? $_GET['type1'] : '';
													$page = isset($_GET['page1']) ? $_GET['page1'] : 1;
													if((!$limit)  || (is_numeric($limit) == false) || ($limit < 14) || ($limit > 16))
													{$limit = 15; }
													if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
													{$page = 1; }

													$total_pages= ceil($total_items / $limit);
													$set_limit=$page * $limit - ($limit);					

													$q =   $mysqli->query("SELECT * FROM trans_receive where user_receive='Office' and (status='Paid' || status='Cancel') ORDER BY `serialno` DESC LIMIT $set_limit, $limit");
													if(!$q) die( mysqli_error());
													$err =  mysqli_num_rows($q);
													$n=1;													
													while($querygetexeres=  mysqli_fetch_object($q)){
														$mmnn=mysqli_fetch_assoc($mysqli->query("SELECT `user`, `log_user` FROM `member` WHERE `user`='".$querygetexeres->user_trans."'"));
														$mmnn22=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mmnn['log_user']."' OR `user`='".$querygetexeres->user_trans."' "));
												?>
												<thead>
													<tr>
														<th><?php echo $n++;?></th>
														<th><?php echo date("d-M-Y h:i:s A", strtotime($querygetexeres->time));?></th>
														<th><?php echo $querygetexeres->user_trans;?></th>
														<th><?php echo $mmnn22['name'];?></th>
														<th><?php echo $querygetexeres->method;; ?></th>
														<th>$<?php echo $querygetexeres->ammount-$querygetexeres->tax;?> ($<?php echo $querygetexeres->ammount;?>)</th>
														
														<th><?php echo $querygetexeres->status;?></th>
													</tr>
												</thead>

												<?php } ?>

											</table>

											<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
												<?php 
												$cat = urlencode($cat); 
												$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href=?limit1=$limit&amp;page1=$prev_page><b>Prev</b></a>");}
												$a = $page ;if($a <= $total_pages){ echo("|<a href=?limit1=$limit&amp;page1=$a><b>$a</b></a>|");}			
												$b = $page + 1;if($b <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$b><b>$b</b></a>|");}			
												$c = $page + 2;if($c <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$c><b>$c</b></a>|");}	
												$d = $page + 3;if($d <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$d><b>$d</b></a>|");}
												$d = $page + 4;if($d <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$d><b>$d</b></a>|");}
												$e = $page + 5;if($e <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$e><b>$e</b></a>|");}			
												$f = $page + 6;if($f <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$f><b>$f</b></a>|");}			
												$g = $page + 7;if($g <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$g><b>$g</b></a>|");}
												$h = $page + 8;if($h <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$h><b>$h</b></a>|");}			
												$i = $page + 9;if($i <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$i><b>$i</b></a>|");}			
												$j = $page + 10;if($j <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$j><b>$j</b></a>|");}
												$next_page = $page + 1;if($next_page <= $total_pages){ echo("<a href=?limit1=$limit&amp;page1=$next_page><b>Next</b></a> &gt;&gt;");}
												?>	
												<form method="get" action="" style="text-align: center;">
													<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;">Total Pages </span>

													<b style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:blue;font-size:13px;">
													<?php echo $total_pages;?></b>

													<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> Show 
														<input type="text"  name="page1" value="<?php echo $page;?>" size="4" />
														<input type="hidden" name="limit1" value="<?php echo $limit;?>" />
														<input type="hidden" id="kkll" value="<?php echo $row['tr_password'];?>" />
													</span>
													<input type="submit"  value="Submit" /> 
												</form>     
											</p> 
										</div>
										<!-- /.table-responsive -->
									</div>
									<!-- /.col-xs-12 (nested) -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.panel-body -->
						</div>
						<!-- /.panel -->
					</div>
					<!--.col-lg-3 --> 
				</div>
				<!--.row-->                        
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
            <script >
			$(document).ready(function(){
				$("#SearcUser").on("click", function(e){
					e.preventDefault();
					e.stopPropagation();
					var vacd=$("#userId").val();
					console.log("HEllo");
					if(vacd!=''){
						var ssdd=$.ajax({
							method:"GET",
							url:"withdraw_search.php",
							data:{ussd:vacd}
						});
						ssdd.done(function(ress){
							//console.log(ress);
							$("#searchResult").html(ress);
						});
					}
				});
				
				$("#CheckCode").on("click", function(){
					let sodf=$("#verCode").val();
					if(sodf!=''){
						const codes=$.ajax({
							method:"GET",
							url:'',
							data:{codesf:sodf}
						});
						codes.done((resd)=>{
							let dfgdf=JSON.parse(resd);
							if(dfgdf[0]==1){
								$(".ffdd").text(dfgdf[1]);
								$("#SubFinal").trigger("click");
							}else{
								$(".ffdd").text(dfgdf[1]);
								$(".ffdd").css("color","red");
							}
						});
					}else{
						$(".ffdd").text("Submit Code");
						$(".ffdd").css("color","red");
					}
				})
				$("#SubCheck").on("click", function(){
					$btn = $(this).button('loading');
					let  payOPtion=Number($("input[name='payFrom']:checked").val());
					let amn=$("#amn").val();
					let user=$("#recipient-name").val();
					let pin=$("#pin").val();
					if(payOPtion==1){
						$("#SubFinal").trigger("click");
					}else if(payOPtion==2){
						const redfg=$.ajax({
							method:"GET",
							url:'',
							data:{amount:amn,user:user,pin:pin,chhK:"Amount"}
						});
						redfg.done((ress)=>{
							console.log(ress);
							let ssdf=JSON.parse(ress);
							$(".ffdd").text(ssdf[1]);
							if(ssdf[0]==1){
								//$("#SubFinal").trigger("click");
								$("#step2").show();
								$("#step1").hide();
								$("#SubCheck").hide();
								$(".ffdd").css("color","green");
							}else{
								$(".ffdd").css("color","red");
							}
							
							$btn.button('reset');
						});
					}
					console.log(payOPtion);
					console.log(amn);
				});
				
				$("#PrintMode").on("click", function(){
					$(".RemPrint").remove();
					$(".ShowPrint").show();
				});
				$(".ddgg").on("click", function(){
					var $checkboxes = $(' input[type="checkbox"]');
					var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
					//console.log(countCheckedCheckboxes);
					$('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
					var ttt=$(this).val();
					$(".hideall").hide();
					$("#kkj"+ttt).show();
					$("#kk2j"+ttt).show();
				});
				
				$('#exampleModal').on('show.bs.modal', function (event) {
					var button = $(event.relatedTarget) // Button that triggered the modal
					var recipient = button.data('whatever') 
					var vals = button.data('vals') 
					var cols = button.data('cols') 
					var serial = button.data('serial')
					var amn = button.data('amn')
					var modal = $(this)
					modal.find('.modal-title').text('Cancel ' + recipient + '`s Request ')
					modal.find('.modal-body #recipient-name').val(recipient)
					modal.find('.modal-body #vals').val(vals)
					modal.find('.modal-body #cols').val(cols)
					modal.find('.modal-body #serial').val(serial)
					modal.find('.modal-body #amn').val(amn)
				});
				
				$('#exampleMoghjgdal').on('show.bs.modal', function (event) {
					var button = $(event.relatedTarget) // Button that triggered the modal
					var recipient = button.data('whatever') 
					var vals = button.data('vals') 
					var cols = button.data('cols') 
					var serial = button.data('serial')
					var modal = $(this)
					modal.find('.modal-title').text(  recipient + ' Withdraw  Request ')
					//modal.find('.modal-body #recipient-name').val(recipient)
					//modal.find('.modal-body #vals').val(vals)
					//modal.find('.modal-body #cols').val(cols)
					//modal.find('.modal-body #serial').val(serial)
					modal.find('#fgjfgjfg').text(recipient +" All")
					modal.find('#Request').val(recipient)
				});
				
			

				$(".upgg").on("click", function(e){
					//e.preventDefault();
					//e.stopPropagation();
					$btn = $(this).button('loading');
					var pin=$("#pin").val();
					var pin2=$("#kkll").val();
					let  payOPtion=Number($("input[name='payFrom']:checked").val());
					var rr=true;
					
					if((pin=='')||(pin!==pin2)){
						rr=false;
					}
					var vals=$("#vals").val();
					var srl=$("#serial").val();
					var cols=$("#cols").val();
					var amn=$("#amn").val();
					var uu=$("#recipient-name").val();

					if((vals!='')&&(rr)){
						var reqq=$.ajax({
							method:"GET",
							url: "payment_action.php",
							data:{vas: vals,ussd:uu, sers: srl,khh:pin, coll:cols, tbs:"trans_receive",agg:amn,payOPtion:payOPtion}
						});
						reqq.done(function(msg){
							console.log(msg);
							var ggf=JSON.parse(msg);
							if(ggf[0]==1){
								$(".ccdd").trigger("click");
								location.reload();
							}else{
								$(".ffdd").text(ggf[1]);
								$btn.button('reset');
							}
							
						});
					}else{
						$(".ffdd").text("Enter Correct PIN Number");
						$btn.button('reset');
					}
				});

			});

		</script>
            <script type="text/javascript" src="lib/js/Chart.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap-switch.min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.matchHeight-min.js"></script>
            <script type="text/javascript" src="lib/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="lib/js/dataTables.bootstrap.min.js"></script>
            <!--<script type="text/javascript" src="lib/js/select2.full.min.js"></script>-->
            <script type="text/javascript" src="lib/js/ace/ace.js"></script>
            <script type="text/javascript" src="lib/js/ace/mode-html.js"></script>
            <script type="text/javascript" src="lib/js/ace/theme-github.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="js/app.js"></script>
            <script type="text/javascript" src="js/index.js"></script>
</body>

</html>
