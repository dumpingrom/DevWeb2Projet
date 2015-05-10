<div class="jumbotron">
	<div class="container">
		<h1>Bonjour, <?php echo $_SESSION['prenom']." ".$_SESSION['nom']." !"; ?></h1>
		<p>Bienvenue dans votre espace administrateur</p>
		<a href="index.php?p=admin&a=create"><button class="btn btn-success">Cr&eacute;er r&eacute;union</button></a>
	</div>
</div>