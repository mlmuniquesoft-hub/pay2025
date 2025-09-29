// reCAPTCHA token handling
var capFt;

// Initialize reCAPTCHA
grecaptcha.ready(function() {
    grecaptcha.execute('6LfIeNgrAAAAABdG_3Q1imBzm3T8JjqculxBEloG', {action: 'signup'}).then(function(token) {
        capFt = token;
        $("#ctads").val(token);
    });
});

// Prevent default form submission
$("#signup-form").on("submit", function(e) {
    e.preventDefault();
    e.stopPropagation();
});

// Add form submission handler for the hidden submit button
$("#submit").on("click", function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Refresh reCAPTCHA token before submission
    grecaptcha.execute('6LfIeNgrAAAAABdG_3Q1imBzm3T8JjqculxBEloG', {action: 'signup'}).then(function(token) {
        $("#ctads").val(token);
        
        // Get form data
        let formData = $("#signup-form").serializeArray();
        
        // Remove any previous error messages
        $(".Ertyy").remove();
        
        // Submit form via AJAX
        $.ajax({
            method: "POST",
            url: "/login/signup_save.php",  
            dataType: "json",
            data: formData,
            beforeSend: function() {
                $("#Mess").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Processing...</span></div> Processing registration...');
                $("#Mess").css("color", "#28a745");
            },
            success: function(response) {
                console.log('Registration response:', response);
                
                if(response.sts === 'success') {
                    $("#Mess").html('<i class="fa fa-check-circle"></i> ' + response.mess);
                    $("#Mess").css("color", "#28a745");
                    
                    // Redirect or reload after success
                    setTimeout(function() {
                        if(response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            location.reload();
                        }
                    }, 2000);
                } else {
                    $("#Mess").html('<i class="fa fa-exclamation-triangle"></i> ' + (response.mess || 'Registration failed'));
                    $("#Mess").css("color", "#f54242");
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Response:', xhr.responseText);
                
                $("#Mess").html('<i class="fa fa-exclamation-triangle"></i> Network error. Please try again.');
                $("#Mess").css("color", "#f54242");
            }
        });
    }).catch(function(error) {
        console.error('reCAPTCHA Error:', error);
        $("#Mess").html('<i class="fa fa-exclamation-triangle"></i> Captcha verification failed. Please refresh and try again.');
        $("#Mess").css("color", "#f54242");
    });
});

// jQuery validation setup
$(document).ready(function() {
    $("#signup-form").validate({
        rules: {
            sponsor_id: {
                required: true
            },
            full_name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },  
            phone_number: {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            re_password: {
                required: true,
                equalTo: "#password"
            },
            Password_tr: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            sponsor_id: "Sponsor ID is required",
            full_name: "Full Name is required", 
            email: {
                required: "Email is required",
                email: "Enter a valid email address"
            },
            phone_number: "Phone Number is required",
            password: {
                required: "Password is required",
                minlength: "Password must be at least 6 characters"
            },
            re_password: {
                required: "Confirm Password is required",
                equalTo: "Passwords do not match"
            },
            Password_tr: {
                required: "Transaction PIN is required", 
                minlength: "Transaction PIN must be at least 4 characters"
            }
        },
        onfocusout: function(element) {
            $(element).valid();
        }
    });
}); 