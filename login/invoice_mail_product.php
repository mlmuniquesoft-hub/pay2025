<?php
$message2='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transit											<a href="https://capitolmoneypay.com/member/nz-login.html" target="_blank" class="btn btn-danger block-center" style="onal//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
        	        <img src="https://capitolmoneypay.com/images/logo111111.png" alt="logo" border="0" style="height: 100px;width: 100px;" />
					 <p>
						Overbergveien 246 1397 NESOYA <br/>
						Palmerston North <br/>
						West Coast, NZ 6004 <br/>
						support@capitolmoneypay.com <br/>
						+64.47261300 <br/>
					</p>
				</div> 
        	    <div  style="background-color: #fbfcfd; border-top: thick double #cccccc; text-align: left;">
        	        <div style="margin: 30px;">
             	       
						<p>
                 	        <h2 style="color: #16c116;">Dear '.$name0.'</h2>
                 	        <h2 style="color: #16c116;">Member ID '.$user.'</h2>
                 	        <h3 style="color: #0d9218;">Thanks For Your Order</h3>
							 <h2 style="color: #16c116;">Invoice / Receipt: '.$Invoice.'</h2>
                 	        <h3 style="color: #0d9218;">Date: '. date("M d, Y h:i A") .'</h3><br> <br>
							<hr />
							<br><br>
             	        </p>
						
             	        <table style="text-align: left;">
							<h3 style="color: #126aab;">Your Product Details</h3>
             	            <tr style="line-height: 26px;">
             	                <th>Product Name</th>
             	                <td>: '.floor($PackAInfo['name']).'</td>
             	            </tr>
             	            <tr style="line-height: 26px;">
             	                <th>Product Quantity</th>
             	                <td>: '. $Qtyr .'</td>
             	            </tr>
							<tr style="line-height: 26px;">
             	                <th>Price</th>
             	                <td>: $'. floor($PackAInfo['sale_price']) .'</td>
             	            </tr>
							<tr style="line-height: 26px;">
             	                <th>Total Price</th>
             	                <td>: $'. floor($totalPrice) .'</td>
             	            </tr>
							<tr style="line-height: 26px;">
             	                <th>Adjust From Income</th>
             	                <td>: $'. floor($require_amn) .'</td>
             	            </tr>
							<tr style="line-height: 26px;">
             	                <th>Payment Due</th>
             	                <td>: $'. floor($totalPrice-$require_amn) .'</td>
             	            </tr>
							
							<tr style="line-height: 26px;">
             	                <th>Order date</th>
             	                <td>: '.date("M d, Y h:i A").'</td>
             	            </tr>
							<tr>
								<td align="center" colspan="2">
									<div style="line-height: 24px;margin-top: 20%;">
										<a href="https://nzrobotrade.com/member/nz-login.html" target="_blank" class="btn btn-danger block-center" style="
											color: #f7f2f2;
											border: 1px solid;
											padding: 10px 40px 15px 37px;
											background: rgb(8, 98, 193);
											font-size: 19px;
											margin: -7px;
										" target="_blank">
											Login Your Account
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
