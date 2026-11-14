<?php
session_start();

function h($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function requerirLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
               exit;
    }
}

function requerirAdmin() {
    requerirLogin();

    if ($_SESSION['rol'] !== 'admin') {
       
        cabecera("Acceso denegado");
        echo '<div class="mensaje error">No tenés permiso para entrar acá.</div>';
        echo '<a class="boton" href="panel.php">Volver a mi panel</a>';
        pie();
        exit;
    }
}

function tokenCSRF() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }

    return $_SESSION['csrf'];
}


function verificarCSRF() {
    if (!isset($_POST['csrf']) || !isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        die("Solicitud no válida.");
    }
}

function validarUsuario($nombre, $apellido, $dni, $email, $pass = null) { 
    $errores = [];

  if ($nombre === "" || $apellido === "" || $dni === "" || $email === "") {
    $errores[] = "Completá todos los campos obligatorios.";
}

if (strlen($nombre) > 50 || strlen($apellido) > 50) {
    $errores[] = "El nombre y el apellido no pueden superar los 50 caracteres.";
}


    if ($dni !== "" && !preg_match('/^[0-9]{7,8}$/', $dni)) {
        $errores[] = "El DNI tiene que tener entre 7 y 8 números, sin puntos.";
    }
    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }
    if ($pass !== null && strlen($pass) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }
  return $errores;
}

function dato_repetido($pdo, $campo, $valor, $idIgnorar = 0) {
    $permitidos = ['dni', 'email'];
   if (!in_array($campo, $permitidos, true)) {
        return false;
    }
    $sql = "SELECT id FROM usuarios WHERE $campo = :valor AND id != :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':valor' => $valor, ':id' => $idIgnorar]);
    return $stmt->fetch() !== false;
}
function cabecera($titulo) {
    $logueado = isset($_SESSION['usuario_id']);
    $esAdmin = $logueado && $_SESSION['rol'] === 'admin';
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($titulo); ?> - CineCentro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="barra">
   <a class="logo" href="index.php">
   <img src="imagenes/logo-cinecentro.png" alt="CineCentro">
</a>
    <nav>
        <a href="index.php">Cartelera</a>
        <a href="candy.php">Candy</a>
         
        <?php if ($logueado): ?>
        <?php if ($esAdmin): ?>
        <a href="admin_usuarios.php">Panel administrativo</a>
        <a href="usuarios_archivados.php">Archivados</a>
        <?php else: ?>
        <a href="panel.php">Mi cuenta</a>
       <?php endif; ?>
     <a href="cerrar_sesion.php">Salir</a>

    <?php else: ?>
    <a href="login.php">Ingresar</a>
    <a href="registro.php">Registrarse</a>
      <?php endif; ?>
    </nav>
</header>
<main class="contenido">
<?php
}

function pie() {
    ?>
</main>
<footer class="pie">CineCentro &copy; 2026</footer>
</body>
</html>
<?php
}
