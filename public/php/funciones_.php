<?php

function fechaInicioYFinDeMes()
{
    $inicio = date('Y-m-01');
    $fin = date('Y-m-t');

    return [$inicio, $fin];
}
function fechaHoy()
{
    return date('Y-m-d');
}
/*
Nota: está limitado a solo traer los 10 primeros registros, ordenados por las veces que se visitaron
*/
function obtenerPaginasVisitadasEnFecha($fecha)
{
    $consulta = 'SELECT COUNT(*) AS conteo_visitas, count(distinct ip) as conteo_visitantes, url, pagina
    from visitas where fecha = ?
    group by url, pagina
    ORDER BY conteo_visitas DESC
    LIMIT 10;';
    $bd = obtenerConexion();
    $sentencia = $bd->prepare($consulta);
    $sentencia->execute([$fecha]);

    return $sentencia->fetchAll();
}

function obtenerConteoVisitasYVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    return (object) [
        'visitantes' => obtenerConteoVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url),
        'visitas' => obtenerConteoVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url),
    ];
}
function obtenerConteoVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ?');
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);

    return $sentencia->fetchObject()->conteo;
}

function obtenerConteoVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ?');
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);

    return $sentencia->fetchObject()->conteo;
}
function obtenerVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT fecha, COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ? GROUP BY fecha');
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);

    return $sentencia->fetchAll();
}
function obtenerVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT fecha, COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ? GROUP BY fecha');
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);

    return $sentencia->fetchAll();
}

function obtenerConteoVisitasYVisitantesEnRango($fechaInicio, $fechaFin)
{
    return (object) [
        'visitantes' => obtenerConteoVisitantesEnRango($fechaInicio, $fechaFin),
        'visitas' => obtenerConteoVisitasEnRango($fechaInicio, $fechaFin),
    ];
}

function obtenerConteoVisitantesEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ?');
    $sentencia->execute([$fechaInicio, $fechaFin]);

    return $sentencia->fetchObject()->conteo;
}

function obtenerConteoVisitasEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ?');
    $sentencia->execute([$fechaInicio, $fechaFin]);

    return $sentencia->fetchObject()->conteo;
}

function obtenerVisitantesEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT fecha, COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? GROUP BY fecha');
    $sentencia->execute([$fechaInicio, $fechaFin]);

    return $sentencia->fetchAll();
}
function obtenerVisitasEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('SELECT fecha, COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? GROUP BY fecha');
    $sentencia->execute([$fechaInicio, $fechaFin]);

    return $sentencia->fetchAll();
}
function registrarVisita($pagina, $url)
{
    $fecha = date('Y-m-d');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $bd = obtenerConexion();
    $sentencia = $bd->prepare('INSERT INTO visitas(fecha, ip, pagina, url) VALUES(?, ?, ?, ?)');

    return $sentencia->execute([$fecha, $ip, $pagina, $url]);
}
