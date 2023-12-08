<?php
session_start();
include_once './connect.php';

$email = $_POST['email'];
$mdp = $_POST['mdp'];

if (isset($email) && !empty($email) && isset($mdp) && !empty($mdp)) {
    // On vérifie si l'utilisateur existe dans la base de données
    $re = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $re->bindParam(':email', $email);
    $re->execute();
    $user = $re->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp, $user['mdp'])) { // Si l'utilisateur existe
        $statut = 'En ligne';
        $re2 = $pdo->prepare("UPDATE user SET statut = :statut WHERE unique_id = :id");
        $re2->bindParam(':statut', $statut);
        $re2->bindParam(':id', $user['unique_id']);
        $result = $re2->execute();

        if ($result) {
            $_SESSION['unique_id'] = $user['unique_id'];
            echo "success";
        } else {
            echo "Les informations que vous avez saisies sont incorrectes !";
        }
    } else {
        echo "Les informations que vous avez saisies sont incorrectes !";
    }
} else {
    echo "Tous les champs sont requis !";
}
