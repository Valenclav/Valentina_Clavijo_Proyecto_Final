
<?php
require_once "conexion.php";
require_once "funciones.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $email = trim($_POST["email"] ?? "");
    $pass = $_POST["password"] ?? "";

    if ($email === "" || $pass === "") {

        $error = "Escribí tu correo y tu contraseña.";

    } else {

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();
      
        if (!$usuario || !password_verify($pass, $usuario['password'])) {

            $error = "Correo o contraseña incorrectos.";

        } elseif ($usuario['fecha_archivado'] !== null) {

            $error = "Tu cuenta está archivada. Comunicate con el administrador.";

        } else {

            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            

            header("Location: panel.php");
            exit;
        }
    }
}

cabecera("Ingresar");
?>

<div class="registro-contenedor">

    <div class="registro-info">

        <h1>¡Bienvenido nuevamente!</h1>
        <p>Ingresá a CineCentro y disfrutá de nuestra cartelera.</p>
        <p>¿Todavía no tenés una cuenta?</p>
        <a href="registro.php" class="boton">Crear cuenta</a>

    </div>

    <div class="registro-caja">

        <h2>Ingresar</h2>

        <?php if ($error !== ""): ?>

            <div class="mensaje error">
                <?php echo h($error); ?>
            </div>

        <?php endif; ?>

        <form method="POST" class="formulario">

            <label>Correo electrónico
                <input type="email" name="email" required>
            </label>

            <label>Contraseña
                <input type="password" name="password" required>
            </label>

            <button type="submit" class="boton">
                Ingresar
            </button>

            </form>
     </div>
</div>
<?php pie(); ?>