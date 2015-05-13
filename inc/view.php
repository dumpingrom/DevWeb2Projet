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

		#si la requete reunion ramene un resultat
		if(count($reu) > 0) {

			foreach ($reu as $r) {
				$nomReunion = $r['nom'];

				$reqCreateur = $bdd->prepare("SELECT * FROM users WHERE id=?");
				$reqCreateur->execute(array($r['idCreateur']));
				$createur = $reqCreateur->fetch();
				$nomCreateur = "Cr&eacute;&eacute;e par <span class='text-info'>".$createur['prenom']." ".$createur['nom']."</span>";
				
				$date = new DateTime($r['dateCreation']);
				$dateCreation = "le ".$date->format("d/m/Y")." &agrave; ".$date->format("H\hi");

				$reqProp = $bdd->prepare("SELECT * FROM propositions INNER JOIN creneaux ON creneaux.id=propositions.idCreneau WHERE idReunion=? ORDER BY dateProp");
				$reqProp->execute(array($r['id']));
				$prop = $reqProp->fetchAll();
				#dtwd
				$propositionsInline = "";

				#recuperation de la premiere date pour initialisation de l'element <table>
				$dateBase = new DateTime($prop[0]['dateProp']);
				
				$jourEnCours = "";
				$rowAnnees = array();
				$rowMois = array();
				$rowJours = array();
				$rowCreneaux = array();
				$derniereProp = end(array_keys($prop));
				$colspanMois = 0;
				$colspanAnnee = 0;
				$i = 0;

				#construction lignes de tableau en fonction des resultats ramenes par la requete $reqProp
				foreach ($prop as $p) {
					#dtwd
					# $propositionsInline .= $p['dateProp']."<br>".$p['heureDebut']." -> ".$p['heureFin']."<br><br>";
					$anneeEnCours = $dateBase->format('Y');
					$moisEnCours = $dateBase->format('F');
					
					# assignation de la date de la proposition à un nouvel objet
					$dateProp = new DateTime($p['dateProp']);
					# recuperation des infos de la date (annee mois et jour)
					$anneeProp = $dateProp->format('Y');
					$moisProp = $dateProp->format('F');
					$jourProp = $dateProp->format('d');
					
					

					if($anneeProp != $anneeEnCours || $i == $derniereProp) {
						($i == 0) ? $rowAnnees[] = '<td colspan="'.$colspanAnnee.'"><span>'.$anneeProp." :: ".$i.'</span></td>' : $rowAnnees[] = '<td colspan="'.$colspanAnnee.'"><span>'.$anneeEnCours." :: ".$i.'</span></td>';

						$colspanAnnee = 0;
						$anneeEnCours = $anneeProp;
					}
					else {
						$anneeEnCours = $anneeProp;
					}

					if($moisProp != $moisEnCours || $i == $derniereProp) {
						echo $moisEnCours." -> ";
						echo $moisProp."<br>";
						if($i == 0 || $i == $derniereProp) {
							$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisProp." :: ".$i.'</span></td>';
						}
						else {
							$rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisEnCours." :: ".$i.'</span></td>';
						}
						#($i == 0) ? $rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisProp.'</span></td>' : $rowMois[] = '<td colspan="'.$colspanMois.'"><span>'.$moisEnCours.'</span></td>';

						$colspanMois = 0;
						$moisEnCours = $moisProp;
					}
					else {
						
						$moisEnCours = $moisProp;
					}

					if($dateBase->getTimestamp() != $dateProp->getTimestamp() || $i == 0) {
						$rowJours[] = '<td class="jour"><span>'.$jourProp." :: ".$i.'</span></td>';
						$jourEnCours = $jourProp;
						$colspanMois += 1;
						$colspanAnnee += 1;
					}
					else {
						#afficher creneau
					}
					/* echo 'moisEnCours => '.$moisEnCours."<br>";
					echo 'moisProp => '.$moisProp.'<br>';
					echo 'anneeEnCours => '.$anneeEnCours.'<br>';
					echo 'anneeProp => '.$anneeProp.'<br>';
					echo 'colspanAnnee => '.$colspanAnnee."<br>";
					echo 'colspanMois => '.$colspanMois."<br>";
					echo "<hr>";*/
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
		<!--<p>
			<?php # echo $propositionsInline; ?>
		</p>-->
		<table class="table table-bordered">
			<tr id="row-annees">
				<?php 
					foreach ($rowAnnees as $a) {
						echo $a;
					}
					echo $rowAnnees[$derniereProp];
				?>
			</tr>
			<tr id="row-mois">
				<?php 
					foreach ($rowMois as $m) {
						echo $m;
					}
				?>
			</tr>
			<tr id="row-jours">
				<?php 
					foreach ($rowJours as $j) {
						echo $j;
					}
				?>
			</tr>
		</table>
	</div>
</div>