<?php

include("../../includes/init.php");

if (!empty($_POST)) {
    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];

    $stmt = $bdd->prepare("
    INSERT INTO repas
        (nom, description, prix)
    VALUES
        (:nom, :description, :prix)
    ");

    $stmt->execute([
        ":nom" => $nom,
        ":description" => $description,
        ":prix" => $prix,
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

        <h2>Ajouter un item au menu</h2>
        <form action="ajouter.php" method="post">
            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom">

                    <p>Description</p>
                    <input type="text" name="description">

                    <p>Prix</p>
                    <input type="text" name="prix">
                    
                    <p><input type="submit" value="Ajouter" class="bouton"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>