<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    try{
        $conn = new PDO("mysql:host=$servername;dbname=ramina_db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie";
    }
    catch (PDOException $e){
        echo "Echec de connection : ".$e->getMessage();
    }
?>