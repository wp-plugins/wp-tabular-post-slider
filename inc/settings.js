jQuery.noConflict();
jQuery(document).ready(function( $ ) {
	$("#tpsbc-tabs" ).tabs();

	$('.control-prev').jcarouselControl({
		target: '-=1'
	});

	$('.control-next').jcarouselControl({
		target: '+=1'
	});
	$('.ui-tabs-anchor').click(function(){
		$('.slider-controls .control-next').click();
	});
});