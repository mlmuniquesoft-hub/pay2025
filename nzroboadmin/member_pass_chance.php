<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }else{
		require '../db/db.php';
		require_once '../db/calculation_admin.php';
		require_once '../db/template.php';
	}           
?>
	

<!DOCTYPE html>


<head>
	
	<title><?php echo $Adminnb; ?></title>
	<link href="templatemo_style.css" rel="stylesheet" type="text/css" />
	<link href="../images/icon.jpg" rel="SHORTCUT ICON"/>

	<script language = "Javascript">	
	function ValidForm6()
	{
	  var oldPassword=document.memberpasschng.oldPassword
		
		if ((oldPassword.value==null)||(oldPassword.value.length < 1 ||oldPassword.value.length > 25)){
			alert("You have not entered your current password")
			oldPassword.focus()
			oldPassword.value.value="";
			return false
		}
			
	  var newPassword1=document.memberpasschng.newPassword1
		
		if ((newPassword1.value==null)||(newPassword1.value.length < 5 ||newPassword1.value.length > 25)){
			alert("Please Enter new Password more than 5 charactor")
			newPassword1.focus()
			newPassword1.value.value="";
			return false
		}
			
	
		var newPassword2=document.memberpasschng.newPassword2
		
		if ((newPassword2.value==null)||(newPassword2.value.length < 5 || newPassword2.value.length > 25)){
			alert("Please Enter same new Password to Verify")
			newPassword2.focus()
			newPassword2.value.value="";
			return false
		}
		
		var c=document.getElementById('one').value;
		var d=document.getElementById('two').value;
		if(c!=d)
		{
		    alert("Password don't match!")
			newPassword1.focus()
			return false
		}
		
	}
	
	
	</script>
	<script language = "Javascript">	
	function ValidForm5()
	{
	  var oldPassword=document.memberpass.oldPassword
		
		if ((oldPassword.value==null)||(oldPassword.value.length < 1 ||oldPassword.value.length > 25)){
			alert("You have not entered your current password")
			oldPassword.focus()
			oldPassword.value.value="";
			return false
		}
			
	  var newPassword1=document.memberpass.newPassword1
		
		if ((newPassword1.value==null)||(newPassword1.value.length < 5 ||newPassword1.value.length > 25)){
			alert("Please Enter new Password more than 5 charactor")
			newPassword1.focus()
			newPassword1.value.value="";
			return false
		}
			
	
		var newPassword2=document.memberpass.newPassword2
		
		if ((newPassword2.value==null)||(newPassword2.value.length < 5 || newPassword2.value.length > 25)){
			alert("Please Enter same new Password to Verify")
			newPassword2.focus()
			newPassword2.value.value="";
			return false
		}
		
		var c=document.getElementById('one').value;
		var d=document.getElementById('two').value;
		if(c!=d)
		{
		    alert("Password don't match!")
			newPassword1.focus()
			return false
		}
		
	}
	
	
	</script>
</head>
<?php
    $memberid = $_SESSION["Admin"];
    $query = "select * from admin where user_id='".$memberid."' ";
    $result=$mysqli->query($query);
    $row = mysqli_fetch_array($result);
?>
<body>
 
<div id="templatmeo_wrapper">

    <div id="templatemo_header">
    
        <div id="site_title">
            <h1><a href="#" target="_parent">
                <img src="../assets/images/cmp-logo.svg" alt="Capitol Money Pay" style="height: 40px;" />
           </a></h1>
        </div> <!-- end of site_title -->
        
        <div id="header_right">
        
            <ul id="header_button">
                <li><a href="home.php"><img src="images/templatemo_home.jpg" alt="home" /></a></li>
                <li><a href="#"><img src="images/templatemo_contact.jpg" alt="contact us" /></a></li>	
            </ul>
            
            <div class="cleaner"></div>

        
        </div>
        
    </div> <!-- end of templatemo_header -->
    

    
    <div id="templatemo_menu">
          <ul>  
 <?php require 'menu.php'; ?>   	
          </ul>  
    </div> <!-- end of templatemo_menu -->
 
    
    <div id="templatemo_content_wrapper">
    
    	<div id="templatemo_left_sidebar">
    	

         	<div class="templatemo_box">
            	<h2><span></span>Member Password Change</h2>
                
                <div class="body">


         <form action="password_action.php" method="post" name="memberpass" onSubmit="return ValidForm5()">
	 <p align="center"><center>        
               <br><b>Current Password :&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="password" name="oldPassword" size="20" maxlength="30"  />
               <br><b>New Password :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="password" name="newPassword1" size="20" maxlength="30" id="one" /> 
               <br><b>Re-New Password :&nbsp;&nbsp;</b> <input type="password" name="newPassword2" size="20" maxlength="30" id="two" /><br/>  
	       <br><input name="submit" type="submit" value="Submit" />
                            &nbsp;&nbsp;  
               <input name="reset" type="reset" value="Refresh" /> <br/><br/>
               
</p></form>

                    <br>
                </div>
            
            	<div class="box_bottom"><span></span></div>
            </div>          
        </div> <!-- end of left_sidebar --> 
 
          
  
    	
  
        
      </div> <!-- end of right_sidebar -->
        
        <div class="cleaner"></div>
    
    </div> <!-- end of templatemo_content_wrapper -->

</div> <!-- end of templatemo_wrapper -->

</body>
</html>		