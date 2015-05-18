<?php
require 'scripts/base.php';
setlocale(LC_ALL, 'fr_FR', 'fr', 'fr_FR@euro');

$nomReu = "";
$info = "";
$scriptTable = "";

if(isset($_GET['id']) && is_string($_GET['id'])) {
	try {
	$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);
	$reqReu = $bdd->prepare("SELECT * FROM reunions WHERE id=? AND idCreateur=?");
	$reqReu->execute(array($_GET['id'], $_SESSION['uid']));

	

	if($resReu = $reqReu->fetch()) {
		$nomReu = $resReu['nom'];

		$sqlVotes = "SELECT propositions.idProp, propositions.dateProp, votes.idVotant, votes.val, votants.nom, creneaux.heureDebut, creneaux.heureFin  
		FROM propositions 
			INNER JOIN votes ON votes.idProp=propositions.idProp 
			INNER JOIN votants ON votants.id=votes.idVotant 
			INNER JOIN creneaux ON propositions.idCreneau=creneaux.id 
				WHERE propositions.idReunion=? 
				ORDER BY votants.id ASC, votes.idProp ASC";
		$reqCreneaux = $bdd->prepare($sqlVotes);
		$reqCreneaux->execute(array($_GET['id']));

		$votes = $reqCreneaux->fetchAll();
		
		$dernierVote = end($votes);
		reset($votes);
		$idVotantPrev = '';

		$rowsVotant = "";


		if(count($votes) > 0) {
			# script JS permettant de rendre le tableau visible
			$scriptTable = '
				<script type="text/javascript">
					document.getElementById("tableResults").style.visibility = "visible";
				</script>
			';
			$i = 0;
			foreach ($votes as $v) {
				$idVotantCurr = $v['idVotant'];
				
				if($idVotantPrev != $idVotantCurr) {
					if($i != 0){
						$rowsVotant .= '</tr>';
					}
					$rowsVotant .= '<tr class="active">
										<td>'.$v['nom'].'</td>';
				}

				($v['val'] == 1) ? $rowsVotant .= '<td class="success">Oui</td>' : $rowsVotant .= '<td class="danger">Non</td>';


				#incr. index et maj date en cours
				$i+=1;
				$idVotantPrev = $idVotantCurr;
			}
			# fin foreach votes
		}
		else {
			$info = "Aucun de vos collaborateurs n'a encore vot&eacute; pour cette r&eacute;union.";
		}

		#mise a jour du nom de la reunion pour l'affichage du titre
		$nomReunion = $resReu['nom'];

		$reqProp = $bdd->prepare("SELECT DISTINCT * FROM propositions INNER JOIN creneaux ON creneaux.id=propositions.idCreneau WHERE idReunion=? ORDER BY dateProp ASC, idCreneau");
		$reqProp->execute(array($resReu['id']));
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

		$rowAnnees = array();
		$rowMois = array();
		$rowJours = array();
		$rowCreneaux = "";
		$rowCount = array();

		#construction lignes de tableau en fonction des resultats ramenes par la requete $reqProp
		foreach ($prop as $p) {
			$sqlCount = "SELECT COUNT(*) AS c FROM propositions INNER JOIN votes ON propositions.idProp=votes.idProp WHERE votes.idProp=? AND val=1";
			$reqCount = $bdd->prepare($sqlCount);
			$reqCount->execute(array($p['idProp']));
			if($resCount = $reqCount->fetch()) {
				$rowCount[] = '<td>'.$resCount['c'].'</td>';
			}

			# assignation de la date de la proposition à un nouvel objet
			$dateProp = new DateTime($p['dateProp']);
			# recuperation des infos de la date (annee mois et jour)
			$anneeProp = $dateProp->format('Y');
			$moisProp = strftime("%b", $dateProp->getTimestamp());
			$jourProp = strftime("%a %d", $dateProp->getTimestamp());
			

			if($anneeProp != $anneeEnCours) {
				$rowAnnees[] = '<td class="active" colspan="'.$colspanAnnee.'"><span>'.$anneeEnCours.'</span></td>';

				$colspanAnnee = 0;
				$anneeEnCours = $anneeProp;
			}
			else {
				$anneeEnCours = $anneeProp;
			}

			if($moisProp != $moisEnCours) {
				$rowMois[] = '<td class="info" colspan="'.$colspanMois.'"><span>'.$moisEnCours.'</span></td>';

				$colspanMois = 0;
				$moisEnCours = $moisProp;
			}
			else {			
				$moisEnCours = $moisProp;
			}

			if($jourEnCours != $jourProp) {
				$rowJours[] = '<td class="jour warning" colspan="'.$colspanJour.'"><span>'.$jourEnCours.'</span></td>';
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
			$rowCreneaux .= '<span class="spanCren">'.$heureDebut->format('H').'h-'.$heureFin->format('H').'h</span>';
			#incr. colspan
			$colspanMois += 1;
			$colspanAnnee += 1;
			$colspanJour += 1;

			if($p == $derniereProp) {
				$rowAnnees[] = '<td class="active" colspan="'.$colspanAnnee.'"><span>'.$anneeProp.'</span></td>';
				$rowMois[] = '<td class="info" colspan="'.$colspanMois.'"><span>'.$moisProp.'</span></td>';
				$rowJours[] = '<td class="jour warning" colspan="'.$colspanJour.'"><span>'.$jourProp.'</span></td>';

			}

			#incr. index et maj date en cours
			$i+=1;
			$dateBase = $dateProp;
	}
}
	} catch (Exception $e) {
		echo "Error: ".$e->getMessage();
	}
}

?>

<div class="container">
	<div class="page-header">
		<h1><?php echo $nomReu; ?></h1>
	</div>
	<p>
		<?php echo $info; ?>
	</p>
	<p>

	</p>
	<table class="table table-bordered" id="tableResults" style="visibility:hidden;">
	<tr id="row-annees"><td class="emptyTd"></td>
		<?php 
			foreach ($rowAnnees as $a) {
				echo $a;
			}
		?>
	</tr>
	<tr id="row-mois"><td class="emptyTd"></td>
		<?php 
			foreach ($rowMois as $m) {
				echo $m;
			}
		?>
	</tr>
	<tr id="row-jours"><td class="emptyTd"></td>
		<?php 
			foreach ($rowJours as $j) {
				echo $j;
			}
		?>
	</tr>
	<tr id="row-cren" class="danger"><td class="emptyTd"></td>
		<?php echo $rowCreneaux; ?>
	</tr>
		<?php echo $rowsVotant; ?>
	<tr id="row-count"><td class="emptyTd"></td>
		<?php 
			foreach ($rowCount as $c) {
				echo $c;
			}
		?>
	</tr>
	</table>
</div>

<script type="text/javascript">
// script permettant d'afficher une medaille dans la case contenant le plus grand chiffre
	var arr = new Array();
	var row = document.getElementById('row-count');
	
	// iteration dans les td contenus dans #row-count et ajout au tableau
	for(var i = 1; i < row.children.length; i++){
		var toPush = parseInt(row.children[i].innerHTML);
		arr.push(toPush);
	}

	// recuperation de la valeur max du tableau
	var max = Math.max.apply(null, arr);
	console.log(max);

	// reiteration des elements de row-count pour affichage de l icone
	for(var j = 1; j < row.children.length; j++){
		var toCompare = parseInt(row.children[j].innerHTML);

		if(toCompare == max) {
			row.children[j].innerHTML += '<br><span class="winner"></span>';
		}
	}

	console.log(arr);
</script>
<?php echo $scriptTable; ?>