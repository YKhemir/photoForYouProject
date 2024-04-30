
<?php
    require_once("include/menu_inclu.php");

    if(isset($_POST["submit"])) { // Vérifie si le formulaire a été soumis
        if(isset($_FILES["image"])) {
            // Connexion à la base de données
            include_once("connexion_bd.php");
            
            require_once("classes/Photo.class.php");
            require_once("classes/PhotoManager.class.php");

            // Vérification de l'image
            $image = $_FILES["image"];
            if($image['error'] === 0) { // Vérifie si aucun fichier n'a d'erreur lors du téléchargement
                // Obtention des informations sur la taille de l'image
                $tailleImage = getimagesize($image['tmp_name']);

                $maxTailleFichier = 30 * 1024 * 1024; // 30 Mo en octets
                if($image['size'] <= $maxTailleFichier){
                    // Vérifie la présence du champ 'nbredephoto' dans le formulaire
                    if(isset($_POST['nbredephoto'])) {
                        if(isset($_POST['prixdelaphoto'])){
                            if($_POST['prixdelaphoto'] >=2 && $_POST['prixdelaphoto']<=100){
                                if(isset($_POST['categorie'])){
                                    // Création d'un gestionnaire de photos
                                    $managerphoto = new PhotoManager($db);

                                    // Création d'un objet Photo avec les informations nécessaires
                                    $photo = new Photo([
                                        'nom_photo' => $image['name'],
                                        'taille_pixels_x' => $tailleImage[0], // Largeur de l'image
                                        'taille_pixels_y' => $tailleImage[1], // Hauteur de l'image
                                        'poids' => $image['size'], // Taille du fichier
                                        'nbrdephoto' => $_POST['nbredephoto'],
                                        'prixphoto' => $_POST['prixdelaphoto'],
                                        'categoriephoto' => $_POST['categorie']
                                    ]);
                            

                                    // Génération d'un nom de fichier unique
                                    $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                                    $uniqueNomPhoto = uniqid() . '.' . $extension;
                                    
                                    // Obtenir le nom d'origine sans l'extension
                                    $nomOrigineSansExtension = pathinfo($_FILES["image"]["name"], PATHINFO_FILENAME);
                                
                                    $nouvelIdentifiant = $nomOrigineSansExtension . '_' . $uniqueNomPhoto;
                                    $targetFile = 'uploads/' . $nouvelIdentifiant;
                                    
                                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                                        // Enregistrement de l'identifiant unique et du nom d'origine combinés dans la base de données
                                        $photo->setnom_photo($nouvelIdentifiant);
                                        $managerphoto->addPhotos($photo);
                                        
                                        $_SESSION['message'] = "Ajouté avec succès !";
                                       
                                    }
                                }
                            } else {
                                $_SESSION['message']  = "Erreur: Champ 'prix' doit etre entre 2 et 100 crédit.";
                            }
                        }
                    } else {
                        $_SESSION['message']  = "Erreur: Champ 'nbredephoto' manquant dans le formulaire.";
                    }
                } else {
                    $_SESSION['message']  = "La taille du fichier dépasse la limite autorisée.";
                }
            } else {
                $_SESSION['message']  = "Erreur il y a pas d'image.";
            }
        }
    }

    // redirection vers vendre
    header("Location: vendre.php");
    exit();
?>
