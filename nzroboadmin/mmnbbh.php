<?php
	$subject = "Approved Your $refg Update Request";
	$message = "
	Thanks For $refg Update Request </br>
	We Update Your New $refg ($eemmnn) </br>
	 </br>
	Thanks, </br>
	";
	
	$message=$message;
	$from = "info@westernscash.com";
	$headers = "From:" . $from;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Westerns Cash<info@westernscash.com>' . "\r\n";
	mail($to,$subject,$message,$headers);
?>