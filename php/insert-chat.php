User
<?php
    session_start();
    if (isset($_SESSION['unique_id'])) {
        include_once './connect.php';
        $outgoing_id = $_POST['outgoing_id'];
        $incoming_id = $_POST['incoming_id'];

        function generateEncryptionKey() {
            // Génération d'une clé aléatoire de 32 octets (256 bits)
            $encryptionKey = bin2hex(random_bytes(32));
            return $encryptionKey;
        }
        
        // Exemple d'utilisation de la fonction
        $key = generateEncryptionKey();
        $message = trim($_POST['message']);

        $encrypted_text = openssl_encrypt($message, 'aes-256-cbc', $key);

        if (!empty($message)) {
            try {
                $re = $pdo->prepare("INSERT INTO message (incoming_msg_id,outgoing_msg_id,msg, cle) VALUES (:incoming, :outgoing, :msg, :cle)");
                $re->bindParam(':incoming', $incoming_id);
                $re->bindParam(':outgoing', $outgoing_id);
                $re->bindParam(':msg', $encrypted_text);
                $re->bindParam(':cle', $key);
                $re->execute();
            } catch (Exception $e) {
                echo "Echec de l'envoi du message";
                die();
            }
        }
    }else{
        header('location: /login.php');
    }