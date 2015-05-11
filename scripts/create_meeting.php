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
			if(isset($_GET['nom']) && is_string($_GET['nom']) && isset($_GET['date']) && is_array($_GET['date'])) {
				# echo "<p>is_array(date) = true</p>";
				#assignation du tableau de valeurs dates a une variable, idem pour les creneaux
				$dates = $_GET['date'];
				$tenToNoon = $_GET['tenToNoon'];
				$twoToFour = $_GET['twoToFour'];
				$fourToSix = $_GET['fourToSix'];
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
							//header('Location: ../index.php?p=admin&a=create&m=hours');
						}
					}
				}
			}
			else {
				# si variables POST pas initialisees, redirection et affichage d'un message d'erreur
				header('Location: ../index.php?p=admin&a=create&m=error');
			}
		}
		else { //non connecte
			header('Location: ../index.php?p=login&a=create&m=req');
		}
	?>
	
</body>
</html>