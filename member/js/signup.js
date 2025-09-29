// Form submission handler without captcha
$("#signup-form").on("submit", function(e) {
    e.preventDefault();
    e.stopPropagation();
});

// Add form submission handler for the hidden submit button
$("#submit").on("click", function(e) {
    e.preventDefault();
    e.stopPropagation();
    
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
            console.error('Status:', status);
            console.error('Response Text:', xhr.responseText);
            
            let errorMsg = 'Registration failed. Please try again.';
            
            // Try to extract meaningful error from response
            if(xhr.responseText) {
                if(xhr.responseText.includes('Fatal error')) {
                    errorMsg = 'Database error occurred. Please contact support.';
                } else if(xhr.responseText.includes('Warning')) {
                    errorMsg = 'Server configuration issue. Please try again.';
                } else if(xhr.responseText.includes('Parse error')) {
                    errorMsg = 'Server error. Please contact support.';
                } else {
                    // Try to parse JSON if possible
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if(response.mess) {
                            errorMsg = response.mess;
                        }
                    } catch(e) {
                        // If not JSON, use generic message
                        errorMsg = 'Server communication error. Please try again.';
                    }
                }
            }
            
            $("#Mess").html('<i class="fa fa-exclamation-triangle"></i> ' + errorMsg);
            $("#Mess").css("color", "#f54242");
        }
    });
});

// jQuery validation setup
$(document).ready(function() {
    $("#signup-form").validate({
        rules: {
            sponsor_id: {
                required: true
            },
            poss: {
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
            poss: "Please select a position (Left or Right)",
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