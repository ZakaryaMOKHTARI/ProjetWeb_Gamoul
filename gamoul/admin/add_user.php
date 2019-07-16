<?php

require 'database.php';

/* Préparation pour vérifier si les champs sont tous remplis
Cette fonctionnalité n'a pas été mise en place, pour un gain de temps. */

$idError = $nomError = $prenomError = $emailError = $loginError = $passwordError = $depError = $villeError = $telError =
$id = $nom = $prenom = $email = $login = $password = $dep = $ville = $tel = "";

if(!empty($_POST))
{

    $pseudo                = checkInput($_POST['pseudo']);
    $email                 = checkInput($_POST['email']);
    $password              = checkInput($_POST['password']);


    // La varibale isSuccess sera utile dans le cas ou nous vérifierons si tous les champs sont bien remplis.
    $isSuccess = true;

    if($isSuccess)
    {

        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO membres (pseudo, email, password) 
                                              values(?, ?, ?)");
        $statement->execute(array($pseudo, $email, $password));
        Database::disconnect();
        header("Location: gestion_users.php");
    }
}

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gamoul.fr</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
<?php include '../header.php' ?>
<div class="container admin">
    <div class="container admin">
        <div class="row">
            <h1><strong>Ajouter un utilisateur</strong></h1>
            <br>
            <form class="form" action="add_user.php" role="form" method="post" >
                <div class="form-group">
                    <label for="pseudo">Pseudo :</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo" value="<?php echo $pseudo;?>">
                </div>
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
                </div>
                <div class="form-group">
                    <label for="password">Mot de pass :</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de pass" value="<?php echo $password;?>">
                </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                    <a class="btn btn-primary" href="menu-admin.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>