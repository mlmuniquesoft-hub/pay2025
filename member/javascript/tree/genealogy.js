var root_user_name = $('#root_user_name').val();
var tree_url = $('#tree_url').val();

jQuery(document).ready(function () {
    getGenologyTree(root_user_name, null);
    generateTooltips();
});
const djfghdf=()=>{
	jQuery(".with_tooltip").on("click", function(){
		let userdf=jQuery(this).attr("data-user");
		//console.log(userdf);
		//console.log("Hello");
		if(userdf!=''){
			getGenologyTree(userdf, null);
			generateTooltips();
		}
		
	});
}

function getGenologyTree(user_name, event) {
    $.ajax({
        type: "POST",
        url: tree_url,
        data: {
            user_name: user_name
        },
        beforeSend: function () {
            
        },
        success: function (data) {
            $('#summary').html(data);
            $("#tree_view").jOrgChart({
                chartElement: '#tree',
                dragAndDrop: false
            });
            djfghdf();
            panZoom();
        }
    });
}

function goToLink(url) {
    window.location.href = url;
}

function generateTooltips() {
    $('body').on('mouseenter', '.tree_icon.with_tooltip:not(.tooltipstered)', function () {
        $(this).tooltipster({
            theme: 'tooltipster-shadow',
            contentAsHTML: true,
            delay: 100,
            interactive: true,
            arrow: false,
            side: ['top', 'bottom'],

        });
        $(this).tooltipster('show');
    });
}

function panZoom() {
    $('body').find('#summary').find('#tree').panzoom({
        $zoomIn: $(".zoom-in"),
        $zoomOut: $(".zoom-out"),
        $reset: $(".zoom-reset"),
        startTransform: 'scale(1.0)',
        maxScale: 2.0,
        increment: 0.05,
        disablePan: true,
        // panOnlyWhenZoomed: true,
        // contain: true
    });
}