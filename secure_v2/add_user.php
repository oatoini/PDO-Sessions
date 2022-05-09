<?php

    require_once("dbconnect.php");
    require_once("MyError.php");
    require_once("Controller.php");

    session_start();

    $controller = new Controller($connexion);
    $form_username = htmlentities(trim($_POST['username']));
    //On va utiliser une regex comme filter pour suivre les recommandations de l’ANSSI
    /*$form_username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, [
        "options"=>[
            "regexp" => '#^[A-Za-z][A-Za-z0-9_]{5,29}$#'
        ]
    ]);*/
        /*le mot de passe doit commencer par [une lettre] [soit lettre majuscule de A à Z soit minuscule de A à Z 
        soit chiffre de 0 à 9 soit un underscore]{minimum 5 caractères et maximum 29}*/

        if (is_string($form_username)){
            
            $form_password = htmlentities(trim($_POST['password']));
            /*$form_password = filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP,[
                "options"=>[
                    "regexp" => '#^.*(?=.{8,63})(?=.*[A-Z])(?=.*[a-z])(?=.*[^A-Za-z0-9]).*$#'
                ]
            ]);*/
            /*SI le form_username c-a-d ce que je récupère, est un string ALORS {Je vais filtrer ça.}
            {8 caractères min}[doit commencer par une lettre maj][doit y avoir une minuscule après][doit y avoir des chiffres]*/

            if(is_string($form_password)){
            //SI ce que je récupère ici est un string ALORS je vais filtrer ça
                $user = $controller->getUser($form_username);

                if(is_array($user)){
                    $_SESSION['error']->setError(-2, "Cet identifiant est déjà pris ! Veuillez en choisir un autre ...");
                    header("Location:sign-in.php?error");
                /*SI (ce que tu me renvoie (c-a-d user) est un array ça signifie qu’il existe en BDD ALORS{on mettra l’affichage de cette 
                erreur dans MyError.php*/ 
                }else{
                    $password2 = filter_input(INPUT_POST, 'passwordverif', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
                /*}SINON{Filter_input de la variable*/
                    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if($password2 === $form_password){
                        //SI le 1er password et le 2e password sont strictement ===  égaux  ALORS {
                        $status=$controller->addUser(strtolower($form_username), password_hash($form_password, PASSWORD_ARGON2I));
                        // var_dump($_SESSION['token']);
                        // die();
                    /*addUser() pour ajouter le mdp et le nom du user et utiliser une fonction native de php password_hash() 
                    qui permet de hasher une chaine de caractères*/
                        if (($status)&& (hash_equals($_SESSION['token'], $token))){ //si le adduser a fonctionné correctement
                            header("Location:index.php");
                        }else{
                            $_SESSION['error']->setError(-3, "Erreur inconnue ! Veuillez réessayer ...");
                            header("Location:sign-in.php?error");
                        //SINON rentres un autre mdp (sans donner trop de détails sur le mdp)
                        }
                    }else{
                        $_SESSION['error']->setError(-4, "Les deux mots de passe ne sont pas identiques");
                        header("Location:sign-in.php?error");
                    }
                }

            }else{
                $_SESSION['error']->setError(-5, "Le mot de passe doit avoir au moins 8 caractères");
                header("Location:sign-in.php?error");
                //Sinon Afficher l'erreur le mot de passe doit avoir huit carcatères
            }
        }else{
            $_SESSION['error']->setError(-6, "Le username doit avoir au moins 5 caractères");
            header("Location:sign-in.php?error");
        }

?>