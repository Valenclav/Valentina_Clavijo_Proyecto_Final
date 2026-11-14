
<?php
require_once "conexion.php";
require_once "funciones.php";

$errores = [];
$exito = false;

$nombre = "";
$apellido = "";
$dni = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $apellido = trim($_POST["apellido"] ?? "");
    $dni = trim($_POST["dni"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pass = $_POST["password"] ?? "";

    $errores = validarUsuario($nombre, $apellido, $dni, $email, $pass);

    if (empty($errores)) {

        if (dato_repetido($pdo, "dni", $dni)) {
            $errores[] = "Ese DNI ya está registrado.";
        }

        if (dato_repetido($pdo, "email", $email)) {
            $errores[] = "Ese correo ya tiene una cuenta.";
        }
    }

    if (empty($errores)) {

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, apellido, dni, email, password)
                VALUES (:nombre, :apellido, :dni, :email, :pass)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':dni' => $dni,
            ':email' => $email,
            ':pass' => $hash
        ]);

        $exito = true;
    }
}

cabecera("Crear cuenta");
?>

<div class="registro-contenedor">

    <div class="registro-info">

        <h1>¡Bienvenido a CineCentro!</h1>
        <p>Creá tu cuenta y disfrutá de nuestra cartelera de películas.</p>
        <p>¿Ya tenés una cuenta?</p>
        <a href="login.php" class="boton">Ingresar</a>
     </div>

    <div class="registro-caja">

      <h2>Crear cuenta</h2>
      <?php if ($exito): ?>
                <div class="mensaje ok">
                ¡Cuenta creada correctamente!
                <a href="login.php">Ingresar</a>
            </div>

        <?php else: ?>

            <?php foreach ($errores as $e): ?>
                <div class="mensaje error">
                    <?php echo h($e); ?>
                </div>
            <?php endforeach; ?>

            <form method="POST" class="formulario">

                <label>Nombre
                    <input type="text" name="nombre"
                    value="<?php echo h($nombre); ?>" required>
                </label>

                <label>Apellido
                    <input type="text" name="apellido"
                    value="<?php echo h($apellido); ?>" required>
                </label>

                <label>DNI (sin puntos)
                    <input type="text" name="dni"
                    value="<?php echo h($dni); ?>" required>
                </label>

                <label>Correo electrónico
                    <input type="email" name="email"
                    value="<?php echo h($email); ?>" required>
                </label>

                <label>Contraseña
                    <input type="password" name="password" required>
                </label>

                <button type="submit" class="boton">
                    Registrarme
                </button>

            </form>

        <?php endif; ?>

    </div>

</div>

<?php pie(); ?>
