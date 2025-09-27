<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logout.php");
    	exit();
    }else{
		require '../db/db.php';  

		$mobile=$_POST['mobile'];
		$category=$_POST['category'];
		$name=$_POST['name'];	
		$email=$_POST['email'];	
		$contact00=$_POST['contact'];	
		$father=$_POST['father'];	
		$mother=$_POST['mother'];	
		$blood=$_POST['blood'];	
		$address=$_POST['address'];	
		$birth=$_POST['birth'];	
		$postal=$_POST['postal'];	
		$swift=$_POST['swift'];	
		$bank=$_POST['bank'];	
		$account=$_POST['account'];	
		$branch=$_POST['branch'];	
		$voter=$_POST['voter'];
		$location=$_POST['location'];	
		if($name==''){
			
		}
		
		$mnb=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$_SESSION["roboMember"]."'"));
		//contact_num='".$contact00."',mobile='".$mobile."',
		$q="UPDATE profile SET 
		name='".$name."',
		country='".$category."',
		father='".$father."',
		mother='".$mother."',
		blood='".$blood."',
		address='".$address."',
		postal='".$postal."',
		birth='".$birth."',
		swift='".$swift."',
		bank='".$bank."',
		account='".$account."',
		branch='".$branch."',
		voter='".$voter."'
		WHERE user='".$mnb['user']."' OR user='".$mnb['log_user']."' ";	       
	
		$mysqli->query($q);	

		$_SESSION['msg3'] = "Profile Updated Successfully !!!";
		header("Location:profile.php");
		exit;
	}		
?>