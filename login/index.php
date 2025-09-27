<?php
	session_start();
	$_SESSION['token']="fhdfhd";
	require_once("../db/db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up NZ Robo Trade</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Main css -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loading.css">
</head>
<body style="padding:20px 0;background-image:url('images/login_page.jpg');background-position:fixed;">

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container" style="background: #92918be0;">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form" style="padding: 58px 15px 0px 15px;height: auto;">
                        <div class="form-row">
                            <div class="form-radio" style="width:100%;">
                                <label for="sponn" >Do you have a sponsor?</label>
                                <div class="form-flex">
                                    <input type="radio" name="sponn" value="1" id="Yess" checked="checked" />
                                    <label for="Yess">Yes</label>
    
                                    <input type="radio" name="sponn" value="0" id="Noo" />
                                    <label for="Noo">No</label>
                                </div>
                            </div>
                        </div>
						<div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label >Sponsor ID</label>
                                <div class="input-group ">
									<i class="fas fa-user"></i>
									<input type="password" class="form-input" name="sponsor_id" id="sponsor_id" />
								</div>
                            </div>
                        </div>
						<div class="form-row">
                            <div class="form-radio" style="width:100%;">
                                <label for="poss" style="font-size:10px;">Choose your position</label>
                                <div class="form-flex">
                                    <input type="radio" name="poss" value="1" id="male1" checked="checked" />
                                    <label for="male1">Left</label>
    
                                    <input type="radio" name="poss" value="0" id="female1" />
                                    <label for="female1">Right</label>
                                </div>
                            </div>
                        </div>
						<div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-input" name="full_name" id="full_name" />
                            </div>
                        </div>
						<div class="form-row">
							<div class="form-group" style="width:100%;">
								<label for="country">Country</label>
								<select class="form-control" name="country" id="country">
									<?php
										$Iiote=$mysqli->query("SELECT * FROM `country`");
										while($allCrt=mysqli_fetch_assoc($Iiote)){
									?>
									<option><?php echo $allCrt['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
                            <label for="phone_number">Phone number</label>
                            <input type="number" class="form-input" name="phone_number" id="phone_number" />
                        </div>
                        <div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-input" name="email" id="email"/>
						</div>
                        <div class="form-row">
                            <div class="form-group" style="width: 100%;">
                                <label for="password">Password</label>
                                <input type="password" class="form-input" name="password" id="password"/>
                            </div>
                        </div>
						<div class="form-row">
                            <div class="form-group" style="width: 100%;">
                                <label for="re_password">Repeat your password</label>
                                <input type="password" class="form-input" name="re_password" id="re_password"/>
                            </div>
                        </div>
						<div class="form-row">
                            <div class="form-group" style="width: 100%;">
                                <label for="re_password">Transaction PIN</label>
                                <input type="password" class="form-input" name="Password_tr" id="Password_tr"/>
                            </div>
                        </div>
						
						
                        <div class="form-group sdfsd">
                            <button type="submit" name="submit" id="submit" class="form-submit" >Sign Up <span style="fornt-size:34px;" id="loadin"></span></button>
                           
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script >
		$("#Noo").on("click", function(){
			$("#sponsor_id").val("robotrade");
		});
		$("#Yess").on("click", function(){
			$("#sponsor_id").val("");
		});
		$("#signup-form").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
			
		});
	</script>
    <script src="vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script >
		(function($) {

    $( "#birth_date" ).datepicker({
        dateFormat: "mm - dd - yy",
        showOn: "both",
        buttonText : '<i class="zmdi zmdi-calendar-alt"></i>',
    });

    $('.add-info-link ').on('click', function() {
        $('.add_info').toggle( "slow" );
    });

    /*$('#country').parent().append('<ul class="list-item" id="newcountry" name="country"></ul>');
    $('#country option').each(function(){
        $('#newcountry').append('<li value="' + $(this).val() + '">'+$(this).text()+'</li>');
    });
    $('#country').remove();
    $('#newcountry').attr('id', 'country');
    $('#country li').first().addClass('init');
    $("#country").on("click", ".init", function() {
        $(this).closest("#country").children('li:not(.init)').toggle();
    });
*/
    $('#city').parent().append('<ul class="list-item" id="newcity" name="city"></ul>');
    $('#city option').each(function(){
        $('#newcity').append('<li value="' + $(this).val() + '">'+$(this).text()+'</li>');
    });
    $('#city').remove();
    $('#newcity').attr('id', 'city');
    $('#city li').first().addClass('init');
    $("#city").on("click", ".init", function() {
        $(this).closest("#city").children('li:not(.init)').toggle();
    });

    var allOptions = $("#country").children('li:not(.init)');
    $("#country").on("click", "li:not(.init)", function() {
        allOptions.removeClass('selected');
        $(this).addClass('selected');
        $("#country").children('.init').html($(this).html());
        allOptions.toggle('slow');
    });

    var FoodOptions = $("#city").children('li:not(.init)');
    $("#city").on("click", "li:not(.init)", function() {
        FoodOptions.removeClass('selected');
        $(this).addClass('selected');
        $("#city").children('.init').html($(this).html());
        FoodOptions.toggle('slow');
    });


    $('#signup-form').validate({
        rules : {
            sponsor_id : {
                required: true,
            },
            full_name : {
                required: true,
            }, 
			email : {
                required: true,
            },
            phone_number : {
                required: true
            },
            password : {
                required: true
            },
            re_password : {
                required: true,
                equalTo: "#password"
            }
        },
		
        onfocusout: function(element) {
            $(element).valid();
        },
		submitHandler:function(form){
			$(".Ertyy").remove();
			let data=$("#signup-form").serializeArray();
			
			const resf=$.ajax({
				method:"POST",
				url:'signup_save.php',
				dataType:'json',
				data:data,
				beforeSend:function(){
					$("#submit").html('<div class="ld ld-spinner ld-clock"></div>');
				},
				success: function(ress){
					if(ress.sts=='success'){
						$("#submit").before('<span class="text-center text-success Ertyy">'+ress.mess+'</span>');
						setTimeout(function(){
							location.href=ress.url;
							console.log(ress.url);
						},1000);
					}else{
						$("#submit").html('Sign Up');
						$("#submit").before('<span class="text-center text-danger Ertyy">'+ress.mess+'</span>');
					}
				}
			})
		}
    });


    /*jQuery.extend(jQuery.validator.messages, {
        required: "",
        remote: "",
        email: "Email Required",
        url: "",
        date: "",
        dateISO: "",
        number: "",
        digits: "",
        creditcard: "",
        equalTo: ""
    });*/
})(jQuery);
	</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>