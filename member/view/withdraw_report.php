	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-lg-12">
			<section class="box">
				<header class="panel_header">
					<h2 class="title pull-left">Withdraw History</h2>
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
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Time</th>
											<th>Withdraw To</th>
											<th>Status</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$images=array(
												"BTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1.png",
												"ETH"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/1027.png",
												"LTC"=>"https://s2.coinmarketcap.com/static/img/coins/32x32/2.png"
											);
											$alliu=array(
												"Cancel"=>"danger",
												"Pending"=>"warning",
												"Paid"=>"success"
											);
											$dfjkghfd=$mysqli->query("SELECT * FROM `trans_receive` WHERE `user_trans`='".$member."' AND `type`='Withdraw' ORDER BY `serialno` DESC");
											while($AllTrans=mysqli_fetch_assoc($dfjkghfd)){
												$jhfgf=explode(":", $AllTrans['method']);
										?>
										
										<tr>
											<td>
												<?php echo date("d M-Y", strtotime($AllTrans['time'])); ?>
											</td>
											<td>
												<?php echo date("H:i:s", strtotime($AllTrans['time'])); ?>
											</td>
											<td>
												<img src="<?php echo $images[trim($jhfgf[0])];?>" style="width:32px;height:32px;"/>
												<?php 
												
												echo $jhfgf[1]; ?>
											</td>
											<td><span class="badge  w-70 round-<?php echo $alliu[$AllTrans['status']]; ?>"><?php echo $AllTrans['status']; ?></span></td>
											<td class="red-text boldy">- $<?php echo $AllTrans['ammount']-$AllTrans['tax']; ?></td>
										</tr>
										<?php } ?>
									
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</section>
		</div>
	</div>