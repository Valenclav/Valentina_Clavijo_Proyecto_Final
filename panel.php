<?php
require_once "conexion.php";
require_once "funciones.php";
requerirLogin();

$stmt = $pdo->prepare("SELECT nombre, apellido, dni, email, rol, fecha_creacion FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $_SESSION['usuario_id']]);
$yo = $stmt->fetch();
if (!$yo) {
    session_destroy();
    header("Location: login.php");
    exit;
}

cabecera("Mi cuenta");
?>
<h1>Hola, <?php echo h($yo['nombre']); ?></h1>

<div class="tarjeta ancha">
    <h2>Mis datos</h2>
    <p><strong>Nombre:</strong> <?php echo h($yo['nombre'] . " " . $yo['apellido']); ?></p>
    <p><strong>DNI:</strong> <?php echo h($yo['dni']); ?></p>
    <p><strong>Correo:</strong> <?php echo h($yo['email']); ?></p>
    <p><strong>Tipo de cuenta:</strong> <?php echo $yo['rol'] === 'admin' ? 'Administrador' : 'Cliente'; ?></p>
    <p><strong>Socio desde:</strong> <?php echo h(date("d/m/Y", strtotime($yo['fecha_creacion']))); ?></p>
</div>

<div class="tarjeta ancha">
    <h2>Mis entradas</h2>
    <p>Todavía no compraste entradas.</p>
    <a class="boton" href="index.php">Ver cartelera</a>
</div>
<?php pie(); ?>

