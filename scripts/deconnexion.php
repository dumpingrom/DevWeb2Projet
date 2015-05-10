<?php

	setcookie(session_name(), '', time()-3600);

	$_SESSION = array();

	session_destroy();

	header('Location: index.php?m=logout');
?>