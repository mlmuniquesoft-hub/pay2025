<?php
	session_start();
	$_SESSION['token']='123asda';
	require_once("../db/db.php");
	$InfoKey=explode("/", base64_decode($_GET['key']));
	$counrty=strlen($InfoKey[0]);
	$user=substr($InfoKey[0],5,$counrty-10);
	$indgfd=explode(".",$user);
	$user=trim($indgfd[0]);
	//var_dump($user);
	$serial=trim($indgfd[1]);
	$TimLen=strlen($InfoKey[1]);
	
	if($TimLen<10){
		echo "<script>javascript:history.back();</script>";
		die();
	}
	
	$CheckUser=mysqli_num_rows($mysqli->query("SELECT * FROM `member` WHERE `user`='".$user."'"));
	$recentTime=time();
	$LastTime=$InfoKey[1];
?>
<!DOCTYPE html>
<html lang="en">
<!--<meta http-equiv="content-type" content="text/html;charset=UTF-8" />--><!-- /Added by HTTrack -->
<head>
  
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NZ Robo Trade Forgot Password</title>
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
	<link rel="manifest" href="/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" href="../assets/images/apple-touch-icon-57-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/images/apple-touch-icon-72-precomposed.png">
    <!-- For iPad Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/images/apple-touch-icon-144-precomposed.png">

    <!-- CORE CSS FRAMEWORK - START -->
    <link href="../assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class=" login_page " style="background:url('image/bitcoin-futures-stockmarket.gif')">

    <div class="container">
        <div class="row">
            
            <div class=" mt-90 col-lg-8 col-lg-offset-2">
                <div class="row">
                    <?php 
						if($recentTime<=$LastTime){
						if($CheckUser>0){
					?>
					<div class="login-wrapper crypto">
                        
                        <div class="col-lg-7 col-sm-12">
                            <div id="login" class="login loginpage mt-0 no-pl no-pr pt30 pb30">    
                                <div class="login-form-header  flex align-items-center">
                                     <img src="../data/crypto-dash/padlock.png" alt="login-icon" style="max-width:64px">
                                     <div class="login-header">
                                         <h4 class="bold" style="color: #dabc48;">Reset Now!</h4>
                                         <h4><small>Enter your New credentials to login.</small></h4>
                                     </div>
                                </div>
                               
                                <div class="box login" style="background-color: #16a8b100!important;">

                                    <div class="content-body" style="padding-top:30px;background-color:#1080881f">

                                        <form id="lWogin-form" action="#" method="POST" novalidate="novalidate" class="no-mb no-mt">
                                            <div class="row"  >
												<h5 id="SignMess" style="display:none;" class="text-center alert alert-success"></h5>
											</div>
                                            <div class="row" id="Sttes1">
                                                <div class="col-xs-12">
                                                   
                                                    <div class="form-group">
                                                        <label class="form-label">New Password</label>
                                                        <div class="controls">
                                                            <input type="password" class="form-control" name="password1" id="password1" placeholder="New Password">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="form-label">Confirm Password</label>
                                                        <div class="controls">
                                                            <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm Password">
                                                        </div>
                                                    </div>
													
													<input type="hidden" id="user_id" value="<?php echo $user; ?>">
                                                    <div class="text-center" id="submit"></div>
                                                    <div class="text-center">
                                                        <button type="button" style="color: #060606;font-size: 29px;background-color: #ccbd70;" id="ForgotPass" class=" btn btn-primary mt-10 btn-corner right-15">Update Password</button>
                                                    </div>
                                                </div>
												
                                            </div>
										
                                        </form>
                                    </div>
                                </div>

                                <p id="nav" class="over-h" style="background: #e6db494d;padding: 5px 20px;">
                                    <a class="pull-left " style="color: #fbfbfb!important;" href="nz-login.html" title="Password Lost and Found">Login</a>
                                    <a class="pull-right " style="color: #fbfbfb!important;" href="nz-register.php" style="color: white !important;" title="Sign Up">Sign Up</a>
                                </p>
								<input type="hidden" id="ClickCount" value="0">
                            </div>
                        </div>
						
						<div class="col-lg-5 col-sm-12 hidden-sm no-padding-left  no-padding-right">
                            <img src="image/4593CEFD-A536-4E40-A310EE023E36BA08_source.jpg" style="height: 276px;margin-top: 34px; margin-left: 6px;" alt="">
                        </div>
                    </div>
						<?php }else{
							echo "<h3 class='alert alert-warning'>Your ID Not Valid</h3>";
							} }else{
								echo "<h3 class='alert alert-warning'>Your Approve Time Expired</h3>";
							}?>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA ENDS -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="../assets/js/jquery-1.11.2.min.js"></script>
    <script>
		document.onkeypress=function(e){if(13==(e=e||window.event).keyCode){e.preventDefault(),e.stopPropagation();let t=Number($("#ClickCount").val());$("#ClickCount").val(1),0==t?$(".LogInStep1").trigger("click"):$("#LogInStep2").trigger("click")}},$(".LogInStep1").on("click",function(e){e.preventDefault(),e.stopPropagation();const t=$("#user_id").val(),s=$("#password").val();$.ajax({method:"GET",url:"/login/login_ssc.php",data:{user_id:t,password:s}}).done(e=>{console.log(e);const t=JSON.parse(e);1==t.sts?($("#MessA").text(t.mess),$("#Sttes2").show(),$("#Sttes1").hide()):$("#submit").html("<h3 class='alert alert-warning'>"+t.mess+"</h3>")})}),$("#LogInStep2").on("click",function(e){e.preventDefault(),e.stopPropagation();const t=$("#user_id").val(),s=$("#secureCode").val();$.ajax({method:"GET",url:"/login/verify.php",data:{user_id:t,secureCode:s}}).done(e=>{const t=JSON.parse(e);1==t.sts?$("#SSDDhg").trigger("click"):$("#submit2").html("<h3 class='alert alert-warning'>"+t.mess+"</h3>")})});let losdf=location.href,usfJk=losdf.split(":"),dfgd=atob(usfJk[2]);if($("#user_id").val(dfgd),""!=dfgd){$.ajax({method:"POST",url:"viewdata/verify_id.php",data:{Usfd:dfgd}})}
	</script>
	<script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/viewport/viewportchecker.js"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
	<script>
		$("#ForgotPass").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			$("#submit").html("");
			let password1=$("#password1").val();
			let password2=$("#password2").val();
			let user_id=$("#user_id").val();
			if(password1!=''){
				if(password1==password2){
					const dfgfd=$.ajax({
						method:"GET",
						url:'viewdata/update_pass.php',
						data:{userdf:user_id,pass1:password1,pass2:password2},
						success:function(ress){
							let erter=JSON.parse(ress);
							if(erter[0]==1){
								$("#submit").html("<h3 class='alert alert-warning'>"+erter[1]+"</h3>");
							}else{
								$("#submit").html("<h3 class='alert alert-warning'>"+erter[1]+"</h3>");
							}
						}
					});
				}else{
					$("#submit").html("<h3 class='alert alert-warning'>Both Password Does Not Match</h3>");
				}
			}else{
				$("#submit").html("<h3 class='alert alert-warning'>Submit Your Password</h3>");
			}
			
		});
	</script>
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS - START -->
    <script src="../assets/js/scripts.js"></script>
	<script src="/login/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="/login/vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LfTCbIUAAAAACb_PpflJsnEXymUtTIYUZY62HrA"></script>
	
    <!-- END CORE TEMPLATE JS - END -->

</body>
</html>