<?php

include "../includes/init.php";

if (!isset( $_SESSION["est_connecte"] )) {
    header("location: connexion.php");
}
$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zone Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include "../composants/header.php" ?>
    <h1>Zone administrative</h1>
    <div class="menu">
        <p><a href="employes/index.php">Gestion des employés</a></p>
        <p><a href="menu/index.php">Gestion du menu</a></p>
        <p>
            <a href="deconnexion.php">
                Deconnexion
            </a>
        </p>
    </div>
</body>

</html>