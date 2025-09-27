<?php
    session_start(); 
    if(!isset($_SESSION['roboMember'])){
    	header("Location:logtout.php");
    	exit();
    }else{
		require '../db/db.php';
		$memberid=strtolower($_SESSION["roboMember"]);
		$FileName=$_FILES['userfile']['name'];
		$location=$_POST['location'];
		$ExtPos=strrpos($FileName,".");
		$Extension=strtolower(substr($FileName,$ExtPos+1,strlen($FileName)-$ExtPos));
		$ImageName="$memberid.".jpg;
		$FinalName = "images/".$ImageName;
		
		if ($_FILES['userfile']['size'] > 5000000){
			$allow=0;
			$_SESSION['msg'] ="Image size more than 1 MB";
			header("Location:$location");
			exit();		 
		}
		
		$ExtPos=strrpos($FileName,".");
		$Extension=strtolower(substr($FileName,$ExtPos+1,strlen($FileName)-$ExtPos));
		$mime=$Extension;		
		if(($mime=='jpg')||($mime=='png')||($mime=='gif')||($mime=='jpeg')){
			$allow=1;
		}else{
			$allow=0;
			$_SESSION['msg']="Image Type Not Valid Must Be png, jpg, gif";
			header("Location:$location");	
			exit();	
		}
				
		if ($FileName==''){
			$allow=0;
			$_SESSION['msg']="Please Select Your Photo";
			header("Location:$location"); 
			exit();	
		}		


		if(($allow!=0)&&($FileName!='')){
			$mmjj=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$memberid."'"));
			move_uploaded_file($_FILES['userfile']['tmp_name'], $FinalName );        
			$src_file = "images/".$ImageName;
			$resource = @imagecreatefromstring(file_get_contents($src_file));
			if($resource!== false){
				$dest_file = "photo/".$ImageName;
				$img_quality = 70;	
				$im = imagecreatefromstring(file_get_contents($src_file));
				$im_w = imagesx($im);
				$im_h = imagesy($im);
				$newheight = 320; 
				$newwidth=($im_w/$im_h)*$newheight;	
				$tn = imagecreatetruecolor($newwidth,$newheight);
				imagecopyresampled ( $tn , $im, 0, 0, 0, 0, $newwidth, $newheight, $im_w, $im_h );
				imagejpeg($tn,$dest_file,$img_quality);        
				unlink($src_file);
				$mysqli->query("UPDATE profile SET	photo='".$ImageName."' WHERE user='".$mmjj['log_user']."'");
				$_SESSION['msg1']="Photo Upload Successful";
				header("Location:$location");
				exit();	
			}else{
				unlink($src_file);
				$_SESSION['msg']="This Photo Is Not a Real Image File";
				header("Location:$location");
				exit();	
			}
		}else{
			$_SESSION['msg']="Photo Upload error try later";
			header("Location:$location");
			exit();		
		}
	}   
?> 