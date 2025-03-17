<?php

include "bdd.php";
session_start();

function selectAll($nom_table, $colonnes = "*", $ordre = null) {
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

function selectParId($nom_table, $id) {
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
