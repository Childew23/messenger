<?php include_once './header.php' ?>
<body>
    <div class="wrapper">
        <section class="form connexion">
            <header>Messagerie</header>
            <form action="#" autocomplete="off">
                <div class="error-txt"></div>
                <div class="field input">
                    <label for="">Adresse email</label>
                    <input type="email" name="email" placeholder="Votre adresse email">
                </div>
                <div class="field input">
                    <label for="">Mot de passe</label>
                    <input type="password" name="mdp" placeholder="Votre mot de passe">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Connexion">
                </div>
            </form>
            <div class="link">Pas encore inscrit ? <a href="index.php">Inscrivez-vous</a></div>
        </section>
    </div>
    <script src="./js/pass-show-hide.js"></script>
    <script src="./js/login.js"></script>
</body>

</html>