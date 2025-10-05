<?php 
require_once("../part/top_header2.php");

include("../part/sideTree.php");
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
		
		//$totalLeft=CountUserss12($usekk['left'],$table, "left");
		//$totalRight=CountUserss12($usekk['right'],$table, "right");
		
		$usermmmqq=mysqli_fetch_assoc($mysqli->query("SELECT `user`,`log_user` FROM `member` WHERE `user`='".$referral."'"));
		$usermmm=mysqli_fetch_assoc($mysqli->query("SELECT `name`,`photo`,`user` FROM `profile` WHERE `user`='".$usermmmqq['log_user']."'"));
		


 ?>
<?php require_once("../part/top_option2.php"); ?>

    <!-- END TOPBAR -->
    <!-- START CONTAINER -->
    <div class="page-container row-fluid container-fluid">

        <!-- SIDEBAR - START -->

        <?php require_once("../part/sidebar2.php"); ?>
        <!--  SIDEBAR - END -->

        <!-- START CONTENT -->
        <section id="main-content" class=" " style="background:#3c5c6f;">
           
<div class="wrapper main-wrapper row" style='min-height:100vh;padding:0px;'>
		 <div class="row">
							<div class="col-sm-6">
								<div class="row">
								<?php
									$plans=array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K");
									$jjk=$mysqli->query("SELECT * FROM `package`");
									$i=0;
									while($ppaasl=mysqli_fetch_assoc($jjk)){
										if(($ppaasl['pack']=="NZBOT500")||($ppaasl['pack']=="NZBOT300")||($ppaasl['pack']=="NZBOT50000")){
											
											$coolk="#040404";
										}else{
											$coolk="#FFF";
										}
										//$coolk="#FFF";
								?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
									<p class="text-center" style="border: 2px solid #FFF;background:<?php echo $ppaasl['color']; ?>;color:<?php echo $coolk; ?>;font-size: 11px;"><?php echo $ppaasl['pack']. " (".$plans[$i] .")"; ?></p>
								</div>
								<?php $i++; } ?>
								</div>
							</div>
							<div class="col-sm-4 col-xs-8" style="padding-right:0px;">
								<div class="form-group">
									<input type="search" class="form-control" name="receiveID" id="valjj" placeholder="Search for records...">
								</div>
								
							</div>
							<div class="col-sm-2 col-xs-4" style="padding-left:0px;">
								<button class="btn btn-success" id="search">Search</button>
							</div>
						</div>
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
			<div id="summary" class="panel-body tree-container1" style="height:100%;margin: auto;width: 100%;top: 0px;">
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
						<div id="tree" class="orgChart" style="overflow:scroll;">
							<div class="jOrgChart">
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
		
		
        <!-- END CONTENT -->
        <?php require_once("../part/footer.php"); ?>
		