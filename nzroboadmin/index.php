<?php
	session_start();
	function generatePassword($length=4, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))].rand(1,100);
			$alt = 0;
			} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
			}
		}
		return $password;
	}
	$_SESSION['token']=generatePassword();

	$name ='sign@@up';
	$_SESSION['join'] = $name;


	require_once '../db/template.php';
	
?>
<!DOCTYPE html>

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
<body style="background-color: #353d47;">
	<div class="container">
		<div class="row">
			<div class="col-sm-12" style="height:100px;"></div>			
		</div>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6" style="background-color: rgba(220, 233, 245, 0.81); padding: 20px; border: 1px solid rgb(204, 204, 204); border-radius: 10px;">
				<form class="form-horizontal" action="login_action.php" method="post">
					<div class="form-group">
						<div class="col-sm-12">
							<h3 align="center">Admin Panel Login & Control</h3>
							<h3 style="font-family:arial; color: red;margin-top:50px; font-size:22px;">
								<center><?php echo $_GET['ErrorMessage']; ?>
							</h3>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						  <input type="text" name="userid" class="form-control" placeholder="Admin ID" >
						</div>
					</div>
					 <div class="form-group">
						<div class="col-sm-12">
						  <input type="password" name="userPassOne" class="form-control" id="one" placeholder="Password"  >
						</div>
					 </div>
					 <div class="form-group">
						<div class="col-sm-5">
						  <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>					
						</div>
						<div class="col-sm-5">
						  <button type="reset" class="btn btn-danger btn-lg btn-block">Refresh</button>
						</div>
					 </div>
				</form>
			</div>			
		</div>
	</div>
</body>
</html>