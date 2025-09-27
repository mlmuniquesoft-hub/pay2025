<?php ob_start();
	session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		$admin = $_SESSION['Admin'];
		$catId=$mysqli->real_escape_string($_POST['cat_id']);
		$scatId = $mysqli->real_escape_string($_POST['scat_id']);
		$offer = $mysqli->real_escape_string($_POST['offer']);
		$offerV = $mysqli->real_escape_string($_POST['offerV']);
		$brandId = $mysqli->real_escape_string($_POST['brandID']);
		$model = $mysqli->real_escape_string($_POST['model']);
		$name = $mysqli->real_escape_string($_POST['Name']);
		$info = $mysqli->real_escape_string($_POST['info']);

		$oPrice = $mysqli->real_escape_string($_POST['oPrice']);
		$sPrice = $mysqli->real_escape_string($_POST['sPrice']);
		
		$cost = $mysqli->real_escape_string($_POST['sCost']);
		if(($sPrice!='')&&($cost!='')){
		$price=$oPrice+$cost;
		}
		if(($sPrice!='')&&($price!='')){
		$profit =$sPrice-$price;
		}
		if(($price!='')&&($sPrice!='')&&($profit!='')){
		$pv = $profit/10;
		}
		if($offer==1){
			$discount =$sPrice*$offerV/100;
			$dPrice=$sPrice-$discount;
		}
		if($dPrice<=0){
			$dPrice=0;
		}
		if($offerV<=0){
			$offerV=0;
		}
			
		
		$stock = $mysqli->real_escape_string($_POST['stock']);
		$place= $mysqli->real_escape_string($_POST['place']);
		$rdate=date('Y-m-d');

		   
		$img1=$_FILES['img1']["name"];
	/* 	$temp_name1 = $_FILES['img1']["tmp_name"];
		move_uploaded_file($temp_name1,"../product/$img1"); */

		$img2=$_FILES['img2']["name"];
		$temp_name2 = $_FILES['img2']["tmp_name"];
		move_uploaded_file($temp_name2,"../nzproducts/$img2");


		$img3=$_FILES['img3']["name"];
		$temp_name3 = $_FILES['img3']["tmp_name"];
		move_uploaded_file($temp_name3,"../nzproducts/$img3");


		$img4=$_FILES['img4']["name"];
		$temp_name4 = $_FILES['img4']["tmp_name"];
			move_uploaded_file($temp_name4,"../nzproducts/$img4");
		


		
	if($name==''){
			$_SESSION['msg'] = "Please Submit Product Name";       
			header("Location: product.php");
			exit();	
		}	
		
	
		if($img1==''){
			$_SESSION['msg'] = "Please Submit Product  Image";       
			header("Location: product.php ");
			exit();	
		}

		if($oPrice==''){
			$_SESSION['msg'] = "Please Submit Product Orginal Price";       
			header("Location: product.php");
			exit();	
		}
		if($sPrice==''){
			$_SESSION['msg'] = "Please Submit Product Sale Price";       
			header("Location:product.php");
			exit();	
		}
		$com=mysqli_fetch_object($mysqli->query("select * from `commission`"));
		
		$spot=$profit*$com->spot/100;
		$direct=$profit*$com->direct/100;
		$matching=$profit*$com->matching/100;
		$bonus=$profit*$com->bonus/100;
		$royality=$profit*$com->royality/100;
		$others=$profit*$com->others/100;
		$weekly=$profit*$com->weekly/100;
		$monthly=$profit*$com->monthly/100;
		$yearly=$profit*$com->yearly/100;
		$gen=$profit*$com->gen/100;
		$psc=$profit*$com->psc/100;
		$incentive=$profit*$com->incentive/100;
		$distributor=$profit*$com->distributor/100;
		$lc=$profit*$com->lc/100;
		$iad=$profit*$com->iad/100;
		$dsd=$profit*$com->dsd/100;
		$sponsor=$profit*$com->sponsor/100;
		$division=$profit*$com->division/100;
		$district=$profit*$com->district/100;
		$ps=$profit*$com->ps/100;
		$union=$profit*$com->union/100;
		$ward=$profit*$com->ward/100;
		$la=$profit*$com->la/100;
		$welfare=$profit*$com->welfare/100;
		$caring=$profit*$com->caring/100;
		$medical=$profit*$com->medical/100;
		$ad=$profit*$com->ad/100;
		$company=$profit*$com->company/100;
		$location="product_add.php";
		$rename1=time();

		if(($name!='')&&($oPrice!='')&&($sPrice!='')&&($img1!='')){
			// img1 | rename1 | ImageName1 Start
	$FileName=$_FILES['img1']['name']; //FileName 
	$ExtPos=strrpos($FileName,".");
	$Extension=strtolower(substr($FileName,$ExtPos+1,strlen($FileName)-$ExtPos));
	$ImageName1=$rename1.'-1.jpg';
	$FinalName = "../image/".$ImageName1;//Temp 1st Folder
		
	if ($_FILES['img1']['size'] > 2000000) //FileName 
	{
	$allow=0;
	$_SESSION['msg']="Image size more than 2 MB";
	header("Location:$location");
	exit();		 
	}
	
	$ExtPos=strrpos($FileName,".");
	$Extension=strtolower(substr($FileName,$ExtPos+1,strlen($FileName)-$ExtPos));
	$mime=$Extension;		
	if(($mime=='jpg')||($mime=='png')||($mime=='gif')||($mime=='jpeg'))
	{
	$allow=1;
	}
	else
	{
	$allow=0;
	$_SESSION['msg']="Image type not valid must be png, jpg, gif";
	header("Location:$location");	
	exit();	
	}
			
	if ($FileName=='') 
	{
	$allow=0;
	$_SESSION['msg']="Please Select your Photo";
	header("Location:$location");
	exit();	
	}		


	if(($allow!=0)&&( ($FileName!='') )) 	
	{
	move_uploaded_file($_FILES['img1']['tmp_name'], $FinalName ); //Final FileName       
	$src_file = "../image/".$ImageName1; //Temp 2nd Folder
	$resource = @imagecreatefromstring(file_get_contents($src_file));
	if($resource!== false)
	{
	$dest_file = "../nzproducts/".$ImageName1; // Destination Folder
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
	// Submittion 
			
			$mysqli->query("INSERT INTO `product` (`spot`, `direct`, `matching`, `bonus`, `royality`, `others`, `weekly`, `monthly`,`yearly`,`gen`, `psc`, `incentive`, `distributor`, `lc`, `iad`, `dsd`, `sponsor`, `division`, `district`, `ps`, `dunion`,`ward`, `la`, `welfare`, `caring`, `medical`, `ad`, `company`,`cat_id`,`scat_id`,`name`,`model`,`brand_id`,`price`,`sale_price`,`cost`,`profit`,`rp`,`discount_price`,`offer`,`offer_value`,`img1`,`img2`,`img3`,`img4`,`info`,`place`,`stock`,`date`) 
			VALUES ('".$spot."','".$direct."','".$matching."','".$bonus."','".$royality."','".$others."','".$weekly."','".$monthly."','".$yearly."','".$gen."','".$psc."','".$incentive."','".$distributor."','".$lc."','".$iad."','".$dsd."','".$sponsor."','".$division."','".$district."','".$ps."','".$union."','".$ward."','".$la."','".$welfare."','".$caring."','".$medical."','".$ad."','".$company."','".$catId."','".$scatId."','".$name."','".$model."','".$brandId."','".$oPrice."','".$sPrice."','".$cost."','".$profit."','".$pv."','".$dPrice."','".$offer."','".$offerV."','".$ImageName1."','".$img2."','".$img3."','".$img4."','".$info."','".$place."','".$stock."','".$rdate."')");
			
			$mysqli->query("update `cat` set `chk`='1' where `cat_id`='".$catId."' ");
			
				$_SESSION['msgs']="All items are successfully submitted.";       
	header("Location:product.php");
	exit();
	}
	else
	{
	unlink($src_file);
	$_SESSION['msg']="This Photo is not a real image file"; 
	header("Location:$location");
	exit();	
	}
	
	}
	else
	{
	$_SESSION['msg']="Photo Upload error try later"; 
	header("Location:$location"); 
	exit();		
	}
	// img1 | rename1 | ImageName1 End	
			}
			else{
				$_SESSION['msg']="Something Missing.";       
				header("Location:product_add.php");
				exit();
			}	
			
		
	

	}
ob_end_flush();	
?>