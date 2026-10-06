jQuery(document).ready(function($){
	$('body').on('click', '.rwf-required strong, .rwf-optional strong, .rwf-layout strong, .rwf-settings strong, .rwf-advance strong, .rwf-styling strong', function(){
		$(this).parent().toggleClass('rwf-collapsed');
		//$(this).parent().find('p').toggle();
	});
	$('.wp-list-table.styles ul li').on('click', function(){
		$(this).siblings().removeClass('selected');
		$(this).addClass('selected');
		$('input[name="rfw_style"]').val($(this).data('id'));
	});
});