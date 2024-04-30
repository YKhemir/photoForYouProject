<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos</title>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .card {
            width: calc(20% - 20px); /* Calcule la largeur pour afficher 5 cartes par ligne */
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            width: 100%;
            height: auto;
        }

        .card-title {
            margin-top: 10px;
        }

        .card-body {
            padding: 10px 0;
        }

        .card-body a {
            display: block;
            text-align: center;
        }

        /* Style personnalisé pour le bouton */
        .custom-button {
            display: block;
            margin: 0 auto;
            text-align: center;
            background-color: orange;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style personnalisé pour les flèches de pagination */
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination .arrow {
            font-size: 20px;
            font-weight: bold;
            display: inline-block;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
            margin: 0 5px;
        }

        .pagination .page-number {
            display: inline-block;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
            margin: 0 5px;
        }

        .pagination .current-page {
            background-color: #f2f2f2;
        }

        
    .delete-icon {
        position: relative;
        display: inline-block;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .delete-icon:before,
    .delete-icon:after {
        content: '';
        position: absolute;
        top: 9px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #000;
    }

    .delete-icon:before {
        transform: rotate(45deg);
    }

    .delete-icon:after {
        transform: rotate(-45deg);
    }
</style>


    
</head>
<body>
    <?php 
        include_once("connexion_bd.php");
        include_once ("./include/menu_inclu.php");
        include_once ("./classes/Photo.class.php");
        include_once ("./classes/PhotoManager.class.php");

        $photoManager = new PhotoManager($db);
        if(isset($_SESSION['user_id'])){
            $userId = $_SESSION['user_id'];
        }
        if($userType === "client"){
            $photos = $photoManager->showPhoto();    
        } else {
            $photos = $photoManager->showUserPhotos($userId);
        }
        
       
        // Pagination
        $perPage = 25;
        $totalPhotos = count($photos);
        $totalPages = ceil($totalPhotos / $perPage);

        if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
            $currentPage = 1;
        } else {
            $currentPage = intval($_GET['page']);
            if ($currentPage < 1) {
                $currentPage = 1;
            } elseif ($currentPage > $totalPages) {
                $currentPage = $totalPages;
            }
        }

        $startIndex = ($currentPage - 1) * $perPage;
        $photos = array_slice($photos, $startIndex, $perPage);

        // Affichage des cartes
        echo '<div class="card-container">';
        foreach ($photos as $photo):
    ?>
           <div class="card" id="photo-<?php echo $photo['id_photo'] ?>">
                <?php
                $photoPath = 'uploads/' . $photo['nom_photo'];
                $nomOrigineSansExtension = explode("_", $photo['nom_photo'])[0];
                ?>
                <img src="<?php echo $photoPath; ?>" class="card-img-top" alt="<?php echo $photo['nom_photo'];?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $nomOrigineSansExtension; ?></h5>
                    <h6 class="category"><?php echo $photo['categorie']; ?></h6>
                    <button class="custom-button" onclick="window.open('<?php echo $photoPath; ?>', '_blank')">Voir la photo</button>
                    <?php 
                        if (($userId !== null) && ($_SESSION['user_type'] != null)) {
                            $userType = $_SESSION['user_type'];
                            // Maintenant, vous pouvez chercher Habilisation dans la table menu
                            if ($userType === "client") {
                                echo '<button class="custom-button">Acheter</button>';
                            } elseif ($userType === "photographe") {
                                $photoNom = "'".$photo['nom_photo']."'";
                                echo '<div class="delete-icon" onclick="deletePhoto('.$photo['id_photo'].','.$userId.','.$photoNom.')"></div>';
                            }
                        }
                    ?>
                    
                </div>
            </div>
    <?php
        endforeach;
        echo '</div>';

        // Affichage de la pagination
        echo '<div class="pagination">';
        if ($currentPage > 1) {
            echo '<a href="?page=' . ($currentPage - 1) . '" class="arrow">&lt;</a>';
        }

        echo '<div style="display: flex; justify-content: center;">'; // Nouvelle ligne de code pour centrer la pagination au milieu
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo '<span class="page-number current-page">' . $i . '</span>';
            } else {
                echo '<a href="?page=' . $i . '" class="page-number">' . $i . '</a>';
            }
        }
        echo '</div>'; // Fin de la ligne de code pour centrer la pagination au milieu

        if ($currentPage < $totalPages) {
            echo '<a href="?page=' . ($currentPage + 1) . '" class="arrow">&gt;</a>';
        }
        echo '</div>';
    ?>
    <script>
        function deletePhoto(photoId,userId,nomPhoto){
            let data = new FormData();
        data.append('user_id', userId);
        data.append('photo_id', photoId);
        data.append('nom_photo', nomPhoto);

        const url = "/AT/projetPhotoForYou/deletePhoto.php";
        let xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onload = function () {
            if (xhr.status === 201) {
                console.log("Photo successfully deleted!");
                document.getElementById('photo-'+photoId).remove();
            } else {
                console.error("Error:", xhr.responseText);
            }
        };

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(new URLSearchParams(data));

        }

        function searchCategories(event) {
            console.log("appelle de ok");
  event.preventDefault(); // Empêche le rechargement de la page

  const searchTerm = document.getElementById('search-input').value.toLowerCase();
  const categoryElements = document.getElementsByClassName('category');

  // Parcourir les catégories et afficher/masquer en fonction du terme de recherche
  for (const category of categoryElements) {
    console.log(category.textContent);
    const categoryName = category.textContent.toLowerCase();
    if (categoryName.includes(searchTerm)) {
      category.parentNode.parentNode.style.display = 'block'; // Afficher la catégorie
    } else {
      category.parentNode.parentNode.style.display = 'none'; // Masquer la catégorie
    }
  }
}

  function searchCategoriesLive(e) {
    console.log("onchange cllaed");
    const input = document.querySelector("input");
    const log = document.getElementById("search-input");
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    log.textContent = e.target.value;
    if(e.length > 3){
        const categoryElements = document.getElementsByClassName('category');

    // Parcourir les catégories et afficher/masquer en fonction du terme de recherche
    for (const category of categoryElements) {
    console.log(category.textContent);
    const categoryName = category.textContent.toLowerCase();
    if (categoryName.includes(searchTerm)) {
        category.parentNode.parentNode.style.display = 'block'; // Afficher la catégorie
    } else {
        category.parentNode.parentNode.style.display = 'none'; // Masquer la catégorie
    }
    }
    
    }
    }

    function debounce(callback, wait) {
  let timeout;
  return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(function () { callback.apply(this, args); }, wait);
  };
}

window.addEventListener('keyup', debounce( () => {
    // code you would like to run 1000ms after the keyup event has stopped firing
    // further keyup events reset the timer, as expected
}, 1000))

    </script>
    

</body>
</html>