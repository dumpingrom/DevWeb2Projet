<div class="container">
<div class="page-header">
	<h1>Mes r&eacute;unions</h1>
</div>
<?php
	require 'scripts/base.php';

	$bdd = new PDO(DSN, LOGIN, PASSWORD, $options);
	$reqConsult = $bdd->prepare("SELECT * FROM reunions WHERE idCreateur=?");
	$reqConsult->execute(array($_SESSION['uid']));
	$resConsult = $reqConsult->fetchAll();
	$content = "";

	if(count($resConsult) > 0) {
		foreach ($resConsult as $reu) {
			$content .= '<tr>';
			$content .= '<td class="linksName"><span>'.$reu['nom'].'</span> <a href="?p=admin&a=results&id='.$reu['id'].'">Voir</a></td>';
			$content .= '<td class="linksInput"><input type="text" class="url-share" value="localhost/devweb2projet/?p=view&id='.$reu['id'].'" readonly></	td>'; 
			$content .= '</tr>';
		}
	}
	else {
		$content .= '<tr><td colspan="2"><span class="text-danger">Vous n\'avez cr&eacute;&eacute; aucune r&eacute;union pour le moment, rendez-vous dans la section <a class="text-info" href="index.php?p=admin&a=create" title="Cr&eacute;er R&eacute;union">Cr&eacute;er R&eacute;union</a>.</span></td></tr>';
	}

?>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nom R&eacute;union</th>
			<th>Lien &agrave; partager</th>
		</tr>
	</thead>
	<tbody>
		<?php
			echo $content;
		?>
	</tbody>
</table>
</div>