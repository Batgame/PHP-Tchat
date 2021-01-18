<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=tchat', 'root', '*****');
}
catch (PDOException $e){
    echo $e->getMessage();
}


if(isset($_POST['formconnexion']))
{
  $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);
  if(!empty($pseudoconnect) AND !empty($mdpconnect))
  {
    $requser = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ? AND mdp = ?');
    $requser->execute(array($pseudoconnect, $mdpconnect));
    $userexist = $requser-> rowCount();
    if($userexist == 1)
    {
      $userinfo = $requser->fetch();
      $_SESSION['id'] = $userinfo['id'];
      $_SESSION['pseudo'] = $userinfo['pseudo'];
      $_SESSION['email'] = $userinfo['email'];
      header("Location: home.php");
    }
    else 
    {
      $erreur = 'Mauvais identifiant ou mot de passe !';
    }

  }
  else
  {
    $erreur = "Tous les champs doivent être complétés !";
  }



}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>َLogin Page</title>
    <link rel="stylesheet" href="style.css">

  </head>
  <body>

<form class="box" action="index.php" method="post">
  <h1>Login</h1>
  <input type="text" name="pseudoconnect" placeholder="Username">
  <input type="password" name="mdpconnect" placeholder="Password">
  <input type="submit" name="formconnexion" value="Login">
  <meta name="viewport" content="width=device-width, maximum-scale=1"/>

  <p style="color: #e74c3c">Pas encore membre? Inscrivez-vous <a href='inscription.php'>ici</a></p> 

  <?php 
  if(isset($erreur))
  {
    echo '<font color="red">'.$erreur.'</>';
  }

  ?>
</form>


  </body>
</html>
