
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



<!DOCTYPE html>
<html>
<head>
    <title>www.PhotoforYou.com</title>
</head>
<body>
<style>
    /* Ajoutez le style pour la classe active */
    .btn.active {
    background-color: #007bff;
    color: #fff;
    }      
    
</style>
<?php 
    include_once('./include/menu_inclu.php');
?>
<div class="p-3 mb-2 bg-light text-dark">
     <h1>Inscription</h1>
     <p>Merci de remplir ce formulaire d'inscription</p>

     <small>Vous ferez bientôt parti de nos membres.Vous avez fait le bon choix ;-)</small>
</div>
   
    
        

    <form  method="post"  class="col-md-4 mb-3" novalidate>
        <div class="col-md-4 mb-3" >
            <div class="form-group row" >
                <label for="prenom">Prenom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" oninput="saisietexteprenom(this)" placeholder="Votre prenom"  required>
                <div class="valid-feedback">
                    Prénom Ok !
                </div>
                <div class="invalid-feedback">
                    Le champ prénom est obligatoire et doit faire entre 4 et 30 caractères
                </div>
            </div>
        </div >
        <div class="col-md-4 mb-3" >
            <div class="form-group row ">
                <label for="Nom">Nom</label>
                <input type="text"  class="form-control" name="nom" id="nom" oninput="saisietextenom(this)" aria-describedby="emailHelp" placeholder="Votre prénom"  required>
                <div class="valid-feedback">
                    Nom Ok !
                </div>
                <div class="invalid-feedback">
                    Le champ nom est obligatoire et doit faire entre 4 et 30 caractères
                </div>
            </div>
             </div>
        </div>
        <div class="col-md-4 mb-3" >   
            <div class="form-group row ">
                <label for="exampleInputEmail1">Adresse éléctronique</label>
                <input type="email" class="form-control" name="Email1" oninput="saisiemail(this)" aria-describedby="emailHelp" placeholder="Enter email" id="mail" required>
                <small id="emailHelp" class="form-text text-muted">Nous ne partegons votre mail.</small>
                <div class="valid-feedback">
                    Mail Ok !
                </div>
                <div class="invalid-feedback">
                    Le champ mail est obligatoire 
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3" >
            <div class="form-group row ">
                <label for="Password1">Votre mot de passe</label>
                <input type="password" class="form-control" oninput='this.setCustomValidity(this.value != Password2.value ? "Mot de passe non identique" : "")' onchange="aff_cach_input('client')" name="Password1" id="Password1" minlength="5" maxlength="30" required>
            </div>
            <p id="erreurMotDePasse"></p>
            <div class="form-group row">
                <label for="Password2">Confirmation du mot de passe</label>
                <input type="password" class="form-control" onchange="aff_cach_input('photographe')" name="Password2" id="Password2" oninput='Password2.setCustomValidity(Password2.value != Password1.value ? "Mot de passe non identique" : "")' class="form-control" minlength="5" maxlength="30" required>
            </div>
            
        </div>
        <div class="col-md-4 mb-3">
    <div class="btn-group" role="group" aria-label="Basic example">
        <input type="radio" class="btn-check" name="choixType" id="photographe" autocomplete="off" value="photographe" onchange="aff_cach_input('photographe')" checked>
        <label class="btn btn-info" for="photographe">Photographe</label>

        <input type="radio" class="btn-check" name="choixType" id="client" autocomplete="off" value="client" onchange="aff_cach_input('client')">
        <label class="btn btn-info" for="client">Client</label>
    </div>
</div>
<!-- Partie Photographe --->
<div id="blockPhotographe" class="col-md-4 mb-3">
    <p class="lead">Partie photographe</p>
    <div class="form">
        <label for="siteWeb">Site Web</label>
        <div class="form-group">
            <input type="url" class="form-control col-md-3" name="siteWeb" id="siteWeb" required oninput="validerSiteWeb()">
        </div>
        <label for="siret">Numéro de siret</label>
        <div class="form-group">
            <input type="text" class="form-control col-md-3" name="siret" id="siret" placeholder="Exemple : 12345678900013" pattern="[0-9]{14}"required oninput="validerSiret()">
        </div>
        <div class="invalid-feedback">
            Le numéro de SIRET est obligatoire et doit être présenté sous cette forme 12345678900013
        </div>
    </div>
</div>

<!--Partie Client -->
<div id="blockClient" class="col-md-4 mb-3">
    <p class="lead">Partie client</p>
    <div class="form">
        <label for="dateNaissance">Date de naissance</label>
        <input type="date" onchange="aff_cach_input('client')" class="form-control" name="dateNaissance" id="dateNaissance" required min="1933-01-01" max="2023-12-31">
        <div class="invalid-feedback">
            La date de naissance est obligatoire et doit être entre 1933 et 2023
        </div>
    </div>
</div>

<br>
<button type="submit" class="btn btn-primary">Envoyez</button>       
</form>
    <script>
        function saisietextenom(input) {
        var nomInput = input;
        var isValidFormat = /^[a-zA-Z]+$/.test(nomInput.value);
        var isValidLength = nomInput.value.length >= 4 && nomInput.value.length <= 30;

        nomInput.classList.toggle('is-valid', isValidFormat && isValidLength);
        nomInput.classList.toggle('is-invalid', !isValidFormat || !isValidLength);
    }

    function saisietexteprenom(input) {
        var prenomInput = input;
        var isValidFormat = /^[a-zA-Z]+$/.test(prenomInput.value);
        var isValidLength = prenomInput.value.length >= 4 && prenomInput.value.length <= 30;

        prenomInput.classList.toggle('is-valid', isValidFormat && isValidLength);
        prenomInput.classList.toggle('is-invalid', !isValidFormat || !isValidLength);
    }
        function saisiemail(input) {
        var mailInput = input;
        var isValidEmail = mailInput.value.includes("@");

        if (isValidEmail) {
            mailInput.classList.remove('is-invalid');
            mailInput.classList.add('is-valid');
        } else {
            mailInput.classList.remove('is-valid');
            mailInput.classList.add('is-invalid');
        }
    };
    document.getElementById('Password1').addEventListener('input', function () {
    var password1Input = this;
    var isValidPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(password1Input.value);

    password1Input.classList.toggle('is-valid', isValidPassword);
    password1Input.classList.toggle('is-invalid', !isValidPassword);

    // Appel à une fonction pour gérer la vérification de l'égalité
    checkPasswordsEquality();
});

document.getElementById('Password2').addEventListener('input', function () {
    var password2Input = this;
    checkPasswordsEquality();
});

function checkPasswordsEquality() {
    var password1Input = document.getElementById('Password1');
    var password2Input = document.getElementById('Password2');

    // Vérification d'égalité
    var passwordsMatch = (password1Input.value === password2Input.value);

    password1Input.classList.toggle('is-valid', passwordsMatch);
    password1Input.classList.toggle('is-invalid', !passwordsMatch);

    password2Input.classList.toggle('is-valid', passwordsMatch);
    password2Input.classList.toggle('is-invalid', !passwordsMatch);
}

// validation du formulaire en fonction des boutons photographe ou client 
function handleToggle(action) {
    var photographeBtn = document.getElementById('photographeBtn');
    var clientBtn = document.getElementById('clientBtn');

    // Ajouter/retirer la classe 'active' en fonction de l'appui sur le bouton
    if (action === 'photographe') {
        photographeBtn.classList.add('active');
        clientBtn.classList.remove('active');
        document.getElementById('choixTypeInput').value = 'photographe';
    } else if (action === 'client') {
        clientBtn.classList.add('active');
        photographeBtn.classList.remove('active');
        document.getElementById('choixTypeInput').value = 'client';
    }
}
// fonction rechargement affichage photographe (siret et siteweb)
document.addEventListener("DOMContentLoaded", function () {
        // Définissez la sélection par défaut sur 'Photographe'
        document.getElementById('photographe').checked = true;

        // Affiche 'blockPhotographe' et masque 'blockClient' lors du chargement de la page
        document.getElementById('blockPhotographe').style.visibility = "visible";
        document.getElementById('blockClient').style.visibility = "hidden";
    });
function aff_cach_input(action) {
    var blockPhotographe = document.getElementById('blockPhotographe');
    var blockClient = document.getElementById('blockClient');

    if (action == "photographe") {
        blockPhotographe.style.display = "block";
        blockPhotographe.style.visibility = "visible";
        blockClient.style.display = "none";
        blockClient.style.visibility = "hidden";
    } else if (action == "client") {
        blockClient.style.display = "block";
        blockClient.style.visibility = "visible";
        blockPhotographe.style.display = "none";
        blockPhotographe.style.visibility = "hidden";
    }
        
}


function validerSiret() {
            var siret = document.getElementById('siret');
            var siteWeb =document.getElementById('siteWeb');
            if (siret.value.length === 14 && /^\d+$/.test(siret.value)) {
                siret.classList.add('is-valid');
                siret.classList.remove('is-invalid');
            } else {
                siret.classList.add('is-invalid');
                siret.classList.remove('is-valid');
            }
        }
function validerSiteWeb(){
    if( siteWeb.value.includes("https://")){
        siteWeb.classList.remove('is-invalid');
        siteWeb.classList.add('is-valid');
    }else{
        siteWeb.classList.remove('is-valid')
        siteWeb.classList.add('is-invalid');
    }
}
function validerdateNaissance() {
    var dateNaissanceInput = document.getElementById('dateNaissance');
    var dateNaissance = dateNaissanceInput.value;

    // Vérifier si la date est dans la plage spécifiée
    if (dateNaissance >= '1933-01-01' && dateNaissance <= '2023-12-31') {
        dateNaissanceInput.classList.remove('is-invalid');
        dateNaissanceInput.classList.add('is-valid');
    } else {
        dateNaissanceInput.classList.remove('is-valid');
        dateNaissanceInput.classList.add('is-invalid');
    }
}
 // Ajoutez cet événement pour valider la date de naissance lors de la soumission du formulaire
 document.querySelector('form').addEventListener('submit', function(event) {
        validerdateNaissance();

        // Si la date de naissance est invalide, empêcher la soumission du formulaire
        if (!document.getElementById('datenaissance').classList.contains('is-valid')) {
            event.preventDefault();
        }
    });
    </script>
    <?php
//include('include/menu_inclu.php'); 

// vérifier les informations du formulaire saisie 

if (isset($_POST['prenom']) && isset($_POST['nom']) && 
    isset($_POST["Email1"]) && isset($_POST["Password1"])&&
    isset($_POST["Password2"]) && isset($_POST["choixType"])){
    // connection à la base de données 
    include_once("connexion_bd.php");
    // Ajoutez des var_dump pour déboguer
    //echo var_dump($_POST);
    include_once('classes/User.class.php');
    include_once('classes/UserManager.class.php');

    $manager = new UserManager($db);

    $emailExists = $manager->emailExists($_POST['Email1']);

    if ($emailExists) {
        echo "Cet e-mail est déjà associé à un compte. Veuillez choisir un autre e-mail.Ou vous connectez !";
    } else {
    
    $user = new User([
         'Nom' => $_POST['nom'],
         'Prenom' => $_POST['prenom'] ,
         'Type' => $_POST['choixType'], 
         'Mail' => $_POST['Email1'], 
         'Mdp' => $_POST['Password1']
        ]);
    //var_dump($user); // Vérifiez les valeurs de l'objet User avant d'appeler add()
    $manager->add($user);
    echo "<p>Bienvenue chez nous !<p>";
    }
} 


?>
   <?php  include('include/footer_inc.php');?>

    
</body>
</html>
 