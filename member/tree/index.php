<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!-- Debug: Starting tree page -->\n";

// Check session first before including files
session_start();
if(!isset($_SESSION['roboMember'])){
    echo "<!DOCTYPE html><html><head><title>Access Denied</title></head><body>";
    echo "<h1>Access Denied</h1><p>Please <a href='../nz-login.html'>login</a> to view this page.</p>";
    echo "</body></html>";
    exit();
}

echo "<!-- Debug: Session check passed for user: " . $_SESSION['roboMember'] . " -->\n";

// Now safely include database files
try {
    require_once("../../db/db.php");
    echo "<!-- Debug: Database connected -->\n";
    require_once("../../db/functions.php");
    echo "<!-- Debug: Functions loaded -->\n";
} catch(Exception $e) {
    echo "<!DOCTYPE html><html><head><title>Database Error</title></head><body>";
    echo "<h1>Database Error</h1><p>" . $e->getMessage() . "</p>";
    echo "</body></html>";
    exit();
}

// Load tree functions
require_once("../part/top_header2.php");
require_once("../part/top_option.php");

include("../part/sideTree.php");

echo "<!-- Debug: sideTree.php loaded -->\n";

$i=0;

		if(isset($_GET['ref22'])){
			$_GET['ref']=base64_encode($_GET['ref22']);
		}
		$refer = isset($_GET['ref']) ? $_GET['ref'] : '';
		$tableq = isset($_GET['table']) ? $_GET['table'] : '';
		if($refer==''){
			$referral=strtolower($_SESSION['roboMember']);
		}elseif($refer!=''){
			$referral=strtolower(base64_decode($_GET['ref']));
		}
		//$ttt=array();
		$iiuu=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `member_total` WHERE `user`='".$_SESSION['roboMember']."'"));
		
		// Check if member_total data exists, provide defaults if not
		if(!$iiuu || $iiuu === null) {
			$iiuu = array(
				'totalLeftId' => '',
				'totalrightId' => ''
			);
		}
		
		$leftall=explode(",", strtolower($iiuu['totalLeftId']));
		$rightall=explode(",", strtolower($iiuu['totalrightId']));
		$ttt=array_merge($leftall,$rightall);
		array_unshift($ttt,$referral);
		//TreeUserDown($_SESSION['roboMember'], "member", "user", $ttt);
		//var_dump($ttt);
		if($referral!=$_SESSION['roboMember']){
			if(!in_array($referral, $ttt)){
				echo "<script>javascript:history.back()</script>";
				die();
			}
		}
		array_unshift($ttt, $referral);
		
		//$ttt = array_slice($ttt, 0, 150);
		
		/*if($tableq==''){
			$ffj=base64_encode("member");
			header("Location: tree.php?table=$ffj");
			exit();
		}elseif($tableq!=''){
			$table=base64_decode($_GET['table']);
		}*/
		$table="member";

		function CountUserss12($user,$table, $sess){
			global $mysqli;
			$users=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$user."'");
			while($user=mysqli_fetch_assoc($users)){
				$_SESSION[$sess]=$_SESSION[$sess]+1;
				CountUserss12($user['user'], $table, $sess);
			}
		}
		
		
		function leftRightww12($usse, $table){
			global $mysqli;
			$eer=array();
			$mmm=$mysqli->query("SELECT * FROM `$table` WHERE `upline`='".$usse."'");
			while($uuui=mysqli_fetch_assoc($mmm)){
				if($uuui['position']==1){
					$eer['left']=$uuui['user'];
				}elseif($uuui['position']==2){
					$eer['right']=$uuui['user'];
				}
			}
			return $eer;
		}
		
		
		$usekk=leftRightww12($referral, $table);
		
		// Ensure left and right keys exist
		if(!isset($usekk['left'])) {
			$usekk['left'] = '';
		}
		if(!isset($usekk['right'])) {
			$usekk['right'] = '';
		}
		
		//$totalLeft=CountUserss12($usekk['left'],$table, "left");
		//$totalRight=CountUserss12($usekk['right'],$table, "right");
		
		$usermmmqq=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$referral."'"));
		
		// Check if user data exists
		if(!$usermmmqq || $usermmmqq === null) {
			$usermmmqq = array(
				'user' => $referral,
				'log_user' => $referral
			);
		}
		
		$usermmm=mysqli_fetch_assoc($mysqli->query("SELECT `name`,`photo`,`user` FROM `profile` WHERE `user`='".$usermmmqq['log_user']."'"));
		
		// Check if profile data exists
		if(!$usermmm || $usermmm === null) {
			$usermmm = array(
				'name' => 'Unknown User',
				'photo' => 'default.jpg',
				'user' => $referral
			);
		}
		


 ?>
<?php require_once("../part/top_option2.php"); ?>

    <!-- END TOPBAR -->
    <!-- START CONTAINER -->
    <div class="page-container row-fluid container-fluid">

        <!-- SIDEBAR - START -->

        <?php require_once("../part/sidebar2.php"); ?>
        <!--  SIDEBAR - END -->
        
        <!-- Fix navigation links for tree subdirectory -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fix sidebar navigation links to point to correct parent directory
            const sidebarLinks = document.querySelectorAll('.page-sidebar-tree a[href^="index.php"]');
            sidebarLinks.forEach(function(link) {
                const href = link.getAttribute('href');
                if (href.startsWith('index.php')) {
                    link.setAttribute('href', '../' + href);
                }
            });
            
            // Fix logo link in top navigation
            const logoLink = document.querySelector('.logo-text[href="index.php"]');
            if (logoLink) {
                logoLink.setAttribute('href', '../index.php');
            }
            
            // Fix dropdown menu links in top navigation
            const dropdownLinks = document.querySelectorAll('.dropdown-menu a[href^="../index.php"]');
            // These are already correct with ../ prefix, no need to modify
            
            console.log('Tree page navigation links fixed');
        });
        </script>

        <!-- START CONTENT -->
        <section id="main-content" class=" " style="background:#3c5c6f;">
           
		<div class="wrapper main-wrapper row" style='min-height:100vh;padding:0px;'>
				
						<?php
							if($_SESSION['roboMember']!=$referral){
						?>
						<div class="row">
							<div class="col-sm-3">
								<a class="btn btn-warning" style="color:#000" href="index.php?ref=<?php echo base64_encode($_SESSION['roboMember'])?>">Back</a>
							</div>
						</div>
						<?php } ?>
						<script>
							$("#search").on("click", function(){
								let fgdf=$("#valjj").val();
								location.href="index.php?ref="+btoa(fgdf);
							});
						</script>
		<div class="row" >
		<div class="col-xs-12" style="padding:0px;margin:0px;">
			<style>
			/* Tree page layout fixes for sidebar2 - DEBUG MODE */
			.page-container {
				display: block !important;
				width: 100% !important;
				min-height: 100vh !important;
			}
			
			#main-content {
				padding: 20px !important;
				overflow-x: auto !important;
				transition: margin-left 0.3s ease !important;
			}
			
			/* Hide old sidebar classes that might conflict */
			.page-sidebar:not(.page-sidebar-tree) {
				display: none !important;
			}
			
			/* FORCE SHOW sidebar2 for debugging */
			.page-sidebar-tree {
				display: block !important;
				position: fixed !important;
				left: 0 !important;
				top: 0 !important;
				height: 100vh !important;
				width: 250px !important;
				background: #2c3e50 !important;
				z-index: 1000 !important;
				transform: translateX(0) !important;
				transition: transform 0.3s ease !important;
			}
			
			/* Mobile responsive - sidebar2 behavior */
			@media (max-width: 768px) {
				.page-sidebar-tree.sidebar-collapsed {
					transform: translateX(-100%) !important;
				}
				
				#main-content {
					margin-left: 0 !important;
					width: 100% !important;
				}
			}
			
			/* Desktop behavior */
			@media (min-width: 769px) {
				.page-sidebar-tree.sidebar-collapsed {
					transform: translateX(-100%) !important;
				}
				
				.page-sidebar-tree:not(.sidebar-collapsed) {
					transform: translateX(0) !important;
				}
				
				#main-content {
					margin-left: 250px !important;
				}
				
				body:has(.page-sidebar-tree.sidebar-collapsed) #main-content {
					margin-left: 0 !important;
				}
			}
			
			/* Center the tree properly */
			.tree-container1 {
				display: flex !important;
				justify-content: center !important;
				align-items: flex-start !important;
				width: 100% !important;
				min-height: 500px !important;
			}
			
			#tree {
				display: inline-block !important;
				margin: 0 auto !important;
			}
			
			.jOrgChart {
				display: inline-block !important;
			}
			
			/* Ensure tree table is centered */
			#tree_div {
				margin: 0 auto !important;
				display: table !important;
			}
			
			/* When sidebar is collapsed - desktop behavior */
			body.sidebar-collapsed .page-container {
				margin-left: 0 !important;
			}
			
			body.sidebar-collapsed .page-sidebar {
				margin-left: -250px !important;
			}
			
			body.sidebar-collapsed #main-content {
				margin-left: 0 !important;
				width: 100% !important;
			}
			</style>
			<div id="summary" class="panel-body tree-container1" style="height:100%;margin: auto;width: 100%;top: 0px;">
						<!-- Load jQuery FIRST before any jQuery plugins -->
						<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
						
						<link rel="stylesheet" href="css/styles-tree.css">
						<link rel="stylesheet" href="css/custom-tree.css">
						<link href="css/prettify-tree.css" type="text/css" rel="stylesheet">
						<script src="js/jquery.tree.js"></script>
						<script>
							jQuery(document).ready(function () {
								$("#tree_view").jOrgChart({
									chartElement: '#tree',
									dragAndDrop: false
								});
							});
						</script>
						<link href="css/style_tooltip.css" rel="stylesheet" type="text/css">
						<script type="text/javascript" src="js/easyTooltip.js"></script>
						<script src="js/jquery.scroll.tree.js"></script>
						<script type="text/javascript">
							$(document).ready(function (){
								var kk;
								$(".node img").on("mouseenter", function(){
									kk=$(this).attr("alt");
									console.log(kk);
									$("img#userlink_"+kk).easyTooltip({
										useElement: "user_"+kk
									});
								});
								
								
							});
						</script>
						<div id="tooltip_div" style="display: none;">
							<?php //include("infoTree.php"); ?>
						</div>
						<div id="tree" class="orgChart" style="overflow:scroll;min-height:500px;border:1px solid #ccc;">
							<div class="jOrgChart">
								<?php 
								echo "<!-- Debug: Tree container loaded -->\n";
								echo "<!-- Debug: About to display tree for referral: " . $referral . " -->\n";
								echo "<!-- Debug: User left: " . (isset($usekk['left']) ? $usekk['left'] : 'NOT SET') . " -->\n";
								echo "<!-- Debug: User right: " . (isset($usekk['right']) ? $usekk['right'] : 'NOT SET') . " -->\n";
								?>
								<table id="tree_div" cellpadding="0" cellspacing="0" border="0" align="center" style="zoom: 1; transform-origin: 0px 0px 0px;">
									<tbody>
										<tr class="node-cells">
											<td class="node-cell" colspan="4">
												<?php InfoPartTree($referral,""); ?>
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
											<?php TreeView($usekk['left'],$referral); ?>
											<?php TreeView($usekk['right'],$referral); ?>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
        </div>
        </div>
  </section>
  <span id="MemberName" data-name="<?php echo $ProfileInfo['name']; ?>"></span>
		<script>
			 var rev = "fwd";
    function titlebar(val){
        var msg  = "Welcome <?php echo $ProfileInfo['name']; ?> To <?php echo $Tiell; ?>";
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
		
		<script>
		// Initialize the new sidebar2 functionality after page loads
		$(document).ready(function() {
			console.log('Tree page: Initializing new sidebar2 functionality');
			
			// Initialize the toggle functionality for both buttons
			function toggleSidebar() {
				console.log('Tree page: Toggle function called');
				
				var sidebar = $('.page-sidebar-tree');
				var mainContent = $('#main-content');
				var topbar = $('.page-topbar');
				
				// Toggle the sidebar
				if (sidebar.hasClass('sidebar-collapsed')) {
					// Open sidebar
					sidebar.removeClass('sidebar-collapsed');
					mainContent.removeClass('sidebar-collapsed');
					if (topbar.length) {
						topbar.removeClass('sidebar-collapsed');
					}
					console.log('Tree page: Sidebar opened');
				} else {
					// Close sidebar
					sidebar.addClass('sidebar-collapsed');
					mainContent.addClass('sidebar-collapsed');
					if (topbar.length) {
						topbar.addClass('sidebar-collapsed');
					}
					console.log('Tree page: Sidebar closed');
				}
			}
			
			// Bind to both toggle buttons
			$('#sidebar-toggle-tree, .sidebar_toggle').off('click').on('click', function(e) {
				e.preventDefault();
				toggleSidebar();
			});
			
			console.log('Tree page: Sidebar2 toggle setup complete');
		});
		</script>
		
		
        <!-- END CONTENT -->
        <?php require_once("../part/footer_tree.php"); ?>
		