<?php
include_once "check_security_token.php";
//connection à la base de donnée
include_once "../config.php";
include_once "database-connection.php";
include_once "function.php";

//récupération du nom du secteur
$name = filter_input(INPUT_POST, "name");

if (checkLenString($name,255)){
    sqlCommand("INSERT INTO sector (name) VALUES (:name)",[":name"=>$name],$conn);
    $_SESSION["error_sector"]=false;
    $_SESSION["status_sector"]="Secteur ajouté avec succès";
}else{
    $_SESSION["error_sector"]=true;
    $_SESSION["status_sector"]="Impossible d'ajouter ce secteur, les données ne sont pas valides";
}
header("location: ../../admin/sector.php");//retour à la page