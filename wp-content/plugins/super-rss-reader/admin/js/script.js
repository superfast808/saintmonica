(function($){
$(document).ready(function(){
    $(document).on('change', '.srr_coffee_amt', function(){
        var $parent = $(this).closest('.srr_coffee_wrap');
        var $btn = $parent.find('.srr_coffee_btn');
        $btn.attr('href', $btn.data('link') + $(this).val());
    });
});
}(jQuery))