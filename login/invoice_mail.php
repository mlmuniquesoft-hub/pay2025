<?php
$message2='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Invoice - Capitol Money Pay</title>
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
			max-width: 680px;
			margin: 20px auto;
			background: #ffffff;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			overflow: hidden;
		}
		
		.header {
			background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
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
		
		.logo::before {
			content: "🤖";
			font-size: 36px;
		}
		
		.header-title {
			font-size: 28px;
			font-weight: 700;
			margin: 0 0 10px 0;
			text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}
		
		.invoice-number {
			font-size: 16px;
			font-weight: 500;
			margin: 0;
			opacity: 0.9;
			background: rgba(255, 255, 255, 0.1);
			padding: 8px 16px;
			border-radius: 20px;
			display: inline-block;
		}
		
		.company-info {
			background: #f8fafc;
			padding: 25px 30px;
			border-bottom: 1px solid #e2e8f0;
		}
		
		.company-address {
			font-size: 14px;
			color: #4a5568;
			line-height: 1.6;
			margin: 0;
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
		
		.member-id {
			font-size: 18px;
			color: #4299e1;
			font-weight: 600;
			margin: 0 0 20px 0;
		}
		
		.thank-you {
			font-size: 16px;
			color: #48bb78;
			font-weight: 500;
			margin: 0 0 30px 0;
		}
		
		.invoice-details {
			background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
			border-radius: 15px;
			padding: 25px;
			margin: 20px 0;
			border-left: 4px solid #4299e1;
		}
		
		.invoice-header {
			display: flex;
			justify-content: space-between;
			margin-bottom: 20px;
			flex-wrap: wrap;
		}
		
		.invoice-info {
			font-size: 14px;
			color: #4a5568;
		}
		
		.robot-details {
			margin: 30px 0;
		}
		
		.robot-title {
			font-size: 20px;
			font-weight: 600;
			color: #2d3748;
			margin: 0 0 20px 0;
			display: flex;
			align-items: center;
		}
		
		.robot-title::before {
			content: "🤖";
			margin-right: 10px;
		}
		
		.details-table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
		}
		
		.details-table th {
			background: #4299e1;
			color: white;
			padding: 15px;
			text-align: left;
			font-weight: 600;
			border-radius: 8px 0 0 0;
		}
		
		.details-table th:last-child {
			border-radius: 0 8px 0 0;
		}
		
		.details-table td {
			padding: 15px;
			border-bottom: 1px solid #e2e8f0;
			background: white;
		}
		
		.details-table tr:last-child td {
			border-bottom: none;
			border-radius: 0 0 8px 8px;
		}
		
		.details-table tr:last-child td:first-child {
			border-radius: 0 0 0 8px;
		}
		
		.details-table tr:last-child td:last-child {
			border-radius: 0 0 8px 0;
		}
		
		.amount {
			font-weight: 600;
			color: #48bb78;
			font-size: 16px;
		}
		
		.login-button {
			display: inline-block;
			background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
			color: white;
			text-decoration: none;
			padding: 18px 40px;
			border-radius: 50px;
			font-weight: 600;
			font-size: 16px;
			transition: all 0.3s ease;
			box-shadow: 0 10px 30px rgba(66, 153, 225, 0.3);
			text-transform: uppercase;
			letter-spacing: 1px;
			margin: 30px 0;
		}
		
		.login-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 40px rgba(66, 153, 225, 0.4);
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
			color: #4299e1;
			text-decoration: none;
			font-weight: 500;
		}
		
		.footer-email:hover {
			color: #3182ce;
		}
		
		@media (max-width: 600px) {
			.email-container {
				margin: 10px;
				border-radius: 15px;
			}
			
			.header, .content, .company-info, .footer {
				padding: 25px 20px;
			}
			
			.header-title {
				font-size: 24px;
			}
			
			.greeting {
				font-size: 20px;
			}
			
			.invoice-details {
				padding: 20px;
			}
			
			.details-table th,
			.details-table td {
				padding: 12px 8px;
				font-size: 14px;
			}
			
			.login-button {
				padding: 16px 30px;
				font-size: 14px;
			}
			
			.invoice-header {
				flex-direction: column;
			}
		}
	  </style>
	</head>
    <body>
        <div class="email-container">
        	<div class="header">
        		<div class="logo"></div>
        		<h1 class="header-title">Invoice Receipt</h1>
        		<div class="invoice-number">Invoice #'.$Invoice.'</div>
        	</div>
        	
        	<div class="company-info">
        		<p class="company-address">
        			<strong>Capitol Money Pay</strong><br/>
        			1600 Pennsylvania Avenue NW<br/>
        			Washington, DC, USA 20500<br/>
        			📧 support@capitolmoneypay.com<br/>
        			📞 +1.202.456.1414
        		</p>
        	</div>
        	
        	<div class="content">
        		<h2 class="greeting">Dear '.$name0.' 👋</h2>
        		<p class="member-id">Member ID: '.$user.'</p>
        		<p class="thank-you">✅ Thank you for your order!</p>
        		
        		<div class="invoice-details">
        			<div class="invoice-header">
        				<div class="invoice-info">
        					<strong>Date:</strong> '. date("M d, Y h:i A") .'
        				</div>
        			</div>
        		</div>
        		
        		<div class="robot-details">
        			<h3 class="robot-title">Robot Package Details</h3>
        			
        			<table class="details-table">
        				<tr>
        					<th>Description</th>
        					<th>Details</th>
        				</tr>
        				<tr>
        					<td><strong>Robot Name</strong></td>
        					<td>CAPBOT'.floor($PackAInfo['pack_amn']).'</td>
        				</tr>
        				<tr>
        					<td><strong>Bot Quantity</strong></td>
        					<td>'. floor($PackAInfo['pack_amn'])/100 .'</td>
        				</tr>
        				<tr>
        					<td><strong>Score</strong></td>
        					<td>'.  floor($PackAInfo['pack_amn'])/10 .'</td>
        				</tr>
        				<tr>
        					<td><strong>Expected Return</strong></td>
        					<td class="amount">$'. floor($PackAInfo['pack_amn'])*4 .'</td>
        				</tr>
        				<tr>
        					<td><strong>Package Price</strong></td>
        					<td class="amount">$'. floor($PackAInfo['pack_amn']) .'</td>
        				</tr>
        				<tr>
        					<td><strong>Upgrade Charge</strong></td>
        					<td class="amount">$'. floor($require_amn) .'</td>
        				</tr>
        				<tr>
        					<td><strong>Order Date</strong></td>
        					<td>'.date("M d, Y h:i A").'</td>
        				</tr>
        			</table>
        		</div>
        		
        		<div style="text-align: center; margin: 40px 0;">
        			<a href="https://capitolmoneypay.com/member/nz-login.html" target="_blank" class="login-button">
        				🔐 Login to Your Account
        			</a>
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
