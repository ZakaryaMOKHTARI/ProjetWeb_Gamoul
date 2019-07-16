<?php
session_start();
require 'admin/database.php';
$db = Database::connect();

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $db->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
    ?>
 <html>
    <head>
        <title>Se connecter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/header.css">

    </head>

    <div class="header mb-50">
        <span class="logo"><a href="index.php"><img src="images/logo_gamoul.png" width="280"></a></span>
        <input type="checkbox" id="chk">
        <label for="chk" class="show-menu-btn">
            <i class="fas fa-ellipsis-h">+</i>
        </label>

        <ul class="menu">
            <a href="index.php">Accueil</a>
            <a href="register.php">Inscription</a>
            <a href="login.php">Connexion</a>
            <a href="login.php">Espace Admin</a>
            <label for="chk" class="hide-menu-btn">
                <i class="fas fa-times">x</i>
            </label>
        </ul>
    </div>
    <body>
    <div align="center">
        <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
        <br /><br />
        Pseudo = <?php echo $userinfo['pseudo']; ?>
        <br />
        Mail = <?php echo $userinfo['email']; ?>
        <br />
        <?php
        if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
            <br />
            <a href="editionprofil.php" class="btn btn-primary">Editer mon profil</a>
            <a href="signout.php" class="btn btn-danger">Se déconnecter</a>
            <?php
        }
        ?>
    </div>
    </body>
 </html>
    <?php
}
?>