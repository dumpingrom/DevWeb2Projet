<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 

	require 'base.php';

	session_start();

	if(empty($_POST['login']) || empty($_POST['pwd'])) {
		header('Location: ../index.php?p=login&m=formErr');
		$_SESSION['connectionOk'] = 0;
		# echo "<p>Connexion impossible car un ou plusieurs champs non renseign&eacute;(s)<p>";
	}
	else {
		$login = $_POST['login'];
		$pwd = md5($_POST['pwd']);
		try {
			$cnx = new PDO(DSN, LOGIN, PASSWORD, $options);
			$req_login = "SELECT * FROM users WHERE login = '".$login."' AND pwd = '".$pwd."'";
			$res = $cnx->query($req_login)->fetchAll();

			if(count($res) == 0) {
				$_SESSION['connectionOk'] = 0;
				header('Location: ../index.php?p=login&m=invalid');
			}
			else {
				$_SESSION['connectionOk'] = 1;
				foreach ($res as $ligne) {
					$_SESSION['nom'] = $ligne['nom'];
					$_SESSION['prenom'] = $ligne['prenom'];
					$_SESSION['uid'] = $ligne['id'];
					//break de securite, une seule ligne devrait etre retournee
					break;
				}
				header('Location: ../index.php?p=admin');
			}
		} catch (Exception $e) {
			die("Echec : ".$e->getMessage());
		}
	}

	?>

</body>
</html>
