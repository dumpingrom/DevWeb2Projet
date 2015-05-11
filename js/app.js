$(function() {
	// handler pour la fermeture des fenetres d'info
	$(document).on({
		click: function() {
			$(this).closest('p').slideUp(250);
		}
	}, ".infoClose");

	// handler pour l'ajout d'une nouvelle date lors de la creation d'une reunion
	$(document).on({
		click: function() {
			var propContainer = $("#propContainer");
			if(propContainer.children().length < 4) {
				$('#propContainer fieldset').first().clone().appendTo(propContainer);
			}
			else {
				$("#errorModal").modal('show');
			}
		}
	}, ".addDate");
});