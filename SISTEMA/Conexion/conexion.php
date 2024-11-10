<?php

    $servidor="mysql:dbname=empresa1;host127.0.0.1";
    $usuario = "root";
    $password="";

    try {

        $pdo = new PDO($servidor,$usuario,$password);

    } catch (PDOException $e) {

        echo "Conexion mala :(".$e->getMessage();

    }

?>