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
			var maxProp = 10;
			if(propContainer.children().length < maxProp) {
				var clone = $('#propContainer fieldset').first().clone();
				clone.appendTo(propContainer);
				clone.find(".datepicker").datepicker({
				    format: "yyyy-mm-dd",
				    startDate: "Date.getDate()",
				    todayBtn: "linked",
				    clearBtn: true,
				    language: "fr",
				    daysOfWeekDisabled: "0,6",
				    autoclose: true,
				    todayHighlight: true
				});
			}
			else {
				$("#errorModal .modal-dialog .modal-content .modal-body").text("Vous ne pouvez faire que "+maxProp+" propositions pour une réunion");
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

	// handler pour la suppression des champs additionnels de proposition de date (admin_create) avec animation
	$(document).on({
		click: function() {
			if($(".proposition").length > 1) {
				$(this).closest(".proposition").animate({
					right: 400,
					height: 'toggle',
					opacity: 0
				}, 400, function() {
					$(this).closest(".proposition").remove();
				});
			}
			else {
				$("#errorModal .modal-dialog .modal-content .modal-body").text("Vous devez faire au moins une proposition pour cette réunion");
				$("#errorModal").modal('show');
			}
		}
	}, ".propClose");
});