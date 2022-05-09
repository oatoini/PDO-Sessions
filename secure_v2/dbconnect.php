<?php
    try{
        $connexion=new PDO('mysql:host=localhost:3306;dbname=pdo_v1',
        'root',
        ''); //instance de la classe PDO
        $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (Exception $error){   //on catch une exception avec une variable, qu'on affichera lorsqu'on l'aura récupérer
        echo $error->getMessage();
    }

?>