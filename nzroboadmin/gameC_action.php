<?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		
		$type33= $_POST['type'];
		$question= $_POST['qquu'];
		$teams= implode("/", $_POST['criteria_active']);
		$power= implode("/", $_POST['criteria_amn']);
		$details= $_POST['details'];
		$pin= $_POST['pin'];
		$location= $_POST['location'];
		$type= $_POST['series'];
		$tds= $_POST['tds'];
		$connc=$$tds;
		$GameStart=$_POST['strtHours'] ."/".$_POST['strtMinute'];
		$GameEndIme=$_POST['endHours'] ."/".$_POST['endMinute'];
		//var_dump($connc);
		//die();
		
		/*if($type33==""){
			$_SESSION['msg']="Select Game Type";
			header("Location:$location");
			exit(); 
		}
		*/
		if($teams==""){
			$_SESSION['msg']="Select Game Teams";
			header("Location:$location");
			exit(); 
		}
	
		if($question==""){
			$_SESSION['msg']="Please Insert Question";
			header("Location:$location");
			exit(); 
		}
		if($details==""){
			$_SESSION['msg']="Please Insert Question";
			header("Location:$location");
			exit(); 
		}
		
		$jhk=mysqli_num_rows($mysqli->query("SELECT * FROM `admin` WHERE `user_id`='".$_SESSION['Admin']."' AND `tr_password`='".$pin."'"));
		if($jhk<1){
			$_SESSION['msg']="Invalid Transaction Password";
			header("Location:$location");
			exit(); 
		}
		if(($question!='')||($teams!='')){
			$querty=$connc->query("INSERT INTO `game_question`( `question`,`detailss`, `teams`, `gameType`,`typeName`, `special_reward`, `startTime`, `endTime`) VALUES ('".$question."','".$details."','".$teams."','".$type."','".$type33."','".$power."','".$GameStart."','".$GameEndIme."')");
			//echo "INSERT INTO `game_question`( `question`,`detailss`, `teams`, `gameType`,`typeName`, `special_reward`, `startTime`, `endTime`) VALUES ('".$question."','".$details."','".$teams."','".$type."','".$type33."','".$power."','".$GameStart."','".$GameEndIme."')";
			//die();
			$_SESSION['msg2'] = "Game Submit  Successfull";       
			header("Location:$location");
			exit();   
		}else{
			$_SESSION['msg']="Game Input missing";
			header("Location:$location");
			exit();   
		}
				
	}
	
?>