<?php

function registrarVisita($pagina, $url)
{
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $at = date('Y-m-d h:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('INSERT INTO visitas(fecha, ip, pagina, url, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?)');

    return $sentencia->execute([$fecha, $ip, $pagina, $url, $at, $at]);
}

function obtenerConexion()
{
    $password = '';
    $user = 'root';
    $dbName = 'nodo';
    $database = new PDO('mysql:host=localhost;dbname='.$dbName, $user, $password);
    $database->query('set names utf8;');
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    return $database;
}
