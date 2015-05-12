<?php
	require_once 'scripts/init_session.php';

	session_start();

	if (!isset($_SESSION['connectionOk'])) {
		$_SESSION['connectionOk'] = 0;
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Planif de r&eacute;unions</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bs-theme.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
</head>
<body>

<?php
	# Detection de la page en cours
	$p = "home";
	if(isset($_GET['p'])) {
		$p = $_GET['p'];
	}

	# inclure la barre de navigation
	include 'inc/nav.php';

	foreach ($_SESSION as $key => $value) {
		echo '<script type="text/javascript">console.log("'.$key." -> ".$value.'");</script>';
	}

	$filename = "inc/".$p.".php";
	if(file_exists($filename)) {
		include $filename;
	}
	else {
		include 'inc/404.php';
	}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/bootstrap-datepicker.fr.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>