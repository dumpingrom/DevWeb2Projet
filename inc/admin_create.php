<div class="container">
	<div class="page-header">
		<h1>Cr&eacute;er une r&eacute;union</h1>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			Nouvelle r&eacute;union
		</div>
		<div class="panel-body">
			<form action="scripts/create_meeting.php">
				<div class="form-group">
					<label for="name">Nom de la r&eacute;union</label>
					<input type="text" name="name" class="form-control" placeholder="Nom de la r&eacute;union">
				</div>
				<fieldset class="proposition bg-info container-fluid">
					<div class="form-group">
						<label for="date">Date de la r&eacute;union</label>
						<input type="date" name="date" class="form-control">
					</div>
					<div class="form-group">
						<label for="cren">Cr&eacute;neaux</label><br>
						<input type="checkbox" name="1012" value="1012"> 10h-12h
						<input type="checkbox" name="1416" value="1416"> 14h-16h
						<input type="checkbox" name="1618" value="1618"> 16h-18h
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>