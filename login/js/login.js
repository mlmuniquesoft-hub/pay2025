var capFt;
  grecaptcha.ready(function() {
      grecaptcha.execute('6LfTCbIUAAAAACb_PpflJsnEXymUtTIYUZY62HrA', {action: 'homepage'}).then(function(token) {
		 capFt=token;
		 $("#ctads").val(token);
      });
  });
  
		$("#login-form").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
		});
		(function($) {


    $('#login-form').validate({
        rules : {
            user_id : {
                required: true,
            },
            password : {
                required: true
            }
            
        },
		
        onfocusout: function(element) {
            $(element).valid();
        },
		submitHandler:function(form){
			let data=$("#login-form").serializeArray();
			$(".Ertyy").remove();
			//
			const resf=$.ajax({
				method:"POST",
				url:'/login/login_action.php',
				dataType:'json',
				data:data,
				beforeSend:function(){
					$("#submit").html('<div class="ld ld-spinner ld-clock"></div>');
				},
				success: function(ress){
					if(ress.resd==1){
						setTimeout(function(){
							location.reload();
						},1000);
					}
					if(ress.sts=='success'){
					$("#submit").before('<span class="text-center text-success Ertyy">'+ress.mess+'</span>');
						setTimeout(function(){
							location.href=ress.url;
						},1000);
					}else{
						
						$("#submit").before('<span class="text-center text-danger Ertyy">'+ress.mess+'</span>');
					}
				}
			})
		}
    });


})(jQuery);