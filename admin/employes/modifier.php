<?php

include("../../includes/init.php");

if (empty($_POST)) {
    $id = $_GET["id"];
    $sql = "
    SELECT *
    FROM repas
    WHERE id = :id
";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":id" => $id,
    ]);
    $un_repas = $stmt->fetch();
} else {
    $id = $_POST["id"];
    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $sql = "
    UPDATE repas
    SET 
        nom = :nom,
        description = :description,
        prix = :prix
    WHERE id = :id
";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":id" => $id,
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
    <title>Modifier</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php include "../../composants/header.php" ?>
    <h1>Zone administrative</h1>
    <div class="menu">
        <a href="index.php" class="bouton">Retour</a>
        <h2>Modifier un item du menu</h2>
        <form action="modifier.php" method="post">
            <input type="hidden" name="id" value="<?= $un_repas["id"] ?>">
            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom" value="<?= $un_repas["nom"] ?>">

                    <p>Description</p>
                    <input type="text" name="description" value="<?= $un_repas["description"] ?>">

                    <p>Prix</p>
                    <input type="text" name="prix" value="<?= $un_repas["prix"] ?>">

                    <p><input type="submit" class="bouton" value="Modifier"></p>
                </div>
        </form>
    </div>
</body>

</html>