<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	function Usedfg($user){
		global $mysqli;
		$RequestTO=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `invoice_req` where `user`='".$user."' AND `active`='1'"));
		$RequestTOwq=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `agent` where `user_id`='".$RequestTO['create_by']."'"));
		echo $RequestTO['create_by'] ."<br/>\n";
	}
	
	$query_10="SELECT * FROM `member` WHERE `specPin`='1' ORDER BY `serial` ASC ";
	$result_10=$mysqli->query($query_10);
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		echo $u_id_tmp ."<br/>";
		$check=Usedfg($u_id_tmp);
		usleep(50);
	}
?>