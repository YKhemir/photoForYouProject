<?php  
// connexion base de données
try {
    $db = new PDO('mysql:host=127.0.0.1:3306;dbname=photoforyou2', 'root', '');
} catch (PDOException $e) {
    echo "Erreur " . $e->getMessage();
    die();
} 
?>