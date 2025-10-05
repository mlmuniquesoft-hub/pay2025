    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="../assets/plugins/pace/pace.min.js"></script>
    <script src="../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/plugins/viewport/viewportchecker.js"></script>
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <script src="../assets/plugins/sparkline-chart/jquery.sparkline.min.js"></script>
    <script src="../assets/plugins/flot-chart/jquery.flot.js"></script>
    <script src="../assets/plugins/flot-chart/jquery.flot.time.js"></script>
    <script src="js/sweetalert.min.js"></script>
    
    <!-- Tree specific scripts -->
    <script src="../theme/libs/jquery/tooltipster/js/tooltipster.bundle.min.js" type="text/javascript"></script>
    <script src="../javascript/tree/jquery.panzoom.min.js"></script>
    <script src="../javascript/tree/jquery.tree.js"></script>
    <script src="../javascript/tree/genealogy.js"></script>
    
    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE TEMPLATE JS - START -->
    <script src="../assets/js/scripts.js"></script>
    <!-- END CORE TEMPLATE JS - END -->
    
    <style>
    /* Tree page specific styles */
    body {
        position: relative;
        overflow-x: auto;
    }
    
    /* Ensure tree container doesn't interfere with sidebar */
    .tree-container1 {
        position: relative;
        z-index: 1;
    }
    
    /* Tree page sidebar styles */
    .page-sidebar {
        position: fixed !important;
        left: 0 !important;
        top: 0 !important;
        height: 100vh !important;
        width: 250px !important;
        z-index: 1000 !important;
        transition: transform 0.3s ease !important;
    }
    
    #main-content {
        margin-left: 250px !important;
        transition: margin-left 0.3s ease !important;
        position: relative !important;
        z-index: 1 !important;
    }
    
    /* When sidebar is collapsed */
    body.sidebar-collapsed .page-sidebar {
        transform: translateX(-250px) !important;
    }
    
    body.sidebar-collapsed #main-content {
        margin-left: 0 !important;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .page-sidebar {
            transform: translateX(-250px) !important;
        }
        
        .page-sidebar.mobile-open {
            transform: translateX(0) !important;
        }
        
        #main-content {
            margin-left: 0 !important;
        }
    }
    
    /* Ensure tree controls are accessible */
    .tree-container1 {
        position: relative;
        min-height: 500px;
    }
    
    /* Tree specific overflow handling */
    #tree {
        overflow: auto !important;
        position: relative !important;
    }
    </style>
    
    <script>
    // Tree page specific sidebar toggle
    (function() {
        'use strict';
        
        // Initialize sidebar state
        var sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        
        function applySidebarState() {
            if (sidebarCollapsed) {
                $('body').addClass('sidebar-collapsed');
                $('.page-sidebar').addClass('collapsed');
            } else {
                $('body').removeClass('sidebar-collapsed');
                $('.page-sidebar').removeClass('collapsed');
            }
        }
        
        function toggleSidebar() {
            sidebarCollapsed = !sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
            applySidebarState();
            
            // Trigger resize for tree components
            setTimeout(function() {
                $(window).trigger('resize');
                // Recalculate tree positioning if needed
                if (typeof window.recalculateTreePosition === 'function') {
                    window.recalculateTreePosition();
                }
            }, 300);
        }
        
        $(document).ready(function() {
            console.log('Tree page sidebar toggle initialized');
            
            // Apply initial state
            applySidebarState();
            
            // Sidebar toggle handlers
            $(document).on('click', '.sidebar_toggle, [data-toggle="sidebar"]', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Sidebar toggle clicked on tree page');
                toggleSidebar();
            });
            
            // Mobile menu handling
            $(document).on('click', '.mobile-menu-toggle', function(e) {
                e.preventDefault();
                $('.page-sidebar').toggleClass('mobile-open');
            });
            
            // Close mobile menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.page-sidebar, .mobile-menu-toggle').length) {
                    $('.page-sidebar').removeClass('mobile-open');
                }
            });
        });
        
    })();
    </script>
    
    <script>
    // Mobile detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
        $(".GooleTrans").css("width","60px");
        $(".GooleTrans").css("overflow","hidden");
        $(".MemmMobile").show();
    } else {
        $(".MemmMobile").hide();
    }
    </script>
</body>
</html>