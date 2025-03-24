<?php

include("../../includes/init.php");
$categories = selectAll("categories", "*");

$erreur_upload = false;
$image_path = "";

if (!empty($_POST)) {
    $nom = $_POST["nom"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $categorie_id = $_POST["categorie_id"];
    
    // Handle image upload
    $upload_result = ajouterImage($_FILES["image"]);
    $erreur_upload = $upload_result["error"];
    $image_path = $upload_result["path"];

    if (!$erreur_upload) {
        $stmt = $bdd->prepare("
        INSERT INTO repas
            (nom, description, prix, image)
        VALUES
            (:nom, :description, :prix, :image)
        ");

        $stmt->execute([
            ":nom" => $nom,
            ":description" => $description,
            ":prix" => $prix,
            ":image" => $image_path
        ]);

        // Get the ID of the newly inserted repas
        $repas_id = $bdd->lastInsertId();

        $sql = "
        INSERT INTO repas_categorie
            (categorie_id, repas_id)
        VALUES
            (:categorie_id, :repas_id)
        ";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            ":repas_id" => $repas_id,
            ":categorie_id" => $categorie_id
        ]);

        header("location: index.php");
        exit;
    }
}

$page = "menu-admin";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un item</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script type="text/javascript">
        function previewImage(input) {
            var preview = document.getElementById('preview');
            var previewDiv = document.getElementById('image_preview');
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                previewDiv.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <?php include "../../composants/header.php" ?>

    <h1>Zone administrative</h1>
    <div class="menu">
        <a href="index.php" class="bouton">Retour</a>

        <h2>Ajouter un item au menu</h2>
        <?php if ($erreur_upload): ?>
            <div class="erreur">
                Erreur lors du téléversement de l'image. Vérifiez que le format est valide (jpg, jpeg, png, gif, avif, webp).
            </div>
        <?php endif ?>
        
        <?php if (!empty($image_path) && file_exists($image_path)): ?>
            <div class="apercu-image">
                <h3>Aperçu de l'image</h3>
                <img src="<?= $image_path ?>" alt="Aperçu" style="max-width: 300px; max-height: 300px;">
            </div>
        <?php endif ?>
        
        <form action="ajouter.php" method="post" enctype="multipart/form-data">
            <div class="un-repas">
                <div>
                    <p>Nom</p>
                    <input type="text" name="nom" required>

                    <p>Description</p>
                    <input type="text" name="description" required>

                    <p>Prix</p>
                    <input type="text" name="prix" required>

                    <p>Catégorie</p>
                    <select name="categorie_id" required>
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie["id"] ?>">
                                <?= $categorie["nom"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <p>Photo</p>

                    <input type="file" name="image" id="image_input" accept="image/*" required onchange="previewImage(this)">
                    
                    <div id="image_preview" style="margin-top: 10px; display: none;">
                        <p>Aperçu :</p>
                        <img id="preview" src="#" alt="Aperçu de l'image" style="max-width: 200px; max-height: 200px; border: 1px solid #ccc; padding: 5px;">
                    </div>
                    
                    <p><input type="submit" value="Ajouter" class="bouton"></p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>