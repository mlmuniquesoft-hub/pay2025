<?php
	session_start();
	if(!isset($_SESSION['roboMember'])){
		header("Location: logout.php");
		exit();
	}else{
		require_once("../../db/db.php");
		require_once("../../db/functions.php");
		$member=$_SESSION['roboMember'];
		$result3=$mysqli->query("select * from member where user='".$_SESSION['roboMember']."' ");
		$memberInfo = mysqli_fetch_array($result3); 
	
		$result1=$mysqli->query("select * from profile where `user`='".$memberInfo['log_user']."' OR `user`='".$memberInfo['user']."' ");
		$ProfileInfo = mysqli_fetch_array($result1); 
		
		$jkfghkd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$memberInfo['pack']."'"));
	// Handle null package data with default values
	if($jkfghkd === null) {
		$jkfghkd = array(
			'pack_amn' => 0,
			'pack' => 'Default Package'
		);
	}
		$Tiell=$_GET['title'];
		if($Tiell==''){
			$Tiell=" Capitol Money Pay";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $Tiell; ?></title>
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon" />
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="/assets/images/apple-touch-icon-57-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/images/apple-touch-icon-72-precomposed.png">
    <!-- For iPad Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/images/apple-touch-icon-144-precomposed.png">

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/assets/fonts/webfont/cryptocoins.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <link href="/assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/morris-chart/css/morris.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/calendar/fullcalendar.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/assets/plugins/icheck/skins/minimal/minimal.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/assets/plugins/swiper/swiper.css" rel="stylesheet" type="text/css">

    <link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->
	
    <script src="/assets/js/jquery-1.11.2.min.js"></script>
  
</head>