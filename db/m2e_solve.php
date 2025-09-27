<?php
	session_start();
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
	require 'functions.php';
	
	function solve_update($memberid,&$ertre){
		global $mysqli;
		$msadf=mysqli_num_rows($mysqli->query("SELECT * FROM `upgrade` "));
		if($msadf>0){
			$msadf22=mysqli_fetch_assoc($mysqli->query("SELECT SUM(ammount) as qwe FROM `trans_receive` WHERE `user_trans`='".$memberid."' AND `user_receive`='make2earn' AND DATE(`time`)<='2018-08-12'"));
			$mysqli->query("UPDATE `trans_receive` SET `status`='Paid' WHERE `user_trans`='".$memberid."' AND `type`='Withdraw' AND `user_receive`='make2earn' AND DATE(`time`)<='2018-08-12'");
			$mysqli->query("UPDATE `trans_receive` SET `status`='Cancel' WHERE `user_trans`='".$memberid."' AND `type`='Withdraw' AND `user_receive`='make2earn' AND DATE(`time`)>'2018-08-12'");
			echo $memberid ." >> ".$msadf22['qwe'] ."\n";
		}
		
	}
	
	
	$query_10="SELECT DISTINCT `user` FROM `upgrade`  ORDER BY `serial` ASC ";//AND `level`=''
	$result_10=$mysqli->query($query_10);
	$i=1;
	$werew=array();
	while($row_10=mysqli_fetch_array($result_10)){
		$u_id_tmp = $row_10['user'];
		//$check=solve_update($u_id_tmp,$werew);
		echo $u_id_tmp ."<br/>";
		$jkdgfd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$u_id_tmp."'"));
		$mysqli->query("UPDATE `upgrade` SET `upline`='".$jkdgfd['upline']."' WHERE `user`='".$u_id_tmp."'");
		usleep(50);
	}
	//var_dump(array_sum($werew));
?>