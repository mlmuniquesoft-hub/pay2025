<script>
	setTimeout(function(){
		const redfg=$.ajax({
			method:"GET",
			url:"viewdata/deposit.php",
			data:{Vals:"Get Data"}
		});
		redfg.done(function(ress){
			//consle.log(ress);
			const losdf=location.href;
			const locb=losdf.split("=");
			const splAds=locb[1].split("&");
			if(splAds[0]=="deposit"){
				const redfgs=$.ajax({
					method:"GET",
					url:'viewdata/view_deposit.php',
					data:{Check:"Data"}
					
				});
				redfgs.done((ressa)=>{
					$("#DepositReport").html(ressa);
				});
				
			}
		});
	}, 10000);
	
</script>
<div class="page-chatapi hideit">

            <div class="search-bar">
                <input type="text" placeholder="Search" class="form-control">
            </div>

            <div class="chat-wrapper">

                <h4 class="group-head">Favourites</h4>
                <ul class="contact-list">

                    <li class="user-row " id='chat_user_1' data-user-id='1'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-1.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Joge Lucky</a></h4>
                            <span class="status available" data-status="available"> Available</span>
                        </div>
                        <div class="user-status available">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_2' data-user-id='2'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-2.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Folisise Chosiel</a></h4>
                            <span class="status away" data-status="away"> Away</span>
                        </div>
                        <div class="user-status away">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_3' data-user-id='3'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-3.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Aron Gonzalez</a></h4>
                            <span class="status busy" data-status="busy"> Busy</span>
                        </div>
                        <div class="user-status busy">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>

                </ul>

                <h4 class="group-head">More Contacts</h4>
                <ul class="contact-list">

                    <li class="user-row " id='chat_user_4' data-user-id='4'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-4.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Chris Fox</a></h4>
                            <span class="status offline" data-status="offline"> Offline</span>
                        </div>
                        <div class="user-status offline">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_5' data-user-id='5'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-5.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Mogen Polish</a></h4>
                            <span class="status offline" data-status="offline"> Offline</span>
                        </div>
                        <div class="user-status offline">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_6' data-user-id='6'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-1.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Smith Carter</a></h4>
                            <span class="status available" data-status="available"> Available</span>
                        </div>
                        <div class="user-status available">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_7' data-user-id='7'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-2.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Amilia Gozenal</a></h4>
                            <span class="status busy" data-status="busy"> Busy</span>
                        </div>
                        <div class="user-status busy">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_8' data-user-id='8'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-3.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Tahir Jemyship</a></h4>
                            <span class="status away" data-status="away"> Away</span>
                        </div>
                        <div class="user-status away">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_9' data-user-id='9'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-4.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Johanson Wright</a></h4>
                            <span class="status busy" data-status="busy"> Busy</span>
                        </div>
                        <div class="user-status busy">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_10' data-user-id='10'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-5.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Loni Tindall</a></h4>
                            <span class="status away" data-status="away"> Away</span>
                        </div>
                        <div class="user-status away">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_11' data-user-id='11'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-1.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Natcho Herlaey</a></h4>
                            <span class="status idle" data-status="idle"> Idle</span>
                        </div>
                        <div class="user-status idle">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>
                    <li class="user-row " id='chat_user_12' data-user-id='12'>
                        <div class="user-img">
                            <a href="#"><img src="../data/profile/avatar-2.png" alt=""></a>
                        </div>
                        <div class="user-info">
                            <h4><a href="#">Shakira Swedan</a></h4>
                            <span class="status idle" data-status="idle"> Idle</span>
                        </div>
                        <div class="user-status idle">
                            <i class="fa fa-circle"></i>
                        </div>
                    </li>

                </ul>
            </div>

        </div>

        <div class="chatapi-windows ">

        </div>
    </div>
    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="/assets/plugins/swiper/jquery.min.js"></script>
    <script src="/assets/js/jquery.easing.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/plugins/viewport/viewportchecker.js"></script>
    
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START 
	<script src="/assets/js/chart-flot.js"></script>

	-->
    <script src="/assets/plugins/sparkline-chart/jquery.sparkline.min.js"></script>

    <script src="/assets/plugins/flot-chart/jquery.flot.js"></script>
    <script src="/assets/plugins/flot-chart/jquery.flot.time.js"></script>
    <script src="js/sweetalert.min.js"></script>
    
    <script src="/assets/plugins/chartjs-chart/Chart.min.js"></script>
    <script >
		if ($("#flot-realtime").length) {
				// We use an inline data source in the example, usually data would
				// be fetched from a server

				var rtdata = [],
					totalPoints = 300;

				function RealTimegetRandomData() {

					if (rtdata.length > 0)
						rtdata = rtdata.slice(1);

					// Do a random walk

					while (rtdata.length < totalPoints) {

						var prev = rtdata.length > 0 ? rtdata[rtdata.length - 1] : 50,
							y = prev + Math.random() * 10 - 5;

						if (y < 0) {
							y = 0;
						} else if (y > 100) {
							y = 100;
						}

						rtdata.push(y);
					}

					// Zip the generated y values with the x values

					var res = [];
					for (var i = 0; i < rtdata.length; ++i) {
						res.push([i, rtdata[i]])
					}

					return res;
				}

				// Set up the control widget

				var updateInterval = 100;
				$("#updateInterval").val(updateInterval).change(function() {
					var v = $(this).val();
					if (v && !isNaN(+v)) {
						updateInterval = +v;
						if (updateInterval < 1) {
							updateInterval = 1;
						} else if (updateInterval > 2000) {
							updateInterval = 2000;
						}
						$(this).val("" + updateInterval);
					}
				});

				var realplot = $.plot("#flot-realtime", [RealTimegetRandomData()], {
					series: {
						shadowSize: 0 // Drawing is faster without shadows
					},
					yaxis: {
						min: 0,
						max: 100
					},
					xaxis: {
						show: true
					},
					colors: ["#FFF","#FFF"],
					grid: {
						tickColor: "#f9f9f947",
						borderWidth: 1,
						borderColor: "#f9f9f947"
					},
				});

				function realtimeupdate() {

					realplot.setData([RealTimegetRandomData()]);

					// Since the axes don't change, we don't need to call realplot.setupGrid()

					realplot.draw();
					setTimeout(realtimeupdate, updateInterval);
				}

				realtimeupdate();

			}
	</script>


    <script src="/assets/plugins/swiper/swiper.js"></script>
    <script src="/assets/js/dashboard-crypto.js"></script>
	<script src="/assets/plugins/autosize/autosize.min.js"></script>
	<script src="/assets/plugins/icheck/icheck.min.js"></script>
	
	<!-- Highcharts for dashboard charts -->
	<script src="/assets2/js/highcharts.js"></script>
	<script src="/assets2/js/highcharts-3d.js"></script>
	<!-- CORE TEMPLATE JS - Must load before other scripts -->
	<script src="/assets/js/scripts.js"></script>
	<!-- Slick Carousel JS - Must load before main.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
	<script src="/assets2/js/main.js"></script>
	
	<!-- Dropdown Functionality Script -->
	<script>
	console.log("=== DROPDOWN DEBUG START ===");
	
	$(document).ready(function() {
		console.log("jQuery DOM Ready");
		console.log("jQuery version:", $.fn.jquery);
		
		// Check elements
		var menuWrapper = $('#main-menu-wrapper');
		var menuLinks = $('#main-menu-wrapper li a');
		var subMenus = $('.sub-menu');
		
		console.log("Menu wrapper found:", menuWrapper.length);
		console.log("Menu links found:", menuLinks.length);  
		console.log("Sub-menus found:", subMenus.length);
		
		// Check if CRYPTOKIT_SETTINGS exists
		if(typeof CRYPTOKIT_SETTINGS !== 'undefined') {
			console.log("CRYPTOKIT_SETTINGS exists - original script should work");
		} else {
			console.log("CRYPTOKIT_SETTINGS missing - using manual implementation");
		}
		
		// Manual dropdown implementation
		console.log("Setting up dropdown handlers...");
		
		$('#main-menu-wrapper li a').off('click').on('click', function(e) {
			console.log("Menu clicked:", $(this).find('.title').text());
			
			var hasSubMenu = $(this).next().hasClass('sub-menu');
			console.log("Has sub-menu:", hasSubMenu);
			
			if (!hasSubMenu) {
				console.log("No sub-menu - allowing navigation");
				return true;
			}
			
			e.preventDefault();
			console.log("Preventing default and toggling menu");
			
			var $parent = $(this).parent();
			var $sub = $(this).next('.sub-menu');
			var $arrow = $(this).find('.arrow');
			
			// Close other open menus
			$('#main-menu-wrapper li.open').not($parent).each(function() {
				$(this).removeClass('open');
				$(this).find('.sub-menu').slideUp(200);
				$(this).find('.arrow').removeClass('open');
			});
			
			// Toggle current menu
			if ($parent.hasClass('open')) {
				console.log("Closing menu");
				$parent.removeClass('open');
				$arrow.removeClass('open');
				$sub.slideUp(200);
			} else {
				console.log("Opening menu");
				$parent.addClass('open');
				$arrow.addClass('open');
				$sub.slideDown(200);
			}
		});
		
		console.log("=== DROPDOWN SETUP COMPLETE ===");
	});
	</script>
	
    
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS ALREADY LOADED ABOVE -->
    <!-- END CORE TEMPLATE JS - END -->
	<script>
		if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
			|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
			isMobile = true;
			$(".GooleTrans").css("width","60px");
			$(".GooleTrans").css("overflow","hidden");
			$(".MemmMobile").show();
		}else{
			$(".MemmMobile").hide();
		}
	</script>
</body>
</html>