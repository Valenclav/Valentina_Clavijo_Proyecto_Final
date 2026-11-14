<?php
$host = "localhost";
$base = "cinecentro";
$usuario = "root";
$clave = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base;charset=utf8mb4", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("No se pudo conectar con la base de datos.");
}
