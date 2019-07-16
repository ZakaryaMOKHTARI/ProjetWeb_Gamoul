<?php
require 'admin/database.php';
$db = Database::connect();
//$bdd = new PDO('mysql:host:localhost; dbname=gamoul', 'root', 'route');

if(isset($_POST['forminscription'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);
    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255) {
            if($mail == $mail2) {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $reqmail = $db->prepare("SELECT * FROM membres WHERE email = ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0) {
                        if($mdp == $mdp2) {
                            $insertmbr = $db->prepare("INSERT INTO membres(pseudo, email, password) VALUES(?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            $erreur = "Votre compte a bien été créé ! <a href=\"login.php\">Me connecter</a>";
                        } else {
                            $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                    } else {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                } else {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            } else {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        } else {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}

Database::disconnect();
?>




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
    <h2>Inscription</h2>
    <form method="POST" action="" style="width: 20%">
        <div class="form-group">
            <label for="pseudo">Pseudo :</label>
            <input type="text" class="form-control" id="pseudo"  name="pseudo" placeholder="Pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
        </div>
        <div class="form-group">
            <label for="mail">Mail :</label>
            <input type="email" class="form-control" id="mail" name="mail" placeholder="Email" value="<?php if(isset($mail)) { echo $mail; } ?>">
        </div>

        <div class="form-group">
            <label for="mail2">Confirmation du mail :</label>
            <input type="email" class="form-control" id="mail2" name="mail2" placeholder="Confirmation email" value="<?php if(isset($mail2)) { echo $mail2; } ?>">
        </div>

        <div class="form-group">
            <label for="mdp">Mot de pass :</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de pass">
        </div>

        <div class="form-group">
            <label for="mdp2">Confirmation du mot de pass :</label>
            <input type="password" class="form-control" id="mdp2" name="mdp2" placeholder="Confirmation mot de pass">
        </div>
        <button type="submit" name="forminscription" class="btn btn-primary">S'inscrire</button>
    </form>
    <?php
    if(isset($erreur)) {
        echo '<font color="red">'.$erreur."</font>";
    }
    ?>
</div>