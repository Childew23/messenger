<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    header("location: users.php");
}
?>

<?php include_once './header.php' ?>

<body>
    <div class="wrapper">
        <section class="form inscription">
            <header>Messagerie</header>
            <form action="#" enctype="multipart/form-data">
                <div class="error-txt"></div>
                <div class="name-details">
                    <div class="field input">
                        <label for="">Nom</label>
                        <input type="text" name="nom" placeholder="Nom de famille" required>
                    </div>
                    <div class="field input">
                        <label for="">Prénom</label>
                        <input type="text" name="prenom" placeholder="Prénom" required>
                    </div>
                </div>
                <div class="field input">
                    <label for="">Adresse email</label>
                    <input type="email" name="email" placeholder="Votre adresse email" required>
                </div>
                <div class="field input">
                    <label for="">Mot de passe</label>
                    <input type="password" name="mdp" placeholder="Votre mot de passe" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field image">
                    <label for="">Sélectionnez votre photo de profil</label>
                    <input type="file" name="image" required>
                </div>
                <div class="field button">
                    <input type="submit" value="Inscrivez vous !">
                </div>
            </form>
            <div class="link">Déjà inscrit ? <a href="login.php">Connectez-vous</a></div>
        </section>
    </div>

    <script src="./js/pass-show-hide.js"></script>
    <script src="./js/signup.js"></script>
</body>

</html>