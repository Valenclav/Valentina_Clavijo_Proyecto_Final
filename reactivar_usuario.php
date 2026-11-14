<?php
require_once "conexion.php";
require_once "funciones.php";
requerirAdmin();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usuarios_archivados.php");
    exit;
}

verificarCSRF();

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE usuarios SET fecha_archivado = NULL WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: usuarios_archivados.php");
exit;
