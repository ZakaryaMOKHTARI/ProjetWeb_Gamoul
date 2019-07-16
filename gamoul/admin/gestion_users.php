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
        <h1><strong>Gestion des utilisateurs </strong><!--<a href="add_user.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>--></h1>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Mot de pass</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Require bloque tout si une erreur survient, contrairement à include.
            require 'database.php';
            // Exemple d'appel de la fonction static connect
            $db = Database::connect();
            $statement = $db->query('SELECT  * FROM membres');
            while($user = $statement->fetch())
            {
                echo '<tr>';
                echo '<td>'. $user['id'] . '</td>';
                echo '<td>'. $user['pseudo'] . '</td>';
                echo '<td>'. $user['email'] . '</td>';
                echo '<td> ---------- </td>';
                echo '<td width=300>';
                echo ' ';
                echo '<a class="btn btn-primary" href="update_user.php?id='.$user['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                echo ' ';
                echo '<a class="btn btn-danger" href="delete_user.php?id='.$user['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
