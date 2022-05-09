<?php
//classe servant à réagir face aux erreurs
class MyError{
    
    private $_code;
    private $_message;
    private $_time;

    function __construct($code = 0 , $message = ""){            //je veux que mon message soit vide à la base
        $this->_code = $code;                                   //pour l'objet en cours _code sera égale à $code
        $this->_message = $message;                             //message sera égale au contenu du message
        $this->_time = new DateTime("NOW", new DateTimeZone("Europe/Paris"));
    }

    function __toString(){                                      //appel de l'objet et lui renvoyer une chaine de caractères
        return ($this->_code != 0) ? "[".$this->_time->format('Y-m-d H:i:s')."] Error".$this->_code." : ".$this->_message :"";   
    /*SI le code est différent de 0 ALORS affiche moi le code et le format de date SINON tu me donnes le message*/     
    }

    function setError($code = 0, $message =""){          //à la base c’est un code=0 et qu’il n’y a aucun message à afficher car 0 erreurs à set
            $this->_code = $code;
            $this->_message = $message;
            $this->_time = new DateTime("NOW", new DateTimeZone("Europe/Paris"));
    }

}
?>