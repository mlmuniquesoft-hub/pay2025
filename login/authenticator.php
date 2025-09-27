<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.coopcrowds.uk/authenticator/index.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"secret=6LfTCbIUAAAAAMMOvOCawpOaDpwwMx0dzASk7nNN&response=$capths");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	$fdgdf=json_decode($server_output);
	var_dump($fdgdf);
?>