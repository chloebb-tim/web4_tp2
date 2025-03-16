<?php

include("../../includes/init.php");

if (!empty($_POST)) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $courriel = $_POST["courriel"];

    $stmt = $bdd->prepare("
    INSERT INTO utilisateurs
        (nom, prenom, courriel)
    VALUES
        (:nom, :prenom, :courriel)
    ");

    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":courriel" => $courriel,
    ]);

    header("location: index.php");
}

$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un item</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include "../../composants/header.php" ?>

    <h1>Zone administrative</h1>
    <div class="menu">
        <a href="index.php" class="bouton">Retour</a>

        <h2>Ajouter un employé</h2>
        <form action="ajouter.php" method="post">
            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom">

                    <p>Prénom</p>
                    <input type="text" name="prenom">

                    <p>Courriel</p>
                    <input type="text" name="courriel">
                    
                    <p><input type="submit" value="Ajouter" class="bouton"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>