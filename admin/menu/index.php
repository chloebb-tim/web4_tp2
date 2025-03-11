<?php

include("../../includes/init.php");

if (isset($_GET["supprimer"])) {
    $stmt = $bdd->prepare("
        DELETE FROM repas
        WHERE id = :id
    ");
    $stmt->execute([
        ":id" => $_GET["supprimer"],
    ]);

    header("location: index.php");
}

$repas = selectAll("repas", "*", "nom COLLATE NOCASE ASC");
$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zone Admin</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include "../../composants/header.php" ?>
    <h1>Gestion du menu</h1>
    <div class="menu">
        <a class="bouton" href="ajouter.php">Ajouter un item au menu</a>
        <?php foreach ($repas as $un_repas): ?>
            <div class="un-repas">
                <div>
                    <p> <?= $un_repas["nom"] ?></p>
                    <p> <?= $un_repas["description"] ?></p>
                    <p> <?= $un_repas["prix"] ?>$</p>
                </div>
                <div class="admin">
                    <a href="modifier.php?id=<?= $un_repas["id"] ?>">Modifier</a>
                    <a href="index.php?supprimer=<?= $un_repas["id"] ?>">Supprimer</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>