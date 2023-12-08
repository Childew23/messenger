<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php"); //On redirige l'utilisateur si il n'est pas connecté
    }
?>

<?php include_once './header.php' ?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                    include_once "./php/connect.php";
                    $re = $pdo->prepare("SELECT * FROM user WHERE unique_id = :id");
                    $re->bindParam(":id", $_SESSION['unique_id']);
                    $re->execute();
                    $user = $re->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="content">
                    <img src="./php/images/<?php echo $user['img']?>" alt="Photo de profil de l'utilisateur">
                    <div class="details">
                        <span><?php echo "$user[prenom] $user[nom]" ?></span>
                        <p><?php echo $user['statut'] ?></p>
                    </div>
                </div>
                <a href="php/logout.php?user_id=<?php echo $user['unique_id'] ?>" class="logout">Déconnexion</a>
            </header>
            <div class="search">
                <span class="text">Rechercher/lancer une conversation</span>
                <input type="text" placeholder="Rechercher">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">

            </div>
        </section>
    </div>

    <script src="./js/users.js"></script>
</body>

</html>