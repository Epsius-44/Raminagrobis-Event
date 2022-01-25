<?php
include_once "check_security_token.php";
include_once "../config.php";
include_once "database-connection.php";
include_once "function.php";


$data_post = getPost(["organization", "event_name", "description", "color_primary", "color_secondary", "start_date", "end_date", "campaign_id"]);
$data_post["color_primary"] = substr($data_post["color_primary"], 1);
$data_post["color_secondary"] = substr($data_post["color_secondary"], 1);
$sector = [];
$sector_id = sqlCommand("SELECT id FROM sector", [], $conn);

foreach ($sector_id as $l) {
    $checkbox = filter_input(INPUT_POST, "checkbox_sector_" . $l["id"]);
    if (isset($checkbox) == true) {
        $sector[] = $l["id"];
    }
}
function checkSector($list_sector_check, $list_sector)
{
    if (count($list_sector_check) == 0) {
        return false;
    }
    $list_id_sector = [];
    foreach ($list_sector as $sector_id) {
        $list_id_sector[] = $sector_id["id"];
    }
    foreach ($list_sector_check as $sector_check) {
        if (in_array($sector_check, $list_id_sector) == false) {
            return false;
        }
    }
    return true;
}
function checkId($id,$conn)
{
    if ($id == null or sqlCommand("SELECT count(*) FROM form WHERE id=:id", [":id" => $id],$conn)[0][0] == 1) {
        return true;
    }
    return false;
}

$newCampaign = $data_post["campaign_id"] == null;
$imagePost = $_FILES['add_file']['error'] != 4;
$checkFileResult = checkFile("add_file", ["image/png", "image/jpg", "image/jpeg"]);


//FIXME checkfile quand aucun fichier select pour modifier une campagne
if (checkLenString($data_post["organization"], 31) && checkLenString($data_post["event_name"], 255)
    && checkLenString($data_post["description"], 65535) && checkLenString($data_post["color_primary"], 6, 6)
    && checkLenString($data_post["color_secondary"], 6, 6) && verifDate($data_post["start_date"], $data_post["end_date"])
    && (($checkFileResult == true && $newCampaign == true) || ($checkFileResult == true && $imagePost == true) || ($imagePost == false && $newCampaign == false))
    && checkSector($sector, $sector_id) && checkId($data_post["campaign_id"],$conn)) {

    if ($imagePost) {
        $directoryDestination = "../../assets/img/";
        $newName = date("Y-m-d-H-i-s") . "_" . $data_post["organization"] . "-" . $data_post["event_name"];
        $name = moveFile("add_file", $directoryDestination, $newName, ["image/png", "image/jpg", "image/jpeg"]);
    }

    if ($newCampaign == true) {
        sqlCommand("INSERT INTO form (title, description, image, color_primary, color_secondary,
            start_date, end_date, organisation) VALUES (:title, :description, :image, :color_primary,:color_secondary, :start_date, :end_date, :organization)",
            [":title" => $data_post["event_name"], "description" => $data_post["description"], ":image" => $name,
                ":color_primary" => $data_post["color_primary"], ":color_secondary" => $data_post["color_secondary"], ":start_date" => $data_post["start_date"],
                ":end_date" => $data_post["end_date"], ":organization" => $data_post["organization"]], $conn);

        $campaign_id = sqlCommand("SELECT id FROM form ORDER BY id DESC LIMIT 1", [], $conn)[0]["id"];


        foreach ($sector as $s) {
            sqlCommand("INSERT INTO form_sector (id_form, id_sector) VALUES (:id_form, :id_sector)", ["id_form" => $campaign_id, ":id_sector" => $s], $conn);
        }
        $fileName = "../../data_csv/".$campaign_id."-".$data_post["event_name"].".csv";
        $file = fopen($fileName,"a");
        fclose($file);


    } else {
        $image = sqlCommand("SELECT image FROM form WHERE id=:campaign_id", ["campaign_id" => $data_post["campaign_id"]], $conn)[0]["image"];
        if ($imagePost == false){
            $name = $image;
        }else{
            unlink("../../assets/img/" . $image);
        }

        sqlCommand("UPDATE form SET title = :title, description = :description, image = :image,
                    color_primary = :color_primary, color_secondary = :color_secondary,
                    start_date = :start_date, end_date = :end_date, organisation = :organization WHERE id = :campaign_id",
            [":title" => $data_post["event_name"], "description" => $data_post["description"], ":image" => $name,
                ":color_primary" => $data_post["color_primary"], ":color_secondary" => $data_post["color_secondary"], ":start_date" => $data_post["start_date"],
                ":end_date" => $data_post["end_date"], ":organization" => $data_post["organization"], ":campaign_id" => $data_post["campaign_id"]], $conn);

        $request_sector_form_db = sqlCommand("SELECT id_sector FROM form_sector WHERE id_form=:id_form", [":id_form" => $data_post["campaign_id"]], $conn);

        $sector_form_id = [];
        foreach ($request_sector_form_db as $element) {
            $id = $element['id_sector'];
            if (in_array($id, $sector)) {
                $sector_form_id[] = $id;
            } else {
                $delete_sector_form[] = $id;
            }
        }
        if (isset($delete_sector_form) == true) {
            foreach ($delete_sector_form as $value) {
                sqlCommand("DELETE FROM form_sector WHERE id_form=:id_form AND id_sector = :id_sector", ["id_form" => $data_post["campaign_id"], "id_sector" => $value], $conn);
            }
        }

        foreach ($sector as $s) {
            if (in_array($s, $sector_form_id) == false) {
                sqlCommand("INSERT INTO form_sector (id_form, id_sector) VALUES (:id_form, :id_sector)", ["id_form" => $data_post["campaign_id"], "id_sector" => $s], $conn);
            }
        }
    }

    echo "Succès de la requête";
    //TODO Redirection

}