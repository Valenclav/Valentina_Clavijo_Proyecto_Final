
<?php
require_once "funciones.php";

requerirLogin();

$productos = [
    "candy" => [ "pochoclos" => ["nombre" => "Pochoclos", "precio" => 5000],
        "vasos" => ["nombre" => "Vasos coleccionables", "precio" => 3000],
        "nachos" => ["nombre" => "Nachos", "precio" => 4500],
        "combo" => ["nombre" => "Combo clásico", "precio" => 10000] ],
    "pelicula" => ["scary_movie" => ["nombre" => "Scary Movie", "precio" => 4500],
        "spiderman" => ["nombre" => "Spider-Man: Brand New Day", "precio" => 3800],
        "toy_story" => ["nombre" => "Toy Story 5", "precio" => 5200],
        "diablo_prada" => ["nombre" => "El diablo viste de Prada 2", "precio" => 4500] ]
];

$tipo = $_POST["tipo"] ?? $_GET["tipo"] ?? "";
$codigo = $_POST["producto"] ?? $_GET["producto"] ?? "";

if (!isset($productos[$tipo][$codigo])) {
    cabecera("Compra");
    echo "<h1>Producto no encontrado</h1>";
    echo '<a href="index.php" class="boton">Volver</a>';
    pie();
    exit;
    }

$producto = $productos[$tipo][$codigo];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    verificarCSRF();

    cabecera("Compra confirmada");
    ?>
    <div class="tarjeta">
        <h1>¡Compra confirmada!</h1>
        <p>Tu compra fue confirmada correctamente.</p>
        <h2><?php echo h($producto["nombre"]); ?></h2>
        <p class="precio">
            $<?php echo number_format($producto["precio"], 0, ',', '.'); ?></p>
        <a href="index.php" class="boton">Volver a Cartelera</a>
        <a href="candy.php" class="boton">Volver a Candy</a>
    </div>
    <?php
    pie();
    exit;
}

cabecera("Confirmar compra");
?>

<h1>Confirmar compra</h1>

<div class="tarjeta">
    <h2><?php echo h($producto["nombre"]); ?></h2>

    <p class="precio">
        $<?php echo number_format($producto["precio"], 0, ',', '.'); ?></p>

    <p>¿Querés confirmar esta compra?</p>

    <form method="POST" action="comprar.php">
        <input type="hidden" name="tipo" value="<?php echo h($tipo); ?>">
        <input type="hidden" name="producto" value="<?php echo h($codigo); ?>">
        <input type="hidden" name="csrf" value="<?php echo h(tokenCSRF()); ?>">

        <button type="submit" class="boton">Confirmar compra</button>
    </form>

    <p><a href="<?php echo $tipo === 'candy' ? 'candy.php' : 'index.php'; ?>">Volver</a></p>
</div>
<?php pie(); ?>
