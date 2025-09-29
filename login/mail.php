<?php
$message2='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Welcome to Capitol Money Pay</title>
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
			max-width: 650px;
			margin: 20px auto;
			background: #ffffff;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			overflow: hidden;
		}
		
		.header {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			padding: 40px 30px;
			text-align: center;
			color: white;
		}
		
		.logo {
			width: 80px;
			height: 80px;
			margin: 0 auto 20px;
			background: rgba(255, 255, 255, 0.2);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			backdrop-filter: blur(10px);
		}
		
		.logo img {
			width: 50px;
			height: 50px;
			filter: brightness(0) invert(1);
		}
		
		.welcome-title {
			font-size: 28px;
			font-weight: 700;
			margin: 0;
			text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}
		
		.welcome-subtitle {
			font-size: 16px;
			font-weight: 400;
			margin: 10px 0 0 0;
			opacity: 0.9;
		}
		
		.content {
			padding: 40px 30px;
		}
		
		.greeting {
			font-size: 24px;
			font-weight: 600;
			color: #2d3748;
			margin: 0 0 10px 0;
		}
		
		.intro-text {
			font-size: 16px;
			color: #4a5568;
			line-height: 1.6;
			margin: 0 0 30px 0;
		}
		
		.account-details {
			background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
			border-radius: 15px;
			padding: 30px;
			margin: 30px 0;
			border-left: 4px solid #667eea;
		}
		
		.details-title {
			font-size: 20px;
			font-weight: 600;
			color: #2d3748;
			margin: 0 0 20px 0;
			display: flex;
			align-items: center;
		}
		
		.details-title::before {
			content: "🔑";
			margin-right: 10px;
			font-size: 24px;
		}
		
		.detail-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 12px 0;
			border-bottom: 1px solid #e2e8f0;
		}
		
		.detail-row:last-child {
			border-bottom: none;
		}
		
		.detail-label {
			font-weight: 600;
			color: #4a5568;
			font-size: 14px;
		}
		
		.detail-value {
			font-weight: 500;
			color: #2d3748;
			font-size: 14px;
			background: #667eea;
			color: white;
			padding: 6px 12px;
			border-radius: 8px;
			font-family: "Monaco", "Menlo", monospace;
		}
		
		.cta-section {
			text-align: center;
			margin: 40px 0;
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
		}
		
		.verify-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 40px rgba(72, 187, 120, 0.4);
		}
		
		.security-notice {
			background: #fff5f5;
			border: 1px solid #fed7d7;
			border-radius: 10px;
			padding: 20px;
			margin: 30px 0;
			text-align: center;
		}
		
		.security-notice-title {
			font-weight: 600;
			color: #c53030;
			margin: 0 0 10px 0;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.security-notice-title::before {
			content: "🔒";
			margin-right: 8px;
		}
		
		.security-notice-text {
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
		
		.footer-text {
			margin: 0;
			line-height: 1.6;
		}
		
		.footer-links {
			margin: 20px 0 0 0;
		}
		
		.footer-link {
			color: #667eea;
			text-decoration: none;
			margin: 0 15px;
			font-weight: 500;
		}
		
		.footer-link:hover {
			color: #764ba2;
		}
		
		@media (max-width: 600px) {
			.email-container {
				margin: 10px;
				border-radius: 15px;
			}
			
			.header, .content, .footer {
				padding: 30px 20px;
			}
			
			.welcome-title {
				font-size: 24px;
			}
			
			.greeting {
				font-size: 20px;
			}
			
			.account-details {
				padding: 20px;
			}
			
			.detail-row {
				flex-direction: column;
				align-items: flex-start;
				gap: 8px;
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
        		<h1 class="welcome-title">Welcome to Capitol Money Pay</h1>
        		<p class="welcome-subtitle">Your Gateway to Smart Financial Growth</p>
        	</div>
        	
        	<div class="content">
        		<h2 class="greeting">Hello '.$name0.'! 👋</h2>
        		<p class="intro-text">
        			Congratulations on joining Capitol Money Pay! We\'re excited to have you as part of our community. Your account has been successfully created and is ready for verification.
        		</p>
        		
        		<div class="account-details">
        			<h3 class="details-title">Your Account Information</h3>
        			<div class="detail-row">
        				<span class="detail-label">User ID</span>
        				<span class="detail-value">'.$user0.'</span>
        			</div>
        			<div class="detail-row">
        				<span class="detail-label">Customer ID</span>
        				<span class="detail-value">'.$loguser00.'</span>
        			</div>
        			<div class="detail-row">
        				<span class="detail-label">Account Status</span>
        				<span class="detail-value">Pending Verification</span>
        			</div>
        			<div class="detail-row">
        				<span class="detail-label">Login Password</span>
        				<span class="detail-value">'.$Password0.'</span>
        			</div>
        			<div class="detail-row">
        				<span class="detail-label">Transaction PIN</span>
        				<span class="detail-value">'.$Pin0.'</span>
        			</div>
        			<div class="detail-row">
        				<span class="detail-label">Registration Date</span>
        				<span class="detail-value">'.date("M d, Y").'</span>
        			</div>
        		</div>
        		
        		<div class="cta-section">
        			<a href="https://capitolmoneypay.com/member/account_verify.html#uID:'.base64_encode($user0).'" class="verify-button">
        				✅ Verify Your Account Now
        			</a>
        		</div>
        		
        		<div class="security-notice">
        			<p class="security-notice-title">Important Security Information</p>
        			<p class="security-notice-text">
        				Please keep your login credentials secure and never share them with anyone. Capitol Money Pay will never ask for your password via email or phone.
        			</p>
        		</div>
        	</div>
        	
        	<div class="footer">
        		<p class="footer-title">Capitol Money Pay</p>
        		<p class="footer-text">
        			Thank you for choosing Capitol Money Pay for your financial journey.<br>
        			If you have any questions, our support team is here to help.
        		</p>
        		<div class="footer-links">
        			<a href="https://capitolmoneypay.com" class="footer-link">Website</a>
        			<a href="mailto:support@capitolmoneypay.com" class="footer-link">Support</a>
        			<a href="https://capitolmoneypay.com/member/nz-login.html" class="footer-link">Login</a>
        		</div>
        	</div>
        </div>
    </body>
</html>';
?>