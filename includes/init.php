<?php

include "bdd.php";
session_start();

function selectAll($nom_table, $colonnes = "*", $ordre = null)
{
    global $bdd;

    $sql = "
        SELECT $colonnes
        FROM $nom_table
    ";

    if ($ordre) {
        $sql .= " ORDER BY $ordre";
    }

    $stmt = $bdd->prepare($sql);
    $stmt->execute([]);
    return $stmt->fetchAll();
}

function selectParId($nom_table, $id)
{
    global $bdd;

    $sql = "
        SELECT *
        FROM $nom_table
        WHERE id = :id
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":id" => $id,
    ]);
    return $stmt->fetch();
}

function selectCount($nom_table)
{
    global $bdd;

    $stmt = $bdd->prepare("
        SELECT 
            COUNT(*) as qty
        FROM $nom_table
    ");
    $stmt->execute();
    $resultat = $stmt->fetch();
    return $resultat["qty"];
}

function ajouterImage($image)
{
    $erreur_upload = false;
    $cible = "";

    if ($image["error"] == 0) {
        $dossier = "uploads/";
        $nom_fichier = date("h-i-s") . "_" . random_int(100000, 999999);
        $extension = pathinfo($image["name"], PATHINFO_EXTENSION);
        $cible = "$dossier$nom_fichier.$extension";

        $extensions_permises = ["jpg", "jpeg", "png", "gif", "avif", "webp"];
        if (in_array($extension, $extensions_permises)) {
            $temp_file = $image["tmp_name"];
            $imageRedimensionnee = redimensionnerImage($cible);

            move_uploaded_file($imageRedimensionnee, $cible);
        } else {
            $erreur_upload = true;
        }
    } else {
        $erreur_upload = true;
    }
    return $erreur_upload;
}

function chargerImage($chemin)
{
    $extension = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
    switch ($extension) {
        case "jpg":
            return imagecreatefromjpeg($chemin);
        case "jpeg":
            return imagecreatefromjpeg($chemin);
        case "png":
            return imagecreatefrompng($chemin);
        case "avif":
            return imagecreatefromavif($chemin);
        case "gif":
            return imagecreatefromgif($chemin);
        case "webp":
            return imagecreatefromwebp($chemin);
        default:
            return false;
    }
}

function redimensionnerImage($image){
    var_dump($image);
    $infos = getimagesize($image);
    $width = $infos[0];
    $height = $infos[1];
    $nouveau_width = round($width / 2);
    $nouveau_height = round($height / 2);
    $pixels = chargerImage($image);
    $nouveaux_pixels = imagescale($pixels, $nouveau_width, $nouveau_height);
    return imagejpeg($nouveaux_pixels, "test");
}