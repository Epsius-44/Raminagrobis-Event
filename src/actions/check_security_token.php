<?php
session_start();
$token = filter_input(INPUT_POST, "token");
if ($_SESSION["token"] != $token) {
    die("Tu essaies de me pirater");
}