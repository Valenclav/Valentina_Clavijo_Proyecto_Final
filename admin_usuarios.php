<?php
require_once "conexion.php";
require_once "funciones.php";
requerirAdmin();

$mensaje = "";
$errores = [];
$busqueda = trim($_GET['q'] ?? "");

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['accion'] ?? "") === "crear") {
    verificarCSRF();

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pass = $_POST["password"] ?? "";

    $errores = validarUsuario($nombre, $apellido, $dni, $email, $pass);
    if (empty($errores) && dato_repetido($pdo, "dni", $dni)) {
        $errores[] = "Ese DNI ya existe.";
    }
    if (empty($errores) && dato_repetido($pdo, "email", $email)) {
        $errores[] = "Ese correo ya existe.";
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, dni, email, password)
                               VALUES (:n, :a, :d, :e, :p)");
        $stmt->execute([
            ':n' => $nombre,
            ':a' => $apellido,
            ':d' => $dni,
            ':e' => $email,
            ':p' => password_hash($pass, PASSWORD_DEFAULT)
        ]);
        $mensaje = "Usuario creado correctamente.";
    }
}

if ($busqueda !== "") {
    $sql = "SELECT * FROM usuarios
            WHERE fecha_archivado IS NULL
            AND (nombre LIKE :q OR apellido LIKE :q OR dni LIKE :q OR email LIKE :q)
            ORDER BY apellido";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':q' => "%$busqueda%"]);
} else {
    $sql = "SELECT * FROM usuarios WHERE fecha_archivado IS NULL ORDER BY apellido";
    $stmt = $pdo->query($sql);
}
$usuarios = $stmt->fetchAll();

cabecera("Administrar usuarios");
?>
<h1>Administrar usuarios</h1>

<?php if ($mensaje !== ""): ?>
    <div class="mensaje ok"><?php echo h($mensaje); ?></div>
<?php endif; ?>
<?php foreach ($errores as $e): ?>
    <div class="mensaje error"><?php echo h($e); ?></div>
<?php endforeach; ?>

<details class="tarjeta ancha">
    <summary>Registrar nuevo usuario</summary>
    <form method="POST" class="formulario">
        <input type="hidden" name="accion" value="crear">
        <input type="hidden" name="csrf" value="<?php echo h(tokenCSRF()); ?>">
        <label>Nombre <input type="text" name="nombre"></label>
        <label>Apellido <input type="text" name="apellido"></label>
        <label>DNI <input type="text" name="dni"></label>
        <label>Correo <input type="email" name="email"></label>
        <label>Contraseña <input type="password" name="password"></label>
        <button type="submit" class="boton">Guardar</button>
    </form>
</details>

<form method="GET" class="buscador">
    <input type="text" name="q" placeholder="Buscar por nombre, apellido, DNI o correo" value="<?php echo h($busqueda); ?>">
    <button type="submit" class="boton">Buscar</button>
</form>

<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?php echo h($u['nombre']); ?></td>
        <td><?php echo h($u['apellido']); ?></td>
        <td><?php echo h($u['dni']); ?></td>
        <td><?php echo h($u['email']); ?></td>
        <td><?php echo h($u['rol']); ?></td>
        <td class="acciones">
            <a class="boton chico" href="editar_usuario.php?id=<?php echo (int)$u['id']; ?>">Editar</a>
            <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
            <form method="POST" action="archivar_usuario.php" onsubmit="return confirm('¿Archivar este usuario?');">
                <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                <input type="hidden" name="csrf" value="<?php echo h(tokenCSRF()); ?>">
                <button type="submit" class="boton chico rojo">Archivar</button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($usuarios)): ?>
    <p>No se encontraron usuarios.</p>
<?php endif; ?>
<?php pie(); ?>

