<?php
session_start();
include ("functions/function_connexion.php");
deconnexion();
//header('location:'.$_SERVER["HTTP_REFERER"] );
header('location:index.php' );
?>

