<?php

include "includes/init.php";

$repas = selectAll("repas", "*", "nom COLLATE NOCASE ASC");
$page = "menu-client";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "composants/header.php" ?>
    <h1>Menu</h1>
    <div class="menu">
        <?php foreach ($repas as $un_repas): ?>
            <div class="un-repas">
                <div>
                    <p> <?= $un_repas["nom"] ?></p>
                    <p> <?= $un_repas["description"] ?></p>
                    <p> <?= $un_repas["prix"] ?>$</p>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>