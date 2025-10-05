<?php
	session_start();
   	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$uuu=$mysqli->real_escape_string($_GET['user']);
		$uui=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$uuu."'"));
		if($uui>0){
			$_SESSION['roboMember']=$uuu;
			$_SESSION['testt']=$uuu;
			echo "<script>
			window.open('../member/index.php');
			javascript:history.back();
			</script>";
			die();
		}else{
			echo "<script>
			javascript:history.back();
			</script>";
			die();
		}
		
	}	

?>