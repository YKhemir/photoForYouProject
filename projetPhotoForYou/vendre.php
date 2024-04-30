<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        include_once('./include/menu_inclu.php');
        
    ?>
    <h1 style="text-align:center">Vendre : du rève !</h1>
    
   
    <!-- Ajoutez une photo -->
    <div class="container d-flex justify-content-center">
    <form action="traitement_upload.php" method="post" enctype="multipart/form-data"  >
        <div class="container mt-3" >
            <div class="form-group">
                <label for="image">Sélectionnez une image :</label>
                <input type="file" name="image" id="image" accept="image/*" multiple="false">
            </div>
            <div class="form-group" >
                <label for="image">Nombre d'image :</label>
                <input  class="form-control mt-3" type="number" name="nbredephoto" value="1" readonly>
                <small class="form-text text-muted">Format d'image pris en charge : JPEG, PNG, GIF</small>
            </div>
            <div class="form-group" >
                <label for="image">Prix :</label>
                <input  id ="prixphoto" class="form-control mt-3" type="number" name="prixdelaphoto">
                <div class="valid-feedback">Le prix est en crédit</div>
                <div class="invalid-feedback">Le prix est en crédit est doit etre entre 2 et 100</div>
            </div>
            <div class="form-group" >
                <label for="image">Catégories :</label>
                <select class="form-select" id="categorie" name="categorie">
                    <option class="category" data-category="nature" value="paysage">Paysage</option>
                    <option class="category" data-category="nature" value="portrait">Portrait</option>
                    <option class="category" data-category="nature" value="animaux">Animaux</option>
                </select>
                <button  type="submit"  class="btn btn-primary mt-3" name="submit">Ajouter l'image</button>
            </div>
        </div>
    </form>
    </div>
    <?php 

    // Récupération du message depuis la session
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : "";

    // Affichage du message en dessous du formulaire
    if (!empty($message)) {
       
        echo '<div class="container d-flex justify-content-center mt-3">';
        echo '<div class="alert alert-primary" role="alert">' . $message . '</div>';
        echo '</div>';
    
        // Supprimez le message de la session
        unset($_SESSION['message']);
    }
    ?>
    <script>
    // Fonction pour valider le champ d'image
    function validerImage(input) {
        var imageSaisie = input;
        var validationTypeImage = /\.(jpeg|jpg|gif|png)$/i.test(imageSaisie.value);
        var invalidTypeImage = !validationTypeImage;

        imageSaisie.classList.toggle('is-valid', validationTypeImage);
        imageSaisie.classList.toggle('is-invalid', invalidTypeImage);
    }

    // Fonction pour valider le champ de prix
    function validerPrix(input) {
        var prixSaisie = input;
        var prixValue = parseInt(prixSaisie.value);
        var validationPrix = prixValue >= 2 && prixValue <= 100;
        var invalidationPrix = !validationPrix;

        prixSaisie.classList.toggle('is-valid', validationPrix);
        prixSaisie.classList.toggle('is-invalid', invalidationPrix);

        var prixFeedback = document.getElementById('prixFeedback');
        prixFeedback.textContent = validationPrix ? '' : 'Doit être entre 2 et 100';
    }

    // Fonction pour valider le champ de catégorie
    function validerCategorie(select) {
        var categorieSelect = select;
        var categorieValue = categorieSelect.value;
        var validationCategorie = categorieValue !== '';

        categorieSelect.classList.toggle('is-valid', validationCategorie);
        categorieSelect.classList.toggle('is-invalid', !validationCategorie);
    }

    // Récupérer les éléments du formulaire pour la validation
    var imageInput = document.getElementById('image');
    var prixInput = document.getElementById('prixphoto');
    var categorieSelect = document.getElementById('categorie');
    var form = document.querySelector('form');

    // Écouter les événements de modification des champs
    imageInput.addEventListener('change', function() {
        validerImage(imageInput);
    });

    prixInput.addEventListener('input', function() {
        validerPrix(prixInput);
    });

    categorieSelect.addEventListener('change', function() {
        validerCategorie(categorieSelect);
    });

    // Écouter l'événement de soumission du formulaire
    form.addEventListener('submit', function(event) {
        // Valider les champs avant de soumettre le formulaire
        validerImage(imageInput);
        validerPrix(prixInput);
        validerCategorie(categorieSelect);

        // Vérifier si les champs sont valides
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Ajouter la classe "was-validated" pour afficher les messages d'erreur Bootstrap
        form.classList.add('was-validated');
    });
    </script>