	<div class="modal fade" id="PlaceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Placement Selection</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form>
			  <div class="form-group">
				<label style="color: #5a5757;" for="recipient-name" class="col-form-label">Placement:</label>
				
				<select class="form-control" id="recipient-name">
					<option value="1">Left</option>
					<option value="2">Right</option>
				</select>
			  </div>
			  
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" id="proceedS">Proceed</button>
		  </div>
		</div>
	  </div>
	</div>
	<script>
		$("#proceedS").on("click", function(){
			let dfgfd=$("#recipient-name").val();
			location.href='nz-register.php?keys='+btoa('<?php echo $memberInfo['user']."/"; ?>'+dfgfd);
		});
	</script>
	
	<div class="wrapper main-wrapper row" style=''>
		<div class='col-xs-12'>
			<div class="page-title">

				<div class="pull-left">
					<!-- PAGE HEADING TAG - START -->
					<h1 class="title">User Profile</h1>
					<!-- PAGE HEADING TAG - END -->
				</div>

				<div class="pull-right hidden-xs">
					<ol class="breadcrumb">
						<li>
							<a href="index.php?route=index&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Robo Trade Dashboard'); ?>"><i class="fa fa-home"></i>Home</a>
						</li>
						<li class="active" style="color:#fff;">
							<strong>User Profile</strong>
						</li>
					</ol>
				</div>

			</div>
		</div>
		<div class="clearfix"></div>
		<!-- MAIN CONTENT AREA STARTS -->

		<div class="col-lg-12">
			
			<div class="row">
				
				<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

					<section class="box has-border-left-3">
						<div class="content-body">    
							
						   <div class="uprofile-image mt-30">
								<img alt="" src="photo/<?php echo $ProfileInfo['photo']; ?>" class="img-responsive">
							</div>
							<div class="uprofile-name">
								<h3>
									<a href="#"><?php echo $ProfileInfo['name']; ?></a>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<span class="uprofile-status online"></span>
								</h3>
								<p class="uprofile-title"><?php
									if($memberInfo['paid']==1){
										echo "Active";
									}else{
										echo "Inactive";
									}
								?> Trader</p>
							</div>
							<div class="uprofile-info">
								<ul class="list-unstyled">
									<li><i class='fa fa-home'></i><?php echo $ProfileInfo['state']; ?>, <?php echo $ProfileInfo['country']; ?></li>
									<li><i class='fa fa-phone'></i> <?php echo $ProfileInfo['mobile']; ?></li>
									<li><i class='fa fa-envelope'></i><?php echo $ProfileInfo['email']; ?></li>
								</ul>
							</div>
							<div class="uprofile-buttons">
								<a href="index.php?route=edit_profile&tild=<?php echo base64_encode(time()); ?>&title=<?php urlencode('Profile Edit'); ?>" class="btn btn-md btn-primary">Edit Profile</a>
								<a class="btn btn-md btn-success"  data-toggle="modal" data-target="#PlaceModal" data-whatever="">Add New Trader</a>
							</div>
							<div class=" uprofile-social no-mb" style="display:none;">

								<a href="#" class="btn btn-primary btn-md facebook"><i class="fa fa-facebook icon-xs"></i></a>
								<a href="#" class="btn btn-primary btn-md twitter"><i class="fa fa-twitter icon-xs"></i></a>
								<a href="#" class="btn btn-primary btn-md google-plus"><i class="fa fa-google-plus icon-xs"></i></a>
								<a href="#" class="btn btn-primary btn-md dribbble"><i class="fa fa-dribbble icon-xs"></i></a>

							</div>
							
						</div>
					</section>
				</div>

				<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
					<section class="box has-border-left-3">
					   
						<div class="content-body ">    
							<div class="row">
							   
								<div class="form-container">
									<form action="#">

										<div class="row">
											<div class="col-xs-12">
												
												<div class="col-xs-12 mb-20 mt-30 no-pl no-pr">
												
													<div class="col-sm-12 avatar-img no-pl no-pr">
														<div class="ico-img">
															<i class="cc RADS" title="RADS"></i>
														</div>
														<div class="form-group">
															<h4 class="bold no-mt mb-5">Team View</h4>
															<span class="desc" style="margin-left:0">Personal Team</span>
														</div>
														<div class="table-responsive">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th>User ID</th>
																		<th>User Info</th>
																		<th>Join Date</th>
																		<th>Status</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																		$jksdhf=$mysqli->query("SELECT * FROM `member` WHERE `sponsor`='".$member."'");
																		while($Msfdds=mysqli_fetch_assoc($jksdhf)){
																			$Proff=mysqli_fetch_assoc($mysqli->query("SELECT `name`, `photo`,`mobile`,`email` FROM `profile` WHERE `user`='".$Msfdds['log_user']."' OR `user`='".$Msfdds['user']."'"));
																	?>
																	<tr>
																		<td>
																		<img style="width:60px;height:60px;border-radius:50%;" src="photo/<?php echo $Proff['photo']?>"><br/>
																		<?php echo $Msfdds['user']; ?></td>
																		<td>
																			Name: <?php echo $Proff['name']?><br/>
																			Contact: <?php echo $Proff['mobile']?><br/>
																			Email: <?php echo $Proff['email']?><br/>
																		</td>
																		<td><?php echo date("d M-Y", strtotime($Msfdds['time'])); ?></td>
																		<td><?php
																			if($Msfdds['paid']==1){
																				echo "Active";
																			}else{
																				echo "Inactive";
																			}
																		?></td>
																	</tr>
																	<?php } ?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<!-- MAIN CONTENT AREA ENDS -->
	</div>