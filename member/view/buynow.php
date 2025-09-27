<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle" style="color:#000;">Product Picture</h5>
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
				<h1 class="title">Products</h1>
				<!-- PAGE HEADING TAG - END -->
			</div>

			<div class="pull-right hidden-xs">
				<ol class="breadcrumb">
					<li>
						<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
					</li>
					<li class="active" style="color:white">
						<strong>Products</strong>
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
									$Pasdf=$mysqli->query("SELECT * FROM `product` WHERE `chk`='1' order by serial desc");
									while($allPack=mysqli_fetch_assoc($Pasdf)){
								?>
								<div class="col-sm-4">
									<div style="background: #3f54bf;z-index: 1;" class="price-pack recommended<?php if($allPack['sale_price']>0){echo ""; } ?>">
										<div class="head" style="background: #a99b30;">
											<p><?php echo $allPack['name']; ?></p>
										</div>
										<a class="TradePic" href="#" data-src="../nzproducts/<?php echo($allPack['img1']); ?>" data-toggle="modal" data-target="#exampleModalLong">
											<img src="../nzproducts/<?php echo($allPack['img1']); ?>" style="height: 200px;width: 150px;" />
										</a>
										
							
										
											<h3><span class="symbol">$</span><?php echo($allPack['sale_price']); ?></h3>
										
										<button type="button" class="Shopping btn btn-success" data-pack="<?php echo base64_encode(time()."/".$allPack['serial']."/NZBOT".$allPack['sale_price']); ?>">Shopping</button>
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
	$(".Shopping").on("click", function(){
		const packInfo=$(this).attr("data-pack");
		console.log(packInfo);
		const redfg=$.ajax({
			method:"GET",
			dataType:'json',
			url:"viewdata/product_info.php",
			data:{packs:packInfo}
		});
		redfg.done((ress)=>{
			//console.log(ress);
			location.href=ress.url;
		});
	});
</script>