/*
 * Super RSS Reader - v1.2
 * Included with "Super RSS Reader" Wordpress plugin @since v2.0
 * Author: Aakash Chakravarthy, www.aakashweb.com
 */

(function($){
$(document).ready(function(){
    
    var widget = $('.super-rss-reader-widget');
    widget.find('.srr-wrap').hide();
    widget.find('.srr-wrap:first').show();
    widget.find('.srr-tab-wrap li:first').addClass('srr-active-tab');

    $('.srr-tab-wrap li').click(function(){
        var id = $(this).attr('data-tab');
        var parent = $(this).parent().parent();
        
        $(this).parent().children('li').removeClass('srr-active-tab');
        $(this).addClass('srr-active-tab');
        
        parent.find('.srr-wrap').hide();
        parent.find('.srr-wrap[data-id=' + id + ']').show();
    });

    // Add the ticker to the required elements
    $('.srr-vticker').each(function(){
        var visible = $(this).attr('data-visible');
        var interval = $(this).attr('data-speed');
        var height = (parseInt(visible) <= 20 ? 'auto' : visible );
        var ticker = $(this).easyTicker({
            'visible': visible,
            'height': height,
            'interval': interval
        });
    });
    
});
}(jQuery));