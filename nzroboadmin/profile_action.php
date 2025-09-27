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
		$name=$_POST['user_name'];	
		$email=$_POST['email'];	
		$mobile=$_POST['contact'];
		
		$pacc=$_POST['pacc'];
		$Jkkm=$_POST['Jkkm'];
		if($Jkkm>0){
			$RRff=$_POST['REfmn'];
		}else{
			$RRff=0;
		}
		
		$query = "select * from member where user='".$user_id."' ";
		$result= $mysqli->query($query);
		$row = mysqli_fetch_array($result);	
			
		$q="UPDATE `profile` SET 
		`name`='".$name."',
		`mobile`='".$mobile."',
		`email`='".$email."'
		WHERE `user`='".$row['log_user']."' ";
		$check=$mysqli->query($q);
		//var_dump();
		if($pacc!=''){
			$q2="UPDATE `member` SET `pack`='".$pacc."' ,`ref_con`='".$RRff."' WHERE `user`='".$user_id."' ";
			$mysqli->query($q2);
		}
		
			
		if($check){
			$_SESSION['msg'] = "Profile Updated Successfully !!!";
			header("Location:member_edit.php?member=$user_id");
			exit;
		}else{
			$_SESSION['msg'] = "Your Connection Not Secure Try Latter";
			header("Location:member_edit.php?member=$user_id");
			exit;
		}
	
	}	
?>