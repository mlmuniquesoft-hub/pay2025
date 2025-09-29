// Login form handler - No reCAPTCHA version
console.log("Login.js loaded successfully - No reCAPTCHA");

// Prevent any reCAPTCHA errors by providing a stub
if (typeof window.grecaptcha === 'undefined') {
    window.grecaptcha = {
        ready: function(callback) {
            console.warn("reCAPTCHA not loaded - using stub");
            if (typeof callback === 'function') {
                callback();
            }
        },
        execute: function() {
            console.warn("reCAPTCHA not loaded - using stub");
            return Promise.resolve('stub-token');
        }
    };
}

var capFt = 'no-captcha-needed';

$("#login-form").on("submit", function(e) {
    e.preventDefault();
    e.stopPropagation();
});

(function($) {
    $("#login-form").validate({
        rules: {
            user_id: {
                required: true
            },
            password: {
                required: true
            }
        },
        onfocusout: function(element) {
            $(element).valid();
        },
        submitHandler: function(form) {
            let formData = $("#login-form").serializeArray();
            $(".Ertyy").remove();
            
            $.ajax({
                method: "POST",
                url: "/login/login_action.php",
                dataType: "json",
                data: formData,
                beforeSend: function() {
                    $("#submit").html('<div class="ld ld-spinner ld-clock"></div>');
                },
                success: function(response) {
                    if (response.resd == 1) {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                    
                    if (response.sts == "success") {
                        $("#submit").before('<span class="text-center text-success Ertyy">' + response.mess + "</span>");
                        setTimeout(function() {
                            location.href = response.url;
                        }, 1000);
                    } else {
                        $("#submit").before('<span class="text-center text-danger Ertyy">' + response.mess + "</span>");
                    }
                }
            });
        }
    });
})(jQuery);