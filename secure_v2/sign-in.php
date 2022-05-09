<?php
require_once("MyError.php");
session_start();
$_SESSION['token'] = bin2hex(random_bytes(24));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-in</title>
</head>
<body>
    <p style="color: red">
        <?php
            if(isset($_GET['error'])){
                echo "<strong>".$_SESSION['error']."</strong>";
            }
        //SI il y a dans l’url GET [‘error’] ALORS on echo le contenu de l’erreur « »

        ?>
    </p>

    <h1>Inscription</h1>
    <form action="add_user.php" method="post">

            <p><input type="text" placeholder="Votre login" name="username" required></p>
            <p><input type="hidden" value="<?=$_SESSION['token']?>" name="token"></p>
            <p><input type="password" placeholder="Votre mot de passe" name="password" required></p>
            <p><input type="password" placeholder="Répétez votre mot de passe !" name="passwordverif" required></p>
            <input type="submit" value="inscription">
    </form>

</body>
</html>