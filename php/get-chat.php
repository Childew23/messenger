<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once './connect.php';
    $outgoing_id = $_POST['outgoing_id'];
    $incoming_id = $_POST['incoming_id'];

    $output = '';
    $re = $pdo->prepare('SELECT * FROM message
        LEFT JOIN user ON user.unique_id = :inId
        WHERE incoming_msg_id = :inId AND outgoing_msg_id = :outId 
        OR incoming_msg_id = :outId AND outgoing_msg_id = :inId');
    $re->bindParam(':outId', $outgoing_id);
    $re->bindParam(':inId', $incoming_id);
    $re->execute();
    $resultat = $re->fetchAll();
    
    for ($i = 0; $i < count($resultat); $i++) {
        $msg = $resultat[$i];

        // Déchiffrement du message
        $decryptedMessage = openssl_decrypt($msg['msg'], 'aes-256-cbc', $msg['cle']);
        if ($msg['outgoing_msg_id'] == $outgoing_id) {
            // Message sortant (envoyé par l'utilisateur actuel)
            $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>' . $decryptedMessage . '</p>
                            </div>
                        </div>';
        } else {
            // Message entrant (reçu de l'autre utilisateur)
            $output .= '<div class="chat incoming">
                            <img src="./php/images/'.$msg['img'].'" alt="">
                            <div class="details">
                                <p>' . $decryptedMessage . '</p>
                            </div>
                        </div>';
        }
    }
    echo $output;
} else {
    header('location: /login.php');
}
?>
