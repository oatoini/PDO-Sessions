<?php
//le controller va traiter la requête http qui sert à récupère les champs du formulaire et qui seront envoyés en POST dans login.php

class Controller{
    private $_connexion;
    private $_user;

    public function __construct($connexion){         //$connexion instance de PDO se trouvant dans dbconnect
        $this->_connexion = $connexion;
    }

    public function getUser($form_username){        /*on créé la fonction getUser qui va recueillir nos méthodes. 
        Le try et catch error, si d’aventure, il ne trouve pas l’user*/
        try{
             //Pour communiquer avec la bdd, mettre la requête sql dans une variable
            //lower pour forcer la minuscule car c'est en minuscule dans la bdd
            $sql = "SELECT username, password FROM user WHERE username = LOWER(:uname) ;";
            //Envoi la requête sql au serveur (prepare-moi la requete sql ,injecté dans la fonction, dans le serveur)
            $statement = $this->_connexion->prepare($sql);
            //injection de paramètres c-a-d attacher les param à ma variable :uname
            $statement->bindParam("uname",$form_username);  //le uname va prendre ce que j'ai mis dans le form comme user
            //execution de la requête
            $statement->execute();

            //on récupère l'objet user de la bdd
            $this->_user = $statement->fetch();
            //une fonction retourne toujours qqch
            return $this->_user;
        }
        catch(Exception $error){
            return $error->getMessage();
        }
    }
    public function verify_password($pwd){
        return password_verify($pwd, $this->_user['password']);
    }

    public function addUser($uname, $pass){

        try{
            //Pour communiquer avec la bdd, mettre la requête sql dans une variable
            $sql = "INSERT INTO user (username, password) VALUES (:name, :pwd)";
           //Envoi la requête sql au serveur (prepare-moi la requete sql ,injecté dans la fonction, dans le serveur)
           $statement = $this->_connexion->prepare($sql);
           //injection de paramètres c-a-d attacher les param à ma variable :uname
           $statement->bindParam("name",$uname);  //le uname va prendre ce que j'ai mis dans le form comme user
           $statement->bindParam("pwd", $pass);
           //execution de la requête et on utilise return car c'est la syntaxe de insert into
           return $statement->execute();
            
        }catch(Exception $error){
            return $error->getMessage();
        }
    }
}
?>