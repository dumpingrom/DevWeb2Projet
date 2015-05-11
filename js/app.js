$(function() {
	//initialisation des datepickers de Bootstrap
	$(".datepicker").datepicker({
	    format: "yyyy-mm-dd",
	    startDate: "Date.getDate()",
	    todayBtn: "linked",
	    clearBtn: true,
	    language: "fr",
	    daysOfWeekDisabled: "0,6",
	    autoclose: true,
	    todayHighlight: true
	});

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

	// handler pour le changement des valeurs des champs hidden dans le formulaire de creation de reunion
	$(document).on({
		change: function () {
			var hiddenInput = $(this).prev();
			// si = 0 -> 1-0 = 0 ; si = 1 -> 1-1 = 0
			hiddenInput.val(1 - hiddenInput.val());
		}
	}, ".dummyChk");
});