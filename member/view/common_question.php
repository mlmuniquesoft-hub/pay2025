	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#e8b82bcf">
				<header class="panel_header">
					<h2 class="title pull-left" style="color: #7ef735;">Rank Report</h2>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive" data-pattern="priority-columns" style="color:#000;font-weight: bold;font-size: 14px;">
								<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
									<thead>
										<tr style="color: #7ef735;">
											<th>Rank</th>
											<th>Present Score</th>
											<th>Require Score</th>
											<th>Level</th>
											<th>Condition</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$jhgdInfo=mysqli_fetch_assoc($mysqli->query("SELECT SUM(matching) as amnfg FROM `binary_income` WHERE `user`='".$member."'"));
											$Score=$jhgdInfo['amnfg'];
											//var_dump($Score);
										?>
										<?php
											$ranksh=array("Silver Star 1","Silver Star 2",
											"Gold Star 1","Gold Star 2",
											"Diamond Star","White Diamond Star","Gold Diamond Star","Platinum Diamond Star","President Diamond Star",
											"Lord President","Ambassador"
											);
											$rankshCons=array("Sponsor Each Side","Sponsor Each Side",
											"Need Personal Sponsored Two<br/><span style='color: #11d0ef;'>Silver Star 01 Each Side</span>",
											"Need Personal Sponsored Two<br/><span style='color: #11d0ef;'>Gold Star 01 Each Side</span>",
											"Need Personal Sponsored Two<br/><span style='color: #11d0ef;'>Gold Star 01 Each Side</span>",
											"Need Personal Sponsored Two<br/><span style='color: #11d0ef;'>Gold Star 02 Each Side</span>",
											"Need Personal Sponsored Three<br/><span style='color: #11d0ef;'>Diamond Star Each Side</span>",
											"Need Personal Sponsored Three<br/><span style='color: #11d0ef;'>White Diamond Star Each Side</span>",
											"Need Personal Sponsored Two<br/><span style='color: #11d0ef;'>Platinum Diamond Star Each Side</span>",
											"Need Personal Sponsored Four<br/><span style='color: #11d0ef;'>President Diamond Star Each Side</span>",
											"Need Personal Sponsored Five<br/><span style='color: #11d0ef;'>Lord President Each Side</span>"
											);
											
											$requirCons=array(100, 200,1000,5000,20000,50000,150000,300000,500000,1000000,2000000);
											$i=0;
											foreach($requirCons as $ranks){
												$jkshd="Pending";
												
										?>
										<tr>
											<td>
												<?php echo $ranksh[$i]; ?>
											</td>
											<td><?php
												if($Score>0){
													if($Score>=$ranks){
														echo $ranks;
														//$jkshd="Achieved";
														$Score=$Score-$ranks;
													}else{
														echo $Score;
														$Score=0;
													}
												}else{
													echo 0;
												}
												
											?></td>
											<td>	
												<?php echo $ranks; ?>
											
											</td>
											
											<td>
												Level <?php echo $i; ?>
											</td>
											<td>
												<?php echo $rankshCons[$i]; ?>
											</td>
											
											<td>
												<?php 
												$hgsfs=mysqli_num_rows($mysqli->query("SELECT `serial` FROM `ranks` WHERE `user`='".$member."' AND `rank`='".$ranksh[$i]."'"));
												if($hgsfs>0){
													echo "Achieved";
												}else{
													echo "Pending";
												}
												
												?>
											</td>
											
										</tr>
										<?php $i++;} ?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</section>
		</div>
	</div>