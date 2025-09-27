<?php
session_start();
require_once("../../db/db.php");
$UserID=$_SESSION['roboMember'];
$hdfgd=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$UserID."'"));
$Tasds=$_GET['acsf'];
$ids=$_GET['ids'];
if($Tasds=="message2"){
	$mysqli->query("UPDATE `$Tasds` SET `active`='0' WHERE `user_id`='".$hdfgd['log_user']."' ");
}else{
	$mysqli->query("UPDATE `$Tasds` SET `active`='0' WHERE `user`='".$UserID."'");
}
echo 0;
?>