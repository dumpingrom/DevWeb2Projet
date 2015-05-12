<?php

require 'scripts/base.php';

$warning = "";
$nomReunion = "R&eacute;union";
$nomCreateur = "";

if(isset($_GET['id']) && is_string($_GET['id'])) {
	try {	
		$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);

		$reqReunion = $bdd->prepare("SELECT * FROM reunions WHERE id=?");

		$reqReunion->execute(array($_GET['id']));

		$reu = $reqReunion->fetchAll();

		if(count($reu) > 0) {
			foreach ($reu as $r) {
				$nomReunion = $r['nom'];

				$reqCreateur = $bdd->prepare("SELECT * FROM users WHERE id=?");
				$reqCreateur->execute(array($r['idCreateur']));
				$createur = $reqCreateur->fetch();
				$nomCreateur = "Cr&eacute;&eacute;e par <span class='text-info'>".$createur['prenom']." ".$createur['nom']."</span>";
				
				$date = new DateTime($reu[0]['dateCreation']);
				$dateCreation = "le ".$date->format("d/m/Y")." &agrave; ".$date->format("H\hi");
			}
		}
		else {
			$warning = '<p class="alert alert-danger">Cette r&eacute;union n\'existe pas <span class="infoClose">x<span></p>';
		}
	} catch (Exception $e) {
		echo "Error : ".$e->getMessage();
	}
}
else {
	$warning = '<p class="alert alert-danger">URL non valide <span class="infoClose">x<span></p>';
}

?>

<div class="container">
	<div class="page-header">
		<h1><?php echo $nomReunion; ?> <small><?php echo $nomCreateur." ".$dateCreation; ?></small></h1>
	</div>
<?php echo $warning ?>
</div>