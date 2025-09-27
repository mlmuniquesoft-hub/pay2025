<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';

	
	$query_10="select * from member where `pack`>'0' order by serial asc";
	$result_10=$mysqli->query( $query_10);		
	while($row_10=mysqli_fetch_array($result_10)){
		$mysqli->query("UPDATE `member` SET `direct`='0.50', `point`='10' WHERE `user`='".$row_10['user']."'");
		
		//$check=rank_update($u_id_tmp);
		usleep(50);		
	}
		
?>