<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','512M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
?>


<?php  
function user_update($U_ID){
		global $mysqli;
		$memberid = $U_ID;
		$date=date("Y-m-d"); 
		$serial=$_SESSION['serial'];
		
		
		$row31=mysqli_fetch_object($mysqli->query("SELECT * FROM `games` WHERE `serial`='".$serial."'"));
		$gameid=$row31->serial;		
		$result=$row31->result;
		
		$row32=mysqli_fetch_object($mysqli->query("SELECT * FROM `play` WHERE `user`='".$memberid."' and `gameid`='".$serial."'"));
		$result1=$row32->draw;
		

		
?>
<?php		
		
		
		
	if($result==$result1)
	{
	$mysqli->query("UPDATE `play` SET `active`='1' WHERE `gameid`='".$serial."' and `user`='".$memberid."'");
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
		$query_10="select user,serial from member where chk='0' order by serial asc";
		$result_10=$mysqli->query( $query_10);		
		while($row_10=mysqli_fetch_array($result_10)){
			$u_id_tmp = $row_10['user'];
			$current_serial = $row_10['serial'];
			$check=0;
			$check=user_update($u_id_tmp);
			usleep(50);
			if($check==1){ /// 1 means this user all data have updated now...			
				$sql="UPDATE member SET chk='1' WHERE user='".$u_id_tmp."'";
				$mysqli->query( $sql);
				$totalCount++;
			}
			if($current_serial==$last_serial){ /// all member data updated completed... 				
					$sql="UPDATE member SET chk='0' where chk='1'";
					$mysqli->query( $sql);
				}
		}
		
?>