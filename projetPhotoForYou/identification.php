<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<!DOCTYPE html>
<html>
<head>
    <title>inscription</title>
</head>
<body>
<?php 
    include('include/menu_inclu.php');
?>
<div class="p-3 mb-2 bg-light text-dark">
     <h1>Identification</h1>
     
</div>
<?php 

include('classes/User.class.php');

// Connexion à la base de données 
include_once("connexion_bd.php");

$manager = new UserManager($db);

// pour la connexion du utilisateurs 
if (isset($_POST['valider'])){
    $mailInscrit = $_POST['mailInscrit'];
    $password1 = md5($_POST['Password1']);

    if($utilisateur = $manager->getUser($mailInscrit)){

        // Utilisation de MD5 pour vérifier le mot de passe
        if($password1 === $utilisateur->getMdp()){
            session_start ();
            $_SESSION['login'] = true;
            $_SESSION['NomUtilisateur'] = $utilisateur->getPrenom();
            $_SESSION['user_id'] = $utilisateur->getId();
            $_SESSION['user_type'] = $utilisateur->getType();
            header('Location: membres.php');
        } else {
            header('Location: index.php');
            echo "<p>Mot de passe incorrect</p>";
        }
    } else {
        header('Location: index.php');
        echo "<p>L'utilisateur n'existe pas</p>";
    }
}
?>

<!-- le formulaire de connexion -->
<form class="p-3 mb-2" method="post" novalidate>
    <div class="col-md-4 mb-3">
        <div class="form-group row">
            <label for="exampleInputEmail1">Adresse électronique</label>
            <input type="email" name="mailInscrit" class="form-control"  <?php echo (isset($_POST['valider']) && !$manager->getUser($mailInscrit) && !empty($mailInscrit)) ? 'is-invalid' : 'is-valid'; ?> id="Email1" oninput="saisiemail(this)" aria-describedby="emailHelp" placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">Nous ne partageons pas votre mail.</small>
            <div class="invalid-feedback">
                <?php 
                if (isset($_POST['valider']) && !$manager->getUser($mailInscrit) && !empty($mailInscrit)){
                    echo "L'utilisateur avec cette adresse e-mail n'existe pas";
                } 
                ?>
            </div>
        </div>           
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group row">
            <label for="exampleInputPassword1">Votre mot de passe</label>
            <input type="password" name="Password1" class="form-control" id="Password1" oninput='motdepasse1.setCustomValidity(motdepasse2.value != motdepasse1.value ? "Mot de passe non identique" : "")' minlength="5" maxlength="30" required>
        </div>
    </div>
       
    <button type="submit" class="btn btn-primary" name="valider">Envoyez</button>
</form>




<script>
    document.getElementById('Email1').addEventListener('input', function () {
        var mailInput = this;
        var isValidEmail = mailInput.value.includes("@");

        if (isValidEmail) {
            mailInput.classList.remove('is-invalid');
            mailInput.classList.add('is-valid');
        } else {
            mailInput.classList.remove('is-valid');
            mailInput.classList.add('is-invalid');
        }
    });

    document.getElementById('Password1').addEventListener('input', function () {
        var password1Input = this;
        var isValidPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/.test(password1Input.value);

        password1Input.setCustomValidity(isValidPassword ? '' : 'Mot de passe non valide');

        password1Input.classList.toggle('is-valid', isValidPassword);
        password1Input.classList.toggle('is-invalid', !isValidPassword);
    });
</script>


