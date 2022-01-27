<?php
include_once "../src/actions/security_token.php";
if (isset($_SESSION["user_connect"]) == false or $_SESSION["user_connect"] == false or isset($_SESSION["username"]) == false) {

    if (isset($redirect)){
        $_SESSION["redirect"] = $redirect;
    }
    header("Location: login.php");
}