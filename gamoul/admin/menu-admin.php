<?php
session_start();
require 'database.php';
$db = Database::connect();

/* if(!$_SESSION['admin']){
    header('location:../login.php');
}*/

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
    <a href="index.php"><h4>Gestion du stock</h4></a>
    <a href="gestion_users.php"><h4>Gestion des utilisateurs</h4></a>
</div>
</body>
</html>
