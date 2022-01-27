<?php
session_start();
$token = filter_input(INPUT_POST, "token");
if (isset($_SESSION["token"]) and $_SESSION["token"] != $token) {
    session_destroy();
    die("Tu essaies de me pirater");
}