<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bdd</title>
</head>
<body>
    <!-- On veut insérer les données en BDD, il faut une connexion à celle-ci. -->
    <?php
        // On démarre une session en cours
        session_start();
        //je récupère les champs du form (username et password sont les names du form)
        $form_username = $_POST['username'];            //$_POST est un tableau associatif
        $form_password = $_POST['password'];

        //je me connecte à la bdd grâce à PDO : couche d'abstraction faisant le lien entre la BDD et l'appli php
        try{
            $connexion=new PDO('mysql:host=localhost:3306;dbname=pdo_v1','root',''); //instance de la classe PDO
            $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  /*$connexion car on récupère un objet (1 ligne de la bdd) 
            FETCH MODE car on récupère telle ligne sous la forme d'un array et PDO:: opérateur de résolution de portée. Je vais chercher la classe 
            (le tableau) PDO*/
        }
        catch (Exception $error){       //on catch une exception avec une variable, qu'on affichera lorsqu'on l'aura récupérer
            echo $error->getMessage();
        }
   
    //Pour communiquer avec la bdd, mettre la requête sql dans une variable
    $sql = "SELECT username, password FROM user WHERE username = :uname;";
    //Envoi la requête sql au serveur (prepare-moi la requete sql ,injecté dans la fonction, dans le serveur)
    $statement = $connexion->prepare($sql);
    //injection de paramètres c-a-d attacher les param à ma variable :uname
    $statement->bindParam("uname",$form_username);  //le uname va prendre ce que j'ai mis dans le form comme user
    //execution de la requête
    $result = $statement->execute();
    ?>
</body>
</html>