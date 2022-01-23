<?php
//connection à la base de donnée
include_once "../config.php";
include_once "database-connection.php";

//réccupération du nouveau nom du secteur
$name = filter_input(INPUT_POST, "name");

$requete = $conn->prepare("INSERT INTO `sector`(`name`) VALUES ('{$name}')"); //creation de la requête
$requete->execute(); //execution de la requête
header("location: ../../admin/sector");//retour à la page