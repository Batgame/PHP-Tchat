<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=membres', 'root', '');

if(isset($_POST['formconnexion']))
{
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);
  if(!empty($mailconnect) AND !empty($mdpconnect))
  {
    $requser = $bdd->prepare('SELECT * FROM membres WHERE mail = ? AND mdp = ?')
    $requser->execute(array($mailconnect, $mdpconnect))
    $userexist = $requser-> rowCount();
    if($userexist == 1)
    {
      $userinfo = $requser->fetch();
      $_SESSION['id'] = $userinfo['id'];
      $_SESSION['pseudo'] = $userinfo['pseudo'];
      $_SESSION['mail'] = $userinfo['mail'];
      header("Location: profil.php?id=".$_SESSION['id']);
    }
    else 
    {
      $erreur = 'Mauvais identifiant ou mot de passe !'
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

<form class="box" action="index.html" method="post">
  <h1>Login</h1>
  <input type="text" name="mailconnect" placeholder="Username">
  <input type="password" name="mdpconnect" placeholder="Password">
  <input type="submit" name="formconnexion" value="Login">
</form>


  </body>
</html>
