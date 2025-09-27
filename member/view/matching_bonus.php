	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Matching Bonus</h2>
					
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive" data-pattern="priority-columns">
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Bonus</th>
											<th>Matching Score</th>
											<th>Balance Scores</th>
											<th>Remaining Score</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$jkhg=$mysqli->query("SELECT * FROM `binary_income` WHERE `user`='".$member."' AND `slot_match`>'0' ORDER BY `serial` DESC LIMIT 30");
											while($AllSPonsor=mysqli_fetch_assoc($jkhg)){
										?>
										<tr>
											<td>
												<?php echo date("d M-Y", strtotime($AllSPonsor['date'])); ?>
											</td>
											<td>$<?php echo floor($AllSPonsor['slot_match']); ?></td>
											<td><?php echo floor($AllSPonsor['matching']); ?></td>
											<td>	
												<?php 
													$dfg=explode("/", $AllSPonsor['total_sale']);
													foreach($dfg as $hgf){
														echo $hgf ."<br/>";
													}
												?>
											</td>
											
											<td><?php if($AllSPonsor['cary']>0){ echo $AllSPonsor['carry_id']." : ". floor($AllSPonsor['cary']);}else{echo "0"; } ?></td>

											
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