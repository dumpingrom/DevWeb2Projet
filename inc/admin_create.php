<div class="container">
	<div class="page-header">
		<h1>Cr&eacute;er une r&eacute;union</h1>
	</div>
	<?php 
	if (isset($_GET['m'])) {
		$m = $_GET['m'];
		switch ($m) {
			case 'dateFormat':
				echo '<p class="alert alert-danger">Format de date incorrect <span class="infoClose">x<span></p>';
				break;
			case 'field':
				echo '<p class="alert alert-danger">Tous les champs sont obligatoires <span class="infoClose">x<span></p>';
				break;
			case 'hours':
				echo '<p class="alert alert-danger">Vous devez proposer au moins un cr&eacute;neau horaire pour la date <span class="infoClose">x<span></p>';
				break;
			case 'okay':
				echo '<p class="alert alert-success">La r&eacute;union a bien &eacute;t&eacute; enregistr&eacute;e <span class="infoClose">x<span></p>';
				break;
			default:
				# code...
				break;
		}
	}
	?>
	<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="ErrorModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-danger" id="errorModalLabel">Erreur</h4>
				</div>
				<div class="modal-body">
					Vous ne pouvez ajouter que 4 dates maximum pour une r&eacute;union
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-success">
		<div class="panel-heading">
			Nouvelle r&eacute;union
		</div>
		<div class="panel-body">
			<form method="post" action="scripts/create_meeting.php">
				<div class="form-group">
					<label for="name">Nom de la r&eacute;union</label>
					<input type="text" name="nom" class="form-control" placeholder="Nom de la r&eacute;union" required>
				</div>
				<button type="button" class="addDate btn btn-default">
					+ Ajouter date
				</button>
				<div id="propContainer">
					<fieldset class="proposition container-fluid">
						<span class="propClose">x</span>
						<div class="form-group">
							<label>Date propos&eacute;e</label>
							<input name="date[]" class="form-control datepicker" required>
						</div>
						<div class="form-group">
							<label for="cren">Cr&eacute;neaux propos&eacute;s</label><br>
							<input type="hidden" name="tenToNoon[]" value="0">
							<input class="dummyChk" type="checkbox"> 10h-12h
							<input type="hidden" name="twoToFour[]" value="0">
							<input class="dummyChk" type="checkbox"> 14h-16h
							<input type="hidden" name="fourToSix[]" value="0">
							<input class="dummyChk" type="checkbox"> 16h-18h
						</div>
					</fieldset>
				</div>
				<button type="submit" class="btn btn-success">Valider</button>
			</form>
		</div>
		<div class="panel-footer">
			<div><small>Note: Tous les champs doivent &ecirc;tre remplis</small></div>
		</div>
	</div>
</div>