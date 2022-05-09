<?php
//pour garder la SESSION et supprimer juste ce qu’il y a dedans, on utilise le UNSET
session_start();

unset($_SESSION['user']);
unset($_SESSION['error']);
header("Location:index.php");

?>