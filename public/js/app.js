
(function($) {
    $(function() {

		$('.modal').modal();
		$.fn.hasScrollBar = function() {
	        return this.get(0).scrollWidth > (this.width() - 300);
	    }

    }); // end of document ready
})(jQuery); // end of jQuery name space