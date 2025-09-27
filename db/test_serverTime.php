<?php
session_start();
$_SESSION['token']="dfgdfgfd";
require '../db/db.php';
require '../db/functions.php';
$mmm22=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `hacker` ORDER BY `serial` DESC LIMIT 1"));
//var_dump($mmm22['date']);
$erter=date("Y-m-d H:i:s");
echo $erter;
$hhg=SeverToLocalTime($mysqli, $mmm22['date'],"+1 hours");
$hhg2=SeverToLocalTime($mysqli, $erter,"+3 hours","GMT");

//$hhg22=strtotime(GMTtmeConvert($erter,"-3 hours","6/2"));

//echo ;
//$erter=strtotime($hhg2)-strtotime($hhg);
//echo ($erter/60) ." >< " ;
//echo strtotime($hhg) ." >< " ;
//echo strtotime($hhg2);
//var_dump($hhg);
var_dump($hhg2);
//var_dump($hhg22);



//var_dump($timeZonett);
//var_dump($gmttTime);

//var_dump(date("M d, Y H:i:s ", strtotime($gmttTime)+$timeZonett));
//var_dump(date("Y-m-d H:i:s ", strtotime($gmttTime."+06:00 hours")));
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
p {
  text-align: center;
  font-size: 60px;
  margin-top:0px;
}
</style>
</head>
<body>
<script>
var GhhTime=function(ttiimm,ppllcc){
	var countDownDate = new Date(ttiimm).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

		// Get todays date and time
		var now = new Date().getTime();
		
		// Find the distance between now an the count down date
		var distance = countDownDate - now;
		
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		// Output the result in an element with id="demo"
		document.getElementById(ppllcc).innerHTML = days + "d " + hours + "h "
		+ minutes + "m " + seconds + "s ";
		
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			document.getElementById(ppllcc).innerHTML = "EXPIRED";
		}
	}, 1000);
}

	//console.log(tyyuu);

</script>
<?php 
	for($i=0;$i<=12;$i++){
?>
<p id="demo<?php echo $i; ?>"></p>

<script>
// Set the date we're counting down to
var tyyuu="<?php echo date("M d, Y H:i:s ", strtotime($hhg . "+$i hours")); ?>";
var tyyuu22="<?php echo "demo" . $i; ?>";
GhhTime(tyyuu, tyyuu22);
</script>
<?php } ?>
</body>
</html>
