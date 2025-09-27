<?php
    session_start(); 
	if(!isset($_SESSION['Admin'])){
    	header("Location:logout.php");
		exit();
    }
	
	include ("../db/db.php");
	include ("../db/functions.php");
	
	?>
	
	<table class="table table-bordered table-hover table-striped">
														<thead>
																<tr>
																	<th>SN:</th>       
																	<th>User:</th>
																	<th>User Info:</th>
																	<th>Registration:</th>
																	<th>Package:</th>
																	<th>Sponsor:</th>
																	<th>Ref:</th>
																	<th>Dep:</th>         
																	<th>Self Sponsor:</th>         
																	<th>Gen:</th>
																	<th>Rank:</th>
																	<th>Net:</th>                    
																	
																	<th>View Downline</th> 
																</tr>
															</thead>
<?php
	if(isset($_GET['user'])){
		$usertocheck = $_GET['user']; 
		$query = $mysqli->query("select * from member where user LIKE '%".$usertocheck."%'");
	}elseif(isset($_GET['hh'])){
		$vals=$_GET['hh'];
		$tables=$_GET['tbs'];
		$cols=$_GET['cols'];
		$query = $mysqli->query("select * from `$tables` where `$cols` LIKE '%".$vals."%'");
	}
	
	while($res= mysqli_fetch_object($query)){
	$mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE (`user`='".$res->user."' OR `log_user`='".$res->user."')"));
	$mghh211=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh['user']."' OR `user`='".$mghh['log_user']."'"));
	
	$mghh2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$mghh['sponsor']."'"));
	$mghh21=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh2['user']."' OR `user`='".$mghh2['log_user']."'"));
	
	$row1 = mysqli_fetch_array($mysqli->query("select * from `balance` where `user`='".$mghh['user']."'"));
	$row2 = mysqli_fetch_array($mysqli->query("select * from `profile` where `user`='".$mghh['log_user']."'"));
	
?>
														<tbody>
															<tr>
																<td><?php echo $res->serial; ?></td>     
																<td><a class="btn btn-success" href="member_login.php?user=<?php echo $mghh['user']; ?>" id="color"><?php echo $mghh['user']; ?></a></td> 
																<td>
																	
																	Name: <?php echo $mghh211['name']; ?><br/>
																	Email: <?php echo $mghh211['email']; ?><br/>
																	Mobile: <?php echo $mghh211['mobile']; ?><br/>
																	</td>
																<td>
																	<?php echo date("d M-Y", strtotime($mghh['time'])); ?><br/>
																	
																</td> 
																<td><?php
																		if($mghh['pack']!='0'){
																			$uuu=$mghh['pack'];
																			 $mghh22=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `upgrade` WHERE `user`='".$mghh['user']."' ORDER BY `serial` ASC"));
																			$packnnm=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$mghh['pack']."' "));
																			echo "<span style='color:#FFF;padding:10px;background-color:".$packnnm['color']."'>" . $packnnm['pack'] ."</span> <p style='margin-top: 8px;'>";
																			echo date("d M-Y", strtotime($mghh22['date'])) ."</p>";
																		}else{
																			echo  "Starter";
																		}
																	?></td>   
																<td>
																Login ID: <?php echo $mghh['sponsor']; ?><br/>
																Name: <?php echo $mghh21['name']; ?><br/>
																Email: <?php echo $mghh21['email']; ?><br/>
																Mobile: <?php echo $mghh21['mobile']; ?><br/>
																</td>
																<td><?php echo $row1['direct_taka']; ?></td>
																<td><?php echo $row1['bcpp_taka']; ?></td>
																<td>
																		<a href="member_total_sponsor.php?uud=<?php echo base64_encode($mghh['user']); ?>" class="btn btn-danger">
																			<?php
																				echo mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `sponsor`='".$mghh['user']."' AND `pack`>'0'"));
																			?>
																		</a>
																	</td>   	 
																<td><?php echo $row1['generation_taka']; ?></td>
																<td></td>
																<td><?php echo remainAmn($mghh['user']); ?></td>
																
																<td>
																	<a href="member_downline.php?ref=<?php echo $mghh['user']; ?>" class="btn btn-info">View Downline</a>
																	<a href="member_upline.php?ref=<?php echo $mghh['user']; ?>" class="btn btn-warning">View Upline</a>
																</td>
															</tr>
														</tbody>
<?php } ?>
													</table>

	