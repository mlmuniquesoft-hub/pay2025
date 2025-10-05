<?php require_once("part/top_header.php"); ?>
<?php require_once("part/top_option.php"); ?>

    <!-- END TOPBAR -->
    <!-- START CONTAINER -->
    <div class="page-container row-fluid container-fluid">

        <!-- SIDEBAR - START -->

        <?php require_once("part/sidebar.php"); ?>
        <!--  SIDEBAR - END -->
		<style>
			#main-content.sidebar_shift {
				margin-left: 45px;
				margin-right: 0;
			}
		</style>
        <!-- START CONTENT -->
        <section id="main-content" class=" " style=" background-image:url(image/term_bg.jpg) /*background: #1163ab;*/">
            <div style="background:#0c0c0c36">
				<div class="row" style="margin-top: 60px;margin-bottom: -60px;">
					<div class="col-sm-12">
						<?php
							$NoticeK=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `notice`"));
						?>
						<h2 style="margin-top: 28px;font-family:Georgia; color:<?php echo $NoticeK['color']; ?>"><marquee><?php echo $NoticeK['body']; ?></marquee></h2>
					</div>
				</div>
			<?php
				$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
				if(!isset($_GET['route'])){
					include("view/index.php");
				}else{
					if($_GET['route']=="tree_view"){
						echo "<script>javascript:location.href='tree/index.php'</script>";
						die();
						
					}else{
						$fileE="view/".$_GET['route'].".php";
					}
					
					if (file_exists($fileE)) {
						include($fileE);
					}else{
						include("view/index.php");
					}
				}
				
				$Sexcv=array_keys($_SESSION);
				foreach($Sexcv as $KEys){
					$Mdf=substr($KEys,0,3);
					if($Mdf=="msg"){
						//echo $Mdf;
						unset($_SESSION[$KEys]);
					}
					
				}
			?>
			</div>
        </section>
		<span id="MemberName" data-name="<?php echo $ProfileInfo['name']; ?>"></span>
		<?php
			$CheckRank=$mysqli->query("SELECT * FROM `ranks` WHERE `user`='".$member."' ORDER BY `serial` DESC");
			$kljgk=mysqli_num_rows($CheckRank);
			if($kljgk>0){
				$InRagf=mysqli_fetch_assoc($CheckRank);
				$RankPO= "Congratulation ".$ProfileInfo['name']." On Achieved ". strtoupper($InRagf['rank']);
			}else{
				$RankPO= "Welcome ".$ProfileInfo['name'] ." To " . $Tiell;
			}
		?>
		<script>
			 var rev = "fwd";
    function titlebar(val){
        var msg  = "<?php echo $RankPO; ?>";
        var res = " ";
        var speed = 300;
        var pos = val;
        msg = " "+msg+" ";
        var le = msg.length;
        if(rev == "fwd"){
            if(pos < le){
                pos = pos+1;
                scroll = msg.substr(0,pos);
                document.title = scroll;
				$("#Hometitle").text(scroll);
                timer = window.setTimeout("titlebar("+pos+")",speed);
            }
            else {
                rev = "bwd";
                timer = window.setTimeout("titlebar("+pos+")",speed);
            }
        }else {
            if(pos > 0) {
                pos = pos-1;
                var ale = le-pos;
                scrol = msg.substr(ale,le);
                document.title = scrol;
				$("#Hometitle").text(scroll);
                timer = window.setTimeout("titlebar("+pos+")",speed);
            }
            else {
                rev = "fwd";
                timer = window.setTimeout("titlebar("+pos+")",speed);
            }
        }
    }
    titlebar(0);
		</script>
		
		
        <!-- END CONTENT -->
        <?php require_once("part/footer.php"); ?>