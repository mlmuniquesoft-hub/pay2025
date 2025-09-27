<?php
	session_start();
	require_once("../../db/db.php");
	require_once("../../db/functions.php");
	$Usdf=$_GET['usdf'];
?>
	<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
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
			</tr>
		</thead>
		<tbody>
			<?php
				$InfoDeposiSt=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$_SESSION['roboMember']."'"));
				
				$LeftMember=explode(",",strtolower($InfoDeposiSt['totalLeftId']));
				$RightMember=explode(",",strtolower($InfoDeposiSt['totalrightId']));
				$Allmerber=array_merge($LeftMember,$RightMember);
				$Usdf=strtolower($Usdf);
				//var_dump($Usdf);
				//var_dump($Allmerber);
				if(in_array($Usdf,$Allmerber)){
				//$t = count($Allmerber); //$mysqli->query("SELECT * FROM balance ");
				$AllmerberList=array();
				array_push($AllmerberList,$Usdf);
				
				$total_items= count($AllmerberList);
				$limit=$_GET['limit'];
				$type=$_GET['type'];
				$page=$_GET['page'];
				if((!$limit)  || (is_numeric($limit) == false) || ($limit < 29) || ($limit > 31))
				{$limit = 30; }
				if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
				{$page = 1; }
									
				$total_pages= ceil($total_items / $limit);
				$set_limit=$page * $limit - ($limit);					
				$sjhfs=array_slice($AllmerberList,$set_limit, $limit);
				$i=1;
				foreach($sjhfs as $memberAS){
					$q =  $mysqli->query("SELECT * FROM balance WHERE `user`='".$memberAS."'");
					$querygetexeres= mysqli_fetch_object($q);
					$mghh=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$querygetexeres->user."'"));
					$mghh211=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh['user']."' OR `user`='".$mghh['log_user']."'"));
					  
					$mghh2=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member` WHERE `user`='".$mghh['sponsor']."'"));
					$mghh21=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `profile` WHERE `user`='".$mghh2['user']."' OR `user`='".$mghh2['log_user']."'"));
			?>
			<tr>
				<td><?php echo $i++; ?></td>     
				<td><a class="btn btn-success" href="#member_login.php?user=<?php echo $querygetexeres->user; ?>" id="color"><?php echo $querygetexeres->user; ?></a></td> 
				<td>
				
				Name: <?php echo $mghh211['name']; ?><br/>
				Email: <?php echo $mghh211['email']; ?><br/>
				Mobile: <?php echo $mghh211['mobile']; ?><br/>
				</td>
				<td>
					<?php echo date("d M-Y", strtotime($mghh['time'])); ?><br/>
					
				</td> 
				<td><?php
					if($mghh['pack']!=0){
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
				
				
				<td><?php echo $querygetexeres->direct_taka; ?></td>
				<td><?php echo $querygetexeres->bcpp_taka; ?></td>
				<td>
					<a href="#member_total_sponsor.php?uud=<?php echo base64_encode($querygetexeres->user); ?>" class="btn btn-danger">
						<?php
							echo mysqli_num_rows($mysqli->query("SELECT `user` FROM `member` WHERE `sponsor`='".$querygetexeres->user."' AND `pack`>'0'"));
						?>
					</a>
					
				</td>  	 
				<td><?php echo $querygetexeres->generation_taka; ?></td> 
				<td></td>  	 
				<td><?php echo remainAmn($querygetexeres->user); ?></td>
				
				
			</tr>
				<?php } }else{  ?>
					<h3 class="text-center text-danger">User Not Found</h3>
				<?php } ?>
		</tbody>
	
	</table>