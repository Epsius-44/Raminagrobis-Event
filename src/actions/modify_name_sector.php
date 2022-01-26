<?php
include_once "check_security_token.php";
//connection à la base de donnée
include_once "function.php";
include_once "../config.php";
include_once "database-connection.php";

//récupération du nouveau nom du secteur
$new_name=filter_input(INPUT_POST, "new_name");
$id=filter_input(INPUT_POST, "id");

if (checkLenString($new_name,255) && sqlCommand("SELECT count(id) FROM sector WHERE id=:id",[":id"=>$id],$conn)[0][0]==1){
    sqlCommand("UPDATE sector SET name=:name WHERE id=:id",[":name"=>$new_name,":id"=>$id],$conn);
    $_SESSION["error_sector"]=false;
    $_SESSION["status_sector"]="Nom du secteur modifié avec succès";
}else{
    $_SESSION["error_sector"]=true;
    $_SESSION["status_sector"]="Impossible de modifier le secteur, les données ne sont pas valide";
}
header("location: ../../admin/sector.php");//retour à la page