<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=messagerie', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}
