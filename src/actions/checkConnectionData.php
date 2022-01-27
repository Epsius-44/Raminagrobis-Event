<?php
if (isset($_SESSION["user_connect"]) == false or $_SESSION["user_connect"] == false or isset($_SESSION["username"]) == false) {
    if (isset($redirect)){
        $_SESSION["redirect"] = $redirect;
        $_SESSION["error"] = true;
        $_SESSION["error_message"] = $message;
    }
    if (isset($_SESSION["user_connect"])){
        unset($_SESSION["user_connect"]);
    }
    var_dump($_SESSION);
    header("Location: ../../admin/login.php");
}