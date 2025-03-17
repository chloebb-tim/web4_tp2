<?php

include("../includes/init.php");

//ajouter ca a verify connexion et le mettre dans init
if (!isset( $_SESSION["est_connecte"] )) {
    header("location: connexion.php");
}

if (!empty($_POST)) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $courriel = $_POST["courriel"];
    $mdp = $_POST["mdp"];
    $mdp_encrypte = password_hash($mdp, PASSWORD_DEFAULT);

    $sql = "
        INSERT INTO utilisateurs
            (nom, prenom, courriel, mdp)
        VALUES
            (:nom, :prenom, :courriel, :mdp)
    ";

    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":courriel" => $courriel,
        ":mdp" => $mdp_encrypte,
    ]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'administrateur</title>
</head>
<body>
    <h1>Création d'administrateur</h1>

    <form action="creer-administrateur.php" method="post">
    <a href="index.php" class="bouton">Retour</a>

        <input name="nom" type="text" placeholder="Nom">
        <input name="prenom" type="text" placeholder="Prénom">
        <input name="courriel" type="text" placeholder="Courriel">
        <input name="mdp" type="password" placeholder="Mot de passe">
        <input type="submit" value="Créer">
    </form>
</body>
</html>