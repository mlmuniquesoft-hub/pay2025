<?php
	session_start();
	require '../db/db.php';
	//var_dump($_POST);
	
	if(isset($_POST['add'])){
		$win = $_POST['win'];
		$id=$_POST['id'];
		
		if($win==''){
			$_SESSION['msg'] = "Your input must be field !";
			header("Location: winner.php");
			exit();
		}
		
		$update = "UPDATE `add_match` SET `winner`='".$win."' WHERE id=1";
		//echo $update;
		$query = mysqli_query($mysqli,$update);
		
		$_SESSION['msg'] = "You have successfully added Winner !";
		header("Location: winner.php");
		exit();
	}else{
		$_SESSION['msg'] = "You faild !";
		header(Location: match_summary.php);
		exit();
	}
	

?>