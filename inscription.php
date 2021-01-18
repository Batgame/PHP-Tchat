<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=tchat', 'root', '****');
}
catch (PDOException $e){
    echo $e->getMessage();
}

if(isset($_POST['forminscription']))
{
  $pseudoincription = htmlspecialchars($_POST['pseudoincription']);
  $pseudoincription = ucfirst($pseudoincription);
  $emailinscription = htmlspecialchars($_POST['emailinscription']);
  $mdpinscription = sha1($_POST['mdpinscription']);

  if(!empty($_POST['pseudoincription']) AND !empty($_POST['emailinscription']) AND !empty($_POST['mdpinscription']))
  {
    $taillepseudo = strlen($pseudoincription);
    
    if($taillepseudo <= 50)
    {
      if(filter_var($emailinscription, FILTER_VALIDATE_EMAIL))
      {
        $addmembre = $bdd->prepare('INSERT INTO membres (email, mdp, pseudo) VALUES (?, ?, ?)');
        $addmembre->execute(array($emailinscription, $mdpinscription, $pseudoincription));
        $erreur = 'Votre compte a bien été crée !';
      }
      else
      {
        $erreur = 'Vous devez entrer un email valide !';
      }
    }
    else 
    {
      $erreur = "Le pseudo est trop long !";
    }
  } else 
  {
    $erreur = 'Tous les champs doivent être remplis !';
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>َSign-Up Page</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, maximum-scale=1"/>

  </head>
  <body>

<form class="box" action="inscription.php" method="post">
  <h1>Inscription</h1>
  <input type="text" name="pseudoincription" placeholder="Username" value="<?php if(isset($pseudoincription)){echo $pseudoincription;} ?>">
  <input type="mail" name="emailinscription" placeholder="E-Mail" value="<?php if(isset($emailinscription)){echo $emailinscription;} ?>">
  <input type="password" name="mdpinscription" placeholder="Password">
  <input type="submit" name="forminscription" value="S'enregistrer">
  <p style="color: #3498db">Déjà membre? Connectez-vous <a href='index.php'>ici</a></p> 


  <?php 
  if(isset($erreur))
  {
    echo '<font color="red">'.$erreur.'</>';
  }

  ?>
</form>


  </body>
</html>
