<?php
session_start();
include_once './connect.php';

$sortie = "";
$re = $pdo->prepare("SELECT * FROM user WHERE NOT unique_id = :id");
$re->bindParam(':id', $_SESSION['unique_id']);
$re->execute();

$donnee = $re->fetchAll(PDO::FETCH_ASSOC);

if (count($donnee) == 0) {
    $sortie .= "Aucun utilisateur";
} elseif (count($donnee) > 0) {
    foreach ($donnee as $user) {
        $re2 = $pdo->prepare("SELECT * FROM message WHERE (incoming_msg_id = :inID OR outgoing_msg_id = :inID) AND (outgoing_msg_id = :outID OR incoming_msg_id = :outID) ORDER BY id DESC LIMIT 1");
        $re2->bindParam(':inID', $user['unique_id']);
        $re2->bindParam(':outID', $_SESSION['unique_id']);
        $re2->execute();
        $result = $re2->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Déchiffrement du message si un message existe
            $decryptedMessage = openssl_decrypt($result['msg'], 'aes-256-cbc', $result['cle']);

            $lastMsg = (!empty($decryptedMessage)) ? $decryptedMessage : "Aucun message";
        } else {
            $lastMsg = "Aucun message";
        }

        // Si le message est long, le découper à l'affichage des utilisateurs
        $msg = (strlen($lastMsg) > 28) ? substr($lastMsg, 0, 28) . '...' : $lastMsg;

        // Si l'utilisateur est hors ligne, ajouter la classe CSS "offline"
        $offline = ($user['statut'] == 'Hors-ligne') ? "offline" : "";

        // Échapper les données avant de les afficher dans le HTML
        $sortie .= '
            <a href="chat.php?userId=' . $user['unique_id'] . '">
                <div class="content">
                    <img src="./php/images/' . htmlentities($user['img']) . '" alt="Photo de profil des autres utilisateurs">
                    <div class="details">
                        <span>' . htmlentities($user['prenom']) . ' ' . htmlentities($user['nom']) . '</span>
                        <p>' . htmlentities($msg) . '</p>
                    </div>
                </div>
                <div class="status-dot ' . htmlentities($offline) . '">
                    <i class="fas fa-circle"></i>
                </div>
            </a>';
    }
    echo $sortie;
}
?>
