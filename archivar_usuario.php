<?php
require_once "conexion.php";
require_once "funciones.php";
requerirAdmin();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin_usuarios.php");
    exit;
}

verificarCSRF();

$id = (int)($_POST['id'] ?? 0);

if ($id > 0 && $id != $_SESSION['usuario_id']) {
    $stmt = $pdo->prepare("UPDATE usuarios SET fecha_archivado = NOW() WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: admin_usuarios.php");
exit;
