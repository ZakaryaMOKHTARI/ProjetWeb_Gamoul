<?php
session_start();
require 'admin/database.php';
$db = Database::connect();

if(isset($_SESSION['id'])) {
    $requser = $db->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $db->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $db->prepare("UPDATE membres SET email = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }
    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);
        if($mdp1 == $mdp2) {
            $insertmdp = $db->prepare("UPDATE membres SET password = ? WHERE id = ?");
            $insertmdp->execute(array($mdp1, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        } else {
            $msg = "Vos deux mdp ne correspondent pas !";
        }
    }
    ?>
    <html>
    <head>
        <title>Gamoul.fr</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/header.css">

    </head>
    <body>
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

    <div align="center">
        <h2>Edition de mon profil</h2>
        <div align="center">
            <form method="POST" action="" enctype="multipart/form-data" style="width: 20%">
                <label>Pseudo :</label><br>
                <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" class="form-control"/><br /><br />
                <label>Mail :</label><br>
                <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['email']; ?>" class="form-control"/><br /><br />
                <label>Mot de passe :</label><br>
                <input type="password" name="newmdp1" placeholder="Mot de passe" class="form-control"/><br /><br />
                <label>Confirmation - mot de passe :</label><br>
                <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" class="form-control"/><br /><br />
                <input type="submit" value="Mettre à jour" class="btn btn-success" />
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
        </div>
    </div>
    </body>
    </html>
    <?php
}
else {
    header("Location: connexion.php");
}
?>