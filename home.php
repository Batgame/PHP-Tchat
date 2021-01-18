<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=tchat', 'root', '****');
}
catch (PDOException $e){
    echo $e->getMessage();
}

if (isset($_SESSION)) 
{
	if(!empty($_SESSION))
	{
    $reqmsg = $bdd->prepare('SELECT * FROM messages WHERE destinataire = ? ORDER BY id DESC');
    $reqmsg->execute(array($_SESSION['pseudo']));

    $msgexist = $reqmsg-> rowCount();

    }
  else
	{
		header('Location: index.php');
	}
}


?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Cover Template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/cover/">

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="cover.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
    <div class="inner">
      <h3 class="masthead-brand">LeTchat</h3>
      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link active" href="home.php">Boite de Réception</a>
        <a class="nav-link" href="envoi.php">Envoi</a>
        <a class="nav-link" href="deco.php">Déconnexion</a>
      </nav>
    </div>
  </header>

  <main role="main" class="inner cover">
    <h1 class="cover-heading">Boite de Réception</h1><br />
    <p class="lead" align="left">
      <?php 

      if($msgexist == 0){ echo "<p align='center'>Vous n'avez aucun message...</>";}
      while($message = $reqmsg->fetch())
      {
        $expediteur = $message['expediteur'];
        $message_texte = $message['message'];
        if($message['lu'] == 0)
        { 
        echo '<a href="#"><b>'.$expediteur.': '.$message_texte.'</b></a><br/>';
        }
        else
        {
        echo '<a href="#">'.$expediteur.': '.$message_texte.'</a><br/>';
        }
      }
      ?>

    </p>
    <br /><br />
    <p class="lead">
      <a href="#" class="btn btn-lg btn-secondary">Envoyer un message</a>          
    </p>
  </main>

  <footer class="mastfoot mt-auto">
    <div class="inner">
      <p>Web Application develop by <a href="https://twitter.com/batgame11">@batgame</a>.</p>
    </div>
  </footer>
</div>
</body>
</html>
