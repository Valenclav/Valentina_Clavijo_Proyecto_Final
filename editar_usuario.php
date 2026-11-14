<?php
require_once "conexion.php";
require_once "funciones.php";
requerirAdmin();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND fecha_archivado IS NULL");
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    header("Location: admin_usuarios.php");
    exit;
}

$errores = [];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verificarCSRF();

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");

    $errores = validarUsuario($nombre, $apellido, $dni, $email);
    if (empty($errores) && dato_repetido($pdo, "dni", $dni, $id)) {
        $errores[] = "Ese DNI ya lo usa otro usuario.";
    }
    if (empty($errores) && dato_repetido($pdo, "email", $email, $id)) {
        $errores[] = "Ese correo ya lo usa otro usuario.";
    }

    if (empty($errores)) {
        $sql = "UPDATE usuarios SET nombre = :n, apellido = :a, dni = :d, email = :e WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':n' => $nombre, ':a' => $apellido, ':d' => $dni, ':e' => $email, ':id' => $id]);
        $mensaje = "Datos guardados.";

        $usuario['nombre'] = $nombre;
        $usuario['apellido'] = $apellido;
        $usuario['dni'] = $dni;
        $usuario['email'] = $email;
    }
}

cabecera("Editar usuario");
?>
<h1>Editar usuario</h1>

<?php if ($mensaje !== ""): ?>
    <div class="mensaje ok"><?php echo h($mensaje); ?></div>
<?php endif; ?>
<?php foreach ($errores as $e): ?>
    <div class="mensaje error"><?php echo h($e); ?></div>
<?php endforeach; ?>

<form method="POST" class="formulario">
    <input type="hidden" name="id" value="<?php echo (int)$usuario['id']; ?>">
    <input type="hidden" name="csrf" value="<?php echo h(tokenCSRF()); ?>">
    <label>Nombre <input type="text" name="nombre" value="<?php echo h($usuario['nombre']); ?>"></label>
    <label>Apellido <input type="text" name="apellido" value="<?php echo h($usuario['apellido']); ?>"></label>
    <label>DNI <input type="text" name="dni" value="<?php echo h($usuario['dni']); ?>"></label>
    <label>Correo <input type="email" name="email" value="<?php echo h($usuario['email']); ?>"></label>
    <button type="submit" class="boton">Guardar cambios</button>
    <a class="boton gris" href="admin_usuarios.php">Volver</a>
</form>
<?php pie(); ?>

