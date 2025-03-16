<?php

include("../../includes/init.php");

if (isset($_GET["supprimer"])) {
    $stmt = $bdd->prepare("
        DELETE FROM utilisateurs
        WHERE id = :id
    ");
    $stmt->execute([
        ":id" => $_GET["supprimer"],
    ]);

    //header("location: index.php");
}

$employes = selectAll("utilisateurs", "*", "nom COLLATE NOCASE ASC");
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
    <h1>Gestion des employés</h1>
    <div class="menu">
        <a class="bouton" href="../creer-administrateur.php">Ajouter un employé</a>
        <?php foreach ($employes as $employe): ?>
            <div class="un-repas">
                <div>
                    <p> <?= $employe["nom"] ?>, <?= $employe["prenom"] ?></p>
                    <p> <?= $employe["courriel"] ?></p>
                </div>
                <div class="admin">
                    <a href="modifier.php?id=<?= $employe["id"] ?>">Modifier</a>
                    <a href="index.php?supprimer=<?= $employe["id"] ?>">Supprimer</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>