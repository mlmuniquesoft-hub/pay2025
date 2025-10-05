        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right"><?php echo isset($Commn) ? $Commn : 'Capitol Money Pay'; ?>. <a href="<?php echo isset($acVbbb) ? $acVbbb : '#'; ?>"><i class="fa fa-long-arrow-up"></i></a></span> © <?php echo date("Y"); ?> Copyright.
            </div>
        </footer>
		<?php 
			// Clear session messages
			if(isset($_SESSION['msg'])) unset($_SESSION['msg']);
			if(isset($_SESSION['msg1'])) unset($_SESSION['msg1']);
			
			// Close database connections if they exist
			if(isset($mysqli) && $mysqli instanceof mysqli) {
				mysqli_close($mysqli);
			}
			if(isset($mysqli3) && $mysqli3 instanceof mysqli) {
				mysqli_close($mysqli3);
			}
			if(isset($mysqli4) && $mysqli4 instanceof mysqli) {
				mysqli_close($mysqli4);
			}
		?>