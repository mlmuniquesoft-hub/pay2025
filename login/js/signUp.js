 var capFt;
	  grecaptcha.ready(function() {
		  grecaptcha.execute('6LfTCbIUAAAAACb_PpflJsnEXymUtTIYUZY62HrA', {action: 'homepage'}).then(function(token) {
			 capFt=token;
			 $("#ctads").val(token);
		  });
	  });
	 
		$("#signup-form").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
		});
		(function($) {


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
            },
			Password_tr : {
                required: true
            }
        },
		messages:{
			sponsor_id:"Submit Sponsor ID",
			full_name:"Submit Your Full Name",
			email: {
				required: "Please provide a email",
				email: "Enter valid email address."
			},
			phone_number:"Submit Your Phone Number",
			password: {
				required: "Enter a password",
				minlength: "At least 8 characters long"
		    },
			re_password: {
				required: "Enter confirm password",
				minlength: "At least 8 characters long",
				equalTo: "Password does not matched."
			},
			Password_tr: {
				required: "Enter a Transaction PIN",
				minlength: "At least 4 characters long"
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
				url:'/login/signup_save.php',
				dataType:'json',
				data:data,
				beforeSend:function(){
					$("#Mess").html('<div class="ld ld-spinner ld-clock"></div>');
				},
				success: function(ress){
					if(ress.resd==1){
						setTimeout(function(){
							location.reload();
						},1000);
					}else{
						if(ress.sts=='success'){
							$("#Mess").before('<span class="text-center text-success Ertyy">'+ress.mess+'</span>');
							
						}else{
							$("#Mess").html('');
							$("#Mess").before('<span class="text-center text-danger Ertyy">'+ress.mess+'</span>');
						}
					}
					
				}
			})
		}
    });

})(jQuery);