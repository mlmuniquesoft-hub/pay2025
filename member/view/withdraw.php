	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Withdraw Fund</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<?php 
						$BalanceSts=remainAmn22($member);
					?>
	<div class="row">
		
		<div class="col-md-12">
			<div class="card" id="Chose" style="background:#1a4bb5">
				
				
				<div class="card-body TransMess">
					<div class="form-group" id="TransMess">
						
					</div>
					<?php
					$jhkjf=$mysqli->query("SELECT * FROM `widraw_req` WHERE `user`='".$member."' AND `pending`='0' AND `type`='Withdraw' ORDER BY `serial` DESC LIMIT 1");
						$jfdf=mysqli_num_rows($jhkjf);
						if($jfdf<1){
					?>
					<div class="form-group">
						<label for="password">Withdraw Able Amount:</label>
						<input type="text" class="form-control" id="avaislToken" value="$<?php echo $BalanceSts['final']; ?>" placeholder="$<?php echo $BalanceSts['final']; ?>" readonly />
						
					</div>
					<div class="form-group">
						<h3 class="text-center" id="Mess"></h3>
					</div>
					<div class="form-group">
						<label for="password">Amount:</label>
						<input type="text" class="form-control" id="NumberOfToken" placeholder="Amount" />
						<span id="errorID1"></span>
					</div>
					<div class="form-group" id="WalletId" style="display:none;">
						<label for="password">External Wallet ID:</label>
						<input type="text" class="form-control" id="assignTo" placeholder="External Wallet ID">
						<span id="errorID"></span>
					</div>
					<button class="btn btn-warning btn-block btn-clean" id="alert_demo_7">Withdraw</button>
					<?php }else{ 
						$hfghsf=mysqli_fetch_assoc($jhkjf);
					?>
						
						<div class="form-group">
							<h3 class="alert alert-warning">Do You Want To Proceed?</h3>
							<p class="alert alert-warning">Transaction Request Initiated From Your Account</p>
						</div>
						<div class="form-group" id="MessTrans">
							
						</div>
						
						<button class="btn btn-warning btn-block btn-clean" data-sers="<?php echo base64_encode($hfghsf['serial']); ?>" id="Procced">Proceed</button>
						<button class="btn btn-danger btn-block btn-clean" data-sers="<?php echo base64_encode($hfghsf['serial']); ?>" id="Cancel">Cancel</button>
					
					<?php } ?>
				</div>
				
			</div>
			
		</div>
	</div>
	<script >
	
	const NootIfy=(e,t)=>{var r={};r.message=e,r.title="Transaction notify",r.icon="fa fa-ball",r.url="#",r.target="_self",$.notify(r,{type:t,placement:{from:"top",align:"right"},time:1e3,delay:0})},redf=e=>{$.ajax({method:"GET",url:"viewdata/withdraw_fund2.php",data:{serial:e}}).done(e=>{let t=JSON.parse(e);1==t[0]?(NootIfy(t[1],"success"),$(".TransMess").html("<h3 class='alert alert-success'>"+t[1]+"</h3>")):(NootIfy(t[1],"danger"),$(".TransMess").html("<h3 class='alert alert-danger'>"+t[1]+"</h3>"))})};var Riier;const Checkdf=e=>{$.ajax({method:"GET",url:"viewdata/check_req.php",data:{serial:e}}).done(t=>{console.log(t),0==t?(redf(e),clearInterval(Riier)):Riier=setInterval(Checkdf(e),1e3)})};$("#Cancel").on("click",function(){let e=$(this).attr("data-sers");$.ajax({method:"POST",url:"viewdata/cancel_trans.php",data:{sers:e}}).done(e=>{location.reload()})}),$("#Procced").on("click",function(){let e=$(this).attr("data-sers");$.ajax({method:"POST",url:"viewdata/proceed_trans.php",data:{sers:e}}).done(e=>{let t=JSON.parse(e);1==t[0]?(Checkdf(ryrOI[2]),$("#MessTrans").html("<p class='alert alert-success'>"+t[1]+"</p>")):$("#MessTrans").html("<p class='alert alert-danger'>"+t[1]+"</p>")})});var method,curencyAmn,AssIgnTo,NumberOfToken,resdf=!0;$("#alert_demo_7").click(function(e){AssIgnTo=$("#assignTo").val(),NumberOfToken=$("#NumberOfToken").val(),$.ajax({method:"GET",url:"https://api.blockcypher.com/v1/"+method.toLowerCase()+"/main/addrs/"+AssIgnTo+"/balance",dataType:"json",statusCode:{404:function(){resdf=!1,$("#errorID").text("Invalid Wallet ID"),$("#errorID").parent().addClass("has-error")},400:function(){resdf=!1,$("#errorID").text("Invalid Wallet ID"),$("#errorID").parent().addClass("has-error")}}}).done(e=>{""!=e.address?resdf?""!=NumberOfToken?""!=method?""!=AssIgnTo?swal({title:"Are you sure?",text:"Your Amount($"+NumberOfToken+") Will Rduce From Your Account",type:"warning",buttons:{confirm:{text:"Yes, Send Request",className:"btn btn-success"},cancel:{visible:!0,className:"btn btn-danger"}}}).then(e=>{if(e){$.ajax({method:"GET",url:"viewdata/send_mail_withdraw.php",data:{curencyAmn:curencyAmn,method:method,AssIgnTo:AssIgnTo,NumberOfToken:NumberOfToken,type:"withdraw"}}).done(e=>{let t,r,a,s,o=JSON.parse(e);1==o[0]?(Checkdf(o[2]),t="Success!",r=o[1],a="success",s="btn btn-success"):(t="Error!",r=o[1],a="error",s="btn btn-danger"),swal({title:t,text:r,type:a,buttons:{confirm:{className:s}}})})}else swal.close()}):($("#messToken").text("Select External Wallet ID"),$("#messToken").css("color","red")):($("#messToken").text("Select External Wallet Type"),$("#messToken").css("color","red")):($("#messToken").text("Select Withdraw Amount"),$("#messToken").css("color","red")):($("#messToken").text("Correct All Field"),$("#messToken").css("color","red")):(resdf=!1,$("#errorID").text("Invalid Wallet ID"),$("#errorID").parent().addClass("has-error"))})});const Bttc=()=>{$(".ConvertAmount").on("click",function(){$("#WalletId").slideDown(1e3),resdf=!0,method=$(this).attr("data-method"),curencyAmn=$(this).attr("data-curen"),console.log("HEllo")})};$("#NumberOfToken").on("keyup",function(){$(".LoderImage").remove(),$(".ConvertAmount").remove();let e=Number($(this).val()),t=Number($("#avaislToken").val());if(e>=5)if(e>t)resdf=!1,$("#errorID1").text("You Select More Then Available"),$("#errorID1").parent().addClass("has-error");else{resdf=!1,$("#errorID1").text(""),$("#errorID1").parent().removeClass("has-error"),$("#errorID1").parent().after("<img class='LoderImage' src='/images/loader_small.gif' style='width:100px;height:100px;'>"),$.ajax({method:"GET",url:"viewdata/exchange_curency.php",data:{amount:e}}).done(e=>{$(".ConvertAmount").remove();var t=JSON.parse(e);let r2=["<span class='badge badge-success'> Active</span>","<span class='badge badge-danger'> In Process</span>","<span class='badge badge-danger'> In Process</span>"];let r=["info","warning","warning"],a=["https://s2.coinmarketcap.com/static/img/coins/32x32/1.png","https://s2.coinmarketcap.com/static/img/coins/32x32/1027.png","https://s2.coinmarketcap.com/static/img/coins/32x32/2.png"],s=0;for(result in t) $("#errorID1").parent().after("<button class='ConvertAmount btn btn-"+r[s]+"' data-method='"+result+"' data-curen='"+t[result]+"' style='margin:10px;'>"+" "+r2[s]+" <img style='width:32px;height:32px;' src='"+a[s]+"'> "+result+"&nbsp; : &nbsp;"+t[result]+"</button>"),s++;Bttc(),$(".LoderImage").hide()})}else resdf=!1,$("#errorID1").text("Minimum Amount $30"),$("#errorID1").parent().addClass("has-error")});
	</script>
				</div>
			</section>
		</div>
	</div>
	<script>
		$("#Profile_pIsv").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
			const FormDDf=$(this).serialize();
			const Accdf=$(this).attr("action");
			const refdg=$.ajax({
				method:"POST",
				dataType:"json",
				url:Accdf,
				data:FormDDf
			});
			refdg.done((ggFD)=>{
				if(ggFD.sts==1){
					$("#messDf2").text(ggFD.mess);
					$(".messDf2").show();
					setTimeout(function(){
						location.reload();
					},3000);
				}else{
					$("#messDf3").text(ggFD.mess);
					$(".messDf3").show();
				}
			});
		});
		$("#VerifyStep").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			const secureCode=$("#secureCode").val();
			const erdd=$.ajax({
				method:"GET",
				dataType:"json",
				url:"/login/verify.php",
				data:{secureCode:secureCode,user_id:'<?php echo $member; ?>'}
			});
			erdd.done((redds)=>{
				if(redds.sts==1){
					$("#SffD").trigger("click");
				}else{
					$("#messDf3").text(redds.mess);
					$(".messDf3").show();
				}
			});
		});
		$("#TrasnferAvv").on("click",function(e){
			e.preventDefault();
			e.stopPropagation();
			const receiveID=$("#receiveID").val();
			const amount=$("#amount").val();
			const TransCode=$("#TransCode").val();
			
			const Resdfgg=$.ajax({
				method:"POST",
				dataType:'json',
				url:"viewdata/checkTrans.php",
				data:{receiveID:receiveID,amount:amount,TransCode:TransCode}
			});
			Resdfgg.done((ress)=>{
				if(ress.sts==1){
					$("#messDf2").text(ress.mess);
					$(".messDf2").show();
					$("#TransOption2").show();
					$("#TransOption").hide();
				}else{
					$("#messDf").text(ress.mess);
					$(".messDf").show();
				}
			});
		});
	</script>