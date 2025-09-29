<?php
	$message='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Verify Your Account - Capitol Money Pay</title>
	  <style>
		@import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
		
		body {
			margin: 0;
			padding: 0;
			font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: #333;
		}
		
		.email-container {
			max-width: 600px;
			margin: 20px auto;
			background: #ffffff;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			overflow: hidden;
		}
		
		.header {
			background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
			padding: 40px 30px;
			text-align: center;
			color: white;
		}
		
		.logo {
			width: 60px;
			height: 60px;
			margin: 0 auto 15px;
			background: rgba(255, 255, 255, 0.2);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.logo img {
			width: 40px;
			height: 40px;
			border-radius: 50%;
		}
		
		.header-title {
			font-size: 24px;
			font-weight: 700;
			margin: 0;
			text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}
		
		.header-subtitle {
			font-size: 14px;
			font-weight: 400;
			margin: 8px 0 0 0;
			opacity: 0.9;
		}
		
		.content {
			padding: 40px 30px;
			text-align: center;
		}
		
		.greeting {
			font-size: 22px;
			font-weight: 600;
			color: #2d3748;
			margin: 0 0 20px 0;
		}
		
		.intro-text {
			font-size: 16px;
			color: #4a5568;
			line-height: 1.6;
			margin: 0 0 30px 0;
		}
		
		.user-id-box {
			background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
			border-radius: 15px;
			padding: 25px;
			margin: 30px 0;
			border-left: 4px solid #48bb78;
			text-align: center;
		}
		
		.user-id-label {
			font-size: 14px;
			color: #4a5568;
			font-weight: 500;
			margin: 0 0 10px 0;
			text-transform: uppercase;
			letter-spacing: 1px;
		}
		
		.user-id-value {
			font-size: 24px;
			font-weight: 700;
			color: #2d3748;
			font-family: "Monaco", "Menlo", monospace;
			background: #48bb78;
			color: white;
			padding: 12px 20px;
			border-radius: 10px;
			display: inline-block;
		}
		
		.verify-button {
			display: inline-block;
			background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
			color: white;
			text-decoration: none;
			padding: 18px 40px;
			border-radius: 50px;
			font-weight: 600;
			font-size: 16px;
			transition: all 0.3s ease;
			box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
			text-transform: uppercase;
			letter-spacing: 1px;
			margin: 20px 0;
		}
		
		.verify-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 40px rgba(72, 187, 120, 0.4);
		}
		
		.urgency-note {
			background: #fff5f5;
			border: 1px solid #fed7d7;
			border-radius: 10px;
			padding: 20px;
			margin: 30px 0;
			text-align: center;
		}
		
		.urgency-note-title {
			font-weight: 600;
			color: #c53030;
			margin: 0 0 10px 0;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.urgency-note-title::before {
			content: "⏰";
			margin-right: 8px;
		}
		
		.urgency-note-text {
			font-size: 14px;
			color: #742a2a;
			line-height: 1.5;
			margin: 0;
		}
		
		.footer {
			background: #2d3748;
			color: #a0aec0;
			padding: 30px;
			text-align: center;
			font-size: 14px;
		}
		
		.footer-title {
			color: white;
			font-weight: 600;
			margin: 0 0 10px 0;
		}
		
		.footer-contact {
			margin: 15px 0 0 0;
		}
		
		.footer-email {
			color: #48bb78;
			text-decoration: none;
			font-weight: 500;
		}
		
		.footer-email:hover {
			color: #38a169;
		}
		
		@media (max-width: 600px) {
			.email-container {
				margin: 10px;
				border-radius: 15px;
			}
			
			.header, .content, .footer {
				padding: 30px 20px;
			}
			
			.header-title {
				font-size: 20px;
			}
			
			.greeting {
				font-size: 18px;
			}
			
			.user-id-box {
				padding: 20px;
			}
			
			.user-id-value {
				font-size: 20px;
				padding: 10px 16px;
			}
			
			.verify-button {
				padding: 16px 30px;
				font-size: 14px;
			}
		}
	  </style>
	</head>
    <body>
        <div class="email-container">
        	<div class="header">
        		<div class="logo">
        			<img src="https://capitolmoneypay.com/favicon/cmp-icon.svg" alt="Capitol Money Pay Logo" />
        		</div>
        		<h1 class="header-title">Account Verification Required</h1>
        		<p class="header-subtitle">One final step to activate your account</p>
        	</div>
        	
        	<div class="content">
        		<h2 class="greeting">Hello '.$name0.'! 👋</h2>
        		<p class="intro-text">
        			Your Capitol Money Pay account has been created successfully! To complete the registration process and start your financial journey with us, please verify your account using the button below.
        		</p>
        		
        		<div class="user-id-box">
        			<p class="user-id-label">Your User ID</p>
        			<div class="user-id-value">'.$user0.'</div>
        		</div>
        		
        		<a href="https://capitolmoneypay.com/member/account_verify.html#uID:'.base64_encode($user0).'" class="verify-button">
        			🔐 Verify Account Now
        		</a>
        		
        		<div class="urgency-note">
        			<p class="urgency-note-title">Time Sensitive</p>
        			<p class="urgency-note-text">
        				Please complete your verification within 48 hours to ensure your account remains active and accessible.
        			</p>
        		</div>
        	</div>
        	
        	<div class="footer">
        		<p class="footer-title">Capitol Money Pay Support Team</p>
        		<p>Thank you for choosing Capitol Money Pay for your financial growth.</p>
        		<div class="footer-contact">
        			Need help? Contact us at: <a href="mailto:support@capitolmoneypay.com" class="footer-email">support@capitolmoneypay.com</a>
        		</div>
        	</div>
        </div>
    </body>
</html>';
?>