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
				<div class="row" style="margin-top: 40px;margin-bottom: -40px;">
					<div class="col-sm-12">
						<?php
							$NoticeK=mysqli_fetch_assoc($mysqli->query("SELECT * FROM `notice`"));
						?>
						<h2 style="margin-top: 28px;font-family:Georgia; color:<?php echo $NoticeK['color']; ?>"><marquee><?php echo $NoticeK['body']; ?></marquee></h2>
					</div>
				</div>
				
				<!-- Crypto Price Ticker -->
				<div class="row" style="margin-top: 30px;margin-bottom: -60px;">
					<div class="col-sm-12">
						<div style="background: linear-gradient(45deg, #1a1a2e, #16213e); padding: 8px; border-radius: 5px; border: 1px solid #333;">
							<h3 style="margin: 0; font-family: Arial, sans-serif; color: #00ff88; font-size: 16px;">
								<marquee behavior="scroll" direction="left" scrollamount="3" id="cryptoTicker">
									<span id="cryptoPrices">Loading cryptocurrency prices...</span>
								</marquee>
							</h3>
						</div>
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
    
    // Crypto Price Ticker Function
    function updateCryptoPrices() {
        // Using CoinGecko API for real-time prices (free, no API key required)
        fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,binancecoin,cardano,solana,dogecoin,ripple,polygon,litecoin,chainlink&vs_currencies=usd&include_24hr_change=true')
        .then(response => response.json())
        .then(data => {
            let cryptoText = '';
            const cryptos = {
                'bitcoin': '₿ BTC',
                'ethereum': 'Ξ ETH',
                'binancecoin': 'BNB',
                'cardano': 'ADA',
                'solana': 'SOL',
                'dogecoin': 'DOGE',
                'ripple': 'XRP',
                'polygon': 'MATIC',
                'litecoin': 'LTC',
                'chainlink': 'LINK'
            };
            
            for (let crypto in data) {
                const price = data[crypto].usd;
                const change = data[crypto].usd_24h_change;
                const changeColor = change >= 0 ? '#00ff88' : '#ff4757';
                const changeSymbol = change >= 0 ? '+' : '';
                
                cryptoText += `<span style="margin-right: 40px;">
                    <strong style="color: #ffd700;">${cryptos[crypto]}:</strong> 
                    <span style="color: white;">$${price.toLocaleString()}</span> 
                    <span style="color: ${changeColor};">(${changeSymbol}${change.toFixed(2)}%)</span>
                </span>`;
            }
            
            document.getElementById('cryptoPrices').innerHTML = cryptoText;
        })
        .catch(error => {
            console.log('Error fetching crypto prices:', error);
            document.getElementById('cryptoPrices').innerHTML = 
                '<span style="color: #ff4757;">Unable to load crypto prices at the moment</span>';
        });
    }
    
    // Update prices on page load and every 30 seconds
    updateCryptoPrices();
    setInterval(updateCryptoPrices, 30000);
		</script>
		
		
        <!-- END CONTENT -->
        <?php require_once("part/footer.php"); ?>