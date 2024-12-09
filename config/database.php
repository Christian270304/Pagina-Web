<?php
    // Christian Torres Barrantes
    require_once __DIR__ . '/env.php';

    $servername = SERVERNAME;
    $usernamebd = USERNAMEBD;
    $password = PASSBD;
    $dbname = DBNAME;

    try {
        // Cremos una conexion PDO.
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $usernamebd, $password); 
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
?>