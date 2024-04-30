<?php 
require_once("Photo.class.php");
class PhotoManager{
    // attributs
    private $_db;
    public function __construct($db){
        $this->setDb($db);
	}

    // CRUD 
    
    
    public function addPhotos(Photo $photo)
    {
        $id = $this->_db->query('SELECT MAX(id_photo) FROM photos')->fetchColumn();
        $id = $id !== false ? $id + 1 : 1;
        $userId = null;
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }
        $q = $this->_db->prepare('INSERT INTO photos (id_photo, nom_photo, taille_pixels_x, taille_pixels_y, poids, nbrdephoto, prix_photo, categorie,idUser)
            VALUES (:id_photo, :nom_photo, :taille_pixels_x, :taille_pixels_y, :poids, :nbrdephoto, :prix_photo, :categorie,:idUser)');
        $q->bindValue(':id_photo', $id);
        $q->bindValue(':nom_photo', $photo->getnom_photo());
        $q->bindValue(':taille_pixels_x', $photo->gettaille_pixels_x());
        $q->bindValue(':taille_pixels_y', $photo->gettaille_pixels_y());
        $q->bindValue(':poids', $photo->getpoids());
        $q->bindValue(':nbrdephoto', $photo->getnbrdephoto());
        $q->bindValue(':prix_photo', $photo->getprixphoto());
        $q->bindValue(':categorie', $photo->getcategoriephoto());
        $q->bindValue(':idUser', $userId);
        
        $q->execute();
    
        $photo->hydrate(['Id' => $id]);
    }

    // afficher les photos de la base de données 
    public function showPhoto(): array
{
    $photos = array(); // Tableau pour stocker les données des photos

    $q = $this->_db->prepare('SELECT id_photo,nom_photo,categorie FROM photos');
    $q->execute();

    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $nomPhoto = $row['nom_photo'];
        $idPhoto = $row['id_photo'];
        $categorie = $row['categorie'];
        $photoData = array(
            'nom_photo' => $nomPhoto,
            'id_photo' => $idPhoto,
            'categorie' => $categorie,
            'chemin_photo' => "uploads/$nomPhoto"
        );
        $photos[] = $photoData; // Ajouter les données de la photo au tableau
    }

    return $photos; // Renvoyer le tableau de photos
}

    // afficher les photo de l'utilisateur
    public function showUserPhotos($userId ) {
        $photosInfo = [];
        $q = $this->_db->prepare('SELECT id_photo ,nom_photo, categorie FROM photos WHERE idUser = :userId');
        $q->bindValue(':userId', $userId, PDO::PARAM_INT);
        $q->execute();
        $photosInfo = $q->fetchAll(PDO::FETCH_ASSOC);
        return $photosInfo;
    }

    // supprimer les photos
    public function deletePhoto($userId, $photoId) {
        // Exécuter la requête de suppression dans la base de données
        $deleteQuery = $this->_db->prepare('DELETE FROM photos WHERE idUser = :userId AND id_photo = :photoId');
        $deleteQuery->execute(array('userId' => $userId, 'photoId' => $photoId));
        
        // Vérifier si la suppression a réussi en vérifiant le nombre de lignes affectées
        if ($deleteQuery->rowCount() > 0) {
            // La photo a été supprimée avec succès
            return true;
        } else {
            // La suppression a échoué
            return false;
        }
    }
    
    
    public function setDb(PDO $db){
        $this -> _db = $db;
    }
}

?>