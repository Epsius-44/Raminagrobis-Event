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
        die("
        <h1>Site momentanément indisponible</h1>
        <p>Une erreur de connexion à la base de donnée bloque le chargement du site web.</p>
        ");
    }
?>