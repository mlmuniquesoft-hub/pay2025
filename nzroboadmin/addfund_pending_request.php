<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_agent.php';
		require_once '../db/template.php';
	}
?>
	<!DOCTYPE html>
<html>

<head>
    <title> <?php echo $Adminnb; ?></title>
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
<?php
    $memberid = $_SESSION["Admin"];
    $query = "select * from admin where user_id='".$memberid."' ";
    $result=  $mysqli->query($query);
    $row =  mysqli_fetch_array($result);
?>

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
			<div class="form-group ffdd" style="display:none;">
           <h3>Enter Correct Pin Number</h3>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">transaction Pin:</label>
           <input type="password" class="form-control" id="pin">
          </div>
        </form>
		<input type="hidden" class="form-control" id="vals">
		<input type="hidden" class="form-control" id="cols">
		<input type="hidden" class="form-control" id="serial">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default ccdd" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary upgg">Send message</button>
      </div>
    </div>
  </div>
</div>













    <div class="app-container">
        <div class="row content-container">
		<?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php //require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">
                        <div class="row">
							<div class="col-xs-12">								
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> Pending Request List
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>SL.NO</th>
											<th>Date</th>
											<th>Requested By</th>
											<th>Requested Amount</th>
											<th>Sender Number</th>
											<th>Transaction Number</th>
											<th>Note</th>
											<th>Action</th>
										</tr>
									</thead>
									<?php
										$limit=$mysqli->real_escape_string($_GET['limit']);
										$type=$mysqli->real_escape_string($_GET['type']);
										$page=$mysqli->real_escape_string($_GET['page']);
										$t = $mysqli->query("SELECT * FROM `req_fund` where `user`='".$memberid."' AND `active`='0'");
										$total_items= mysqli_num_rows($t);
										if((!$limit)  || (is_numeric($limit) == false) || ($limit < 49) || ($limit > 51)){$limit = 50; }
										if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))	{$page = 1; }
															
										$total_pages= ceil($total_items / $limit);
										$set_limit=$page * $limit - ($limit);			
										$n=1;
										$q = $mysqli->query("SELECT * FROM `req_fund` where `user`='".$memberid."' AND `active`='0' ORDER BY DATE(date) DESC LIMIT $set_limit, $limit");

										while($reqw=mysqli_fetch_assoc($q)){
									?>
									<tbody class="del<?php echo $reqw['serial']; ?>">
										<tr>
											<td><?php echo $n++; ?></td>
											<td><?php echo $reqw['date']; ?></td>
											<td><?php echo $reqw['receiver']; ?></td>
											<td><?php echo $reqw['amount']; ?></td>
											<td><?php echo $reqw['sender_number']; ?></td>
											<td><?php echo $reqw['uniq_number']; ?></td>
											<td><?php echo $reqw['remark']; ?></td>
											<td>
												<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-vals="1" data-serial="<?php echo $reqw['serial']; ?>" data-cols="active" data-whatever="<?php echo $reqw['receiver']; ?>">Accept</button>
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-vals="2" data-serial="<?php echo $reqw['serial']; ?>" data-cols="active" data-whatever="<?php echo $reqw['receiver']; ?>">Cancel</button>
												
											</td>
										</tr>  
									</tbody>
									<?php } ?>

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
            </div>
        </div>
			<?php require_once'footer.php'?>
	</div>
<?php unset($_SESSION['msg']);?>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
			
            <script >
				$(document).ready(function(){
					$('#exampleModal').on('show.bs.modal', function (event) {
					  var button = $(event.relatedTarget) // Button that triggered the modal
					  var recipient = button.data('whatever') 
					  var vals = button.data('vals') 
					  var cols = button.data('cols') 
					  var serial = button.data('serial') 
					  var modal = $(this)
					  modal.find('.modal-title').text('Cancel ' + recipient + '`s Request ')
					  modal.find('.modal-body #recipient-name').val(recipient)
					  modal.find('.modal-body #vals').val(vals)
					  modal.find('.modal-body #cols').val(cols)
					  modal.find('.modal-body #serial').val(serial)
					});
					
					$(".upgg").on("click", function(e){
						//e.preventDefault();
						//e.stopPropagation();
						$btn = $(this).button('loading');
						var pin=$("#pin").val();
						var pin2=$("#kkll").val();
						var rr=true;
						if((pin=='')||(pin!==pin2)){
							rr=false;
						}
						var vals=$("#vals").val();
						var srl=$("#serial").val();
						var cols=$("#cols").val();
						if(vals=="Delete"){
							$(".del"+srl).hide();
						}
						if((vals!='')&&(rr)){
							var reqq=$.ajax({
								method:"GET",
								url: "info_update_action.php",
								data:{vas: vals, sers: srl, coll:cols, tbs:"req_fund"}
							});
							reqq.done(function(){
								$(".ccdd").trigger("click");
								$(".del"+srl).hide();
							});
						}else{
							$(".ffdd").show();
							 $btn.button('reset')
						}
					});
					
					$(".oopp").on("click", function(){
						var yy=$(this).val();
						$("."+yy).show();
					});
					$(".ffrr").on("click", function(){
						$(".hiidd").hide();
						var yy=$(this).val();
						$("."+yy).show();
					});
					$(".ggff").on("click", function(){
						$(".ddffdd").hide();
						var yy=$(this).val();
						$("."+yy).show();
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
