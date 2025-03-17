<?php

include("../../includes/init.php");

$categories = selectAll("categories", "*");


if (empty($_POST)) {
    $id = $_GET["id"];
    $sql = "
    SELECT 
        repas.*, repas_categorie.categorie_id, categories.nom as categorie_nom
    FROM 
        repas
    LEFT JOIN repas_categorie 
        ON repas.id = repas_categorie.repas_id
    LEFT JOIN categories 
        ON repas_categorie.categorie_id = categories.id
    WHERE 
        repas.id = :id
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
    $categorie_id = $_POST["categorie_id"];

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

    $sql_check = "
        SELECT * 
        FROM repas_categorie 
        WHERE repas_id = :repas_id
    ";
    $stmt_check = $bdd->prepare($sql_check);
    $stmt_check->execute([":repas_id" => $id]);
    $relation_existante = $stmt_check->fetch();

    if ($categorie_id == "") {
        $sql = "
            DELETE FROM repas_categorie 
            WHERE repas_id = :repas_id
            ";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([":repas_id" => $id]);

    } else {

        if ($relation_existante) {
            $sql = "
            UPDATE repas_categorie 
            SET 
                 categorie_id = :categorie_id,
            WHERE repas_id = :repas_id
            ";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ":repas_id" => $id,
                ":categorie_id" => $categorie_id
            ]);
        } else {
            $sql = "
              INSERT INTO repas_categorie
                 (categorie_id, repas_id)
            VALUES
                 (:categorie_id, :repas_id)
            ";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ":repas_id" => $id,
                ":categorie_id" => $categorie_id
            ]);
        }
    }




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

                    <p>Catégorie</p>
                    <select name="categorie_id">
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie["id"] ?>" <?= ($categorie["id"] == $un_repas["categorie_id"]) ? "selected" : "" ?>>
                                <?= $categorie["nom"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>

                    <p><input type="submit" class="bouton" value="Modifier"></p>
                </div>
        </form>
    </div>
</body>

</html>