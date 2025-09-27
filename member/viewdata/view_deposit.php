<?php
	session_start();
	require_once("../../db/db.php");
	$member=$_SESSION['roboMember'];
?>	
	<table id="tech-companies-1" class="table vm trans table-small-font no-mb table-bordered table-striped">
		<thead>
			<tr>
				<th>Crypto Wallet</th>
				<th>Transaction Hash</th>
				<th>Time</th>
				<th>Status</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$InfoDeposit=$mysqli->query("SELECT * FROM `req_fund` WHERE `user`='".$member."'");
				while($allDeposit=mysqli_fetch_assoc($InfoDeposit)){
			?>
			<tr>
				<td>
					<div class="round img2">
						<img src="../data/crypto-dash/coin1.png" alt="">
					</div>
					<div class="designer-info">
						<h6>Bitcoin</h6>
					</div>
				</td>
				<td>
					<a class="btn btn-info" target="_blank" href="https://www.blockchain.com/btc/tx/<?php echo $allDeposit['uniq_number']; ?>">
						<?php echo substr($allDeposit['uniq_number'],0,20); ?>
					</a>
				</td>
				<td><small class="text-muted"><?php echo date("d M-Y H:i:s", strtotime($allDeposit['date'])); ?></small></td>
				<td><span class="badge  w-70 round-success">completed</span></td>
				<td class="green-text boldy">
				
				<?php //echo $allDeposit['amount']/100000000; ?> 
				+ $ <?php echo number_format($allDeposit['amount'], 2, '.',''); ?>
				
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>