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
        <div class="row content-container">
		<?php require_once'menu.php'?>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
					<?php require_once'topshow.php'?>
                    <div class="row  no-margin-bottom">

					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-default">
									<div class="panel-heading">
										<i class="fa fa-bar-chart-o fa-fw"></i> update Member
										<div class="pull-right"> </div>
									</div>
									<!-- /.panel-heading -->
								<div class="panel-body">
									<div class="row">
								
<?php
	$member_id=$_GET['member'];
	$query = "select * from member where user='".$member_id."' ";
	$result= $mysqli->query($query);
	$row = mysqli_fetch_array($result);	
	$query1 = "select * from profile where user='".$member_id."' ";
	$result1= $mysqli->query($query1);
	$row1 = mysqli_fetch_array($result1);
	$query2 = "select * from balance where user='".$member_id."' ";
	$result2= $mysqli->query($query2);
	$row2 = mysqli_fetch_array($result2);	
	if($member_id!=''){
?> 	  	
<form class="form-horizontal" action="profile_action.php" method="post">
<div class="form-group">
	<label class="col-sm-4 control-label">User Id :</label>
	<div class="col-sm-8">
	<input type="text" name="user_id" class="form-control" value="<?php echo $row["user"];?>" placeholder="User Id" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Name :</label>
	<div class="col-sm-8">
	<input type="text" name="user_name" class="form-control" value="<?php echo $row1["name"];?>" placeholder="Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">E-Mail :</label>
	<div class="col-sm-8">
	<input type="text" name="email" class="form-control" value="<?php echo $row1["email"];?>" placeholder="E-Mail" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Contact Number :</label>
	<div class="col-sm-8">
	<input type="text" name="contact" class="form-control" value="<?php echo $row1["mobile"];?>" placeholder="number" />
	</div>
</div>
<!--<div class="form-group">
	<label class="col-sm-4 control-label">National ID :</label>
	<div class="col-sm-8">
	<input type="text" name="nation_id" class="form-control" value="<?php echo $row1["votar_id"];?>" placeholder="National ID" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Paypal ID :</label>
	<div class="col-sm-8">
	<input type="text" name="paypal_id" class="form-control" value="<?php echo $row1["paypal_id"];?>" readonly placeholder="Paypal ID" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Payza ID :</label>
	<div class="col-sm-8">
	<input type="text" name="payza_id" class="form-control" value="<?php echo $row1["payza_id"];?>" readonly placeholder="Payza ID" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Reference ID :</label>
	<div class="col-sm-8">
	<input type="text" name="reference" class="form-control" value="<?php echo $row["reffereduser"];?>" readonly placeholder="Reference ID" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Joining Date :</label>
	<div class="col-sm-8">
	<input type="text" name="join_date" class="form-control" value="<?php echo $row["join_date"];?>" readonly placeholder="Joining Date" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Date of Birth :</label>
	<div class="col-sm-8">
	<input type="text" name="birth_date" class="form-control" value="<?php echo $row1["birth_date"];?>" readonly placeholder="Date of Birth" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Father Name :</label>
	<div class="col-sm-8">
	<input type="text" name="father_name" class="form-control" value="<?php echo $row1["father_name"];?>" readonly placeholder="Father Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Mother Name :</label>
	<div class="col-sm-8">
	<input type="text" name="mother_name" class="form-control" value="<?php echo $row1["mother_name"];?>" readonly placeholder="Mother Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Nominee Name :</label>
	<div class="col-sm-8">
	<input type="text" name="nomi_name" class="form-control" value="<?php echo $row1["nomini_name"];?>" placeholder="Nominee Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Nominee Father :</label>
	<div class="col-sm-8">
	<input type="text" name="nomi_father" class="form-control" value="<?php echo $row1["nomini_father"];?>" placeholder="Nominee Father" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Nominee mother :</label>
	<div class="col-sm-8">
	<input type="text" name="nomi_mother" class="form-control" value="<?php echo $row1["nomini_mother"];?>" placeholder="Nominee mother" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Nominee Relation :</label>
	<div class="col-sm-8">
	<input type="text" name="nomi_relation" class="form-control" value="<?php echo $row1["nomini_relation"];?>" placeholder="Nominee Relation" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Nominee Age :</label>
	<div class="col-sm-8">
	<input type="text" name="nomi_age" class="form-control" value="<?php echo $row1["nomini_age"];?>" placeholder="Nominee Age" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Address :</label>
	<div class="col-sm-8">
	<input type="text" name="address" class="form-control" value="<?php echo $row1["address"];?>" placeholder="Address" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">City :</label>
	<div class="col-sm-8">
	<input type="text" name="city" class="form-control" value="<?php echo $row1['district'];?>"readonly placeholder="city" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">State :</label>
	<div class="col-sm-8">
	<input type="text" name="state" class="form-control" value="<?php echo $row1['state'];?>" placeholder="State" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Post Code :</label>
	<div class="col-sm-8">
	<input type="text" name="post_code" class="form-control" value="<?php echo $row1['post_code'];?>" placeholder="Post Code" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Country :</label>
	<div class="col-sm-8">
	<input type="text" name="country" class="form-control" value="<?php echo $row1['country'];?>" placeholder="Country" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Bank Name :</label>
	<div class="col-sm-8">
	<input type="text" name="bank_name" class="form-control" value="<?php echo $row1['bank_name'];?>" placeholder="Bank Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Bank Account Name :</label>
	<div class="col-sm-8">
	<input type="text" name="bank_acc_name" class="form-control" value="<?php echo $row1['account_holder_name'];?>" placeholder="Bank Account Name" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Bank Account NO :</label>
	<div class="col-sm-8">
	<input type="text" name="bank_acc_no" class="form-control" value="<?php echo $row1['bank_account_no'];?>" placeholder="Bank Account NO" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Branch :</label>
	<div class="col-sm-8">
	<input type="text" name="bank_code" class="form-control" value="<?php echo $row1['brank_branch'];?>" placeholder="Branch" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-4 control-label">Country Agent :</label>
	<div class="col-sm-8">
	<input type="text" name="agent" class="form-control" value="<?php echo $row1['agency_name'];?>" placeholder="Country Coordinator" />
	</div>
</div>-->
<div class="form-group">
	<div class="col-sm-6">
	</div>
	<div class="col-sm-4">
	<input class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="Submit">
	</div>
</div>
</form>
	<?php } ?>
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
			<?php require_once'footer.php'?>
		</div>
<?php unset($_SESSION['msg']);?>
            <!-- Javascript Libs -->
            <script type="text/javascript" src="lib/js/jquery.min.js"></script>
            <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
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