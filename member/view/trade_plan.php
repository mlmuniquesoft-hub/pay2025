<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle" style="color:#000;">Robot Image</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body" style="color:#000;">
				<img id="FullPic" src="" style="height: 100%;width: 100%;" />
		  </div>
		  <div class="modal-footer">
			<button type="button" id="closeSS" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

<div class="wrapper main-wrapper row" style='min-height:100vh'>
	<div class="col-xs-12">
		<div class="page-title">

			<div class="pull-left">
				<!-- PAGE HEADING TAG - START -->
				<h1 class="title">Traders Plan</h1>
				<!-- PAGE HEADING TAG - END -->
			</div>

			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
					</li>
					<li class="active" style="color:white">
						<strong>Traders Plan</strong>
					</li>
				</ol>
			</div>

		</div>
	</div>
	<div class="clearfix"></div>
	<!-- MAIN CONTENT AREA STARTS -->

	<div class="col-lg-12">
		<section class="box ">
			
			<div class="content-body">
				<div class="row">
					<div class="col-xs-12">

						<!-- start -->

						<div class="pricing-tables">

							<div class="row">
								<?php
									$userPack=$memberInfo['pack'];
									$Pasdf=$mysqli->query("SELECT * FROM `package` WHERE `active`='1'");
									while($allPack=mysqli_fetch_assoc($Pasdf)){
								?>
								<div class="col-sm-4">
									<div style="background: #3f54bf;z-index: 1;" class="price-pack recommended<?php if($allPack['pack_amn']>=3000){echo ""; } ?>">
										<div class="head" style="background: #a99b30;">
											<h3>NZBOT<?php echo $allPack['pack_amn']; ?></h3>
										</div>
										<a class="TradePic" href="#" data-src="package/Dbot<?php echo floor($allPack['pack_amn']); ?>-241x300.png" data-toggle="modal" data-target="#exampleModalLong">
											<img src="package/Dbot<?php echo floor($allPack['pack_amn']); ?>-241x300.png" style="height: 200px;width: 150px;" />
										</a>
										<ul class="item-list list-unstyled">
											<li style="margin:0px;"><strong><?php echo floor($allPack['pack_amn']/100); ?></strong> NZBOT</li>
											<li style="margin:0px;"><strong><?php echo $allPack['pack_amn']/10; ?> </strong> Scores</li>
											<li style="margin:0px;"><strong>2.65% </strong> Up to </li>
										</ul>
										<div class="price">
											<h3><span class="symbol">$</span><?php echo floor($allPack['pack_amn']); ?></h3>
											<h4>+ $10 Membership Fee</h4>
										</div>
										<button type="button" class="btn btn-lg  <?php if($allPack['serial']<=$userPack){echo "btn-default disabled"; }else{echo "btn-success Upgrade";} ?>" data-pack="<?php echo base64_encode(time()."/".$allPack['serial']."/NZBOT".$allPack['pack_amn']); ?>"><?php if($allPack['serial']<=$userPack){echo "Disabled"; }else{echo "Upgrade";} ?></button>
									</div>
								</div>
								<?php } ?>
								
							</div>
							<!-- row-->

						</div>
						<!-- end -->

					</div>
				</div>
			</div>
		</section>
	</div>

</div>
<script>
	$(".TradePic").on("click", function(){
		let iMsd=$(this).attr("data-src");
		$("#FullPic").attr("src",iMsd);
	});
	$(".Upgrade").on("click", function(){
		const packInfo=$(this).attr("data-pack");
		const redfg=$.ajax({
			method:"POST",
			dataType:'json',
			url:"viewdata/pack_info.php",
			data:{packs:packInfo}
		});
		redfg.done((ress)=>{
			location.href=ress.url;
		});
	});
</script>