// JavaScript Document
jQuery(document).ready(function($){
	
	$('input[name^="wpc_reset"]').on('click', function(){
		$(this).toggleClass('selected');		
		
		$('input[name="wpc_reset_action['+$(this).data('item')+']"').val($(this).hasClass('selected')?'true':'false');				
	});
	
	$('.wpch_primary ul li.available').on('click', 'a', function(){
		$('.wpch_grid').hide();
		
		
		$('.wpch .wpch_form_wrap').show();		
		$('input[name^="wpc_reset"]').hide();
		$('.wpch_form_style, .wpch_thumbnail img, .wpch_thumbnail .preview, .wpch_cf7_wrap').hide();
		$(this).parents().eq(1).find('li.selected').removeClass('selected');
		$(this).parent().addClass('selected');
		var key = $(this).data('key');
		var styles = 'wpc['+key+'][styles]';
		var obj = $('select[name="'+styles+'"]');
		if(obj.length>0){
			obj.show();
			$('.wpch_cf7_wrap.wpch_'+key+'_form').show();
			obj.val(obj.find('option:first-child').val()).trigger('change');
			window.history.pushState(null, null, 'options-general.php?page=wpc&s='+key);
			$('input[name="wpc_reset['+key+']"]').show();
			$('.wpch_grid[data-grid="'+key+'"]').show()
		}
		
	});
	$('.wpch_form_style').change(function(){
		
		var obj = $(this).find('option:selected');
		var item_type = $(this).data('obj');
		var forms_str = obj.data('forms')+'';
		var forms = forms_str.split('|');
		var url = obj.data('url');
		
		url = ($.trim(url)?url:obj.data('full'));
		
		$('.wpch_thumbnail img').attr('src', url).show();
		$('.wpch_thumbnail .preview').show();
		$('.wpch_thumbnail .title').html(obj.data('cap')).show();
		var selection = $('.wpch_forms_selection:visible');
		selection.find('option:selected').prop("selected", false);
		
		if(selection && forms.length>0){
			
			
			$('input[name="wpc['+item_type+'][forms][]"').val('');
			
			$.each(forms, function(i, num){
				
				$('input[name="wpc['+item_type+'][forms][]"').val(num);
				selection.find('option[value="'+num+'"]').prop( "selected", true );
					
			});
		}
		
		if(obj.data('css')=='no')
		$('.wpch_buton').hide();
		else
		$('.wpch_buton').show();
		
		//console.log(forms);
	});
	$('.wpch_thumbnail .preview').click(function(){
		var obj = $('.wpch_form_style:visible').find('option:selected');
		
		window.open(obj.data('full'), 'wpch_preview');
	});
	
	if($('.wpc_supported').length>0){
		$('.wpc_supported.installed:first-child > a').click();
	}





	function parse_query_string(query) {
	  var vars = query.split("&");
	  var query_string = {};
	  for (var i = 0; i < vars.length; i++) {
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") {
		  query_string[pair[0]] = decodeURIComponent(pair[1]);
		  // If second entry with this name
		} else if (typeof query_string[pair[0]] === "string") {
		  var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
		  query_string[pair[0]] = arr;
		  // If third or later entry with this name
		} else {
		  query_string[pair[0]].push(decodeURIComponent(pair[1]));
		}
	  }
	  return query_string;
	}		

	$('.wrap.wpch a.nav-tab').click(function(){
		$(this).siblings().removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active');
		$('.nav-tab-content').hide();
		$('.nav-tab-content').eq($(this).index()).show();
		//window.history.replaceState('', '', wos_obj.this_url+'&t='+$(this).index());			
		
	});				
	
	var query = window.location.search.substring(1);
	var qs = parse_query_string(query);		
	
	if(typeof(qs.t)!='undefined'){
		$('.wrap.wpch a.nav-tab').eq(qs.t).click();
		
	}
	if($('.wrap.wpch').length>0)
	$('.wrap.wpch').show();	
});		