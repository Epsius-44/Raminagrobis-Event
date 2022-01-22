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