	<?php
											
	?>
	<div class="wrapper main-wrapper row" style='height:100vh'>
		<div class="col-lg-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Total Member List</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<div class="row">
						<div class="col-sm-12">
							<!--<input type="text" id="yyy" placeholder="Search User" class="form-control" />
							  <input type="text" class="form-control" id="yyy" placeholder="Search User" aria-label="...">-->
							  <div class="input-group mb-12" style="width:50%;">
								  <input type="text" style="width:50%;" id="UserVal" class="form-control" placeholder="Search User" aria-label="Search User" aria-describedby="basic-addon2">
								  <div class="input-group-append">
									<button class="btn btn-info" id="Search" type="button">Search</button>
								  </div>
								</div>
						</div>
						<div class="col-xs-12">
							<div class="table-responsive" id="DepositReport" data-pattern="priority-columns">
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
											$InfoDeposiSt=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$member."'"));
											
											$LeftMember=explode(",",$InfoDeposiSt['totalLeftId']);
											$RightMember=explode(",",$InfoDeposiSt['totalrightId']);
											$Allmerber=array_merge($LeftMember,$RightMember);
											
											//$t = count($Allmerber); //$mysqli->query("SELECT * FROM balance ");
											
											$total_items= count($Allmerber);
											$limit=$_GET['limit'];
											$type=$_GET['type'];
											$page=$_GET['page'];
											if((!$limit)  || (is_numeric($limit) == false) || ($limit < 29) || ($limit > 31))
											{$limit = 30; }
											if((!$page) || (is_numeric($page) == false) || ($page < 0) || ($page > $total_items))
											{$page = 1; }
																
											$total_pages= ceil($total_items / $limit);
											$set_limit=$page * $limit - ($limit);					
											$sjhfs=array_slice($Allmerber,$set_limit, $limit);
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
										<?php } ?>
									</tbody>
								
								</table>
								<p align="center" style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> 
<?php 
	$cat = urlencode($cat);
$Newds="route=member_list&tild=MTU5NDM4Njg2Nw==";
	$prev_page = $page - 1;if($prev_page >= 1){echo("<b>&lt;&lt;</b> <a href=?$Newds&amp;limit=$limit&amp;page=$prev_page><b>Prev</b></a>");}
	$a = $page ;if($a <= $total_pages){ echo("|<a href=?$Newds&amp;limit=$limit&amp;page=$a><b>$a</b></a>|");}			
	$b = $page + 1;if($b <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$b><b>$b</b></a>|");}			
	$c = $page + 2;if($c <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$c><b>$c</b></a>|");}	
	$d = $page + 3;if($d <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$d = $page + 4;if($d <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$d><b>$d</b></a>|");}
	$e = $page + 5;if($e <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$e><b>$e</b></a>|");}			
	$f = $page + 6;if($f <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$f><b>$f</b></a>|");}			
	$g = $page + 7;if($g <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$g><b>$g</b></a>|");}
	$h = $page + 8;if($h <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$h><b>$h</b></a>|");}			
	$i = $page + 9;if($i <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$i><b>$i</b></a>|");}			
	$j = $page + 10;if($j <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$j><b>$j</b></a>|");}
	$next_page = $page + 1;if($next_page <= $total_pages){ echo("<a href=?$Newds&amp;limit=$limit&amp;page=$next_page><b>Next</b></a> &gt;&gt;");}
?>	
	<form method="get" action="" style="text-align: center;">
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;">Total Pages </span>
		
		<b style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:blue;font-size:13px;">
		<?php echo $total_pages;?></b>
		
		<span style="font-family:MV Boli, Helvetica, sans-serif, Arial;align:center;color:red;font-size:13px;"> Show 
			<input type="text"  name="page" value="<?php echo $page;?>" size="4" />
			<input type="hidden" name="limit" value="<?php echo $limit;?>" />
		</span>
		<input type="submit"  value="Submit" /> 
	</form>     
</p>
							</div>

						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
		$("#Search").on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			let dfgd=$("#UserVal").val();
			if(dfgd!=''){
				const Rewer=$.ajax({
					method:"GET",
					url:"viewdata/serch_down.php",
					data:{usdf:dfgd}
				});
				Rewer.done(function(redfg){
					$("#DepositReport").html(redfg);
				})
			}
		});
	</script>