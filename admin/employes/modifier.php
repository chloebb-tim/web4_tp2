<?php

include("../../includes/init.php");

$erreur_mdp = "";
$utilisateur = [
    "id" => "",
    "nom" => "",
    "prenom" => "",
    "courriel" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $courriel = $_POST["courriel"];
    $mdp = $_POST["mdp"];
    $mdp_confirmation = $_POST["mdp_confirmation"];

    $utilisateur["id"] = $id;
    $utilisateur["nom"] = $nom;
    $utilisateur["prenom"] = $prenom;
    $utilisateur["courriel"] = $courriel;

    if (!empty($mdp)) {
        if ($mdp !== $mdp_confirmation) {
            $erreur_mdp = "Les mots de passe ne correspondent pas.";
        } else {
            $mdp_encrypte = password_hash($mdp, PASSWORD_DEFAULT);
            $sql = "
            UPDATE utilisateurs
            SET 
                nom = :nom,
                prenom = :prenom,
                courriel = :courriel,
                mdp = :mdp
            WHERE id = :id
            ";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([
                ":id" => $id,
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":courriel" => $courriel,
                ":mdp" => $mdp_encrypte,
            ]);
        }
    } 

    if (empty($mdp) || empty($erreur_mdp)) {
        $sql = "
        UPDATE utilisateurs
        SET 
            nom = :nom,
            prenom = :prenom,
            courriel = :courriel
        WHERE id = :id
        ";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            ":id" => $id,
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":courriel" => $courriel,
        ]);

        if (empty($erreur_mdp)) {
            header("location: index.php");
            exit();
        }
    }
} else {
    // Si ce n'est pas un POST, récupérer les données de l'utilisateur
    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM utilisateurs WHERE id = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([":id" => $id]);
        $utilisateur = $stmt->fetch();
    }
}

$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="fr">

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
        <h2>Modifier un utilisateur</h2>
        <form action="modifier.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($utilisateur["id"]) ?>">

            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom" value="<?= htmlspecialchars($utilisateur["nom"]) ?>">

                    <p>Prénom</p>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($utilisateur["prenom"]) ?>">

                    <p>Courriel</p>
                    <input type="text" name="courriel" value="<?= htmlspecialchars($utilisateur["courriel"]) ?>">

                    <p>Réinitialiser le mot de passe</p>
                    <input name="mdp" type="password" placeholder="Mot de passe">
                    <p>Confirmer le nouveau mot de passe</p>
                    <input name="mdp_confirmation" type="password" placeholder="Mot de passe">

                    <?php if (!empty($erreur_mdp)): ?>
                        <p class="erreur"><?= $erreur_mdp ?></p>
                    <?php endif; ?>

                    <p><input type="submit" class="bouton" value="Modifier"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
