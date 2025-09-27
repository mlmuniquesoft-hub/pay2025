<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345fh';	
	require 'db.php';
?>


<?php  
function user_update($U_ID){
	global $mysqli;
	$memberid = $U_ID;
	$date=date("Y-m-d"); 
	$lastday=date('Y-m-d', strtotime($date .' -1 day')); 	
	
	
	
	$_SESSION['amount']=0;
	/*Invest amount user total*/	
	$queryget="SELECT SUM(amount) AS `amount` FROM `bcpp` where `user`='".$memberid."'";
	$querygetexe=$mysqli->query($queryget);
	while($querygetexeres=mysqli_fetch_array($querygetexe))
	{
	$_SESSION['amount']=$querygetexeres['amount']*1;	
	}

	
	
	if($_SESSION['amount']>40)
	{
	$mysqli->query("UPDATE `member` SET `total_invest`='".$_SESSION['amount']."'	WHERE `user`='".$memberid."'");
	}

	
	
	
		return 1;
	} /// end of user_update function
?>
<?php
	//// Max serial Number of member table

        $totalCount=0;
        $query_1="select max(serial) as last_serial from member";
        $result_1=$mysqli->query( $query_1);
        $row_1 = mysqli_fetch_array($result_1);
        $last_serial = $row_1[0];
		$query_10="select user,serial from member where chk3='0' order by serial asc";
		$result_10=$mysqli->query( $query_10);		
		while($row_10=mysqli_fetch_array($result_10)){
			$u_id_tmp = $row_10['user'];
			$current_serial = $row_10['serial'];
			$check=0;
			$check=user_update($u_id_tmp);
			usleep(50);
			if($check==1){ /// 1 means this user all data have updated now...			
				$sql="UPDATE member SET chk3='1' WHERE user='".$u_id_tmp."'";
				$mysqli->query( $sql);
				$totalCount++;
			}
			if($current_serial==$last_serial){ /// all member data updated completed... 				
					$sql="UPDATE member SET chk3='0' where chk1='1'";
					$mysqli->query( $sql);
				}
		}
		
?>