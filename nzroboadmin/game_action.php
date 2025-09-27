<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		require '../db/functions.php';
		
		$gameName=$_POST['gameName'];
		$memberlevel=$_POST['level'];
		$user=$_POST['user'];
		$type=$_POST['type'];
		$pin=$_POST['pin'];
		$copyNumber=$_POST['copyNumber'];
		$criteria_active=implode("", $_POST['criteria_active']);
		$criteria_amn=implode("", $_POST['criteria_amn']);
		$GameStart=$_POST['strtHours'] ."/".$_POST['strtMinute'];
		$GameEndIme=$_POST['endHours'] ."/".$_POST['endMinute'];
		$location=$_POST['location'];
		$chekk=1;
		//$_POST['short_ques']=
		//var_dump($_POST['trade_bal']);
		//die();
		if($type==''){
			$chekk=0;
			$_SESSION['msg']="Please Choose Game Type";
			header("Location: $location");
			exit();
		}
		if($user==''){
			$chekk=0;
			$_SESSION['msg']="Please Choose Member Type";
			header("Location: $location");
			exit();
		}
		if(empty($criteria_active)){
			$chekk=0;
			$_SESSION['msg']="Please Choose Team Or Game Criteria";
			header("Location: $location");
			exit();
		}
		if(empty($criteria_amn)){
			$chekk=0;
			$_SESSION['msg']="Please Choose Team Or Game Return Amount";
			header("Location: $location");
			exit();
		}
		if(empty($pin)){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Transaction Pin";
			header("Location: $location");
			exit();
		}
		$gghh=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($gghh<1){
			$chekk=0;
			$_SESSION['msg']="Please Insert Your Correct Transaction Pin";
			header("Location: $location");
			exit();
		}
		if($chekk==1){
			$_POST['startTime']=$GameStart;
			$_POST['endTime']=$GameEndIme;
			for($i=1;$i<=$copyNumber; $i++){
				$rrtt=InsertInfo("games", $_POST);
			}
			
			if($rrtt==1){
				$_SESSION['msg1']="Your Game Submit Successfully";
				header("Location: $location");
				exit();
			}else{
				$_SESSION['msg']="Your Connection Not Secure Try Latter";
				header("Location: $location");
				exit();
			}
		}else{
			$_SESSION['msg']="Your Connection Not Secure Try Latter";
			header("Location: $location");
			exit();
		}
		
		
	}
?>