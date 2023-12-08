<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
}
?>

<?php include_once './header.php' ?>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <?php
                    include_once "./php/connect.php";
                    $re = $pdo->prepare("SELECT * FROM user WHERE unique_id = :id");
                    $re->bindParam(":id", $_GET['userId']);
                    $re->execute();
                    $user = $re->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="./php/images/<?php echo $user['img']?>" alt="<?php echo "Photo de profil de $user[prenom] $user[nom]" ?>">
                <div class="details">
                    <span><?php echo "$user[prenom] $user[nom]" ?></span>
                    <p><?php echo "$user[statut]" ?></p>
                </div>
            </header>
            <div class="chat-box">
                
            </div>
            <form action="#" class="typing-area">
                <input type="hidden" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>">
                <input type="hidden" name="incoming_id" value="<?php echo $_GET['userId']; ?>">
                <input type="text" name="message" class="input-field" placeholder="Envoyer un message..." autocomplete="off">
                <button><i class="fa-brands fa-telegram"></i></button>
            </form>
        </section>
    </div>

    <script src="./js/chat.js"></script>
</body>

</html>