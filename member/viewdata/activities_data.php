<?php
	$Activirt=array("Buy:p1","Sell:p2","Exchange:p3");
	//$imdfgg=array("p2","p1","p3");
	
	$text=rand(50,99999);
	$sfds=array("+:green-text","-:red-text");
	$dfgfdg=array_rand($Activirt);
	$dfgfdg3=array_rand($sfds);
	
	$Byertre=explode(":", $Activirt[$dfgfdg]);
	
	if($Byertre[0]=="Exchange"){
		$ActiStret=array("completed:success","Pending:warning","exchanged:primary","Canceled:danger");
		$dfgfdg2=array_rand($ActiStret);
		$Byertre2=explode(":", $ActiStret[$dfgfdg2]);
		$Byertre3=explode(":", " :blue-text");
	}else{
		$ActiStret=array("completed:success","Pending:warning","Canceled:danger");
		$dfgfdg2=array_rand($ActiStret);
		$Byertre2=explode(":", $ActiStret[$dfgfdg2]);
		$Byertre3=explode(":", $sfds[$dfgfdg3]);
	}
	$srereer=array(1,2,3,4,5,6,7,8,9);
	shuffle($srereer);
	$dfgfdg21=array_rand($srereer);
	$dfdfdg="+".$srereer[$dfgfdg21]." second";
?>
	<tr>
		<td>
			<div class="round img2">
				<img src="../data/crypto-dash/<?php echo $Byertre[1]; ?>.png" alt="">
			</div>
			<div class="designer-info">
				<h6><?php echo $Byertre[0]; ?> Record</h6>
				<small class="text-muted"><span class="mr-10"><?php echo date("m-d"); ?></span> <?php echo date("H:i:s", strtotime($dfdfdg)); ?></small>
			</div>
		</td>
		<td><span class="badge w-70 round-<?php echo $Byertre2[1]; ?>"><?php echo $Byertre2[0]; ?></span></td>
		<td class="<?php echo $Byertre3[1]; ?> boldy"><?php echo $Byertre3[0]; ?><?php echo $text; ?>$</td>
	</tr>