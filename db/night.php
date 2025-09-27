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
		
		function count_right($right_id)
		{
		global $mysqli;	
		global $lastday;
		$exe6 = $mysqli->query("SELECT user,upline,invest,point,date,paid FROM member WHERE upline='".$right_id."'");
		while($result6=mysqli_fetch_array($exe6))
		{
			$_SESSION['right_s']= $_SESSION['right_s']+$result6['point']+$result6['invest'];
			$_SESSION['right']= $_SESSION['right']+1; 
			if($result6['paid']==1)
			{
			$_SESSION['right_a']= $_SESSION['right_a']+1; 
			}				
			if($result6['date']==$lastday)
			{
			$_SESSION['right1']= $_SESSION['right1']+1; 
			$_SESSION['right_i']= $_SESSION['right_i']+$result6['invest'];		
			$_SESSION['right_p']= $_SESSION['right_p']+$result6['point'];
			}				
		$res7=mysqli_fetch_array($mysqli->query("SELECT user,upline,point,invest,date,paid FROM member WHERE user='".$result6['user']."'"));
		count_right($res7['user']);
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
		/*Matching BV Based on Package Right Node Start*/	
		$_SESSION['right']=0;	 //right user total	
		$_SESSION['right_a']=0;  //right user active
		$_SESSION['right1']=0;   //right user today
		$_SESSION['right_p']=0;	 //right point today
		$_SESSION['right_i']=0;  //right invest today
		$_SESSION['right_s']=0;	 //right point total	
		$result5 = mysqli_fetch_array($mysqli->query("SELECT user,position,upline,point,invest,date,paid FROM member WHERE upline='".$memberid."' AND position='Right' "));
		$right_id=$result5['user'];
		if($result5['user'])
		{
			$_SESSION['right_s']= $result5['point']+$result5['invest'];			
			$_SESSION['right']=1;
			if($result5['paid']==1)
			{
			$_SESSION['right_a']=1;
			}			
			if($result5['date']==$lastday)
			{	
			$_SESSION['right1']=1;
			$_SESSION['right_i']=$result5['invest'];	
			$_SESSION['right_p']=$result5['point'];			
			}
		}
		count_right($right_id);
		/*Matching BV Based on Package Right Node End*/			
		
		
		
	?>


	<?php		
	
	$que1 = "SELECT `user`, `date`,`flash`,`l_cary`, `r_cary` FROM `binary` WHERE `user`='".$memberid."' ORDER BY serial DESC LIMIT 1";
	$res1=$mysqli->query($que1);
	$rows1 = mysqli_fetch_array($res1);	
	
 	$left_u = ($_SESSION['left_p']+$_SESSION['left_i']+$rows1['l_cary']); 
 	$right_u = ($_SESSION['right_p']+$_SESSION['right_i']+$rows1['r_cary']); 
	if($left_u==$right_u)
	{			
	$mysqli->query("UPDATE `balance` SET 
		`match_point`='".$left_u."',
		`un_used_left_point`='0',
		`un_used_right_point`='0'  			
	WHERE `user`='".$memberid."'");
	}			
	elseif($left_u>$right_u)
	{
	$mysqli->query("UPDATE `balance` SET 
		`match_point`='".$right_u."',
		`un_used_left_point`='".($left_u-$right_u)."',
		`un_used_right_point`='0'  			
	WHERE `user`='".$memberid."'");			
	}
	elseif($left_u<$right_u)
	{
	$mysqli->query("UPDATE `balance` SET 
		`match_point`='".$left_u."',
		`un_used_left_point`='0',
		`un_used_right_point`='".($right_u-$left_u)."'  			
	WHERE user='".$memberid."'");			
	} 
	?>

	
	
	<?php
	/*Getting Current Data again from Database */
	$result=$mysqli->query("select `user`, `match_point`, `flash_match_point`, `flash_point` from `balance` where `user`='".$memberid."'");
	$row = mysqli_fetch_array($result);
	$matcpointupdate=$row['match_point']; 

	$result6=$mysqli->query("select `user`, `date`, `matching` from `binary` where `user`='".$memberid."' AND `date`='".$lastday."'");
	$check6 = mysqli_num_rows($result6);	

 	$left_t = ($_SESSION['left_p']+$_SESSION['left_i']); 
	$right_t = ($_SESSION['right_p']+$_SESSION['right_i']); 
	if($left_t>0){$active=1;}
	elseif($right_t>0){$active=1;}
	else{$active=0;}	
	
	/*Creating Or Updating Todays Matching BV Data To Database */	
	if(($check6==0)&&($active==1))
	{
	$mysqli->query("INSERT INTO `binary`(`user`, `date`, `matching`,`l_new`,`r_new`)
	VALUES ('".$memberid."','".$lastday."','".$matcpointupdate."','".$left_u."','".$right_u."')");
	} 

		
			
?> 
	

<?php
	/*Creating New Flash Matching BV Based On Package and Condition Start*/
	$query7 = "select `user`, `date`, `matching` from `binary` where `user`='".$memberid."' AND `date`='".$lastday."' ";
	$result7=$mysqli->query($query7);
	$row7=mysqli_fetch_array($result7);
	$matching=$row7['matching'];
	$lastday7=$row7['date'];  	
	
	/*Final Matching BV Based on Frist Package Start*/
	if($pack=='Visitor')
	{
		if(($matching>19)&&($matching<=49))
		{
		$mysqli->query("UPDATE `binary` SET 
		`flash_match`='20',
		`flash`='".($matching-20)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");
		}
		elseif(($matching>49)&&($matching<=99))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='50',
		`flash`='".($matching-50)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}	
		elseif(($matching>99)&&($matching<=249))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='100',
		`flash`='".($matching-100)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}	
		elseif(($matching>249)&&($matching<=499))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='250',
		`flash`='".($matching-250)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}
		elseif($matching>499)
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='500',
		`flash`='".$matching."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}		
	}
    elseif($pack=='Earner')
	{
		if(($matching>19)&&($matching<=49))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='20',
		`flash`='".($matching-20)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");
		}
		elseif(($matching>49)&&($matching<=99))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='50',
		`flash`='".($matching-50)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}
		
		elseif(($matching>99)&&($matching<=249))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='100',
		`flash`='".($matching-100)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}	
		elseif(($matching>249)&&($matching<=499))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='250',
		`flash`='".($matching-250)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}
		elseif(($matching>499)&&($matching<=999))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='500',
		`flash`='".($matching-500)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}	
		elseif(($matching>999)&&($matching<=2499))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='1000',
		`flash`='".($matching-1000)."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}	
		elseif($matching>2499)
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='2500',
		`flash`='".$matching."'
		WHERE `date`='".$lastday7."' AND `user`='".$memberid."'");		
		}
	}	
	elseif($pack=='Success')
	{
		if(($matching>19)&&($matching<=49))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='20',
		`flash`='".($matching-20)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");
		}
		elseif(($matching>49)&&($matching<=99))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='50',
		`flash`='".($matching-50)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
		elseif(($matching>99)&&($matching<=249))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='100',
		`flash`='".($matching-100)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}	
		elseif(($matching>249)&&($matching<=499))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='250',
		`flash`='".($matching-250)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}
		elseif(($matching>499)&&($matching<=999))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='500',
		`flash`='".($matching-500)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
		elseif(($matching>999)&&($matching<=2499))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='1000',
		`flash`='".($matching-1000)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
		elseif(($matching>2499)&&($matching<=4999))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='2500',
		`flash`='".($matching-2500)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
		elseif(($matching>4999)&&($matching<=9999))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='5000',
		`flash`='".($matching-5000)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
		elseif(($matching>9999)&&($matching<=24999))
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='10000',
		`flash`='".($matching-10000)."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}			
		elseif($matching>24999)
		{
		$mysqli->query("UPDATE `binary` SET
		`flash_match`='25000',
		`flash`='".$matching."'
		WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");		
		}		
	}	

	
?>
	

<?php
	/*Creating New Flash Matching Taka Based On Package and Condition Start*/	
	$queryget="SELECT SUM(flash_match) AS `flash_match`, SUM(flash) AS `flash`	FROM `binary` where `user`='".$memberid."' ";
	$querygetexe=$mysqli->query($queryget);
	while($querygetexeres=mysqli_fetch_array($querygetexe))
	{
	$_SESSION['flash_match']=$querygetexeres['flash_match'];	
	$_SESSION['flash']=$querygetexeres['flash'];
	$_SESSION['matc_taka']=($querygetexeres['flash_match']*.05);
	}
	/*Creating New Flash Matching Taka Based On Package and Condition End*/	


	

		$mysqli->query( "UPDATE `balance` SET 
			`left_user`='".$_SESSION['left']."',
			`right_user`='".$_SESSION['right']."',
			`left_point`='".$_SESSION['left_s']."',
			`right_point`='".$_SESSION['right_s']."',
			`left_invest`='".$_SESSION['left_i']."',
			`right_invest`='".$_SESSION['right_i']."',			
			`match_taka`='".($_SESSION['matc_taka'])."',
			`flash_match_point`='".$_SESSION['flash_match']."',
			`flash_point`='".$_SESSION['flash']."'
		WHERE `user`='".$memberid."'");


	
?>
<?php


	$row9=mysqli_fetch_array($mysqli->query("select `user`, `date`, `flash_match`,`l_new`,`r_new`  from `binary` where `user`='".$memberid."' AND `date`='".$lastday."' "));
	$un_flash=$row9['flash_match'];	
	$un_left=$row9['l_new'];
	$un_right=$row9['r_new'];
	$cary_left=0;
	$cary_right=0;
	if($un_right<$un_left){$cary_left=($un_left-$un_flash);}
	elseif($un_left<$un_right){$cary_right=($un_right-$un_flash);}	
	elseif($un_left==$un_right){$cary_left=($un_right-$un_flash);}
	
	$mysqli->query("UPDATE `binary` SET  
		`l_point`='".$_SESSION['left_s']."',
		`r_point`='".$_SESSION['right_s']."',
		`l_cary`='".$cary_left."',
		`r_cary`='".$cary_right."',
		`l_invest`='".$_SESSION['left_i']."',
		`r_invest`='".$_SESSION['right_i']."',
		`chk`='1'
	WHERE `date`='".$lastday7."' AND  `user`='".$memberid."'");


	
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