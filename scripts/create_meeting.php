<html>
<head>
	<title></title>
</head>
<body>
	<?php
		# restauration session, inclusion base.php et creation objet PDO pour execution requetes
		session_start();
		require 'base.php';

		# verification de la connexion
		if($_SESSION['connectionOk'] == 1) {
			try {
				$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);
				# initialisation d'une variable de type booleen pour verification des dates
				$isDateCorrect = true;
				# booleen pour verification de reunion deja creee
				$isMeetingCreated = false;
				# verification des variables POST
				if(!empty($_POST['nom']) && is_string($_POST['nom']) && isset($_POST['date']) && is_array($_POST['date'])) {
					# preparation de la requete pour l'insertion de la reunion a la BDD
					$reqReunion = $bdd->prepare("INSERT INTO reunions (nom, idCreateur) VALUES (?, ?)");
					# idem pour la requete d'insertion des propositions
					$reqProp = $bdd->prepare("INSERT INTO propositions (dateProp, idReunion, idCreneau) VALUES(?, ?, ?)");
					#assignation du tableau de valeurs dates a une variable, idem pour les creneaux
					$dates = $_POST['date'];
					$tenToNoon = $_POST['tenToNoon'];
					$twoToFour = $_POST['twoToFour'];
					$fourToSix = $_POST['fourToSix'];
					# echo "<p>".implode(', ', $dates)."</p>";
					#parcours du tableau des dates envoyees
					foreach ($dates as $key => $date) {
						# verification du format de la date
						$isDateCorrect = (DateTime::createFromFormat('d/m/y', $date) || DateTime::createFromFormat('m/d/y', $date) || DateTime::createFromFormat('Y-m-d', $date));
						if($isDateCorrect == false) {
							# si date incorrecte, redirection et sortie de boucle (en theorie break; ne devrait jamais etre execute, il s'agit d'une securite suppl.)
							header('Location: ../index.php?p=admin&a=create&m=dateFormat');
							break;
						}
						else {
							# sinon verification et parcours des creneaux coches
							if($tenToNoon[$key] == 0 && $twoToFour[$key] == 0 && $fourToSix[$key] == 0) {
								# si aucun creneau coche, redirection et affichage d'un message d'erreur
								header('Location: ../index.php?p=admin&a=create&m=hours');
							}
							else {
								if($isMeetingCreated == false) {
									# reunion creee, assignation de la valeur vrai au booleen correspondant
									$isMeetingCreated = true;
									# execution de la requete d'insertion de reunion
									$reqReunion->execute(array($_POST['nom'], $_SESSION['uid']));

									# recuperation de l'ID de la reunion nouvellement creee pour insertion des propostions (cle etrangere)
									$justCreated = $bdd->lastInsertId();
								}
								if($tenToNoon[$key] == 1) {
									$reqProp->execute(array($date, $justCreated, 1));
								}
								if($twoToFour[$key] == 1) {
									$reqProp->execute(array($date, $justCreated, 2));
								}
								if($fourToSix[$key] == 1) {
									$reqProp->execute(array($date, $justCreated, 3));
								}
								if($key == count($dates)-1) {
									header('Location: ../index.php?p=admin&a=create&m=okay&id='.$justCreated);
								}
							}
						}
						# reinitialisation du booleen de reunion creee
					}
				}
				else {
					# si variables POST pas initialisees, redirection et affichage d'un message d'erreur
					header('Location: ../index.php?p=admin&a=create&m=field');
				}
			} catch (Exception $e) {
				die("Echec : ".$e->getMessage());
			}
		}
		else { //non connecte
			header('Location: ../index.php?p=login&m=req');
		}
	?>
	
</body>
</html>