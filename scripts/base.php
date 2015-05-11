<?php
//constantes de connexion
define('DSN', 'mysql:host=localhost;port=3306;dbname=planif_meeting');

//id + pwd user
define('LOGIN', 'videodesk');
define('PASSWORD', 'videodesk');

//options pilote
$options = array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_PERSISTENT => true );
?>