<?php
include('include/menu_inclu.php'); 

// vérifier les informations du formulaire saisie 
if (isset($_POST['prenom']) && isset($_POST['nom']) && 
    isset($_POST["Email1"]) && isset($_POST["Password1"])
    && isset($_POST["Password2"]) && isset($_POST["choixType"])){
    echo "Bienvenue chez nous !";
 
    // connection à la base de données 
    include_once("connexion_bd.php");
    // Ajoutez des var_dump pour déboguer
    var_dump($_POST);
    include_once('classes/User.class.php');
    include_once('classes/UserManager.class.php');
    $manager = new UserManager($db);
    $user = new User([
         'Nom' => $_POST['nom'],
         'Prenom' => $_POST['prenom'] ,
         'Type' => $_POST['choixType'], 
         'Mail' => $_POST['Email1'], 
         'Mdp' => $_POST['Password1']
        ]);
    var_dump($user); // Vérifiez les valeurs de l'objet User avant d'appeler add()
    $manager->add($user);
    
} else {
    echo "erreur de ";

}

