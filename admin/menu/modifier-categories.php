<?php

include("../../includes/init.php");
if (isset($_GET["supprimer"])) {
    $stmt = $bdd->prepare("
        DELETE FROM categories
        WHERE id = :id
    ");
    $stmt->execute([
        ":id" => $_GET["supprimer"],
    ]);

    header("location: modifier-categories.php");
}
// Process form submission
if (!empty($_POST) && isset($_POST["id"]) && isset($_POST["nom"])) {
    $id = $_POST["id"];
    $nom = $_POST["nom"];

    $sql = "
    UPDATE categories
    SET 
        nom = :nom
    WHERE id = :id
    ";
    $stmt = $bdd->prepare($sql);
    $result = $stmt->execute([
        ":id" => $id,
        ":nom" => $nom
    ]);

    if ($result) {
        $success_message = "Catégorie modifiée avec succès!";
    } else {
        $error_message = "Erreur lors de la modification de la catégorie.";
    }

    // Uncomment to redirect after update
    // header("location: index.php");
    // exit;
}

// Get all categories
$categories = selectAll("categories", "*");
$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include "../../composants/header.php" ?>
    <h1>Zone administrative</h1>
    <div class="menu">
        <a href="index.php" class="bouton">Retour</a>
        <a href="ajouter-categorie.php" class="bouton">Ajouter une catégorie</a>
        <h2>Modifier les catégories</h2>
        
        <?php if (isset($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>
        
        <div>
            <?php foreach ($categories as $categorie): ?>
                <div>
                    <form action="modifier-categories.php" method="post">
                        <input type="hidden" name="id" value="<?= $categorie["id"] ?>">
                        <div class="un-repas">
                            <p>Nom de la catégorie</p>
                            <input type="text" name="nom" value="<?= $categorie["nom"] ?>">
                            <p><input type="submit" class="bouton" value="Modifier"></p>
                            <p><a href="modifier-categories.php?supprimer=<?= $categorie["id"] ?>">Supprimer</a></p>

                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>