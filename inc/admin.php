<?php
if($_SESSION['connectionOk'] == 0) {
	header('Location: index.php?p=login&m=req');
}

if (isset($_GET['a'])) {
	include 'inc/admin_'.$_GET['a'].'.php';
}
else {
	include 'inc/admin_home.php';
}
?>