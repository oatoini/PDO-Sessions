<?php
    require_once("MyError.php");
    // On démarre une session en cours
    
    session_start();
    $_SESSION['token'] = bin2hex(random_bytes(24));

    if (!isset($_SESSION['error'])) //pour utiliser MyError{} qui est une classe
    //SI il n'y a pas d'error en session, ALORS
        $_SESSION['error'] = new MyError;
    //l'erreur en session c'est une new instance de MyError
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>secure_v2</title>
</head>
<body>
    <p style="color: red">
        <?php
            if(isset($_GET['error'])){
                echo "<strong>".$_SESSION['error']."</strong>";
                //SI il y a dans l’url GET [‘error’] ALORS on echo le contenu de l’erreur « »
            }
        ?>
    </p>

    <?php

        if(!isset($_SESSION['user'])){
            echo "<h2> Connectez-vous OU <a href='sign-in.php'>Inscrivez-vous !</a></h2>"; 
        //SI ( !je n’ai pas($SESSION[‘user’])){ Je redirigerai vers un echo « »} 
        //si je clique sur inscrivez-vous, ça me renvoie à l'url sign in
        }else{
            echo "<h2> Bienvenue ".ucwords($_SESSION['user']['username'])."</h2>";  //ucwords semblable à uppercase
            echo "<h2> <a href='logout.php'>Deconnexion</a></h2>";
        //SINON Afficher echo et le lien qui renvoie au logout

        }
    ?>
    <!-- Un formulaire s'envoie en post. Avec cette méthode, les données du formulaire seront encodées dans une URL.-->
    <form action="login.php" method="post">
    <!-- Le name du champ est considéré comme une variable contenant la valeur saisie.-->
        <p><input type="text" name="username" placeholder="Votre login" required></p>
        <p><input type ="hidden" value="<?=$_SESSION['token']?>" name="token"></p>
        <p><input type="password" name="password" placeholder="Votre mot de passe" required></p>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>