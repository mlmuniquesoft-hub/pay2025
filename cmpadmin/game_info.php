<><?php
	session_start();
	if(($_SESSION['Admin']=='')||(!isset($_SESSION['Admin']))){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';
		$gametype=$_GET['tt'];
		
		$myyp=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `games` WHERE `type`='".$gametype."' AND `active`='1'"));
		$rrtt=array();
		$rrtt['team_a']=$myyp['team_a'];
		$rrtt['team_b']=$myyp['team_b'];
		$rrtt['team_aReturn']=$myyp['teama_return'];
		$rrtt['team_bReturn']=$myyp['teamb_return'];
		$rrtt['details']=$myyp['details'];
		echo json_encode($rrtt);
	}
?>