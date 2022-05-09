<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // On démarre une session en cours
        session_start();
    ?>
    <!-- Un formulaire s'envoie en post. Avec cette méthode, les données du formulaire seront encodées dans une URL.-->
    <form action="bdd.php" method="post">
    <!-- Le name du champ est considéré comme une variable contenant la valeur saisie.-->
        <p><input type="text" name="username" id="username" placeholder="Votre username" required="required"></p>
        <p><input type="password" name="password" id="password" placeholder="Votre mot de passe" required="required"></p>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>