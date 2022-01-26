<?php

function checkLenString($valueCheck, $length_max, $length_min = 1)
{
    return strlen($valueCheck) <= $length_max && strlen($valueCheck) >= $length_min;
}

function checkDateExist($date, $format= "Y-m-d"){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function verifDate($date1,$date2){
    return checkDateExist($date1) && checkDateExist($date2) && $date1 <= $date2;
}

function getPost($args){
    $result = [];
    foreach($args as $varName){
        $result[$varName] = filter_input(INPUT_POST,$varName);
    }
    return $result;
}

function moveFile($file_name_post, $destinationPath, $newName, $authorized_type = ["*"]){
    if (checkFile($file_name_post,$authorized_type) == true){
        $extension = pathinfo(basename($_FILES[$file_name_post]["name"]), PATHINFO_EXTENSION);
        $destination = $destinationPath.$newName.".".$extension;
        move_uploaded_file($_FILES[$file_name_post]["tmp_name"],$destination);
        return ($newName.".".$extension);
    }else{
        return null;
    }
}


function checkFile($file_name_post, $authorized_type = ["*"]){
    return ($_FILES[$file_name_post]["error"] == 0 and ($authorized_type == ["*"] or in_array($_FILES[$file_name_post]["type"],$authorized_type)));
}

function nbDays($start_date, $end_date) {

    $start = explode("-", $start_date);
    $end = explode("-", $end_date);

    $diff = mktime(0, 0, 0, $end[1], $end[2], $end[0]) -
        mktime(0, 0, 0, $start[1], $start[2], $start[0]);

    return(($diff / 86400));
}

function url_campaign($id,$level){
    return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http')."://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"],$level)."/?id=".$id);
}

function DataBDSafe($data){
    return htmlspecialchars($data, ENT_SUBSTITUTE, 'UTF-8');
}