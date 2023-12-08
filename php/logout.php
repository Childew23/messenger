<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once './connect.php';
    
    // Vérifier si user_id est défini dans l'URL
    if (isset($_GET['user_id'])) {
        $statut = 'Hors-ligne';
        $re = $pdo->prepare("UPDATE user SET statut = :statut WHERE unique_id = :id");
        $re->bindParam(':statut', $statut);
        $re->bindParam(':id', $_GET['user_id']);
        $result = $re->execute();

        if ($result) {
            session_unset();
            session_destroy();
            header("location: /login.php");
        } else {
            header("location: /users.php");
        }
    } else {
        // Redirection si user_id n'est pas défini dans l'URL
        header("location: /users.php");
    }
} else {
    header("location: /login.php");
}
