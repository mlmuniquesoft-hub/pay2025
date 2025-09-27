	<div class="wrapper main-wrapper row" style=''>
		<div class="col-xs-12 col-md-4">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Update Profile Picture</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<form id="Profile_pIsv" action="photo_action.php" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<?php if(isset($_SESSION['msg'])){ ?>
									<h3 class="alert alert-danger"><?php echo $_SESSION['msg']; ?></h3>
									<?php } ?>
									<?php if(isset($_SESSION['msg1'])){ ?>
									<h3 class="alert alert-success"><?php echo $_SESSION['msg1']; ?></h3>
									<?php } ?>
								</div>
								<div class="form-group">
									<img src="photo/<?php echo $ProfileInfo['photo']; ?>">
								</div>
								<div class="form-group">
									<label class="form-label" for="field-2">New Image</label>
									
									<div class="controls">
										<input type="file"  class="form-control" name="userfile" id="userfile">
										<input type="hidden"  value="<?php echo $actual_link; ?>" name="location" id="location">
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info" >Update Picture</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="col-xs-12 col-md-8">
			<section class="box ">
				<header class="panel_header">
					<h2 class="title pull-left">Update Profile Information</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-md-8 col-sm-9 col-xs-12">
							<form id="ProfileUdate" method="POST" action="profile_action.php" >
								<?php if(isset($_SESSION['msg3'])){ ?>
								<h3 class="alert alert-success"><?php echo $_SESSION['msg3']; ?></h3>
								<?php } ?>
								<div class="form-group">
									<label class="form-label" for="field-1">Name</label>
									
									<div class="controls">
										<input type="text" class="form-control" value="<?php echo $ProfileInfo['name']; ?>" name="Name" id="Name" >
									</div>
								</div>

								<div class="form-group">
									<label class="form-label" for="field-2">Email</label>
									
									<div class="controls">
										<input type="text" value="<?php echo $ProfileInfo['email']; ?>" class="form-control" id="email" readonly />
									</div>
								</div>

								<div class="form-group">
									<label class="form-label" for="field-3">Phone</label>
									
									<div class="controls">
										<input type="text" class="form-control" value="<?php echo $ProfileInfo['mobile']; ?>" name="mobile" id="mobile" readonly />
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="form-label" for="field-3">State</label>
									<span class="desc"></span>
									<div class="controls">
										<input type="text" class="form-control" value="<?php echo $ProfileInfo['state']; ?>" name="state" id="state">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-3">Country</label>
									<span class="desc"></span>
									<div class="controls">
										<select class="form-control" name="country" id="country">
											<option value=''>Select Country</option>
											<?php
												$jhgd=$mysqli->query("SELECT * FROM `country`");
												while($ALCoutry=mysqli_fetch_assoc($jhgd)){
											?>
											<option value='<?php echo $ALCoutry['name']; ?>' <?php if($ALCoutry['name']==$ProfileInfo['country']){echo "selected";} ?>><?php echo $ALCoutry['name']; ?></option>
											<?php } ?>
										</select>
										
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="field-3">Zip Code</label>
									<span class="desc"></span>
									<div class="controls">
										<input type="text" class="form-control" value="<?php echo $ProfileInfo['postal']; ?>" name="postal" id="postal">
										<input type="hidden"  value="<?php echo $actual_link; ?>" name="location" id="location">
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-info" >Update Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
		/*$("#ProfileUdate").on("submit", function(e){
			e.preventDefault();
			e.stopPropagation();
			let Dtaj=$(this).serialize();
		});*/
	</script>