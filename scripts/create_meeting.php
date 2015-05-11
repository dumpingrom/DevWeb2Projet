<html>
<head>
	<title></title>
</head>
<body>
	<?php
		session_start();
		# verification de la connexion
		if($_SESSION['connectionOk'] == 1) {
			# initialisation d'une variable de type booleen
			$isDateCorrect = true;
			# verification des variables POST
			if(!empty($_POST['nom']) && is_string($_POST['nom']) && isset($_POST['date']) && is_array($_POST['date'])) {
				# initialisation d'une chaine de caracteres contenant la requete pour l'insertion de la reunion a la BDD
				$reqReunion = "INSERT INTO reunions ('nom') VALUES (".$_POST['nom'].")";
				#assignation du tableau de valeurs dates a une variable, idem pour les creneaux
				$dates = $_POST['date'];
				$tenToNoon = $_POST['tenToNoon'];
				$twoToFour = $_POST['twoToFour'];
				$fourToSix = $_POST['fourToSix'];
				echo "<p>".$tenToNoon."</p>";
				# echo "<p>".implode(', ', $dates)."</p>";
				#parcours du tableau des dates envoyees
				foreach ($dates as $key => $value) {
					# verification du format de la date
					$isDateCorrect = (DateTime::createFromFormat('d/m/y', $value) || DateTime::createFromFormat('m/d/y', $value) || DateTime::createFromFormat('Y-m-d', $value));
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
							header('Location: ../index.php?p=admin&a=create&m=okay');
						}
					}
				}
			}
			else {
				# si variables POST pas initialisees, redirection et affichage d'un message d'erreur
				header('Location: ../index.php?p=admin&a=create&m=field');
			}
		}
		else { //non connecte
			header('Location: ../index.php?p=login&a=create&m=req');
		}
	?>
	
</body>
</html>