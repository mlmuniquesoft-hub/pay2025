<?php
	session_start();
	$_SESSION['token']="dfgdfgdf";
	require_once("../db/db.php");
	if(isset($_GET['uuss'])){
		$counrt=$_GET['uuss'];
		$InfoCountry=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `country` WHERE `name`='".$counrt."'"));
		echo $InfoCountry['calling_code'];
		die();
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta property="og:title" content="Capitol Money Pay Signup">
	<meta property="og:description" content="Capitol Money Pay Best Place For Your Fixed Earning With Robot">
	<meta property="og:image" content="https://capitolmoneypay.com/assets/images/cmp-logo.svg">
	<meta property="og:url" content="https://capitolmoneypay.com/member/nz-register.php">
	<meta name="twitter:card" content="https://capitolmoneypay.com/assets/images/cmp-logo.svg">
    <meta property="og:site_name" content="Capitol Money Pay">
	<meta name="twitter:image:alt" content="Capitol Money Pay">
	
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Capitol Money Pay Signup</title>
    <meta content="Capitol Money Pay Best Place For Your Fixed Earning With Robot" name="description" />
    <meta content="Capitol Money Pay" name="author" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon/cmp-icon.svg">
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
    <link href="../assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->
	<style>
		.error{
			color:#f55a0e;
		}
		
		::-webkit-input-placeholder { /* Edge */
		  color: red;
		}

		:-ms-input-placeholder { /* Internet Explorer */
		  color: red;
		}

		::placeholder {
		  color: red;
		}
		
	</style>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class=" login_page login-bg" style="background-image:url('image/140132_Cover.png')!important;background-repeat: repeat!important;">
	 <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#000;">Important Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style='color:#000'>Hi Everyone, 😃 <br/>
The COVID19 Pandemic is disrupting businesses everywhere. People are observing self-isolation in government-imposed lockdowns to keep everyone safe. Many industries have adapted to these new changes and we believe that Digital Technology will play a strong part in the current scenario. 🌐</p>
		  <p style='color:#000'>*_Important announcement:*_ <br/>
Dear traders,The Covid-19 has wreaked havoc on lives and livelihoods around the world.Status is running.We are sincerely sorry that all our activities including trading were stopped due to the Covid-19. In this case, all traders are 100% safe.As per the decision of the company, all the activities of In the first week of June 2020 are going to be resumed for the information of the successful traders considering the past and present times.The company is committed to work with a long-term plan to manage the business activities of traders.Your cooperation is highly desirable.Follow the rules of the World Health Organization and stay safe.</p>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button style="display:none;" id="LunchModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  
</button>
	
	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header" style="display:none;">
			<h5 class="modal-title" id="exampleModalLongTitle" style="color:#000;">Term & Condition</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="width:100%;min-height:100vh;color:#000;background-image:url('image/term_bg.jpg')">
				<div style="background: #23202080;padding: 17px;">
				<h2 style="color:#fff240;">Terms & Condition</h2>
				<p style="color:#fff240;">Mail Verification is Mandatory Within Next 48 Hours Of Registration.</p>
				<p style="color:#fff240;">Free Joining, The First Time You Start A Plan, $10 Is Paid As A System Service For Life Time.There is No Second Chance To Purchase A Smaller Plan Than The Purchased Plan.</p>
				<p style="color:#fff240;">Withdraw: <br/>
					Fund Transfer Account To Account (P2P) Instant. Convert USD To BTC(Bitcoin) Minimum Withdrawal USD 50.00 With 8% Transaction Fee, Maximum Withdrawal For Each Day $3000.00/$5000.00 In Terms Of Appeal. Weekly, Monday Fund Will Be Transfered To Account Holders Requesting Address.
				</p>
				<p style="color:#fff240;">Daily Earning:<br/>
					Be Active After Bought The Product, D.Bot Trading Earning Will Get Daily Return Up To 2.65%. All Earning Will Be Transfered To Account Balance From Monday To Friday.

				</p>
				<p style="color:#fff240;">Sponsor Honor:<br/>
					6% To 10% Unlimited Daily. It Will Be Real Time Payout.
				</p>
				<p style="color:#fff240;">Binary Bonus:<br/>
					You Are Required To Sponsor At Least One Activation To Get a Pairing Bonus 10% From Smaller Side. 

				</p>
				<p style="color:#fff240;">Generation Bonus:<br/>
					Active Account Will Get Reschedule Gain Generation Bonus(Matching Profit). Earn Generation Bonus Up To 12% From 12 Level.
				</p>
				<p style="color:#fff240;">Global Profit Sharing (GPS):<br/>
					Buy Minimum D.Bot 3000 Since Then You Can Received Global Profit Sharing(GPS) From All Across The World. GPS Is Gain By Companies Source Of Income Will Be Paid According To Its Rules. The Holiday Will Be Credited As A Todays WOrking Profit Transfer To The Trading Earning Side Of Company.
				</p>
				<p style="color:#fff240;">Upgrade:<br/>
					Every Upgrade Can Be Done By Purchasing The Bigger Plan From Your Initial Plan.
				</p>
				<p style="color:#fff240;">Renew:<br/>
					Estimated You Will Get Approximate 400% Earning From The Activation Plan.You WIll Need To Update To The Next Plan After The Plan Is Complete. You Can See The Plan Change Warning Also A Notification Alert Receive To Requested Mail.
				</p>
				<p style="color:#fff240;">Bot Trading Technology Is Higher Level Security, Cost Efficient, Energy Saving, P2P Quick Transaction.</p>
				<p style="color:#fff240;">
					Pormise:<br/>
						I'm An Adult. I Know Such Site Are In Danger, Interested In Working In Compliance With Obligation. 
				</p>
				
				</div>
		  </div>
		  <div class="modal-footer" style="background: #d2ce26;">
			<button type="button" style="color: #020101;" id="closeSS" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" style="background: #0c87bf;" class="btn btn-info" id="Accept">Accept</button>
		  </div>
		</div>
	  </div>
	</div>
    <div class="container">
        <div class="row">
            
            <div class=" mt-90 col-lg-8 col-lg-offset-2">
                <div class="row">
                    <div class="login-wrapper crypto" style="background: #25239024!important;">
                        <div class="col-lg-6 col-sm-12 over-h hidden-sm no-padding-left  no-padding-right">
                            <img src="../image/200w.webp" style="width: 100%;height: 795px;margin-top: 71px;margin-left: 10px;" alt="">
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div id="login" class="login loginpage mt-0 no-pl no-pr pt30 pb30">    
                                <div class="login-form-header flex align-items-center">
                                     <img src="../data/crypto-dash/signup.png" alt="login-icon" style="max-width:64px">
                                     <div class="login-header">
                                         <h4 class="bold" style="color: #dcb413;">Signup Now!</h4>
                                         <h4><small>Enter your data to register.</small></h4>
                                     </div>
                                </div>
                               
                                <div class="box login" style="background-color: #16a8b100 !important;">

                                    <div class="content-body" style="background-color: #16a8b100 !important">

                                        <form id="signup-form" action="#" novalidate="novalidate" class="no-mb no-mt">
                                            <div class="row">
                                                <div class="col-xs-12">
													<div class="form-group" style="display:none;">
														<label >Do You Have Sponsor ID</label>
														<input type='radio' class="shfsd" name="sponn" value='1' checked /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
														<input type='radio' class="shfsd" name="sponn" value='2'/> No
													</div>
													<?php
														if(isset($_GET['keys'])){
															$UserId=explode("/", base64_decode($_GET['keys']));
														} else {
															$UserId = array('', ''); // Default empty values
														}
													?>
                                                    <div class="form-group">
                                                        <label class="form-label">Sponsor ID</label>
                                                        <div class="controls">
                                                            <input type="text" class="form-control" value="<?php echo $UserId[1]; ?>" name="sponsor_id" id="sponsor_id" placeholder="Sponsor ID" />
                                                            <span id="SponsorError" style="color: red; font-size: 12px;"></span>
                                                        </div>
                                                    </div>
													<input type='hidden' name="poss" value='<?php if($UserId[2]!=''){echo $UserId[2];}else{echo 1;} ?>'  />
														<?php //}else{ ?>
														<!--<input type="hidden" value="<?php //echo 'robotrade'; ?>" name="sponsor_id" id="sponsor_id" />
														<input type='hidden' name="poss" value='1'  />-->
														<?php //} ?>
													
													<div class="form-group">
                                                        <label class="form-label">Full Name</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="text" class="form-control" name="full_name"  id="full_name" placeholder="Full Name">
                                                        </div>
                                                    </div>
													
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="text" class="form-control" name="email" id="email" placeholder="Email">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="form-label">Country</label>
                                                        <div class="controls">
                                                            <select class="form-control" name="country" id="country" style="background-color: #e7ebf5;">
																<option value=''>Select Your Country</option>
																<?php
																	$kljfgs=$mysqli->query("SELECT * FROM `country`");
																	while($askdja=mysqli_fetch_assoc($kljfgs)){
																?>
																<option><?php echo $askdja['name']; ?></option>
																<?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="form-label">Phone Number</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="form-label">User Name</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="text" class="form-control" name="log_id" id="log_id" placeholder="User Name">
															<p id="UserError" style="color:#f55a0e;" class="text-center text-danger"></p>
                                                        </div>
                                                    </div>
													
                                                    <div class="form-group">
                                                        <label class="form-label">Password</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Confirm Password</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="password" class="form-control" name="re_password" id="re_password" placeholder="Confirm Password">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="form-label">Set Transaction Code</label>
                                                        <div class="controls">
                                                            <input style="background-color: #e7ebf5;" type="password" class="form-control" name="Password_tr" id="Password_tr" placeholder="Set Transaction Code">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <input type="checkbox" style="display:none;" name="terms" id="terms" value='1'  /><span id="ssd" style="color:#FFF"> Accept</span> <a href="#" id="consHG" data-toggle="modal" data-target="#exampleModalLong" style="color:#fff240;font-size:22px;">Terms & Condition</a>
                                                    </div>
													
													<input type="hidden" id="ctads" name="capths" />
                                                    <div class="text-center" id="Mess">
														
													</div>
                                                    <div class="text-center">
                                                        <button type="button" id="submitTest" class="btn btn-primary mt-10 btn-corner right-15">Sign up</button>
                                                        <button id="submit" style="display:none" class="btn btn-primary mt-10 btn-corner right-15">Sign up</button>
                                                        <a href="nz-login.html" style="background:#d2cd19" class="btn mt-10 btn-corner signup">Login</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA ENDS -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="../assets/js/jquery-1.11.2.min.js"></script>
    <script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/viewport/viewportchecker.js"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <script>
		let dfgd=0;
		$("#Accept").on("click", function(){
			dfgd=1;
			$("#closeSS").trigger("click");
			$("#terms").show();
			$("#terms").attr("checked","checked");
			$("#consHG").css("color","white");
		});
		$("#submitTest").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			
			// Validate sponsor ID and username before submission
			let sponsor_id = $("#sponsor_id").val().trim();
			let username = $("#log_id").val().trim();
			let hasErrors = false;
			
			// Check sponsor ID
			if(sponsor_id === '') {
				$("#SponsorError").text("Sponsor ID is required");
				$("#SponsorError").css("color", "red");
				hasErrors = true;
			} else if($("#SponsorError").text().includes("does not exist") || $("#SponsorError").text().includes("Server error")) {
				hasErrors = true;
			}
			
			// Check username
			if(username === '') {
				$("#UserError").text("Username is required");
				$("#UserError").css("color", "red");
				hasErrors = true;
			} else if($("#UserError").text().includes("already taken") || $("#UserError").text().includes("Server error")) {
				hasErrors = true;
			}
			
			if(hasErrors) {
				$("#Mess").text("Please fix validation errors before submitting");
				$("#Mess").css("color","red");
				$("#Mess").css("font-size","18px");
				return false;
			}
			
			let dfgfd=$("#terms:checked").val();
			if(dfgfd==1){
				if(dfgd==1){
					$("#submit").trigger("click");
					//$("#Mess").text("Please, Try Later");
					$("#Mess").css("color","#f54242");
					$("#Mess").css("font-size","22px;");
					//counnb();
				}else{
					$("#consHG").trigger("click");
					$("#Mess").text("Read Terms & Condition");
					$("#Mess").css("color","#f54242");
					$("#Mess").css("font-size","22px;");
				}
			}else{
				$("#consHG").trigger("click");
				$("#Mess").text("Accept Terms & Condition");
				$("#Mess").css("color","#f54242");
				$("#Mess").css("font-size","22px;");
			}
			
		});
		$("#country").on("change", function(){
			let dfgfd2=$(this).val();
			const dfgfd=$.ajax({
				method:"GET",
				url:'',
				data:{uuss:dfgfd2}
			})
			dfgfd.done((edf)=>{
				$("#phone_number").val(edf);
			});
		});
		$("#log_id").on("keyup", function(){
			let user=$(this).val();
			if(user!=''){
				const redf=$.ajax({
					method:"GET",
					url:"./viewdata/checkuserd.php",
					data:{dfgfd:user},
					dataType: "json",
					timeout: 10000
				});
				redf.done((redd)=>{
					try {
						// Check if response is already an object
						let dfgdf = (typeof redd === 'object') ? redd : JSON.parse(redd);
						if(dfgdf['sts']=='error'){
							$(this).parent().addClass("has-error");
							$("#UserError").text(dfgdf['mess']);
							$("#UserError").css("color","red");
						}else{
							$("#UserError").text(dfgdf['mess']);
							$("#UserError").css("color","green");
							$(this).parent().removeClass("has-error");
						}
					} catch(e) {
						console.error("JSON Parse Error:", e);
						console.log("Response received:", redd);
						$("#UserError").text("Server error occurred");
						$("#UserError").css("color","red");
					}
				}).fail(function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
					console.log("XHR:", xhr);
					$("#UserError").text("Connection error: " + status);
					$("#UserError").css("color","red");
				});
			}
		});
		
		// Sponsor ID validation
		$("#sponsor_id").on("keyup blur", function(){
			let sponsor_id = $(this).val().trim();
			if(sponsor_id != ''){
				const sponsorAjax = $.ajax({
					method: "GET",
					url: "./viewdata/checksponsor.php",
					data: {sponsor_id: sponsor_id},
					dataType: "json",
					timeout: 10000
				});
				sponsorAjax.done((response) => {
					try {
						// Check if response is already an object
						let result = (typeof response === 'object') ? response : JSON.parse(response);
						if(result['sts'] == 'error'){
							$("#SponsorError").text(result['mess']);
							$("#SponsorError").css("color", "red");
							$(this).parent().addClass("has-error");
						} else if(result['sts'] == 'warning'){
							$("#SponsorError").text(result['mess']);
							$("#SponsorError").css("color", "orange");
							$(this).parent().removeClass("has-error");
						} else {
							$("#SponsorError").text(result['mess']);
							$("#SponsorError").css("color", "green");
							$(this).parent().removeClass("has-error");
						}
					} catch(e) {
						console.error("JSON Parse Error:", e);
						console.log("Response received:", response);
						$("#SponsorError").text("Server error occurred");
						$("#SponsorError").css("color", "red");
					}
				}).fail(function(xhr, status, error) {
					console.error("AJAX Error:", status, error);
					console.log("XHR:", xhr);
					$("#SponsorError").text("Connection error: " + status);
					$("#SponsorError").css("color", "red");
				});
			} else {
				$("#SponsorError").text("");
				$(this).parent().removeClass("has-error");
			}
		});
		
		const counnb=()=>{
			let timer=50;
			let dfgd=setInterval(function(){
				let dfdf=timer--;
				if(dfdf>=0){
					$("#countr").text(dfdf);
				}else{
					clearInterval(dfgd);
					$("#countr").html("<button type='button' class='btn btn-warning' id='ResendMail'>Resend</button>");
					dfghd();
				}
				
				console.log(dfdf);
			},1000);
		}
		const dfghd=()=>{
			$("#ResendMail").on("click", function(e){
				e.preventDefault();
				e.stopPropagation();
				
				let userd=$("#log_id").val();
				let full_name=$("#full_name").val();
				let email=$("#email").val();
				if(email!=''){
					const redfg=$.ajax({
						method:"GET",
						url:"/login/resend_signup.php",
						data:{user:userd,name:full_name,email:email},
						dataType: "json"
					});
					redfg.done(function(ress){
						try {
							// Check if response is already an object
							let dfg = (typeof ress === 'object') ? ress : JSON.parse(ress);
							$("#Mess").before('<h3 style="color:#3c3535;" class="alert alert-warning text-center Ertyy">'+dfg.mess+"</h3>");
						} catch(e) {
							console.error("JSON Parse Error:", e);
							console.log("Response received:", ress);
							$("#Mess").before('<h3 style="color:red;" class="alert alert-danger text-center">Server error occurred</h3>');
						}
					}).fail(function(xhr, status, error) {
						console.error("AJAX Error:", status, error);
						$("#Mess").before('<h3 style="color:red;" class="alert alert-danger text-center">Connection error occurred</h3>');
					});
				}else{
					$("#Mess").text("Submit Your Email");
					$("#Mess").css("color","#f54242");
					$("#Mess").css("font-size","22px;");
				}
			});
		}
		
		
    </script>
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS - START -->
   
	<script src="/login/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="/login/vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <!-- reCAPTCHA disabled for localhost development -->
    <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LfTCbIUAAAAACb_PpflJsnEXymUtTIYUZY62HrA"></script> -->
	<script src="js/signup.js"></script>
	<script >
		$(".shfsd").on("click", function(){
			let dfgfd=$(this).val();
			if(dfgfd==2){
				$("#sponsor_id").val("5911051");
				$("#sponsor_id").attr("type","password");
				$("#POssd").hide();
			}else{
				$("#sponsor_id").val("");
				$("#sponsor_id").attr("type","text");
				$("#POssd").show();
			}
		});
	</script>
	 <script  >
		//$("#LunchModal").trigger("click");
	  </script>
    <!-- END CORE TEMPLATE JS - END -->
 <script src="../assets/js/scripts.js"></script>
</body>

</html>