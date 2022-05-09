<?php
//on cherche d'abord à se connecter
require_once("dbconnect.php"); // pour ne pas le monopoliser
require_once("MyError.php");
require_once("Controller.php");

session_start();

$controller = new Controller($connexion);

//récupère le contenu de nos variables

//récupère les champs du formulaire
$form_username = $_POST['username'];

$form_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
/*on va mettre dans une variable objet user, le user que j’aurai récupéré en BDD car la fonction getUser renvoie à un objet 
obligatoirement. Pour utiliser le controller, qui est une classe, il faut l'instancier et on lui donne son unique argument*/
$user = $controller->getUser($form_username); //vas me chercher la méthode getUser et je t’injecte $form_username 

//vérification

if (is_array($user)){
//si le user est bien un tableau alors je le mets en session
    $form_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($controller->verify_password($form_password)){
        
            if(hash_equals($_SESSION['token'], $token)){
            //SI les token correspondent ALORS
                $_SESSION['user'] = $user;
                header("Location:index.php");
            //je les envoie dans user
            }else{
                $_SESSION['error']->setError(-7, "Identification incorrecte ! Veuillez réessayer ...");
                header("Location:index.php?error");
            //SINON je lui dis identifiant incorrect car je n'ai pas d'user en session
            }
        }
}else{
    $_SESSION['error']->setError(-1, "Identification incorrecte ! Veuillez réessayer ...");
    header("Location:index.php?error");
//sinon afficher une erreur avec sa fonction, et stocker cette erreur dans le tableau de stockage session
}

?>