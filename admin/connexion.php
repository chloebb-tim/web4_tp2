<?php

include("../includes/init.php");

if (!empty($_POST)) {
    $courriel = $_POST["courriel"];
    $mdp = $_POST["mdp"];

    $sql = "
        SELECT *
        FROM utilisateurs
        WHERE
            courriel = :courriel
    ";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":courriel" => $courriel,
    ]);

    $utilisateur = $stmt->fetch();
    
    $utilisateur_existe = $utilisateur != false;

    if ($utilisateur_existe) {
        // Vérification mdp
        $mdp_valide = password_verify($mdp, $utilisateur["mdp"]);

        if ($mdp_valide) {
            $_SESSION["est_connecte"] = true;
            header("location: index.php");
        } else {
            $erreur = true;
        }
    } else {
        $erreur = true;
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à l'admin</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if (isset($erreur)): ?>
        <p class="erreur">
            Erreur de connexion.
        </p>
    <?php endif; ?>

    <form action="connexion.php" method="post">
        <input name="courriel" type="text" placeholder="Courriel">
        <input name="mdp" type="password" placeholder="Mot de passe">
        <input type="submit" value="Connecter">
    </form>
</body>
</html>