<script src="{{ asset('js/jquery.easydrag.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="{{ asset('js/zoom.jquery.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/jquery.zoom.css') }}">
<div id="dragable" style="padding: 5px 0 0 5px; position:absolute;left:800px;top:150px;display:none;">
	<button style="float: right;" type="button" class="dragclose"><span aria-hidden="true">&times;</span></button>
	<div id="dragImage"></div>
	<div class="buttons" style="position: relative;bottom: 26px;">
		<button id="prevButton">&lt;</button>
		<button id="nextButton" style="float: right;">&gt;</button>
	</div>
</div>
<script type="text/javascript">
let zoomMap = $('#dragImage').ZoomArea({
        zoomLevel: 1,
        minZoomLevel: 1,
        maxZoomLevel: 15,
        parentOverflow: 'auto',
        exceptionsZoom: ['marker-all'],
        hideWhileAnimate: ['map-area', 'marker-all'],
        externalIncrease: '.map-control-zoomin',
        externalDecrease: '.map-control-zoomout',
        virtualScrollbars: false,
        usedAnimateMethod: 'jquery'
    }); 
$(document).ready(function(){
	var activeZoomImage = '';
	$(document).on('click', 'img[class^=zoom]', function() {
        //$('#dragable').toggleClass('transition');
    });
	
	$(document).on('click', '#prevButton', function() {
        if($('.zoom'+(activeZoomImage-1)).length > 0) {
			$('.zoom'+activeZoomImage).hide();
			$('.zoom'+(activeZoomImage-1)).show();
			activeZoomImage=activeZoomImage-1;
		}
    });
	
	$(document).on('click', '#nextButton', function() {
        if($('.zoom'+(activeZoomImage+1)).length > 0) {
			$('.zoom'+activeZoomImage).hide();
			$('.zoom'+(activeZoomImage+1)).show();
			activeZoomImage=activeZoomImage+1;
		}
    });
	
	$("#dragable").easydrag();
	
	$('.open_photo_slider').click(function () {
		$("#dragable #dragImage").empty();
		var images = $(this).parent().attr('data-url');
		var j = 0;
		$.map(images.split(','), function(src, i) {
			if(i > 0) {
				var style = 'style="display:none;"';
			} else {
				var style = '';
			}
			if (src != '') {
				j++;
				$("#dragable #dragImage").append('<img class="zoom'+j+'" src="{{asset("")}}'+src+'" '+style+'>');
			} 
		});
		if(j > 0) {
			activeZoomImage = 1;
			var position = $(this).offset();
			var mtop = position.top-250;
			$("#dragable").css({"top":mtop});
			$("#dragable").show();
		}
	});
	
	$("[id^=photo_]").click(function (){
		var clickedImageId = $(this).attr('id');
		$("#dragable #dragImage").empty();
		$("[id^=photo_]").map(function() {
			var style = 'style="display:none;"';
			imageId = $(this).attr('id');
			var cls = imageId.substr(6);
			if(imageId == clickedImageId) {
				var style = 'style=""';
				activeZoomImage = parseInt(cls);
			}
			src = $(this).attr('src');
			$("#dragable #dragImage").append('<img class="zoom'+cls+'" src="'+src+'" '+style+'>');
		});
		
		$("#dragable").show();
		$(window).scrollTop('0');
	});
	
	$(".dragclose").click(function (){
		$("#dragable #dragImage").html('');
		$("#dragable").hide();
	});
});
</script>