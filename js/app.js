$(function() {
	$(document).on({
		click: function() {
			$(this).closest('p').slideUp(250);
		}
	}, ".infoClose");
});