<?php
	function InfoPartTree($user,$upline){
		global $mysqli;
		 $coolk="#FFF";
		if($user!=''){
			$kkll2=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user`,`pack`,`point` FROM `member` WHERE `user`='".$user."'"));
			$kkll=$mysqli->query("SELECT `user`, `name`, `photo` FROM `profile` WHERE `user`='".$kkll2['log_user']."'");
			$checkUser=mysqli_num_rows($kkll);
			if($checkUser>0){
				if($kkll2['pack']>0){
					$mgnn=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `package` WHERE `serial`='".$kkll2['pack']."'"));
					$color=$mgnn['color'];
					if(($mgnn['pack']=="NZBOT500")||($mgnn['pack']=="NZBOT300")||($mgnn['pack']=="NZBOT50000")){
						$coolk="#040404";
					}
				}else{
					$color="#90909a";
				}
				$mnmn=mysqli_fetch_assoc($kkll);
				$name=$mnmn['name'];
				$user=$kkll2['user'];
				$photo="../photo/".$mnmn['photo'];
				$link="index.php?ref=".base64_encode($kkll2['user']);
			}else{
				$color="#90909a";
				$name="Add Here";
				$user="Add Here";
				$photo="img/add.png";
				$link="#register.php?spon=".base64_encode($_SESSION['winMember']) ."&place=".base64_encode($upline);
			}
		}else{
			$color="#90909a";
			$name="Add Here";
			$user="Add Here";
			$photo="img/add.png";
			$link="#register.php?spon=".base64_encode($_SESSION['winMember']) ."&place=".base64_encode($upline);
		}
?>
	<div class="node" style="border-radius: 7px;cursor: default;min-width:110px !important;height:auto !important;">
		<a href="<?php echo $link; ?>" id="level-0">
			<img style="width:70px!important;height:70px!important;border-radius: 0%!important;border: 2px solid #454552 !important;" class="tree_icon" src="<?php echo $photo; ?>" alt="<?php echo $user; ?>" id="userlink_<?php echo $user; ?>" onclick="getGenologyTree(&quot;INF750391&quot;,event);"  title="">
		</a>
		
		<div class="username" style="color:<?php echo $coolk; ?>;border-radius: 10px; border:2px solid #FFF; margin-top: 2px;background: <?php echo $color;?> !important;"><?php echo $user; ?>
		<?php
			$hjs=$mysqli->query("SELECT * FROM `ranks` WHERE `user`='".$user."' ORDER BY `serial` DESC");
			$jjks=mysqli_num_rows($hjs);
			if($jjks>0){
				$RankInfo=mysqli_fetch_assoc($hjs);
				$RankName=explode(" ", $RankInfo['rank']);
		?>
		<div class="username" style="color: #0c0c0c;border-radius: 10px;border:2px solid #FFF;margin-top: 2px;background: #dee125 !important;font-weight: bold;"><?php 
		foreach($RankName as $Hgsd){
			echo substr($Hgsd,0,1) ." ";
		}
		 ?>
		<?php
		}
		if($kkll2['pack']>0){ ?>
		<?php //echo "<br/>". $mgnn['pack']; ?>
		<?php } ?>
		</div>
	</div>
<?php } ?>

<?php
	function TreeView($user,$upline){
?>
	<td class="node-container" colspan="2">
		<table id="tree_div" cellpadding="0" cellspacing="0" border="0" align="center">
			<tbody>
				<tr class="node-cells">
					<td class="node-cell" colspan="4">
						<?php 
							InfoPartTree($user,$upline);
							$userLeftt=leftRightww12($user, "member");
						?>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div class="line down"></div>
					</td>
				</tr>
				<tr>
					<td class="line left">&nbsp;</td>
					<td class="line right top">&nbsp;</td>
					<td class="line left top">&nbsp;</td>
					<td class="line right">&nbsp;</td>
				</tr>
				<tr>
					<td class="node-container" colspan="2">
						<table id="tree_div" cellpadding="0" cellspacing="0" border="0" align="center">
							<tbody>
								<tr class="node-cells">
									<td class="node-cell" colspan="4">
										<?php 
										InfoPartTree($userLeftt['left'],$user);
										$userLeftt1=leftRightww12($userLeftt['left'], "member");
										
										?>
									</td>
								</tr>
								
								
							</tbody>
						</table>
					</td>
					<td class="node-container" colspan="2">
						<table id="tree_div" cellpadding="0" cellspacing="0" border="0" align="center">
							<tbody>
								<tr class="node-cells">
									<td class="node-cell" colspan="4">
										<?php 
											InfoPartTree($userLeftt['right'],$user);
											$userLeftt2=leftRightww12($userLeftt['right'], "member");
										?>
									</td>
								</tr>
								
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
	<?php } ?>