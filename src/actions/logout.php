<?php
include_once "check_security_token.php";
session_start();
session_destroy();
header("location: ../../admin/login.php");
?>