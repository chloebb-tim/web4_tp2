<?php

include("../../includes/init.php");
$categories = selectAll("categories", "*");


if (!empty($_POST)) {
    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $categorie_id = $_POST["categorie_id"];

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
    
    // Get the ID of the newly inserted repas
    $repas_id = $bdd->lastInsertId();

    $sql = "
    INSERT INTO repas_categorie
        (categorie_id, repas_id)
     VALUES
        (:categorie_id, :repas_id)
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":repas_id" => $repas_id,
        ":categorie_id" => $categorie_id
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

                    <p>Catégorie</p>
                    <select name="categorie_id">
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie["id"] ?>">
                                <?= $categorie["nom"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>

                    <p><input type="submit" value="Ajouter" class="bouton"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>