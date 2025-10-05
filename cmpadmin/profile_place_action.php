  <?php
    session_start(); 
    if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';  
		//var_dump($_POST);
		//die();
		$user_cid=$_POST['user_cid'];
		$user_cid_prev=$_POST['user_cid_prev'];	
		$update_user=$_POST['update_user'];	
		$user_placeId=$_POST['user_placeId'];
		$place_user=$_POST['place_user'];
		$sponsorr=$_POST['sponsorr'];
		$cggf=0;
		if($user_cid!=$user_cid_prev){
			$query1 = mysqli_num_rows($mysqli->query("select `user` from member where log_user='".$user_cid."' "));
			if($query1>0){
				$cggf=1;
				$_SESSION['msg3'] = "This New CID Already In Use";
				header("Location:member_edit.php?member=$update_user");
				exit;
			}else{
				$mysqli->query("INSERT INTO `profile` (user) VALUES ('".$user_cid."')");
			}
		}
		$mmnbb=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$update_user."'"));
		if($mmnbb['upline']!=$user_placeId){
			$checkPlace=mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `upline`='".$user_placeId."' AND `position`='".$place_user."'"));
			if($checkPlace>0){
				$cggf=1;
				$_SESSION['msg3'] = "This Placement IDs Place Already Booked";
				header("Location:member_edit.php?member=$update_user");
				exit;
			}
		}
		
		if($cggf==0){
			$q="UPDATE `member` SET 
			`log_user`='".$user_cid."',
			`position`='".$place_user."',
			`upline`='".$user_placeId."',
			`sponsor`='".$sponsorr."'
			WHERE `user`='".$update_user."' ";
			
			$check=$mysqli->query($q);	
			$_SESSION['msg4'] = "Profile Updated Successfully !!!";
			header("Location:member_edit.php?member2=$update_user");
			exit;
		}else{
			$_SESSION['msg3'] = "Your Connection Not Secure Try Latter";
			header("Location:member_edit.php?membe2r=$update_user");
			exit;
		}
	
	}	
?>