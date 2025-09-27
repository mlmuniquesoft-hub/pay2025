<?php
	 session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../../db/db.php';
		require '../../db/functions.php';
		$rett=array();
		$user=$_SESSION['roboMember'];
		$jkdghd=$mysqli->query("SELECT * FROM `game_return` WHERE `user`='".$user."' ORDER BY `serial` DESC LIMIT 15");
		$fGGcHECK=mysqli_num_rows($jkdghd);
		//array_push($rett,$fGGcHECK);
		if($fGGcHECK>0){
			while($Allert=mysqli_fetch_assoc($jkdghd)){
				array_push($rett,$Allert['bonus_bal']);
			}
		}else{
			$jkdhfg=$mysqli->query("SELECT DISTINCT `bonus_bal` FROM `game_return` ORDER BY `serial` DESC LIMIT 15");
			while($allREst=mysqli_fetch_assoc($jkdhfg)){
				array_push($rett,$allREst['bonus_bal']);
			}
		}
		$GGfsdfs=count($rett);
		if($GGfsdfs<=0){
			for($i=0;$i<=10;$i++){
				array_push($rett,$i);
			}
		}
		
		echo json_encode($rett);
		die();
	}

?>