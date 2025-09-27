<?php
	session_start();
	if(!isset($_SESSION['roboMember'])){
		header("Location: logout.php");
		exit();
	}else{
		require_once("../db/db.php");
		require_once("../db/functions.php");
	$member=$_SESSION['roboMember'];
	$result3=$mysqli->query("select * from member where user='".$_SESSION['roboMember']."' ");
	$memberInfo = mysqli_fetch_array($result3); 
	
	// PHP 8.2 compatibility: Check if memberInfo is valid
	if(!$memberInfo) {
		$memberInfo = array('log_user' => '', 'user' => '', 'pack' => 0, 'paid' => 0);
	}
	
	$result1=$mysqli->query("select * from profile where `user`='".$memberInfo['log_user']."' OR `user`='".$memberInfo['user']."' ");
	$ProfileInfo = mysqli_fetch_array($result1); 
	
	// PHP 8.2 compatibility: Check if ProfileInfo is valid  
	if(!$ProfileInfo) {
		$ProfileInfo = array('photo' => 'default.jpg');
	}
	
	$jkfghkd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$memberInfo['pack']."'"));
	// Handle null package data with default values
	if($jkfghkd === null) {
		$jkfghkd = array(
			'pack_amn' => 0,
			'pack' => 'Default Package'
		);
	}
		$Tiell = isset($_GET['title']) ? $_GET['title'] : '';
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
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	
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
	
    <!-- Add Slick Carousel CSS for styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
	
    <script src="/assets/js/jquery-1.11.2.min.js"></script>
  
</head>