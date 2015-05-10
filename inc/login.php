<div class="container" id="container-connexion">
	<div class="page-header">
		<h1>Connexion</h1>
	</div>
	<?php 
		if (isset($_GET['m'])) {
			$m = $_GET['m'];

			switch ($m) {
				case 'formErr':
					echo '<p class="alert alert-danger">Tous les champs sont obligatoires<span class="infoClose">X</span></p>';
					break;
				case 'req':
					echo '<p class="alert alert-danger">Vous devez &ecirc;tre connect&eacute;<span class="infoClose">X</span></p>';
					break;
				case 'invalid':
					echo '<p class="alert alert-danger">Cette combinaison utilisateur / mot de passe n\'existe pas<span class="infoClose">X</span></p>';
					break;				
				default:
					# code...
					break;
			}
		}
	 ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Veuillez entrer vos informations de connexion</h3>		
		</div>
		<div class="panel-body">	
			<form method="post" action="scripts/connexion.php" class="">
				<div class="form-group">
					<label for="login">Nom d'utilisateur</label>
					<input type="text" name="login" placeholder="Nom d'utilisateur" class="form-control input-lg">
				</div>
				<div class="form-group">
					<label for="pwd">Mot de passe</label>
					<input type="password" name="pwd" placeholder="Mot de passe" class="form-control input-lg">
				</div>
				<button type="submit" class="btn btn-default">Connexion</button>
			</form>
		</div>

	</div>
</div>