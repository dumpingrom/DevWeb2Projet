<div class="jumbotron">
	<div class="container">
		<h1>Bienvenue</h1>
		<?php 
		if (isset($_GET['m'])) {
			$m = $_GET['m'];
			switch ($m) {
				case 'logout':
					echo '<p class="alert alert-success">Vous avez &eacute;t&eacute; d&eacute;connect&eacute; <span class="infoClose">x<span></p>';
					break;
				case 'vote':
					echo '<p class="alert alert-success">Votre vote a bien &eacute;t&eacute; pris en compte, merci ! <span class="infoClose">x<span></p>';
					break;
				
				default:
					# code...
					break;
			}
		}
		?>
		<p>Cette application vous permet de cr&eacute;er des sondages Web afin de trouver une date de r&eacute;union qui convienne &agrave; tous vos collaborateurs. Pour cr&eacute;er un sondage, <a href="index.php?p=login" title="Connexion">connectez-vous &agrave; votre espace utilisateur</a> et rendez-vous dans la section Cr&eacute;er un sondage.</p>
	</div>
</div>