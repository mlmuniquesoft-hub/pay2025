	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-lg-12">
			<section class="box">
				<header class="panel_header">
					<h2 class="title pull-left">Notification Details</h2>
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
											<th>Details</th>
											<th>Type</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$dfjkghfd=$mysqli->query("SELECT * FROM `view` WHERE `user`='".$member."' ORDER BY `serial` DESC LIMIT 30");
											while($AllTrans=mysqli_fetch_assoc($dfjkghfd)){
												if($AllTrans['types']=="credit"){
													$dfgdf="green-text";
													$sfs="round-success";
													
												}elseif($AllTrans['types']=="debit"){
													$dfgdf="red-text";
													$sfs="round-warning";
												}else{
													$dfgdf="white-text";
												}
										?>
										<tr>
											<td>
												<?php echo date("d M-Y", strtotime($AllTrans['date'])); ?>
											</td>
											<td>
												<?php echo date("H:i:s", strtotime($AllTrans['time'])); ?>
											</td>
											<td>
												<?php echo $AllTrans['description']; ?>
											</td>
											<td><span style="paddin:10px;" class="badge  w-70 <?php echo $sfs; ?>"><?php echo strtoupper($AllTrans['types']); ?></span></td>
											<td class="<?php echo $dfgdf; ?> boldy">$<?php echo $AllTrans['amount']; ?></td>
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