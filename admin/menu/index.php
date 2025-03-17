<?php

include("../../includes/init.php");

$categories = selectAll("categories", "*");

// À l'endroit où vous récupérez les repas
if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
    $categorie_id = $_GET['categorie'];
    $sql = "
    SELECT repas.*
    FROM repas
    INNER JOIN repas_categorie ON repas.id = repas_categorie.repas_id
    WHERE repas_categorie.categorie_id = :categorie_id
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':categorie_id' => $categorie_id]);
    var_dump($categorie_id);
    $repas = $stmt->fetchAll();
} else {
    // Récupérer tous les repas si aucune catégorie n'est sélectionnée
    $repas = selectAll("repas", "*", "nom");
}

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
        <div class="filtres">
            <h3>Filtrer par catégorie</h3>

            <a href="index.php" class="bouton <?= !isset($_GET['categorie']) ? 'actif' : '' ?>">Tout</a>

            <?php foreach ($categories as $categorie): ?>
                <a href="index.php?categorie=<?= $categorie['id'] ?>"
                    class="bouton <?= (isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id']) ? 'actif' : '' ?>">
                    <?= $categorie['id'] ?>
                </a>
            <?php endforeach; ?>
        </div>


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