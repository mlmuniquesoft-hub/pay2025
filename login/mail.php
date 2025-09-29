<?php
$message2='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Capitol Money Pay</title>
		
	</head>
    <body>
        <div align="center">
             <div style="max-width: 680px; min-width: 500px; border: 2px solid #e3e3e3; border-radius:5px; margin-top: 20px">   
        	    <div>
        	        <img src="https://capitolmoneypay.com/images/logo111111.png" alt="logo" border="0" style="height: 200px;width: 200px;" />
        	    </div> 
        	    <div  style="background-color: #fbfcfd; border-top: thick double #cccccc; text-align: left;">
        	        <div style="margin: 30px;">
             	        <p>
                 	        <h2 style="color: #16c116;">Dear '.$name0.'</h2>
                 	        <h3 style="color: #0d9218;">Welcome to Capitol Money Pay!</h3><br> <br>
							<hr />
							<br><br>
             	        </p>
             	        <table style="text-align: left;">
							<h3 style="color: #126aab;">Accessing your account</h3>
             	            <tr style="line-height: 26px;">
             	                <th>User ID</th>
             	                <td>: '.$user0.'</td>
             	            </tr>
             	            <tr style="line-height: 26px;">
             	                <th>CID</th>
             	                <td>: '.$loguser00.'</td>
             	            </tr>
             	            <tr style="line-height: 26px;">
             	                <th>Status</th>
             	                <td>: Free</td>
             	            </tr>
             	            <tr style="line-height: 26px;">
             	                <th>Password</th>
             	                <td>: '.$Password0.'</td>
             	            </tr>
             	            <tr style="line-height: 26px;">
             	                <th>Transaction PIN</th>
             	                <td>: '.$Pin0.'</td>
             	            </tr>
							<tr style="line-height: 26px;">
             	                <th>Joining date</th>
             	                <td>: '.date("Y-m-d h:i:s a").'</td>
             	            </tr>
							<tr>
								<td align="center" colspan="2">
									<div style="line-height: 24px;margin-top: 20%;">
										<a href="https://capitolmoneypay.com/member/account_verify.html#uID:'.base64_encode($user0).'" target="_blank" class="btn btn-danger block-center" style="
											color: #f7f2f2;
											border: 1px solid;
											padding: 10px 40px 15px 37px;
											background: rgb(212, 55, 54);
											font-size: 16px;
											margin: -7px;
										" target="_blank">
											Verify Your Account
										</a>
									</div>
									<div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
								</td>
							</tr>
             	        </table>
             	        <br>  <br>
             	   
             	    </div>
        	    </div>   
        	</div>   
    	</div>
    </body>
</html>';
?>