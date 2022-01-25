<?php
include_once "check_security_token.php";
include_once "../config.php";
include_once "database-connection.php";

$username = $_POST['username'];
$psw = $_POST['password'];
$user = sqlCommand("SELECT login FROM user WHERE (login = :username OR email=:username) AND password = :password",[':username'=>$username, ':password'=>$psw],$conn);
if (count($user)==1){
    $_SESSION["username"] = $user[0]["login"];
    $_SESSION["user_connect"] = true;
    header("location: ../../admin/campaigns_list.php");
} else {
    $_SESSION["connection_error"] = "Identifiant ou mot de passe incorect";
    header("location: ../../admin/login.php");
}