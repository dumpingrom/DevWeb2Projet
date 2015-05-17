<?php

require 'scripts/base.php';
setlocale(LC_ALL, 'fr_FR', 'fr', 'fr_FR@euro');

$warning = "";
$nomCreateur = "";
$nomReunion = "";
$dateCreation = "";
$instructions = "Veuillez v&eacute;rifier l'URL dans la barre d'adresse de votre navigateur. L'URL devrait &ecirc;tre de la forme <code>www.votemeet.com/?p=view&id=98</code>";
$formNom = "";

$rowAnnees = array();
$rowMois = array();
$rowJours = array();
$rowCreneaux = "";

if(isset($_GET['id']) && is_string($_GET['id'])) {
	try {	
		$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);

		$reqReunion = $bdd->prepare("SELECT * FROM reunions WHERE id=?");

		$reqReunion->execute(array($_GET['id']));

		$reu = $reqReunion->fetchAll();

		#si la requete reunion ramene un resultat
		if(count($reu) > 0) {

			foreach ($reu as $r) {
				#mise a jour du nom de la reunion pour l'affichage du titre
				$nomReunion = $r['nom'];
				#mise a jour du texte d'instruction
				$instructions = "Veuillez cocher vos disponibilit&eacute;s, pour les dates et horaires propos&eacute;s, indiquer votre nom et valider pour envoyer votre vote.";
				#mise a jour de la partie formulaire pour le nom du votant
				$formNom = '<div class="form-group">
								<label>Votre nom</label>
								<input type="text" name="nomVotant" class="form-control" required><br>
							</div>
							<button class="btn btn-success" type="submit">Valider</button>';

				$reqCreateur = $bdd->prepare("SELECT * FROM users WHERE id=?");
				$reqCreateur->execute(array($r['idCreateur']));
				$createur = $reqCreateur->fetch();
				$nomCreateur = "Cr&eacute;&eacute;e par <span class='text-info'>".$createur['prenom']." ".$createur['nom']."</span>";
				
				$date = new DateTime($r['dateCreation']);
				$dateCreation = "le ".$date->format("d/m/Y")." &agrave; ".$date->format("H\hi");

				$reqProp = $bdd->prepare("SELECT DISTINCT * FROM propositions INNER JOIN creneaux ON creneaux.id=propositions.idCreneau WHERE idReunion=? ORDER BY dateProp ASC, idCreneau");
				$reqProp->execute(array($r['id']));
				$prop = $reqProp->fetchAll();

				#recuperation de la premiere date pour initialisation de l'element <table>
				$dateBase = new DateTime($prop[0]['dateProp']);
				
				$derniereProp = end($prop);
				reset($prop);
				$colspanMois = 0;
				$colspanAnnee = 0;
				$colspanJour = 0;
				$i = 0;
				$anneeEnCours = $dateBase->format('Y');
				$moisEnCours = strftime("%b", $dateBase->getTimestamp());
				$jourEnCours = strftime("%a %d", $dateBase->getTimestamp());

				#construction lignes de tableau en fonction des resultats ramenes par la requete $reqProp
				foreach ($prop as $p) {					
					# assignation de la date de la proposition à un nouvel objet
					$dateProp = new DateTime($p['dateProp']);
					# recuperation des infos de la date (annee mois et jour)
					$anneeProp = $dateProp->format('Y');
					$moisProp = strftime("%b", $dateProp->getTimestamp());
					$jourProp = strftime("%a %d", $dateProp->getTimestamp());
					

					if($anneeProp != $anneeEnCours) {
						$rowAnnees[] = '<td colspan="'.$colspanAnnee.'"><span>'.$anneeEnCours.'</span></td>';

						$colspanAnnee = 0;
						$anneeEnCours = $anneeProp;
					}
					else {
						$anneeEnCours = $anneeProp;
					}

					if($moisProp != $moisEnCours) {
						$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisEnCours.'</span></td>';

						/*if($i == 0) {
							$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisProp.'</span></td>';
						}
						else {
							$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisEnCours.'</span></td>';
						}*/
						#($i == 0) ? $rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisProp.'</span></td>' : $rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisEnCours.'</span></td>';

						$colspanMois = 0;
						$moisEnCours = $moisProp;
					}
					else {			
						$moisEnCours = $moisProp;
					}

					if($jourEnCours != $jourProp) {
						$rowJours[] = '<td class="jour" colspan="'.$colspanJour.'"><span>'.$jourEnCours.'</span></td>';
						$colspanJour = 0;
						$jourEnCours = $jourProp;
					}
					else {
						$jourEnCours = $jourProp;
					}

					# affichage creneaux
					if($i != 0) {
						$rowCreneaux .= '</td>';
					}
					$rowCreneaux .= '<td class="creneaux">';
					$heureDebut = new DateTime($p['heureDebut']);
					$heureFin = new DateTime($p['heureFin']);
					$rowCreneaux .= '<span class="spanCren">
					<input type="hidden" value="'.$p['idProp'].'" name="idProp[]">
					<input type="hidden" value="0" name="voteCreneau[]">
					<input type="checkbox" class="dummyChk"><br>'.$heureDebut->format('H').'h-'.$heureFin->format('H').'h
					</span>';
					#incr. colspan
					$colspanMois += 1;
					$colspanAnnee += 1;
					$colspanJour += 1;

					if($p == $derniereProp) {
						$rowAnnees[] = '<td colspan="'.$colspanAnnee.'"><span>'.$anneeProp.'</span></td>';
						$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisProp.'</span></td>';
						$rowJours[] = '<td class="jour" colspan="'.$colspanJour.'"><span>'.$jourProp.'</span></td>';

					}

					#incr. index et maj date en cours
					$i+=1;
					$dateBase = $dateProp;
				}
				#fin foreach proposition

				#break de securite car un seul resultat en theorie pour la req reunion
				break;
			}
			#fin foreach req reunion
		}
		# si aucun resultat pour la requete reunion
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
	<div>
	<div>
		<span>
			<?php echo $instructions; ?>
		</span>
	</div>
		<!--<p>
			<?php # echo $propositionsInline; ?>
		</p>-->
		<form method="post" action="scripts/vote.php" name="formVote" id="formVote">
		<table class="table table-bordered" id="tableProp">
			<tr id="row-annees" class="active">
				<?php 
					foreach ($rowAnnees as $a) {
						echo $a;
					}
				?>
			</tr>
			<tr id="row-mois" class="info">
				<?php 
					foreach ($rowMois as $m) {
						echo $m;
					}
				?>
			</tr>
			<tr id="row-jours" class="warning">
				<?php 
					foreach ($rowJours as $j) {
						echo $j;
					}
				?>
			</tr>
			<tr id="row-cren" class="danger">
				<?php echo $rowCreneaux; ?>
			</tr>
		</table>
		<?php echo $formNom; ?>
		</form>
	</div>
</div>