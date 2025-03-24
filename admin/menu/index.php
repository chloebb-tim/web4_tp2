<?php

include("../../includes/init.php");

$nb_items = selectCount("repas");
$nb_items_par_page = 7;
$nb_page_total = ceil($nb_items / $nb_items_par_page);

// première page : 1
$page = $_GET["page"] ?? 1;

$categories = selectAll("categories", "*");

// À l'endroit où vous récupérez les repas
if (isset($_GET['categorie']) && !empty($_GET['categorie'])) {
    $categorie_id = $_GET['categorie'];
    $sql = "
    SELECT repas.*
    FROM repas
    INNER JOIN repas_categorie ON repas.id = repas_categorie.repas_id
    WHERE repas_categorie.categorie_id = :categorie_id
    LIMIT :limit
    OFFSET :offset
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":categorie_id" => $categorie_id,
        ":limit" => $nb_items_par_page,
        ":offset" => $nb_items_par_page * ($page - 1),
    ]);
    $repas = $stmt->fetchAll();
} else {
    // Récupérer tous les repas si aucune catégorie n'est sélectionnée
    $stmt = $bdd->prepare("
    SELECT *
    FROM repas
    LIMIT :limit
    OFFSET :offset
");
    $stmt->execute([
        ":limit" => $nb_items_par_page,
        ":offset" => $nb_items_par_page * ($page - 1),
    ]);
    $repas = $stmt->fetchAll();
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

// $page = "menu-admin";
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
                    <?= $categorie['nom'] ?>
                </a>
            <?php endforeach; ?>
            <p class="modifier-cat"><a href="modifier-categories.php">Modifier les catégories</a></p>
        </div>


        <?php foreach ($repas as $un_repas): ?>
            <div class="un-repas">
                <div>
                    <p> <?= $un_repas["nom"] ?></p>
                    <p> <?= $un_repas["description"] ?></p>
                    <p> <?= $un_repas["prix"] ?></p>
                </div>
                <div class="admin">
                    <a href="modifier.php?id=<?= $un_repas["id"] ?>">Modifier</a>
                    <a href="index.php?supprimer=<?= $un_repas["id"] ?>">Supprimer</a>
                </div>
            </div>
        <?php endforeach ?> 
        <!-- next and back dont work if categorie is chosen -->
        <div class="boutons">
            <p>Page <?= $page ?> de <?= $nb_page_total ?></p>
            <?php if ($page >= 2): ?>
                <a href="index.php?page=<?= $page - 1 ?>">Précédent</a>
            <?php else: ?>
                <a href="" class="inactif">Précédent</a>
            <?php endif ?>
            <?php if ($page < $nb_page_total): ?>
                <a href="index.php?page=<?= $page + 1 ?>">Suivant</a>
            <?php else: ?>
                <a href="" class="inactif">Suivant</a>
            <?php endif ?>

        </div>
    </div>
</body>

</html>