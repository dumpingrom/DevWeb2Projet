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
			case 'error':
				echo '<p class="alert alert-danger">Erreur lors de l\'envoi des donn&eacute;es <span class="infoClose">x<span></p>';
				break;
			case 'hours':
				echo '<p class="alert alert-danger">Vous devez proposer au moins un cr&eacute;neau horaire pour la date <span class="infoClose">x<span></p>';
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
	<div class="panel panel-primary">
		<div class="panel-heading">
			Nouvelle r&eacute;union
		</div>
		<div class="panel-body">
			<form method="get" action="scripts/create_meeting.php">
				<div class="form-group">
					<label for="name">Nom de la r&eacute;union</label>
					<input type="text" name="nom" class="form-control" placeholder="Nom de la r&eacute;union">
				</div>
				<button type="button" class="addDate btn btn-default">
					<strong>+ Ajouter date</strong>
				</button>
				<div id="propContainer">
					<fieldset class="proposition bg-info container-fluid">
						<div class="form-group">
							<label>Date propos&eacute;e</label>
							<input type="date" name="date[]" class="form-control">
						</div>
						<div class="form-group">
							<label for="cren">Cr&eacute;neaux propos&eacute;s</label><br>
							<input type="checkbox" name="tenToNoon[]"> 10h-12h
							<input type="checkbox" name="twoToFour[]"> 14h-16h
							<input type="checkbox" name="fourToSix[]"> 16h-18h
						</div>
					</fieldset>
				</div>
				<button type="submit" class="btn btn-success">Valider</button>
			</form>
		</div>
	</div>
</div>