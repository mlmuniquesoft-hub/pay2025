<div class="wrapper main-wrapper row" style='min-height:100vh'>
	<?php
	function downUserQW($users,$table){
		global $mysqli;
		$fff=array();
		if(is_array($users)){
			foreach($users as $user){
				$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$user."'");
				while($spp=mysqli_fetch_assoc($uu)){
					array_push($fff, $spp['user']);
				}
			}
		}else{
			$uu=$mysqli->query("select `sponsor`,`user` from `$table` where sponsor='".$users."'");
			while($spp=mysqli_fetch_assoc($uu)){
				array_push($fff, $spp['user']);
			}
		}
		return $fff;
	}
	$Userfg=array();
	$ttt2=downUserQW($member,'member');
	$Userfg[0]=$ttt2;
	for($i=1;$i<=14;$i++){
		$ttt2=downUserQW($ttt2,'member');
		$Userfg[$i]=$ttt2;
	}
	
?>
	
		<div class="col-md-12">
			<section class="box" style="background:#211c8896">
				<header class="panel_header">
					<h2 class="title pull-left">Unilevel Team</h2>
					<div class="actions panel_actions pull-right">
						<a class="box_toggle fa fa-chevron-down"></a>
						<a class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></a>
						<a class="box_close fa fa-times"></a>
					</div>
				</header>
				<div class="content-body">
					<h3>Welcome <?php echo $ProfileInfo['name']; ?> to your Unilevel  team!</h3>
					
					
					<div class="form-group">
						<div class="selectgroup selectgroup-pills">
							<?php
								for($i=0;$i<10;$i++){
									$userCount=count($Userfg[$i]);
									if($userCount>0){
							?>
							<label class="selectgroup-item" style="margin:10px;background: #4128be;padding: 11px;">
								<input type="radio" name="pays" value="<?php echo $i; ?>" class="selectgroup-input" <?php if($i==0){ echo "checked";}?> />
								<span class="selectgroup-button">Level <?php echo $i+1; ?> <br/> <?php echo $userCount; ?> T.M</span>
							</label>
							<span id="level<?php echo $i; ?>" data-uus="<?php echo base64_encode(implode(",",$Userfg[$i])); ?>"></span>
							<?php } } ?>
						</div>
					</div>
					<br/>
					<div class="table-responsive" id="information">
						
							<thead>
								<tr>
									<th>Position</th>
									<th>Name</th>
									<th>Sponsor Key</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Position</th>
									<th>Name</th>
									<th>Sponsor Key</th>
								</tr>
							</tfoot>
							<tbody>
								<tr>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	
	
	<script>
		const UserInfo=(userList)=>{
			let redf=$.ajax({
				method:"POST",
				url:'viewdata/cooperative.php',
				data:{userfg:userList}
			});
			redf.done((ress)=>{
				
				$("#information").html(ress);
				
			});
		}
		let BaseUdf=$("#level0").attr("data-uus");
		UserInfo(BaseUdf);
		$(".selectgroup-input").on("click", function(){
			let Ledf=$(this).val();
			let UserlIst=$("#level"+Ledf).attr("data-uus");
			UserInfo(UserlIst);
			//DaterTadle();
		});
		
	</script>
</div>