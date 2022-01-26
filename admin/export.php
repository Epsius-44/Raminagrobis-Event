<?php
$form_id = filter_input(INPUT_GET, "id");
include_once "../src/config.php";
include_once "../src/actions/database-connection.php";
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=CampaignExport_'.$form_id.'.csv');
$result = sqlCommand("SELECT * FROM form_data WHERE id_form=:form_id", [":form_id" => $form_id], $conn);
echo "id; civility; firstname; lastname; email; tel_mob; tel_fix; type; comp_name; people_num; news; score; id_category\r\n";
foreach ($result as $r){
    echo $r['id'].";".$r['civility'].";".$r['firstname'].";".$r['lastname'].";".$r['email'].";".$r['tel_mob'].";".$r['tel_fix'].";".$r['type'].";".$r['comp_name'].";".$r['people_num'].";".$r['news'].";".$r['score'].";".$r['id_category']."\r\n";
}