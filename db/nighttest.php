<?php
	$timing_start = explode(' ', microtime());
	error_reporting(-1);
	set_time_limit(0);
	ini_set('memory_limit','4096M');
	$_SESSION['token']='12345gh';	
	require 'db.php';
?>

<?php

		function count_left($left_id)
		{
		global $mysqli;
		global $lastday;
		$exe2 = $mysqli->query("SELECT user,upline,invest,point,date,paid FROM member WHERE upline='".$left_id."'");
		while($result2=mysqli_fetch_array($exe2))
		{
			$_SESSION['left_s']=$_SESSION['left_s']+$result2['point']+$result2['invest'];			
			$_SESSION['left']=$_SESSION['left']+1;
			if($result2['paid']==1)
			{
			$_SESSION['left_a']=$_SESSION['left_a']+1;
			}	
			if($result2['date']==$lastday)
			{
			$_SESSION['left1']=$_SESSION['left1']+1;
			$_SESSION['left_i']=$_SESSION['left_i']+$result2['invest']; 		
			$_SESSION['left_p']=$_SESSION['left_p']+$result2['point']; 		
			}			

		$res3=mysqli_fetch_array($mysqli->query("SELECT user,upline,point,invest,date,paid FROM member WHERE user='".$result2['user']."'"));
		count_left($res3['user']);
		}
		}	
		

	
?>


<?php  
function user_update($U_ID){
		global $mysqli;
		global $lastday;
		
		$memberid = $U_ID;
		$datee =date('Y-m-d');
		$lastday=date('Y-m-d', strtotime($datee .' -1 day')); 
		
		/*Run query from Database*/         
		$result=$mysqli->query("select user,point,pack from member where user='".$memberid."' ");
		$row = mysqli_fetch_array($result);
		$point=$row['point'];
	    $pack=$row['pack'];

	?>

	<?php	
		/*Matching BV Based on Package Left Node Start*/
		$_SESSION['left']=0;
		$_SESSION['left1']=0;
		$_SESSION['left_p']=0;
		$_SESSION['left_i']=0;			
		$_SESSION['left_a']=0;
		$_SESSION['left_s']=0;
		$result1=mysqli_fetch_array($mysqli->query("SELECT user,position,upline,point,invest,date,paid FROM member WHERE upline='".$memberid."' AND position='Left' "));
		$left_id=$result1['user'];
		if($result1['user'])
		{
			$_SESSION['left_s']=$result1['point']+$result1['invest'];
			$_SESSION['left']=1;
			if($result1['paid']==1)
			{
			$_SESSION['left_a']=1;
			}
			if($result1['date']==$lastday)
			{
			$_SESSION['left1']=1;
			$_SESSION['left_i']=$result1['invest'];
			$_SESSION['left_p']=$result1['point'];	
			}			
		}
		count_left($left_id);
		/*Matching BV Based on Package Left Node End*/	
	?>


	<?php		
	

		echo $_SESSION['left'];
		echo" - ";
		echo $_SESSION['left1'];
		echo" - ";		
		echo $_SESSION['left_p'];
		echo" - ";		
		echo $_SESSION['left_i'];	
		echo" - ";		
		echo $_SESSION['left_a'];
		echo" - ";		
		echo $_SESSION['left_s'];
		

	
	
	
	
	

	
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