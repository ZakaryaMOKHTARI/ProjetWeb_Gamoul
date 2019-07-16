<?php

require 'database.php';

if(!empty($_GET['id']))
{
    $id = checkInput($_GET['id']);
}

if(!empty($_POST))
{
    $pseudo                = checkInput($_POST['pseudo']);
    $email              = checkInput($_POST['email']);
    $password           = checkInput($_POST['password']);


        $db = Database::connect();
            $statement = $db->prepare("UPDATE membres set pseudo = ?, email = ?, password = ? WHERE id = ?");
            $statement->execute(array($pseudo, $email, $password, $id));
        Database::disconnect();
        header("Location: gestion_users.php");

}

        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM membres where id = ?");
        $statement->execute(array($id));
        $user = $statement->fetch();
        $pseudo = $user[1];
        $email = $user[2];
        $password = $user[3];
        Database::disconnect();


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
    <div class="row">
        <div class="col-sm-6">
            <h1><strong>Modifier un utilisateur</strong></h1>
            <br>
            <form class="form" action="<?php echo 'update_user.php?id='.$id;?>" role="form" method="post" >
                <div class="form-group">
                    <label for="nom">Pseudo :
                        <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $pseudo;?>">
                </div>
                <div class="form-group">
                    <label for="email">Email :
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">
                </div>
                <div class="form-group">
                    <label for="password">Mot de pass :
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mot de pass" value="<?php echo $password;?>">
                </div>
                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                    <a class="btn btn-primary" href="menu-admin.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
