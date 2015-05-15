<?php

require 'base.php';
session_start();


if (isset($_POST['nomVotant']) && is_string($_POST['nomVotant'])) {
	#creation nouvel objet PDO
	$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);

	#preparation requete insertion votant
	$reqVotant = $bdd->prepare('INSERT INTO votants (nom) VALUES (?)');
	$resVotant = $reqVotant->execute(array($_POST['nomVotant']));

	$idVotant = $bdd->lastInsertId();

	foreach ($_POST['voteCreneau'] as $i => $cren) {
		$reqVoteCren = $bdd->prepare('INSERT INTO votes (idProp, idVotant, val) VALUES (?, ?, ?)');
		$reqVoteCren->execute(array($_POST['idProp'][$i], $idVotant, $cren));
	}

	header('Location: ../index.php?p=home&m=vote');
}

?>