<?php
  $a = 'active';
  $home_active = '';
  $admin_active = '';
  $login_active = '';
  # assignation de la classe active a la page en cours
  switch ($p) {
    case 'home':
      $home_active = $a;
      break;
    case 'admin':
      $admin_active = $a;
      break;
    case 'login':
      $login_active = $a;
      break;
    
    default:
      # code...
      break;
  }
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="navbar-brand" style="vertical-align: middle;">VOT&amp;<br><span class="text-success">MEET</span></span>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php echo $home_active; ?>"><a href="index.php">Accueil <span class="sr-only">(current)</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if ($_SESSION['connectionOk'] == 0) {
            echo '<li class="'.$login_active.'"><a href="index.php?p=login">Connexion</a></li>';
          } else {
            echo '
                  <li class="'.$admin_active.'"><a href="index.php?p=admin">Admin</a></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$_SESSION['prenom'].' '.$_SESSION['nom'].' <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="index.php?p=logout">Deconnexion</a></li>
                      <li><a href="index.php?p=admin&a=create">Cr&eacute;er r&eacute;union</a></li>
                      <li><a href="index.php?p=admin&a=links">Mes r&eacute;unions</a></li>
                    </ul>
                  </li>
            ';
          }
        ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>