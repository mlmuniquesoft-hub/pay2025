<?php
	session_start();
	if( $_SESSION['Admin'] == ''){
		$msg="Please login first!";
		header("Location: ../admin/index.php?msg=$msg");
		exit();
	}else{
		require '../db/db.php';
		$admin = $_SESSION["Admin"];

		$desc = $_POST['desc'];
		$serial = $_POST['serial'];
		$top = $_POST['top'];
		$left = $_POST['left'];
		$text_color = $_POST['text_color'];
		$background = $_POST['background'];

		$images1 =  $_FILES['img1']["name"];
		$temp_name1 = $_FILES['img1']["tmp_name"];
		move_uploaded_file($temp_name1,"../member/slide/$images1");


		
		
		if(($images1!='')&&isset($_POST['submit'])){
			if($images1==''){
				$_SESSION['msg'] = "Please submit your  Image";       
				header("Location:promotion.php");
				exit();	
			}
			$query12="INSERT INTO `slide`(`image`,`desc`,`left`,`top`,`text_color`,`background`) VALUES ('".$images1."','".$desc."','".$left."','".$top."','".$text_color."','".$background."')";
			$mysqli->query($query12);	
			$_SESSION['msg'] = "Your Slide successfully submitted.";       
			header("Location:promotion.php ");
			exit();	
		}
		
		if(isset($_POST['update'])){
			$query12="UPDATE `slide` SET `desc`='".$desc."',`text_color`='".$text_color."',`background`='".$background."',`left`='".$left."',`top`='".$top."' WHERE serial='".$serial."' ";
			mysqli_query($connection, $query12);	
			$_SESSION['msg'] = "Your Slide successfully submitted.";       
			header("Location:promotion.php?slide=$serial");
			exit();	
		}else{
			$_SESSION['msg'] = "Submission Error Try later."; 
			header("Location:promotion.php");
			exit();	
		}

	}
?>