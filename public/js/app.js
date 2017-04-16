
(function($) {
    $(function() {

		$('.modal').modal();
		$.fn.hasScrollBar = function() {
	        return this.get(0).scrollWidth > (this.width() - 300);
	    }
	    $('.activate_modal').on('click', function(){
	    	var id = $(this).attr('href');
	    	$(id).find('input[type=text], input[type=email]').each(function(){
	    		$(this).val('');
	    	});
	    });
    }); // end of document ready
})(jQuery); // end of jQuery name space