<?php
	session_start();
	if(!isset($_SESSION['roboMember'])){
		header("Location: logout.php");
		exit();
	}else{
		require_once("../../db/db.php");
		$UserList=explode(",", base64_decode($_POST['userfg']));
		
		if($UserList[0]!=''){
?>
	<table id="basic-datatables" class="display table table-striped table-hover" >
		<thead>
			<tr>
				<th>Serial</th>
				<th>Name</th>
				<th>User ID</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Serial</th>
				<th>Name</th>
				<th>User ID</th>
			</tr>
		</tfoot>
<?php
			$n=1;
			foreach($UserList as $user){
				$palsdf=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user`,`position` FROM `member` WHERE `user`='".$user."'"));
				$palsdfPro=mysqli_fetch_assoc($mysqli->query("SELECT `name` FROM `profile` WHERE `user`='".$user."' OR `user`='".$palsdf['log_user']."'"));
?>
				<tbody>
					<tr>
						<td><?php echo $n++; ?></td>
						<td><?php echo $palsdfPro['name']; ?></td>
						<td><?php echo $palsdf['user']; ?></td>
					</tr>
				</tbody>
<?php
			}
?>
</table>
<?php
		}else{
?>
	<td colspan='3'><h3 class="text-center text-danger">No Member Found</h3></td>
<?php			
		}
		
		
	}
?>
