<?php
include "database-connection.php";
$organization = filter_input(INPUT_POST, "organization");
$event_name = filter_input(INPUT_POST, "event_name");
$description = filter_input(INPUT_POST, "description");
$add_file = filter_input(INPUT_POST, "add_file");
$color_primary = substr(filter_input(INPUT_POST, "color_primary"), 1);
$color_secondary = substr(filter_input(INPUT_POST, "color_secondary"), 1);
$start_date = filter_input(INPUT_POST, "start_date");
$end_date = filter_input(INPUT_POST, "end_date");
$campaign_id = filter_input(INPUT_POST, "campaign_id");


$sector = [];
$request = $conn->prepare("select id from sector");
$request->execute();
$sector_id = $request->fetchAll();
//TODO boucle pour chaque secteur + vérifier intégriter donnée envoyé


foreach ($sector_id as $l) {
    $checkbox = filter_input(INPUT_POST, "checkbox_sector_" . $l["id"]);
    if ($checkbox != null) {
        array_push($sector, $l["id"]);
    }
}


function integrityString($valueCheck, $length_max)
{
    return strlen($valueCheck) <= $length_max;
}


if (integrityString($organization, 31) && integrityString($event_name, 255)
    && integrityString($description, 65535) && integrityString($add_file, 255)
    && integrityString($color_primary, 6) && integrityString($color_secondary, 6)) {
    var_dump($end_date);
    if ($campaign_id == null) {
        $request = $conn->prepare("insert into form (title, description, image, color_primary, color_secondary,
                      start_date, end_date, organisation) values (:title, :description, :image, :color_primary,
                                                                  :color_secondary, :start_date, :end_date, :organisation)");
    } else {
        $request = $conn->prepare("update form set title = :title, description = :description, image = :image,
                    color_primary = :color_primary, color_secondary = :color_secondary,
                    start_date = :start_date, end_date = :end_date, organinsation = :organinsation where id = :id");
        $request->bindParam(":id", $campaign_id);
    }

    $destinationPath = "../../../banner/".basename($_FILES["fichier"]["name"]);
    move_uploaded_file($_FILES["fichier"]["tmp_name"], $destinationPath);
    //TODO fichier à déplacer et à renommer + destination dans la BD





    var_dump($event_name);
    $request->bindParam(":title", $event_name);
    var_dump($description);
    $request->bindParam(":description", $description);
    var_dump($add_file);
    $request->bindParam(":image", $add_file);
    var_dump($color_primary);
    $request->bindParam(":color_primary", $color_primary);
    $request->bindParam(":color_secondary", $color_secondary);
    $request->bindParam(":start_date", $start_date);
    $request->bindParam(":end_date", $end_date);
    $request->bindParam(":organisation", $organization);
    $request->execute();
    echo "Succès de la requête";
}