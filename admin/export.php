<?php
// Récupération de l'id du formulaire souhaiter
$form_id = filter_input(INPUT_GET, "id");
if (isset($form_id)){//page redirection après la connexion de l'utilisateur s'il n'était pas encore connecté
    $redirect = "campaign_data.php?id=$form_id";
}
include_once "../src/actions/checkConnectionAdmin.php";
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
include_once "../src/actions/function.php";
// Changement du header de la page pour dire au navigateur qu'il s'agit d'un fichier csv
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=CampaignExport_'.$form_id.'.csv');
// Récupération des données
$result = sqlCommand("SELECT d.*, s.name as category FROM `form_data` as d LEFT JOIN sector as s ON d.id_category = s.id WHERE d.id_form=:form_id", [":form_id" => $form_id], $conn);
// Tableau de signification
$civility = ["H", "F", "A"];
$bool = ["Non", "Oui"];
// Création de la première ligne avec les en-têtes
echo "id; civility; firstname; lastname; email; tel_mob; tel_fix; comp_name; category; people_num; news; score\r\n";
// Création des lignes de données
foreach ($result as $r){
    $ligne = clean($r['id']).";";
    $ligne = $ligne.$civility[$r['civility']].";".clean($r['firstname']).";".clean($r['lastname']).";";
    $ligne = $ligne.clean($r['email']).";".clean($r['tel_mob']).";".clean($r['tel_fix']).";";
    $ligne = $ligne.(($r['type']==0) ? "/;/;" : clean($r['comp_name']).";".clean($r['category']).";");
    $ligne = $ligne.clean($r['people_num']).";".$bool[$r['news']].";".clean($r['score'])."\r\n";
    echo $ligne;
}
