	<div class="wrapper main-wrapper row" style='min-height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Sponsor List</h2>
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
											<th>User</th>
											<th>User Info</th>
											<th>Join Date</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$jkhg=$mysqli->query("SELECT * FROM `member` WHERE `sponsor`='".$member."'");
											while($AllSPonsor=mysqli_fetch_assoc($jkhg)){
												$PrrInf=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$AllSPonsor['log_user']."' OR `user`='".$AllSPonsor['user']."'"));
										?>
										<tr>
											<td>
												<div class="round img2">
													<img src="/member/photo/<?php echo $PrrInf['photo'];?>"  alt="">
												</div>
												<div class="designer-info">
													<h6><?php echo $AllSPonsor['user']; ?></h6>
												</div>
											</td>
											<td>	
												Name: <?php echo $PrrInf['name'];?><br/>
												Email: <?php echo $PrrInf['email'];?><br/>
												Phone: <?php echo $PrrInf['mobile'];?><br/>
											</td>
											<td><?php echo date("d M-Y", strtotime($AllSPonsor['time'])); ?></td>
											<td>
												<?php 
													if($AllSPonsor['paid']==1){
												?>
												<span class="badge  w-70 round-success">Active</span>
													<?php }else{ ?>
													<span class="badge  w-70 round-warning">Inactive</span>
													<?php } ?>
											</td>
											
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