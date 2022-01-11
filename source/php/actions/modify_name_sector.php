<?php
//connection à la base de donnée
include "database-connection.php";

//réccupération du nouveau nom du secteur
$new_name=filter_input(INPUT_POST, "new_name");

$previous_name=filter_input(INPUT_POST, "previous_name");

$requete=$conn->prepare("UPDATE `sector` SET `name`='{$new_name}' WHERE `name`='{$previous_name}'"); //creation de la requête
$requete->execute(); //execution de la requête
header("location: ../../../admin/sector");//retour à la page