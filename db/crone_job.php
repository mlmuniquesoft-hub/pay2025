 <?php
	include('sms_api.php');
	$_SESSION['token']='123456789asdfgh';	
	include "db.php";
	
	$SQL="select * from sms where Status='Pending'";
	
	$res=$mysqli->query($SQL);
	while ($rs=mysqli_fetch_object($res))
	{
		sleep(1);
		SendSMS("Greetings",$rs->mobile,$rs->text);
		$SQL="Update sms set Status='Success' where serial=".$rs->serial;
		$mysqli->query($SQL);
	}
	
	
	
	
?>