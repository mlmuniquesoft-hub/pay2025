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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
    <link href="../assets/plugins/swiper/swiper.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->
	<!-- Modern Registration Page Styling -->
	<style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .modern-register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header img {
            width: 64px;
            height: 64px;
            margin-bottom: 15px;
        }
        
        .register-header h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .register-header p {
            color: #666;
            font-size: 16px;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }
        
        .required-field {
            color: #dc3545;
        }
        
        .form-control {
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff !important;
            color: #333 !important;
            width: 100%;
            box-sizing: border-box;
        }
        
        /* Only apply appearance none to inputs, not selects */
        input.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
            background: #fff !important;
        }
        
        /* Specific styling for select dropdowns */
        select.form-control {
            background: #fff !important;
            background-image: url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'><path fill='%23666' d='M2 0L0 2h4zm0 5L0 3h4z'/></svg>") !important;
            background-repeat: no-repeat !important;
            background-position: right 15px center !important;
            background-size: 12px !important;
            padding-right: 40px !important;
            height: auto !important;
            min-height: 45px !important;
        }
        
        select.form-control option {
            background: #ffffff !important;
            color: #333333 !important;
            padding: 10px 15px !important;
            border: none !important;
            font-size: 14px !important;
            line-height: 1.4 !important;
            display: block !important;
            width: 100% !important;
        }
        
        select.form-control option:hover {
            background: #f8f9fa !important;
            color: #333333 !important;
        }
        
        select.form-control option:checked,
        select.form-control option:selected {
            background: #667eea !important;
            color: #ffffff !important;
        }
        
        /* Force select visibility */
        #country, #poss {
            background-color: #ffffff !important;
            color: #333333 !important;
            border: 2px solid #e1e8ed !important;
            -webkit-appearance: menulist !important;
            -moz-appearance: menulist !important;
            appearance: menulist !important;
        }
        
        #country option, #poss option {
            background-color: #ffffff !important;
            color: #333333 !important;
            padding: 8px 12px !important;
        }
        
        .form-control.is-valid {
            border-color: #28a745;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .form-control.is-warning {
            border-color: #ffc107;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .sponsor-section {
            background: rgba(102, 126, 234, 0.05);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .sponsor-section .form-label {
            color: #667eea;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }
        
        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }
        
        .validation-feedback {
            font-size: 12px;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        
        .validation-success {
            color: #28a745;
        }
        
        .validation-error {
            color: #dc3545;
        }
        
        .validation-warning {
            color: #ffc107;
        }
        
        .validation-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .position-info {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo-container img {
            max-height: 50px;
            width: auto;
        }
        
        .links-section a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .links-section a:hover {
            color: #764ba2;
            text-decoration: none;
        }
        
        .terms-link {
            color: #667eea !important;
            font-size: 18px;
            text-decoration: underline;
        }
        
        .terms-link:hover {
            color: #764ba2 !important;
        }
        
        #Mess {
            margin: 15px 0;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .register-card {
                padding: 30px 20px;
                margin: 10px;
                max-width: 95%;
            }
            
            .register-header h2 {
                font-size: 24px;
            }
            
            .form-control {
                padding: 10px 12px;
            }
        }
        
        /* Hide old styling */
        .login-wrapper, .box.login, .content-body {
            display: none;
        }
        
        /* Ensure dropdown visibility */
        .register-card {
            position: relative;
            z-index: 1;
        }
        
        select.form-control {
            position: relative;
            z-index: 10;
        }
        
        /* Fix for dropdown options visibility */
        select option {
            background-color: #ffffff !important;
            color: #333333 !important;
            padding: 10px !important;
            font-size: 14px !important;
        }
        
        /* Ensure select dropdown is clickable */
        .form-group select {
            cursor: pointer;
        }
        
        /* Additional select styling for better visibility */
        select.form-control::-ms-expand {
            display: none;
        }
        
        .form-control[multiple], .form-control[size] {
            height: auto;
        }
	</style>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login_page login-bg">
	 <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#000;">Welcome to Capitol Money Pay</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style='color:#000'>Welcome to Capitol Money Pay! 🚀<br/>
We're excited to have you join our investment community. Our platform provides cutting-edge trading technology and investment opportunities for modern investors.</p>
		  <p style='color:#000'><strong>Important Information:</strong><br/>
Dear investors, Capitol Money Pay is committed to providing you with secure and profitable investment opportunities. Our platform operates with advanced trading algorithms and comprehensive risk management systems. All investments are processed through secure channels with full transparency.</p>
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
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;">Mail Verification is Mandatory Within Next 48 Hours Of Registration.</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;">Free Joining, The First Time You Start A Plan, $10 Is Paid As A System Service For Life Time. There is No Second Chance To Purchase A Smaller Plan Than The Purchased Plan.</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Withdraw:</strong><br/>
					Fund Transfer Account To Account (P2P) Instant. Convert USD To BTC(Bitcoin) Minimum Withdrawal USD 50.00 With 8% Transaction Fee, Maximum Withdrawal For Each Day $3000.00/$5000.00 In Terms Of Appeal. Weekly, Monday Fund Will Be Transfered To Account Holders Requesting Address.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Daily Earning:</strong><br/>
					Be Active After Bought The Product, Investment Trading Earning Will Get Daily Return Up To 2.65%. All Earning Will Be Transfered To Account Balance From Monday To Friday.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Sponsor Honor:</strong><br/>
					6% To 10% Unlimited Daily. It Will Be Real Time Payout.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Binary Bonus:</strong><br/>
					You Are Required To Sponsor At Least One Activation To Get a Pairing Bonus 10% From Smaller Side.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Generation Bonus:</strong><br/>
					Active Account Will Get Reschedule Gain Generation Bonus(Matching Profit). Earn Generation Bonus Up To 12% From 12 Level.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Global Profit Sharing (GPS):</strong><br/>
					Buy Minimum Investment 3000 Since Then You Can Received Global Profit Sharing(GPS) From All Across The World. GPS Is Gain By Companies Source Of Income Will Be Paid According To Its Rules. The Holiday Will Be Credited As A Todays Working Profit Transfer To The Trading Earning Side Of Company.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Upgrade:</strong><br/>
					Every Upgrade Can Be Done By Purchasing The Bigger Plan From Your Initial Plan.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;"><strong>Renew:</strong><br/>
					Estimated You Will Get Approximate 400% Earning From The Activation Plan. You Will Need To Update To The Next Plan After The Plan Is Complete. You Can See The Plan Change Warning Also A Notification Alert Receive To Requested Mail.
				</p>
				<p style="color: rgba(255, 255, 255, 0.9); background: rgba(255, 255, 255, 0.1); padding: 10px; border-radius: 8px; margin: 10px 0;">Investment Trading Technology Is Higher Level Security, Cost Efficient, Energy Saving, P2P Quick Transaction.</p>
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
	
	<!-- Main Registration Container -->
    <div class="modern-register-container">
        <div class="register-card">
            <!-- Logo Section -->
            <div class="logo-container">
                <img src="/assets/images/cmp-logo.svg" alt="Capitol Money Pay" />
            </div>
            
            <!-- Registration Header -->
            <div class="register-header">
                <img src="../data/crypto-dash/signup.png" alt="signup-icon">
                <h2>Create Your Account</h2>
                <p>Join Capitol Money Pay today and start investing</p>
            </div>
            
            <!-- Registration Form -->
            <form id="signup-form" action="#" novalidate="novalidate" class="no-mb no-mt">
				
				<div id="Mess"></div>
				
				<?php
					if(isset($_GET['keys'])){
						$UserId=explode("/", base64_decode($_GET['keys']));
				?>
				<div class="sponsor-section">
					<div class="form-group">
						<label class="form-label">Sponsor ID <span class="required-field">*</span></label>
						<div class="controls">
							<input type="text" class="form-control" value="<?php echo $UserId[1]; ?>" name="sponsor_id" id="sponsor_id" placeholder="Enter Sponsor ID" required />
							<div id="sponsor_id_feedback" class="validation-feedback"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="form-label">Position <span class="required-field">*</span></label>
						<div class="controls">
							<select class="form-control" name="poss" id="poss" required>
								<option value="">-- Please Select Position --</option>
								<option value="1" <?php echo ($UserId[2] == '1') ? 'selected' : ''; ?>>Left (1)</option>
								<option value="2" <?php echo ($UserId[2] == '2') ? 'selected' : ''; ?>>Right (2)</option>
							</select>
							<div class="position-info">Choose left or right position in your sponsor's tree</div>
						</div>
					</div>
				</div>
					<?php }else{ ?>
					<div class="sponsor-section">
						<div class="form-group">
							<label class="form-label">Sponsor ID <span class="required-field">*</span></label>
							<div class="controls">
								<input type="text" class="form-control" name="sponsor_id" id="sponsor_id" placeholder="Enter Sponsor ID" required />
								<div id="sponsor_id_feedback" class="validation-feedback"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="form-label">Position <span class="required-field">*</span></label>
							<div class="controls">
								<select class="form-control" name="poss" id="poss" required>
									<option value="">-- Please Select Position --</option>
									<option value="1">Left (1)</option>
									<option value="2">Right (2)</option>
								</select>
								<div class="position-info">Choose left or right position in your sponsor's binary tree</div>
							</div>
						</div>
					</div>
					<?php } ?>
				
				<div class="form-group">
					<label class="form-label">Full Name <span class="required-field">*</span></label>
					<div class="controls">
						<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Enter your full name" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Email <span class="required-field">*</span></label>
					<div class="controls">
						<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
						<div id="email_feedback" class="validation-feedback"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Country <span class="required-field">*</span></label>
					<div class="controls">
						<select class="form-control" name="country" id="country" required>
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
					<label class="form-label">Phone Number <span class="required-field">*</span></label>
					<div class="controls">
						<input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone number" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Username <span class="required-field">*</span></label>
					<div class="controls">
						<input type="text" class="form-control" name="log_id" id="log_id" placeholder="Choose a username" required>
						<div id="log_id_feedback" class="validation-feedback"></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Password <span class="required-field">*</span></label>
					<div class="controls">
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Confirm Password <span class="required-field">*</span></label>
					<div class="controls">
						<input type="password" class="form-control" name="re_password" id="re_password" placeholder="Confirm password" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-label">Transaction Code <span class="required-field">*</span></label>
					<div class="controls">
						<input type="password" class="form-control" name="Password_tr" id="Password_tr" placeholder="Set transaction code" required>
					</div>
				</div>
				
				<div class="form-group" style="text-align: center; margin-bottom: 20px;">
					<input type="checkbox" style="display:none;" name="terms" id="terms" value='1' />
					<span id="ssd" style="color:#333; font-weight: 500;"> Accept</span> 
					<a href="#" id="consHG" data-toggle="modal" data-target="#exampleModalLong" class="terms-link">Terms & Conditions</a>
				</div>
				
				<div class="text-center">
					<button type="button" id="submitTest" class="btn btn-primary">Create Account</button>
					<button id="submit" style="display:none" class="btn btn-primary">Create Account</button>
				</div>
				
				<!-- Links Section -->
				<div class="links-section" style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e1e8ed;">
					<p style="color: #666; margin: 0;">
						Already have an account? 
						<a href="nz-login.html">Login here</a>
					</p>
				</div>
            </form>
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
    <script src="../assets/plugins/swiper/swiper.js"></script>
    <script>
        window.jQuery || document.write('<script src="../assets/js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <script>
		// Force select dropdown visibility
		$(document).ready(function() {
			// Ensure select elements are visible and functional
			$("#country, #poss").each(function() {
				$(this).css({
					'background-color': '#ffffff',
					'color': '#333333',
					'border': '2px solid #e1e8ed',
					'appearance': 'menulist',
					'-webkit-appearance': 'menulist',
					'-moz-appearance': 'menulist'
				});
			});
			
			// Add click handler for better debugging
			$("#country, #poss").on('click focus', function() {
				console.log('Select clicked:', $(this).attr('id'));
				console.log('Options count:', $(this).find('option').length);
			});
		});
		
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
			
			// Check if all required fields are valid
			let isFormValid = true;
			let errorMessage = "";
			
			// Check sponsor ID
			if(!$("#sponsor_id").hasClass("is-valid") && $("#sponsor_id").val().trim() !== "") {
				isFormValid = false;
				errorMessage = "Please enter a valid Sponsor ID";
			} else if($("#sponsor_id").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Sponsor ID is required";
			}
			
			// Check username
			if(!$("#log_id").hasClass("is-valid") && $("#log_id").val().trim() !== "") {
				isFormValid = false;
				errorMessage = "Please enter a valid Username";
			} else if($("#log_id").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Username is required";
			}
			
			// Check email
			if(!$("#email").hasClass("is-valid") && $("#email").val().trim() !== "") {
				isFormValid = false;
				errorMessage = "Please enter a valid Email";
			} else if($("#email").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Email is required";
			}
			
			// Check other required fields
			if($("#full_name").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Full Name is required";
			}
			
			if($("#poss").val() === "") {
				isFormValid = false;
				errorMessage = "Please select a position (Left or Right)";
			}
			
			if($("#password").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Password is required";
			}
			
			if($("#re_password").val().trim() === "") {
				isFormValid = false;
				errorMessage = "Confirm Password is required";
			}
			
			if($("#password").val() !== $("#re_password").val()) {
				isFormValid = false;
				errorMessage = "Passwords do not match";
			}
			
			if(!isFormValid) {
				$("#Mess").text(errorMessage);
				$("#Mess").css("color","#f54242");
				$("#Mess").css("font-size","18px");
				return;
			}
			
			let dfgfd=$("#terms:checked").val();
			if(dfgfd==1){
				if(dfgd==1){
					$("#submit").trigger("click");
					$("#Mess").text("Processing registration...");
					$("#Mess").css("color","#28a745");
					$("#Mess").css("font-size","18px");
				}else{
					$("#consHG").trigger("click");
					$("#Mess").text("Read Terms & Condition");
					$("#Mess").css("color","#f54242");
					$("#Mess").css("font-size","18px");
				}
			}else{
				$("#consHG").trigger("click");
				$("#Mess").text("Accept Terms & Condition");
				$("#Mess").css("color","#f54242");
				$("#Mess").css("font-size","18px");
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
			let user = $(this).val();
			let $field = $(this);
			let $feedback = $("#log_id_feedback");
			
			if(user.length === 0) {
				$field.removeClass("is-valid is-invalid is-warning");
				$feedback.html("");
				return;
			}
			
			if(user.length < 4) {
				$field.removeClass("is-valid is-warning").addClass("is-invalid");
				$feedback.html("Minimum 4 characters required").removeClass("validation-success validation-warning").addClass("validation-error");
				return;
			}
			
			// Show loading spinner
			$feedback.html('<span class="validation-spinner"></span> Checking availability...');
			$field.removeClass("is-valid is-invalid is-warning");
			
			// Debounced AJAX call
			clearTimeout(window.usernameTimeout);
			window.usernameTimeout = setTimeout(function() {
				$.ajax({
					method: "GET",
					url: "viewdata/checkuserd.php",
					data: {dfgfd: user},
					dataType: "json"
				}).done(function(response) {
					if(response.sts === 'error') {
						$field.removeClass("is-valid is-warning").addClass("is-invalid");
						$feedback.html(response.mess).removeClass("validation-success validation-warning").addClass("validation-error");
					} else {
						$field.removeClass("is-invalid is-warning").addClass("is-valid");
						$feedback.html(response.mess || "Username is available").removeClass("validation-error validation-warning").addClass("validation-success");
					}
				}).fail(function() {
					$field.removeClass("is-valid is-warning").addClass("is-invalid");
					$feedback.html("Error checking username").removeClass("validation-success validation-warning").addClass("validation-error");
				});
			}, 500); // 500ms delay
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
						data:{user:userd,name:full_name,email:email}
					});
					redfg.done(function(ress){
						let dfg=JSOn.parse(ress);
						$("#Mess").before('<h3 style="color:#3c3535;" class="alert alert-warning text-center Ertyy">'+dfg.mess+"</h3>");
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
	<script src="js/signup.js?v=<?php echo time(); ?>"></script>
	<script >
		$(".shfsd").on("click", function(){
			let dfgfd=$(this).val();
			if(dfgfd==2){
				$("#sponsor_id").val("5911051");
				$("#sponsor_id").attr("type","password");
				$("#sponsor_id").attr("readonly", true);
				$("#poss").val("1");
				$("#poss").attr("disabled", true);
				$("#POssd").hide();
			}else{
				$("#sponsor_id").val("");
				$("#sponsor_id").attr("type","text");
				$("#sponsor_id").attr("readonly", false);
				$("#poss").attr("disabled", false);
				$("#POssd").show();
			}
		});
		
		// Add sponsor ID validation
		$("#sponsor_id").on("blur keyup", function(){
			let sponsorId = $(this).val().trim();
			let $field = $(this);
			let $feedback = $("#sponsor_id_feedback");
			
			if(sponsorId.length === 0) {
				$field.removeClass("is-valid is-invalid is-warning");
				$feedback.html("");
				return;
			}
			
			// Show loading spinner
			$feedback.html('<span class="validation-spinner"></span> Validating sponsor...');
			$field.removeClass("is-valid is-invalid is-warning");
			
			// Debounced AJAX call for sponsor validation
			clearTimeout(window.sponsorTimeout);
			window.sponsorTimeout = setTimeout(function() {
				$.ajax({
					method: "GET",
					url: "viewdata/validate_sponsor.php",
					data: {sponsor_id: sponsorId},
					dataType: "json",
					timeout: 10000 // 10 second timeout
				}).done(function(response) {
					console.log("Sponsor validation response:", response); // Debug log
					if(response.status === 'error') {
						$field.removeClass("is-valid is-warning").addClass("is-invalid");
						$feedback.html(response.message).removeClass("validation-success validation-warning").addClass("validation-error");
					} else if(response.status === 'warning') {
						$field.removeClass("is-valid is-invalid").addClass("is-warning");
						$feedback.html(response.message).removeClass("validation-success validation-error").addClass("validation-warning");
					} else {
						$field.removeClass("is-invalid is-warning").addClass("is-valid");
						$feedback.html(response.message).removeClass("validation-error validation-warning").addClass("validation-success");
					}
				}).fail(function(xhr, status, error) {
					console.error("Sponsor validation failed:", {xhr: xhr, status: status, error: error}); // Debug log
					$field.removeClass("is-valid is-warning").addClass("is-invalid");
					let errorMsg = "Error validating sponsor";
					if(status === 'timeout') errorMsg = "Request timeout - check connection";
					if(xhr.responseText) errorMsg = "Server error: " + xhr.responseText.substring(0, 50);
					$feedback.html(errorMsg).removeClass("validation-success validation-warning").addClass("validation-error");
				});
			}, 300); // 300ms delay for sponsor
		});
		
		// Add email validation
		$("#email").on("blur keyup", function(){
			let email = $(this).val().trim();
			let $field = $(this);
			let $feedback = $("#email_feedback");
			
			if(email.length === 0) {
				$field.removeClass("is-valid is-invalid is-warning");
				$feedback.html("");
				return;
			}
			
			// Basic email format check first
			let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if(!emailRegex.test(email)) {
				$field.removeClass("is-valid is-warning").addClass("is-invalid");
				$feedback.html("Invalid email format").removeClass("validation-success validation-warning").addClass("validation-error");
				return;
			}
			
			// Show loading spinner
			$feedback.html('<span class="validation-spinner"></span> Checking email...');
			$field.removeClass("is-valid is-invalid is-warning");
			
			// Debounced AJAX call for email validation
			clearTimeout(window.emailTimeout);
			window.emailTimeout = setTimeout(function() {
				$.ajax({
					method: "GET",
					url: "viewdata/validate_email.php",
					data: {email: email},
					dataType: "json",
					timeout: 10000 // 10 second timeout
				}).done(function(response) {
					console.log("Email validation response:", response); // Debug log
					if(response.status === 'error') {
						$field.removeClass("is-valid is-warning").addClass("is-invalid");
						$feedback.html(response.message).removeClass("validation-success validation-warning").addClass("validation-error");
					} else {
						$field.removeClass("is-invalid is-warning").addClass("is-valid");
						$feedback.html(response.message).removeClass("validation-error validation-warning").addClass("validation-success");
					}
				}).fail(function(xhr, status, error) {
					console.error("Email validation failed:", {xhr: xhr, status: status, error: error}); // Debug log
					$field.removeClass("is-valid is-warning").addClass("is-invalid");
					let errorMsg = "Error checking email";
					if(status === 'timeout') errorMsg = "Request timeout - check connection";
					if(xhr.responseText) errorMsg = "Server error: " + xhr.responseText.substring(0, 50);
					$feedback.html(errorMsg).removeClass("validation-success validation-warning").addClass("validation-error");
				});
			}, 500); // 500ms delay for email
		});
		
		// Position field interaction
		$("#sponsor_id").on("input", function(){
			let sponsorId = $(this).val();
			if(sponsorId && sponsorId.length > 0) {
				$("#poss").prop("disabled", false);
			} else {
				$("#poss").prop("disabled", true);
				$("#poss").val(""); // Reset to default option
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