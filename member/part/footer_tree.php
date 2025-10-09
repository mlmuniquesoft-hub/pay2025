    <!-- END CONTAINER -->
    <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->

    <!-- CORE JS FRAMEWORK - START -->
    <script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
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
    /* FINAL FIX: Force only one sidebar and ensure proper toggle */
    
    /* Hide ALL sidebars except the first one */
    .page-sidebar:not(:first-child) {
        display: none !important;
        visibility: hidden !important;
        position: absolute !important;
        left: -9999px !important;
    }
    
    /* Ensure tree page body behaves correctly */
    body {
        overflow-x: auto !important;
    }
    
    /* Tree container positioning */
    .tree-container1 {
        position: relative;
        z-index: 1;
        min-height: 500px;
    }
    
    /* Tree specific overflow handling */
    #tree {
        overflow: auto !important;
        position: relative !important;
    }
    </style>
    
    <script>
    // Tree page initialization - minimal interference with main sidebar
    $(document).ready(function() {
        console.log('Tree page loaded');
        
        // Force hide any extra sidebars that might appear
        setTimeout(function() {
            $('.page-sidebar:not(:first)').remove();
        }, 500);
        
        // Mobile detection for responsive features
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        if (isMobile) {
            $(".GooleTrans").css({"width":"60px", "overflow":"hidden"});
            $(".MemmMobile").show();
        } else {
            $(".MemmMobile").hide();
        }
        
        // Handle tree resize after sidebar toggles
        $(document).on('click', '.sidebar_toggle, .sidebar-toggle', function() {
            setTimeout(function() {
                $(window).trigger('resize');
                if (typeof window.recalculateTreePosition === 'function') {
                    window.recalculateTreePosition();
                }
            }, 350);
        });
    });
    </script>
</body>
</html>