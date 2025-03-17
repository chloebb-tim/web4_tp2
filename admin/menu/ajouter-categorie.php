<?php

include("../../includes/init.php");

if (!empty($_POST)) {
    $nom = $_POST["nom"];

    $stmt = $bdd->prepare("
    INSERT INTO categories
        (nom)
    VALUES
        (:nom)
    ");

    $stmt->execute([
        ":nom" => $nom,
    ]);

    header("location: modifier-categories.php");
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

        <h2>Ajouter une catégorie</h2>
        <form action="ajouter-categorie.php" method="post">
            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom">
                    <p><input type="submit" value="Ajouter" class="bouton"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>