	<div class="wrapper main-wrapper row" style="min-height:100vh">

		<div class="col-xs-12">

			<div class="pull-left">
				<!-- PAGE HEADING TAG - START -->
				<h4 class="title boldy mb-5 mt-15" style="color: #37e037;">D.bot Working</h4>
				<!-- PAGE HEADING TAG - END -->
			</div>

		</div>

		<div class="clearfix"></div>

		<div class="col-lg-12 mt-15 ">
			<section class="wra">
				<div class="swiper-container coins-slider text-center swiper-container-horizontal" id="InvestCoin">
					
				</div>
				
			</section>
		</div>
		<script>
			const InvestRE=()=>{
				let urtyrt;
				const redfg2=$.ajax({
					method:"GET",
					url:"viewdata/invets_coin.php",
					data:{}
				});
				redfg2.done((erwwe)=>{
					//console.log(erwwe);
					$("#InvestCoin").html(erwwe);
					//clearInterval(urtyrt);
					//urtyrt=setInterval(InvestRE,35000);
					
				})
			}
			InvestRE();
			
			
			
		</script>
		

		<div class="clearfix"></div>

		<div class="col-lg-8">
			
				<section class="box " style="background-color: #333d5d96;">
                        <header class="panel_header">
                            <h2 class="title pull-left" style="color: #f9f28d;">Real Time</h2>
                            <div class="actions panel_actions pull-right">
                                <a class="box_toggle fa fa-chevron-down"></a>
                                <a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
                                <a class="box_close fa fa-times"></a>
                            </div>
                        </header>
						
                        <div class="content-body">
                            <div class="row">
                                <div class="col-xs-12" style="padding:0px;">

                                    <div class="flot-demo-container">
                                        <div id="flot-realtime" class="flot-demo-placeholder" style="width: 663px;"></div>
                                    </div>
                                    <br>
                                   
                                </div>
                            </div>
                        </div>
                    </section>
					<style>
						#flot-realtime canvas{
							width: 663px;
						}
					</style>
			
		</div>
		
		<div class="col-xs-12 col-md-6 col-lg-4">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Stock Status</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">    
					<div class="row">
						<div class="col-xs-12" id="CoinPrice" style="height:372px;overflow:hidden;">
							
							

						</div>      
					</div> <!-- End .row -->
				</div>
			</section>
		</div>
		<script>
		
			const Courty=()=>{
				const redfg=$.ajax({
					method:"GET",
					url:"viewdata/coin_data.php",
					data:{}
				});
				redfg.done((erwwe)=>{
					$("#CoinPrice").html(erwwe);
					
				})
			}
			Courty();
			//InvestRE();
			
		</script>
		<div class="clearfix"></div>

		<div class="col-lg-6">
			<section class="box">
				<header class="panel_header">
					<h2 class="title pull-left">Recent Activities</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table vm table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Crypto Orders</th>
											<th>Status</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$Activirt=array("Buy:p1","Sell:p2","Exchange:p3");
											//$imdfgg=array("p2","p1","p3");
											
											$text=rand(50,99999);
											$sfds=array("+:green-text","-:red-text");
											$dfgfdg=array_rand($Activirt);
											$dfgfdg3=array_rand($sfds);
											
											$Byertre=explode(":", $Activirt[$dfgfdg]);
											
											if($Byertre[0]=="Exchange"){
												$ActiStret=array("completed:success","Pending:warning","exchanged:primary","Canceled:danger");
												$dfgfdg2=array_rand($ActiStret);
												$Byertre2=explode(":", $ActiStret[$dfgfdg2]);
												$Byertre3=explode(":", " :blue-text");
											}else{
												$ActiStret=array("completed:success","Pending:warning","Canceled:danger");
												$dfgfdg2=array_rand($ActiStret);
												$Byertre2=explode(":", $ActiStret[$dfgfdg2]);
												$Byertre3=explode(":", $sfds[$dfgfdg3]);
											}
											$srereer=array(1,2,3,4,5,6,7,8,9);
											shuffle($srereer);
											$dfgfdg21=array_rand($srereer);
											$dfdfdg="+".$srereer[$dfgfdg21]." second";
										?>
										<tr>
											<td>
												<div class="round img2">
													<img src="../data/crypto-dash/<?php echo $Byertre[1]; ?>.png" alt="">
												</div>
												<div class="designer-info">
													<h6><?php echo $Byertre[0]; ?> Record</h6>
													<small class="text-muted"><span class="mr-10"><?php echo date("m-d"); ?></span> <?php echo date("H:i:s", strtotime($dfdfdg)); ?></small>
												</div>
											</td>
											<td><span class="badge w-70 round-<?php echo $Byertre2[1]; ?>"><?php echo $Byertre2[0]; ?></span></td>
											<td class="<?php echo $Byertre3[1]; ?> boldy"><?php echo $Byertre3[0]; ?><?php echo $text; ?>$</td>
										</tr>
										

									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</section>
			
		</div>
		<script>
			const deleterow=function(tableID){
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;

				table.deleteRow(rowCount -1);
			}
			const TrabbleUp=(req,res)=>{
				const dfgfd=$.ajax({
					method:"GET",
					url:"viewdata/"+req,
					data:{}
				});
				dfgfd.done((redfg)=>{
					$("#"+res+" tbody tr:first").before(redfg);
					var table = document.getElementById(res);
					var rowCount = table.rows.length;
					if(rowCount>=7){
						deleterow(res);
					}
				});
			}
			setInterval(function(){
				TrabbleUp("activities_data.php","tech-companies-1");
				TrabbleUp("coin_trade.php","tech-companies-2");
				
			}, 2500);
			
			
			
			
		</script>

		<div class="col-lg-6">
			<section class="box">
				<header class="panel_header">
					<h2 class="title pull-left">Transactions History</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">

							<div class="table-responsive" data-pattern="priority-columns">
								<table id="tech-companies-2" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Crypto Trade</th>
											<th>Time</th>
											<th>Status</th>
											<th>Amount</th>
										</tr>
									</thead>
									
     
									<tbody>
										
										<tr>
											
										</tr>
										
										
										

									</tbody>
									
								</table>
							</div>

						</div>
					</div>
				</div>
			</section>
			
		</div>

	</div>
