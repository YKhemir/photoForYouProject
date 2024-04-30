<?php 
include_once("connexion_bd.php");
include_once("./classes/Photo.class.php");
include_once("./classes/PhotoManager.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $photoId = $_POST['photo_id'];
    $photoNom = $_POST['nom_photo'];

    //echo $photoNom;
    $photoManager = new PhotoManager($db);
    try {
        $photoManager->deletePhoto($userId, $photoId);
        unlink("uploads/$photoNom");
        http_response_code(201); // Indique que la suppression a été effectuée avec succès
        echo "Photo successfully deleted!";
    } catch (Exception $e) {
        http_response_code(500); // Indique une erreur interne du serveur
        echo "Error: Unable to delete the photo ".$e->getMessage();
    }
} else {
    http_response_code(400); // Indique une mauvaise requête
    echo "Error: Bad request";
}
?>