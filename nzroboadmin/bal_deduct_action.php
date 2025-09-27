  <?php
    session_start(); 
    if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';  
		//var_dump($_POST);
		//die();
		$user_id=$_POST['user_id'];
		$dddres=$_POST['dddres'];	
		$ddaamn=$_POST['ddaamn'];
		
		if($ddaamn>0){
			$check=$mysqli->query("INSERT INTO `bal_deduct`( `user`, `amount`, `reson`) VALUES ('".$user_id."','".$ddaamn."','".$dddres."')");
		}
		
		if($check){
			$_SESSION['msg'] = "Deduct Successfully Completed !!!";
			header("Location:deduct_mem_balance.php?member=$user_id");
			exit;
		}else{
			$_SESSION['msg'] = "Your Connection Not Secure Try Latter";
			header("Location:deduct_mem_balance.php?member=$user_id");
			exit;
		}
	
	}	
?>