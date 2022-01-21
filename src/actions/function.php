<?php

function checkLenSting($valueCheck, $length_max, $length_min = 1)
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