<?php 
    session_start();
    include ("./include/menu_inclu.php");
    include("./include/fonction.php");

    $nomUtilisateur = isset($_SESSION['NomUtilisateur']) ? $_SESSION['NomUtilisateur'] : '';
    // pour l'affichage 
    echo generationEntete( "Page des utilisateurs", "Bonjour ".$_SESSION['NomUtilisateur']);
    include ("./include/footer_inc.php");


?>