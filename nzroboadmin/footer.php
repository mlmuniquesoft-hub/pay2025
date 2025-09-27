        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right"><?php echo $Commn; ?>. <a href="<?php echo $acVbbb; ?>"><i class="fa fa-long-arrow-up"></i></a></span> © <?php echo date("Y"); ?> Copyright.
            </div>
        </footer>
		<?php 
			unset($_SESSION['msg']);
			unset($_SESSION['msg1']);
			mysqli_close($mysqli);
			mysqli_close($mysqli3);
			mysqli_close($mysqli4);
		?>