<?php
session_start();
include_once './connect.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

if (isset($nom) && !empty($nom) && isset($prenom) && !empty($prenom) && isset($email) && !empty($email) && isset($mdp) && !empty($mdp)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //On vérifie si l'email est valide
        // On vérifie si l'email existe dans la base de donnée
        $reVerifMail = $pdo->prepare("SELECT email FROM user WHERE email = :email");
        $reVerifMail->bindParam(':email', $email);
        $reVerifMail->execute();

        $donnees = $reVerifMail->fetch(PDO::FETCH_ASSOC);

        if ($donnees) { //Si l'email existe dans la base de donnée
            echo "$email existe déjà !";
        } else {
            //On vérifie ce que l'utilisateur envoie comme fichier
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name']; //On récupère le nom de l'image que l'utilisateur a upload
                $img_type = $_FILES['image']['type']; //On récupère le type de l'image que l'utilisateur a upload
                $tmp_name = $_FILES['image']['tmp_name']; //Ce nom temporaire est utilisé quand on sauvegarde l'image dans nos dossiers

                // On va récupérer l'extension de l'image
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode); //C'est ici qu'on récupère l'extension de l'image

                $extensions = ['png', 'jpeg', 'jpg'];  //les formats d'images les plus courantes
                if (in_array($img_ext, $extensions)) {  //Si l'utilisateur a envoyé une image dans un des formats
                    $time = time(); //ça va nous retourner le temps 
                    //on en a besoin pour renommer l'image par le moment où il envoie le formulaire
                    //comme ça toutes les images ou un nom unique

                    // On va déplacer l'image que l'utilisateur a envoyé dans un dossier fait pour ça
                    $new_img_name = $time . $img_name;  //On rajoute le temps devant le nom du fichier
                    if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) { //Si l'image a bien été envoyé dans le dossier
                        $status = "En ligne"; //Une fois l'utilisateur inscrit son statut le marquera comme connecté
                        $random_id = rand(time(), 10000000); // On crée un id random pour l'utilisateur

                        try {
                            $re = $pdo->prepare("INSERT INTO user (unique_id, prenom, nom, email, mdp, img, statut) VALUES (:unique_id, :prenom, :nom, :email, :mdp, :img, :statut)");
                            $re->bindParam(':unique_id', $random_id);
                            $re->bindParam(':prenom', $prenom);
                            $re->bindParam(':nom', $nom);
                            $re->bindParam(':email', $email);
                            $re->bindParam(':mdp', $mdp);
                            $re->bindParam(':img', $new_img_name);
                            $re->bindParam(':statut', $status);
                            $re->execute();
                        } catch (Exception $e) {
                            echo "<p>" . $e->getMessage() . "</p>";
                        }
                        $re2 = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                        $re2->bindParam(':email', $email);
                        $re2->execute();
                        $donneesUser = $re2->fetch(PDO::FETCH_ASSOC);

                        if ($donneesUser) {
                            $_SESSION['unique_id'] = $donneesUser['unique_id'];
                            echo "success";
                        }
                    }
                } else {
                    echo "Veuillez sélectionner une image dans un des formats suivants : jpeg, jpg, png !";
                }
            } else {
                echo "Veuillez sélectionner une image !";
            }
        }
    } else {
        echo "$email - Ce n'est pas une adresse mail valide !";
    }
} else {
    echo 'Tous les champs sont requis !';
}
