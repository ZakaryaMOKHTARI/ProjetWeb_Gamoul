<?php
session_start();
require 'admin/database.php';
$db = Database::connect();

if(isset($_POST['formconnexion'])) {
    $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
        $requser = $db->prepare("SELECT * FROM membres WHERE pseudo = ? AND password = ?");
        $requser->execute(array($pseudoconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];

            if($pseudoconnect == 'admin'){
                header("Location: admin/menu-admin.php");
            }else{
                header("Location: profil.php?id=".$_SESSION['id']);
            }

        } else {
            $erreur = "Pseudo ou mot de pass incorrect";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés";
    }

}
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
</head>
<body>
<div align="center">
    <h2>Connexion</h2>
    <br /><br />
    <form method="POST" action="">
        <div class="form-group" style="width: 20%;">
            <input type="text" name="pseudoconnect" placeholder="Pseudo" class="form-control"/>
            <input type="password" name="mdpconnect" placeholder="Mot de passe" class="form-control"/>
        </div>

        <br /><br />
        <input type="submit" name="formconnexion" value="Se connecter !" class="btn btn-primary"/>
    </form>
    <?php
    if(isset($erreur)) {
        echo '<font color="red">'.$erreur."</font>";
    }
    ?>
</div>
</body>
</html>