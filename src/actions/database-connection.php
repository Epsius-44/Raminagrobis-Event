<?php
try {
    $conn = new PDO("mysql:host=" . Config::SERVER . ";dbname=" . Config::DB, Config::USER, Config::PSW);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("
        <main>
            <div class='container'>
                <h1>Site momentanément indisponible</h1>
                <p>Une erreur de connexion à la base de donnée bloque le chargement du site web.</p>
            </div>
        </main>
        ");
}

function sqlCommand($cmd, $args, $sql)
{
    $request = $sql->prepare($cmd);
    foreach ($args as $key => &$value) {
        $request->bindParam($key, $value);
    }
    $request->execute();
    return $request->fetchAll();
}