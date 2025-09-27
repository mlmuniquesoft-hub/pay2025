<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
		header("Location:logout.php");
		exit();
	}else{
		require '../db/db.php';
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
											<form class="form-horizontal" id="formElem" name="formElem" action="create_match_action.php" method="post">
												
												<div class="form-group">
													<h3 style="color:red;text-align:center;"><?php echo $_SESSION['msg']; ?></h3>
													<h3 style="color:green;text-align:center;"><?php echo $_SESSION['msg1']; ?></h3>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 control-label">Game Title</label>
													<div class="col-sm-8">	
														<input type="text" name="game_title" class="form-control" placeholder="Game Title"  >
														<input type="hidden" name="location" value="<?php echo $_SERVER['PHP_SELF']; ?>"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">Game Name</label>
													<div class="col-sm-8">	
														<select class="form-control" name="gameName">
															<option value="">Select Name</option>
															<?php 
																$fghgf=$mysqli->query("SELECT * FROM `game_name`");
																while($hdfgss=mysqli_fetch_assoc($fghgf)){
															?>
															<option value="<?php echo $hdfgss['serial']; ?>"><?php echo $hdfgss['name_game']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 control-label">Game Description</label>
													<div class="col-sm-8">
														<textarea name="game_details" class="form-control" placeholder="Game Description"></textarea>
														
													</div>
												</div>	
												
												
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
															<th scope="col">Game Title</th>
															<th scope="col">Game Description</th>
															<th scope="col">Status</th>
														</tr>
													</thead>
				<?php
					$t = $mysqli->query("SELECT * FROM `game_details` WHERE `active`='1' ");
					$total_items= mysqli_num_rows($t);
					$limit=$_GET['limit'];
					$type=$_GET['type'];
					$page=$_GET['page'];
					if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51)){$limit = 50; }
					if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))	{$page = 1; }								
					$total_pages= ceil($total_items / $limit);
					$set_limit=$page * $limit - ($limit);			
					$q = $mysqli->query("SELECT * FROM `game_details` WHERE `active`='1' ORDER BY serial DESC LIMIT $set_limit, $limit");

					$n=1;
					while($querygetexeres= mysqli_fetch_object($q))
					{
						
					
						
				?>
													<tbody class="del<?php echo $querygetexeres->serial; ?>">
														<tr>
															<td><?php echo $querygetexeres->serial; ?></td>										
															<td><?php echo $querygetexeres->game_title; ?></td>																
															<td><textarea class="form-control uopp" cols="68" rows="4" data-serial="<?php echo $querygetexeres->serial; ?>" data-cols="game_details" ><?php echo $querygetexeres->game_details; ?></textarea></td>
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
									data:{vas: vals, sers: srl, coll:cols, tbs:"game_details", retur:vals2}
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
									data:{vas: vals, sers: srl, coll:cols, tbs:"game_details"}
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
